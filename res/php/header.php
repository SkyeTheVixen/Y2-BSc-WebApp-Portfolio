<?php
    include("_connect.php");
    include_once("headerfuncs.inc.php");
    //If visiting account page with no slash at the end, redirect to account/
    if($currentPage == "account" && (!endsWith($_SERVER['REQUEST_URI'], "/"))){
        header("Location: account/");
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=$pathHead?>favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=$pathHead?>favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=$pathHead?>favicon/favicon-16x16.png">
    <link rel="manifest" href="<?=$pathHead?>favicon/site.webmanifest">
    <link rel="mask-icon" href="<?=$pathHead?>favicon/safari-pinned-tab.svg" color="#0b2033">
    <link rel="shortcut icon" href="<?=$pathHead?>favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#0b2033">
    <meta name="msapplication-config" content="<?=$pathHead?>favicon/browserconfig.xml">
    <meta name="theme-color" content="#0b2033">
    <title><?= $title; ?></title>
    <!-- End Metadata -->

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?=$pathHead?>css/<?=$currentPage;?>.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- End Stylesheets -->
</head>
