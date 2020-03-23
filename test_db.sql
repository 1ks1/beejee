-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2020 at 01:19 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `tasktext` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('new','done','edited','done_edited') COLLATE utf8_unicode_ci NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `tasktext`, `status`, `userID`) VALUES
(15, 'aaaaaaaaaaaaaaaaaa', 'done_edited', 3),
(16, 'ывфывфыв', 'done_edited', 2),
(17, 'Colgate - ssss', 'done_edited', 8),
(18, 'assssssssss', 'done', 2),
(19, 'Vjlth gjaaa', 'edited', 5),
(20, ';;;;;;kjjhfhgdgfsdfsdf&lt;&gt;&lt;/&gt;', 'done', 7),
(21, 'vvvv', 'done', 3),
(22, '000', 'done', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `role`) VALUES
(1, 'Administrator', 'admin', '202cb962ac59075b964b07152d234b70', 'dce8927ec96cc98b175de7dfc665d654', 'admin'),
(2, 'info', 'sabrina456@p5mail.com', '25d55ad283aa400af464c76d713c07ad', '', 'user'),
(3, 'zxg69885', 'asasasdsd@mail.ru', '25d55ad283aa400af464c76d713c07ad', '', 'user'),
(4, 'fulitka', 'fufel@mail.com', '25d55ad283aa400af464c76d713c07ad', '', 'user'),
(5, 'asdasdasd', 'iab52721@eanok.com', '25d55ad283aa400af464c76d713c07ad', '', 'user'),
(6, 'test', 'test@test.com', '25d55ad283aa400af464c76d713c07ad', '', 'user'),
(7, 'aaaaasdasd', 'ltn96734@zzrgg.com', '25d55ad283aa400af464c76d713c07ad', '', 'user'),
(8, 'asdasd', 'francua98@gmail.com', '25d55ad283aa400af464c76d713c07ad', '', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
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
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
