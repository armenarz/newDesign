-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 06 2019 г., 21:32
-- Версия сервера: 5.1.53
-- Версия PHP: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `promtest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `menuId` int(11) NOT NULL AUTO_INCREMENT,
  `menuName` tinyblob NOT NULL,
  `menuDescription` tinyblob NOT NULL,
  PRIMARY KEY (`menuId`)
) ENGINE=MyISAM  DEFAULT CHARSET=ucs2 AUTO_INCREMENT=29 ;

--
-- Дамп данных таблицы `menus`
--

INSERT INTO `menus` (`menuId`, `menuName`, `menuDescription`) VALUES
(1, 0x3c6920636c6173733d226661732066612d646976696465223e3c2f693e, 0x64697669646572),
(2, 0xd097d0b0d0bad0b0d0b7d18b, 0x20),
(3, 0xd0a0d0b5d0b7d183d0bbd18cd182d0b0d182d18b266e6273703bd182d0b5d181d182d0bed0b2, 0x20),
(4, 0xd09fd180d0bed182d0bed0bad0bed0bb, 0x20),
(5, 0xd09ed182d187d0b5d182d18b, 0x20),
(6, 0xd0a0d0b5d0b0d0b3d0b5d0bdd182d18b, 0x20),
(7, 0xd094d0bed0bad182d0bed180d0b0, 0x20),
(8, 0xd094d180d183d0b3d0b8d0b5, 0x20),
(9, 0xd098d0b7d0bcd0b5d0bdd0b8d182d18c266e6273703bd0bfd0b0d180d0bed0bbd18c, 0x20),
(10, 0xd0a1d182d0b0d182d0b8d181d182d0b8d0bad0b0, 0x20),
(11, 0xd09fd0b0d186d0b8d0b5d0bdd182d18b, 0x20),
(12, 0xd09fd180d0bed187d0b5d0b5, 0x20),
(13, 0xd09fd0b5d180d0b5d0b2d0bed0b7d0bad0b0, 0x20),
(14, 0xd09fd0b5d180d0b5d0b2d0bed0b7d0bad0b0266e6273703bd0bfd180d0bed0b1d0b8d180d0bed0ba, 0x20),
(15, 0xd09ed182d0bfd180d0b0d0b2d0bad0b0, 0x20),
(16, 0xd09fd180d0b8d0b5d0bc, 0x20),
(17, 0xd09ed0b1d189d0b0d18f266e6273703bd0b8d0bdd184d0bed180d0bcd0b0d186d0b8d18f, 0x20),
(18, 0xd0a1d0bad0bbd0b0d0b4, 0x20),
(19, 0xd0a0d0b5d0b3d0b8d181d182d180d0b0d186d0b8d18f, 0x20),
(20, 0xd09ed182d0b7d18bd0b2, 0x20),
(21, 0x446f75626c65266e6273703b636865636b, 0x20),
(22, 0x4c6f6773, 0x20),
(23, 0xd092d18bd185d0bed0b4, 0x20),
(24, 0xd09cd0b5d182d0b0d0b1d0bed0bbd0b8d187d0b5d181d0bad0b8d0b9266e6273703b636865636b7570, 0x20),
(25, 0xd09dd0bed0b2d0bed181d182d0b8, 0x20),
(26, 0xd09fd180d0bed187d0b5d0b532, 0x20),
(27, 0x3c6920636c6173733d226661732066612d636f67223e3c2f693e, 0x47656e6572616c206d656e75),
(28, 0x43524d, 0x437573746f6d65722d72656c6174696f6e73686970206d616e6167656d656e74);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
