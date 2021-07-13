-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 18, 2021 at 08:25 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asms`
--

-- --------------------------------------------------------

--
-- Table structure for table `filtersms`
--

DROP TABLE IF EXISTS `filtersms`;
CREATE TABLE IF NOT EXISTS `filtersms` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `vendor` varchar(50) NOT NULL,
  `alarm_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `filter_op` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `filtersms`
--

INSERT INTO `filtersms` (`id`, `vendor`, `alarm_name`, `filter_op`) VALUES
(1, 'HUAWEI', 'Mains Input Out of Range', '1'),
(2, 'HUAWEI', 'Generator Running Alarm', '1'),
(3, 'HUAWEI', 'SCTP Link Fault', '0'),
(4, 'HUAWEI', 'Cell Unavailable', '1'),
(5, 'HUAWEI', 'Battery Current Out of Range', '1'),
(6, 'HUAWEI', 'Board Hardware Fault', '1'),
(7, 'HUAWEI', 'Battery Power Unavailable', '0'),
(8, 'ZTE', 'Battery Discharge', '0'),
(9, 'ZTE', 'DC SPD Abnormal', '0'),
(10, 'ZTE', 'AC Power Off', '0'),
(11, 'ZTE', 'SMR PFC Fault', '0'),
(12, 'ZTE', 'SMR Internal Temperature High', '0'),
(13, 'ZTE', 'DC Voltage Low', '0'),
(14, 'ZTE', 'AC Phase Lack', '0'),
(15, 'ZTE', 'Battery Temperature High', '0'),
(16, 'ZTE', 'Access Control Alarm', '0'),
(17, 'ZTE', 'SPD-C Alarm', '0'),
(18, 'ZTE', 'LLVD1 Alarm', '0'),
(19, 'ZTE', 'SMR Communication Fail', '0'),
(20, 'ZTE', 'Environment Temperature High', '0'),
(21, 'ZTE', 'Communication Failure', '0'),
(22, 'ZTE', 'Battery Voltage Low', '0'),
(23, 'ZTE', 'Phase Voltage Low', '0'),
(24, 'ZTE', 'Battery Temperature Invalid', '0'),
(25, 'ZTE', 'SMR Input Voltage Low Off', '0'),
(26, 'ZTE', 'AC Voltage Imbalance', '0'),
(27, 'ZTE', 'Battery Test Fail', '0'),
(28, 'ZTE', 'AC Input Switch Off', '0'),
(29, 'ZTE', 'Data From Device Unmatched', '0');

-- --------------------------------------------------------

--
-- Table structure for table `recsms`
--

DROP TABLE IF EXISTS `recsms`;
CREATE TABLE IF NOT EXISTS `recsms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime NOT NULL,
  `msg` varchar(500) CHARACTER SET latin1 NOT NULL,
  `sender_num` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recsms`
--

