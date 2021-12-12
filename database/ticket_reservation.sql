-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2021 at 06:39 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticket_reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Bday` date NOT NULL,
  `CitizenID` varchar(13) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `Name`, `Bday`, `CitizenID`, `Address`, `Password`) VALUES
(1, 'Somsak Jeam', '2013-11-24', '6463081814877', 'Sakon Nakhon', 'Somsak007'),
(2, 'Satoshi Ketchum', '1991-10-24', '7653131515106', 'Loburi', 'Sat0shigoh'),
(3, 'Watashi Raka', '2016-11-16', '3564745555067', 'Amnat Charoen', 'Elder830'),
(4, 'John Winyuu', '1987-09-25', '8516261250589', 'Pattani', 'JohnQuantum'),
(5, 'Zera Ora', '1975-05-04', '4116744134622', 'Samut Sakhon', 'ZeraZZ'),
(6, 'Wipada Wantaratorn', '2001-04-02', '1234567891011', 'Nakhon Si Thammarat', 'Nan1060'),
(15, 'Herbal One', '1991-06-11', '1597534862025', 'Tak', 'fingerroot');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackID` int(11) NOT NULL,
  `PaymentID` int(11) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `StaffReply` varchar(255) DEFAULT NULL,
  `StaffID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FeedbackID`, `PaymentID`, `Comment`, `StaffReply`, `StaffID`) VALUES
