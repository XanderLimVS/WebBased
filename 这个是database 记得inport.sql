-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 07:42 AM
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
-- Database: `web ass`
--
--
CREATE DATABASE IF NOT EXISTS `web ass` DEFAULT CHARACTER SET utf8mb4 COLLATE=utf8mb4_general_ci;
USE `web ass`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `cover_image`, `description`) VALUES
(1, 'Kawaii Friends', 'picture/Kawaii/Kitty Kawaii.png', NULL),
(2, 'Mecha Guardians Series', 'picture/Mech/Ice Bear.png', NULL),
(3, 'Dino Pals Adventure', 'picture/Dino/Triceratops.png', NULL),
(4, 'Mythic Beasts Crate', 'picture/Mythic Beast/Eagle.png', NULL),
(5, 'Artist Editions', 'picture/Artist/Art.png', NULL),
(6, 'Galactic Explorers', 'picture/Galaxy/Astronaut.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `stock` int(11) DEFAULT 10,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `price`, `image_url`, `stock`) VALUES
(1, 1, 'Kawaii Friends - Green Panda', 49.99, 'picture/Kawaii/Green Panda Kawaii.png', 20),
(2, 1, 'Kawaii Friends - Kitty', 49.99, 'picture/Kawaii/Kitty Kawaii.png', 20),
(3, 1, 'Kawaii Friends - Koala', 49.99, 'picture/Kawaii/Koala Kawaii.png', 20),
(4, 1, 'Kawaii Friends - Panda', 49.99, 'picture/Kawaii/Panda Kawaii.png', 20),
(5, 1, 'Kawaii Friends - Penguins', 49.99, 'picture/Kawaii/Penguins Kawaii.png', 20),
(6, 1, 'Kawaii Friends - Red Panda', 49.99, 'picture/Kawaii/Red Panda Kawaii.png', 5),
(7, 2, 'Mecha Guardians - Eagle Warriors', 49.99, 'picture/Mech/Eagle Warriors.png', 20),
(8, 2, 'Mecha Guardians - Green Terminator', 49.99, 'picture/Mech/Green Terminator.png', 20),
(9, 2, 'Mecha Guardians - Grey Robot', 49.99, 'picture/Mech/Grey Robot.png', 20),
(10, 2, 'Mecha Guardians - Ice Bear', 49.99, 'picture/Mech/Ice Bear.png', 20),
(11, 2, 'Mecha Guardians - Red Samurai', 49.99, 'picture/Mech/Red Samurai.png', 20),
(12, 2, 'Mecha Guardians - Grass Dragon', 49.99, 'picture/Mech/Grass Dragon.png', 5),
(13, 3, 'Dino Pals - Allosaurus', 49.99, 'picture/Dino/Allosaurus.png', 20),
(14, 3, 'Dino Pals - Carnotaurus', 49.99, 'picture/Dino/Carnotaurus.png', 20),
(15, 3, 'Dino Pals - Spinosaurus', 49.99, 'picture/Dino/Spinosaurus.png', 20),
(16, 3, 'Dino Pals - Triceratops', 49.99, 'picture/Dino/Triceratops.png', 20),
(17, 3, 'Dino Pals - Velociraptor', 49.99, 'picture/Dino/Velociraptor.png', 20),
(18, 3, 'Dino Pals - T-Rex', 49.99, 'picture/Dino/T-Rex.png', 5),
(19, 4, 'Mythic Beasts - Eagle', 49.99, 'picture/Mythic Beast/Eagle.png', 20),
(20, 4, 'Mythic Beasts - Ice Eagle', 49.99, 'picture/Mythic Beast/Ice Eagle.png', 20),
(21, 4, 'Mythic Beasts - Phenix', 49.99, 'picture/Mythic Beast/Phenix.png', 20),
(22, 4, 'Mythic Beasts - Rianbow Dragom', 49.99, 'picture/Mythic Beast/Rianbow Dragom.png', 20),
(23, 4, 'Mythic Beasts - Unicorn', 49.99, 'picture/Mythic Beast/Unicorn.png', 20),
(24, 4, 'Mythic Beasts - Dark Dragon ', 49.99, 'picture/Mythic Beast/Dark Dragon.png', 5),
(25, 5, 'Artist Editions - Art', 49.99, 'picture/Artist/Art.png', 20),
(26, 5, 'Artist Editions - Colorful', 49.99, 'picture/Artist/Colorful.png', 20),
(27, 5, 'Artist Editions - Core', 49.99, 'picture/Artist/Core.png', 20),
(28, 5, 'Artist Editions - Haidan', 49.99, 'picture/Artist/Haidan.png', 20),
(29, 5, 'Artist Editions - Star', 49.99, 'picture/Artist/Star.png', 20),
(30, 5, 'Artist Editions - Undefine', 49.99, 'picture/Artist/Undefine.png', 5),
(31, 6, 'Galactic Explorers - Astronaut', 49.99, 'picture/Galaxy/Astronaut.png', 20),
(32, 6, 'Galactic Explorers - Big Galaxy', 49.99, 'picture/Galaxy/Big Galaxy.png', 20),
(33, 6, 'Galactic Explorers - Galaxy', 49.99, 'picture/Galaxy/Galaxy.png', 20),
(34, 6, 'Galactic Explorers - Galaxy Robot', 49.99, 'picture/Galaxy/Galaxy Robot.png', 20),
(35, 6, 'Galactic Explorers - Robot', 49.99, 'picture/Galaxy/Robot.png', 20),
(36, 6, 'Galactic Explorers - Galaxy Spirit', 49.99, 'picture/Galaxy/Galaxy Spirit.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL ,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `user_status` enum('active','inactive','banned') DEFAULT 'active',
  `user_type` enum('admin','customer') DEFAULT 'customer',
  `coins` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `password`, `phone`, `address`, `user_status`, `user_type`, `coins`) VALUES
(1, 'LiangWey', 'OngLiangWey', 'liangwey@example.com', '123456', '012-3456789', '123, Jalan Bukit Bintang, 55100 Kuala Lumpur, Malaysia', 'active', 'customer', 100),
(2, 'WeiMing', 'KokWeiMing', 'weiming@example.com', '123456', '011-3456789', '3, Jalan Bukit Jalil, 55100 Kuala Lumpur, Malaysia', 'active', 'customer', 50);

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `Cart_Item_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Cart_Item_ID`),
  KEY `User_ID` (`User_ID`),
  KEY `Product_ID` (`Product_ID`),
  CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status` enum('pending','paid','shipped','completed','cancelled') DEFAULT 'pending',
  `total_payable` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('credit_card','e_wallet','online_banking') NOT NULL,
  `payment_status` enum('pending','successful','failed') DEFAULT 'pending',
  `payment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coin_item`
--

CREATE TABLE `coin_item` (
  `coin_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `coin` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`coin_item_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `coin_item_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;