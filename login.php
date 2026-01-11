<?php 
include('db.php'); 

if(isset($_POST['login'])){
    // 1. Form Validation (Server-side)
    $user_input = trim($_POST['username']);
    $pass_input = $_POST['password'];

    // 2. Prepared Statement (Requirement: Prevent SQL Injection)
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $user_input);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // 3. Secure Verification
    if($row && password_verify($pass_input, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user'] = $row['username'];
        $_SESSION['role'] = $row['role']; // Store role for permissions
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Invalid Credentials');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 card p-4 shadow-sm">
                <h3 class="text-center text-primary">Staff Login</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>