<?php
session_start();

// Connect to database
$mysqli = new mysqli('localhost', 'root', '', 'restaurant_db');

// Check for database connection error
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Fetch menu items from database
$query = "SELECT * FROM Menu";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Menu</title>
    <style>
        /* Container for the entire page */
        .container {
            width: 90%;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        /* Styling the title */
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Grid layout for menu items */
        .menu-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        /* Each individual menu item */
        .menu-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            text-align: left;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        /* Menu item image */
        .menu-img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
        }

        /* Description container for each item */
        .menu-description {
            padding: 15px;
        }

        .menu-description h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .menu-description p {
            font-size: 14px;
            margin-bottom: 8px;
        }

        .logout-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Our Menu</h1>
    <div class="menu-items">
        <?php while($row = $result->fetch_assoc()) { ?>
            <div class="menu-item">
                <a href="order.php?menu_id=<?php echo $row['Menu_ID']; ?>">
                    <img src="images/<?php echo $row['Menu_ID']; ?>.jpg" alt="<?php echo $row['Name']; ?>" class="menu-img">
                </a>
                <div class="menu-description">
                    <h3><?php echo $row['Name']; ?></h3>
                    <p><?php echo $row['Description']; ?></p>
                    <p><strong>Category:</strong> <?php echo $row['Category']; ?></p>
                    <p><strong>Price:</strong> <?php echo $row['Price']; ?> Tk</p>
                </div>
            </div>
        <?php } ?>
    </div>
    <form action="login.php" method="POST">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</div>

</body>
</html>

<?php
$mysqli->close();
?>
