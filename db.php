<?php
$host = "localhost";
$user = "root";
$pass = ""; // Leave this completely empty, no spaces
$dbname = "blog"; // Ensure this matches the DB you created in phpMyAdmin

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>