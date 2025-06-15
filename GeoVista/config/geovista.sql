-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 04. Jun 2025 um 14:55
-- Server-Version: 10.4.22-MariaDB
-- PHP-Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `geovista`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `answer`
--

CREATE TABLE `answer` (
  `id_answer` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `isCorrectAnswer` tinyint(1) NOT NULL,
  `fk_question` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `answer`
--

INSERT INTO `answer` (`id_answer`, `description`, `isCorrectAnswer`, `fk_question`) VALUES
(5, 'Vilnius', 0, 1),
(6, 'Brüssel', 1, 1),
(7, 'Podgorica', 0, 1),
(8, 'Dublin', 0, 1),
(9, 'London', 1, 2),
(10, 'Reykjavík', 0, 2),
(11, 'Wien', 0, 2),
(12, 'Bern', 0, 2),
(13, 'Wien', 0, 3),
(14, 'Paris', 0, 3),
(15, 'Brüssel', 0, 3),
(16, 'Berlin', 1, 3),
(17, 'Lissabon', 1, 4),
(18, 'Madrid', 0, 4),
(19, 'Skopje', 0, 4),
(20, 'Sofia', 0, 4),
(21, 'Rom', 0, 5),
(22, 'Zagreb', 0, 5),
(23, 'Prag', 1, 5),
(24, 'Belgrad', 0, 5),
(25, 'Wien', 1, 6),
(26, 'Amsterdam', 0, 6),
(27, 'Oslo', 0, 6),
(28, 'Stockholm', 0, 6),
(29, 'London', 0, 7),
(30, 'Dublin', 1, 7),
(31, 'Amsterdam', 0, 7),
(32, 'Wien', 0, 7),
(33, 'Warschau', 0, 8),
(34, 'Berlin', 0, 8),
(35, 'Brüssel', 0, 8),
(36, 'Bratislava', 1, 8),
(37, 'Bratislava', 0, 9),
(38, 'Dublin', 0, 9),
(39, 'Helsinki', 0, 9),
(40, 'Reykjavík', 1, 9),
(41, 'Stockholm', 0, 10),
(42, 'Luxemburg', 0, 10),
(43, 'Oslo', 1, 10),
(44, 'Kirschinau', 0, 10),
(125, 'Bern', 0, 11),
(126, 'Vaduz', 1, 11),
(127, 'Luxemburg', 0, 11),
(128, 'Nikosia', 0, 11),
(129, 'Madrid', 1, 12),
(130, 'Vilnius', 0, 12),
(131, 'Pristina', 0, 12),
(132, 'Zagreb', 0, 12),
(133, 'Sarajevo', 0, 13),
(134, 'Athen', 0, 13),
(135, 'Rom', 1, 13),
(136, 'Skopje', 0, 13),
(137, 'Athen', 1, 14),
(138, 'Tirana', 0, 14),
(139, 'Madrid', 0, 14),
(140, 'Rom', 0, 14),
(141, 'Ankara', 0, 15),
(142, 'Lissabon', 0, 15),
(143, 'Paris', 1, 15),
(144, 'Rom', 0, 15),
(145, 'Bukarest', 0, 16),
(146, 'Prag', 0, 16),
(147, 'Belgrad', 0, 16),
(148, 'Sofia', 1, 16),
(149, 'Ljubljana', 1, 17),
(150, 'Brüssel', 0, 17),
(151, 'Budapest', 0, 17),
(152, 'Prag', 0, 17),
(153, 'Riga', 0, 18),
(154, 'Kopenhagen', 1, 18),
(155, 'Helsinki', 0, 18),
(156, 'Reykjavík', 0, 18),
(157, 'Dublin', 0, 19),
(158, 'Tallin', 0, 19),
(159, 'Kopenhagen', 0, 19),
(160, 'Amsterdam', 1, 19),
(161, 'Bratislava', 0, 20),
(162, 'Ljubljana', 0, 20),
(163, 'Prag', 0, 20),
(164, 'Budapest', 1, 20),
(165, 'Armenien', 0, 21),
(166, 'Andorra', 1, 21),
(167, 'Albanien', 0, 21),
(168, 'Luxemburg', 0, 21),
(169, 'Kroatien', 0, 22),
(170, 'Serbien', 0, 22),
(171, 'Bosnien und Herzegowina', 1, 22),
(172, 'Slowakei', 0, 22),
(173, 'Moldawien', 1, 23),
(174, 'Rumänien', 0, 23),
(175, 'Bulgarien', 0, 23),
(176, 'Armenien', 0, 23),
(177, 'Monaco', 0, 24),
(178, 'Liechtenstein', 0, 24),
(179, 'San Marino', 1, 24),
(180, 'Vatikanstadt', 0, 24),
(181, 'Mazedonien', 1, 25),
(182, 'Montenegro', 0, 25),
(183, 'Kosovo', 0, 25),
(184, 'Albanien', 0, 25),
(185, 'Armenien', 0, 26),
(186, 'Griechenland', 0, 26),
(187, 'Serbien', 0, 26),
(188, 'Georgien', 1, 26),
(189, 'Kirgisistan', 0, 27),
(190, 'Turkmenistan', 0, 27),
(191, 'Usbekistan', 0, 27),
(192, 'Kasachstan', 1, 27),
(193, 'Malta', 1, 28),
(194, 'Irland', 0, 28),
(195, 'Zypern', 0, 28),
(196, 'Griechenland', 0, 28),
(197, 'Bosnien und Herzegowina', 0, 29),
(198, 'Serbien', 1, 29),
(199, 'Kroatien', 0, 29),
(200, 'Slowenien', 0, 29),
(201, 'Irland', 0, 30),
(202, 'Norwegen', 0, 30),
(203, 'Island', 1, 30),
(204, 'Schweden', 0, 30),
(205, 'Estland', 0, 31),
(206, 'Lettland', 1, 31),
(207, 'Litauen', 0, 31),
(208, 'Finnland', 0, 31),
(209, 'Armenien', 1, 32),
(210, 'Georgien', 0, 32),
(211, 'Albanien', 0, 32),
(212, 'Moldawien', 0, 32),
(213, 'Italien', 0, 33),
(214, 'Schottland', 0, 33),
(215, 'Belgien', 0, 33),
(216, 'Irland', 1, 33),
(217, 'Slowenien', 1, 34),
(218, 'Kroatien', 0, 34),
(219, 'Serbien', 0, 34),
(220, 'Bosnien und Herzegowina', 0, 34),
(221, 'Georgien', 0, 35),
(222, 'Moldawien', 0, 35),
(223, 'Rumänien', 1, 35),
(224, 'Bulgarien', 0, 35),
(225, 'Monaco', 0, 36),
(226, 'San Marino', 0, 36),
(227, 'Liechtenstein', 1, 36),
(228, 'Andorra', 0, 36),
(229, 'Zypern', 1, 37),
(230, 'Griechenland', 0, 37),
(231, 'Malta', 0, 37),
(232, 'Türkei', 0, 37),
(233, 'Bosnien und Herzegowina', 0, 38),
(234, 'Kroatien', 0, 38),
(235, 'Montenegro', 1, 38),
(236, 'Serbien', 0, 38),
(237, 'Schweden', 1, 39),
(238, 'Norwegen', 0, 39),
(239, 'Finnland', 0, 39),
(240, 'Island', 0, 39),
(241, 'Estland', 0, 40),
(242, 'Lettland', 0, 40),
(243, 'Litauen', 1, 40),
(244, 'Finnland', 0, 40),
(245, 'Österreich', 0, 41),
(246, 'Frankreich', 0, 41),
(247, 'Deutschland', 1, 41),
(248, 'Schweiz', 0, 41),
(249, 'Spanien', 0, 42),
(250, 'Frankreich', 1, 42),
(251, 'Italien', 0, 42),
(252, 'Belgien', 0, 42),
(253, 'Portugal', 0, 43),
(254, 'Italien', 0, 43),
(255, 'Frankreich', 0, 43),
(256, 'Spanien', 1, 43),
(257, 'Griechenland', 0, 44),
(258, 'Spanien', 0, 44),
(259, 'Italien', 1, 44),
(260, 'Frankreich', 0, 44),
(261, 'Spanien', 0, 45),
(262, 'Portugal', 1, 45),
(263, 'Italien', 0, 45),
(264, 'Griechenland', 0, 45),
(265, 'Slowakei', 0, 46),
(266, 'Kroatien', 0, 46),
(267, 'Slowenien', 1, 46),
(268, 'Österreich', 0, 46),
(269, 'Tschechien', 0, 47),
(270, 'Slowakei', 1, 47),
(271, 'Ungarn', 0, 47),
(272, 'Polen', 0, 47),
(273, 'Österreich', 0, 48),
(274, 'Deutschland', 0, 48),
(275, 'Tschechien', 1, 48),
(276, 'Slowakei', 0, 48),
(277, 'Polen', 0, 49),
(278, 'Slowenien', 0, 49),
(279, 'Ungarn', 1, 49),
(280, 'Tschechien', 0, 49),
(281, 'Deutschland', 0, 50),
(282, 'Österreich', 1, 50),
(283, 'Schweiz', 0, 50),
(284, 'Ungarn', 0, 50),
(285, 'Litauen', 0, 51),
(286, 'Tschechien', 0, 51),
(287, 'Deutschland', 0, 51),
(288, 'Polen', 1, 51),
(289, 'Slowenien', 0, 52),
(290, 'Serbien', 0, 52),
(291, 'Kroatien', 1, 52),
(292, 'Bosnien und Herzegowina', 0, 52),
(293, 'Österreich', 0, 53),
(294, 'Frankreich', 0, 53),
(295, 'Deutschland', 0, 53),
(296, 'Schweiz', 1, 53),
(297, 'Niederlande', 0, 54),
(298, 'Frankreich', 0, 54),
(299, 'Belgien', 1, 54),
(300, 'Luxemburg', 0, 54),
(301, 'Deutschland', 0, 55),
(302, 'Belgien', 0, 55),
(303, 'Niederlande', 1, 55),
(304, 'Dänemark', 0, 55),
(305, 'Schweden', 0, 56),
(306, 'Dänemark', 0, 56),
(307, 'Norwegen', 1, 56),
(308, 'Finnland', 0, 56),
(309, 'Finnland', 0, 57),
(310, 'Norwegen', 0, 57),
(311, 'Schweden', 1, 57),
(312, 'Dänemark', 0, 57),
(313, 'Norwegen', 0, 58),
(314, 'Schweden', 0, 58),
(315, 'Estland', 0, 58),
(316, 'Finnland', 1, 58),
(317, 'Großbritannien', 0, 59),
(318, 'Island', 0, 59),
(319, 'Irland', 1, 59),
(320, 'Belgien', 0, 59),
(321, 'Italien', 0, 60),
(322, 'Bulgarien', 0, 60),
(323, 'Griechenland', 1, 60),
(324, 'Türkei', 0, 60),
(325, 'Spanien', 0, 61),
(326, 'Frankreich', 0, 61),
(327, 'Italien', 1, 61),
(328, 'Griechenland', 0, 61),
(329, 'Dänemark', 0, 62),
(330, 'Schweden', 0, 62),
(331, 'Norwegen', 1, 62),
(332, 'Belgien', 0, 62),
(333, 'Spanien', 0, 63),
(334, 'Portugal', 1, 63),
(335, 'Frankreich', 0, 63),
(336, 'Belgien', 0, 63),
(337, 'Albanien', 0, 64),
(338, 'Kosovo', 0, 64),
(339, 'Serbien', 0, 64),
(340, 'Nordmazedonien', 1, 64),
(341, 'Luxemburg', 0, 65),
(342, 'Liechtenstein', 1, 65),
(343, 'Schweiz', 0, 65),
(344, 'Andorra', 0, 65),
(345, 'Lettland', 0, 66),
(346, 'Litauen', 0, 66),
(347, 'Polen', 0, 66),
(348, 'Estland', 1, 66),
(349, 'Kroatien', 0, 67),
(350, 'Slowenien', 1, 67),
(351, 'Bosnien und Herzegowina', 0, 67),
(352, 'Österreich', 0, 67),
(353, 'Monaco', 0, 68),
(354, 'Andorra', 1, 68),
(355, 'Luxemburg', 0, 68),
(356, 'San Marino', 0, 68),
(357, 'Serbien', 0, 69),
(358, 'Slowenien', 0, 69),
(359, 'Bosnien und Herzegowina', 0, 69),
(360, 'Kroatien', 1, 69),
(361, 'Polen', 0, 70),
(362, 'Tschechien', 1, 70),
(363, 'Slowakei', 0, 70),
(364, 'Ungarn', 0, 70),
(365, 'Rumänien', 0, 71),
(366, 'Bulgarien', 0, 71),
(367, 'Serbien', 1, 71),
(368, 'Nordmazedonien', 0, 71),
(369, 'Italien', 0, 72),
(370, 'Andorra', 0, 72),
(371, 'San Marino', 1, 72),
(372, 'Vatikanstadt', 0, 72),
(373, 'Kosovo', 0, 73),
(374, 'Serbien', 0, 73),
(375, 'Montenegro', 1, 73),
(376, 'Bosnien und Herzegowina', 0, 73),
(378, 'Großbritannien', 0, 74),
(379, 'Frankreich', 0, 74),
(380, 'Irland', 1, 74),
(381, 'Belgien', 0, 74),
(382, 'Nordmazedonien', 0, 75),
(383, 'Montenegro', 0, 75),
(384, 'Kosovo', 1, 75),
(385, 'Albanien', 0, 75),
(386, 'Kroatien', 0, 76),
(387, 'Serbien', 0, 76),
(388, 'Bosnien und Herzegowina', 1, 76),
(389, 'Slowenien', 0, 76),
(390, 'Estland', 0, 77),
(391, 'Lettland', 0, 77),
(392, 'Belarus', 0, 77),
(393, 'Litauen', 1, 77),
(394, 'Belgien', 0, 78),
(395, 'Liechtenstein', 0, 78),
(396, 'Schweiz', 0, 78),
(397, 'Luxemburg', 1, 78),
(398, 'Zypern', 0, 79),
(399, 'Griechenland', 0, 79),
(400, 'Italien', 0, 79),
(401, 'Malta', 1, 79),
(402, 'Griechenland', 0, 80),
(403, 'Nordmazedonien', 0, 80),
(404, 'Albanien', 1, 80),
(405, 'Montenegro', 0, 80);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `geovista`
--

CREATE TABLE `geovista` (
  `pk_geovista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `geovista`
--

INSERT INTO `geovista` (`pk_geovista`) VALUES
(1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `question`
--

CREATE TABLE `question` (
  `id_question` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `fk_quiz` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `question`
--

INSERT INTO `question` (`id_question`, `description`, `image`, `fk_quiz`) VALUES
(1, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/bruessel.jpg', 2),
(2, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/london.jpg', 2),
(3, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/berlin.jpg', 2),
(4, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/lissabon.jpg', 2),
(5, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/prag.jpg', 2),
(6, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/wien.jpg', 2),
(7, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/dublin.jpg', 2),
(8, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/bratislava.jpg', 2),
(9, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/reykjavik.jpg', 2),
(10, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/oslo.jpg', 2),
(11, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/vaduz.jpg', 2),
(12, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/madrid.jpg', 2),
(13, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/rom.jpg', 2),
(14, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/athen.jpg', 2),
(15, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/paris.jpg', 2),
(16, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/sofia.jpg', 2),
(17, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/ljubljana.jpg', 2),
(18, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/kopenhagen.jpg', 2),
(19, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/amsterdam.jpg', 2),
(20, 'Um welche Hauptstadt handelt es sich?', 'res/img/question_img/capitals/budapest.jpg', 2),
(21, 'Welche Nation wird durch diese Flagge repräsentiert?', 'res/img/question_img/flags/andorra.svg', 3),
(22, 'Welches Land gehört zu dieser Flagge?', 'res/img/question_img/flags/bosnienundherzegowina.svg', 3),
(23, 'Zu welchem Land gehört diese Flagge?', 'res/img/question_img/flags/moldawien.svg', 3),
(24, 'Diese Flagge gehört zu welchem Land?', 'res/img/question_img/flags/sanmarino.svg', 3),
(25, 'Welche Nation wird von dieser Flagge symbolisiert?', 'res/img/question_img/flags/mazedonien.svg', 3),
(26, 'Welche Nation ist auf dieser Flagge zu sehen?', 'res/img/question_img/flags/georgien.svg', 3),
(27, 'Diese Flagge gehört zu welchem Land in Zentralasien?', 'res/img/question_img/flags/kasachstan.svg', 3),
(28, 'Für welches Land ist diese Flagge charakteristisch?', 'res/img/question_img/flags/malta.svg', 3),
(29, 'Welche Nation wird von dieser Flagge repräsentiert?', 'res/img/question_img/flags/serbien.svg', 3),
(30, 'Diese Flagge gehört zu welchem Land?', 'res/img/question_img/flags/island.svg', 3),
(31, 'Zu welchem Land gehört diese Flagge?', 'res/img/question_img/flags/lettland.svg', 3),
(32, 'Welche Nation wird von dieser Flagge symbolisiert?', 'res/img/question_img/flags/armenien.svg', 3),
(33, 'Zu welchem Land gehört diese Flagge?', 'res/img/question_img/flags/irland.svg', 3),
(34, 'Diese Flagge gehört zu welchem Land?', 'res/img/question_img/flags/slowenien.svg', 3),
(35, 'Welche Nation wird von dieser Flagge dargestellt?', 'res/img/question_img/flags/rumaenien.svg', 3),
(36, 'Zu welchem Land gehört diese Flagge?', 'res/img/question_img/flags/liechtenstein.svg', 3),
(37, 'Diese Flagge gehört zu welchem Land?', 'res/img/question_img/flags/zypern.svg', 3),
(38, 'Für welches Land ist diese Flagge? ', 'res/img/question_img/flags/montenegro.svg', 3),
(39, 'Welche Nation wird durch diese Flagge symbolisiert?', 'res/img/question_img/flags/schweden.svg', 3),
(40, 'Zu welchem Land gehört diese Flagge?', 'res/img/question_img/flags/litauen.svg', 3),
(41, 'Um welches Land handelt es sich?', 'DEU', 4),
(42, 'Um welches Land handelt es sich?', 'FRA', 4),
(43, 'Um welches Land handelt es sich?', 'ESP', 4),
(44, 'Um welches Land handelt es sich?', 'ITA', 4),
(45, 'Um welches Land handelt es sich?', 'PRT', 4),
(46, 'Um welches Land handelt es sich?', 'SVN', 4),
(47, 'Um welches Land handelt es sich?', 'SVK', 4),
(48, 'Um welches Land handelt es sich?', 'CZE', 4),
(49, 'Um welches Land handelt es sich?', 'HUN', 4),
(50, 'Um welches Land handelt es sich?', 'AUT', 4),
(51, 'Um welches Land handelt es sich?', 'POL', 4),
(52, 'Um welches Land handelt es sich?', 'HRV', 4),
(53, 'Um welches Land handelt es sich?', 'CHE', 4),
(54, 'Um welches Land handelt es sich?', 'BEL', 4),
(55, 'Um welches Land handelt es sich?', 'NLD', 4),
(56, 'Um welches Land handelt es sich?', 'NOR', 4),
(57, 'Um welches Land handelt es sich?', 'SWE', 4),
(58, 'Um welches Land handelt es sich?', 'FIN', 4),
(59, 'Um welches Land handelt es sich?', 'IRL', 4),
(60, 'Um welches Land handelt es sich?', 'GRC', 4),
(61, 'Um welches Land handelt es sich hier?', 'ITA', 1),
(62, 'Um welches Land handelt es sich hier?', 'NOR', 1),
(63, 'Um welches Land handelt es sich hier?', 'PRT', 1),
(64, 'Um welches Land handelt es sich hier?', 'MKD', 1),
(65, 'Um welches Land handelt es sich hier?', 'LIE', 1),
(66, 'Um welches Land handelt es sich hier?', 'EST', 1),
(67, 'Um welches Land handelt es sich hier?', 'SVN', 1),
(68, 'Um welches Land handelt es sich hier?', 'AND', 1),
(69, 'Um welches Land handelt es sich hier?', 'HRV', 1),
(70, 'Um welches Land handelt es sich hier?', 'CZE', 1),
(71, 'Um welches Land handelt es sich hier?', 'SRB', 1),
(72, 'Um welches Land handelt es sich hier?', 'SMR', 1),
(73, 'Um welches Land handelt es sich hier?', 'MNE', 1),
(74, 'Um welches Land handelt es sich hier?', 'IRL', 1),
(75, 'Um welches Land handelt es sich hier?', 'KOS', 1),
(76, 'Um welches Land handelt es sich hier?', 'BIH', 1),
(77, 'Um welches Land handelt es sich hier?', 'LTU', 1),
(78, 'Um welches Land handelt es sich hier?', 'LUX', 1),
(79, 'Um welches Land handelt es sich hier?', 'MLT', 1),
(80, 'Um welches Land handelt es sich hier?', 'ALB', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quiz`
--

CREATE TABLE `quiz` (
  `id_quiz` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `fk_geovista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `quiz`
--

INSERT INTO `quiz` (`id_quiz`, `name`, `icon`, `fk_geovista`) VALUES
(1, 'Länder', 'res/img/quiz_icons/icon-laenderFarbe.svg', 1),
(2, 'Hauptstädte', 'res/img/quiz_icons/icon-hauptstaedte.svg', 1),
(3, 'Flaggen', 'res/img/quiz_icons/icon-flaggen.svg', 1),
(4, 'Länder (Umrisse)', 'res/img/quiz_icons/icon-laenderUmriss.svg', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `fk_geovista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `isAdmin`, `fk_geovista`) VALUES
(1, 'admin', 'admin.admin@admin.com', '$2y$10$ApIN.rhJ5I4OPeif88gRQeSueGDhBA52Ehe4j5IjuR.K3YOXxOpP.', 1, 1),
(2, 'maxmustermann', 'max.mustermann@gmx.com', '$2y$10$n23aeO0GqUIwb1CZAokgGeZ1.ytROvlB.FOc6B1S5CpHEwVuMSeaW', 0, 1),
(3, 'annademo', 'anna.demo@gmx.com', '$2y$10$Z8luiGFj51ajWD887rslxOC4YQJ290NeZAuaD9wArkOuUuLY/XUta', 0, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id_answer`),
  ADD KEY `fk_question` (`fk_question`);

--
-- Indizes für die Tabelle `geovista`
--
ALTER TABLE `geovista`
  ADD PRIMARY KEY (`pk_geovista`);

--
-- Indizes für die Tabelle `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id_question`),
  ADD KEY `fk_quiz` (`fk_quiz`);

--
-- Indizes für die Tabelle `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id_quiz`),
  ADD KEY `fk_geovista_l` (`fk_geovista`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD KEY `fk_geovista` (`fk_geovista`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `answer`
--
ALTER TABLE `answer`
  MODIFY `id_answer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=442;

--
-- AUTO_INCREMENT für Tabelle `question`
--
ALTER TABLE `question`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT für Tabelle `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id_quiz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `fk_question` FOREIGN KEY (`fk_question`) REFERENCES `question` (`id_question`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `fk_quiz` FOREIGN KEY (`fk_quiz`) REFERENCES `quiz` (`id_quiz`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `fk_geovista_l` FOREIGN KEY (`fk_geovista`) REFERENCES `geovista` (`pk_geovista`);

--
-- Constraints der Tabelle `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_geovista` FOREIGN KEY (`fk_geovista`) REFERENCES `geovista` (`pk_geovista`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
