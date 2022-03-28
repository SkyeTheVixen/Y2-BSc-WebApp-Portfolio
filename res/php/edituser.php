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

    $CUID = $_POST["CUID"];
    $courseName= $mysqli->real_escape_string($_POST["name"]);
    $courseDescription= $mysqli->real_escape_string($_POST["description"]);
    $courseStartDate= $mysqli->real_escape_string($_POST["startDate"]);
    $courseEndDate= $mysqli->real_escape_string($_POST["endDate"]);
    $courseDeliveryMethod= $mysqli->real_escape_string($_POST["deliveryMethod"]);
    $CourseMaxParticipants= $mysqli->real_escape_string($_POST["maxParticipants"]);
    $CourseSelfEnrol= $mysqli->real_escape_string($_POST["selfEnrol"]);
    $CourseSelfEnrol == "true" ? $CourseSelfEnrol = 1 : $CourseSelfEnrol = 0;

    //SQL prepared Statement
    $sql="UPDATE `tblCourses` SET `CourseTitle`=?,`CourseDescription`=?,`StartDate`=?,`EndDate`=?,`DeliveryMethod`=?,`SelfEnrol`=?,`MaxParticipants`=?,`CurrentParticipants`=? WHERE `CUID`=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssssss", $courseName, $courseDescription, $courseStartDate, $courseEndDate, $courseDeliveryMethod, $CourseSelfEnrol, $CourseMaxParticipants, $CourseMaxParticipants, $CUID);
    if($stmt -> execute()){
        $to = $User["Email"];
        $subject = "User Update";
        $txt = "Hi ".$User["FirstName"]." ".$User["LastName"].".\n\nThis email is confirmation that course $courseName [$CUID] has been updated.\n\nKind Regards,\nVD Training Team\n\n";
        sendMail($to, "Vixendev Training",  $subject, $txt, $txt);
        echo json_encode(array("statusCode" => 200));
    }
    else{
        echo json_encode(array("statusCode" => 201));
    }

?>
