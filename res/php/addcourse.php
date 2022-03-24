<?php
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../login");
    }
    include_once("_connect.php");
    include("functions.inc.php");

    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $_SESSION["UserID"]);
    $stmt -> execute();
    $result = $stmt->get_result();
    if($result -> num_rows === 1){
        $User = $result->fetch_array(MYSQLI_ASSOC);
        if($User["AccessLevel"] === "user"){
            header("Location: index");
        }
    }
    $courseName= $mysqli->real_escape_string($_POST["courseNameInput"]);
    $courseDescription= $mysqli->real_escape_string($_POST["courseDescriptionInput"]);
    $courseStartDate= $mysqli->real_escape_string($_POST["courseStartDateInput"]);
    $courseEndDate= $mysqli->real_escape_string($_POST["courseEndDateInput"]);
    $courseDeliveryMethod= $mysqli->real_escape_string($_POST["courseDeliveryMethod"]);
    $CourseMaxParticipants= $mysqli->real_escape_string($_POST["courseMaxParticipants"]);
    $CourseSelfEnrol= $mysqli->real_escape_string($_POST["courseSelfEnrol"]);
    $CourseSelfEnrol == "true" ? $CourseSelfEnrol = 1 : $CourseSelfEnrol = 0;
    $CUID= GenerateID();

    //SQL Prepped Statement
    $sql="INSERT INTO `tblCourses` (`CUID`, `CourseTitle`, `CourseDescription`, `StartDate`, `EndDate`, `DeliveryMethod`, `SelfEnrol`, `MaxParticipants`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";



    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssssss", $CUID, $courseName, $courseDescription, $courseStartDate, $courseEndDate, $courseDeliveryMethod, $CourseSelfEnrol, $CourseMaxParticipants);
    if($stmt -> execute()){
        $to = $User["Email"];
        $subject = "Course Creation";
        $txt = "Hi ".$User["FirstName"]." ".$User["LastName"].".\n\nThis email is confirmation that course $courseName [$CUID] has been created.\n\nKind Regards,\nVD Training Team\n\n";
        sendMail($to, "Vixendev Training",  $subject, $txt, $txt);
        echo json_encode(array("statuscode" => 200));
    }
    else{
        echo json_encode(array("statuscode" => 201));
    }
    $stmt -> close();

?>