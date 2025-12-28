let Utils = {
  datatable: function (table_id, columns, data, pageLength = 15) {
    if ($.fn.dataTable.isDataTable("#" + table_id)) {
      $("#" + table_id).DataTable().destroy();
    }

    $("#" + table_id).DataTable({
      data: data,
      columns: columns,
      pageLength: pageLength,
      lengthMenu: [5, 10, 15, 25, 50, 100, "All"]
    });
  },

  parseJwt: function (token) {
    if (!token) return null;
    try {
      const base64Url = token.split('.')[1];
      const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
      const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
      }).join(''));

      const decoded = JSON.parse(jsonPayload);
      return decoded.user || decoded;
    } catch (e) {
      console.error("Invalid JWT token", e);
      return null;
    }
  },

  isAdmin: function () {
    const token = localStorage.getItem("user_token");
    const user = Utils.parseJwt(token);
    return user && user.role === Constants.ADMIN_ROLE;
  },

  isLoggedIn: function () {
    return !!localStorage.getItem("user_token");
  },

  logout: function () {
    localStorage.removeItem("user_token");
    // This goes back to home or login page
    window.location.hash = "#home"; 
    window.location.reload();
  }
};