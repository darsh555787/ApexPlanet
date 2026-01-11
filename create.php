<?php 
include('db.php'); 

// Check if user is logged in
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
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
                <div class="mb-3">
                    <input type="text" name="title" class="form-control" placeholder="Title" required>
                </div>
                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="4" placeholder="What's on your mind?" required></textarea>
                </div>
                
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
    // 1. Server-side Validation (Task 4 Requirement)
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $errors = [];

    if(empty($title)) { $errors[] = "Title is required."; }
    if(strlen($content) < 5) { $errors[] = "Content is too short."; }

    if(empty($errors)) {
        // Handling the Image Upload
        $imgName = !empty($_FILES['image']['name']) ? $_FILES['image']['name'] : null;
        $tmpName = $_FILES['image']['tmp_name'];

        if($imgName){
            move_uploaded_file($tmpName, "uploads/".$imgName);
        }

        // 2. Prepared Statements (Task 4 Requirement: Prevent SQL Injection)
        $stmt = $conn->prepare("INSERT INTO posts (title, content, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $imgName);
        
        if($stmt->execute()){
            echo "<script>window.location='index.php';</script>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
        }
        $stmt->close();
    } else {
        // Display validation errors
        foreach($errors as $err) {
            echo "<script>alert('$err');</script>";
        }
    }
}
?>
</body>
</html>