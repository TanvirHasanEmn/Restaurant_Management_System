<?php
session_start();

// Check if the user is logged in (can be either admin or customer)
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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $number_of_guests = $_POST['number_of_guests'];
    $customer_id = $_SESSION['user_id'];  // Assume user_id is stored in the session

    // Input validation
    if (empty($reservation_date) || empty($reservation_time) || empty($number_of_guests)) {
        $message = "All fields are required.";
    } else {
        // Insert reservation into the database
        $stmt = $mysqli->prepare("INSERT INTO Reservation (Reservation_Date, Reservation_Time, Number_of_Guests, Customer_ID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssii', $reservation_date, $reservation_time, $number_of_guests, $customer_id);

        if ($stmt->execute()) {
            $message = "Reservation created successfully!";
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
    <title>Create Reservation</title>
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

        input[type="text"], input[type="date"], input[type="time"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #218838;
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

<h1>Create a Reservation</h1>

<div class="container">
    <form action="reservation.php" method="POST">
        <div class="form-group">
            <label for="reservation_date">Reservation Date:</label>
            <input type="date" id="reservation_date" name="reservation_date" required>
        </div>
        
        <div class="form-group">
            <label for="reservation_time">Reservation Time:</label>
            <input type="time" id="reservation_time" name="reservation_time" required>
        </div>
        
        <div class="form-group">
            <label for="number_of_guests">Number of Guests:</label>
            <input type="number" id="number_of_guests" name="number_of_guests" min="1" required>
        </div>

        <button type="submit" class="btn">Submit Reservation</button>
    </form>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
</div>

</body>
</html>
