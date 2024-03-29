<?php
    $currentPage="courses";
    $title="Courses | VD Training";
    $pathHead="res/";
    $pageRedirect="";
    include("res/php/_connect.php");
    include("res/php/_authcheck.php");
    include("res/php/functions.inc.php");
    include("res/php/main/header.php"); 
    include("res/php/main/navbar.php");
?>


<!-- Main Content -->
<div class="container">

    <!-- Title -->
    <div class="row mt-5 mb-1">
        <div class="col-12">
            <h1 class="text-center">Courses</h1>
        </div>
    </div>
    <!-- End Title -->


    <!-- Tab list -->
    <ul class="nav nav-tabs" id="TabbedCourses" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming"
                type="button" role="tab" aria-controls="upcoming" aria-selected="true">Upcoming</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button" role="tab"
                aria-controls="past" aria-selected="false">Past</button>
        </li>
    </ul>
    <!-- End Tab List -->

    <!-- Upcoming Courses -->
    <div class="tab-content pt-5" id="myTabContent">

        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            <?php
                $sql="SELECT * FROM `tblCourses` WHERE date(`EndDate`) > cast(now() as date) ORDER BY `StartDate` ASC";
                $stmt = $mysqli->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $mysqli->commit();
                $stmt->close();
            ?>
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
                                <li class="list-group-item" id="participantCount-<?=$rows["CUID"];?>">Participants:
                                    <?=$rows['CurrentParticipants']?>/<?=$rows['MaxParticipants']; ?></li>
                                <li class="list-group-item"><progress id="progress-<?=$rows["CUID"];?>"
                                        max="<?=$rows['MaxParticipants']; ?>"
                                        value="<?=$rows['CurrentParticipants']?>"></progress></li>
                                <li class="list-group-item d-flex" id="btns<?=$rows["CUID"];?>">
                                    <?php if((($rows['CurrentParticipants'] < $rows['MaxParticipants']) && $rows['SelfEnrol'] == 1) || (($rows['CurrentParticipants'] < $rows['MaxParticipants']) && isAdmin($mysqli))){?>
                                    <?php if(UserIsEnrolled($mysqli, $rows['CUID'])){ ?>
                                    <a class="btn btn-success disabled" disabled>✅ Enrolled!</a>
                                    <a data-courseid="<?=$rows['CUID']; ?>"
                                        class="btn btn-danger btn-unenrol">Unenroll</a></li>
                                <?php } else { ?>
                                <a data-courseid="<?=$rows['CUID']; ?>" class="btn btn-enrol btn-primary">Register</a>
                                <?php } ?>
                                <?php } else { ?>
                                <?php if(UserIsEnrolled($mysqli, $rows['CUID'])){ ?>
                                <?php if($rows["SelfEnrol"] == 0){?>
                                <a data-courseid="<?=$rows['CUID']; ?>" class="btn btn-enrol btn-success disabled me-1"
                                    disabled>✅ Enrolled!</a>
                                <a data-courseid="<?=$rows['CUID']; ?>" class="btn btn-unenrol btn-danger disabled"
                                    disabled>Unenroll</a>
                                <?php } else { ?>
                                <a data-courseid="<?=$rows['CUID']; ?>" class="btn btn-unenrol btn-danger">Unenroll</a>
                                <a data-courseid="<?=$rows['CUID']; ?>" class="btn btn-enrol btn-success disabled me-1"
                                    disabled>✅ Enrolled!</a>
                                <?php } ?>
                                <?php } else { ?>
                                <a data-courseid="<?=$rows['CUID']; ?>" class="enrol-btn btn btn-secondary disabled"
                                    disabled
                                    title="Please speak to your admin to request access to this course">Register</a>
                                <?php } ?>
                                <?php } ?>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- End Classes Cards -->
        </div>
        <!-- End Upcoming Courses -->

        <!-- Past Courses -->
        <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
            <?php
                $sql="SELECT * FROM `tblCourses` WHERE date(`EndDate`) < cast(now() as date) ORDER BY `StartDate` ASC";
                $stmt = $mysqli->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $mysqli->commit();
                $stmt->close();
            ?>
            <!-- Classes cards -->
            <div class="row">
                <?php while($rows = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                <div class="col-sm-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-dark text-light">
                            <?=$rows['CourseTitle']; ?> - [EXPIRED]
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?=$rows['CourseDescription'] ?></p>
                        </div>
                        <div class="card-footer">
                            <ul class="list-group">
                                <li class="list-group-item">Start Date: <?= $rows['StartDate']; ?></li>
                                <li class="list-group-item">End Date: <?=$rows['EndDate']; ?></li>
                                <li class="list-group-item">Delivery Method: <?=$rows['DeliveryMethod']; ?></li>
                                <li class="list-group-item" id="participantCount-<?=$rows["CUID"];?>">Participants:
                                    <?=$rows['CurrentParticipants']?>/<?=$rows['MaxParticipants']; ?></li>
                                <li class="list-group-item"><progress id="progress-<?=$rows["CUID"];?>"
                                        max="<?=$rows['MaxParticipants']; ?>"
                                        value="<?=$rows['CurrentParticipants']?>"></progress>
                                    <?php if((($rows['CurrentParticipants'] < $rows['MaxParticipants']) && $rows['SelfEnrol'] == 1) || (($rows['CurrentParticipants'] < $rows['MaxParticipants']) && isAdmin($mysqli))){?>
                                    <?php if(UserIsEnrolled($mysqli, $rows['CUID'])){ ?>
                                    <a data-courseid="<?=$rows['CUID']; ?>"
                                        class="btn btn-enrol btn-success disabled me-1" disabled>✅ Enrolled!</a>
                                    <?php } else { ?>
                                    <a data-courseid="<?=$rows['CUID']; ?>" class="btn btn-enrol btn-primary disabled"
                                        disabled>Register</a>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <?php if(UserIsEnrolled($mysqli, $rows['CUID'])){ ?>
                                    <a data-courseid="<?=$rows['CUID']; ?>"
                                        class="btn btn-enrol btn-success disabled me-1" disabled>✅ Enrolled!</a>
                                    <?php } else { ?>
                                    <a data-courseid="<?=$rows['CUID']; ?>" class="enrol-btn btn btn-secondary disabled"
                                        disabled
                                        title="Please speak to your admin to request access to this course">Register</a>
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
    </div>



</div>
<!-- End Main Content -->


<?php
    include("res/php/main/main.footer.php");
?>