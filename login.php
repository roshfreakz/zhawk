<!DOCTYPE html>
<html>

<head>
    <?php require_once("_header.html"); ?>
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
                            <img src="assets/img/brand/logo-full.png" class="img-fluid login-logo" alt="logo">
                        </div>
                        <div class="card-body px-lg-5 py-lg-5">

                            <!-- Login -->
                            <form role="form" id="divlogin">
                                <h1 class="header1 text-center py-3">Login</h1>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" name="Email" placeholder="Email" type="email" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" name="Password" placeholder="Password" type="password" required>
                                    </div>
                                </div>
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id="customCheckLogin" type="checkbox">
                                    <label class="custom-control-label" for="customCheckLogin">
                                        <span>Remember me</span>
                                    </label>
                                </div>
                                <div class="text-center">
                                    <input type="hidden" name="CheckLogin" value="true">
                                    <button type="submit" class="btn btn-block btn-primary my-4">Login</button>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <a onclick="ToggleScreen('forgot')"><small>Forgot password <i class="fa fa-question"></i></small></a>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a onclick="ToggleScreen('register')"><small> Register <i class="fa fa-user-plus"></i></small></a>
                                    </div>
                                </div>
                            </form>

                            <!-- Register -->
                            <form role="form" id="divregister" style="display: none;">
                                <h1 class="header1 text-center py-3">Register</h1>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                        </div>
                                        <input class="form-control" name="FullName" placeholder="Full Name" type="text" required>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                        </div>
                                        <input class="form-control" name="Mobile" placeholder="Mobile" type="number" required>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" name="Email" placeholder="Email" type="email" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" name="Password" id="Pass" placeholder="Password" type="password" autocomplete="new-password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-key-25"></i></span>
                                        </div>
                                        <input class="form-control" name="ConfirmPassword" id="CPass" placeholder="Confirm Password" type="password" autocomplete="new-password" required>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <input type="hidden" name="RegisterUser" value="true">
                                    <button type="submit" class="btn btn-block btn-primary my-4">Register</button>
                                </div>
                                <div class="row mt-2">
                                    <div class="col text-right">
                                        <a onclick="ToggleScreen('login')"><small>Login <i class="fa fa-sign-in-alt"></i></small></a>
                                    </div>
                                </div>
                            </form>

                            <!-- Forgot -->
                            <form role="form" id="divforgot" style="display: none;">
                                <h1 class="header1 text-center py-3">Forgot Password</h1>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Email" type="email">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-block btn-primary my-4">Submit</button>
                                </div>
                                <div class="row mt-2">
                                    <div class="col text-right">
                                        <a onclick="ToggleScreen('login')"><small>Login <i class="fa fa-sign-in-alt"></i></small></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php require_once("_footer.html"); ?>
    <script src="local/login.js"></script>
</body>

</html>