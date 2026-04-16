-- =====================================================
-- CORRECTED DATABASE SETUP FOR LOGIN & REGISTER SYSTEM
-- =====================================================
-- This file creates the exact database and table structure
-- that matches your current web application configuration

-- Create database (matches config.php: $database = "user_db")
CREATE DATABASE IF NOT EXISTS `user_db`;
USE `user_db`;

-- =====================================================
-- Table: users (matches all PHP database operations)
-- =====================================================
-- Only includes columns that are actually used by your web application
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `reset_code` int DEFAULT 0 COMMENT 'Password reset code',

  -- Unique constraint for email (matches your existing data)
  UNIQUE KEY `email_unique` (`email`),

  -- Index for email lookups (used in SELECT WHERE email=...)
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Insert sample data (matches your existing users.sql)
-- =====================================================
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Tuan', 'tuan.tranraven621@hcmut.edu.vn', '$2y$10$NNTtrlVkX/DNhtF4PZ1dU.veMoK4.vfLUFqjus4B.NGH0hCUU.Ie.', 'admin'),
(3, 'Duy ', 'tuan24102005@gmail.com', '$2y$10$Te2J1YcV3jLgRV6x.AmWpONgl7iDoJbL8RVxVlwrzron9HkhqsqIG', 'user');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_CHARACTER_SET_RESULTS */;
