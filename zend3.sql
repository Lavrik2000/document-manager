-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 26 2018 г., 20:43
-- Версия сервера: 5.6.38
-- Версия PHP: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `zend3`
--

-- --------------------------------------------------------

--
-- Структура таблицы `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `number` varchar(10) NOT NULL,
  `name` varchar(256) NOT NULL,
  `depart_issue` varchar(256) NOT NULL,
  `date_issue` date NOT NULL,
  `author` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `documents`
--

INSERT INTO `documents` (`id`, `number`, `name`, `depart_issue`, `date_issue`, `author`) VALUES
(1, '4500486422', 'паспорт', 'ОВД Марьина роща г Москвы', '2001-08-01', 'test@bk.ru'),
(2, '7455899656', 'свидетельство', 'ЗАГС354 Мытищи', '2015-12-06', 'test@bk.ru'),
(3, '125698786', 'свидетельство о браке', 'ЗАГС №354 ва', '1996-11-01', 'test@bk.ru'),
(4, '4500789563', 'паспорт', 'ОВД Бутырский', '2001-05-03', 'test@bk.ru'),
(5, '4504695231', 'паспорт', 'ОВД Переделкино', '1998-11-23', 'test2@bk.ru'),
(6, '4402569821', 'паспорт', 'ОВД Кунцево', '2008-02-15', 'test2@bk.ru'),
(7, '4900402568', 'паспорт', 'ОВД Петровский', '2004-04-01', 'test2@bk.ru'),
(8, '4500789564', 'паспорт', 'ОВД Марьино', '2002-01-01', 'test2@bk.ru'),
(9, '5100785321', 'паспорт', 'ОВД Переделкино', '2017-08-08', 'test2@bk.ru'),
(10, '4601242330', 'паспорт', 'ОВД Китай Город', '2014-07-12', 'test2@bk.ru'),
(23, '2222333333', 'aaaadsdfdsfvsdfaf', 'asdsd sdafff', '2018-01-18', 'test2@bk.ru'),
(29, '4500789569', 'aaaadsdfdsfvsdfaf2', 'asdsd sdafff', '2003-01-01', 'test2@bk.ru'),
(32, '555555555', 'aaaadsdfdsfvsdfaf2', 'asdsd sdafff csdfdfdf edwd', '2018-01-01', 'test@bk.ru');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `pwd_reset_token` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pwd_reset_token_creation_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `full_name`, `password`, `status`, `date_created`, `pwd_reset_token`, `pwd_reset_token_creation_date`) VALUES
(2, 'test@bk.ru', 'Serge Pr', '$2y$10$BVjtybNF24NtcdVPdvV5OuAHNWCy67pHlTGgNrmpUJSDYWEoVuGo2', 1, '2018-05-21 12:13:52', NULL, NULL),
(3, 'test2@bk.ru', 'Alex Done', '$2y$10$t25K13IBYY4Jy04VLIZ64ezuEwBCHfFqXzWoQ7UrhghqrYsTU/Ueq', 1, '2018-05-21 12:14:51', NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_idx` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
