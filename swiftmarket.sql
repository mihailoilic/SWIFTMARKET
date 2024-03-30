-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2021 at 04:37 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swiftmarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

CREATE TABLE `bans` (
  `ban_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ban_description` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_category_id` int(11) DEFAULT NULL,
  `category_image_id` int(11) DEFAULT NULL,
  `genders_apply` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `parent_category_id`, `category_image_id`, `genders_apply`) VALUES
(1, 'Electronic devices', NULL, 146, 0),
(2, 'Household, appliances & furniture', NULL, 0, 0),
(3, 'Books & magazines', NULL, 0, 0),
(4, 'Clothing', NULL, 0, 1),
(5, 'Footwear', NULL, 0, 1),
(6, 'Accessories', NULL, 0, 1),
(7, 'Health & beauty', NULL, 0, 0),
(8, 'Phones', 1, NULL, 0),
(9, 'Tablets', 1, NULL, 0),
(10, 'Desktop PCs', 1, NULL, 0),
(11, 'Laptops', 1, NULL, 0),
(12, 'TVs', 1, NULL, 0),
(13, 'Audio/Video', 1, NULL, 0),
(15, 'Furniture', 2, NULL, 0),
(16, 'Home appliances', 2, NULL, 0),
(17, 'Home decor', 2, NULL, 0),
(18, 'Kitchen', 2, NULL, 0),
(19, 'Garden', 2, NULL, 0),
(21, 'Books', 3, NULL, 0),
(22, 'Magazines', 3, NULL, 0),
(23, 'Dresses', 4, NULL, 0),
(24, 'Tops, tees & blouses', 4, NULL, 0),
(25, 'Hoodies & sweatshirts', 4, NULL, 0),
(26, 'Jeans & pants', 4, NULL, 0),
(27, 'Skirts', 4, NULL, 0),
(28, 'Leggings', 4, NULL, 0),
(29, 'Coats & jackets', 4, NULL, 0),
(30, 'Suiting & blazers', 4, NULL, 0),
(31, 'Socks', 4, NULL, 0),
(32, 'Sneakers', 5, NULL, 0),
(33, 'Boots', 5, NULL, 0),
(34, 'Shoes', 5, NULL, 0),
(35, 'Sandals', 5, NULL, 0),
(36, 'Slippers', 5, NULL, 0),
(37, 'Pumps', 5, NULL, 0),
(38, 'Jewelry', 6, NULL, 0),
(39, 'Wallets', 6, NULL, 0),
(40, 'Sunglasses', 6, NULL, 0),
(41, 'Hats & gloves', 6, NULL, 0),
(43, 'Hair & skin care', 7, NULL, 0),
(44, 'Fragrance', 7, NULL, 0),
(45, 'Makeup', 7, NULL, 0),
(46, 'Supplements', 7, NULL, 0),
(48, 'Headphones', 1, NULL, 0),
(452, 'Other', 1, NULL, 0),
(1457, 'Other', 2, NULL, 0),
(4245, 'Other', 6, NULL, 0),
(4747, 'Other', 4, NULL, 0),
(4755, 'Other', 7, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

CREATE TABLE `conditions` (
  `condition_id` int(11) NOT NULL,
  `condition_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conditions`
--

INSERT INTO `conditions` (`condition_id`, `condition_name`) VALUES
(1, 'New'),
(2, 'Used, like new'),
(3, 'Used'),
(4, 'Used, damaged'),
(5, 'Refurbished');

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `gender_id` int(11) NOT NULL,
  `gender_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`gender_id`, `gender_name`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Unisex'),
(4, 'Kids'),
(5, 'Boys'),
(6, 'Girls');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `image_filename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_thumbnail_filename` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `image_filename`, `image_thumbnail_filename`, `image_title`, `product_id`) VALUES
(0, 'test.jpg', 'test.jpg', 'Test img', NULL),
(17, '0.94036800 1622649112.jpg', '0.07974300 1622649113-thumbnail.jpg', 'Novi', 10),
(18, '0.10109200 1622649113.jpg', '0.14293100 1622649113-thumbnail.jpg', 'Novi', 10),
(19, '0.34053200 1622668076.jpg', '0.34441200 1622668076-thumbnail.jpg', 'Novi item idemoo asdfds asfdas fas fdsa sadf', 11),
(20, '0.47367200 1622668076.jpg', '0.54152100 1622668076-thumbnail.jpg', 'Novi item idemoo asdfds asfdas fas fdsa sadf', 11),
(23, '0.55208500 1622803095.jpg', '0.62066800 1622803095-thumbnail.jpg', 'New iPhone 12 mini 256GB Purple Unlocked', 14),
(24, '0.75949100 1622803095.jpg', '0.82260000 1622803095-thumbnail.jpg', 'New iPhone 12 mini 256GB Purple Unlocked', 14),
(25, '0.83113400 1622803095.jpg', '0.88990900 1622803095-thumbnail.jpg', 'New iPhone 12 mini 256GB Purple Unlocked', 14),
(26, '0.23736100 1622803533.jpg', '0.30755300 1622803533-thumbnail.jpg', 'Apple iPhone 11 64gb', 15),
(27, '0.31806300 1622803533.jpg', '0.37912300 1622803533-thumbnail.jpg', 'Apple iPhone 11 64gb', 15),
(28, '0.51933100 1622803533.jpg', '0.58865600 1622803533-thumbnail.jpg', 'Apple iPhone 11 64gb', 15),
(29, '0.00648500 1622804290.jpg', '0.07346800 1622804290-thumbnail.jpg', 'The World Atlas of Birds Hardcover Book', 16),
(30, '0.21822600 1622804290.jpg', '0.28075500 1622804290-thumbnail.jpg', 'The World Atlas of Birds Hardcover Book', 16),
(31, '0.41929100 1622804290.jpg', '0.48336000 1622804290-thumbnail.jpg', 'The World Atlas of Birds Hardcover Book', 16),
(32, '0.97116100 1622804570.jpg', '0.01189000 1622804571-thumbnail.jpg', 'VALUES OF THE GAME (Basketball) Book', 17),
(33, '0.96034400 1622804858.jpg', '0.03062200 1622804859-thumbnail.jpg', 'AQUARIOLOGY Hard Cover Book', 18),
(34, '0.17356300 1622804859.jpg', '0.23739100 1622804859-thumbnail.jpg', 'AQUARIOLOGY Hard Cover Book', 18),
(35, '0.52361100 1622805125.jpg', '0.59006700 1622805125-thumbnail.jpg', 'New Samsung Black Galaxy Buds Plus', 19),
(36, '0.72974300 1622805125.jpg', '0.80327500 1622805125-thumbnail.jpg', 'New Samsung Black Galaxy Buds Plus', 19),
(37, '0.253534001622805317.jpg', '0.327224001622805317-thumbnail.jpg', 'Northface hedgehog hiking shoes boots', 20),
(38, '0.468628001622805317.jpg', '0.537241001622805317-thumbnail.jpg', 'Northface hedgehog hiking shoes boots', 20),
(39, '0.797021001622805659.jpg', '0.880540001622805659-thumbnail.jpg', 'Cruising World - magazine back issues 1975-1995', 21),
(40, '0.893813001622805659.jpg', '0.964539001622805659-thumbnail.jpg', 'Cruising World - magazine back issues 1975-1995', 21),
(41, '0.976933001622805659.jpg', '0.042279001622805660-thumbnail.jpg', 'Cruising World - magazine back issues 1975-1995', 21),
(42, '0.078228001622805806.jpg', '0.150562001622805806-thumbnail.jpg', 'iphone 12 pro 256gb', 22),
(43, '0.162587001622805806.jpg', '0.230669001622805806-thumbnail.jpg', 'iphone 12 pro 256gb', 22),
(44, '0.374332001622805806.jpg', '0.444833001622805806-thumbnail.jpg', 'iphone 12 pro 256gb', 22),
(45, '0.454469001622805806.jpg', '0.517321001622805806-thumbnail.jpg', 'iphone 12 pro 256gb', 22),
(46, '0.130989001622806502.jpg', '0.206771001622806502-thumbnail.jpg', 'IPhone 12 pro 128g Factory Unlocked Black', 23),
(47, '0.217819001622806502.jpg', '0.275285001622806502-thumbnail.jpg', 'IPhone 12 pro 128g Factory Unlocked Black', 23),
(48, '0.285227001622806502.jpg', '0.344763001622806502-thumbnail.jpg', 'IPhone 12 pro 128g Factory Unlocked Black', 23),
(49, '0.912506001622806956.jpg', '0.986549001622806956-thumbnail.jpg', 'S21 ultra 256gb phantom brown BRAND NEW', 24),
(50, '0.000105001622806957.jpg', '0.061087001622806957-thumbnail.jpg', 'S21 ultra 256gb phantom brown BRAND NEW', 24),
(51, '0.072490001622806957.jpg', '0.131232001622806957-thumbnail.jpg', 'S21 ultra 256gb phantom brown BRAND NEW', 24),
(52, '0.142891001622806957.jpg', '0.201180001622806957-thumbnail.jpg', 'S21 ultra 256gb phantom brown BRAND NEW', 24),
(53, '0.076969001622807053.jpg', '0.141200001622807053-thumbnail.jpg', 'iPhone SE 2 (2020) 128 gb red UNLOCKED', 25),
(54, '0.152859001622807053.jpg', '0.213534001622807053-thumbnail.jpg', 'iPhone SE 2 (2020) 128 gb red UNLOCKED', 25),
(55, '0.103468001622807152.jpg', '0.171625001622807152-thumbnail.jpg', 'iPhone XR 64GB Coral', 26),
(56, '0.313515001622807152.jpg', '0.380477001622807152-thumbnail.jpg', 'iPhone XR 64GB Coral', 26),
(57, '0.526537001622807152.jpg', '0.590441001622807152-thumbnail.jpg', 'iPhone XR 64GB Coral', 26),
(58, '0.728663001622807152.jpg', '0.791453001622807152-thumbnail.jpg', 'iPhone XR 64GB Coral', 26),
(59, '0.902979001622807241.jpg', '0.936127001622807241-thumbnail.jpg', 'Original HTC earbud + Cushions, Cable & Volume Control', 27),
(60, '0.942013001622807241.jpg', '0.978774001622807241-thumbnail.jpg', 'Original HTC earbud + Cushions, Cable & Volume Control', 27),
(61, '0.897952001622807360.jpg', '0.967238001622807360-thumbnail.jpg', 'One Plus 6T 128g Unlocked', 28),
(62, '0.976723001622807360.jpg', '0.040155001622807361-thumbnail.jpg', 'One Plus 6T 128g Unlocked', 28),
(63, '0.050337001622807361.jpg', '0.111810001622807361-thumbnail.jpg', 'One Plus 6T 128g Unlocked', 28),
(64, '0.093417001622807474.jpg', '0.163545001622807474-thumbnail.jpg', 'For sale over head headphone BackBeat Fit 6100', 29),
(65, '0.312855001622807474.jpg', '0.381295001622807474-thumbnail.jpg', 'For sale over head headphone BackBeat Fit 6100', 29),
(66, '0.059118001622837262.jpg', '0.129509001622837262-thumbnail.jpg', 'Samsung Galaxy S7 for parts, w/ Sprint SIM card', 30),
(67, '0.141762001622837262.jpg', '0.207647001622837262-thumbnail.jpg', 'Samsung Galaxy S7 for parts, w/ Sprint SIM card', 30),
(68, '0.590335001622837951.jpg', '0.662310001622837951-thumbnail.jpg', 'Samsung S10 Plus unlocked 512GB', 31),
(69, '0.674259001622837951.jpg', '0.733865001622837951-thumbnail.jpg', 'Samsung S10 Plus unlocked 512GB', 31),
(70, '0.968561001622838158.jpg', '0.046302001622838159-thumbnail.jpg', 'Samsung galaxy note 9 128g T-mobile ,Metro ,Sprint', 32),
(71, '0.056854001622838159.jpg', '0.114246001622838159-thumbnail.jpg', 'Samsung galaxy note 9 128g T-mobile ,Metro ,Sprint', 32),
(72, '0.123590001622838159.jpg', '0.180358001622838159-thumbnail.jpg', 'Samsung galaxy note 9 128g T-mobile ,Metro ,Sprint', 32),
(73, '0.190005001622838159.jpg', '0.242753001622838159-thumbnail.jpg', 'Samsung galaxy note 9 128g T-mobile ,Metro ,Sprint', 32),
(74, '0.005149001622838316.jpg', '0.060560001622838316-thumbnail.jpg', 'Apple iPad Pro (32GB, Wi-Fi, Space Gray) 12.9in Tablet', 33),
(75, '0.070339001622838316.jpg', '0.133149001622838316-thumbnail.jpg', 'Apple iPad Pro (32GB, Wi-Fi, Space Gray) 12.9in Tablet', 33),
(76, '0.505062001622838498.jpg', '0.546757001622838498-thumbnail.jpg', 'LIKE NEW WHITE LTE SONY Z3 8” WATERPROOF TABLET WITH SCR PROTECTOR', 34),
(77, '0.553640001622838498.jpg', '0.592597001622838498-thumbnail.jpg', 'LIKE NEW WHITE LTE SONY Z3 8” WATERPROOF TABLET WITH SCR PROTECTOR', 34),
(79, '0.598289001622838699.jpg', '0.668722001622838699-thumbnail.jpg', 'Samsung Galaxy Tab A SM-T350 8-Inch Tablet (16 GB, Titanium)', 35),
(80, '0.689494001622838699.jpg', '0.759505001622838699-thumbnail.jpg', 'Samsung Galaxy Tab A SM-T350 8-Inch Tablet (16 GB, Titanium)', 35),
(81, '0.430994001622838853.jpg', '0.505109001622838853-thumbnail.jpg', 'HP 23 Touchscreen All-in-One desktop computer', 36),
(82, '0.022410001622838940.jpg', '0.097369001622838940-thumbnail.jpg', 'HP HPE 410t - Intel I5, 6Gb, 1TB, Wi-Fi, Windows 7 Tower', 37),
(83, '0.110437001622838940.jpg', '0.178048001622838940-thumbnail.jpg', 'HP HPE 410t - Intel I5, 6Gb, 1TB, Wi-Fi, Windows 7 Tower', 37),
(84, '0.049841001622839000.jpg', '0.115711001622839000-thumbnail.jpg', 'Macbook Pro 13, 16GB RAM space gray', 38),
(85, '0.411401001622839111.jpg', '0.486654001622839111-thumbnail.jpg', 'Lenovo ThinkPad T420 laptop Win10 i7@2.8Ghz SSD 500 8GB MS Office 2019', 39),
(86, '0.500332001622839111.jpg', '0.565465001622839111-thumbnail.jpg', 'Lenovo ThinkPad T420 laptop Win10 i7@2.8Ghz SSD 500 8GB MS Office 2019', 39),
(87, '0.666172001622839203.jpg', '0.734021001622839203-thumbnail.jpg', 'Microsoft Surface Pro 4 Intel Core i5 256 GB SSD 8 GB RAM', 40),
(88, '0.868627001622839203.jpg', '0.930076001622839203-thumbnail.jpg', 'Microsoft Surface Pro 4 Intel Core i5 256 GB SSD 8 GB RAM', 40),
(89, '0.411469001622839681.jpg', '0.509377001622839681-thumbnail.jpg', 'Sony VAIO VPCEA290X laptop & Core i3 & 14.0\" REFURBISHED & 30day WARRANTY', 41),
(90, '0.728689001622839828.jpg', '0.813857001622839828-thumbnail.jpg', 'MacBook Pro 13 - 2015', 42),
(91, '0.960503001622839828.jpg', '0.038700001622839829-thumbnail.jpg', 'MacBook Pro 13 - 2015', 42),
(92, '0.285418001622839874.jpg', '0.327650001622839874-thumbnail.jpg', 'Item Test', 43),
(93, '0.137639001622840203.jpg', '0.205463001622840203-thumbnail.jpg', 'MacBook Pro 16\" 2020', 44),
(94, '0.222317001622840358.jpg', '0.304049001622840358-thumbnail.jpg', 'MacBook Pro 16', 45),
(95, '0.380233001622840826.jpg', '0.447172001622840826-thumbnail.jpg', 'Macbook 2015 + Brand New Battery + Box ', 46),
(96, '0.013345001622841022.jpg', '0.089920001622841022-thumbnail.jpg', 'Xbox Series X - *New', 47),
(97, '0.604772001622847146.jpg', '0.632201001622847146-thumbnail.jpg', 'Sharp Quattron 60 inch LCD HD TV', 48),
(98, '0.639392001622847146.jpg', '0.643345001622847146-thumbnail.jpg', 'Sharp Quattron 60 inch LCD HD TV', 48),
(99, '0.907835001622847312.jpg', '0.960233001622847312-thumbnail.jpg', '55\" Samsung 4k smart tv', 49),
(100, '0.060211001622847313.jpg', '0.103325001622847313-thumbnail.jpg', '55\" Samsung 4k smart tv', 49),
(101, '0.041748001622847576.jpg', '0.111182001622847576-thumbnail.jpg', 'Sony CD AM/FM Mini Stereo Audio System', 50),
(102, '0.254756001622847576.jpg', '0.320397001622847576-thumbnail.jpg', 'Sony CD AM/FM Mini Stereo Audio System', 50),
(103, '0.531138001622847714.jpg', '0.599878001622847714-thumbnail.jpg', 'Samsung 2.1 Soundbar and Subwoofer HW-MM45C', 51),
(104, '0.611076001622847714.jpg', '0.674231001622847714-thumbnail.jpg', 'Samsung 2.1 Soundbar and Subwoofer HW-MM45C', 51),
(105, '0.688069001622847714.jpg', '0.749583001622847714-thumbnail.jpg', 'Samsung 2.1 Soundbar and Subwoofer HW-MM45C', 51),
(106, '0.924053001622847845.jpg', '0.995262001622847845-thumbnail.jpg', 'Coaster Phoenix Contemporary Youth Storage Bed in Cappuccino', 52),
(107, '0.004137001622847846.jpg', '0.063856001622847846-thumbnail.jpg', 'Coaster Phoenix Contemporary Youth Storage Bed in Cappuccino', 52),
(108, '0.330108001622847929.jpg', '0.403438001622847929-thumbnail.jpg', 'Baker\'s Rack', 53),
(109, '0.663806001622848052.jpg', '0.737120001622848052-thumbnail.jpg', 'GE Refrigerator like new', 54),
(110, '0.750569001622848052.jpg', '0.820630001622848052-thumbnail.jpg', 'GE Refrigerator like new', 54),
(111, '0.455417001622848150.jpg', '0.543813001622848150-thumbnail.jpg', '18,000 BTU 1.5 Ton ductless mini split air conditioner', 55),
(112, '0.649326001622848150.jpg', '0.699321001622848150-thumbnail.jpg', '18,000 BTU 1.5 Ton ductless mini split air conditioner', 55),
(113, '0.459460001622848259.jpg', '0.535912001622848259-thumbnail.jpg', 'Mid century Santa Cruz artist signed still life painting', 56),
(114, '0.551401001622848259.jpg', '0.623356001622848259-thumbnail.jpg', 'Mid century Santa Cruz artist signed still life painting', 56),
(115, '0.963954001622848319.jpg', '0.039617001622848320-thumbnail.jpg', 'Beautiful Pillar Candle Holders', 57),
(116, '0.823004001622848409.jpg', '0.894149001622848409-thumbnail.jpg', 'Lot of porcelain & Antique coffee mugs and kitchen ware', 58),
(117, '0.030615001622848410.jpg', '0.095513001622848410-thumbnail.jpg', 'Lot of porcelain & Antique coffee mugs and kitchen ware', 58),
(118, '0.893178001622848513.jpg', '0.968958001622848513-thumbnail.jpg', 'Kitchen Towel 8 Piece Set', 59),
(119, '0.123809001622848514.jpg', '0.197647001622848514-thumbnail.jpg', 'Kitchen Towel 8 Piece Set', 59),
(120, '0.838783001622848616.jpg', '0.915877001622848616-thumbnail.jpg', 'Weber BBQ', 60),
(121, '0.928488001622848616.jpg', '0.997624001622848616-thumbnail.jpg', 'Weber BBQ', 60),
(122, '0.535829001622848823.jpg', '0.639770001622848823-thumbnail.jpg', 'String of Rubies succulent', 61),
(123, '0.649576001622848823.jpg', '0.718293001622848823-thumbnail.jpg', 'String of Rubies succulent', 61),
(124, '0.921495001622849334.jpg', '0.991793001622849334-thumbnail.jpg', 'Clothes Hamper', 62),
(125, '0.153124001622982433.jpg', '0.229503001622982433-thumbnail.jpg', 'Walt Disney Minnie Mouse T-Shirt', 63),
(126, '0.345259001622982729.jpg', '0.429437001622982729-thumbnail.jpg', 'Levi’s women 710 super skinny jeans - waist 30', 64),
(127, '0.443261001622982729.jpg', '0.512400001622982729-thumbnail.jpg', 'Levi’s women 710 super skinny jeans - waist 30', 64),
(128, '0.525529001622982729.jpg', '0.589291001622982729-thumbnail.jpg', 'Levi’s women 710 super skinny jeans - waist 30', 64),
(129, '0.644055001622982914.jpg', '0.700814001622982914-thumbnail.jpg', '12-14 Boy clothes -great for the season', 65),
(130, '0.797826001622982914.jpg', '0.850551001622982914-thumbnail.jpg', '12-14 Boy clothes -great for the season', 65),
(131, '0.997480001622982914.jpg', '0.073836001622982915-thumbnail.jpg', '12-14 Boy clothes -great for the season', 65),
(132, '0.784183001622983156.jpg', '0.866653001622983156-thumbnail.jpg', 'BAPE Double Knit Side Shark Shorts Black', 66),
(133, '0.878692001622983156.jpg', '0.953430001622983156-thumbnail.jpg', 'BAPE Double Knit Side Shark Shorts Black', 66),
(146, '0.654964001623004334.jpg', '0.743641001623004334-thumbnail.jpg', 'Cover image', NULL),
(148, '0.190012001623004398.jpg', '0.285789001623004398-thumbnail.jpg', 'Cover image', NULL),
(149, '0.102730001623251306.jpg', '0.231548001623251306-thumbnail.jpg', 'Cover image', NULL),
(150, '0.930734001623251423.jpeg', '0.025023001623251424-thumbnail.jpeg', 'Cover image', NULL),
(151, '0.203406001623251495.jpg', '0.357364001623251495-thumbnail.jpg', 'Cover image', NULL),
(152, '0.910071001623251802.jpg', '0.066459001623251803-thumbnail.jpg', 'Cover image', NULL),
(153, '0.077357001623251986.jpeg', '0.227002001623251986-thumbnail.jpeg', 'Cover image', NULL),
(154, '0.111796001623252081.jpg', '0.408351001623252081-thumbnail.jpg', 'Cover image', NULL),
(155, '0.560631001623258064.jpg', '0.717316001623258064-thumbnail.jpg', 'Cover image', NULL),
(156, '0.979386001623258117.jpg', '0.131732001623258118-thumbnail.jpg', 'Cover image', NULL),
(157, '0.148471001623258340.jpg', '0.325569001623258340-thumbnail.jpg', 'Cover image', NULL),
(158, '0.457839001623258553.jpg', '0.714759001623258553-thumbnail.jpg', 'Cover image', NULL),
(159, '0.436810001623266340.', '0.436977001623266340-thumbnail.', '', 67),
(160, '0.750432001623267039.', '0.750598001623267039-thumbnail.', '', 68),
(161, '0.748469001623276934.jpg', '0.766698001623276934-thumbnail.jpg', 'Alex Evening Cowl Neck Glitter Gown', 75),
(162, '0.407771001623277393.jpg', '0.491471001623277393-thumbnail.jpg', 'Couch - Good/Fair Condition', 76),
(163, '0.502331001623277393.jpg', '0.589968001623277393-thumbnail.jpg', 'Couch - Good/Fair Condition', 76);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `message_text` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `message_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `offer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `offer_price` decimal(10,1) NOT NULL,
  `offer_status` tinyint(4) NOT NULL DEFAULT 0,
  `seller_new_messages` int(11) NOT NULL DEFAULT 0,
  `buyer_new_messages` int(11) NOT NULL DEFAULT 0,
  `buyer_rating` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`offer_id`, `product_id`, `buyer_id`, `offer_price`, `offer_status`, `seller_new_messages`, `buyer_new_messages`, `buyer_rating`) VALUES
