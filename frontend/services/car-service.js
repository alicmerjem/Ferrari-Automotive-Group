var CarService = {
  init: function() {
    // Controller Logic: Setup validation for the add car form (Milestone 5 Requirement)
    $("#add-car-form").validate({
      rules: {
        model: { required: true },
        year: { required: true, digits: true },
        price: { required: true, number: true },
        category: { required: true }
      },
      submitHandler: function(form) {
        var entity = Object.fromEntries(new FormData(form).entries());
        CarService.save(entity);
      }
    });
  },

  // --- DATA METHODS (Model/Service Layer) ---

  list: function() {
    RestClient.get("api/cars", function(data) {
      // Logic: Fetch data and then pass it to the View
      CarService.renderCarTable(data);
    });
  },

  save: function(entity) {
    RestClient.post("api/cars", entity, function(response) {
      $("#addCarModal").modal("hide");
      toastr.success("Saved!");
      CarService.list();
    });
  },

  viewDetails: function(id) {
    localStorage.setItem("selected_car_id", id);
    window.location.hash = "#car-details";
  },

  // --- VIEW METHODS (UI Layer) ---

  renderCarTable: function(data) {
    var html = "";
    for (var i = 0; i < data.length; i++) {
      var status = data[i].status ? data[i].status.toLowerCase() : 'available';
      var badgeClass = (status === 'available') ? "bg-success" : (status === 'sold' ? "bg-danger" : "bg-warning text-dark");
      
      // Reverted to your exact original 5-column structure
      html += `
      <tr>
        <td class="fw-bold">${data[i].model}</td>
        <td>${data[i].year}</td>
        <td>$${Number(data[i].price).toLocaleString()}</td>
        <td><small class="text-uppercase">${data[i].category}</small></td>
        <td><span class="badge ${badgeClass}">${status.toUpperCase()}</span></td>
      </tr>`;
    }
    $("#cars-table tbody").html(html);
  }
};