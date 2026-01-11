<?php
$host = "127.0.0.1:3307"; // This forces the connection to use port 3307
$user = "root";
$pass = "";               // Empty password as shown in your phpMyAdmin
$dbname = "blog";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>