-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2021 at 03:09 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `bad_orders`
--

CREATE TABLE `bad_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batchId` bigint(20) UNSIGNED NOT NULL,
  `deducted` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `type`, `amount`, `created_at`, `updated_at`) VALUES
(6, 'Utilities', 200, '2021-07-15 07:48:45', '2021-07-15 07:48:45'),
(7, 'Rent', 500, '2021-07-15 07:48:45', '2021-07-15 07:48:45'),
(8, 'Others', 100, '2021-07-15 07:48:45', '2021-07-15 07:48:45'),
(9, 'Rent', 1000, '2021-08-27 00:21:35', '2021-08-27 00:21:35'),
(10, 'Utilities', 500, '2021-08-27 00:21:35', '2021-08-27 00:21:35');

-- --------------------------------------------------------

--
-- Table structure for table `item_batches`
--

CREATE TABLE `item_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batchNum` int(11) NOT NULL,
  `stockId` bigint(20) UNSIGNED NOT NULL,
  `productId` bigint(20) UNSIGNED NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_batches`
--

INSERT INTO `item_batches` (`id`, `batchNum`, `stockId`, `productId`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(12, 1, 11, 8, 8, 13, '2021-07-15 07:22:05', '2021-07-16 06:16:44'),
(14, 2, 13, 8, 8.75, 10, '2021-07-15 07:29:13', '2021-07-15 07:29:13'),
(19, 3, 18, 8, 7.25, 5, '2021-07-15 07:46:45', '2021-07-15 07:46:45'),
(20, 1, 19, 10, 63.5, 4, '2021-07-15 07:46:45', '2021-07-15 07:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `description`, `created_at`, `updated_at`) VALUES
(11, 'Login at Thursday 15th of July 2021 03:03:36 PM', '2021-07-15 07:03:36', '2021-07-15 07:03:36'),
(12, 'Login at Thursday 15th of July 2021 03:05:33 PM', '2021-07-15 07:05:33', '2021-07-15 07:05:33'),
(13, 'Login at Thursday 15th of July 2021 03:13:32 PM', '2021-07-15 07:13:32', '2021-07-15 07:13:32'),
(14, '327430976239643 stocks has been removed at Thursday 15th of July 2021 03:31:59 PM', '2021-07-15 07:31:59', '2021-07-15 07:31:59'),
(15, '8496624487039574391 stocks has been removed at Thursday 15th of July 2021 03:36:02 PM', '2021-07-15 07:36:02', '2021-07-15 07:36:02'),
(16, '58932125891237659 stocks has been removed at Thursday 15th of July 2021 03:43:47 PM', '2021-07-15 07:43:47', '2021-07-15 07:43:47'),
(17, '8587567348572390634 stocks has been removed at Thursday 15th of July 2021 03:43:49 PM', '2021-07-15 07:43:49', '2021-07-15 07:43:49'),
(18, 'Login at Thursday 15th of July 2021 03:49:37 PM', '2021-07-15 07:49:37', '2021-07-15 07:49:37'),
(19, 'Login at Thursday 15th of July 2021 04:33:54 PM', '2021-07-15 08:33:54', '2021-07-15 08:33:54'),
(20, 'Login at Friday 16th of July 2021 08:48:42 AM', '2021-07-16 00:48:42', '2021-07-16 00:48:42'),
(21, 'Login at Friday 16th of July 2021 02:12:33 PM', '2021-07-16 06:12:33', '2021-07-16 06:12:33'),
(22, 'Login at Friday 16th of July 2021 02:20:18 PM', '2021-07-16 06:20:18', '2021-07-16 06:20:18'),
(23, 'Login at Friday 16th of July 2021 02:24:39 PM', '2021-07-16 06:24:39', '2021-07-16 06:24:39'),
(24, 'Login at Friday 16th of July 2021 02:31:51 PM', '2021-07-16 06:31:52', '2021-07-16 06:31:52'),
(25, 'Login at Friday 16th of July 2021 02:32:21 PM', '2021-07-16 06:32:21', '2021-07-16 06:32:21'),
(26, 'Login at Friday 16th of July 2021 02:35:11 PM', '2021-07-16 06:35:11', '2021-07-16 06:35:11'),
(27, 'Login at Friday 16th of July 2021 02:45:06 PM', '2021-07-16 06:45:06', '2021-07-16 06:45:06'),
(28, 'Login at Friday 16th of July 2021 02:54:44 PM', '2021-07-16 06:54:44', '2021-07-16 06:54:44'),
(29, 'Login at Friday 27th of August 2021 08:04:40 AM', '2021-08-27 00:04:40', '2021-08-27 00:04:40'),
(30, 'Login at Friday 27th of August 2021 08:41:12 AM', '2021-08-27 00:41:12', '2021-08-27 00:41:12'),
(31, 'Login at Friday 27th of August 2021 10:00:34 AM', '2021-08-27 02:00:34', '2021-08-27 02:00:34'),
(32, 'Login at Friday 27th of August 2021 01:02:56 PM', '2021-08-27 05:02:56', '2021-08-27 05:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `printers`
--

CREATE TABLE `printers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `netWeight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` double NOT NULL,
  `threshold` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `barcode`, `netWeight`, `discount`, `threshold`, `category`, `created_at`, `updated_at`) VALUES
