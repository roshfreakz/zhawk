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
                                    <li><a href="#"><i class="ni ni-tv-2"></i></a></li>
                                    <li class="pl-2"><a href="#">Dashboards</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Card stats -->
                    <div class="row">

                        <div class="col-md-4 col-12">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Answered Calls</h5>
                                            <span class="h2 card-numbers font-weight-bold mb-0" id="AnsweredCalls">0</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="ni ni-chart-pie-35"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Missed Calls</h5>
                                            <span class="h2 card-numbers font-weight-bold mb-0" id="MissedCalls">0</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="ni ni-money-coins"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Total Calls</h5>
                                            <span class="h2 card-numbers font-weight-bold mb-0" id="TotalCalls">0</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="ni ni-chart-bar-32"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php require_once("_footer.html"); ?>
    <script>
        var todate = new Date();
        var fromdate = new Date();
        fromdate.setDate(todate.getDate() - 13);

        var datastr = {
            "token": localStorage.getItem('token'),
            "from": Date.parse(fromdate),
            "to": Date.parse(todate),
        }

        $(function() {
            GetUserList();
        })

        function GetUserList() {

            $.ajax({
                    url: 'https://piopiy.telecmi.com/v1/agentAnalysis',
                    method: 'POST',
                    dataType: 'json',
                    contentType: "application/json",
                    data: JSON.stringify(datastr),
                    beforeSend: ShowLoadingFn
                })
                .done(function(data) {
                    console.log(data);
                    if (data.code == 200) {
                        if (data.calls.length > 0) {  
                            var call = data.calls[0];                          
                            $('#AnsweredCalls').text(call.answered);
                            $('#MissedCalls').text(call.missed);
                            $('#TotalCalls').text(call.answered + call.missed);
                        }
                    } else {
                        showNotify('Error in Fetching Data', 'danger');
                    }
                })
                .always(function() {
                    HideLoadingFn();
                })
                .fail(function(data) {
                    showNotify('Error in Fetching Data', 'danger');
                });
        }
    </script>
</body>

</html>