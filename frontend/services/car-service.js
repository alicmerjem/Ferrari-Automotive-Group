var CarService = {
  init: function() {
    // Controller: Add Car Validation
    $("#add-car-form").validate({
      rules: {
        model: { required: true },
        year: { required: true, digits: true },
        price: { required: true, number: true },
        category: { required: true }
      },
      messages: {
        model: "Please specify the car model",
        year: "Please enter a valid production year",
        price: "Price must be a valid number",
        category: "Please select a category"
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
      CarService.renderCarTable(data);
    });
  },

  save: function(entity) {
    $.blockUI({ message: '<h3>Saving Car...</h3>' });
    RestClient.post("api/cars", entity, function(response) {
      $.unblockUI();
      $("#addCarModal").modal("hide");
      toastr.success("Saved!");
      CarService.list();
    }, function(error) {
      $.unblockUI();
      toastr.error("Error saving car");
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