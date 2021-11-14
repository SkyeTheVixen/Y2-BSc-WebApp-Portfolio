$(document).ready(function () {
    $("#logoutBtn").click(function (event) {
        $.ajax({
            type: "get",
            url: "php/logout.php",
            success: function (dataResult) {
                location.href = "login";
            }
        });
        event.preventDefault();
    })

    $("#button").click(function (event) {
        $.ajax({
            type: "get",
            url: "php/sendTestEmail.php",
            success: function (dataResult) {
                var status = JSON.parse(dataResult);
                alert(status.statuscode);
            }
        });
        event.preventDefault();
    })
})