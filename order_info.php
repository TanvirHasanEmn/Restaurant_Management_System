<?php
// Database connection
$servername = "localhost";
$username = "root";  // Use your database username
$password = "";      // Use your database password
$dbname = "restaurant_db";  // Use your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders ordered by date (most recent first)
$sql = "SELECT Order_ID, Order_Date, Order_Time, Total_Amount, Payment_Status, Customer_ID 
        FROM Order_R 
        ORDER BY Order_Date DESC, Order_Time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .no-data {
            text-align: center;
            font-size: 18px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Order Information</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Order Time</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Customer ID</th>
                    </tr>
                </thead>
                <tbody>";
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Order_ID"] . "</td>
                    <td>" . $row["Order_Date"] . "</td>
                    <td>" . $row["Order_Time"] . "</td>
                    <td>$" . number_format($row["Total_Amount"], 2) . "</td>
                    <td>" . $row["Payment_Status"] . "</td>
                    <td>" . $row["Customer_ID"] . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='no-data'>No orders available</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
