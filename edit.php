<?php 
include('db.php'); 
if(!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }

// Fetch the existing post data
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM posts WHERE id=$id");
    $post = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Post | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h3 class="text-warning mb-4">Edit Post</h3>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $post['title']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-control" rows="5" required><?php echo $post['content']; ?></textarea>
                    </div>
                    <button type="submit" name="update" class="btn btn-warning w-100">Update Post</button>
                    <a href="index.php" class="btn btn-link w-100 text-secondary mt-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST['update'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Post Updated Successfully!'); window.location='index.php';</script>";
    }
}
?>
</body>
</html>