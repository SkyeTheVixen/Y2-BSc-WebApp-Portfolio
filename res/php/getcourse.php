<?php

    include("_connect.php");
    $CUID = $_POST['CUID'];
    $sql = "SELECT * FROM `tblCourses` WHERE `CUID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $CUID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    $mysqli->close();
    echo json_encode($row);


?>