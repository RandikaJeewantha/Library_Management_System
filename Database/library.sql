-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2019 at 07:43 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
`book_id` int(5) NOT NULL,
  `book_name` varchar(300) NOT NULL,
  `book_author` varchar(100) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_name`, `book_author`, `is_available`, `category`, `quantity`) VALUES
(1, 'Great War 1914-18', 'London County Council', 0, 'War', 1),
(2, 'Billy Lynn''s Long Halftime Walk', 'Ben Fountain', 1, 'War', 3),
(3, 'War and Peace', 'Leo Tolstoy', 1, 'War', 12),
(4, 'Austerlitz', 'Winfried Georg Sebald', 1, 'War', 4),
(5, 'In Search of Lost Time  ', 'Marcel Proust', 1, 'Novel', 1),
(6, 'Ulysses', 'James Joyce', 1, 'Novel', 5),
(7, 'Don Quixote', 'Miguel de Cervantes', 1, 'Novel', 4),
(8, 'The Great Gatsby', 'F. Scott Fitzgerald', 1, 'Novel', 9),
(9, 'Moby Dick', 'Herman Melville', 1, 'Novel', 2),
(10, 'Cosmos', 'Carl Sagan', 1, 'Science', 6),
(11, 'Pale Blue Dot', 'Carl Sagan', 1, 'Science', 2),
(12, 'The Universe in a Nutshell', 'Stephen Hawking', 1, 'Science', 4),
(13, 'The Selfish Gene', 'Richard Dawkins', 1, 'Science', 2),
(14, 'The Hot Zone', 'Richard Preston', 1, 'Science', 10),
(15, 'Queen Lucia', 'E F Benson', 1, 'Comedy', 1),
(16, 'Cold Comfort Farm', 'Stella Gibbons', 1, 'Comedy', 3),
(17, 'The Code of the Woosters', 'PG Wodehouse', 1, 'Comedy', 8),
(18, 'test', 'test author', 0, 'test category', 5),
(19, 'Asterix the Gaul', 'RenÃ© Goscinny', 0, 'Cartoons', 3);

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE IF NOT EXISTS `borrow` (
  `book_borrow_user` int(4) NOT NULL,
  `borrow_book_id` int(4) NOT NULL,
`borrow_id` int(4) NOT NULL,
  `issued_date` date NOT NULL,
  `returned_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`book_borrow_user`, `borrow_book_id`, `borrow_id`, `issued_date`, `returned_date`) VALUES
(3, 2, 2, '2019-08-26', '2019-09-05'),
(3, 6, 3, '2019-08-26', '2019-09-05'),
(10, 14, 4, '2019-08-26', '2019-09-05'),
(13, 11, 5, '2019-08-26', '2019-09-05'),
(5, 17, 26, '2019-08-26', '2019-09-05'),
(12, 17, 27, '2019-08-26', '2019-09-05'),
(7, 13, 28, '2019-08-26', '2019-09-05'),
(13, 13, 29, '2019-08-26', '2019-09-05'),
(5, 12, 30, '2019-08-26', '2019-09-05'),
(10, 12, 31, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `pendings`
--

CREATE TABLE IF NOT EXISTS `pendings` (
  `user_type` varchar(40) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pendings`
--

INSERT INTO `pendings` (`user_type`, `first_name`, `last_name`, `email`, `password`) VALUES
('Teacher', 'saduni', 'harshamali', 'teacher2@yahoo.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `user_type` varchar(40) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `require_delete_account` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type`, `first_name`, `last_name`, `email`, `password`, `last_login`, `is_deleted`, `require_delete_account`) VALUES
(3, 'Student', 'Kasun', 'Bandara', 'kasun@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0),
(4, 'Book Keeper', 'sameera', 'Rathnayake', 'sameera@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0),
(5, 'Student', 'sharmal', 'vithana', 'damith@ab.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '2019-05-19 21:02:29', 1, 0),
(7, 'Book Keeper', 'nial', 'diaus', 'nial@123.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '2019-08-23 14:21:26', 0, 0),
(8, 'Librarian', 'mithun', 'fernando', 'mithun@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '2019-06-13 16:01:50', 0, 0),
(9, 'Student', 'edwin', 'root', 'edwin12@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '2019-08-26 11:02:43', 0, 0),
(10, 'Teacher', 'mahela', 'jayawardana', 'mahela@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0),
(11, 'Teacher', 'sanath', 'jayasooriya', 'sanath@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 1, 0),
(12, 'Librarian', 'randika', 'jeewantha', 'randikaherath0@gmail.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '2019-08-26 10:45:26', 0, 0),
(13, 'Teacher', 'saduni', 'herath', 'teacher@yahoo.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0),
(35, 'Student', 'kasun', 'udayanga', 'student@yahoo.com', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', '0000-00-00 00:00:00', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
 ADD PRIMARY KEY (`book_id`), ADD UNIQUE KEY `book_name` (`book_name`);

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
 ADD PRIMARY KEY (`borrow_id`);

--
-- Indexes for table `pendings`
--
ALTER TABLE `pendings`
 ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
MODIFY `book_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `borrow`
--
ALTER TABLE `borrow`
MODIFY `borrow_id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
