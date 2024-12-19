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
    <title>PCS - Delete User</title>
    <link rel="stylesheet" href="../CSS/ModifyUser.css">
</head>

<body>
    <div class="container-deleteuser">
        <h1 class="h1-deleteuser">Deleting content</h1>
        <?php
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = $_GET['id'];
            } elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {
                $id = $_POST['id'];
            } else {
                echo '<p class="error-message-deleteuser">Oi may mali sa website bat ka nandito?</p>';
                exit();
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sure'])) {
                if ($_POST['sure'] == 'Yes') {
                    $q = "DELETE FROM users WHERE user_id = $id LIMIT 1";
                    $result = @mysqli_query($dbcon, $q);
                    if (mysqli_affected_rows($dbcon) == 1) {
                        echo "<h3 class='success-message-deleteuser'>User  Deleted</h3>";
                        echo "<h3>Redirecting to View User page...</h3>";
                        header("refresh:3;url=register_view-users.php");
                        exit();
                    } else {
                        echo "<h3 class='error-message-deleteuser'>The user could not be deleted</h3>";
                        echo "<h3>" . mysqli_error($dbcon) . " <br>Query: "  . $q . "</h3>";
                    }
                } else {
                    echo '<h3 class="error-message-deleteuser">The user has NOT been deleted.</h3>';
                }
            } else {
                $q = "SELECT CONCAT(first_name, ' ', last_name) AS full_name FROM users WHERE user_id = $id";
                $result = @mysqli_query($dbcon, $q);
                if (mysqli_num_rows($result) == 1) {
                    $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
                    echo "<h3 class='h3-deleteuser'>Username: {$row['full_name']}</h3>";
                    echo "<h3 class='h3-deleteuser'>ALERT: ARE YOU SURE YOU WANT TO YEET THIS USER? THIS ACTION CANNOT BE UNDONE!</h3>";
                    echo '<form action="delete_user.php" method="post">
                        <div>
                            <button class="button-deleteuser" type="submit" name="sure" value="Yes">Yes</button>                            
                            <button class="button-deleteuser" type="button" onclick="window.history.back();">No</button>
                        </div>
                        <input type="hidden" name="id" value="' . $id . '">
                    </form>';
                } else {
                    echo '<p class="error-message-deleteuser">This page has been accessed in error.</p>';
                }
            }

            mysqli_close($dbcon);
        ?>
    </div>
</body>

</html>