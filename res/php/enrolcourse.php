<?php
    //If user aint logged in, redirect them
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../../login");
    }

    //Include the connection and functions
    include_once("_connect.php");
    include_once("functions.inc.php");

    $mysqli->autocommit(FALSE);
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
        echo json_encode(array("statuscode"=>202)); //Added a return as some one could possibly submit bad data
        exit();
    }
    $course = $result->fetch_array(MYSQLI_ASSOC);
    $stmt->close();
    if($course["CurrentParticipants"] == $course["MaxParticipants"]){
        $mysqli->rollback();
        echo json_encode(array("statuscode"=>203)); //Added a return as some one could possibly submit bad data
        exit();
    }
    if($course["SelfEnrol"] == 0 && !isAdmin($mysqli)){
        $mysqli->rollback();
        echo json_encode(array("statuscode"=>204)); //Added a return as some one could possibly submit bad data
        exit();
    }
    $sql="UPDATE `tblCourses` SET `CurrentParticipants`=`CurrentParticipants`+1 WHERE `CUID`=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $stmt->close();
    $mysqli->commit();

    $sql = "INSERT INTO `tblUserCourses` (`UUID`, `CUID`) VALUES (?, ?);";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['UserID'], $course_id);
    if($stmt->execute()){
        $mysqli->commit();
        sendMail(getLoggedInUser($mysqli)->Email, "Vixendev Training", "You have been enrolled in a course", "You have been enrolled in the course " . $course["CourseName"] . ".", "You have been enrolled in the course " . $course["CourseName"] . ".");
        echo json_encode(array("statuscode"=>200)); //Only one return as no one could possibly submit bad data

    }
    else{
        $mysqli->rollback();
        echo json_encode(array("statuscode"=>201)); //Added a return as some one could possibly submit bad data
    }
    $stmt->close();

?>