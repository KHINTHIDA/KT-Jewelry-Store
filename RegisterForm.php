<?php
require_once 'config.php';

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (strlen($password) < 6) {
        $message = "Password must be at least 6 characters long.";
    } else {
        $hash_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows >= 1) {
            $message = "Email already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO customers (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hash_password);
            
            if ($stmt->execute()) {
                echo "<script>
                    alert('Registration successful!');
                    window.location.href = 'Login.php';
                </script>";
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 400px;">
    <h2 class="mb-4">Sign Up</h2>
    
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>

    <form id="registrationForm" action="RegisterForm.php" method="POST" onsubmit="return validateForm();">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div id="passwordMessage" class="form-text"></div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>

    <script>
    const password = document.querySelector("#password");
    const passwordMessage = document.querySelector("#passwordMessage");

    password.addEventListener("input", () => {
        if (password.value.length < 6) {
            passwordMessage.textContent = "Password is too short (minimum 6 characters required)";
            passwordMessage.className = "form-text text-danger";
        } else {
            passwordMessage.textContent = "Password looks good";
            passwordMessage.className = "form-text text-success";
        }
    });

    function validateForm() {
        if (password.value.length < 6) {
            alert("Password must be at least 6 characters long!");
            return false;
        }
        return true;
    }
    </script>

    <div class="mt-3 text-center">
        <a href="Login.php">Already have an account? Log in here</a>
    </div>
</div>
</body>
</html>