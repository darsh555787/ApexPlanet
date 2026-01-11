<?php
include('db.php');
if(!isset($_SESSION['user'])) exit;

if(isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $user_id = $_SESSION['user_id']; // Ensure you store ID in session during login

    $check = mysqli_query($conn, "SELECT * FROM likes WHERE post_id=$post_id AND user_id=$user_id");
    
    if(mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");
    } else {
        mysqli_query($conn, "INSERT INTO likes (post_id, user_id) VALUES ($post_id, $user_id)");
    }
    header("Location: index.php");
}
?>