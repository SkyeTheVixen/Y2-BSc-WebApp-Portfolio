<?php include("./php/_authcheck.php"); ?>
<?php $title = "Home | VD Training"; ?>
<?php $currentPage = "index"; ?>
<?php include("./php/_header.php"); ?>

    <!-- Navigation bar -->
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="index">
                <img src="res/img/vdLogoFull.png" alt="VD Training Logo" width="30" height="24"
                    class="d-inline-block align-text-top">
                Vixendev Training
            </a>
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse w-100" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link link-light active" aria-current="page" href="index"><i
                                class="fas fa-home"></i>
                            Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-light" href="courses"><i class="fas fa-graduation-cap"></i>Courses</a>
                    </li>
                    <li class="nav-item dropdown" id="mgtDrop">
                        <a id="mgtDrop" class="nav-link dropdown-toggle link-light" href="#" id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-wrench"></i> Management
                        </a>
                        <ul id="mgtDrop" class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="usermanagement"><i class="fas fa-users"></i> User
                                    Management</a></li>
                            <li><a class="dropdown-item" href="coursemanagement"><i
                                        class="fas fa-chalkboard-teacher"></i> Course
                                    Management</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="account" class="nav-link link-light"><i class="far fa-id-badge"></i> My Account</a>
                    </li>
                    <li class="nav-item right" id="logoutBtn">
                        <a href="php/logout" class="nav-link link-light"><i class="fas fa-door-open"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navigation bar -->

    <!-- Main Page Content -->
    <div class="container">

        <!-- Welcome Greeting -->
        <div class="row">
            <div class="col-12 mt-5 align-items-center">
                <h1 class="text-center">Good
                    <?php
                    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
                    $stmt = mysqli_prepare($connect, $sql);
                    mysqli_stmt_bind_param($stmt, 's', $_SESSION["userID"]);
                    $stmt -> execute();
                    $result = $stmt->get_result();
                    $User = $result->fetch_array(MYSQLI_ASSOC);
                    $hour = date('G');
                    if ( $hour >= 0 && $hour <= 12) {
                        echo " Morning, ".$User["FirstName"]." ".$User["LastName"];
                    } else if ( $hour >= 12 && $hour <= 18 ) {
                        echo " Afternoon, ".$User["FirstName"]." ".$User["LastName"];
                    } else if ( $hour >= 19 ) {
                        echo " Evening, ".$User["FirstName"]." ".$User["LastName"];
                    }
                ?>
                </h1>
            </div>
        </div>
        <!-- End Welcome Greeting -->


    </div>
    <!-- End Main Page Content -->

    <div class="footer">

    </div>

    <?php include("../includes/footer.php"); ?>