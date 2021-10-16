<?php
    include_once("_connect.php");
    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UUID` = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $_SESSION["userID"]);
    $stmt -> execute();
    $result = $stmt->get_result();
    if($result -> num_rows === 1){
        $User = $result->fetch_array(MYSQLI_ASSOC);
        if($User["AccessLevel"] === "user"){
            header("Location: index.php");
        }
    }
    $email= mysqli_real_escape_string($connect, $_POST["email"]);
    $password= mysqli_real_escape_string($connect, $_POST["password"]);
    $firstName= mysqli_real_escape_string($connect, $_POST["firstname"]);
    $lastName= mysqli_real_escape_string($connect, $_POST["lastname"]);
    $jobTitle= mysqli_real_escape_string($connect, $_POST["jobtitle"]);
    $accessLevel= mysqli_real_escape_string($connect, $_POST["accesslevel"]);
	$encPass=password_hash($password, 1, array('cost' => 10));

    //UUID
    $uuidData = $uuidData ?? random_bytes(16);
    assert(strlen($uuidData) == 16);
    $uuidData[6] = chr(ord($uuidData[6]) & 0x0f | 0x40);
    $uuidData[8] = chr(ord($uuidData[8]) & 0x3f | 0x80);
    $UUID = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($uuidData), 4));

    $url = "<img src=\"https://proficon.stablenetwork.uk/api/identicon/$UUID.svg\" alt=\"Profile Photo\">";

    //SQL Prepped Statement
    $sql="INSERT INTO `tblUsers` (`UUID`, `Email`, `Password`, `FirstName`, `LastName`, `JobTitle`, `AccessLevel`, profileImage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

	$to = $email;
	$subject = "User Account Creation";
	$txt = "Hi ".$firstName." ".$lastName.".\n\nA User account has been created for you on the training platform. The login details are listed below.\n\n\nUsername: ".$email."\nPassword: ".$password."\nURL: https://ws255237-wad.remote.ac\n\nKind Regards,\nVD Training Team\n\n";
	$headers = "From: noreply@vixendev.com";
	mail($to,$subject,$txt,$headers);
    $stmt=mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $UUID, $email, $encPass, $firstName, $lastName, $jobTitle, $accessLevel, $url);
    if($stmt -> execute()){
        echo json_encode(array("statuscode" => 200));
    }
    else{
        echo json_encode(array("statuscode" => 201));
    }
    $stmt -> close();

?>