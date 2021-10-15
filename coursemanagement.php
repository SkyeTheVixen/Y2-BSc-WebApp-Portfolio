<?php
    session_start();
    include_once("./php/_connect.php");
    if (!isset($_SESSION['userID'])){
        header("Location: ./login.php");
	}
	else{
		$sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 's', $_SESSION["userID"]);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            if($User["AccessLevel"] === "user"){
                header("Location: index.php");
            }
        }
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
    <title>Course Management | VD Training</title>
    <!-- End Metadata and Icons -->

    <!-- Stylesheets -->
    <link rel="stylesheet" href="res/css/global.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- End Stylesheets -->

    <!-- Important scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $("#addCourseForm").submit(function (event) {
                var data = $(this).serialize();
                event.preventDefault();
                $.ajax({
                    type: "post",
                    url: "php/addcourse.php",
                    data: data,
                    cache: false,
                    success: function (result) {
                        var Data = JSON.parse(result);
                        if (Data.statuscode === 200) {
                            $("#addCourseModal").modal('toggle');
                        } else if (Data.statuscode === 201) {
                            alert("Error while adding Course. Try again");
                        }
                    }
                })

            });
        })
    </script>
    <!-- End Important scripts -->
</head>

<body>

    <!-- Navigation bar -->
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="index.php">
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
                        <a class="nav-link link-light" aria-current="page" href="index.php"><i class="fas fa-home"></i>
                            Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-light" href="courses.php"><i
                                class="fas fa-graduation-cap"></i>Courses</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle link-light active" href="#" id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-wrench"></i> Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="usermanagement.php"><i class="fas fa-users"></i> User
                                    Management</a></li>
                            <li><a class="dropdown-item active" href="#"><i class="fas fa-chalkboard-teacher"></i>
                                    Course
                                    Management</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="account.php" class="nav-link link-light"><i class="far fa-id-badge"></i> My Account</a>
                    </li>
                    <li class="nav-item">
                        <a href="php/logout.php" class="nav-link link-light"><i class="fas fa-door-open"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navigation bar -->

    <!-- Main Page Content -->
    <div class="container">


        <!-- Table of courses -->
        <table class="mt-5 table table-striped table-hover" id="courseTable">
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Delivery Method</th>
                    <th>Max Participants</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        $sql = "SELECT * FROM `tblCourses`";
                        $run = mysqli_query($connect, $sql);

                        while($result = mysqli_fetch_assoc($run))
                        {
                    ?>
                <tr>
                    <td><?=$result["CUID"]?></td>
                    <td><?=$result["CourseName"]?></td>
                    <td><?=$result["CourseDescription"]?></td>
                    <td><?=$result["StartDate"]?></td>
                    <td><?=$result["EndDate"]?></td>
                    <td><?=$result["DeliveryMethod"]?></td>
                    <td><?=$result["MaxParticipants"]?></td>
                    <td><a data-id="<?=$result["CUID"]?>" class="viewCourse"><i class="fa fa-eye"></i></a></td>
                    <td><a data-id="<?=$result["CUID"]?>" class="editCourse"><i class="fa fa-pencil"></i></a></td>
                    <td><a data-id="<?=$result["CUID"]?>" class="delCourse" data-bs-toggle="modal"
                            data-bs-target="#delCourseModal"><i class="fas fa-trash-alt"></i></a>
                    </td>
                    <?php
                            }
                        ?>
                </tr>
            </tbody>
        </table>
        <!-- End Table of courses -->


        <button class="px-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add Course</button>


        <!-- Add User Modal -->
        <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <form autocomplete="off" id="addCourseForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="courseNameInput" class="form-label">Course Name</label>
                                <input type="text" required class="form-control" name="courseNameInput">
                            </div>
                            <div class="mb-3">
                                <label for="courseDescriptionInput" class="form-label">Course Description</label>
                                <textarea required class="form-control" name="courseDescriptionInput"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="courseStartDateInput" class="form-label">Start Date</label>
                                <input type="date" required class="form-control" name="courseStartDateInput">
                            </div>
                            <div class="mb-3">
                                <label for="courseEndDateInput" class="form-label">End Date</label>
                                <input type="date" required class="form-control" name="courseEndDateInput">
                            </div>
                            <div class="mb-3">
                                <label for="courseDeliveryMethod" class="form-label">Delivery Method</label>
                                <select class="form-select" required name="courseDeliveryMethod"
                                    aria-label="selectAccessLevel">
                                    <option selected>Delivery Method</option>
                                    <option value="admin">In Person</option>
                                    <option value="user">Online</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="courseMaxParticipants" class="form-label">Maximum Participants</label>
                                <input type="number" required class="form-control" name="courseMaxParticipants">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="addCourseBtn">Add Course</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- End Add User Modal -->


    </div>
    <!-- End Main Page Content -->

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/93e867abff.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <!-- End Scripts -->
</body>

</html>