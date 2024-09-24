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

// Fetch reservations ordered by date (most recent first)
$sql = "SELECT Reservation_ID, Reservation_Date, Reservation_Time, Number_of_Guests, Customer_ID 
        FROM Reservation 
        ORDER BY Reservation_Date DESC, Reservation_Time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Information</title>
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
    <h1>Reservation Information</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Reservation Date</th>
                        <th>Reservation Time</th>
                        <th>Number of Guests</th>
                        <th>Customer ID</th>
                    </tr>
                </thead>
                <tbody>";
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Reservation_ID"] . "</td>
                    <td>" . $row["Reservation_Date"] . "</td>
                    <td>" . $row["Reservation_Time"] . "</td>
                    <td>" . $row["Number_of_Guests"] . "</td>
                    <td>" . $row["Customer_ID"] . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='no-data'>No reservations available</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
