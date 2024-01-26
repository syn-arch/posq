-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 26, 2024 at 02:03 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posq`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses_role`
--

CREATE TABLE `akses_role` (
  `akses_role` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `c` int(11) NOT NULL,
  `u` int(11) NOT NULL,
  `d` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akses_role`
--

INSERT INTO `akses_role` (`akses_role`, `id_menu`, `id_role`, `c`, `u`, `d`) VALUES
(416, 1, 1, 0, 0, 0),
(417, 10, 1, 1, 1, 1),
(418, 11, 1, 0, 0, 0),
(419, 22, 1, 0, 0, 0),
(420, 23, 1, 0, 0, 0),
(421, 24, 1, 0, 0, 0),
(422, 27, 1, 0, 0, 0),
(423, 62, 1, 0, 0, 0),
(424, 64, 1, 0, 0, 0),
(425, 76, 1, 1, 1, 1),
(426, 77, 1, 1, 1, 1),
(427, 78, 1, 1, 1, 1),
(428, 79, 1, 1, 1, 1),
(429, 80, 1, 0, 0, 0),
(430, 81, 1, 1, 1, 1),
(431, 85, 1, 0, 0, 0),
(432, 87, 1, 0, 0, 0),
(433, 88, 1, 0, 0, 0),
(434, 89, 1, 0, 0, 0),
(435, 91, 1, 0, 0, 0),
(436, 92, 1, 1, 1, 1),
(437, 93, 1, 1, 1, 1),
(438, 94, 1, 0, 0, 0),
(439, 95, 1, 0, 0, 0),
(440, 96, 1, 1, 1, 1),
(441, 97, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE `backup` (
  `id_backup` int(11) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `file` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_detail_pembelian` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_modal` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id_detail_pembelian`, `id_pembelian`, `id_produk`, `nama_produk`, `qty`, `harga_modal`, `harga_jual`, `total_harga`) VALUES
(1, 1, 1, '1 Set Komputer 17-10100F 3060 TI 16GB DDR4', 10, 8000000, 13500000, 135000000),
(2, 2, 2, 'Laptop Acer Swift 3', 6, 2500000, 4500000, 27000000);

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail_penjualan` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_modal` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail_penjualan`, `id_penjualan`, `id_produk`, `nama_produk`, `qty`, `harga_modal`, `harga_jual`, `total_harga`) VALUES
(42, 6, 1, '1 Set Komputer 17-10100F 3060 TI 16GB DDR4', 1, 8000000, 13500000, 13500000),
(43, 6, 2, 'Laptop Acer Swift 3', 1, 2500000, 4500000, 4500000),
(44, 7, 1, '1 Set Komputer 17-10100F 3060 TI 16GB DDR4', 4, 8000000, 13500000, 54000000),
(45, 8, 1, '1 Set Komputer 17-10100F 3060 TI 16GB DDR4', 5, 8000000, 13500000, 67500000),
(46, 8, 2, 'Laptop Acer Swift 3', 4, 2500000, 4500000, 18000000),
(47, 9, 2, 'Laptop Acer Swift 3', 1, 2500000, 4500000, 4500000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Uncategoriez');

-- --------------------------------------------------------

--
-- Table structure for table `marketplace`
--

CREATE TABLE `marketplace` (
  `id_marketplace` int(11) NOT NULL,
  `nama_marketplace` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `link_toko` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `marketplace`
--

INSERT INTO `marketplace` (`id_marketplace`, `nama_marketplace`, `gambar`, `link_toko`) VALUES
(1, 'Shopee', 'shopee.png', '-'),
(2, 'Tokopedia', 'tokopedia.jpg', '-');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `ada_submenu` int(11) NOT NULL,
  `submenu` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `urutan` int(11) NOT NULL,
  `crudable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `icon`, `ada_submenu`, `submenu`, `url`, `urutan`, `crudable`) VALUES
