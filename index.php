<?php 
include('db.php'); 

if(!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }

$current_user = $_SESSION['user'];
$u_id = $_SESSION['user_id']; 
$u_role = $_SESSION['role']; // Access role from session

// --- 1. SECURE SEARCH & PAGINATION (Prepared Statements) ---
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_param = "%$search%";

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Use Prepared Statement for Fetching Posts
$stmt = $conn->prepare("SELECT * FROM posts WHERE title LIKE ? OR content LIKE ? ORDER BY id DESC LIMIT ?, ?");
$stmt->bind_param("ssii", $search_param, $search_param, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Get total count for pagination (Prepared)
$t_stmt = $conn->prepare("SELECT COUNT(*) as total FROM posts WHERE title LIKE ? OR content LIKE ?");
$t_stmt->bind_param("ss", $search_param, $search_param);
$t_stmt->execute();
$total_posts = $t_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_posts / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ApexPlanet | Secure Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f2ef; font-family: system-ui, -apple-system, sans-serif; }
        .post-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 16px; }
        .badge-role { font-size: 0.7rem; vertical-align: middle; }
    </style>
</head>
<body>

<nav class="navbar sticky-top mb-4 bg-white border-bottom shadow-sm">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand fw-bold text-primary" href="index.php">ApexPlanet</a>
        <form class="d-flex ms-auto me-3" method="GET">
            <input name="search" class="form-control form-control-sm rounded-pill bg-light" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
        </form>
        <div class="d-flex align-items-center">
            <span class="badge bg-secondary me-2 badge-role"><?php echo strtoupper($u_role); ?></span>
            <a href="create.php" class="btn btn-primary btn-sm rounded-pill px-3 me-2">Post</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <?php while($row = $result->fetch_assoc()): 
                $post_id = $row['id'];
            ?>
                <div class="post-card shadow-sm">
                    <div class="p-3 d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white text-center" style="width:40px; height:40px; line-height:40px;">A</div>
                            <div class="ms-2">
                                <div class="fw-bold small">Apex Staff</div>
                                <div class="text-muted" style="font-size:0.7rem;"><?php echo $row['created_at']; ?></div>
                            </div>
                        </div>
                        <div>
                            <a href="edit.php?id=<?php echo $post_id; ?>" class="text-muted text-decoration-none small me-2">Edit</a>
                            
                            <?php if($u_role == 'admin'): ?>
                                <a href="delete.php?id=<?php echo $post_id; ?>" class="text-danger text-decoration-none small" onclick="return confirm('Delete this post?')">Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="px-3 pb-2">
                        <h6 class="fw-bold"><?php echo htmlspecialchars($row['title']); ?></h6>
                        <p class="small"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    </div>

                    <?php if(!empty($row['image'])): ?>
                        <img src="uploads/<?php echo $row['image']; ?>" class="w-100" style="max-height:400px; object-fit:cover;">
                    <?php endif; ?>
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