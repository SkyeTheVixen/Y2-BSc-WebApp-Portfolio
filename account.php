<?php
    $currentPage="account";
    $title="Account | VD Training";
    $pathHead="../res/";
    $pageRedirect="../";
    include_once("res/php/_connect.php");
    include_once("res/php/_authcheck.php");
    include_once("res/php/functions.inc.php");
    include_once("res/php/main/header.php"); 
    include_once("res/php/main/navbar.php");
    $user=getLoggedInUser($mysqli);
?>


<!-- Main Content -->
<div class="container">
    <div class="row mt-5">
        <div class="col-12">
            <!-- Name and identicon -->
            <div class="row h-25">
                <div class="col-6 d-flex align-items-center">
                    <img src="https://proficon.stablenetwork.uk/api/identicon/<?=$user->UUID;?>.svg" alt="Profile Icon" class="h-10 me-3">
                    <h1><?=htmlspecialchars($user->FirstName." ".$user->LastName); ?></h1>
                </div>


                <div class="col-6 me-0 text-right">
                    <?php
                        $sql = "SELECT `CUID` FROM `tblUserCourses` WHERE `UUID`  = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("s", $user->UUID);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    ?>
                    <div class="row text-right end-0">
                        <h5>Current courses enrolled on: <?= $result->num_rows ?></h5>
                    </div>
                    <?php
                        $sql = "SELECT `CUID` FROM `tblUserCourses` WHERE `UUID`  = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("s", $user->UUID);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $nextCourseDate = "";
                        $nextCourseName = "";
                        $course = $result->fetch_object();
                        if($result->num_rows == 0){
                            $nextCourseName = "None";
                            $nextCourseDate = "";
                        }
                        else{
                            for($i=0; $i<$result->num_rows; $i++){
                                $row = $result->fetch_object();
                                $courseRow = getCourse($mysqli, $course->CUID);
                                if($nextCourseDate == ""){
                                    $nextCourseDate = $courseRow->StartDate;
                                    $nextCourseName = $courseRow->CourseTitle . " on ";
                                }
                                if($courseRow->StartDate > date("Y-m-d") && $courseRow->StartDate < $nextCourseDate){
                                    $nextCourseName = $courseRow->CourseTitle . " on ";
                                    $nextCourseDate = $courseRow->StartDate;
                                }
                            }
                        }
                        
                    ?>
                    <div class="row">
                        <h5>Next Course: <?=$nextCourseName . $nextCourseDate; ?></h5>
                    </div>
                </div>
                <hr class="mt-5"/>
            </div>
            <!-- End identicon -->
        </div>
    </div>
</div>
<!-- End Main Content -->


<?php
    include("res/php/main/main.footer.php");
?>