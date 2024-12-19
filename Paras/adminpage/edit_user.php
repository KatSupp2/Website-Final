<?php
session_start(); 

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 1) { 
    header('Location: https://www.noggin-clontith.com/');
    exit();
}

require('../LogSys/mysqli_connect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PCS - Edit User</title>
    <link rel="stylesheet" href="../CSS/ModifyUser.css">
</head>

<body>
    <?php include '../MainPage/NavAdmin.php'; ?>
    <div class="container-edituser">
        <h2 class="h2-edituser">Edit User</h2>
        <div id="loading" class="loading-spinner" style="display: none;"></div>
        <?php
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            echo '<p class="error-message-viewusers">This page has been accessed in error.</p>';
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];

            if (empty($_POST['fname'])) {
                $errors[] = 'You forgot to enter the first name.';
            } else {
                $fn = mysqli_real_escape_string($dbcon, trim($_POST['fname']));
            }

            if (empty($_POST['lname'])) {
                $errors[] = 'You forgot to enter the last name.';
            } else {
                $ln = mysqli_real_escape_string($dbcon, trim($_POST['lname']));
            }

            if (empty($_POST['email'])) {
                $errors[] = 'You forgot to enter the email address.';
            } else {
                $e = mysqli_real_escape_string($dbcon, trim($_POST['email']));
            }

            if (empty($errors)) {
                $q = "UPDATE users SET first_name='$fn', last_name='$ln', email='$e' WHERE user_id=$id LIMIT 1";
                $result = @mysqli_query($dbcon, $q);
                if (mysqli_affected_rows($dbcon) == 1) {
                    echo '<p class="success-message-viewusers">The user has been edited.</p>';
                    echo "<h3>Redirecting to View User page...</h3>";
                    echo '<script>
                            setTimeout(function() {
                                window.location.href = "register_view-users.php";
                            }, 3000); // Redirect after 3 seconds
                          </script>';
                    exit();
                } else {
                    echo '<p class="error-message-viewusers">The user could not be edited due to a system error.</p>';
                    echo '<p>' . mysqli_error($dbcon) . '</p>';
                }
            } else {
                echo '<p class="error-message-viewusers">The following error(s) occurred:<br>';
                foreach ($errors as $msg) {
                    echo " - $msg<br>\n";
                }
                echo '</p><p>Please try again.</p>';
            }
        }

        $q = "SELECT first_name, last_name, email FROM users WHERE user_id=$id";
        $result = @mysqli_query($dbcon, $q);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            echo '<form action="edit_user.php?id=' . $id . '" method="post" class="form-edituser">
                <p>First Name: <input type="text" name="fname" value="' . htmlspecialchars($row[0]) . '" class="input-edituser" required></p>
                <p>Last Name: <input type="text" name="lname" value="' . htmlspecialchars($row[1]) . '" class="input-edituser" required></p>
                <p>Email: <input type="email" name="email" value="' . htmlspecialchars($row[2]) . '" class="input-edituser" required></p>
                <p><input type="submit" name="submit" value="Submit" class="button-edituser"></p>
                </form>';
        } else {
            echo '<p class="error-message-viewusers">This page has been accessed in error.</p>';
        }

        mysqli_close($dbcon);
        ?>
    </div>
</body>

</html>