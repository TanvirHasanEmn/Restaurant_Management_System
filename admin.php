<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        h1 {
            margin-top: 20px;
            margin-bottom: 40px;
            color: #333;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .grid-item {
            text-align: center;
        }

        .icon-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            border: 2px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.3s;
        }

        .icon-button:hover {
            background-color: #f0f0f0;
            transform: scale(1.05);
        }

        .icon-button img {
            width: 80px;
            height: 80px;
        }

        .icon-button span {
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="grid-container">
            <div class="grid-item">
                <a href="order_info.php">
                    <button class="icon-button">
                        <img src="icons/order.png" alt="Order Information">
                        <span>Order Information</span>
                    </button>
                </a>
            </div>
            <div class="grid-item">
                <a href="reservation_info.php">
                    <button class="icon-button">
                        <img src="icons/reservation.png" alt="Table Reservation">
                        <span>Table Reservation</span>
                    </button>
                </a>
            </div>
            <div class="grid-item">
                <a href="user_feedback.php">
                    <button class="icon-button">
                        <img src="icons/feedback.png" alt="User Feedback">
                        <span>User Feedback</span>
                    </button>
                </a>
            </div>
            <div class="grid-item">
                <a href="staff_info.php">
                    <button class="icon-button">
                        <img src="icons/staff.png" alt="Staff Information">
                        <span>Staff Information</span>
                    </button>
                </a>
            </div>
            <div class="grid-item">
                <a href="customer_info.php">
                    <button class="icon-button">
                        <img src="icons/customer.png" alt="Customer Information">
                        <span>Customer Information</span>
                    </button>
                </a>
            </div>
            <div class="grid-item">
                <a href="report.php">
                    <button class="icon-button">
                        <img src="icons/report.png" alt="Report">
                        <span>Report</span>
                    </button>
                </a>
            </div>
            <div class="grid-item">
                <a href="menu_selection.php">
                    <button class="icon-button">
                        <img src="icons/menu.png" alt="Menu Selection">
                        <span>Menu Selection</span>
                    </button>
                </a>
            </div>
        </div>
        </div>
    <form action="login.php" method="POST">
        <button type="submit" class="logout-button">Logout</button>
    </form>
    </div>
</body>
</html>
