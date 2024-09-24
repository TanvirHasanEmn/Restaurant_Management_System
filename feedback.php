<?php
session_start();

// Check if the user is logged in (assume it's a customer)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'restaurant_db');

// Check connection
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$message = '';

// Fetch menu items for dropdown selection
$menu_result = $mysqli->query("SELECT Menu_ID, Name FROM Menu");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $menu_id = $_POST['menu_id'];
    $customer_id = $_SESSION['user_id'];  // Assume customer ID is stored in the session

    // Input validation
    if (empty($rating) || empty($comment) || empty($menu_id)) {
        $message = "All fields are required.";
    } else {
        // Insert feedback into the database
        $stmt = $mysqli->prepare("INSERT INTO Feedback (Rating, Comment, Customer_ID, Menu_ID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isii', $rating, $comment, $customer_id, $menu_id);

        if ($stmt->execute()) {
            $message = "Feedback submitted successfully!";
        } else {
            $message = "Error: " . $mysqli->error;
        }

        $stmt->close();
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            resize: vertical;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #d9534f;
        }
    </style>
</head>
<body>

<h1>Submit Feedback</h1>

<div class="container">
    <form action="feedback.php" method="POST">
        <div class="form-group">
            <label for="rating">Rating (1-5):</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>
        </div>

        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea id="comment" name="comment" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="menu_id">Menu Item:</label>
            <select id="menu_id" name="menu_id" required>
                <option value="">Select Menu Item</option>
                <?php while ($menu_row = $menu_result->fetch_assoc()): ?>
                    <option value="<?= $menu_row['Menu_ID'] ?>"><?= $menu_row['Name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn">Submit Feedback</button>
    </form>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
</div>

</body>
</html>
