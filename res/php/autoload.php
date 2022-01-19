<?php

    //Get the autoload composer file from wherever it is located
    require __DIR__ . '../../../vendor/autoload.php';
    return Dotenv\Dotenv::createImmutable(__DIR__);
    
?>