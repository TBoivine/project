<?php

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "bindata";

// Create connection
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

//echo "Database connected successfully";
?>