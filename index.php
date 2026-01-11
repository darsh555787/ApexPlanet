<?php 
include('db.php'); 

// Requirement: Implement session management to handle user login states
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feeds | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f2ef; font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto; }
        .navbar { background-color: #ffffff; border-bottom: 1px solid #e0e0e0; position: sticky; top: 0; z-index: 1000; }
        .post-card { border-radius: 8px; border: 1px solid #e0e0e0; background: #fff; margin-bottom: 16px; overflow: hidden; }
        .post-img { width: 100%; max-height: 450px; object-fit: cover; border-bottom: 1px solid #f0f0f0; }
        .btn-linkedin { background-color: #0a66c2; color: white; border-radius: 24px; font-weight: 600; }
        .btn-linkedin:hover { background-color: #004182; color: white; }
        .username-header { color: #000000; font-weight: 600; font-size: 0.9rem; }
        .post-date { color: rgba(0,0,0,0.6); font-size: 0.75rem; }
    </style>
</head>
<body>

<nav class="navbar shadow-sm mb-4">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand fw-bold text-primary" href="#">ApexPlanet</a>
        <div class="d-flex align-items-center">
            <a href="create.php" class="btn btn-linkedin btn-sm px-4 me-3">Start a post</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            
            <?php
            // Requirement: Read - Display a list of posts from the database
            $query = "SELECT * FROM posts ORDER BY id DESC";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="post-card shadow-sm">
                    <div class="p-3 d-flex align-items-center">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                            <?php echo strtoupper(substr($_SESSION['user'], 0, 1)); ?>
                        </div>
                        <div>
                            <div class="username-header"><?php echo $_SESSION['user']; ?></div>
                            <div class="post-date"><?php echo date('F j, Y', strtotime($row['created_at'])); ?></div>
                        </div>
                    </div>

                    <div class="px-3 pb-2">
                        <h6 class="fw-bold"><?php echo htmlspecialchars($row['title']); ?></h6>
                        <p class="text-muted mb-2" style="font-size: 0.9rem;"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    </div>

                    <?php if(!empty($row['image']) && file_exists("uploads/" . $row['image'])): ?>
                        <img src="uploads/<?php echo $row['image']; ?>" class="post-img" alt="Post Image">
                    <?php endif; ?>

                    <div class="p-2 border-top d-flex justify-content-around">
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-light text-secondary btn-sm flex-grow-1 mx-1 fw-semibold">
                           Edit
                        </a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-light text-danger btn-sm flex-grow-1 mx-1 fw-semibold" onclick="return confirm('Delete this post permanently?')">
                           Delete
                        </a>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo "<div class='text-center p-5 card shadow-sm'>
                        <h5 class='text-secondary'>No posts yet. Be the first to share!</h5>
                        <a href='create.php' class='btn btn-primary mt-3'>Create Post</a>
                      </div>";
            }
            ?>

        </div>
    </div>
</div>

</body>
</html>