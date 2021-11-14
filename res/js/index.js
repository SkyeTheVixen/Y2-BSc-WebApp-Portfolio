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
                console.log(dataResult);
                var status = JSON.parse(dataResult);
                if (status.statuscode === 200) {
                    alert("Email sent successfully");
                } else if (status.statuscode === 201) {                 
                    alert("Email not sent");
                }
            }
        });
        event.preventDefault();
    })
})