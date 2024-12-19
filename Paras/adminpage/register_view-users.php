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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/LogSys.css">
    <title>PCS - View Users</title>
</head>

<body>
    <?php include '../MainPage/NavAdmin.php'; ?>
    <div class="container-viewusers">
        <h2 class="h2-viewusers">Registered Users</h2>
        <div class="search-container">
            <form action="" method="GET" style="width: 100%;">
                <div class="search-input-container">
                    <input type="text" name="search" class="search-input" placeholder="Search by name..." required>
                </div>
            </form>
        </div>
        <?php
        $search = isset($_GET['search']) ? mysqli_real_escape_string($dbcon, $_GET['search']) : '';
        $q = "SELECT user_id, first_name, last_name, email, DATE_FORMAT(registration_date, '%m - %d - %Y') AS regdat 
              FROM users
              WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%'
              ORDER BY user_level DESC, registration_date ASC";
        $result = @mysqli_query($dbcon, $q);

        if ($result) {
            echo "<table class='table-viewusers'>
                    <tr>
                        <th class='th-viewusers'>Name</th>
                        <th class='th-viewusers'>Email</th>
                        <th class='th-viewusers'>Registered Date</th>
                        <th class='th-viewusers'>Actions</th>
                    </tr>";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<tr class='tr-viewusers'>
                        <td class='td-viewusers'>{$row['first_name']} {$row['last_name']}</td>
                        <td class='td-viewusers'>{$row['email']}</td>
                        <td class='td-viewusers'>{$row['regdat']}</td>
                        <td class='td-viewusers'>
                            <a href='delete_user.php?id={$row['user_id']}'><button class='button-viewusers'>Delete User</button></a>
                            <a href='edit_user.php?id={$row['user_id']}'><button class='button-viewusers'>Edit User</button></a>
                            <a href='change_pw.php?id={$row['user_id']}'><button class='button-viewusers'>Change Password</button></a>
                        </td>
                      </tr>";
            }
            echo "</table>";
            mysqli_free_result($result);
        } else {
            echo "<p class='error-message-viewusers'>The current registered users cannot be retrieved. Error: " . mysqli_error($dbcon) . "</p>";
        }
        mysqli_close($dbcon);
    ?>
    </div>
</body>

</html>