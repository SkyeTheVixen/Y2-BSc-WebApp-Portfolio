$(document).ready(function () {

    //Login
    function login(token) {
        //Check if the login fields have been filled in
        if ($("#InputEmail").val() === "" || $("#InputPassword").val() === "") {
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You may have entered invalid credentials. Please try again',
                heightAuto: false
            });
        }

        //AJAX Authentication request
        $.ajax({
            type: "post",
            url: "res/php/auth.php",
            data: $('#loginForm').serialize() + "&token=" + token,
            cache: false,
            success: function (res) {
                var DataResult = JSON.parse(res);
                if(DataResult.statusCode === 200) {
                    window.location.href = "index";
                } else if (DataResult.statusCode === 201 || DataResult.statusCode === 202 || DataResult.statusCode === 203) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please check your email or password.',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 204) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        html: 'Your Account is Locked, try again or <a href="mailto:webmaster@vixendev.com">contact support</a> if this issue reoccurs.',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 205) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: 'You\'ve been IP blocked for 5 minutes due to multiple incorrect login attempts. Please <a href="mailto:webmaster@vixendev.com">contact support</a> if this issue reoccurs.',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 206) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: 'That email didnt match the expected format.',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 207) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: 'You failed the captcha, try again or <a href="mailto:webmaster@vixendev.com">contact support</a> if this issue reoccurs.',
                        heightAuto: false
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again',
                    heightAuto: false
                });
            }
        });
    }

    $("#loginForm").submit(function (event) {
        event.preventDefault();
        grecaptcha.ready(function () {
            grecaptcha.execute('6Ldh57IeAAAAABHfJ3uN3Zxp_1c-zTEbB3sVuk98', {
                action: 'create_comment'
            }).then(function (token) {
                login(token);
            });
        });
    });




    //Password Reset - Refactor
    $("#passResetForm").submit(function (event) {
        event.preventDefault();
        var email = $("#emailInputReset").val();
        if (email === "") {
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter your email address',
                heightAuto: false
            });
        }
        $.ajax({
            type: "post",
            url: "res/php/passreset.php",
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
                        text: 'Password reset link has been sent to your email address',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 201) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong, try again.',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 202) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No Account was found with this email.',
                        heightAuto: false
                    });
                }
            }
        });
    });

})