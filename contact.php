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
                                            <th class="wp-10">Status</th>
                                            <th class="wp-30">Notes</th>
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
    <?php require_once("_addcontact.html"); ?>
    <script>
        $(function() {
            GetContactList();

            $('#contactForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serializeArray();
                $.ajax({
                        url: 'postContact.php',
                        method: 'POST',
                        dataType: 'json',
                        data: formData,
                        beforeSend: ShowLoadingFn
                    })
                    .done(function(data) {
                        if (data.Result) {
                            GetContactList();
                            showNotify(data.Result, 'success');
                            $('#AddContactModal').modal('hide');
                        } else {
                            showNotify(data.Error, 'danger');
                        }
                    })
                    .always(function() {
                        HideLoadingFn();
                    })
                    .fail(function(data) {
                        var err = JSON.parse(result.responseText);
                        showNotify(err.result, 'danger');
                    });
            });
        });

        function GetContactList() {
            $.ajax({
                    url: 'postContact.php',
                    method: 'POST',
                    dataType: 'json',
                    data: ({
                        GetContact: true,
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
                            var dhtml = '<button class="btn btn-warning btn-sm mr-4" onclick="GetContactDetails(' + row.Id + ')"><i class="fa fa-edit"></i></button>';
                            dhtml += '<button class="btn btn-danger btn-sm" onclick="DeleteContact(' + row.Id + ')"><i class="fa fa-trash"></i></button>';
                            return dhtml;
                        },
                    },
                    {
                        data: "Name",
                        name: "Name"
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
                        data: "Status",
                        name: "Status"
                    },
                    {
                        data: "Notes",
                        name: "Notes"
                    },

                ]
            })

        }

        function GetContactDetails(Id) {
            $.ajax({
                    url: 'postContact.php',
                    method: 'POST',
                    dataType: 'json',
                    data: ({
                        GetContact: true,
                        Id: Id
                    }),
                    beforeSend: ShowLoadingFn
                })
                .done(function(data) {
                    if (data.Status) {
                        $('input[name="Id"]').val(Id);
                        $('#AddContactModal').modal('show');
                        $('input[name="Name"]').val(data.Result.Name);
                        $('input[name="Mobile"]').val(data.Result.Mobile);
                        $('input[name="Email"]').val(data.Result.Email);
                        $('select[name="Status"]').val(data.Result.Status);
                        $('textarea[name="Notes"]').val(data.Result.Notes);
                    } else
                        showNotify(data.Error, 'danger');
                })
                .always(function() {
                    HideLoadingFn();
                })
                .fail(function(result) {
                    var err = JSON.parse(result.responseText);
                    showNotify(err.result, 'danger');
                });
        }

        $('#AddContactModal').on('show.bs.modal', function(event) {
            $('#addcontactTitle').text('Update Contact');
            $('button[type="submit"]').text('Update');
            $('input[name="ModifyContact"]').val('Update');
        });

        function DeleteContact(Id) {
            $.ajax({
                    url: 'postContact.php',
                    method: 'POST',
                    dataType: 'json',
                    data: ({
                        ModifyContact: "Delete",
                        Id: Id
                    }),
                    beforeSend: ShowLoadingFn
                })
                .done(function(data) {
                    if (data.Status) {
                        showNotify(data.Result, 'warning');
                        GetContactList();
                    } else
                        showNotify(data.Error, 'danger');
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