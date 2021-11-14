<?php

include("functions.inc.php");

$to = "skylar.beacham@outlook.com";
$subject = "Test Email";
$userName = "Skylar Beacham";
$txt = "Test Email";
sendMail($to, $userName,  $subject, $txt, $txt);

echo json_encode(array("statuscode" => 200));

?>