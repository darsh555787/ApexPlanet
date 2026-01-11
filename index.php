<?php include('db.php'); 
if(!isset($_SESSION['user'])) { header("Location: login.php"); } // Auth check
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary mb-4 px-4">
        <span class="navbar-brand">ApexPlanet Blog Admin</span>
        <div>
            <a href="create.php" class="btn btn-light btn-sm">New Post</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM posts ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($res)) {
                echo "
                <div class='col-md-4 mb-3'>
                    <div class='card h-100 shadow-sm'>
                        <div class='card-body'>
                            <h5>{$row['title']}</h5>
                            <p class='text-muted small'>{$row['created_at']}</p>
                            <p>".substr($row['content'], 0, 100)."...</p>
                        </div>
                        <div class='card-footer bg-white border-0'>
                            <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>