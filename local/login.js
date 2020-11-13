$(function () {

    HideLoadingFn();

    $('form').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        switch (this.id) {
            case "divlogin":
                CheckLogin(formData);
                break;
            case "divregister":
                var Pass = $('#Pass').val();
                var CPass = $('#CPass').val();
                if (Pass == CPass) RegisterUser(formData);
                else showNotify("Passwords doesn't Match!", 'danger');
                break;
            case "divforgot":
                ForgotPassword(formData);
                break;
        }
    });
});

function ToggleScreen(arg) {
    $('.form-control').val('');
    $('#divregister').hide();
    $('#divforgot').hide();
    $('#divlogin').hide();
    if (arg != "") {
        $('#div' + arg).show();
    }
}

function CheckLogin(formData) {
    $.ajax({
            url: 'server/login.php',
            method: 'POST',
            dataType: 'json',
            data: formData,
            beforeSend: ShowLoadingFn
        })
        .done(function (data) {
            console.log("Success", data);
            if (data.Status) {
                showNotify("Login Success", 'success');
                localStorage.setItem("userData", data.Result);
                window.location.href = "index.php";
            }else{
                showNotify(data.Error, 'danger');
            }
        })
        .always(function () {
            HideLoadingFn();
        })
        .fail(function (data) {
            console.log("Failed", data);
            var result = JSON.parse(data.responseText);
            showNotify(result.Error, 'danger');
        });
}

function RegisterUser(formData) {
    $.ajax({
            url: 'server/login.php',
            method: 'POST',
            dataType: 'json',
            data: formData,
            beforeSend: ShowLoadingFn
        })
        .done(function (data) {
            if (data.Status) {
                showNotify(data.Result, 'success');
                ToggleScreen('login');
            } else
                showNotify(data.Result, 'danger');
        })
        .always(function () {
            HideLoadingFn();
        })
        .fail(function (result) {
            var err = JSON.parse(result.responseText);
            showNotify(err.result, 'danger');
        });
}

function ForgotPassword(formData) {
    $.ajax({
            url: 'server/login.php',
            method: 'POST',
            dataType: 'json',
            data: formData,
            beforeSend: ShowLoadingFn
        })
        .done(function (data) {
            showNotify(data.result.message, 'success');
            ToggleScreen('login');
        })
        .always(function () {
            HideLoadingFn();
        })
        .fail(function (result) {
            var err = JSON.parse(result.responseText);
            showNotify(err.result.message, 'danger');
        });
}