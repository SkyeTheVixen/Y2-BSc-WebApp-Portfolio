<?php

    //Require the autoload script
    $dotenv = require("autoload.php");
    $dotenv->load();

    
    //Connect to Maria Server
    $mysqli = mysqli_connect($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASS"], $_ENV["DB_NAME"]);
    if(!$mysqli) {
        die("Connection failed: " . mysqli_connect_error());
    }

?>