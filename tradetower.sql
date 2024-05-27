-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 03:53 PM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `joinedOrdersAndProducts` (IN `customer_id` INT)   BEGIN
    SELECT 
    	p.name,
        p.price,
        o.quantity, 
        o.Subtotal
    FROM 
        orders o
    INNER JOIN 
        products p 
    ON 
        o.product_id = p.product_id
    WHERE 
        o.customer_id = customer_id;
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
(9, 'asd', 'asd@asd.asd', 'asd', '$2y$10$EXUuONs5pmBaLInepxuH3ORXImOegRB8CZfB9I9GZP1IUTxQAn60W'),
(10, 'asds', 'asd@asd.asd', 'asd', '$2y$10$EXUuONs5pmBaLInepxuH3ORXImOegRB8CZfB9I9GZP1IUTxQAn60W'),
(11, 'Zoren', 'drzors@gmail.com', 'Zoren', '$2y$10$wHsEy2bHDTJT3Ow0v871HO9nPw/j22xIIg1rkOgdr5OvDQFDlLxLe'),
(12, 'asd', 'Drzoren@gmail.com', 'asd', '$2y$10$IYz/Qf52m1ocdue5q5qgCeqFs.AzjH4pMejBt2480yDbBCoU.5Isi');

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
(50, 9, 1, 9, 29.00),
(51, 9, 2, 10, 468.00),
(52, 11, 2, 9, 58.00),
(53, 11, 1, 9, 29.00),
(54, 11, 1, 10, 234.00),
(55, 11, 1, 11, 222.00),
(56, 10, 3, 9, 87.00),
(57, 10, 1, 9, 29.00),
(58, 10, 2, 9, 58.00),
(59, 12, 1, 9, 29.00),
(60, 12, 1, 9, 29.00);

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
(9, 'popberry pie', 'yum yum', 103, 29.00),
(10, 'scarrot wine', 'dizzyy', 119, 234.00),
(11, 'popberry', 'berry', 117, 222.00);

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
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `idx_description` (`description`(768)),
  ADD KEY `idx_quantity` (`quantity`),
  ADD KEY `idx_price` (`price`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
