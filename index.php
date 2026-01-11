<?php include('db.php'); 
if(!isset($_SESSION['user'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Feeds | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f2ef; font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto; }
        .navbar { background-color: #ffffff; border-bottom: 1px solid #e0e0e0; }
        .post-card { border-radius: 8px; border: 1px solid #e0e0e0; background: #fff; margin-bottom: 20px; }
        .post-img { width: 100%; border-top-left-radius: 8px; border-top-right-radius: 8px; max-height: 400px; object-fit: cover; }
        .btn-linkedin { background-color: #0a66c2; color: white; border-radius: 20px; }
        .btn-linkedin:hover { background-color: #004182; color: white; }
    </style>
</head>
<body>
<nav class="navbar sticky-top shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">ApexPlanet</a>
        <div class="d-flex">
            <a href="create.php" class="btn btn-linkedin me-2">Start a Post</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM posts ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($res)) { ?>
                <div class="post-card shadow-sm">
                    <?php if($row['image']): ?>
                        <img src="uploads/<?php echo $row['image']; ?>" class="post-img">
                    <?php endif; ?>
                    <div class="p-3">
                        <h5 class="fw-bold"><?php echo $row['title']; ?></h5>
                        <p class="text-secondary small"><?php echo $row['created_at']; ?></p>
                        <p class="text-muted"><?php echo $row['content']; ?></p>
                        <hr>
                        <div class="d-flex gap-2">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm flex-grow-1">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm text-danger flex-grow-1">Delete</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>