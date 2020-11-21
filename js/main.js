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


  var telecmi = new TeleCMI();
  telecmi.start(localStorage.getItem('token'));
  telecmi.onConnect = function (data) {
    if (data.status == 'connected') {
      telecmi.subscribeCalls();
    } else if (data.status == 'error') {
      showNotify('Agent Status Error', 'danger');
    }
  };

  if (localStorage.getItem("agentStatus") != null) {
    $('#agentStatus').val(localStorage.getItem('agentStatus'));
  } else {
    telecmi.setOnline();
  }

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
    localStorage.setItem("agentStatus", status);
    $('#agentStatus').val(localStorage.getItem('agentStatus'));
  });


  telecmi.onCalls = function (data) {
    console.log(data);
    $('#callerNumber').text(data.to);
    switch (data.action) {
      case "ch-c":
        $('#callNotifyModal').modal('show');
        $('#callerStatus').text('Ringing...');
        break;
      case "ch-s":
        $('#callNotifyModal').modal('show');
        $('#callerStatus').text('Call Connected');
        break;
      case "ch-d":
        $('#callerStatus').text('Call Ended');
        break;
    }
  };


});