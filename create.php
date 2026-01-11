<?php include('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f3f2ef;">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 card p-4 border-0 shadow">
            <h4 class="mb-3">Create a Post</h4>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="title" class="form-control mb-3" placeholder="Title" required>
                <textarea name="content" class="form-control mb-3" rows="4" placeholder="What do you want to talk about?" required></textarea>
                <label class="form-label">Add a photo</label>
                <input type="file" name="image" class="form-control mb-4" accept="image/*">
                <button type="submit" name="post" class="btn btn-primary w-100 rounded-pill">Post</button>
            </form>
        </div>
    </div>
</div>

<?php
if(isset($_POST['post'])){
    $t = mysqli_real_escape_string($conn, $_POST['title']);
    $c = mysqli_real_escape_string($conn, $_POST['content']);
    $imgName = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];

    if($imgName){
        move_uploaded_file($tmpName, "uploads/".$imgName);
    }

    mysqli_query($conn, "INSERT INTO posts (title, content, image) VALUES ('$t', '$c', '$imgName')");
    header("Location: index.php");
}
?>
</body>
</html>