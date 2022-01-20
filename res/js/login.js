$(document).ready(function () {
    let regenCount = 1;
    let suregenCount = 1;
    $("#loginForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            url: 'res/jCaptcha/backend.php',
            type: 'POST',
            data: {
                'txtCaptcha': $('#InputCaptcha').val()
            },
            success: function (res) {
                if (res == 'true')
                {
                    var email = $("#InputEmail").val();
                    var password = $("#InputPassword").val();
                    if (email === "" || password === "") {
                        return Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'You may have entered invalid credentials. Please try again',
                            heightAuto: false
                        }).then(function () {
                            $('#imgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                            $('#InputCaptcha').val('');
                        });
                    }
                    $.ajax({
                        type: "post",
                        url: "res/php/auth.php",
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
                                    text: 'Your credentials were invalid.',
                                    heightAuto: false
                                }).then(function () {
                                    $('#imgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                                    $('#InputCaptcha').val('');
                                });
                            } else if (DataResult.statusCode === 202) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'No user account was found with this email address',
                                    heightAuto: false
                                }).then(function () {
                                    $('#imgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                                    $('#InputCaptcha').val('');
                                });
                            } else if (DataResult.statusCode === 203) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: 'Please enter your email address And/Or Password',
                                    heightAuto: false
                                }).then(function () {
                                    $('#imgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                                    $('#InputCaptcha').val('');
                                });
                            } else if (DataResult.statusCode === 204) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    html: 'Your Account is Locked. Please <a href="mailto:webmaster@vixendev.com">contact support</a>.',
                                    heightAuto: false
                                }).then(function () {
                                    $('#imgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                                    $('#InputCaptcha').val('');
                                });
                            } else if (DataResult.statusCode === 205) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: 'You\'ve been IP blocked for 5 minutes due to multiple incorrect login attempts. Please <a href="mailto:webmaster@vixendev.com">contact support</a>.',
                                    heightAuto: false
                                }).then(function () {
                                    $('#imgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                                    $('#InputCaptcha').val('');
                                });
                            } else if (DataResult.statusCode === 206) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: 'That email didnt match the expected format.',
                                    heightAuto: false
                                }).then(function () {
                                    $('#imgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                                    $('#InputCaptcha').val('');
                                });
                            }
                        }
                    });
                }
                else
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: 'The captcha was invalid',
                        heightAuto: false
                    }).then(function () {
                        $('#imgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                        $('#InputCaptcha').val('');
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
                }  else if (DataResult.statusCode === 201) {
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
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.ajax({
                    type: "post",
                    url: "res/php/logger.php",
                    data: {
                        jqXHR: jqXHR,
                        textStatus: textStatus,
                        errorThrown: errorThrown
                    },
                    cache: false
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again',
                    heightAuto: false
                });
            }
        });
    });

    $('#btnNewCaptcha').click(function (e) {
        e.preventDefault();

        if (regenCount > 5)
            $('#btnNewCaptcha').remove();
        else
        {
            $('#imgCaptcha').attr('src', 'res/jCaptcha/generate.php');
            regenCount++;
        }
    });
})