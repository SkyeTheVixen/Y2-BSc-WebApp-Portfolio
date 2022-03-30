<?php
    //If user aint logged in, redirect them
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../../login");
    }

    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once("$path/res/php/_connect.php");
    include_once("$path/res/php/functions.inc.php");

    //Escape the course ID, just in case
    $course_id = $mysqli->real_escape_string($_POST['courseID']);
    $sql="SELECT * FROM `tblCourses` WHERE `CUID`=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows <= 0){
        $mysqli->rollback();
        $stmt->close();
        echo json_encode(array("statusCode"=>202)); //Added a return as some one could possibly submit bad data
        exit();
    }
    $course = $result->fetch_array(MYSQLI_ASSOC);
    $stmt->close();
    if($course["SelfEnrol"] == 0 && !isAdmin($mysqli)){
        $mysqli->rollback();
        echo json_encode(array("statusCode"=>204)); //Added a return as some one could possibly submit bad data
        exit();
    }
    $sql="UPDATE `tblCourses` SET `CurrentParticipants`=`CurrentParticipants`-1 WHERE `CUID`=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $stmt->close();
    $mysqli->commit();

    $sql = "DELETE FROM `tblUserCourses` WHERE `CUID` = ? AND `UUID` = ?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $course_id, $_SESSION['UserID']);
    if($stmt->execute()){
        $mysqli->commit();
        $sql2 = "SELECT * FROM `tblCourses` WHERE `CUID`=?";
        $stmt2 = $mysqli->prepare($sql2);
        $stmt2->bind_param("s", $course_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $course = $result2->fetch_object();
        sendMail(getLoggedInUser($mysqli)->Email, "Vixendev Training", "You have been Unenrolled from course", "You have been unenrolled from the course " . $course->CourseTitle . ".", "You have been unenrolled from the course " . $course->CourseTitle . ".");
        echo json_encode(array("statusCode"=>200)); //Only one return as no one could possibly submit bad data

    }
    else{
        $mysqli->rollback();
        echo json_encode(array("statusCode"=>201)); //Added a return as some one could possibly submit bad data
    }
    $stmt->close();

?>