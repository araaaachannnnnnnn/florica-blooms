-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Feb 2025 pada 14.29
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `floricablooms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Keychain'),
(2, 'Bouquet');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `shipping_method` varchar(20) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `order_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `shipping_method`, `shipping_fee`, `payment_method`, `order_date`) VALUES
(1, NULL, 20000.00, 'send', 10000.00, 'mbanking', '2025-02-10 02:11:05'),
(2, NULL, 50000.00, 'send', 10000.00, 'mbanking', '2025-02-10 04:34:14'),
(3, NULL, 50000.00, 'send', 10000.00, 'mbanking', '2025-02-10 07:00:56'),
(4, NULL, 50000.00, 'send', 10000.00, 'mbanking', '2025-02-10 07:05:36'),
(5, NULL, 50000.00, 'send', 10000.00, 'mbanking', '2025-02-10 07:08:20'),
(6, NULL, 50000.00, 'send', 10000.00, 'mbanking', '2025-02-10 07:12:20'),
(7, NULL, 50000.00, 'send', 10000.00, 'mbanking', '2025-02-10 07:12:48'),
(8, 3, 20000.00, 'send', 10000.00, 'mbanking', '2025-02-10 10:29:12'),
(9, 2, 20000.00, 'send', 10000.00, 'mbanking', '2025-02-10 16:15:14'),
(10, 2, 10000.00, 'send', 10000.00, 'mbanking', '2025-02-10 16:16:40'),
(11, 2, 20000.00, 'send', 10000.00, 'mbanking', '2025-02-10 16:22:13'),
(12, NULL, 50000.00, 'send', 10000.00, 'mbanking', '2025-02-10 16:25:28'),
(13, 2, 47500.00, 'send', 10000.00, 'mbanking', '2025-02-10 16:30:30'),
(14, 2, 47500.00, 'send', 10000.00, 'mbanking', '2025-02-10 18:13:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 20000.00),
(2, 2, 2, 1, 50000.00),
(3, 3, 2, 1, 50000.00),
(4, 4, 2, 1, 50000.00),
(5, 5, 2, 1, 50000.00),
(6, 6, 2, 1, 50000.00),
(7, 7, 2, 1, 50000.00),
(8, 8, 3, 2, 10000.00),
(9, 9, 1, 1, 20000.00),
(10, 10, 3, 1, 10000.00),
(11, 11, 1, 1, 20000.00),
(12, 12, 2, 1, 50000.00),
(13, 13, 2, 1, 47500.00),
(14, 14, 2, 1, 47500.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `category_id`) VALUES
(1, 'Keychain Cherry', 'Gantungan kunci berbentuk Cherry', 20000.00, 47, 'img/11.png', 1),
(2, 'Bouquet Tulip', 'Bungan single berbentuk Tulip', 50000.00, 491, 'img/15.png', 2),
(3, 'Keychain Random', 'Gantungan kunci bisa request', 10000.00, 97, 'img/12.png', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(2, 'tes', 'b93939873fd4923043b9dec975811f66'),
(3, 'fachri123', 'ce5ed70cc6cc094998b84b466e68fbfd'),
(4, 'admin', '4f9268d766cb3dcf4cbc912b39f6e06c'),
(5, 'fachriokokokoko', 'b93939873fd4923043b9dec975811f66');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_member`
--

CREATE TABLE `users_member` (
  `id_users_member` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `profile_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users_member`
--

INSERT INTO `users_member` (`id_users_member`, `username`, `password`, `profile_image`) VALUES
(1, 'tesss', 'b93939873fd4923043b9dec975811f66', NULL),
(2, 'tesok', 'b93939873fd4923043b9dec975811f66', 'uploads/image_from_gizlocal+5K6JZDPgaFGGBSYgcEICC.jpeg'),
(3, 'Rain', '9720d6814b12d136584137f7fdb4932c', NULL),
(4, 'lala', '412a1ed6d21e55191ee5131f266f5178', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `users_member`
--
ALTER TABLE `users_member`
  ADD PRIMARY KEY (`id_users_member`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users_member`
--
ALTER TABLE `users_member`
  MODIFY `id_users_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
