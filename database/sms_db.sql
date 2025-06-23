-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 11:43 AM
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
-- Database: `sms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_boxes`
--

CREATE TABLE `about_boxes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_boxes`
--

INSERT INTO `about_boxes` (`id`, `title`, `content`, `icon`, `logo`, `image`) VALUES
(23, 'Vision and Mission', 'Tanza National Trade School envisions itself as a center of academic excellence and vocational efficiency, striving to be a leading educational institution in Cavite and the Philippines. Its mission is to produce empowered individuals equipped with relevant knowledge, skills, and values, preparing them for success in higher education and their chosen careers. Vision Tanza National Trade School aims to be a community that is: Academically Excellent Vocationally Efficient Socially Responsible Future-Ready Mission Tanza National Trade School seeks to develop individuals with: Relevant Knowledge Practical Skills Strong Values Lifelong Learning Mindset', '', 'University-256.png', NULL),
(24, 'History', 'History of Tanza National Trade School Annex\r\n\r\nTanza National Trade School was established through Republic Act No. 3832, approved on June 27, 1963. It began operations in June 1973, offering secondary trade education. Initially, from 1973 to 1987, TNTS functioned as an annex-satellite school under the supervision of Cavite College of Arts and Trades in Rosario, Cavite. During this period, while the school operated under this arrangement, its financial operations were managed separately, with funds provided directly through the Department of Education, Culture, and Sports (DECS) Regional Office. In June 1987, TNTS gained financial autonomy and came directly under the DECS Regional Office\'s supervision. By June 1992, the school expanded its curriculum to include post-secondary education, offering two-year technical courses alongside its four-year secondary trade education.\r\n\r\nTanza National Trade School-Annex is an extension of the main Tanza National Trade School campus, located in Paradahan I, Tanza, Cavite. Established in 1973, Tanza National Trade School has been dedicated to providing vocational and technical education to the youth of Tanza and its neighboring communities. The Annex continues this tradition by offering quality education and training to equip students with the necessary skills for their future careers.\r\n\r\n', '', 'tntsannexicon_white.png', NULL),
(25, 'Location', 'Tanza National Trade School Annex is situated in Pabahay 2000, Bagtas, Tanza, Cavite, Philippines, 4108. The annex provides a convenient and accessible learning environment for students in Tanza and nearby areas, promoting a safe and supportive educational atmosphere.', '', 'maps.png', 'map.png');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(127) NOT NULL,
  `lname` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `fname`, `lname`) VALUES
(4, 'admin', '$2y$10$ebEP4TzK3XvD1xQyLFVU/OoPC1guyWN/cRujMscMeblLeP3Aro58q', 'test', 'test'),
(5, '123', '$2y$10$QL6vEUEAvcumKWfMFWpMfeoXG8lIWwtOTzhB2G4R8edOtV7LAmjLe', '123', '123');

-- --------------------------------------------------------

--
-- Table structure for table `career_suggestions`
--

