<?php
$errors = array();
require 'mysqli_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['fname'])) {
        $errors[] = "Please Enter Your First Name.";
    } else {
        $fn = trim($_POST['fname']);
    }

    if (empty($_POST['lname'])) {
        $errors[] = "Please Enter Your Last Name.";
    } else {
        $ln = trim($_POST['lname']);
    }

    if (empty($_POST['email'])) {
        $errors[] = "Please Enter Your Email Address.";
    } else {
        $e = trim($_POST['email']);
    }

    if (empty($_POST['psword1'])) {
        $errors[] = "Please Enter Your Password.";
    } elseif ($_POST['psword1'] !== $_POST['psword2']) {
        $errors[] = "Your Passwords Do Not Match.";
    } else {
        $p = trim($_POST["psword1"]);
    }

    if (empty($errors)) {
        $email_check_query = "SELECT * FROM users WHERE email='$e' LIMIT 1";
        $result = mysqli_query($dbcon, $email_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $errors[] = "Email already registered. Please use a different email.";
        } else {
            $hashed_password = password_hash($p, PASSWORD_DEFAULT);
            $q = "INSERT INTO users (first_name, last_name, email, password, registration_date) 
                  VALUES ('$fn', '$ln', '$e', '$hashed_password', NOW())";
            $result = mysqli_query($dbcon, query: $q);

            if ($result) {
                header('Location: register-thanks.php');
                exit();
            } else {
                echo '<h2>System Error</h2>
                      <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
                echo '<p>' . mysqli_error($dbcon) . '</p>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../CSS/LogSys.css">
    <title>Register</title>
</head>

<body>
    <?php include '../MainPage/NavOther.php'; ?>
    <div class="container-reg">
        <div class="reg-page">
            <h2>Register</h2>
            <form action="register-page.php" method="post">
                <p>
                    <label for="fname">First Name: </label>
                    <input type="text" name="fname" size="30" maxlength="40"
                        value="<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>">
                </p>
                <p>
                    <label for="lname">Last Name: </label>
                    <input type="text" name="lname" size="30" maxlength="40"
                        value="<?php if (isset($_POST['lname'])) echo $_POST['lname']; ?>">
                </p>
                <p>
                    <label for="email">Email Address: </label>
                    <input type="email" name="email" size="30" maxlength="40"
                        value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                </p>
                <p>
                    <label for="psword1">Password: </label>
                    <input type="password" name="psword1" size="20" maxlength="40">
                </p>
                <p>
                    <label for="psword2">Confirm Password: </label>
                    <input type="password" name="psword2" size="20" maxlength="40">
                </p>
                <p><input type="submit" name="submit" value="Register"></p>
            </form>
        </div>
        <div class="image-reg-page">
            <img src="../others/Images/regpage.jpg" alt="Register Page" class="img-reg-page">
            <?php
            if (!empty($errors)) {
                echo '<div class="error-reg-page">';
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
    </div>
</body>

</html>