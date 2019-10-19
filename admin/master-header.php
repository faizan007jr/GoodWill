<?php
session_start();
require ('../conn.php');

if(empty($_SESSION["seller"])) {
    header('Location: ../login.php');
}

if(isset($_POST["logout"])) {
    session_destroy();
    header('Location: ../login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../images/icons/icons8-shopping-bag-filled-50.png" />
    <link rel="stylesheet" href="../css/bootstrap-flatly.min.css" type="text/css" />
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/main.css?v=5" type="text/css" />
    <style>
        html {
            position: relative;
            min-height: 100%;
        }
        footer {
            display: none;
            position: absolute;
            left: 0;
            bottom: 0;
            height: auto;
            width: 100%;
        }

    </style>
    <script type="text/javascript" src="../scripts/jquery.min.js"></script>
    <title>Goodwill</title>
</head>

<body>

<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Goodwill</a>
        <form class="form-inline my-2" method="post">
            <input class="btn btn-warning my-2 my-sm-0" type="submit" name="logout" value="Log Out" />
        </form>
    </div>
</nav>

<main class="container mt-5 pt-5">