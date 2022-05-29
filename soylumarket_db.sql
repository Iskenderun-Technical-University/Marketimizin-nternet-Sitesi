-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2022 at 10:08 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soylumarket_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `name`, `image`, `link`, `type`) VALUES
(1, 'slide kampanya 1', '1.jpg', NULL, 1),
(2, 'slide kampanya 2', '2.jpg', NULL, 1),
(3, 'slide kampanya 3', '3.jpg', '/soylumarket', 1),
(4, 'alt kısım kampanya 1', '5d5c0253dea79c47329d6388c8fb61b7.jpg', NULL, 2),
(5, 'alt kısım kampanya 2', '54ec4b63f5d4dc492aaee574c60360ff.jpg', NULL, 2),
(6, 'alt kısım kampanya 3', '110be12e28977266e87d5d51ef9b737c.jpg', NULL, 2),
(8, 'alt kısım kampanya 4', 'ee121eb4e09bbb8949249a0cee66a29e.jpg', '/soylumarket', 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `description` text COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Su ve İçecek', ''),
(2, 'Bakliyat', ''),
(3, 'Atıştırmalık', ''),
(4, 'Kişisel Bakım', ''),
(6, 'Et', 'Kırmızı et, balık, beyaz et');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `description` text COLLATE utf8mb4_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `price`, `image`, `description`) VALUES
(1, 4, '3lt Yağ', 99, '04110117-b0e31e.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat a nam quas culpa quam temporibus facilis alias, officia ducimus vel dolore placeat. Iusto natus veniam dolorem. Laudantium, dolorum eaque. Obcaecati.'),
(2, 4, 'Çikolata', 10, '07038906-1b0f89.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat a nam quas culpa quam temporibus facilis alias, officia ducimus vel dolore placeat. Iusto natus veniam dolorem. Laudantium, dolorum eaque. Obcaecati.'),
(3, 4, 'Yoğurt', 20, '12509378-caf701.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat a nam quas culpa quam temporibus facilis alias, officia ducimus vel dolore placeat. Iusto natus veniam dolorem. Laudantium, dolorum eaque. Obcaecati.'),
(4, 6, 'Ton Balığı', 50, '09035810-03fb20.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat a nam quas culpa quam temporibus facilis alias, officia ducimus vel dolore placeat. Iusto natus veniam dolorem. Laudantium, dolorum eaque. Obcaecati.'),
(5, 3, 'Bisküvi', 20, '07013840-46eda8.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat a nam quas culpa quam temporibus facilis alias, officia ducimus vel dolore placeat. Iusto natus veniam dolorem. Laudantium, dolorum eaque. Obcaecati.'),
(6, 6, 'Sucuk', 122, '14209433-7957ed.jpg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat a nam quas culpa quam temporibus facilis alias, officia ducimus vel dolore placeat. Iusto natus veniam dolorem. Laudantium, dolorum eaque. Obcaecati.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'burak', '1123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
