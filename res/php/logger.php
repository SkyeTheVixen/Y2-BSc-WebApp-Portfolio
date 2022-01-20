<?php

    include("_connect.php");

    $jqXHR = $mysqli->real_escape_string($_POST["jqXHR"]);
    $textStatus = $mysqli->real_escape_string($_POST["textStatus"]);
    $errorThrown = $mysqli->real_escape_string($_POST["errorThrown"]);
    $finalstring = date("Y-m-d H:i:s") . " - " . $jqXHR . " - " . $textStatus . " - " . $errorThrown . "\n\n";
    file_put_contents("jQuery.log", $finalstring, FILE_APPEND);
    exit();

?>