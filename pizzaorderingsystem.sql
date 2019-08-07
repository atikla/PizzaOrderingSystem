-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2018 at 02:26 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzaorderingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL COMMENT 'EmpID',
  `AdminName` varchar(255) NOT NULL COMMENT 'EmpName',
  `AdminUser` varchar(255) NOT NULL COMMENT 'EmpUser for login into system',
  `AdminPass` varchar(255) NOT NULL COMMENT 'EmpPass for login into System'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Employee Info';

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminName`, `AdminUser`, `AdminPass`) VALUES
(1, 'admin', 'admin', 'admin'),
(30, 'Mohamed', 'aliwimo', 'aliwimo');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL COMMENT 'CustomerID',
  `CustomerPhone` varchar(11) NOT NULL,
  `CustomerEmail` varchar(255) NOT NULL,
  `CustomerFname` varchar(255) NOT NULL,
  `CustomerLname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Customer Info';

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `CustomerPhone`, `CustomerEmail`, `CustomerFname`, `CustomerLname`) VALUES
(157, '5398976163', 'aliwimo@gmail.com', 'Mohamed', 'Aliwi');

-- --------------------------------------------------------

--
-- Table structure for table `fullorder`
--

CREATE TABLE `fullorder` (
  `OrderID` int(11) NOT NULL COMMENT 'OrderID ',
  `CustomerID` int(11) NOT NULL COMMENT 'CustomerID who ordered this order',
  `TotalPrice` int(11) NOT NULL COMMENT 'it will be calculate from pizza Ingredients and nonpizza product',
  `Status` varchar(255) NOT NULL DEFAULT 'Received' COMMENT 'it will be Your order has been taken, getting ready, out, order declined, delivered',
  `OrderAddress` varchar(255) NOT NULL COMMENT 'OrderAddress',
  `OrderTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'when customer placed order',
  `OrderDeliverTime` timestamp NULL DEFAULT NULL COMMENT 'when order delivered or order declined'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='FullOrder ';

--
-- Dumping data for table `fullorder`
--

INSERT INTO `fullorder` (`OrderID`, `CustomerID`, `TotalPrice`, `Status`, `OrderAddress`, `OrderTime`, `OrderDeliverTime`) VALUES
(209, 157, 16, 'Delivered', 'Samsun', '2018-12-27 23:00:10', '2018-12-28 01:20:04'),
(210, 157, 14, 'Rejected', 'Samsun', '2018-12-27 23:42:52', NULL),
(211, 157, 58, 'Received', 'Samsun', '2018-12-28 00:07:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `IngID` int(11) NOT NULL COMMENT 'IngID',
  `IngName` varchar(255) NOT NULL COMMENT 'IngName',
  `IngPrice` int(11) NOT NULL COMMENT 'IngPrice'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ingredients ';

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`IngID`, `IngName`, `IngPrice`) VALUES
(8, 'Cheese', 4),
(9, 'Tomato', 2),
(10, 'Pepper', 3),
(11, 'Onion', 3),
(12, 'Rocca', 3),
(13, 'BlackOlive', 4),
(14, 'GreenOlive', 4),
(15, 'Sausage', 2),
(16, 'Mushroom', 4),
(17, 'Shrimp', 3);

-- --------------------------------------------------------

--
-- Table structure for table `nonpizza`
--

CREATE TABLE `nonpizza` (
  `nonID` int(11) NOT NULL COMMENT 'nonpizza product ID',
  `nonPrice` int(11) NOT NULL COMMENT 'nonpizza product Price',
  `nonName` varchar(255) NOT NULL COMMENT 'nonpizza Product Name',
  `nonCategory` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='NonPizza ';

--
-- Dumping data for table `nonpizza`
--

INSERT INTO `nonpizza` (`nonID`, `nonPrice`, `nonName`, `nonCategory`) VALUES
(50, 2, 'Cola', 'Drinks'),
(51, 3, 'Automn Salad', 'Salad'),
(53, 1, 'Water', 'Drinks'),
(54, 1, 'Chips', 'Other'),
(55, 3, 'Su', 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `ordernonpizza`
--

CREATE TABLE `ordernonpizza` (
  `OrderNonPizzaID` int(11) NOT NULL COMMENT 'OrderNonPizzaID',
  `OrderID` int(11) NOT NULL COMMENT 'OrderID to these nonpizza product belong to',
  `nonID` int(11) NOT NULL COMMENT 'nonpizza productID',
  `amount` int(11) NOT NULL COMMENT 'nonpizza product amount'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='OrderNonPizza ';

--
-- Dumping data for table `ordernonpizza`
--

INSERT INTO `ordernonpizza` (`OrderNonPizzaID`, `OrderID`, `nonID`, `amount`) VALUES
(1, 209, 51, 1),
(2, 211, 50, 1),
(3, 211, 53, 1),
(4, 211, 55, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL COMMENT 'PaymentID',
  `OrderID` int(11) NOT NULL COMMENT 'OrderID for this pyment',
  `CustomerID` int(11) NOT NULL COMMENT 'CustomerID for the customer has done this pyment',
  `PaymentType` varchar(255) NOT NULL COMMENT 'PaymentType (pay at the door POS or pay cash )'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Payment  Info';

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PaymentID`, `OrderID`, `CustomerID`, `PaymentType`) VALUES
(108, 209, 157, 'Cash'),
(109, 210, 157, 'Cash'),
(110, 211, 157, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `pizza`
--

CREATE TABLE `pizza` (
  `PizzaID` int(11) NOT NULL COMMENT 'PizzaID',
  `OrderID` int(11) NOT NULL COMMENT 'this pizza which order belong to',
  `Price` int(11) NOT NULL COMMENT 'it will be calculated from pizza ingredients',
  `Amount` int(3) NOT NULL COMMENT 'number of these pizzas',
  `PizzaSize` varchar(255) NOT NULL COMMENT 'XL, L, M, S',
  `PizzaDough` varchar(255) NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pizza ';

--
-- Dumping data for table `pizza`
--

INSERT INTO `pizza` (`PizzaID`, `OrderID`, `Price`, `Amount`, `PizzaSize`, `PizzaDough`) VALUES
(235, 209, 13, 1, 'small', 'normal'),
(236, 210, 14, 1, 'medium', 'thin'),
(237, 211, 8, 1, 'small', 'normal'),
(238, 211, 15, 1, 'small', 'normal'),
(239, 211, 29, 1, 'small', 'normal');

-- --------------------------------------------------------

--
-- Table structure for table `pizzaingredients`
--

CREATE TABLE `pizzaingredients` (
  `PizzaIngredientID` int(11) NOT NULL COMMENT 'PizzaIngredientID',
  `PizzaID` int(11) NOT NULL COMMENT 'PizzaID these ingredint belong to',
  `IngID` int(11) NOT NULL COMMENT 'IngID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='PizzaIngredients ';

--
-- Dumping data for table `pizzaingredients`
--

INSERT INTO `pizzaingredients` (`PizzaIngredientID`, `PizzaID`, `IngID`) VALUES
(583, 235, 8),
(584, 235, 9),
(585, 235, 10),
(586, 236, 9),
(587, 236, 14),
(588, 237, 14),
(589, 238, 9),
(590, 238, 10),
(591, 238, 14),
(592, 238, 15),
(593, 239, 9),
(594, 239, 10),
(595, 239, 11),
(596, 239, 12),
(597, 239, 13),
(598, 239, 14),
(599, 239, 15),
(600, 239, 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `fullorder`
--
ALTER TABLE `fullorder`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `fullorder_ibfk_1` (`CustomerID`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`IngID`);

--
-- Indexes for table `nonpizza`
--
ALTER TABLE `nonpizza`
  ADD PRIMARY KEY (`nonID`);

--
-- Indexes for table `ordernonpizza`
--
ALTER TABLE `ordernonpizza`
  ADD PRIMARY KEY (`OrderNonPizzaID`),
  ADD KEY `nonpizzaorderr_ibfk_1` (`OrderID`),
  ADD KEY `nonpizzaorderr_ibfk_2` (`nonID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `payment_ibfk_1` (`CustomerID`),
  ADD KEY `paymentr_ibfk_2` (`OrderID`);

--
-- Indexes for table `pizza`
--
ALTER TABLE `pizza`
  ADD PRIMARY KEY (`PizzaID`),
  ADD KEY `pizzar_ibfk_1` (`OrderID`);

--
-- Indexes for table `pizzaingredients`
--
ALTER TABLE `pizzaingredients`
  ADD PRIMARY KEY (`PizzaIngredientID`),
  ADD KEY `pizzaring_ibfk_1` (`IngID`),
  ADD KEY `pizzarid_ibfk_1` (`PizzaID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'EmpID', AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'CustomerID', AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `fullorder`
--
ALTER TABLE `fullorder`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'OrderID ', AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `IngID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IngID', AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `nonpizza`
--
ALTER TABLE `nonpizza`
  MODIFY `nonID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'nonpizza product ID', AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `ordernonpizza`
--
ALTER TABLE `ordernonpizza`
  MODIFY `OrderNonPizzaID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'OrderNonPizzaID', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PaymentID', AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `pizza`
--
ALTER TABLE `pizza`
  MODIFY `PizzaID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PizzaID', AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `pizzaingredients`
--
ALTER TABLE `pizzaingredients`
  MODIFY `PizzaIngredientID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PizzaIngredientID', AUTO_INCREMENT=601;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fullorder`
--
ALTER TABLE `fullorder`
  ADD CONSTRAINT `fullorder_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ordernonpizza`
--
ALTER TABLE `ordernonpizza`
  ADD CONSTRAINT `nonpizzaorderr_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `fullorder` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nonpizzaorderr_ibfk_2` FOREIGN KEY (`nonID`) REFERENCES `nonpizza` (`nonID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paymentr_ibfk_2` FOREIGN KEY (`OrderID`) REFERENCES `fullorder` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pizza`
--
ALTER TABLE `pizza`
  ADD CONSTRAINT `pizzar_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `fullorder` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pizzaingredients`
--
ALTER TABLE `pizzaingredients`
  ADD CONSTRAINT `pizzarid_ibfk_1` FOREIGN KEY (`PizzaID`) REFERENCES `pizza` (`PizzaID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pizzaring_ibfk_1` FOREIGN KEY (`IngID`) REFERENCES `ingredients` (`IngID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
