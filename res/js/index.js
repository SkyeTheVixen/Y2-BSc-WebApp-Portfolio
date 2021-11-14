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
                alert("done");
            }
        });
        event.preventDefault();
    })
})