<?php
    $currentPage="courses";
    $title="Courses | VD Training";
    $pathHead="res/";
    $pageRedirect="";
    include("res/php/_connect.php");
    include("res/php/_authcheck.php");
    include("res/php/functions.inc.php");
    include("res/php/header.php"); 
    include("res/php/navbar.php");
    $mysqli->autocommit(false);
    $sql="SELECT * FROM `tblCourses` WHERE date(`EndDate`) > cast(now() as date) ORDER BY `StartDate` ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $mysqli->commit();
    $stmt->close();
?>


<!-- Main Content -->
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
        <?php while($rows = $result->fetch_array(MYSQLI_ASSOC)) { ?>
            <div class="col-sm-3 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-dark text-light">
                        <?=$rows['CourseTitle']; ?>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?=$rows['CourseDescription'] ?></p>
                    </div>
                    <div class="card-footer">
                        <ul class="list-group">
                            <li class="list-group-item">Start Date: <?= $rows['StartDate']; ?></li>
                            <li class="list-group-item">End Date: <?=$rows['EndDate']; ?></li>
                            <li class="list-group-item">Delivery Method: <?=$rows['DeliveryMethod']; ?></li>
                            <li class="list-group-item">Participants: <?=$rows['CurrentParticipants']?>/<?=$rows['MaxParticipants']; ?><br><progress max="<?=$rows['MaxParticipants']; ?>" value="<?=$rows['CurrentParticipants']?>"></progress></li>
                            <?php if(($rows['CurrentParticipants'] < $rows['MaxParticipants']) && $rows['SelfEnrol'] == "on"){?>
                                <?php if(UserIsEnrolled($mysqli, $rows['CUID'])){?>
                                    <li class="list-group-item"><a data-courseid="<?=$rows['CUID']; ?>" class="enrol-btn btn btn-primary">Register</a></li>
                                <?php } else { ?>
                                    <li class="list-group-item"><a data-courseid="<?=$rows['CUID']; ?>" class="enrol-btn btn btn-primary">Register</a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- End Classes Cards -->

</div>
<!-- End Main Content -->


<?php
    include("res/php/footer.php");
?>




