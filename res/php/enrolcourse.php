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
    $course_id = $mysqli->real_escape_string($_POST['course_id']);
    $sql = "INSERT INTO `tblUserCourses` (`UUID`, `CUID`) VALUES ('?', '?');";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['UUID'], $course_id);
    if($stmt->execute()){
        $mysqli->commit();
        echo json_encode(array("statuscode"=>200)); //Only one return as no one could possibly submit bad data

    }
    else{
        $mysqli->rollback();
        echo json_encode(array("statuscode"=>201)); //Added a return as some one could possibly submit bad data
    }
    $stmt->close();

?>