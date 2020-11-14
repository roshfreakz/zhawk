<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Zhawk</title>
    <link rel="icon" href="img/logo-mini.png" type="image/png">
    <link rel="stylesheet" href="css/fontawesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/argon.css" type="text/css">
    <link rel="stylesheet" href="css/custom.css" type="text/css">
</head>

<body class="bg-default">
    <div class="main-content">
        <div class="header bg-gradient-primary login-header">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col">
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>

        <div class="container login-container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-header bg-transparent text-center">
                            <img src="img/logo-full.png" class="img-fluid login-logo" alt="logo">
                        </div>
                        <div class="card-body px-lg-5 py-lg-5">
                            <form role="form" id="divlogin">
                                <div class="form-group mb-3">
                                    <label class="label-control small">Agent ID</label>
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input class="form-control" type="text" name="id" value="102_2223264" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="label-control small">Password</label>
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input class="form-control" type="password" name="password" value="Sjrinfo@123" required>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <input type="hidden" name="CheckLogin" value="true">
                                    <button type="submit" class="btn btn-block btn-primary my-4">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>
    <script src="js/argon.js"></script>

    <script>
        localStorage.clear();
        $('#divlogin').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serializeArray();
            $.ajax({
                    url: 'https://piopiy.telecmi.com/v1/agentLogin',
                    method: 'POST',
                    dataType: 'json',
                    data: formData,
                    beforeSend: ShowLoadingFn
                })
                .done(function(data) {
                    if (data.code == 200) {
                        showNotify("Login Success", 'success');
                        localStorage.setItem("token", data.token);
                        localStorage.setItem("userData", JSON.stringify(data.agent));
                        window.location.href = "index.php";
                    } else if (data.code == 404) {
                        showNotify('Invalid agent id or password', 'warning');
                    } else {
                        showNotify('Authentication failed', 'danger');
                    }
                })
                .always(function() {
                    HideLoadingFn();
                })
                .fail(function(data) {
                    showNotify('Server Error', 'danger');
                });
        });
    </script>
</body>

</html>