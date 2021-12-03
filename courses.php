<?php include("./php/_authcheck.php"); ?>
<?php $title = "Courses | VD Training"; ?>
<?php $currentPage = "courses"; ?>
<?php include("./php/_header.php"); ?>
<?php include("./php/_connect.php"); ?>
<?php $sql="SELECT * FROM `tblCourses` WHERE date(`EndDate`) > cast(now() as date) ORDER BY `StartDate` ASC"; ?>
<?php $query = mysqli_query($connect, $sql); ?>


<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="#">
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
                        <a class="nav-link link-light" href="index"><i class="fas fa-home"></i>
                            Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-light active" aria-current="page" href="#"><i
                                class="fas fa-graduation-cap"></i>Courses</a>
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
                    <li class="nav-item right">
                        <a href="php/logout" class="nav-link link-light"><i class="fas fa-door-open"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navigation bar -->

    <!-- Main Page Content -->
    <div class="container">

        <!-- Title -->
        <div class="row my-5">
            <div class="col-12">
                <h1 class="text-center">Courses</h1>
                <hr>
            </div>
        </div>
        <!-- End Title -->

        <!-- Classes cards -->
        <div class="row">
            <?php while($rows = mysqli_fetch_assoc($query)) { ?>
                <div class="col-sm-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-dark text-light">
                            <?php echo $rows['CourseTitle']; ?>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo $rows['CourseDescription'] ?></p>
                            <ul class="list-group">
                                <li class="list-group-item">Start Date: <?php echo $rows['StartDate']; ?></li>
                                <li class="list-group-item">End Date: <?php echo $rows['EndDate']; ?></li>
                                <li class="list-group-item">Delivery Method: <?php echo $rows['DeliveryMethod']; ?></li>
                                <li class="list-group-item">Participants: <?php echo $rows['CurrentParticipants']?>/<?php echo $rows['MaxParticipants']; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- End Classes Cards -->

    </div>
    <!-- End Main Page Content -->

    <?php include("./php/_footer.php"); ?>
</body>

</html>