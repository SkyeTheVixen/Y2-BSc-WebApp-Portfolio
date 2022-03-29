<?php
    $title="Reset Password | VD Training";
    $currentPage="resetPass";
    $pathHead="res/";
    $pageRedirect="";
    include_once("res/php/main/header.php"); 
?>

<body>
    <!-- Main Page Content -->
    <div class="container-fluid h-100">
        <!-- Login Form -->
        <div class="row h-100 justify-content-end">
            <div id="formcol" class="col-auto h-100 loginform shadow d-flex">
                <div class="pb-5 my-auto w-100">
                    <div class="row pt-4">
                        <h2 class="text-center w-100">Password Reset</h2>
                    </div>
                    <div class="row pb-4 align-middle">
                        <form id="resetForm" class="align-middle" method="POST" autocomplete="off">
                            <!-- Inputs -->
                            <div class="form-group form-inline pb-2">
                                <label for="InputPassword">New Password</label>
                                <input type="password" autocomplete="new-password" name="password" class="form-control" id="InputPassword" placeholder="P4s5w0Rd">
                            </div>
                            <div class="form-group form-inline pb-2">
                                <label for="InputPassword">Repeat Password</label>
                                <input type="password" autocomplete="new-password" name="passwordRepeat" class="form-control" id="InputPasswordRepeat" placeholder="P4s5w0Rd">
                            </div>
                            <input type="hidden" name="token" value="<?php echo $_GET["token"]; ?>">
                            <!-- End Inputs -->

                            <!-- Buttons -->
                            <div class="form-group pt-2 text-center">
                                <button type="submit" id="setPassBtn" class="btn btn-primary">Set Password</button>                            
                            </div>
                            <!-- End Buttons -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Login Form -->
    </div>
    <!-- End Main Page Content -->
    <?php include_once("res/php/main/login.footer.php"); ?>