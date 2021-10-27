<?php
    session_start();
	include("./php/_connect.php");
    if (!isset($_SESSION['userID'])){
        header("Location: ./login");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata and Icons -->
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
    <title>Home | VD Training</title>
    <!-- End Metadata and Icons -->

    <!-- Stylesheets -->
    <link rel="stylesheet" href="res/css/global.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- End Stylesheets -->

    <!-- Important Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#logoutBtn").click(function (event) {
                $.ajax({
                    type: "get",
                    url: "php/logout.php",
                    success: function (dataResult) {
                        location.href = "login";
                    }
                });
                event.preventDefault();
            })
        })
    </script>
    <?php
        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 's', $_SESSION["userID"]);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            if($User["AccessLevel"] === "user"){
                echo "<script type='text/javascript'>$(document).ready(function () { $('#mgtDrop').remove(); })</script>";
            }
        }
    ?>
    <!-- End Important Scripts -->


</head>

<body>
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
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
                            <li><a class="dropdown-item" href="coursemanagement"><i class="fas fa-chalkboard-teacher"></i> Course
                                    Management</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="account" class="nav-link link-light"><i class="far fa-id-badge"></i> My Account</a>
                    </li>
                    <li class="nav-item" id="logoutBtn">
                        <a href="php/logout" class="nav-link link-light"><i class="fas fa-door-open"></i> Logout</a>
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

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/93e867abff.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <!-- End Scripts -->
</body>

</html>