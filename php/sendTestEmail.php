<?php

$to = $email;
$subject = "User Account Creation";
$userName = $firstName . " " . $lastName;
$txt = "Hi ".$firstName." ".$lastName.".\n\nA User account has been created for you on the training platform. The login details are listed below.\n\n\nUsername: ".$email."\nPassword: ".$password."\nURL: https://ws255237-wad.remote.ac\n\nKind Regards,\nVD Training Team\n\n";
sendMail($to, $userName,  $subject, $txt, $txt);

echo json_encode(array("statuscode" => 200));

?>