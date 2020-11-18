$(function () {
  if (localStorage.getItem("userData") != null) {
    var userData = JSON.parse(localStorage.getItem("userData"));
    $('#spanFullName').text(userData.name);
  }

  var page = window.location.pathname;
  var path = page.split("/");
  var npath = path[2];

  $('#navbar-sidebar li a').removeClass('active');
  if (npath) $('#navbar-sidebar li a[href="' + npath + '"]').addClass('active');
  else $('#navbar-sidebar li a[href="index.php"]').addClass('active');

  // Set Agent Status
  var telecmi = new TeleCMI();
  telecmi.start(localStorage.getItem('token'));

  $('#statusForm').on('submit', function (e) {
    e.preventDefault();
    var status = $('#agentStatus').val();
    switch (status) {
      case "o":
        telecmi.setOnline();
        break;
      case "d":
        telecmi.setBreak();
        break;
      case "s":
        telecmi.setDialer();
        break;
    }
    showNotify('Agent Status Updated', 'success');
    $('#UpdateStatusModal').modal('hide');
  });

});