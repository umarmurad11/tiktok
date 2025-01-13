<?php
$host = "tiktokmysql.mysql.database.azure.com";
$db_name = "t";
$username = "usman";
$password = "Ritesh@123";

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
