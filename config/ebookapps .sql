-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jun 2025 pada 19.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebookapps`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ebooks`
--

CREATE TABLE `ebooks` (
  `id` int(11) NOT NULL,
  `added_by` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `author` varchar(100) NOT NULL,
  `year` year(4) DEFAULT NULL,
  `category` enum('Artificial Intelligence','Computer Science','Cyber Security','Data Science','Design','Development','IT and Software','Machine Learning','Network and Security','Operating System','Programming Languages','Others') NOT NULL,
  `type` enum('Free','Paid') NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `link` varchar(255) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `status` enum('Verified','Unverified') NOT NULL DEFAULT 'Unverified',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ebooks`
--

INSERT INTO `ebooks` (`id`, `added_by`, `title`, `description`, `author`, `year`, `category`, `type`, `price`, `link`, `cover`, `status`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'Docker Tutorial', NULL, 'Tutorialspoint', NULL, 'IT and Software', 'Paid', 0, 'https://www.tutorialspoint.com/ebook/docker_tutorial/index.asp', 'IMG-01012023-EA002.jpg', 'Verified', '2023-01-01 00:00:00', '2023-01-01 00:00:00'),
(3, 'admin', 'Arduino Tutorial', NULL, 'Tutorialspoint', NULL, 'IT and Software', 'Paid', 0, 'https://www.tutorialspoint.com/ebook/arduino_tutorial/index.asp', 'IMG-01012023-EA003.jpg', 'Verified', '2023-01-01 00:00:00', '2023-01-01 00:00:00'),
(4, 'admin', 'Operating System Tutorial', NULL, 'Tutorialspoint', NULL, 'IT and Software', 'Paid', 0, 'https://www.tutorialspoint.com/ebook/operating_system_tutorial/index.asp', 'IMG-01012023-EA004.jpg', 'Verified', '2023-01-01 00:00:00', '2023-01-01 00:00:00'),
(5, 'admin', 'Kali Linux Tutorial', NULL, 'Tutorialspoint', NULL, 'IT and Software', 'Paid', 0, 'https://www.tutorialspoint.com/ebook/kali_linux_tutorial/index.asp', 'IMG-01012023-EA005.jpg', 'Verified', '2023-01-01 00:00:00', '2023-01-01 00:00:00'),
(6, 'admin', 'Fundamentals of Information Security', NULL, 'Sanil Nadkarni', NULL, 'Cyber Security', 'Paid', 0, 'https://www.tutorialspoint.com/ebook/fundamentals_of_information_security/index.asp', 'IMG-01012023-EA006.jpg', 'Verified', '2023-01-01 00:00:00', '2023-01-01 00:00:00'),
(7, 'admin', 'C++ Tutorial', NULL, 'Tutorialspoint', NULL, 'Programming Languages', 'Paid', 0, 'https://www.tutorialspoint.com/ebook/cplusplus-tutorial/index.asp', 'IMG-01012023-EA007.jpg', 'Verified', '2023-01-01 00:00:00', '2023-01-01 00:00:00'),
(8, 'admin', 'Laravel Tutorial', NULL, 'Tutorialspoint', NULL, 'Programming Languages', 'Paid', 0, 'https://www.tutorialspoint.com/ebook/laravel_tutorial/index.asp', 'IMG-01012023-EA008.jpg', 'Verified', '2023-01-01 00:00:00', '2023-01-01 00:00:00'),
(9, 'admin', 'Learning Go Programming', NULL, 'Shubhangi Agarwal', NULL, 'Programming Languages', 'Paid', 0, 'https://www.tutorialspoint.com/ebook/learning_go_programming/index.asp', 'IMG-01012023-EA009.jpg', 'Verified', '2023-01-01 00:00:00', '2023-01-01 00:00:00'),
(10, 'admin', 'CSS Tutorial', NULL, 'Tutorialspoint', NULL, 'Development', 'Free', 0, 'https://www.tutorialspoint.com/ebook/css_tutorial/index.asp', 'IMG-01012023-EA010.jpg', 'Verified', '2023-01-01 00:00:00', '2025-06-26 03:34:33'),
(11, 'admin', 'Mastering Blockchain Second Edition', NULL, 'Imran Bashir', NULL, 'Machine Learning', 'Paid', 0, 'https://www.tutorialspoint.com/ebook/mastering_blockchain_second_edition/index.asp', 'IMG-01012023-EA011.jpg', 'Unverified', '2023-01-01 00:00:00', '2025-06-26 02:46:38'),
(12, 'admin', 'C++ High Performance Second Edition', NULL, 'Björn Andrist', NULL, 'Programming Languages', 'Paid', 0, 'https://www.tutorialspoint.com/ebook/cplusplus_high_performance_second_edition/index.asp', 'IMG-01012023-EA012.jpg', 'Verified', '2023-01-01 00:00:00', '2023-01-01 00:00:00'),
(13, 'admin', 'Modern Cybersecurity Strategies for Enterprises', '', 'Ashish Mishra', NULL, 'IT and Software', 'Paid', 50000, 'https://www.tutorialspoint.com/ebook/modern-cybersecurity-strategies-for-enterprises/index.asp', 'IMG-01012023-EA013.jpg', 'Verified', '2023-01-01 00:00:00', '2025-06-29 15:43:34'),
(14, 'admin', 'Atomic Habits', NULL, 'James Clear', NULL, 'Development', 'Paid', 0, 'https://jamesclear.com/atomic-habits', 'IMG-29062025-EA002.jpg', 'Verified', '2023-01-01 00:00:00', '2025-06-29 12:00:14'),
(15, 'admin', 'How To Win Friends  and Influence People', 'You can go after the job you want—and get it!\r\n\r\nYou can take the job you have—and improve it!\r\n\r\nYou can take any situation—and make it work for you!\r\n\r\nDale Carnegie’s rock-solid, time-tested advice has carried countless people up the ladder of success in their business and personal lives. One of the most groundbreaking and timeless bestsellers of all time, How to Win Friends &amp;amp;amp;amp; Influence People will teach you:\r\n\r\n-Six ways to make people like you\r\n\r\n-Twelve ways to win people to your way of thinking\r\n\r\n-Nine ways to change people without arousing resentment\r\n\r\nAnd much more! Achieve your maximum potential—a must-read for the twenty-first century with more than 15 million copies sold!', 'Dale Carnegie', '2018', 'Development', '', 100000, 'https://www.dalecarnegie.com/en/courses/216', 'IMG-29062025-EA001.jpg', 'Verified', '2025-06-26 09:45:24', '2025-06-29 16:30:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempt_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','member') NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$ddYE93ywRmjo./RshVQgC.sw5PGLAJrA4NWfsVaaZ2UdQK1hgo3eC', 'admin'),
(2, 'member', '$2y$10$LkvpELIhyEPsvNbxrQ5OjOpLpUyPtcS89Hl99hbkVleP03saU9AEq', 'member'),
(5, 'jeki', '$2y$10$yxqTGT2KLaevIrQ5tfwgTu07wXDJRPjxnYZ7gWCq.52.YHuLwEvBa', 'member'),
(6, 'member1', '$2y$10$FUhqKhsOYO6S3qkNp6LIO.Wiy6WiKiBaaR0pMMjzDImD5/NdgpJGq', 'member'),
(7, 'udin', '$2y$10$MdlhHStCPI56HTXaupvps.aDYMtOnm6gVnCNOgcTC4inGOPrmNzpy', 'member');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ebooks`
--
ALTER TABLE `ebooks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `added_by` (`added_by`);

--
-- Indeks untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `ebooks`
--
ALTER TABLE `ebooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
