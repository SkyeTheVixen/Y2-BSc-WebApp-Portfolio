<?php

    //Get the autoload composer file from wherever it is located
    if(file_exists("../vendor/autoload.php")){
        require '../vendor/autoload.php';
    }else if(file_exists("vendor/autoload.php")){
        require 'vendor/autoload.php';
    }else if(file_exists("./vendor/autoload.php")){
        require './vendor/autoload.php';
    }else if(file_exists("../../vendor/autoload.php")){
        require '../../vendor/autoload.php';
    }

    return Dotenv\Dotenv::createImmutable(__DIR__);
?>