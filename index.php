<?php
    $currentPage="index";
    $title="Home | VD Training";
    $pathHead="res/";
    $pageRedirect="";
    session_start();
    include("res/php/_connect.php");
    include("res/php/_authcheck.php");
    include("res/php/header.php"); 
    include("res/php/navbar.php");
?>


<!-- Main Content -->
<div class="container">

    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
        </div>

        <!-- Upcoming Courses -->
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>My Upcoming Courses</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                
                                $sql = "SELECT * FROM `tblCourses` WHERE `EndDate` >= CURDATE() AND `CUID` = (SELECT `CUID` FROM `tblUserCourses` WHERE `UUID` = ?) ORDER BY `StartDate` ASC";
                                $stmt = $mysqli->prepare($sql);
                                $stmt->bind_param("s", $_SESSION['UserID']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()) {
                                    echo "<td>" . $row['StartDate'] . "</td>";
                                    echo "<td>" . $row['CourseTitle'] . "</td>";
                                    echo "<td>" . $row['Delivery Method'] . "</td>";
                                }
                            ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Upcoming Courses -->
    </div>

</div>
<!-- End Main Content -->


<?php
    include("res/php/footer.php");
?>