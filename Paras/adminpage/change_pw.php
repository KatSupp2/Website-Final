<?php
session_start(); 

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 1) { 
    header('Location: https://www.noggin-clontith.com/');
    exit();
}

require('../LogSys/mysqli_connect.php');

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $query = "SELECT password FROM users WHERE user_id='$user_id'";
    $result = @mysqli_query($dbcon, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        if (password_verify($old_password, $hashed_password)) {
            if ($new_password === $confirm_password) {
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_query = "UPDATE users SET password='$hashed_new_password' WHERE user_id='$user_id'";
                $update_result = @mysqli_query($dbcon, $update_query);

                if ($update_result) {
                    echo "<p>Password changed successfully.</p>";
                } else {
                    echo "<p>Error changing password: " . mysqli_error($dbcon) . "</p>";
                }
            } else {
                echo "<p>New password and confirmation do not match.</p>";
            }
        } else {
            echo "<p>Old password is incorrect.</p>";
        }
    } else {
        echo "<p>Error retrieving user data: " . mysqli_error($dbcon) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/ModifyUser.css">
    <title>PCS - Change Password</title>
</head>

<body>
    <div class="container-change-password-changepw">
        <h2 class="h2-changepw">Change Password</h2>
        <form action="" method="POST">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <div class="form-group-changepw">
                <label class="label-changepw" for="old_password">Old Password:</label>
                <input type="password" class="changepw" name="old_password" id="old_password" required>
            </div>
            <div class="form-group-changepw">
                <label class="label-changepw" for="new_password">New Password:</label>
                <input type="password" class="changepw" name="new_password" id="new_password" required>
            </div>
            <div class="form-group-changepw">
                <label class="label-changepw" for="confirm_password">Confirm New Password:</label>
                <input type="password" class="changepw" name="confirm_password" id="confirm_password" required>
            </div>
            <div class="form-group-changepw">
                <button type="submit" class="button-changepw">Change Password</button>
            </div>
        </form>
    </div>
</body>

</html>