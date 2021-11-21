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
        $token = GenerateID().str_replace("-", "", $userID);
        $expiresAt = time() + 600;
        $sql = "INSERT INTO `tblPasswordReset`(`UUID`, `Token`, `ExpiresAt`) VALUES ('?' '?' '?')";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $userID, $token, $expiresAt);
        $stmt -> execute();
        $stmt -> close();

        //Mail confirmation
        $to = $row["Email"];
        $subject = "Password Reset";
        $userName = $row["FirstName"] . " " . $row["LastName"];
        $txt = "Hi ".$userName.".<br><br>You recently requested a password reset, no biggie, happens to the best of us<br><br>Reset Link: https://ws255237-wad.remote.ac/reset.php?token=".$token."<br><br>Kind Regards,<br>VD Training Team<br><br>";
        $plaintxt = "Hi ".$userName.".\n\nYou recently requested a password reset, no biggie, happens to the best of us\n\nReset Link: https://ws255237-wad.remote.ac/reset.php?token=".$token."\n\nKind Regards,\nVD Training Team\n\n";
        sendMail($to, $userName,  $subject, $txt, $plaintxt);

    }
?>