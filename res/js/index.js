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
})