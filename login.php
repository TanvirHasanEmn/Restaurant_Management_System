<?php
// Connect to the database
$mysqli = new mysqli('localhost', 'root', '', 'restaurant_db');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Initialize variables
$error = '';

// Validate form input when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $role = $mysqli->real_escape_string($_POST['role']);

    // Check if email exists and role matches
    $check_user = "SELECT * FROM Users WHERE Email = '$email' AND Role = '$role'";
    $result = $mysqli->query($check_user);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['Password'])) {
            // Redirect based on role
            if ($role == 'customer') {
                header("Location: customer.php");
                exit();
            } elseif ($role == 'admin') {
                header("Location: admin.php");
                exit();
            }
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Invalid email or role.";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management - Login</title>
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: white;
            width: 360px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-box h1 {
            color: #1877f2;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .login-box input[type="email"],
        .login-box input[type="password"],
        .login-box select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            background-color: #1877f2;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #145dbf;
        }

        .login-box p {
            margin-top: 10px;
            font-size: 14px;
            color: #606770;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Login</h1>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                </select>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
