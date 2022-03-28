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
    $email= $mysqli->real_escape_string($_POST["editEmail"]);
    $firstName= $mysqli->real_escape_string($_POST["addFirstName"]);
    $lastName= $mysqli->real_escape_string($_POST["addLastName"]);
    $jobTitle= $mysqli->real_escape_string($_POST["addJobTitle"]);
    $accessLevel= $mysqli->real_escape_string($_POST["addAccessLevel"]);

    //SQL Prepared Statement
    $sql="INSERT INTO `tblUsers` (`UUID`, `Email`, `Password`, `FirstName`, `LastName`, `JobTitle`, `AccessLevel`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssss", $UUID, $email, "NOPASS", $firstName, $lastName, $jobTitle, $accessLevel);
    if($stmt -> execute()){
        $subject = "User Account Creation";
        $txt = "Hi ".$firstName." ".$lastName.".<br><br>A User account has been created for you on the training platform. The login details are listed below.<br><br><br>Username: ".$email."<br>Password: [MUST BE SET]<br>URL: https://ws255237-wad.remote.ac<br><br>Kind Regards,<br>VD Training Team<br><br>";
        $plaintxt = "Hi ".$firstName." ".$lastName.".\n\nA User account has been created for you on the training platform. The login details are listed below.\n\n\nUsername: ".$email."\nPassword: [MUST BE SET]\nURL: https://ws255237-wad.remote.ac\n\nKind Regards,\nVD Training Team\n\n";
        sendMail($email, "Vixendev Training",  "User Account Creation", $txt, $plaintxt);
        echo json_encode(array("statusCode" => 200));
    }
    else{
        echo json_encode(array("statusCode" => 201));
    }
    $stmt -> close();

?>