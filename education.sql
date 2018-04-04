-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 04, 2018 lúc 11:15 AM
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
(1, '2018-03-06', '2018-04-18', 1, NULL),
(4, '2018-04-19', '2018-05-17', 4, NULL),
(5, '2018-04-19', '2018-05-10', 1, NULL),
(6, '2018-04-13', '2018-08-14', 1, NULL),
(7, '2018-03-01', '2018-04-13', 4, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course`
--

CREATE TABLE `course` (
  `id` bigint(20) NOT NULL,
  `name` char(100) NOT NULL,
  `subject` bigint(20) NOT NULL,
  `price` bigint(20) NOT NULL,
  `certificate_required` bigint(20) DEFAULT NULL,
  `total_of_period` bigint(20) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `img_url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `course`
--

INSERT INTO `course` (`id`, `name`, `subject`, `price`, `certificate_required`, `total_of_period`, `description`, `img_url`) VALUES
(1, 'English for fresher', 1, 5000000, NULL, 50, 'Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem.', './img/course1.jpg'),
(2, 'English for fresher 2', 1, 2000000, 1, 60, 'Sed porttitor lectus nibh. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.', './img/course2.jpg'),
(3, 'English for fresher 3', 1, 3000000, 2, 20, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quis lorem ut libero malesuada feugiat. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.Quisque velit nisi, pretium ut lacinia in, elementum id enim. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.', './img/course3.jpg'),
(4, 'Basic Maths', 2, 2000000, NULL, 30, 'Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem.', './img/maths1.jpg'),
(5, 'Advance Maths', 2, 3000000, 4, 50, 'Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem.', './img/maths2.jpg'),
(6, 'Art for beginer', 3, 6000000, NULL, 30, 'Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem.', './img/art1.jpg'),
(7, 'Piano', 4, 6000000, 9, 40, 'Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem.', './img/piano1.jpg'),
(8, 'Guitar', 4, 4000000, 9, 30, 'Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem.', './img/guita1.jpg'),
(9, 'Music Theory', 4, 6000000, NULL, 40, 'Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem.', './img/music1.jpg');

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
(1, 2),
(2, 2),
(3, 2),
(4, 1),
(5, 1),
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
  `name` char(50) NOT NULL,
  `address` char(100) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `mail` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `employee`
--

INSERT INTO `employee` (`id`, `name`, `address`, `phone`, `mail`) VALUES
(1, 'Tran Phong Phu', '113 Ky Con, Phuong Nguyen Thai Binh, Quan 1, TP Ho Chi Minh', 905642156, 'phutp@gmail.com'),
(2, 'Nguyen Thi Hanh', 'So 31 Nguyen Van Giai, Phuong Da Kao, Quan 1, TP Ho Chi Minh', 1236546794, 'hanhtn@gmail.com'),
(3, 'Nguyen Xuan Hoa', 'So 15 Nguyen Thi Minh Khai, Phuong Tan Hiep, Quan Tan Binh, TP Ho Chi Minh', 194536771, 'hoaxn@gmail.com'),
(4, 'Tran Binh Trong', 'So 31 Nguyen Van Giai, Phuong Da Kao, Quan 1, TP Ho Chi Minh', 1697446546, 'trongbt@gmail.com'),
(5, 'Nguyen Thi Ai Nhi', 'So 15 Nguyen Giai, Phuong Binh Tho, Quan Thu Duc, TP Ho Chi Minh', 166231567, 'nhiatn@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam`
--

CREATE TABLE `exam` (
  `id` bigint(20) NOT NULL,
  `register` bigint(20) NOT NULL,
  `type_of_exam` char(1) NOT NULL,
  `score` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `main_teacher`
--

CREATE TABLE `main_teacher` (
  `id` bigint(20) NOT NULL,
  `degree` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `main_teacher`
--

INSERT INTO `main_teacher` (`id`, `degree`) VALUES
(1, 'Professor'),
(2, 'Senior Lecturer'),
(4, 'Musician'),
(5, 'Artist');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `office`
--

CREATE TABLE `office` (
  `id` bigint(20) NOT NULL,
  `address` char(100) NOT NULL,
  `location` varchar(300) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `mail` char(100) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `office`
--

INSERT INTO `office` (`id`, `address`, `location`, `phone`, `mail`, `name`) VALUES
(1, 'Trung Tam Anh Ngu B.E.N, Le Dai Hanh, phuong 15, Quan 11, Ho Chi Minh', 'https://www.google.com/maps/place/Trung+T%C3%A2m+Anh+Ng%E1%BB%AF+B.E.N/@10.7693669,106.6504617,17z/data=!3m1!4b1!4m5!3m4!1s0x31752e9552b97111:0x3e81a87c9948d39e!8m2!3d10.7693669!4d106.6526504', 1332546548, 'anhnguBen@gmail.com', 'Trung Tam Anh Ngu B.E.N'),
(2, 'Trung Tam Ve Sang Tao Wow Art Quan 11 Lac Long Quan phuong 10 Tan Binh Ho Chi Minh', 'https://www.google.com/maps/place/Trung+T%C3%A2m+V%E1%BA%BD+S%C3%A1ng+T%E1%BA%A1o+Wow+Art+Qu%E1%BA%ADn+11/@10.7649565,106.640477,17z/data=!3m1!4b1!4m5!3m4!1s0x31752e90cb12a473:0x4a615d2ca3247431!8m2!3d10.7649565!4d106.6426657', 166326414, 'wowart@gmail.com', 'Trung Tam Ve Sang Tao Wow Art'),
(3, 'Trung Tam Am Nhac FASOL Luy Ban Bich Tan Thoi Hoa Tan Phu Ho Chi Minh', 'https://www.google.com/maps/place/Trung+T%C3%A2m+%C3%82m+Nh%E1%BA%A1c+FASOL/@10.7668763,106.6297982,17z/data=!3m1!4b1!4m5!3m4!1s0x31752e9e6035f40d:0x42fb1314b4fbf63c!8m2!3d10.7668763!4d106.6319869', 91564856, 'fasolmusic@gmail.com', 'Trung Tam Am Nhac FASOL'),
(4, 'Trung tam toan TITAN EDUCATION Mac Dinh Chi Da Kao Quan 1 Ho Chi Minh', 'https://www.google.com/maps/place/Trung+t%C3%A2m+to%C3%A1n+TITAN+EDUCATION/@10.7883586,106.6936165,17z/data=!3m1!4b1!4m5!3m4!1s0x31752f499401b65b:0x8978b8f612b5e3b6!8m2!3d10.7883586!4d106.6958052', 904221635, 'titaneducation@gmail.com', 'Trung tam toan TITAN EDUCATION');

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
(4, 2, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `office_ta`
--

CREATE TABLE `office_ta` (
  `id` bigint(20) NOT NULL,
  `teaching_assistant` bigint(20) NOT NULL,
  `office` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `position`
--

CREATE TABLE `position` (
  `id` bigint(20) NOT NULL,
  `name` char(1) NOT NULL,
  `salary` bigint(20) NOT NULL,
  `rate_salary` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotion`
--

CREATE TABLE `promotion` (
  `id` bigint(20) NOT NULL,
  `name` char(1) NOT NULL,
  `benefit` char(1) NOT NULL,
  `required` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `register`
--

CREATE TABLE `register` (
  `id` bigint(20) NOT NULL,
  `class` bigint(20) NOT NULL,
  `promotion` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `score` bigint(20) NOT NULL,
  `pass` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 1, 1, 'Monday', 1, 2),
(2, 1, 2, 'Wednesday', 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `room_ta`
--

CREATE TABLE `room_ta` (
  `id` bigint(20) NOT NULL,
  `TA` bigint(20) NOT NULL,
  `room_schedule` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Cấu trúc bảng cho bảng `subject`
--

CREATE TABLE `subject` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `subject`
--

INSERT INTO `subject` (`id`, `name`, `description`) VALUES
(1, 'English', 'English for everyone'),
(2, 'Maths', 'Maths for everyone'),
(3, 'Fine Art', 'Fine Art for everyone'),
(4, 'Music', 'Music for everyone');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teaching_assistant`
--

CREATE TABLE `teaching_assistant` (
  `id` bigint(20) NOT NULL,
  `degree` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `teaching_assistant`
--

INSERT INTO `teaching_assistant` (`id`, `degree`) VALUES
(4, 'Master of assistant');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','member','','') NOT NULL DEFAULT 'member',
  `avatar` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$2lnE8Q3W9U49vhhfNq1EyuwckGTjO2uNMVRaJIrVDHfZ4UZamNPY6', 'admin', './img/avatar.jpg', 'YiXyuCmNJVNFlTx8p3Qap9EwNZyj7BY8cUXM3n0C1LAjWdtZP72hiQfrzDDO', '2018-03-16 02:49:36', '2018-03-16 02:49:36');

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
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Register_fk0` (`class`),
  ADD KEY `Register_fk1` (`promotion`),
  ADD KEY `Register_fk2` (`user`);

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
-- Chỉ mục cho bảng `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `teaching_assistant`
--
ALTER TABLE `teaching_assistant`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `class`
--
ALTER TABLE `class`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `exam`
--
ALTER TABLE `exam`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `main_teacher`
--
ALTER TABLE `main_teacher`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `office`
--
ALTER TABLE `office`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `office_main_teacher`
--
ALTER TABLE `office_main_teacher`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `office_ta`
--
ALTER TABLE `office_ta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `office_worker`
--
ALTER TABLE `office_worker`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `position`
--
ALTER TABLE `position`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `register`
--
ALTER TABLE `register`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `room`
--
ALTER TABLE `room`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `room_schedule`
--
ALTER TABLE `room_schedule`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `room_ta`
--
ALTER TABLE `room_ta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `subject`
--
ALTER TABLE `subject`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `teaching_assistant`
--
ALTER TABLE `teaching_assistant`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `Course_fk1` FOREIGN KEY (`certificate_required`) REFERENCES `course` (`id`);

--
-- Các ràng buộc cho bảng `course_room`
--
ALTER TABLE `course_room`
  ADD CONSTRAINT `course_room_fk0` FOREIGN KEY (`course`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `course_room_fk1` FOREIGN KEY (`room`) REFERENCES `room` (`id`);

--
-- Các ràng buộc cho bảng `course_ta`
--
ALTER TABLE `course_ta`
  ADD CONSTRAINT `course_TA_fk0` FOREIGN KEY (`course`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `course_TA_fk1` FOREIGN KEY (`TA`) REFERENCES `teaching_assistant` (`id`);

--
-- Các ràng buộc cho bảng `course_teacher`
--
ALTER TABLE `course_teacher`
  ADD CONSTRAINT `course_teacher_fk0` FOREIGN KEY (`course`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `course_teacher_fk1` FOREIGN KEY (`teacher`) REFERENCES `main_teacher` (`id`);

--
-- Các ràng buộc cho bảng `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `Exam_fk0` FOREIGN KEY (`register`) REFERENCES `register` (`id`);

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
-- Các ràng buộc cho bảng `register`
--
ALTER TABLE `register`
  ADD CONSTRAINT `Register_fk0` FOREIGN KEY (`class`) REFERENCES `class` (`id`),
  ADD CONSTRAINT `Register_fk1` FOREIGN KEY (`promotion`) REFERENCES `promotion` (`id`),
  ADD CONSTRAINT `Register_fk2` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `Room_fk0` FOREIGN KEY (`office`) REFERENCES `office` (`id`);

--
-- Các ràng buộc cho bảng `room_schedule`
--
ALTER TABLE `room_schedule`
  ADD CONSTRAINT `room_schedule_fk0` FOREIGN KEY (`class`) REFERENCES `class` (`id`),
  ADD CONSTRAINT `room_schedule_fk1` FOREIGN KEY (`schedule`) REFERENCES `schedule` (`id`),
  ADD CONSTRAINT `room_schedule_fk2` FOREIGN KEY (`teacher`) REFERENCES `main_teacher` (`id`),
  ADD CONSTRAINT `room_schedule_fk3` FOREIGN KEY (`room`) REFERENCES `room` (`id`);

--
-- Các ràng buộc cho bảng `room_ta`
--
ALTER TABLE `room_ta`
  ADD CONSTRAINT `room_TA_fk0` FOREIGN KEY (`TA`) REFERENCES `teaching_assistant` (`id`),
  ADD CONSTRAINT `room_TA_fk1` FOREIGN KEY (`room_schedule`) REFERENCES `room_schedule` (`id`);

--
-- Các ràng buộc cho bảng `teaching_assistant`
--
ALTER TABLE `teaching_assistant`
  ADD CONSTRAINT `Teaching Assistant_fk0` FOREIGN KEY (`id`) REFERENCES `employee` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
