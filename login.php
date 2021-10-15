<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="res/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="res/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="res/favicon/favicon-16x16.png">
    <link rel="manifest" href="res/favicon/site.webmanifest">
    <link rel="mask-icon" href="res/favicon/safari-pinned-tab.svg" color="#0b2033">
    <link rel="shortcut icon" href="res/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#0b2033">
    <meta name="msapplication-config" content="res/favicon/browserconfig.xml">
    <meta name="theme-color" content="#0b2033">
    <title>Login | VD Training</title>
    <!-- End Metadata -->

    <!-- Stylesheets -->
    <link rel="stylesheet" href="res/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- End Stylesheets -->

    <!-- Important Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
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
                    url: "php/auth.php",
                    data: {
                        txtUser: email,
                        txtPassword: password
                    },
                    cache: false,
                    success: function (dataResult) {
                        var DataResult = JSON.parse(dataResult);
                        if (DataResult.statusCode === 200) {
                            location.href = "index.php";
                        } else if (DataResult.statusCode === 201) {
                            $("#incorrectPassModal").modal('toggle');
                        }
                    }
                });
            })
        })
    </script>
    <!-- End Important Scripts -->

</head>

<body>

    <div class="container h-100">
        <div class="row h-25 align-items-center">
            <div class="col">
                <img src="res/img/vdLogoFull.png">
            </div>
        </div>
        <div class="row h-75 align-items-center">
            <div class="col-3"></div>
            <div class="col-6 loginform align-items-center shadow">
                <div class="row pt-4">
                    <h1 class="text-center w-100">Login to VD Training</h1>
                </div>
                <div class="row pb-4">
                    <form id="loginForm" method="POST" autocomplete="off">
                        <div class="form-group py-2">
                            <label for="InputEmail">Email address</label>
                            <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp"
                                placeholder="joe@somedomain.com" name="txtUser">
                        </div>
                        <div class="form-group pb-2">
                            <label for="InputPassword">Password</label>
                            <input type="password" name="txtPassword" class="form-control" id="InputPassword"
                                placeholder="P4s5w0Rd">
                        </div>
                        <div class="form-group pt-2 text-center">
                            <button type="submit" id="loginBtn" class="btn btn-success">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-3"></div>
        </div>

        <div class="modal fade" id="incorrectPassModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Incorrect login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3 h-100 align-content-center text-center">
                                <h1><i class="fas fa-exclamation-triangle fa-2x"></i></h1>
                            </div>
                            <div class="col-9">
                                <h1>Your user or password was incorrect</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/93e867abff.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <!-- End Scripts -->
</body>

</html>