<?php
session_start(); 

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 0) { 
    header('Location: LogSys/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Website ni Paras - MEMBER</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="CSS/MainPage.css">
    <script src="CSS/MainPage.js"></script>
    </body>

</head>

<body>
    <?php include ('MainPage/NavLogin-Members.php'); ?>
    <?php include ('MainPage/Header.php'); ?>
    <?php include ('MainPage/Info.php'); ?>
    <?php include ('MainPage/Footer.php'); ?>
</body>

</html>