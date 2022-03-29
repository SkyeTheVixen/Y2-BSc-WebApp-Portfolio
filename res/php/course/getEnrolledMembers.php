<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once("$path/res/php/_connect.php");
    include_once("$path/res/php/functions.inc.php");
    
    $CUID = $_POST['CUID'];
    //Function to return users who are enrolled on a course
    $sql = "SELECT * FROM `tblUserCourses` WHERE `CUID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $CUID);
    $stmt->execute();
    $users = [];
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc())
    {
        array_push($users, $row["UUID"]);
        $sql2 = "SELECT * FROM `tblUsers` WHERE `UUID` = ?";
        $stmt2 = $mysqli->prepare($sql2);
        $stmt2->bind_param("s", $row["UUID"]);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $user = $result2->fetch_object();
        array_push($users, $user->FirstName. " " . $user->LastName);
    }
    $stmt->close();
    echo json_encode($users);
?>