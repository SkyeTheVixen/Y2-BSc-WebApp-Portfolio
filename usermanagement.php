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
                echo "<script>alert('');</script>";
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
    <title>User Management | VD Training</title>
    <!-- End Metadata and Icons -->

    <!-- Stylesheets -->
    <link rel="stylesheet" href="res/css/usermgt.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- End Stylesheets -->

    <!-- Important Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#addUserBtn").click(function (event) {
                var email = $("#emailInput").val();
                var password = $("#passwordInput").val();
                var firstName = $("#firstNameInput").val();
                var lastName = $("#lastNameInput").val();
                var jobTitle = $("#jobTitleInput").val();
                var accessLevel = $("#accessLevelSelect").val();
                console.log(email);
                console.log(password);
                console.log(firstName);
                console.log(lastName);
                console.log(jobTitle);
                console.log(accessLevel);

                $.ajax({
                    type: "post",
                    url: "php/adduser.php",
                    data: {
                        email: email,
                        password: password,
                        firstname: firstName,
                        lastname: lastName,
                        jobtitle: jobTitle,
                        accesslevel: accessLevel
                    },
                    cache: false,
                    success: function (result) {
                        var Data = JSON.parse(result);
                        if (Data.statuscode === 200) {
                            $("#addUserModal").modal('toggle');
                            $("#userTable").load("usermanagement.php #userTable");
                        } else if (Data.statuscode === 201) {
                            alert("Error while adding User. Try again");
                        }
                    }
                })

            });

            $("#delUserBtn").click(function (event) {
                var uuid = $("#").attr('data-id');
                $.ajax({
                    type: "post",
                    url: "php/deluser.php",
                    data: {
                        uuid: uuid
                    },
                    cache: false,
                    success: function (result) {
                        var Data = JSON.parse(result);
                        if (Data.statuscode === 200) {
                            $("#delUserModal").modal('toggle');
                            $("#userTable").load("usermanagement.php #userTable");
                        } else if (Data.statuscode === 201) {
                            alert("Error while deleting User. Try again");
                        }
                    }
                })

            });

            $(".delUUID").click(function (event) {
                $("#delUserBtn").attr("data-id", $(this).attr('data-id'));
            });
        });
    </script>
    <!-- End Important Scripts -->

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
                        <a class="nav-link link-light" href="#"><i class="fas fa-graduation-cap"></i>Courses</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle link-light active" href="#" id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-wrench"></i> Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item active" id="navddUserMgt" href="usermanagement.php"><i
                                        class="fas fa-users"></i> User Management</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-chalkboard-teacher"></i> Course
                                    Management</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-light"><i class="far fa-id-badge"></i> My Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-light" href="./php/logout.php"><i class="fas fa-door-open"></i>
                            Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navigation bar -->

    <!-- Main Page Content -->
    <div class="container">

        <!-- Table of Users -->
        <table class="mt-5 table table-striped table-hover" id="userTable">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Job Title</th>
                    <th>Access Level</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        $sql = "SELECT * FROM `tblUsers`";
                        $run = mysqli_query($connect, $sql);

                        while($result = mysqli_fetch_assoc($run))
                        {
                    ?>
                <tr>
                    <td><?=$result["UUID"]?></td>
                    <td><?=$result["FirstName"]?></td>
                    <td><?=$result["LastName"]?></td>
                    <td><?=$result["Email"]?></td>
                    <td><?=$result["JobTitle"]?></td>
                    <td><?=$result["AccessLevel"]?></td>
                    <td><a href="#" data-id="<?=$result["UUID"]?>" class="editUser"><i class="fa fa-pencil"></i></a>
                    </td>
                    <td><a class="delUUID" data-bs-toggle="modal" data-bs-target="#delUserModal" data-id="<?=$result["UUID"]?>" class="delUser"><i class="fas fa-trash-alt"></i></a>
                    </td>
                    <?php
                            }
                        ?>
                </tr>
            </tbody>
        </table>
        <!-- End Table of Users -->


        <!-- Pagination for Table -->
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item disabled"><a class="page-link">Previous</a></li>
                <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
        <!-- End Pagination for Table -->


        <button class="px-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>


        <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="firstNameInput" class="form-label">First Name</label>
                                <input type="text" required class="form-control" id="firstNameInput">
                            </div>
                            <div class="mb-3">
                                <label for="lastNameInput" class="form-label">Last Name</label>
                                <input type="text" required class="form-control" id="lastNameInput">
                            </div>
                            <div class="mb-3">
                                <label for="jobTitleInput" class="form-label">Job Title</label>
                                <input type="text" required class="form-control" id="jobTitleInput">
                            </div>
                            <div class="mb-3">
                                <label for="accessLevelSelect" class="form-label">Access Level</label>
                                <select class="form-select" required id="accessLevelSelect"
                                    aria-label="selectAccessLevel">
                                    <option selected>Access Level</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="emailInput" class="form-label">Email address</label>
                                <input type="email" required class="form-control" id="emailInput">
                            </div>
                            <div class="mb-3">
                                <label for="passwordInput" class="form-label">Password (must be 8+ characters)</label>
                                <input type="password" required class="form-control" id="passwordInput">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="addUserBtn">Add User</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Add User Modal -->


        <!-- Del User Modal -->
        <div class="modal fade" id="delUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete User?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3 h-100 align-content-center text-center">
                                <h1><i class="fas fa-question-circle fa-2x"></i></h1>
                            </div>
                            <div class="col-9">
                                <h1> Delete this user? (irreversible)</h1>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="delUserBtn">Delete User</button>
                    </div>
                </div>
            </div>



        </div>
        <!-- End Del User Modal -->


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