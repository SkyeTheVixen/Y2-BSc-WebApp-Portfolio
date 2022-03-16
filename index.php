<?php

    $currentPage="index";
    $title="Home | VD Training";
    $pathHead="res/";
    $pageRedirect="";
    include("res/php/_connect.php");
    include("res/php/_authcheck.php");
    include("res/php/functions.inc.php");
    include("res/php/header.php"); 
    include("res/php/navbar.php");
    $mysqli->autocommit(false);

?>


<!-- Main Content -->
<div class="container">

    <div class="row text-center pt-5">
        <div class="col-md-12 text-center">
            <h1>Welcome to VD Training</h1>
            <p>A CPD Enrollment platform.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 pt-4"></div>

        <!-- Upcoming Courses -->
        <div class="col-sm-12 col-md-6 col-lg-6 pt-4">
            <div class="card">
                <div class="card-header">
                    <h4>My Upcoming Courses</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Starts on</th>
                                <th>Course</th>
                                <th>Delivery</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //Fetch Users course ID's
                                $sql = "SELECT * FROM `tblUserCourses` WHERE `UUID` = ?";
                                $stmt = $mysqli->prepare($sql);
                                $loggedInUser = getLoggedInUser($mysqli);
                                $stmt->bind_param("s", $loggedInUser->UUID);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                for($i=0; $i<$result->num_rows; $i++){
                                    //Fetch each course descriptor
                                    $row = $result->fetch_object();
                                    $sql2 = "SELECT * FROM `tblCourses` WHERE `EndDate` >= CURDATE() AND `CUID` = ? ORDER BY `StartDate` ASC LIMIT 3";
                                    $stmt2 = $mysqli->prepare($sql2);
                                    $stmt2->bind_param("s", $row->CUID);
                                    $stmt2->execute();
                                    $result2 = $stmt2->get_result();
                                    $row2 = $result2->fetch_object();
                                    echo "<tr>";
                                    echo "<td>" . getFriendlyDate($row2->StartDate) . "</td>";
                                    echo "<td>" . $row2->CourseTitle . "</td>";
                                    echo "<td>" . $row2->DeliveryMethod . "</td>";
                                    echo "</tr>";
                                }
                            ?>
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