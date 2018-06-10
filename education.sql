-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 10, 2018 lúc 10:29 AM
-- Phiên bản máy phục vụ: 10.1.31-MariaDB
-- Phiên bản PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `education`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class`
--

CREATE TABLE `class` (
  `id` bigint(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `course` bigint(20) NOT NULL,
  `supervisor` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `class`
--

INSERT INTO `class` (`id`, `start_date`, `end_date`, `course`, `supervisor`) VALUES
(1, '2018-03-06', '2018-06-01', 1, NULL),
(15, '2018-05-08', '2019-05-07', 1, 4),
(18, '2018-05-08', '2019-05-07', 1, 4),
(20, '2018-05-09', '2018-11-14', 5, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course`
--

CREATE TABLE `course` (
  `id` bigint(20) NOT NULL,
  `name` char(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `subject` bigint(20) NOT NULL,
  `price` bigint(20) NOT NULL,
  `certificate_required` bigint(20) DEFAULT NULL,
  `total_of_period` bigint(20) NOT NULL,
  `description` varchar(1000) CHARACTER SET utf32 COLLATE utf32_unicode_ci DEFAULT NULL,
  `img_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `teaching_assistant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `course`
--

INSERT INTO `course` (`id`, `name`, `subject`, `price`, `certificate_required`, `total_of_period`, `description`, `img_url`, `teaching_assistant`) VALUES
(1, 'English for fresher', 1, 5000000, NULL, 50, 'Cras ultricies ligula sed magna dictum porta. Proin eget tortor risus. Donec rutrum congue leo eget malesuada. Cras ultricies ligula sed magna dictum porta. Nulla porttitor accumsan tincidunt. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem.', './img/course/1.jpg', 2),
(2, 'English for fresher 2', 1, 2000000, 1, 60, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ultricies ligula sed magna dictum porta. Vivamus suscipit tortor eget felis porttitor volutpat. Sed porttitor lectus nibh. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', './img/course/2.jpg', NULL),
(3, 'English for fresher 3', 1, 3000000, 2, 20, 'Vivamus suscipit tortor eget felis porttitor volutpat. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Cras ultricies ligula sed magna dictum porta. Cras ultricies ligula sed magna dictum porta. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.', './img/course/3.jpg', NULL),
(4, 'Basic Maths', 2, 2000000, NULL, 30, 'Vivamus suscipit tortor eget felis porttitor volutpat. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Cras ultricies ligula sed magna dictum porta. Cras ultricies ligula sed magna dictum porta. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.', './img/course/4.jpg', NULL),
(5, 'Advance Maths', 2, 3000000, 4, 50, 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Nulla porttitor accumsan tincidunt. Donec sollicitudin molestie malesuada. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet quam id dui posuere blandit.', './img/course/5.jpg', NULL),
(6, 'Art for beginer', 3, 6000000, NULL, 30, 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Nulla porttitor accumsan tincidunt. Donec sollicitudin molestie malesuada. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet quam id dui posuere blandit.', './img/course/6.jpg', 2),
(7, 'Piano', 4, 6000000, 9, 40, 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Nulla porttitor accumsan tincidunt. Donec sollicitudin molestie malesuada. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet quam id dui posuere blandit.', './img/course/7.jpg', 1),
(8, 'Guitar', 4, 4000000, 9, 30, 'Vivamus suscipit tortor eget felis porttitor volutpat. Vivamus suscipit tortor eget felis porttitor volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Pellentesque in ipsum id orci porta dapibus. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.', './img/course/8.jpg', 1),
(9, 'Music Theory', 4, 600000, NULL, 60, 'Vivamus suscipit tortor eget felis porttitor volutpat. Vivamus suscipit tortor eget felis porttitor volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Pellentesque in ipsum id orci porta dapibus. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.', './img/course/9.jpg', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_room`
--

CREATE TABLE `course_room` (
  `id` bigint(20) NOT NULL,
  `course` bigint(20) NOT NULL,
  `room` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `course_room`
--

INSERT INTO `course_room` (`id`, `course`, `room`) VALUES
(1, 5, 1),
(2, 4, 1),
(3, 8, 2),
(4, 7, 2),
(5, 1, 3),
(6, 2, 3),
(7, 3, 4),
(8, 1, 4),
(9, 9, 5),
(10, 8, 5),
(11, 4, 6),
(12, 5, 6),
(13, 7, 7),
(14, 8, 7),
(15, 6, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_ta`
--

CREATE TABLE `course_ta` (
  `course` bigint(20) NOT NULL,
  `TA` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `course_ta`
--

INSERT INTO `course_ta` (`course`, `TA`) VALUES
(1, 4),
(2, 4),
(3, 4),
(1, 7),
(2, 7),
(3, 7),
(9, 9),
(8, 9),
(7, 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_teacher`
--

CREATE TABLE `course_teacher` (
  `course` bigint(20) NOT NULL,
  `teacher` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `course_teacher`
--

INSERT INTO `course_teacher` (`course`, `teacher`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 2),
(3, 2),
(4, 1),
(4, 6),
(5, 1),
(5, 6),
(6, 5),
(7, 4),
(8, 4),
(9, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employee`
--

CREATE TABLE `employee` (
  `id` bigint(20) NOT NULL,
  `name` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` char(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) NOT NULL,
  `mail` char(100) NOT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `employee`
--

INSERT INTO `employee` (`id`, `name`, `address`, `phone`, `mail`, `birthday`) VALUES
(1, 'Tran Phong Phu', '113 Ky Con, Phuong Nguyen Thai Binh, Quan 1, TP Ho Chi Minh', '09056421560', 'phutp@gmail.com', '1945-04-25'),
(2, 'Nguyen Thi Hanh', 'So 31 Nguyen Van Giai, Phuong Da Kao, Quan 1, TP Ho Chi Minh', '1236546794', 'hanhtn@gmail.com', NULL),
(3, 'Dương Vũ Thông', 'test', '0986781993', 'anhnguBen@gmail.com', '1993-01-13'),
(4, 'Tran Binh Trong', 'So 31 Nguyen Van Giai, Phuong Da Kao, Quan 1, TP Ho Chi Minh', '11111111', 'test@gmail.com', '1993-01-13'),
(5, 'Nguyen Thi Ai Nhi', 'So 15 Nguyen Giai, Phuong Binh Tho, Quan Thu Duc, TP Ho Chi Minh', '166231567', 'nhiatn@gmail.com', NULL),
(6, 'Ho Minh Nha', '270A-Ly Thuong Kiet, P14, Q10, TPHCM', '01662319176', 'minhnha93@gmai.com', '1993-09-18'),
(7, 'Ho Minh Tin', '270 Lac Long Quan, Q10, TPHCM', '01235487125', 'tinkhung11@gmail.com', '1994-05-01'),
(8, 'Nguyen Thi Mai', 'TP Ho Chi Minha', '016654227', 'mainguyen@gmail.com', '1990-08-08'),
(9, 'Vuong A Tu', '199 Dien Bien Phu, P14, Q15, TPHCM', '01663453', 'minhnha91@gmail.com', '1989-05-22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam`
--

CREATE TABLE `exam` (
  `id` bigint(20) NOT NULL,
  `register` bigint(20) NOT NULL,
  `score` bigint(20) NOT NULL,
  `teacher_feedback` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `supervisor_feedback` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `result` set('Pass','Fail','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `exam`
--

INSERT INTO `exam` (`id`, `register`, `score`, `teacher_feedback`, `supervisor_feedback`, `result`) VALUES
(12, 30, 5, 'Lười học', 'Đi học đều', 'Pass'),
(15, 29, 4, 'Học rất ngu', 'Lười đi học', 'Fail'),
(16, 28, 6, 'Học chưa tốt', NULL, 'Pass'),
(20, 31, 1, 'Yếu kém', NULL, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `main_teacher`
--

CREATE TABLE `main_teacher` (
  `id` bigint(20) NOT NULL,
  `degree` char(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `main_teacher`
--

INSERT INTO `main_teacher` (`id`, `degree`) VALUES
(1, 'Professor'),
(2, 'Senior Lecturer'),
(3, 'aa'),
(4, 'Musician'),
(5, 'Artist'),
(6, 'Master of Maths');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `office`
--

CREATE TABLE `office` (
  `id` bigint(20) NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` bigint(20) NOT NULL,
  `mail` char(100) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `office`
--

INSERT INTO `office` (`id`, `address`, `location`, `phone`, `mail`, `name`) VALUES
(1, 'Trung Tam Anh Ngu B.E.N, Le Dai Hanh, phuong 15, Quan 11, Ho Chi Minh', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5468212243677!2d106.65046171480061!3d10.769366892326317!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752e9552b97111%3A0x3e81a87c9948d39e!2zVHJ1bmcgVMOibSBBbmggTmfhu68gQkVO!5e0!3m2!1svi!2s!4v1528255517795\" width=\"500\" height=\"300\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 1332546548, 'anhnguBen@gmail.com', 'Trung Tam Anh Ngu B.E.N'),
(2, 'Trung Tam Ve Sang Tao Wow Art Quan 11 Lac Long Quan phuong 10 Tan Binh Ho Chi Minh', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62712.83486721857!2d106.63586513955914!3d10.768955106642673!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752e90cb12a473%3A0x4a615d2ca3247431!2zVHJ1bmcgVMOibSBW4bq9IFPDoW5nIFThuqFvIFdvdyBBcnQgUXXhuq1uIDEx!5e0!3m2!1svi!2s!4v1528255787880\" width=\"500\" height=\"300\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 166326414, 'wowart@gmail.com', 'Trung Tam Ve Sang Tao Wow Art'),
(3, 'Trung Tam Am Nhac FASOL Luy Ban Bich Tan Thoi Hoa Tan Phu Ho Chi Minh', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.57922474091!2d106.6297982148007!3d10.766876292327991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752e9e6035f40d%3A0x42fb1314b4fbf63c!2zVHJ1bmcgVMOibSDDgm0gTmjhuqFjIEZBU09M!5e0!3m2!1svi!2s!4v1528255822349\" width=\"500\" height=\"300\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 91564856, 'fasolmusic@gmail.com', 'Trung Tam Am Nhac FASOL'),
(4, 'Trung tam toan TITAN EDUCATION Mac Dinh Chi Da Kao Quan 1 Ho Chi Minh', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.2994894715684!2d106.69361651480081!3d10.788358592313465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f499401b65b%3A0x8978b8f612b5e3b6!2sTrung+t%C3%A2m+to%C3%A1n+TITAN+EDUCATION!5e0!3m2!1svi!2s!4v1528255841547\" width=\"500\" height=\"300\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>', 904221635, 'titaneducation@gmail.com', 'Trung tam toan TITAN EDUCATION');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `office_main_teacher`
--

CREATE TABLE `office_main_teacher` (
  `id` bigint(20) NOT NULL,
  `teacher` bigint(20) NOT NULL,
  `office` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `office_main_teacher`
--

INSERT INTO `office_main_teacher` (`id`, `teacher`, `office`) VALUES
(1, 5, 2),
(2, 4, 3),
(3, 1, 4),
(4, 2, 1),
(5, 1, 1),
(6, 1, 3),
(7, 6, 4),
(9, 3, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `office_ta`
--

CREATE TABLE `office_ta` (
  `id` bigint(20) NOT NULL,
  `teaching_assistant` bigint(20) NOT NULL,
  `office` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `office_ta`
--

INSERT INTO `office_ta` (`id`, `teaching_assistant`, `office`) VALUES
(1, 4, 1),
(2, 7, 1),
(3, 9, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `office_worker`
--

CREATE TABLE `office_worker` (
  `id` bigint(20) NOT NULL,
  `position` bigint(20) NOT NULL,
  `office` bigint(20) NOT NULL,
  `experience` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `office_worker`
--

INSERT INTO `office_worker` (`id`, `position`, `office`, `experience`) VALUES
(3, 1, 2, 1),
(4, 1, 1, 1),
(8, 1, 4, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `position`
--

CREATE TABLE `position` (
  `id` bigint(20) NOT NULL,
  `name` char(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `salary` bigint(20) NOT NULL,
  `rate_salary` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `position`
--

INSERT INTO `position` (`id`, `name`, `salary`, `rate_salary`) VALUES
(1, 'Class Supervisor', 5000000, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotion`
--

CREATE TABLE `promotion` (
  `code` varchar(20) NOT NULL,
  `benefit` tinyint(3) UNSIGNED NOT NULL,
  `course` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `promotion`
--

INSERT INTO `promotion` (`code`, `benefit`, `course`) VALUES
('eng50', 50, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `register`
--

CREATE TABLE `register` (
  `id` bigint(20) NOT NULL,
  `class` bigint(20) NOT NULL,
  `promotion` varchar(20) DEFAULT NULL,
  `user` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `register`
--

INSERT INTO `register` (`id`, `class`, `promotion`, `user`, `created_date`) VALUES
(28, 1, NULL, 1, '2018-05-15 10:21:02'),
(29, 20, NULL, 2, '2018-05-25 16:31:08'),
(30, 1, NULL, 2, '2018-05-25 16:32:10'),
(31, 15, NULL, 2, '2018-05-25 21:55:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room`
--

CREATE TABLE `room` (
  `id` bigint(20) NOT NULL,
  `office` bigint(20) NOT NULL,
  `max_student` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `room`
--

INSERT INTO `room` (`id`, `office`, `max_student`) VALUES
(1, 4, 50),
(2, 3, 30),
(3, 1, 40),
(4, 1, 30),
(5, 3, 60),
(6, 4, 45),
(7, 2, 35),
(8, 2, 30);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_schedule`
--

CREATE TABLE `room_schedule` (
  `id` bigint(20) NOT NULL,
  `class` bigint(20) NOT NULL,
  `schedule` bigint(20) NOT NULL,
  `current_date` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Sartuday','Sunday') NOT NULL,
  `teacher` bigint(20) NOT NULL,
  `room` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `room_schedule`
--

INSERT INTO `room_schedule` (`id`, `class`, `schedule`, `current_date`, `teacher`, `room`) VALUES
(1, 1, 1, 'Monday', 1, 3),
(2, 1, 2, 'Wednesday', 1, 4),
(14, 15, 1, 'Wednesday', 1, 3),
(17, 18, 1, 'Thursday', 1, 3),
(20, 20, 1, 'Wednesday', 6, 1),
(21, 20, 4, 'Thursday', 6, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_ta`
--

CREATE TABLE `room_ta` (
  `id` bigint(20) NOT NULL,
  `TA` bigint(20) NOT NULL,
  `room_schedule` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `room_ta`
--

INSERT INTO `room_ta` (`id`, `TA`, `room_schedule`) VALUES
(1, 4, 1),
(4, 4, 17),
(5, 7, 17);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `schedule`
--

CREATE TABLE `schedule` (
  `id` bigint(20) NOT NULL,
  `slot_in_day` bigint(20) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `schedule`
--

INSERT INTO `schedule` (`id`, `slot_in_day`, `start_time`, `end_time`) VALUES
(1, 1, '07:00:00', '09:00:00'),
(2, 2, '09:00:00', '11:00:00'),
(3, 3, '13:00:00', '15:00:00'),
(4, 4, '15:00:00', '17:00:00'),
(5, 5, '17:00:00', '19:00:00'),
(6, 6, '19:00:00', '21:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student_level`
--

CREATE TABLE `student_level` (
  `id` int(11) NOT NULL,
  `course` bigint(20) NOT NULL,
  `member` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `student_level`
--

INSERT INTO `student_level` (`id`, `course`, `member`) VALUES
(1, 1, 1),
(3, 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subject`
--

CREATE TABLE `subject` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `subject`
--

INSERT INTO `subject` (`id`, `name`, `description`, `img`) VALUES
(1, 'Anh văn', 'English for everyone', './img/subject/1.jpg'),
(2, 'Toán', 'Maths for everyone', './img/subject/2.jpg'),
(3, 'Mỹ thuật', 'Fine Art for everyone', './img/subject/3.jpg'),
(4, 'Âm nhạc', 'Music for everyone', './img/subject/4.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teacher_dayoff`
--

CREATE TABLE `teacher_dayoff` (
  `id` bigint(20) NOT NULL,
  `backup_teacher` bigint(20) DEFAULT NULL,
  `date` date NOT NULL,
  `room_schedule` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `teacher_dayoff`
--

INSERT INTO `teacher_dayoff` (`id`, `backup_teacher`, `date`, `room_schedule`) VALUES
(1, NULL, '2018-06-13', 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teaching_assistant`
--

CREATE TABLE `teaching_assistant` (
  `id` bigint(20) NOT NULL,
  `degree` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `teaching_assistant`
--

INSERT INTO `teaching_assistant` (`id`, `degree`) VALUES
(4, 'Master of assistant'),
(7, 'College'),
(9, 'College');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teaching_offset`
--

CREATE TABLE `teaching_offset` (
  `id` bigint(20) NOT NULL,
  `teacher_dayoff` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `room_schedule` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `teaching_offset`
--

INSERT INTO `teaching_offset` (`id`, `teacher_dayoff`, `date`, `room_schedule`) VALUES
(1, 1, '2019-05-01', 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','member','teacher','ta') NOT NULL DEFAULT 'member',
  `avatar` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teacher` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `avatar`, `remember_token`, `created_at`, `updated_at`, `teacher`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$k70eXjqMBJRqSbQOC4TXIepNCHPn16G9qgvVwOoxpYy2PLhtAXhgW', 'admin', './img/user/1.png', 'SpiAtOmUKSmwUphQAzuWMFybpUp4yUIOs1S3xTHz9e6oK9Rb9qJfhwk2oNhk', '2018-03-16 02:49:36', '2018-03-16 02:49:36', NULL),
(2, 'Ho Minh Nha', 'minhnha9z@gmail.com', '$2y$10$OEqomicQymWMLknNUyqAa.QNAmR2owCmxp9z13eMipl3ejYqnMRf6', 'member', './img/user/2.jpg', 'Q8FtW7Uu5NhZyzvBLqD038AeNTwSmmqcZljUmBXx2HLWLsyUwb1AMxKkRhRf', NULL, NULL, NULL),
(5, 'Teacher', 'teacher@gmail.com', '$2y$10$KIJY16Dlgxc0nVUV5j6VTOIG8ur.b0H3fkFEyEqF6lQnpUk4l1Q12', 'teacher', './img/user/5.jpg', '2FhtZycWbmBmwoirnsMooNKuKom6Xn5E85nQqmY4fDUPr6iauyjXhmUxtn37', NULL, NULL, 1),
(6, 'Dương Vũ Thông', 'anhnguBen@gmail.com', '$2y$10$UAbMrnRN/YgRNIafrMA6Re8nvxW2WP0vKlW4vGAJWIZJkSKYODyo6', 'teacher', NULL, NULL, NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Class_fk0` (`course`),
  ADD KEY `Class_fk1` (`supervisor`);

--
-- Chỉ mục cho bảng `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Course_fk0` (`subject`),
  ADD KEY `Course_fk1` (`certificate_required`);

--
-- Chỉ mục cho bảng `course_room`
--
ALTER TABLE `course_room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_room_fk0` (`course`),
  ADD KEY `course_room_fk1` (`room`);

--
-- Chỉ mục cho bảng `course_ta`
--
ALTER TABLE `course_ta`
  ADD KEY `course_TA_fk0` (`course`),
  ADD KEY `course_TA_fk1` (`TA`);

--
-- Chỉ mục cho bảng `course_teacher`
--
ALTER TABLE `course_teacher`
  ADD PRIMARY KEY (`course`,`teacher`),
  ADD KEY `course_teacher_fk1` (`teacher`);

--
-- Chỉ mục cho bảng `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `register` (`register`),
  ADD KEY `Exam_fk0` (`register`);

--
-- Chỉ mục cho bảng `main_teacher`
--
ALTER TABLE `main_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `office_main_teacher`
--
ALTER TABLE `office_main_teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `office_main_teacher_fk0` (`teacher`),
  ADD KEY `office_main_teacher_fk1` (`office`);

--
-- Chỉ mục cho bảng `office_ta`
--
ALTER TABLE `office_ta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `office_TA_fk0` (`teaching_assistant`),
  ADD KEY `office_TA_fk1` (`office`);

--
-- Chỉ mục cho bảng `office_worker`
--
ALTER TABLE `office_worker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Office Worker_fk1` (`position`),
  ADD KEY `Office Worker_fk2` (`office`);

--
-- Chỉ mục cho bảng `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`code`),
  ADD KEY `course` (`course`);

--
-- Chỉ mục cho bảng `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Register_fk0` (`class`),
  ADD KEY `Register_fk2` (`user`),
  ADD KEY `promotion` (`promotion`);

--
-- Chỉ mục cho bảng `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Room_fk0` (`office`);

--
-- Chỉ mục cho bảng `room_schedule`
--
ALTER TABLE `room_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_schedule_fk0` (`class`),
  ADD KEY `room_schedule_fk1` (`schedule`),
  ADD KEY `room_schedule_fk2` (`teacher`),
  ADD KEY `room_schedule_fk3` (`room`);

--
-- Chỉ mục cho bảng `room_ta`
--
ALTER TABLE `room_ta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_TA_fk0` (`TA`),
  ADD KEY `room_TA_fk1` (`room_schedule`);

--
-- Chỉ mục cho bảng `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `student_level`
--
ALTER TABLE `student_level`
  ADD PRIMARY KEY (`id`),
  ADD KEY `studen_level_fk01` (`course`),
  ADD KEY `studen_level_fk02` (`member`);

--
-- Chỉ mục cho bảng `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `teacher_dayoff`
--
ALTER TABLE `teacher_dayoff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_backup_fk0` (`room_schedule`),
  ADD KEY `teacher_backup_fk1` (`backup_teacher`);

--
-- Chỉ mục cho bảng `teaching_assistant`
--
ALTER TABLE `teaching_assistant`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `teaching_offset`
--
ALTER TABLE `teaching_offset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_dayoff` (`teacher_dayoff`),
  ADD KEY `room_schedule` (`room_schedule`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_fk0` (`teacher`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `class`
--
ALTER TABLE `class`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `course`
--
ALTER TABLE `course`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `course_room`
--
ALTER TABLE `course_room`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `employee`
--
ALTER TABLE `employee`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `exam`
--
ALTER TABLE `exam`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `main_teacher`
--
ALTER TABLE `main_teacher`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `office`
--
ALTER TABLE `office`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `office_main_teacher`
--
ALTER TABLE `office_main_teacher`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `office_ta`
--
ALTER TABLE `office_ta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `office_worker`
--
ALTER TABLE `office_worker`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `position`
--
ALTER TABLE `position`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `register`
--
ALTER TABLE `register`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `room`
--
ALTER TABLE `room`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `room_schedule`
--
ALTER TABLE `room_schedule`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `room_ta`
--
ALTER TABLE `room_ta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `student_level`
--
ALTER TABLE `student_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `subject`
--
ALTER TABLE `subject`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `teacher_dayoff`
--
ALTER TABLE `teacher_dayoff`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `teaching_assistant`
--
ALTER TABLE `teaching_assistant`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `teaching_offset`
--
ALTER TABLE `teaching_offset`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `Class_fk0` FOREIGN KEY (`course`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `Class_fk1` FOREIGN KEY (`supervisor`) REFERENCES `office_worker` (`id`);

--
-- Các ràng buộc cho bảng `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `Course_fk0` FOREIGN KEY (`subject`) REFERENCES `subject` (`id`),
  ADD CONSTRAINT `Course_fk1` FOREIGN KEY (`certificate_required`) REFERENCES `course` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `course_room`
--
ALTER TABLE `course_room`
  ADD CONSTRAINT `course_room_fk0` FOREIGN KEY (`course`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_room_fk1` FOREIGN KEY (`room`) REFERENCES `room` (`id`);

--
-- Các ràng buộc cho bảng `course_ta`
--
ALTER TABLE `course_ta`
  ADD CONSTRAINT `course_TA_fk0` FOREIGN KEY (`course`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_TA_fk1` FOREIGN KEY (`TA`) REFERENCES `teaching_assistant` (`id`);

--
-- Các ràng buộc cho bảng `course_teacher`
--
ALTER TABLE `course_teacher`
  ADD CONSTRAINT `course_teacher_fk0` FOREIGN KEY (`course`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_teacher_fk1` FOREIGN KEY (`teacher`) REFERENCES `main_teacher` (`id`);

--
-- Các ràng buộc cho bảng `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `Exam_fk0` FOREIGN KEY (`register`) REFERENCES `register` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `main_teacher`
--
ALTER TABLE `main_teacher`
  ADD CONSTRAINT `Main Teacher_fk0` FOREIGN KEY (`id`) REFERENCES `employee` (`id`);

--
-- Các ràng buộc cho bảng `office_main_teacher`
--
ALTER TABLE `office_main_teacher`
  ADD CONSTRAINT `office_main_teacher_fk0` FOREIGN KEY (`teacher`) REFERENCES `main_teacher` (`id`),
  ADD CONSTRAINT `office_main_teacher_fk1` FOREIGN KEY (`office`) REFERENCES `office` (`id`);

--
-- Các ràng buộc cho bảng `office_ta`
--
ALTER TABLE `office_ta`
  ADD CONSTRAINT `office_TA_fk0` FOREIGN KEY (`teaching_assistant`) REFERENCES `teaching_assistant` (`id`),
  ADD CONSTRAINT `office_TA_fk1` FOREIGN KEY (`office`) REFERENCES `office` (`id`);

--
-- Các ràng buộc cho bảng `office_worker`
--
ALTER TABLE `office_worker`
  ADD CONSTRAINT `Office Worker_fk0` FOREIGN KEY (`id`) REFERENCES `employee` (`id`),
  ADD CONSTRAINT `Office Worker_fk1` FOREIGN KEY (`position`) REFERENCES `position` (`id`),
  ADD CONSTRAINT `Office Worker_fk2` FOREIGN KEY (`office`) REFERENCES `office` (`id`);

--
-- Các ràng buộc cho bảng `promotion`
--
ALTER TABLE `promotion`
  ADD CONSTRAINT `promotion_ibfk_1` FOREIGN KEY (`course`) REFERENCES `course` (`id`);

--
-- Các ràng buộc cho bảng `register`
--
ALTER TABLE `register`
  ADD CONSTRAINT `Register_fk0` FOREIGN KEY (`class`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Register_fk2` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `register_ibfk_1` FOREIGN KEY (`promotion`) REFERENCES `promotion` (`code`);

--
-- Các ràng buộc cho bảng `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `Room_fk0` FOREIGN KEY (`office`) REFERENCES `office` (`id`);

--
-- Các ràng buộc cho bảng `room_schedule`
--
ALTER TABLE `room_schedule`
  ADD CONSTRAINT `room_schedule_fk0` FOREIGN KEY (`class`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_schedule_fk1` FOREIGN KEY (`schedule`) REFERENCES `schedule` (`id`),
  ADD CONSTRAINT `room_schedule_fk2` FOREIGN KEY (`teacher`) REFERENCES `main_teacher` (`id`),
  ADD CONSTRAINT `room_schedule_fk3` FOREIGN KEY (`room`) REFERENCES `room` (`id`);

--
-- Các ràng buộc cho bảng `room_ta`
--
ALTER TABLE `room_ta`
  ADD CONSTRAINT `room_TA_fk0` FOREIGN KEY (`TA`) REFERENCES `teaching_assistant` (`id`),
  ADD CONSTRAINT `room_TA_fk1` FOREIGN KEY (`room_schedule`) REFERENCES `room_schedule` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `student_level`
--
ALTER TABLE `student_level`
  ADD CONSTRAINT `studen_level_fk01` FOREIGN KEY (`course`) REFERENCES `course` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `studen_level_fk02` FOREIGN KEY (`member`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `teacher_dayoff`
--
ALTER TABLE `teacher_dayoff`
  ADD CONSTRAINT `teacher_backup_fk0` FOREIGN KEY (`room_schedule`) REFERENCES `room_schedule` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_backup_fk1` FOREIGN KEY (`backup_teacher`) REFERENCES `employee` (`id`);

--
-- Các ràng buộc cho bảng `teaching_assistant`
--
ALTER TABLE `teaching_assistant`
  ADD CONSTRAINT `Teaching Assistant_fk0` FOREIGN KEY (`id`) REFERENCES `employee` (`id`);

--
-- Các ràng buộc cho bảng `teaching_offset`
--
ALTER TABLE `teaching_offset`
  ADD CONSTRAINT `teaching_offset_ibfk_3` FOREIGN KEY (`teacher_dayoff`) REFERENCES `teacher_dayoff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teaching_offset_ibfk_4` FOREIGN KEY (`room_schedule`) REFERENCES `room_schedule` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `teacher_fk0` FOREIGN KEY (`teacher`) REFERENCES `main_teacher` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
