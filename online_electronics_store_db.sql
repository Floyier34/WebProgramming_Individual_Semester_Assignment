-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `online_electronics_store_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `email`, `password`) VALUES
(1, 'Admin User', 'admin@example.com', '$2y$10$Nqq/y251QX2Ccvb1Ax7hUuMqQSkG3yRLCxN2KPdetnSP3oaXVH70a');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'Lenovo'),
(2, 'Aether Mobile'),
(3, 'NovaCore'),
(4, 'Lumenix'),
(5, 'Orbit Labs'),
(6, 'PulseAudio'),
(7, 'Vertex Computing'),
(8, 'Zenith Gear'),
(9, 'EchoWave'),
(10, 'TitanForge'),
(11, 'Skylink');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Laptop'),
(2, 'Smartphones'),
(3, 'Tablets'),
(4, 'Smart Home'),
(5, 'Audio'),
(6, 'Wearables'),
(7, 'Gaming'),
(8, 'Networking'),
(9, 'Storage'),
(10, 'Displays');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `devices`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `devices`
--

INSERT INTO `devices` (`id`, `name`, `price`, `short_description`, `brand_id`, `description`, `category_id`, `image`, `file`) VALUES
(2, 'Lenovo LOQ', 400.00, 'Spec: high end', 1, 'Spec: high end', 1, '69c8a7a140fea2.05530704.jpg', '69c8a7a1417268.68088047.jpg'),
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
(30, 'Aether NovaPhone X2', 799.00, '6.7 inch OLED, 5G, 128GB storage', 1, 'Flagship phone with fast 5G modem, dual camera system, and long battery life for daily use.', 1, 'empty.png', 'empty.png'),
(31, 'NovaCore Glide S5', 649.00, '6.5 inch AMOLED, 90Hz, 256GB', 2, 'Slim smartphone with smooth 90Hz display, stereo speakers, and fast charging support.', 1, 'empty.png', 'empty.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `reset_code` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `reset_code`) VALUES
(1, 'Admin User', 'admin@example.com', '$2y$10$Nqq/y251QX2Ccvb1Ax7hUuMqQSkG3yRLCxN2KPdetnSP3oaXVH70a', 'admin', 0),
(2, 'Tuan', 'tuan24102005@gmail.com', '$2y$10$PgHHZjFu7C7bueCM/.nZ6emppgIZN5htjDBpYLWE.mSVBivmstuXC', 'admin', 0),
(3, 'Tuan', 'tuan.tranraven621@hcmut.edu.vn', '$2y$10$8K3U4PNqgr00prL8L4xQ8ulElnw50QCKjVRraONmwXxhIZFEtkwme', 'user', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