(8, 'Marty\'s Crackling', '4800194152884', '26g', 0, 0, 'junk food', '2021-07-15 07:22:05', '2021-07-15 07:22:05'),
(10, 'Bingo Double Choco 10pcs', '4807770101557', '280g', 0, 0, 'biscuit', '2021-07-15 07:46:45', '2021-07-15 07:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `pin` varchar(255) NOT NULL,
  `tries` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `pin`, `tries`, `status`, `created_at`, `updated_at`) VALUES
(1, 'hanna ', '$2y$10$wGuiRV4jbH.Q2ZIuh2T.1eAhpV2yvT2evLpq2/uIlD56kxIfMd7da', 0, 'unlocked', '2020-09-23 15:45:16', '2021-07-16 07:12:59'),
(2, 'mark', '$2y$10$FtAZ4G7UwwFxShDbiLeCTuEgTLW3bdEewQ.9l/LK4TGcmCR4MdtQu', 0, 'unlocked', '2021-07-07 06:18:06', '2021-07-16 06:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `orderId` varchar(255) NOT NULL,
  `cashierName` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `vat` double NOT NULL,
  `benefits` double NOT NULL,
  `discounts` double NOT NULL,
  `customerName` varchar(255) NOT NULL,
  `cash` double NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `orderId`, `cashierName`, `name`, `price`, `quantity`, `vat`, `benefits`, `discounts`, `customerName`, `cash`, `type`, `status`, `created_at`, `updated_at`) VALUES
(24, '202107150', 'mark', 'Mrty\'s Crcklng', 8.75, 3, 0.12, 0, 0, 'dave', 100, 'storecredit', 'unpaid', '2021-07-15 07:49:24', '2021-07-15 07:49:24'),
(25, '202107150', 'mark', 'Bng Dbl Chc 10pcs', 63.5, 1, 0.12, 0, 0, 'dave', 100, 'storecredit', 'unpaid', '2021-07-15 07:49:24', '2021-07-15 07:49:24'),
(26, '202107152', 'hanna ', 'Mrty\'s Crcklng', 8.75, 1, 0.12, 0, 0, 'dave', 8.75, 'storecredit', 'unpaid', '2021-07-15 08:33:15', '2021-07-15 08:33:15'),
(27, '202107160', 'mark', 'Mrty\'s Crcklng', 8.75, 3, 0.12, 0, 0, '', 50, 'cash', '', '2021-07-16 06:16:44', '2021-07-16 06:16:44');

-- --------------------------------------------------------

--
-- Table structure for table `stock_logs`
--

CREATE TABLE `stock_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siorNo` varchar(255) DEFAULT NULL,
  `supplierName` varchar(255) DEFAULT NULL,
  `productId` bigint(20) UNSIGNED NOT NULL,
  `cost` double NOT NULL,
  `newAdded` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_logs`
--

INSERT INTO `stock_logs` (`id`, `siorNo`, `supplierName`, `productId`, `cost`, `newAdded`, `created_at`, `updated_at`) VALUES
(11, '7540997415358989', 'Bluebasketph', 8, 5.75, 20, '2021-07-15 07:22:05', '2021-07-15 07:22:05'),
(13, '8672951684249231', 'Bluebasketph', 8, 6, 10, '2021-07-15 07:29:13', '2021-07-15 07:29:13'),
(18, '984675452370345', 'Bluebasketph', 8, 5.6, 5, '2021-07-15 07:46:45', '2021-07-15 07:46:45'),
(19, '984675452370345', 'Bluebasketph', 10, 54.65, 5, '2021-07-15 07:46:45', '2021-07-15 07:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tax` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `tax`, `created_at`, `updated_at`) VALUES
(1, 0.12, '2020-10-19 18:46:02', '2021-07-06 08:53:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `created_at`, `updated_at`) VALUES
(1, '$2y$10$a.3YQYZ8fNfhP1/3qQKFwOTraPzngLVsY6wpv705Uj51Ztj9qpRJa', '2020-07-02 17:45:31', '2021-07-07 08:53:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bad_orders`
--
ALTER TABLE `bad_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batchId` (`batchId`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_batches`
--
ALTER TABLE `item_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productId` (`productId`),
  ADD KEY `stockId` (`stockId`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `printers`
--
ALTER TABLE `printers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_logs`
--
ALTER TABLE `stock_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`productId`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
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
-- AUTO_INCREMENT for table `bad_orders`
--
ALTER TABLE `bad_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item_batches`
--
ALTER TABLE `item_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `printers`
--
ALTER TABLE `printers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `stock_logs`
--
ALTER TABLE `stock_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bad_orders`
--
ALTER TABLE `bad_orders`
  ADD CONSTRAINT `bad_orders_ibfk_1` FOREIGN KEY (`batchId`) REFERENCES `item_batches` (`id`);

--
-- Constraints for table `item_batches`
--
ALTER TABLE `item_batches`
  ADD CONSTRAINT `item_batches_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `item_batches_ibfk_2` FOREIGN KEY (`stockId`) REFERENCES `stock_logs` (`id`);

--
-- Constraints for table `stock_logs`
--
ALTER TABLE `stock_logs`
  ADD CONSTRAINT `stock_logs_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
