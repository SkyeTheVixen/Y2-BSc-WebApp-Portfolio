$(document).ready(function () {

    //Login
    function login(token) {

    }

    $("#loginForm").submit(function (event) {
        event.preventDefault();
        //Check if the login fields have been filled in
        if ($("#InputEmail").val() === "" || $("#InputPassword").val() === "") {
            return Swal.fire('Oops...', 'You may have entered invalid credentials. Please try again', 'error', {
                heightAuto: false
            });
        }
        grecaptcha.ready(function () {
            grecaptcha.execute('6Ldh57IeAAAAABHfJ3uN3Zxp_1c-zTEbB3sVuk98', {
                action: 'create_comment'
            }).then(function (token) {
                //AJAX Authentication request
                $.post("res/php/auth.php", $('#loginForm').serialize() + "&token=" + token, function (res) {
                        if (JSON.parse(res).statusCode === 200) {
                            window.location.href = "index";
                        } else if (JSON.parse(res).statusCode === 201 || JSON.parse(res).statusCode === 202 || JSON.parse(res).statusCode === 203) {
                            Swal.fire('Oops...', 'Please check your credentials', 'error',{
                                heightAuto: false
                            });
                        } else if (JSON.parse(res).statusCode === 204) {
                            Swal.fire('Oops...', '', 'warning',{
                                html: 'Your Account is Locked, try again or <a href="mailto:webmaster@vixendev.com">contact support</a> if this issue reoccurs.',
                                heightAuto: false
                            });
                        } else if (JSON.parse(res).statusCode === 205) {
                            Swal.fire('Oops...', '', 'error',{
                                html: 'You\'ve been IP blocked for 5 minutes due to multiple incorrect login attempts. Please <a href="mailto:webmaster@vixendev.com">contact support</a> if this issue reoccurs.',
                                heightAuto: false
                            });
                        } else if (JSON.parse(res).statusCode === 206) {
                            Swal.fire('Oops...', '', 'error',{
                                html: 'That email didnt match the expected format.',
                                heightAuto: false
                            });
                        } else if (JSON.parse(res).statusCode === 207) {
                            Swal.fire('Oops...', '', 'error',{
                                html: 'You failed the captcha, try again or <a href="mailto:webmaster@vixendev.com">contact support</a> if this issue reoccurs.',
                                heightAuto: false
                            });
                        }
                    }
                );
            });
        });
    });

    //Password Reset
    $("#passResetForm").submit(function (e) {
        e.preventDefault();
        if ($("#emailInputReset").val() === "") {
            return Swal.fire('Oops...', 'Please enter your email address', 'error', {
                heightAuto: false
            });
        }
        $.post("res/php/user/resetPass.php", $(this).serialize(), function (res, status, xhr) {
            if (xhr.status === 200) {
                Swal.fire('Success', 'If an account with this email exists, a link has been sent to reset the password', 'success', {
                    heightAuto: false
                });
            } else if (xhr.status === 201) {
                Swal.fire('Oops...', 'Something went wrong, try again.', 'error', {
                    heightAuto: false
                });
            } else if (xhr.status === 202) {
                Swal.fire('Success', 'If an account with this email exists, a link has been sent to reset the password', 'success', {
                    heightAuto: false
                });
            } else if (xhr.status === 203) {
                Swal.fire('Success', 'If an account with this email exists, a link has been sent to reset the password', 'success', {
                    heightAuto: false
                });
            }
        });
    });
})