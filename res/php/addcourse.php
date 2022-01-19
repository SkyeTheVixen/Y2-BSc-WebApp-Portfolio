<?php
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../login");
    }
    include_once("_connect.php");
    include("functions.inc.php");

    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 's', $_SESSION["UserID"]);
    $stmt -> execute();
    $result = $stmt->get_result();
    if($result -> num_rows === 1){
        $User = $result->fetch_array(MYSQLI_ASSOC);
        if($User["AccessLevel"] === "user"){
            header("Location: index");
        }
    }

    $courseName= mysqli_real_escape_string($mysqli, $_POST["courseNameInput"]);
    $courseDescription= mysqli_real_escape_string($mysqli, $_POST["courseDescriptionInput"]);
    $courseStartDate= mysqli_real_escape_string($mysqli, $_POST["courseStartDateInput"]);
    $courseEndDate= mysqli_real_escape_string($mysqli, $_POST["courseEndDateInput"]);
    $courseDeliveryMethod= mysqli_real_escape_string($mysqli, $_POST["courseDeliveryMethod"]);
    $CourseMaxParticipants= mysqli_real_escape_string($mysqli, $_POST["courseMaxParticipants"]);
    $CourseSelfEnrol= mysqli_real_escape_string($mysqli, $_POST["courseSelfEnrol"]);
    $CourseSelfEnrol == "on" ? $CourseSelfEnrol = 1 : $CourseSelfEnrol = 0;
    $CUID= GenerateID();

    //SQL Prepped Statement
    $sql="INSERT INTO `tblCourses` (`CUID`, `CourseTitle`, `CourseDescription`, `StartDate`, `EndDate`, `DeliveryMethod`, `SelfEnrol`, `MaxParticipants`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";



    
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $CUID, $courseName, $courseDescription, $courseStartDate, $courseEndDate, $courseDeliveryMethod, $CourseSelfEnrol, $CourseMaxParticipants);
    if($stmt -> execute()){
        $to = $User["email"];
        $subject = "Course Creation";
        $txt = "Hi ".$User["firstName"]." ".$User["lastName"].".\n\nThis email is confirmation that course $CUID has been created.\n\nKind Regards,\nVD Training Team\n\n";
        sendMail($to, $userName,  $subject, $txt, $txt);
        echo json_encode(array("statuscode" => 200));
    }
    else{
        echo json_encode(array("statuscode" => 201));
    }
    $stmt -> close();

?>