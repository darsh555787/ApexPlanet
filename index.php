<?php include('db.php'); 
if(!isset($_SESSION['user'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand">ApexPlanet Admin</span>
        <div class="ms-auto">
            <a href="create.php" class="btn btn-success btn-sm">Add Post</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM posts ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($res)) { ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="text-primary"><?php echo $row['title']; ?></h5>
                            <p><?php echo substr($row['content'], 0, 100); ?>...</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>