CREATE TABLE `career_suggestions` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `jobs` text NOT NULL,
  `courses` text NOT NULL,
  `track` varchar(255) DEFAULT NULL,
  `clusters` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career_suggestions`
--

INSERT INTO `career_suggestions` (`id`, `category_id`, `jobs`, `courses`, `track`, `clusters`) VALUES
(1, 1, 'Software Developer, Data Analyst, Engineer', 'Computer Science, Information Technology, Engineering', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(2, 1, 'Biologist, Chemist, Environmental Scientist', 'Biology, Chemistry, Environmental Science', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(3, 1, 'Doctor, Nurse, Pharmacist', 'Medicine, Nursing, Pharmacy', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(4, 1, 'Robotics Engineer, AI Specialist, Data Scientist', 'Robotics, Artificial Intelligence, Data Science', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(5, 1, 'Astronomer, Mathematician, Statistician', 'Astronomy, Mathematics, Statistics', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(6, 2, 'Journalist, Teacher, Psychologist', 'Communication Arts, Education, Psychology', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(7, 2, 'Historian, Political Analyst, Public Servant', 'History, Political Science, Sociology', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(8, 2, 'Social Worker, Counselor, Human Rights Advocate', 'Social Work, Counseling, Social Sciences', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(9, 2, 'Lawyer, Diplomat, Policy Advisor', 'Law, International Relations, Public Administration', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(10, 2, 'Linguist, Anthropologist, Philosopher', 'Linguistics, Anthropology, Philosophy', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(11, 3, 'Entrepreneur, Marketing Specialist, Accountant', 'Business Administration, Marketing, Accountancy', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(12, 3, 'Financial Analyst, Investment Banker, Auditor', 'Finance, Economics, Business Analytics', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(13, 3, 'Hotel Manager, Real Estate Agent, Retail Manager', 'Hospitality Management, Real Estate, Business Management', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(14, 3, 'E-commerce Manager, Product Manager, Brand Strategist', 'E-Commerce, Product Management, Strategic Marketing', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(15, 3, 'Business Consultant, Sales Executive, Operations Manager', 'Management, Business Development, Sales', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(16, 4, 'Mechanic, Electrician, Automotive Technician', 'Automotive Technology, Electrical Installation, Mechatronics', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(17, 4, 'Chef, Baker, Barista', 'Culinary Arts, Hospitality Services, Food Technology', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(18, 4, 'Plumber, Welder, Carpenter', 'Construction Services, Welding Technology, Plumbing', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(19, 4, 'HVAC Technician, Industrial Technician, Machinist', 'HVAC, Industrial Tech, Machine Operations', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(20, 4, 'Tailor, Cosmetologist, Housekeeping Staff', 'Tailoring, Beauty Care, Housekeeping', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(21, 5, 'Graphic Designer, Animator, Illustrator', 'Multimedia Arts, Graphic Design, Animation', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(22, 5, 'Filmmaker, Director, Cinematographer', 'Film, Media Production, Visual Communication', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(23, 5, 'Stage Actor, Dancer, Musician', 'Performing Arts, Theater Arts, Music', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(24, 5, 'Interior Designer, Fashion Designer, Photographer', 'Interior Design, Fashion Design, Photography', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(25, 5, 'Art Curator, Visual Artist, Art Teacher', 'Fine Arts, Art Studies, Art Education', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(26, 1, 'Geologist, Meteorologist, Oceanographer', 'Geology, Meteorology, Marine Science', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(27, 1, 'Cybersecurity Analyst, Ethical Hacker, Penetration Tester', 'Cybersecurity, Computer Science, Information Systems', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(28, 1, 'Biomedical Engineer, Medical Technologist, Geneticist', 'Biomedical Engineering, Medical Technology, Genetics', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(29, 1, 'Game Developer, UX Designer, 3D Modeler', 'Game Development, Human-Computer Interaction, Multimedia Arts', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(30, 1, 'Aerospace Engineer, Pilot, Flight Engineer', 'Aerospace Engineering, Aeronautics, Aviation Technology', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(31, 2, 'Archivist, Museum Curator, Cultural Researcher', 'Archival Studies, Museum Studies, Cultural Studies', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(32, 2, 'Guidance Counselor, Life Coach, Behavioral Therapist', 'Psychology, Counseling, Behavioral Sciences', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(33, 2, 'Broadcast Producer, Radio Host, Content Writer', 'Mass Communication, Broadcast Journalism, Creative Writing', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(34, 2, 'Ethicist, Theologian, Sociologist', 'Ethics, Theology, Sociology', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(35, 2, 'Urban Planner, Demographer, Community Developer', 'Urban Planning, Demography, Public Policy', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(36, 3, 'Supply Chain Manager, Logistics Analyst, Procurement Officer', 'Supply Chain Management, Logistics, Business Operations', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(37, 3, 'Tax Consultant, Budget Analyst, Actuary', 'Accountancy, Finance, Actuarial Science', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(38, 3, 'Digital Marketing Expert, SEO Specialist, Social Media Manager', 'Marketing, Digital Business, E-Commerce', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(39, 3, 'Franchise Owner, Retail Entrepreneur, Business Coach', 'Entrepreneurship, Retail Management, Business Coaching', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(40, 3, 'HR Specialist, Talent Acquisition Manager, Organizational Psychologist', 'Human Resource Management, Organizational Behavior, Psychology', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(41, 4, 'Drone Operator, Digital Fabrication Technician, CNC Machine Operator', 'Drone Technology, Industrial Tech, CNC Programming', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(42, 4, 'Makeup Artist, Nail Technician, Spa Attendant', 'Cosmetology, Beauty Therapy, Spa Services', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(43, 4, 'Event Planner, Floral Designer, Wedding Coordinator', 'Events Management, Floral Design, Hospitality', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(44, 4, 'Agricultural Technician, Livestock Farmer, Horticulturist', 'Agriculture, Animal Science, Horticulture', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(45, 4, 'Call Center Agent, BPO Specialist, Office Assistant', 'Office Management, Communication Skills, BPO Training', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(46, 5, 'Tattoo Artist, Graffiti Artist, Street Performer', 'Visual Arts, Tattoo Design, Performance Arts', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(47, 5, 'Storyboard Artist, Comic Book Illustrator, Concept Artist', 'Illustration, Comic Arts, Digital Art', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(48, 5, 'Music Producer, Audio Engineer, Sound Designer', 'Music Production, Sound Engineering, Audio Technology', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(49, 5, 'Voice Actor, Foley Artist, Dubbing Director', 'Voice Acting, Media Arts, Sound Design', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(50, 5, 'Art Therapist, Community Art Facilitator, Expressive Arts Teacher', 'Art Therapy, Expressive Arts, Community Development', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(51, 9, 'Software Developer, Data Analyst, Engineer', '', '', NULL),
(52, 9, '', 'Computer Science, Information Technology, Engineering', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(53, 9, 'Software Developer, Data Analyst, Engineer', '', '', NULL),
(54, 9, 'Software Developer, Data Analyst, Engineer', 'Computer Science, Information Technology, Engineering', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(55, 10, 'Doctor, Nurse, Pharmacist', 'Robotics, Artificial Intelligence, Data Science', '', NULL),
(56, 10, 'Historian, Political Analyst, Public Servant', 'Communication Arts, Education, Psychology', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(57, 10, 'Graphic Designer, Animator, Illustrator', 'Fine Arts, Art Studies, Art Education', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(58, 11, 'Journalist, Teacher, Psychologist', 'Communication Arts, Education, Psychology', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(59, 12, 'Entrepreneur, Marketing Specialist, Accountant', 'Business Administration, Marketing, Accountancy', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(60, 13, 'Mechanic, Electrician, Automotive Technician', 'Automotive Technology, Electrical Installation, Mechatronics', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(61, 14, 'Historian, Political Analyst, Public Servant', 'History, Political Science, Sociology', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(62, 15, 'Doctor, Nurse, Pharmacist', 'Medicine, Nursing, Pharmacy, Social Work, Counseling, Social Sciences', 'Academic Track', 'Arts, Social Sciences, and Humanities, Business and Entrepreneurship, STEM'),
(63, 13, 'Mechanic, Electrician, Automotive Technician', '', '', NULL),
(64, 13, 'Mechanic, Electrician, Automotive Technician', 'Automotive Technology, Electrical Installation, Mechatronics', 'Technical Professional (TechPro) Track', 'Field Experience, Agriculture and Fishery Arts, Industrial Arts and Maritime'),
(65, 9, '', '', '', 'STEM'),
(66, 10, '', '', '', 'Arts, Social Sciences, and Humanities'),
(67, 11, '', '', '', 'Arts, Social Sciences, and Humanities'),
(68, 12, '', '', '', 'Business and Entrepreneurship'),
(69, 13, '', '', '', 'Industrial Arts and Maritime'),
(70, 14, '', '', '', 'Business and Entrepreneurship'),
(71, 15, '', '', '', 'STEM'),
(72, 9, 'Software Developer, Data Analyst, Engineer', 'Computer Science, Information Technology, Engineering', 'Academic Track', 'STEM'),
(73, 10, 'Graphic Designer, Animator, Illustrator', 'Fine Arts, Art Studies, Art Education', 'Academic Track', 'Arts, Social Sciences, and Humanities'),
(74, 11, 'Journalist, Teacher, Public Relations Specialist', 'Communication Arts, Education, Public Relations', 'Academic Track', 'Arts, Social Sciences, and Humanities'),
(75, 12, 'Entrepreneur, Marketing Specialist, Accountant', 'Business Administration, Marketing, Accountancy', 'Academic Track', 'Business and Entrepreneurship'),
(76, 13, 'Mechanic, Electrician, Automotive Technician', 'Automotive Technology, Electrical Installation, Mechatronics', 'Technical Professional (TechPro) Track', 'Industrial Arts and Maritime'),
(77, 14, 'Manager, Team Leader, Project Manager', 'Management, Leadership Studies, Business Administration', 'Academic Track', 'Business and Entrepreneurship'),
(78, 15, 'Doctor, Nurse, Pharmacist', 'Medicine, Nursing, Pharmacy', 'Academic Track', 'STEM');

-- --------------------------------------------------------

--
-- Table structure for table `category_results`
--

CREATE TABLE `category_results` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `result_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_results`
--

INSERT INTO `category_results` (`id`, `category_id`, `result_text`) VALUES
(1, 9, 'test'),
(2, 10, ''),
(3, 11, ''),
(4, 12, ''),
(5, 13, ''),
(6, 14, ''),
(7, 15, '');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `grade` int(11) NOT NULL,
  `section` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `grade`, `section`) VALUES
(10, 10, 14);

-- --------------------------------------------------------

--
-- Table structure for table `counseling_records`
--

CREATE TABLE `counseling_records` (
  `id` int(11) NOT NULL,
  `lrn` varchar(20) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `grade_level` varchar(10) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `section` varchar(50) NOT NULL,
  `adviser` varchar(100) NOT NULL,
  `schedule` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `additional_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counseling_records`
--

INSERT INTO `counseling_records` (`id`, `lrn`, `first_name`, `last_name`, `grade_level`, `gender`, `section`, `adviser`, `schedule`, `status`, `is_archived`, `additional_details`) VALUES
(3, '123456789', NULL, NULL, '10', 'M', 'A', 'Mr. Smith', '2025-04-12 15:12:00', 's', 1, NULL),
(4, '112233445', NULL, NULL, '11', 'M', 'C', 'Mr. Dumbledore', '2025-04-12 15:16:00', 'In Progress', 1, 'test edit'),
(5, '123456789', NULL, NULL, '10', 'M', 'A', 'Mr. Smith', '2025-04-12 15:19:00', 'Pending', 1, NULL),
(6, '987654321', NULL, NULL, '9', 'F', 'B', 'Ms. Johnson', '2025-04-12 15:20:00', 'Complete', 1, NULL),
(7, '123456789', NULL, NULL, '10', 'M', 'A', 'Mr. Smith', '2025-04-12 15:50:00', 'Pending', 1, 'sadasd'),
(8, '987654321', NULL, NULL, '9', 'F', 'B', 'Ms. Johnson', '2025-04-01 00:23:00', 'Pending', 1, 'test'),
(9, '', 'hendrix', 'dequins', '11', 'M', 'A', 'Mr. Smith', '2025-04-25 00:28:00', 'Pending', 1, NULL),
(10, '', 'John', 'Doe', '10', '', 'A', 'Mr. Smith', '2025-04-26 00:24:00', 'Pending', 1, NULL),
(11, '', 'John', 'Doe', '10', 'M', 'A', 'Mr. Smith', '2025-04-26 00:45:00', 'Ongoing', 0, NULL),
(12, '123456789', 'John', 'Doe', '10', 'M', 'A', 'Mr. Smith', '2025-06-12 01:28:00', 'Pending', 0, 'ss');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL,
  `grade` varchar(31) NOT NULL,
  `grade_code` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`grade_id`, `grade`, `grade_code`) VALUES
(10, '7', 'JH'),
(11, '8', 'JH'),
(12, '9', 'JH'),
(13, '10', 'JH'),
(14, '11', 'SH'),
(15, '12', 'SH');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `tracking_number` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `sender_full_name` varchar(100) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `is_new` tinyint(1) DEFAULT 1,
  `type_of_request` varchar(255) NOT NULL,
  `feedback` text DEFAULT NULL,
  `admin_message` text DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `tracking_number`, `status`, `sender_full_name`, `sender_email`, `message`, `date_time`, `is_new`, `type_of_request`, `feedback`, `admin_message`, `is_archived`) VALUES
(4, '', 'Pending', 'Hendrix Luigi Arangorin DEQUINA', 'Hendrixluigi@gmail.com', 'd', '2025-02-13 18:41:28', 0, '', NULL, NULL, 0),
(5, '', 'Pending', 'Hendrix Luigi Arangorin DEQUINA', 'Hendrixluigi@gmail.com', 'test', '2025-02-14 20:57:00', 0, '', NULL, NULL, 0),
(6, '', 'Pending', 'Hendrix Luigi Arangorin DEQUINA', 'Hendrixluigi@gmail.com', 's', '2025-02-14 21:02:30', 0, '', NULL, NULL, 0),
(7, '', 'Pending', 'Hendrix Luigi Arangorin DEQUINA', 'Hendrixluigi@gmail.com', 'asdasdasdsad', '2025-02-14 21:02:40', 0, '', NULL, NULL, 0),
(8, '', 'Pending', '123123123123123', 'Hendrixluigi@gmail.com', 'eee', '2025-03-24 12:54:27', 0, 'Request for Certificate', NULL, NULL, 0),
(9, '', 'Pending', 'dasdas', 'Hendrixluigi@gmail.com', 'ddd', '2025-03-24 12:57:13', 0, 'Request Clearance Form', NULL, NULL, 1),
(10, '', 'Pending', '123123123123123', 'Hendrixluigi@gmail.com', 'test', '2025-03-24 12:58:10', 0, 'Request for Certificate', NULL, NULL, 1),
(11, '', 'Pending', 'dasdas', 'Hendrixluigi@gmail.com', 'sssss', '2025-03-25 09:49:31', 0, 'Request Good Moral', NULL, NULL, 1),
(12, '', 'Pending', 'sss', 'Hendrixluigi@gmail.com', 'test', '2025-03-25 09:49:41', 0, 'Request Clearance Form', NULL, NULL, 1),
(13, '', 'Pending', '123123123123123', 'Hendrixluigi@gmail.com', '123123123', '2025-04-01 15:05:29', 0, 'Request Clearance Form', NULL, NULL, 1),
(14, 'REQ-67eca37acd0d0', 'Completed', 'dasdas', 'Hendrixluigi@gmail.com', 'asdasdas', '2025-04-02 10:39:54', 0, 'Request Clearance Form', NULL, NULL, 1),
(15, 'REQ-67eca4cd64131', 'Completed', 'dasdas', 'Hendrixluigi@gmail.com', 'asdasdas', '2025-04-02 10:45:33', 0, 'Request Clearance Form', 'hi', NULL, 1),
(16, '', 'Pending', 'dasdasdddddd', 'Hendrixluigi@gmail.com', '123123', '2025-04-02 11:01:09', 0, 'Request Clearance Form', NULL, NULL, 1),
(17, '', 'Pending', 'daa', 'drix@gmail.com', 'd', '2025-04-02 11:02:16', 0, 'Request Clearance Form', NULL, NULL, 1),
(18, 'REQ-67eca8c1efb6b', 'Pending', '123', 'Hendrixluigi@gmail.com', 'ee', '2025-04-02 11:02:25', 0, 'Request Clearance Form', NULL, NULL, 1),
(19, 'REQ-67eca92c45dbb', 'Completed', 'velocveed', 'Hendrixluigi@gmail.com', '123', '2025-04-02 11:04:12', 0, 'Request Clearance Form', 'asdsa', NULL, 1),
(20, '', 'Pending', 'testaw', 'Hendrixluigi@gmail.com', '123', '2025-04-02 11:06:12', 0, 'Request Clearance Form', NULL, NULL, 1),
(21, '', 'Pending', 'eqweqw111', 'Hendrixluigi@gmail.com', 'eee', '2025-04-02 11:07:38', 0, 'Request Clearance Form', NULL, NULL, 1),
(40, 'REQ-67ef4906e539a', 'Completed', 'test 1050', 'Hendrixluigi@gmail.com', 'concern test', '2025-04-04 10:50:46', 0, 'Send Concern', NULL, 'Respond Test', 0),
(41, 'REQ-67ef492457eb7', 'Pending', 'test 1050', 'Hendrixluigi@gmail.com', 'concern test', '2025-04-04 10:51:16', 0, 'Send Concern', NULL, NULL, 0),
(42, 'REQ-67ef49a7c88d9', 'Pending', 'test 1053', 'Hendrixluigi@gmail.com', 'Good Moral Test', '2025-04-04 10:53:27', 0, 'Request Good Moral', NULL, NULL, 0),
(43, 'REQ-67ef49c09785d', 'Completed', 'Good Moral Test', 'GoodMoralTest@gmail.com', 'Good Moral Test', '2025-04-04 10:53:52', 0, 'Request Good Moral', NULL, 'Admin Message Test 2', 0),
(44, 'REQ-67ef4ffba3de2', 'Completed', 'GANJI', 'Hendrixluigi@gmail.com', 'TEST MORAL GANJI', '2025-04-04 11:20:27', 0, 'Request Good Moral', NULL, 'TEST ADMIN MSSAGETEST ADMIN MSSAGETEST ADMIN MSSAGETEST ADMIN MSSAGETEST ADMIN MSSAGETEST ADMIN MSSAGETEST ADMIN MSSAGETEST ADMIN MSSAGE', 0),
(45, 'REQ-67ef535d52e42', 'Pending', 'test 11 34', 'Hendrixluigi@gmail.com', 'notification test', '2025-04-04 11:34:53', 0, 'Request Clearance Form', NULL, NULL, 0),
(46, 'REQ-67ef53dde90ce', 'Pending', 'TEST 11 36', 'Hendrixluigi@gmail.com', 'Notification Test', '2025-04-04 11:37:01', 0, 'Request Clearance Form', NULL, NULL, 0),
(47, 'REQ-67ef56bf0dbf5', 'Completed', 'TEST 11 49', 'Hendrixluigi@gmail.com', 'TEST NOTIFICATION DASHBOARD AYOKO NA BAI', '2025-04-04 11:49:19', 0, 'Request Temporary Card', NULL, '', 1),
(48, 'REQ-67fca94ccc48f', 'Completed', '09158777437', 'Hendrixluigi@gmail.com', 'Certificate of graduation request\r\nDequina Hendrix Luigi A\r\n202109267', '2025-04-14 14:21:00', 0, 'Request for Certificate', NULL, 'please head to the department', 0),
(49, 'REQ-67fcaac340c52', 'In Progress', '09770877226', 'Hendrixluigi@gmail.com', 'concern test', '2025-04-14 14:27:15', 0, 'Send Concern', NULL, '', 0),
(50, 'REQ-67ffd59e939a8', 'In Progress', '12312312', 'Hendrixluigi@gmail.com', 'eee', '2025-04-17 00:06:54', 0, 'Request Clearance Form', NULL, 'please head to the department', 0),
(51, 'REQ-68060124cf52b', 'Completed', '199393940521', 'Hendrixluigi@gmail.com', 'lrnm test', '2025-04-21 16:26:12', 0, 'Request Clearance Form', NULL, 'okayu', 1),
(52, 'REQ-6808b5b7412f9', 'In Progress', '111111111111', 'Hendrixluigi@gmail.com', 'test', '2025-04-23 17:41:11', 0, 'Request Clearance Form', NULL, 'test admn reply', 0),
(53, 'REQ-680c9e1641626', 'In Progress', '112233445566', 'Hendrixluigi@gmail.com', 'LRN Test', '2025-04-26 16:49:26', 0, 'Request Clearance Form', NULL, '', 0),
(54, 'REQ-680ca1db8d150', 'In Progress', '112233445566', 'Hendrixluigi@gmail.com', 'LRN Test', '2025-04-26 17:05:31', 0, 'Request Clearance Form', NULL, 'send message test', 0),
(55, 'REQ-6842319daae3d', 'Pending', '123456789123', 'Hendrixluigi@gmail.com', 'test', '2025-06-06 08:09:01', 0, 'Request Clearance Form', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `date`) VALUES
(8, 'Congratulations, Dr. Johna Mendez!', 'On behalf of your TNTS Annex family, we are incredibly proud of your remarkable success. Your journey from serving as the SSG Vice President to achieving such great heights is truly inspiring.\r\n\r\nYou are a shining example of dedication and excellence, and your achievements continue to motivate every Annexian to dream big and work hard.❤️❤️❤️', '1741844218492_i7vx9c_2_1 (1).jpg', '2025-03-13 05:50:40'),
(9, 'Division Festival of Talents', 'Congratulations to the Red Cross Club President for winning the Read-a-Thon at the Division Festival of Talents!  Your TNTS Annex family is very proud of you.🎉🎉❤️❤️\r\nhttps://www.facebook.com/share/p/15LdNspDG1/', '1742551037883_sbxyv8_2_1.jpg', '2025-03-13 05:51:28'),
(10, 'Early Registration for Upcoming Grade Sevens', 'Sa mga incoming Grade 7 S.Y 2025 -2026\r\neto po hinihintay ninyo, magpa Early Register na po sa darating na Sabado , January 25, 2025.', '1742550700733_hfa9v6_2_1.jpg', '2025-03-13 05:52:12');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `question_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `category_id`, `question_text`) VALUES
(24, 10, 'I enjoy drawing, painting, or designing things.'),
(25, 10, 'I am passionate about expressing myself through writing, music, or performance arts.'),
(26, 11, 'I enjoy discussing and debating important topics.'),
(27, 11, 'I find it easy to express my thoughts clearly, both in writing and speaking.'),
(28, 12, 'I enjoy finding ways to make money or start a business.'),
(29, 12, 'I like leading a team and making important decisions.'),
(30, 13, 'I enjoy building, fixing, or assembling things.'),
(31, 13, 'I like working with tools, machines, or technology.'),
(32, 14, 'I am confident in making decisions and taking responsibility for outcomes.'),
(33, 14, 'I enjoy organizing events, projects, or teams.'),
(34, 15, 'I am interested in human biology and how the body functions.'),
(35, 15, 'I like the idea of helping people improve their health and well-being.'),
(76, 10, 'I enjoy creating art, music, or writing stories.'),
(77, 10, 'I like experimenting with new ideas and concepts.'),
(78, 10, 'I am passionate about expressing myself through creative outlets.'),
(79, 10, 'I enjoy designing visually appealing projects.'),
(80, 10, 'I find inspiration in exploring different forms of art.'),
(81, 11, 'I enjoy helping others solve their problems.'),
(82, 11, 'I like working in teams and collaborating with others.'),
(83, 11, 'I am interested in understanding how people think and behave.'),
(84, 11, 'I enjoy discussing and debating social issues.'),
(85, 11, 'I feel fulfilled when I can support and guide others.'),
(86, 12, 'I enjoy planning and organizing events or projects.'),
(87, 12, 'I like taking risks and exploring new business opportunities.'),
(88, 12, 'I am interested in learning about finance and investments.'),
(89, 12, 'I enjoy negotiating and persuading others.'),
(90, 12, 'I like leading teams and making strategic decisions.'),
(91, 13, 'I enjoy working with tools and machinery.'),
(92, 13, 'I like building or repairing things with my hands.'),
(93, 13, 'I am interested in learning technical skills.'),
(94, 13, 'I enjoy solving practical problems in creative ways.'),
(95, 13, 'I prefer hands-on work over theoretical tasks.'),
(96, 14, 'I enjoy taking charge and leading others.'),
(97, 14, 'I like organizing and managing projects.'),
(98, 14, 'I am interested in learning about leadership strategies.'),
(99, 14, 'I enjoy making decisions and taking responsibility for outcomes.'),
(100, 14, 'I like inspiring and motivating others to achieve goals.'),
(101, 15, 'I am interested in learning about human anatomy and biology.'),
(102, 15, 'I enjoy helping others improve their health and well-being.'),
(103, 15, 'I like learning about medical advancements and treatments.'),
(104, 15, 'I feel fulfilled when I can provide care and support to others.'),
(105, 15, 'I am interested in pursuing a career in healthcare or social work.'),
(106, 9, 'I enjoy solving puzzles and logical challenges.'),
(107, 9, 'I like analyzing data to find patterns and solutions.'),
(108, 9, 'I am interested in learning about algorithms and programming.'),
(109, 9, 'I enjoy working on tasks that require critical thinking.'),
(110, 9, 'I prefer structured and organized problem-solving tasks.');

