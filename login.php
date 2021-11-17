<?php $title="Login | VD Training"; ?>
<?php $currentPage="login"; ?>
<?php include("./php/_header.php"); ?>

<body>
    <!-- Main Page Content -->
    <div class="container-fluid h-100">
        <!-- Login Form -->
        <div class="row h-100 align-content-center justify-content-center">
            <div class="col-auto loginform w-50 align-items-center shadow">
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
                            <button type="submit" id="loginBtn" class="btn btn-primary">Login</button>
                            <button type="button" id="forgotBtn" data-bs-toggle="modal"
                                data-bs-target="#forgotPassModal" class="btn btn-secondary">Forgot Password?</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Login Form -->

        <!-- Modals -->
        <div class="modal fade" id="forgotPassModal" tabindex="-1" aria-labelledby="forgotUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Forgot Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="emailInput" class="form-label">Email address</label>
                                <input type="email" required class="form-control" id="emailInput">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="addUserBtn">Send reset Link</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modals -->
    </div>
    <!-- End Main Page Content -->

    <!-- Password Reset Modal -->
    <div class="modal fade" id="passwordResetModal" tabindex="-1" aria-labelledby="addUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Password Reset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="passResetForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email address</label>
                            <input type="email" required class="form-control" id="emailInput">
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


    <?php include("./php/_footer.php"); ?>
</body>

</html>