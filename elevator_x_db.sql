-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2025 at 07:01 PM
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
-- Database: `elevator_x_db`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `active_gigs_view`
-- (See below for the actual view)
--
CREATE TABLE `active_gigs_view` (
`id` int(11)
,`title` varchar(255)
,`description` text
,`category` enum('technology','healthcare','fintech','e-commerce','education','sustainability','food-beverage','manufacturing','retail','consulting','media-entertainment','travel-tourism','real-estate','agriculture','other')
,`funding_needed` varchar(50)
,`views_count` int(11)
,`interests_count` int(11)
,`created_at` timestamp
,`entrepreneur_first_name` varchar(100)
,`entrepreneur_last_name` varchar(100)
,`business_name` varchar(255)
,`business_location` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `entrepreneurs`
--

CREATE TABLE `entrepreneurs` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `business_category` enum('technology','healthcare','fintech','e-commerce','education','sustainability','food-beverage','manufacturing','retail','consulting','media-entertainment','travel-tourism','real-estate','agriculture','other') NOT NULL,
  `business_stage` enum('idea','research','prototype','early-revenue','growth','established') NOT NULL,
  `business_location` varchar(255) NOT NULL,
  `business_description` text NOT NULL,
  `business_website` varchar(500) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `linkedin_profile` varchar(500) DEFAULT NULL,
  `support_needed` text DEFAULT NULL,
  `funding_need` varchar(50) DEFAULT NULL,
  `business_plan` varchar(100) DEFAULT NULL,
  `business_registration_file` varchar(255) DEFAULT NULL,
  `how_heard` varchar(100) DEFAULT NULL,
  `newsletter_subscribe` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entrepreneurs`
--

INSERT INTO `entrepreneurs` (`id`, `first_name`, `last_name`, `email`, `phone`, `password_hash`, `business_name`, `business_category`, `business_stage`, `business_location`, `business_description`, `business_website`, `date_of_birth`, `nationality`, `linkedin_profile`, `support_needed`, `funding_need`, `business_plan`, `business_registration_file`, `how_heard`, `newsletter_subscribe`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'chamudu', 'lakman', 'divarathnac@gmail.com', 'divarathnac@gmail.co', '$2y$10$C8m3MRVnq3UC.JVTGTEOJ.1CZa4AfnUF7BzvHXrE4wQoSrsYigtIW', 'jj sl', 'manufacturing', 'prototype', 'jj sl', 'aaaaaaaaaaaaa', NULL, '2004-06-15', 'french', NULL, 'funding,legal', '250k-500k', 'yes-detailed', NULL, 'university', 1, 1, '2025-08-20 14:15:45', '2025-08-31 18:50:23'),
(5, 'Nimesh', 'Perera', 'np@gmail.com', '0723456233', '$2y$10$X6uBEKDX3gnIlXLDC6kOE.V8hnzEbFmHMWt9.En0OLoKfLSzybRgS', 'Lanka Tech Hub', 'technology', 'prototype', 'Ragama', 'A startup focused on providing AI-driven software solutions for small businesses.', 'https://lankatechhub.lk', '1992-12-07', 'sri-lankan', NULL, 'mentorship,funding,networking', '10k-25k', 'yes-basic', NULL, 'newsletter', 1, 1, '2025-09-01 06:28:58', '2025-09-01 08:59:25'),
(6, 'Tharushi', 'Fernando', 'tf@gmail.com', '0786785467', '$2y$10$mULMYTcyNPS4kaYo1EdjT.Nqb3uB7qEKzM.TxI93KwbVihXd8XJki', 'Green Harvest Organics', 'agriculture', 'growth', 'Kandy', 'Organic farming and distribution of fresh fruits and vegetables with eco-friendly packaging.', 'https://greenharvest.lk', '1993-03-31', 'sri-lankan', NULL, 'funding,legal,marketing', '25k-50k', 'yes-detailed', NULL, 'referral', 1, 1, '2025-09-01 06:35:08', '2025-09-01 08:01:36'),
(7, 'Janith', 'Silva', 'js@gmail.com', '0745676432', '$2y$10$VoEQvHshOM4Ln9ijWvE3R.ySz3VHCIhHogObBSzK20/VLPxOQHcYW', 'EduNext Lanka', 'education', 'idea', 'Galle', 'An online platform providing affordable e-learning content for school students in Sinhala & English.', 'https://edunext.lk', '1993-09-11', 'sri-lankan', NULL, 'mentorship,funding,education', '10k-25k', 'yes-basic', NULL, 'social-media', 1, 1, '2025-09-01 06:42:23', '2025-09-01 06:42:23'),
(8, 'Kavindi', 'Jayasinghe', 'kj@gmail.com', '0765453762', '$2y$10$8KJfAZjvnaWM4qZKqJM8S.W/9M/Adwp.SYzr6ePi1f5BALtxmItmK', 'Ceylon Handcrafts', 'other', 'growth', 'Embilipitiya', 'Handmade wooden and clay crafts showcasing traditional Sri Lankan artistry, targeting global e-commerce markets.', 'https://ceylonhandcrafts.lk', '1999-02-27', 'sri-lankan', NULL, 'mentorship,funding,networking', 'under-10k', 'working-on-it', NULL, 'other', 1, 1, '2025-09-01 06:48:25', '2025-09-01 06:48:25');

-- --------------------------------------------------------

--
-- Table structure for table `gigs`
--

CREATE TABLE `gigs` (
  `id` int(11) NOT NULL,
  `entrepreneur_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` enum('technology','healthcare','fintech','e-commerce','education','sustainability','food-beverage','manufacturing','retail','consulting','media-entertainment','travel-tourism','real-estate','agriculture','other') NOT NULL,
  `target_market` text DEFAULT NULL,
  `business_model` text DEFAULT NULL,
  `competitive_advantage` text DEFAULT NULL,
  `current_status` enum('idea','research','development','testing','launched') DEFAULT 'idea',
  `funding_needed` varchar(50) DEFAULT NULL,
  `funding_purpose` text DEFAULT NULL,
  `equity_offered` varchar(20) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `business_plan_file` varchar(255) DEFAULT NULL,
  `pitch_deck_file` varchar(255) DEFAULT NULL,
  `demo_video_url` varchar(500) DEFAULT NULL,
  `visibility` enum('public','private','mentors_only','investors_only') DEFAULT 'public',
  `status` enum('draft','active','paused','completed','cancelled') DEFAULT 'draft',
  `featured` tinyint(1) DEFAULT 0,
  `views_count` int(11) DEFAULT 0,
  `interests_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gigs`
--

INSERT INTO `gigs` (`id`, `entrepreneur_id`, `title`, `description`, `category`, `target_market`, `business_model`, `competitive_advantage`, `current_status`, `funding_needed`, `funding_purpose`, `equity_offered`, `featured_image`, `business_plan_file`, `pitch_deck_file`, `demo_video_url`, `visibility`, `status`, `featured`, `views_count`, `interests_count`, `created_at`, `updated_at`) VALUES
(5, 5, 'AI-Powered Business Automation Software', 'We are building AI-powered tools to help small and medium businesses automate repetitive tasks, analyze data, and improve efficiency. Our goal is to bring enterprise-level AI solutions to Sri Lankan SMEs at affordable prices.', 'technology', NULL, NULL, NULL, 'idea', '10k-50k', NULL, NULL, NULL, NULL, NULL, NULL, 'public', 'draft', 0, 0, 0, '2025-09-01 08:00:08', '2025-09-01 08:00:08'),
(6, 6, 'Organic Fruits & Vegetables with Sustainable Packaging', 'Green Harvest is committed to providing chemical-free, organic fruits and vegetables grown in Sri Lanka. We use eco-friendly packaging to reduce waste and ensure healthy living for all. Funding will expand production capacity and distribution networks.', 'agriculture', NULL, NULL, NULL, 'development', '40000', NULL, NULL, NULL, NULL, NULL, NULL, 'public', 'draft', 0, 0, 0, '2025-09-01 08:08:48', '2025-09-01 08:08:48'),
(7, 5, 'AI-Powered Business Automation Software', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'healthcare', NULL, NULL, NULL, 'idea', '10k-50k', NULL, NULL, NULL, NULL, NULL, NULL, 'public', 'draft', 0, 0, 0, '2025-09-01 08:19:55', '2025-09-01 08:19:55'),
(8, 5, 'aaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'technology', NULL, NULL, NULL, 'idea', '10k-50k', NULL, NULL, NULL, NULL, NULL, NULL, 'public', 'draft', 0, 0, 0, '2025-09-01 08:25:54', '2025-09-01 08:25:54'),
(9, 5, 'AI-Powered Business Automation Software', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'technology', NULL, NULL, NULL, 'idea', '10k-50k', NULL, NULL, NULL, NULL, NULL, NULL, 'public', 'draft', 0, 0, 0, '2025-09-01 09:01:00', '2025-09-01 09:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `gig_images`
--

CREATE TABLE `gig_images` (
  `id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `image_filename` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `image_order` int(11) DEFAULT 1,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investors`
--

CREATE TABLE `investors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `investment_focus` enum('technology','healthcare','fintech','e-commerce','education','sustainability','real-estate','food-beverage','manufacturing','retail','other') NOT NULL,
  `investment_range` varchar(50) NOT NULL,
  `business_stage` varchar(50) DEFAULT NULL,
  `geographic_preference` varchar(50) DEFAULT NULL,
  `investment_experience` varchar(50) DEFAULT NULL,
  `investment_details` text DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `linkedin_profile` varchar(500) DEFAULT NULL,
  `website` varchar(500) DEFAULT NULL,
  `business_statement_file` varchar(255) NOT NULL,
  `how_heard` varchar(100) DEFAULT NULL,
  `additional_info` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `messaging_unlocked` tinyint(1) DEFAULT 0,
  `mentorship_plan` varchar(50) DEFAULT NULL,
  `mentorship_expires` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investors`
--

INSERT INTO `investors` (`id`, `first_name`, `last_name`, `email`, `phone`, `password_hash`, `investment_focus`, `investment_range`, `business_stage`, `geographic_preference`, `investment_experience`, `investment_details`, `company_name`, `job_title`, `linkedin_profile`, `website`, `business_statement_file`, `how_heard`, `additional_info`, `is_active`, `created_at`, `updated_at`, `messaging_unlocked`, `mentorship_plan`, `mentorship_expires`) VALUES
(5, 'Dilan', 'Wijesekara', 'dw@gmail.com', '0777654325', '$2y$10$6El0tW2arAMoBYbDC9wwU.ytGoQAJfitQks8UorC6CoPeD.d5we2e', 'technology', '50k-100k', 'growth', 'local', '1-5-investments', 'Previously invested in 3 local fintech startups and an e-commerce platform.', 'BlueWave Capital (Private) Ltd', 'Managing Director', NULL, 'https://bluewavecapital.lk', '68b5467dad9bd_1756710525.png', 'referral', NULL, 1, '2025-09-01 07:08:45', '2025-09-01 08:20:52', 1, NULL, NULL),
(6, 'Sanduni', 'de Alwis', 'sa@gmail.com', '0777252234', '$2y$10$.JSQTBwT4LHid.RSthA1ueXs4D2Evkh0tifKk6S4CStpWvsJGtys2', 'sustainability', 'under-50k', 'established', 'international', '6-15-investments', 'Angel investor in 2 organic farming startups and 1 online tutoring platform. Strong interest in social impact projects.', 'GreenFuture Investments', 'Senior Partner', 'https://linkedin.com/in/sandunidealwis', NULL, '68b5490411ae9_1756711172.png', 'google', NULL, 1, '2025-09-01 07:19:32', '2025-09-01 09:02:46', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `investor_connections`
--

CREATE TABLE `investor_connections` (
  `id` int(11) NOT NULL,
  `entrepreneur_id` int(11) NOT NULL,
  `investor_id` int(11) NOT NULL,
  `gig_id` int(11) DEFAULT NULL,
  `status` enum('pending','accepted','rejected','blocked') DEFAULT 'pending',
  `connection_type` enum('interest','meeting_request','investment_offer') DEFAULT 'interest',
  `request_message` text DEFAULT NULL,
  `response_message` text DEFAULT NULL,
  `meeting_scheduled_at` timestamp NULL DEFAULT NULL,
  `meeting_notes` text DEFAULT NULL,
  `investment_amount` decimal(15,2) DEFAULT NULL,
  `equity_percentage` decimal(5,2) DEFAULT NULL,
  `investment_terms` text DEFAULT NULL,
  `due_diligence_status` enum('not_started','in_progress','completed') DEFAULT 'not_started',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `responded_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investor_payments`
--

CREATE TABLE `investor_payments` (
  `id` int(11) NOT NULL,
  `investor_id` int(11) NOT NULL,
  `payment_type` enum('messaging_access','mentorship','investment') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `plan_type` varchar(50) DEFAULT NULL,
  `status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investor_payments`
--

INSERT INTO `investor_payments` (`id`, `investor_id`, `payment_type`, `amount`, `plan_type`, `status`, `created_at`) VALUES
(1, 1, 'mentorship', 99.00, '1-month', 'completed', '2025-08-21 06:52:02'),
(2, 1, 'mentorship', 99.00, '1-month', 'completed', '2025-08-21 09:20:50'),
(3, 1, 'messaging_access', 50.00, NULL, 'completed', '2025-08-21 09:21:07'),
(4, 4, 'messaging_access', 50.00, NULL, 'completed', '2025-08-31 11:20:22'),
(5, 4, 'mentorship', 999.00, '1-year', 'completed', '2025-08-31 11:21:20'),
(6, 5, 'messaging_access', 50.00, NULL, 'completed', '2025-09-01 08:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_type` enum('entrepreneur','investor','mentor') NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `recipient_type` enum('entrepreneur','investor','mentor') NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `message_type` enum('text','file','meeting_invite') DEFAULT 'text',
  `attachment_file` varchar(255) DEFAULT NULL,
  `attachment_type` varchar(50) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `is_archived` tinyint(1) DEFAULT 0,
  `replied_to_message_id` int(11) DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `active_gigs_view`
--
DROP TABLE IF EXISTS `active_gigs_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `active_gigs_view`  AS SELECT `g`.`id` AS `id`, `g`.`title` AS `title`, `g`.`description` AS `description`, `g`.`category` AS `category`, `g`.`funding_needed` AS `funding_needed`, `g`.`views_count` AS `views_count`, `g`.`interests_count` AS `interests_count`, `g`.`created_at` AS `created_at`, `e`.`first_name` AS `entrepreneur_first_name`, `e`.`last_name` AS `entrepreneur_last_name`, `e`.`business_name` AS `business_name`, `e`.`business_location` AS `business_location` FROM (`gigs` `g` join `entrepreneurs` `e` on(`g`.`entrepreneur_id` = `e`.`id`)) WHERE `g`.`status` = 'active' AND `g`.`visibility` = 'public' ORDER BY `g`.`created_at` DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `entrepreneurs`
--
ALTER TABLE `entrepreneurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_business_category` (`business_category`),
  ADD KEY `idx_business_stage` (`business_stage`),
  ADD KEY `idx_is_active` (`is_active`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `gigs`
--
ALTER TABLE `gigs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_entrepreneur_id` (`entrepreneur_id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_visibility` (`visibility`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `gig_images`
--
ALTER TABLE `gig_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_gig_id` (`gig_id`);

--
-- Indexes for table `investors`
--
ALTER TABLE `investors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_investment_focus` (`investment_focus`),
  ADD KEY `idx_investment_range` (`investment_range`),
  ADD KEY `idx_is_active` (`is_active`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `investor_connections`
--
ALTER TABLE `investor_connections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_connection` (`entrepreneur_id`,`investor_id`,`gig_id`),
  ADD KEY `idx_entrepreneur_id` (`entrepreneur_id`),
  ADD KEY `idx_investor_id` (`investor_id`),
  ADD KEY `idx_gig_id` (`gig_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `investor_payments`
--
ALTER TABLE `investor_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sender` (`sender_id`,`sender_type`),
  ADD KEY `idx_recipient` (`recipient_id`,`recipient_type`),
  ADD KEY `idx_sent_at` (`sent_at`),
  ADD KEY `idx_is_read` (`is_read`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `entrepreneurs`
--
ALTER TABLE `entrepreneurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gigs`
--
ALTER TABLE `gigs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `gig_images`
--
ALTER TABLE `gig_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `investors`
--
ALTER TABLE `investors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `investor_connections`
--
ALTER TABLE `investor_connections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `investor_payments`
--
ALTER TABLE `investor_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gigs`
--
ALTER TABLE `gigs`
  ADD CONSTRAINT `gigs_ibfk_1` FOREIGN KEY (`entrepreneur_id`) REFERENCES `entrepreneurs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gig_images`
--
ALTER TABLE `gig_images`
  ADD CONSTRAINT `gig_images_ibfk_1` FOREIGN KEY (`gig_id`) REFERENCES `gigs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investor_connections`
--
ALTER TABLE `investor_connections`
  ADD CONSTRAINT `investor_connections_ibfk_1` FOREIGN KEY (`entrepreneur_id`) REFERENCES `entrepreneurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `investor_connections_ibfk_2` FOREIGN KEY (`investor_id`) REFERENCES `investors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `investor_connections_ibfk_3` FOREIGN KEY (`gig_id`) REFERENCES `gigs` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
