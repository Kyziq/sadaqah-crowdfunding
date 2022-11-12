-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2022 at 08:58 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sadaqahcrowdfunding`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `campaign_id` int(11) NOT NULL,
  `campaign_name` varchar(100) NOT NULL,
  `campaign_description` varchar(1000) NOT NULL,
  `campaign_banner` varchar(200) NOT NULL,
  `campaign_category_id` int(11) NOT NULL,
  `campaign_amount` double NOT NULL,
  `campaign_start` datetime(6) NOT NULL,
  `campaign_end` datetime(6) NOT NULL,
  `campaign_raised` double NOT NULL,
  `campaign_created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `campaign_admin_id` int(11) NOT NULL,
  `campaign_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`campaign_id`, `campaign_name`, `campaign_description`, `campaign_banner`, `campaign_category_id`, `campaign_amount`, `campaign_start`, `campaign_end`, `campaign_raised`, `campaign_created_date`, `campaign_admin_id`, `campaign_status`) VALUES
(1, 'Rawatan Bulanan Peserta Dialisis Pusat Haemodialisis Zakat Kedah', 'Dialisis adalah rawatan yang mengambil alih tugas-tugas yang dilakukan oleh buah pinggang. Pusat Haemodialisis Zakat Kedah memberikan rawatan ini secara bulanan kepada peserta-peserta yang datang ke pusat ini.', 'images/campaign/Rawatan Bulanan Peserta Dialisis Pusat Haemodialisis Zakat Kedah--2022-10-29--17-20-07.jpg', 1, 3500, '2022-11-01 00:00:00.000000', '2022-11-30 00:00:00.000000', 500, '2022-10-29 09:20:07', 1, 1),
(2, '(Misi Banjir Baling) Baik Pulih Rumah', 'Jumlah mangsa banjir yang dipindahkan ke pusat pemindahan sementara (PPS) di Kedah meningkat kepada 267 orang daripada 87 keluarga setakat 8 pagi ini berbanding 87 orang daripada 27 keluarga semalam. ', 'images/campaign/(Misi Banjir Baling) Baik Pulih Rumah--2022-10-29--17-27-54.png', 4, 13000, '2022-10-29 00:00:00.000000', '2022-11-30 00:00:00.000000', 0, '2022-10-29 09:27:54', 1, 1),
(3, 'MERCY Mission Malaysia', 'MERCY Malaysia is an international non-profit organisation focusing on providing medical relief, sustainable health-related development and risk reduction activities for vulnerable communities, in both crisis and non-crisis situation.', 'images/campaign/MERCY Mission Malaysia--2022-10-29--17-29-43.jpg', 3, 24000, '2022-10-01 00:00:00.000000', '2022-12-31 00:00:00.000000', 0, '2022-10-29 09:29:43', 1, 1),
(4, 'Ringankan Beban Golongan Terjejas', 'Keperluan asas harian akan diutamakan kepada golongan-golongan yang terjejas.', 'images/campaign/Ringankan Beban Golongan Terjejas--2022-10-29--17-33-40.jpg', 1, 1000, '2022-11-01 00:00:00.000000', '2022-11-08 00:00:00.000000', 0, '2022-10-29 09:33:40', 1, 3),
(5, 'Yayasan Institut Jantung Negara', 'Memberikan bantuan kepada pesakit jantung di Yayasan Institut Jantung Negara. Jantung adalah organ yang paling penting dalam badan manusia. Ia memainkan peranan yang besar untuk memastikan fungsi badan manusia terus berjalan dengan baik. Jika berlakunya kerosakan pada organ ini akan menjejaskan banyak bahagian di dalam badan manusia.', 'images/campaign/Yayasan Institut Jantung Negara--2022-10-29--17-36-06.jpg', 3, 50000, '2022-11-01 00:00:00.000000', '2022-12-31 00:00:00.000000', 20000, '2022-10-29 09:36:06', 1, 1),
(6, 'Bantuan Sekolah-Sekolah Malaysia', 'Pelajar adalah masa depan negara kita. Marilah meringankan beban perbelanjaan persekolahan pelajar-pelajar sekolah dari segi peralatan, buku dan keperluan asas yang diperlukan. ', 'images/campaign/Bantuan Sekolah-Sekolah Malaysia--2022-10-29--17-40-37.jpg', 2, 8000, '2022-11-10 00:00:00.000000', '2022-12-10 00:00:00.000000', 0, '2022-10-29 09:40:37', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Cash'),
(2, 'School Necessity'),
(3, 'Facilitator'),
(4, 'Service');

-- --------------------------------------------------------

--
-- Table structure for table `donate`
--

CREATE TABLE `donate` (
  `donate_id` int(11) NOT NULL,
  `donate_amount` double NOT NULL,
  `donate_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `donate_proof` varchar(200) NOT NULL,
  `donate_status` int(11) NOT NULL,
  `donator_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donate`
