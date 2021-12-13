-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2021 at 05:55 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `openemr`
--

-- --------------------------------------------------------

--
-- Structure for view `v_procedures`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_procedures`  AS SELECT `po`.`patient_id` AS `pid`, `po`.`procedure_order_id` AS `procedure_order_id`, `po`.`date_collected` AS `DATE`, `poc`.`procedure_code` AS `procedure_code`, `poc`.`procedure_name` AS `procedure_name`, timestampdiff(HOUR,`po`.`date_collected`,current_timestamp()) AS `proc_age`, CASE WHEN timestampdiff(HOUR,`po`.`date_collected`,current_timestamp()) > 24 THEN 0 WHEN timestampdiff(HOUR,`po`.`date_collected`,current_timestamp()) <= 24 THEN 1 END AS `day_flag` FROM (`procedure_order` `po` join `procedure_order_code` `poc` on(`po`.`procedure_order_id` = `poc`.`procedure_order_id`)) ;

--
-- VIEW `v_procedures`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
