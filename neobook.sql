-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 19 fév. 2025 à 10:49
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `neobook`
--

-- --------------------------------------------------------

--
-- Structure de la table `basket`
--

DROP TABLE IF EXISTS `basket`;
CREATE TABLE IF NOT EXISTS `basket` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_ht` double NOT NULL,
  `total_ttc` double NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2246507B9395C3F3` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `basket`
--

INSERT INTO `basket` (`id`, `customer_id`, `created_at`, `updated_at`, `user_token`, `total_ht`, `total_ttc`, `status`) VALUES
(69, 1, '2025-02-09 22:32:12', '2025-02-10 09:33:02', 'njer1d8u7conptmdpl4pajfsm0', 7.71, 0, 'abandonné'),
(72, 1, '2025-02-10 09:39:15', '2025-02-10 09:39:20', 'eagbgkausp6m3ons76css6bd7g', 35.71, 0, 'abandonné'),
(78, NULL, '2025-02-10 10:50:27', '2025-02-10 10:50:27', 'bu2erh0khll71j6rrpamqogndg', 18.28, 0, 'En cours'),
(80, 1, '2025-02-10 10:52:48', '2025-02-16 17:09:21', '9gmfqqvrbc1lgifc0nuhku8g9g', 35.75, 40.37, 'Transformé'),
(86, NULL, '2025-02-10 19:36:27', '2025-02-10 19:36:27', 'gusiiilin8gn1eq2190p25fqep', 7.89, 0, 'En cours'),
(89, NULL, '2025-02-10 19:55:05', '2025-02-10 19:55:05', '8nk2t416qop6af3f1c0fsdi3dh', 18.28, 0, 'En cours'),
(90, NULL, '2025-02-10 19:57:52', '2025-02-10 20:58:14', '5b94tj274h10pp3ucqksckvr3p', 18.28, 0, 'Abandonné'),
(95, NULL, '2025-02-16 16:25:18', '2025-02-16 16:32:04', '7tie7hinfe0la8egvlcb7uqstc', 14.38, 15.17, 'Abandonné'),
(96, NULL, '2025-02-16 16:44:31', '2025-02-16 16:48:24', '7tie7hinfe0la8egvlcb7uqstc', 14.38, 15.17, 'Abandonné'),
(97, NULL, '2025-02-16 16:48:24', '2025-02-16 16:51:25', '7tie7hinfe0la8egvlcb7uqstc', 14.38, 15.17, 'Abandonné'),
(98, NULL, '2025-02-16 16:51:25', '2025-02-16 16:54:31', '7tie7hinfe0la8egvlcb7uqstc', 0, 0, 'Abandonné'),
(99, NULL, '2025-02-16 16:54:31', '2025-02-16 16:58:16', '7tie7hinfe0la8egvlcb7uqstc', 0, 0, 'Abandonné'),
(100, 1, '2025-02-16 16:58:16', '2025-02-16 17:03:53', '7tie7hinfe0la8egvlcb7uqstc', 0, 0, 'Abandonné'),
(103, 1, '2025-02-16 17:05:36', '2025-02-16 17:09:12', '7tie7hinfe0la8egvlcb7uqstc', 14.9, 15.72, 'Abandonné'),
(104, 1, '2025-02-16 17:13:05', '2025-02-16 17:13:07', '7tie7hinfe0la8egvlcb7uqstc', 35.71, 37.67, 'Transformé'),
(105, 2, '2025-02-16 17:15:50', '2025-02-16 17:16:08', 'pnuko3u9lb8kolkhdpcdqlflat', 9.46, 9.98, 'Transformé'),
(106, 1, '2025-02-16 17:34:56', '2025-02-16 17:35:05', 'u59n6359ag4n1grmrs8e5gtar2', 7.89, 8.32, 'Transformé'),
(107, 1, '2025-02-16 17:46:07', '2025-02-16 17:46:13', '9n0jss28ih1r8u2cb8ntc567ii', 18.3, 21.96, 'Transformé'),
(108, 1, '2025-02-16 17:50:26', '2025-02-16 17:50:30', 'toa9df9mod2tdkm2jeogb9s3cs', 17.45, 0, 'Transformé'),
(109, 1, '2025-02-16 17:50:51', '2025-02-16 17:50:51', 'toa9df9mod2tdkm2jeogb9s3cs', 35.71, 37.67, 'abandonné'),
(110, NULL, '2025-02-19 09:16:25', '2025-02-19 09:17:22', 'p62vu34g56c04c3qne4s4qu2p1', 0, 0, 'Abandonné'),
(111, NULL, '2025-02-19 09:17:22', '2025-02-19 09:17:55', 'p62vu34g56c04c3qne4s4qu2p1', 34.34, 40.68, 'En cours');

-- --------------------------------------------------------

--
-- Structure de la table `basket_format`
--

