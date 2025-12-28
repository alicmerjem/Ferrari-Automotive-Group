var CarService = {
    // ADMIN PANEL: Table view
    list: function() {
        RestClient.get("api/cars", function(data) {
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
        });
    },

    // DYNAMIC DETAILS: When "Learn More" is clicked
    viewDetails: function(id) {
        localStorage.setItem("selected_car_id", id);
        window.location.hash = "#car-details";
    },

    save: function(entity) {
        RestClient.post("api/cars", entity, function(response) {
            $("#addCarModal").modal("hide");
            toastr.success("Saved!");
            CarService.list();
        });
    }
};