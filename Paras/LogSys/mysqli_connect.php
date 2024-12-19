<?php
$servername = "localhost"; 
$username = "kurtparas";
$password = "kurtparas";
$dbname = "members_paras";

$dbcon = new mysqli($servername, $username, $password, $dbname);

if ($dbcon->connect_error) {
    die("Could Not Connect to MySQLi Server: " . $dbcon->connect_error);
}
?>