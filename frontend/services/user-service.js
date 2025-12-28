var UserService = {
  init: function () {
    var token = localStorage.getItem("user_token");
    
    // Redirect logic
    if (token && (window.location.hash === "#login" || window.location.hash === "")) {
      window.location.replace("index.html");
    }

    // 1. Controller Logic: Login Form Validation & Submission
    $("#login-form").validate({
      rules: {
        email: { required: true, email: true },
        password: { required: true, minlength: 5 }
      },
      submitHandler: function (form) {
        var entity = Object.fromEntries(new FormData(form).entries());
        UserService.login(entity);
      },
    });

    // 2. Controller Logic: Register Form Validation (Added for Milestone 5)
    $("#register-form").validate({
      rules: {
        first_name: "required",
        last_name: "required",
        email: { required: true, email: true },
        password: { required: true, minlength: 6 }
      },
      submitHandler: function (form) {
        var entity = Object.fromEntries(new FormData(form).entries());
        UserService.register(entity);
      },
    });
  },

  // --- DATA METHODS (Model/Service Layer) ---

  login: function (entity) {
    RestClient.post("auth/login", entity, function (result) {
      if (result.data && result.data.token) {
        localStorage.setItem("user_token", result.data.token);
        toastr.success(result.message || "Welcome back!");
        setTimeout(function() {
            window.location.replace("index.html");
        }, 1000);
      }
    }, function (error) {
      const errorMsg = error.responseJSON?.error || "Invalid email or password";
      toastr.error(errorMsg);
    });
  },

  register: function (entity) {
    RestClient.post("auth/register", entity, function (result) {
      toastr.success("Registration successful! You can now login.");
      window.location.hash = "#login";
    }, function (error) {
      toastr.error(error.responseJSON?.message || "Registration failed");
    });
  },

  logout: function () {
    localStorage.clear();
    window.location.hash = "#home";
    window.location.reload();
  },

  list: function() {
    RestClient.get("api/users", function(data) {
        // Separation of Concerns: We call a specific render function
        UserService.renderUserTable(data);
    }, function(error) {
        toastr.error("Could not load users.");
    });
  },

  // --- VIEW METHODS (UI Layer) ---

  renderUserTable: function(data) {
    var html = "";
    for (var i = 0; i < data.length; i++) {
        var userId = data[i].user_id;
        var role = data[i].role ? data[i].role.toUpperCase() : 'USER';
        var badgeClass = (role === 'ADMIN') ? 'bg-danger' : 'bg-secondary';
        
        html += `
        <tr>
            <td class="text-muted">#${userId}</td>
            <td>${data[i].first_name} ${data[i].last_name}</td>
            <td>${data[i].email}</td>
            <td><span class="badge ${badgeClass}">${role}</span></td>
        </tr>`;
    }
    
    if (data.length === 0) {
        html = '<tr><td colspan="4" class="text-center">No users found.</td></tr>';
    }
    
    $("#users-table tbody").html(html);
  },

  generateMenuItems: function() {
    const token = localStorage.getItem("user_token");
    const user = Utils.parseJwt(token);

    if (user && user.role) {
      let nav = `
        <li class="nav-item"><a href="#home" class="nav-link text-white ms-3">Home</a></li>
        <li class="nav-item"><a href="#inventory" class="nav-link text-white ms-3">Inventory</a></li>
        <li class="nav-item"><a href="#aboutus" class="nav-link text-white ms-3">About</a></li>
        <li class="nav-item"><a href="#profile" class="nav-link text-warning ms-3">My Profile</a></li>
      `;

      if (user.role === Constants.ADMIN_ROLE) {
        nav += `<li class="nav-item"><a href="#admin_panel" class="nav-link text-warning ms-3">Admin Panel</a></li>`;
      }

      nav += `<li class="nav-item"><a href="javascript:void(0)" onclick="UserService.logout()" class="nav-link text-danger ms-3">Logout</a></li>`;
      $(".navbar-nav").html(nav);
    }
  },

  loadProfile: function() {
    const token = localStorage.getItem("user_token");
    const user = Utils.parseJwt(token);

    if (user) {
        $("#profile-full-name").text((user.first_name || "") + " " + (user.last_name || ""));
        $("#profile-email").text(user.email || "N/A");
        $("#profile-role").text(user.role === 'ADMIN' ? "Elite Administrator" : "Scuderia Member");
        $("#user-initials").text(user.first_name ? user.first_name.charAt(0).toUpperCase() : "U");
    } else {
        window.location.hash = "#login";
    }
  }
};