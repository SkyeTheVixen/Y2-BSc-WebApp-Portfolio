<?php

    //Check the session is active
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../../login");
    }

    //Required includes
    include_once("../_connect.php");
    include_once("../functions.inc.php");
    
    //Check form data
    if(!isset($_POST["uuid"])){
        return;
    }

    //Function to get a single User object
    $UUID = $_POST["uuid"];
    $sql = "SELECT * FROM `tblUsers` WHERE `UUID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $UUID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_object();
    $mysqli->commit();
    $stmt->close();
    echo json_encode($user);

?>