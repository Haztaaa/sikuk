-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2026 at 07:55 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uji_kelayakan`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `aksi` varchar(100) DEFAULT NULL,
  `tabel` varchar(50) DEFAULT NULL,
  `id_ref` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id_log`, `id_user`, `aksi`, `tabel`, `id_ref`, `created_at`) VALUES
(1, 1, 'tambah_kendaraan', 'kendaraan', 1, '2026-02-23 04:59:52'),
(2, 1, 'tambah_kendaraan', 'kendaraan', 2, '2026-02-23 17:39:49'),
(3, 1, 'buat_pengajuan', 'pengajuan_uji', 2, '2026-02-24 01:33:59'),
(4, 1, 'buat_pengajuan', 'pengajuan_uji', 3, '2026-02-24 01:40:36'),
(5, 1, 'buat_pengajuan', 'pengajuan_uji', 5, '2026-02-25 05:54:21'),
(6, 1, 'approve_manager', 'pengajuan_uji', 5, '2026-02-26 22:04:06'),
(7, 1, 'approve_manager', 'pengajuan_uji', 3, '2026-02-26 22:49:27'),
(8, 1, 'approve_admin_ohs', 'pengajuan_uji', 3, '2026-02-26 22:51:22'),
(9, 1, 'approve_manager', 'pengajuan_uji', 3, '2026-02-26 22:53:05'),
(10, 1, 'approve_admin_ohs', 'pengajuan_uji', 3, '2026-02-26 22:53:11'),
(11, 1, 'approve_manager', 'pengajuan_uji', 3, '2026-02-26 23:01:42'),
(12, 1, 'approve_admin_ohs', 'pengajuan_uji', 3, '2026-02-26 23:01:48'),
(13, 1, 'edit_jadwal', 'jadwal_uji', 1, '2026-02-26 23:11:05'),
(14, 1, 'approve_admin_ohs', 'pengajuan_uji', 5, '2026-02-27 14:09:01'),
(15, 1, 'approve_manager', 'pengajuan_uji', 3, '2026-02-27 14:22:52'),
(16, 1, 'approve_admin_ohs', 'pengajuan_uji', 3, '2026-02-27 14:22:59'),
(17, 1, 'edit_jadwal', 'jadwal_uji', 1, '2026-02-27 14:23:26'),
(18, 1, 'approve_manager', 'pengajuan_uji', 5, '2026-02-27 14:23:46'),
(19, 1, 'approve_admin_ohs', 'pengajuan_uji', 5, '2026-02-27 14:23:52'),
(20, 1, 'edit_jadwal', 'jadwal_uji', 2, '2026-02-27 14:24:20'),
(21, 1, 'buat_pengajuan', 'pengajuan_uji', 6, '2026-02-27 14:42:50'),
(22, 1, 'approve_manager', 'pengajuan_uji', 6, '2026-02-27 14:44:14'),
(23, 1, 'approve_manager', 'pengajuan_uji', 3, '2026-02-27 14:47:19'),
(24, 1, 'approve_admin_ohs', 'pengajuan_uji', 6, '2026-02-27 14:47:30'),
(25, 1, 'approve_manager', 'pengajuan_uji', 6, '2026-02-27 14:49:47'),
(26, 1, 'approve_admin_ohs', 'pengajuan_uji', 6, '2026-02-27 14:49:52');

-- --------------------------------------------------------

--
-- Table structure for table `checklist_item`
--

