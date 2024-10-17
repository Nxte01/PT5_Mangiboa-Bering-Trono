-- Adminer 4.8.1 MySQL 10.4.34-MariaDB-1:10.4.34+maria~ubu2004 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `allclients`;
CREATE TABLE `allclients` (
  `ClientNumber` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `givenName` text DEFAULT NULL,
  `ClientAddress` text DEFAULT NULL,
  `lastName` text DEFAULT NULL,
  PRIMARY KEY (`ClientNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `allclients` (`ClientNumber`, `givenName`, `ClientAddress`, `lastName`) VALUES
(1,	'John Smith',	'123 Main Street, Apt. 4B, Anytown, USA',	'Albercarky'),
(2,	'Casandra Nova',	'456 Oak Avenue, Anytown, USA',	'Pinewood'),
(3,	'Bob Indra',	'789 Willow Lane, Ruralville, USA',	'Bolyfood'),
(4,	'Nova Stark',	'P.O. Box 123, Anytown, USA',	'Tresance'),
(5,	'Elmochio Minoi',	'Suite 101, 123 Business Boulevard, Anytown, USA',	'Baraka'),
(6,	'Gruth Makvin',	'456 Industrial Park Drive, Anytown, USA',	'Cape Neddick'),
(7,	'Katelyn Mcintyre',	'789 Main Street, Anytown, USA',	'Serra'),
(8,	'Bethan Sanford',	'123 School Road, Anytown, USA',	'Faulkton'),
(9,	'Lloyd Davies',	'456 Government Center, Anytown, USA',	'Suditi'),
(10,	'Saarah Cruz',	'123 Base Road, Anytown, USA',	'Chatfield'),
(11,	'Nathan Miguel',	'Luinab',	'Trono');

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `item_num` int(11) NOT NULL AUTO_INCREMENT,
  `description` text DEFAULT NULL,
  `asking_price` bigint(20) DEFAULT NULL,
  `critiqued_comments` text DEFAULT NULL,
  `condition` text DEFAULT NULL,
  `item_type` text DEFAULT NULL,
  `is_sold` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`item_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `items` (`item_num`, `description`, `asking_price`, `critiqued_comments`, `condition`, `item_type`, `is_sold`) VALUES
(1,	'Baroque Armchair',	3200,	'Rich detailing newly polished',	'Excellent',	'Furniture',	0),
(2,	'Queen Anne Dining Table',	3500,	'Stunning centerpiece minor scratches',	'Good',	'Furniture',	0),
(3,	'Victorian Oak Chair',	1200,	'Beautifully carved with minimal wear',	'Good',	'Furniture',	0),
(4,	'Chippendale Chest',	2200,	'Original handles some fading',	'Good',	'Furniture',	0),
(5,	'Rococo Side Table',	1300,	'Ornate carvings minor nicks',	'Fair',	'Furniture',	0),
(6,	'Victorian Mahogany Cabinet',	2700,	'Intricate inlays slight wear on edges',	'Good',	'Furniture',	0),
(7,	'Art Deco Lamp',	750,	'Vintage style slight discoloration',	'Fair',	'Home Decor',	0),
(8,	'Mid-century Modern Chair',	950,	'Iconic design fabric slightly worn',	'Good',	'Furniture',	0),
(9,	'Georgian Mirror',	1800,	'Gilt frame with aged patina',	'Good',	'Home Decor',	1),
(11,	'ItemTest',	1200,	'Test',	'Bad',	'TestItem',	1),
(12,	'Emerald',	9998,	'cra',	'Excellent',	'Jewel',	1);

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `purchase_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `p_cost` bigint(20) DEFAULT NULL,
  `p_date` date DEFAULT NULL,
  `condition_at_purchase` text DEFAULT NULL,
  `ClientNumber` bigint(20) unsigned DEFAULT NULL,
  `item_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`purchase_id`),
  KEY `Items_Purchases` (`item_num`),
  KEY `AllClients_Purchases` (`ClientNumber`),
  CONSTRAINT `purchases_ibfk_10` FOREIGN KEY (`ClientNumber`) REFERENCES `allclients` (`ClientNumber`),
  CONSTRAINT `purchases_ibfk_5` FOREIGN KEY (`item_num`) REFERENCES `items` (`item_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `purchases` (`purchase_id`, `p_cost`, `p_date`, `condition_at_purchase`, `ClientNumber`, `item_num`) VALUES
(40,	1000,	'2024-10-09',	'Bad',	11,	11);

DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales` (
  `saleID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `commissionPaid` bigint(20) DEFAULT NULL,
  `sellingPrice` bigint(20) NOT NULL,
  `salesTax` decimal(10,0) NOT NULL,
  `date_sold` date NOT NULL,
  `ClientNumber` bigint(20) unsigned DEFAULT NULL,
  `item_num` int(11) NOT NULL,
  PRIMARY KEY (`saleID`),
  KEY `AllClients_Sales` (`ClientNumber`),
  KEY `Items_Sales` (`item_num`),
  CONSTRAINT `sales_ibfk_11` FOREIGN KEY (`item_num`) REFERENCES `items` (`item_num`),
  CONSTRAINT `sales_ibfk_5` FOREIGN KEY (`ClientNumber`) REFERENCES `allclients` (`ClientNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sales` (`saleID`, `commissionPaid`, `sellingPrice`, `salesTax`, `date_sold`, `ClientNumber`, `item_num`) VALUES
(1,	300,	77777777,	9333333,	'2024-10-16',	11,	9);

-- 2024-10-16 04:36:37