(1, 'Dashboard', 'fa fa-tachometer-alt', 0, 0, 'dashboard', 1, 0),
(10, 'Data Sales', 'fas fa-user-shield', 0, 87, 'user', 1, 1),
(11, 'Akses Menu Sales', 'fas fa-shield-alt', 0, 87, 'user/akses', 2, 0),
(22, 'Profil Saya', 'fa fa-user', 0, 0, 'profil', 8, 0),
(23, 'Utilitas', 'fas fa-cog', 1, 0, 'utilitas', 7, 0),
(24, 'Backup Database', 'fas fa-database', 0, 23, 'utilitas/backup', 1, 0),
(27, 'Pengaturan', 'fas fa-cogs', 0, 0, 'pengaturan', 9, 0),
(62, 'Pengelola Menu', 'fa fa-bars', 0, 23, 'menu', 3, 0),
(64, 'CRUD Generator', 'fas fa-edit', 0, 23, 'utilitas/crud_generator', 2, 0),
(76, 'Data Pelanggan', 'fas fa-user-check', 0, 88, 'pelanggan', 1, 1),
(77, 'Data Supplier', 'fas fa-box', 0, 88, 'supplier', 2, 1),
(78, 'Data Kategori', 'fas fa-tags', 0, 88, 'kategori', 3, 1),
(79, 'Data Produk', 'fas fa-box-open', 0, 88, 'produk', 4, 1),
(80, 'Penjualan Baru', 'fas fa-cart-arrow-down', 0, 89, 'penjualan/create', 1, 0),
(81, 'Riwayat Penjualan', 'fas fa-shopping-cart', 0, 89, 'penjualan', 2, 1),
(85, 'Laporan Penjualan', 'fas fa-book', 0, 91, 'laporan/penjualan', 1, 0),
(87, 'Sales', 'fas fa-user-circle', 1, 0, '#', 2, 0),
(88, 'Master', 'fas fa-check-circle', 1, 0, '#', 3, 0),
(89, 'Penjualan', 'fas fa-cart-arrow-down', 1, 0, '#', 4, 0),
(91, 'Laporan', 'fas fa-book', 1, 0, '#', 6, 0),
(92, 'Data Marketplace', 'fas fa-store', 0, 88, 'marketplace', 5, 1),
(93, 'Status Pesanan', 'fas fa-shapes', 0, 88, 'status', 6, 1),
(94, 'Pembelian', 'fas fa-cart-plus', 1, 0, '#', 5, 0),
(95, 'Pembelian Baru', 'fas fa-cart-plus', 0, 94, 'pembelian/create', 1, 0),
(96, 'Riwayat Pembelian', 'fas fa-cart-plus', 0, 94, 'pembelian', 2, 1),
(97, 'Laporan Pembelian', 'fas fa-book', 0, 91, 'laporan/pembelian', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `no_telepon`, `email`) VALUES
(1, 'Umum', '-', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_marketplace` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `nomor_invoice` varchar(255) NOT NULL,
  `no_pesanan` varchar(255) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sub_total` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_user`, `id_marketplace`, `id_status`, `nomor_invoice`, `no_pesanan`, `nama_pelanggan`, `alamat`, `telepon`, `tanggal`, `sub_total`, `diskon`, `total`, `bayar`, `keterangan`) VALUES
(1, 0, 1, 1, 'INV0000001', '', '', '', '', '2024-01-26 12:34:12', 135000000, 0, 135000000, 135000000, ''),
(2, 0, 1, 1, 'INV0000002', '', '', '', '', '2024-01-26 12:34:30', 27000000, 0, 27000000, 27000000, '');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id_pengaturan` int(11) NOT NULL,
  `nama_aplikasi` varchar(255) NOT NULL,
  `logo` varchar(128) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `smtp_host` varchar(128) NOT NULL,
  `smtp_email` varchar(128) NOT NULL,
  `smtp_username` varchar(128) NOT NULL,
  `smtp_password` varchar(128) NOT NULL,
  `smtp_port` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id_pengaturan`, `nama_aplikasi`, `logo`, `favicon`, `smtp_host`, `smtp_email`, `smtp_username`, `smtp_password`, `smtp_port`) VALUES
(1, 'CODEIGNITER ROCKS', 'layers.png', 'favicon.ico', 'ssl://smtp.gmail.com', 'email@email.com', 'email@email.com', 'password', 465);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_marketplace` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `nomor_invoice` varchar(255) NOT NULL,
  `no_pesanan` varchar(255) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sub_total` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `id_marketplace`, `id_status`, `nomor_invoice`, `no_pesanan`, `nama_pelanggan`, `alamat`, `telepon`, `tanggal`, `sub_total`, `diskon`, `total`, `bayar`, `keterangan`) VALUES
(6, 0, 1, 1, '00122', 'FJK123', 'adi11123', 'Bandung12312312', '085864273756112312312', '2024-01-04 11:05:32', 18000000, 0, 18000000, 20000000, ''),
(7, 0, 1, 3, '123', '1232', 'dias', '123', '33444', '2024-01-04 11:05:08', 54000000, 0, 54000000, 55000000, ''),
(8, 0, 1, 1, 'INV0000008', '', '', '', '', '2024-01-26 10:39:01', 85500000, 0, 85500000, 90000000, ''),
(9, 0, 1, 1, 'INV0000009', '', '', '', '', '2024-01-01 10:39:27', 4500000, 0, 4500000, 4000000, '');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga_modal` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok` float NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `harga_modal`, `harga_jual`, `stok`, `satuan`, `gambar`, `keterangan`) VALUES
(1, 1, '1 Set Komputer 17-10100F 3060 TI 16GB DDR4', 8000000, 13500000, 100, '', '20f535c616bbe807a1166e5661b396fd.jpg', '-'),
(2, 1, 'Laptop Acer Swift 3', 2500000, 4500000, 100, '', 'default.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama_role`) VALUES
(1, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id_status` int(11) NOT NULL,
  `nama_status` varchar(255) NOT NULL,
  `warna` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id_status`, `nama_status`, `warna`) VALUES
