$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault();
        var email = $("#InputEmail").val();
        var password = $("#InputPassword").val();
        if (email === "" || password === "") {
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You may have entered invalid credentials. Please try again',
                heightAuto: false
            });
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
                        text: 'You may have entered invalid credentials. Please try again',
                        heightAuto: false
                    });
                }
            }
        });
    })

    $("#passResetForm").submit(function (event) {
        event.preventDefault();
        var email = $("#emailInputReset").val();
        if (email === "") {
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter your email address'
            });
        }
        $.ajax({
            type: "post",
            url: "../php/passReset.php",
            data: {
                email: email
            },
            cache: false,
            success: function (dataResult) {
                var DataResult = JSON.parse(dataResult);
                if (DataResult.statusCode === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Password reset link has been sent to your email address'
                    });
                } else if (DataResult.statusCode === 201) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please enter your email address'
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again'
                });
            }
        });
    });
})