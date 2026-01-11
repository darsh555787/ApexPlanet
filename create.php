<?php 
include('db.php'); 
// Protect the page: Only logged-in users can add posts
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Post | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 card p-4 shadow-sm">
                <h3 class="text-primary mb-4">Create New Blog Post</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Post Title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-control" rows="5" placeholder="Write your content here..." required></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" name="add_post" class="btn btn-primary flex-grow-1">Publish</button>
                        <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
if(isset($_POST['add_post'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    $query = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Post added successfully!'); window.location='index.php';</script>";
    }
}
?>