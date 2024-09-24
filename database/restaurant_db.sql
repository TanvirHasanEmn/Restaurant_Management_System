-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 06:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chef`
--

CREATE TABLE `chef` (
  `Chef_ID` int(11) NOT NULL,
  `Specialty` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Customer_ID` int(11) NOT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Street` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `Zip_Code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Customer_ID`, `First_Name`, `Last_Name`, `Phone`, `Email`, `Street`, `City`, `Zip_Code`) VALUES
(1, 'tanvir', 'hasan', '01711111111', 'Tanvir@gmail.com', 'dhaka', 'dhaka', '6700');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `Feedback_ID` int(11) NOT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Comment` varchar(255) DEFAULT NULL,
  `Customer_ID` int(11) DEFAULT NULL,
  `Menu_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`Feedback_ID`, `Rating`, `Comment`, `Customer_ID`, `Menu_ID`) VALUES
(1, 5, 'delicious pizza', 1, 1),
(2, 4, 'good', 1, 3),
(3, 3, 'well', 1, 2),
(4, 5, 'delicious', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `Menu_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Category` varchar(50) DEFAULT NULL,
  `Price` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`Menu_ID`, `Name`, `Description`, `Category`, `Price`) VALUES
(1, 'Extra cheesy Pizza', ' pizza with mozzarella cheese and tomato sauce', 'Pizza', 299.00),
(2, 'Beef Kacchi', 'special beef kacchi', 'Salad', 399.00),
(3, 'Spaghetti ', 'Spaghetti with sauce made with beef and tomatoes', 'Pasta', 199.00),
(4, 'Grilled Chicken Sandwich', 'Grilled chicken with lettuce,and tomato on a toasted bun', 'Sandwich', 249.00),
(5, 'Chocolate Cake', '1 Pound Chocolate cake with a rich chocolate frosting', 'Dessert', 499.00),
(6, 'burger', 'burger', 'food', 199.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `Order_Item_ID` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Menu_ID` int(11) DEFAULT NULL,
  `Order_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_r`
--

CREATE TABLE `order_r` (
  `Order_ID` int(11) NOT NULL,
  `Order_Date` date DEFAULT NULL,
  `Order_Time` time DEFAULT NULL,
  `Total_Amount` decimal(10,2) DEFAULT NULL,
  `Payment_Status` varchar(20) DEFAULT NULL,
  `Customer_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_r`
--

INSERT INTO `order_r` (`Order_ID`, `Order_Date`, `Order_Time`, `Total_Amount`, `Payment_Status`, `Customer_ID`) VALUES
(1, '2024-09-23', '03:05:00', 200.00, 'Paid', 1),
(2, '2024-09-11', '11:26:00', 259.00, 'paid', 1),
(3, '2024-09-25', '14:44:00', 299.00, 'pending', 1),
(4, '2024-09-23', '17:05:00', 299.00, 'paid', 1),
(5, '2024-09-25', '11:58:00', 299.00, 'paid', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Payment_ID` int(11) NOT NULL,
  `Payment_Method` varchar(50) DEFAULT NULL,
  `Payment_Amount` decimal(10,2) DEFAULT NULL,
  `Order_ID` int(11) DEFAULT NULL,
  `Customer_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`Payment_ID`, `Payment_Method`, `Payment_Amount`, `Order_ID`, `Customer_ID`) VALUES
(1, 'Cash', 299.00, 1, 1),
(2, 'Debit Card', 399.00, 2, 1),
(3, 'Cash', 299.00, 2, 1),
(4, 'Cash', 299.00, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `Reservation_ID` int(11) NOT NULL,
  `Reservation_Date` date DEFAULT NULL,
  `Reservation_Time` time DEFAULT NULL,
  `Number_of_Guests` int(11) DEFAULT NULL,
  `Customer_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`Reservation_ID`, `Reservation_Date`, `Reservation_Time`, `Number_of_Guests`, `Customer_ID`) VALUES
(1, '2024-09-25', '16:27:00', 3, 1),
(2, '2024-09-23', '17:05:00', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL,
  `Contact` varchar(20) DEFAULT NULL,
  `Street` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `Zip_Code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_ID`, `Name`, `Role`, `Contact`, `Street`, `City`, `Zip_Code`) VALUES
(1, 'Anik', 'staff', '0179999999999', 'dhaka', 'dhaka', '6500'),
(2, 'abir', 'cheff', '0198774868546', 'dhaka', 'dhaka', '6500');

-- --------------------------------------------------------

--
-- Table structure for table `table_r`
--

CREATE TABLE `table_r` (
  `Table_ID` int(11) NOT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `Location` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('admin','customer') NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Username`, `Password`, `Role`, `Email`) VALUES
(13, '', '$2y$10$C8gVopJA4EwWljTS4nn53e7cvrISn4xtC2YlhUnHp/3SmXSvOqnie', 'admin', 'tanvirhasanemn@gmail.com'),
(14, '', '$2y$10$I7H39b8NbuirnbNu2GgW8ehy64a2anqt5SRCsSaoSq.6tlSefCLDm', 'customer', 'tanvir@gmail.com'),
(15, '', '$2y$10$5lXUzSMN8ByLLt1iB.j1zeXLRbtvRzVkFoZ4l8XyuTxOgtcJY/wcK', 'customer', 'tanvir222@gmail.com'),
(16, '', '$2y$10$dieGHB6JlpdFupFFquqvT.pFtIjB/UqLDQze7zAQyUgokA0YmPQ.a', 'customer', 'nafiz222@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chef`
--
ALTER TABLE `chef`
  ADD PRIMARY KEY (`Chef_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Customer_ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`Feedback_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`),
  ADD KEY `Menu_ID` (`Menu_ID`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`Menu_ID`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`Order_Item_ID`),
  ADD KEY `Menu_ID` (`Menu_ID`),
  ADD KEY `Order_ID` (`Order_ID`);

--
-- Indexes for table `order_r`
--
ALTER TABLE `order_r`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `Order_ID` (`Order_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`Reservation_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_ID`);

--
-- Indexes for table `table_r`
--
ALTER TABLE `table_r`
  ADD PRIMARY KEY (`Table_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Feedback_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `Menu_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `Order_Item_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_r`
--
ALTER TABLE `order_r`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `Reservation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `Staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_r`
--
ALTER TABLE `table_r`
  MODIFY `Table_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chef`
--
ALTER TABLE `chef`
  ADD CONSTRAINT `chef_ibfk_1` FOREIGN KEY (`Chef_ID`) REFERENCES `staff` (`Staff_ID`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`Menu_ID`) REFERENCES `menu` (`Menu_ID`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`Menu_ID`) REFERENCES `menu` (`Menu_ID`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`Order_ID`) REFERENCES `order_r` (`Order_ID`);

--
-- Constraints for table `order_r`
--
ALTER TABLE `order_r`
  ADD CONSTRAINT `order_r_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`Order_ID`) REFERENCES `order_r` (`Order_ID`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`Customer_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
