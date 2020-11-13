$(function(){
    GetUserList();
})


function GetUserList() {
    var datastr = {
        "appid": 2223264,
        "token": "92924bb6-9c55-41c5-b380-df6706727a6b"
    }
    $.ajax({
            url: 'https://piopiy.telecmi.com/v1/analysis',
            method: 'POST',
            dataType: 'json',
            contentType: "application/json",
            data: JSON.stringify(datastr),
            beforeSend: ShowLoadingFn
        })
        .done(function (data) {
            console.log("Success", data);
            if(data.code == 200){
                $('#TotalCalls').text(data.total);
                $('#AnsweredCalls').text(data.answered);
                $('#MissedCalls').text(data.missed);
            }
        })
        .always(function () {
            HideLoadingFn();
        })
        .fail(function (data) {
            var result = JSON.parse(data.responseText);
            showNotify(result.Error, 'danger');
        });
}