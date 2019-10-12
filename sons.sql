-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 12 Paź 2019, 08:08
-- Wersja serwera: 5.7.25
-- Wersja PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sons`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `login` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `hero` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`userid`, `login`, `email`, `password`, `hero`) VALUES
(3, 'Wiking13', 'test@test.pl', '$2y$10$kjVfGw8EbMMjzX2W8rUtreDSRD3c9GGsc5wmhMPMkDIG1GehlH7ru', 0),
(4, 'siemaChłop', 'test12@gmail.pl', '$2y$10$/spQCpRWhXkx6zPZvnuEROPU009QhQV.ZgGBLC/hWS4zf0ybxHTOS', 0),
(5, 'Kapsel12', 'kapi12@gmail.com', '$2y$10$YfSZA9kUGk2jAY3MsP97lOCYZG9bDFS88xka8YxjLsZOjgIFzmckS', 0),
(6, 'user13', 'user13@gmail.com', '$2y$10$/1xXqBq0eaxm2QrVNDGWF.7eSiuu1O/5mGHcW7YhsqP6r6REiRLg2', 0),
(7, 'kacper', 'testX@gmail.pl', '$2y$10$BFmssR2lV5TcUmJrbkuMX.X9H4h9NcQE0xiP9SQc03cMm.tGDQVMy', 0),
(8, 'Root', 'root@goons.pl', '$2y$10$7HqYjV8l8yQtY1DgEEIO5u7N.VE1mSXPJvEhYL8xtpqbCAWE5ohey', 0),
(9, 'BLA13', 'bla@gmail.com', '$2y$10$Igaah67x5Qza7sA45x77aevRCkfDbzR4OEgrNo.gmq6k/dHTiaZ3m', 0),
(10, 'sven', 'sven@gmail.se', '$2y$10$9TFnPmbPteFWm3G7ukPe5.t3/omqpnP2zMftt/d3aegu0d6MkZhd6', 0),
(11, 'król', 'dsads@sadas.pl', '$2y$10$Jz3igNwg1Aomh2fY.Jq2n.yj7nmhCSjnm7/3rkoXrwWPudI4Pxxke', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
