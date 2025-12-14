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
      const base64Payload = token.split('.')[1];
      const payload = atob(base64Payload);
      return JSON.parse(payload).user || JSON.parse(payload);
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
    window.location.href = "login.html";
  }
};
