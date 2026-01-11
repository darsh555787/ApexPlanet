<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Post | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f2ef; }
        .create-card { border-radius: 8px; border: none; }
        .btn-post { background-color: #0a66c2; color: white; border-radius: 20px; font-weight: 600; }
        .btn-post:hover { background-color: #004182; color: white; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 card p-4 shadow-sm create-card">
            <h4 class="mb-4 fw-bold">Share an Update</h4>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="title" class="form-control mb-3" placeholder="Title" required>
                <textarea name="content" class="form-control mb-3" rows="4" placeholder="What's on your mind?" required></textarea>
                
                <label class="form-label text-secondary small">Add a Photo</label>
                <input type="file" name="image" class="form-control mb-4" accept="image/*">
                
                <div class="d-flex justify-content-end">
                    <button type="submit" name="post" class="btn btn-post px-4">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if(isset($_POST['post'])){
    $t = mysqli_real_escape_string($conn, $_POST['title']);
    $c = mysqli_real_escape_string($conn, $_POST['content']);
    
    // Handling the Image Upload
    $imgName = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];

    if($imgName){
        // Move the file from temporary storage to your 'uploads' folder
        move_uploaded_file($tmpName, "uploads/".$imgName);
    }

    $sql = "INSERT INTO posts (title, content, image) VALUES ('$t', '$c', '$imgName')";
    if(mysqli_query($conn, $sql)){
        echo "<script>window.location='index.php';</script>";
    }
}
?>
</body>
</html>