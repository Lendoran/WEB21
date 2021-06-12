-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 07, 2021 at 07:58 PM
-- Server version: 5.7.11
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `obchod`
--
CREATE DATABASE IF NOT EXISTS `obchod` DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci;
USE `obchod`;

-- --------------------------------------------------------

--
-- Table structure for table `produkty`
--

CREATE TABLE `produkty` (
  `id` int(11) NOT NULL,
  `kod` int(11) NOT NULL,
  `jmeno` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `sklad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`id`, `kod`, `jmeno`, `cena`, `sklad`) VALUES
(3, 745863783, 'Rohlík', '1.90', 1000),
(4, 753897337, 'Chleba', '19.90', 200),
(5, 354876214, 'Tvarohový koláč', '9.90', 120),
(6, 498487621, 'Celozrnný rohlík', '3.50', 360);

-- --------------------------------------------------------

--
-- Table structure for table `uzivatele`
--

CREATE TABLE `uzivatele` (
  `id` int(11) NOT NULL,
  `uzivatel_jmeno` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `crypto_password` varchar(96) COLLATE utf8_czech_ci NOT NULL,
  `zakaznicka_karta` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `uzivatele`
--
ALTER TABLE `uzivatele`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;