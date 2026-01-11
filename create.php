<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Post | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="text-primary mb-4">Add New Post</h3>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter post title" required>
                    </div>
                    <div class="mb-3">
                        <label>Content</label>
                        <textarea name="content" class="form-control" rows="5" placeholder="Write something..." required></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary w-100">Publish Post</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Post Created Successfully!'); window.location='index.php';</script>";
    }
}
?>
</body>
</html>