DROP TABLE IF EXISTS `basket_format`;
CREATE TABLE IF NOT EXISTS `basket_format` (
  `basket_id` int NOT NULL,
  `format_id` int NOT NULL,
  PRIMARY KEY (`basket_id`,`format_id`),
  KEY `IDX_18E0D3261BE1FB52` (`basket_id`),
  KEY `IDX_18E0D326D629F605` (`format_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `basket_format`
--

INSERT INTO `basket_format` (`basket_id`, `format_id`) VALUES
(69, 243),
(72, 204),
(72, 243),
(78, 238),
(80, 210),
(80, 237),
(86, 242),
(89, 238),
(90, 238),
(95, 203),
(96, 203),
(97, 203),
(103, 243),
(104, 204),
(104, 243),
(105, 209),
(106, 242),
(107, 237),
(108, 233),
(109, 204),
(109, 243),
(110, 247);

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `editor_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parution_date` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CBE5A3316995AC4C` (`editor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=208 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id`, `editor_id`, `title`, `cover`, `summary`, `genre`, `parution_date`, `status`, `created_at`, `updated_at`) VALUES
(166, 115, 'Jean Jaurès, n\'oublions pas ses combats', 'petite-histoire-de-jean-jaures-678ce5a584003.jpg', '<p>Reprehenderit distinctio voluptas et magni repellendus. Accusantium rem ut aut vero atque. Tenetur nulla ut blanditiis reprehenderit est perferendis. Commodi cumque quia exercitationem.</p>', 'riou', '2025-01-20', 1, '0000-00-00 00:00:00', '2025-02-16 08:48:44'),
(168, 115, 'Une fleur pour l\'éternité', 'une-fleur-pour-l-eternite-678ce7472726a.jpg', '<p>Mollitia ad non praesentium nesciunt nemo pariatur nobis. Deleniti in ullam debitis inventore aut. Delectus id libero rerum consequatur magnam. Alias et voluptas suscipit autem neque doloribus.</p>', 'boulay', '2015-05-18', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(169, 117, 'Jean Jaurès, n\'oublions pas ses combats', 'petite-histoire-de-jean-jaures-678ce7578f894.jpg', '<p>Error delectus et est sequi mollitia nostrum. Nulla perferendis quisquam earum optio ipsam. Omnis laudantium eligendi culpa veritatis ad maiores. Deserunt nam a quis non occaecati dignissimos.</p>', 'dufour', '2004-12-21', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(170, 114, 'Le goût subtil du venin', 'le-gout-subtil-du-venin-678ce7681a5d6.jpg', '<p>Ut aliquid quam est qui. Dolore nihil et quam dicta molestiae sint aperiam.</p>', 'hoarau', '1973-12-10', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(171, 114, 'La Terre éphémère', 'la-terre-ephemere-tome-5-osmose-678ce782414a3.jpg', '<p>Veniam nisi sunt voluptate voluptatem eius aut nihil quo. Ut omnis esse eligendi ducimus voluptatem veritatis fuga vel. Laborum ut similique aut dolores sed et doloremque.</p>', 'delaunay', '1971-05-23', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(172, 114, 'Derrière la fumée', 'derriere-la-fumee-678ce78fa4478.jpg', '<p>Est odio ut dolorem consequatur repellat dignissimos. Quia necessitatibus nihil nobis alias sint dolor aut. Corrupti nihil amet optio aut quia quas.</p>', 'clerc', '1982-12-06', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(174, 116, 'Derrière la fumée', 'derriere-la-fumee-678ce81690aed.jpg', 'Vitae laboriosam culpa id sint. Sint hic natus vel. Et pariatur vel at cupiditate laboriosam soluta quis. Voluptatum iure quasi quidem odio in harum eum earum.', 'lemonnier', '2007-09-06', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(175, 114, 'La Terre éphémère', 'la-terre-ephemere-tome-5-osmose-678ce8270c5c4.jpg', '<p>Odio magnam voluptatem beatae qui qui aspernatur. Facere dolore esse molestiae in. Et assumenda nulla quo. Quaerat earum maxime suscipit. Est at tempore repudiandae consequuntur.</p>', 'moulin', '1979-03-14', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(178, 115, 'Le goût subtil du venin', 'le-gout-subtil-du-venin-678ceb33d90db.jpg', '<p>Odio est exercitationem quidem vitae. Itaque odio totam consectetur dignissimos in possimus. Est sit quae modi ipsum nam.</p>', 'camus', '2025-05-14', 1, '0000-00-00 00:00:00', '2025-02-03 20:38:36'),
(179, 115, 'Jean Jaurès, n\'oublions pas ses combats', 'petite-histoire-de-jean-jaures-678ceb04b4f16-678ceb10a4aab.jpg', '<p>Ex officiis voluptatem ea quo. Et sit qui omnis nam pariatur. Modi nemo architecto delectus corrupti non. Sint accusantium minima quas occaecati. Qui voluptatem facilis rerum assumenda.</p>', 'ruiz', '2016-01-06', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(180, 116, 'Jean Jaurès, n\'oublions pas ses combats', 'petite-histoire-de-jean-jaures-678ceb04b4f16.jpg', '<p>Qui eveniet distinctio iste iste et occaecati. Voluptatem placeat itaque et sint quia. Neque tempora aliquid distinctio perferendis vitae.</p>', 'garnier', '1986-12-31', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(181, 115, 'La Terre éphémère', 'la-terre-ephemere-tome-5-osmose-678ceaf3225ff.jpg', '<p>Corrupti reiciendis et et id ipsam neque. Aliquid quia doloribus iure incidunt sapiente vero. Blanditiis quae odio praesentium qui aut commodi eveniet dolorem.</p>', 'fernandez', '1991-03-28', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(182, 116, 'Derrière la fumée', 'derriere-la-fumee-678ceae2e9ca6.jpg', '<p>Quidem sit qui illo magni doloremque saepe. Molestiae eligendi laboriosam eaque. Id ratione dignissimos enim sint. Tempore eos animi distinctio culpa nemo distinctio.</p>', 'bigot', '1999-11-30', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(183, 114, 'Le goût subtil du venin', 'le-gout-subtil-du-venin-678cead75f2c8.jpg', '<p>Quae voluptates libero quasi corrupti unde. Animi consequatur est ipsam porro illo nisi. Corporis et et asperiores temporibus autem non sit ducimus. Vel doloremque temporibus ipsa ex nemo aut.</p>', 'guilbert', '1994-03-17', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(184, 116, 'L\'armée sans Prince 2 - Catholique et Royale', 'l-armee-sans-prince-tome-2-catholique-et-royale-678ceac419d8b.jpg', '<p>Iste id quo quaerat ipsum. Beatae in repudiandae consectetur vitae iste. Explicabo tempora sunt laboriosam optio cumque sed omnis.</p>', 'bruneau', '1998-06-10', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(185, 115, 'Une fleur pour l\'éternité', 'une-fleur-pour-l-eternite-678cea959208d.jpg', '<p>Error perferendis excepturi aut facilis sunt. Eum quis qui libero dolorum. Voluptate velit ut et beatae. Quo autem architecto laudantium quia possimus ipsam.</p>', 'gosselin', '1988-06-03', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(186, 117, 'Le goût subtil du venin', 'le-gout-subtil-du-venin-678cea414bbbd.jpg', '<p>Error perferendis qui repellat culpa. Ratione tempora corrupti consectetur quod. Expedita provident quo debitis ut.</p>', 'payet', '2002-02-13', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(187, 117, 'Derrière la fumée', 'derriere-la-fumee-678ce9f7d103c.jpg', '<p>Excepturi non aut id aperiam sit ab. Ipsa tempora et est ullam. Est dignissimos architecto excepturi sed commodi praesentium nihil. Rerum quis quia fugit ex unde nam consequatur.</p>', 'maillet', '2001-03-14', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(188, 116, 'La Terre éphémère', 'la-terre-ephemere-tome-5-osmose-678ce9d9de5d3.jpg', '<p>Consequuntur nam voluptas maiores minima vel necessitatibus. Aperiam a dolor esse eos. Ipsa atque temporibus vel cum sit odio sint fuga. Ut autem quis voluptate recusandae sapiente aperiam sed.</p>', 'vidal', '2016-10-15', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(189, 115, 'L\'armée sans Prince 2 - Catholique et Royale', 'l-armee-sans-prince-tome-2-catholique-et-royale-678ce843763be-678ce9ca2efaa.jpg', '<p>Enim maiores dolore non. Quae laudantium maiores voluptatibus vel eum ratione facilis. Beatae vel vel ducimus quod non quisquam unde qui. Et in id eligendi. Ullam minima maiores deleniti impedit.</p>', 'fournier', '2011-04-10', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(190, 114, 'Une fleur pour l\'éternité', 'une-fleur-pour-l-eternite-678ce9b9adb86.jpg', '<p>Veniam quia veniam autem consequatur quibusdam. Harum magnam et consequuntur iure vero iure eos. Autem qui temporibus quo fugit veritatis accusantium. Est natus dolores dolores est.</p>', 'techer', '1990-02-19', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(191, 116, 'Derrière la fumée', 'derriere-la-fumee-678ce99c86eeb.jpg', '<p>Exercitationem similique corrupti quibusdam adipisci accusantium. Vel earum quod quasi illum possimus sed. Facilis dolorum aperiam sint aperiam sed vel itaque qui. Iure omnis velit fuga corporis. et ouais</p>', 'colin', '2025-09-25', 1, '0000-00-00 00:00:00', '2025-01-19 18:16:51'),
(192, 114, 'Une fleur pour l\'éternité', 'une-fleur-pour-l-eternite-678ce9475297a-678ce97ff1bd3.jpg', '<p>Repellat omnis at sed eaque odio vero temporibus. Magnam autem sunt et minima. Repellat harum consequatur cum facere architecto sit itaque.</p>', 'humbert', '2025-06-03', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(193, 114, 'La Terre éphémère', 'la-terre-ephemere-tome-5-osmose-678ce8270c5c4-678ce96d79e66.jpg', '<p>Nihil molestiae quia ut voluptas expedita libero. Ut consequuntur rerum ducimus quos aut. Nihil nobis ut rerum harum aliquid.</p>', 'gros', '2025-11-07', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(194, 114, 'Derrière la fumée', 'derriere-la-fumee-678ce95c00e31.jpg', '<p>Repudiandae repellat earum sed dignissimos. Non magni sit ea. Iure et molestias ullam alias ea et iste.</p>', 'marchal', '2025-09-22', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(195, 114, 'Une fleur pour l\'éternité', 'une-fleur-pour-l-eternite-678ce9475297a.jpg', '<p>Doloremque et aliquid et animi. Laudantium quisquam eveniet velit eveniet qui praesentium. Animi dolores doloribus dolorem consequatur. Voluptatem saepe omnis est ut voluptas.</p>', 'deschamps', '2017-02-28', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(196, 114, 'L\'armée sans Prince 2 - Catholique et Royale', 'l-armee-sans-prince-tome-2-catholique-et-royale-678ce92390cc8.jpg', '<p>Id sunt consectetur totam quo odit qui velit iste. Numquam dolorem perspiciatis perspiciatis consequatur. Inventore quis consequuntur et est et neque beatae.</p>', 'pineau', '1991-10-04', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(197, 117, 'L\'armée sans Prince 2 - Catholique et Royale', 'l-armee-sans-prince-tome-2-catholique-et-royale-678ce90b6668b.jpg', '<p>Earum aut reprehenderit sunt non. Molestias quia eius totam dolorem voluptates aspernatur nisi. Architecto est eum quisquam maxime. Dicta incidunt debitis modi nostrum nemo quidem dolorum.</p>', 'maillet', '2022-03-12', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(198, 114, 'Derrière la fumée', 'derriere-la-fumee-678ce8eeb2a81.jpg', '<p>Voluptatibus soluta porro quod ut ut rerum. Et optio modi perferendis ex. Repellat qui eius est velit earum.</p>', 'sanchez', '1970-05-14', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(199, 116, 'Derrière la fumée', 'derriere-la-fumee-678ce87f8910f.jpg', '<p>Aut aspernatur cum tenetur delectus nam. Voluptatum officiis optio a non necessitatibus. Sunt minima aut pariatur laudantium dolorem. Voluptate sint repudiandae sit eos suscipit.</p>', 'robert', '1991-12-04', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(200, 117, 'Une fleur pour l\'éternité', 'une-fleur-pour-l-eternite-678ce85cbdcfe.jpg', '<p>Vero rem dolor ipsam et. Tenetur aliquid aspernatur ipsum est autem iste. Repellendus sit minus expedita quasi necessitatibus nulla excepturi. Quod quis perspiciatis sint.</p>', 'carpentier', '1983-01-03', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(201, 114, 'L\'armée sans Prince 2 - Catholique et Royale', 'l-armee-sans-prince-tome-2-catholique-et-royale-678ce843763be.jpg', '<p>Molestiae sed molestias itaque. Unde facere repellat dolores quisquam aliquam accusamus. Aperiam dolore quisquam natus distinctio. Cupiditate alias aut qui qui eius optio.</p>', 'boucher', '2009-11-24', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(202, 120, 'Jean Jaurès, n\'oublions pas ses combats', 'petite-histoire-de-jean-jaures-678ce7578f894.jpg', '<p>Error delectus et est sequi mollitia nostrum. Nulla perferendis quisquam earum optio ipsam. Omnis laudantium eligendi culpa veritatis ad maiores. Deserunt nam a quis non occaecati dignissimos.</p>', 'dufour', '2004-12-21', 1, '0000-00-00 00:00:00', '2025-02-08 12:46:22'),
(203, 121, 'Le goût subtil du venin', 'le-gout-subtil-du-venin-678ce7a5b5870.jpg', '<p>Dolor ducimus qui a cupiditate quo ut. Odit ipsum velit quaerat totam. Praesentium quia adipisci enim alias nulla ipsam porro. Corrupti dicta sed quaerat.</p>', 'gonzalez', '2011-09-28', 1, '0000-00-00 00:00:00', '2025-02-09 21:21:04'),
(204, 122, 'Une fleur pour l\'éternité', 'une-fleur-pour-l-eternite-678ce7472726a.jpg', '<p>Mollitia ad non praesentium nesciunt nemo pariatur nobis. Deleniti in ullam debitis inventore aut. Delectus id libero rerum consequatur magnam. Alias et voluptas suscipit autem neque doloribus.</p>', 'boulay', '2015-05-18', 1, '0000-00-00 00:00:00', '2025-02-09 21:41:17'),
(205, 123, 'Le goût subtil du venin', 'le-gout-subtil-du-venin-678ce7681a5d6.jpg', '<p>Ut aliquid quam est qui. Dolore nihil et quam dicta molestiae sint aperiam.</p>', 'hoarau', '1973-12-10', 1, '0000-00-00 00:00:00', '2025-02-09 22:08:37'),
(206, 124, 'Jean Jaurès, n\'oublions pas ses combats', 'petite-histoire-de-jean-jaures-678ce5a584003.jpg', '<p>Reprehenderit distinctio voluptas et magni repellendus. Accusantium rem ut aut vero atque. Tenetur nulla ut blanditiis reprehenderit est perferendis. Commodi cumque quia exercitationem.</p>', 'riou', '2025-01-20', 1, '0000-00-00 00:00:00', '2025-02-09 22:08:37'),
(207, 125, 'Le goût subtil du venin', 'le-gout-subtil-du-venin-678ce7681a5d6.jpg', '<p>Ut aliquid quam est qui. Dolore nihil et quam dicta molestiae sint aperiam.</p>', 'hoarau', '1973-12-10', 1, '0000-00-00 00:00:00', '2025-02-09 22:26:42');

-- --------------------------------------------------------

--
-- Structure de la table `book_format`
--

DROP TABLE IF EXISTS `book_format`;
CREATE TABLE IF NOT EXISTS `book_format` (
  `book_id` int NOT NULL,
  `format_id` int NOT NULL,
  PRIMARY KEY (`book_id`,`format_id`),
  KEY `IDX_F76D795216A2B381` (`book_id`),
  KEY `IDX_F76D7952D629F605` (`format_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `book_format`
--

INSERT INTO `book_format` (`book_id`, `format_id`) VALUES
(166, 201),
(166, 246),
(168, 203),
(168, 244),
(169, 204),
(169, 243),
(170, 242),
(170, 247),
(171, 206),
(171, 241),
(172, 207),
(172, 240),
(174, 209),
(174, 238),
(175, 210),
(175, 237),
(178, 213),
(178, 236),
(179, 214),
(180, 215),
(181, 216),
(182, 217),
(183, 218),
(184, 205),
(185, 219),
(186, 220),
(186, 248),
(187, 221),
(188, 222),
(189, 223),
(190, 224),
(191, 225),
(192, 226),
(193, 227),
(194, 228),
(195, 229),
(196, 230),
(197, 231),
(198, 232),
(199, 233),
(200, 234),
(201, 235);

-- --------------------------------------------------------

--
-- Structure de la table `bo_sk_co`
--

DROP TABLE IF EXISTS `bo_sk_co`;
CREATE TABLE IF NOT EXISTS `bo_sk_co` (
  `id` int NOT NULL AUTO_INCREMENT,
  `book_id` int NOT NULL,
  `contributor_id` int NOT NULL,
  `skill_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D1A239BC16A2B381` (`book_id`),
  KEY `IDX_D1A239BC7A19A357` (`contributor_id`),
  KEY `IDX_D1A239BC5585C142` (`skill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bo_sk_co`
--

INSERT INTO `bo_sk_co` (`id`, `book_id`, `contributor_id`, `skill_id`) VALUES
(65, 178, 167, 199),
(66, 179, 168, 199),
(67, 180, 169, 199),
(68, 181, 170, 199),
(69, 182, 171, 199),
(70, 183, 172, 199),
(71, 184, 173, 199),
(72, 185, 174, 199),
(73, 186, 175, 199),
(74, 187, 176, 199),
(75, 188, 177, 199),
(76, 189, 177, 199),
(77, 190, 176, 199),
(78, 191, 167, 199),
(79, 192, 168, 199),
(80, 193, 169, 199),
(81, 194, 170, 199),
(82, 195, 171, 199),
(83, 196, 172, 199),
(84, 197, 173, 199),
(85, 198, 174, 199),
(87, 200, 176, 199),
(88, 201, 177, 199),
(89, 178, 171, 199),
(90, 166, 169, 199),
(92, 168, 173, 199),
(93, 169, 171, 199),
(94, 170, 167, 199),
(95, 171, 170, 199),
(96, 172, 174, 199),
(98, 174, 168, 199),
(99, 175, 172, 199),
(104, 178, 168, 198),
(105, 178, 173, 197),
(106, 199, 173, 197),
(107, 199, 167, 199),
(108, 198, 176, 197),
(109, 197, 169, 197),
(110, 196, 175, 197),
(111, 195, 176, 197),
(112, 194, 171, 197),
(113, 193, 173, 197),
(114, 192, 168, 197),
(115, 191, 172, 197),
(116, 190, 174, 197),
(117, 189, 167, 197),
(119, 186, 173, 197),
(120, 166, 167, 197),
(121, 168, 167, 197),
(122, 166, 169, 198),
(123, 202, 175, 199);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(205, 'Romance'),
(206, 'Roman historique'),
(207, 'Poésie'),
(209, 'Roman noir'),
(210, 'Fantasy, SF'),
(211, 'Témoignages'),
(212, 'Contes et nouvelles'),
(213, 'Essais'),
(214, 'Biographies'),
(215, 'Jeunesse'),
(216, 'Sport et bien-être'),
(217, 'Classique');

-- --------------------------------------------------------

--
-- Structure de la table `category_book`
--

DROP TABLE IF EXISTS `category_book`;
CREATE TABLE IF NOT EXISTS `category_book` (
  `category_id` int NOT NULL,
  `book_id` int NOT NULL,
  PRIMARY KEY (`category_id`,`book_id`),
  KEY `IDX_407ED97612469DE2` (`category_id`),
  KEY `IDX_407ED97616A2B381` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category_book`
--

INSERT INTO `category_book` (`category_id`, `book_id`) VALUES
(205, 169),
(205, 180),
(205, 183),
(205, 187),
(205, 189),
(206, 168),
(206, 192),
(206, 195),
(206, 200),
(207, 166),
(207, 169),
(207, 182),
(207, 193),
(209, 166),
(209, 179),
(209, 181),
(209, 188),
(209, 190),
(209, 191),
(209, 199),
(210, 175),
(210, 186),
(210, 187),
(210, 198),
(210, 200),
(211, 170),
(211, 174),
(211, 183),
(211, 189),
(211, 194),
(211, 196),
(211, 199),
(212, 175),
(212, 178),
(212, 179),
(212, 194),
(213, 172),
(213, 186),
(213, 190),
(214, 172),
(214, 188),
(214, 201),
(215, 171),
(215, 175),
(215, 178),
(215, 189),
(215, 202),
(216, 166),
(216, 169),
(216, 170),
(216, 186),
(216, 194),
(216, 195),
(217, 202);

-- --------------------------------------------------------

--
-- Structure de la table `contributor`
--

DROP TABLE IF EXISTS `contributor`;
CREATE TABLE IF NOT EXISTS `contributor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contributor`
--

INSERT INTO `contributor` (`id`, `lastname`, `firstname`, `bio`, `photo`, `status`, `created_at`, `slug`, `updated_at`) VALUES
(167, 'Shearer', 'Françoise', '<p>Voluptatum rem et cupiditate maxime omnis veritatis non. Aliquid quos illum dolorem et quas non. Quod consequatur sequi necessitatibus soluta.</p>', 'jovanovic-678ced5b6c728.jpg', 1, '2021-03-07 02:26:00', 'ShearerFrançois', '2025-01-22 14:30:22'),
(168, 'Vaissière', 'Marcel', '<p>Voluptas ad exercitationem quas cum sint omnis. Iste inventore mollitia a commodi error sequi. Minima cum illo alias totam quisquam architecto non nesciunt.</p>', 'vaissierejf-678ced6c11e81.jpg', 1, '2004-04-11 04:10:00', 'VaissièreMarcel', '0000-00-00 00:00:00'),
(169, 'Shearer', 'Lyonel', 'Id facere amet occaecati repellat placeat dolor assumenda voluptatibus. Occaecati facere id officia facere nemo dolores eum. Voluptatem quia omnis libero consequatur sed ipsa quis.', 'jovanovic.jpg', 1, '2008-02-29 04:09:51', 'ShearerLyonel', '0000-00-00 00:00:00'),
(170, 'Grelet', 'Anne', 'Ut qui fugiat aut alias exercitationem quae sint minima. In excepturi libero qui qui. Hic impedit culpa perspiciatis sit doloremque sed. Quia nam nam rem consequatur quis vel eos.', 'shearer.jpg', 1, '2012-02-24 06:35:07', 'GreletAnne', '0000-00-00 00:00:00'),
(171, 'Grelet', 'Jean-François', 'Ut perspiciatis ad soluta quia. Hic qui eum incidunt eveniet et nesciunt. Et repellendus quia vel dolorum laborum occaecati illo.', 'vaissierejf.jpg', 1, '2002-02-24 15:08:02', 'GreletJean-François', '0000-00-00 00:00:00'),
(172, 'Vaissière', 'Françoise', 'Saepe et eos aperiam accusantium tempore at aut. Qui voluptate asperiores animi libero aut tempora. Adipisci sunt soluta suscipit. Optio iure aut a officiis velit sit.', 'grelet.jpg', 1, '2017-08-17 06:50:24', 'VaissièreFrançoise', '0000-00-00 00:00:00'),
(173, 'Le Gloahec', 'Anne', 'Ea molestiae doloremque assumenda. Ea molestiae debitis deleniti est porro omnis ut. Repudiandae distinctio repellendus omnis omnis.', 'vaissierejf.jpg', 1, '2001-09-22 21:58:23', 'LeGLoahecAnne', '0000-00-00 00:00:00'),
(174, 'Le Gloahec', 'Françoise', 'Eius aperiam reprehenderit harum mollitia ad asperiores. Et voluptatem ab et occaecati. Explicabo ut qui fugit rerum. Optio ullam repudiandae temporibus sit delectus aut et.', 'grelet.jpg', 1, '2007-10-13 16:02:05', 'LeGLoahecFrançoise', '0000-00-00 00:00:00'),
(175, 'Jovnovic', 'Marcel', 'Autem odio maxime quia aut exercitationem et et. Iure minus nemo eligendi quia nam consequuntur. Dignissimos impedit unde dolore pariatur.', 'jovanovic.jpg', 1, '2019-07-08 19:41:19', 'JovnovicMarcel', '0000-00-00 00:00:00'),
(176, 'Vaissière', 'Anne', 'Est nesciunt vitae est consectetur non voluptas. Debitis ullam at magnam omnis voluptatem quo. Maiores sapiente suscipit nesciunt consequatur. Sint assumenda deserunt veniam laudantium a aspernatur.', 'legloahec.jpg', 1, '2014-10-15 19:03:41', 'VaissièreAnne', '0000-00-00 00:00:00'),
(177, 'Vaissière', 'Lyonel', 'Magni culpa ea asperiores suscipit voluptate consequatur ab aut. Eaque id est in ipsam minus optio. Illum aspernatur blanditiis nihil dolore eligendi.', 'vaissierejf.jpg', 1, '2018-10-30 17:01:11', 'VaissièreLyonel', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241231171350', '2024-12-31 17:14:02', 807),
('DoctrineMigrations\\Version20250101095751', '2025-01-01 09:58:02', 220),
('DoctrineMigrations\\Version20250101105837', '2025-01-01 10:58:49', 678),
('DoctrineMigrations\\Version20250101115545', '2025-01-01 11:55:56', 413),
('DoctrineMigrations\\Version20250101121451', '2025-01-01 12:15:04', 370),
('DoctrineMigrations\\Version20250103131756', '2025-01-03 13:18:35', 198),
('DoctrineMigrations\\Version20250103134052', '2025-01-03 13:41:02', 38),
('DoctrineMigrations\\Version20250104104705', '2025-01-04 10:47:21', 588),
('DoctrineMigrations\\Version20250104180459', '2025-01-04 18:05:12', 246),
('DoctrineMigrations\\Version20250104192402', '2025-01-04 19:24:25', 93),
('DoctrineMigrations\\Version20250104195221', '2025-01-04 19:53:07', 26),
('DoctrineMigrations\\Version20250104200538', '2025-01-04 20:05:52', 268),
('DoctrineMigrations\\Version20250104201147', '2025-01-04 20:11:59', 47),
('DoctrineMigrations\\Version20250104213447', '2025-01-04 21:35:28', 127),
('DoctrineMigrations\\Version20250104215048', '2025-01-04 21:50:59', 156),
('DoctrineMigrations\\Version20250107210843', '2025-01-07 21:09:04', 173),
('DoctrineMigrations\\Version20250107211015', '2025-01-07 21:10:35', 285),
('DoctrineMigrations\\Version20250108195038', '2025-01-08 19:50:51', 285),
('DoctrineMigrations\\Version20250108204345', '2025-01-08 20:44:04', 341),
('DoctrineMigrations\\Version20250108210239', '2025-01-08 21:02:56', 39),
('DoctrineMigrations\\Version20250110192508', '2025-01-10 19:25:38', 250),
('DoctrineMigrations\\Version20250110193130', '2025-01-10 19:31:44', 86),
('DoctrineMigrations\\Version20250110193556', '2025-01-10 19:36:08', 625),
('DoctrineMigrations\\Version20250110193923', '2025-01-10 19:39:37', 90),
('DoctrineMigrations\\Version20250110194501', '2025-01-10 21:33:30', 350),
('DoctrineMigrations\\Version20250110211102', '2025-01-10 21:46:36', 399),
('DoctrineMigrations\\Version20250112153935', '2025-01-12 15:39:48', 126),
('DoctrineMigrations\\Version20250112195706', '2025-01-12 19:57:20', 43),
('DoctrineMigrations\\Version20250115194837', '2025-01-15 19:48:48', 121),
('DoctrineMigrations\\Version20250118124310', '2025-01-18 12:43:23', 132),
('DoctrineMigrations\\Version20250119143911', '2025-01-19 14:39:30', 481),
('DoctrineMigrations\\Version20250119144351', '2025-01-19 14:44:01', 42),
('DoctrineMigrations\\Version20250119150516', '2025-01-19 15:05:37', 56),
('DoctrineMigrations\\Version20250119191100', '2025-01-19 19:11:10', 33),
('DoctrineMigrations\\Version20250119191752', '2025-01-19 19:18:09', 96),
('DoctrineMigrations\\Version20250119193810', '2025-01-19 19:38:26', 90),
('DoctrineMigrations\\Version20250119195746', '2025-01-19 19:58:03', 97),
('DoctrineMigrations\\Version20250120194147', '2025-01-20 19:42:01', 151),
('DoctrineMigrations\\Version20250120201719', '2025-01-20 20:17:29', 30),
('DoctrineMigrations\\Version20250124211038', '2025-01-24 21:10:56', 93),
('DoctrineMigrations\\Version20250124215349', '2025-01-24 21:54:05', 29),
('DoctrineMigrations\\Version20250124220620', '2025-01-24 22:06:32', 22),
('DoctrineMigrations\\Version20250125222716', '2025-01-25 22:27:27', 228),
('DoctrineMigrations\\Version20250126170630', '2025-01-26 17:06:46', 90),
('DoctrineMigrations\\Version20250129084825', '2025-01-29 08:48:45', 222),
('DoctrineMigrations\\Version20250130210008', '2025-01-30 21:00:22', 103),
('DoctrineMigrations\\Version20250131223219', '2025-01-31 22:32:31', 116),
('DoctrineMigrations\\Version20250201085305', '2025-02-01 08:53:21', 124),
('DoctrineMigrations\\Version20250205174326', '2025-02-05 17:43:43', 203),
('DoctrineMigrations\\Version20250205180617', '2025-02-05 18:06:40', 152),
('DoctrineMigrations\\Version20250205185729', '2025-02-05 18:57:47', 189),
('DoctrineMigrations\\Version20250205191400', '2025-02-05 19:14:09', 30),
('DoctrineMigrations\\Version20250205205707', '2025-02-05 20:57:28', 144),
('DoctrineMigrations\\Version20250210164735', '2025-02-10 16:47:52', 410),
('DoctrineMigrations\\Version20250210202902', '2025-02-10 20:29:14', 327);

-- --------------------------------------------------------

--
-- Structure de la table `download`
--

DROP TABLE IF EXISTS `download`;
CREATE TABLE IF NOT EXISTS `download` (
  `id` int NOT NULL AUTO_INCREMENT,
  `expiration_date` datetime NOT NULL,
  `download_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `download_count` int NOT NULL,
  `max_attempts` int NOT NULL,
  `oder_download_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_781A8270A28B73D9` (`oder_download_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `editor`
--

DROP TABLE IF EXISTS `editor`;
CREATE TABLE IF NOT EXISTS `editor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `editor`
--

INSERT INTO `editor` (`id`, `name`, `logo`, `description`, `status`, `created_at`, `updated_at`) VALUES
(114, 'CAIRN', 'cairn-678cdd999d317.jpg', '<p>Et velit nemo eos ut quia soluta similique. Qui vitae illum aut laborum. Et laboriosam quas dolores repudiandae qui atque omnis omnis. Velit quia a ad accusamus optio at ut.</p>', 1, '2019-11-30 03:48:00', '2025-01-22 14:31:55'),
(115, 'Amphora', 'amphora-678cdd8df3c3f.jpg', '<p>Labore a eum ipsum rerum nesciunt totam. Quisquam excepturi rerum qui. Quam quasi aut est voluptatibus in. Quidem dolore quia magni aut facere et nisi porro.</p>', 1, '1980-01-15 03:39:00', '0000-00-00 00:00:00'),
(116, 'Ella', 'ella-678cdd829e94c.jpg', '<p>Consectetur inventore voluptatem nostrum mollitia corporis. Illum veritatis commodi maiores ipsum nemo veritatis. Officia facilis rerum praesentium esse voluptatum est dolore maxime.</p>', 1, '1973-08-10 10:49:00', '0000-00-00 00:00:00'),
(117, 'De Borée', 'deboree-678cdd6ce61b3.png', '<p>Non a eveniet culpa debitis repudiandae. Alias aut ut rerum natus fugit magni. Et amet omnis fugit a ut cumque. Deserunt dolor qui non qui qui ut laboriosam.&nbsp;</p>', 1, '2001-02-07 16:30:00', '2025-01-19 15:05:59'),
(119, 'Marivole', 'marivole-678cd5c609a88-678d13fd45bfb.png', '<p>En vieux fran&ccedil;ais, la marivole est une coccinelle. Cette maison d&#39;&eacute;dition a &eacute;t&eacute; lanc&eacute;e en 2012 par Christophe Matho. Marivole a d&#39;abord valoris&eacute; le roman r&eacute;gional et s&#39;est ensuite progressivement orient&eacute; vers la litt&eacute;rature g&eacute;n&eacute;rale. Marivole publie tout &agrave; la fois des romans du terroir, des &laquo;&nbsp;romans f&eacute;minins&nbsp;&raquo;, des suspenses, des romans historiques, des romans psychologiques et m&ecirc;me des livres illustr&eacute;s. Marivole est &eacute;clectique dans les genres litt&eacute;raires mais s&#39;efforce de proposer des livres d&#39;auteurs &laquo;&nbsp;qui ont vraiment quelque chose &agrave; dire, et qui le disent diff&eacute;remment. Des romans qui s&#39;inscrivent dans litt&eacute;rature contemporaine et se distinguent par leur l&#39;&eacute;criture et leur histoire&nbsp;&raquo;.&nbsp;&nbsp;</p>', 1, '2025-01-19 15:02:21', '0000-00-00 00:00:00'),
(120, 'De Borée', 'deboree-678cdd6ce61b3.png', '<p>Non a eveniet culpa debitis repudiandae. Alias aut ut rerum natus fugit magni. Et amet omnis fugit a ut cumque. Deserunt dolor qui non qui qui ut laboriosam.&nbsp;</p>', 1, '2001-02-07 16:30:00', '2025-02-08 12:46:22'),
(121, 'Amphora', 'amphora-678cdd8df3c3f.jpg', '<p>Labore a eum ipsum rerum nesciunt totam. Quisquam excepturi rerum qui. Quam quasi aut est voluptatibus in. Quidem dolore quia magni aut facere et nisi porro.</p>', 1, '1980-01-15 03:39:00', '2025-02-09 21:21:04'),
(122, 'Amphora', 'amphora-678cdd8df3c3f.jpg', '<p>Labore a eum ipsum rerum nesciunt totam. Quisquam excepturi rerum qui. Quam quasi aut est voluptatibus in. Quidem dolore quia magni aut facere et nisi porro.</p>', 1, '1980-01-15 03:39:00', '2025-02-09 21:41:17'),
(123, 'CAIRN', 'cairn-678cdd999d317.jpg', '<p>Et velit nemo eos ut quia soluta similique. Qui vitae illum aut laborum. Et laboriosam quas dolores repudiandae qui atque omnis omnis. Velit quia a ad accusamus optio at ut.</p>', 1, '2019-11-30 03:48:00', '2025-02-09 22:08:37'),
(124, 'Amphora', 'amphora-678cdd8df3c3f.jpg', '<p>Labore a eum ipsum rerum nesciunt totam. Quisquam excepturi rerum qui. Quam quasi aut est voluptatibus in. Quidem dolore quia magni aut facere et nisi porro.</p>', 1, '1980-01-15 03:39:00', '2025-02-09 22:08:37'),
(125, 'CAIRN', 'cairn-678cdd999d317.jpg', '<p>Et velit nemo eos ut quia soluta similique. Qui vitae illum aut laborum. Et laboriosam quas dolores repudiandae qui atque omnis omnis. Velit quia a ad accusamus optio at ut.</p>', 1, '2019-11-30 03:48:00', '2025-02-09 22:26:42');

-- --------------------------------------------------------

--
-- Structure de la table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nick_name_id` int NOT NULL,
  `book_id` int DEFAULT NULL,
  `stars` int NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D229445815B4D30C` (`nick_name_id`),
  KEY `IDX_D229445816A2B381` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `format`
--

DROP TABLE IF EXISTS `format`;
CREATE TABLE IF NOT EXISTS `format` (
  `id` int NOT NULL AUTO_INCREMENT,
  `isbn` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_ht` double NOT NULL,
  `duration` int NOT NULL,
  `words_count` int NOT NULL,
  `pages_count` int NOT NULL,
  `file_size` double NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_extract` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` int NOT NULL,
  `price_ttc` double NOT NULL,
  `tva_rate_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DEBA72DFC54C8C93` (`type_id`),
  KEY `IDX_DEBA72DF38C0512E` (`tva_rate_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `format`
--

INSERT INTO `format` (`id`, `isbn`, `price_ht`, `duration`, `words_count`, `pages_count`, `file_size`, `file_path`, `book_extract`, `type_id`, `price_ttc`, `tva_rate_id`) VALUES
(201, '9790026597219', 13.22, 15, 8052, 902, 6.2, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4348.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4437.tmp', 56, 13.95, 1),
(202, '9796480285983', 24.55, 24, 9111, 676, 17.46, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4377.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4437.tmp', 56, 0, 1),
(203, '9799680291792', 14.38, 99, 7379, 201, 16.77, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 56, 15.17, 1),
(204, '9792732399668', 20.81, 89, 7752, 403, 14.8, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4389.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 56, 21.95, 1),
(205, '9798318985317', 22.17, 93, 3936, 303, 7.53, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak438A.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 56, 0, 1),
(206, '9797961982285', 3.65, 35, 2677, 435, 17.06, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak438B.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 56, 3.85, 1),
(207, '9793431736358', 27.49, 39, 4933, 125, 11.29, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak439C.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 56, 29, 1),
(208, '9784847117008', 27.24, 85, 8852, 513, 14.48, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak439D.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 56, 0, 1),
(209, '9780446714525', 9.46, 40, 9079, 831, 1.53, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43AD.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 56, 9.98, 1),
(210, '9784510034502', 17.45, 53, 9351, 657, 7.14, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43AE.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 56, 18.41, 1),
(211, '9784946357787', 9.3, 15, 3452, 730, 21.29, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43BF.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 56, 0, 1),
(212, '9781306222761', 8.58, 80, 3846, 629, 11.44, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43D0.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 56, 0, 1),
(213, '9782880251963', 16.68, 17, 597, 284, 2.07, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43D1.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 56, 17.6, 1),
(214, '9789413634606', 18.3, 44, 3405, 684, 14.6, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43E1.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 56, 19.31, 1),
(215, '9783668617292', 18.28, 19, 1181, 464, 19.75, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43F2.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 56, 19.29, 1),
(216, '9781153080149', 9.28, 98, 5826, 439, 6.43, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4402.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 56, 0, 1),
(217, '9791825583397', 29.56, 10, 3098, 705, 3.14, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4403.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 56, 0, 1),
(218, '9789915730585', 24.7, 83, 2079, 663, 10.12, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4414.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 56, 0, 1),
(219, '9784050880911', 7.89, 43, 2461, 933, 18.71, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4415.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 56, 0, 1),
(220, '9786916469414', 14.9, 90, 600, 266, 28.9, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 56, 0, 1),
(221, '9798782754785', 7.71, 16, 9238, 928, 9.25, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4436.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 56, 0, 1),
(222, '9784923284716', 26.86, 38, 3124, 982, 11.34, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4437.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 56, 0, 1),
(223, '9784923284718', 26.86, 38, 3124, 982, 11.34, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4437.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 2),
(224, '9790026597219', 13.22, 15, 8052, 902, 6.2, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4348.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 2),
(225, '9796480285983', 24.55, 24, 19111, 452, 17.46, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4377.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 2),
(226, '9799680291792', 14.38, 99, 7379, 201, 16.77, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 1),
(227, '9792732399668', 20.81, 89, 7752, 403, 14.8, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4389.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 1),
(228, '9798318985317', 22.17, 93, 3936, 303, 7.53, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak438A.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 1),
(229, '9797961982285', 3.65, 35, 2677, 435, 17.06, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak438B.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 1),
(230, '9793431736358', 27.49, 39, 4933, 125, 11.29, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak439C.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 1),
(231, '9784847117008', 27.24, 85, 8852, 513, 14.48, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak439D.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 1),
(232, '9780446714525', 9.46, 40, 9079, 831, 1.53, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43AD.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 1),
(233, '9784510034502', 17.45, 53, 9351, 657, 7.14, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43AE.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 1),
(234, '9784946357787', 9.3, 15, 3452, 730, 21.29, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43BF.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 1),
(235, '9781306222761', 8.58, 80, 3846, 629, 11.44, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43D0.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 1),
(236, '9782880251963', 26.68, 17, 9597, 284, 12.25, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43D1.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 55, 32.02, 2),
(237, '9789413634606', 18.3, 44, 3405, 684, 14.6, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43E1.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 21.96, 2),
(238, '9783668617292', 18.28, 19, 1181, 464, 19.75, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak43F2.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 21.94, 2),
(239, '9781153080149', 9.28, 98, 5826, 439, 6.43, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4402.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 0, 1),
(240, '9791825583397', 29.56, 10, 3098, 705, 3.14, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4403.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 35.47, 2),
(241, '9789915730585', 24.7, 83, 2079, 663, 10.12, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4414.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 29.64, 2),
(242, '9784050880911', 7.89, 43, 2461, 933, 18.71, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4415.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 8.32, 1),
(243, '9786916469414', 14.9, 90, 600, 266, 28.9, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 15.72, 1),
(244, '9798782754785', 7.71, 16, 9238, 928, 9.25, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4436.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 55, 9.25, 2),
(245, '9784923284716', 26.86, 38, 3124, 982, 11.34, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4437.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4437.tmp', 55, 0, 2),
(246, '9784923284718', 26.86, 38, 3124, 982, 11.34, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4437.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4437.tmp', 55, 32.23, 2),
(247, '9793431736352', 5.99, 8, 26759, 345, 2, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4432.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4378.tmp', 56, 7.19, 2),
(248, '9786916469412', 22.99, 15, 28502, 304, 1.5, 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 'http://C:\\Users\\user\\AppData\\Local\\Temp\\fak4426.tmp', 55, 0, 2);

-- --------------------------------------------------------

--
-- Structure de la table `key_words`
--

DROP TABLE IF EXISTS `key_words`;
CREATE TABLE IF NOT EXISTS `key_words` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `key_words`
--

INSERT INTO `key_words` (`id`, `tag`) VALUES
(1, 'Émouvant'),
(2, 'Bouleversant'),
(3, 'haletant'),
(4, 'stimulant'),
(5, 'poétique'),
(6, 'humoristique'),
(7, 'Décalé'),
(8, 'Mystérieux'),
(9, 'Fantastique'),
(10, 'Tendre'),
(11, 'Folklore'),
(12, 'Traditions'),
(13, 'écologie'),
(14, 'Terroir'),
(15, 'Angoissant'),
(16, 'Dramatique'),
(17, 'Instructif'),
(18, 'Poignant'),
(19, 'Amour'),
(20, 'Frisson'),
(21, 'Enquête'),
(22, 'Énigme'),
(23, 'Psychiatrie'),
(24, 'Policier'),
(25, 'Hôpital'),
(26, 'Bombe'),
(27, 'Noir'),
(28, 'Récits'),
(29, 'Histoire'),
(30, 'Meurtre'),
(31, 'Recherches'),
(32, 'Migrations'),
(33, 'Innovation'),
(34, 'Impératrice'),
(35, 'Lourdes'),
(36, 'Gavarnie'),
(37, 'Tarbes'),
(38, 'Hautes-Pyrénées'),
(39, 'Dédicaces'),
(40, 'Bourbonnais');

-- --------------------------------------------------------

--
-- Structure de la table `key_words_book`
--

DROP TABLE IF EXISTS `key_words_book`;
CREATE TABLE IF NOT EXISTS `key_words_book` (
  `key_words_id` int NOT NULL,
  `book_id` int NOT NULL,
  PRIMARY KEY (`key_words_id`,`book_id`),
  KEY `IDX_88B0431EB598DE74` (`key_words_id`),
  KEY `IDX_88B0431E16A2B381` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `key_words_book`
--

INSERT INTO `key_words_book` (`key_words_id`, `book_id`) VALUES
(1, 166),
(2, 166),
(2, 168),
(2, 180),
(3, 166),
(3, 169),
(3, 175),
(3, 180),
(4, 169),
(4, 170),
(4, 179),
(7, 179),
(8, 179),
(12, 175),
(20, 172),
(20, 202),
(21, 172),
(21, 202),
(22, 202),
(24, 178),
(25, 178),
(26, 174),
(26, 178),
(30, 170),
(31, 168),
(38, 171),
(39, 171),
(39, 174),
(40, 171);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messenger_messages`
--

INSERT INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
(1, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:39:\\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\\":5:{i:0;s:41:\\\"registration/confirmation_email.html.twig\\\";i:1;N;i:2;a:3:{s:9:\\\"signedUrl\\\";s:168:\\\"https://127.0.0.1:8000/verify/email?expires=1737323815&signature=%2FMW4yozaRgXCMG8XxngeG78PPz41l6kVoHo9ChvjlGw%3D&token=bra%2BqvyHaPr8y6sNpjZF752OoHmMTjPawHqWDVO1MvU%3D\\\";s:19:\\\"expiresAtMessageKey\\\";s:26:\\\"%count% hour|%count% hours\\\";s:20:\\\"expiresAtMessageData\\\";a:1:{s:7:\\\"%count%\\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:18:\\\"contact@neobook.Fr\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:15:\\\"Contact Neobook\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:18:\\\"beauquelc@yahoo.fr\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:25:\\\"Please Confirm your Email\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}i:4;N;}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2025-01-19 20:56:55', '2025-01-19 20:56:55', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `new_customer` tinyint(1) NOT NULL,
  `total_ht` double NOT NULL,
  `created_at` datetime NOT NULL,
  `status_id` int NOT NULL,
  `payment_mode_id` int DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `basket_id` int NOT NULL,
  `user_token_id` int DEFAULT NULL,
  `total_ttc` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F52993981BE1FB52` (`basket_id`),
  UNIQUE KEY `UNIQ_F5299398A15303B9` (`user_token_id`),
  KEY `IDX_F52993989395C3F3` (`customer_id`),
  KEY `IDX_F52993986BF700BD` (`status_id`),
  KEY `IDX_F52993986EAC8BA0` (`payment_mode_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `customer_id`, `new_customer`, `total_ht`, `created_at`, `status_id`, `payment_mode_id`, `updated_at`, `basket_id`, `user_token_id`, `total_ttc`) VALUES
(32, 1, 1, 35.75, '2025-02-10 13:33:57', 3, NULL, '2025-02-10 13:33:57', 80, 80, 0),
(40, NULL, 1, 14.38, '2025-02-16 16:44:33', 2, NULL, '2025-02-16 16:44:33', 96, 96, 15.17),
(41, 1, 1, 14.9, '2025-02-16 17:05:45', 1, NULL, '2025-02-16 17:05:45', 103, 103, 15.72),
(42, 1, 1, 35.71, '2025-02-16 17:13:07', 2, NULL, '2025-02-16 17:13:07', 104, 104, 37.67),
(43, 2, 1, 9.46, '2025-02-16 17:16:08', 2, NULL, '2025-02-16 17:32:31', 105, 105, 9.98),
(44, 1, 1, 7.89, '2025-02-16 17:35:05', 3, NULL, '2025-02-16 17:35:05', 106, 106, 8.32),
(45, 1, 1, 18.3, '2025-02-16 17:46:13', 2, NULL, '2025-02-16 17:46:13', 107, 107, 21.96),
(46, 1, 1, 17.45, '2025-02-16 17:50:30', 2, NULL, '2025-02-16 17:50:30', 108, 108, 0);

-- --------------------------------------------------------

--
-- Structure de la table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_status`
--

INSERT INTO `order_status` (`id`, `status`) VALUES
(1, 'En attente'),
(2, 'Échoué'),
(3, 'Paiement accepté');

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `skill`
--

DROP TABLE IF EXISTS `skill`;
CREATE TABLE IF NOT EXISTS `skill` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `skill`
--

INSERT INTO `skill` (`id`, `name`) VALUES
(197, 'Lecteur'),
(198, 'Préfacier'),
(199, 'Auteur');

-- --------------------------------------------------------

--
-- Structure de la table `to_be_read`
--

DROP TABLE IF EXISTS `to_be_read`;
CREATE TABLE IF NOT EXISTS `to_be_read` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `book_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_54B4E7CF9395C3F3` (`customer_id`),
  KEY `IDX_54B4E7CF16A2B381` (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `to_be_read`
--

INSERT INTO `to_be_read` (`id`, `customer_id`, `status`, `book_id`) VALUES
(1, 1, 'à lire', 174),
(7, 1, 'à lire', 169),
(9, 1, 'à lire', 193);

-- --------------------------------------------------------

--
-- Structure de la table `tva`
--

DROP TABLE IF EXISTS `tva`;
CREATE TABLE IF NOT EXISTS `tva` (
  `id` int NOT NULL AUTO_INCREMENT,
  `taux` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tva`
--

INSERT INTO `tva` (`id`, `taux`) VALUES
(1, 5.5),
(2, 20);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `type_img`, `name`) VALUES
(55, 'headphones', 'Audio'),
(56, 'book', 'eBook');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `last_visit_date` datetime NOT NULL,
  `opt_in` tinyint(1) NOT NULL,
  `preference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `created_at`, `last_visit_date`, `opt_in`, `preference`, `nickname`, `is_verified`, `updated_at`) VALUES
(1, 'c.beauquel@neobook.fr', '[\"ROLE_ADMIN\"]', '$2y$13$WNg1VIQsuCRmyFv8ue77Mu.fkY2qjDDjWKmlxUOQLNr3PxxQ5dFTu', 'Christophe', 'Beauquel', '2025-01-12 12:52:12', '2025-02-19 09:42:49', 1, 'Doctrine\\Common\\Collections\\ArrayCollection@00000000000005530000000000000000', 'chris', 1, '2025-02-19 09:42:49'),
(2, 'beauquelc@yahoo.fr', '[]', '$2y$13$GA7uKQBXwDbVl61Ty36smuQ6.z/MJs8.xIfta1jzJFHLeKafbJJVa', 'John', 'Smith', '2025-01-19 20:56:54', '2025-02-16 17:16:07', 1, 'Roman noir', 'jsmith', 0, '2025-02-16 17:16:07');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `FK_2246507B9395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `basket_format`
--
ALTER TABLE `basket_format`
  ADD CONSTRAINT `FK_18E0D3261BE1FB52` FOREIGN KEY (`basket_id`) REFERENCES `basket` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_18E0D326D629F605` FOREIGN KEY (`format_id`) REFERENCES `format` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `FK_CBE5A3316995AC4C` FOREIGN KEY (`editor_id`) REFERENCES `editor` (`id`);

--
-- Contraintes pour la table `book_format`
--
ALTER TABLE `book_format`
  ADD CONSTRAINT `FK_F76D795216A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F76D7952D629F605` FOREIGN KEY (`format_id`) REFERENCES `format` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `bo_sk_co`
--
ALTER TABLE `bo_sk_co`
  ADD CONSTRAINT `FK_D1A239BC16A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `FK_D1A239BC5585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`),
  ADD CONSTRAINT `FK_D1A239BC7A19A357` FOREIGN KEY (`contributor_id`) REFERENCES `contributor` (`id`);

--
-- Contraintes pour la table `category_book`
--
ALTER TABLE `category_book`
  ADD CONSTRAINT `FK_407ED97612469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_407ED97616A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `download`
--
ALTER TABLE `download`
  ADD CONSTRAINT `FK_781A8270A28B73D9` FOREIGN KEY (`oder_download_id`) REFERENCES `order` (`id`);

--
-- Contraintes pour la table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `FK_D229445815B4D30C` FOREIGN KEY (`nick_name_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_D229445816A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);

--
-- Contraintes pour la table `format`
--
ALTER TABLE `format`
  ADD CONSTRAINT `FK_DEBA72DF38C0512E` FOREIGN KEY (`tva_rate_id`) REFERENCES `tva` (`id`),
  ADD CONSTRAINT `FK_DEBA72DFC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);

--
-- Contraintes pour la table `key_words_book`
--
ALTER TABLE `key_words_book`
  ADD CONSTRAINT `FK_88B0431E16A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_88B0431EB598DE74` FOREIGN KEY (`key_words_id`) REFERENCES `key_words` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F52993981BE1FB52` FOREIGN KEY (`basket_id`) REFERENCES `basket` (`id`),
  ADD CONSTRAINT `FK_F52993986BF700BD` FOREIGN KEY (`status_id`) REFERENCES `order_status` (`id`),
  ADD CONSTRAINT `FK_F52993986EAC8BA0` FOREIGN KEY (`payment_mode_id`) REFERENCES `payment` (`id`),
  ADD CONSTRAINT `FK_F52993989395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F5299398A15303B9` FOREIGN KEY (`user_token_id`) REFERENCES `basket` (`id`);

--
-- Contraintes pour la table `to_be_read`
--
ALTER TABLE `to_be_read`
  ADD CONSTRAINT `FK_54B4E7CF16A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `FK_54B4E7CF9395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
