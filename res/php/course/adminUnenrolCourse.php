<?php

    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once("$path/res/php/_connect.php");
    include_once("$path/res/php/functions.inc.php");

    $CUID = $_POST['CUID'];
    $UUID = $_POST['UUID'];

    //Function to delete link table entry
    $sql = "DELETE FROM `tblUserCourses` WHERE `CUID` = ? AND `UUID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $CUID, $UUID);
    $stmt->execute();
    $mysqli->commit();
    $stmt->close();
    
    //Function to update the course participant count
    $sql = "UPDATE `tblCourses` SET `CurrentParticipants` = `CurrentParticipants` - 1 WHERE `CUID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $CUID);
    $stmt->execute();
    $mysqli->commit();
    $stmt->close();

    echo json_encode(array("statusCode" => 200));

?>