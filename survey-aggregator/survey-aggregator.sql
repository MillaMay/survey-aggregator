-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 14 2023 г., 00:52
-- Версия сервера: 5.7.29
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `survey-aggregator`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `votes` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`id`, `survey_id`, `votes`, `answer`) VALUES
(6, 2, 100, 'Шум'),
(7, 2, 200, 'Люди'),
(8, 2, 300, 'Рутина'),
(22, 6, 50, 'Да'),
(23, 6, 35, 'Нет'),
(24, 6, 75, 'Не знаю'),
(25, 6, 100, 'Да, все-таки пофиг'),
(34, 9, 10, '8'),
(35, 9, 5, '7'),
(109, 62, 55, 'Желтый'),
(112, 65, 5, 'I am gerl'),
(113, 65, 10, 'I am boy'),
(114, 65, 15, 'I am'),
(115, 66, 38, '4'),
(116, 66, 29, '5');

-- --------------------------------------------------------

--
-- Структура таблицы `surveys`
--

CREATE TABLE `surveys` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `title` varchar(250) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `surveys`
--

INSERT INTO `surveys` (`id`, `user_id`, `title`, `status`, `date`) VALUES
(2, 1, 'Что вас злит?', 1, '2023-06-12 12:50:11'),
(6, 1, 'Мне пофиг?', 0, '2023-06-13 00:02:31'),
(9, 1, '4+4', 1, '2023-06-13 00:17:52'),
(62, 4, 'Любимый цвет?', NULL, '2023-06-13 03:06:20'),
(65, 1, 'what am I ?', 1, '2023-06-13 22:24:56'),
(66, 4, '2+2', 0, '2023-06-14 00:14:51');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'milla@gmail.com', '12345'),
(4, 'setup.a.tech@gmail.com', '1234567'),
(11, '123@gmail.com', '123');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT для таблицы `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
