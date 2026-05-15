-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2026 at 01:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ai_academic_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `semester` int(2) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `mid_total` int(3) DEFAULT NULL,
  `mid_obtained` int(3) DEFAULT NULL,
  `g2_obtained` int(3) DEFAULT 0,
  `assignment_total` int(3) DEFAULT NULL,
  `assignment_obtained` int(3) DEFAULT NULL,
  `presentation_total` int(3) DEFAULT NULL,
  `presentation_obtained` int(3) DEFAULT NULL,
  `failures` int(1) DEFAULT 0,
  `studytime` int(1) DEFAULT 1,
  `absences` int(3) DEFAULT 0,
  `activities` varchar(3) DEFAULT 'no',
  `job` varchar(3) DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `student_id`, `semester`, `subject_name`, `mid_total`, `mid_obtained`, `g2_obtained`, `assignment_total`, `assignment_obtained`, `presentation_total`, `presentation_obtained`, `failures`, `studytime`, `absences`, `activities`, `job`) VALUES
(1, 1, 1, 'Introduction to Programming', 30, 25, 0, 10, 9, 10, 8, 0, 1, 0, 'no', 'no'),
(2, 1, 1, 'Discrete Mathematics', 30, 20, 0, 10, 7, 10, 9, 0, 1, 0, 'no', 'no'),
(3, 2, 3, 'Linear Algebra', 30, 10, 0, 10, 0, 10, 5, 0, 1, 0, 'no', 'no'),
(5, 1, 7, 'Compiler Construction', 30, 22, 0, 10, 8, 10, 9, 0, 1, 2, 'no', 'no'),
(6, 1, 7, 'Parallel & Distributed Computing', 30, 25, 0, 10, 9, 10, 8, 0, 1, 1, 'no', 'no'),
(7, 1, 7, 'Software Project Management', 30, 12, 0, 10, 4, 10, 5, 0, 1, 12, 'no', 'no'),
(8, 16, 7, 'Compiler Construction', 30, 22, 0, 10, 8, 10, 9, 0, 1, 2, 'no', 'no'),
(9, 16, 7, 'Parallel & Distributed Computing', 30, 25, 0, 10, 9, 10, 8, 0, 1, 1, 'no', 'no'),
(10, 16, 7, 'Software Project Management', 30, 12, 0, 10, 4, 10, 5, 0, 1, 12, 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `program_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `program_name`, `description`) VALUES
(1, 'BS Computer Science', 'Bachelor of Science in Computer Science'),
(2, 'BS Mathematics', 'Bachelor of Science in Mathematics');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `program` varchar(50) NOT NULL,
  `semester` int(2) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verify_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `password`, `program`, `semester`, `is_verified`, `verify_token`) VALUES
(1, 'Ali Khan', 'ali@example.com', '12345', 'BSCS', 1, 1, NULL),
(2, 'Sara Ahmed', 'sara@example.com', '12345', 'BSMaths', 3, 1, NULL),
(10, 'fatima kayani', 'kayani@gmail.com', '1234567890', 'BSCS', 7, 0, NULL),
(11, 'Alishba Hussain', 'alishba480@gmail.com', '12345678', 'BSCS', 7, 0, NULL),
(12, 'Ramisha khadim', 'ramisha123@example.com', '12345', 'BSCS', 7, 0, NULL),
(14, 'Sana', 'sana@gmail.com', '12345', 'BSCS', 8, 0, NULL),
(15, 'Amina khan', 'amina@gmail.com', '12345', 'BSCS', 7, 0, NULL),
(16, 'Hijweria', 'hijweria@gmail.com', '12345', 'BSCS', 7, 1, NULL),
(17, 'mudassarahmed', 'mudassarahmed854@gmail.com', '12345', 'BSMaths', 8, 0, '3a2e30f04236cfa89fad5709dc6e803e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
