$(function() {
    var app = $.spapp({
        defaultView: "#home",
        templateDir: "./views/"
    });

    app.route({
        view: "admin_panel",
        load: "admin_panel.html",
    onReady: function() { 
        CarService.list(); // This keeps the admin table working!
    }    
    });

    app.route({
        view: "inventory",
        load: "inventory.html"
    });

    app.route({
        view: "car-details",
        load: "car_details.html"
    });

    app.run();

    // Global listeners
    if (localStorage.getItem("user_token")) {
        UserService.generateMenuItems();
    }

    $(document).on("submit", "#login-form", function (e) {
        e.preventDefault();
        UserService.login(Object.fromEntries(new FormData(this).entries()));
    });

    $(document).on("submit", "#register-form", function (e) {
        e.preventDefault();
        UserService.register(Object.fromEntries(new FormData(this).entries()));
    });

    $(document).on("submit", "#add-car-form", function (e) {
        e.preventDefault();
        CarService.save(Object.fromEntries(new FormData(this).entries()));
    });
});