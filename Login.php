<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $input_id = trim($_POST['username'] ?? ''); 
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM admins WHERE TRIM(username) = ?");
    $stmt->bind_param("s", $input_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        if ($password === $admin['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $admin['username'];
            header("Location: AddProduct.php");
            exit();
        } else {
            $error_msg = "Incorrect admin password.";
        }
    } else {
       
        $stmt = $conn->prepare("SELECT * FROM customers WHERE TRIM(email) = ? OR TRIM(username) = ?");
        $stmt->bind_param("ss", $input_id, $input_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows == 1) {
            $customer = $result->fetch_assoc();
            if (password_verify($password, $customer['password'])) {
                $_SESSION['customer_logged_in'] = true;
                $_SESSION['customer_email'] = $customer['email'];
                $_SESSION['customer_name'] = $customer['username'];
                
                header("Location: homepage.php");
                exit();
            } else {
                $error_msg = "Incorrect password.";
            }
        } else {
            $error_msg = "Username or Email not found in database.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <form action="Login.php" method="POST" class="container mt-5" style="max-width: 400px;">
        
        <h2 class="mb-4">Login</h2>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_msg); ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">Username or Email:</label>
            <input type="text" name="username" class="form-control" required placeholder="Enter username or email">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required placeholder="Enter password">
        </div>
        
        <button type="submit" name="login" class="btn btn-primary w-100">Log in</button>
        
        <div class="mt-3 text-center">
            <a href="RegisterForm.php">Not a member? Sign up here</a>
        </div>
    </form>

</body>
</html>