-- --------------------------------------------------------

--
-- Table structure for table `question_weights`
--

CREATE TABLE `question_weights` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `weight` float NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_categories`
--

CREATE TABLE `quiz_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `language` varchar(10) DEFAULT 'en'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_categories`
--

INSERT INTO `quiz_categories` (`id`, `name`, `description`, `language`) VALUES
(9, 'Logical & Analytical Thinking', 'Questions related to logical reasoning and problem-solving.', 'en'),
(10, 'Creativity & Artistic Expression', 'Questions related to artistic and creative expression.', 'en'),
(11, 'Social & Communication Skills', 'Questions related to social interaction and communication.', 'en'),
(12, 'Business & Entrepreneurship', 'Questions related to business and entrepreneurial skills.', 'en'),
(13, 'Hands-On & Technical Work', 'Questions related to practical and technical skills.', 'en'),
(14, 'Leadership & Decision-Making', 'Questions related to leadership and decision-making abilities.', 'en'),
(15, 'Healthcare & Service-Oriented Careers', 'Questions related to healthcare and service-oriented careers.', 'en'),
(22, 'Finance', '', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_options`
--

CREATE TABLE `quiz_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `label` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `results` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`results`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `results`, `created_at`) VALUES
(1, '{\"Logical Thinking\": 85, \"Creative Thinking\": 70, \"Social Skills\": 90}', '2025-04-10 05:30:23');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_settings`
--

