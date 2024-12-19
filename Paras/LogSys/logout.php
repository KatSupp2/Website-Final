<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php'); // balik sa login after maglogin si admin o member
    exit();
} else {
    header('Location: register-page.php'); // wala ka yatang account? register muna
    exit();
}
?>