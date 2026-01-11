<?php
$host = "localhost";
$user = "root";
$pass = ""; // This must be an empty string, no spaces.
$dbname = "blog";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>