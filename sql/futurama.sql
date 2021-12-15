-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2020 at 10:12 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `futurama`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `audit_id` int(11) NOT NULL,
  `audit_user` int(11) NOT NULL,
  `audit_action` varchar(255) NOT NULL,
  `audit_entity` varchar(255) NOT NULL,
  `audit_entity_pk` int(11) NOT NULL,
  `audit_message` varchar(255) DEFAULT NULL,
  `audit_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`audit_id`, `audit_user`, `audit_action`, `audit_entity`, `audit_entity_pk`, `audit_message`, `audit_date`) VALUES
(1, 10, 'insert', 'Order', 4, '', '2020-07-15 00:00:00'),
(2, 10, 'insert', 'Message', 3, '', '2020-07-15 00:00:00'),
(3, 10, 'insert', 'Message', 4, '', '2020-07-15 00:00:00'),
(4, 3, 'delete', 'Order', 4, '', '2020-07-15 00:00:00'),
(5, 3, 'delete', 'User', 8, '', '2020-07-15 01:19:14'),
(6, 10, 'insert', 'Order', 5, '', '2020-07-15 01:20:09'),
(7, 10, 'insert', 'Message', 5, '', '2020-07-15 01:20:09'),
(8, 10, 'insert', 'Message', 6, '', '2020-07-15 01:20:33'),
(9, 3, 'insert', 'Message', 7, '', '2020-07-15 01:21:56'),
(10, 3, 'update', 'User', 7, '', '2020-07-15 20:46:36'),
(11, 11, 'insert', 'User', 11, '', '2020-07-15 20:50:05'),
(12, 11, 'insert', 'Order', 6, '', '2020-07-15 20:50:42'),
(13, 11, 'insert', 'Message', 8, '', '2020-07-15 20:50:42'),
(14, 12, 'insert', 'User', 12, '', '2020-07-15 20:51:22'),
(15, 12, 'insert', 'Message', 9, '', '2020-07-15 20:51:56'),
(16, 7, 'update', 'Order', 5, '', '2020-07-15 22:07:57'),
(17, 7, 'update', 'Order', 5, '', '2020-07-15 22:08:04'),
(18, 7, 'update', 'Order', 5, '', '2020-07-15 22:10:44');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `message_sender` varchar(255) NOT NULL,
  `message_text` varchar(255) NOT NULL,
  `message_date` datetime NOT NULL DEFAULT current_timestamp(),
  `message_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `message_sender`, `message_text`, `message_date`, `message_order`) VALUES
(3, '1', 'foijsaijodfijoasdiojfaijodsfoijasdoijfoaijsdf', '2020-07-15 00:49:19', 4),
(4, '1', 'message', '2020-07-15 00:49:48', 4),
(5, '1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2020-07-15 01:20:09', 5),
(6, '1', 'fasidjfoisdf', '2020-07-15 01:20:33', 5),
(7, '0', 'jioijoijoijoijojjio', '2020-07-15 01:21:56', 5),
(8, '1', 'This is a Test Ticket', '2020-07-15 20:50:42', 6),
(9, '0', 'This is Test Response', '2020-07-15 20:51:56', 6);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `module_icon` varchar(50) NOT NULL,
  `module_path` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`, `module_icon`, `module_path`) VALUES
(1, 'Admin Dashboard', 'fad fa-tachometer-slowest', 'AdminDashboard'),
(2, 'Clients', 'fad fa-users-cog', 'Clients'),
(3, 'Orders', 'fad fa-file-invoice', 'Orders'),
(4, 'News', 'fad fa-newspaper', 'News'),
(5, 'My Orders', 'fad fa-tachometer-slowest', 'MyOrders'),
(6, 'My Profile', 'fad fa-head-side', 'MyProfile'),
(7, 'Log Out', ' fad fa-sign-out', 'out');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `news_title` text NOT NULL,
  `news_content` longtext NOT NULL,
  `news_image` text NOT NULL,
  `news_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `news_content`, `news_image`, `news_date`) VALUES
