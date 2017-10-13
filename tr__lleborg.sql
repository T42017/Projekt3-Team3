-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 13 okt 2017 kl 10:09
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
  `category` varchar(100) NOT NULL,
  `release_year` varchar(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `publisher` varchar(50) NOT NULL,
  `language` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumpning av Data i tabell `books`
--

INSERT INTO `books` (`id`, `title`, `ISBN`, `author`, `category`, `release_year`, `user_id`, `publisher`, `language`) VALUES
(1, 'Star Wars Forces of Destiny', '9781566199094', 'Jennifer Muro', 'Science fiction, Action, Äventyr', '2017', 2, 'Carrie Beck Dave Filoni', 'Engelska'),
(2, 'Harry Potter and the Philosopher''s Stone', '1746382947341', 'J. K. Rowling', 'Fantasy, Drama, Mysterie, Thriller', '1997', NULL, 'Bloomsbury Publishing (UK), Scholastic (US)', 'Engelska'),
(3, 'Harry Potter and the Chamber of Secrets', '0747538492', 'J. K. Rowling', 'Fantasy', '1998', 3, 'Bloomsbury (UK) (Canada 2010–present)', 'Engelska'),
(4, 'Harry Potter and the Prisoner of Azkaban', '0747542155', 'J. K. Rowling', 'Fantasy', '1999', NULL, 'Bloomsbury (UK) (Canada 2010–present)', 'Engelska'),
(5, 'Harry Potter and the Goblet of Fire', '074754624X', 'J. K. Rowling', 'Fantasy', '2000', 2, 'Bloomsbury (UK) (Canada 2010–present)', 'Engelska'),
(6, 'Harry Potter and the Order of the Phoenix', '0747551006', 'J. K. Rowling', 'Fantasy', '2003', NULL, 'Bloomsbury (UK) (Canada 2010–present)', 'Engelska'),
(7, 'Harry Potter and the Half-Blood Prince', '0747581088', 'J. K. Rowling', 'Fantasy', '2005', NULL, 'Bloomsbury (UK) (Canada 2010–present)', 'Engelska'),
(8, 'Harry Potter and the Deathly Hallows', '0545010225', 'J. K. Rowling', 'Fantasy', '2007', NULL, 'Bloomsbury', 'Engelska'),
(9, 'Minecraft', '9789113043722', 'Daniel Goldberg, Linus Larsson', 'Biografi', '2012', NULL, 'Norstedt', 'Svenska'),
(37, 'Hästen och hans pojke', '9789163887932', 'Lewis, C. S. (Clive Staples)', 'Fantasy, Äventyr', '2016', NULL, 'Bonnier Carlsen', 'Svenska'),
(38, 'Häxan och lejonet', '9789163887901', 'Lewis, C. S. (Clive Staples)', 'Fantasy, Äventyr', '2016', NULL, 'Bonnier Carlsen', 'Svenska'),
(39, 'Caspian, prins av Narnia', '9789163887925', 'Lewis, C. S. (Clive Staples)', 'Fantasy, Äventyr', '2016', NULL, 'Bonnier Carlsen', 'Svenska'),
(40, 'Kung Caspian och skeppet Gryningen', '9789163887918', 'Lewis, C. S. (Clive Staples)', 'Fantasy, Äventyr', '2016', NULL, 'Bonnier Carlsen', 'Svenska'),
(42, 'The Da Vinci code', '0552149519', 'Dan Brown', 'Mysterie, Thriller, Deckare', '2004', NULL, 'Corgi Yearling', 'Engelska'),
(43, 'Jag är Zlatan Ibrahimović ', '9789100126537', 'Zlatan Ibrahimovic, David Lagercrantz', 'Biografi', '2011', NULL, 'Bonnier', 'Svenska'),
(44, 'Sveriges historia 1600-1721', '9789113024400', 'Nils Erik Villstrand', 'Historia', '2011', NULL, 'Norstedt', 'Svenska'),
(45, 'Processen', '9789174996203', 'Franz Kafka', 'Roman, Expressionism', '2014', NULL, 'Modernista', 'Svenska'),
(46, 'The ruins of Gorlan', '9780142406632', 'John Flanagan', 'Fantasy, Äventyr', '2006', NULL, 'Corgi Yearling', 'Engelska'),
(47, 'The Burning Bridge', '9780440867395', 'John Flanagan', 'Fantasy, Äventyr', '2007', NULL, 'Corgi Yearling', 'Engelska'),
(48, 'The Icebound Land', '9780440867401', 'John Flanagan', 'Fantasy, Äventyr', '2008', NULL, 'Corgi Yearling', 'Engelska'),
(49, 'Oakleaf bearers', '9780440867418', 'John Flanagan', 'Fantasy, Äventyr', '2008', NULL, 'Corgi Yearling', 'Engelska'),
(50, 'The sorcerer in the north', '9780440869054', 'John Flanagan', 'Fantasy, Äventyr', '2009', NULL, 'Corgi Yearling', 'Engelska'),
(51, 'The Siege of Macindaw', '9780440869078', 'John Flanagan', 'Fantasy, Äventyr', '2010', NULL, 'Corgi Yearling', 'Engelska'),
(52, 'Erak''s ransom', '9780440869733', 'John Flanagan', 'Fantasy, Äventyr', '2011', NULL, 'Corgi Yearling', 'Engelska'),
(53, 'The Kings of Clonmel', '9780440869825', 'John Flanagan', 'Fantasy, Äventyr', '2011', NULL, 'Corgi Yearling', 'Engelska'),
(54, 'Halt''s peril', '9780440869832', 'John Flanagan', 'Fantasy, Äventyr', '2011', NULL, 'Corgi Yearling', 'Engelska'),
(55, 'The emperor of Nihon-Ja', '9780440869849', 'John Flanagan', 'Fantasy, Äventyr', '2011', NULL, 'Corgi Yearling', 'Engelska'),
(56, 'The Lost Stories', '9780440869931', 'John Flanagan', 'Fantasy, Äventyr', '2011', NULL, 'Corgi Yearling', 'Engelska'),
(57, 'The Royal Ranger', '9780440869948', 'John Flanagan', 'Fantasy, Äventyr', '2013', NULL, 'Corgi Yearling', 'Engelska'),
(58, 'Svenska hackare [Elektronisk resurs]', '9789113033440', 'Linus Larsson, Daniel Goldberg', 'Samhälle & kultur', '2014', NULL, 'Norstedts', 'Svenska'),
(59, 'Sveriges rikes lag', '9789139019848', 'Johan Munck', 'Lagar & regler', '2017', NULL, 'Wolters Kluwer', 'Svenska'),
(61, 'Trafikens grunder', '9789188377159', '', 'Lagar & regler', '2016', NULL, 'STR service', 'Svenska'),
(62, 'Masse : helvetet tur & retur', '9789188483089', 'Marcus Birro, Mats Magnusson', 'Biografi', '2017', NULL, 'Idrottsförlaget', 'Svenska');

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
(5, 'Marcus Linné', 'marcus.linne@lund.ntig.se', '3548654723');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
