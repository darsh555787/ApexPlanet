<?php
include('db.php');
if(isset($_POST['comment']) && isset($_SESSION['user'])) {
    $p_id = $_POST['post_id'];
    $user = $_SESSION['user'];
    $msg = mysqli_real_escape_string($conn, $_POST['comment']);

    mysqli_query($conn, "INSERT INTO comments (post_id, username, comment) VALUES ($p_id, '$user', '$msg')");
    header("Location: index.php");
}
?>