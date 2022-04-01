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
    if(!isset($_POST["addEmail"]) || !isset($_POST["addFirstName"]) || !isset($_POST["addLastName"]) || !isset($_POST["addJobTitle"]) || !isset($_POST["addAccessLevel"])){
        echo json_encode(array("statusCode" => 202));
        return;
    }

    //Set form details
    $UUID= GenerateID();
    $email= $_POST["addEmail"];
    $firstName= $_POST["addFirstName"];
    $lastName= $_POST["addLastName"];
    $jobTitle= $_POST["addJobTitle"];
    $accessLevel= $_POST["addAccessLevel"];

    //SQL Prepared Statement
    $sql="INSERT INTO `tblUsers` (`UUID`, `Email`, `FirstName`, `LastName`, `JobTitle`, `IsLocked`, `AccessLevel`, `Password`) VALUES (?, ?, ?, ?, ?, 0, ?, 'NOPASS')";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssss", $UUID, $email, $firstName, $lastName, $jobTitle, $accessLevel);
    if($stmt -> execute()){
        $mysqli->commit();
        $to = $email;
        $subject = "User Account Creation";
        $plaintxt = "Hi ".$firstName." ".$lastName.".\n\nA User account has been created for you on the training platform. The login details are listed below.\n\n\nUsername: ".$email."\nPassword: [MUST BE SET]\nURL: https://ws255237-wad.remote.ac\n\nKind Regards,\nVD Training Team\n\n";
        $txt = "Hi ".$firstName." ".$lastName.".<br><br>A User account has been created for you on the training platform. The login details are listed below.<br><br><br>Username: ".$email."<br>Password: [MUST BE SET]<br>URL: https://ws255237-wad.remote.ac<br><br>Kind Regards,<br>VD Training Team<br><br>";
        sendMail($email, "Vixendev Training",  "User Account Creation", $txt, $plaintxt);

        //Generate a token and send it to user
        $token = GenerateID();
        $sql = "INSERT INTO `tblPasswordResets` (`UUID`, `Token`, `Expiry`) VALUES (?, ?, now() + INTERVAL 15 MINUTE) ON DUPLICATE KEY UPDATE `Token` = ?, `Expiry` = now() + INTERVAL 15 MINUTE";
        $stmt = $mysqli -> prepare($sql);
        $stmt -> bind_param('sss', $UUID, $token, $token);
        if($stmt -> execute()){
            $mysqli -> commit();
            $stmt -> close();
            $subject = "VD Training | Password Reset";
            $message = "https://ws255237-wad.remote.ac/newpass.php?token=" . $token;
            sendMail($to, "VD Training", $subject, $message, $message);
            echo json_encode(array("statusCode" => 200));
        }
        else{
            $mysqli -> rollback();
            $stmt -> close();
            echo json_encode(array("statusCode" => 201));
        }
    }
    else{
    }

?>