CREATE TABLE `quiz_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrar_office`
--

CREATE TABLE `registrar_office` (
  `r_user_id` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(31) NOT NULL,
  `lname` varchar(31) NOT NULL,
  `address` varchar(31) NOT NULL,
  `employee_number` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` varchar(31) NOT NULL,
  `qualification` varchar(31) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `date_of_joined` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `section` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section`) VALUES
(14, 'ROSAS'),
(15, 'SAMPAGU'),
(16, 'KAMELYA'),
(17, 'SANTAN'),
(18, 'GUMAMEL');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `current_year` int(11) NOT NULL,
  `current_semester` varchar(11) NOT NULL,
  `school_name` varchar(100) NOT NULL,
  `slogan` varchar(300) NOT NULL,
  `about` text NOT NULL,
  `primary_color` varchar(7) DEFAULT NULL,
  `secondary_color` varchar(7) DEFAULT NULL,
  `font_style` varchar(50) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT NULL,
  `background_color` varchar(7) DEFAULT NULL,
  `school_address` varchar(255) DEFAULT NULL,
  `contact_details` varchar(255) DEFAULT NULL,
  `welcome_message` text DEFAULT NULL,
  `school_logo` varchar(255) DEFAULT NULL,
  `services_description` text DEFAULT NULL,
  `about_background_image` varchar(255) DEFAULT NULL,
  `services_background_image` varchar(255) DEFAULT NULL,
  `news_section_color` varchar(7) DEFAULT '#ffffff',
  `news_section_font_color` varchar(7) DEFAULT '#000000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `current_year`, `current_semester`, `school_name`, `slogan`, `about`, `primary_color`, `secondary_color`, `font_style`, `logo`, `background_image`, `background_color`, `school_address`, `contact_details`, `welcome_message`, `school_logo`, `services_description`, `about_background_image`, `services_background_image`, `news_section_color`, `news_section_font_color`) VALUES
