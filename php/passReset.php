<?php

    include_once("_connect.php");
    include("functions.inc.php");

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $sql = "SELECT * FROM tblUsers WHERE email = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    $stmt -> execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $userID = $row['UUID'];
        $token = GenerateID();
        $sql = "INSERT INTO `tblPasswordReset`(`UUID`, `Token`, `ExpiresAt`) VALUES ('?' '?' '?')";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $userID, $token, $expiresAt);
        $stmt -> execute();
        $stmt -> close();
    }
?>