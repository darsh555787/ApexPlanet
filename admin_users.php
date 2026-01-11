<?php 
include('db.php'); 
// Strict Security: Only allow Admins to see this page
if(!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle Role Updates
if(isset($_POST['update_role'])) {
    $target_id = $_POST['user_id'];
    $new_role = $_POST['role'];
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $new_role, $target_id);
    $stmt->execute();
    echo "<script>alert('Role Updated Successfully!');</script>";
}

$users = $conn->query("SELECT id, username, role FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h3 class="fw-bold text-primary mb-4">User Role Management</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Current Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($u = $users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($u['username']); ?></td>
                    <td><span class="badge bg-info text-dark"><?php echo strtoupper($u['role']); ?></span></td>
                    <td>
                        <form method="POST" class="d-flex gap-2">
                            <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                            <select name="role" class="form-select form-select-sm">
                                <option value="editor" <?php if($u['role']=='editor') echo 'selected'; ?>>Editor</option>
                                <option value="admin" <?php if($u['role']=='admin') echo 'selected'; ?>>Admin</option>
                            </select>
                            <button name="update_role" type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-link">Back to Feed</a>
    </div>
</div>
</body>
</html>