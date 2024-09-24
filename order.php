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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order & Reservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            margin-top: 50px;
        }

        h1 {
            color: #333;
            font-size: 36px;
            margin-bottom: 40px;
        }

        .menu-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            justify-content: center;
            align-items: center;
        }

        .menu-button {
            padding: 20px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 10px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .menu-button:hover {
            background-color: #0056b3;
        }

        .menu-button a {
            color: white;
            text-decoration: none;
        }

        /* Styling for Logout Button */
        .logout-button {
            background-color: #ff4d4d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 30px;
        }

        .logout-button:hover {
            background-color: #ff1a1a;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Order and Reservation Options</h1>
    
    <div class="menu-buttons">
        <!-- Place Order Button -->
        <button class="menu-button">
            <a href="place_order.php">Place Order</a>
        </button>

        <!-- Table Reservation Button -->
        <button class="menu-button">
            <a href="reservation.php">Table Reservation</a>
        </button>

        <!-- Feedback Button -->
        <button class="menu-button">
            <a href="feedback.php">Feedback / Rating</a>
        </button>

        <!-- Payment Button -->
        <button class="menu-button">
            <a href="payment.php">Payment</a>
        </button>
    </div>

    <!-- Logout Button -->
    <form action="logout.php" method="POST">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</div>

</body>
</html>

<?php
$mysqli->close();
?>