INSERT INTO `recsms` (`id`, `date_time`, `msg`, `sender_num`) VALUES
(16, '2020-03-09 20:57:27', '+  NE Name=KGDER1_00L_Deraniyagala_IP_Dh  Alarm Name=Mains Input Out of Range  Occurrence Time=2020/2/11 18:42:18 GMT+05:30  Location Information=Cabinet No.=0, Subrack No.=7, Slot No.=0, Board Type=PMU, Specific Problem=AC Phase Loss  Clearance Time=2020/2/12 06:18:36 GMT+05:30  -', '718754216'),
(21, '2020-03-09 20:59:17', '+  NE Name=KGDEE1_GU0_Deegala_@Dh  Alarm Name=Mains Input Out of Range  Occurrence Time=2020/2/11 19:27:13 GMT+05:30  Location Information=Cabinet No.=1, Subrack No.=7, Slot No.=0, Board Type=PMU, Specific Problem=AC Failure  Clearance Time=2020/2/12 07:30:56 GMT+05:30  -', '718754216'),
(22, '2020-03-09 20:59:53', '+  NE Name=KGDEE1_GU0_Deegala_@Dh  Alarm Name=Mains Input Out of Range  Occurrence Time=2020/2/11 19:27:15 GMT+05:30  Location Information=Cabinet No.=0, Subrack No.=7, Slot No.=0, Board Type=PMU, Specific Problem=AC Failure  Clearance Time=2020/2/12 07:31:05 GMT+05:30  -', '718754216'),
(25, '2020-03-09 21:02:47', '+  NE Name=KGDER2_0U0_Ilukthenna2_Dh  Alarm Name=Mains Input Out of Range  Occurrence Time=2020/2/12 05:50:27 GMT+05:30  Location Information=Cabinet No.=0, Subrack No.=7, Slot No.=0, Board Type=PMU, Specific Problem=AC Failure  Clearance Time=2020/2/12 07:47:34 GMT+05:30  -', '718754266'),
(24, '2020-03-09 21:01:59', '+  NE Name=KGDER2_0U0_Ilukthenna2_Dh  Alarm Name=Mains Input Out of Range  Occurrence Time=2020/2/12 05:50:27 GMT+05:30  Location Information=Cabinet No.=0, Subrack No.=7, Slot No.=0, Board Type=PMU, Specific Problem=AC Failure  Clearance Time=2020/2/12 07:47:34 GMT+05:30  -', '718754266'),
(26, '2020-03-09 21:03:35', 'alarm raise: NE:Site 57 (KNPNW1_Punnaveli_89_Jf); Alarm Code:AC Power Off(70145); Raised Time:2020-02-11 14:28:22', '718754266'),
(27, '2020-03-09 21:04:18', 'alarm raise: NE:Site 248  ( 706_JFNAI1_Nagadeepa __Jf  ); Alarm Code:AC Power Off(70145); Raised Time:2020-02-11 14:44:38', '719875563'),
(28, '2020-03-09 21:04:44', 'alarm raise: NE:Site 248  ( 706_JFNAI1_Nagadeepa __Jf  ); Alarm Code:AC Power Off(70145); Raised Time:2020-02-11 15:04:44', '719875563'),
(29, '2020-03-09 21:06:41', 'alarm1(alarm raise): NE:Site 159 (KNTHI1_Thirunagar__9_Jf); Alarm Code:AC Power Off(70145); Raised Time:2020-02-11 15:59:37 ...etc( total 2 record(s) )', '719875563'),
(30, '2020-03-09 21:07:10', 'alarm1(alarm raise): NE:Site 242 (JFCHK1_CHUNDIKULAM_89_Jf); Alarm Code:AC Power Off(70145); Raised Time:2020-02-11 16:39:10 ...etc( total 2 record(s) )', '719875563'),
(31, '2020-03-09 21:07:35', 'alarm1(alarm raise): NE:Site 242 (JFCHK1_CHUNDIKULAM_89_Jf); Alarm Code:AC Power Off(70145); Raised Time:2020-02-11 17:16:14 ...etc( total 2 record(s) )', '719875563'),
(32, '2020-03-09 21:08:21', 'alarm1(alarm raise): NE:Site 313 (861_JFSAR1_Sarasalai__Jf ); Alarm Code:AC Power Off(70145); Raised Time:2020-02-11 17:44:19 ...etc( total 2 record(s) )', '719875563'),
(33, '2020-03-09 21:09:31', 'alarm1(alarm raise): NE:Site22007  (JFDEL1_DELFT__9_Jf)); Alarm Code:AC Power Off(70145); Raised Time:2020-02-11 18:19:25 ...etc( total 2 record(s) )', '719875563'),
(34, '2020-03-09 21:10:06', 'alarm1(alarm raise): NE:Site 8 (JFDEL1_DELFT__8_Jf); Alarm Code:AC Power Off(70145); Raised Time:2020-02-11 21:43:09 ...etc( total 2 record(s) )', '719875563'),
(35, '2020-03-09 21:10:47', 'alarm1(alarm raise): NE:Site 8 (JFDEL1_DELFT__8_Jf); Alarm Code:AC Power Off(70145); Raised Time:2020-02-11 23:11:32 ...etc( total 2 record(s) )', '719875563'),
(36, '2020-03-09 21:11:23', 'alarm1(alarm raise): NE:Site22007  (JFDEL1_DELFT__9_Jf)); Alarm Code:AC Power Off(70145); Raised Time:2020-02-12 04:49:57 ...etc( total 2 record(s) )', '719875563'),
(39, '2020-03-09 21:13:39', 'alarm1(alarm raise): NE:Site 57 (KNPNW1_Punnaveli_89_Jf); Alarm Code:AC Power Off(70145); Raised Time:2020-02-12 06:51:00 ...etc( total 2 record(s) )', '719875563'),
(41, '2020-03-09 21:16:16', 'alarm raise: NE:Site22007  (JFDEL1_DELFT__9_Jf)); Alarm Code:AC Power Off(70145); Raised Time:2020-02-12 07:58:55', '719875563'),
(42, '2020-03-09 21:16:47', 'alarm1(alarm raise): NE:Site 8 (JFDEL1_DELFT__8_Jf); Alarm Code:AC Power Off(70145); Raised Time:2020-02-12 07:58:10 ...etc( total 2 record(s) )', '719875563');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `region_code` varchar(5) CHARACTER SET latin1 NOT NULL,
  `officer_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `mobile_num` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `region_name`, `region_code`, `officer_name`, `mobile_num`) VALUES
(55, 'Colombo', 'Co', 'Nimal Wimalasiri', '94715487123'),
(56, 'Colombo', 'Co', 'Hiran lakmal', '94715421350'),
(57, 'Colombo', 'Co', 'Lakmal Siriwardene', '94715472358'),
(54, 'Colombo', 'Co', 'Nimal Chandrasiri', '94716542138'),
(53, 'Colombo', 'Co', 'Anuruddha Sumanasiri ', '94718754126');

-- --------------------------------------------------------

--
-- Table structure for table `sentsms`
--

DROP TABLE IF EXISTS `sentsms`;
CREATE TABLE IF NOT EXISTS `sentsms` (
  `id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `region_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `alarm_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `ack` varchar(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'inoc', '$2y$10$YdfyAQ0bJxycsdk3TZLnIOEXksNJs5pb3TS1JdwqOwzOgtFNMyPAW');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