CREATE TABLE `checklist_item` (
  `id_item` int(10) UNSIGNED NOT NULL,
  `id_template` int(10) UNSIGNED NOT NULL,
  `kategori` enum('CRITICAL','GENERAL') NOT NULL DEFAULT 'GENERAL',
  `no_urut` varchar(10) NOT NULL,
  `kriteria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checklist_item`
--

INSERT INTO `checklist_item` (`id_item`, `id_template`, `kategori`, `no_urut`, `kriteria`) VALUES
(1, 1, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(2, 1, 'CRITICAL', '2', 'Fire Extinguisher min. 2kg good and on the right place'),
(3, 1, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(4, 1, 'CRITICAL', '4', 'Reversing alarm operational'),
(5, 1, 'CRITICAL', '5', 'Park and service brake operational'),
(6, 1, 'CRITICAL', '6', 'Seatbelt provided and in good condition'),
(7, 1, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(8, 1, 'CRITICAL', '8', 'Tyres in good condition (min. treads 1.5mm)'),
(9, 1, 'CRITICAL', '9', '4 wheel drive (high and low range)'),
(10, 1, 'GENERAL', '10', 'VHF 2 ways Radio fitted and operational'),
(11, 1, 'GENERAL', '11', 'Horn operational'),
(12, 1, 'GENERAL', '12', 'Emergency Stop / shutdown devices operational'),
(13, 1, 'GENERAL', '13', 'All controls, buttons, levers, etc., clearly labelled'),
(14, 1, 'GENERAL', '14', 'Isolation points lockable'),
(15, 1, 'GENERAL', '15', 'Batteries secured and connections tight'),
(16, 1, 'GENERAL', '16', 'Cable and hoses adequately secured and protected'),
(17, 1, 'GENERAL', '17', 'Cover and guards in good condition and secured'),
(18, 1, 'GENERAL', '18', 'Safety glass and mirror clear and in good condition / no additional accessories'),
(19, 1, 'GENERAL', '19', 'Undercarriage: wheel, rim, axel, spring etc in good condition'),
(20, 1, 'GENERAL', '20', 'Mobile Equipment Identification Number (front, rear, left & right side)'),
(21, 1, 'GENERAL', '21', 'Maintenance records / mechanical inspection reports provided'),
(22, 1, 'GENERAL', '22', 'No oil or fuel leaks'),
(23, 1, 'GENERAL', '23', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(24, 2, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(25, 2, 'CRITICAL', '2', 'Fire Extinguisher min. 6kg good and on the right place'),
(26, 2, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(27, 2, 'CRITICAL', '4', 'Reversing alarm operational'),
(28, 2, 'CRITICAL', '5', 'Park and service brake operational'),
(29, 2, 'CRITICAL', '6', 'Seatbelt provided and in good condition'),
(30, 2, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(31, 2, 'CRITICAL', '8', 'Tyres in good condition'),
(32, 2, 'CRITICAL', '9', '6 or 4 wheel drive (high and low range)'),
(33, 2, 'GENERAL', '10', 'VHF 2 ways Radio fitted and operational'),
(34, 2, 'GENERAL', '11', 'Horn operational'),
(35, 2, 'GENERAL', '12', 'Emergency Stop / shutdown devices operational'),
(36, 2, 'GENERAL', '13', 'All controls, buttons, levers, etc., clearly labelled'),
(37, 2, 'GENERAL', '14', 'Isolation points lockable'),
(38, 2, 'GENERAL', '15', 'Batteries secured and connections tight'),
(39, 2, 'GENERAL', '16', 'Cable and hoses adequately secured and protected'),
(40, 2, 'GENERAL', '17', 'Cover and guards in good condition and secured'),
(41, 2, 'GENERAL', '18', 'Ladder, stairs, walkways and platforms in good condition'),
(42, 2, 'GENERAL', '19', 'Safety glass and mirror clear and in good condition / no additional accessories'),
(43, 2, 'GENERAL', '20', 'Undercarriage: wheel, rim, axel, spring etc in good condition'),
(44, 2, 'GENERAL', '21', 'Mobile Equipment Identification Number (front, rear, left & right side)'),
(45, 2, 'GENERAL', '22', 'Maintenance records / mechanical inspection reports provided'),
(46, 2, 'GENERAL', '23', 'No oil or fuel leaks'),
(47, 2, 'GENERAL', '24', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(48, 3, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(49, 3, 'CRITICAL', '2', 'Fire Extinguisher min. 6kg and fire suppression system fitted, good and on the right place'),
(50, 3, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(51, 3, 'CRITICAL', '4', 'Reversing alarm operational'),
(52, 3, 'CRITICAL', '5', 'Seatbelt provided and in good condition (all seats)'),
(53, 3, 'CRITICAL', '6', 'Tyres in good condition'),
(54, 3, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(55, 3, 'CRITICAL', '8', 'Park and service brake operational'),
(56, 3, 'GENERAL', '9', 'VHF 2 ways Radio fitted and operational'),
(57, 3, 'GENERAL', '10', 'Horn operational'),
(58, 3, 'GENERAL', '11', 'Emergency Stop / shutdown devices operational'),
(59, 3, 'GENERAL', '12', 'All controls, buttons, levers, etc., clearly labelled'),
(60, 3, 'GENERAL', '13', 'Isolation points lockable'),
(61, 3, 'GENERAL', '14', 'Batteries secured and connections tight'),
(62, 3, 'GENERAL', '15', 'Cable and hoses adequately secured and protected'),
(63, 3, 'GENERAL', '16', 'Cover and guards in good condition and secured'),
(64, 3, 'GENERAL', '17', 'Ladder, stairs, walkways and platforms in good condition'),
(65, 3, 'GENERAL', '18', 'Safety glass and mirror clear and in good condition'),
(66, 3, 'GENERAL', '19', 'Undercarriage: wheel, rim, axel, spring etc in good condition'),
(67, 3, 'GENERAL', '20', 'Mobile Equipment Identification Number (front, rear, left & right side)'),
(68, 3, 'GENERAL', '21', 'Maintenance records / mechanical inspection reports provided'),
(69, 3, 'GENERAL', '22', 'No oil or fuel leaks'),
(70, 3, 'GENERAL', '23', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(71, 4, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(72, 4, 'CRITICAL', '2', 'Fire Extinguisher min. 9kg and fire suppression system fitted, good and on the right place'),
(73, 4, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(74, 4, 'CRITICAL', '4', 'Reversing alarm operational'),
(75, 4, 'CRITICAL', '5', 'Seatbelt provided and in good condition (all passenger seats)'),
(76, 4, 'CRITICAL', '6', 'Tyres in good condition'),
(77, 4, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(78, 4, 'CRITICAL', '8', 'Park and service brake operational'),
(79, 4, 'CRITICAL', '9', 'VHF 2 ways Radio fitted and operational'),
(80, 4, 'CRITICAL', '10', 'Buggy whip & Flag (min. 4.5 meters from the ground)'),
(81, 4, 'GENERAL', '11', 'Horn operational'),
(82, 4, 'GENERAL', '12', 'Emergency Stop / shutdown devices operational'),
(83, 4, 'GENERAL', '13', 'All controls, buttons, levers, etc., clearly labelled'),
(84, 4, 'GENERAL', '14', 'Isolation points lockable'),
(85, 4, 'GENERAL', '15', 'Batteries secured and connections tight'),
(86, 4, 'GENERAL', '16', 'Cable and hoses adequately secured and protected'),
(87, 4, 'GENERAL', '17', 'Cover and guards in good condition and secured'),
(88, 4, 'GENERAL', '18', 'Ladder, stairs, walkways and platforms in good condition'),
(89, 4, 'GENERAL', '19', 'Safety glass and mirror clear and in good condition'),
(90, 4, 'GENERAL', '20', 'Undercarriage: wheel, rim, axel, spring etc in good condition'),
(91, 4, 'GENERAL', '21', 'Mobile Equipment Identification Number (front, rear, left & right side)'),
(92, 4, 'GENERAL', '22', 'Maintenance records / mechanical inspection reports provided'),
(93, 4, 'GENERAL', '23', 'No oil or fuel leaks'),
(94, 4, 'GENERAL', '24', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(95, 5, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (pit access only)'),
(96, 5, 'CRITICAL', '2', 'Fire Extinguisher min. 6kg good and on the right place'),
(97, 5, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(98, 5, 'CRITICAL', '4', 'Reversing alarm operational'),
(99, 5, 'CRITICAL', '5', 'Park and service brake operational'),
(100, 5, 'CRITICAL', '6', 'Seatbelt provided and in good condition'),
(101, 5, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(102, 5, 'CRITICAL', '8', 'Tyres in good condition'),
(103, 5, 'GENERAL', '9', 'VHF 2 ways Radio fitted and operational'),
(104, 5, 'GENERAL', '10', 'Horn operational'),
(105, 5, 'GENERAL', '11', 'Emergency Stop / shutdown devices operational'),
(106, 5, 'GENERAL', '12', 'All controls, buttons, levers, etc., clearly labelled'),
(107, 5, 'GENERAL', '13', 'Isolation points lockable'),
(108, 5, 'GENERAL', '14', 'Batteries secured and connections tight'),
(109, 5, 'GENERAL', '15', 'Electric cable, grounding and hoses adequately secured and protected'),
(110, 5, 'GENERAL', '16', 'Cover and guards in good condition and secured'),
(111, 5, 'GENERAL', '17', 'Ladder, stairs, walkways and platforms in good condition'),
(112, 5, 'GENERAL', '18', 'Safety glass and mirror clear and in good condition'),
(113, 5, 'GENERAL', '19', 'Undercarriage: wheel, rim, axel, spring etc in good condition'),
(114, 5, 'GENERAL', '20', 'Mobile Equipment Identification Number (front, rear, left & right side)'),
(115, 5, 'GENERAL', '21', 'Maintenance records / mechanical inspection reports provided'),
(116, 5, 'GENERAL', '22', 'No oil or fuel leaks'),
(117, 5, 'GENERAL', '23', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(118, 6, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(119, 6, 'CRITICAL', '2', 'Fire Extinguisher min. 6kg good and on the right place'),
(120, 6, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(121, 6, 'CRITICAL', '4', 'Reversing alarm operational'),
(122, 6, 'CRITICAL', '5', 'Park and service brake operational'),
(123, 6, 'CRITICAL', '6', 'Seatbelt provided and in good condition'),
(124, 6, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(125, 6, 'CRITICAL', '8', 'Tyres in good condition'),
(126, 6, 'CRITICAL', '9', '6 or 4 wheel drive (high and low range)'),
(127, 6, 'GENERAL', '10', 'VHF 2 ways Radio fitted and operational'),
(128, 6, 'GENERAL', '11', 'Horn operational'),
(129, 6, 'GENERAL', '12', 'Emergency Stop / shutdown devices operational'),
(130, 6, 'GENERAL', '13', 'All controls, buttons, levers, etc., clearly labelled'),
(131, 6, 'GENERAL', '14', 'Isolation points lockable'),
(132, 6, 'GENERAL', '15', 'Batteries secured and connections tight'),
(133, 6, 'GENERAL', '16', 'Cable and hoses adequately secured and protected'),
(134, 6, 'GENERAL', '17', 'Cover and guards in good condition and secured'),
(135, 6, 'GENERAL', '18', 'Ladder, stairs, walkways and platforms in good condition'),
(136, 6, 'GENERAL', '19', 'Roll over / falling object protection (ROPS/FOBS) fitted and in good condition'),
(137, 6, 'GENERAL', '20', 'Safety glass clear and in good condition'),
(138, 6, 'GENERAL', '21', 'Undercarriage: wheel, rim, axel, spring etc in good condition'),
(139, 6, 'GENERAL', '22', 'Mobile Equipment Identification Number (front, rear, left & right side)'),
(140, 6, 'GENERAL', '23', 'Maintenance records / mechanical inspection reports provided'),
(141, 6, 'GENERAL', '24', 'No oil or fuel leaks'),
(142, 6, 'GENERAL', '25', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(143, 7, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(144, 7, 'CRITICAL', '2', 'Fire Extinguisher min. 6kg good and on the right place'),
(145, 7, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(146, 7, 'CRITICAL', '4', 'Reversing alarm operational'),
(147, 7, 'CRITICAL', '5', 'Park and service brake operational'),
(148, 7, 'CRITICAL', '6', 'Seatbelt provided and in good condition'),
(149, 7, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(150, 7, 'CRITICAL', '8', 'Tyres in good condition'),
(151, 7, 'CRITICAL', '9', '6 or 4 wheel drive (high and low range)'),
(152, 7, 'GENERAL', '10', 'VHF 2 ways radio fitted and operational'),
(153, 7, 'GENERAL', '11', 'Boom extension condition'),
(154, 7, 'GENERAL', '12', 'Horn operational'),
(155, 7, 'GENERAL', '13', 'Condition of wire rope (sling)'),
(156, 7, 'GENERAL', '14', 'Condition of jack (outrigger)'),
(157, 7, 'GENERAL', '15', 'Control lever outrigger, good condition'),
(158, 7, 'GENERAL', '16', 'Hook good condition, with latch'),
(159, 7, 'GENERAL', '17', 'Tuas control hydraulic crane labelled'),
(160, 7, 'GENERAL', '18', 'Emergency Stop / shutdown devices operational'),
(161, 7, 'GENERAL', '19', 'All controls, buttons, levers, etc., clearly labelled'),
(162, 7, 'GENERAL', '20', 'Isolation points lockable'),
(163, 7, 'GENERAL', '21', 'Batteries secured and connections tight'),
(164, 7, 'GENERAL', '22', 'Cable and hoses adequately secured and protected'),
(165, 7, 'GENERAL', '23', 'Cover and guards in good condition and secured'),
(166, 7, 'GENERAL', '24', 'Maintenance records / mechanical inspection reports provided'),
(167, 7, 'GENERAL', '25', 'No oil or fuel leaks'),
(168, 7, 'GENERAL', '26', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(169, 8, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(170, 8, 'CRITICAL', '2', 'Fire Extinguisher min. 6kg and fire suppression system fitted, good and on the right place'),
(171, 8, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(172, 8, 'CRITICAL', '4', 'Reversing alarm operational'),
(173, 8, 'CRITICAL', '5', 'Seatbelt provided and in good condition'),
(174, 8, 'CRITICAL', '6', 'Tyres in good condition'),
(175, 8, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(176, 8, 'CRITICAL', '8', 'Park and service brake operational'),
(177, 8, 'GENERAL', '9', 'UHF 2 ways Radio fitted and operational'),
(178, 8, 'GENERAL', '10', 'Horn operational'),
(179, 8, 'GENERAL', '11', 'Emergency Stop / shutdown devices operational'),
(180, 8, 'GENERAL', '12', 'All controls, buttons, levers, etc., clearly labelled'),
(181, 8, 'GENERAL', '13', 'Isolation points lockable'),
(182, 8, 'GENERAL', '14', 'Batteries secured and connections tight'),
(183, 8, 'GENERAL', '15', 'Cable and hoses adequately secured and protected'),
(184, 8, 'GENERAL', '16', 'Cover and guards in good condition and secured'),
(185, 8, 'GENERAL', '17', 'Ladder, stairs, walkways and platforms in good condition'),
(186, 8, 'GENERAL', '18', 'Roll over / falling object protection (ROPS/FOBS) fitted and in good condition'),
(187, 8, 'GENERAL', '19', 'Safety glass clear and in good condition'),
(188, 8, 'GENERAL', '20', 'Articulation lock provided and operational'),
(189, 8, 'GENERAL', '21', 'Mobile Equipment Identification Number (front, rear, left & right side)'),
(190, 8, 'GENERAL', '22', 'Maintenance records / mechanical inspection reports provided'),
(191, 8, 'GENERAL', '23', 'No oil or fuel leaks'),
(192, 8, 'GENERAL', '24', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(193, 9, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(194, 9, 'CRITICAL', '2', 'Fire Extinguisher min. 9kg and fire suppression system fitted, good and on the right place'),
(195, 9, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(196, 9, 'CRITICAL', '4', 'Reversing alarm operational'),
(197, 9, 'CRITICAL', '5', 'Seatbelt provided and in good condition'),
(198, 9, 'CRITICAL', '6', 'Tyres in good condition'),
(199, 9, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(200, 9, 'CRITICAL', '8', 'Park and service brake operational'),
(201, 9, 'GENERAL', '9', 'VHF 2 ways Radio fitted and operational'),
(202, 9, 'GENERAL', '10', 'Horn operational'),
(203, 9, 'GENERAL', '11', 'Emergency Stop / shutdown devices operational'),
(204, 9, 'GENERAL', '12', 'All controls, buttons, levers, etc., clearly labelled'),
(205, 9, 'GENERAL', '13', 'Isolation points lockable'),
(206, 9, 'GENERAL', '14', 'Batteries secured and connections tight'),
(207, 9, 'GENERAL', '15', 'Cable and hoses adequately secured and protected'),
(208, 9, 'GENERAL', '16', 'Cover and guards in good condition and secured'),
(209, 9, 'GENERAL', '17', 'Ladder, stairs, walkways and platforms in good condition'),
(210, 9, 'GENERAL', '18', 'Roll over / falling object protection (ROPS/FOBS) fitted and in good condition'),
(211, 9, 'GENERAL', '19', 'Safety glass clear and in good condition'),
(212, 9, 'GENERAL', '20', 'Undercarriage: wheel, rim, axel, spring etc in good condition'),
(213, 9, 'GENERAL', '21', 'Mobile Equipment Identification Number (front, rear, left & right side)'),
(214, 9, 'GENERAL', '22', 'Maintenance records / mechanical inspection reports provided'),
(215, 9, 'GENERAL', '23', 'No oil or fuel leaks'),
(216, 9, 'GENERAL', '24', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(217, 10, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(218, 10, 'CRITICAL', '2', 'Fire Extinguisher min. 9kg and fire suppression system fitted, good and on the right place'),
(219, 10, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(220, 10, 'CRITICAL', '4', 'Reversing alarm operational'),
(221, 10, 'CRITICAL', '5', 'Seatbelt provided and in good condition'),
(222, 10, 'CRITICAL', '6', 'Tyres in good condition'),
(223, 10, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(224, 10, 'CRITICAL', '8', 'Park and service brake operational'),
(225, 10, 'CRITICAL', '9', 'VHF 2 ways Radio fitted and operational'),
(226, 10, 'CRITICAL', '10', 'Buggy whip & Flag (min. 4.5 meters from the ground)'),
(227, 10, 'GENERAL', '11', 'Horn operational'),
(228, 10, 'GENERAL', '12', 'Emergency Stop / shutdown devices operational'),
(229, 10, 'GENERAL', '13', 'All controls, buttons, levers, etc., clearly labelled'),
(230, 10, 'GENERAL', '14', 'Isolation points lockable'),
(231, 10, 'GENERAL', '15', 'Batteries secured and connections tight'),
(232, 10, 'GENERAL', '16', 'Cable and hoses adequately secured and protected'),
(233, 10, 'GENERAL', '17', 'Cover and guards in good condition and secured'),
(234, 10, 'GENERAL', '18', 'Ladder, stairs, walkways and platforms in good condition'),
(235, 10, 'GENERAL', '19', 'Fork and mast in good condition and secure'),
(236, 10, 'GENERAL', '20', 'Overhead guard fitted and in good condition'),
(237, 10, 'GENERAL', '21', 'Load backrest extension fitted'),
(238, 10, 'GENERAL', '22', 'Maintenance records / mechanical inspection reports provided'),
(239, 10, 'GENERAL', '23', 'No oil or fuel leaks'),
(240, 10, 'GENERAL', '24', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(241, 11, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(242, 11, 'CRITICAL', '2', 'Fire Extinguisher min. 6kg fitted, good and on the right place'),
(243, 11, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(244, 11, 'CRITICAL', '4', 'Reversing or moving alarm operational'),
(245, 11, 'CRITICAL', '5', 'Park and service brake operational'),
(246, 11, 'CRITICAL', '6', 'Seatbelt provided and in good condition'),
(247, 11, 'CRITICAL', '7', 'All controls, buttons, levers, etc., clearly labelled'),
(248, 11, 'GENERAL', '8', 'VHF 2 ways Radio fitted and operational'),
(249, 11, 'GENERAL', '9', 'Powerline warning poster intact and displayed prominently'),
(250, 11, 'GENERAL', '10', 'Horn operational'),
(251, 11, 'GENERAL', '11', 'Safety lock system operational'),
(252, 11, 'GENERAL', '12', 'Emergency Stop / shutdown devices operational'),
(253, 11, 'GENERAL', '13', 'Isolation points lockable'),
(254, 11, 'GENERAL', '14', 'Batteries secured and connections tight'),
(255, 11, 'GENERAL', '15', 'Cable and hoses adequately secured and protected'),
(256, 11, 'GENERAL', '16', 'Cover and guards in good condition and secured'),
(257, 11, 'GENERAL', '17', 'Ladder, stairs, walkways and platforms in good condition'),
(258, 11, 'GENERAL', '18', 'Roll over / falling object protection (ROPS/FOBS) fitted and in good condition'),
(259, 11, 'GENERAL', '19', 'Undercarriage in good condition (track, sprocket, roller)'),
(260, 11, 'GENERAL', '20', 'Boom, arm and bucket in good condition'),
(261, 11, 'GENERAL', '21', 'Maintenance records / mechanical inspection reports provided'),
(262, 11, 'GENERAL', '22', 'No oil or fuel leaks'),
(263, 11, 'GENERAL', '23', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(264, 12, 'CRITICAL', '1', 'Flashing beacon light fitted and operational'),
(265, 12, 'CRITICAL', '2', 'UHF 2 ways Radio fitted and operational'),
(266, 12, 'CRITICAL', '3', 'Fire Extinguisher fitted, good and on the right place'),
(267, 12, 'CRITICAL', '4', 'Head, tail, brake, indicator and clearance lights operational'),
(268, 12, 'CRITICAL', '5', 'Horn operational'),
(269, 12, 'CRITICAL', '6', 'Reversing alarm operational'),
(270, 12, 'CRITICAL', '7', 'Park and service brake operational'),
(271, 12, 'GENERAL', '8', 'Emergency Stop / shutdown devices operational'),
(272, 12, 'GENERAL', '9', 'All controls, buttons, levers, etc., clearly labelled'),
(273, 12, 'GENERAL', '10', 'Seatbelt provided and in good condition'),
(274, 12, 'GENERAL', '11', 'Isolation points lockable'),
(275, 12, 'GENERAL', '12', 'Batteries secured and connections tight'),
(276, 12, 'GENERAL', '13', 'Cable and hoses adequately secured and protected'),
(277, 12, 'GENERAL', '14', 'Cover and guards in good condition and secured'),
(278, 12, 'GENERAL', '15', 'Ladder, stairs, walkways and platforms in good condition'),
(279, 12, 'GENERAL', '16', 'Roll over / falling object protection (ROPS/FOBS) fitted and in good condition'),
(280, 12, 'GENERAL', '17', 'Safety glass clear and in good condition'),
(281, 12, 'GENERAL', '18', 'Tyres in good condition'),
(282, 12, 'GENERAL', '19', 'Articulation lock provided'),
(283, 12, 'GENERAL', '20', 'Drum in good condition'),
(284, 12, 'GENERAL', '21', 'Maintenance records / mechanical inspection reports provided'),
(285, 12, 'GENERAL', '22', 'No oil or fuel leaks'),
(286, 12, 'GENERAL', '23', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(287, 13, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(288, 13, 'CRITICAL', '2', 'Fire Extinguisher min. 6kg fitted, good and on the right place'),
(289, 13, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(290, 13, 'CRITICAL', '4', 'Reversing or moving alarm operational'),
(291, 13, 'CRITICAL', '5', 'Park and service brake operational'),
(292, 13, 'CRITICAL', '6', 'Seatbelt provided and in good condition'),
(293, 13, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(294, 13, 'CRITICAL', '8', 'Adequate tyre treads'),
(295, 13, 'GENERAL', '9', 'UHF 2 ways Radio fitted and operational'),
(296, 13, 'GENERAL', '10', 'Powerline warning poster intact and displayed prominently'),
(297, 13, 'GENERAL', '11', 'Horn operational'),
(298, 13, 'GENERAL', '12', 'Safety lock system operational'),
(299, 13, 'GENERAL', '13', 'Emergency Stop / shutdown devices operational'),
(300, 13, 'GENERAL', '14', 'All controls, buttons, levers, etc., clearly labelled'),
(301, 13, 'GENERAL', '15', 'Isolation points lockable'),
(302, 13, 'GENERAL', '16', 'Batteries secured and connections tight'),
(303, 13, 'GENERAL', '17', 'Cable and hoses adequately secured and protected'),
(304, 13, 'GENERAL', '18', 'Cover and guards in good condition and secured'),
(305, 13, 'GENERAL', '19', 'Ladder, stairs, walkways and platforms in good condition'),
(306, 13, 'GENERAL', '20', 'Roll over / falling object protection (ROPS/FOBS) fitted and in good condition'),
(307, 13, 'GENERAL', '21', 'Blade and circle drive in good condition'),
(308, 13, 'GENERAL', '22', 'Maintenance records / mechanical inspection reports provided'),
(309, 13, 'GENERAL', '23', 'No oil or fuel leaks'),
(310, 13, 'GENERAL', '24', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(311, 14, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(312, 14, 'CRITICAL', '2', 'Fire Extinguisher fitted, good and on the right place'),
(313, 14, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(314, 14, 'CRITICAL', '4', 'Reversing alarm operational'),
(315, 14, 'CRITICAL', '5', 'Park and service brake operational'),
(316, 14, 'CRITICAL', '6', 'Seat and Seatbelt in good condition'),
(317, 14, 'CRITICAL', '7', 'Standard OEM steering wheel'),
(318, 14, 'CRITICAL', '8', 'Tyres in good condition'),
(319, 14, 'GENERAL', '9', 'UHF 2 ways Radio fitted and operational'),
(320, 14, 'GENERAL', '10', 'Horn operational'),
(321, 14, 'GENERAL', '11', 'Emergency Stop / shutdown devices operational'),
(322, 14, 'GENERAL', '12', 'All controls, buttons, levers, etc., clearly labelled'),
(323, 14, 'GENERAL', '13', 'Isolation points lockable'),
(324, 14, 'GENERAL', '14', 'Batteries secured and connections tight'),
(325, 14, 'GENERAL', '15', 'Cable and hoses adequately secured and protected'),
(326, 14, 'GENERAL', '16', 'Cover and guards in good condition and secured'),
(327, 14, 'GENERAL', '17', 'Ladder, stairs, walkways and platforms in good condition'),
(328, 14, 'GENERAL', '18', 'Roll over / falling object protection (ROPS/FOBS) fitted and in good condition'),
(329, 14, 'GENERAL', '19', 'Bucket and arms in good condition'),
(330, 14, 'GENERAL', '20', 'Articulation lock provided and operational'),
(331, 14, 'GENERAL', '21', 'Maintenance records / mechanical inspection reports provided'),
(332, 14, 'GENERAL', '22', 'No oil or fuel leaks'),
(333, 14, 'GENERAL', '23', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(334, 15, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (access pit only)'),
(335, 15, 'CRITICAL', '2', 'Fire Extinguisher min. 6kg and fire suppression system (OEM) fitted, good and on the right place'),
(336, 15, 'CRITICAL', '3', 'Head, tail, brake, indicator and clearance lights operational'),
(337, 15, 'CRITICAL', '4', 'Reversing or moving alarm operational'),
(338, 15, 'CRITICAL', '5', 'Park and service brake operational'),
(339, 15, 'CRITICAL', '6', 'Seatbelt provided and in good condition'),
(340, 15, 'CRITICAL', '7', 'All controls, buttons, levers, etc., clearly labelled'),
(341, 15, 'GENERAL', '8', 'UHF 2 ways Radio fitted and operational'),
(342, 15, 'GENERAL', '9', 'Horn operational'),
(343, 15, 'GENERAL', '10', 'Emergency Stop / shutdown devices operational'),
(344, 15, 'GENERAL', '11', 'Isolation points lockable'),
(345, 15, 'GENERAL', '12', 'Batteries secured and connections tight'),
(346, 15, 'GENERAL', '13', 'Cable and hoses adequately secured and protected'),
(347, 15, 'GENERAL', '14', 'Cover and guards in good condition and secured'),
(348, 15, 'GENERAL', '15', 'Ladder, stairs, walkways and platforms in good condition'),
(349, 15, 'GENERAL', '16', 'Roll over / falling object protection (ROPS/FOBS) fitted and in good condition'),
(350, 15, 'GENERAL', '17', 'Cabin, Door, Window, Seat, AC (air ventilation system) in good condition'),
(351, 15, 'GENERAL', '18', 'Blade and ripper in good condition'),
(352, 15, 'GENERAL', '19', 'Undercarriage in good condition (track, sprocket, roller)'),
(353, 15, 'GENERAL', '20', 'Maintenance records / mechanical inspection reports provided'),
(354, 15, 'GENERAL', '21', 'No oil or fuel leaks'),
(355, 15, 'GENERAL', '22', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(356, 16, 'CRITICAL', '1', 'Flashing beacon light fitted and operational'),
(357, 16, 'CRITICAL', '2', 'Fire Extinguisher fitted, good and on the right place'),
(358, 16, 'CRITICAL', '3', 'Horn operational'),
(359, 16, 'CRITICAL', '4', 'Emergency Stop / shutdown devices operational'),
(360, 16, 'GENERAL', '5', 'All controls, buttons, levers, etc., clearly labelled'),
(361, 16, 'GENERAL', '6', 'Seatbelt provided and in good condition'),
(362, 16, 'GENERAL', '7', 'Isolation points lockable'),
(363, 16, 'GENERAL', '8', 'Batteries secured and connections tight'),
(364, 16, 'GENERAL', '9', 'Cable and hoses adequately secured and protected'),
(365, 16, 'GENERAL', '10', 'Cover and guards in good condition and secured'),
(366, 16, 'GENERAL', '11', 'Ladder, stairs, walkways and platforms in good condition'),
(367, 16, 'GENERAL', '12', 'Undercarriage in good condition (track, sprocket, roller)'),
(368, 16, 'GENERAL', '13', 'Maintenance records / mechanical inspection reports provided'),
(369, 16, 'GENERAL', '14', 'No oil or fuel leaks'),
(370, 16, 'GENERAL', '15', 'Machine in good condition'),
(371, 17, 'GENERAL', '1', 'Semua lampu dalam keadaan baik'),
(372, 17, 'GENERAL', '2', 'Lampu rotary (Amber color flashing light)'),
(373, 17, 'GENERAL', '3', 'Nomor identitas unit 3 Sides'),
(374, 17, 'GENERAL', '4', 'Klakson berfungsi dengan baik'),
(375, 17, 'GENERAL', '5', 'Alarm mundur berfungsi'),
(376, 17, 'GENERAL', '6', 'Semua meteran/pengukur dan tombol/tuas lengkap dengan label'),
(377, 17, 'GENERAL', '7', 'Emergency stop'),
(378, 17, 'GENERAL', '8', 'Safety release katup udara pada tangki'),
(379, 17, 'GENERAL', '9', 'Ball valve saluran udara bertekanan'),
(380, 17, 'GENERAL', '10', 'Sistem pengereman'),
(381, 17, 'GENERAL', '11', 'Wire mesh pelindung mesin yang berputar'),
(382, 17, 'GENERAL', '12', 'Kondisi tali kawat (Wire rope)'),
(383, 17, 'GENERAL', '13', 'Semua alat ukur listrik berfungsi'),
(384, 17, 'GENERAL', '14', 'Semua kabel listrik terlindung'),
(385, 17, 'GENERAL', '15', 'Catatan perawatan / laporan inspeksi mekanik tersedia'),
(386, 17, 'GENERAL', '16', 'Tidak ada kebocoran oli atau bahan bakar'),
(387, 17, 'GENERAL', '17', 'Mesin dalam kondisi baik'),
(388, 18, 'CRITICAL', '1', 'Flashing beacon light fitted and operational'),
(389, 18, 'CRITICAL', '2', 'VHF 2 ways Radio fitted and operational'),
(390, 18, 'CRITICAL', '3', 'Powerline warning poster intact and displayed prominently'),
(391, 18, 'CRITICAL', '4', 'Pilot on jumbo power cable in good condition'),
(392, 18, 'CRITICAL', '5', 'Fire Extinguisher fitted, good and on the right place'),
(393, 18, 'CRITICAL', '6', 'Fire Suppression System fitted, good, proper pressure, module in good function'),
(394, 18, 'CRITICAL', '7', 'Head, tail, brake, indicator and clearance lights operational'),
(395, 18, 'CRITICAL', '8', 'Horn operational'),
(396, 18, 'CRITICAL', '9', 'Reversing/operating alarm operational'),
(397, 18, 'CRITICAL', '10', 'Park and service brake operational'),
(398, 18, 'GENERAL', '11', 'Engine Emergency Stop / shutdown devices operational'),
(399, 18, 'GENERAL', '12', 'Boom Emergency Stop / shutdown device operational'),
(400, 18, 'GENERAL', '13', 'All controls, buttons, levers, etc., clearly labelled'),
(401, 18, 'GENERAL', '14', 'Operator seat, seatbelt provided and in good condition'),
(402, 18, 'GENERAL', '15', 'Isolation points lockable'),
(403, 18, 'GENERAL', '16', 'Batteries secured and connections tight'),
(404, 18, 'GENERAL', '17', 'Cable and hoses adequately secured and protected'),
(405, 18, 'GENERAL', '18', 'Cover and guards in good condition and secured'),
(406, 18, 'GENERAL', '19', 'Ladder, stairs, walkways and platforms in good condition'),
(407, 18, 'GENERAL', '20', 'Boom and drill steel in good condition'),
(408, 18, 'GENERAL', '21', 'Water and flushing system operational'),
(409, 18, 'GENERAL', '22', 'Maintenance records / mechanical inspection reports provided'),
(410, 18, 'GENERAL', '23', 'No oil or fuel leaks'),
(411, 18, 'GENERAL', '24', 'Machine/Engine in good condition (Operational testing/Running engine)'),
(412, 19, 'CRITICAL', '1', 'Flashing beacon light fitted and operational (if mobile)'),
(413, 19, 'CRITICAL', '2', 'Fire Extinguisher fitted, good and on the right place'),
(414, 19, 'CRITICAL', '3', 'Emergency Stop / shutdown devices operational'),
(415, 19, 'GENERAL', '4', 'All controls, buttons, gauges, levers, etc., clearly labelled'),
(416, 19, 'GENERAL', '5', 'Isolation points lockable'),
(417, 19, 'GENERAL', '6', 'Batteries secured and connections tight'),
(418, 19, 'GENERAL', '7', 'Cable and hoses adequately secured and protected'),
(419, 19, 'GENERAL', '8', 'Cover and guards in good condition and secured'),
(420, 19, 'GENERAL', '9', 'Earthing/grounding in good condition'),
(421, 19, 'GENERAL', '10', 'Exhaust properly directed / muffler in good condition'),
(422, 19, 'GENERAL', '11', 'Fuel tank in good condition, no leaks'),
(423, 19, 'GENERAL', '12', 'Oil level adequate, no leaks'),
(424, 19, 'GENERAL', '13', 'Cooling system in good condition'),
(425, 19, 'GENERAL', '14', 'Electrical connections tight and insulated'),
(426, 19, 'GENERAL', '15', 'Output voltage/pressure within specification'),
(427, 19, 'GENERAL', '16', 'Safety relief valve fitted and operational (Compressor/Pump)'),
(428, 19, 'GENERAL', '17', 'Maintenance records / mechanical inspection reports provided'),
(429, 19, 'GENERAL', '18', 'Machine/Engine in good condition (Operational testing/Running engine)');

-- --------------------------------------------------------

--
-- Table structure for table `checklist_template`
--

CREATE TABLE `checklist_template` (
  `id_template` int(10) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `jenis_unit` varchar(100) NOT NULL,
  `nama_template` varchar(200) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checklist_template`
--

INSERT INTO `checklist_template` (`id_template`, `kode`, `jenis_unit`, `nama_template`, `is_active`, `created_at`) VALUES
(1, '002C', 'Light Vehicle', 'Light Vehicle Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(2, '002D', 'Light Truck', 'Light Truck Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(3, '002E', 'Bus', 'Bus Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(4, '002F', 'Bus Manhaul', 'Bus Manhaul Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(5, '002G', 'Fuel Truck', 'Fuel Truck Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(6, '002H', 'Dump Truck', 'Dump Truck Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(7, '002I', 'Crane Truck', 'Crane Truck Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(8, '002J', 'ADT', 'Articulated Dump Truck (ADT) Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(9, '002K', 'Haul Truck', 'Haul Truck / Heavy Duty Dump Truck Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(10, '002L', 'Forklift', 'Forklift Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(11, '002M', 'Excavator', 'Excavator Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(12, '002N', 'Compactor', 'Compactor Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(13, '002O', 'Motor Grader', 'Grader Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(14, '002P', 'Wheel Loader', 'Wheel Loader Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(15, '002Q', 'Bulldozer', 'Dozer Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(16, '002R', 'Crawler', 'Crawler Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(17, '002S', 'Drill Rig', 'Drill Rig Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(18, '002T', 'Jumbo', 'Jumbo Commissioning Checklist', 1, '2026-02-24 01:19:10'),
(19, '002U', 'Equipment Support', 'Equipment Support (Genset/Compressor/Lighting/Pump) Commissioning Checklist', 1, '2026-02-24 01:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('1ankt28lbguka3n6v8ephv3h4764lmbf', '::1', 1772110139, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131303133393b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('1ba05kk4mb9cqvbi80uomr98ujmjc4a9', '::1', 1772174484, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323137343438343b636170746368615f636f64657c693a31323b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('1o6u1an510oosbubke9dgc5s1jq8fdcp', '::1', 1772109777, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323130393737373b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('3vfeiqp5too7ud1b963viviu982rk075', '::1', 1772108624, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323130383632343b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('6p5l9nth1cks1qujbalrk4nt472eq3jf', '::1', 1772113105, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131333130353b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('8sgcocscal661gt9o4qnj3mhak8v5v16', '::1', 1772116273, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131363237333b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('9snqbgkspgn8c8f5fuk770541kv3tado', '::1', 1772174835, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323137343833353b636170746368615f636f64657c693a31323b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('akovmuqii5uf0236gt2ut2sfcf3lav3b', '::1', 1772173366, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323137333336363b636170746368615f636f64657c693a31323b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('apg5mlck6qscqn1vb8o2qv73v70np5iq', '::1', 1772114262, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131343236323b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('cpt3cprlf3k7kvua6iog2c8fbh83iodf', '::1', 1772114625, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131343632353b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('galihlm90im9f9sg54qrn017k466eiff', '::1', 1772175318, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323137353231353b636170746368615f636f64657c693a31323b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('gdhcmb51377oicp7jle4ma0ald6b8e3v', '::1', 1772172406, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323137323430363b636170746368615f636f64657c693a31323b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('hh2tou6rk1rr5infth4qi7m07cgj28f8', '::1', 1772119202, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131383939303b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('isb5rr5qsets6ke0lv30c81ggd8eeaqd', '::1', 1772175215, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323137353231353b636170746368615f636f64657c693a31323b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('kv02taph251j4l1gvpq1f1d5of099l16', '::1', 1772111046, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131313034363b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('lkdqioht2t9lp6t3p5p9tk3q9j78ubin', '::1', 1772118680, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131383638303b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('m6eb356ojsh2tac4so8kl1i83pjij0b6', '::1', 1772118367, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131383336373b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('n27d225rkgdko39g6j3ph7hh0863ov97', '::1', 1772111834, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131313833343b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('nksqdd4j1b3gqcpnlgc8urg0hmmufo45', '::1', 1772118990, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131383939303b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('nu4c4dobv2363visobjj2aprqnlf68t2', '::1', 1772113549, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131333534393b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('paj7ltl1nr2cq58hvpnnl0is47f6ij7p', '::1', 1772117125, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131373132353b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('prg0eibrll57pq6fv8nr7dvcgihuek6s', '::1', 1772111495, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131313439353b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('r551v3sce7ebgca6jpc6rqubvcrvffd0', '::1', 1772118021, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131383032313b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('s0q964npn2ssfo47ltv6df3mjrfmhdml', '::1', 1772174081, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323137343038313b636170746368615f636f64657c693a31323b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('sl6u8g5smoe82hjde1ahhp9rvh3907ik', '::1', 1772117448, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323131373434383b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('ugk9kjfpeeji72aahne0bhlvnund2186', '::1', 1772108929, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323130383932393b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('upbkcnvi636n1pur1u01duj094eo1oo1', '::1', 1772109474, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737323130393437343b636170746368615f636f64657c693a31333b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_uji`
--

CREATE TABLE `jadwal_uji` (
  `id_jadwal` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `id_mekanik` int(11) NOT NULL,
  `tanggal_uji` datetime NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('scheduled','done','cancelled') NOT NULL DEFAULT 'scheduled',
  `created_at` datetime DEFAULT current_timestamp(),
  `dibuat_oleh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `no_polisi` varchar(20) NOT NULL,
  `nomor_unit` varchar(50) DEFAULT NULL,
  `jenis_kendaraan` varchar(50) DEFAULT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `model_unit` varchar(50) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `perusahaan` varchar(100) DEFAULT NULL,
  `is_unit_baru` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id_kendaraan`, `no_polisi`, `nomor_unit`, `jenis_kendaraan`, `merk`, `tipe`, `model_unit`, `tahun`, `perusahaan`, `is_unit_baru`, `created_at`) VALUES
(1, 'DB 1234 GT', NULL, 'Dump Truck', 'Volvo', 'D6T', NULL, 2020, NULL, 1, '2026-02-23 04:59:52'),
(2, 'DB 1234 GG', NULL, 'Dump Truck', 'Volvo', 'D6T', NULL, 2021, NULL, 0, '2026-02-23 17:39:49'),
(3, 'DB 12222 GG', 'BD-001', 'Bulldozer', 'Volvo', 'BDD-22DDA', 'BDD-22DDA', 2023, 'PT. Energy Logistics', 1, '2026-02-27 14:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_approval`
--

CREATE TABLE `pengajuan_approval` (
  `id_approval` int(11) NOT NULL,
  `id_approver` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `level_approval` varchar(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengajuan_approval`
--

INSERT INTO `pengajuan_approval` (`id_approval`, `id_approver`, `id_pengajuan`, `level_approval`, `status`, `catatan`, `created_at`) VALUES
(2, 1, 3, 'manager', 'approved', '', '2026-02-26 22:49:27'),
(3, 1, 5, 'manager', 'approved', '', '2026-02-26 22:04:06'),
(4, 1, 5, 'admin', 'approved', '', '2026-02-27 14:23:46'),
(5, 1, 3, 'admin_ohs', 'approved', '', '2026-02-26 22:53:05'),
(6, 1, 3, 'admin_ohs', 'approved', '', '2026-02-26 22:51:22'),
(7, 1, 3, 'admin_ohs', 'approved', '', '2026-02-26 23:01:42'),
(8, 1, 3, 'admin_ohs', 'approved', '', '2026-02-26 22:53:11'),
(9, 1, 3, 'admin_ohs', 'approved', '', '2026-02-27 14:22:52'),
(10, 1, 3, 'admin_ohs', 'approved', '', '2026-02-26 23:01:48'),
(11, 1, 5, 'admin_ohs', 'approved', '', '2026-02-27 14:09:01'),
(12, 1, 3, 'admin_ohs', 'approved', '', '2026-02-27 14:47:19'),
(13, 1, 3, 'admin_ohs', 'approved', '', '2026-02-27 14:22:59'),
(14, 0, 5, 'admin_ohs', 'pending', NULL, '2026-02-27 14:23:46'),
(15, 1, 5, 'admin_ohs', 'approved', '', '2026-02-27 14:23:52'),
(16, 1, 6, 'manager', 'approved', '', '2026-02-27 14:44:14'),
(17, 1, 6, 'admin_ohs', 'approved', '', '2026-02-27 14:49:47'),
(18, 0, 3, 'admin_ohs', 'pending', NULL, '2026-02-27 14:47:19'),
(19, 1, 6, 'admin_ohs', 'approved', '', '2026-02-27 14:47:30'),
(20, 0, 6, 'admin_ohs', 'pending', NULL, '2026-02-27 14:49:47'),
(21, 1, 6, 'admin_ohs', 'approved', '', '2026-02-27 14:49:52');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_lampiran`
--

CREATE TABLE `pengajuan_lampiran` (
  `id_lampiran` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `jenis_lampiran` enum('stnk','unit_depan','unit_belakang','unit_kiri','unit_kanan') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengajuan_lampiran`
--

INSERT INTO `pengajuan_lampiran` (`id_lampiran`, `id_pengajuan`, `jenis_lampiran`, `file_path`, `uploaded_at`) VALUES
(5, 5, 'stnk', 'uploads/lampiran/5/stnk_1771970061.jpg', '2026-02-25 05:54:21'),
(6, 5, 'unit_depan', 'uploads/lampiran/5/unit_depan_1771970061.png', '2026-02-25 05:54:21'),
(7, 5, 'unit_belakang', 'uploads/lampiran/5/unit_belakang_1771970061.jpeg', '2026-02-25 05:54:21'),
(8, 5, 'unit_kiri', 'uploads/lampiran/5/unit_kiri_1771970061.jpeg', '2026-02-25 05:54:21'),
(9, 5, 'unit_kanan', 'uploads/lampiran/5/unit_kanan_1771970061.png', '2026-02-25 05:54:21'),
(10, 6, 'stnk', 'uploads/lampiran/6/stnk_1772174570.jpg', '2026-02-27 14:42:50'),
(11, 6, 'unit_depan', 'uploads/lampiran/6/unit_depan_1772174570.png', '2026-02-27 14:42:50'),
(12, 6, 'unit_belakang', 'uploads/lampiran/6/unit_belakang_1772174570.png', '2026-02-27 14:42:50'),
(13, 6, 'unit_kiri', 'uploads/lampiran/6/unit_kiri_1772174570.png', '2026-02-27 14:42:50'),
(14, 6, 'unit_kanan', 'uploads/lampiran/6/unit_kanan_1772174570.png', '2026-02-27 14:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_uji`
--

CREATE TABLE `pengajuan_uji` (
  `id_pengajuan` int(11) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `id_pemohon` int(11) NOT NULL,
  `email_pemohon` varchar(100) DEFAULT NULL,
  `tipe_pengajuan` varchar(100) NOT NULL,
  `tipe_akses` varchar(100) NOT NULL,
  `tujuan` varchar(200) NOT NULL,
  `nomor_mesin` varchar(100) NOT NULL,
  `nomor_rangka` varchar(100) NOT NULL,
  `status` enum('draft','submitted','approved_manager','approved_admin','scheduled','inspected','review_ohs','approved_ohs','approved_ktt','sticker_released','rejected') NOT NULL DEFAULT 'draft',
  `tanggal_pengajuan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengajuan_uji`
--

INSERT INTO `pengajuan_uji` (`id_pengajuan`, `id_kendaraan`, `id_pemohon`, `email_pemohon`, `tipe_pengajuan`, `tipe_akses`, `tujuan`, `nomor_mesin`, `nomor_rangka`, `status`, `tanggal_pengajuan`) VALUES
(3, 2, 1, 'jack@gmail.com', 'new_commissioning', 'mining', 'Ayyyyy', '232323', '232323', 'submitted', '2026-02-24 01:40:36'),
(5, 1, 1, 'jack@gmail.com', 'new_commissioning', 'mining', 'tesss', '222222', '222222', 'submitted', '2026-02-25 05:54:21'),
(6, 3, 1, 'jack@gmail.com', 'new_commissioning', 'mining', 'test tett e ekkaekaea', '313123123123', '2323231', 'approved_admin', '2026-02-27 14:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_perusahaan` int(11) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `singkatan` varchar(30) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `nama_perusahaan`, `singkatan`, `is_active`) VALUES
(1, 'CV. Cahaya Dwi Perkasa', 'CDP', 1),
(2, 'CV. Charisma', 'CHR', 1),
(3, 'CV. Daya Kreasitama', 'CDK', 1),
(4, 'CV. Puncak Kencana', 'CPK', 1),
(5, 'On the Job Training', 'OJT', 1),
(6, 'Police', 'POL', 1),
(7, 'PT Batu Biru Nusantara', 'BBN', 1),
(8, 'PT. AKR', 'AKR', 1),
(9, 'PT. Anggun Permai Tekindo', 'APT', 1),
(10, 'PT. Arlie Labora Utama', 'ALU', 1),
(11, 'PT. Bromindo Mekar Mitra', 'BMM', 1),
(12, 'PT. DNX Indonesia', 'DNX', 1),
(13, 'PT. Eka Dharma Jaya Sakti', 'EDJS', 1),
(14, 'PT. Energy Logistics', 'ELG', 1),
(15, 'PT. G4S', 'G4S', 1),
(16, 'PT. Geopersada Mulia Abadi (GMA)', 'GMA', 1),
(17, 'PT. Hanwha Mining Services Indonesia', 'HMSI', 1),
(18, 'PT. Hexindo', 'HXD', 1),
(19, 'PT. Indos Cakra Mandiri', 'ICM', 1),
(20, 'PT. Intertek', 'ITK', 1),
(21, 'PT. Kilat Jaya', 'KLJ', 1),
(22, 'PT. Liotec Mitra Utama', 'LMU', 1),
(23, 'PT. Macmahon Indonesia', 'MMI', 1),
(24, 'PT. Manado Karya Anugerah', 'MKA', 1),
(25, 'PT. Mandara Fasilitas Indonesia', 'MFI', 1),
(26, 'PT. Maxidrill', NULL, 1),
(27, 'PT. Metso Outotec', NULL, 1),
(28, 'PT. Panca', NULL, 1),
(29, 'PT. Pilar Muda Indotama', NULL, 1),
(30, 'PT. PSI Drilling Service', NULL, 1),
(31, 'PT. Samudera Mulia Abadi (SMA)', NULL, 1),
(32, 'PT. Saribuana Manado', NULL, 1),
(33, 'PT. Tata Wisata', NULL, 1),
(34, 'PT. Tombers Karya Bersama', NULL, 1),
(35, 'PT. Tou Maesa Sejahtera (TMS)', NULL, 1),
(36, 'PT. Trakindo', NULL, 1),
(37, 'PT. Tumou Tou Manado', NULL, 1),
(38, 'PT. United Tractor', NULL, 1),
(39, 'Siloam Hospital', NULL, 1),
(40, 'Visitor', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nama_role`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Mekanik'),
(4, 'OHS'),
(5, 'KTT');

-- --------------------------------------------------------

--
-- Table structure for table `sticker_release`
--

CREATE TABLE `sticker_release` (
  `id_sticker` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `nomor_sticker` varchar(50) DEFAULT NULL,
  `tanggal_release` datetime DEFAULT NULL,
  `released_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tipe_kendaraan`
--

CREATE TABLE `tipe_kendaraan` (
  `id_tipe_kendaraan` int(11) NOT NULL,
  `nama_tipe` varchar(100) NOT NULL,
  `kode_tipe` varchar(30) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipe_kendaraan`
--

INSERT INTO `tipe_kendaraan` (`id_tipe_kendaraan`, `nama_tipe`, `kode_tipe`, `is_active`) VALUES
(1, 'Light Vehicle', 'LV', 1),
(2, 'Light Truck', 'LT', 1),
(3, 'Bus', 'BUS', 1),
(4, 'Bus Manhaul', 'BUS_MH', 1),
(5, 'Fuel Truck', 'FT', 1),
(6, 'Dump Truck', 'DT', 1),
(7, 'Crane Truck', 'CT', 1),
(8, 'Articulated Dump Truck (ADT)', 'ADT', 1),
(9, 'Haul Truck', 'HT', 1),
(10, 'Forklift', 'FL', 1),
(11, 'Excavator', 'EX', 1),
(12, 'Compactor', 'CP', 1),
(13, 'Motor Grader', 'MG', 1),
(14, 'Wheel Loader', 'WL', 1),
(15, 'Bulldozer', 'BD', 1),
(16, 'Crawler', 'CW', 1),
(17, 'Drill Rig', 'DR', 1),
(18, 'Jumbo', 'JB', 1),
(19, 'Equipment Support (Genset/Compressor/Lighting/Pump)', 'ES', 1);

-- --------------------------------------------------------

--
-- Table structure for table `uji_checklist`
--

CREATE TABLE `uji_checklist` (
  `id_checklist` int(11) NOT NULL,
  `id_uji` int(11) NOT NULL,
  `id_item` int(10) UNSIGNED NOT NULL,
  `hasil` enum('yes','no','na') NOT NULL DEFAULT 'na',
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uji_kelayakan`
--

CREATE TABLE `uji_kelayakan` (
  `id_uji` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `id_mekanik` int(11) DEFAULT NULL,
  `id_template` int(10) UNSIGNED DEFAULT NULL,
  `tanggal_uji` datetime DEFAULT NULL,
  `hasil` enum('lulus','tidak_lulus') DEFAULT NULL,
  `catatan_umum` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `id_role`, `nama`, `username`, `email`, `password`, `is_active`, `created_at`) VALUES
(1, 1, 'Administrator', 'admin', 'admin@gmail.com', '$2y$10$9JmqLtLuImhzuXlJTxvKqeL1VgCZ/WOcGlDRClBv2XJ/8ZsGW9JnO', 1, '2026-02-23 02:46:54'),
(2, 2, 'User Test', 'user', 'user@gmail.com', '$2y$10$9JmqLtLuImhzuXlJTxvKqeL1VgCZ/WOcGlDRClBv2XJ/8ZsGW9JnO', 1, '2026-02-25 05:25:34'),
(3, 3, 'Mekanik Test', 'mekanik', 'mekanik@gmail.com', '$2y$10$9JmqLtLuImhzuXlJTxvKqeL1VgCZ/WOcGlDRClBv2XJ/8ZsGW9JnO', 1, '2026-02-25 05:25:34'),
(4, 4, 'OHS Test', 'ohs', 'ohs@gmail.com', '$2y$10$9JmqLtLuImhzuXlJTxvKqeL1VgCZ/WOcGlDRClBv2XJ/8ZsGW9JnO', 1, '2026-02-25 05:25:34'),
(5, 5, 'KTT Test', 'ktt', 'ktt@gmail.com', '$2y$10$9JmqLtLuImhzuXlJTxvKqeL1VgCZ/WOcGlDRClBv2XJ/8ZsGW9JnO', 1, '2026-02-25 05:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id_user_role` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id_user_role`, `id_user`, `id_role`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `tabel` (`tabel`),
  ADD KEY `id_ref` (`id_ref`);

--
-- Indexes for table `checklist_item`
--
ALTER TABLE `checklist_item`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `fk_item_template` (`id_template`);

--
-- Indexes for table `checklist_template`
--
ALTER TABLE `checklist_template`
  ADD PRIMARY KEY (`id_template`),
  ADD UNIQUE KEY `uk_kode` (`kode`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `jadwal_uji`
--
ALTER TABLE `jadwal_uji`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`),
  ADD KEY `id_pengajuan` (`id_pengajuan`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`);

--
-- Indexes for table `pengajuan_approval`
--
ALTER TABLE `pengajuan_approval`
  ADD PRIMARY KEY (`id_approval`);

--
-- Indexes for table `pengajuan_lampiran`
--
ALTER TABLE `pengajuan_lampiran`
  ADD PRIMARY KEY (`id_lampiran`),
  ADD KEY `id_pengajuan` (`id_pengajuan`);

--
-- Indexes for table `pengajuan_uji`
--
ALTER TABLE `pengajuan_uji`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `id_kendaraan` (`id_kendaraan`),
  ADD KEY `id_pemohon` (`id_pemohon`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `sticker_release`
--
ALTER TABLE `sticker_release`
  ADD PRIMARY KEY (`id_sticker`),
  ADD KEY `released_by` (`released_by`),
  ADD KEY `id_pengajuan` (`id_pengajuan`);

--
-- Indexes for table `tipe_kendaraan`
--
ALTER TABLE `tipe_kendaraan`
  ADD PRIMARY KEY (`id_tipe_kendaraan`);

--
-- Indexes for table `uji_checklist`
--
ALTER TABLE `uji_checklist`
  ADD PRIMARY KEY (`id_checklist`),
  ADD UNIQUE KEY `uk_uji_item` (`id_uji`,`id_item`),
  ADD KEY `id_uji` (`id_uji`),
  ADD KEY `id_item` (`id_item`);

--
-- Indexes for table `uji_kelayakan`
--
ALTER TABLE `uji_kelayakan`
  ADD PRIMARY KEY (`id_uji`),
  ADD KEY `id_mekanik` (`id_mekanik`),
  ADD KEY `id_pengajuan` (`id_pengajuan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id_user_role`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `checklist_item`
--
ALTER TABLE `checklist_item`
  MODIFY `id_item` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=430;

--
-- AUTO_INCREMENT for table `checklist_template`
--
ALTER TABLE `checklist_template`
  MODIFY `id_template` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `jadwal_uji`
--
ALTER TABLE `jadwal_uji`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengajuan_approval`
--
ALTER TABLE `pengajuan_approval`
  MODIFY `id_approval` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pengajuan_lampiran`
--
ALTER TABLE `pengajuan_lampiran`
  MODIFY `id_lampiran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pengajuan_uji`
--
ALTER TABLE `pengajuan_uji`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sticker_release`
--
ALTER TABLE `sticker_release`
  MODIFY `id_sticker` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipe_kendaraan`
--
ALTER TABLE `tipe_kendaraan`
  MODIFY `id_tipe_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `uji_checklist`
--
ALTER TABLE `uji_checklist`
  MODIFY `id_checklist` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uji_kelayakan`
--
ALTER TABLE `uji_kelayakan`
  MODIFY `id_uji` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id_user_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checklist_item`
--
ALTER TABLE `checklist_item`
  ADD CONSTRAINT `fk_item_template` FOREIGN KEY (`id_template`) REFERENCES `checklist_template` (`id_template`);

--
-- Constraints for table `jadwal_uji`
--
ALTER TABLE `jadwal_uji`
  ADD CONSTRAINT `jadwal_uji_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_uji` (`id_pengajuan`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_uji_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `pengajuan_lampiran`
--
ALTER TABLE `pengajuan_lampiran`
  ADD CONSTRAINT `pengajuan_lampiran_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_uji` (`id_pengajuan`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_uji`
--
ALTER TABLE `pengajuan_uji`
  ADD CONSTRAINT `pengajuan_uji_ibfk_1` FOREIGN KEY (`id_kendaraan`) REFERENCES `kendaraan` (`id_kendaraan`),
  ADD CONSTRAINT `pengajuan_uji_ibfk_2` FOREIGN KEY (`id_pemohon`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `sticker_release`
--
ALTER TABLE `sticker_release`
  ADD CONSTRAINT `sticker_release_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_uji` (`id_pengajuan`) ON DELETE CASCADE,
  ADD CONSTRAINT `sticker_release_ibfk_2` FOREIGN KEY (`released_by`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `uji_kelayakan`
--
ALTER TABLE `uji_kelayakan`
  ADD CONSTRAINT `uji_kelayakan_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_uji` (`id_pengajuan`) ON DELETE CASCADE,
  ADD CONSTRAINT `uji_kelayakan_ibfk_2` FOREIGN KEY (`id_mekanik`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
