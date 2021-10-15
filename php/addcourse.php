<?php
    include_once("_connect.php");
    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $_SESSION["userID"]);
    $stmt -> execute();
    $result = $stmt->get_result();
    if($result -> num_rows === 1){
        $User = $result->fetch_array(MYSQLI_ASSOC);
        if($User["AccessLevel"] === "user"){
            header("Location: index.php");
        }
    }
    $courseName= mysqli_real_escape_string($connect, $_POST["courseNameInput"]);
    $courseDescription= mysqli_real_escape_string($connect, $_POST["courseDescriptionInput"]);
    $courseStartDate= mysqli_real_escape_string($connect, $_POST["courseStartDateInput"]);
    $courseEndDate= mysqli_real_escape_string($connect, $_POST["courseEndDateInput"]);
    $courseDeliveryMethod= mysqli_real_escape_string($connect, $_POST["courseDeliveryMethod"]);
    $CourseMaxParticipants= mysqli_real_escape_string($connect, $_POST["courseMaxParticipants"]);

    //UUID
    $CUIDData = $CUIDData ?? random_bytes(16);
    assert(strlen($CUIDData) == 16);
    $CUIDData[6] = chr(ord($CUIDData[6]) & 0x0f | 0x40);
    $CUIDData[8] = chr(ord($CUIDData[8]) & 0x3f | 0x80);
    $CUID = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($CUIDData), 4));

    //SQL Prepped Statement
    $sql="INSERT INTO `tblCourses` (`CUID`, `CourseTitle`, `CourseDescription`, `StartDate`, `EndDate`, `DeliveryMethod`, `MaxParticipants`) VALUES (?, ?, ?, ?, ?, ?, ?)";

	$to = $User["email"];
	$subject = "Course Creation";
	$txt = "Hi ".$User["firstName"]." ".$User["lastName"].".\n\nThis email is confirmation that course $CUID has been created.\n\nKind Regards,\nVD Training Team\n\n";
	$headers = "From: noreply@vixendev.com";
	mail($to,$subject,$txt,$headers);
    $stmt=mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $CUID, $courseName, $courseDescription, $courseStartDate, $courseEndDate, $courseDeliveryMethod, $CourseMaxParticipants);
    if($stmt -> execute()){
        echo json_encode(array("statuscode" => 200));
    }
    else{
        echo json_encode(array("statuscode" => 201));
    }
    $stmt -> close();

?>