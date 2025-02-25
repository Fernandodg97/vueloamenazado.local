-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 25-02-2025 a las 18:15:38
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
-- Estructura de tabla para la tabla `Datos`
--

CREATE TABLE `Datos` (
  `id_clave` int NOT NULL,
  `id_pajaro` int NOT NULL,
  `estado_conservacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `dieta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `poblacion_europea` text,
  `pluma` text,
  `longitud` text,
  `peso` text,
  `envergadura` text,
  `habitats` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Datos`
--

INSERT INTO `Datos` (`id_clave`, `id_pajaro`, `estado_conservacion`, `dieta`, `poblacion_europea`, `pluma`, `longitud`, `peso`, `envergadura`, `habitats`) VALUES
(231, 238, 'Not assessed', 'Insects, grubs, caterpillars and spiders.', '12-20,000 pairs', 'Brown, Buff', '13cm', '10-14g', '16.5-19.5cm', 'Wetland'),
(232, 239, 'Not assessed', 'Mainly fish but also dead birds and mammals, eggs and young birds.', 'Nulo', 'Brown, Black, Buff, White', '41-46cm', '330-570g', '110-125cm', 'Marine and Intertidal, Wetland'),
(233, 240, 'Not assessed', 'Mainly fish but also crustaceans and insects.', '500-900,000 pairs', 'Grey, Black, White', '33-35cm', '95-120g', '75-85cm', 'Marine and Intertidal, Wetland'),
(234, 241, 'Not assessed', 'Aquatic insects and their larvae, crustaceans and worms.', '37-54,000 pairs', 'Black, White', '42-45cm', '260-290g', '77-80cm', 'Marine and Intertidal, Wetland, Grassland'),
(235, 242, 'Not assessed', 'Small fish such as anchovies, sprats and sardines and squid.', '3,142 pairs', 'Nulo', '34-39cm', '472-565g', '83-93cm', 'Nulo'),
(236, 243, 'Not assessed', 'Mainly shellfish, marine snails and worms and shrimps.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Red, Black, White', '37-39cm', '230-450g', '70-80cm', 'Marine and Intertidal, Wetland, Grassland'),
(237, 244, 'Not assessed', 'Mice, voles, shrews and some larger mammals and small birds.', '110-220,000 pairs', 'Cream/Buff, Brown, Grey, White', '33-39cm', '250-350g', '80-95cm', 'Marine and Intertidal, Farmland, Wetland, Grassland'),
(238, 245, 'Not assessed', 'Vegetation, the leaves and stems of grasses, roots and seeds.', '>390,000', 'Cream/Buff, Brown, Grey, Black, White', '58-70cm', '1300-2200g', '132-145cm', 'Marine and Intertidal, Farmland, Wetland, Grassland'),
(239, 246, 'Not assessed', 'Insects, insect larvae, spiders and seeds.', '232-437,000 birds', 'Cream/Buff, Brown, Grey, Orange, Blue, Black, White', '12.5cm', '12-18g', '16-18cm', 'Wetland'),
(240, 247, 'Not assessed', 'In the UK, Bewick\'s Swans feed in fields on leftover potatoes and grain. On their breeding grounds they eat aquatic plants and grass.', '>23,000 birds (winter)', 'White', '115-127cm', '6000g', '170-195cm', 'Marine and Intertidal, Farmland, Wetland'),
(241, 248, 'Not assessed', 'Fish, amphibians and insects.', '21-29,000 pairs', 'Cream/Buff, Brown, Black, White', 'Nulo', 'Nulo', 'Nulo', 'Wetland'),
(242, 249, 'Not assessed', 'Buds, shoots, catkins and berries.', '2,500,000-4,850,000 pairs', 'Cream/Buff, Brown, Grey, Black, White', '40-55cm', '930-1200g', '65-80cm', 'Woodland, Upland'),
(243, 250, 'Not assessed', 'Fish and crustaceans.', '120-290,000 pairs', 'Grey, Black, White', '30-32cm', '300-460g', '52-58cm', 'Marine and Intertidal, Wetland'),
(244, 251, 'Not assessed', 'Insects, spiders, worms, berries and seeds.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Red, Black', '14.5cm', '14-20g', '23-26cm', 'Urban and Suburban, Marine and Intertidal, Farmland'),
(245, 252, 'Not assessed', 'Insects, invertebrates and fish.', '83-170,000 pairs', 'Grey, Black, White', '22-24cm', '73g', '64-68cm', 'Marine and Intertidal, Wetland'),
(246, 253, 'Not assessed', 'Worms, insects, fish and carrion.', '130,000 pairs', 'Cream/Buff, Brown, Grey, Black, White', '34-37cm', '200-400g', '100-110cm', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(247, 254, 'Not assessed', 'Insects, crustaceans and small fish.', 'Nulo', 'Brown, Grey, Orange, Black, White, Yellow', '28-34cm', '250-350g', '56-60cm', 'Marine and Intertidal, Wetland'),
(248, 255, 'Not assessed', 'Insects, worms and snails, but also some plants, beetles, grasshoppers and other small insects during the breeding season.', '99-140,000 pairs', 'Cream/Buff, Brown, Grey, Black, White', '40-44cm', '280-340g', '70-82cm', 'Marine and Intertidal, Wetland, Grassland'),
(249, 256, 'Not assessed', 'Fish', 'Nulo', 'Brown, Grey, Black, White', '58-73cm', '2300-3400g', '58-73cm', 'Marine and Intertidal, Wetland'),
(250, 257, 'Not assessed', 'Blackbird food consists of a variety of insects and worms, but they also eat berries and fruit when in season.', 'Nulo', 'Brown, Black, White', '24-25cm', '80-100g', '34-38.5cm', 'Woodland, Urban and Suburban, Farmland, Grassland'),
(251, 258, 'Not assessed', 'Insects and berries.', 'Nulo', 'Cream/Buff, Brown, Grey, Blue, Black, White', '13cm', '21g', '20-23cm', 'Woodland, Urban and Suburban, Farmland'),
(252, 259, 'Not assessed', 'Insects, caterpillars, seeds and nuts.', '20-44 million pairs', 'Grey, Green, Blue, Black, White, Yellow', '12cm', '11g', '18cm', 'Woodland, Urban and Suburban, Farmland'),
(253, 260, 'Not assessed', 'Insects, caterpillars and berries.', 'Nulo', 'Nulo', '14cm', '20g', '20-22.5cm', 'Nulo'),
(254, 261, 'Not assessed', 'Nulo', '13-22 million pairs', 'Cream/Buff, Brown, Grey, Orange, Black, White', '14cm', '24g', '25-26cm', 'Woodland, Urban and Suburban, Farmland'),
(255, 262, 'Not assessed', 'Vegetation, especially eel-grass.', 'Nulo', 'Brown, Grey, Black, White', '56-61cm', '1,300- 1,600g', '110-120cm', 'Marine and Intertidal, Farmland, Wetland, Grassland'),
(256, 263, 'Not assessed', 'Seeds, buds and insects (for young).', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Pink/Purple, Blue, Black, White', '14.5-16.5cm', '21-27g', '22-26cm', 'Woodland, Urban and Suburban, Farmland'),
(257, 264, 'Not assessed', 'Buzzards tend to eat small mammals, birds and carrion. Even earthworms and large insects when other prey is in short supply.', 'Nulo', 'Brown, Black, White', '51-57cm', '550-1,300g', '113-128cm', 'Woodland, Upland, Farmland, Heathland, Grassland'),
(258, 265, 'Not assessed', 'Vegetation - roots, grass, leaves and seeds.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '90-110cm', '4,300-5,000g', '1.5-1.8m', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(259, 266, 'Not assessed', 'Berries, shoots and stems.', 'Nulo', 'Nulo', '60-87cm', '1,500-5,000g', '87-125cm', 'Woodland'),
(260, 267, 'Not assessed', 'Carrion, insects, worms, seeds, fruit, eggs and any scraps.', 'Nulo', 'Black', '45-47cm', '370-650g', '93-104cm', 'Woodland, Upland, Urban and Suburban, Farmland, Heathland, Wetland, Grassland'),
(261, 268, 'Not assessed', 'Insects, worms, reptiles, frogs and mice.', 'Nulo', 'White, Yellow', '45-50cm', '300-400g', '82-95cm', 'Farmland, Wetland, Grassland'),
(262, 269, 'Not assessed', 'Insects and larvae.', 'Nulo', 'Cream/Buff, Brown, Red, White', '13.5cm', '9-17g', '15-19cm', 'Wetland'),
(263, 270, 'Not assessed', 'Insects and seeds.', 'Nulo', 'Nulo', '14.5cm', '18-29g', '24.5-28.5cm', 'Woodland, Urban and Suburban, Farmland, Heathland, Grassland'),
(264, 271, 'Not assessed', 'Insects and spiders.', 'Nulo', 'Cream/Buff, Brown, Green, Yellow', '10-11cm', '6-10g', '15-21cm', 'Woodland, Urban and Suburban, Farmland, Heathland, Wetland'),
(265, 272, 'Not assessed', 'Insects and larvae.', 'Nulo', 'Black', '39-40cm', '260-350g', '73-90cm', 'Marine and Intertidal, Farmland'),
(266, 273, 'Not assessed', 'Insects and seeds.', 'Nulo', 'Cream/Buff, Brown, Grey, Green, Black, Yellow', '15.5cm', '21-27g', '22-25.5cm', 'Farmland'),
(267, 274, 'Not assessed', 'Insects, seeds and nuts.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White, Yellow', '11.5cm', '8-10g', '17-21cm', 'Woodland, Urban and Suburban, Heathland'),
(268, 275, 'Not assessed', 'Seeds, grains, buds and shoots.', 'Nulo', 'Cream/Buff, Brown, Grey, Pink/Purple, Black, White', '32cm', '200g', '51cm', 'Urban and Suburban, Farmland'),
(269, 276, 'Not assessed', 'Worms, insects, fish, carrion and rubbish.', 'Nulo', 'Brown, Grey, Black, White', '40-42cm', '300-480g', '110-130cm', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(270, 277, 'Not assessed', 'Small seeds from birch, alder and spruce, and insects.', 'Nulo', 'Cream/Buff, Brown, Grey, Pink/Purple, Red, Black, White', '12-14cm', '12-16g', '20-25cm', 'Woodland, Farmland, Wetland'),
(271, 278, 'Not assessed', 'Seeds, buds and small invertebrates.', 'Nulo', 'Nulo', '14.5-15cm', '21-27g', '22-26cm', 'Nulo'),
(272, 279, 'Not assessed', 'Insects and some worms and molluscs.', 'Nulo', 'Brown, White', '19-21cm', '40-60g', '32-35cm', 'Upland, Marine and Intertidal, Wetland'),
(273, 280, 'Not assessed', 'Molluscs.', 'Nulo', 'Nulo', '44-54cm', '650-1,300g', '79-90cm', 'Marine and Intertidal'),
(274, 281, 'Not assessed', 'Fish', 'Nulo', 'Grey, Black, White', '31-35cm', '90-150g', '77-98cm', 'Marine and Intertidal, Wetland'),
(275, 282, 'Not assessed', 'Fish', 'Nulo', 'Brown, Black, White', '80-100cm', '2,100-2,500g', '130-160cm', 'Urban and Suburban, Marine and Intertidal, Wetland'),
(276, 283, 'Not assessed', 'Seeds and insects.', 'Nulo', 'Cream/Buff, Brown', '18cm', '35-56g', '26-32cm', 'Farmland, Grassland'),
(277, 284, 'Not assessed', 'Insects and seeds.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '27-30cm', '120-200g', '46-53cm', 'Farmland, Wetland, Grassland'),
(278, 285, 'Not assessed', 'Seeds, roots, insects, snails and worms.', 'Nulo', 'Cream/Buff, Brown, Grey, Red, Black, White', '110-120cm', '4,000-7,000g', '220-245cm', 'Farmland, Wetland, Grassland'),
(279, 286, 'Not assessed', 'Insects and seeds.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '11.5cm', '10-13g', '17-20cm', 'Woodland'),
(280, 287, 'Not assessed', 'Seeds from conifers.', 'Nulo', 'Nulo', '16.5cm', '35-50g', '27-30.5cm', 'Woodland'),
(281, 288, 'Not assessed', 'Insects, especially hairy caterpillars.', 'Nulo', 'Brown, Grey, Black, White', '32-34cm', '105-130g', '55-65cm', 'Woodland, Upland, Urban and Suburban, Farmland, Heathland, Wetland'),
(282, 289, 'Not assessed', 'Worms, shellfish and shrimps.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '50-60cm', '575-1,000g', '80-100cm', 'Upland, Marine and Intertidal, Farmland, Wetland, Grassland'),
(283, 290, 'Not assessed', 'Snails, worms and shrimps.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Red, Black, White', '18-23cm', '45-90g', '38-41cm', 'Marine and Intertidal, Wetland, Grassland'),
(284, 291, 'Not assessed', 'Insects and other invertebrates.', 'Nulo', 'Brown, Grey, Pink/Purple, Blue, Red, Black, White', '12-13cm', '9-12g', '13-18cm', 'Heathland'),
(285, 292, 'Not assessed', 'Insect larvae and freshwater shrimps.', 'Nulo', 'Brown, Black, White', '18cm', '55-75g', '25-30cm', 'Upland, Wetland'),
(286, 293, 'Not assessed', 'Insects and worms', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Black, White', '20-22cm', '90-145g', '57-64cm', 'Upland, Marine and Intertidal, Farmland, Grassland'),
(287, 294, 'Not assessed', 'Insects, snails and worms.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '16-20cm', '40-50g', '35-40cm', 'Upland, Marine and Intertidal, Heathland, Wetland, Grassland'),
(288, 295, 'Not assessed', 'Insects, spiders, worms and seeds.', 'Nulo', 'Brown, Grey, Black', '14cm', '19-24g', '19-21cm', 'Woodland, Urban and Suburban, Farmland, Grassland'),
(289, 296, 'Not assessed', 'Seeds and grass.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Green, Black, White', '63-73cm', '1,500-2,250g', '110-130cm', 'Farmland, Wetland, Grassland'),
(290, 297, 'Not assessed', 'Shellfish, especially mussels.', 'Nulo', 'Cream/Buff, Brown, Black', '50-71cm', '1,200-2,800g', '80-108cm', 'Marine and Intertidal'),
(291, 298, 'Not assessed', 'Vegetation, seeds, snails and insect larvae.', 'Nulo', 'Black, White', '36-38cm', '600-900g', '70-80cm', 'Urban and Suburban, Marine and Intertidal, Wetland, Grassland'),
(292, 299, 'Not assessed', 'Insects, worms and berries.', 'Nulo', 'Brown, Grey, Orange, Black, White', '25cm', '80-130g', '39-42cm', 'Woodland, Urban and Suburban, Farmland, Grassland'),
(293, 300, 'Not assessed', 'Firecrests eat tiny morsels like spiders, moth eggs and other small insect food.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Green, Red, Black, White, Yellow', '9cm', '5-7g', '13-16cm', 'Woodland, Urban and Suburban'),
(294, 301, 'Not assessed', 'Fish waste, crustaceans and sand eels.', 'Nulo', 'Grey, White', '45-50cm', '610-1,000g', '100-112cm', 'Marine and Intertidal'),
(295, 302, 'Not assessed', 'Stems, leaves and seeds.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '46-56cm', '650-900g', '84-95cm', 'Marine and Intertidal, Wetland, Grassland'),
(296, 303, 'Not assessed', 'Fish.', 'Nulo', 'Black, White, Yellow', '87-100cm', '2,400-3,600g', '165-180cm', 'Marine and Intertidal'),
(297, 304, 'Not assessed', 'Insects and berries.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '14cm', '16-22g', '20-24.5cm', 'Woodland, Urban and Suburban, Farmland'),
(298, 305, 'Not assessed', 'Plant material and insects.', 'Nulo', 'Cream/Buff, Brown, Grey, Green, Blue, Black', '37-41cm', '250-450g', '60-63cm', 'Wetland, Grassland'),
(299, 306, 'Not assessed', 'Scavenges for carrion, shellfish and scraps.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '62-68cm', '1000-2000g', '150-165cm', 'Marine and Intertidal, Wetland'),
(300, 307, 'Not assessed', 'Goldcrests eat tiny morsels like spiders, moth eggs and other small insect food.', 'Nulo', 'Cream/Buff, Brown, Grey, Green, Black, White, Yellow', '9cm', '6g', '14cm', 'Woodland, Urban and Suburban'),
(301, 308, 'Not assessed', 'Birds and mammals - some carrion.', 'Nulo', 'Cream/Buff, Brown, Black, White', '75-88cm', 'Nulo', '204-220cm', 'Upland'),
(302, 309, 'Not assessed', 'Insects and berries.', 'Nulo', 'Nulo', '24cm', '56-79g', '44-47cm', 'Woodland'),
(303, 310, 'Not assessed', 'Leaves and buds, insects and spiders.', 'Nulo', 'Nulo', '60-115cm', '550-710g', '65-75cm', 'Woodland'),
(304, 311, 'Not assessed', 'Worms, beetles and insects.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White, Yellow', '26-29cm', '160-280g', '67-76cm', 'Upland, Marine and Intertidal, Farmland, Heathland, Wetland, Grassland'),
(305, 312, 'Not assessed', 'Mussels, insect larvae, small fish and plants', 'Nulo', 'Nulo', '42-50cm', '650-1200g', '65-80cm', 'Marine and Intertidal, Wetland'),
(306, 313, 'Not assessed', 'Seeds and insects in summer.', 'Nulo', 'Cream/Buff, Brown, Red, Black, White, Yellow', '12cm', '14-19g', '21-25.5cm', 'Urban and Suburban, Farmland'),
(307, 314, 'Not assessed', 'Fish.', 'Nulo', 'Nulo', '58-66cm', 'Nulo', '82-97cm', 'Upland, Marine and Intertidal, Wetland'),
(308, 315, 'Not assessed', 'Birds and mammals.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '48-62cm', 'Nulo', '135-165cm', 'Woodland, Upland, Farmland, Wetland, Grassland'),
(309, 316, 'Not assessed', 'Insects', 'Nulo', 'Cream/Buff, Brown, White', '12.5-13.5cm', '11-16g', '15-19cm', 'Heathland, Wetland, Grassland'),
(310, 317, 'Not assessed', 'Omnivorous - shellfish, birds and carrion.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '64-78cm', '1000-2000g', '150-165cm', 'Upland, Urban and Suburban, Marine and Intertidal, Farmland, Wetland'),
(311, 318, 'Not assessed', 'Mainly fish.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Black, White', '46-51cm', '590-1,500g', '85-90cm', 'Urban and Suburban, Marine and Intertidal, Wetland'),
(312, 319, 'Not assessed', 'Beetles and other insects, small mammals and birds. Food is often stored in a \'larder\' by impaling it on a thorn!', 'Nulo', 'Brown, Grey, Black, White', 'Nulo', 'Nulo', 'Nulo', 'Farmland, Heathland, Wetland, Grassland'),
(313, 320, 'Not assessed', 'Fish and crustaceans.', 'Nulo', 'Black, White', '70-90cm', '3,600-4,500g', '127-147cm', 'Marine and Intertidal, Wetland'),
(314, 321, 'Not assessed', 'Fish and squid.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '43-51cm', '715-950g', '100-118cm', 'Marine and Intertidal'),
(315, 322, 'Not assessed', 'Fish, carrion, other birds.', 'Nulo', 'Cream/Buff, Brown, Black, White', '53-58cm', '1200-2000g', '125-140cm', 'Marine and Intertidal'),
(316, 323, 'Not assessed', 'Insects, seeds and nuts.', 'Nulo', 'Cream/Buff, Brown, Grey, Red, Black, White', '22-23cm', '85g', '34-39cm', 'Woodland, Urban and Suburban'),
(317, 324, 'Not assessed', 'Insects, seeds and nuts.', 'Nulo', 'Cream/Buff, Grey, Green, Blue, Black, White, Yellow', '14cm', '18g', '24cm', 'Woodland, Urban and Suburban, Farmland'),
(318, 325, 'Not assessed', 'Fish, insects and frogs, caught by spearing with its sharp beak.', 'Nulo', 'White', 'Nulo', 'Nulo', 'Nulo', 'Marine and Intertidal, Farmland, Wetland, Grassland'),
(319, 326, 'Not assessed', 'Insects.', 'Nulo', 'Brown, Black, White', '22cm', 'Nulo', 'Nulo', 'Marine and Intertidal, Farmland, Wetland'),
(320, 327, 'Not assessed', 'Ants, ants, and more ants. They use their strong beak to dig into ant colonies and eat the inhabitants.', 'Nulo', 'Cream/Buff, Grey, Green, Red, Black, White, Yellow', '30-34cm', '180-220g', '40-42cm', 'Woodland, Urban and Suburban, Farmland, Grassland'),
(321, 328, 'Not assessed', 'Seeds and insects.', 'Nulo', 'Cream/Buff, Brown, Grey, Green, Black, White, Yellow', '15cm', '28g', '26cm', 'Woodland, Urban and Suburban, Farmland'),
(322, 329, 'Not assessed', 'Worms, snails and fish', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '32cm', '190g', '69cm', 'Marine and Intertidal, Wetland'),
(323, 330, 'Not assessed', 'Lots of fish, but also small birds such as ducklings, small mammals like voles and amphibians. After harvesting, grey herons can sometimes be seen in fields, looking for rodents.', 'Nulo', 'Cream/Buff, Grey, Black, White', '90-98cm', '1,500-2,000g', '175-195cm', 'Woodland, Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(324, 331, 'Not assessed', 'Leaves, seeds and insects.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Black, White', '30cm', '390g', '46cm', 'Farmland, Grassland'),
(325, 332, 'Not assessed', 'In winter, this species eats marine plankton picked from the sea\'s surface. On breeding grounds, Grey Phalaropes eat small insects and aquatic creatures.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '20-22cm', '50-75g', '34-41cm', 'Marine and Intertidal, Wetland'),
(326, 333, 'Not assessed', 'Shellfish and worms.', 'Nulo', 'Brown, Grey, Black, White', '28cm', '240g', '77cm', 'Marine and Intertidal, Wetland, Grassland'),
(327, 334, 'Not assessed', 'Insects.', 'Nulo', 'Nulo', '18-19cm', '14-22g', '25-27cm', 'Upland, Urban and Suburban, Marine and Intertidal, Wetland'),
(328, 335, 'Not assessed', 'Grass, roots, cereal leaves and spilled grain.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '76-89cm', '2,900-3,700g', '147-180cm', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(329, 336, 'Not assessed', 'Fish and crustaceans.', 'Nulo', 'Brown, Black, White', '38-45cm', '850-1,130g', '64-73cm', 'Marine and Intertidal'),
(330, 337, 'Not assessed', 'Seeds, buds and shoots.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Blue, Black, White', '18cm', '48-62g', '29-33cm', 'Woodland, Urban and Suburban'),
(331, 338, 'Not assessed', 'Mainly small birds and mammals.', 'Nulo', 'Nulo', '44-52cm', 'Nulo', '100-120cm', 'Upland, Marine and Intertidal, Farmland, Wetland, Grassland'),
(332, 339, 'Not assessed', 'Omnivorous- carrion, offal, seeds, fruits, young birds, eggs, small mammals, insects and fish.', 'Nulo', 'Grey, Black, White', '54-60cm', '690-1440g', '130-150cm', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(333, 340, 'Not assessed', 'Insects and small birds.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Blue, Black, White', '28-36cm', '131-340g', '70-92cm', 'Woodland, Urban and Suburban, Farmland, Heathland, Wetland, Grassland'),
(334, 341, 'Not assessed', 'Mainly insect larvae of wasps and bees.', 'Nulo', 'Nulo', '52-60cm', '600-1,100g', '135-150cm', 'Woodland'),
(335, 342, 'Not assessed', 'Omnivorous - includes carrion, invertebrates, grain, eggs, and young birds.', 'Nulo', 'Brown, Grey, Black', '45-47cm', '370-650g', '93-104cm', 'Woodland, Upland, Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(336, 343, 'Not assessed', 'Insects and spiders.', 'Nulo', 'Cream/Buff, Brown, Orange, Pink/Purple, Black, White', '26-28cm', '47-87g', '42-46cm', 'Urban and Suburban, Farmland, Grassland'),
(337, 344, 'Not assessed', 'Insects.', 'Nulo', 'Blue, Black, White', '12cm', '15-23g', '26-29cm', 'Urban and Suburban, Farmland, Wetland'),
(338, 345, 'Not assessed', 'Seeds and scraps.', 'Nulo', 'Nulo', '14-15cm', '24-38g', '21-25.5cm', 'Urban and Suburban, Farmland'),
(339, 346, 'Not assessed', 'Fish - alive or as carrion.', 'Nulo', 'Cream/Buff, Grey, White', '52-60cm', '750g', '130-158cm', 'Marine and Intertidal, Farmland, Wetland'),
(340, 347, 'Not assessed', 'Insects, worms and snails.', 'Nulo', 'Cream/Buff, Brown, Green, Black, White, Yellow', '17-19cm', '35-73g', '38-42cm', 'Wetland, Grassland'),
(341, 348, 'Not assessed', 'Insects, young birds and eggs, fruit, seeds and scraps.', 'Nulo', 'Grey, Black', '34cm', '220g', '70cm', 'Woodland, Upland, Urban and Suburban, Farmland, Grassland'),
(342, 349, 'Not assessed', 'Mainly acorns, nuts, seeds and insects, but also eats nestlings of other birds and small mammals.', 'Nulo', 'Cream/Buff, Brown, Grey, Pink/Purple, Blue, Black, White', '34-35cm', '140-190g', '52-58cm', 'Woodland, Urban and Suburban, Farmland'),
(343, 350, 'Not assessed', 'Small mammals and birds, worms and insects.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Red, Black', '32-35cm', '156-252g', '71-80cm', 'Urban and Suburban, Farmland, Heathland, Grassland'),
(344, 351, 'Not assessed', 'Fish and aquatic insects.', 'Nulo', 'Brown, Orange, Green, Blue, White', '16-17cm', '34-46g', '24-26cm', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland'),
(345, 352, 'Not assessed', 'Fish, shrimps and worms.', 'Nulo', 'Grey, Black, White', '38-40cm', '300-500g', '95-110cm', 'Marine and Intertidal'),
(346, 353, 'Not assessed', 'Shellfish and worms.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '23-25cm', '125-215g', '47-54cm', 'Marine and Intertidal, Wetland'),
(347, 354, 'Not assessed', 'Seeds', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '15-16cm', '20-28g', '25.5-28cm', 'Marine and Intertidal, Farmland, Grassland'),
(348, 355, 'Not assessed', 'Worms and insects.', 'Nulo', 'Brown, Grey, Orange, Green, Black, White', '28-31cm', '140-320g', '82-87cm', 'Upland, Marine and Intertidal, Farmland, Wetland, Grassland'),
(349, 356, 'Not assessed', 'Crustaceans, molluscs and small fish.', 'Nulo', 'Brown, Grey, Black, White', '19-22cm', '40-50g', '45-48cm', 'Marine and Intertidal'),
(350, 357, 'Not assessed', 'Omnivore - scavenges a wide range of food.', 'Nulo', 'Grey, Black, White', '52-64cm', '620-1,000g', '135-150cm', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(351, 358, 'Not assessed', 'Seeds, particularly of birch and alder, plus plants like willowherb and sorrel, but they also visit bird feeders.', 'Nulo', 'Cream/Buff, Brown, Grey, Pink/Purple, Red, Black, White', '11.5cm', '9-12g', '20-22.5cm', 'Woodland, Urban and Suburban, Farmland, Heathland, Wetland'),
(352, 359, 'Not assessed', 'Insects', 'Nulo', 'Cream/Buff, Red, Black, White', '14-15cm', '17-25g', '25-27cm', 'Woodland, Urban and Suburban, Wetland'),
(353, 360, 'Not assessed', 'In spring and summer, they mainly eat insects. In autumn, these warblers feed up on berries to build up their fat reserves before migration.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '13cm', '12g', '18cm', 'Woodland, Urban and Suburban, Farmland, Grassland'),
(354, 361, 'Not assessed', 'Seeds and insects.', 'Nulo', 'Nulo', '13.5cm', '15-22g', '21-25.5cm', 'Urban and Suburban, Farmland, Heathland, Grassland'),
(355, 362, 'Not assessed', 'Plankton, other tiny marine creatures and fish.', 'Nulo', 'Brown, Black, White', '17-19cm', '140-170g', '40-48cm', 'Marine and Intertidal'),
(356, 363, 'Not assessed', 'Fish.', 'Nulo', 'White', '55-65cm', '350-550g', '88-95cm', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(357, 364, 'Not assessed', 'Insects, larvae and small fish.', 'Nulo', 'Cream/Buff, Brown, Red, Black', '25-29cm', '100-140g', '40-45cm', 'Urban and Suburban, Marine and Intertidal, Wetland'),
(358, 365, 'Not assessed', 'Insects and fish.', 'Nulo', 'Grey, Pink/Purple, Black, White', '25-27cm', '85-150g', '70-78cm', 'Marine and Intertidal, Wetland'),
(359, 366, 'Not assessed', 'Small mammals and birds, beetles and worms.', 'Nulo', 'Cream/Buff, Brown, White', '21-23cm', '140-220g', '54-58cm', 'Woodland, Urban and Suburban, Farmland, Grassland'),
(360, 367, 'Not assessed', 'Insects and aquatic invertebrates.', 'Nulo', 'Cream/Buff, Brown, Black, White', '14-15cm', '32-48g', '42-48cm', 'Wetland, Grassland'),
(361, 368, 'Not assessed', 'Mainly insects - also crustaceans and molluscs.', 'Nulo', 'Cream/Buff, Brown, Orange, Black, White', '12-14cm', '20-40g', '34-37cm', 'Marine and Intertidal, Wetland, Grassland'),
(362, 369, 'Not assessed', 'Fish', 'Nulo', 'Grey, Black, White', '22-24cm', '49-63g', '48-55cm', 'Marine and Intertidal, Wetland'),
(363, 370, 'Not assessed', 'Small rodents, and small birds in winter.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Black', '35-37cm', '210-370g', '84-95cm', 'Woodland, Farmland, Wetland'),
(364, 371, 'Not assessed', 'Mussels, cockles, clams, crabs and small fish.', 'Nulo', 'Brown, Grey, Black, White', '58-60cm', '520-950g', '73-79cm', 'Marine and Intertidal'),
(365, 372, 'Not assessed', 'Small mammals and, when at sea, small fish, offal and carrion.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White, Yellow', '41-46cm', '240-350g', '105-117cm', 'Marine and Intertidal'),
(366, 373, 'Not assessed', 'Insects, occasionally seeds in autumn and winter.', 'Nulo', 'Cream/Buff, Brown, Pink/Purple, Black, White', '14cm', '7-10g', '16-19cm', 'Woodland, Urban and Suburban, Farmland, Heathland'),
(367, 374, 'Not assessed', 'Omnivore and scavenger.', 'Nulo', 'Green, Blue, Black, White', '44-46cm', '200-250g', '52-60cm', 'Woodland, Upland, Urban and Suburban, Farmland, Heathland, Wetland, Grassland'),
(368, 375, 'Not assessed', 'Seeds, acorns and berries, plants, insects and shellfish.', 'Nulo', 'Nulo', '51-62cm', '750-1500g', '81-98cm', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(369, 376, 'Not assessed', 'Insects, vegetation and seeds.', 'Nulo', 'Nulo', '41-49cm', '430-690g', '68-74cm', 'Woodland, Wetland'),
(370, 377, 'Not assessed', 'Fish, especially herrings, sardines and sprats.', 'Nulo', 'Brown, Black, White', '30-38cm', '350-450g', '76-82cm', 'Marine and Intertidal'),
(371, 378, 'Not assessed', 'Small birds and mammals.', 'Nulo', 'Nulo', '48-56cm', 'Nulo', '115-130cm', 'Marine and Intertidal, Farmland, Wetland'),
(372, 379, 'Not assessed', 'Insects and seeds. If Marsh Tits find a good supply - perhaps at a garden feeder - they may start to hoard seeds, burying and hiding them for a rainy day. Their hippocampus - the part of their brain which specialises in remembering things - is large, bigger than a Great Tit\'s.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '11.5cm', '10-13g', '18-19.5cm', 'Woodland, Urban and Suburban'),
(373, 380, 'Not assessed', 'Insects, and occasionally berries in autumn.', 'Nulo', 'Nulo', '13-15cm', '10-15g', '18-21cm', 'Nulo'),
(374, 381, 'Not assessed', 'Insects - flies, beetles and moths - and spiders.', 'Nulo', 'Cream/Buff, Brown, Grey, Green, Pink/Purple, Black, White', '14.5cm', '15-22g', '22-25cm', 'Upland, Marine and Intertidal, Farmland, Heathland, Wetland, Grassland'),
(375, 382, 'Not assessed', 'Insects, fish, offal and carrion.', 'Nulo', 'Brown, Grey, Black, White', '36-38cm', '230-280g', '92-100cm', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(376, 383, 'Not assessed', 'Mainly small birds.', 'Nulo', 'Nulo', '25-30cm', 'Nulo', '50-62cm', 'Upland, Marine and Intertidal, Farmland, Wetland, Grassland'),
(377, 384, 'Not assessed', 'Worms, slugs, insects and berries.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '27cm', '100-150g', '42-48cm', 'Woodland, Urban and Suburban, Farmland, Heathland, Grassland'),
(378, 385, 'Not assessed', 'Small birds, voles, shrews, rabbits, lizards and insects.', 'Nulo', 'Nulo', '43-47cm', '225-450g', '100-120cm', 'Farmland, Wetland, Grassland'),
(379, 386, 'Not assessed', 'Water plants, seeds, fruit, grasses, insects, snails, worms and small fish.', 'Nulo', 'Brown, Black, White', '32-35cm', '250-400g', '50-55cm', 'Urban and Suburban, Farmland, Wetland, Grassland'),
(380, 387, 'Not assessed', 'Water plants, insects and snails.', 'Nulo', 'White', '140-160cm', '10,000-12,000g', '208-238cm', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(381, 388, 'Not assessed', 'Insects.', 'Nulo', 'Cream/Buff, Brown, White', '15-17cm', '17-24g', '23-26cm', 'Woodland, Wetland, Grassland'),
(382, 389, 'Not assessed', 'Insects - moths and beetles.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '26-28cm', '65-100g', '57-64cm', 'Woodland, Heathland'),
(383, 390, 'Not assessed', 'Insects, hazel nuts, acorns, beechmast and other nuts and seed.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Blue, Black, White', '14cm', '20-25g', '22.5-27cm', 'Woodland, Urban and Suburban'),
(384, 391, 'Not assessed', 'Fish.', 'Nulo', 'Cream/Buff, Brown, White', '52-60cm', '1,200-2,000g', '145-170cm', 'Marine and Intertidal, Wetland'),
(385, 392, 'Not assessed', 'Mussels and cockles on the coast, mainly worms inland.', 'Nulo', 'Black, White', '40-45cm', '430-650g', '80-86cm', 'Upland, Marine and Intertidal, Farmland, Wetland, Grassland'),
(386, 393, 'Not assessed', 'Conifer seeds, mainly pine, and some insects in the breeding season.', 'Nulo', 'Nulo', '16-18cm', '48-61g', '30-34cm', 'Woodland'),
(387, 394, 'Not assessed', 'Small creatures that live in shoreline mud.', 'Nulo', 'Cream/Buff, Brown, Orange, Black, White', '19-23cm', '68-94g', '38-44cm', 'Marine and Intertidal, Wetland, Grassland'),
(388, 395, 'Not assessed', 'Medium-sized birds, such as wading birds, pigeons and small ducks.', 'Nulo', 'Grey, Black, White', '39-50cm', '600-1300g', '95-115cm', 'Upland, Marine and Intertidal, Farmland, Wetland, Grassland'),
(389, 396, 'Not assessed', 'Seeds, grain, shoots and insects.', 'Nulo', 'Nulo', '53-89cm', 'Nulo', '70-90cm', 'Woodland, Urban and Suburban, Farmland, Grassland'),
(390, 397, 'Not assessed', 'Insects and caterpillars, fruit and seeds in late summer and on migration.', 'Nulo', 'Nulo', '13cm', '12-15g', '21-24cm', 'Woodland, Urban and Suburban'),
(391, 398, 'Not assessed', 'Mainly insects, may eat seeds and household scraps in winter.', 'Nulo', 'Cream/Buff, Grey, Black, White', '18cm', '17-25g', '25-30cm', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(392, 399, 'Not assessed', 'Grain, winter cereals, potatoes and grass.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '60-76cm', '2,200-2,700g', '135-160cm', 'Marine and Intertidal, Farmland, Wetland, Grassland'),
(393, 400, 'Not assessed', 'A variety of plants and invertebrates.', 'Nulo', 'Nulo', '63-70cm', '700-900g', '80-95cm', 'Marine and Intertidal, Wetland, Grassland'),
(394, 401, 'Not assessed', 'Plants and seeds, snails, small fish and insects.', 'Nulo', 'Nulo', '46cm', '930g', '77cm', 'Urban and Suburban, Marine and Intertidal, Wetland'),
(395, 402, 'Not assessed', 'Shoots, leaves, leaf buds, berries and insects.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '34-36cm', '400-600g', '54-60cm', 'Upland'),
(396, 403, 'Not assessed', 'Fish, especially sandeels.', 'Nulo', 'Grey, Black, White', '26-29cm', '320-480g', '47-63cm', 'Marine and Intertidal'),
(397, 404, 'Not assessed', 'Winkles, insects, spiders, crustaceans and plants.', 'Nulo', 'Brown, Grey, Pink/Purple, Black, White', '20-22cm', '60-75g', '40-44cm', 'Marine and Intertidal'),
(398, 405, 'Not assessed', 'Seeds and insects.', 'Nulo', 'Cream/Buff, Brown, Black, White', '16-18cm', '75-135g', '32-35cm', 'Farmland, Grassland'),
(399, 406, 'Not assessed', 'Carrion, mammals, birds and eggs, insects and other invertebrates.', 'Nulo', 'Blue, Black', '60-68cm', '800-1,500g', '120-150cm', 'Woodland, Upland, Urban and Suburban, Marine and Intertidal, Farmland'),
(400, 407, 'Not assessed', 'Fish, especially sandeels, sprats and herrings.', 'Nulo', 'Black, White', '37-39cm', '590-730g', '63-67cm', 'Marine and Intertidal'),
(401, 408, 'Not assessed', 'Heather, seeds, berries, insects', 'Nulo', 'Brown, Orange, Red, White', '37-42cm', '650-750g', '55-66cm', 'Upland'),
(402, 409, 'Not assessed', 'Mainly carrion and worms, but opportunistic and will occasionally take small mammals.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Red, Black, White', '60-66cm', '800-1,300g', '175-195cm', 'Woodland, Upland, Urban and Suburban, Farmland'),
(403, 410, 'Not assessed', 'Insects, and small birds and mammals', 'Nulo', 'Nulo', '17cm', '25-35g', '24-27cm', 'Woodland, Marine and Intertidal, Farmland, Heathland, Grassland'),
(404, 411, 'Not assessed', 'Fish', 'Nulo', 'Nulo', '52-58cm', '900-1,350g', '70-86cm', 'Marine and Intertidal, Wetland'),
(405, 412, 'Not assessed', 'Stems, roots and seeds of aquatic vegetation.', 'Nulo', 'Nulo', '53-57cm', '900-1,400g', '85-90cm', 'Wetland'),
(406, 413, 'Not assessed', 'Seeds and roots.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Blue, Black, White', '32-34cm', '400-550g', '47-50cm', 'Urban and Suburban, Farmland, Heathland, Grassland'),
(407, 414, 'Not assessed', 'Fish, crustaceans, aquatic insects.', 'Nulo', 'Brown, Grey, Red, Black, White', '40-46cm', '700-900g', '77-85cm', 'Marine and Intertidal, Wetland'),
(408, 415, 'Not assessed', 'Mainly insects.', 'Nulo', 'Nulo', '17-19cm', '27-48g', '32-41cm', 'Marine and Intertidal, Wetland'),
(409, 416, 'Not assessed', 'Fish.', 'Nulo', 'Brown, Grey, Red, Black, White', '53-69cm', '1,200-1,600g', '106-116cm', 'Marine and Intertidal, Wetland'),
(410, 417, 'Not assessed', 'Redshanks hunt for insects, earthworms, molluscs and crustaceans by probing their bills into soil and mud.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '28cm', 'Nulo', '62cm', 'Upland, Marine and Intertidal, Wetland, Grassland'),
(411, 418, 'Not assessed', 'Mainly insects; also spiders, worms and berries.', 'Nulo', 'Nulo', '14cm', '11-19g', '20-24cm', 'Woodland, Upland, Urban and Suburban'),
(412, 419, 'Not assessed', 'Berries and worms.', 'Nulo', 'Cream/Buff, Brown, Orange, Red, Black, White', '21cm', '50-75g', '33-35cm', 'Woodland, Urban and Suburban, Farmland, Grassland'),
(413, 420, 'Not assessed', 'Seeds and insects.', 'Nulo', 'Nulo', '15-16.5cm', '16-25g', '21-28cm', 'Urban and Suburban, Farmland, Wetland, Grassland'),
(414, 421, 'Not assessed', 'Insects; berries in autumn.', 'Nulo', 'Cream/Buff, Brown, White', '13cm', '10-15g', '17-21cm', 'Urban and Suburban, Farmland, Wetland'),
(415, 422, 'Not assessed', 'Insects and berries.', 'Nulo', 'Nulo', '23-24cm', '95-130g', '38-42cm', 'Upland, Farmland, Grassland'),
(416, 423, 'Not assessed', 'Fruit, berries, nuts and seeds.', 'Nulo', 'Green, Pink/Purple, Blue, Red, White', '38-42cm', '96-139g', '42-48cm', 'Woodland, Urban and Suburban'),
(417, 424, 'Not assessed', 'Flies, spiders, marine worms, crustaceans, molluscs.', 'Nulo', 'Cream/Buff, Brown, Black, White', '18-20cm', '55-75g', '48-57cm', 'Marine and Intertidal, Wetland, Grassland'),
(418, 425, 'Not assessed', 'Worms, seeds, fruits, insects and other invertebrates.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Red, White, Yellow', '14cm', '14-21g', '20-22cm', 'Woodland, Urban and Suburban, Farmland'),
(419, 426, 'Not assessed', 'Seeds and cereals.', 'Nulo', 'Cream/Buff, Brown, Grey, Pink/Purple, Blue, Black, White', '31-34cm', '230-370g', '63-70cm', 'Urban and Suburban, Marine and Intertidal, Farmland'),
(420, 427, 'Not assessed', 'Insects, beetles, small fish, small shellfish and seeds.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '16.5cm', '20-30g', '23-28cm', 'Marine and Intertidal, Wetland'),
(421, 428, 'Not assessed', 'Rooks will eat almost anything, including worms, grain, nuts and insects, small mammals, birds (especially eggs and nestlings) and Carrion.', 'Nulo', 'Blue, Black', '44-46cm', '280-340g', '81-99cm', 'Woodland, Urban and Suburban, Farmland, Grassland'),
(422, 429, 'Not assessed', 'Fish.', 'Nulo', 'Grey, Pink/Purple, Black, White', '33-38cm', '95-130g', '72-80cm', 'Marine and Intertidal'),
(423, 430, 'Not assessed', 'Mammals, including rabbits and voles. On the breeding grounds, lemmings are a staple food.', 'Nulo', 'Brown, Grey, Black, White', '50-60cm', '600-1300g', '120-150cm', 'Marine and Intertidal, Farmland, Wetland'),
(424, 431, 'Not assessed', 'Aquatic insect larvae and plant seeds.', 'Nulo', 'Nulo', '35-43cm', '350-800g', '53-62cm', 'Wetland'),
(425, 432, 'Not assessed', 'Insects, larvae, frogs, small fish, seeds.', 'Nulo', 'Nulo', '20-32cm', '70-150g', '46-58cm', 'Farmland, Wetland, Grassland'),
(426, 433, 'Not assessed', 'Invertebrates, taken on the wing.', 'Nulo', 'Cream/Buff, Brown, White', '12cm', '13-14g', '26-29cm', 'Farmland, Wetland'),
(427, 434, 'Not assessed', 'Small marine worms, crustaceans and molluscs.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Black, White', '20-21cm', '50-60g', '36-39cm', 'Marine and Intertidal, Wetland, Grassland'),
(428, 435, 'Not assessed', 'Fish including sandeels, sprats and whiting.', 'Nulo', 'Grey, Black, White', '36-41cm', '210-260g', '95-105cm', 'Marine and Intertidal, Wetland'),
(429, 436, 'Not assessed', 'Insects', 'Nulo', 'Nulo', '14-15cm', '14.5-16.5g', '15-20cm', 'Nulo'),
(430, 437, 'Not assessed', 'Shellfish, crustacea and small insects.', 'Nulo', 'Nulo', '42-51cm', '800g-1,300g', '67-78cm', 'Marine and Intertidal, Wetland'),
(431, 438, 'Not assessed', 'Pine seeds.', 'Nulo', 'Nulo', '16-17cm', '44g', '27-37cm', 'Woodland'),
(432, 439, 'Not assessed', 'Insects, berries in autumn.', 'Nulo', 'Cream/Buff, Brown, Black, White, Yellow', '13cm', '10-13g', '17-21cm', 'Urban and Suburban, Farmland, Wetland'),
(433, 440, 'Not assessed', 'Seeds, buds and small invertebrates.', 'Nulo', 'Nulo', '11-12cm', '12-15g', '18-20cm', 'Nulo'),
(434, 441, 'Not assessed', 'Fish, crustacea and molluscs.', 'Nulo', 'Brown, Green, Black', '65-80cm', '1750-2250g', '90-105cm', 'Marine and Intertidal'),
(435, 442, 'Not assessed', 'Invertebrates, small shellfish, aquatic snails.', 'Nulo', 'Cream/Buff, Brown, Orange, Green, Black, White', '58-65cm', '850g-1400g', '110-133cm', 'Marine and Intertidal, Farmland, Wetland, Grassland'),
(436, 443, 'Not assessed', 'Seeds and small insects.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White, Yellow', '14-17cm', '35-45g', '30-35cm', 'Marine and Intertidal'),
(437, 444, 'Not assessed', 'Small mammals especially voles.', 'Nulo', 'Cream/Buff, Brown, Black, White', '34-42cm', '260-350g', '90-105cm', 'Upland, Marine and Intertidal, Farmland, Wetland, Grassland'),
(438, 445, 'Not assessed', 'Small insects, plant matter sifted from the water.', 'Nulo', 'Nulo', '44-52cm', '400-1,000g', '70-84cm', 'Marine and Intertidal, Wetland, Grassland'),
(439, 446, 'Not assessed', 'Seeds (especially of conifers), alders, birch, some insects.', 'Nulo', 'Cream/Buff, Brown, Green, Black, White, Yellow', '12cm', '12-18g', '20-23cm', 'Woodland, Urban and Suburban'),
(440, 447, 'Not assessed', 'Seeds, insects.', 'Nulo', 'Cream/Buff, Brown, Black', '18-19cm', '33-45g', '30-36cm', 'Upland, Marine and Intertidal, Farmland, Heathland, Grassland'),
(441, 448, 'Nulo', 'Nulo', 'Nulo', 'Nulo', 'Nulo', 'Nulo', 'Nulo', 'Nulo'),
(442, 449, 'Not assessed', 'Fish, insect larvae and other insects.', 'Nulo', 'Grey, Black, White', '36-44cm', '500-800g', '55-69cm', 'Marine and Intertidal, Wetland'),
(443, 450, 'Not assessed', 'Small invertebrates (including worms and insect larvae).', 'Nulo', 'Cream/Buff, Brown, Black, White', '23-28cm', '80-120g', '39-45cm', 'Upland, Marine and Intertidal, Farmland, Wetland, Grassland'),
(444, 451, 'Not assessed', 'Seeds, insects.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '16-17cm', '28-50g', '32-38cm', 'Upland, Marine and Intertidal, Farmland'),
(445, 452, 'Not assessed', 'Grass.', 'Nulo', 'Nulo', '65-80cm', '1800-4300g', '132-165cm', 'Nulo'),
(446, 453, 'Not assessed', 'Worms, snails, fruit.', 'Nulo', 'Cream/Buff, Brown, Orange, Black, White', '23cm', '65-100g', '33-36cm', 'Woodland, Urban and Suburban, Farmland, Grassland'),
(447, 454, 'Not assessed', 'Fish, squid, crustaceans, offal from fishing boats.', 'Nulo', 'Brown, Grey, Black, White', '40-51cm', '650-950g', '94-109cm', 'Marine and Intertidal'),
(448, 455, 'Not assessed', 'Mainly small birds', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Blue, Black, White', '28-38cm', 'Nulo', '55-70cm', 'Urban and Suburban, Farmland, Heathland, Wetland, Grassland'),
(449, 456, 'Not assessed', 'Mainly aquatic invertebrates and small fish.', 'Nulo', 'Cream/Buff, White, Yellow', '80-90cm', '1,300-2,000g', '120-135cm', 'Marine and Intertidal, Wetland'),
(450, 457, 'Not assessed', 'Insects, snails, worms, small fish and plant materials.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '22-24cm', '70-110g', '37-42cm', 'Wetland'),
(451, 458, 'Not assessed', 'Flying insects, such as moths, butterflies, damselflies, craneflies and other tasty morsels. If the weather is bad, they can search trees and shrubs for other insect food.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '14cm', '14-19g', '23-25cm', 'Woodland, Urban and Suburban, Farmland'),
(452, 459, 'Not assessed', 'Insect larvae, shrimps, small fish and worms.', 'Nulo', 'Nulo', '29-31cm', '140-200g', '61-67cm', 'Marine and Intertidal, Wetland, Grassland'),
(453, 460, 'Not assessed', 'Invertebrates, fruit.', 'Nulo', 'Cream/Buff, Brown, Grey, Green, Pink/Purple, Blue, Black, White', '21cm', '75-90g', '37-42cm', 'Woodland, Upland, Urban and Suburban, Marine and Intertidal, Farmland, Wetland, Grassland'),
(454, 461, 'Not assessed', 'Seeds.', 'Nulo', 'Grey, Green, Pink/Purple, Blue, Black, White', '30-33cm', '290-330g', '60-66cm', 'Woodland, Urban and Suburban, Farmland'),
(455, 462, 'Not assessed', 'Invertebrates that are found on the ground.', 'Nulo', 'Cream/Buff, Brown, Black, White', '40-44cm', '430-500g', '77-85cm', 'Farmland, Heathland, Grassland'),
(456, 463, 'Not assessed', 'Invertebrates, seeds, fruit.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Black, White', '12.5cm', '13-17g', '18-21cm', 'Marine and Intertidal, Farmland, Heathland, Wetland, Grassland'),
(457, 464, 'Not assessed', 'Fish, plankton and crustaceans.', 'Nulo', 'Brown, Grey, Black, White', '14-18cm', '23-30g', '36-39cm', 'Marine and Intertidal'),
(458, 465, 'Not assessed', 'A range of small invertebrates which are caught on the wing.', 'Nulo', 'Cream/Buff, Orange, Blue, Red, Black, White', '17-19cm', '16-25g', '32-35cm', 'Upland, Urban and Suburban, Farmland, Wetland, Grassland'),
(459, 466, 'Not assessed', 'Flying insects and airborne spiders.', 'Nulo', 'Cream/Buff, Brown, Black, White', '16-17cm', '36-50g', '42-48cm', 'Urban and Suburban, Farmland, Wetland, Grassland'),
(460, 467, 'Not assessed', 'Grass, cereals, potatoes and other crops.', '50,000 – 70,000 individuals', 'Cream/Buff, Brown, Grey, White', '66-88cm', 'Nulo', '147-175cm', 'Farmland, Wetland, Grassland'),
(461, 468, 'Not assessed', 'Small mammals and rodents, small birds, frogs, fish, insects and worms.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Black, White', '37-39cm', '350-590g', '94-104cm', 'Woodland, Urban and Suburban, Farmland'),
(462, 469, 'Not assessed', 'Seeds and small invertebrates.', 'Nulo', 'Nulo', '34-38cm', '240-360g', '58-64cm', 'Marine and Intertidal, Wetland, Grassland'),
(463, 470, 'Not assessed', 'Insects and larvae, worms, crustaceans and molluscs.', '85,000-420,000 pairs (including Russia)', 'Cream/Buff, Brown, Grey, Black, White', '13-15cm', '2,400g', '34-37cm', 'Marine and Intertidal, Wetland, Grassland'),
(464, 471, 'Not assessed', 'Mainly small invertebrates. Some plant matter, especially berries, in autumn.', 'Nulo', 'Cream/Buff, Brown, White', '15cm', '20-25g', '25-27cm', 'Woodland, Heathland, Grassland'),
(465, 472, 'Not assessed', 'Seeds and insects.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '14cm', '19-25g', '20-22cm', 'Woodland, Urban and Suburban, Farmland'),
(466, 473, 'Not assessed', 'Insects and spiders, and some seeds in winter.', 'Nulo', 'Cream/Buff, Brown, Black, White', '12.5cm', '8-12g', '18-21cm', 'Woodland, Urban and Suburban, Farmland'),
(467, 474, 'Not assessed', 'Molluscs, insects and some plants.', 'Nulo', 'Nulo', '40-47cm', '450-1000g', '67-73cm', 'Urban and Suburban, Marine and Intertidal, Wetland'),
(468, 475, 'Not assessed', 'Grass, cereals, potatoes and other crops.', '550,000 individuals', 'Cream/Buff, Brown, Grey, White', '53-70cm', 'Nulo', '118-140cm', 'Farmland, Wetland, Grassland'),
(469, 476, 'Not assessed', 'Insects, crustaceans and molluscs.', 'Nulo', 'Brown, Black, White', '21-24cm', '85-150g', '50-57cm', 'Marine and Intertidal, Wetland'),
(470, 477, 'Not assessed', 'Seeds.', 'Nulo', 'Cream/Buff, Brown, Grey, Orange, Pink/Purple, Blue, Black, White', '26-28cm', '130-180g', '47-53cm', 'Woodland, Urban and Suburban, Farmland, Heathland, Grassland'),
(471, 478, 'Not assessed', 'Seeds.', 'Nulo', 'Cream/Buff, Brown, Orange, Pink/Purple, White', '14cm', '13-18g', '22-24cm', 'Upland, Marine and Intertidal, Farmland, Grassland'),
(472, 479, 'Not assessed', 'Shellfish, crabs, sea urchins, fish and insect larvae.', 'Nulo', 'Brown, Black, White', '52-59cm', '1,100-2,000g', '90-99cm', 'Marine and Intertidal'),
(473, 480, 'Not assessed', 'Insects and larvae.', 'Nulo', 'Cream/Buff, Brown, Grey, White', '17cm', '20-36g', '22.5-28cm', 'Nulo'),
(474, 481, 'Not assessed', 'Omnivorous - mainly small fish, snails and insects.', 'Nulo', 'Cream/Buff, Brown, Grey, Blue, Black, White', '23-28cm', '80-180g', '38-45cm', 'Urban and Suburban, Wetland, Grassland'),
(475, 482, 'Not assessed', 'Berries, particularly rowan and hawthorn, but also cotoneaster and rose.', 'Nulo', 'Cream/Buff, Brown, Grey, Pink/Purple, Red, Black, White, Yellow', '18cm', '45-70g', '32-35cm', 'Urban and Suburban, Farmland'),
(476, 483, 'Not assessed', 'Insects and larvae.', 'Nulo', 'Nulo', '14.5-15.5cm', '17-30g', '26-32cm', 'Upland, Farmland, Grassland'),
(477, 484, 'Not assessed', 'On breeding grounds insects, snails and slugs; on passage, crabs, shrimps, molluscs, worms.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '40-46cm', '270-450g', '71-81cm', 'Upland, Marine and Intertidal, Wetland, Grassland'),
(478, 485, 'Not assessed', 'Insects and some seeds.', 'Nulo', 'Nulo', '12.5cm', '16-24g', '21-24cm', 'Woodland, Upland, Farmland, Heathland, Grassland'),
(479, 486, 'Not assessed', 'Grass, clover, grain, winter wheat and potatoes.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '65-78cm', '1,900-2,500g', '130-165cm', 'Marine and Intertidal, Farmland, Wetland, Grassland'),
(480, 487, 'Not assessed', 'White-tailed Eagles are versatile and opportunistic hunters and carrion feeders, sometimes pirating food from other birds and even otters. They eat largely fish, but also take various birds, rabbits and hares. Some pairs kill many Fulmars, which are thought to be the source of DDT and PCBs (chemicals) recorded in eagle eggs. Carrion is an important part of their diet, especially during the winter months. Most lambs are taken as carrion. When fishing, they fly low over water, stop to hover for a moment and drop to snatch fish from the surface. During the breeding season while they are rearing young, they require 500-600g of food per day. This drops to 200-300g per day during the winter months when the birds are less active.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '70-90cm', 'Nulo', '200-240cm', 'Upland, Marine and Intertidal, Farmland, Wetland'),
(481, 488, 'Not assessed', 'Insects, and berries and fruit in autumn.', 'Nulo', 'Nulo', '14cm', '12-18g', '18.5-23cm', 'Woodland, Urban and Suburban, Farmland, Heathland, Grassland'),
(482, 489, 'Not assessed', 'Aquatic plants, grass, grain, potatoes.', 'Nulo', 'White', '140-160cm', '9,000-11,000g', '205-235cm', 'Marine and Intertidal, Farmland, Wetland, Grassland'),
(483, 490, 'Not assessed', 'Aquatic plants, grasses, roots.', 'Nulo', 'Nulo', '45-51cm', '500-900g', '75-86cm', 'Marine and Intertidal, Wetland, Grassland'),
(484, 491, 'Not assessed', 'Insects, seeds and berries.', 'Nulo', 'Cream/Buff, Brown, Grey, Black, White', '11.5cm', '8-14g', '17-19cm', 'Woodland, Urban and Suburban'),
(485, 492, 'Not assessed', 'A wide variety of small insects and spiders. Fruit and berries in autumn.', 'Nulo', 'Cream/Buff, Brown, Green, Yellow', '10.5-11.5cm', '7-12g', '16-22cm', 'Woodland, Urban and Suburban, Heathland, Grassland'),
(486, 493, 'Not assessed', 'Insects, worms, spiders, shellfish, small fish and small aquatic invertebrates.', 'Nulo', 'Cream/Buff, Brown, Black, White', '19-21cm', '50-90g', '36-40cm', 'Wetland, Grassland'),
(487, 494, 'Not assessed', 'Mainly insects and spiders.', 'Nulo', 'Cream/Buff, Brown, Green, Black, White, Yellow', '12-13cm', '8-12g', '19.5-24cm', 'Woodland, Urban and Suburban'),
(488, 495, 'Not assessed', 'Worms, beetles, spiders, caterpillars, fly larvae and small snails.', 'Nulo', 'Cream/Buff, Brown, Black', '33-35cm', '240-420g', '55-65cm', 'Woodland, Upland, Urban and Suburban, Farmland'),
(489, 496, 'Not assessed', 'Seeds and insects.', 'Nulo', 'Cream/Buff, Brown, Black, White', '15cm', '25-35g', '27-30cm', 'Woodland, Farmland, Heathland'),
(490, 497, 'Not assessed', 'Crops like cabbages, sprouts, peas and grain. Also buds, shoots, seeds, nuts and berries.', 'Nulo', 'Brown, Grey, Pink/Purple, Blue, Black, White', '40-42cm', '480-550g', '75-80cm', 'Woodland, Urban and Suburban, Farmland, Grassland'),
(491, 498, 'Not assessed', 'Insects and spiders.', 'Nulo', 'Cream/Buff, Brown, White', '9-10cm', '7-12g', '13-17cm', 'Woodland, Urban and Suburban, Farmland, Heathland'),
(492, 499, 'Not assessed', 'Ants.', 'Nulo', 'Cream/Buff, Brown, Grey, Black', '16-17cm', '30-45g', '25-27cm', 'Urban and Suburban, Farmland, Grassland'),
(493, 500, 'Not assessed', 'Small insects, including flies and beetles.', 'Nulo', 'Nulo', '17cm', '16-22g', '23-27cm', 'Grassland'),
(494, 501, 'Not assessed', 'Insects.', 'Nulo', 'Brown, Grey, Green, White, Yellow', '10cm', '7g', 'Nulo', 'Woodland, Urban and Suburban'),
(495, 502, 'Not assessed', 'Omnivorous - a scavenger.', 'Nulo', 'Grey, Black, White', '55-67cm', 'Nulo', 'Nulo', 'Urban and Suburban, Marine and Intertidal, Farmland, Wetland'),
(496, 503, 'Not assessed', 'Seeds and insects.', 'Nulo', 'Nulo', '16-16.5cm', '25-36g', '23-29.5cm', 'Nulo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Datos`
--
ALTER TABLE `Datos`
  ADD PRIMARY KEY (`id_clave`),
  ADD KEY `id_pajaro` (`id_pajaro`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Datos`
--
ALTER TABLE `Datos`
  MODIFY `id_clave` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=497;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Datos`
--
ALTER TABLE `Datos`
  ADD CONSTRAINT `Datos_ibfk_1` FOREIGN KEY (`id_pajaro`) REFERENCES `Pajaro` (`id_pajaro`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
