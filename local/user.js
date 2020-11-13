$(function () {
    GetUserList();
   
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
        .done(function (data) {
            console.log("Success", data);
            var result = JSON.parse(data.Result);
            BindUserTable(result);
        })
        .always(function () {
            HideLoadingFn();
        })
        .fail(function (data) {
            var result = JSON.parse(data.responseText);
            showNotify(result.Error, 'danger');
        });
}

function BindUserTable(result){
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
                    var dhtml = '<button class="btn btn-warning btn-sm mr-4" onclick="DoUpdateUser(' + row.UserId + ', this)"><i class="fa fa-edit"></i></button>';
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
                render: function(data, type, row, meta) {
                    if (row.Status == "1") {
                        return '<button class="btn btn-success btn-sm" onclick="DoChangeStatus(this,' + row.UserId + ',0)"> Active </button>';
                    } else {
                        return '<button class="btn btn-secondary btn-sm" onclick="DoChangeStatus(this,' + row.UserId + ',1)"> Inactive </button>';
                    }
                }
            },

        ]
    })

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

