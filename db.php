<?php
$host = "127.0.0.1"; // Changed from localhost to IP
$user = "root";
$pass = "";         // Leave empty as per your screenshot
$dbname = "blog";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // Uncomment the line below to test if it works, then delete it
    // echo "Connected successfully!"; 
}
?>