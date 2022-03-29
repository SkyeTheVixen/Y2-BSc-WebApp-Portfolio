<?php

    //includes
    include_once("../_connect.php");
    include_once("../functions.inc.php");

    //Check form data
    if(!isset($_POST["email"])){
        http_response_code(201);
        return;
    }

    //Get user based on email
    $email = $_POST["resetEmail"];
    $sql = "SELECT `UUID` FROM `tblUsers` WHERE `Email` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0){
        $mysqli->rollback();
        $stmt->close();
        http_response_code(202);
    }
    $user = $result->fetch_object();
    $mysqli->commit();
    $stmt->close();

    //Generate a token and send it to user
    $token = GenerateID();
    $sql = "INSERT INTO `tblPasswordResets` (`UUID`, `Token`, `Expiry) VALUES (?, ?, now() + INTERVAL 15 MINUTE) ON DUPLICATE KEY UPDATE `Token` = ?, `Expiry` = now() + INTERVAL 15 MINUTE";
    $stmt = $mysqli -> prepare($sql);
    $stmt -> bind_param('sss', $user->UUID, $token, $token);
    if($stmt -> execute()){
        $mysqli -> commit();
        $stmt -> close();
        $subject = "VD Training | Password Reset";
        $message = "https://ws255237-wad.remote.ac/newpass.php?token=" . $token;
        sendMail($email, "VD Training", $subject, $message, $message);
        http_response_code(200);
    }
    else{
        $mysqli -> rollback();
        $stmt -> close();
        http_response_code(203);
    }
    $mysqli -> close();
?>