--

INSERT INTO `donate` (`donate_id`, `donate_amount`, `donate_date`, `donate_proof`, `donate_status`, `donator_id`, `admin_id`, `campaign_id`) VALUES
(1, 500, '2022-11-12 17:44:13.809653', 'images/donation-proof/nik-campaignID1--2022-11-13--01-34-33.png', 1, 6, 1, 1),
(2, 20000, '2022-11-12 18:07:53.943770', 'images/donation-proof/amran-campaignID5--2022-11-13--02-07-23.pdf', 1, 8, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `level_id` int(11) NOT NULL,
  `level_desc` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`level_id`, `level_desc`) VALUES
(1, 'admin'),
(2, 'auditor'),
(3, 'donator');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_desc`) VALUES
(1, 'Accepted'),
(2, 'Declined'),
(3, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `user_password`, `user_name`, `user_email`, `user_phone`, `user_address`, `user_level`) VALUES
(1, 'haziq', '$2y$10$zSiPHRket9McR8nGFnueXu6imkY97sySIKUSMy687jCwAGAc9G1k.', 'Muhammad Khairul Haziq bin Mohamad Khairi', 'ihaziqkhairi@gmail.com', '0164005754', '28, Jln 2K, Bandar Tropika, 62209 Precinct 8, Putrajaya', 1),
(2, 'gopi', '$2y$10$tHlRCmwoTLXVM4Av6gEdt.ntiCR9gudqKTQKgThgFZWq48qrKJL0O', 'Gopinathan a/l Pragash', 'gopinathan@yahoo.com', '0179620125', 'No. 1, Jalan Ampang 8/4, SS64O, 62040 Precinct 5, Putrajaya', 3),
(3, 'shazwan', '$2y$10$PcbMA9xHXDa.GUP2PHsi3.JypawKONQ3.K0v2A/wBwCoBOwrw.f/u', 'Muhammad Shazwan bin Ikmal', 'shazwan@gmail.com', '0198662327', 'Z-00-23, Jalan Wan Kadir 2/5, Pandan Manggis, 34854 Tanjung Rambutan, Perak', 2),
(4, 'natasha', '$2y$10$jEG37OkT.JoumBI/iDQfIuSGnqaoMU9Dn8FjPxeGEYjtqgIRtPsIS', 'Natasha Aliah binti Ahmad', 'natashaaliah@gmail.com', '0129589912', 'No. 1G-90, Jln Cochrane 3P, Bandar Sri Rahman, 52746 Sungai Lembing, Pahang Darul Makmur', 2),
(5, 'afifah', '$2y$10$rEi2gatQf592vnH1X5kzkupBGc46DrsKAMhS1HKittSENzBhhPeOW', 'Afifah binti Hazzam', 'afifah@gmail.com', '0195827301', 'No. 447, Lorong 3/7, Pandan Meru, 23750 Rantau Abang, Terengganu Darul Iman', 2),
(6, 'nik', '$2y$10$mScJv5719orWWZ1ChCPR.uKRBPRSJBZduAjom9oZQedvtaWhR5PxC', 'Nik Afiq bin Hakimi', 'nikafiq@yahoo.com', '0168491023', 'B-16-69, Lorong Sultan Azlan Shah 1/99, PJU5, 11950 Batu Kawan, Pulau Pinang', 3),
(7, 'chai', '$2y$10$0JCpGRtbT09bzK4UC4zFKOlcNOKPKa6uViWeH2dNFZHrNbX8W4rBq', 'Chai Key Teh', 'chaikeyteh@gmail.com', '0176932012', '987, Jalan 9, SS87, 47143 Subang Jaya, Selangor', 3),
(8, 'amran', '$2y$10$oduKRntTG6OCcWKDPHSNn.uqyANMDCH2DKaB9DSMoZL3pYqRB01v6', 'Muhammad Amran bin Ikmal', 'amranikmal@outlook.com', '0198662322', 'Z-00-23, Jalan Wan Kadir 2/5, Pandan Manggis, 34854 Tanjung Rambutan, Perak', 3),
(9, 'raihan', '$2y$10$ZKBpL/tVjSpqZdZH6Vgw8eANey2iGmVoBXI/iYKvsteL3jy/kUlfy', 'Muhammad Raihan bin Azlan', 'raihanazlan@gmail.com', '0196862931', 'No. 50, Jalan 2/5, Taman Anggerik, 12159 George Town, Penang', 3),
(10, 'ain', '$2y$10$hD7PrLZsJ5/FjttRbzLwlelbl5jVFy5r3RZDK6nP3g00h.pZy79Xu', 'Ain Amni binti Kamarul', 'ainamni@gmail.com', '0129518232', '312, Lorong 2Y, Bandar Utara, 27454 Karak, Pahang Darul Makmur', 3);

-- --------------------------------------------------------

--
-- Table structure for table `verification`
--

CREATE TABLE `verification` (
  `verification_id` int(11) NOT NULL,
  `verification_status` int(11) NOT NULL,
  `verification_comment` varchar(1000) NOT NULL,
  `verification_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `campaign_id` int(11) NOT NULL,
  `auditor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `verification`
--

INSERT INTO `verification` (`verification_id`, `verification_status`, `verification_comment`, `verification_date`, `campaign_id`, `auditor_id`) VALUES
(1, 1, 'Mantap', '2022-11-12 17:22:55', 1, 5),
(2, 1, 'Mantap!', '2022-11-12 17:32:24', 2, 5),
(3, 1, 'Mantap', '2022-11-12 17:32:38', 3, 5),
(4, 1, 'Mantap', '2022-11-12 17:32:52', 6, 5),
(5, 1, 'Mantap', '2022-11-12 17:32:55', 5, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`campaign_id`),
  ADD KEY `categoryID` (`campaign_category_id`),
  ADD KEY `campaignAdminId` (`campaign_admin_id`),
  ADD KEY `campaign` (`campaign_status`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `donate`
--
ALTER TABLE `donate`
  ADD PRIMARY KEY (`donate_id`),
  ADD KEY `donatorId` (`donator_id`),
  ADD KEY `adminId` (`admin_id`),
  ADD KEY `campaignId` (`campaign_id`),
  ADD KEY `statusId` (`donate_status`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `userLevel` (`user_level`);

--
-- Indexes for table `verification`
--
ALTER TABLE `verification`
  ADD PRIMARY KEY (`verification_id`),
  ADD KEY `campaign_id` (`campaign_id`),
  ADD KEY `auditorId` (`auditor_id`),
  ADD KEY `verificationStatus` (`verification_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donate`
--
ALTER TABLE `donate`
  MODIFY `donate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `verification`
--
ALTER TABLE `verification`
  MODIFY `verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaign`
--
ALTER TABLE `campaign`
  ADD CONSTRAINT `campaign` FOREIGN KEY (`campaign_status`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `campaignAdminId` FOREIGN KEY (`campaign_admin_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `categoryID` FOREIGN KEY (`campaign_category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `donate`
--
ALTER TABLE `donate`
  ADD CONSTRAINT `adminId` FOREIGN KEY (`admin_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `campaignId` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`),
  ADD CONSTRAINT `donatorId` FOREIGN KEY (`donator_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `statusId` FOREIGN KEY (`donate_status`) REFERENCES `status` (`status_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `userLevel` FOREIGN KEY (`user_level`) REFERENCES `level` (`level_id`);

--
-- Constraints for table `verification`
--
ALTER TABLE `verification`
  ADD CONSTRAINT `auditorId` FOREIGN KEY (`auditor_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `campId` FOREIGN KEY (`campaign_id`) REFERENCES `campaign` (`campaign_id`),
  ADD CONSTRAINT `verificationStatus` FOREIGN KEY (`verification_status`) REFERENCES `status` (`status_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
