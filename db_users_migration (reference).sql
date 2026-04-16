-- =====================================================
-- ADD USERS TABLE TO MAIN DATABASE
-- =====================================================
-- This integrates the login-register system into online_electronics_store_db

USE `online_electronics_store_db`;

-- =====================================================
-- Create users table (for both admin and regular users)
-- Matches the schema used in login-register system
-- =====================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `reset_code` int(11) DEFAULT 0,
  
  -- Indexes for performance
  KEY `idx_email` (`email`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Insert default admin user (password hash for 'admin123')
-- =====================================================
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `password`, `role`) 
VALUES (1, 'Admin User', 'admin@example.com', '$2y$10$Nqq/y251QX2Ccvb1Ax7hUuMqQSkG3yRLCxN2KPdetnSP3oaXVH70a', 'admin');

COMMIT;