(1, 1, 'Good movie. Thank you.', 'Thank you.', 1),
(2, 2, 'The seat is too expensive.', 'We are sorry. We will consider decreasing the seat price in the future.', 2),
(3, 5, 'The movie is really funny. I love it.', 'Thank you.', 3),
(4, 6, 'The theater is so cold that I\'m freezing.', 'We are sorry. We will adjust the ac\'s temperature.', 4),
(5, 9, 'Booking system is still confusing to use.', 'We are sorry. We will try to make it easier to use.', 5),
(6, 10, 'Could you consider adding a promotion with a popcorn or drinks?', 'Thank you for suggestion. We will consider it in the future.', 3),
(7, 11, 'I want to pay with credit card.', 'We are sorry. We will consider it in the future.', 5),
(8, 1, 'My seat is broken. Please fix it.', NULL, NULL),
(9, 2, 'Staff is impolite.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `GenresID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`GenresID`, `Name`) VALUES
(1, 'Action'),
(2, 'Comedy'),
(3, 'Drama'),
(4, 'Fantasy'),
(5, 'Horror'),
(6, 'Adventure');

-- --------------------------------------------------------

--
-- Table structure for table `movgenres`
--

CREATE TABLE `movgenres` (
  `MovID` int(11) NOT NULL,
  `GenresID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movgenres`
--

INSERT INTO `movgenres` (`MovID`, `GenresID`) VALUES
(1, 1),
(1, 4),
(1, 6),
(2, 4),
(3, 1),
(3, 4),
(3, 6),
(4, 1),
(4, 4),
(4, 6),
(5, 2),
(5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `MovID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Plot` varchar(255) NOT NULL,
  `Duration` time NOT NULL,
  `AirDate` date NOT NULL,
  `Audio` varchar(255) NOT NULL,
  `Subtitle` varchar(255) NOT NULL,
  `Photo` varchar(255) NOT NULL,
  `StaffID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`MovID`, `Title`, `Plot`, `Duration`, `AirDate`, `Audio`, `Subtitle`, `Photo`, `StaffID`) VALUES
(1, 'Demon Slayer: Kimetsu no Yaiba the Movie: Mugen Train', 'With Kyojuro Rengoku, Tanjiro and the others board the\r\nMugen Train to face a demon who traps his victims in\r\ndreams so sweet, they never want to wake up.', '01:56:00', '2021-12-24', 'JP', 'TH', 'https://i.imgur.com/C6K3L5D.jpg', 3),
(2, 'The Seven Deadly Sins: Cursed By Light', 'Meliodas and his friends jump back into action when the new era of peace is threatened by a powerful magical alliance that could spell the end for all.', '01:20:00', '2022-01-07', 'JP', 'EN', 'https://i.imgur.com/y5AW0HU.jpg', 1),
(3, 'The Legend of Muay Thai: 9 Satra', 'Trained for destiny, a muay thai prodigy must deliver a sacred weapon to his prince to free their kingdom from the rule of a monstrous clan.', '01:45:00', '2021-12-12', 'TH', 'EN', 'https://i.imgur.com/O4lKYID.jpg', 5),
(4, 'The Matrix', 'What is The Matrix? That question leads computer hacker Neo down a rabbit hole -- and to the mind-blowing truth about the world as he knows it.', '02:16:00', '2022-09-09', 'TH', 'TH', 'https://i.imgur.com/4FwMOb4.jpg', 3),
(5, 'Wish Dragon', 'Determined teen Din is longing to reconnect with his childhood best friend when he meets a wish-granting dragon who shows him the magic of possibilities.', '01:22:00', '2022-06-13', 'EN', 'TH', 'https://i.imgur.com/6oxXkKU.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `TicketID` int(11) NOT NULL,
  `Price` double(13,2) NOT NULL,
  `Status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PaymentID`, `CustomerID`, `TicketID`, `Price`, `Status`) VALUES
(1, 1, 1, 380.00, 'Paid'),
(2, 2, 2, 1520.00, 'Paid'),
(3, 3, 3, 370.00, 'Unpaid'),
(4, 4, 4, 400.00, 'Unpaid'),
(5, 5, 5, 1530.00, 'Paid'),
(6, 1, 6, 1550.00, 'Paid'),
(7, 2, 7, 330.00, 'Unpaid'),
(8, 3, 8, 380.00, 'Unpaid'),
(9, 4, 9, 320.00, 'Paid'),
(10, 5, 10, 380.00, 'Paid'),
(11, 1, 1, 360.00, 'Cancelled'),
(12, 6, 11, 140.00, 'Cancelled'),
(13, 1, 10, 360.00, 'Cancelled'),
(14, 1, 10, 360.00, 'Cancelled'),
(15, 1, 11, 400.00, 'Cancelled'),
(16, 2, 8, 380.00, 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `seat`
--

CREATE TABLE `seat` (
  `SeatID` int(11) NOT NULL,
  `Row` char(1) NOT NULL,
  `Column` int(11) NOT NULL,
  `TheaterID` int(11) NOT NULL,
  `STypeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seat`
--

INSERT INTO `seat` (`SeatID`, `Row`, `Column`, `TheaterID`, `STypeID`) VALUES
(1, 'A', 1, 1, 2),
(2, 'A', 2, 1, 2),
(3, 'A', 3, 1, 2),
(4, 'A', 4, 1, 3),
(5, 'A', 5, 1, 3),
(6, 'A', 6, 1, 3),
(7, 'A', 7, 1, 3),
(8, 'A', 8, 1, 2),
(9, 'A', 9, 1, 2),
(10, 'A', 10, 1, 2),
(11, 'B', 1, 1, 1),
(12, 'B', 2, 1, 1),
(13, 'B', 3, 1, 1),
(14, 'B', 4, 1, 1),
(15, 'B', 5, 1, 1),
(16, 'B', 6, 1, 1),
(17, 'B', 7, 1, 1),
(18, 'B', 8, 1, 1),
(19, 'B', 9, 1, 1),
(20, 'B', 10, 1, 1),
(21, 'C', 1, 1, 1),
(22, 'C', 2, 1, 1),
(23, 'C', 3, 1, 1),
(24, 'C', 4, 1, 1),
(25, 'C', 5, 1, 1),
(26, 'C', 6, 1, 1),
(27, 'C', 7, 1, 1),
(28, 'C', 8, 1, 1),
(29, 'C', 9, 1, 1),
(30, 'C', 10, 1, 1),
(31, 'D', 1, 1, 1),
(32, 'D', 2, 1, 1),
(33, 'D', 3, 1, 1),
(34, 'D', 4, 1, 1),
(35, 'D', 5, 1, 1),
(36, 'D', 6, 1, 1),
(37, 'D', 7, 1, 1),
(38, 'D', 8, 1, 1),
(39, 'D', 9, 1, 1),
(40, 'D', 10, 1, 1),
(41, 'E', 1, 1, 1),
(42, 'E', 2, 1, 1),
(43, 'E', 3, 1, 1),
(44, 'E', 4, 1, 1),
(45, 'E', 5, 1, 1),
(46, 'E', 6, 1, 1),
(47, 'E', 7, 1, 1),
(48, 'E', 8, 1, 1),
(49, 'E', 9, 1, 1),
(50, 'E', 10, 1, 1),
(51, 'A', 1, 2, 2),
(52, 'A', 2, 2, 2),
(53, 'A', 3, 2, 2),
(54, 'A', 4, 2, 3),
(55, 'A', 5, 2, 3),
(56, 'A', 6, 2, 3),
(57, 'A', 7, 2, 3),
(58, 'A', 8, 2, 2),
(59, 'A', 9, 2, 2),
(60, 'A', 10, 2, 2),
(61, 'B', 1, 2, 1),
(62, 'B', 2, 2, 1),
(63, 'B', 3, 2, 1),
(64, 'B', 4, 2, 1),
(65, 'B', 5, 2, 1),
(66, 'B', 6, 2, 1),
(67, 'B', 7, 2, 1),
(68, 'B', 8, 2, 1),
(69, 'B', 9, 2, 1),
(70, 'B', 10, 2, 1),
(71, 'C', 1, 2, 1),
(72, 'C', 2, 2, 1),
(73, 'C', 3, 2, 1),
(74, 'C', 4, 2, 1),
(75, 'C', 5, 2, 1),
(76, 'C', 6, 2, 1),
(77, 'C', 7, 2, 1),
(78, 'C', 8, 2, 1),
(79, 'C', 9, 2, 1),
(80, 'C', 10, 2, 1),
(81, 'D', 1, 2, 1),
(82, 'D', 2, 2, 1),
(83, 'D', 3, 2, 1),
(84, 'D', 4, 2, 1),
(85, 'D', 5, 2, 1),
(86, 'D', 6, 2, 1),
(87, 'D', 7, 2, 1),
(88, 'D', 8, 2, 1),
(89, 'D', 9, 2, 1),
(90, 'D', 10, 2, 1),
(91, 'E', 1, 2, 1),
(92, 'E', 2, 2, 1),
(93, 'E', 3, 2, 1),
(94, 'E', 4, 2, 1),
(95, 'E', 5, 2, 1),
(96, 'E', 6, 2, 1),
(97, 'E', 7, 2, 1),
(98, 'E', 8, 2, 1),
(99, 'E', 9, 2, 1),
(100, 'E', 10, 2, 1),
(101, 'A', 1, 3, 2),
(102, 'A', 2, 3, 2),
(103, 'A', 3, 3, 2),
(104, 'A', 4, 3, 3),
(105, 'A', 5, 3, 3),
(106, 'A', 6, 3, 3),
(107, 'A', 7, 3, 3),
(108, 'A', 8, 3, 2),
(109, 'A', 9, 3, 2),
(110, 'A', 10, 3, 2),
(111, 'B', 1, 3, 1),
(112, 'B', 2, 3, 1),
(113, 'B', 3, 3, 1),
(114, 'B', 4, 3, 1),
(115, 'B', 5, 3, 1),
(116, 'B', 6, 3, 1),
(117, 'B', 7, 3, 1),
(118, 'B', 8, 3, 1),
(119, 'B', 9, 3, 1),
(120, 'B', 10, 3, 1),
(121, 'C', 1, 3, 1),
(122, 'C', 2, 3, 1),
(123, 'C', 3, 3, 1),
(124, 'C', 4, 3, 1),
(125, 'C', 5, 3, 1),
(126, 'C', 6, 3, 1),
(127, 'C', 7, 3, 1),
(128, 'C', 8, 3, 1),
(129, 'C', 9, 3, 1),
(130, 'C', 10, 3, 1),
(131, 'D', 1, 3, 1),
(132, 'D', 2, 3, 1),
(133, 'D', 3, 3, 1),
(134, 'D', 4, 3, 1),
(135, 'D', 5, 3, 1),
(136, 'D', 6, 3, 1),
(137, 'D', 7, 3, 1),
(138, 'D', 8, 3, 1),
(139, 'D', 9, 3, 1),
(140, 'D', 10, 3, 1),
(141, 'E', 1, 3, 1),
(142, 'E', 2, 3, 1),
(143, 'E', 3, 3, 1),
(144, 'E', 4, 3, 1),
(145, 'E', 5, 3, 1),
(146, 'E', 6, 3, 1),
(147, 'E', 7, 3, 1),
(148, 'E', 8, 3, 1),
(149, 'E', 9, 3, 1),
(150, 'E', 10, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `seatbooking`
--

CREATE TABLE `seatbooking` (
  `SeatID` int(11) NOT NULL,
  `PaymentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seatbooking`
--

INSERT INTO `seatbooking` (`SeatID`, `PaymentID`) VALUES
(2, 4),
(5, 2),
(8, 10),
(15, 9),
(41, 13),
(42, 14),
(53, 1),
(53, 15),
(56, 6),
(75, 8),
(78, 16),
(100, 11),
(106, 5),
(110, 3),
(140, 12),
(149, 7);

-- --------------------------------------------------------

--
-- Table structure for table `seattype`
--

CREATE TABLE `seattype` (
  `STypeID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Price` double(13,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seattype`
--

INSERT INTO `seattype` (`STypeID`, `Name`, `Price`) VALUES
(1, 'Normal', 200.00),
(2, 'Premium', 220.00),
(3, 'Ultimate', 1400.00);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `BDay` date NOT NULL,
  `CitizenID` varchar(13) NOT NULL,
  `Address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `Name`, `BDay`, `CitizenID`, `Address`, `Password`) VALUES
(1, 'Ross Angelis', '1990-10-13', '2533053127263', 'Bangkok', 'Ross4217'),
(2, 'Marry Jane', '1995-08-15', '8533048041584', 'Nonthaburi', 'MJane'),
(3, 'Yuki Tabara', '1996-04-02', '3711506853861', 'Nan', 'xYuki555x'),
(4, 'Keroro Gunzo', '1985-02-28', '8423523045705', 'Loei', 'Gundam007'),
(5, 'Luca Radioza', '1999-01-01', '1117480076557', 'Tak', 'Luca448'),
(11, 'Calvin Gold', '1992-08-14', '1809945321678', 'Bangkok', 'biopharm');

-- --------------------------------------------------------

--
-- Table structure for table `theater`
--

CREATE TABLE `theater` (
  `TheaterID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `theater`
--

INSERT INTO `theater` (`TheaterID`, `Name`) VALUES
(1, 'Theater 1'),
(2, 'Theater 2'),
(3, 'Theater 3');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `TicketID` int(11) NOT NULL,
  `MovID` int(11) NOT NULL,
  `TheaterID` int(11) NOT NULL,
  `AirTime` datetime NOT NULL,
  `Price` double(13,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`TicketID`, `MovID`, `TheaterID`, `AirTime`, `Price`) VALUES
(1, 1, 2, '2021-12-24 13:10:00', 160.00),
(2, 2, 1, '2022-07-01 10:00:00', 120.00),
(3, 3, 3, '2021-12-12 19:20:00', 150.00),
(4, 4, 1, '2022-09-09 16:25:00', 180.00),
(5, 5, 3, '2022-06-13 15:45:00', 130.00),
(6, 3, 2, '2021-12-24 15:30:00', 150.00),
(7, 5, 3, '2022-06-15 11:45:00', 130.00),
(8, 4, 2, '2022-09-12 19:20:00', 180.00),
(9, 2, 1, '2022-07-07 17:25:00', 120.00),
(10, 1, 1, '2021-12-24 19:30:00', 160.00),
(11, 1, 3, '2021-11-07 15:00:00', 160.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`),
  ADD KEY `PaymentID` (`PaymentID`),
  ADD KEY `StaffID` (`StaffID`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`GenresID`);

--
-- Indexes for table `movgenres`
--
ALTER TABLE `movgenres`
  ADD PRIMARY KEY (`MovID`,`GenresID`),
  ADD KEY `GenresID` (`GenresID`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`MovID`),
  ADD KEY `StaffID` (`StaffID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `TicketID` (`TicketID`);

--
-- Indexes for table `seat`
--
ALTER TABLE `seat`
  ADD PRIMARY KEY (`SeatID`),
  ADD KEY `TheaterID` (`TheaterID`),
  ADD KEY `STypeID` (`STypeID`);

--
-- Indexes for table `seatbooking`
--
ALTER TABLE `seatbooking`
  ADD PRIMARY KEY (`SeatID`,`PaymentID`),
  ADD KEY `PaymentID` (`PaymentID`);

--
-- Indexes for table `seattype`
--
ALTER TABLE `seattype`
  ADD PRIMARY KEY (`STypeID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- Indexes for table `theater`
--
ALTER TABLE `theater`
  ADD PRIMARY KEY (`TheaterID`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`TicketID`),
  ADD KEY `MovID` (`MovID`),
  ADD KEY `TheaterID` (`TheaterID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `GenresID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `MovID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `seat`
--
ALTER TABLE `seat`
  MODIFY `SeatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `seattype`
--
ALTER TABLE `seattype`
  MODIFY `STypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `theater`
--
ALTER TABLE `theater`
  MODIFY `TheaterID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `TicketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`PaymentID`) REFERENCES `payment` (`PaymentID`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`);

--
-- Constraints for table `movgenres`
--
ALTER TABLE `movgenres`
  ADD CONSTRAINT `movgenres_ibfk_1` FOREIGN KEY (`MovID`) REFERENCES `movie` (`MovID`),
  ADD CONSTRAINT `movgenres_ibfk_2` FOREIGN KEY (`GenresID`) REFERENCES `genres` (`GenresID`);

--
-- Constraints for table `movie`
--
ALTER TABLE `movie`
  ADD CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`TicketID`) REFERENCES `ticket` (`TicketID`);

--
-- Constraints for table `seat`
--
ALTER TABLE `seat`
  ADD CONSTRAINT `seat_ibfk_1` FOREIGN KEY (`TheaterID`) REFERENCES `theater` (`TheaterID`),
  ADD CONSTRAINT `seat_ibfk_2` FOREIGN KEY (`STypeID`) REFERENCES `seattype` (`STypeID`);

--
-- Constraints for table `seatbooking`
--
ALTER TABLE `seatbooking`
  ADD CONSTRAINT `seatbooking_ibfk_1` FOREIGN KEY (`SeatID`) REFERENCES `seat` (`SeatID`),
  ADD CONSTRAINT `seatbooking_ibfk_2` FOREIGN KEY (`PaymentID`) REFERENCES `payment` (`PaymentID`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`MovID`) REFERENCES `movie` (`MovID`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`TheaterID`) REFERENCES `theater` (`TheaterID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