(1, 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\nContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\n\r\n\r\n', 'img/image-news.png', '2020-07-12 00:02:37'),
(3, 'Why do we use it?\r\n', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\n', 'img/image-news.png', '2020-07-12 00:47:27'),
(4, 'Why do we use it?\r\n', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\n', 'img/image-news.png', '2020-07-12 00:47:40'),
(5, 'Why do we use it?\r\n', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\n', 'img/image-news.png', '2020-07-12 00:47:51'),
(6, 'Why do we use it?\r\n', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\n', 'img/image-news.png', '2020-07-12 00:47:57');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_name` varchar(255) NOT NULL,
  `order_product` int(11) NOT NULL,
  `order_budget` varchar(255) DEFAULT NULL,
  `order_status` varchar(50) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `user_id`, `order_name`, `order_product`, `order_budget`, `order_status`, `order_date`) VALUES
(4, 10, 'fjoasjdfoaijdsf', 1, '100-200', 'closed', '2020-07-15 00:49:19'),
(5, 10, 'What is Lorem Ipsum?', 2, '100', 'pending', '0000-00-00 00:00:00'),
(6, 11, 'Tabis', 3, '360', 'pending', '2020-07-15 20:50:42');

-- --------------------------------------------------------

--
-- Table structure for table `ourteam`
--

CREATE TABLE `ourteam` (
  `ourteam_id` int(11) NOT NULL,
  `ourteam_name` varchar(254) NOT NULL,
  `ourteam_jobDescription` varchar(254) NOT NULL,
  `ourteam_img` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ourteam`
--

INSERT INTO `ourteam` (`ourteam_id`, `ourteam_name`, `ourteam_jobDescription`, `ourteam_img`) VALUES
(1, 'JOHN DOE', 'CEO', 'img/teammember1.png'),
(2, 'FILANE FISTEKU', 'COO', 'img/teammember2.png'),
(3, 'MAX MUSTERMANN', 'SOFTWARE ENGINEER', 'img/teammember3.png'),
(4, 'PIERRE JACQUES', 'Quality Assurance Engineer', 'img/teammember4.png');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_description`, `product_icon`) VALUES
(1, 'App Development', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', 'img/box-1.png'),
(2, 'Web Development', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'img/box-2.png'),
(3, 'Software Development', 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'img/box-3.png'),
(4, 'Why do we use it?\r\n', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', 'img/box-1.png'),
(5, 'Where does it come from?\r\n', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one ', 'img/box-2.png'),
(6, 'Where can I get some?\r\n', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour', 'img/box-3.png');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(0, 'ADMIN'),
(1, 'USER');

-- --------------------------------------------------------

--
-- Table structure for table `role_modules`
--

CREATE TABLE `role_modules` (
  `role_modules_id` int(11) NOT NULL,
  `role_modules_role` int(11) NOT NULL,
  `role_modules_module` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_modules`
--

INSERT INTO `role_modules` (`role_modules_id`, `role_modules_role`, `role_modules_module`) VALUES
(8, 0, 1),
(9, 0, 2),
(10, 0, 3),
(11, 0, 4),
(12, 1, 5),
(13, 1, 6),
(14, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `slider_id` int(11) NOT NULL,
  `slider_color` varchar(7) NOT NULL,
  `slider_image` varchar(255) NOT NULL,
  `slider_title` varchar(255) NOT NULL,
  `slider_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slider_id`, `slider_color`, `slider_image`, `slider_title`, `slider_description`) VALUES
(1, '#EFE2DC', 'img/slider1.png', 'Let us create your App', 'lorem ipsum dolor sit amet,diri dsot nfrops'),
(2, '#C4F1FF', 'img/slider3.png', 'Let us create your Software', 'lorem ipsum dolor sit amet,diri dsot nfrops'),
(3, '#C2D3FF', 'img/slider2.png', 'Let us create your Website', 'lorem ipsum dolor sit amet,diri dsot nfrops');

-- --------------------------------------------------------

--
-- Table structure for table `technologies`
--

CREATE TABLE `technologies` (
  `technologies_id` int(11) NOT NULL,
  `technologies_title` varchar(254) NOT NULL,
  `technologies_description` varchar(254) NOT NULL,
  `technologies_img` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `technologies`
--

INSERT INTO `technologies` (`technologies_id`, `technologies_title`, `technologies_description`, `technologies_img`) VALUES
(1, 'HTML', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', 'img/html.png'),
(2, 'PHP', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'img/php.png'),
(3, 'JavaScript', 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'img/javascript.png'),
(4, 'C#', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...', 'img/csharp.png'),
(5, 'JAVA', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'img/java.png'),
(6, 'Python', 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'img/python.png');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `testimonial_id` int(11) NOT NULL,
  `testimonial_name` varchar(255) NOT NULL,
  `testimonial_title` varchar(255) NOT NULL,
  `testimonial_message` varchar(255) NOT NULL,
  `testimonial_rating` tinyint(4) NOT NULL,
  `testimonial_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`testimonial_id`, `testimonial_name`, `testimonial_title`, `testimonial_message`, `testimonial_rating`, `testimonial_image`) VALUES
(1, 'Melon Tusk', 'Multi millionare', '\"This is better than X Æ A-12\"', 5, 'img/elon_musk.jpg'),
(2, 'Gill Bates', 'CEO of Macrohard', '\"I have never seen a more unique and better company\"', 5, 'img/gill_bates.jpg'),
(3, 'Geve Stobs', 'Apple Juice', '\"I hesitate to articulate in fear i may deviate upon the highest degree of accuracy\\\"', 4, 'img/geve_stobs.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int(11) NOT NULL,
  `ticket_email` varchar(255) NOT NULL,
  `ticket_sex` char(1) NOT NULL,
  `ticket_country` varchar(255) NOT NULL,
  `ticket_name` varchar(255) NOT NULL,
  `ticket_message` varchar(255) NOT NULL,
  `ticket_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_full_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_full_name`, `user_email`, `user_username`, `user_password`, `user_role`) VALUES
(3, 'Shkumbin Hasani', 'sh131171@gmail.com', 'shkumbin', '$2y$10$s6NvkP9/vZy.1SXeU6B/B.VoaS5WvENoQZw0K.cLojN8g43.gnvGK', 0),
(7, 'Etnik Beqiri ', 'etnik@uni.al', 'etniki', '$2y$10$uCb/lJg/MDqFOIYcR3YbxuibY5F5Z5VL88T0dlxhkVPAqpcwe076O', 0),
(10, 'Argjent Sahiti ', 'argjentsahiti@gmail.com', 'argjent', '$2y$10$9mKNyrNqf9yzXtNkJRm2ruRx.EDho66Go/AtyRDJ/Kr.qwGafR6He', 1),
(11, 'User User ', 'user@gmail.com', 'useruser', '$2y$10$zSjE3Qv03467pK8quL/5leOFD7j66IGmWvwdupOp1doBAKL0M.gU.', 1),
(12, 'Admin Admin ', 'admin@futurama.com', 'adminadmin', '$2y$10$hR7zUBZLFyuOI9j7D1hV9OZoCs9Cub.QNVWVM9t/RWGKfuX0cRuBG', 0);

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `visitor_id` int(11) NOT NULL,
  `visitor_browser` varchar(255) NOT NULL,
  `visitor_os` varchar(255) DEFAULT NULL,
  `visitor_cookie_id` varchar(255) DEFAULT NULL,
  `visitor_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`visitor_id`, `visitor_browser`, `visitor_os`, `visitor_cookie_id`, `visitor_date`) VALUES
(29, 'Default Browser', 'unknown', 'Ej6Ox-OKgFe-rOeYS-9Tmxj-oUC5N', NULL),
(30, 'Default Browser', 'unknown', 'Ej6Ox-OKgFe-rOeYS-9Tmxj-oUC5N', NULL),
(31, 'Default Browser', 'unknown', 'Ej6Ox-OKgFe-rOeYS-9Tmxj-oUC5N', NULL),
(32, 'Default Browser', 'unknown', 'Ej6Ox-OKgFe-rOeYS-9Tmxj-oUC5N', NULL),
(33, 'Default Browser', 'unknown', 'Ej6Ox-OKgFe-rOeYS-9Tmxj-oUC5N', NULL),
(34, 'Default Browser', 'unknown', 'RbhUL-JEC26-TDCXY-3Os2V-5KAeD', NULL),
(35, 'Default Browser', 'unknown', 'Ej6Ox-OKgFe-rOeYS-9Tmxj-oUC5N', NULL),
(36, 'Default Browser', 'unknown', 'Ej6Ox-OKgFe-rOeYS-9Tmxj-oUC5N', '2020-07-12 02:58:52'),
(37, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-12 02:59:12'),
(38, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-12 03:24:17'),
(39, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-12 07:46:58'),
(40, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-12 07:47:05'),
(41, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-12 10:12:05'),
(42, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-12 18:02:48'),
(43, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-12 18:04:22'),
(44, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-13 17:23:20'),
(45, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-13 17:24:06'),
(46, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-13 17:26:52'),
(47, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-13 21:21:56'),
(48, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-13 21:28:54'),
(49, 'Default Browser', 'unknown', 'a42WA-q7gQK-3QKrO-2AudE-PLVAz', '2020-07-13 21:32:53'),
(50, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-14 01:42:41'),
(51, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-14 01:42:42'),
(52, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-14 02:27:58'),
(53, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-14 02:29:10'),
(54, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-14 02:32:13'),
(55, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-14 02:32:57'),
(56, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-14 02:33:11'),
(57, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-14 02:36:58'),
(58, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:47:52'),
(59, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:52:35'),
(60, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:52:40'),
(61, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:53:05'),
(62, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:54:39'),
(63, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:54:44'),
(64, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:55:03'),
(65, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:55:08'),
(66, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:55:28'),
(67, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:55:57'),
(68, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:56:15'),
(69, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 00:56:25'),
(70, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 01:19:36'),
(71, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 01:19:42'),
(72, 'Default Browser', 'unknown', 'UWydm-wlDPP-M58y7-3Sx4o-5yR9U', '2020-07-15 01:21:38'),
(73, 'Default Browser', 'unknown', 'oGX74-lj2Mx-0tuy6-EdqoP-OiT6s', '2020-07-15 20:45:51'),
(74, 'Default Browser', 'unknown', 'oGX74-lj2Mx-0tuy6-EdqoP-OiT6s', '2020-07-15 20:46:45'),
(75, 'Default Browser', 'unknown', 'oGX74-lj2Mx-0tuy6-EdqoP-OiT6s', '2020-07-15 20:47:00'),
(76, 'Default Browser', 'unknown', 'oGX74-lj2Mx-0tuy6-EdqoP-OiT6s', '2020-07-15 20:48:21'),
(77, 'Default Browser', 'unknown', 'oGX74-lj2Mx-0tuy6-EdqoP-OiT6s', '2020-07-15 20:49:44'),
(78, 'Default Browser', 'unknown', 'oGX74-lj2Mx-0tuy6-EdqoP-OiT6s', '2020-07-15 20:50:47'),
(79, 'Default Browser', 'unknown', 'oGX74-lj2Mx-0tuy6-EdqoP-OiT6s', '2020-07-15 20:58:39'),
(80, 'Default Browser', 'unknown', 'oGX74-lj2Mx-0tuy6-EdqoP-OiT6s', '2020-07-15 22:10:45'),
(81, 'Default Browser', 'unknown', 'oGX74-lj2Mx-0tuy6-EdqoP-OiT6s', '2020-07-15 22:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `whoarewe`
--

CREATE TABLE `whoarewe` (
  `whoarewe_id` int(11) NOT NULL,
  `whoarewe_title` varchar(254) NOT NULL,
  `whoarewe_description` text NOT NULL,
  `whoarewe_img` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `whoarewe`
--

INSERT INTO `whoarewe` (`whoarewe_id`, `whoarewe_title`, `whoarewe_description`, `whoarewe_img`) VALUES
(2, 'WHO ARE WE?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'img/office.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD UNIQUE KEY `audit_audit_id_uindex` (`audit_id`),
  ADD KEY `audit_ibfk_1` (`audit_user`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `message_order` (`message_order`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_product` (`order_product`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ourteam`
--
ALTER TABLE `ourteam`
  ADD PRIMARY KEY (`ourteam_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_product_name_uindex` (`product_name`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name_uindex` (`role_name`);

--
-- Indexes for table `role_modules`
--
ALTER TABLE `role_modules`
  ADD PRIMARY KEY (`role_modules_id`),
  ADD KEY `role_modules_role` (`role_modules_role`),
  ADD KEY `role_modules_module` (`role_modules_module`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `technologies`
--
ALTER TABLE `technologies`
  ADD PRIMARY KEY (`technologies_id`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`testimonial_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_user_email_uindex` (`user_email`),
  ADD UNIQUE KEY `user_user_username_uindex` (`user_username`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`visitor_id`);

--
-- Indexes for table `whoarewe`
--
ALTER TABLE `whoarewe`
  ADD PRIMARY KEY (`whoarewe_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_modules`
--
ALTER TABLE `role_modules`
  MODIFY `role_modules_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `testimonial_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `visitor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit`
--
ALTER TABLE `audit`
  ADD CONSTRAINT `audit_ibfk_1` FOREIGN KEY (`audit_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`message_order`) REFERENCES `order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`order_product`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_modules`
--
ALTER TABLE `role_modules`
  ADD CONSTRAINT `role_modules_ibfk_1` FOREIGN KEY (`role_modules_role`) REFERENCES `role` (`role_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_modules_ibfk_2` FOREIGN KEY (`role_modules_module`) REFERENCES `module` (`module_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