(1, 0, '', 'TANZA NATIONAL TRADE SCHOOL - ANNEX', 'tanza national trade school - annex', '', '#ffffff', '#9f1015', '', NULL, 'bg.jpg', '#eaeaea', '', '', '', 'tntsannexicon.png', '', 'lq5YNa1l (1).jpg', 'lq5YNa1l (1).jpg', '#ffffff', '#000000');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `lrn` varchar(255) NOT NULL,
  `guardian` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `birthplace` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female','N/A') DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `adviser` varchar(255) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `fname`, `lname`, `lrn`, `guardian`, `address`, `birthday`, `birthplace`, `gender`, `grade`, `section`, `adviser`, `class_id`) VALUES
(29, 'Hendrix Luigi', 'DEQUINA', '123456789123', 'Alma Dequina', 'SECTION E BLK 16 LOT 11', '2003-03-12', 'Cavite', 'Male', '11', '16', 'Jane Smith', 10);

-- --------------------------------------------------------

--
-- Table structure for table `student_score`
--

CREATE TABLE `student_score` (
  `id` int(11) NOT NULL,
  `semester` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `results` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_score`
--

INSERT INTO `student_score` (`id`, `semester`, `year`, `student_id`, `teacher_id`, `subject_id`, `results`) VALUES
(1, 'II', 2021, 1, 1, 1, '10 15,15 20,10 10,10 20,30 35'),
(2, 'II', 2023, 1, 1, 4, '15 20,4 5'),
(3, 'I', 2022, 1, 1, 5, '10 20,50 50');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject` varchar(31) NOT NULL,
  `subject_code` varchar(31) NOT NULL,
  `grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject`, `subject_code`, `grade`) VALUES
