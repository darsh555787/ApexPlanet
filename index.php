<?php 
include('db.php'); 

// Auth Check: Standard session management requirement
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// --- TASK 3: SEARCH LOGIC ---
$search = "";
$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    // Search filter for both Title and Content
    $search_query = " WHERE title LIKE '%$search%' OR content LIKE '%$search%' ";
}

// --- TASK 3: PAGINATION LOGIC ---
$limit = 5; // Posts per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch filtered and paginated results
$query = "SELECT * FROM posts $search_query ORDER BY id DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

// Get total count for pagination links
$total_query = "SELECT COUNT(*) AS total FROM posts $search_query";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_posts = $total_row['total'];
$total_pages = ceil($total_posts / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advanced Feed | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f2ef; font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto; }
        .navbar { background-color: #ffffff; border-bottom: 1px solid #e0e0e0; position: sticky; top: 0; z-index: 1000; }
        .search-form { background-color: #eef3f8; border-radius: 4px; padding: 2px 8px; }
        .search-input { background: transparent; border: none; outline: none; padding: 5px; width: 250px; }
        .post-card { border-radius: 8px; border: 1px solid #e0e0e0; background: #fff; margin-bottom: 16px; overflow: hidden; }
        .post-img { width: 100%; max-height: 450px; object-fit: cover; border-bottom: 1px solid #f0f0f0; }
        .btn-linkedin { background-color: #0a66c2; color: white; border-radius: 24px; font-weight: 600; }
        .btn-linkedin:hover { background-color: #004182; color: white; }
    </style>
</head>
<body>

<nav class="navbar shadow-sm mb-4">
    <div class="container d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <a class="navbar-brand fw-bold text-primary" href="index.php">ApexPlanet</a>
            
            <form action="index.php" method="GET" class="search-form d-none d-md-flex ms-3">
                <input type="text" name="search" class="search-input" placeholder="Search posts..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-sm text-primary">Search</button>
            </form>
        </div>
        
        <div class="d-flex align-items-center">
            <a href="create.php" class="btn btn-linkedin btn-sm px-4 me-3">Start a post</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="post-card shadow-sm">
                        <div class="p-3 d-flex align-items-center">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                <?php echo strtoupper(substr($_SESSION['user'], 0, 1)); ?>
                            </div>
                            <div>
                                <div class="fw-bold" style="font-size: 0.9rem;"><?php echo $_SESSION['user']; ?></div>
                                <div class="text-muted" style="font-size: 0.75rem;"><?php echo date('M j, Y', strtotime($row['created_at'])); ?></div>
                            </div>
                        </div>

                        <div class="px-3 pb-2">
                            <h6 class="fw-bold"><?php echo htmlspecialchars($row['title']); ?></h6>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                        </div>

                        <?php if(!empty($row['image']) && file_exists("uploads/" . $row['image'])): ?>
                            <img src="uploads/<?php echo $row['image']; ?>" class="post-img" alt="Post">
                        <?php endif; ?>

                        <div class="p-2 border-top d-flex justify-content-around">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-light text-secondary btn-sm flex-grow-1 mx-1 fw-semibold">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-light text-danger btn-sm flex-grow-1 mx-1 fw-semibold" onclick="return confirm('Delete this post?')">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>

                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="index.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>

            <?php else: ?>
                <div class='text-center p-5 card shadow-sm'>
                    <h5 class='text-secondary'>No posts found matching your criteria.</h5>
                    <a href='index.php' class='btn btn-primary mt-3'>Clear Search</a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>