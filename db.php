<?php
// 1. Force errors to show on screen
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>PHP is working!</h1>"; // If you see this, PHP is fine.

$host = "127.0.0.1:3307"; 
$user = "root";
$pass = ""; 
$dbname = "blog";

// 2. Try to connect
$conn = mysqli_connect($host, $user, $pass, $dbname);

// 3. Check connection
if (!$conn) {
    die("<b style='color:red'>Database Connection Failed:</b> " . mysqli_connect_error());
} else {
    echo "<b style='color:green'>Success! Database is connected.</b>";
}
?>