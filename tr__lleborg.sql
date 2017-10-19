-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 19 okt 2017 kl 10:41
-- Serverversion: 10.1.19-MariaDB
-- PHP-version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `trälleborg`
--
CREATE DATABASE IF NOT EXISTS `trälleborg` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `trälleborg`;

-- --------------------------------------------------------

--
-- Tabellstruktur `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `ISBN` varchar(13) NOT NULL,
  `author` varchar(50) NOT NULL,
  `release_year` varchar(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `publisher` varchar(50) NOT NULL,
  `language` varchar(50) NOT NULL,
  `image_location` varchar(50) NOT NULL DEFAULT 'uploads/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `books`
--

INSERT INTO `books` (`id`, `title`, `ISBN`, `author`, `release_year`, `user_id`, `publisher`, `language`, `image_location`) VALUES
(1, 'Star Wars Forces of Destiny', '9781566199094', 'Jennifer Muro', '2017', 2, 'Carrie Beck Dave Filoni', 'Engelska', 'uploads/default.png'),
(2, 'Harry Potter and the Philosopher''s Stone', '1746382947341', 'J. K. Rowling', '1997', NULL, 'Bloomsbury Publishing (UK), Scholastic (US)', 'Engelska', 'uploads/default.png'),
(3, 'Harry Potter and the Chamber of Secrets', '0747538492', 'J. K. Rowling', '1998', 3, 'Bloomsbury (UK) (Canada 2010–present)', 'Engelska', 'uploads/default.png'),
(4, 'Harry Potter and the Prisoner of Azkaban', '0747542155', 'J. K. Rowling', '1999', NULL, 'Bloomsbury (UK) (Canada 2010–present)', 'Engelska', 'uploads/default.png'),
(5, 'Harry Potter and the Goblet of Fire', '074754624X', 'J. K. Rowling', '2000', 2, 'Bloomsbury (UK) (Canada 2010–present)', 'Engelska', 'uploads/default.png'),
(6, 'Harry Potter and the Order of the Phoenix', '0747551006', 'J. K. Rowling', '2003', NULL, 'Bloomsbury (UK) (Canada 2010–present)', 'Engelska', 'uploads/default.png'),
(7, 'Harry Potter and the Half-Blood Prince', '0747581088', 'J. K. Rowling', '2005', NULL, 'Bloomsbury (UK) (Canada 2010–present)', 'Engelska', 'uploads/default.png'),
(8, 'Harry Potter and the Deathly Hallows', '0545010225', 'J. K. Rowling', '2007', NULL, 'Bloomsbury', 'Engelska', 'uploads/default.png'),
(9, 'Minecraft', '9789113043722', 'Daniel Goldberg, Linus Larsson', '2012', NULL, 'Norstedt', 'Svenska', 'uploads/default.png'),
(37, 'Hästen och hans pojke', '9789163887932', 'Lewis, C. S. (Clive Staples)', '2016', NULL, 'Bonnier Carlsen', 'Svenska', 'uploads/default.png'),
(38, 'Häxan och lejonet', '9789163887901', 'Lewis, C. S. (Clive Staples)', '2016', NULL, 'Bonnier Carlsen', 'Svenska', 'uploads/default.png'),
(39, 'Caspian, prins av Narnia', '9789163887925', 'Lewis, C. S. (Clive Staples)', '2016', NULL, 'Bonnier Carlsen', 'Svenska', 'uploads/default.png'),
(40, 'Kung Caspian och skeppet Gryningen', '9789163887918', 'Lewis, C. S. (Clive Staples)', '2016', NULL, 'Bonnier Carlsen', 'Svenska', 'uploads/default.png'),
(42, 'The Da Vinci code', '0552149519', 'Dan Brown', '2004', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(43, 'Jag är Zlatan Ibrahimović ', '9789100126537', 'Zlatan Ibrahimovic, David Lagercrantz', '2011', NULL, 'Bonnier', 'Svenska', 'uploads/default.png'),
(44, 'Sveriges historia 1600-1721', '9789113024400', 'Nils Erik Villstrand', '2011', NULL, 'Norstedt', 'Svenska', 'uploads/default.png'),
(45, 'Processen', '9789174996203', 'Franz Kafka', '2014', NULL, 'Modernista', 'Svenska', 'uploads/default.png'),
(46, 'The ruins of Gorlan', '9780142406632', 'John Flanagan', '2006', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(47, 'The Burning Bridge', '9780440867395', 'John Flanagan', '2007', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(48, 'The Icebound Land', '9780440867401', 'John Flanagan', '2008', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(49, 'Oakleaf bearers', '9780440867418', 'John Flanagan', '2008', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(50, 'The sorcerer in the north', '9780440869054', 'John Flanagan', '2009', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(51, 'The Siege of Macindaw', '9780440869078', 'John Flanagan', '2010', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(52, 'Erak''s ransom', '9780440869733', 'John Flanagan', '2011', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(53, 'The Kings of Clonmel', '9780440869825', 'John Flanagan', '2011', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(54, 'Halt''s peril', '9780440869832', 'John Flanagan', '2011', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(55, 'The emperor of Nihon-Ja', '9780440869849', 'John Flanagan', '2011', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(56, 'The Lost Stories', '9780440869931', 'John Flanagan', '2011', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(57, 'The Royal Ranger', '9780440869948', 'John Flanagan', '2013', NULL, 'Corgi Yearling', 'Engelska', 'uploads/default.png'),
(58, 'Svenska hackare [Elektronisk resurs]', '9789113033440', 'Linus Larsson, Daniel Goldberg', '2014', NULL, 'Norstedts', 'Svenska', 'uploads/default.png'),
(59, 'Sveriges rikes lag', '9789139019848', 'Johan Munck', '2017', NULL, 'Wolters Kluwer', 'Svenska', 'uploads/default.png'),
(61, 'Trafikens grunder', '9789188377159', '', '2016', NULL, 'STR service', 'Svenska', 'uploads/default.png'),
(62, 'Masse : helvetet tur & retur', '9789188483089', 'Marcus Birro, Mats Magnusson', '2017', NULL, 'Idrottsförlaget', 'Svenska', 'uploads/default.png'),
(63, 'Creating a website [Elektronisk resurs]', '7309860800007', 'MacDonald, Matthew.', '2011', NULL, 'Sebastopol, Calif. : O''Reilly', 'Engelska', 'uploads/default.png'),
(86, 'Left hand of god', '9780141333557', 'Hoffman, Paul', '2011', NULL, 'Penguin Books Ltd', 'Engelska', 'uploads/php46A6.jpg');

-- --------------------------------------------------------

--
-- Tabellstruktur `books_genre`
--

DROP TABLE IF EXISTS `books_genre`;
CREATE TABLE `books_genre` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `books_genre`
--

INSERT INTO `books_genre` (`id`, `book_id`, `genre_id`) VALUES
(85, 1, 8),
(82, 1, 10),
(84, 1, 11),
(50, 2, 2),
(51, 3, 2),
(52, 4, 2),
(53, 5, 2),
(54, 6, 2),
(55, 7, 2),
(56, 8, 2),
(116, 9, 7),
(57, 37, 2),
(86, 37, 8),
(58, 38, 2),
(87, 38, 8),
(59, 39, 2),
(88, 39, 8),
(60, 40, 2),
(89, 40, 8),
(121, 42, 5),
(117, 43, 7),
(119, 44, 9),
(61, 46, 2),
(90, 46, 8),
(62, 47, 2),
(91, 47, 8),
(63, 48, 2),
(92, 48, 8),
(64, 49, 2),
(93, 49, 8),
(65, 50, 2),
(94, 50, 8),
(66, 51, 2),
(95, 51, 8),
(67, 52, 2),
(96, 52, 8),
(68, 53, 2),
(97, 53, 8),
(69, 54, 2),
(98, 54, 8),
(70, 55, 2),
(99, 55, 8),
(71, 56, 2),
(100, 56, 8),
(72, 57, 2),
(101, 57, 8),
(118, 62, 7),
(122, 63, 6),
(123, 65, 6),
(124, 66, 6),
(126, 67, 3),
(129, 67, 5),
(130, 67, 6),
(125, 67, 7),
(127, 67, 9),
(128, 67, 10),
(131, 86, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(11, 'Action'),
(8, 'Äventyr'),
(7, 'Biografi'),
(3, 'Drama'),
(2, 'Fantasy'),
(9, 'Historia'),
(10, 'Sci-fi'),
(5, 'Skräck'),
(6, 'Teknik');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `telephone`) VALUES
(2, 'Simon Svensson', 'nope@nope.com', '0706334793'),
(3, 'Awesome Simon', 'gmail@gmail.com', '0703667523'),
(4, 'Erik Eriksson', 'erik.eriksson@gmail.com', '123123456'),
(5, 'Marcus Linné', 'marcus.linne@lund.ntig.se', '3548654723'),
(6, 'Mathias Andersson', 'mathias.andersson@lund.ntig.se', '112');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ISBN` (`ISBN`),
  ADD KEY `user_id` (`user_id`);

--
-- Index för tabell `books_genre`
--
ALTER TABLE `books_genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `book_id` (`book_id`,`genre_id`);

--
-- Index för tabell `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT för tabell `books_genre`
--
ALTER TABLE `books_genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT för tabell `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
