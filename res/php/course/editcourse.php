<?php

    //Check the user is logged in
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../login");
    }
    
    //Required includes
    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once("$path/res/php/_connect.php");
    include_once("$path/res/php/functions.inc.php");

    //Check user is admin
    if(getLoggedInUser($mysqli) && getLoggedInUser($mysqli)->AccessLevel == "user"){
        return http_response_code(202);
    }

    //Check form has been submitted
    if(!isset($_POST) && count($_POST) < 7){
        return http_response_code(202);
    }

    $CUID = $_POST["editCourseId"];
    $courseTitle= $mysqli->real_escape_string($_POST["editCourseName"]);
    $courseDescription= $mysqli->real_escape_string($_POST["editCourseDescription"]);
    $courseStartDate= $mysqli->real_escape_string($_POST["editCourseStartDate"]);
    $courseEndDate= $mysqli->real_escape_string($_POST["editCourseEndDate"]);
    $courseDeliveryMethod= $mysqli->real_escape_string($_POST["editCourseDeliveryMethod"]);
    $CourseMaxParticipants= $mysqli->real_escape_string($_POST["editCourseMaxParticipants"]);
    $CourseSelfEnrol= $mysqli->real_escape_string($_POST["editCourseSelfEnrol"]);
    $CourseSelfEnrol == "true" ? $CourseSelfEnrol = 1 : $CourseSelfEnrol = 0;

    //SQL prepared Statement
    $sql="UPDATE `tblCourses` SET `CourseTitle`=?,`CourseDescription`=?,`StartDate`=?,`EndDate`=?,`DeliveryMethod`=?,`SelfEnrol`=?,`MaxParticipants`=?,`CurrentParticipants`=? WHERE `CUID`=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssssss", $courseTitle, $courseDescription, $courseStartDate, $courseEndDate, $courseDeliveryMethod, $CourseSelfEnrol, $CourseMaxParticipants, $CourseMaxParticipants, $CUID);
    if($stmt -> execute()){
        $mysqli->commit();
        $subject = "Course Update";
        $txt = "Hi ".getLoggedInUser($mysqli)->FirstName." ".getLoggedInUser($mysqli)->LastName.".\n\nThis email is confirmation that course $courseTitle [$CUID] has been updated.\n\nKind Regards,\nVD Training Team\n\n";
        sendMail(getLoggedInUser($mysqli)->Email, "Vixendev Training",  $subject, $txt, $txt);
        echo json_encode(array("name" => $courseTitle));
        http_response_code(200);
    }
    else{
        http_response_code(201);
    }

?>
