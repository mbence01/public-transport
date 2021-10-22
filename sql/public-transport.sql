-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Gép: localhost:3306
-- Létrehozás ideje: 2021. Okt 22. 04:55
-- Kiszolgáló verziója: 8.0.26-0ubuntu0.20.04.3
-- PHP verzió: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `public-transport`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `busz`
--

CREATE TABLE `busz` (
  `rendszam` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tipus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ev` date NOT NULL,
  `sofor_szemelyi_szam` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `indul`
--

CREATE TABLE `indul` (
  `indulasi_ora` int DEFAULT NULL,
  `indulasi_perc` int DEFAULT NULL,
  `indulasi_nap` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `jarat_megnevezes` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jarat`
--

CREATE TABLE `jarat` (
  `megnevezes` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `menetido` int NOT NULL,
  `megallok_szama` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jegy`
--

CREATE TABLE `jegy` (
  `id` int NOT NULL,
  `jarat_megnevezes` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `datum` datetime NOT NULL,
  `felhasznalva` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `megall`
--

CREATE TABLE `megall` (
  `megallo_id` int DEFAULT NULL,
  `jarat_megnevezes` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sorszam` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `megallo`
--

CREATE TABLE `megallo` (
  `id` int NOT NULL,
  `nev` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `menetrend`
--

CREATE TABLE `menetrend` (
  `indulasi_ora` int NOT NULL,
  `indulasi_perc` int NOT NULL,
  `indulasi_nap` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sofor_szemelyi_szam` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sofor`
--

CREATE TABLE `sofor` (
  `vezeteknev` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `keresztnev` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `szemelyi_szam` int NOT NULL,
  `csatlakozas_datuma` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `busz`
--
ALTER TABLE `busz`
  ADD PRIMARY KEY (`rendszam`),
  ADD KEY `sofor_szemelyi_szam` (`sofor_szemelyi_szam`);

--
-- A tábla indexei `indul`
--
ALTER TABLE `indul`
  ADD KEY `indulasi_ora` (`indulasi_ora`),
  ADD KEY `indulasi_perc` (`indulasi_perc`),
  ADD KEY `indulasi_nap` (`indulasi_nap`),
  ADD KEY `jarat_megnevezes` (`jarat_megnevezes`);

--
-- A tábla indexei `jarat`
--
ALTER TABLE `jarat`
  ADD PRIMARY KEY (`megnevezes`);

--
-- A tábla indexei `jegy`
--
ALTER TABLE `jegy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jarat_megnevezes` (`jarat_megnevezes`);

--
-- A tábla indexei `megall`
--
ALTER TABLE `megall`
  ADD KEY `megallo_id` (`megallo_id`),
  ADD KEY `jarat_megnevezes` (`jarat_megnevezes`);

--
-- A tábla indexei `megallo`
--
ALTER TABLE `megallo`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `menetrend`
--
ALTER TABLE `menetrend`
  ADD PRIMARY KEY (`indulasi_ora`,`indulasi_perc`,`indulasi_nap`),
  ADD KEY `sofor_szemelyi_szam` (`sofor_szemelyi_szam`);

--
-- A tábla indexei `sofor`
--
ALTER TABLE `sofor`
  ADD PRIMARY KEY (`szemelyi_szam`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `jegy`
--
ALTER TABLE `jegy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `megallo`
--
ALTER TABLE `megallo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `busz`
--
ALTER TABLE `busz`
  ADD CONSTRAINT `busz_ibfk_1` FOREIGN KEY (`sofor_szemelyi_szam`) REFERENCES `sofor` (`szemelyi_szam`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `indul`
--
ALTER TABLE `indul`
  ADD CONSTRAINT `indul_ibfk_1` FOREIGN KEY (`jarat_megnevezes`) REFERENCES `jarat` (`megnevezes`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `indul_ibfk_2` FOREIGN KEY (`indulasi_ora`) REFERENCES `menetrend` (`indulasi_ora`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `jegy`
--
ALTER TABLE `jegy`
  ADD CONSTRAINT `jegy_ibfk_1` FOREIGN KEY (`jarat_megnevezes`) REFERENCES `jarat` (`megnevezes`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `megall`
--
ALTER TABLE `megall`
  ADD CONSTRAINT `megall_ibfk_1` FOREIGN KEY (`jarat_megnevezes`) REFERENCES `jarat` (`megnevezes`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `megall_ibfk_2` FOREIGN KEY (`megallo_id`) REFERENCES `megallo` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `menetrend`
--
ALTER TABLE `menetrend`
  ADD CONSTRAINT `menetrend_ibfk_1` FOREIGN KEY (`sofor_szemelyi_szam`) REFERENCES `sofor` (`szemelyi_szam`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
