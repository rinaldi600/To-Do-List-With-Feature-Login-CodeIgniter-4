-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Agu 2021 pada 17.18
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `account`
--

INSERT INTO `account` (`id`, `email`, `username`, `password`) VALUES
(5, 'rinaldihendrawan2@gmail.com', 'rinaldi600', '$2y$10$9GKOQBJ2fVWpTLYsNyCCVe3LhJzwikTdDgKQY/E1e3OAPGqFxdGuq'),
(8, 'artdraw69@gmail.com', 'Rinaldi007', '$2y$10$AyJGmB.LiarKviYyM27ZdOp6aJ1WgJ17Z9h8yb/Lgk9wpHMlNIKHG'),
(23, 'rinaldihendrawan007@gmail.com', 'rinaldi500', '$2y$10$mZHRBvjd4yfx4dZA6EhJOeFHnxKSJBpzKeiihRV81Yls1BfwaNJ8i');

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_token`
--

CREATE TABLE `auth_token` (
  `id` int(11) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `auth_token`
--

INSERT INTO `auth_token` (`id`, `email`, `token`) VALUES
(16, 'rinaldihendrawan007@gmail.com', '49cefdf16a1ae9cb34a3a746f34608de54cb3b563fcdfda7cd324f0e1c530a85'),
(17, 'artdraw69@gmail.com', '4a303199eca3483b7c2941dc66e142cc7b98469f35b1e8a3f7d6d9bbbacdff95'),
(18, 'rinaldihendrawan2@gmail.com', '2de18646055b31c31462e857ab355af4739262ba76e31dc84ed1bd718bbdcf45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `list`
--

CREATE TABLE `list` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `username` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `list`
--

INSERT INTO `list` (`id`, `text`, `username`, `created_at`, `updated_at`) VALUES
(3, 'Dr. Ir. H. Soekarno adalah Presiden pertama Republik Indonesia yang menjabat pada periode 1945–1967. Ia memainkan peranan penting dalam memerdekakan bangsa Indonesia dari penjajahan Belanda.', 'rinaldi600', '2021-07-19 05:08:34', '2021-07-19 05:08:34'),
(8, 'New', 'Rinaldi007', '2021-07-22 04:39:57', '2021-07-22 04:39:57'),
(12, 'Jenderal Besar TNI (Purn.) H. M. Soeharto, (bahasa Jawa: Suharta atau Suhartå; Hanacaraka:ꦯꦸꦲꦂꦠ; ER, EYD: Suharto; lahir di Kemusuk, Yogyakarta, 8 Juni 1921 – meninggal di Jakarta, 27 Januari 2008 pada umur 86 tahun) adalah Presiden kedua Indonesia yang menjabat dari tahun 1967 sampai 1998, menggantikan Soekarno. Di dunia internasional, terutama di Dunia Barat, Soeharto sering dirujuk dengan sebutan populer \"The Smiling General\" (bahasa Indonesia: \"Sang Jenderal yang Tersenyum\") karena raut mukanya yang senantiasa tersenyum dan menunjukkan keramahan. Meski begitu, dengan berbagai kontroversi yang terjadi ia sering juga disebut sebagai otoriter bagi yang berseberangan dengannya.', 'rinaldi600', '2021-08-02 14:00:37', '2021-08-02 14:00:37');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD KEY `username_2` (`username`);

--
-- Indeks untuk tabel `auth_token`
--
ALTER TABLE `auth_token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD UNIQUE KEY `email_3` (`email`),
  ADD KEY `email` (`email`),
  ADD KEY `email_2` (`email`);

--
-- Indeks untuk tabel `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `username_2` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `auth_token`
--
ALTER TABLE `auth_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `list`
--
ALTER TABLE `list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `auth_token`
--
ALTER TABLE `auth_token`
  ADD CONSTRAINT `auth_token_ibfk_1` FOREIGN KEY (`email`) REFERENCES `account` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `list_ibfk_1` FOREIGN KEY (`username`) REFERENCES `account` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
