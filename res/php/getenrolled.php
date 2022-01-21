<?php

    include("_connect.php");
    $CUID = $_POST['CUID'];
    $sql = "SELECT * FROM `tblUserCourses` WHERE `CUID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $CUID);
    $stmt->execute();
    $users = [];
    $i = 0;
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc())
    {
        $users[$i] = $row;
        $i++;
    }
    $stmt->close();
    $mysqli->close();
    echo json_encode($users);


?>