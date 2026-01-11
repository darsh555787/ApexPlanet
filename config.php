<?php
$conn = mysqli_connect("localhost", "root", "", "blog");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start(); // Important for User Authentication
?>