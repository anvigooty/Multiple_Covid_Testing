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
-- Structure for view `v_covid`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_covid`  AS SELECT concat('C-',`form_covid_testing`.`id`) AS `procedure_order_id`, `form_covid_testing`.`date` AS `date`, `form_covid_testing`.`pid` AS `pid`, `form_covid_testing`.`test_status` AS `test_status`, `form_covid_testing`.`test_notes` AS `test_notes`, `form_covid_testing`.`doctor` AS `doctor`, `form_covid_testing`.`procedure_code` AS `procedure_code`, timestampdiff(HOUR,`form_covid_testing`.`date`,current_timestamp()) AS `proc_age`, CASE WHEN timestampdiff(HOUR,`form_covid_testing`.`date`,current_timestamp()) > 24 THEN 0 WHEN timestampdiff(HOUR,`form_covid_testing`.`date`,current_timestamp()) <= 24 THEN 1 END AS `day_flag` FROM `form_covid_testing` ;

--
-- VIEW `v_covid`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
