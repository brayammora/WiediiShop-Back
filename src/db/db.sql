-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 29, 2019 at 12:37 PM
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
(90, 1, 12, '2019-11-26 15:29:00', NULL, 'SIN PAGAR'),
(91, 1, 12, '2019-11-26 15:30:22', NULL, 'SIN PAGAR'),
(92, 1, 12, '2019-11-26 16:02:15', NULL, 'SIN PAGAR'),
(100, 1, 1, '2019-11-27 08:13:34', NULL, 'SIN PAGAR'),
(101, 1, 1, '2019-11-27 11:18:08', NULL, 'SIN PAGAR'),
(102, 1, 1, '2019-11-27 11:18:08', NULL, 'SIN PAGAR'),
(103, 1, 1, '2019-11-27 11:18:08', NULL, 'SIN PAGAR'),
(104, 2, 1, '2019-11-27 11:18:08', NULL, 'SIN PAGAR'),
(105, 2, 1, '2019-11-27 11:18:08', NULL, 'SIN PAGAR'),
(106, 2, 1, '2019-11-27 11:18:08', NULL, 'SIN PAGAR'),
(107, 2, 1, '2019-11-27 11:18:08', NULL, 'SIN PAGAR'),
(108, 1, 1, '2019-11-27 11:21:00', NULL, 'SIN PAGAR'),
(109, 2, 1, '2019-11-27 11:21:00', NULL, 'SIN PAGAR'),
(110, 1, 1, '2019-11-27 16:26:53', NULL, 'SIN PAGAR');

--
-- Triggers `purchase`
--
DELIMITER $$
CREATE TRIGGER `actualizarTotal` BEFORE INSERT ON `purchase` FOR EACH ROW UPDATE user as a
	INNER JOIN 
	(
  	  		select b.idUser as idUser, SUM(product.price) as total
  			 from product
  	   inner join purchase on (purchase.idProduct = product.idProduct)
  	   inner join user b on (b.idUser = NEW.idUser and b.idUser = purchase.idUser)
  	     group by 1
	) as x ON (a.idUser = x.idUser)
	SET debt = x.total
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `idReturns` int(11) NOT NULL,
  `idPurchase` int(11) NOT NULL,
  `dateReturns` datetime NOT NULL,
  `reason` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`idReturns`, `idPurchase`, `dateReturns`, `reason`) VALUES
(58, 95, '2019-11-27 10:26:27', 'Producto en mal estado o vencido.'),
(59, 95, '2019-11-27 10:33:23', 'Producto en mal estado o vencido.'),
(60, 109, '2019-11-27 11:21:46', 'Producto en mal estado o vencido.'),
(61, 95, '2019-11-27 13:39:40', 'Producto en mal estado o vencido.'),
(62, 95, '2019-11-27 13:39:51', 'Producto en mal estado o vencido.'),
(63, 94, '2019-11-27 13:40:00', 'Producto en mal estado o vencido.'),
(64, 108, '2019-11-27 13:43:36', 'Producto en mal estado o vencido.');

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
  `password` varchar(200) DEFAULT NULL,
  `debt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `name`, `document`, `mail`, `fingerprint`, `rol`, `password`, `debt`) VALUES
(1, 'Brayam Mora', '111111', 'brayam.mora@wiedii.co', '1111', NULL, NULL, 9000),
(3, 'Nicola Di Candia', '333333', 'nicola.dicandia@wiedii.co', '3333', NULL, NULL, NULL),
(5, 'Yorluis Vega', '555555', 'yorluis.vega@wiedii.co', '5555', NULL, NULL, NULL),
(7, 'Andres Carrillo', '666666', 'andres.carrillo@wiedii.co', '6666', NULL, NULL, NULL),
(8, 'Renzon Caceres', '777777', 'renzon.caceres@wiedii.co', '7777', NULL, NULL, NULL),
(12, 'Juan Mora', '222222', 'juan.mora@correo.com', '2222', 'admin', '1234', 9000);

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
  MODIFY `idPurchase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `idReturns` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

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
