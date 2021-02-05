-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 05, 2021 at 07:55 PM
-- Server version: 10.4.12-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `todo_list`
--

CREATE TABLE `todo_list` (
  `id` int(50) NOT NULL,
  `title` text CHARACTER SET utf8mb4 NOT NULL,
  `description` text CHARACTER SET utf8mb4 NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `performer` int(50) DEFAULT NULL,
  `manager` int(100) NOT NULL,
  `priority` int(50) DEFAULT NULL,
  `status` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `todo_list`
--

INSERT INTO `todo_list` (`id`, `title`, `description`, `start_date`, `end_date`, `update_date`, `performer`, `manager`, `priority`, `status`) VALUES
(1, 'Тот самый день', 'именно тот', '2021-02-04 00:39:00', '2021-02-05 00:39:00', '2021-02-05 16:05:43', 3, 1, 1, 3),
(2, 'Сделать сайт за неделю', 'Сделать классный сайт за неделю', '2021-02-04 14:40:00', '2021-02-05 14:46:00', '2021-02-05 20:56:10', 2, 1, 2, 3),
(26, 'Рефакторинг кода', 'Переписать все', '2021-02-03 18:01:00', '2021-02-04 18:01:00', '2021-02-04 14:48:17', 5, 4, 2, 2),
(34, 'Рефакторинг кода', 'Переписать все', '2021-02-04 23:38:00', '2021-02-05 23:38:00', '2021-02-05 15:12:30', 3, 1, 3, 2),
(35, 'на неделю', '1', '2021-02-05 03:45:00', '2021-02-10 03:45:00', '2021-02-05 16:05:39', 2, 1, 1, 2),
(36, 'на неделю 2', '2', '2021-02-06 03:46:00', '2021-02-11 03:46:00', '2021-02-05 03:46:31', 2, 1, 1, 1),
(37, 'на месяц', '3', '2021-02-05 03:46:00', '2021-02-26 03:46:00', '2021-02-05 03:47:00', 2, 1, 1, 1),
(38, 'Исправить баг', 'баги', '2021-02-05 17:00:00', '2021-02-06 17:00:00', '2021-02-05 18:19:40', 3, 1, 1, 1),
(41, 'новая задача 3', 'новая задача 3', '2021-02-05 20:54:00', '2021-02-06 20:54:00', '2021-02-05 21:26:14', 2, 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_list`
--

CREATE TABLE `user_list` (
  `id` int(100) NOT NULL,
  `firstname` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `middlename` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `password` text CHARACTER SET utf8mb4 NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1 - manager',
  `manager` int(100) NOT NULL COMMENT 'if 0 than manager'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_list`
--

INSERT INTO `user_list` (`id`, `firstname`, `lastname`, `middlename`, `email`, `password`, `type`, `manager`) VALUES
(1, 'Admin', 'Admin', 'Admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1, 0),
(2, 'Андрей', 'Кожевников', 'Константинович', 'qwerty@mail.ru', 'd8578edf8458ce06fbc5bb76a58c5ca4', 2, 1),
(3, 'Виктория', 'Белова', 'Юрьевна', 'qwerty1@mail.ru', '6dbd0fe19c9a301c4708287780df41a2', 2, 1),
(4, 'Иван', 'Иванов', 'Иванович', 'qwerty2@mail.ru', '4cc2321ca77b832bd20b66f86f85bef6', 1, 0),
(5, 'Светлова', 'Светлана', 'Михайловна', 'qwerty3@mmail.ru', 'a6fc8c37c5a4ee63f21c8cddedc44e4b', 2, 4),
(11, 'Петр', 'Петров', 'Петрович', 'qwerty4@mail.ru', 'b71655748c0645232e10221c13f4ab7c', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todo_list`
--
ALTER TABLE `todo_list`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `user_list`
--
ALTER TABLE `user_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todo_list`
--
ALTER TABLE `todo_list`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `user_list`
--
ALTER TABLE `user_list`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
