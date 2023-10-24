-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2023 at 12:11 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thrifting`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ManageStok` (IN `operator` VARCHAR(10), IN `idB` INT, IN `nama` VARCHAR(50), IN `desk` VARCHAR(100), IN `stok` INT)   BEGIN
		case operator
		when 'insert' then 
			insert into stock(nama,fdeskripsi,stok) values (nama, desk,stok);
		when 'update' then
			update stock
			set
				fdeskripsi = desk
			where id_barang = idB;
		when 'delete' then
			delete from stock
			where id_barang = idB;
		end case;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ManageTransaksi` (`operator` VARCHAR(10), `idTr` INT, `idBarang` INT, `idPekerja` INT, `jumlah` INT, `stat` VARCHAR(20))   BEGIN
	
	case operator
		when 'insert' then
			insert into transaksi(id_barang,id_pekerja,jumlah,ket) values (idBarang,idPekerja,jumlah,stat);
		when 'update' then
			update transaksi
			SET 
				transaksi.jumlah = jumlah,
				transaksi.ket = stat
				WHERE 
				idTr = id_transaksi ;
		WHEN 'delete' THEN
			DELETE FROM transaksi
			WHERE
				idTr = id_transaksi ;
	end case;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `jumlah_stok` () RETURNS INT(11)  BEGIN
	  DECLARE total_stok int;
	  SELECT SUM(stok) INTO total_stok FROM stock;
	  RETURN total_stok;
	END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `lihat_stock_barang` (`iid_barang` INT) RETURNS INT(11)  BEGIN
	DECLARE jumlah_stok INT;
	SELECT stok INTO jumlah_stok FROM stock WHERE iid_barang = id_barang;
	RETURN jumlah_stok;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `deskripsi`
--

CREATE TABLE `deskripsi` (
  `id` int(11) NOT NULL,
  `deskripsi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deskripsi`
--

INSERT INTO `deskripsi` (`id`, `deskripsi`) VALUES
(12, 'Dress'),
(13, 'Rok'),
(14, 'Kemeja'),
(15, 'Sweater'),
(17, 'Jilbab');

--
-- Triggers `deskripsi`
--
DELIMITER $$
CREATE TRIGGER `cegahDescSama` BEFORE INSERT ON `deskripsi` FOR EACH ROW BEGIN
	IF EXISTS (SELECT * FROM deskripsi WHERE deskripsi = NEW.deskripsi) THEN
	    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Deskripsi sudah ada.';
	    end if;

    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_pekerja` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_pekerja`, `username`, `pass`) VALUES
(2, 'dhea', 'dhea'),
(3, 'dita', 'dita'),
(1, 'novita', 'novita');

-- --------------------------------------------------------

--
-- Table structure for table `pekerja`
--

CREATE TABLE `pekerja` (
  `id_pekerja` int(11) NOT NULL,
  `nama_pekerja` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pekerja`
--

INSERT INTO `pekerja` (`id_pekerja`, `nama_pekerja`) VALUES
(1, 'Novita'),
(2, 'Dhea'),
(3, 'Dita');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id_barang` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `fdeskripsi` int(11) NOT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id_barang`, `nama`, `fdeskripsi`, `stok`) VALUES
(20, 'Denim', 15, 14),
(21, 'Flanel', 14, 25),
(22, 'Linen', 14, 10),
(23, 'Midi', 13, 40),
(24, 'Flare', 13, 20),
(26, 'Shinwa', 17, 25);

