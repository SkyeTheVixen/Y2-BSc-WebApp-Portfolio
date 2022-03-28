<?php
    session_start();
    if (!isset($_SESSION['UserID'])){
        header("Location: ../login");
    }
    include_once("_connect.php");
    include_once("functions.inc.php");
    
    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $_SESSION["UserID"]);
    $stmt -> execute();
    $result = $stmt->get_result();
    if($result -> num_rows === 1){
        $User = $result->fetch_array(MYSQLI_ASSOC);
        if($User["AccessLevel"] === "user"){
            header("Location: index");
        }
    }

    $email= $mysqli->real_escape_string($_POST["email"]);
    $firstName= $mysqli->real_escape_string($_POST["firstname"]);
    $lastName= $mysqli->real_escape_string($_POST["lastname"]);
    $jobTitle= $mysqli->real_escape_string($_POST["jobtitle"]);
    $accessLevel= $mysqli->real_escape_string($_POST["accesslevel"]);
    $UUID= GenerateID();
    $url= "<img class=\"h-25\" src=\"https://proficon.stablenetwork.uk/api/identicon/$UUID.svg\" alt=\"Profile Photo\">";

    //SQL Prepped Statement
    $sql="INSERT INTO `tblUsers` (`UUID`, `Email`, `Password`, `FirstName`, `LastName`, `JobTitle`, `AccessLevel`, profileImage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    //Mail confirmation
	$to = $email;
	$subject = "User Account Creation";
    $userName = $firstName . " " . $lastName;
	$txt = "Hi ".$firstName." ".$lastName.".<br><br>A User account has been created for you on the training platform. The login details are listed below.<br><br><br>Username: ".$email."<br>Password: [MUST BE SET]<br>URL: https://ws255237-wad.remote.ac<br><br>Kind Regards,<br>VD Training Team<br><br>";
    $plaintxt = "Hi ".$firstName." ".$lastName.".\n\nA User account has been created for you on the training platform. The login details are listed below.\n\n\nUsername: ".$email."\nPassword: [MUST BE SET]\nURL: https://ws255237-wad.remote.ac\n\nKind Regards,\nVD Training Team\n\n";
    sendMail($to, $userName,  $subject, $txt, $plaintxt);

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssssss", $UUID, $email, "NOPASS", $firstName, $lastName, $jobTitle, $accessLevel, $url);
    if($stmt -> execute()){
        echo json_encode(array("statusCode" => 200));
    }
    else{
        echo json_encode(array("statusCode" => 201));
    }
    $stmt -> close();

?>