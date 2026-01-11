<?php include('db.php'); ?>
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

<?php
if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    $row = mysqli_fetch_assoc($result);
    
    if($row && password_verify($pass, $row['password'])) {
        $_SESSION['user'] = $row['username']; // Requirement: Session Management
        header("Location: index.php");
    } else {
        echo "<script>alert('Invalid Credentials');</script>";
    }
}
?>