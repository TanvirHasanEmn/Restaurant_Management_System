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

// Fetch orders for the customer
$customer_id = $_SESSION['user_id'];
$order_result = $mysqli->query("SELECT Order_ID FROM Order_R WHERE Customer_ID = $customer_id");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];
    $payment_amount = $_POST['payment_amount'];
    $order_id = $_POST['order_id'];
    
    // Input validation
    if (empty($payment_method) || empty($payment_amount) || empty($order_id)) {
        $message = "All fields are required.";
    } else {
        // Insert payment data into the database
        $stmt = $mysqli->prepare("INSERT INTO Payment (Payment_Method, Payment_Amount, Order_ID, Customer_ID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sdii', $payment_method, $payment_amount, $order_id, $customer_id);

        if ($stmt->execute()) {
            $message = "Payment made successfully!";
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
    <title>Make Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
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

        input[type="number"], input[type="text"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
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

<h1>Make a Payment</h1>

<div class="container">
    <form action="payment.php" method="POST">
        <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="">Select Payment Method</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Debit Card">Debit Card</option>
                <option value="Cash">Cash</option>
                <option value="Mobile Payment">Mobile Payment</option>
            </select>
        </div>

        <div class="form-group">
            <label for="payment_amount">Payment Amount:</label>
            <input type="number" id="payment_amount" name="payment_amount" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="order_id">Order ID:</label>
            <select id="order_id" name="order_id" required>
                <option value="">Select Order</option>
                <?php while ($order_row = $order_result->fetch_assoc()): ?>
                    <option value="<?= $order_row['Order_ID'] ?>"><?= $order_row['Order_ID'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn">Submit Payment</button>
    </form>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
</div>

</body>
</html>
