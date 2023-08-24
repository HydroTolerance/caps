-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2023 at 06:21 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zephyderm_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment_slots`
--

CREATE TABLE `appointment_slots` (
  `time_id` int(11) NOT NULL,
  `slots` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_slots`
--

INSERT INTO `appointment_slots` (`time_id`, `slots`) VALUES
(1, '1:00 PM - 1:30 PM'),
(2, '1:30 PM - 2:00 PM'),
(3, '2:00 PM - 2:30 PM'),
(4, '2:30 PM - 3:00 PM'),
(16, '3:00 PM - 3:30 PM'),
(17, '3:30 PM - 4:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `book1`
--

CREATE TABLE `book1` (
  `id` int(11) NOT NULL,
  `appointment_id` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `health_concern` text NOT NULL,
  `services` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(255) NOT NULL,
  `reference_code` varchar(255) NOT NULL,
  `appointment_status` enum('Approved','Pending','Rescheduled','Cancelled') DEFAULT NULL,
  `apt_reason` text NOT NULL,
  `created` date NOT NULL,
  `otp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book1`
--

INSERT INTO `book1` (`id`, `appointment_id`, `firstname`, `lastname`, `number`, `email`, `health_concern`, `services`, `date`, `time`, `reference_code`, `appointment_status`, `apt_reason`, `created`, `otp`) VALUES
(153, 'apt#047', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'asdfasdfasdf', 'Consultation', '2023-08-09', '1:00 PM - 1:30 PM', 'cCjJ42huadpbWCG', 'Rescheduled', 'afsfasdfasdfas', '2022-01-01', ''),
(154, 'apt#048', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'adfasdfasdf', 'Consultation', '2023-08-23', '1:00 PM - 1:30 PM', 'tV5zSuvrtPIwKt7', 'Rescheduled', 'asdfasdfasddfasdfadsf', '0000-00-00', ''),
(155, 'apt#049', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'dafsdfsdfas', 'Consultation', '2023-08-11', '1:00 PM - 1:30 PM', 'HXSwRkGNWcHnVxs', 'Rescheduled', 'asdfasdfasdfasfdasfsdsdf', '0000-00-00', ''),
(156, 'apt#050', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'fsdafasdfsadf', 'Nail', '2023-08-16', '1:00 PM - 1:30 PM', 'ZMCu4tzlrGbKOI2', 'Rescheduled', 'asdfasdfasdfsadf', '0000-00-00', ''),
(157, 'apt#051', 'Arola', 'Mohammad', '09168603112', 'asdfasdf@gafs.com', 'asdfasdfa', 'Consultation', '2023-08-09', '1:00 PM - 1:30 PM', 'lnyRgQtojP3i7kZ', 'Rescheduled', 'asdfasdfasdfadf', '0000-00-00', ''),
(158, 'apt#052', 'Arola', 'Mohammad', '09168603112', '', 'asfdfasdfdfs', 'Skin', '0000-00-00', '', 'FF4UYj7jUYbF5of', 'Rescheduled', '', '0000-00-00', ''),
(159, 'apt#053', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'sdfasdfasdfadsfdsf', 'Nail', '2023-06-02', '1:00 PM - 1:30 PM', 'tisie2IgWJCLavO', 'Rescheduled', 'asdfasdfasdfasdf', '0000-00-00', ''),
(160, 'apt#054', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'asdfasdfasdfdsaf', 'Consultation', '2023-08-25', '1:00 PM - 1:30 PM', 'pFHHfCumXjBwTIb', 'Rescheduled', 'adfasdfasdfdsf', '0000-00-00', ''),
(161, 'apt#055', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'asdfasdfasdfdsaf', 'Consultation', '2023-06-02', '1:00 PM - 1:30 PM', '7YotEaU5CbKoZLm', 'Rescheduled', 'fdsafasdfasd', '0000-00-00', ''),
(162, 'apt#056', 'Arola', 'Mohammad', '09168603112', 'blazered098@gmail.com', 'fadsfasdfadsf', 'Consultation', '2023-08-04', '1:30 PM - 2:00 PM', 'mOKpisVmszofN6B', 'Rescheduled', 'asdfadfadsfaf', '0000-00-00', ''),
(163, 'apt#057', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'fadsfasdfadsffasdfasdf', 'Consultation', '2023-08-26', '2:00 PM - 2:30 PM', '8YaEGRByO2DVWvV', 'Rescheduled', 'asdfasdfasdfasdfasdfasdfasdf', '0000-00-00', ''),
(164, 'apt#058', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'asfsadfsdafdsds', 'Skin', '2023-06-07', '1:00 PM - 1:30 PM', 'gELqJP1ExHbeSCm', 'Approved', '', '0000-00-00', ''),
(165, 'apt#059', 'Nur Miswari', 'Alloha', '09877555509', 'asdfasdf@gmail.com', 'dsfsadfasdfasdfa', 'Hair', '2023-06-05', '1:00 PM - 1:30 PM', 'cRCvoXYbKtEAVLF', 'Approved', '', '0000-00-00', ''),
(166, 'apt#060', 'Nur Miswari', 'Alloha', '09877555509', 'julzhafiz@gmail.com', 'dsfsadfasdfasdfa', 'Hair', '2023-08-12', '1:00 PM - 1:30 PM', 'QhjReBvctWEyBkG', 'Approved', 'afdsfasdf', '0000-00-00', ''),
(167, 'apt#061', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'asdfasdfadsf', 'Hair', '2023-07-07', '1:00 PM - 1:30 PM', 'jA4MuhAif10EZ6j', 'Rescheduled', 'asdfasdfadsfasdf', '0000-00-00', ''),
(168, 'apt#062', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'asdfasdfasdfasdfadsfadsf', 'Consultation', '2023-07-03', '1:00 PM - 1:30 PM', '8SOufvyePRhXfxK', 'Approved', '', '0000-00-00', ''),
(169, 'apt#063', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'afasdf', 'Consultation', '2023-07-07', '1:00 PM - 1:30 PM', 'ZU2O0x8bjGY41oJ', 'Rescheduled', 'asdfasdfasfadsfsddf', '0000-00-00', ''),
(170, 'apt#061', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'asdfasdfasdf', 'Hair', '2023-08-09', '1:00 PM - 1:30 PM', 'NbQMI6WM8HDHdLH', 'Cancelled', 'asdfasdfasdfasdfsdfsadfasdf', '0000-00-00', ''),
(171, 'apt#066', 'Arthur', 'Morgan', '09168603112', 'julzhafiz@gmail.com', 'adsfasdfasdffdfsdsf', 'Nail', '2023-08-16', '1:00 PM - 1:30 PM', 'PoYKxj2YX9f9v1Q', 'Cancelled', 'adfasfasdfasdfasdfasfdasfdsfadsffasdfsdfdsaafds', '2023-08-12', ''),
(172, 'apt#067', 'John', 'Marston', '09168603112', 'julzhafiz@gmail.com', 'asdfasdfasdfadsff', 'Skin', '2023-08-18', '1:00 PM - 1:30 PM', '8masf9tjevIZckW', 'Approved', '', '2023-08-12', ''),
(173, 'apt#068', 'Arola', 'Mohammad', '09168603112', 'julzhafiz@gmail.com', 'asdfasdfasdfasdfadsf', 'Nail', '2023-08-23', '1:00 PM - 1:30 PM', 'R6XFKfFEw4gnELa', 'Pending', '', '2023-08-20', '');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `id` int(11) NOT NULL,
  `booking_status` enum('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `datepick`
--

CREATE TABLE `datepick` (
  `date_id` int(11) NOT NULL,
  `check_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`) VALUES
(33, 'WHAT IS ZEPHYRIS SKIN CARE CENTER?', 'Zephyris Skin Care Center is a dermatology clinic that offers a wide range of care for patients with skin, hair, and nail problems. The clinic has been in business for 13 years, it was established in June 2009. It is owned by Dr. Zharlah Gulmatico-Flores MD, MMPHA, FPDS, FPADSFI.'),
(34, 'WHAT ARE THE CLINIC HOURS OF ZEPHYRIS SKIN CARE CENTER?', 'It is open on Mondays, Wednesdays, Fridays, and Saturdays from 1:00 to 4:30 pm, until notice has been made. The clinic can accommodate an average of 15 to 20 patients a day.');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `services` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `services`) VALUES
(5, 'MEDICAL FACIAL'),
(6, 'ACNE SURGERY'),
(7, 'BB GLOW FACIAL'),
(8, 'PIMPLE INJECTION');

-- --------------------------------------------------------

--
-- Table structure for table `slots`
--

CREATE TABLE `slots` (
  `id` int(11) NOT NULL,
  `slots_left` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slots`
--

INSERT INTO `slots` (`id`, `slots_left`) VALUES
(1, '4');

-- --------------------------------------------------------

--
-- Table structure for table `zp_account`
--

CREATE TABLE `zp_account` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `age` int(10) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `bday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zp_account`
--

INSERT INTO `zp_account` (`id`, `fname`, `lname`, `role`, `age`, `contact`, `email`, `password`, `bday`) VALUES
(1, 'jeff', 'jeff', 'Derma', 0, '', 'blazered098@gmail.com', '$2y$10$Cgz.vYphTXPjmIW75i/rwe21RtgmjL72u9QBpsqYYDTd0KXxKX2ci', NULL),
(3, 'like', 'like', 'Staff', 0, '', 'bjomwinston0107@gmail.com', '$2y$10$CrI.DtnlMFbdsqh2yPMBWuOX0O38fmUu2Ikh6BPatQioC3UMsQLr6', NULL),
(11, 'admin', 'admin', 'Admin', 9, '32', 'julzhafiz@gmail.com', '$2y$10$Pz0CS4MPXSbitaA59DVgzuR8ptA67eeBp2/rGs/ktTTpwn0XVYq.i', '2023-05-12');

-- --------------------------------------------------------

--
-- Table structure for table `zp_accounts`
--

CREATE TABLE `zp_accounts` (
  `id` int(11) NOT NULL,
  `clinic_firstname` varchar(100) NOT NULL,
  `clinic_lastname` varchar(100) NOT NULL,
  `clinic_email` varchar(255) NOT NULL,
  `clinic_password` varchar(255) NOT NULL,
  `clinic_role` varchar(50) NOT NULL,
  `account_status` enum('active','deactivated') NOT NULL DEFAULT 'active',
  `zep_acc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zp_accounts`
--

INSERT INTO `zp_accounts` (`id`, `clinic_firstname`, `clinic_lastname`, `clinic_email`, `clinic_password`, `clinic_role`, `account_status`, `zep_acc`) VALUES
(1, 'Arolas', 'Mohammad', 'julzhafiz@gmail.com', '$2y$10$6ZZmCVCJ9smUAN2F6NTccus3rL6YX4gBt9gx9ktGmQqmrkVjrd8Dy', 'Admin', 'active', 'clinic_account-001'),
(2, 'arola', 'mohammad', 'blazered098@gmail.com', '$2y$10$gDzdmQg7JMgB6SDaxBnIR.tcFgGgiedK8HnMoHr/I58T6yz6l8aHG', 'Derma', 'deactivated', 'clinic_account-002'),
(3, 'Arola', 'Mohammad', 'admins@admin.com', '$2y$10$bFALWdxeLi.iQOX83k0aJOyr4Y8.mP7L.3am0ZQFxptthE4/CsZIu', 'Admin', 'active', 'clinic_account-003'),
(4, 'hello', 'miss', 'hafsdfa@gmail.com', '$2y$10$zHH2gKwUiSD.GLYs7TDN2OkHFRuWQm9yGIeUV9z9fE8vuxuAI7d0i', 'Admin', 'active', 'clinic_account-004'),
(5, 'Arola', 'Mohammad', 'julzhafiz@gmail.com', '$2y$10$aGCjhE2o/aYjCnGf4OG3NuiFqW40zjAXjoKc9Opcul7tbcR3Qf7Ku', 'Derma', 'active', 'clinic_account-005'),
(6, 'lefy', 'lefy', 'blazered098@gmail.com', '$2y$10$aSAXuWhsjko6kgrN.pLIdOUDxRYkqrQYAIv2rqXYiOEq9.WWFPEvm', 'Derma', 'active', 'clinic_account-006');

-- --------------------------------------------------------

--
-- Table structure for table `zp_client_record`
--

CREATE TABLE `zp_client_record` (
  `id` int(11) NOT NULL,
  `client_firstname` varchar(50) NOT NULL,
  `client_lastname` varchar(50) NOT NULL,
  `client_birthday` date NOT NULL,
  `client_gender` enum('Male','Female') NOT NULL,
  `client_number` varchar(20) NOT NULL,
  `client_email` varchar(100) NOT NULL,
  `client_emergency_person` varchar(100) NOT NULL,
  `client_relation` varchar(50) NOT NULL,
  `client_emergency_contact_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zp_client_record`
--

INSERT INTO `zp_client_record` (`id`, `client_firstname`, `client_lastname`, `client_birthday`, `client_gender`, `client_number`, `client_email`, `client_emergency_person`, `client_relation`, `client_emergency_contact_number`) VALUES
(1, 'Arola', 'Mohammad', '2023-07-07', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', '0', '09168603112'),
(2, 'Arola', 'Mohammad', '2023-07-20', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', '0', 'asdfasdfasd'),
(3, 'Arola', 'Mohammad', '2023-07-12', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', '0', 'asdfasdfads'),
(4, 'Jom', 'Winston', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'father', '09168603112'),
(5, 'Jom', 'Winston', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'father', '09168603112'),
(6, 'Arola', 'Mohammad', '0000-00-00', 'Female', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfa', 'adsfasdfasdfasdf'),
(7, 'Arola', 'Mohammad', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'father', '09168603112'),
(8, 'Arola', 'Mohammad', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'father', '09168603112'),
(9, 'Arola', 'Mohammad', '0000-00-00', 'Female', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'dsfadfadf', 'asdfasdfadsf'),
(10, 'Arola', 'Mohammad', '0000-00-00', 'Female', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'dsfadfadf', 'asdfasdfadsf'),
(11, 'Arola', 'Mohammad', '0000-00-00', 'Female', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfas', 'adsfasdfasdfasdf'),
(12, 'Arola', 'Mohammad', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfads', 'asdfasfas'),
(13, 'Arola', 'Mohammad', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfads', 'asdfasfas'),
(14, 'Arola', 'Mohammad', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdf', 'asdfasdfasdf'),
(15, 'asdfasdfasdf', 'dfasdfasdf', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfasdf', 'asdfasdfasdfasdfd'),
(16, 'Arola', 'Mohammad', '0000-00-00', 'Female', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfas', 'adfasdfasdfasdf'),
(17, 'Arola', 'Mohammad', '0000-00-00', 'Female', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'sdafsafsadf', 'asdfasdfsdf'),
(18, 'Arola', 'Mohammad', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'sdfsfsd', 'fsfdsfdsf'),
(19, 'qwertyuiopsdfghjk', 'qwertyuioasdhjkl', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfghj', 'asdfghj'),
(20, 'Arola', 'Mohammad', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'adfasdfasdfa', 'sdfasdfasdfa'),
(21, 'adfasdfasdf', 'asdfgrdvsad', '0000-00-00', 'Female', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfads', '09168603112'),
(22, 'dcdcdcdc', 'ccdcdcdc', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfa', '09168603112'),
(23, 'reerttertert', 'ertertetertert', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'ertetert', 'ertertert'),
(24, 'sefsdfsdfsdfsf', 'sdfdfsdfsdfs', '0000-00-00', 'Female', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'sdfsdfsfds', 'sdfsdfsdfsdfds'),
(25, 'nfd', 'mnbvc', '2023-08-16', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', '0', '09168603112'),
(26, 'fffffff', 'fffffff', '0000-00-00', 'Female', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfads', '09168603112'),
(27, 'Arolass', 'Mohammadssss', '2023-08-02', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfa', '09168603112'),
(28, 'asdfasdfasdfasdf', 'asdfasdfasdfa', '0000-00-00', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfasdfsdf', 'asfdasdfasdfasf'),
(29, 'adfaceafe', 'asdceceds', '2023-08-02', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', '0', '09168603112'),
(30, 'asdfasfeer', 'asfersdfasdf', '2023-08-07', 'Male', '09168603112', 'julzhafiz@gmail.com', 'Arola Mohammad', 'asdfasdfads', '09168603112'),
(31, 'asdfasdfafvsdv', 'vasdvasdfasee', '2023-08-07', 'Male', 'asdfasdfas', 'asdfasdfasdf@fagfgfg.com', 'Arola Mohammad', 'asdfasdfasdf', 'asdfasdfasdfdsf');

-- --------------------------------------------------------

--
-- Table structure for table `zp_derma_appointment`
--

CREATE TABLE `zp_derma_appointment` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date_appointment` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zp_derma_appointment`
--

INSERT INTO `zp_derma_appointment` (`id`, `patient_id`, `date_appointment`) VALUES
(1, 29, '2023-08-02'),
(2, 29, '2023-08-23'),
(3, 29, '2023-08-10'),
(4, 29, '2023-07-04');

-- --------------------------------------------------------

--
-- Table structure for table `zp_derma_record`
--

CREATE TABLE `zp_derma_record` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date_diagnosis` date NOT NULL,
  `history` varchar(255) NOT NULL,
  `diagnosis` text NOT NULL,
  `management` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zp_derma_record`
--

INSERT INTO `zp_derma_record` (`id`, `patient_id`, `date_diagnosis`, `history`, `diagnosis`, `management`) VALUES
(1, 2, '0000-00-00', '', 'asfsadfsdfsfdfafd', ''),
(2, 1, '0000-00-00', '', 'fasdfasfadfsfarola', ''),
(4, 3, '0000-00-00', '', '<p><b>asdfasdfasdfsdf</b></p>', ''),
(7, 2, '0000-00-00', '', 'asfsadfsdfsfdfafdasdfasdf', ''),
(8, 2, '0000-00-00', '', 'asfsadfsdfsfdfafd<br>asdfasdf', ''),
(9, 1, '0000-00-00', '', '<p>adsfasdfadsf</p>', ''),
(11, 3, '0000-00-00', '', '<p><font color=\"#000000\" style=\"background-color: rgb(255, 255, 0);\">sadfasdfadsf</font></p>', ''),
(12, 3, '0000-00-00', '', '<p><b><u>fasdfasdfasdf</u></b></p>', ''),
(13, 1, '0000-00-00', '', 'katarata', ''),
(17, 1, '0000-00-00', '', '<p>asdfasdf asdfadsf</p>', ''),
(18, 1, '0000-00-00', '', '<p>adsasdfdf</p>', ''),
(19, 1, '0000-00-00', '', '<p><font color=\"#000000\" style=\"background-color: rgb(255, 255, 0);\">asdfasdf</font> sdfasdfa</p>', ''),
(20, 1, '0000-00-00', '', '<p>asdfasdfasdf</p>', ''),
(21, 1, '0000-00-00', '', '<p>asdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasf</p>', ''),
(22, 1, '0000-00-00', '', '<p>asdfasdfasdfds</p>', ''),
(23, 1, '0000-00-00', '', '<p>afasdfasdfasdf</p>', ''),
(24, 1, '0000-00-00', '', '<p>vvvffvfvf</p>', ''),
(25, 2, '0000-00-00', '', '<p>fvfvfvfvfvfv</p>', ''),
(26, 1, '0000-00-00', '', '<p>asdfasdfsd</p>', ''),
(27, 1, '0000-00-00', '', '<p>asdfsdfasd</p>', ''),
(28, 1, '0000-00-00', '', '<p>dfghfghd</p>', ''),
(29, 29, '2023-08-03', '', '<p>asdfasdfasdf</p>', ''),
(31, 29, '0000-00-00', '', 'asdfasdfasdfsd', ''),
(32, 29, '0000-00-00', '<p>asdfasdfasd</p>', '', ''),
(33, 29, '2023-08-18', '<p>asdfasdfsdf</p>', 'asddfasdfsddf', ''),
(34, 29, '2023-08-18', '<p>asdfasdfsdf</p>', 'asddfasdfsddf', ''),
(35, 29, '2023-08-24', 'asdfasdfasd', 'asdfasdfasdfsdf', ''),
(36, 29, '2023-08-03', 'asdfasdfasdf', 'asdfasdfsadf', ''),
(37, 29, '2023-08-18', 'asdfasdfasdf', 'asdfasdfsdf', ''),
(38, 29, '2023-08-18', 'asdfasdfasdf', 'asdfasdfsdf', ''),
(39, 29, '2023-08-07', '', '<p>asdfasdfasdf</p>', ''),
(40, 29, '2023-08-07', '', '<p>asdfasdfasdf</p>', ''),
(41, 29, '2023-08-26', '', '<p>asdfasdfasdfsafd</p>', ''),
(42, 29, '2023-08-09', '<p>asdfasdfasdf</p>', 'asdfasdfsdf', ''),
(43, 29, '2023-08-09', '<p>asdfasdfasdf</p>', 'asdfasdfsddf', 'adfasdfasdfadfsadf'),
(44, 29, '2023-08-05', '<p>qwertyuwrerwerwerwe</p>', 'asdfasdfasdfsdfsd', 'asdfasdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment_slots`
--
ALTER TABLE `appointment_slots`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `book1`
--
ALTER TABLE `book1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `datepick`
--
ALTER TABLE `datepick`
  ADD PRIMARY KEY (`date_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slots`
--
ALTER TABLE `slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zp_account`
--
ALTER TABLE `zp_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zp_accounts`
--
ALTER TABLE `zp_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `zep_acc` (`zep_acc`);

--
-- Indexes for table `zp_client_record`
--
ALTER TABLE `zp_client_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zp_derma_appointment`
--
ALTER TABLE `zp_derma_appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zp_derma_record`
--
ALTER TABLE `zp_derma_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`patient_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_slots`
--
ALTER TABLE `appointment_slots`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `book1`
--
ALTER TABLE `book1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `datepick`
--
ALTER TABLE `datepick`
  MODIFY `date_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `slots`
--
ALTER TABLE `slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zp_account`
--
ALTER TABLE `zp_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `zp_accounts`
--
ALTER TABLE `zp_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `zp_client_record`
--
ALTER TABLE `zp_client_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `zp_derma_appointment`
--
ALTER TABLE `zp_derma_appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `zp_derma_record`
--
ALTER TABLE `zp_derma_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `zp_derma_record`
--
ALTER TABLE `zp_derma_record`
  ADD CONSTRAINT `id` FOREIGN KEY (`patient_id`) REFERENCES `zp_client_record` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
