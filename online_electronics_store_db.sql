-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2021 at 10:38 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_electronics_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Admin User', 'admin@example.com', '$2y$10$Nqq/y251QX2Ccvb1Ax7hUuMqQSkG3yRLCxN2KPdetnSP3oaXVH70a');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'Aether Mobile'),
(2, 'NovaCore'),
(3, 'Lumenix'),
(4, 'Orbit Labs'),
(5, 'PulseAudio'),
(6, 'Vertex Computing'),
(7, 'Zenith Gear'),
(8, 'EchoWave'),
(9, 'TitanForge'),
(10, 'Skylink');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `short_description` varchar(255) NOT NULL DEFAULT '',
  `brand_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Smartphones'),
(2, 'Laptops'),
(3, 'Tablets'),
(4, 'Smart Home'),
(5, 'Audio'),
(6, 'Wearables'),
(7, 'Gaming'),
(8, 'Networking'),
(9, 'Storage'),
(10, 'Displays');

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `name`, `price`, `short_description`, `brand_id`, `description`, `category_id`, `image`, `file`) VALUES
(1, 'Aether NovaPhone X2', 799.00, '6.7 inch OLED, 5G, 128GB storage', 1, 'Flagship phone with fast 5G modem, dual camera system, and long battery life for daily use.', 1, 'empty.png', 'empty.png'),
(2, 'NovaCore Glide S5', 649.00, '6.5 inch AMOLED, 90Hz, 256GB', 2, 'Slim smartphone with smooth 90Hz display, stereo speakers, and fast charging support.', 1, 'empty.png', 'empty.png'),
(3, 'Lumenix Prism Mini', 549.00, '5.8 inch OLED, compact build, 128GB', 3, 'Compact smartphone designed for one hand use with bright display and reliable all day battery.', 1, 'empty.png', 'empty.png'),
(4, 'Vertex Ultralite 14', 999.00, '14 inch FHD, 16GB RAM, 512GB SSD', 6, 'Lightweight laptop for work and study with efficient processor and quiet cooling.', 2, 'empty.png', 'empty.png'),
(5, 'Lumenix StudioBook 16', 1799.00, '16 inch QHD, 32GB RAM, 1TB SSD', 3, 'Creator focused laptop with large color accurate display and strong GPU performance.', 2, 'empty.png', 'empty.png'),
(6, 'TitanForge Raider 15', 1499.00, '15.6 inch 144Hz, 16GB RAM, RTX class GPU', 9, 'Gaming laptop built for high frame rates and advanced cooling under heavy loads.', 2, 'empty.png', 'empty.png'),
(7, 'NovaCore Slate 11', 429.00, '11 inch LCD, 128GB, quad speakers', 2, 'Everyday tablet for media and notes with balanced performance and long battery life.', 3, 'empty.png', 'empty.png'),
(8, 'Zenith Gear Canvas 10', 299.00, '10 inch display, pen support, 64GB', 7, 'Portable tablet with pen support for sketches, reading, and casual browsing.', 3, 'empty.png', 'empty.png'),
(9, 'Aether Tab Air 12', 599.00, '12.4 inch display, 256GB, fast charge', 1, 'Large screen tablet suited for split screen work and streaming in high resolution.', 3, 'empty.png', 'empty.png'),
(10, 'Orbit Labs HomeHub', 199.00, 'WiFi 6 hub, voice control, multi room', 4, 'Central smart home hub that connects sensors, lights, and voice assistants.', 4, 'empty.png', 'empty.png'),
(11, 'EchoWave Smart Plug Duo', 39.00, 'Two pack, energy monitoring, app control', 8, 'Smart plugs with scheduling and energy tracking for efficient power use.', 4, 'empty.png', 'empty.png'),
(12, 'Skylink SecureCam 2K', 89.00, '2K camera, night vision, motion alerts', 10, 'Indoor security camera with clear video, night mode, and instant motion alerts.', 4, 'empty.png', 'empty.png'),
(13, 'PulseAudio WaveBuds Pro', 179.00, 'ANC earbuds, 30 hour total battery', 5, 'True wireless earbuds with active noise canceling and clear call microphones.', 5, 'empty.png', 'empty.png'),
(14, 'EchoWave Studio Speaker', 229.00, '120W speaker, Bluetooth 5.3, deep bass', 8, 'Room filling speaker with rich bass and multi device Bluetooth pairing.', 5, 'empty.png', 'empty.png'),
(15, 'Orbit Labs NoiseCancel 700', 249.00, 'Over ear, ANC, 35 hour battery', 4, 'Comfortable over ear headphones with adaptive noise canceling and travel case.', 5, 'empty.png', 'empty.png'),
(16, 'Zenith Gear FitTrack 3', 79.00, 'Fitness band, heart rate, sleep tracking', 7, 'Slim fitness tracker with health metrics, workout modes, and water resistance.', 6, 'empty.png', 'empty.png'),
(17, 'Aether PulseWatch 2', 299.00, 'GPS watch, AMOLED, 5 day battery', 1, 'Smartwatch with built in GPS, bright display, and multi sport tracking.', 6, 'empty.png', 'empty.png'),
(18, 'Lumenix Loop Band', 49.00, 'Minimal band, step tracking, USB C charge', 3, 'Simple wearable focused on steps and notifications with a lightweight design.', 6, 'empty.png', 'empty.png'),
(19, 'TitanForge Blaze Console', 499.00, '4K gaming, 1TB storage, ray tracing', 9, 'Home console delivering fast load times and smooth 4K gaming performance.', 7, 'empty.png', 'empty.png'),
(20, 'Vertex Quantum Controller', 69.00, 'Wireless controller, low latency, USB C', 6, 'Ergonomic controller with responsive triggers and long battery life.', 7, 'empty.png', 'empty.png'),
(21, 'PulseAudio Arena Headset', 99.00, 'Surround sound, noise mic, braided cable', 5, 'Gaming headset with virtual surround and clear voice capture.', 7, 'empty.png', 'empty.png'),
(22, 'Skylink Mesh Router AX6', 299.00, 'WiFi 6 mesh, 3 pack coverage', 10, 'Mesh router system designed to blanket large homes with stable WiFi.', 8, 'empty.png', 'empty.png'),
(23, 'Orbit Labs Range Extender Pro', 79.00, 'Dual band extender, gigabit port', 4, 'Range extender that boosts weak signals and adds a wired port for devices.', 8, 'empty.png', 'empty.png'),
(24, 'NovaCore StreamSwitch 8', 49.00, '8 port gigabit switch, fanless', 2, 'Compact network switch with silent operation for desks or media racks.', 8, 'empty.png', 'empty.png'),
(25, 'Vertex Vault SSD 1TB', 129.00, 'NVMe SSD, 3500MB per second, heatsink', 6, 'High speed NVMe drive for fast boot times and quick file transfers.', 9, 'empty.png', 'empty.png'),
(26, 'Lumenix Pocket SSD 512GB', 79.00, 'USB C portable SSD, 512GB', 3, 'Pocket size external SSD with durable shell and fast USB C speeds.', 9, 'empty.png', 'empty.png'),
(27, 'TitanForge IronDrive HDD 4TB', 119.00, '3.5 inch HDD, 7200RPM, 4TB', 9, 'Desktop hard drive offering reliable bulk storage for games and media.', 9, 'empty.png', 'empty.png'),
(28, 'Lumenix ClearView 27', 329.00, '27 inch IPS, 144Hz, QHD', 3, 'Smooth gaming and work monitor with sharp resolution and vivid colors.', 10, 'empty.png', 'empty.png'),
(29, 'Vertex EdgeWide 34', 599.00, '34 inch ultrawide, 165Hz, curved', 6, 'Ultrawide curved display built for multitasking and immersive gaming.', 10, 'empty.png', 'empty.png'),
(30, 'NovaCore PixelPanel 24', 159.00, '24 inch FHD, 75Hz, thin bezel', 2, 'Affordable monitor with thin bezels for dual screen setups.', 10, 'empty.png', 'empty.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
