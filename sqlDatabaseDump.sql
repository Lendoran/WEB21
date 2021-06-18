SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `users_horeso` DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci;
USE `users_horeso`;

CREATE TABLE IF NOT EXISTS `produkty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kod` int(11) NOT NULL,
  `jmeno` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `sklad` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=16 ;

INSERT INTO `produkty` (`id`, `kod`, `jmeno`, `cena`, `sklad`) VALUES
(1, 536357162, 'Bageta', 8.90, 672),
(2, 362519685, 'Paprikáš', 29.90, 192),
(3, 745863783, 'Rohlík', 1.90, 985),
(4, 753897337, 'Chleba', 19.90, 200),
(5, 354876214, 'Tvarohový koláč', 9.90, 120),
(6, 498487621, 'Celozrnný rohlík', 3.50, 360),
(7, 791891969, 'Mléko', 13.90, 540),
(8, 246987411, 'Vajíčka 10Ks', 16.50, 430),
(9, 984651982, 'Máslo', 32.90, 215),
(10, 654165494, 'Pivní rohlík', 4.25, 630),
(11, 195497954, 'Makový koláč', 10.90, 95),
(12, 503616513, 'Pomerančový džus', 12.90, 249),
(13, 249941108, 'Jablko', 3.30, 543),
(14, 349641987, 'Párky', 39.90, 165),
(15, 349641987, 'Pomeranč', 5.90, 345);

CREATE TABLE IF NOT EXISTS `uzivatele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uzivatel_jmeno` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `crypto_password` varchar(96) COLLATE utf8_czech_ci NOT NULL,
  `zakaznicka_karta` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;
