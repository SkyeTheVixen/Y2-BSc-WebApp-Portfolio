<?php

    $currentPage="index";
    $title="Home | VD Training";
    $pathHead="res/";
    $pageRedirect="";
    include_once("res/php/_connect.php");
    include_once("res/php/_authcheck.php");
    include_once("res/php/functions.inc.php");
    include_once("res/php/main/header.php"); 
    include_once("res/php/main/navbar.php");

    if(isset($_GET['er'])){
        echo "<script>Swal.fire('Oops...', 'Insufficient Permissions', 'error');</script>";
    }
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
        <div class="col-sm-12 col-md-6 col-lg-6 pt-4">
            <!-- Company News -->
            <div class="card">
                <div class="card-header">
                    <h4>Company News</h4>
                </div>
                <div class="card-body">
                    <?php
                        $sql = "SELECT * FROM `tblNews` ORDER BY `CreatedAt` DESC LIMIT 4";
                        $result = mysqli_query($mysqli, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<h5 class='card-title'>".$row['Title']."</h5>";
                                echo "<p class='card-text'>".$row['Content']."</p>";
                                echo "<br>";
                            }
                        }
                    ?>
                </div>
            </div>
            <!-- End Company news -->
        </div>

        <div class="col-sm-12 col-md-6 col-lg-6 pt-4">
            <div class="row mb-2">
                <!-- Upcoming Courses -->
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
                                    $courseCount = 0;
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
                                        if($stmt2->num_rows() > 0){
                                            $courseCount = 1;
                                            $row2 = $result2->fetch_object();
                                            echo "<tr>";
                                            echo "<td>" . getFriendlyDate($row2->StartDate) . "</td>";
                                            echo "<td>" . $row2->CourseTitle . "</td>";
                                            echo "<td>" . $row2->DeliveryMethod . "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    if($courseCount == 0) {
                                        echo "<tr>";
                                        echo "<td>No Upcoming Courses</td>";
                                        echo "<td></td>";
                                        echo "<td></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Upcoming Courses -->

            </div>
            <div class="row">
                <!-- Calendar -->
                <div class="card">
                    <div class="card-header">
                        <h4>Calendar</h4>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
                <!-- End Calendar -->
            </div>
        </div>
    </div>

</div>
<!-- End Main Content -->


<?php
    include("res/php/main/main.footer.php");
?>