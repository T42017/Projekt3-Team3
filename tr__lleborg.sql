-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 19 okt 2017 kl 10:24
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
(85, 'En dtestpost', '1234567890', '', '2000', NULL, 'Huddinge : Förf', 'Svenska', 'uploads/phpFE5.jpg');

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
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
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
