-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 26, 2019 at 02:59 PM
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
  `datePurchase` datetime NOT NULL,
  `datePayment` datetime DEFAULT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`idPurchase`, `idProduct`, `idUser`, `datePurchase`, `datePayment`, `state`) VALUES
(58, 1, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(59, 1, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(60, 1, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(61, 2, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(62, 3, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(63, 3, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(64, 4, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(65, 4, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(66, 5, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(67, 5, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(68, 5, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(69, 5, 1, '2019-11-26 07:40:43', NULL, 'SIN PAGAR'),
(70, 5, 1, '2019-11-26 07:40:43', NULL, 'DEVUELTO'),
(71, 1, 1, '2019-11-26 09:03:10', NULL, 'SIN PAGAR'),
(72, 1, 1, '2019-11-26 09:04:24', NULL, 'SIN PAGAR'),
(73, 1, 1, '2019-11-26 09:06:51', NULL, 'SIN PAGAR');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `idReturns` int(11) NOT NULL,
  `idPurchase` int(11) NOT NULL,
  `dateReturns` date NOT NULL,
  `reason` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`idReturns`, `idPurchase`, `dateReturns`, `reason`) VALUES
(39, 70, '2019-11-26', 'survey1');

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
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`idReturns`);

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
  MODIFY `idPurchase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `idReturns` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
