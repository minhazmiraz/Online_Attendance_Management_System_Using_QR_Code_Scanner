-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2018 at 11:30 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activeattendance`
--

CREATE TABLE `tbl_activeattendance` (
  `activeattendanceId` varchar(255) NOT NULL,
  `courseId` varchar(30) NOT NULL,
  `classId` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table for Admin';

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `name`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `id` int(11) NOT NULL,
  `roll` int(11) NOT NULL,
  `attend` tinyint(1) NOT NULL,
  `att_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class`
--

CREATE TABLE `tbl_class` (
  `classId` varchar(5) NOT NULL,
  `semester` int(11) NOT NULL,
  `section` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_class`
--

INSERT INTO `tbl_class` (`classId`, `semester`, `section`) VALUES
('1AM', 1, 'A'),
('1BM', 1, 'B'),
('6AM', 6, 'A'),
('6BM', 6, 'B'),
('6CM', 6, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

CREATE TABLE `tbl_course` (
  `courseId` varchar(30) NOT NULL,
  `courseTitle` varchar(50) NOT NULL,
  `semester` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`courseId`, `courseTitle`, `semester`) VALUES
('cse-3607', 'Numerical Methods', 6),
('cse-3609', 'Theory of Computing', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courseallocstu`
--

CREATE TABLE `tbl_courseallocstu` (
  `courseallocstu_id` varchar(255) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `classId` varchar(5) NOT NULL,
  `courseId` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_courseallocstu`
--

INSERT INTO `tbl_courseallocstu` (`courseallocstu_id`, `stu_id`, `classId`, `courseId`) VALUES
('1510066AMcse-3607', 151006, '6AM', 'cse-3607'),
('1510066AMcse-3609', 151006, '6AM', 'cse-3609'),
('1510116AMcse-3607', 151011, '6AM', 'cse-3607'),
('1510496AMcse-3609', 151049, '6AM', 'cse-3609');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courseallocteacher`
--

CREATE TABLE `tbl_courseallocteacher` (
  `courseallocteacher_id` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `classId` varchar(5) NOT NULL,
  `courseId` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_courseallocteacher`
--

INSERT INTO `tbl_courseallocteacher` (`courseallocteacher_id`, `teacher_id`, `classId`, `courseId`) VALUES
('courseallocId', 9871, '6AM', 'cse-3609');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `name` varchar(255) NOT NULL,
  `roll` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `password` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `os` varchar(255) NOT NULL,
  `os_version` varchar(255) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `fingerprint` varchar(255) NOT NULL,
  `color_depth` varchar(255) NOT NULL,
  `resolution` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`name`, `roll`, `email`, `phone`, `password`, `user_agent`, `os`, `os_version`, `ip`, `fingerprint`, `color_depth`, `resolution`) VALUES
('Tanim Sarwar', 151004, 'tanimsarwar78687@gmail.com', '8801517115090', '912ec803b2ce49e4a541068d495ab570', 'Mozilla/5.0 (Linux; Android 7.0; Redmi Note 4 Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.137 Mobile Safari/537.36', 'Android', '7.0', '192.168.43.1', '2613320186', '24', '360x640'),
('Ahsanul Kalam Akib', 151006, 'akib9ctg@gmail.com', '8801521527954', 'fda5e54c190c891a582006a23a7df236', '', '', '', '', '', '', ''),
('Tanzeed Kaisar', 151011, 'kaisartanzeed@gmail.com', '8801843232625', 'ca0cfcedb966a284f241b0de0798827c', '', '', '', '', '', '', ''),
('Misbah Ahmed Chyy Fahim', 151021, 'imiiucian@gmail.com', '8801914590820', '0d30143b0ac1a28b5f02dc4ed74e6062', '', '', '', '', '', '', ''),
('Showmik Barua', 151026, 'shwmik619@gmail.com', '8801996423891', 'd3f550d19e7497843c40d99fdf42e0dc', '', '', '', '', '', '', ''),
('minhazmiraz', 151049, 'minhazmiraz49@gmail.com', '8801845110988', '95da50be0a2dffad0297268211d60381', 'Mozilla/5.0 (Linux; Android 5.1; HUAWEI TIT-AL00 Build/HUAWEITIT-AL00) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.111 Mobile Safari/537.36', 'Android', '5.1', '192.168.0.103', '3196278049', '32', '360x640');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

CREATE TABLE `tbl_teacher` (
  `teacher_id` int(11) NOT NULL,
  `teachername` varchar(255) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_teacher`
--

INSERT INTO `tbl_teacher` (`teacher_id`, `teachername`, `email`, `phone`, `PASSWORD`) VALUES
(9871, 'Mr. Tanveer Ahsan', 'tanveerahsan@gmail.com', '8801789523129', '4bd6a600d4cb755c07712c599a95da2b'),
(9872, 'Abdul Kadar Muhammad Masum', 'akmmasum@cse.iiuc.ac.bd', '8801708519252', '21e4ef94f2a6b23597efabaec584b504');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tempstuattendance`
--

CREATE TABLE `tbl_tempstuattendance` (
  `tempstuattendanceId` varchar(255) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `courseId` varchar(30) NOT NULL,
  `classId` varchar(5) NOT NULL,
  `attend_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_activeattendance`
--
ALTER TABLE `tbl_activeattendance`
  ADD PRIMARY KEY (`activeattendanceId`),
  ADD UNIQUE KEY `activeattendanceId` (`activeattendanceId`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_class`
--
ALTER TABLE `tbl_class`
  ADD PRIMARY KEY (`classId`);

--
-- Indexes for table `tbl_course`
--
ALTER TABLE `tbl_course`
  ADD PRIMARY KEY (`courseId`);

--
-- Indexes for table `tbl_courseallocstu`
--
ALTER TABLE `tbl_courseallocstu`
  ADD PRIMARY KEY (`courseallocstu_id`),
  ADD UNIQUE KEY `courseallocstu_id` (`courseallocstu_id`);

--
-- Indexes for table `tbl_courseallocteacher`
--
ALTER TABLE `tbl_courseallocteacher`
  ADD PRIMARY KEY (`courseallocteacher_id`),
  ADD UNIQUE KEY `courseallocteacher_id` (`courseallocteacher_id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`roll`),
  ADD UNIQUE KEY `roll` (`roll`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `teacher_id` (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `tbl_tempstuattendance`
--
ALTER TABLE `tbl_tempstuattendance`
  ADD PRIMARY KEY (`tempstuattendanceId`),
  ADD UNIQUE KEY `tempstuattendanceId` (`tempstuattendanceId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
