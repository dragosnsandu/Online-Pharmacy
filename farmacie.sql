-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2019 at 07:43 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farmacie`
--

-- --------------------------------------------------------

--
-- Table structure for table `clienti`
--

CREATE TABLE `clienti` (
  `id_client` int(11) NOT NULL,
  `CNP` char(13) NOT NULL,
  `Nume` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Prenume` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Ocupatie` varchar(30) DEFAULT NULL,
  `Strada` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Oras` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Judet` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Telefon` char(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comenzi`
--

CREATE TABLE `comenzi` (
  `id_comanda` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `livrare` datetime NOT NULL,
  `prelucrare` datetime NOT NULL,
  `efectuare_plata` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `continut_comanda`
--

CREATE TABLE `continut_comanda` (
  `id_comanda` int(11) NOT NULL,
  `id_medicament` int(11) NOT NULL,
  `cantitate_medicament` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `istoric_comenzi`
--

CREATE TABLE `istoric_comenzi` (
  `id_comanda` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `medicamente`
--

CREATE TABLE `medicamente` (
  `id_medicament` int(11) NOT NULL,
  `id_producator` int(11) NOT NULL,
  `concentratie` int(11) NOT NULL,
  `Nume` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Categorie` varchar(30) NOT NULL,
  `Pret` decimal(10,2) NOT NULL,
  `Procent_reducere` int(11) NOT NULL,
  `nr_pastile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `producatori`
--

CREATE TABLE `producatori` (
  `id_producator` int(11) NOT NULL,
  `nume` varchar(100) NOT NULL,
  `locatie` varchar(50) NOT NULL,
  `telefon` char(10) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prospecte`
--

CREATE TABLE `prospecte` (
  `id_prospect` int(11) NOT NULL,
  `doza_recomandata_adult_zi` int(11) NOT NULL,
  `doza_recomandata_copil_zi` int(11) NOT NULL,
  `mod_administrare` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contraindicatii` varchar(255) CHARACTER SET utf8 NOT NULL,
  `reactii_adverse` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`id_client`),
  ADD UNIQUE KEY `CNP` (`CNP`),
  ADD UNIQUE KEY `Telefon` (`Telefon`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `comenzi`
--
ALTER TABLE `comenzi`
  ADD PRIMARY KEY (`id_comanda`),
  ADD KEY `pk_comanda_client` (`id_client`);

--
-- Indexes for table `continut_comanda`
--
ALTER TABLE `continut_comanda`
  ADD UNIQUE KEY `id_comanda` (`id_comanda`,`id_medicament`),
  ADD KEY `fk_medicamente` (`id_medicament`);

--
-- Indexes for table `istoric_comenzi`
--
ALTER TABLE `istoric_comenzi`
  ADD PRIMARY KEY (`id_comanda`),
  ADD KEY `status` (`status`),
  ADD KEY `pk_client` (`id_client`);

--
-- Indexes for table `medicamente`
--
ALTER TABLE `medicamente`
  ADD PRIMARY KEY (`id_medicament`),
  ADD KEY `fk_id_producator` (`id_producator`);

--
-- Indexes for table `producatori`
--
ALTER TABLE `producatori`
  ADD PRIMARY KEY (`id_producator`),
  ADD UNIQUE KEY `telefon` (`telefon`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `prospecte`
--
ALTER TABLE `prospecte`
  ADD PRIMARY KEY (`id_prospect`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clienti`
--
ALTER TABLE `clienti`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comenzi`
--
ALTER TABLE `comenzi`
  MODIFY `id_comanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `istoric_comenzi`
--
ALTER TABLE `istoric_comenzi`
  MODIFY `id_comanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `medicamente`
--
ALTER TABLE `medicamente`
  MODIFY `id_medicament` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `producatori`
--
ALTER TABLE `producatori`
  MODIFY `id_producator` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prospecte`
--
ALTER TABLE `prospecte`
  MODIFY `id_prospect` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comenzi`
--
ALTER TABLE `comenzi`
  ADD CONSTRAINT `pk_comanda_client` FOREIGN KEY (`id_client`) REFERENCES `clienti` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `continut_comanda`
--
ALTER TABLE `continut_comanda`
  ADD CONSTRAINT `fk_comanda` FOREIGN KEY (`id_comanda`) REFERENCES `comenzi` (`id_comanda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_medicamente` FOREIGN KEY (`id_medicament`) REFERENCES `medicamente` (`id_medicament`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `istoric_comenzi`
--
ALTER TABLE `istoric_comenzi`
  ADD CONSTRAINT `pk_client` FOREIGN KEY (`id_client`) REFERENCES `comenzi` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pk_comanda` FOREIGN KEY (`id_comanda`) REFERENCES `comenzi` (`id_comanda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicamente`
--
ALTER TABLE `medicamente`
  ADD CONSTRAINT `fk_id_producator` FOREIGN KEY (`id_producator`) REFERENCES `producatori` (`id_producator`) ON UPDATE CASCADE;

--
-- Constraints for table `prospecte`
--
ALTER TABLE `prospecte`
  ADD CONSTRAINT `fk_medicament_prospect` FOREIGN KEY (`id_prospect`) REFERENCES `medicamente` (`id_medicament`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
