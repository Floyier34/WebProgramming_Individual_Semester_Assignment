-- =====================================================
-- DATABASE MODIFICATION FOR EXISTING USERS TABLE
-- =====================================================
-- Use this file to add missing columns to an existing users table
-- This will NOT drop or recreate the table - it only adds new columns

USE `user_db`;

-- =====================================================
-- Step 1: Add reset_code column if it doesn't exist
-- =====================================================
ALTER TABLE `users`
ADD COLUMN `reset_code` INT DEFAULT 0 COMMENT 'Password reset code'
AFTER `role`;

-- =====================================================
-- Verification Query - Run this to check all columns
-- =====================================================
-- SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'users' AND TABLE_SCHEMA = 'user_db';

-- =====================================================
-- If you need to UNDO these changes, uncomment and use:
-- =====================================================
-- ALTER TABLE `users` DROP COLUMN `reset_code`;

COMMIT;
