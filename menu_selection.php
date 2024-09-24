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

// Handle Add Menu Item
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $insert_sql = "INSERT INTO Menu (Name, Description, Category, Price) VALUES ('$name', '$description', '$category', '$price')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "New menu item added successfully";
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

// Handle Update
if (isset($_POST['update'])) {
    $menu_id = $_POST['menu_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $update_sql = "UPDATE Menu SET Name='$name', Description='$description', Category='$category', Price='$price' WHERE Menu_ID='$menu_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Handle Delete
if (isset($_POST['delete'])) {
    $menu_id = $_POST['menu_id'];

    $delete_sql = "DELETE FROM Menu WHERE Menu_ID='$menu_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch Menu data
$sql = "SELECT * FROM Menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Selection</title>
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

        input[type="text"], input[type="number"] {
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

        .add-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Menu Selection</h1>

    <!-- Add New Menu Item Form -->
    <div class="add-form">
        <h2>Add New Menu Item</h2>
        <form method="POST">
            <label for="name">Name:</label><br>
            <input type="text" name="name" required><br>
            <label for="description">Description:</label><br>
            <input type="text" name="description" required><br>
            <label for="category">Category:</label><br>
            <input type="text" name="category" required><br>
            <label for="price">Price:</label><br>
            <input type="number" step="0.01" name="price" required><br>
            <input type="submit" name="add" value="Add Item">
        </form>
    </div>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Menu ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>";
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <form method='POST'>
                        <td>" . $row["Menu_ID"] . "</td>
                        <td><input type='text' name='name' value='" . $row["Name"] . "'></td>
                        <td><input type='text' name='description' value='" . $row["Description"] . "'></td>
                        <td><input type='text' name='category' value='" . $row["Category"] . "'></td>
                        <td><input type='number' step='0.01' name='price' value='" . $row["Price"] . "'></td>
                        <input type='hidden' name='menu_id' value='" . $row["Menu_ID"] . "'>
                        <td><input type='submit' name='update' value='Update'></td>
                        <td><input type='submit' name='delete' value='Delete'></td>
                    </form>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='no-data'>No menu items available</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
