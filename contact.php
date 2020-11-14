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
                            <button class="btn btn-primary d-none" onclick="ToggleScreen('Form')" id="addContact">Add Contact</button>
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
                            <div class="table-responsive" id="contactTable">
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

                            <form id="contactForm" style="display: none;">
                                <h6 class="heading-small text-muted mb-4">Add Contact</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-username">Full Name</label>
                                                <input class="form-control" name="FullName" placeholder="Full Name" type="text" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-username">Mobile</label>
                                                <input class="form-control" name="Mobile" placeholder="Mobile" type="number" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-first-name">Email</label>
                                                <input class="form-control" name="Email" placeholder="Email" type="email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-last-name">Password</label>
                                                <input class="form-control" name="Password" id="Pass" placeholder="Password" type="password" autocomplete="new-password" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-last-name">Confirm Password</label>
                                                <input class="form-control" name="ConfirmPassword" id="CPass" placeholder="Confirm Password" type="password" autocomplete="new-password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-first-name">Status</label>
                                                <select class="form-control" placeholder="Confirm Password" name="Status" required>
                                                    <option>Online</option>
                                                    <option>Do Not Disturb</option>
                                                    <option>Start Campaign</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-last-name">Notes</label>
                                                <textarea class="form-control" name="Notes" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col text-right">
                                            <div class="form-group">
                                                <input type="hidden" name="AddContact" value="true">
                                                <button type="submit" class="btn btn-success">Save</button>
                                                <button type="button" class="btn btn-secondary ml-2" onclick="ToggleScreen('Table')">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
    <!-- Footer -->
    <?php require_once("_footer.html"); ?>
    <?php require_once("_addcontact.html"); ?>
    <script>
        $(function() {
            GetUserList();

            $('#contactForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serializeArray();
                var Pass = $('#Pass').val();
                var CPass = $('#CPass').val();
                if (Pass == CPass) AddContact(formData);
                else showNotify("Passwords doesn't Match!", 'danger');
            });
        });

        function ToggleScreen(arg) {
            $('#contactForm .form-control').val('');
            $('#contactTable').hide();
            $('#contactForm').hide();
            $('#addContact').show();
            if (arg) {
                $('#contact' + arg).show();
            }
            if (arg == 'Form') {
                $('#addContact').hide();
            }
        }

        function GetUserList() {
            $.ajax({
                    url: 'server/postUser.php',
                    method: 'POST',
                    dataType: 'json',
                    data: ({
                        GetUserList: true
                    }),
                    beforeSend: ShowLoadingFn
                })
                .done(function(data) {
                    var result = JSON.parse(data.Result);
                    BindUserTable(result);
                })
                .always(function() {
                    HideLoadingFn();
                })
                .fail(function(data) {
                    var result = JSON.parse(data.responseText);
                    showNotify(result.Error, 'danger');
                });
        }

        function BindUserTable(result) {
            $('#userTable').DataTable({
                aaData: result,
                autoWidth: false,
                destroy: true,
                language: {
                    search: '',
                    searchPlaceholder: "Search...",
                    paginate: {
                        next: '&#8594;',
                        previous: '&#8592;'
                    }
                },
                order: [],
                columnDefs: [{
                    orderable: false,
                    targets: [0]
                }, ],
                columns: [{
                        render: function(data, type, row, meta) {
                            var dhtml = '<button class="btn btn-warning btn-sm mr-4" onclick="DoUpdateUser(' + row.UserId + ')"><i class="fa fa-edit"></i></button>';
                            dhtml += '<button class="btn btn-danger btn-sm" onclick="DoDeleteUser(' + row.UserId + ')"><i class="fa fa-trash"></i></button>';
                            return dhtml;
                        },
                    },
                    {
                        data: "FullName",
                        name: "FullName"
                    },

                    {
                        data: "Email",
                        name: "Email"
                    },
                    {
                        data: "Mobile",
                        name: "Mobile"
                    },
                    {
                        data: "Notes",
                        name: "Notes"
                    },
                    {
                        data: "Status",
                        name: "Status"
                    },
                ]
            })

        }

        function AddContact(formData) {
            $.ajax({
                    url: 'server/postUser.php',
                    method: 'POST',
                    dataType: 'json',
                    data: formData,
                    beforeSend: ShowLoadingFn
                })
                .done(function(data) {
                    if (data.Status) {
                        showNotify('Contact Added Successfully!', 'success');
                        ToggleScreen('Table');
                        GetUserList();
                    } else
                        showNotify(data.Result, 'danger');
                })
                .always(function() {
                    HideLoadingFn();
                })
                .fail(function(result) {
                    var err = JSON.parse(result.responseText);
                    showNotify(err.result, 'danger');
                });
        }

        function DoDeleteUser(arg) {
            $.ajax({
                    url: 'server/postUser.php',
                    method: 'POST',
                    dataType: 'json',
                    data: ({
                        DeleteContact: true,
                        UserId: arg
                    }),
                    beforeSend: ShowLoadingFn
                })
                .done(function(data) {
                    if (data.Status) {
                        showNotify('Contact Deleted Successfully!', 'success');
                        GetUserList();
                    } else
                        showNotify(data.Result, 'danger');
                })
                .always(function() {
                    HideLoadingFn();
                })
                .fail(function(result) {
                    var err = JSON.parse(result.responseText);
                    showNotify(err.result, 'danger');
                });
        }
    </script>
</body>

</html>