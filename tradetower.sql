-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 04:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tradetower`
--
CREATE DATABASE IF NOT EXISTS `tradetower` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tradetower`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addProducts` (IN `name` VARCHAR(255), IN `description` VARCHAR(255), IN `quantity` INT, IN `price` DECIMAL(10,2))   BEGIN
  INSERT INTO products (`name`, `description`, `quantity`, `price`) VALUES (name, description, quantity, price);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `removeProducts` (IN `itemID` INT)   BEGIN
    DELETE FROM products WHERE product_id = itemID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `totalPrice` ()   BEGIN
    SELECT SUM(quantity * price) as total FROM products;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `totalQuantity` ()   BEGIN
    SELECT SUM(quantity) AS TotalQuantity
    FROM products;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateProducts` (IN `p_product_id` INT, IN `p_name` VARCHAR(255), IN `p_description` TEXT, IN `p_quantity` INT, IN `p_price` DECIMAL(10,2))   BEGIN
    UPDATE products
    SET
        name = p_name,
        description = p_description,
        quantity = p_quantity,
        price = p_price
    WHERE
        product_id = p_product_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `username`, `password`) VALUES
(8, 'asd', 'asd@asd.asd', 'asd', '$2y$10$EXUuONs5pmBaLInepxuH3ORXImOegRB8CZfB9I9GZP1IUTxQAn60W'),
(9, 'asd', 'asd@asd.asd', 'asd', '$2y$10$EXUuONs5pmBaLInepxuH3ORXImOegRB8CZfB9I9GZP1IUTxQAn60W');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `Subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `customer_id`, `quantity`, `product_id`, `Subtotal`) VALUES
(44, 9, 1, 9, 0.00),
(45, 9, 1, 10, 0.00),
(46, 9, 1, 11, 0.00),
(47, 9, 3, 9, 87.00),
(48, 9, 1, 9, 29.00);

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `calculateSubtotal` BEFORE INSERT ON `orders` FOR EACH ROW BEGIN
  DECLARE product_price DECIMAL(10, 2);
  -- Get the price of the product
  SELECT price INTO product_price FROM products WHERE product_id = NEW.product_id;
  -- Calculate the Subtotal
  SET NEW.Subtotal = NEW.quantity * product_price;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `quantity`, `price`) VALUES
(9, 'popberry pie', 'yum', 118, 29.00),
(10, 'scarrot wine', 'dizzyy', 122, 234.00),
(11, 'popberry', 'fruit', 118, 222.00);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `orders_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewproducts`
-- (See below for the actual view)
--
CREATE TABLE `viewproducts` (
`product_id` int(11)
,`name` varchar(255)
,`description` text
,`quantity` int(11)
,`price` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Structure for view `viewproducts`
--
DROP TABLE IF EXISTS `viewproducts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewproducts`  AS SELECT `products`.`product_id` AS `product_id`, `products`.`name` AS `name`, `products`.`description` AS `description`, `products`.`quantity` AS `quantity`, `products`.`price` AS `price` FROM `products` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `orders_id` (`orders_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`orders_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