--
-- Triggers `stock`
--
DELIMITER $$
CREATE TRIGGER `cegahBarangSama` BEFORE INSERT ON `stock` FOR EACH ROW BEGIN
	    IF EXISTS (SELECT * FROM stock WHERE nama = NEW.nama) THEN
	    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Barang sudah ada.';
	    END IF;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_pekerja` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ket` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_barang`, `id_pekerja`, `jumlah`, `tanggal`, `ket`) VALUES
(70, 20, 2, 2, '2023-04-01 06:51:40', 'Out'),
(71, 23, 2, 5, '2023-04-01 06:51:51', 'Masuk'),
(73, 20, 2, 2, '2023-04-11 13:49:10', 'Masuk'),
(75, 20, 2, 5, '2023-04-12 03:19:24', 'Masuk'),
(76, 20, 2, 6, '2023-04-12 03:20:02', 'Out'),
(77, 26, 2, 10, '2023-04-12 03:21:46', 'Masuk'),
(78, 26, 2, 5, '2023-04-12 03:22:03', 'Out');

--
-- Triggers `transaksi`
--
DELIMITER $$
CREATE TRIGGER `TransaksiBarang_BI` BEFORE INSERT ON `transaksi` FOR EACH ROW BEGIN
    declare stok_saat_ini int;
    IF NEW.ket = 'Masuk' THEN
	update stock as s 
		set s.stok = s.stok + NEW.jumlah WHERE s.id_barang = NEW.id_barang;
    ELSEIF NEW.ket = 'Out' THEN
        SELECT stok INTO stok_saat_ini FROM stock WHERE stock.id_barang = NEW.id_barang;
        IF NEW.jumlah > stok_saat_ini THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok barang saat ini tidak mencukupi.';
        ELSE
            UPDATE stock AS s SET s.stok = s.stok - NEW.jumlah WHERE s.id_barang = NEW.id_barang;
        END IF;
    END IF;


    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TransaksiBarang_BU` BEFORE UPDATE ON `transaksi` FOR EACH ROW BEGIN
	declare stok_awal int;
        IF NEW.ket = 'Masuk' THEN
            UPDATE stock SET stok = stok - OLD.jumlah + NEW.jumlah WHERE id_barang = NEW.id_barang;
        ELSEIF NEW.ket = 'Out' THEN
            set stok_awal = (select stok from stock where id_barang = new.id_barang) + old.jumlah;
            IF NEW.jumlah > stok_awal THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok barang tidak mencukupi. Silahkan hubungi suplier';
            ELSE
                UPDATE stock SET stok = stok_awal - NEW.jumlah WHERE id_barang = NEW.id_barang;
            END IF;
        END IF;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TransaksiDelete` AFTER DELETE ON `transaksi` FOR EACH ROW BEGIN
    if old.ket = 'Masuk' then
	update stock set
		stok = stok - old.jumlah
		where stock.id_barang = old.id_barang;
    elseif old.ket = 'Out'THEN
	UPDATE stock SET
		stok = stok + old.jumlah
		WHERE stock.id_barang = old.id_barang;
		end if;

    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_stock`
-- (See below for the actual view)
--
CREATE TABLE `view_stock` (
`nama` varchar(50)
,`stok` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_transaksi_stock`
-- (See below for the actual view)
--
CREATE TABLE `view_transaksi_stock` (
`id_barang` int(11)
,`nama_barang` varchar(50)
,`jumlah` int(11)
,`ket` varchar(10)
,`tanggal` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `view_stock`
--
DROP TABLE IF EXISTS `view_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_stock`  AS SELECT `stock`.`nama` AS `nama`, `stock`.`stok` AS `stok` FROM `stock``stock`  ;

-- --------------------------------------------------------

--
-- Structure for view `view_transaksi_stock`
--
DROP TABLE IF EXISTS `view_transaksi_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_transaksi_stock`  AS SELECT `stock`.`id_barang` AS `id_barang`, `stock`.`nama` AS `nama_barang`, `transaksi`.`jumlah` AS `jumlah`, `transaksi`.`ket` AS `ket`, `transaksi`.`tanggal` AS `tanggal` FROM (`transaksi` join `stock` on(`transaksi`.`id_barang` = `stock`.`id_barang`))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deskripsi`
--
ALTER TABLE `deskripsi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`),
  ADD KEY `fk_login` (`id_pekerja`);

--
-- Indexes for table `pekerja`
--
ALTER TABLE `pekerja`
  ADD PRIMARY KEY (`id_pekerja`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `deskripsi` (`fdeskripsi`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_pekerja` (`id_pekerja`),
  ADD KEY `transaksi_ibfk_1` (`id_barang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deskripsi`
--
ALTER TABLE `deskripsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pekerja`
--
ALTER TABLE `pekerja`
  MODIFY `id_pekerja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `fk_login` FOREIGN KEY (`id_pekerja`) REFERENCES `pekerja` (`id_pekerja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`fdeskripsi`) REFERENCES `deskripsi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_pekerja` FOREIGN KEY (`id_pekerja`) REFERENCES `pekerja` (`id_pekerja`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `stock` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
