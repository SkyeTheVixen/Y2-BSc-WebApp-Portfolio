<?php 
    $currentPage == "account" ? ($pathHead = "../res/" && $pageredirect = "../") : ($pathHead = "res/" && $pageredirect = "");
?>

<body style="min-height: 100%;">
    <!-- Navigation bar -->
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="<?=$pageredirect;?>index">
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
                        <a href="<?=$pageredirect;?>index" <?= $currentPage=="index" ? "class=\"nav-link link-light active\" aria-current=\"page\"" : "class=\"nav-link link-light\"";?>><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=$pageredirect;?>Courses" <?= $currentPage=="courses" ? "class=\"nav-link link-light active\" aria-current=\"page\"" : "class=\"nav-link link-light\"";?>><i class="fas fa-pencil-alt"></i> New Baste</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle link-light active" href="#" id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-wrench"></i> Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a href="<?=$pageredirect;?>usermanagement" <?=$currentPage=="courses" ? "class=\"droptdown-item\" aria-current=\"page\"" : "class=\"dropdown-item\"";?> id="navddUserMgt"><i class="fas fa-users"></i> User Management</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= $pageredirect;?>coursemanagement"><i class="fas fa-chalkboard-teacher"></i> Course Management</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="<?=$pageredirect;?>account" <?= $currentPage=="account" ? "class=\"nav-link link-light active\" aria-current=\"page\"" : "class=\"nav-link link-light\"";?>><i class="fas fa-user"></i> Account</a>
                    </li>
                    <li class="nav-item right" id="logoutBtn">
                        <a href="<?=$pathHead;?>php/logout" class="nav-link link-light"><i class="fas fa-door-open"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navigation bar -->