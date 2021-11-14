<?php include("./php/_accesscheck.php"); ?>
<?php include("./php/_authcheck.php"); ?>
<?php $title = "User Management | VD Training"; ?>
<?php $currentPage = "usermanagement"; ?>
<?php include("./php/_header.php"); ?>

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
                        <a class="nav-link link-light" aria-current="page" href="index"><i class="fas fa-home"></i>
                            Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-light" href="courses"><i class="fas fa-graduation-cap"></i>Courses</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle link-light active" href="#" id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-wrench"></i> Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item active" id="navddUserMgt" href="usermanagement"><i
                                        class="fas fa-users"></i> User Management</a></li>
                            <li><a class="dropdown-item" href="coursemanagement"><i
                                        class="fas fa-chalkboard-teacher"></i> Course
                                    Management</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="account" class="nav-link link-light"><i class="far fa-id-badge"></i> My Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-light" href="./php/logout"><i class="fas fa-door-open"></i>
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
        <div class="row mt-5">
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
                        <td><a data-id="<?=$result["UUID"]?>" class="editUser"><i class="fa fa-pencil"></i></a>
                        </td>
                        <td><a class="delUUID" data-bs-toggle="modal" data-bs-target="#delUserModal"
                                data-id="<?=$result["UUID"]?>" class="delUser"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        <?php
                            }
                        ?>
                    </tr>
                </tbody>
            </table>
            <!-- End Table of Users -->
        </div>

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
    </div>
    <!-- End Main Page Content -->

    <?php include("../includes/_footer.php"); ?>
</body>

</html>