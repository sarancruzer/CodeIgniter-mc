-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 11, 2017 at 03:38 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 5.6.30-12~ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobileclinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `awareness`
--

CREATE TABLE `awareness` (
  `id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `distirct_or_city` int(11) DEFAULT NULL,
  `block_or_zone` int(11) DEFAULT NULL,
  `panchyat_or_ward` int(11) DEFAULT NULL,
  `village_or_slum` int(11) DEFAULT NULL,
  `awareness_type` int(11) DEFAULT NULL,
  `attendees` int(11) DEFAULT NULL,
  `boys_above_18` int(11) DEFAULT NULL,
  `girls_above_18` int(11) DEFAULT NULL,
  `male_above_30` int(11) DEFAULT NULL,
  `female_above_30` int(11) DEFAULT NULL,
  `male_below_30` int(11) DEFAULT NULL,
  `female_below_30` int(11) DEFAULT NULL,
  `reported_by` int(11) DEFAULT NULL,
  `reported_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `awareness`
--

INSERT INTO `awareness` (`id`, `state`, `distirct_or_city`, `block_or_zone`, `panchyat_or_ward`, `village_or_slum`, `awareness_type`, `attendees`, `boys_above_18`, `girls_above_18`, `male_above_30`, `female_above_30`, `male_below_30`, `female_below_30`, `reported_by`, `reported_date`) VALUES
(1, 1, 2, 2, 2, 5, 1, 30, 2, 2, 10, 2, 5, 10, 1, '2016-11-15 13:18:20'),
(2, 2, 3, 3, 3, 3, 2, 30, 2, 2, 10, 2, 5, 10, 1, '2016-11-15 13:22:40');

-- --------------------------------------------------------

--
-- Table structure for table `awareness_type`
--

CREATE TABLE `awareness_type` (
  `id` int(11) NOT NULL,
  `awareness_type` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `awareness_type`
--

INSERT INTO `awareness_type` (`id`, `awareness_type`, `status`) VALUES
(1, 'Eye Donate', '1'),
(2, 'Blood Donate', '0'),
(3, 'Cleaning And Disease', '1');

-- --------------------------------------------------------

--
-- Table structure for table `city_or_block`
--

CREATE TABLE `city_or_block` (
  `id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `district_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city_or_block`
--

INSERT INTO `city_or_block` (`id`, `city_name`, `district_id`, `state_id`) VALUES
(1, 'Omalur', 2, 4),
(2, 'Mettur', 2, 4),
(3, 'sdfsdfsd', 2, 4),
(5, 'Ponnur', 4, 1),
(6, 'Bapatla', 4, 1),
(7, 'Tadepalle', 4, 1),
(8, 'Markapur', 5, 1),
(9, 'Kandukur', 5, 1),
(10, 'Kanigiri', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE `diagnosis` (
  `diagnosis_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `height` varchar(20) DEFAULT NULL,
  `weight` varchar(20) DEFAULT NULL,
  `temperature` varchar(50) DEFAULT NULL,
  `body_pain` varchar(255) DEFAULT NULL,
  `heart_rate` varchar(255) DEFAULT NULL,
  `sugar_level` varchar(255) DEFAULT NULL,
  `bp` varchar(255) DEFAULT NULL,
  `paleness_face_nail` varchar(255) DEFAULT NULL,
  `haemoglobin` varchar(255) DEFAULT NULL,
  `urine_albumin` varchar(50) DEFAULT NULL,
  `urine_sugar` varchar(50) DEFAULT NULL,
  `blood_sugar` varchar(50) DEFAULT NULL,
  `anaemia` varchar(20) DEFAULT NULL,
  `observation_i` varchar(255) DEFAULT NULL,
  `recommendation` varchar(255) DEFAULT NULL,
  `referrals` varchar(255) DEFAULT NULL,
  `treatment` varchar(255) DEFAULT NULL,
  `de_worming` varchar(255) DEFAULT NULL,
  `vaccination` varchar(255) DEFAULT NULL,
  `vitamin_a` varchar(255) DEFAULT NULL,
  `ifa` varchar(255) DEFAULT NULL,
  `blood` varchar(255) DEFAULT NULL,
  `urine` varchar(255) DEFAULT NULL,
  `body_fluids` varchar(255) DEFAULT NULL,
  `imaging` varchar(255) DEFAULT NULL,
  `mortality` varchar(255) DEFAULT NULL,
  `preliminary_diagnosis` text,
  `final_diagnosis` text,
  `circulatory_id` int(11) DEFAULT NULL,
  `digestive_id` int(11) DEFAULT NULL,
  `skin_id` int(11) DEFAULT NULL,
  `nervous_id` int(11) DEFAULT NULL,
  `urinary_id` int(11) DEFAULT NULL,
  `speech_id` int(11) DEFAULT NULL,
  `general_id` int(11) DEFAULT NULL,
  `cognition_id` int(11) DEFAULT NULL,
  `next_follow_up` date DEFAULT NULL,
  `diagnosis_by` int(11) NOT NULL,
  `date_of_diagnosis` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `diagnosis`
--

INSERT INTO `diagnosis` (`diagnosis_id`, `patient_id`, `blood_group`, `height`, `weight`, `temperature`, `body_pain`, `heart_rate`, `sugar_level`, `bp`, `paleness_face_nail`, `haemoglobin`, `urine_albumin`, `urine_sugar`, `blood_sugar`, `anaemia`, `observation_i`, `recommendation`, `referrals`, `treatment`, `de_worming`, `vaccination`, `vitamin_a`, `ifa`, `blood`, `urine`, `body_fluids`, `imaging`, `mortality`, `preliminary_diagnosis`, `final_diagnosis`, `circulatory_id`, `digestive_id`, `skin_id`, `nervous_id`, `urinary_id`, `speech_id`, `general_id`, `cognition_id`, `next_follow_up`, `diagnosis_by`, `date_of_diagnosis`) VALUES
(1, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, 8, 10, 13, 18, 19, 17, NULL, 1, '2016-11-22 13:15:23'),
(2, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, 9, 10, 14, NULL, 19, NULL, NULL, 1, '2016-11-22 13:06:54'),
(3, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 8, NULL, 14, NULL, 19, NULL, NULL, 1, '2016-11-22 13:04:49'),
(4, 5, 'B+ve', '144', '85', '15', 'body pain', 'heart rate', 'sugar level', 'bp', 'paleness_face_nail', 'haemoglobin', 'urine_albumin', 'urine_sugar', 'blood_sugar', 'anaemia', 'observation_i', 'recommendation', 'referrals', 'treatment', 'de_worming', 'vaccination', 'vitamin_a', 'ifa', '', '', '', '', '', '', '', 3, 0, 3, 10, 0, 0, 0, 0, '2016-02-11', 1, '2016-11-22 09:29:01'),
(5, 11, 'B+ve', '144', '85', '15', 'body pain', 'heart rate', 'sugar level', 'bp', 'paleness_face_nail', 'haemoglobin', 'urine_albumin', 'urine_sugar', 'blood_sugar', 'anaemia', 'observation_i', 'recommendation', 'referrals', 'treatment', 'de_worming', 'vaccination', 'vitamin_a', 'ifa', 'blood', 'urine', 'body_fluids', 'imaging', 'mortality', 'preliminary_diagnosis', 'final_diagnosis', 4, 1, 0, 10, 0, 0, 0, 0, '2016-02-11', 1, '2016-11-21 09:31:21'),
(6, 16, 'B+ve', '144', '85', '15', 'body pain', 'heart rate', 'sugar level', 'bp', 'paleness_face_nail', 'haemoglobin', 'urine_albumin', 'urine_sugar', 'blood_sugar', 'anaemia', 'observation_i', 'recommendation', 'referrals', 'treatment', 'de_worming', 'vaccination', 'vitamin_a', 'ifa', 'blood', 'urine', 'body_fluids', 'imaging', 'mortality', 'preliminary_diagnosis', 'final_diagnosis', 5, 0, 1, 1, 1, 1, 1, 1, '2016-02-11', 1, '2016-11-20 09:38:11');

-- --------------------------------------------------------

--
-- Table structure for table `district_list`
--

CREATE TABLE `district_list` (
  `id` int(11) NOT NULL,
  `district_name` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `district_list`
--

INSERT INTO `district_list` (`id`, `district_name`, `state_id`) VALUES
(1, 'Chennai', 4),
(2, 'Salem', 4),
(3, 'Thirupathi', 1),
(4, 'Guntur', 1),
(5, 'Prakasam', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hospitals_list`
--

CREATE TABLE `hospitals_list` (
  `id` int(11) NOT NULL,
  `hospital_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hospitals_list`
--

INSERT INTO `hospitals_list` (`id`, `hospital_name`) VALUES
(1, 'SRM Hospital'),
(2, 'Vijaya Hospital'),
(3, 'safsdf');

-- --------------------------------------------------------

--
-- Table structure for table `masters`
--

CREATE TABLE `masters` (
  `id` int(11) NOT NULL,
  `master_type` varchar(255) NOT NULL,
  `master_value` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masters`
--

INSERT INTO `masters` (`id`, `master_type`, `master_value`, `status`) VALUES
(1, 'circulatory_respiratory', 'system 1', '1'),
(2, 'digestive_abdomen', 'system 2', '1'),
(3, 'circulatory_respiratory', 'circulatory 1', '1'),
(4, 'circulatory_respiratory', 'circulatory 2', '1'),
(5, 'circulatory_respiratory', 'circulatory 3', '1'),
(6, 'circulatory_respiratory', 'cir 4', '1'),
(7, 'digestive_abdomen', 'dig', '1'),
(8, 'skin_subcutaneous_tissue', 'skin and sub', '1'),
(9, 'skin_subcutaneous_tissue', 'skin 2', '1'),
(10, 'nervous_musculoskeletal_systems', 'nervous 1', '1'),
(11, 'nervous_musculoskeletal_systems', 'nervous 2', '1'),
(12, 'nervous_musculoskeletal_systems', 'nervous 3', '1'),
(13, 'urinary_system', 'urinary', '1'),
(14, 'urinary_system', 'urinary 2', '1'),
(15, 'urinary_system', 'urinary 3', '1'),
(16, 'cognition_perception_emotional', 'cognition 1', '1'),
(17, 'cognition_perception_emotional', 'cognition 2', '1'),
(18, 'speech_voice', 'speech 1', '1'),
(19, 'general_symptoms_signs', 'general', '1');

-- --------------------------------------------------------

--
-- Table structure for table `masters_types`
--

CREATE TABLE `masters_types` (
  `id` int(11) NOT NULL,
  `master_key` varchar(255) NOT NULL,
  `master_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masters_types`
--

INSERT INTO `masters_types` (`id`, `master_key`, `master_name`) VALUES
(1, 'circulatory_respiratory', 'Circulatory and respiratory'),
(2, 'digestive_abdomen', 'Digestive system and abdomen'),
(3, 'skin_subcutaneous_tissue', 'Skin and subcutaneous tissue'),
(4, 'nervous_musculoskeletal_systems', 'Nervous and musculoskeletal systems'),
(5, 'urinary_system', 'Urinary system'),
(6, 'cognition_perception_emotional', 'Cognition, perception, emotional'),
(7, 'speech_voice', 'Speech and voice'),
(8, 'general_symptoms_signs', 'General symptoms and signs');

-- --------------------------------------------------------

--
-- Table structure for table `patient_child`
--

CREATE TABLE `patient_child` (
  `id` int(11) NOT NULL,
  `child_name` varchar(255) NOT NULL,
  `child_dob` date NOT NULL,
  `child_gender` varchar(20) NOT NULL,
  `patient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_child`
--

INSERT INTO `patient_child` (`id`, `child_name`, `child_dob`, `child_gender`, `patient_id`) VALUES
(1, 'venkat', '2016-11-09', 'male', 5),
(2, 'suresh', '2016-11-16', 'Female', 5),
(3, 'venkat', '2000-10-11', 'male', 12),
(4, 'suresh', '2012-01-20', 'Female', 12),
(5, 'uya', '0000-00-00', 'Male', 16),
(6, 'jhjhh', '0000-00-00', 'Female', 16);

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `tab_cap_syrup` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `bb` int(11) DEFAULT NULL,
  `ab` int(11) DEFAULT NULL,
  `bl` int(11) DEFAULT NULL,
  `al` int(11) DEFAULT NULL,
  `eve` int(11) DEFAULT NULL,
  `bm` int(11) DEFAULT NULL,
  `am` int(11) DEFAULT NULL,
  `days` int(11) NOT NULL,
  `prescribed_by` int(11) NOT NULL,
  `date_of_prescription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`id`, `patient_id`, `tab_cap_syrup`, `description`, `bb`, `ab`, `bl`, `al`, `eve`, `bm`, `am`, `days`, `prescribed_by`, `date_of_prescription`) VALUES
(1, 5, '', 'This is test', 0, 1, 0, 1, 0, 0, 1, 30, 3, '2016-11-05 08:14:30'),
(2, 5, 'cap', 'This is test description', 0, 1, 0, 1, 0, 0, 1, 30, 3, '2016-11-05 08:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `referred_to` varchar(255) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `preliminary_diagnosis` text,
  `final_diagnosis` text,
  `referred_by` int(11) NOT NULL,
  `referred_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `patient_id`, `referred_to`, `hospital_id`, `preliminary_diagnosis`, `final_diagnosis`, `referred_by`, `referred_date`) VALUES
(1, 5, 'usan boy', 1, 'This is preliminary', 'this is final diagnosis', 1, '2016-11-07 10:23:56'),
(2, 5, '1', 1, 'ghfggiuiuj', 'final', 1, '2016-11-18 10:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `title` varchar(20) DEFAULT NULL,
  `initials` varchar(10) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `slum_or_village` int(11) DEFAULT NULL,
  `ward_or_panchayat` int(11) DEFAULT NULL,
  `city_block` int(11) DEFAULT NULL,
  `district` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `husband_or_father_name` varchar(255) DEFAULT NULL,
  `child_one` varchar(255) DEFAULT NULL,
  `monthly_income` varchar(50) DEFAULT NULL,
  `registration_by` int(11) NOT NULL,
  `date_of_registration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `title`, `initials`, `first_name`, `last_name`, `dob`, `gender`, `address`, `slum_or_village`, `ward_or_panchayat`, `city_block`, `district`, `state`, `mobile`, `email`, `occupation`, `marital_status`, `husband_or_father_name`, `child_one`, `monthly_income`, `registration_by`, `date_of_registration`) VALUES
(5, 'Mr', 'R', 'venkatesh', 'Rathinam', '1988-05-30', 'Male', 'chennai', 5, 2, 2, 2, 4, '9874556321', 'venkat.r@claritaz.com', 'Senior Software Engineer', 'single', 'Rathinam', 'no', '30000', 3, '2016-10-30 04:19:54'),
(6, 'Mr', 'Ggg', 'Hhhh', 'Hhhh', '1970-01-01', NULL, NULL, 2, 2, 2, 2, 4, '235667888', 'Ggg@fggh.com', NULL, NULL, NULL, NULL, NULL, 1, '2016-10-26 04:27:15'),
(7, 'Mr', 'R', 'venkatesh', 'Rathinam', '1988-05-30', 'Male', 'chennai', 2, 2, 2, 2, 4, '9874556321', 'venkat1.r@claritaz.com', 'Senior Software Engineer', 'single', 'Rathinam', 'no', '30000', 1, '2016-10-25 04:34:26'),
(8, 'Mr', 'KS', 'Anand', 'Kumar', '2016-10-26', 'Male', 'gg', 2, 2, 2, 2, 4, '99999886655', 'Prakash.kalai@gmail.com', 'Occu', 'Single', 'Kalai', 'Hhh', '12000', 1, '2016-10-24 04:41:47'),
(9, 'Mr', 'fkjgfgfg', 'fghdg', 'jkdjdghj', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6767676766', 'iihjfhfghkj@g.com', NULL, NULL, NULL, NULL, NULL, 1, '2016-11-04 20:31:23'),
(10, 'Mr', 'R', 'venkatesh', 'Rathinam', '1988-05-30', 'Male', 'chennai', 2, 2, 2, 2, 4, '9874556321', 'fdfg.r@claritaz.com', 'Senior Software Engineer', 'single', 'Rathinam', 'no', '30000', 1, '2016-11-07 05:22:38'),
(11, 'Mr', 'R', 'venkatesh', 'Rathinam', '1988-05-30', NULL, 'chennai', 2, 2, 2, 2, 4, '9874556321', 'fdffgfg.r@claritaz.com', 'Senior Software Engineer', 'single', 'Rathinam', 'no', '30000', 1, '2016-11-07 06:12:16'),
(12, 'Mr', 'R', 'venkatesh', 'Rathinam', '1988-05-30', 'Male', 'chennai', 2, 2, 2, 2, 4, '9874556321', 'sdf.r@claritaz.com', 'Senior Software Engineer', 'single', 'Rathinam', 'no', '30000', 1, '2016-11-07 06:12:41'),
(13, 'Mr', 'R', 'venkatesh', 'Rathinam', '1988-05-30', 'Male', 'chennai', 2, 2, 2, 2, 4, '9874556321', 'sddsdf.r@claritaz.com', 'Senior Software Engineer', 'single', 'Rathinam', 'no', '30000', 1, '2016-11-07 06:22:37'),
(14, 'Mr', 'R', 'venkatesh', 'Rathinam', '1988-05-30', 'Male', 'chennai', 2, 2, 2, 2, 4, '9874556321', 'sddfdgsdf.r@claritaz.com', 'Senior Software Engineer', 'single', 'Rathinam', 'no', '30000', 1, '2016-11-07 06:23:12'),
(15, 'Mr', 'R', 'venkatesh', 'Rathinam', '1988-05-30', 'Male', 'chennai', 2, 2, 2, 2, 4, '9874556321', 'sddfdgsdsdf.r@claritaz.com', 'Senior Software Engineer', 'single', 'Rathinam', 'no', '30000', 1, '2016-11-07 06:24:49'),
(16, 'Mr', 'R', 'venkatesh', 'Rathinam', '1988-05-30', 'Female', 'chennai', 2, 2, 2, 2, 4, '9874556321', 'f.r@claritaz.com', 'Senior Software Engineer', 'single', 'Rathinam', 'no', '30000', 1, '2016-11-07 07:23:35'),
(17, 'Mr', 'R', 'venkatesh', 'Rathinam', NULL, 'Male', 'chennai', 2, 2, 2, 2, 4, '9874556321', 'sds.r@claritaz.com', 'Senior Software Engineer', 'single', 'Rathinam', 'no', '30000', 1, '2016-12-08 22:45:56'),
(18, 'Mr', 'R', 'venkatesh', 'Rathinam', '1988-05-30', 'Male', 'chennai', 2, 2, 2, 2, 4, '9874556321', 'sdssad.r@claritaz.com', 'Senior Software Engineer', 'single', 'Rathinam', 'no', '30000', 1, '2016-12-08 23:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `slum_or_village`
--

CREATE TABLE `slum_or_village` (
  `id` int(11) NOT NULL,
  `village_name` varchar(255) NOT NULL,
  `panchayat_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slum_or_village`
--

INSERT INTO `slum_or_village` (`id`, `village_name`, `panchayat_id`, `city_id`, `district_id`, `state_id`) VALUES
(4, 'bapat', 6, 6, 4, 1),
(5, 'Sengattur', 2, 2, 2, 4),
(6, 'kanigri', 7, 10, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `state_list`
--

CREATE TABLE `state_list` (
  `id` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state_list`
--

INSERT INTO `state_list` (`id`, `state_name`) VALUES
(1, 'Andhra Pradesh'),
(2, 'Assam'),
(3, 'Bihar'),
(4, 'Tamil Nadu'),
(5, ''),
(6, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_role` int(11) NOT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `registered_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `user_role`, `device_id`, `is_active`, `registered_on`) VALUES
(1, 'demo', 'demo', 'Demo', 'gonto@me.com', 1, 'ertwretwrewretwretretwert', '1', '2016-11-01 03:53:07'),
(2, 'muthu1y1', 'muthu', 'y1', 'muthu1@claritaz.com', 3, '', '0', '2016-11-01 04:17:14'),
(3, 'venkat', 'venkat', 'venkat', 'venkat@cla.com', 2, 'sdf', '1', '2016-11-01 09:19:22'),
(4, 'sdsdgf', 'sdfgsd', 'gsdgd', 'sdfg@sdaf.com', 0, '', '1', '2016-11-01 09:27:37'),
(9, 'ww', 'fdgh', 'ww', 'ww@sdfsd.com', 3, NULL, '0', '2016-11-01 13:40:37'),
(10, 'qwwwww', 'wwwww', 'wwwwww', 'wwwwwww@d.com', 3, NULL, '1', '2016-11-01 13:43:16'),
(11, 'abu', 'e10adc3949ba59abbe56e057f20f883e', 'abu', 'ven@sdf.com', 2, NULL, '1', '2016-11-02 12:48:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `user_role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_role`) VALUES
(1, 'Admin'),
(2, 'Doctors'),
(3, 'Health Workers');

-- --------------------------------------------------------

--
-- Table structure for table `ward_or_panchayat`
--

CREATE TABLE `ward_or_panchayat` (
  `id` int(11) NOT NULL,
  `panchayat_name` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ward_or_panchayat`
--

INSERT INTO `ward_or_panchayat` (`id`, `panchayat_name`, `city_id`, `district_id`, `state_id`) VALUES
(2, 'Banapuram', 2, 2, 4),
(6, 'bapat', 6, 4, 1),
(7, 'kani', 10, 5, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `awareness`
--
ALTER TABLE `awareness`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `awareness_type`
--
ALTER TABLE `awareness_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_or_block`
--
ALTER TABLE `city_or_block`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`diagnosis_id`);

--
-- Indexes for table `district_list`
--
ALTER TABLE `district_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospitals_list`
--
ALTER TABLE `hospitals_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masters`
--
ALTER TABLE `masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masters_types`
--
ALTER TABLE `masters_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_child`
--
ALTER TABLE `patient_child`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slum_or_village`
--
ALTER TABLE `slum_or_village`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state_list`
--
ALTER TABLE `state_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`username`);

--
-- Indexes for table `ward_or_panchayat`
--
ALTER TABLE `ward_or_panchayat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `awareness`
--
ALTER TABLE `awareness`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `awareness_type`
--
ALTER TABLE `awareness_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `city_or_block`
--
ALTER TABLE `city_or_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `diagnosis`
--
ALTER TABLE `diagnosis`
  MODIFY `diagnosis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `district_list`
--
ALTER TABLE `district_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `hospitals_list`
--
ALTER TABLE `hospitals_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `masters`
--
ALTER TABLE `masters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `masters_types`
--
ALTER TABLE `masters_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `patient_child`
--
ALTER TABLE `patient_child`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `slum_or_village`
--
ALTER TABLE `slum_or_village`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `state_list`
--
ALTER TABLE `state_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `ward_or_panchayat`
--
ALTER TABLE `ward_or_panchayat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
