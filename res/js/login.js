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
                            console.log(dataResult);
                            var DataResult = JSON.parse(dataResult);
                            if (DataResult.statusCode === 200) {
                                console.log(dataResult);
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

    $("#signupForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            url: 'res/jCaptcha/backend.php',
            type: 'POST',
            data: {
                'txtCaptcha': $('#suInputCaptcha').val()
            },
            success: function (res) {
                if (res == 'true')
                {
                    var Email = $("#signupInputEmail").val();
                    var Password = $("#signupInputPassword").val();
                    var PasswordConfirm = $("#signupInputPasswordConfirm").val();
                    var FirstName = $("#signupInputFirstName").val();
                    var LastName = $("#signupInputLastName").val();
                    if (Email === "" || Password === "" || PasswordConfirm === "" || FirstName === "" || LastName === "") {
                        if(Email === ""){
                            $("#signupInputEmail").addClass("border border-danger");
                        }
                        if(Password === ""){
                            $("#signupInputPassword").addClass("border border-danger");
                        }
                        if(PasswordConfirm === ""){
                            $("#signupInputPasswordConfirm").addClass("border border-danger");
                        }
                        if(FirstName === ""){
                            $("#signupInputFirstName").addClass("border border-danger");
                        }
                        if(LastName === ""){
                            $("#signupInputLastName").addClass("border border-danger");
                        }
                        return Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please ensure all fields are filled in',
                            heightAuto: false
                        }).then(function () {
                            $('#suimgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                            $('#suInputCaptcha').val('');
                        });
                    }
                    else if(Password !== PasswordConfirm){
                        $("#signupInputPassword").focus();
                        return Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please Ensure Your passwords match',
                            heightAuto: false
                        }).then(function () {
                            $('#suimgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                            $('#suInputCaptcha').val('');
                        });
                    }
                    $.ajax({
                        type: "post",
                        url: "res/php/signup.php",
                        data: {
                            FirstName: FirstName,
                            LastName: LastName,
                            Email: Email,
                            Password: Password,
                            PasswordConfirm: PasswordConfirm
                        },
                        cache: false,
                        success: function (dataResult) {
                            console.log(dataResult);
                            var DataResult = JSON.parse(dataResult);
                            if (DataResult.statusCode === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Congrats!',
                                    text: 'We\'ve sent you an email with a link to confirm your account, please check your spam if it does not arrive. If you havent received it after 5 minutes, please contact support with your name and email address and we will endeavour to sort it for you.',
                                    heightAuto: false
                                });
                            } else if (DataResult.statusCode === 201) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'You are missing values.',
                                    heightAuto: false
                                }).then(function () {
                                    $('#suimgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                                    $('#suInputCaptcha').val('');
                                });
                            } else if (DataResult.statusCode === 202) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Your passwords do not match',
                                    heightAuto: false
                                }).then(function () {
                                    $('#suimgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                                    $('#suInputCaptcha').val('');
                                });
                            } else if (DataResult.statusCode === 203) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'This email address is already in use',
                                    heightAuto: false
                                }).then(function () {
                                    $('#suimgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                                    $('#suInputCaptcha').val('');
                                });
                            }
                        }
                    });
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: 'The captcha was invalid',
                        heightAuto: false
                    }).then(function () {
                        $('#suimgCaptcha').attr('src', 'res/jCaptcha/generate.php');
                        $('#suInputCaptcha').val('');
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
                console.log(textStatus, errorThrown, jqXHR);
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

    $('#btnsuNewCaptcha').click(function (e) {
        e.preventDefault();

        if (suregenCount > 5)
            $('#btnNewCaptcha').remove();
        else
        {
            $('#imgCaptcha').attr('src', 'res/jCaptcha/generate.php');
            suregenCount++;
        }
    });
})