-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:2025
-- Generation Time: Jul 21, 2025 at 03:15 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int NOT NULL,
  `event_name` varchar(200) NOT NULL,
  `description` text,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `venue` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_tickets` int NOT NULL,
  `available_tickets` int NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `description`, `event_date`, `event_time`, `venue`, `price`, `total_tickets`, `available_tickets`, `created_by`, `created_at`) VALUES
(1, 'Konser Musik Rock Indonesia', 'Konser musik rock terbesar di Indonesia dengan menghadirkan band-band legendaris seperti Slank, Padi, dan Sheila on 7. Acara ini akan menjadi momen bersejarah bagi pecinta musik rock tanah air.', '2025-08-15', '19:00:00', 'Gelora Bung Karno, Jakarta', 150000.00, 5000, 3199, 2, '2025-07-20 08:00:00'),
(2, 'Seminar Teknologi AI 2025', 'Seminar teknologi AI terdepan dengan pembicara dari Google, Microsoft, dan OpenAI. Diskusi tentang masa depan AI dan implementasinya dalam berbagai industri.', '2025-08-20', '09:00:00', 'Hotel Indonesia Kempinski, Jakarta', 250000.00, 300, 150, 3, '2025-07-20 08:30:00'),
(3, 'Workshop Digital Marketing', 'Workshop intensif digital marketing untuk UMKM. Belajar strategi marketing online, social media marketing, dan content creation yang efektif.', '2025-08-25', '13:00:00', 'Co-working Space Jakarta', 75000.00, 100, 45, 4, '2025-07-20 09:00:00'),
(4, 'Festival Kuliner Nusantara', 'Festival kuliner terbesar yang menampilkan makanan tradisional dari seluruh Indonesia. Ada lebih dari 100 stan makanan dan demo memasak.', '2025-09-05', '10:00:00', 'Taman Mini Indonesia Indah, Jakarta', 50000.00, 2000, 800, 2, '2025-07-20 09:30:00'),
(5, 'Konser Jazz Under The Stars', 'Konser jazz romantis di bawah bintang dengan pemandangan kota Jakarta. Menampilkan musisi jazz ternama Indonesia.', '2025-09-10', '20:00:00', 'Plaza Senayan, Jakarta', 200000.00, 800, 600, 3, '2025-07-20 10:00:00'),
(6, 'Expo Startup Indonesia', 'Pameran startup terbesar di Indonesia. Tempat networking, pitching, dan investasi untuk startup lokal.', '2025-09-15', '08:00:00', 'Jakarta Convention Center', 100000.00, 1500, 1200, 4, '2025-07-20 10:30:00'),
(7, 'Gema Festival', 'Konser musik dengan beberapa guest star terkenal.', '2025-09-20', '07:00:00', 'Stadion Kridosono, Yogyakarta', 50000.00, 50, 30, 2, '2025-07-20 11:00:00'),
(8, 'Webinar Investasi Saham', 'Webinar tentang investasi saham untuk pemula. Belajar dasar-dasar investasi dan strategi trading yang aman.', '2025-09-25', '19:00:00', 'Online via Zoom', 100000.00, 500, 400, 3, '2025-07-20 11:30:00'),
(9, 'Pameran Seni Kontemporer', 'Pameran seni kontemporer dengan karya-karya seniman muda Indonesia. Acara ini mendukung perkembangan seni lokal.', '2025-10-05', '10:00:00', 'Galeri Nasional Indonesia', 75000.00, 300, 200, 4, '2025-07-20 12:00:00'),
(10, 'Konser Pop Indonesia', 'Konser musik pop dengan lineup artis-artis populer Indonesia. Acara musik yang tidak boleh dilewatkan.', '2025-10-10', '19:30:00', 'ICE BSD, Tangerang', 180000.00, 3000, 2500, 2, '2025-07-20 12:30:00'),
(11, 'JKT48 Special Concert FULL HOUSE', 'JKT48 Special Concert FULL HOUSE', '2025-07-26', '19:00:00', 'Istora Senayan, Jakarta Pusat', 450000.00, 2500, 2499, 2, '2025-07-20 08:21:48');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'event_organizer'),
(3, 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int NOT NULL,
  `event_id` int NOT NULL,
  `user_id` int NOT NULL,
  `quantity` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `purchase_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','paid','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `event_id`, `user_id`, `quantity`, `total_price`, `purchase_date`, `status`) VALUES
