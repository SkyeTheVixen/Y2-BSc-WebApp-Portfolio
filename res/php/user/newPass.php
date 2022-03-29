<?php
    //imports
    include_once("../_connect.php");
    include_once("../functions.inc.php");
    $token = $_POST["token"];

    //SQL to check the token is valid
    $sql = "SELECT * FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ? AND `tblPasswordResets`.`Expiry` > NOW()";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0) {
        http_response_code(201);
        exit();
    }
    $mysqli->commit();
    $stmt->close();


    //Check passwords are set
    if(!(isset($_POST["password"])) || !(isset($_POST["passwordConfirm"]))) {
        http_response_code(202);
        exit();
    }

    //Get parameters
    $password = $_POST["password"];
    $passwordConfirm = $_POST["passwordConfirm"];

    //if passwords don't match
    if($password != $passwordConfirm) {
        echo json_encode(array("statusCode" => 202));
        exit();
    }

    //Encrypt the password
    $password = password_hash($password, 1, array('cost' => 10));

    //SQL to get user
    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UserID` = (SELECT `tblPasswordResets`.`UserID` FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ? AND `tblPasswordResets`.`Expiry` > NOW())";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $mysqli->commit();
    $stmt->close();

    //SQL to update password
    $sql = "UPDATE `tblUsers` SET `Password` = ? WHERE `tblUsers`.`UserID` = (SELECT `tblPasswordResets`.`UserID` FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ? AND `tblPasswordResets`.`Expiry` > NOW())";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $password, $token);
    $stmt->execute();
    $mysqli->commit();
    $stmt->close();

    //SQL to delete token
    $sql = "DELETE FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $mysqli->commit();
    $stmt->close();

    $mysqli->close();


    $fullName = $row["FirstName"] . " " . $row["LastName"];
    $subject = "Bastepin | Password has been Reset";
    $message = "Hello " . $fullName . ",<br><br>Your password has been reset.<br><br>If you did not request this, please contact us immediately.<br><br>Thank you,<br>Bastepin";
    $altMessage = "Hello " . $fullName . ",\n\nYour password has been reset.\n\nIf you did not request this, please contact us immediately.\n\nThank you,\nBastepin";
    sendMail($row["Email"], $fullName, $subject, $message, $altMessage);
    echo json_encode(array("statusCode" => 200));