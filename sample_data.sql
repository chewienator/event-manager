-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2020 at 02:44 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sentral`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `disabled` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `name`, `disabled`) VALUES
(1, 'Sports', 0),
(2, 'Art', 0),
(3, 'Service Organizations', 0),
(4, 'Academic Extension', 0),
(5, 'Performing Arts', 0),
(6, 'Music', 0),
(7, 'Student Government', 0),
(8, 'Student Media', 0),
(9, 'School Club', 0),
(11, 'new activity', 1);

-- --------------------------------------------------------

--
-- Table structure for table `class_group`
--

CREATE TABLE `class_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `disabled` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class_group`
--

INSERT INTO `class_group` (`id`, `name`, `disabled`) VALUES
(1, 'Group 1', 0),
(2, 'Group 2', 0),
(3, 'Group 3', 0),
(4, 'Group 4', 0);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `activity_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `location_id` int(11) NOT NULL,
  `location_id2` int(11) NOT NULL,
  `distance` int(11) NOT NULL,
  `traveling_time` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `registration_close` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `disabled` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `activity_id`, `description`, `location_id`, `location_id2`, `distance`, `traveling_time`, `date_time`, `registration_close`, `active`, `disabled`) VALUES
(1, 'Footy tournament', 1, 'This is a sports tournament for all kids in groups 2 and 3', 4, 2, 1721, 346, '2020-04-08 13:00:00', '2020-04-03 14:00:00', 1, 0),
(2, 'Band concert at opera house', 6, 'Event at Sydney opera house', 4, 5, 10678, 838, '2020-04-06 21:00:00', '2020-04-20 19:00:00', 1, 0),
(3, 'School Play at Opera house', 5, 'Ultimo to opera house event', 1, 5, 9461, 675, '2020-06-17 10:00:00', '2020-06-07 11:55:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_attendees`
--

CREATE TABLE `event_attendees` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attending` tinyint(4) NOT NULL DEFAULT 0,
  `confirmed` tinyint(4) NOT NULL DEFAULT 0,
  `attended` tinyint(4) NOT NULL DEFAULT 0,
  `is_organiser` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_attendees`
--

INSERT INTO `event_attendees` (`event_id`, `user_id`, `attending`, `confirmed`, `attended`, `is_organiser`) VALUES
(1, 2, 0, 0, 0, 1),
(1, 6, 0, 0, 0, 0),
(1, 7, 0, 0, 0, 0),
(1, 8, 1, 1, 0, 0),
(1, 9, 0, 0, 0, 0),
(1, 10, 0, 0, 0, 0),
(2, 2, 1, 0, 0, 0),
(2, 7, 0, 1, 0, 0),
(2, 8, 1, 1, 0, 0),
(2, 9, 1, 1, 0, 1),
(2, 10, 1, 0, 1, 1),
(3, 6, 0, 0, 0, 0),
(3, 7, 0, 0, 0, 0),
(3, 8, 0, 0, 0, 0),
(3, 9, 0, 0, 0, 1),
(3, 10, 0, 0, 0, 0),
(2, 1, 0, 0, 0, 0),
(2, 5, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `disabled` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `latitude`, `longitude`, `disabled`) VALUES
(1, 'Ultimo Public School', '-33.87747540000001', '151.1958187', 0),
(2, 'School of Computer Science, The University of Sydney', '-33.8882736', '151.1940845', 0),
(3, 'St James Catholic Primary School, Woolley Street, Glebe NSW, Australia', '-33.8688197', '151.2092955', 1),
(4, 'St James Catholic Primary School', '-33.8796491', '151.1848133', 0),
(5, 'Sydney Opera House', '-33.8567844', '151.2152967', 0),
(6, 'UNSW Sydney', '-33.917347', '151.2312675', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `user_type` tinyint(4) NOT NULL,
  `disabled` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `group_id`, `first_name`, `last_name`, `email`, `mobile`, `user_type`, `disabled`) VALUES
(1, 0, 'Carlos', 'Gomez', 'cgomez@mpg-live.com', '', 1, 0),
(2, 3, 'Mike', 'Myers', 'mike@myers.com', '887897', 2, 0),
(3, 1, 'Dolly', 'Parton', 'dolly@parton.com', '2345678', 2, 0),
(4, 1, 'Alyson', 'Newton', 'alyson@newton.com', '1234567890', 3, 0),
(5, 1, 'Charlie', 'Wilson', 'charlie@wilson.com', '1234567890', 3, 0),
(6, 2, 'Peter', 'Pan', 'peter@neverland.com', '889686', 3, 0),
(7, 2, 'Olivia', 'Martin', 'olivia@martin.com', '88789', 3, 0),
(8, 2, 'Amelia', 'Vidmar', 'amelia@vidmar.com', '1234567890', 3, 0),
(9, 2, 'Emily', 'Pillion', 'emily@pillion.com', '8689689', 2, 0),
(10, 1, 'Gayle', 'Porter', 'gayle@porter.com', '', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `disabled` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `name`, `disabled`) VALUES
(1, 'Admin', 0),
(2, 'Staff / Teacher', 0),
(3, 'Student / Parent', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_group`
--
ALTER TABLE `class_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `class_group`
--
ALTER TABLE `class_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
