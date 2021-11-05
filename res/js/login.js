$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault();
        var email = $("#InputEmail").val();
        var password = $("#InputPassword").val();
        if (email === "" || password === "") {
            return;
        }
        $.ajax({
            type: "post",
            url: "../php/auth.php",
            data: {
                txtUser: email,
                txtPassword: password
            },
            cache: false,
            success: function (dataResult) {
                var DataResult = JSON.parse(dataResult);
                if (DataResult.statusCode === 200) {
                    location.href = "index";
                } else if (DataResult.statusCode === 201) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'You may have entered invalid credentials. Please try again'
                    });
                }
            }
        });
    })
})