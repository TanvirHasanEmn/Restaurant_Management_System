<?php
// Connect to the database
$mysqli = new mysqli('localhost', 'root', '', 'restaurant_db');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Initialize variables
$error = '';
$success = '';

// Validate form input when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $mysqli->real_escape_string($_POST['role']);

    // Check if email is already in use
    $check_email = "SELECT * FROM Users WHERE Email = '$email'";
    $result = $mysqli->query($check_email);

    if ($result->num_rows > 0) {
        $error = "Email is already registered. Please use another email.";
    } else {
        // Insert user data into the database
        $sql = "INSERT INTO Users (Email, Password, Role) VALUES ('$email', '$password', '$role')";

        if ($mysqli->query($sql) === TRUE) {
            $success = "Signup successful!";
        } else {
            $error = "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management - Signup</title>
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

        .signup-box {
            background-color: white;
            width: 360px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .signup-box h1 {
            color: #1877f2;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .signup-box input[type="email"],
        .signup-box input[type="password"],
        .signup-box select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .signup-box button {
            width: 100%;
            padding: 12px;
            background-color: #1877f2;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
        }

        .signup-box button:hover {
            background-color: #145dbf;
        }

        .signup-box p {
            margin-top: 10px;
            font-size: 14px;
            color: #606770;
        }

        .error, .success {
            color: red;
            margin-bottom: 15px;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="signup-box">
            <h1>Sign Up</h1>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>

            <?php if ($success): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                </select>
                <button type="submit">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