(9, 'Test course', 'test', 10);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `employee_number` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT 'N/A',
  `qualification` varchar(255) DEFAULT 'N/A',
  `date_of_birth` date DEFAULT NULL,
  `subject` varchar(255) DEFAULT 'N/A',
  `class` varchar(255) DEFAULT 'N/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `fname`, `gender`, `email_address`, `position`, `lname`, `username`, `password`, `address`, `employee_number`, `phone_number`, `qualification`, `date_of_birth`, `subject`, `class`) VALUES
(30, 'Hendrix Luigi', 'Male', 'Hendrixluigi@gmail.com', 'Math Teacher', 'Dequina', '12345', '$2y$10$ctL6ZE9z0nFiDhPhDepKyeqLIWj/3zqZWe8E9Wa1/BlkGazmSkmw2', 'SECTION E BLK 16 LOT 11', 'A12', '58777437', 'BsIT', '2003-03-12', '9', '10');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_invites`
--

CREATE TABLE `teacher_invites` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_invites`
--

INSERT INTO `teacher_invites` (`id`, `email`, `position`, `token`, `expires_at`, `used`) VALUES
(1, 'Hendrixluigi@gmail.com', 'Position Test', '199af050d5b86345bb94b8b7d1f925aecfab52943becd453859eb61ca7f85a6a', '2025-05-18 04:14:09', 0),
(2, 'Hendrixluigi@gmail.com', 'Position Test', 'd65e70055fe5dcdea867874d7ccf4c6b0fc7744555afaa9b22e1305e92341054', '2025-05-18 04:15:49', 0),
(3, 'Hendrixluigi@gmail.com', 'Position Test', 'edaef8b17b3a405df8e774fd6404fdf9f8bd59cab882c1f48d5cc09623705999', '2025-05-18 04:17:07', 1),
(4, 'Hendrixluigi@gmail.com', 'Math Teacher', 'e0350e7be82a2a1abec3d8327c306b8632e5383a15837f5f5ae1096251712c7b', '2025-05-19 20:00:33', 1),
(5, 'Hendrixluigi@gmail.com', 'Math Teacher', 'e81e600ed27ec8236aad8d24e88813a5e6baf2e8b421ec427e92c4b4b25fdb5b', '2025-05-20 01:38:46', 1),
(6, 'Hendrixluigi@gmail.com', 'Math Teacher', '4ab452593936d192c1f0135036c27e871ef89e2d4dcbbc3d76c68cfcf981f9ac', '2025-05-20 01:51:18', 0),
(7, 'Hendrixluigi@gmail.com', 'Math Teacher', '2848260bbacb4da33bf03bdb9d08617c28148b0126f6b978498c3588a0990f3a', '2025-05-20 05:01:31', 1),
(8, 'Hendrixluigi@gmail.com', 'Math Teacher', '50fa230d0b08e0e6662b974831b3b85e0f0e2a0e2768b82ac3d021255e5ea86c', '2025-06-07 17:03:17', 0);

