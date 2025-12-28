$(function() {
    var app = $.spapp({
        defaultView: "#home",
        templateDir: "./views/"
    });

    // 1. Define Routes
    app.route({
        view: "login",
        load: "login.html",
        onReady: function() { 
            UserService.init(); // Initialize validation when login page loads
        }
    });

    app.route({
        view: "register",
        load: "register.html",
        onReady: function() { 
            UserService.init(); // Initialize validation when register page loads
        }
    });

    app.route({
        view: "admin_panel",
        load: "admin_panel.html",
        onReady: function() { 
            CarService.list(); 
            CarService.init(); // Initialize add-car validation
        }    
    });

    app.route({
        view: "profile",
        load: "profile.html",
        onReady: function() {
            UserService.loadProfile();
        }
    });

    // Other routes stay the same...
    app.route({ view: "inventory", load: "inventory.html" });
    app.route({ view: "car-details", load: "car_details.html" });

    app.run();

    // 2. Global UI Setup
    UserService.generateMenuItems(); 

    // 3. Manual Submission Listeners (The "Safety Net")
    // If the validation plugin isn't catching the submit, this will.
    $(document).on("submit", "#login-form", function (e) {
        e.preventDefault();
        // Only run if the form is actually valid
        if($(this).valid()) {
            var entity = Object.fromEntries(new FormData(this).entries());
            UserService.login(entity);
        }
    });

    $(document).on("submit", "#register-form", function (e) {
        e.preventDefault();
        if($(this).valid()) {
            var entity = Object.fromEntries(new FormData(this).entries());
            UserService.register(entity);
        }
    });
});