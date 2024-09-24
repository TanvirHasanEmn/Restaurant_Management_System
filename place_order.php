<?php
session_start();

// Check if user is logged in as customer
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}

// Connect to database
$mysqli = new mysqli('localhost', 'root', '', 'restaurant_db');

// Check for database connection error
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Initialize variables for order input
$orderDate = $orderTime = $totalAmount = $paymentStatus = "";
$error = "";

// If form is submitted, insert order into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderDate = $_POST['order_date'];
    $orderTime = $_POST['order_time'];
    $totalAmount = $_POST['total_amount'];
    $paymentStatus = $_POST['payment_status'];
    $customerId = $_SESSION['user_id']; // Assuming user ID is stored in the session when logged in

    // Prepare and bind the SQL statement
    $stmt = $mysqli->prepare("INSERT INTO Order_R (Order_Date, Order_Time, Total_Amount, Payment_Status, Customer_ID) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdsd', $orderDate, $orderTime, $totalAmount, $paymentStatus, $customerId);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "<script>alert('Order placed successfully!');</script>";
        // Redirect to another page or show success message
    } else {
        $error = "Error placing order: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .order-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #555;
        }

        input[type="date"],
        input[type="time"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 5px;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .logout-button {
            margin-top: 20px;
            text-align: center;
        }

        .logout-button a {
            color: #ff4d4d;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="order-container">
    <h1>Place Your Order</h1>
    
    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <!-- Order Date -->
        <div class="form-group">
            <label for="order_date">Order Date:</label>
            <input type="date" name="order_date" id="order_date" required>
        </div>

        <!-- Order Time -->
        <div class="form-group">
            <label for="order_time">Order Time:</label>
            <input type="time" name="order_time" id="order_time" required>
        </div>

        <!-- Total Amount -->
        <div class="form-group">
            <label for="total_amount">Total Amount:</label>
            <input type="number" step="0.01" name="total_amount" id="total_amount" required>
        </div>

        <!-- Payment Status -->
        <div class="form-group">
            <label for="payment_status">Payment Status:</label>
            <select name="payment_status" id="payment_status" required>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn">Submit Order</button>
        </div>
    </form>

    <!-- Logout Button -->
    <div class="logout-button">
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
