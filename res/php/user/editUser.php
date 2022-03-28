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
    if(!isset($_POST["editEmail"]) || !isset($_POST["editFirstName"]) || !isset($_POST["editLastName"]) || !isset($_POST["editJobTitle"]) || !isset($_POST["editAccessLevel"]) || !isset($_POST["editUUID"])){
        echo json_encode(array("statusCode" => 202));
        return;
    }

    //Set form details
    $UUID= $mysqli->real_escape_string($_POST["editUUID"]);
    $email= $mysqli->real_escape_string($_POST["editEmail"]);
    $firstName= $mysqli->real_escape_string($_POST["editFirstName"]);
    $lastName= $mysqli->real_escape_string($_POST["editLastName"]);
    $jobTitle= $mysqli->real_escape_string($_POST["editJobTitle"]);
    $accessLevel= $mysqli->real_escape_string($_POST["editAccessLevel"]);

    //SQL Prepared Statement
    $sql="UPDATE `tblUsers` SET `Email` = ?, `FirstName` = ?, `LastName` = ?, `JobTitle` = ?, `AccessLevel` = ? WHERE `tblUsers`.`UUID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssss", $email, $firstName, $lastName, $jobTitle, $accessLevel, $UUID);
    if($stmt -> execute()){
        $mysqli->commit();
        echo json_encode(array("statusCode" => 200));
    }
    else{
        $mysqli->rollback();
        echo json_encode(array("statusCode" => 201));
    }
    $stmt -> close();
?>