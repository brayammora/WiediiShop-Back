-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 15, 2019 at 09:28 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `WiediiShop`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `idProduct` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` varchar(200) NOT NULL,
  `barcode` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`idProduct`, `name`, `price`, `barcode`) VALUES
(1, 'Galletas Festival', '1000', '11111'),
(2, 'Minichips', '800', '11112'),
(3, 'Jugo Hit', '1600', '11113'),
(4, 'Chocolatina Pequeña', '500', '11114'),
(5, 'Mani', '600', '11115');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `idPurchase` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `datePurchase` date NOT NULL,
  `datePayment` date NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `document` varchar(200) NOT NULL,
  `mail` varchar(200) NOT NULL,
  `fingerprint` varchar(200) DEFAULT NULL,
  `rol` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `name`, `document`, `mail`, `fingerprint`, `rol`, `password`) VALUES
(1, 'Brayam Mora', '111111', 'brayam.mora@wiedii.co', '1111', NULL, NULL),
(3, 'Nicola Di Candia', '333333', 'nicola.dicandia@wiedii.co', '3333', NULL, NULL),
(5, 'Yorluis Vega', '555555', 'yorluis.vega@wiedii.co', '5555', NULL, NULL),
(7, 'Andres Carrillo', '666666', 'andres.carrillo@wiedii.co', '6666', NULL, NULL),
(8, 'Renzon Caceres', '777777', 'renzon.caceres@wiedii.co', '7777', NULL, NULL),
(12, 'Juan Mora', '222222', 'juan.mora@correo.com', '2222', 'admin', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`idProduct`),
  ADD UNIQUE KEY `barcode` (`barcode`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`idPurchase`),
  ADD KEY `fk_purchase_product` (`idProduct`),
  ADD KEY `fk_purchase_user` (`idUser`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `document` (`document`),
  ADD UNIQUE KEY `fingerprint` (`fingerprint`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `idProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `idPurchase` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `fk_purchase_product` FOREIGN KEY (`idProduct`) REFERENCES `product` (`idProduct`),
  ADD CONSTRAINT `fk_purchase_user` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);
