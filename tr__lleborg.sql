-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 11 okt 2017 kl 10:26
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
  `ISBN` varchar(20) NOT NULL,
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
(1, 'Star Wars Forces of Destiny', '978-1-56619-909-4', 'Jennifer Muro', 'Science fiction,\r\nAction/Adventure,\r\nAnthology,', '2017', 2, 'Carrie Beck Dave Filoni', 'English'),
(2, 'Harry Potter and the Philosopher''s Stone', '1746382947341', 'J. K. Rowling', 'Fantasy, Drama, Mystery, Thriller', '1997', NULL, 'Bloomsbury Publishing (UK), Scholastic (US)', 'English'),
(3, 'Harry Potter and the Chamber of Secrets', '0-7475-3849-2', 'J. K. Rowling', 'Fantasy', '1998', 3, 'Bloomsbury (UK) (Canada 2010–present)', 'English'),
(4, 'Harry Potter and the Prisoner of Azkaban', '0-7475-4215-5', 'J. K. Rowling', 'Fantasy', '1999', NULL, 'Bloomsbury (UK) (Canada 2010–present)', 'English'),
(5, 'Harry Potter and the Goblet of Fire', '0-7475-4624-X', 'J. K. Rowling', 'Fantasy', '2000', 2, 'Bloomsbury (UK) (Canada 2010–present)', 'English'),
(6, 'Harry Potter and the Order of the Phoenix', '0-7475-5100-6', 'J. K. Rowling', 'Fantasy', '2003', NULL, 'Bloomsbury (UK) (Canada 2010–present)', 'English'),
(7, 'Harry Potter and the Half-Blood Prince', '0-7475-8108-8', 'J. K. Rowling', 'Fantasy', '2005', NULL, 'Bloomsbury (UK) (Canada 2010–present)', 'English'),
(8, 'Harry Potter and the Deathly Hallows', '0-545-01022-5', 'J. K. Rowling', 'Fantasy', '2007', NULL, 'Bloomsbury', 'English'),
(36, 'En dtestpost', '1234567890', 'Gunelius, Susan M.', '', '2000', NULL, 'Huddinge : Förf', 'swe'),
(37, 'Hästen och hans pojke', '978-91-638-8793-2', 'Lewis, C. S. (Clive Staples)', 'Fantasy, Äventyr', '2016', NULL, 'Bonnier Carlsen', 'Svenska'),
(38, 'Häxan och lejonet', '978-91-638-8790-1', 'Lewis, C. S. (Clive Staples)', 'Fantasy, äventyr', '2016', NULL, 'Bonnier Carlsen', 'Svenska'),
(39, 'Caspian, prins av Narnia', '978-91-638-8792-5', 'Lewis, C. S. (Clive Staples)', 'Fantasy, Äventyr', '2016', NULL, 'Bonnier Carlsen', 'Svenska'),
(40, 'Kung Caspian och skeppet Gryningen', '978-91-638-8791-8', 'Lewis, C. S. (Clive Staples)', 'Fantasy, Äventyr', '2016', NULL, 'Bonnier Carlsen', 'Svenska'),
(41, 'Minecraft', '978-91-1-304372-2', 'Daniel Goldberg, Linus Larsson', 'Biografi', '2012', NULL, 'Norstedt', 'Svenska'),
(42, 'The Da Vinci code', '0-552-14951-9', 'Dan Brown', 'Mystery, Thriller, Deckare', '2004', NULL, 'Corgi', 'English');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
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
