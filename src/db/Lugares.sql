-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 25-02-2025 a las 18:15:44
-- Versión del servidor: 8.0.41-0ubuntu0.24.04.1
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `wikiagapornis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Lugares`
--

CREATE TABLE `Lugares` (
  `id_lugar` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ubicacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Lugares`
--

INSERT INTO `Lugares` (`id_lugar`, `nombre`, `ubicacion`) VALUES
(179, 'North Hill', 'Papa Westray'),
(180, 'Mousa', 'Mousa'),
(181, 'Lodmoor', 'Weymouth'),
(182, 'Fetlar', 'Between Aith and Funzie'),
(183, 'Birsay Moors', 'Evie'),
(184, '', ''),
(185, 'Minsmere', 'Westleton'),
(186, 'Langford Lowfields', 'South Collingham'),
(187, 'Vange Marsh', 'Vange'),
(188, 'Nigg Bay', 'Ankerville'),
(189, 'Culbin Sands', 'Nairn'),
(190, 'Lough Foyle', 'Ballykelly'),
(191, 'Capel Fleet', 'Harty'),
(192, 'Dearne Valley – Old Moor', 'Barnsley and Rotherham'),
(193, 'Geltsdale', 'Hallbankgate'),
(194, 'Mersehead', 'Caulkerbush'),
(195, 'Balranald', 'Hogda Gearraidh'),
(196, 'Coll', 'Totronald'),
(197, 'Bowers Marsh', 'Bowers Gifford'),
(198, 'Cors Ddyga', 'Pentre Berw'),
(199, 'Corrimony', 'Corrimony'),
(200, 'Inversnaid', 'Inversnaid'),
(201, 'Mull of Galloway', 'Cairngaan'),
(202, 'St Aidan\'s', 'Great Preston'),
(203, 'Marshside', 'Southport'),
(204, 'Freiston Shore', 'Freiston Shore'),
(205, 'Nene Washes', 'Eldernell'),
(206, 'Loch Ruthven', 'Croachy'),
(207, 'Loch Druidibeg', 'Groigearraidh'),
(208, 'RSPB Shop at Darts Farm', 'Ebford'),
(209, 'Wallasea Island', 'Essex Marina'),
(210, 'Fairy Glen', 'Rosemarkie'),
(211, 'Fen Drayton Lakes', 'Fen Drayton'),
(212, 'Church Wood', 'Hedgerly'),
(213, 'Radipole Lake', 'Weymouth'),
(214, 'Marazion Marsh', 'Longrock'),
(215, 'Rainham Marshes', 'Purfleet'),
(216, 'The Oa', 'Lower Killeyan'),
(217, 'South Stack', 'Holyhead'),
(218, 'Ramsey Island', 'St Davids'),
(219, 'Labrador Bay', 'Between Maidencombe and Shaldon'),
(220, 'Exminster and Powderham Marshes', 'Exminster'),
(221, 'Portmore Lough', 'Ballinderry Lower/Lower Ballinderry'),
(222, 'Havergate Island', 'Orford'),
(223, 'Winterbourne Downs', 'Newton Tony'),
(224, 'Loch Gruinart', 'Aoradh'),
(225, 'Lakenheath Fen', 'Hockwold cum Wilton'),
(226, 'West Sedgemoor', 'Heale'),
(227, 'Loch Garten, Abernethy', 'Mains of Garten'),
(228, 'Farnham Heath', 'Tilford'),
(229, 'Nagshead', 'Parkend'),
(230, 'Cliffe Pools', 'Cliffe'),
(231, 'Mawddach Valley - Arthog Bog', 'Groigearraidh'),
(232, 'Loch Druidibeg', 'ubicación desconocida'),
(233, 'Lower Lough Erne Islands', 'Leggs'),
(234, 'Brodgar', 'Stennes'),
(235, 'Titchwell Marsh', 'Titchwell'),
(236, 'Aylesbeare Common', 'Hawkerland'),
(237, 'Arne', 'Arne'),
(238, 'Cwm Clydach', 'Craig-cefn-parc'),
(239, 'Forsinard Flows', 'Forsinard'),
(240, 'Aghatirourke', '(West of) Kinawley'),
(241, 'Loch na Muilne', 'Arnol'),
(242, 'Stanford Wharf', 'Stanford-le-Hope'),
(243, 'Onziebust', 'Egilsay'),
(244, 'Fowlsheugh', 'Crawton'),
(245, 'St Bees Head', 'St Bees'),
(246, 'Dunnet Head', 'Brough'),
(247, 'Loch of Kinnordy', 'Kinnordy'),
(248, 'Baron\'s Haugh', 'Motherwell'),
(249, 'Troup Head', 'Northfield'),
(250, 'Bempton Cliffs', 'Bridlington'),
(251, 'Noup Cliffs', 'Noup Head lighthouse'),
(252, 'Wolves Wood', 'Hadleigh'),
(253, 'Ouse Washes', 'Welches Dam'),
(254, 'Broadwater Warren', 'Tunbridge Wells'),
(255, 'Glenborrodale', 'Between Glenbeg and Glenborrodale'),
(256, 'Crook of Baldoon', 'Braehead'),
(257, 'Dove Stone', 'Oldham'),
(258, 'Flatford Wildlife Garden', 'East Bergholt'),
(259, 'Sandwell Valley', 'Hamstead'),
(260, 'Gwenffrwd-Dinas', 'Ystradffin'),
(261, 'Lochwinnoch', 'Lochwinnoch'),
(262, 'Hodbarrow', 'Steel Green'),
(263, 'Ouse Fen', 'Earith'),
(264, 'Hoy', 'Linksness'),
(265, 'Trumland', 'Brinian'),
(266, 'The Lodge', 'Sandy'),
(267, 'Ham Wall', 'Between Meare and Ashcott'),
(268, 'Lytchett Fields', 'Lytchett Minster'),
(269, 'Rye Meads', 'Hoddesdon'),
(270, 'Matford Marshes', 'Matford'),
(271, 'Canvey Wick', 'Canvey Island'),
(272, 'Chapel Wood', 'Spreacombe'),
(273, 'Fairburn Ings', 'Newton'),
(274, 'Middleton Lakes', 'Bodymoor Heath'),
(275, 'Broubster Leans', 'Thurso'),
(276, 'Highnam Woods', 'Churcham'),
(277, 'Cottascarth and Rendall Moss', 'Settiscarth'),
(278, 'Snettisham', 'Snettisham'),
(279, 'Stour Estuary', 'Wrabness'),
(280, 'Beckingham Marshes', 'Beckingham'),
(281, 'Udale Bay', 'Jemimaville'),
(282, 'Mawddach Valley - Arthog Bog', 'ubicación desconocida'),
(283, 'Blean Woods', 'Rough Common'),
(284, 'Hesketh Out Marsh', 'Hesketh Bank'),
(285, 'Loch Spynie', 'Oakenhead'),
(286, 'Loch Leven', 'Kinross'),
(287, 'Langstone Harbour', 'Stoke'),
(288, 'Pagham Harbour Local Nature Reserve', 'Pagham'),
(289, 'Garston Wood', 'Deanland'),
(290, 'Hazeley Heath', 'Hartley Wintney'),
(291, 'Rockland Marshes', 'Rockland St Mary'),
(292, 'North Warren', 'Aldeburgh'),
(293, 'Pulborough Brooks', 'Wiggonholt'),
(294, 'Budby South Forest', 'Budby'),
(295, 'Consall Woods', 'Stoke-on-Trent'),
(296, 'Loch Lomond', 'Gartocharn'),
(297, 'Adur Estuary', 'Shoreham-by-Sea'),
(298, 'Lake Vyrnwy', 'Llanwddyn'),
(299, 'Carngafallt', 'Elan Village'),
(300, 'Berney Marshes and Breydon Water', 'Berney Arms'),
(301, 'Dee Estuary - Point of Ayr', 'Talacre, opposite side of the Estuary to the parent site'),
(302, 'Marwick Head', 'Marwick'),
(303, 'Coombes Valley', 'Bradnop'),
(304, 'Hobbister', 'Hobbister'),
(305, 'Fore Wood', 'Crowhurst'),
(306, 'Greylake', 'Greylake'),
(307, '', 'ubicación desconocida'),
(308, 'Buckenham Marshes', 'Buckenham'),
(309, 'Surlingham Church Marsh', 'Surlingham'),
(310, 'Sumburgh Head', 'Sumburgh'),
(311, 'Conwy', 'Llandudno Junction'),
(312, 'Loch of Spiggie', 'Skelberry'),
(313, 'Dingle Marshes', 'Dunwich'),
(314, 'Hayle Estuary', 'Hayle'),
(315, 'RSPB shop at Carsington Water', 'Ashbourne'),
(316, 'Medmerry', 'Earnley'),
(317, 'Dungeness', 'Dungeness'),
(318, 'Wood of Cree', 'Penninghame'),
(319, 'Mawddach Valley Coed Garth Gell', 'Pen-Y-Bryn');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Lugares`
--
ALTER TABLE `Lugares`
  ADD PRIMARY KEY (`id_lugar`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Lugares`
--
ALTER TABLE `Lugares`
  MODIFY `id_lugar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=320;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
