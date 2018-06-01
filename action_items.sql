
-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 27 2018 г., 16:30
-- Версия сервера: 5.5.53
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ruslania`
--

-- --------------------------------------------------------

--
-- Структура таблицы `action_items`
--

CREATE TABLE `action_items` (
  `id` int(11) NOT NULL,
  `entity` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `action_items`
--

INSERT INTO `action_items` (`id`, `entity`, `item_id`, `type`) VALUES
(1, 10, 227, 2),
(11, 10, 145787, 0),
(12, 10, 963247, 1),
(13, 22, 234518, 1),
(14, 22, 234467, 2),
(15, 10, 607, 2),
(16, 10, 685, 1),
(17, 10, 576635, 2),
(18, 10, 707137, 1),
(19, 10, 803157, 2),
(20, 10, 1234738, 1),
(21, 10, 1234789, 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `action_items`
--
ALTER TABLE `action_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `action_items`
--
ALTER TABLE `action_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
