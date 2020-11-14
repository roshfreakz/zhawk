$(function () {
  if (localStorage.getItem("userData") != null) {
    var userData = JSON.parse(localStorage.getItem("userData"));
    $('#spanFullName').text(userData.name);
  }

  var page = window.location.pathname;
  var path = page.split("/");
  var npath = path[2]; 
  
  $('#navbar-sidebar li a').removeClass('active');
  $('#navbar-sidebar li a[href="' + npath + '"]').addClass('active');

});

