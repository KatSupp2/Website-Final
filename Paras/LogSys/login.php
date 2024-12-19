<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'mysqli_connect.php';

    $errors = [];
    $e = '';

    if (empty($_POST['email'])) {
        $errors[] = 'Please input your email address.';
    } else {
        $e = trim($_POST['email']);           
    }

    if (empty($_POST['psword'])) {
        $errors[] = 'Please input your password.';
    } else {
        $p = trim($_POST['psword']);  
    }
    
    if (!empty($e) && !empty($p)) {
        $q = "SELECT user_id, password, user_level FROM users WHERE email = ?";
        $stmt = mysqli_prepare($dbcon, $q);
        mysqli_stmt_bind_param($stmt, 's', $e);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if (password_verify($p, $row['password'])) {
                session_start();
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_level'] = (int) $row['user_level'];
                
                $url = ($_SESSION['user_level'] === 1) ? '../admin-page.php' : '../members-page.php';
                header('Location: ' . $url);
                exit();
            } else {
                $errors[] = 'Password is wrong, please try again.';
            }
        } else {
            $errors[] = 'Please register first.';
        }
        
        mysqli_free_result($result);
        mysqli_close($dbcon);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/LogSys.css">
</head>

<body>
    <?php include '../MainPage/NavOther.php'; ?>
    <div class="container-login">
        <div class="login-page">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <p>
                    <label for="email">Email Address: </label>
                    <input type="email" name="email" size="30" maxlength="40"
                        value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>">
                </p>
                <p>
                    <label for="psword">Password: </label>
                    <input type="password" name="psword" size="30" maxlength="40">
                </p>
                <p><input type="submit" name="submit" value="Login"></p>
            </form>
            <?php
            if (!empty($errors)) {
                echo '<div class="error-login-page">';
                echo '<h2>Error!</h2>
                    <p>The Following Error(s) Occurred: <br>';
                foreach ($errors as $msg) {
                    echo " - $msg<br/>";
                }
                echo '</p><h4>Please Try Again</h4><br/>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="image-login-page">
            <img src="../others/Images/regpage.jpg" alt="Login Page" class="img-login-page">
            <div class="overlay"></div>
        </div>
    </div>
</body>

</html>