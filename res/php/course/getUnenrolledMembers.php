<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once("$path/res/php/_connect.php");
    include_once("$path/res/php/functions.inc.php");

    $CUID = $_POST['CUID'];
    //Function to return users who are able to be enrolled on a course
    $sql = "SELECT * FROM `tblUsers` WHERE `UUID` NOT IN (SELECT `UUID` FROM `tblUserCourses` WHERE `CUID` = ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $CUID);
    $stmt->execute();
    $users = [];
    $result = $stmt->get_result();
    while($row = $result->fetch_object())
    {
        array_push($users, $row->UUID);
        array_push($users, $row->FirstName. " " . $row->LastName);
    }
    echo json_encode($users);
?>