(1, 'Pesanan Baru', 'info'),
(2, 'Diproses', 'warning'),
(3, 'Terkirim', 'success');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `no_telepon`, `email`) VALUES
(1, 'PT. Jaka Laras Suaka Indonesia', '-', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `token_user`
--

CREATE TABLE `token_user` (
  `id` int(11) NOT NULL,
  `id_user` char(10) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` char(10) NOT NULL,
  `nama_user` varchar(128) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `telepon` char(12) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(128) NOT NULL,
  `gambar` varchar(128) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `alamat`, `jk`, `telepon`, `email`, `password`, `gambar`, `id_role`) VALUES
('PTS00001', 'Administrator', 'Bandung', 'L', '085864273756', 'admin@admin.com', '$2y$10$t2LIGNkyTgoo.wfFq65HU.RMH3.maKSCVMYL1.ix0l.xZjAOfi1PK', 'man-1.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses_role`
--
ALTER TABLE `akses_role`
  ADD PRIMARY KEY (`akses_role`);

--
-- Indexes for table `backup`
--
ALTER TABLE `backup`
  ADD PRIMARY KEY (`id_backup`);

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id_detail_pembelian`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail_penjualan`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `marketplace`
--
ALTER TABLE `marketplace`
  ADD PRIMARY KEY (`id_marketplace`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id_pengaturan`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `token_user`
--
ALTER TABLE `token_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses_role`
--
ALTER TABLE `akses_role`
  MODIFY `akses_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=442;

--
-- AUTO_INCREMENT for table `backup`
--
ALTER TABLE `backup`
  MODIFY `id_backup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `id_detail_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marketplace`
--
ALTER TABLE `marketplace`
  MODIFY `id_marketplace` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id_pengaturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `token_user`
--
ALTER TABLE `token_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
