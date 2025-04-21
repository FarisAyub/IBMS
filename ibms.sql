-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 01:14 AM
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
-- Database: `ibms`
--

-- --------------------------------------------------------

--
-- Table structure for table `ibms-accounts`
--

CREATE TABLE `ibms-accounts` (
  `Username` varchar(12) NOT NULL,
  `Password` varchar(12) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `Age` int(3) NOT NULL,
  `Phone` varchar(11) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `Country` varchar(255) NOT NULL,
  `Access` int(1) NOT NULL,
  `AvatarId` varchar(255) NOT NULL,
  `Created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ibms-accounts`
--

INSERT INTO `ibms-accounts` (`Username`, `Password`, `Email`, `Name`, `Gender`, `Age`, `Phone`, `Street`, `Country`, `Access`, `AvatarId`, `Created`) VALUES
('admin', 'admin', 'test@email.com', 'Administrator', 'Male', 27, '01274999999', '14 Test Street', 'United Kingdom', 2, 'ava4', '2025-03-01'),
('user', 'user', 'testuser@email.com', 'User', 'Male', 27, '01274999999', '14 Test Street', 'United Kingdom', 1, 'ava3', '2025-03-01');

-- --------------------------------------------------------

--
-- Table structure for table `ibms-appointments`
--

CREATE TABLE `ibms-appointments` (
  `app_id` int(8) NOT NULL,
  `Username` varchar(12) NOT NULL,
  `Message` varchar(80) NOT NULL,
  `Return_message` varchar(12) NOT NULL,
  `App_loc` varchar(255) NOT NULL,
  `App_date` date NOT NULL,
  `Time` varchar(4) NOT NULL,
  `Status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ibms-appointments`
--

INSERT INTO `ibms-appointments` (`app_id`, `Username`, `Message`, `Return_message`, `App_loc`, `App_date`, `Time`, `Status`) VALUES
(1, 'admin', 'I need some help with my car insurance and would appreciate some advice.', 'Your appoint', 'Leeds', '2019-01-01', '6PM', 'Successful');

-- --------------------------------------------------------

--
-- Table structure for table `ibms-data`
--

CREATE TABLE `ibms-data` (
  `Policy_id` int(11) NOT NULL,
  `Views` int(11) NOT NULL,
  `Likes` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ibms-data`
--

INSERT INTO `ibms-data` (`Policy_id`, `Views`, `Likes`) VALUES
(1, 10, 0),
(2, 18, 3),
(3, 0, 0),
(4, 0, 0),
(5, 0, 0),
(6, 0, 0),
(7, 0, 0),
(8, 0, 0),
(9, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ibms-healthins`
--

CREATE TABLE `ibms-healthins` (
  `healthins_id` int(11) NOT NULL,
  `Username` varchar(12) NOT NULL,
  `Policy_id` int(11) NOT NULL,
  `SSN` int(9) NOT NULL,
  `Job` varchar(255) NOT NULL,
  `Employer` varchar(255) NOT NULL,
  `Hire_date` date NOT NULL,
  `Policy_start_date` date NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Quote` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ibms-healthins`
--

INSERT INTO `ibms-healthins` (`healthins_id`, `Username`, `Policy_id`, `SSN`, `Job`, `Employer`, `Hire_date`, `Policy_start_date`, `Status`, `Quote`) VALUES
(3, 'admin', 9, 123151231, 'Software Developer', 'John Doe', '2018-01-01', '2018-01-01', 'Pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `ibms-homeins`
--

CREATE TABLE `ibms-homeins` (
  `homeins_id` int(11) NOT NULL,
  `Username` varchar(12) NOT NULL,
  `Policy_id` int(11) NOT NULL,
  `Property` varchar(255) NOT NULL,
  `Year_built` varchar(12) NOT NULL,
  `Bedroom_count` int(2) NOT NULL,
  `Square_footage` int(4) NOT NULL,
  `Purchase_price` varchar(255) NOT NULL,
  `Stories` int(2) NOT NULL,
  `Purchase_date` date NOT NULL,
  `Policy_start_date` date NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Quote` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ibms-likes`
--

CREATE TABLE `ibms-likes` (
  `like_id` int(8) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Liked` int(1) NOT NULL,
  `Rating` int(1) NOT NULL,
  `Policy_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ibms-policies`
--

CREATE TABLE `ibms-policies` (
  `Policy_id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ibms-policies`
--

INSERT INTO `ibms-policies` (`Policy_id`, `img`, `Title`, `Type`, `Description`) VALUES
(1, '../Images/AvivaCI.jpg', 'Aviva', 'Car Insurance', 'Defaqto 5 star car insurance from $163 - 10% paid this for standard cover. Terms and conditions\r\napply.'),
(2, 'AdmiralCI.jpg', 'Admiral', 'Car Insurance', 'Admiral Car Insurance Information'),
(3, 'AdrianCI.jpg', 'Adrian', 'Car Insurance', 'Adrian car insurance description.'),
(4, 'TescoHI.jpg', 'Tesco', 'Home Insurance', 'Tesco home insurance description.'),
(5, 'ChurchillHI.jpg', 'Churchill', 'Health Insurance', 'Churchill health insurance decsription.'),
(6, 'DlCI.jpg', 'Direct Line', 'Health Insurance', 'Direct line health insurance description.'),
(7, 'JohnlewHI.jpg', 'John Lewis', 'Home Insurance', 'John Lewis home insurance description.'),
(8, 'MandsHI.jpg', 'M&S', 'Home Insurance', 'M&S home insurance description.'),
(9, 'sagaHI.jpg', 'SAGA', 'Health Insurance', 'Saga health insurance description.');

-- --------------------------------------------------------

--
-- Table structure for table `ibms-preferences`
--

CREATE TABLE `ibms-preferences` (
  `Username` varchar(12) NOT NULL,
  `Preference_1` varchar(255) NOT NULL,
  `Preference_2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ibms-preferences`
--

INSERT INTO `ibms-preferences` (`Username`, `Preference_1`, `Preference_2`) VALUES
('admin', 'Car Insurance', 'Requested'),
('user', 'Vehicle Insurance', 'Requested');

-- --------------------------------------------------------

--
-- Table structure for table `ibms-vehicleins`
--

CREATE TABLE `ibms-vehicleins` (
  `vehins_id` int(11) NOT NULL,
  `Username` varchar(12) NOT NULL,
  `Policy_id` int(11) NOT NULL,
  `Make` varchar(255) NOT NULL,
  `Model` varchar(255) NOT NULL,
  `Manufacture_year` varchar(4) NOT NULL,
  `Reg_Date` date NOT NULL,
  `Policy_Start` date NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Quote` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ibms-accounts`
--
ALTER TABLE `ibms-accounts`
  ADD PRIMARY KEY (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `ibms-appointments`
--
ALTER TABLE `ibms-appointments`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `Username` (`Username`);

--
-- Indexes for table `ibms-data`
--
ALTER TABLE `ibms-data`
  ADD PRIMARY KEY (`Policy_id`);

--
-- Indexes for table `ibms-healthins`
--
ALTER TABLE `ibms-healthins`
  ADD PRIMARY KEY (`healthins_id`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `Policy_id` (`Policy_id`);

--
-- Indexes for table `ibms-homeins`
--
ALTER TABLE `ibms-homeins`
  ADD PRIMARY KEY (`homeins_id`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `Policy_id` (`Policy_id`);

--
-- Indexes for table `ibms-likes`
--
ALTER TABLE `ibms-likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `Policy_id` (`Policy_id`);

--
-- Indexes for table `ibms-policies`
--
ALTER TABLE `ibms-policies`
  ADD PRIMARY KEY (`Policy_id`),
  ADD UNIQUE KEY `Policy_id` (`Policy_id`);

--
-- Indexes for table `ibms-preferences`
--
ALTER TABLE `ibms-preferences`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `ibms-vehicleins`
--
ALTER TABLE `ibms-vehicleins`
  ADD PRIMARY KEY (`vehins_id`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `Policy_id` (`Policy_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ibms-appointments`
--
ALTER TABLE `ibms-appointments`
  MODIFY `app_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ibms-healthins`
--
ALTER TABLE `ibms-healthins`
  MODIFY `healthins_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ibms-likes`
--
ALTER TABLE `ibms-likes`
  MODIFY `like_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ibms-policies`
--
ALTER TABLE `ibms-policies`
  MODIFY `Policy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ibms-appointments`
--
ALTER TABLE `ibms-appointments`
  ADD CONSTRAINT `ibms-appointments_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `ibms-accounts` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ibms-data`
--
ALTER TABLE `ibms-data`
  ADD CONSTRAINT `ibms-data_ibfk_1` FOREIGN KEY (`Policy_id`) REFERENCES `ibms-policies` (`Policy_id`);

--
-- Constraints for table `ibms-healthins`
--
ALTER TABLE `ibms-healthins`
  ADD CONSTRAINT `ibms-healthins_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `ibms-accounts` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ibms-healthins_ibfk_2` FOREIGN KEY (`Policy_id`) REFERENCES `ibms-policies` (`Policy_id`);

--
-- Constraints for table `ibms-homeins`
--
ALTER TABLE `ibms-homeins`
  ADD CONSTRAINT `ibms-homeins_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `ibms-accounts` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ibms-homeins_ibfk_2` FOREIGN KEY (`Policy_id`) REFERENCES `ibms-policies` (`Policy_id`);

--
-- Constraints for table `ibms-preferences`
--
ALTER TABLE `ibms-preferences`
  ADD CONSTRAINT `ibms-preferences_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `ibms-accounts` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ibms-vehicleins`
--
ALTER TABLE `ibms-vehicleins`
  ADD CONSTRAINT `ibms-vehicleins_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `ibms-accounts` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ibms-vehicleins_ibfk_2` FOREIGN KEY (`Policy_id`) REFERENCES `ibms-policies` (`Policy_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
