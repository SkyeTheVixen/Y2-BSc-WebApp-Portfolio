<?php

    include("_connect.php");
    $CUID = $_POST['CUID'];
    $sql = "SELECT * FROM `tblUserCourses` WHERE `CUID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $CUID);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_array(MYSQLI_ASSOC);
    $stmt->close();
    $mysqli->close();
    echo json_encode($row);


?>