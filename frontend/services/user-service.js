var UserService = {
  init: function() {
    var token = localStorage.getItem("user_token");
    
    // Redirect logic
    if (token && (window.location.pathname.includes("login.html") || 
                  window.location.pathname.includes("register.html"))) {
      window.location.replace("index.html");
    }
    
    if (!token && !window.location.pathname.includes("login.html") && 
        !window.location.pathname.includes("register.html")) {
      window.location.replace("login.html");
    }
    
    // Login form
    if ($("#login-form").length > 0) {
      $("#login-form").validate({
        rules: {
          email: { required: true, email: true },
          password: { required: true, minlength: 6 }
        },
        submitHandler: function(form) {
          var entity = Object.fromEntries(new FormData(form).entries());
          UserService.login(entity);
        }
      });
    }
    
    // Register form
    if ($("#register-form").length > 0) {
      $("#register-form").validate({
        rules: {
          first_name: "required",
          last_name: "required",
          email: { required: true, email: true },
          password: { required: true, minlength: 6 }
        },
        submitHandler: function(form) {
          var entity = Object.fromEntries(new FormData(form).entries());
          UserService.register(entity);
        }
      });
    }
  },

  login: function(entity) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + "auth/login",
      type: "POST",
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        if (result.success && result.data && result.data.token) {
          localStorage.setItem("user_token", result.data.token);
          toastr.success("Login successful!");
          setTimeout(function() {
            window.location.replace("index.html");
          }, 500);
        } else {
          toastr.error("Login failed");
        }
      },
      error: function(xhr) {
        toastr.error(xhr.responseJSON?.message || "Login failed");
      }
    });
  },

  register: function(entity) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + "auth/register",
      type: "POST",
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        if (result.success) {
          toastr.success("Registration successful! Please login.");
          setTimeout(function() {
            window.location.replace("login.html");
          }, 1000);
        } else {
          toastr.error(result.message || "Registration failed");
        }
      },
      error: function(xhr) {
        toastr.error(xhr.responseJSON?.message || "Registration failed");
      }
    });
  },

  logout: function() {
    localStorage.removeItem("user_token");
    toastr.success("Logged out successfully");
    setTimeout(function() {
      window.location.replace("login.html");
    }, 500);
  },

  getCurrentUser: function() {
    const token = localStorage.getItem("user_token");
    return Utils.parseJwt(token);
  },

  generateMenuItems: function() {
    const user = this.getCurrentUser();
    
    if (!user) {
      window.location.replace("login.html");
      return;
    }
    
    let nav = "";
    let main = "";
    
    if (user.role === 'admin') {
      // ADMIN - Can see all pages
      nav = `
        <li class="nav-item">
          <a class="nav-link" href="#home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#inventory">Manage Inventory</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#services">Service Appointments</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#aboutus">About Us</a>
        </li>
        <li class="nav-item">
          <button class="btn btn-outline-danger btn-sm" onclick="UserService.logout()">Logout</button>
        </li>
      `;
      
      main = `
        <section id="home" data-load="home.html"></section>
        <section id="inventory" data-load="inventory.html"></section>
        <section id="services" data-load="services.html"></section>
        <section id="aboutus" data-load="aboutus.html"></section>
      `;
    } else {
      // CUSTOMER - Can browse and book services
      nav = `
        <li class="nav-item">
          <a class="nav-link" href="#home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#inventory">Browse Inventory</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#services">Book Service</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#aboutus">About Us</a>
        </li>
        <li class="nav-item">
          <button class="btn btn-outline-danger btn-sm" onclick="UserService.logout()">Logout</button>
        </li>
      `;
      
      main = `
        <section id="home" data-load="home.html"></section>
        <section id="inventory" data-load="inventory.html"></section>
        <section id="services" data-load="services.html"></section>
        <section id="aboutus" data-load="aboutus.html"></section>
      `;
    }
    
    // Update navigation
    if ($("#tabs").length > 0) {
      $("#tabs").html(nav);
    }
    
    // Update main content
    if ($("#spapp").length > 0) {
      $("#spapp").html(main);
    }
  }
};

$(document).ready(function() {
  UserService.init();
});