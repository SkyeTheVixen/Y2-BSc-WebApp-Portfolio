<?php 
    $title="Login | VD Training";
    $currentPage="login";
    $pathHead="res/";
    $pageRedirect="";
    include_once("res/php/main/header.php"); 
?>

<body>
    <?php
    if(isset($_GET["er"])) {
        switch(strtolower($_GET["er"])){
            case "noactivcode":
                echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Something went wrong with the activation link. Please try again.', heightAuto: false });</script>";
                break;
            case "invalidactivcode":
                echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'That activation code was invalid', heightAuto: false });</script>";
                break;
            case "prevactivation":
                echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'You have already activated your account. Please login.', heightAuto: false });</script>";
                break;
            case "activationsuccess":
                echo "<script>Swal.fire({ icon: 'success', title: 'Congrats!', text: 'Your Account has been activated! Please log in', heightAuto: false });</script>"; 
                break;
            case "notokensupplied":
                echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'No token was supplied, please request one', heightAuto: false });</script>"; 
                break;
            case "expiredtokensupplied":
                echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Your token has expired, please request a new one', heightAuto: false });</script>"; 
                break;
            case "invalidtokensupplied":
                echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Your token was invalid, please request a new one', heightAuto: false });</script>"; 
                break;
        }
    }
?>
    <!-- Main Page Content -->
    <div class="container-fluid h-100">
        <!-- Login Form -->
        <div class="row h-100 justify-content-end">
            <div id="formcol" class="col-auto h-100 loginform shadow d-flex">
                <div class="pb-5 my-auto w-100">
                    <div class="row pt-4">
                        <h2 class="text-center w-100">VD Training Login</h2>
                    </div>
                    <div class="row pb-4 align-middle">
                        <form id="loginForm" class="align-middle" method="POST" autocomplete="off">
                            <!-- Inputs -->
                            <div class="form-group form-inline py-2">
                                <label for="InputEmail">Email address:</label>
                                <input type="email" autocomplete="username" class="form-control" id="InputEmail"
                                    aria-describedby="emailHelp" placeholder="joe@somedomain.com" name="txtUser">
                            </div>
                            <div class="form-group form-inline pb-2">
                                <label for="InputPassword">Password</label>
                                <input type="password" autocomplete="current-password" name="txtPassword"
                                    class="form-control" id="InputPassword" placeholder="P4s5w0Rd">
                            </div>
                            <!-- End Inputs -->

                            <!-- Buttons -->
                            <div class="form-group pt-2 text-center">
                                <button type="submit" id="loginBtn" class="btn btn-primary">Login</button>
                                <?php $data = file_get_contents("res/php/data.txt"); if($data == "true") {?>
                                <button type="button" id="forgotBtn" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#forgotPassModal">Forgot Password?</button>
                                <?php } ?>
                            
                            </div>
                            <!-- End Buttons -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Login Form -->

        <?php $data = file_get_contents("res/php/data.txt"); if($data == "true") {?>
            <!-- Password Reset Modal -->
            <div class="modal fade" id="forgotPassModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Forgot Password?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="passResetForm">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="emailInputReset" class="form-label">Email address</label>
                                    <input type="email" required class="form-control" id="emailInputReset">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" id="sendLinkBtn">Send Link</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- End Password Reset Modal -->
        <?php } ?>

    </div>
    <!-- End Main Page Content -->
    <?php include_once("res/php/main/login.footer.php"); ?>