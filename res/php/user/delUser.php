<?php
    //Check the session is active
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../../login");
    }

    //Required includes
    include_once("../_connect.php");
    include_once("../functions.inc.php");
    
    //Check user is admin
    if(getLoggedInUser($mysqli) && getLoggedInUser($mysqli)->AccessLevel == "user"){
        header("Location: ../../index");
    }

    //Check form details
    if(!isset($_POST["uuid"])){
        echo json_encode(array("statusCode" => 202));
        return;
    }

    //Set form details
    $uuid = $mysqli->real_escape_string($_POST["uuid"]);

    //SQL query
    $sql = "DELETE FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $uuid);
    if($stmt -> execute()){
        $mysqli->commit();
        echo json_encode(array("statusCode" => 200));
    }
    else{
        $mysqli->rollback();
        echo json_encode(array("statusCode" => 201));
    }
    
?>