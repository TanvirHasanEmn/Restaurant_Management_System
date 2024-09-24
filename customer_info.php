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

// Handle update
if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $update_sql = "UPDATE users SET email='$email', role='$role' WHERE user_id='$user_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Handle delete
if (isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];

    $delete_sql = "DELETE FROM users WHERE user_id='$user_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch users data
$sql = "SELECT user_id, email, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information</title>
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

        form {
            display: inline;
        }

        input[type="text"] {
            width: 90%;
            padding: 5px;
            margin: 5px 0;
        }

        input[type="submit"], button {
            padding: 8px 12px;
            background-color: #007BFF;
            border: none;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Customer Information</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>";
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <form method='POST'>
                        <td>" . $row["user_id"] . "</td>
                        <td><input type='text' name='email' value='" . $row["email"] . "'></td>
                        <td><input type='text' name='role' value='" . $row["role"] . "'></td>
                        <input type='hidden' name='user_id' value='" . $row["user_id"] . "'>
                        <td><input type='submit' name='update' value='Update'></td>
                        <td><input type='submit' name='delete' value='Delete'></td>
                    </form>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='no-data'>No users available</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
