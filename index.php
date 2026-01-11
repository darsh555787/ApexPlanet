<?php 
include('db.php'); 

if(!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }

$current_user = $_SESSION['user'];
// Assuming you store user_id in session during login. If not, add it to login.php
$u_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; 

// --- 1. LIKE LOGIC (Toggle) ---
if(isset($_GET['like_id'])) {
    $p_id = $_GET['like_id'];
    $check = mysqli_query($conn, "SELECT * FROM likes WHERE post_id=$p_id AND user_id=$u_id");
    if(mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "DELETE FROM likes WHERE post_id=$p_id AND user_id=$u_id");
    } else {
        mysqli_query($conn, "INSERT INTO likes (post_id, user_id) VALUES ($p_id, $u_id)");
    }
    header("Location: index.php"); exit();
}

// --- 2. COMMENT LOGIC ---
if(isset($_POST['add_comment'])) {
    $p_id = $_POST['post_id'];
    $msg = mysqli_real_escape_string($conn, $_POST['comment_text']);
    mysqli_query($conn, "INSERT INTO comments (post_id, username, comment) VALUES ($p_id, '$current_user', '$msg')");
    header("Location: index.php"); exit();
}

// --- 3. SEARCH & PAGINATION ---
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$search_q = $search ? " WHERE title LIKE '%$search%' OR content LIKE '%$search%' " : "";

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$query = "SELECT * FROM posts $search_q ORDER BY id DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

$total_posts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM posts $search_q"))['total'];
$total_pages = ceil($total_posts / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ApexPlanet | Social Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f2ef; font-family: system-ui, -apple-system, sans-serif; }
        .navbar { background: #fff; border-bottom: 1px solid #ddd; }
        .post-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px; }
        .action-btn { border: none; background: none; color: #666; font-weight: 600; padding: 8px; width: 100%; border-radius: 4px; }
        .action-btn:hover { background: #f3f2ef; }
        .comment-box { background: #f8f9fa; border-radius: 8px; padding: 10px; margin-bottom: 5px; font-size: 0.85rem; }
    </style>
</head>
<body>

<nav class="navbar sticky-top mb-4">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand fw-bold text-primary" href="index.php">ApexPlanet</a>
        <form class="d-flex ms-auto me-3" method="GET">
            <input name="search" class="form-control form-control-sm rounded-pill bg-light" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
        </form>
        <a href="create.php" class="btn btn-primary btn-sm rounded-pill px-3 me-2">Post</a>
        <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill">Logout</a>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <?php while($row = mysqli_fetch_assoc($result)): 
                $post_id = $row['id'];
                $like_res = mysqli_query($conn, "SELECT * FROM likes WHERE post_id=$post_id");
                $like_count = mysqli_num_rows($like_res);
            ?>
                <div class="post-card shadow-sm">
                    <div class="p-3 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white text-center" style="width:40px; height:40px; line-height:40px;">A</div>
                            <div class="ms-2">
                                <div class="fw-bold small">Apex User</div>
                                <div class="text-muted" style="font-size:0.7rem;"><?php echo $row['created_at']; ?></div>
                            </div>
                        </div>
                        <a href="edit.php?id=<?php echo $post_id; ?>" class="text-muted text-decoration-none">Edit</a>
                    </div>

                    <div class="px-3 pb-2">
                        <h6 class="fw-bold"><?php echo htmlspecialchars($row['title']); ?></h6>
                        <p class="small"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    </div>

                    <?php if(!empty($row['image'])): ?>
                        <img src="uploads/<?php echo $row['image']; ?>" class="w-100" style="max-height:400px; object-fit:cover;">
                    <?php endif; ?>

                    <div class="px-3 py-2 border-bottom d-flex justify-content-between text-muted small">
                        <span>👍 <?php echo $like_count; ?> Likes</span>
                        <span><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM comments WHERE post_id=$post_id")); ?> Comments</span>
                    </div>

                    <div class="d-flex p-1 border-bottom">
                        <a href="index.php?like_id=<?php echo $post_id; ?>" class="action-btn text-decoration-none text-center">Like</a>
                        <button class="action-btn" onclick="document.getElementById('c-form-<?php echo $post_id; ?>').focus()">Comment</button>
                    </div>

                    <div class="p-3">
                        <form method="POST" class="d-flex mb-3">
                            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                            <input id="c-form-<?php echo $post_id; ?>" name="comment_text" class="form-control form-control-sm rounded-pill" placeholder="Add a comment..." required>
                            <button name="add_comment" type="submit" class="btn btn-link btn-sm text-decoration-none">Post</button>
                        </form>
                        
                        <?php 
                        $com_res = mysqli_query($conn, "SELECT * FROM comments WHERE post_id=$post_id ORDER BY id DESC LIMIT 2");
                        while($com = mysqli_fetch_assoc($com_res)): ?>
                            <div class="comment-box">
                                <span class="fw-bold"><?php echo $com['username']; ?></span>: <?php echo htmlspecialchars($com['comment']); ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endwhile; ?>

            <nav class="pb-5">
                <ul class="pagination pagination-sm justify-content-center">
                    <?php for($i=1; $i<=$total_pages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

</body>
</html>