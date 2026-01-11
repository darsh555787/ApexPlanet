<?php 
include('db.php'); 

// Auth Check: Standard session management requirement
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Fetch existing data
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $res = mysqli_query($conn, "SELECT * FROM posts WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
}

// Handle Update Logic
if(isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $old_image = $_POST['old_image'];
    
    // Check if a new image is being uploaded
    if(!empty($_FILES['image']['name'])) {
        $new_image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$new_image);
        // Delete the old physical file if it exists
        if(!empty($old_image) && file_exists("uploads/".$old_image)) {
            unlink("uploads/".$old_image);
        }
    } else {
        // Keep the old image if no new one is selected
        $new_image = $old_image;
    }

    // Update query
    $sql = "UPDATE posts SET title='$title', content='$content', image='$new_image' WHERE id=$id";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Post updated!'); window.location='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Post | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f2ef; }
        .edit-card { border-radius: 8px; border: none; }
        .current-img { max-height: 150px; border-radius: 4px; border: 1px solid #ddd; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 card p-4 shadow-sm edit-card">
            <h4 class="fw-bold mb-4">Edit Your Post</h4>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Content</label>
                    <textarea name="content" class="form-control" rows="5" required><?php echo htmlspecialchars($row['content']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold d-block">Current Image</label>
                    <?php if(!empty($row['image'])): ?>
                        <img src="uploads/<?php echo $row['image']; ?>" class="current-img mb-2">
                        <p class="text-muted small">Select a new file below only if you want to change this image.</p>
                    <?php else: ?>
                        <p class="text-muted small">No image uploaded for this post.</p>
                    <?php endif; ?>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="d-flex gap-2 pt-3">
                    <button type="submit" name="update" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                    <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>