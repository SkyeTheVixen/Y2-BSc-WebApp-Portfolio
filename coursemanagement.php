<?php include("./php/_authcheck.php"); ?>
<?php include("./php/_accesscheck.php"); ?>
<?php $title = "Course Management | VD Training"; ?>
<?php $currentPage = "coursemanagement"; ?>
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
                            <li><a class="dropdown-item" href="usermanagement"><i class="fas fa-users"></i> User
                                    Management</a></li>
                            <li><a class="dropdown-item active" href="#"><i class="fas fa-chalkboard-teacher"></i>
                                    Course
                                    Management</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="account" class="nav-link link-light"><i class="far fa-id-badge"></i> My Account</a>
                    </li>
                    <li class="nav-item">
                        <a href="php/logout" class="nav-link link-light"><i class="fas fa-door-open"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navigation bar -->

    <!-- Main Page Content -->
    <div class="container">

        <!-- Table of courses -->
        <div class="row mt-5">
            <table class="mt-5 table table-striped table-hover" id="courseTable">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Description</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Delivery Method</th>
                        <th>Allow Self-enrol?</th>
                        <th>Max Participants</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM `tblCourses` ORDER BY `tblCourses`.`CreatedAt` DESC";
                        $run = mysqli_query($connect, $sql);

                        while($result = mysqli_fetch_assoc($run))
                        {
                    ?>
                    <tr>
                        <td><?=$result["CUID"]?></td>
                        <td><?=$result["CourseTitle"]?></td>
                        <td><?=$result["CourseDescription"]?></td>
                        <td><?=$result["StartDate"]?></td>
                        <td><?=$result["EndDate"]?></td>
                        <td><?=$result["DeliveryMethod"]?></td>
                        <td><?=$result["SelfEnrol"]?></td>
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
        </div>
        <!-- End Table of Courses -->

        <!-- Add Course Button -->
        <button class="px-3 btn btn-primary right" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add Course</button>
        <!-- End Add Course Button -->

        <!-- Add Course Modal -->
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
                                    <option value="In Person">In Person</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>
                            <div class="mb-3 form-check form-switch">
                                <label for="courseSelfEnrol" class="form-label">Allow Self Enrolment?</label>
                                <input class="form-check-input" type="checkbox" role="switch" name="courseSelfEnrol">
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
        <!-- End Add Course Modal -->

    </div>
    <!-- End Main Page Content -->

    <?php include("../includes/_footer.php"); ?>
</body>

</html>