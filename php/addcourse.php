<?php
    include_once("_connect.php");
    include("functions.inc.php");
    if(!PermCheck() === "true") return;

    $courseName= mysqli_real_escape_string($connect, $_POST["courseNameInput"]);
    $courseDescription= mysqli_real_escape_string($connect, $_POST["courseDescriptionInput"]);
    $courseStartDate= mysqli_real_escape_string($connect, $_POST["courseStartDateInput"]);
    $courseEndDate= mysqli_real_escape_string($connect, $_POST["courseEndDateInput"]);
    $courseDeliveryMethod= mysqli_real_escape_string($connect, $_POST["courseDeliveryMethod"]);
    $CourseMaxParticipants= mysqli_real_escape_string($connect, $_POST["courseMaxParticipants"]);
    $CourseSelfEnrol= mysqli_real_escape_string($connect, $_POST["courseSelfEnrol"]);
    $CUID= GenerateID();

    //SQL Prepped Statement
    $sql="INSERT INTO `tblCourses` (`CUID`, `CourseTitle`, `CourseDescription`, `StartDate`, `EndDate`, `DeliveryMethod`, `SelfEnrol`, `MaxParticipants`) VALUES (?, ?, ?, ?, ?, ?, ?)";

	$to = $User["email"];
	$subject = "Course Creation";
	$txt = "Hi ".$User["firstName"]." ".$User["lastName"].".\n\nThis email is confirmation that course $CUID has been created.\n\nKind Regards,\nVD Training Team\n\n";
	$headers = "From: noreply@vixendev.com";
	mail($to,$subject,$txt,$headers);
    $stmt=mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $CUID, $courseName, $courseDescription, $courseStartDate, $courseEndDate, $courseDeliveryMethod, $CourseSelfEnrol, $CourseMaxParticipants);
    if($stmt -> execute()){
        echo json_encode(array("statuscode" => 200));
    }
    else{
        echo json_encode(array("statuscode" => 201));
    }
    $stmt -> close();

?>