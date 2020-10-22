-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2020 at 10:54 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wallpaper_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `status_about`
--

CREATE TABLE `status_about` (
  `id` int(11) NOT NULL,
  `about` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_about`
--

INSERT INTO `status_about` (`id`, `about`, `created_at`) VALUES
(1, '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '2020-03-29 14:41:28');

-- --------------------------------------------------------

--
-- Table structure for table `status_category`
--

CREATE TABLE `status_category` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `created_at` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_liked_wallpaper`
--

CREATE TABLE `status_liked_wallpaper` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_notification`
--

CREATE TABLE `status_notification` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status_privacy`
--

CREATE TABLE `status_privacy` (
  `id` int(11) NOT NULL,
  `privacy_policy` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_privacy`
--

INSERT INTO `status_privacy` (`id`, `privacy_policy`, `created_at`) VALUES
(1, '<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '2020-03-29 14:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `status_token`
--

CREATE TABLE `status_token` (
  `id` int(11) NOT NULL,
  `token_id` varchar(555) NOT NULL,
  `device_type` varchar(15) NOT NULL,
  `user_token` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status_users`
--

CREATE TABLE `status_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL,
  `device_type` int(11) NOT NULL COMMENT '1 = Android , 2 = iPhone',
  `device_token` text NOT NULL,
  `role` int(11) NOT NULL,
  `profile_image` varchar(50) NOT NULL,
  `login_token` text NOT NULL,
  `android_key` text NOT NULL,
  `notification_status` int(11) NOT NULL DEFAULT 1 COMMENT '1 = enable , 2 = disable',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_users`
--

INSERT INTO `status_users` (`id`, `username`, `email`, `password`, `device_type`, `device_token`, `role`, `profile_image`, `login_token`, `android_key`, `notification_status`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'VHMzZzNaejZRYjBuZ3ZrZUlTM0JzUT09', 0, '', 1, '', '', '', 1, '2020-06-08 05:34:54');

-- --------------------------------------------------------

--
-- Table structure for table `status_wallpapers`
--

CREATE TABLE `status_wallpapers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `wallpaper_color` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `wallpaper_height` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = Pending, 1 = Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `status_about`
--
ALTER TABLE `status_about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_category`
--
ALTER TABLE `status_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_liked_wallpaper`
--
ALTER TABLE `status_liked_wallpaper`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_notification`
--
ALTER TABLE `status_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_privacy`
--
ALTER TABLE `status_privacy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_token`
--
ALTER TABLE `status_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_users`
--
ALTER TABLE `status_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_wallpapers`
--
ALTER TABLE `status_wallpapers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `status_about`
--
ALTER TABLE `status_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status_category`
--
ALTER TABLE `status_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_liked_wallpaper`
--
ALTER TABLE `status_liked_wallpaper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_notification`
--
ALTER TABLE `status_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_privacy`
--
ALTER TABLE `status_privacy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status_token`
--
ALTER TABLE `status_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_users`
--
ALTER TABLE `status_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status_wallpapers`
--
ALTER TABLE `status_wallpapers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
