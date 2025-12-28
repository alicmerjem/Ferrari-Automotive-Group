var UserService = {
  init: function () {
    var token = localStorage.getItem("user_token");
    // If we have a token and the user is on the login page, send them home
    if (token && (window.location.hash === "#login" || window.location.hash === "")) {
      window.location.replace("index.html");
    }
    
    // Setup validation for the login form (Lab requirement)
    $("#login-form").validate({
      submitHandler: function (form) {
        var entity = Object.fromEntries(new FormData(form).entries());
        UserService.login(entity);
      },
    });
  },

login: function (entity) {
    RestClient.post("auth/login", entity, function (result) {
      // Based on your AuthRoutes: result.data contains the user + token
      if (result.data && result.data.token) {
        localStorage.setItem("user_token", result.data.token);
        toastr.success(result.message || "Welcome back!");
        
        // Wait a second so they see the success message, then go home
        setTimeout(function(){
            window.location.replace("index.html");
        }, 1000);
      }
    }, function (error) {
      // This will now show the REAL error from your AuthService
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
    window.location.hash = "#home"; // Go to home hash
    window.location.reload();      // Refresh to clear the dynamic navbar
  },

  // This is the "Magic" function from your lab doc 
  // It changes the UI based on who is logged in
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

    // Only show for Admin
    if (user.role === Constants.ADMIN_ROLE) {
      nav += `<li class="nav-item"><a href="#admin_panel" class="nav-link text-warning ms-3">Admin Panel</a></li>`;
    }

    // Replace Login/Register with Logout
    nav += `<li class="nav-item"><a href="javascript:void(0)" onclick="UserService.logout()" class="nav-link text-danger ms-3">Logout</a></li>`;
    
    // Update the UI
    $(".navbar-nav").html(nav);
  }
}, 

list: function() {
        console.log("Fetching users for admin table...");
        RestClient.get("api/users", function(data) {
            var html = "";
            for (var i = 0; i < data.length; i++) {
                // Using user_id to match your UserDao
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
        }, function(error) {
            console.error("User list error:", error);
            toastr.error("Could not load users.");
        });
    },

    loadProfile: function() {
    const token = localStorage.getItem("user_token");
    const user = Utils.parseJwt(token); // Decodes your JWT token

    if (user) {
        // user.first_name, user.email, etc., come from your JWT payload
        $("#profile-full-name").text((user.first_name || "") + " " + (user.last_name || ""));
        $("#profile-email").text(user.email || "N/A");
        $("#profile-role").text(user.role === 'ADMIN' ? "Elite Administrator" : "Scuderia Member");
        $("#user-initials").text(user.first_name ? user.first_name.charAt(0).toUpperCase() : "U");
    } else {
        window.location.hash = "#login";
    }
},
};