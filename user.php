<!DOCTYPE html>
<html>

<head>
    <?php require_once("_header.html"); ?>
</head>

<body>
    <!-- Sidenav -->
    <?php require_once("_sidebar.html"); ?>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <?php require_once("_topbar.html"); ?>
        <!-- Header -->
        <div class="header pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li><a href="#"><i class="fas fa-users"></i></a></li>
                                    <li class="pl-2"><a href="#">Contacts</a></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col text-right">
                            <button class="btn btn-primary">Add Contact</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">

            <div class="row">
                <div class="col">
                    <div class="card">                      
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="userTable">
                                    <thead>
                                        <tr>
                                            <th class="wp-10">Modify</th>
                                            <th class="wp-20">Name</th>
                                            <th class="wp-20">Email</th>
                                            <th class="wp-10">Mobile</th>
                                            <th class="wp-30">Notes</th>
                                            <th class="wp-10">Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php require_once("_footer.html"); ?>
    <script src="local/user.js"></script>
</body>

</html>