-- --------------------------------------------------------

--
-- Table structure for table `violations_records`
--

CREATE TABLE `violations_records` (
  `id` int(11) NOT NULL,
  `lrn` varchar(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `grade_level` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL,
  `violation` text NOT NULL,
  `offense` enum('1st','2nd','3rd') NOT NULL,
  `type_of_offense` enum('Minor','Major') NOT NULL,
  `sanction` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Pending','Scheduled','Ongoing','Completed','Cancelled','No Show','Rescheduled','Referred','Follow-Up Needed','Closed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `violations_records`
--

INSERT INTO `violations_records` (`id`, `lrn`, `name`, `grade_level`, `section`, `violation`, `offense`, `type_of_offense`, `sanction`, `date`, `status`, `created_at`, `updated_at`) VALUES
(2, '987654321', 'Mary Jane', '9', 'B', '7. Extortion, blackmail, or theft.', '1st', 'Major', '1-Day Suspension', '2025-08-13', 'Ongoing', '2025-04-26 09:37:16', '2025-04-26 09:37:16'),
(4, '112233445566', 'Harry Potter', '11', 'C', '8. Gambling or betting within campus.', '1st', 'Minor', '1-Day Suspension', '2025-04-26', 'Scheduled', '2025-04-26 09:44:16', '2025-04-26 09:44:16'),
(5, '123456789123', 'Hendrix Luigi DEQUINA', '11', '16', '6. Any form of cheating.', '1st', 'Minor', '1-Day Suspension', '2025-04-08', 'Pending', '2025-06-06 15:15:20', '2025-06-06 15:15:20');

-- --------------------------------------------------------

--
-- Table structure for table `website_visits`
--

CREATE TABLE `website_visits` (
  `id` int(11) NOT NULL,
  `visit_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_visits`
--

INSERT INTO `website_visits` (`id`, `visit_time`) VALUES
(1, '2025-04-14 06:10:21'),
(2, '2025-04-14 06:10:21'),
(3, '2025-04-14 06:10:21'),
(4, '2025-04-14 06:19:19'),
(5, '2025-04-14 06:19:24'),
(6, '2025-04-14 06:19:29'),
(7, '2025-04-14 06:19:39'),
(8, '2025-04-16 07:05:50'),
(9, '2025-04-16 07:12:50'),
(10, '2025-04-16 07:13:09'),
(11, '2025-04-16 07:13:13'),
(12, '2025-04-16 07:22:37'),
(13, '2025-04-16 07:29:06'),
(14, '2025-04-16 07:29:16'),
(15, '2025-04-16 07:41:56'),
(16, '2025-04-16 07:42:03'),
(17, '2025-04-16 07:42:24'),
(18, '2025-04-16 07:42:32'),
(19, '2025-04-16 07:42:45'),
(20, '2025-04-16 07:55:39'),
(21, '2025-04-16 07:55:44'),
(22, '2025-04-16 07:57:55'),
(23, '2025-04-16 07:57:56'),
(24, '2025-04-16 07:58:00'),
(25, '2025-04-16 08:03:25'),
(26, '2025-04-16 08:03:32'),
(27, '2025-04-16 08:07:46'),
(28, '2025-04-16 08:09:17'),
(29, '2025-04-16 08:09:24'),
(30, '2025-04-16 08:11:04'),
(31, '2025-04-16 08:56:29'),
(32, '2025-04-16 09:09:37'),
(33, '2025-04-16 16:06:32'),
(34, '2025-04-16 16:17:55'),
(35, '2025-04-16 16:19:12'),
(36, '2025-04-16 16:34:01'),
(37, '2025-04-16 16:34:57'),
(38, '2025-04-16 23:59:21'),
(39, '2025-04-19 06:51:30'),
(40, '2025-04-20 01:07:22'),
(41, '2025-04-20 01:07:40'),
(42, '2025-04-20 02:22:31'),
(43, '2025-04-21 01:43:43'),
(44, '2025-04-21 10:09:42'),
(45, '2025-04-22 15:08:45'),
(46, '2025-04-23 07:28:16'),
(47, '2025-04-23 09:25:54'),
(48, '2025-04-23 09:40:08'),
(49, '2025-04-23 09:40:32'),
(50, '2025-04-23 09:40:43'),
(51, '2025-04-24 10:09:28'),
(52, '2025-04-24 11:08:42'),
(53, '2025-04-24 14:10:44'),
(54, '2025-04-24 15:36:29'),
(55, '2025-04-25 16:11:37'),
(56, '2025-04-26 08:31:34'),
(57, '2025-04-26 08:43:14'),
(58, '2025-04-26 10:10:24'),
(59, '2025-04-28 08:54:45'),
(60, '2025-05-07 17:40:57'),
(61, '2025-05-07 17:43:31'),
(62, '2025-05-07 18:10:32'),
(63, '2025-05-07 18:12:15'),
(64, '2025-05-08 08:04:43'),
(65, '2025-05-08 08:06:37'),
(66, '2025-05-08 08:09:37'),
(67, '2025-05-08 08:13:16'),
(68, '2025-05-08 08:17:18'),
(69, '2025-05-08 18:15:30'),
(70, '2025-05-08 18:52:23'),
(71, '2025-05-08 19:44:48'),
(72, '2025-05-12 22:46:31'),
(73, '2025-05-13 22:55:39'),
(74, '2025-05-13 22:56:21'),
(75, '2025-05-13 22:56:41'),
(76, '2025-05-16 21:30:51'),
(77, '2025-05-16 22:36:01'),
(78, '2025-05-17 01:30:47'),
(79, '2025-05-17 01:30:50'),
(80, '2025-05-17 01:31:53'),
(81, '2025-05-17 01:52:27'),
(82, '2025-05-18 17:52:45'),
(83, '2025-05-18 23:31:25'),
(84, '2025-06-05 23:31:02'),
(85, '2025-06-05 23:31:56'),
(86, '2025-06-05 23:37:06'),
(87, '2025-06-06 15:12:22'),
(88, '2025-06-06 15:36:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_boxes`
--
ALTER TABLE `about_boxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `career_suggestions`
--
ALTER TABLE `career_suggestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_results`
--
ALTER TABLE `category_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `counseling_records`
--
ALTER TABLE `counseling_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_ibfk_1` (`category_id`);

--
-- Indexes for table `question_weights`
--
ALTER TABLE `question_weights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_categories`
--
ALTER TABLE `quiz_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_options`
--
ALTER TABLE `quiz_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_settings`
--
ALTER TABLE `quiz_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrar_office`
--
ALTER TABLE `registrar_office`
  ADD PRIMARY KEY (`r_user_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_score`
--
ALTER TABLE `student_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `teacher_invites`
--
ALTER TABLE `teacher_invites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `violations_records`
--
ALTER TABLE `violations_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `website_visits`
--
ALTER TABLE `website_visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_boxes`
--
ALTER TABLE `about_boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `career_suggestions`
--
ALTER TABLE `career_suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `category_results`
--
ALTER TABLE `category_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `counseling_records`
--
ALTER TABLE `counseling_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `question_weights`
--
ALTER TABLE `question_weights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_categories`
--
ALTER TABLE `quiz_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `quiz_options`
--
ALTER TABLE `quiz_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_settings`
--
ALTER TABLE `quiz_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrar_office`
--
ALTER TABLE `registrar_office`
  MODIFY `r_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `student_score`
--
ALTER TABLE `student_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `teacher_invites`
--
ALTER TABLE `teacher_invites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `violations_records`
--
ALTER TABLE `violations_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `website_visits`
--
ALTER TABLE `website_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_results`
--
ALTER TABLE `category_results`
  ADD CONSTRAINT `category_results_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `quiz_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `quiz_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_weights`
--
ALTER TABLE `question_weights`
  ADD CONSTRAINT `question_weights_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_options`
--
ALTER TABLE `quiz_options`
  ADD CONSTRAINT `quiz_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `quiz_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
