<?php
session_start();

// Database connection
$mysqli = new mysqli('localhost', 'root', '', 'restaurant_db');

// Check connection
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$message = '';

// Handle form submission to add or update staff
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_id = $_POST['staff_id'] ?? null;
    $name = $_POST['name'];
    $role = $_POST['role'];
    $contact = $_POST['contact'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zip_code = $_POST['zip_code'];

    // Validation
    if (empty($name) || empty($role) || empty($contact) || empty($street) || empty($city) || empty($zip_code)) {
        $message = "All fields are required.";
    } else {
        if ($staff_id) {
            // Update staff
            $stmt = $mysqli->prepare("UPDATE Staff SET Name=?, Role=?, Contact=?, Street=?, City=?, Zip_Code=? WHERE Staff_ID=?");
            $stmt->bind_param('ssssssi', $name, $role, $contact, $street, $city, $zip_code, $staff_id);
        } else {
            // Add new staff
            $stmt = $mysqli->prepare("INSERT INTO Staff (Name, Role, Contact, Street, City, Zip_Code) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssss', $name, $role, $contact, $street, $city, $zip_code);
        }

        if ($stmt->execute()) {
            $message = $staff_id ? "Staff updated successfully!" : "Staff added successfully!";
        } else {
            $message = "Error: " . $mysqli->error;
        }

        $stmt->close();
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $staff_id = $_GET['delete'];
    $mysqli->query("DELETE FROM Staff WHERE Staff_ID=$staff_id");
    header("Location: staff_info.php");
    exit();
}

// Fetch all staff members
$result = $mysqli->query("SELECT * FROM Staff");

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Information</title>
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
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            padding: 10px 20px;
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

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #d9534f;
        }

        .edit, .delete {
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .edit {
            background-color: #28a745;
        }

        .delete {
            background-color: #dc3545;
        }

        .delete:hover {
            background-color: #c82333;
        }

        .edit:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h1>Staff Information</h1>

<div class="container">
    <form action="staff_info.php" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="role">Role:</label>
            <input type="text" id="role" name="role" required>
        </div>

        <div class="form-group">
            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" required>
        </div>

        <div class="form-group">
            <label for="street">Street:</label>
            <input type="text" id="street" name="street" required>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>
        </div>

        <div class="form-group">
            <label for="zip_code">Zip Code:</label>
            <input type="text" id="zip_code" name="zip_code" required>
        </div>

        <input type="hidden" id="staff_id" name="staff_id">

        <button type="submit" class="btn">Submit</button>
    </form>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Contact</th>
                <th>Street</th>
                <th>City</th>
                <th>Zip Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Staff_ID'] ?></td>
                    <td><?= $row['Name'] ?></td>
                    <td><?= $row['Role'] ?></td>
                    <td><?= $row['Contact'] ?></td>
                    <td><?= $row['Street'] ?></td>
                    <td><?= $row['City'] ?></td>
                    <td><?= $row['Zip_Code'] ?></td>
                    <td>
                        <a href="staff_info.php?edit=<?= $row['Staff_ID'] ?>" class="edit">Edit</a>
                        <a href="staff_info.php?delete=<?= $row['Staff_ID'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this staff?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    // Pre-fill form with staff data for editing
    <?php if (isset($_GET['edit'])): ?>
    var staff = <?php echo json_encode($result->fetch_assoc()) ?>;
    document.getElementById('name').value = staff.Name;
    document.getElementById('role').value = staff.Role;
    document.getElementById('contact').value = staff.Contact;
    document.getElementById('street').value = staff.Street;
    document.getElementById('city').value = staff.City;
    document.getElementById('zip_code').value = staff.Zip_Code;
    document.getElementById('staff_id').value = staff.Staff_ID;
    <?php endif; ?>
</script>

</body>
</html>