(14, 11, 2, '1000.0', 1, 0, 1, 4),
(18, 11, 3, '233.0', 2, 0, 0, NULL),
(20, 10, 3, '54.0', 1, 0, 0, NULL),
(21, 22, 6, '1000.0', 0, 0, 0, NULL),
(22, 15, 6, '350.0', 0, 0, 0, NULL),
(23, 14, 6, '900.0', 0, 1, 0, NULL),
(24, 29, 6, '90.0', 0, 0, 0, NULL),
(25, 24, 6, '1400.0', 0, 0, 0, NULL),
(26, 14, 5, '850.0', 0, 0, 0, NULL),
(27, 43, 2, '400.0', 1, 0, 0, 5),
(28, 45, 5, '2400.0', 1, 0, 0, 5),
(29, 46, 3, '390.0', 1, 0, 0, 5),
(30, 14, 3, '750.0', 0, 0, 0, NULL),
(35, 32, 7, '250.0', 0, 0, 0, NULL),
(38, 14, 7, '750.0', 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `page_info`
--

CREATE TABLE `page_info` (
  `page_id` int(11) NOT NULL,
  `page_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_image_id` int(11) NOT NULL,
  `show_on_nav` tinyint(4) NOT NULL DEFAULT 0,
  `requires_auth` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_info`
--

INSERT INTO `page_info` (`page_id`, `page_name`, `page_title`, `page_description`, `page_image_id`, `show_on_nav`, `requires_auth`) VALUES
(1, 'home', 'Buy & Sell Items With Ease', 'Welcome to SWIFT community!', 158, 1, 0),
(2, 'buy', 'Buy Items', 'Begin your shopping adventure', 155, 1, 0),
(3, 'sell', 'Sell Items', 'Time to earn some money', 156, 1, 0),
(4, 'contact', 'Contact Us', 'Ask us anything, anytime', 150, 1, 0),
(5, 'author', 'About Author', 'Learn more about the developer', 0, 1, 0),
(11, 'admin', 'Website Management', 'Welcome, administrator!', 154, 0, 1),
(12, 'profile', 'Your Profile', 'View & edit your information', 0, 0, 1),
(13, 'wish-list', 'Your Wish List', 'Items you liked', 0, 0, 1),
(16, 'user-products', 'My items', 'All items that you created', 0, 0, 1),
(17, 'user-offers', 'My offers', 'See all offers that you made', 153, 0, 1),
(18, 'c-h-a-t', 'Chat', 'Strike a bargain and agree on delivery terms', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` decimal(10,1) DEFAULT NULL,
  `condition_id` int(11) NOT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `seller_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_views` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_price`, `condition_id`, `gender_id`, `seller_id`, `category_id`, `product_date_created`, `product_views`, `active`) VALUES
(10, 'Novi Proizvod', 'Proizvod', '10233.0', 1, 2, 1, 23, '2021-06-02 15:51:52', 171, 0),
(11, 'Novi item idemoo ', 'sdfDASf dasf dasf sdf dasf dsfsdfDASf dasf dasf sdf dasf dsfsdfDASf dasf dasf sdf dasf dsfsdfDASf dasf dasf sdf dasf dsfsdfDASf dasf dasf sdf dasf dsf', '1023.0', 2, NULL, 1, 8, '2021-06-02 21:07:56', 31, 0),
(14, 'New iPhone 12 mini 256GB Purple Unlocked', 'A brand new iPhone 12 mini 256GB Purple unlocked, works for any carrier. Open the box just to take out sim card. Phone is not activated, never turned on. I can meet now, delivery OK for a fee.', '949.0', 1, NULL, 2, 8, '2021-06-04 10:38:15', 204, 1),
(15, 'Apple iPhone 11 64gb', 'Selling my Apple iPhone 11 64gb in black. It’s in great condition and has little to no scratches (the pictures speak for themselves!). I originally purchased it from T-Mobile but I’ve fully paid off the device so it’s good to use. I can keep the screen protector on or take it off, whatever your preference is.', '420.0', 3, NULL, 4, 8, '2021-06-04 10:45:33', 20, 1),
(16, 'The World Atlas of Birds Hardcover Book', 'THE WORLD ATLAS OF BIRDS\r\nFOREWORD by ROGER TORY PETERSON\r\nCONSULTANT EDITOR\r\nSIR PETER SCOTT\r\nADVISORY EDITOR FOR AMERICA\r\nOLIN SEWALL PETTINGILL JR.\r\n\r\nThe World Atlas of Birth selects more than five hundred species of birds and examine, them in depth. region by region choosing each one to illustrate a particular facet of bird-life - a hunting technique or physical specialization\" courtship behavior or feeding habit. ', '25.0', 3, NULL, 4, 21, '2021-06-04 10:58:09', 8, 1),
(17, 'VALUES OF THE GAME (Basketball) Book', 'By Bill Bradley & Phil Jackson\r\nHard Bound, Excellent Condition\r\n\r\n\"In many ways basketball was a lens through which I looked at life--I had learned to make judgments about character from what I saw players do on the court.\" --Bill Bradley Bradley, former U.S. senator and presidential candidate and member of two championship New York Knicks teams, returns to the scene of his first career, and first passion, in Values of the Game.', '22.0', 2, NULL, 4, 21, '2021-06-04 11:02:50', 3, 1),
(18, 'AQUARIOLOGY Hard Cover Book', 'Dr John Gratzek et al.\r\n95 pages\r\nTetra Press\r\nhard cover\r\n7.5\" x 10.5\"', '4.0', 3, NULL, 4, 21, '2021-06-04 11:07:38', 2, 1),
(19, 'New Samsung Black Galaxy Buds Plus', 'Brand New in sealed box\r\nSamsung Galaxy Buds+\r\nBlack', '85.0', 1, NULL, 4, 48, '2021-06-04 11:12:05', 2, 1),
(20, 'Northface hedgehog hiking shoes boots', 'Woman’s 8.5 Northface Hedgehog hiking boots. Barely used.', '25.0', 3, 2, 4, 34, '2021-06-04 11:15:17', 2, 1),
(21, 'Cruising World - magazine back issues 1975-1995', 'Cruising World magazine collection. Original subscriber. Mostly complete from 1975-1989; see complete list below. \r\n\r\nOct 75 (first Boat Show Issue)\r\nJul/Aug 76, Sep 76,Oct 76, Nov/Dec 76\r\nJan-Dec 77\r\nJan-Dec 78 (no Sep)\r\nJan-Dec 79\r\nJan-Dec 80 (no Feb)\r\nJan-Dec 81\r\nJan-Dec 82\r\nJan-Dec 83\r\nJan-Dec 84\r\nJan-Dec 85\r\nJan-Dec 86\r\nJan-Dec 87\r\nJan-Dec 88 (no Sep)\r\nJan-Mar, Sep 89\r\nNov 92\r\nJul, Aug 95', '10.0', 3, NULL, 4, 22, '2021-06-04 11:20:59', 1, 1),
(22, 'iphone 12 pro 256gb', '256gb Space Grey\r\n\r\nComes with box and 2 cases\r\n\r\nunlocked\r\n\r\ncash only', '1050.0', 2, NULL, 4, 8, '2021-06-04 11:23:26', 9, 1),
(23, 'IPhone 12 pro 128g Factory Unlocked Black', 'Still available if you see this post .\r\nFactory unlocked for all carriers in flawless condition,no shipping. Price is not negotiable I will not reply to lower offers. Serious buyers only please. NO SHIPPING , SEND ME A CODE LOW LIFE LOSERS !!', '900.0', 2, NULL, 5, 8, '2021-06-04 11:35:01', 4, 1),
(24, 'S21 ultra 256gb phantom brown BRAND NEW', 'Hello,\r\n\r\nBrand new s21 ultra phanton brown unopened! Sealed with cases and chargers. (Pic is my wife\'s for example)\r\n\r\nI ordered this one directly from Samsung but it took over a month to arrive! Ended up finding one on ebay sealed too.\r\n\r\nRare color and you don\'t need to wait for it!\r\n\r\nHonestly way better picture screen and features than iphone. I have an iPhone too on another line so tested back to back. Alot of texting upgrades. My family Wants to switch!', '1650.0', 1, NULL, 5, 8, '2021-06-04 11:42:36', 35, 1),
(25, 'iPhone SE 2 (2020) 128 gb red UNLOCKED', 'iPhone SE 2 (2020) 128 gb red UNLOCKED\r\n\r\nPerfect condition\r\n\r\nUnlocked', '300.0', 2, NULL, 5, 8, '2021-06-04 11:44:13', 11, 1),
(26, 'iPhone XR 64GB Coral', 'iPhone XR in coral with 64GB storage. Excellent condition - screen has always been under a screen protector and is flawless. Battery has 89% capacity remaining. Phone is unlocked and ready to use with any carrier. Original box and new screen protectors are included, and I can include a charger as well if desired.\r\n\r\nI\'m the original owner.', '380.0', 3, NULL, 5, 8, '2021-06-04 11:45:51', 36, 1),
(27, 'Original HTC earbud + Cushions, Cable & Volume Con', 'Brand New Original HTC 3.5mm Stereo In-ear Earphones/Earbuds Headset MiC Earphones with Volume Control and micro cable for Computer data transfer. also a set of extra cushions as you see in the pictures.\r\nIt might as well be compatible with other mobile phones.\r\n\r\nRespond with your phone number, if interested.', '15.0', 3, NULL, 5, 48, '2021-06-04 11:47:21', 2, 1),
(28, 'One Plus 6T 128g Unlocked', 'Unlocked for all carriers in excellent condition, phone only. No trades or shipping. Price is NOT negotiable, I don\'t reply to lower offers. Don\'t ask if you are not a serious buyer please. Thanks', '200.0', 3, NULL, 2, 8, '2021-06-04 11:49:20', 2, 1),
(29, 'For sale over head headphone BackBeat Fit 6100', 'BackBeat Fit 6100 barely used.', '110.0', 2, NULL, 2, 48, '2021-06-04 11:51:13', 14, 1),
(30, 'Samsung Galaxy S7 for parts, w/ Sprint SIM card', 'I bought this phone off of ebay with the hopes that the LCD could be salvaged. The rear cover had already been removed. The ad stated that the phone would not charge so they had no way to test the display. I was hoping it was only a battery or charge port problem, but it turns out the LCD is also broken.\r\n\r\nI\'m offering this phone for parts. The battery is bad and the LCD display is broken. All other parts should be good, including: mother board with rear camera, daughter board, charge port, sid', '15.0', 4, NULL, 2, 8, '2021-06-04 20:07:42', 6, 1),
(31, 'Samsung S10 Plus unlocked 512GB', '- Phone works internationally.\r\n- Compatible with any carriers.\r\n- Clean, financed history (will never be blacklist).\r\n- Trusted seller, 2-month warranty.', '550.0', 1, NULL, 6, 8, '2021-06-04 20:19:11', 1, 1),
(32, 'Samsung galaxy note 9 128g T-mobile ,Metro ,Sprint', 'In excellent condition for T-mobile,Metro,Sprint. Phone only, no shipping. Price is not negotiable, don\'t waste your time with lower offers please', '310.0', 2, NULL, 6, 8, '2021-06-04 20:22:38', 81, 1),
(33, 'Apple iPad Pro (32GB, Wi-Fi, Space Gray) 12.9in Ta', 'Lightly used, no scratches or cosmetic damage. I can supply a charger, cable, and a black UAG case.\r\n\r\nIt has been completely wiped, and is ready for a new PW and apple sign in.', '350.0', 3, NULL, 6, 9, '2021-06-04 20:25:15', 16, 1),
(34, 'WHITE LTE SONY Z3 8” WATERPROOF TABLET W/ SCR PROT', 'anyone who interested in it, contact me', '339.0', 2, NULL, 6, 9, '2021-06-04 20:28:18', 2, 1),
(35, 'Samsung Galaxy Tab A SM-T350 8-Inch Tablet (16 GB,', 'Product works and looks like new.\r\n\r\nI bought it 2 years ago and used it for a short time, tablet has no scratches or any dings. Included are the tablet, USB cable, and charger.\r\n\r\nPerfect for your child\'s first tablet so they can play games and use educational apps, etc..\r\n\r\nScreen Size 8 Inches\r\nBrand Samsung\r\nSeries Galaxy Tab A\r\nMemory Storage Capacity 16 GB\r\nItem Dimensions LxWxH 16 x 10 x 16 inches\r\n\r\nOperating system, Android 5.0 Lollipop\r\nPackage Dimensions, 6.35 L x 27.432 H x 21.082 W ', '40.0', 3, NULL, 6, 9, '2021-06-04 20:31:39', 7, 1),
(36, 'HP 23 Touchscreen All-in-One desktop computer', 'HP 23 Touchscreen All-in-One desktop computer, comes with keyboard and mouse.\r\n\r\nSpecs:\r\n\r\nIntel i5 Quad Core with 3.2ghz\r\n4gb ram\r\n500GB Hard Drive\r\n23\" Touchscreen\r\nBuilt in Webcam (good for zoom)\r\nWiFi\r\nHDMI port\r\nDVD drive\r\n\r\nWindow 10 fresh installed and activated.\r\n\r\n$275 for the whole set.', '275.0', 3, NULL, 6, 10, '2021-06-04 20:34:13', 4, 1),
(37, 'HP HPE 410t - Intel I5, 6Gb, 1TB, Wi-Fi, Windows 7', 'HP HPE 410t\r\nIntel I5-760 2.8 Ghz,\r\n4 Cores. 4 Threads,\r\n6Gb DDR3, 1TB SATA Drive\r\nWi-Fi, DVD-RW Drive\r\nNvidia GeForce 315 graphics card\r\nHDMI, DVI\r\nWin 7 - 64 bit\r\nNero, Oracle Open Office\r\n\r\n$65 with Keyboard and Mouse\r\nAdd $20 for 22\" LCD Monitor', '65.0', 3, NULL, 6, 10, '2021-06-04 20:35:40', 2, 1),
(38, 'Macbook Pro 13, 16GB RAM space gray', 'Macbook Pro 13 space gray, 16 gb, 256GB, Four Thunderbolt 3 Ports\r\nLike new\r\nNo issues at all. Comes with charger.', '1000.0', 2, NULL, 6, 11, '2021-06-04 20:36:39', 1, 1),
(39, 'Lenovo ThinkPad T420 laptop Win10 i7@2.8Ghz SSD 500 8GB MS Office 2019', '14 Lenovo ThinkPad T420 laptop Win10 Pro i7 @2.8GHz Chip SSD 500Gb RAM 8Gb Microsoft Office 2019 Notebook\r\n\r\n- Firmed Price\r\n- Work Great - No Issue\r\n- Condition 9/10\r\n\r\n14 inches Lenovo ThinkPad T420\r\n\r\nIntel i7 @2.8GHz\r\n\r\nDual GPU 1Gb Nvidia 4200M\r\nScreen Resolution 1600 x 900p\r\n\r\n8GB RAM Memory\r\n\r\n500Gb Intel SSD SATA - Solid State Drive\r\n\r\nWin 10 Pro with 64 Bit Genuine Version\r\n\r\nMicrosoft Office 2019 with 64 Bit Genuine Version\r\n\r\nVirus scan detection\r\n\r\nAll drivers are loaded without conflicting\r\n\r\nDVD ± RW\r\n\r\nCamera - Bluetooth\r\nHD, eSATA, SD Card Reader, and USB Ports\r\n\r\nBattery is included with Lenovo AC charger - adapter', '240.0', 3, NULL, 6, 11, '2021-06-04 20:38:31', 6, 1),
(40, 'Microsoft Surface Pro 4 Intel Core i5 256 GB SSD 8 GB RAM', 'Up for sale is my Microsoft Surface Pro 4. My company has provided me a new laptop so I have no need for this one. Very gently used, but has one or two minor hairline surface scratches, but not an eyesore by any means. Screen is scratch free and looks amazing! Included are the Surface Pro Signature Keyboard Type Cover and original power adapter. 2 3 5 6 1724. Specs are below.\r\n\r\nProcessor: Intel Core i5-6300U CPU @ 2.40GHz\r\nMemory: 8GB\r\nStorage: 256GB SSD\r\nDisplay: 12.3” PixelSense™ Display Resolution: 2736 x 1824 (267 PPI) Aspect Ratio: 3:2 Touch: 10 point multi-touch\r\nGraphics: Intel® HD graphics 520\r\nWireless: 802.11ac Wi-Fi\r\nFull-size USB 3.0 microSD™ card reader Surface Connect™ Headset jack Mini DisplayPort Cover port\r\nCameras: 5.0MP front-facing camera with 1080p HD video\r\n8.0MP rear-facing autofocus camera with 1080p HD video Stereo microphones Stereo speakers with Dolby® Audio™ Premium\r\nDimensions: 11.50” x 7.93” x 0.33” (292.10mm x 201.42mm x 8.45mm)\r\nWeight: 1.73lbs (786g)\r\n', '500.0', 3, NULL, 6, 11, '2021-06-04 20:40:03', 2, 1),
(41, 'Sony VAIO VPCEA290X laptop & Core i3 & 14.0\" REFURBISHED & 30day WARRA', 'Sony VAIO Notebook/Laptop\r\nModel: VPCEA290X\r\nProcessor: Intel Core i3\r\nHard Drive: 320GB\r\nMemory: 4GB\r\nScreen Size: 14.0\" in LCD\r\nOperating System : Windows 7 Pro-64 bit\r\nHardware Connectivity: HDMI, USB 2.0\r\nColor: White, Black, Red, Blue ...\r\n\r\nFresh Windows with new hard drives, loaded with Adobe reader, Adobe flash (on-line version)\r\n\r\n*** 30 day WARRANTY (repair/exchange only, no returns for refunds)\r\n*** Special discounts for students, senior citizens and buyers not in within (408) area code\r\n*** We repair laptops, desktops & FREE diagnostic, estimate', '245.0', 5, NULL, 5, 11, '2021-06-04 20:48:01', 2, 1),
(42, 'MacBook Pro 13 - 2015', 'MacBook Pro (Retina, 13-inch, Early 2015).\r\n8Gb memory\r\n256Gb Flash Storage\r\nCome with Charger', '450.0', 3, NULL, 5, 11, '2021-06-04 20:50:28', 1, 1),
(43, 'Item Test', 'Item test', '452.0', 3, NULL, 5, 9, '2021-06-04 20:51:14', 8, 0),
(44, 'MacBook Pro 16\" 2020', 'Up for sale is a mint condition MacBook Pro 16\" 2020 (latest) 2.4G i9/32GB/2TB/5500M. It\'s basically the max-out configuration sans RAM.\r\n\r\nThis laptop was only powered on for less than half hour to take screenshot.\r\n\r\nI bought both MacBook Air M1 and this MacBook Pro, then realized I don\'t need this horse power as I have another iMac Pro already. And I prefer the light weight and fanless of my M1.\r\n\r\nApple retails for $4200 after tax. Asking $3800. Reasonable offers welcome, but low baller will be ignored. Cash only please.\r\nSome items I am interested in trading, top-up from either side is required if the value is different\r\n1. 12.9\" 3rd/4th/M1 iPad Pro\r\n2. high end gaming laptop with RTX 3070/3080 series graphics card\r\n3. Dji drone\r\n4. some other latest techs', '3800.0', 2, NULL, 2, 11, '2021-06-04 20:56:42', 28, 1),
(45, 'MacBook Pro 16', 'Macbook', '2500.0', 2, NULL, 2, 11, '2021-06-04 20:59:18', 6, 0),
(46, 'Macbook 2015 + Brand New Battery + Box ', 'Selling my well maintained 2015 Gold Macbook with a brand new battery installed.\r\n\r\nCharger, Cable and Cover included.\r\n\r\nOriginal 13.3 inch macbook air m1 box included.\r\n\r\nSelling it because I am moving to a desktop setup.\r\n\r\nLocal pick up and cash only.', '400.0', 3, NULL, 5, 11, '2021-06-04 21:07:06', 3, 0),
(47, 'Xbox Series X - *New', 'Brand new XBox Series X. $699 cash.', '699.0', 1, NULL, 3, 452, '2021-06-04 21:10:21', 6, 1),
(48, 'Sharp Quattron 60 inch LCD HD TV', 'TV in excellent condition. Amazing clear picture better than most LED and 4K TVs with 240 Hz motion for no blur motion. NO dead pixels. Everything works in full 1080p resolution. (2) Sharp 3D glasses and (1) remote included.\r\n\r\nRead reviews: https://www.bhphotovideo.com/c/product/757524-REG/Sharp_LC60LE835U_LC60LE835U_60_AQUOS_3D.html\r\n\r\nAQUOS Quattron 3DTV\r\nTechnology produces a brighter 3D experience, with reduced crosstalk blurs with red, green, blue, and yellow pixels.\r\n\r\nFull HD 1080p X-Gen LCD Panel\r\nWith 10-bit processing is designed with advanced pixel control to minimize light leakage and wider aperture to let more light through\r\n\r\nAquoMotion 240\r\nIt virtually eliminates blur and artifacts on fast-motion picture quality\r\n', '195.0', 2, NULL, 2, 12, '2021-06-04 22:52:26', 1, 1),
(49, '55\" Samsung 4k smart tv', '55\" Samsung 4k smart tv\r\nun55nu6900\r\nWorks fine but has 1 line coming down on right side and picture is brighter at the bottom', '100.0', 4, NULL, 2, 12, '2021-06-04 22:55:12', 1, 1),
(50, 'Sony CD AM/FM Mini Stereo Audio System', 'Sony CMT EX5 5CD AM/FM Mini Stereo Audio System in excellent working and very good cosmetic condition.\r\nComes with remote control.', '100.0', 3, NULL, 6, 13, '2021-06-04 22:59:35', 2, 1),
(51, 'Samsung 2.1 Soundbar and Subwoofer HW-MM45C', 'For sale is a used and near mint Samsung 2.1 soundbar with wireless subwoofer. This is like new and comes complete with soundbar, subwoofer, remote control, instruction manual, HDMI cable, and toslink (optical) cable.', '110.0', 2, NULL, 6, 13, '2021-06-04 23:01:54', 2, 1),
(52, 'Coaster Phoenix Contemporary Youth Storage Bed in Cappuccino', 'Up fir sale Coaster Phoenix Contemporary Youth Storage Bed in Cappuccino color in excellent shape.\r\n\r\nDimensions are 77.75\"W x 52.00\"D x 50.50\"H\r\n\r\nRecently moved and unfortunately it does not fit the new vibe.\r\n\r\nLesly firm full size mattress is available in like new condition for additional $200.\r\n\r\nhttps://www.dealbeds.com/coaster-phoenix-contemporary-youth-storage-bed-in-cappuccino/?sku=400410F&gclid=CjwKCAjwnPOEBhA0EiwA609ReeG7yU18aw4wGNY778X2ffbtOwewkL-DgQYeg-25Rd1WsrrQqAU5ahoCXB8QAvD_BwE', '400.0', 3, NULL, 6, 15, '2021-06-04 23:04:05', 14, 1),
(53, 'Baker\'s Rack', '36\" wide 70\" High Frame Material: Iron . green 4 wooden shelves\r\nPerfect for storing spirits and wine bottles in the dining room, towels and toiletries in the bathroom, or picture frames and succulents in the hall, this baker’s rack just may be the most versatile piece you own. Its rustic powder-coated iron frame has 4 engineered wood shelves that are spacious enough to house a microwave, toaster oven, and coffee maker in the kitchen. Plus, the metal is adorned with textured swirls for even more on-trend charm.', '90.0', 3, NULL, 6, 15, '2021-06-04 23:05:29', 3, 1),
(54, 'GE Refrigerator like new', 'very clean like new!', '400.0', 2, NULL, 6, 16, '2021-06-04 23:07:32', 1, 1),
(55, '18,000 BTU 1.5 Ton ductless mini split air conditioner', 'Hello,\r\n\r\nI have this state of art superior technology 18,000 BTU 15 seers, okyotech brand mini split ductless air conditioner for sale with amazing deal.\r\n\r\nToshiba Compressor, 3D air flow technology, high energy efficient-15 seer yet reliable, ozone friendly chlorine free R410A coolant, smart cooling and heating technology, infrared feel me technology, digital remote controller and so many more great features. 5 years warranty for the Toshiba compressor and 3 years for the unit which is the longest warranty in the market.\r\n\r\nIt comes with full installation set including 17 feet copper line set, cables, accessories etc.', '750.0', 3, NULL, 6, 16, '2021-06-04 23:09:10', 21, 1),
(56, 'Mid century Santa Cruz artist signed still life painting', 'Mid century Santa Cruz artist signed still life painting......', '40.0', 3, NULL, 6, 17, '2021-06-04 23:10:59', 1, 1),
(57, 'Beautiful Pillar Candle Holders', 'Beautiful Fitz and Floyd detail carved pillar candleholders. Individual holders are $25 each.', '25.0', 3, NULL, 6, 17, '2021-06-04 23:11:59', 1, 1),
(58, 'Lot of porcelain & Antique coffee mugs and kitchen ware', 'Really nice collection of older and newer Kitchen stuff.\r\n\r\n$20 for everything.\r\n\r\nAll in excellent condition', '20.0', 3, NULL, 5, 18, '2021-06-04 23:13:29', 32, 1),
(59, 'Kitchen Towel 8 Piece Set', 'Kitchen Towel Set, brand new, never used, $40.00 or make offer\r\n\r\n8 pieces, 100% Polyester (microfiber)\r\n\r\nTwo dish towels (16 x 19), two dish cloths (12 x 12), one pot handle holder, two pot holder/mat and one dish mat\r\n\r\nSerious offers only and please no offers for trades, thanks.', '40.0', 1, NULL, 5, 18, '2021-06-04 23:15:13', 34, 1),
(60, 'Weber BBQ', 'Deluxe 22 Weber - Only 1 year old. Used approx. 5 times. Works great. Bought a new bbq.', '45.0', 2, NULL, 5, 19, '2021-06-04 23:16:56', 1, 1),
(61, 'String of Rubies succulent', 'Beautiful string of Rubies succulent @ 6\" nersury pot. Best work on hanging basket and less water more sun exposure will turn into beautiful purple color (see photo 2 for reference). Small yellow flowers (see photo 3 for reference) will grow during spring season. Ask for $10 each pot in cash payment and local pick up with facial mask only.', '10.0', 1, NULL, 5, 19, '2021-06-04 23:20:23', 5, 1),
(62, 'Clothes Hamper', 'beautiful clothes hamper...', '15.0', 3, NULL, 5, 1457, '2021-06-04 23:28:54', 1, 1),
(63, 'Walt Disney Minnie Mouse T-Shirt', 'Size M (adult)\r\nMade in USA\r\n100% Cotton', '15.0', 1, 4, 1, 24, '2021-06-06 12:27:13', 10, 1),
(64, 'Levi’s women 710 super skinny jeans - waist 30', 'Levi’s women 710 Super Skinny Jeans\r\nWaist - 30\r\nJust worn 2-3 times, looks New.\r\nSelling them because, they no longer fit me!!!\r\nitem can be shipped (buyers need to pay the shipping cost)', '22.0', 2, 2, 1, 26, '2021-06-06 12:32:09', 5, 1),
(65, '12-14 Boy clothes -great for the season', 't-shirts, sport shirts, etc', '60.0', 3, 5, 4, 24, '2021-06-06 12:35:14', 6, 1),
(66, 'BAPE Double Knit Side Shark Shorts Black', 'I have a pair size medium. ', '200.0', 1, 1, 1, 4747, '2021-06-06 12:39:16', 37, 1),
(75, 'Alex Evening Cowl Neck Glitter Gown', 'Alex Evening Cowl Neck Glitter Gown, size 6, smoke grey color, never worn. Purchased through Macys in March, missed the deadline to return it. Lovely comfortable dress, new with tags, never worn, has been in a smoke-free, pet-free, covid-free home. Found something else I liked better, so trying to sell it. ', '55.0', 1, 2, 7, 23, '2021-06-09 22:15:34', 4, 1),
(76, 'Couch - Good/Fair Condition', 'Comfortable blue cloth couch in good/fair condition (5 years old) from house with cat.\r\nNo stains. Fabric is starting to wear - but not too much.\r\n\r\nDimensions - Length 84\" x Width 38\" x Height 33\" Lounge seat 60\"\r\nThe base under the lounge of the couch is separate. See photos.\r\n\r\nYou will need to pick it up and move it.\r\nSecond floor apartment. Does not fit in the elevator.\r\nI carried it upstairs with one other person and it worked out.\r\n\r\nI love this couch and it has served me well. Hope it finds a good new home!\r\nCute blue striped pillow not included.\r\n', '100.0', 3, NULL, 7, 15, '2021-06-09 22:23:13', 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` tinyint(4) NOT NULL,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'User'),
(2, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` tinyint(4) NOT NULL DEFAULT 1,
  `user_date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `unlock_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `full_name`, `city`, `country`, `role_id`, `user_date_created`, `unlock_code`) VALUES
(1, 'admin', 'mihailoilic121@gmail.com', '84ec16d310c1a2041035111810677a29', 'Website Admin', 'Belgrade', 'Serbia', 2, '2021-05-31 14:05:27', NULL),
(2, 'mihailoilic', 'mihailoilic122@gmail.com', 'a9caad057db9631c4709fd2eecbe67b3', 'Mihailo Ilic', 'Belgrade', 'Serbia', 1, '2021-05-31 18:09:08', NULL),
(3, 'test222', 'test@asdfasdf.df', '805f2c60046b4c34c035b66a17f26f57', 'Test Account', 'Belgrade', 'Serbia', 1, '2021-06-03 11:30:02', NULL),
(4, 'jhelmSF', 'jhelm33@fake.mail', '72a4f9d5c4539d56a75bcdd709952ade', 'John Helm', 'San Francisco', 'United States', 1, '2021-06-04 10:43:32', NULL),
(5, 'Tcharles22', 'tch2333@fake.mail', '47bce5c74f589f4867dbd57e9ca9f808', 'Thomas Charles', 'London', 'United Kingdom', 1, '2021-06-04 11:28:34', NULL),
(6, 'CutieAlley', 'cutieally@fake.mail', '47bce5c74f589f4867dbd57e9ca9f808', 'Cutie Alley', 'New York City', 'United States', 1, '2021-06-04 20:17:04', NULL),
(7, 'user', 'user@testacc.mail', '40f5d0b0e3b4fc8347d43f474fd26487', 'User Test Account', 'Belgrade', 'Serbia', 1, '2021-06-09 22:12:57', NULL),
(8, 'asdf', 'ventilator@mail.com', '9aea6f4badb332e2b7ed2c432e68c48c', 'Ždfdfasdf Ždfffd', 'žćšžšžšžšć', 'žćžćžćž', 1, '2021-06-10 14:35:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wish_list`
--

CREATE TABLE `wish_list` (
  `wish_list_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wish_list`
--

INSERT INTO `wish_list` (`wish_list_id`, `user_id`, `product_id`) VALUES
(13, 1, 14),
(14, 1, 39),
(16, 5, 14),
(17, 7, 26);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`ban_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_category_id` (`parent_category_id`),
  ADD KEY `category_image_id` (`category_image_id`);

--
-- Indexes for table `conditions`
--
ALTER TABLE `conditions`
  ADD PRIMARY KEY (`condition_id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`gender_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `offer_id` (`offer_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`offer_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `page_info`
--
ALTER TABLE `page_info`
  ADD PRIMARY KEY (`page_id`),
  ADD KEY `page_image_id` (`page_image_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `condition_id` (`condition_id`),
  ADD KEY `gender_id` (`gender_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `wish_list`
--
ALTER TABLE `wish_list`
  ADD PRIMARY KEY (`wish_list_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `ban_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4756;

--
-- AUTO_INCREMENT for table `conditions`
--
ALTER TABLE `conditions`
  MODIFY `condition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `page_info`
--
ALTER TABLE `page_info`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wish_list`
--
ALTER TABLE `wish_list`
  MODIFY `wish_list_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bans`
--
ALTER TABLE `bans`
  ADD CONSTRAINT `bans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`offer_id`);

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `offers_ibfk_2` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`condition_id`) REFERENCES `conditions` (`condition_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `images` (`product_id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`gender_id`),
  ADD CONSTRAINT `products_ibfk_5` FOREIGN KEY (`seller_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `wish_list`
--
ALTER TABLE `wish_list`
  ADD CONSTRAINT `wish_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `wish_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
