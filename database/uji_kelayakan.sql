-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2026 at 10:02 PM
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
(1, 1, 'tambah_kendaraan', 'kendaraan', 1, '2026-02-23 04:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `checklist_item`
--

CREATE TABLE `checklist_item` (
  `id_item` int(11) NOT NULL,
  `id_template` int(11) NOT NULL,
  `nama_item` varchar(100) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `checklist_template`
--

CREATE TABLE `checklist_template` (
  `id_template` int(11) NOT NULL,
  `jenis_kendaraan` varchar(50) DEFAULT NULL,
  `nama_template` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
('0gsdrtsp6bvj98f6vej0mh1b2h2oh55l', '::1', 1771792977, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313739323937373b636170746368615f636f64657c693a343b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('1evsvrt235v1m92ha2kdu9kfb1r8b1nv', '::1', 1771791681, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313739313638313b636170746368615f636f64657c693a343b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('36df9bqrs27mcsdprp8mp9rhoathkkvn', '::1', 1771792626, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313739323632363b636170746368615f636f64657c693a343b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('3lnd9t1dlsnttafcs746nfmkgo737ld9', '::1', 1771785164, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313738353136343b636170746368615f636f64657c693a31333b),
('3t137fhdjipocgu76jsqbjo4su3lshn3', '::1', 1771786803, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313738363830333b636170746368615f636f64657c693a31333b6c6f67696e5f617474656d70747c693a353b),
('45rrnoig5ljvhapl28ve4118cd0bnkem', '::1', 1771791024, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313739313032343b636170746368615f636f64657c693a343b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('525bbp7so0djk2ri5j30o01fj39dvro1', '::1', 1771790299, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313739303239393b636170746368615f636f64657c693a363b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('5v6qjfpu1rgc97mvmolmsepp0mf7o338', '::1', 1771793960, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313739333936303b636170746368615f636f64657c693a343b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('9oici336p0627hu76cfa4u2adjjd8aoi', '::1', 1771792220, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313739323232303b636170746368615f636f64657c693a343b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('bjgp9rjga6iug6rbe4mfokrteir6idvv', '::1', 1771788758, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313738383735383b636170746368615f636f64657c693a363b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('dgahjrounll8ep03tlkj6g06o7qub09k', '::1', 1771787767, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313738373736373b636170746368615f636f64657c693a31303b),
('e8etp4icl9g1rruqpg2g9pi1nji0q149', '::1', 1771786034, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313738363033343b636170746368615f636f64657c693a31333b),
('hrrhu55sn3e18qd7sheqlftmvdvmotlf', '::1', 1771784834, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313738343833343b636170746368615f636f64657c693a31353b),
('hss6et4rmqibf4kg3f20e7pi1a3g2j0k', '::1', 1771784519, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313738343531393b636170746368615f636f64657c693a383b),
('i2kvk7u8ttaki61vu7i973q0fetqv66e', '::1', 1771788129, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313738383132393b636170746368615f636f64657c693a353b),
('jpt37vt1jom01na2mh8p7rtgusgs76ne', '::1', 1771790695, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313739303639353b636170746368615f636f64657c693a363b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('n2fah9cth8hn9mu0hs52veumhkftlsek', '::1', 1771785558, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313738353535383b636170746368615f636f64657c693a31333b),
('ne9j3qhvbea18ldndbndlikniol7olt9', '::1', 1771786496, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313738363439363b636170746368615f636f64657c693a31333b),
('oc8u71ihvb8qdl5hvuo4als7j5l90a8k', '::1', 1771793281, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313739333238313b636170746368615f636f64657c693a343b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('ok9pe7h14t5akos6n7dqd3cp5se4arqo', '::1', 1771793648, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313739333634383b636170746368615f636f64657c693a343b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b),
('s0lfisj2pr816cqsbldqnsj4ij8eukrt', '::1', 1771794106, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313739343130363b636170746368615f636f64657c693a31313b),
('uqms4kbcba81mct015rushboelqcgrs5', '::1', 1771789790, 0x5f5f63695f6c6173745f726567656e65726174657c693a313737313738393739303b636170746368615f636f64657c693a363b69645f757365727c733a313a2231223b6e616d617c733a31333a2241646d696e6973747261746f72223b726f6c657c733a313a2231223b6c6f676765645f696e7c623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_uji`
--

CREATE TABLE `jadwal_uji` (
  `id_jadwal` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `tanggal_uji` datetime NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `no_polisi` varchar(20) NOT NULL,
  `jenis_kendaraan` varchar(50) DEFAULT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `is_unit_baru` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id_kendaraan`, `no_polisi`, `jenis_kendaraan`, `merk`, `tipe`, `tahun`, `is_unit_baru`, `created_at`) VALUES
(1, 'DB 1234 GT', 'Dump Truck', 'Volvo', 'D6T', 2020, 1, '2026-02-23 04:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_approval`
--

CREATE TABLE `pengajuan_approval` (
  `id_approval` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `level_approval` enum('manager','admin_ohs','ohs_superintendent','ktt') NOT NULL,
  `id_approver` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_uji`
--

CREATE TABLE `pengajuan_uji` (
  `id_pengajuan` int(11) NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `id_pemohon` int(11) NOT NULL,
  `email_pemohon` varchar(100) DEFAULT NULL,
  `status` enum('draft','submitted','review_manager','approved_manager','review_admin','approved_admin','scheduled','inspected','review_ohs','approved_ohs','approved_ktt','sticker_released','rejected') DEFAULT 'draft',
  `tanggal_pengajuan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `uji_checklist`
--

CREATE TABLE `uji_checklist` (
  `id_uji_checklist` int(11) NOT NULL,
  `id_uji` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `kondisi` enum('baik','rusak','perlu_perbaikan') DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uji_kelayakan`
--

CREATE TABLE `uji_kelayakan` (
  `id_uji` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `id_mekanik` int(11) DEFAULT NULL,
  `tanggal_uji` datetime DEFAULT NULL,
  `hasil` enum('lulus','tidak_lulus') DEFAULT NULL,
  `catatan_umum` text DEFAULT NULL
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
(1, 1, 'Administrator', 'admin', 'admin@gmail.com', '$2y$10$9JmqLtLuImhzuXlJTxvKqeL1VgCZ/WOcGlDRClBv2XJ/8ZsGW9JnO', 1, '2026-02-23 02:46:54');

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
  ADD KEY `id_template` (`id_template`);

--
-- Indexes for table `checklist_template`
--
ALTER TABLE `checklist_template`
  ADD PRIMARY KEY (`id_template`);

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
  ADD PRIMARY KEY (`id_approval`),
  ADD KEY `id_approver` (`id_approver`),
  ADD KEY `id_pengajuan` (`id_pengajuan`),
  ADD KEY `level_approval` (`level_approval`),
  ADD KEY `status` (`status`);

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
-- Indexes for table `uji_checklist`
--
ALTER TABLE `uji_checklist`
  ADD PRIMARY KEY (`id_uji_checklist`),
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
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `checklist_item`
--
ALTER TABLE `checklist_item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checklist_template`
--
ALTER TABLE `checklist_template`
  MODIFY `id_template` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_uji`
--
ALTER TABLE `jadwal_uji`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengajuan_approval`
--
ALTER TABLE `pengajuan_approval`
  MODIFY `id_approval` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_lampiran`
--
ALTER TABLE `pengajuan_lampiran`
  MODIFY `id_lampiran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_uji`
--
ALTER TABLE `pengajuan_uji`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sticker_release`
--
ALTER TABLE `sticker_release`
  MODIFY `id_sticker` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uji_checklist`
--
ALTER TABLE `uji_checklist`
  MODIFY `id_uji_checklist` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uji_kelayakan`
--
ALTER TABLE `uji_kelayakan`
  MODIFY `id_uji` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id_user_role` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checklist_item`
--
ALTER TABLE `checklist_item`
  ADD CONSTRAINT `checklist_item_ibfk_1` FOREIGN KEY (`id_template`) REFERENCES `checklist_template` (`id_template`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal_uji`
--
ALTER TABLE `jadwal_uji`
  ADD CONSTRAINT `jadwal_uji_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_uji` (`id_pengajuan`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_uji_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `pengajuan_approval`
--
ALTER TABLE `pengajuan_approval`
  ADD CONSTRAINT `pengajuan_approval_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_uji` (`id_pengajuan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengajuan_approval_ibfk_2` FOREIGN KEY (`id_approver`) REFERENCES `users` (`id_user`);

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
-- Constraints for table `uji_checklist`
--
ALTER TABLE `uji_checklist`
  ADD CONSTRAINT `uji_checklist_ibfk_1` FOREIGN KEY (`id_uji`) REFERENCES `uji_kelayakan` (`id_uji`) ON DELETE CASCADE,
  ADD CONSTRAINT `uji_checklist_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `checklist_item` (`id_item`);

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
