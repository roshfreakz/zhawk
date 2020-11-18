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
                                    <li><a href="#"><i class="fas fa-chart-line"></i></a></li>
                                    <li class="pl-2"><a href="#">Reports</a></li>
                                </ol>
                            </nav>
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
                            <div class="d-flex px-4">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <button class="btn btn-primary nav-link active" id="Answered" onclick="GetOutBoundCalls(this.id)">Answered</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="btn btn-primary nav-link" id="Missed" onclick="GetOutBoundCalls(this.id)">Missed</button>
                                    </li>
                                </ul>
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item d-flex align-items-center">
                                        <label class="mr-3">From</label>
                                        <input class="form-control form-control-sm" type="date" name="fromDate">
                                    </li>
                                    <li class="nav-item d-flex align-items-center">
                                        <label class="mr-3">To</label>
                                        <input class="form-control form-control-sm" type="date" name="toDate">
                                    </li>
                                </ul>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover" id="userTable">
                                    <thead>
                                        <tr>
                                            <th>To</th>
                                            <th>Name</th>
                                            <th>Time</th>
                                            <th>Action</th>
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
            var type = "Answered";
            var today = new Date();
            var fromdatestr = new Date();
            var todatestr = new Date();
            fromdatestr.setDate(today.getDate() - 1);
            todatestr.setDate(today.getDate() + 1);

            $('input[name="fromDate"]').val(moment(fromdatestr).format("YYYY-MM-DD"));
            $('input[name="toDate"]').val(moment(todatestr).format("YYYY-MM-DD"));

            GetOutBoundCalls(type);

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
                            showNotify(data.Result, 'success');
                            $('#AddContactModal').modal('hide');
                        }
                    })
                    .always(function() {
                        HideLoadingFn();
                    })
                    .fail(function(data) {
                        showNotify('Server Error', 'danger');
                    });
            });

        })

        function GetOutBoundCalls(arg) {
            type = arg;

            var fromdate = $('input[name="fromDate"]').val();
            var todate = $('input[name="toDate"]').val();

            var datastr = {
                "token": localStorage.getItem('token'),
                "from": Date.parse(fromdate),
                "to": Date.parse(todate),
                "page": 1,
            }

            $('#pills-tab li button').removeClass('active');
            $('#' + arg).addClass('active');
            var dataurl = 'https://piopiy.telecmi.com/v1/agentOut' + arg;
            $.ajax({
                    url: dataurl,
                    method: 'POST',
                    dataType: 'json',
                    contentType: "application/json",
                    data: JSON.stringify(datastr),
                    beforeSend: ShowLoadingFn
                })
                .done(function(data) {
                    BindUserTable(data.cdr);
                })
                .always(function() {
                    HideLoadingFn();
                })
                .fail(function(data) {
                    var result = JSON.parse(data.responseText);
                    showNotify(result.Error, 'danger');
                });
        }


        $('input[type="date"]').on('change', function() {
            GetOutBoundCalls(type);

        });

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
                        data: "to",
                        name: "to"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        render: function(data, type, row, meta) {
                            var dateStr = new Date(row.time);
                            return moment(dateStr).format('DD-MMM-YYYY hh:mm A');
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            var dhtml = '<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#AddContactModal" data-mobile="' + row.to + '"><i class="fa fa-user-plus"></i></button>';
                            return dhtml;
                        }
                    }
                ]
            })

        }

        $('#AddContactModal').on('show.bs.modal', function(event) {
            var mobile = $(event.relatedTarget).data('mobile');
            $('#contactForm .form-control').val('');
            $(this).find('input[name="Mobile"]').val(mobile);
        })
    </script>
</body>

</html>