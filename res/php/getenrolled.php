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
        array_push($users, $row["UUID"]);
        $sql2 = "SELECT * FROM `tblUsers` WHERE `UUID` = ?";
        $stmt2 = $mysqli->prepare($sql2);
        $stmt2->bind_param("s", $row["UUID"]);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $row2 = $result2->fetch_assoc();
        array_push($users, $row2["FirstName"]. " " . $row2["LastName"]);
    }
    $stmt->close();




    $mysqli->close();
    echo json_encode($users);


?>