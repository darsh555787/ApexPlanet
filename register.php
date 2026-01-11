<?php include('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register | ApexPlanet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 card p-4 shadow-sm">
                <h3 class="text-center text-primary">Create Account</h3>
                <form method="POST">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
if(isset($_POST['register'])){
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Requirement: Hashing
    $sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
    if(mysqli_query($conn, $sql)) {
        header("Location: login.php");
    }
}
?>