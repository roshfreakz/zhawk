$(function () {
  if (localStorage.getItem("userData") != null) {
    var userData = JSON.parse(localStorage.getItem("userData"));
    $('#spanFullName').text(userData.FullName);
  }

  var page = window.location.pathname;
  var path = page.split("/");
  var npath = path[2]; 
  console.log(npath);
  $('#navbar-sidebar li a').removeClass('active');
  $('#navbar-sidebar li a[href="' + npath + '"]').addClass('active');

})

function ShowLoadingFn() {
  $('#loader').show();
  $('button').prop('disabled', true);
}

function HideLoadingFn() {
  setTimeout(function () {
    $('#loader').hide();
    $('button').prop('disabled', false);
  }, 1000);
}

function showNotify(msg, type) {
  $.notify({
    message: msg
  }, {
    type: type,
    allow_dismiss: true,
    template: '<div data-notify="container" class="notify alert alert-{0}" role="alert">' +
      '<span data-notify="title">{1}</span>' +
      '<span data-notify="message">{2}</span>' +
      '</div>'
  });
}