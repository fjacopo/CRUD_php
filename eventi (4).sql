-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 21, 2024 alle 11:56
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventi`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `dettagli_contatto_organizzatori`
--

CREATE TABLE `dettagli_contatto_organizzatori` (
  `ID_organizzatore` int(11) NOT NULL,
  `Telefono` varchar(255) DEFAULT NULL,
  `Indirizzo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `dettagli_contatto_organizzatori`
--

INSERT INTO `dettagli_contatto_organizzatori` (`ID_organizzatore`, `Telefono`, `Indirizzo`) VALUES
(1, '331212212', 'Via Roma 123'),
(2, '335555555', 'Via Milano 456'),
(3, '338888888', 'Via Napoli 789');

-- --------------------------------------------------------

--
-- Struttura della tabella `eventi`
--

CREATE TABLE `eventi` (
  `ID_evento` int(11) NOT NULL,
  `Nome_evento` varchar(255) DEFAULT NULL,
  `Data` date DEFAULT NULL,
  `ID_organizzatore` int(11) DEFAULT NULL,
  `ID_luogo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `eventi`
--

INSERT INTO `eventi` (`ID_evento`, `Nome_evento`, `Data`, `ID_organizzatore`, `ID_luogo`) VALUES
(1, 'Concerto Live', '2024-03-10', 1, 1),
(2, 'Conferenza Tecnologica', '2024-04-15', 2, 2),
(3, 'Festa di Compleanno', '2024-05-20', 3, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `luoghi`
--

CREATE TABLE `luoghi` (
  `ID_luogo` int(11) NOT NULL,
  `Nome_luogo` varchar(255) DEFAULT NULL,
  `Indirizzo` varchar(255) DEFAULT NULL,
  `Capacita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `luoghi`
--

INSERT INTO `luoghi` (`ID_luogo`, `Nome_luogo`, `Indirizzo`, `Capacita`) VALUES
(1, 'Centro Congressi', 'Via Roma 1', 500),
(2, 'Teatro Municipale', 'Piazza Garibaldi 3', 300),
(3, 'Sala Eventi', 'Corso Italia 10', 200);

-- --------------------------------------------------------

--
-- Struttura della tabella `organizzatori`
--

CREATE TABLE `organizzatori` (
  `ID_organizzatore` int(11) NOT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Cognome` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `organizzatori`
--

INSERT INTO `organizzatori` (`ID_organizzatore`, `Nome`, `Cognome`, `Email`) VALUES
(1, 'John', 'Doe', 'john@example.com'),
(2, 'Jane', 'Smith', 'jane@example.com'),
(3, 'Mark', 'Johnson', 'mark@example.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipanti`
--

CREATE TABLE `partecipanti` (
  `ID_partecipante` int(11) NOT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `Cognome` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `partecipanti`
--

INSERT INTO `partecipanti` (`ID_partecipante`, `Nome`, `Cognome`, `Email`) VALUES
(1, 'Alice', 'Brown', 'alice@example.com'),
(2, 'Tom', 'Wilson', 'tom@example.com'),
(3, 'Emma', 'Davis', 'emma@example.com');

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipanti_eventi`
--

CREATE TABLE `partecipanti_eventi` (
  `ID_partecipante` int(11) NOT NULL,
  `ID_evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `partecipanti_eventi`
--

INSERT INTO `partecipanti_eventi` (`ID_partecipante`, `ID_evento`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `dettagli_contatto_organizzatori`
--
ALTER TABLE `dettagli_contatto_organizzatori`
  ADD PRIMARY KEY (`ID_organizzatore`);

--
-- Indici per le tabelle `eventi`
--
ALTER TABLE `eventi`
  ADD PRIMARY KEY (`ID_evento`),
  ADD KEY `ID_organizzatore` (`ID_organizzatore`),
  ADD KEY `ID_luogo` (`ID_luogo`);

--
-- Indici per le tabelle `luoghi`
--
ALTER TABLE `luoghi`
  ADD PRIMARY KEY (`ID_luogo`);

--
-- Indici per le tabelle `organizzatori`
--
ALTER TABLE `organizzatori`
  ADD PRIMARY KEY (`ID_organizzatore`);

--
-- Indici per le tabelle `partecipanti`
--
ALTER TABLE `partecipanti`
  ADD PRIMARY KEY (`ID_partecipante`);

--
-- Indici per le tabelle `partecipanti_eventi`
--
ALTER TABLE `partecipanti_eventi`
  ADD PRIMARY KEY (`ID_partecipante`,`ID_evento`),
  ADD KEY `ID_evento` (`ID_evento`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `dettagli_contatto_organizzatori`
--
ALTER TABLE `dettagli_contatto_organizzatori`
  ADD CONSTRAINT `fk_dettagli_contatto_organizzatori_organizzatori` FOREIGN KEY (`ID_organizzatore`) REFERENCES `organizzatori` (`ID_organizzatore`);

--
-- Limiti per la tabella `eventi`
--
ALTER TABLE `eventi`
  ADD CONSTRAINT `eventi_ibfk_1` FOREIGN KEY (`ID_organizzatore`) REFERENCES `organizzatori` (`ID_organizzatore`),
  ADD CONSTRAINT `eventi_ibfk_2` FOREIGN KEY (`ID_luogo`) REFERENCES `luoghi` (`ID_luogo`);

--
-- Limiti per la tabella `partecipanti_eventi`
--
ALTER TABLE `partecipanti_eventi`
  ADD CONSTRAINT `partecipanti_eventi_ibfk_1` FOREIGN KEY (`ID_partecipante`) REFERENCES `partecipanti` (`ID_partecipante`),
  ADD CONSTRAINT `partecipanti_eventi_ibfk_2` FOREIGN KEY (`ID_evento`) REFERENCES `eventi` (`ID_evento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
