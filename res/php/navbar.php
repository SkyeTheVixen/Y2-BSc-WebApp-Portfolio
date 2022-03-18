<?php
    include_once("_connect.php");
    include_once("functions.inc.php");
?>
<body style="min-height: 100%;">
    <!-- Navigation bar -->
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="<?=$pageRedirect;?>index">
                <img src="<?=$pathHead;?>img/vdLogoFull.png" alt="VD Training Logo" width="30" height="24"
                    class="d-inline-block align-text-top">
                Training
            </a>
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse w-100" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="<?=$pageRedirect;?>index" <?= $currentPage=="index" ? "class=\"nav-link link-light active\" aria-current=\"page\"" : "class=\"nav-link link-light\"";?>><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=$pageRedirect;?>courses" <?= $currentPage=="courses" ? "class=\"nav-link link-light active\" aria-current=\"page\"" : "class=\"nav-link link-light\"";?>><i class="fas fa-graduation-cap"></i>Courses</a>
                    </li>
                    <?php if(getLoggedInUser($mysqli)->AccessLevel == "admin") {?>
                    <li class="nav-item dropdown" id="mgtDrop">
                        <a <?= ($currentPage=="coursemanagement") || ($currentPage=="usermanagement") ? "class=\"nav-link dropdown-toggle link-light active\"" : "class=\"nav-link dropdown-toggle  link-light\"";?> id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-wrench"></i> Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a href="<?=$pageRedirect;?>usermanagement" class="dropdown-item" id="navddUserMgt"><i class="fas fa-users"></i> User Management</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= $pageRedirect;?>coursemanagement"><i class="fas fa-chalkboard-teacher"></i> Course Management</a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a href="<?=$pageRedirect;?>account" <?= $currentPage=="account" ? "class=\"nav-link link-light active\" aria-current=\"page\"" : "class=\"nav-link link-light\"";?>><i class="fas fa-user"></i> Account</a>
                    </li>
                    <li class="nav-item align-right" id="logoutBtn">
                        <a href="<?=$pathHead;?>php/logout" class="nav-link link-light"><i class="fas fa-door-open"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navigation bar -->