(1, 1, 5, 2, 300000.00, '2025-07-20 13:00:00', 'paid'),
(2, 1, 6, 1, 150000.00, '2025-07-20 13:15:00', 'paid'),
(3, 2, 7, 1, 250000.00, '2025-07-20 13:30:00', 'paid'),
(4, 3, 8, 2, 150000.00, '2025-07-20 14:00:00', 'paid'),
(5, 4, 9, 3, 150000.00, '2025-07-20 14:15:00', 'paid'),
(6, 5, 10, 1, 200000.00, '2025-07-20 14:30:00', 'paid'),
(7, 6, 5, 1, 100000.00, '2025-07-20 15:00:00', 'paid'),
(8, 7, 6, 1, 50000.00, '2025-07-20 15:15:00', 'paid'),
(9, 8, 7, 1, 100000.00, '2025-07-20 15:30:00', 'pending'),
(10, 9, 8, 2, 150000.00, '2025-07-20 16:00:00', 'paid'),
(11, 10, 9, 1, 180000.00, '2025-07-20 16:15:00', 'paid'),
(12, 1, 10, 3, 450000.00, '2025-07-20 16:30:00', 'paid'),
(13, 2, 5, 1, 250000.00, '2025-07-20 17:00:00', 'cancelled'),
(14, 3, 6, 1, 75000.00, '2025-07-20 17:15:00', 'paid'),
(15, 4, 7, 2, 100000.00, '2025-07-20 17:30:00', 'paid'),
(16, 5, 8, 1, 200000.00, '2025-07-20 18:00:00', 'pending'),
(17, 6, 9, 1, 100000.00, '2025-07-20 18:15:00', 'paid'),
(18, 7, 10, 1, 50000.00, '2025-07-20 18:30:00', 'paid'),
(19, 8, 5, 2, 200000.00, '2025-07-20 19:00:00', 'paid'),
(20, 9, 6, 1, 75000.00, '2025-07-20 19:15:00', 'paid'),
(21, 11, 5, 1, 450000.00, '2025-07-20 08:24:21', 'paid'),
(22, 1, 16, 1, 150000.00, '2025-07-21 14:32:19', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `full_name`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$PihYaWAf/mXKjiaJiCaRV.biSHcPJPtPPvM6i8C9EtOb1upk2vDDm', 'admin@eventticket.com', 'Administratorr', 1, '2025-07-20 06:26:14', '2025-07-21 14:07:33'),
(2, 'organizer1', '$2y$10$zdtHxo9Ccswk3jc9jI4pq.ZkRelcMWbCNtdrh4g2sjT88H03ld.OS', 'organizer1@eventticket.com', 'Budi Santoso', 2, '2025-07-20 07:00:00', NULL),
(3, 'organizer2', '$2y$10$PxN.RJK6s9LpL7i4WkprIODUzW9ygQUd7ca5rHvTDk0cMmRdUxkOS', 'organizer2@eventticket.com', 'Siti Rahmawati', 2, '2025-07-20 07:15:00', NULL),
(4, 'organizer3', '$2y$10$mlkfSDZTFG.3f63.TSsjeut8j9IONgKIoqbC0pdHbY.i92u33A9eq', 'organizer3@eventticket.com', 'Ahmad Hidayat', 2, '2025-07-20 07:30:00', NULL),
(5, 'customer1', '$2y$10$S.YK.EtBfJq1c2ZGH9/u8eVvtggRl3BeOvydvBl1t3F6UvyLJKony', 'customer1@email.com', 'Dewi Sartikaa', 3, '2025-07-20 08:00:00', '2025-07-21 08:49:33'),
(6, 'customer2', '$2y$10$NselEDadl2EiXf0OAJGfBuUGDHRxifmI7rlvyhBPGe5ep2JSQ75V.', 'customer2@email.com', 'Rudi Hermawan', 3, '2025-07-20 08:15:00', NULL),
(7, 'customer3', '$2y$10$usDobfFlkodebZhAymCedu3nFVOb64MnRpreYIXCrIwtOD62GQ8S.', 'customer3@email.com', 'Maya Indah', 3, '2025-07-20 08:30:00', NULL),
(8, 'customer4', '$2y$10$H4YI0Vo1fIRKhSoK9YmLBeDHOOjBULdW8aV5O1j3qjjFGdmvdU.2G', 'customer4@email.com', 'Joko Widodo', 3, '2025-07-20 08:45:00', NULL),
(9, 'customer5', '$2y$10$j440.nST/TNqz/bn7zveHuP48GoQHxUoZToj9oug1d7fpKVQXHW1W', 'customer5@email.com', 'Sri Wahyuni', 3, '2025-07-20 09:00:00', NULL),
(10, 'customer6', '$2y$10$jwVEdli0FCzprt5jfTtSVeztZloweFfwWkaV4UYdLcIVCUib95v32', 'customer6@email.com', 'Bambang Sutejo', 3, '2025-07-20 09:15:00', NULL),
(11, 'customer7', '$2y$10$QWWvweGIiZ8g6js92NI0PeJ1CHgZ/UOBDiCRE70Y6k/4GVFmFKCom', 'customer7@email.com', 'Nina Kartika', 3, '2025-07-20 09:30:00', NULL),
(12, 'customer8', '$2y$10$ABDPsd3xFvRzQAbeGEoztuYxgaBlnLaXZwMcO0D0P5.XLwlxnW5g6', 'customer8@email.com', 'Agus Setiawan', 3, '2025-07-20 09:45:00', NULL),
(13, 'customer9', '$2y$10$lMWegMbeuRI0w7yrp0WJHO6lXXsL8x0LL5qG1.kb6bN0r0IShU37K', 'customer9@email.com', 'Ratna Sari', 3, '2025-07-20 10:00:00', NULL),
(14, 'customer10', '$2y$10$pQvi4/ODqJ5wBtCnQnAg.uWD8oaRR/ocDrhuno7LeU69yaAxeTDn2', 'customer10@email.com', 'Eko Prasetyo', 3, '2025-07-20 10:15:00', NULL),
(15, 'Noval', '$2y$10$pbSqAttsu.DFMsF1B6Plgu/bJTKCsBQv9w7f3o567qeUhWwx8xcJO', 'noval@example.com', 'Noval Maulana', 3, '2025-07-21 11:55:47', '2025-07-21 11:55:47'),
(16, 'Noval Maulana', '$2y$10$FwgWD0X5P0NFJbYosz/Kp.IeI4EQlD3tO6FjbadAdM7ZEZiDBxbhi', 'noval911@example.com', 'Noval Maulana Pratama Nugroho Informatika', 3, '2025-07-21 14:31:18', '2025-07-21 14:33:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
