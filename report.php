<?php
session_start();

// Connect to the database
$mysqli = new mysqli('localhost', 'root', '', 'restaurant_db');

// Check for connection error
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Queries for each report using subqueries

// 1. List of Orders and Payment Status order by date (updated with JOIN)
$order_query = "SELECT Order_R.Order_ID, Order_R.Order_Date, 
                CASE 
                    WHEN Payment.Payment_ID IS NOT NULL THEN 'Paid' 
                    ELSE 'Pending' 
                END AS Payment_Status
                FROM Order_R
                LEFT JOIN Payment ON Order_R.Order_ID = Payment.Order_ID
                ORDER BY Order_R.Order_Date";

// 2. List of Reservations by Date (using subquery)
$reservation_query = "SELECT Reservation.Reservation_ID, Reservation.Reservation_Date, Reservation.Number_of_Guests 
                     FROM Reservation 
                     WHERE EXISTS (SELECT 1 FROM Customer WHERE Customer.Customer_ID = Reservation.Customer_ID)
                     ORDER BY Reservation.Reservation_Date";

// 3. List of Feedback by Rating (using subquery)
$feedback_query = "SELECT Feedback.Rating, Feedback.Comment, 
                  (SELECT Menu.Name FROM Menu WHERE Menu.Menu_ID = Feedback.Menu_ID) AS Menu_Item 
                  FROM Feedback 
                  ORDER BY Feedback.Rating DESC";

// 4. Total Payments by Customer (using subquery)
$payment_query = "SELECT Customer.First_Name, Customer.Last_Name, 
                  (SELECT SUM(Payment.Payment_Amount) 
                   FROM Payment 
                   WHERE Payment.Customer_ID = Customer.Customer_ID) AS Total_Payments 
                  FROM Customer";

// 5. List of Orders and Ordered Menu Items (using subquery)
$order_items_query = "SELECT Order_R.Order_ID, 
                      (SELECT Menu.Name FROM Menu WHERE Menu.Menu_ID = Order_Item.Menu_ID) AS Menu_Item, 
                      Order_Item.Quantity 
                      FROM Order_R 
                      JOIN Order_Item ON Order_R.Order_ID = Order_Item.Order_ID";

// 6. Most Popular Menu Items (using subquery)
$popular_items_query = "SELECT Menu.Name, 
                        (SELECT SUM(Order_Item.Quantity) 
                         FROM Order_Item 
                         WHERE Order_Item.Menu_ID = Menu.Menu_ID) AS Total_Ordered 
                        FROM Menu 
                        ORDER BY Total_Ordered DESC 
                        LIMIT 5";

// Execute the queries
$order_result = $mysqli->query($order_query);
$reservation_result = $mysqli->query($reservation_query);
$feedback_result = $mysqli->query($feedback_query);
$payment_result = $mysqli->query($payment_query);
$order_items_result = $mysqli->query($order_items_query);
$popular_items_result = $mysqli->query($popular_items_query);

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        
        h1 {
            color: #333;
        }
        
        .container {
            margin-top: 30px;
        }

        .report {
            margin-bottom: 40px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .btn-back {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>Admin Reports</h1>

<div class="container">
    <!-- 1. List of Orders and Payment Status -->
    <div class="report">
        <h2>1. List of Orders and Payment Status</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Payment Status</th>
            </tr>
            <?php while ($row = $order_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Order_ID'] ?></td>
                    <td><?= $row['Order_Date'] ?></td>
                    <td><?= $row['Payment_Status'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- 2. List of Reservations by Date -->
    <div class="report">
        <h2>2. List of Reservations by Date</h2>
        <table>
            <tr>
                <th>Reservation ID</th>
                <th>Reservation Date</th>
                <th>Number of Guests</th>
            </tr>
            <?php while ($row = $reservation_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Reservation_ID'] ?></td>
                    <td><?= $row['Reservation_Date'] ?></td>
                    <td><?= $row['Number_of_Guests'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- 3. List of Feedback by Rating -->
    <div class="report">
        <h2>3. List of Feedback by Rating</h2>
        <table>
            <tr>
                <th>Rating</th>
                <th>Comment</th>
                <th>Menu Item</th>
            </tr>
            <?php while ($row = $feedback_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Rating'] ?></td>
                    <td><?= $row['Comment'] ?></td>
                    <td><?= $row['Menu_Item'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- 4. Total Payments by Customer -->
    <div class="report">
        <h2>4. Total Payments by Customer</h2>
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Total Payments</th>
            </tr>
            <?php while ($row = $payment_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['First_Name'] ?></td>
                    <td><?= $row['Last_Name'] ?></td>
                    <td><?= $row['Total_Payments'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- 5. List of Orders and Ordered Menu Items -->
    <div class="report">
        <h2>5. List of Orders and Ordered Menu Items</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Menu Item</th>
                <th>Quantity</th>
            </tr>
            <?php while ($row = $order_items_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Order_ID'] ?></td>
                    <td><?= $row['Menu_Item'] ?></td>
                    <td><?= $row['Quantity'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- 6. Most Popular Menu Items -->
    <div class="report">
        <h2>6. Most Popular Menu Items</h2>
        <table>
            <tr>
                <th>Menu Item</th>
                <th>Total Ordered</th>
            </tr>
            <?php while ($row = $popular_items_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Name'] ?></td>
                    <td><?= $row['Total_Ordered'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <a href="admin.php"><button class="btn-back">Back to Admin Dashboard</button></a>
</div>

</body>
</html>
