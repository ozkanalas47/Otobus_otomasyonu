-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 09 Haz 2025, 19:55:56
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `otobus`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `otobus`
--

CREATE TABLE `otobus` (
  `otobus_id` int(11) NOT NULL,
  `otobus_no` varchar(50) DEFAULT NULL,
  `plaka` varchar(20) DEFAULT NULL,
  `firma` varchar(100) DEFAULT NULL,
  `kapasite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `otobus`
--

INSERT INTO `otobus` (`otobus_id`, `otobus_no`, `plaka`, `firma`, `kapasite`) VALUES
(1, 'OT1', '47ABC47', 'Mardin Seyahat', 40),
(2, 'OT2', '49XYZ49', 'Mus Seyahat', 50),
(3, 'OT3', '21QWE21', 'Diyarbakir Seyahat', 20);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rezervasyon`
--

CREATE TABLE `rezervasyon` (
  `rezervasyon_id` int(11) NOT NULL,
  `sefer_id` int(11) DEFAULT NULL,
  `tarih` datetime DEFAULT NULL,
  `tutar` decimal(10,2) DEFAULT NULL,
  `durum` varchar(20) DEFAULT NULL,
  `odeme_tipi` varchar(20) DEFAULT NULL,
  `odeme_durumu` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `rezervasyon`
--

INSERT INTO `rezervasyon` (`rezervasyon_id`, `sefer_id`, `tarih`, `tutar`, `durum`, `odeme_tipi`, `odeme_durumu`) VALUES
(1, 1, '2025-05-29 09:00:00', 900.00, 'beklemede', 'kredi_karti', 'beklemede'),
(2, 2, '2025-05-29 09:05:00', 300.00, 'beklemede', 'online', 'beklemede'),
(3, 1, '2025-05-29 10:00:00', 900.00, 'onaylandi', 'kredi_karti', 'tamamlandi'),
(4, 1, '2025-06-08 08:32:45', 900.00, 'iptal', 'kredi_karti', 'beklemede');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sefer`
--

CREATE TABLE `sefer` (
  `sefer_id` int(11) NOT NULL,
  `otobus_id` int(11) DEFAULT NULL,
  `nereden` varchar(100) DEFAULT NULL,
  `nereye` varchar(100) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  `kalkis_saat` time DEFAULT NULL,
  `varis_saat` time DEFAULT NULL,
  `ucret` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `sefer`
--

INSERT INTO `sefer` (`sefer_id`, `otobus_id`, `nereden`, `nereye`, `tarih`, `kalkis_saat`, `varis_saat`, `ucret`) VALUES
(1, 1, 'Mardin', 'Agri', '2025-05-30', '08:00:00', '14:00:00', 900.00),
(2, 2, 'Agri', 'Mus', '2025-05-30', '09:00:00', '17:30:00', 300.00);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yolcu`
--

CREATE TABLE `yolcu` (
  `yolcu_id` int(11) NOT NULL,
  `rezervasyon_id` int(11) DEFAULT NULL,
  `ad` varchar(100) DEFAULT NULL,
  `cinsiyet` varchar(10) DEFAULT NULL,
  `telefon` varchar(15) DEFAULT NULL,
  `koltuk_no` varchar(10) DEFAULT NULL,
  `koltuk_durum` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yolcu`
--

INSERT INTO `yolcu` (`yolcu_id`, `rezervasyon_id`, `ad`, `cinsiyet`, `telefon`, `koltuk_no`, `koltuk_durum`) VALUES
(1, 1, 'Mehmet Demir', 'erkek', '5551112233', 'K1', 'rezerve'),
(2, 2, 'Ayse Yilmaz', 'kadin', '5552223344', 'K2', 'rezerve'),
(3, 3, 'Fatma Sahin', 'kadin', '5553334455', 'K3', 'rezerve'),
(4, 4, 'Mehmet Demir', 'erkek', '05066561936', 'K1', 'rezerve');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `otobus`
--
ALTER TABLE `otobus`
  ADD PRIMARY KEY (`otobus_id`);

--
-- Tablo için indeksler `rezervasyon`
--
ALTER TABLE `rezervasyon`
  ADD PRIMARY KEY (`rezervasyon_id`);

--
-- Tablo için indeksler `sefer`
--
ALTER TABLE `sefer`
  ADD PRIMARY KEY (`sefer_id`);

--
-- Tablo için indeksler `yolcu`
--
ALTER TABLE `yolcu`
  ADD PRIMARY KEY (`yolcu_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `otobus`
--
ALTER TABLE `otobus`
  MODIFY `otobus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `rezervasyon`
--
ALTER TABLE `rezervasyon`
  MODIFY `rezervasyon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `sefer`
--
ALTER TABLE `sefer`
  MODIFY `sefer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `yolcu`
--
ALTER TABLE `yolcu`
  MODIFY `yolcu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

