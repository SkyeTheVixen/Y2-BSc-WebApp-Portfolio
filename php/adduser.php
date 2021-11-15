<?php
    session_start();
    if (!isset($_SESSION['userID'])){
        header("Location: ../login");
    }
    include_once("_connect.php");
    include_once("functions.inc.php");
    
    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $_SESSION["userID"]);
    $stmt -> execute();
    $result = $stmt->get_result();
    if($result -> num_rows === 1){
        $User = $result->fetch_array(MYSQLI_ASSOC);
        if($User["AccessLevel"] === "user"){
            header("Location: index");
        }
    }

    $email= mysqli_real_escape_string($connect, $_POST["email"]);
    $password= mysqli_real_escape_string($connect, $_POST["password"]);
    $firstName= mysqli_real_escape_string($connect, $_POST["firstname"]);
    $lastName= mysqli_real_escape_string($connect, $_POST["lastname"]);
    $jobTitle= mysqli_real_escape_string($connect, $_POST["jobtitle"]);
    $accessLevel= mysqli_real_escape_string($connect, $_POST["accesslevel"]);
	$encPass=password_hash($password, 1, array('cost' => 10));
    $UUID= GenerateID();
    $url= "<img class=\"h-25\" src=\"https://proficon.stablenetwork.uk/api/identicon/$UUID.svg\" alt=\"Profile Photo\">";

    //SQL Prepped Statement
    $sql="INSERT INTO `tblUsers` (`UUID`, `Email`, `Password`, `FirstName`, `LastName`, `JobTitle`, `AccessLevel`, profileImage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    //Mail confirmation
	$to = $email;
	$subject = "User Account Creation";
    $userName = $firstName . " " . $lastName;
	$txt = "Hi ".$firstName." ".$lastName.".<br><br>A User account has been created for you on the training platform. The login details are listed below.<br><br><br>Username: ".$email."<br>Password: ".$password."<br>URL: https://ws255237-wad.remote.ac<br><br>Kind Regards,<br>VD Training Team<br><br>";
    $plaintxt = "Hi ".$firstName." ".$lastName.".\n\nA User account has been created for you on the training platform. The login details are listed below.\n\n\nUsername: ".$email."\nPassword: ".$password."\nURL: https://ws255237-wad.remote.ac\n\nKind Regards,\nVD Training Team\n\n";
    sendMail($to, $userName,  $subject, $txt, $plaintxt);

    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $UUID, $email, $encPass, $firstName, $lastName, $jobTitle, $accessLevel, $url);
    if($stmt -> execute()){
        echo json_encode(array("statuscode" => 200));
    }
    else{
        echo json_encode(array("statuscode" => 201));
    }
    $stmt -> close();

?>