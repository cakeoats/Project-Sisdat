-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2022 at 10:14 PM
-- Server version: 10.3.34-MariaDB-log-cll-lve
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miamoemy_uang`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('debit','kredit') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `user_id`, `name`, `type`) VALUES
(1, 'akmal', 'Makanan', 'kredit'),
(2, 'akmal', 'gajian 2', 'debit'),
(3, 'margo', 'Makanan', 'kredit'),
(4, 'akmlazry', 'Makan', 'kredit'),
(5, 'akmlazry', 'Top Up', 'kredit'),
(6, 'shfiradifa', 'Makan', 'kredit'),
(7, 'shfiradifa', 'Uang Jajan', 'debit'),
(8, 'shfiradifa', 'Hiburan', 'kredit'),
(9, 'shfiradifa', 'Transportasi', 'kredit'),
(10, 'shfiradifa', 'Sedekah', 'kredit'),
(11, 'kia', 'makan', 'kredit'),
(12, 'Dhifann', 'Makan', 'kredit'),
(13, 'fathy', 'bebas', 'debit'),
(14, 'fathy', 'bebas', 'kredit');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `wallet` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `note` varchar(255) NOT NULL,
  `type` enum('debit','kredit') NOT NULL,
  `category` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `wallet_id`, `wallet`, `amount`, `note`, `type`, `category`, `date`) VALUES
(1, 'akmal', 2, 'BCA', 15000, '', 'debit', 'gajian 2', '2022-05-11 18:30:52'),
(4, 'akmlazry', 9, 'GOPAY', 20000, 'Bayar Gocar', 'kredit', 'Top Up', '2022-05-12 13:13:55'),
(5, 'akmlazry', 7, 'CASH', 50000, 'Dinner', 'kredit', 'Makan', '2022-05-12 13:14:11'),
(6, 'shfiradifa', 8, 'SHAFIRA RAMADHINA ADIFA', 35000, 'Ice Cream', 'kredit', 'Makan', '2022-05-12 13:16:16'),
(7, 'akmal', 3, 'BNI', 15000, '', 'kredit', 'Makanan', '2022-05-12 13:17:00'),
(8, 'shfiradifa', 8, 'SHAFIRA RAMADHINA ADIFA', 100000, '', 'debit', 'Uang Jajan', '2022-05-12 13:18:06'),
(9, 'shfiradifa', 8, 'SHAFIRA RAMADHINA ADIFA', 50000, 'Nonton Dr. Strange', 'kredit', 'Hiburan', '2022-05-12 13:19:27'),
(10, 'shfiradifa', 8, 'SHAFIRA RAMADHINA ADIFA', 285000, 'Traktiran ultah', 'kredit', 'Hiburan', '2022-05-12 13:19:55'),
(11, 'shfiradifa', 8, 'ATM BCA', 16000, 'Gojek', 'kredit', 'Transportasi', '2022-05-12 13:43:04'),
(12, 'shfiradifa', 8, 'ATM BCA', 700000, '', 'kredit', 'Sedekah', '2022-05-12 13:46:06'),
(13, 'shfiradifa', 8, 'ATM BCA', 30000, 'THR', 'debit', 'Uang Jajan', '2022-05-12 13:46:47'),
(14, 'shfiradifa', 8, 'ATM BCA', 50000, 'Shopee COD', 'kredit', 'Hiburan', '2022-05-12 13:47:16'),
(15, 'kia', 10, 'bca', 50000, 'gofut', 'kredit', 'makan', '2022-05-12 15:42:35'),
(16, 'Dhifann', 11, 'CASH', 30000, '', 'kredit', 'Makan', '2022-05-12 17:34:33'),
(17, 'fathy', 12, 'bca', 20000, 'gojek', 'kredit', 'bebas', '2022-05-21 21:39:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'akmal', '$2y$10$PDgEyzGbyjobCtqwd6b7geUR55VEYclPCdrq5OIg11kGHZwEQ5Nq6', '2022-05-11'),
(2, 'margo', '$2y$10$/e/yMNCkYVXk.5odJmwmn.BcH.zAQa/RVwTl4BBPZ47hMnqAMLLgG', '2022-05-11'),
(3, 'akmlazry', '$2y$10$iGS2IVYtXoJPI.OagfqV0.bZ5BEjHol6wo7trNJuHF0h6Qqi6a3vG', '2022-05-12'),
(4, 'shfiradifa', '$2y$10$xYsEuDmyFFl/LOgRxK3z1uEh5vk43VbcQCzWsTrTCGt/GiV74E0Ri', '2022-05-12'),
(5, 'kia', '$2y$10$vTtDkf8Bh733UW.5hwDsueL.V7cEjXG6n5Mp8C5Zzi3vvfuZ1YyX6', '2022-05-12'),
(6, 'Dhifann', '$2y$10$HM9RY2RZ7FAyqaOWwINxiuOsZna8VXJQ9WXZ0Q7DKQ2PvLacJVhy2', '2022-05-12'),
(7, 'admin', '$2y$10$pCCr9U.iOsTyxS.0pGJGV.TvuzmJUoSQscyTScTqznlhgjKOpmWDe', '2022-05-18'),
(8, 'admin1', '$2y$10$NqpkmytRXYZDzjJ5R1AWkuO/DXO7UnURmbhk/tvIyLpKvVIphQNl2', '2022-05-18'),
(9, 'admin2', '$2y$10$W3OItIKNk.YL.aopo5FgB.S407mZkA6TJwXkiFsCDG.ygqyq7P2Pm', '2022-05-18'),
(10, 'admin3', '$2y$10$MTDor0DE42wPiAgkxkq8Z.fxoj2bs6g42lvZaGsXo06DIIADd4lge', '2022-05-18'),
(11, 'fathy', '$2y$10$jXxuzor1p.WcqLfTt.YvG.iUp2w3ue/WKDJ7OEEJzc0ZkqtqFxrfi', '2022-05-21');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `balance` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL,
  `created_at` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `name`, `balance`, `last_update`, `created_at`) VALUES
(2, 'akmal', 'BCA', '50000', '2022-05-11 16:16:33', '2022-05-11'),
(3, 'akmal', 'BNI', '50000', '2022-05-11 16:16:33', '2022-05-11'),
(4, 'akmal', 'BRI', '20000', '2022-05-11 16:16:33', '2022-05-11'),
(5, 'akmal', 'Cash', '0', '2022-05-11 18:02:03', '2022-05-11'),
(6, 'margo', 'GOPAY', '50000', '2022-05-11 18:11:43', '2022-05-11'),
(7, 'akmlazry', 'CASH', '100000', '2022-05-12 13:11:59', '2022-05-12'),
(8, 'shfiradifa', 'ATM BCA', '-6000', '2022-05-12 13:21:41', '2022-05-12'),
(9, 'akmlazry', 'GOPAY', '30000', '2022-05-12 13:13:32', '2022-05-12'),
(10, 'kia', 'bca', '950000', '2022-05-12 15:42:01', '2022-05-12'),
(11, 'Dhifann', 'CASH', '70000', '2022-05-12 17:33:43', '2022-05-12'),
(12, 'fathy', 'bca', '9980000', '2022-05-21 21:37:06', '2022-05-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
