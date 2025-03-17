-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : zkittyabangbang.mysql.db
-- Généré le : lun. 17 mars 2025 à 12:56
-- Version du serveur : 8.0.40-31
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zkittyabangbang`
--

-- --------------------------------------------------------

--
-- Structure de la table `bestiaryAreas`
--

CREATE TABLE `bestiaryAreas` (
  `areaID` int NOT NULL,
  `areaName` varchar(255) NOT NULL,
  `areaPicture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiaryAreas`
--

INSERT INTO `bestiaryAreas` (`areaID`, `areaName`, `areaPicture`) VALUES
(1, 'Nouvelle Kadath', 'areas_67bf9ba1c0f24.png'),
(2, 'Gouffre de Yhanthlei', 'areas_57bf9ba1c0f24.png'),
(3, 'Val d\'Innsmouth', 'areas_47bf9ba1c0f24.png'),
(4, 'Carcosa-Nord', 'areas_37bf9ba1c0f24.png');

-- --------------------------------------------------------

--
-- Structure de la table `bestiaryAreasHabitats`
--

CREATE TABLE `bestiaryAreasHabitats` (
  `ahID` int NOT NULL,
  `ahAreaID` int NOT NULL,
  `ahHabitatID` int NOT NULL,
  `ahHabitatCoordinates` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiaryAreasHabitats`
--

INSERT INTO `bestiaryAreasHabitats` (`ahID`, `ahAreaID`, `ahHabitatID`, `ahHabitatCoordinates`) VALUES
(250, 1, 49, '{\"xPercent\": 85.60606060606061, \"yPercent\": 63.036616161616166}'),
(251, 2, 49, '{\"xPercent\": 27.02020202020202, \"yPercent\": 19.85479797979798}'),
(252, 4, 49, '{\"xPercent\": 25.5050505050505, \"yPercent\": 91.5719696969697}'),
(253, 4, 49, '{\"xPercent\": 83.58585858585859, \"yPercent\": 48.64267676767677}'),
(254, 2, 50, '{\"xPercent\": 20.95959595959596, \"yPercent\": 30.460858585858585}'),
(255, 2, 50, '{\"xPercent\": 68.68686868686868, \"yPercent\": 79.95580808080808}'),
(256, 3, 50, '{\"xPercent\": 42.42424242424242, \"yPercent\": 10.76388888888889}'),
(257, 4, 50, '{\"xPercent\": 12.626262626262626, \"yPercent\": 69.09722222222221}'),
(258, 4, 50, '{\"xPercent\": 86.36363636363636, \"yPercent\": 86.01641414141415}'),
(259, 1, 51, '{\"xPercent\": 47.97979797979798, \"yPercent\": 35.006313131313135}'),
(260, 2, 51, '{\"xPercent\": 53.78787878787878, \"yPercent\": 54.70328282828283}'),
(261, 2, 51, '{\"xPercent\": 40.4040404040404, \"yPercent\": 90.05681818181817}'),
(262, 2, 51, '{\"xPercent\": 36.61616161616162, \"yPercent\": 17.83459595959596}'),
(263, 4, 51, '{\"xPercent\": 59.84848484848485, \"yPercent\": 6.976010101010101}'),
(264, 1, 52, '{\"xPercent\": 31.313131313131315, \"yPercent\": 43.84469696969697}'),
(265, 2, 52, '{\"xPercent\": 79.29292929292929, \"yPercent\": 69.60227272727273}'),
(266, 2, 52, '{\"xPercent\": 45.45454545454545, \"yPercent\": 11.7739898989899}'),
(267, 3, 52, '{\"xPercent\": 42.42424242424242, \"yPercent\": 11.521464646464649}'),
(268, 4, 52, '{\"xPercent\": 59.59595959595959, \"yPercent\": 90.81439393939394}'),
(269, 1, 53, '{\"xPercent\": 62.121212121212125, \"yPercent\": 90.56186868686868}'),
(270, 1, 53, '{\"xPercent\": 93.68686868686868, \"yPercent\": 54.95580808080808}'),
(271, 2, 54, '{\"xPercent\": 45.20202020202021, \"yPercent\": 73.39015151515152}'),
(272, 3, 54, '{\"xPercent\": 43.43434343434344, \"yPercent\": 52.68308080808081}'),
(273, 4, 54, '{\"xPercent\": 32.57575757575758, \"yPercent\": 59.24873737373737}'),
(274, 1, 55, '{\"xPercent\": 79.29292929292929, \"yPercent\": 53.94570707070707}'),
(275, 2, 55, '{\"xPercent\": 33.08080808080808, \"yPercent\": 47.380050505050505}'),
(276, 2, 55, '{\"xPercent\": 76.51515151515152, \"yPercent\": 48.64267676767677}'),
(277, 3, 55, '{\"xPercent\": 56.313131313131315, \"yPercent\": 42.07702020202021}');

-- --------------------------------------------------------

--
-- Structure de la table `bestiaryAreasSafePlaces`
--

CREATE TABLE `bestiaryAreasSafePlaces` (
  `asID` int NOT NULL,
  `asAreaID` int NOT NULL,
  `asSafePlaceID` int NOT NULL,
  `asSafePlaceCoordinates` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiaryAreasSafePlaces`
--

INSERT INTO `bestiaryAreasSafePlaces` (`asID`, `asAreaID`, `asSafePlaceID`, `asSafePlaceCoordinates`) VALUES
(191, 1, 6, '{\"xPercent\": 44.260700389105054, \"yPercent\": 64.73735408560312}'),
(192, 1, 6, '{\"xPercent\": 69.74708171206225, \"yPercent\": 48.20038910505836}'),
(193, 1, 6, '{\"xPercent\": 78.30739299610894, \"yPercent\": 65.12645914396887}'),
(194, 2, 6, '{\"xPercent\": 81.32295719844358, \"yPercent\": 16.001945525291827}'),
(195, 2, 6, '{\"xPercent\": 10.700389105058363, \"yPercent\": 40.32101167315175}'),
(196, 3, 6, '{\"xPercent\": 90.6614785992218, \"yPercent\": 12.9863813229572}'),
(197, 3, 6, '{\"xPercent\": 83.75486381322958, \"yPercent\": 52.188715953307394}'),
(198, 1, 7, '{\"xPercent\": 73.24902723735408, \"yPercent\": 55.8852140077821}'),
(199, 2, 7, '{\"xPercent\": 81.6147859922179, \"yPercent\": 11.138132295719846}'),
(200, 3, 7, '{\"xPercent\": 88.81322957198444, \"yPercent\": 58.219844357976655}'),
(201, 4, 7, '{\"xPercent\": 26.459143968871597, \"yPercent\": 16.585603112840467}'),
(202, 1, 8, '{\"xPercent\": 31.517509727626457, \"yPercent\": 43.92023346303502}'),
(203, 1, 8, '{\"xPercent\": 49.5136186770428, \"yPercent\": 45.18482490272373}'),
(204, 1, 8, '{\"xPercent\": 69.94163424124513, \"yPercent\": 48.492217898832685}'),
(205, 1, 8, '{\"xPercent\": 83.94941634241245, \"yPercent\": 62.11089494163424}'),
(206, 2, 8, '{\"xPercent\": 74.90272373540856, \"yPercent\": 21.93579766536965}'),
(207, 2, 8, '{\"xPercent\": 24.12451361867704, \"yPercent\": 18.1420233463035}'),
(208, 2, 8, '{\"xPercent\": 60.21400778210116, \"yPercent\": 10.749027237354086}'),
(209, 3, 8, '{\"xPercent\": 75.58365758754863, \"yPercent\": 11.429961089494164}'),
(210, 3, 8, '{\"xPercent\": 78.30739299610894, \"yPercent\": 74.46498054474708}'),
(211, 3, 8, '{\"xPercent\": 69.8443579766537, \"yPercent\": 32.538910505836576}'),
(212, 3, 8, '{\"xPercent\": 40.27237354085603, \"yPercent\": 19.795719844357976}'),
(213, 3, 8, '{\"xPercent\": 27.33463035019455, \"yPercent\": 69.79571984435798}'),
(214, 3, 8, '{\"xPercent\": 57.97665369649806, \"yPercent\": 63.95914396887159}'),
(215, 3, 8, '{\"xPercent\": 25.87548638132296, \"yPercent\": 30.10700389105058}'),
(216, 4, 8, '{\"xPercent\": 23.73540856031128, \"yPercent\": 19.114785992217897}');

-- --------------------------------------------------------

--
-- Structure de la table `bestiaryDangers`
--

CREATE TABLE `bestiaryDangers` (
  `dangerID` int NOT NULL,
  `dangerValue` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiaryDangers`
--

INSERT INTO `bestiaryDangers` (`dangerID`, `dangerValue`) VALUES
(1, 'Minimum'),
(2, 'Modéré'),
(3, 'Élevé'),
(4, 'Maximum');

-- --------------------------------------------------------

--
-- Structure de la table `bestiaryGlossaryWords`
--

CREATE TABLE `bestiaryGlossaryWords` (
  `glossaryWordID` int NOT NULL,
  `glossaryWordValue` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `glossaryWordDefinition` varchar(2500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `glossaryWordDateCreation` datetime NOT NULL,
  `glossaryWordDateModification` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiaryGlossaryWords`
--

INSERT INTO `bestiaryGlossaryWords` (`glossaryWordID`, `glossaryWordValue`, `glossaryWordDefinition`, `glossaryWordDateCreation`, `glossaryWordDateModification`) VALUES
(13, 'Maître Marionnettiste', 'Pouvoir psychique utilisé par certaines entités pour manipuler les corps et les esprits des vivants à distance, les forçant à attaquer leurs alliés ou à exécuter des actions contre leur volonté.', '2025-02-23 17:41:08', '2025-02-23 17:41:08'),
(14, 'Empreinte Corrompue\n', 'Les créatures les plus anciennes ou puissantes laissent une marque surnaturelle sur les lieux qu’elles traversent, transformant l’environnement et modifiant la perception de la réalité pour ceux qui y pénètrent.', '2025-02-23 17:52:38', '2025-02-23 18:26:54'),
(15, 'Reconstruction Organique', 'Pouvoir de certaines entités démoniaques ou créatures mutantes leur permettant de régénérer des membres perdus ou de reformer leur corps après une destruction partielle.\r\n', '2025-02-27 20:37:57', '2025-02-27 20:37:57'),
(16, 'Regard Pétrifiant\r\n', 'Compétence unique des créatures dotées d’un puissant pouvoir visuel, leur permettant d’immobiliser une cible ou de transformer en pierre ceux qui croisent leur regard trop longtemps.', '2025-02-27 20:37:57', '2025-02-27 20:37:57'),
(17, 'Cracheur d’Acide\r\n', 'Aptitude développée par certains mutants et monstres reptiliens à projeter un liquide corrosif capable de dissoudre les métaux et la chair.', '2025-02-27 20:37:57', '2025-02-27 20:37:57'),
(18, 'Marche-Spectrale\n', 'Pouvoir permettre à certaines créatures du Chaos ou fantomatiques de traverser les murs, d\'apparaître et disparaître instantanément dans un nuage d’ombres.\n', '2025-02-27 20:37:57', '2025-02-27 20:37:57'),
(19, 'Rituel Sanguin\n', 'Technique utilisée par certaines créatures pour puiser dans l’énergie vitale de leurs proies et déclencher des effets puissants comme la guérison, l’augmentation de leur force ou l’invocation d’autres créatures.\n', '2025-02-27 20:37:57', '2025-02-27 20:37:57');

-- --------------------------------------------------------

--
-- Structure de la table `bestiaryHabitats`
--

CREATE TABLE `bestiaryHabitats` (
  `habitatID` int NOT NULL,
  `habitatName` varchar(255) NOT NULL,
  `habitatPicture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiaryHabitats`
--

INSERT INTO `bestiaryHabitats` (`habitatID`, `habitatName`, `habitatPicture`) VALUES
(49, 'Cryptes', 'habitats_67cf45b6cfd5b.png'),
(50, 'Caverne putride', 'habitats_67cf45eeb6fca.png'),
(51, 'Lac souterrain', 'habitats_67cf463cb8852.png'),
(52, 'Ruines oubliées', 'habitats_67cf468e6e0d8.png'),
(53, 'Geyser de glace', 'habitats_67d313dd17315.png'),
(54, 'Faille éthérée', 'habitats_67d7fe4feab1e.png'),
(55, 'Cimetière', 'habitats_67d7feb4e3dc4.png');

-- --------------------------------------------------------

--
-- Structure de la table `bestiaryMonsters`
--

CREATE TABLE `bestiaryMonsters` (
  `monsterID` int NOT NULL,
  `monsterName` varchar(255) NOT NULL,
  `monsterHabitatID` int NOT NULL,
  `monsterAreaID` int NOT NULL,
  `monsterDangerID` int NOT NULL,
  `monsterMasterID` int DEFAULT NULL,
  `monsterRankID` int NOT NULL,
  `monsterTypeID` int NOT NULL,
  `monsterPicture` varchar(255) NOT NULL,
  `monsterDescription` varchar(2500) DEFAULT NULL,
  `monsterBehavior` varchar(2500) DEFAULT NULL,
  `monsterStrengthes` json DEFAULT NULL,
  `monsterWeaknesses` json DEFAULT NULL,
  `monsterAdvice` varchar(2500) DEFAULT NULL,
  `monsterDateCreation` datetime NOT NULL,
  `monsterDateModification` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiaryMonsters`
--

INSERT INTO `bestiaryMonsters` (`monsterID`, `monsterName`, `monsterHabitatID`, `monsterAreaID`, `monsterDangerID`, `monsterMasterID`, `monsterRankID`, `monsterTypeID`, `monsterPicture`, `monsterDescription`, `monsterBehavior`, `monsterStrengthes`, `monsterWeaknesses`, `monsterAdvice`, `monsterDateCreation`, `monsterDateModification`) VALUES
(70, 'Daelian', 52, 2, 4, NULL, 1, 79, 'monster_67cf47bf20e2a.png', 'Daelian est une entité transcendante, une incarnation de l’au-delà, flottant entre les dimensions comme un rêve insaisissable. Son corps est une silhouette indistincte, faite d’une brume argentée parsemée d’éclats d’étoiles mourantes. Ses yeux, deux vortex lumineux, ne reflètent aucune émotion humaine, seulement une sagesse et une puissance insondables. Lorsqu’il se manifeste, il semble plier la réalité autour de lui, imposant une présence qui défie les lois du temps et de l’espace.', 'Daelian est un observateur silencieux du cosmos, rarement impliqué dans les conflits des mortels. Cependant, lorsqu’il juge que l’équilibre est menacé, il intervient avec une autorité absolue. Il ne frappe jamais par colère ou vengeance, mais par nécessité cosmique. Son attitude est froide et calculée, ses actions étant aussi inévitables qu’un destin scellé. Ceux qui tentent de lui parler perçoivent des échos de voix anciennes résonnant dans leur esprit, une cacophonie de vérités et de secrets interdits.', '[\"Intangibilité \", \"Manipulation de la réalité\", \"Connaissance absolue\"]', '[\"Vulnérabilité aux ancrages dimensionnels\", \"Dissipation d’énergie spirituelle\", \"Faible attachement au monde matériel\"]', 'Utilisez des artefacts d’ancrage dimensionnel pour limiter ses déplacements et l’empêcher de se dissoudre dans l’éther.\r\n\r\nÉvitez d’attaquer de manière brute ; privilégiez des stratégies d’affaiblissement spirituel qui le forceront à se manifester pleinement.\r\n\r\nNe laissez pas son savoir vous perturber. Son don de connaissance absolue peut semer le doute dans l’esprit de ses adversaires. Restez concentré et imprévisible.', '2025-03-10 21:12:47', '2025-03-17 10:10:54'),
(71, 'Bahamet', 52, 2, 4, 70, 2, 81, 'monster_67cff541811cd.png', 'Bahamet est un démon infernale qui hante les ruines oubliées du Gouffre de Yhanhlei, un lieu où le temps semble figé et où l’air est chargé d’une énergie malveillante. Son corps est une fusion de chair et de métal maudit, recouvert de plaques d’obsidienne qui dégagent une chaleur infernale. Sa tête, semblable à un crâne de bélier cornu, est ornée d’un troisième œil écarlate qui ne cligne jamais et perçoit les âmes aussi clairement que la chair.\r\n\r\nSes mains griffues dégagent une fumée noire toxique, et sa voix résonne comme un écho d’un millier de murmures damnés. Lorsque Bahamet se meut, le sol lui-même semble vibrer sous l’empreinte de son aura démoniaque, et l’air devient oppressant, comme si l’enfer entier s’était approché.\r\n\r\n', 'Bahamet est une guerrierre impitoyable et méthodique. Contrairement aux démons berserks qui attaquent sans réfléchir, il analyse ses ennemis, jouant avec eux comme un prédateur sadique avant d’infliger un coup fatal.\r\n\r\nIl aime semer la peur avant de frapper, apparaissant dans les ombres des ruines, chuchotant des mensonges dans l’esprit de ses adversaires et invoquant des visions cauchemardesques. Lorsqu’il attaque, c’est avec une force brute écrasante, combinée à des malédictions infernales qui affaiblissent ceux qui osent lui résister.\r\n\r\nIl est aussi un commandant respecté des enfers, supervisant les créatures moindres et les envoyant harceler ses proies avant d’intervenir lui-même pour achever le travail.', '[\"Force titanesque\", \"Immunité aux flammes et à la corruption\", \"Manipulation mentale\"]', '[\"Eau bénite & symboles sacrés\", \"Attaques foudroyantes\", \"Orgueil démesuré\"]', 'Ne le laissez pas jouer avec votre esprit : Bahamet excelle dans la manipulation psychique. Protégez votre esprit avec des enchantements ou de la discipline mentale.\r\nUtilisez la vitesse et la mobilité : Il est incroyablement puissant, mais sa taille et son armure le rendent légèrement plus lent que les combattants agiles. Attaquez puis esquivez rapidement.\r\nExploitez son arrogance : Bahamet préfère dominer ses adversaires plutôt que les tuer immédiatement. Feindre la faiblesse ou jouer sur son ego peut ouvrir une opportunité d’attaque fatale.\r\nBahamet n’est pas un simple démon ; c’est une incarnation de la terreur et de la domination. Se dresser contre lui, c’est affronter une puissance infernale qui n’accorde ni pitié ni répit.', '2025-03-11 09:33:05', '2025-03-17 10:15:16'),
(72, 'Darlkira', 51, 1, 4, NULL, 1, 84, 'monster_67d312e74d743.png', 'Darlkira est une aberration divine, un être dont la forme défie toute logique biologique. Son corps immense, amorphe et visqueux, est un amalgame d’organes mutés et de tentacules chitineux qui s’étendent dans l’obscurité du lac souterrain de Nouvelle Kadata. Sa peau translucide laisse entrevoir un réseau de veines luisantes pulsant d’une énergie inconnue. Ses multiples yeux, disséminés de manière aléatoire sur sa masse en perpétuelle mutation, luisent d’une intelligence malsaine.\r\n\r\nAutrefois une divinité oubliée, Darlkira a été corrompue par une force inconnue, mutée au fil des âges jusqu’à devenir une monstruosité insondable. Son existence est un paradoxe : ni totalement physique, ni complètement éthérée, évoluant à la frontière de l’anomalie et du sacré.', 'Darlkira est un prédateur silencieux et méthodique. Il n’a pas besoin de chasser ; il attend que ses proies tombent dans son domaine, attirées par des visions hypnotiques projetées dans l’eau sombre. Ceux qui osent troubler la quiétude du lac ressentent immédiatement une présence écrasante, une pression dans leur esprit comme si une entité titanesque les scrutait.\r\n\r\nLorsqu’il attaque, c’est avec une rapidité terrifiante pour sa taille. Ses tentacules jaillissent de l’eau avec une précision chirurgicale, cherchant à broyer, percer ou infecter ses cibles avec une sécrétion mutagène qui altère irrémédiablement la chair. Il n’a pas de pitié, seulement une insatiable curiosité malsaine pour la mutation et l’assimilation.', '[\"Régénération absolue\", \"Mutation adaptative\", \"Influence psychique\"]', '[\"Lumière pure\", \"Températures extrêmes\", \"Esprit perturbé\"]', 'Ne restez pas dans l’eau : Darlkira y est souverain, et toute immersion dans le lac signifie une mort presque certaine. Trouvez un moyen de le forcer à émerger.\r\nUtilisez la lumière sacrée ou les projectiles énergétiques : Son corps étant en mutation constante, une exposition à des forces pures peut ralentir son adaptation et sa régénération.\r\nRestez imprévisible : Il apprend rapidement de ses ennemis. Si vous utilisez toujours la même attaque ou la même approche, il développera une contre-mesure en quelques instants.\r\nDarlkira n’est pas un ennemi à prendre à la légère. Un combat contre lui est une lutte contre une force en perpétuelle évolution. Ceux qui osent l’affronter doivent être prêts à tout… ou accepter d’être assimilés dans son corps cauchemardesque.', '2025-03-13 18:16:23', '2025-03-17 10:12:30'),
(73, 'Eliath', 54, 4, 4, 76, 505, 79, 'monster_67d31b03dd953.png', 'Eliath est une créature éthérée à l’apparence cauchemardesque, ressemblant aux sinistres Illithids des légendes interdites. Son corps long et mince est enveloppé d’une robe noire flottante qui semble être faite de fumée et de ténèbres condensées. Son visage est un abîme insondable, dominé par une série de tentacules sinueux qui s’agitent en permanence, émettant une brume violette irisée. Ses yeux, deux orbes blanchâtres sans pupilles, transpercent l’âme et projettent une froideur surnaturelle dans l’esprit de ceux qui osent les croiser.\r\n\r\nSes doigts sont allongés et se terminent en griffes acérées, mais ce ne sont pas ses armes les plus redoutables. Eliath ne combat pas avec sa force physique, mais avec son esprit, un vortex de conscience malveillante capable d’écraser la volonté de ses adversaires.', 'Eliath est un manipulateur froid et méthodique. Il ne se précipite jamais au combat, préférant saper les défenses mentales de ses ennemis avant même qu’ils ne réalisent qu’ils sont en danger.\r\n\r\nDepuis les ruines oubliées de Carcosa Nord, il tisse un réseau invisible de corruption psychique, chuchotant des idées empoisonnées aux aventuriers téméraires, leur faisant douter de la réalité, les poussant à s’attaquer les uns les autres. Il n’a pas besoin d’armes : son simple regard peut plonger un esprit faible dans la folie ou l’illusion.\r\n\r\nQuand il passe à l’attaque, il projette son essence dans l’esprit de ses victimes, leur infligeant des visions insoutenables ou les forçant à revivre leurs pires cauchemars. Ceux qui succombent deviennent ses marionnettes, esclaves de sa volonté qui continueront à se battre en son nom même après leur mort.', '[\"Maître du contrôle mental\", \"Corps éthéré\", \"Terreur psychique\"]', '[\"Protection mentale\", \"Lumière intense et magie sacrée\", \"Faible en combat physique\"]', 'Ne le regardez pas dans les yeux trop longtemps : Son regard est une arme qui peut instiller la folie et la soumission.\r\nUtilisez des enchantements de protection mentale : Les runes de clarté ou les artefacts d’argent peuvent empêcher son influence sur votre esprit.\r\nForcer le combat direct : Eliath est un prédateur psychique, pas un guerrier. Si vous parvenez à l’exposer à un combat physique, il sera bien plus vulnérable.\r\nEliath est une terreur silencieuse, une présence qui n’a pas besoin de lever un doigt pour triompher. Ceux qui s’égarent dans les ruines oubliées de Carcosa Nord doivent se méfier… car avant même qu’ils ne lèvent leur lame contre lui, ils auront peut-être déjà perdu.\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2025-03-13 18:50:59', '2025-03-17 11:51:43'),
(74, 'Zentaur', 50, 3, 4, 70, 2, 88, 'monster_67d31db5eebc4.png', 'Zentaur est une monstruosité titanesque, un cadavre ambulant fusionné avec la férocité d’un crocodile et la puissance d’un prédateur préhistorique. Son corps en putréfaction est recouvert d’écailles verdâtres, craquelées et suintantes d’un liquide nauséabond. Sa gueule béante est remplie de crocs noirs et irréguliers, certains brisés, d’autres anormalement longs, capables de broyer l’acier.\r\n\r\nSes bras massifs, terminés par des griffes décharnées, sont assez puissants pour éventrer un chevalier en armure d’un seul coup. Ses jambes épaisses, semblables à celles d’un raptor, lui permettent d’effectuer des bonds brutaux malgré son apparence massive. Chaque pas qu’il fait s’accompagne d’un bruit de chair en décomposition et d’un râle guttural qui semble résonner dans les ténèbres de la caverne putride.', 'Zentaur est une machine de destruction implacable, mais loin d’être un simple monstre sans cervelle. Il chasse avec une intelligence froide et tactique, utilisant sa taille et sa vitesse de manière méthodique pour piéger ses proies. Il est capable de rester immobile pendant des heures, dissimulé dans l’ombre de sa caverne, attendant qu’une victime imprudente entre dans son territoire.\r\n\r\nLorsqu’il attaque, il privilégie les embuscades brutales. Il bondit sur ses cibles avec une force colossale, cherchant à les immobiliser sous son poids avant de les déchiqueter à coups de griffes et de morsures. Il n’a pas besoin de manger, mais il aime broyer ses victimes et les laisser se relever en tant que zombies inférieurs pour élargir son influence.\r\n\r\nSi un combat dure trop longtemps, Zentaur entre dans une rage nécrotique, où ses blessures cessent de ralentir ses mouvements et où sa force atteint un niveau terrifiant.', '[\"Force bestiale\", \"Résistance à la douleur et aux blessures\", \"Capacité de résurrection\"]', '[\"Désintégration sacrée\", \"Mobilité réduite hors de son territoire\", \"Tête blindée, mais non invulnérable\"]', 'Restez mobile et combattez à distance : Évitez le corps-à-corps à tout prix. Ses attaques sont trop puissantes pour être bloquées directement.\r\nAttaquez en équipe : Seul, affronter Zentaur est suicidaire. Il faut des combattants spécialisés pour exploiter ses faiblesses.\r\nÉvitez son territoire autant que possible : Dans la caverne putride, il est presque imbattable. Attirez-le dans une zone ouverte où il ne peut pas tendre d’embuscades.\r\nZentaur n’est pas un simple zombie : c’est un titan putride, une force de destruction qui ne connaît ni repos ni fatigue. Ceux qui osent le défier doivent être prêts à frapper vite, fort et sans hésitation… avant qu’il ne les écrase sous ses griffes implacables.', '2025-03-13 19:02:29', '2025-03-17 10:18:29'),
(75, 'Garash', 52, 4, 4, 72, 2, 81, 'monster_67d31ecba6995.png', 'Garash est une horreur ailée, une chauve-souris démoniaque d’une taille colossale dont l’ombre seule suffit à plonger les âmes faibles dans la terreur. Son corps est recouvert d’un cuir sombre et écailleux, parsemé de cicatrices rougeoyantes qui pulsent au rythme de son cœur infernal. Ses ailes membraneuses, semblables à celles d’un dragon, s’étendent sur plusieurs mètres et produisent un battement assourdissant lorsqu’il prend son envol.\r\n\r\nSa tête est celle d’un cauchemar vivant : un museau allongé garni de crocs dégoulinant d’une bile acide, des oreilles tordues qui captent le moindre son, et des yeux d’un jaune livide qui transpercent l’obscurité. Lorsqu’il hurle, son cri infernal brise les tympans et s’infiltre dans l’esprit, semant la confusion et la panique.', 'Garash est un chasseur nocturne et un maître du terrain, utilisant son agilité et sa capacité à voler pour dominer ses adversaires. Il rôde silencieusement au-dessus des ruines de Carcosa Norrd, observant d’en haut, patient, avant de fondre sur ses proies avec une rapidité terrifiante.\r\n\r\nIl attaque avec une intelligence froide, frappant depuis les ombres avant de disparaître à nouveau dans le ciel noir. Il se délecte de la peur et du désespoir de ses victimes, jouant avec elles comme un chat avec une souris avant de leur asséner le coup fatal.\r\n\r\nLorsqu’il se sent en danger, il pousse un hurlement infernal, une onde sonore démoniaque capable de déstabiliser même les guerriers les plus aguerris, brisant leur concentration et rendant leurs mouvements hésitants.\r\n\r\n', '[\"Vitesse et agilité extrêmes \", \"Cri paralysant\", \"Maître de la furtivité\"]', '[\"Lumière intense\", \"Vulnérabilité au sol\", \"Cri prévisible\"]', 'Forcer le combat au sol : Garash est beaucoup plus dangereux dans les airs. Endommager ses ailes ou le piéger dans un espace confiné peut limiter son avantage.\r\nUtiliser des sources de lumière : Une lumière intense peut le forcer à reculer et perturber son vol, le rendant plus vulnérable.\r\nProtéger son esprit : Son cri affecte la concentration et la perception. Les enchantements de protection mentale ou les bouchons d’oreilles enchantés peuvent atténuer son effet.\r\nGarash est un cauchemar ailé, une terreur qui rôde dans les cieux de Carcosa Nord. L’affronter, c’est accepter de combattre une ombre vivante qui frappe avant même que vous ne réalisiez qu’il est là…', '2025-03-13 19:07:07', '2025-03-17 10:19:57'),
(76, 'Varian', 49, 4, 4, 72, 2, 79, 'monster_67d31f2daf8b9.png', 'Varian est une entité spectrale de forme étrange : une gigantesque masse bleuâtre, à mi-chemin entre une citrouille difforme et une sphère brumeuse. Sa surface est semi-solide, oscillant entre un état gazeux et un état liquide, ce qui lui permet de modifier subtilement sa taille et sa densité. Son apparence est dominée par un sourire démentiel et tordu, figé dans une expression cauchemardesque qui semble s&#039;étirer plus il s’approche de ses victimes. Ses yeux fendus, luminescents, transpercent l’âme de ceux qui osent le regarder trop longtemps.\r\n\r\nSon corps ne projette aucune ombre, ce qui rend sa présence d’autant plus troublante. Il ne parle pas, mais son rictus suffisant semble murmurer aux esprits faibles, instillant une paranoïa insidieuse dans l&#039;esprit de ses proies.', 'Varian est une entité malicieuse et sadique, plus intéressée par le tourment psychologique que par la destruction brute. Il adore jouer avec ses victimes avant de les achever, les poussant à la folie par des illusions et des distorsions de la réalité. Dans les cryptes de Carcosa Nord, il se fond parfaitement dans l’obscurité et attend patiemment que des intrus s’égarent dans son domaine.\r\n\r\nIl n’attaque pas directement au début. Il préfère chuchoter des rires fantomatiques, projeter des ombres mouvantes et faire apparaître des copies spectrales de lui-même pour désorienter ses cibles. Quand il frappe enfin, c’est avec une onde d’énergie éthérée qui drainent l’essence vitale et provoque une faiblesse soudaine.\r\n\r\nSi une proie tente de fuir, il se déplace instantanément entre les ombres, apparaissant toujours à quelques pas devant elle, souriant toujours plus grand, comme s’il savait que l’issue était déjà décidée.', '[\"Immortalité apparente\", \"Manipulation de la perception\", \"Déplacement instantané\"]', '[\"Objets ancrés à la réalité\", \"Lumière divine\", \"Absence d\'armure physique\"]', 'Restez groupés et évitez la panique : Il se nourrit de la peur et de l’isolement. Un groupe organisé a plus de chances de résister à ses illusions.\r\nUtilisez des sources de lumière constantes : Une torche bénite ou un sort de lumière sacrée peut limiter son champ d’action et l’empêcher de disparaître à volonté.\r\nIgnorez ses illusions et frappez sa vraie forme : Varian crée souvent plusieurs copies de lui-même, mais seule son véritable corps peut être endommagé. Observer attentivement les ombres peut révéler sa position réelle.\r\nVarian est un cauchemar vivant, une entité qui s’amuse avec l’esprit de ses victimes avant de les réduire à l’état de coquilles vides. Ceux qui l’affrontent doivent être prêts à voir leur propre réalité se distordre… et à ne pas céder à la terreur.', '2025-03-13 19:08:45', '2025-03-17 10:22:03'),
(77, 'Neysar', 49, 2, 3, 74, 505, 80, 'monster_67d31fc57c70a.png', 'Neysar est une créature d&#039;une obscurité pure et dévorante, une entité du Néant, une forme vivante constituée uniquement de ténèbres mouvantes et d’un vide absolu. Son apparence varie constamment, mais elle reste essentiellement une masse indéfinie, ressemblant parfois à une silhouette humanoïde, parfois à une vague de ténèbres tourbillonnantes. Ce qui frappe les témoins qui osent le décrire, c&#039;est l&#039;absence totale de lumière autour de lui : il absorbe tout ce qu’il touche, annihilant l&#039;existence et plongeant l&#039;environnement dans une noirceur totale.\r\n\r\nIl ne possède pas de traits distincts comme un visage, mais sa présence peut être ressentie par une sensation glaciale et oppressante, comme si le temps et l’espace se déformaient autour de lui. Les cryptes où il réside, dans le Gouffre de Yhanthlei, sont plongées dans une nuit perpétuelle, et le seul signe de son passage est la tempête de ténèbres qu’il laisse derrière lui.', 'Neysar est une entité froide, calculatrice et dénuée de toute émotion humaine. Il se nourrit du vide et de la destruction, préférant annihiler les vies, les âmes et les réalités plutôt que de les détruire physiquement. Son but semble être de plonger tout ce qui existe dans le néant absolu, comme une entité cosmique cherchant à effacer la matière, la pensée et même l’existence elle-même.\r\n\r\nDans les cryptes, Neysar attire les âmes perdues et les voyageurs imprudents avec des murmures insidieux et des illusions hypnotiques, leur donnant l’impression qu’ils sont proches de la vérité ou d’un grand pouvoir. Puis, lorsqu&#039;ils s&#039;approchent, il se manifeste sous forme de ténèbres mouvantes, aspirant leur essence vitale, la dissolvant dans le néant. Ceux qui succombent à son appel deviennent des esprits dévorés, leurs âmes absorbées dans le vide.\r\n\r\nNeysar ne cherche pas à combattre directement. Il manipule la peur, l’incertitude et la désolation psychologique, mais il ne se prive pas d&#039;éliminer ses ennemis lorsqu&#039;il est défié. Lorsqu&#039;il se bat, il use de rayons de néant, des faisceaux d’énergie pure qui dévorent tout sur leur passage, effaçant les êtres vivants, les pierres, et même les sorts magiques.', '[\"Absorption de l’existence\", \"Manipulation du vide \", \"Résistance à la magie\"]', '[\"Lumière et pureté sacrée\", \"Concentration mentale\", \"Environnement stable \"]', 'Lumière et purification : Utilisez des sorts de lumière sacrée, des artefacts lumineux ou des objets bénis pour restreindre ses mouvements. Les sources de lumière pure peuvent perturber son existence et réduire son contrôle sur le Néant.\r\nNe succombez pas à ses illusions : Restez ferme dans votre volonté. Neysar cherche à plonger ses ennemis dans un abîme psychologique. Gardez votre esprit concentré et vos pensées lucides.\r\nPréparez-vous à l&#039;invisible : Soyez prêt à affronter une créature qui ne se manifeste pas de manière conventionnelle. Des protections contre les attaques invisibles ou les sorts d’illusion seront essentielles pour le combattre.\r\nNe vous laissez pas isoler : Neysar cherche à diviser et à détruire les groupes. Restez ensemble et ne vous laissez pas isoler dans les cryptes, car cela facilitera son influence.\r\nNeysar est une incarnation du Néant absolu, une entité qui efface tout ce qu&#039;elle touche, qu&#039;il s&#039;agisse de corps, d&#039;esprits ou de réalités. Ceux qui l&#039;affrontent doivent comprendre que la lutte contre lui n’est pas seulement physique, mais aussi une bataille contre le vide même qui cherche à dévorer leur existence.', '2025-03-13 19:11:17', '2025-03-17 10:25:30'),
(78, 'Diliak', 52, 2, 2, 77, 508, 84, 'monster_67d329714085f.png', 'Diliak est une créature mutant, un être déformé par des mutations incontrôlées, une abomination née des ténèbres du Gouffre de Yhanthlei. Son corps est massif, composé de chair grossièrement déformée, avec des membres anormalement longs et contorsionnés, couverts d’une peau écailleuse d’un gris verdâtre et humide. Ses yeux sont d&#039;un rouge brillant, contrastant avec la pâleur de sa peau, et semblent constamment bouger de façon anormale, presque comme s&#039;ils étaient indépendants de son corps.\r\n\r\nSon dos est orné de dents et de protubérances osseuses, donnant l’impression d’un être qui aurait été conçu pour détruire et mutiler. Ses bras sont particulièrement puissants, dotés de griffes acérées qui semblent capables de déchirer la roche elle-même. Diliak est souvent perçu comme une horrible fusion de créature animale et humanoïde, avec des mutations aléatoires qui le rendent imprévisible et extrêmement difficile à combattre.\r\n\r\nSon habitat, les ruines oubliées du Gouffre de Yhanthlei, est un labyrinthe de débris et de structures effondrées. L&#039;endroit regorge de créatures mutantes comme lui, et la terre elle-même semble être imprégnée de la corruption et de l&#039;instabilité qui ont transformé Diliak en ce qu&#039;il est.', 'Diliak est un prédateur vicieux, un monstre qui se nourrit de chaos et de souffrance. Il est constamment à la recherche de proies faibles à écraser ou à dévorer. Contrairement à d&#039;autres créatures plus stratégiques, Diliak agit souvent de manière imprévisible et brutale. Il peut paraître désordonné dans ses attaques, mais il est très intelligent pour un mutant, apprenant rapidement comment exploiter les faiblesses de ses adversaires.\r\n\r\nIl attaque principalement avec ses griffes monstrueuses et ses crocs tranchants, dévorant ses victimes ou les écrasant sous sa masse corporelle. Diliak utilise aussi sa flexibilité exceptionnelle pour se faufiler dans des espaces étroits, lui permettant d&#039;attaquer par surprise. Lorsqu&#039;il est blessé, il devient encore plus agressif, cherchant à faire souffrir ses ennemis avant de les tuer.\r\n\r\nIl n&#039;hésite pas à provoquer la terreur chez ses ennemis, en se montrant d&#039;abord à une distance sûre puis en utilisant des hurlements déformés pour déstabiliser ses proies. Diliak semble également capable d’émettre des vibrations puissantes par ses mouvements, provoquant des secousses violentes et des dérèglements du terrain autour de lui, rendant les attaques à distance difficiles.', '[\"Force physique dévastatrice\", \"Mutations imprévisibles\", \"Vibrations et terrain\"]', '[\"Sensible aux attaques physiques ciblées\", \"Peur de l\'ordre \", \"Dépendance au terrain\"]', 'Utiliser des attaques ciblées : Essayez d’attirer Diliak dans des zones ouvertes où vous pouvez le frapper directement sur ses points faibles, comme ses yeux ou ses articulations. Ses zones de vulnérabilité sont ses articulations plus souples et son visage.\r\nÉvitez ses secousses : Lorsque Diliak commence à provoquer des vibrations, maintenez-vous à une distance sécuritaire et préparez-vous à esquiver ses attaques. Restez à l&#039;écart de la terre instable qu&#039;il génère.\r\nExploiter des sorts d&#039;ordre ou de contrôle : Si vous avez accès à des sorts ou artefacts qui imposent l&#039;ordre ou la structure, utilisez-les pour perturber ses capacités et lui faire perdre son agilité. Cela peut le rendre plus vulnérable aux attaques.\r\nConcentrez-vous sur ses mouvements : Diliak peut paraître désordonné dans ses attaques, mais ses mutations lui permettent de s’adapter et de devenir plus imprévisible à mesure que le combat avance. Restez calme et essayez de suivre ses mouvements pour anticiper ses attaques.\r\n', '2025-03-13 19:52:33', '2025-03-17 10:30:31'),
(79, 'Xenolian', 53, 1, 3, 71, 505, 86, 'monster_67d34d4534f6b.png', 'Xenolian est une entité élémentaire de givre, une manifestation vivante du froid éternel et des glaciers impitoyables. Son corps massif est composé de glace cristalline, dont chaque facette scintille d&#039;une lueur glacée, projetant des éclats lumineux qui semblent étouffer la chaleur dans l’air. Ses bras et ses jambes sont formés de statues de glace vivantes, tandis que son tronc est parcouru de veines d’un bleu intense, comme si des éclats d&#039;énergie élémentaire circulaient sous sa peau glacée.\r\n\r\nSon visage, bien que très distant et rigide, est sculpté dans la glace, donnant l&#039;impression d’un être figé dans une expression de sérénité glaciale et de puissance insondable. De chaque côté de son crâne, d&#039;énormes antennes de glace émergent, ressemblant à des stalactites géantes, créant un halo cristallin autour de son aura.\r\n\r\nXenolian émane une température polaire, la simple proximité de son corps suffit à geler l&#039;air, rendant toute chaleur presque intolérable. Son habitat, le geyser de glace de Nouvelle Kadatah, est un lieu de beauté glaciale, où d&#039;énormes colonnes de glace jaillissent du sol, transformant le paysage en un royaume d’éclats de cristal gelé.', 'Xenolian est une entité calme et mesurée, agissant plus comme un gardien élémentaire de son domaine gelé que comme un prédateur. Il préserve l&#039;équilibre des forces naturelles de la glace, veillant à ce que le froid et le givre restent intacts dans la région de Nouvelle Kadatah. Cependant, lorsqu&#039;il est provoqué ou lorsque son territoire est menacé, il devient une force dévastatrice, capable de libérer une violence glacée infinie.\r\n\r\nXenolian attaque avec une grande maîtrise des éléments glacés, créant des blizzards dévastateurs, lançant des projections de glace tranchantes et contrôlant des jets d&#039;eau glacée sous pression, capables de transformer la chair en glace en un instant. Il peut aussi provoquer des murs de glace impénétrables pour piéger ses ennemis, les isolant dans un espace où la chaleur et l’oxygène sont peu à peu absorbés.\r\n\r\nLorsqu&#039;il se déplace, Xenolian semble flotter à la surface de la glace, glissant sans effort, sa taille imposante n’entravant en rien sa vitesse. Son cri, semblable au vent glacial soufflant à travers une vallée gelée, est capable de geler l&#039;air autour de lui et d’altérer l’équilibre de ses ennemis, perturbant leur respiration et leur agilité.', '[\"Maîtrise des éléments de glace\", \"Résistance physique\", \"Manipulation des geysers de glace\"]', '[\"Vulnérabilité à la chaleur\", \"Fragilité en terrain instable\", \"Dépendance à la glace\"]', 'Exploiter la chaleur : Utilisez des sorts de feu ou des objets en magma pour affaiblir Xenolian. La chaleur réduira son pouvoir, le forçant à se retirer ou à adopter une forme plus vulnérable.\r\nNe pas rester immobile : Les attaques de glace sont extrêmement puissantes et peuvent figer une victime en quelques secondes. Restez en mouvement pour éviter de devenir une cible facile pour ses projectiles glacés.\r\nCombattez à distance : Xenolian est plus dangereux à courte portée, où il peut utiliser son contrôle sur la glace pour créer des pièges et des obstacles. Utilisez des attaques à distance pour l’affaiblir avant de vous engager dans un combat rapproché.\r\nÉvitez ses murs de glace : Si Xenolian crée un mur de glace autour de vous, utilisez des sorts de dégel ou cherchez à briser la glace avec des attaques physiques puissantes ou des sorts de terre. La glace est solide mais fragile sous la bonne pression.\r\nXenolian est une force élémentaire d’une puissance stupéfiante, un être qui représente la froideur du monde et la perfection glacée de la nature. Ceux qui s’aventurent dans les geysers de glace de Nouvelle Kadatah doivent se préparer à affronter une tempête gelée incarnée dans un corps de givre, où la chaleur et la lumière sont leurs ennemis.', '2025-03-13 22:25:25', '2025-03-17 10:27:18'),
(80, 'Khael', 49, 1, 3, 75, 505, 81, 'monster_67d34dd08f3e9.png', 'Khael est une créature démoniaque imposante, prenant la forme d&#039;une gargouille massive aux ailes battantes. Son corps est fait de pierre noire marbrée, parsemée de runies infernales gravées dans la matière, pulsant de lumière rouge sombre. Ses yeux sont des orbites vides d’où émanent des flammes infernales dansantes, et son regard seul est suffisant pour glacer le sang de ceux qui osent croiser son chemin.\r\n\r\nSa silhouette est à la fois terrifiante et majestueuse, avec de grandes ailes de pierre finement détaillées, pouvant déployer toute leur envergure pour lui permettre de voler avec une grâce sinistre. Il est doté de griffes acérées qui semblent capables de déchirer la pierre elle-même, et d&#039;une gueule béante parsemée de dents ressemblant à des éclats de métal brisé.\r\n\r\nKhael est souvent vu comme un gardien des cryptes de Nouvelle Kadatah, un prédateur patient qui attend que les âmes intrusives s&#039;approchent trop près de son domaine. Il se fond parfaitement dans son environnement, où la poussière et les ombres des cryptes dissimulent sa silhouette imposante.', 'Khael est un prédateur stratégique et patient, généralement posé et en retrait. Il ne se précipite pas au combat, attendant le moment opportun pour frapper. Son intelligence démoniaque est évidente dans la manière dont il piège ses ennemis et les manipule pour qu’ils se retrouvent dans des situations de vulnérabilité.\r\n\r\nDans les cryptes, il rôde dans l’ombre, observant ceux qui osent pénétrer son domaine. Khael est un gardien qui ne cherche pas simplement à tuer, mais à torturer psychologiquement ses adversaires. Il les force à se perdre dans les couloirs tortueux, leur faisant entendre des murmures infernaux et des bruits angoissants pour troubler leur esprit. Lorsqu’il les attaque, il utilise ses griffes et ses crocs pour déchirer sa victime, tout en faisant pleuvoir des projectiles de pierre enflammée ou des flammes infernales pour brûler tout ce qui se trouve à portée.\r\n\r\nKhael est également capable de manipuler les ombres autour de lui, les rendant suffocantes pour ses ennemis et leur masquant la lumière nécessaire pour se défendre. Lorsqu&#039;il déploie ses ailes, il crée des rafales d’air chargées de cendres et de soufre, perturbant la visibilité et la respiration de ses adversaires.', '[\"Contrôle des ombres\", \"Puissance physique\", \"Résistance aux attaques physiques\"]', '[\"Faiblesse à la magie de terre\", \"Vulnérabilité à la lumière divine\", \"Attaques à distance\"]', 'Exploitez la lumière sacrée : Utilisez des enchantements sacrés, des artefacts lumineux ou des sorts de purification pour affaiblir Khael. La lumière intense perturbera son pouvoir et le rendra plus vulnérable.\r\nRestez mobiles : Évitez de vous laisser piéger dans l’obscurité ou les illusions de Khael. Restez en mouvement pour éviter ses attaques de griffes et de flammes, et pour échapper à ses pièges basés sur l&#039;ombre.\r\nAttaquez à distance avec des sorts de terre : Khael étant une créature de pierre, des sorts de pouvoir tellurique comme ceux qui peuvent fissurer ou détruire des structures de roche peuvent affaiblir son corps et briser sa résistance.\r\nNe sous-estimez pas sa ruse : Khael est un stratège rusé. Ne vous laissez pas manipuler par ses illusions ou ses pièges psychologiques. Gardez votre sang-froid et votre esprit clair, et ne perdez pas de vue vos objectifs.\r\nKhael est un gardien démoniaque des cryptes, un prédateur silencieux et méthodique qui n’hésite pas à utiliser les ombres et les illusions pour piéger ses ennemis. Ceux qui se retrouvent dans son domaine doivent se préparer à affronter non seulement sa puissance brute, mais aussi les tourments psychologiques de sa présence infernale.', '2025-03-13 22:27:44', '2025-03-17 10:28:35'),
(82, 'Gravefang ', 55, 2, 2, 77, 508, 88, 'monster_67d7ecb7e4581.png', 'Gravefang est un chien zombie imposant, une créature décharnée issue des profondeurs des cimetières maudits de Yhanthlei. Son corps est dévêtu, presque entièrement décomposé, mais sa musculature demeure étonnamment intacte. La peau de son dos est déchirée, exposant des os béants et des muscles putréfiés. Son pelage, désormais terni et en lambeaux, est parsemé de taches de sang séché et de morsures, luttant pour se maintenir intact. Sa tête, bien que déformée et rongée par la nécrose, garde encore des traits de féroce animalité : des crocs acérés et des yeux brillants, d’un vert surnaturel, qui brillent d&#039;une lueur sinistre.', 'Gravefang est un prédateur impitoyable, agissant par instincts primaires, mais sa nature de zombie lui confère aussi une obéissance stricte à son créateur ou à son maître. Il suit les ordres avec une fidélité absolue, se déplaçant dans les zones obscures et les cimetières en recherchant ses proies à l&#039;odeur, traquant sans relâche. Contrairement aux chiens vivants, Gravefang ne ressent ni douleur ni fatigue. Cela le rend extrêmement dangereux, car il peut poursuivre sa cible indéfiniment sans faiblir.\r\n\r\nIl est capable de se déplacer silencieusement, attendant que sa victime se rapproche avant de surgir dans une charge brutale. Ses attaques se concentrent principalement sur la déchirure et la mutilation, ses crocs et griffes étant capables de déchirer les chairs humaines et les armures légères. Gravefang préfère s&#039;attaquer par surprise, utilisant sa capacité à se faufiler dans les ombres des ruines pour fondre sur ses ennemis.', '[\"Vitesse et agilité\", \"Résilience à la douleur\", \"Instinct de prédateur développé\"]', '[\"Vulnérabilité à l’acier\", \"Dépendance aux ordres\", \"Incapacité à régénérer d’énormes pertes\"]', 'Utilisez des armes tranchantes : Les attaques avec des épées, haches, ou tout autre objet tranchant sont particulièrement efficaces contre la créature, car elles peuvent sectionner les tendons et limiter sa mobilité.\r\nDétournez son attention : Si vous avez plusieurs ennemis ou alliés, essayez de diviser son attention en utilisant des bruits ou des mouvements pour l&#039;attirer ailleurs. Sa concentration peut être facilement perturbée, ce qui permet de prendre l&#039;avantage.\r\nCibler la tête : Bien que la créature soit résistante, un coup à la tête (particulièrement avec des armes perforantes comme des pieux ou des lances) peut infliger un dommage mortal et mettre fin à sa régénération.\r\nNe laissez pas vos alliés se disperser : Le hurlement de Gravefang peut déstabiliser un groupe. Si vous êtes accompagné, restez organisé et ne laissez pas vos coéquipiers se disperser, car il pourrait isoler et éliminer les plus faibles.', '2025-03-17 10:34:47', '2025-03-17 11:51:51'),
(83, 'Serpentaris', 50, 4, 3, 73, 508, 79, 'monster_67d7ed42944da.png', 'Serpentaris est un serpent éthéré d&#039;une beauté sinistre et envoûtante. Ce serpent spectral mesure plusieurs mètres de long, ses écailles translucides sont teintées de nuances d&#039;argent et de bleu profond, lui conférant une apparence presque iridescente. La lumière semble se distordre autour de lui, comme si la réalité elle-même avait du mal à saisir pleinement sa forme. Ses yeux phosphorescents brillent d’une lueur inquiétante, capable d&#039;hypnotiser ceux qui croisent son regard. Il est dépourvu de corps solide, mais plutôt constitué de vagues d&#039;énergie éthérée qui se déplacent avec une fluidité surnaturelle. Sa longueur serpentine se tord et se déplace avec une grâce fluide, lui permettant de se faufiler à travers des espaces impossibles pour une créature matérielle.', 'Serpentaris est une créature furtive et traîtresse, n’agissant jamais directement, mais plutôt en usant de la ruse et de l’illusion pour manipuler ses ennemis. Il est capable de se déplacer à travers les dimensions éthérées, disparaissant et réapparaissant sans crier gare, rendant la poursuite de la créature extrêmement difficile. Il chasse principalement en utilisant des sorts psychiques, des illusions mentales, et des attacks furtives. Lorsqu&#039;il attaque, il préfère se fondre dans l&#039;ombre ou l&#039;éther, frappant avec des morsures spectrales ou des ondes d&#039;énergie dévastatrices.', '[\"Maniement des illusions et des rêves\", \"Mobilité éthérée\", \"Contrôle de l’environnement\"]', '[\"Vulnérabilité à la magie lumineuse\", \"Dépendance à l’éther\", \"Limité à des attaques physiques indirectes\"]', 'Utiliser la magie lumineuse ou sacrée : Serpentaris est vulnérable à la lumière. Des sorts sacrés, des artefacts qui rayonnent de lumière ou des armes bénies peuvent l&#039;affaiblir considérablement et l’empêcher de se fondre dans l’éther.\r\nRester concentré et organisé : Ses illusions peuvent troubler vos sens et perturber la cohésion de votre groupe. Maintenez votre calme et coordonnez vos mouvements pour éviter d’être désorienté par ses attaques psychiques.\r\nExploiter les zones solides : Bien qu’il puisse se déplacer dans les dimensions éthérées, il est vulnérable lorsque sur le plan matériel. Dirigez-le vers des zones où il ne peut pas se fondre dans l’éther facilement, ou utilisez des sorts de répulsion éthérée pour l&#039;empêcher d&#039;utiliser cette capacité.', '2025-03-17 10:37:06', '2025-03-17 10:37:06'),
(84, 'Mycroptis ', 50, 2, 3, 79, 508, 91, 'monster_67d7ede46c2e2.png', 'Le Mycroptis est une créature fongique ressemblant à un petit poulpe vert, mais avec des caractéristiques uniques qui le distinguent des espèces maritimes classiques. Ce petit monstre mesure environ 3 à 5 cm de long, ses tentacules courts et visqueux sont recouverts de moisissures fluorescentes et de poils fongiques. La peau de Mycroptis est d&#039;un vert pâle, presque luminescent, et ses tentacules sont capables de s’étendre et de se ramifier de manière flexible pour saisir des proies ou manipuler son environnement.\r\n\r\nSur son dos se trouve un réseau de spores et de champignons en formation, qui émettent des gaz toxiques ou des mycotoxines capables d’affecter ses ennemis. Sa tête, quant à elle, est semblable à celle d’un poulpe, mais son regard est intense, comme s&#039;il pouvait percevoir le moindre mouvement à son tour.\r\n\r\nLe Mycroptis est une créature qui prospère dans les environnements pourris, les cavernes humides et saturées de moisissures, et ses habitats sont souvent remplis de champignons géants et de fongus hallucinogènes. Il semble pouvoir se nourrir d&#039;énergie fongique et de matière organique décomposée.', 'Le Mycroptis est une créature furtive et territoriale, évoluant principalement dans des zones d&#039;humidité extrême, comme les grottes putrides, où les énergies fongiques sont les plus abondantes. Il préfère éviter les combats directs, mais se nourrit essentiellement des matières organiques en décomposition et des plantes fongiques. Il se cache dans les ombres des grottes, dans les fissures, et attend que ses proies passent à proximité.\r\n\r\nLorsqu&#039;il se sent menacé ou qu&#039;il chasse, il utilise ses tentacules pour attaquer rapidement. Son attaque principale consiste à empoisonner ses ennemis avec une substance toxique qu&#039;il sécrète sur ses tentacules. Il peut aussi libérer une nuée de spores dans l&#039;air, créant une zone de confusion où la respiration devient difficile et où les ennemis sont sujets à des hallucinations ou à des effets paralysants. Il a une grande capacité à se cacher parmi les champignons géants et peut même se camoufler en partie pour attendre patiemment sa proie.\r\n\r\nMalgré sa petite taille, le Mycroptis peut être très dangereux en groupe, car il se déplace souvent en colonies dans les grottes, créant des nuées d’attaques et de toxines. Si un seul Mycroptis échoue à capturer sa proie, il peut appeler ses congénères à l’aide, rendant toute attaque contre lui particulièrement risquée.', '[\"Toxicité et empoisonnement\", \"Manipulation des spores\", \"Camouflage et furtivité\"]', '[\"Vulnérabilité aux températures extrêmes\", \"Faible résistance physique\", \"Sensibilité à la lumière intense\"]', 'pportez de la lumière : Utilisez des lampes fortes ou des sorts de lumière pour perturber ses mouvements et son camouflage dans l’obscurité. La lumière gêne le Mycroptis, le forçant à fuir ou à se cacher dans les recoins de la caverne.\r\nNe vous laissez pas surprendre par les spores : Les hallucinations et la paralysie peuvent être de graves menaces. Tenez-vous à l’écart des nuées de spores et portez des masques de protection pour vous protéger des effets toxiques.\r\nUtilisez des armes perforantes ou tranchantes : Le Mycroptis n&#039;a pas une grande résistance physique. Des attaques directes avec des armes tranchantes ou perforantes peuvent facilement le tuer, surtout si vous ciblez ses tentacules ou son corps fragile.\r\nÉvitez les combats en groupe : Bien que le Mycroptis soit relativement faible en solo, il devient beaucoup plus dangereux en colonies. Évitez les zones où vous pourriez être submergé par plusieurs créatures et restez vigilant pour ne pas être attaqué par surprise.', '2025-03-17 10:39:48', '2025-03-17 10:39:48'),
(85, 'Necrogon ', 51, 1, 2, 73, 508, 92, 'monster_67d7ee8bee49a.png', 'Le Necrogon est une grenouille nécrotique de taille moyenne, mesurant environ 60 cm de long, avec une peau noire et luisante, parsemée de veines violet sombre et de taches nécrotiques qui semblent bouillonner d’énergie sombre. Ses yeux sont d’un rouge incandescent, brillants d&#039;une lueur malsaine, et dégagent une aura de mort imminente. Les crochets de ses pattes sont plus longs que la normale, et ses griffes se terminent par des sabots acérés. Sa langue, d&#039;un vert pourpre, est capable de saisir ses proies avec une adhérence surnaturelle, et elle libère un venin toxique capable de décomposer la chair et d&#039;empoisonner l&#039;âme elle-même.\r\n\r\nCette grenouille, bien que de taille relativement petite, incarne la necrose, se nourrissant non seulement de matière organique en décomposition mais aussi de l&#039;énergie vitale de ses proies. Elle habite les lacs souterrains aux eaux sombres et stagnantes, où la vie peine à survivre. Son habitat naturel est souvent rempli de miasmes putrides, où l’air est lourd, et les plantes aquatiques nécrotiques prospèrent.', 'Le Necrogon est une créature agressive, mais discrète. Il chasse principalement dans les lacs souterrains, où il se cache sous la surface de l’eau ou parmi les débris flottants, attendant le moment propice pour attaquer ses proies. Il utilise sa langue toxique pour attraper ses victimes, injectant un venin décomposant qui commence à détruire les tissus corporels et à affaiblir le système nerveux de sa proie.\r\n\r\nLorsqu&#039;il est provoqué ou attaqué, le Necrogon libère une vapeur nauséabonde et une brume nécrotique qui se propage rapidement, affaiblissant toute forme de vie à proximité. Cette brume, chargée de toxines nécrotiques, peut désintégrer progressivement la chair et corrompre les âmes, rendant toute tentative de guérison pratiquement vaine. Il est également capable d’émettre des croassements terrifiants, qui affolent ses ennemis et peuvent désorienter les intrus dans ses eaux.\r\n\r\nLe Necrogon préfère opérer seul, mais, dans des conditions où il se sent menacé, il peut rassembler plusieurs autres membres de son espèce, formant des groupes de chasse qui exploitent leur environnement pour prendre d&#039;assaut leurs proies.', '[\"Toxicité dévastatrice\", \"Manipulation des miasmes\", \"Agilité amphibie\"]', '[\"Vulnérabilité au feu\", \"Dépendance à l’humidité\", \"Faiblesse face à la purification\"]', 'Protégez-vous contre les toxines : Étant donné la puissance du venin nécrotique, assurez-vous de porter des protections contre les toxines et d’utiliser des antivenins. La guérison rapide après une attaque peut être cruciale pour empêcher des effets mortels.\r\nNe restez pas dans l’eau : L’attaque du Necrogon est beaucoup plus dangereuse lorsqu’il est dans son environnement naturel. Si possible, éloignez-vous des plans d&#039;eau stagnants où il peut se cacher et vous attaquer par surprise.\r\nUtilisez des armes bénies ou purificatrices : Si vous avez accès à des armes enchantées ou à des sorts de purification, utilisez-les pour neutraliser les effets nécrotiques de la créature. Les magies de lumière ou de purification peuvent réduire son pouvoir et dissiper les effets de la brume toxique.\r\nExploitez sa faiblesse à la chaleur : Bien que les flammes ne soient pas fatales à un Necrogon, elles peuvent perturber ses attaques, affaiblir sa régénération, et réduire son agilité. N&#039;hésitez pas à utiliser des sorts de feu ou des armes enflammées pour l’attaquer.', '2025-03-17 10:42:35', '2025-03-17 10:42:35'),
(86, 'Furmidon ', 51, 4, 2, 73, 508, 90, 'monster_67d7ef8d9bc69.png', 'Le Furmidon est une petite boule de poils au regard perçant, d&#039;un diamètre d&#039;environ 20 cm. Bien que sa forme apparaisse d&#039;abord inoffensive et adorable, c&#039;est une créature parasitique d&#039;une grande dangerosité. Son pelage est d&#039;un gris terne, presque translucide par endroits, recouvert de poils fins et soyeux qui semblent respirer une énergie corrompue. Des yeux jaunes perçants brillent à travers son pelage éparse, et sa petite bouche est équipée de dents acérées capables de perforer la peau et de se fixer à ses hôtes.\r\n\r\nSous son apparence mignonne, le Furmidon cache un réseau parasitaire constitué de filaments sombres qui se propagent dans tout son corps. Lorsqu&#039;il se fixe sur un hôte, il peut infester celui-ci et influencer son esprit, en invoquant des visions et en provoquant une sensation de détérioration progressive.\r\n\r\nBien qu&#039;il semble être un simple mammifère minuscule, il est en réalité un prédateur rusé, et sa taille ne doit en aucun cas être sous-estimée. Ses dents et griffes ne sont que les outils pour se fixer sur un hôte, mais son principal pouvoir est de parasiter les esprits de ses victimes à travers des filaments mentaux.', 'Le Furmidon est une créature très furtive et intelligente. Il passe la majeure partie de son temps à se cacher dans les recoins sombres des lacs souterrains ou des grottes de Carcosa Nord, où il se nourrit de la faune locale, en se fixant rapidement sur des créatures plus grandes pour les parasitiser. Lorsqu’il attaque, il grimpe habilement sur son hôte, se fixant sur lui avec ses griffes acérées et ses dents avant d’injecter un toxine paralysant qui permet à ses racines parasitaires d’envahir l&#039;esprit et le corps de l’hôte.\r\n\r\nEn cas de menace, il utilise souvent la furtivité pour s’approcher, se cachant derrière des pierres ou des végétaux. Une fois sur sa victime, le Furmidon peut exercer un contrôle mental sur elle, provoquant une série de visions hallucinatoires et créant un sentiment de lente dégradation physique et mentale. Ce processus peut durer plusieurs jours, la victime devenant de plus en plus faible et confuse avant que le Furmidon ne prenne pleinement le contrôle.\r\n\r\nIl est aussi capable de se disséminer dans l&#039;environnement, se cachant dans des zones humides et sombres, et attend souvent des proies isolées pour les attaquer une par une.', '[\"Contrôle mental et parasitisme\", \"Dissimulation et furtivité\", \"Croissance rapide des filaments parasitaires\"]', '[\"Vulnérabilité aux énergies purifiantes\", \"Faible en combat direct\", \"Dépendance à l\'ombre et à l\'humidité\"]', 'Soyez attentif aux signes de parasitisme : Si vous constatez des hallucinations, une fatigue extrême ou des changements dans le comportement de votre groupe, il est possible qu’un Furmidon soit à l’œuvre. Soyez sur vos gardes et effectuez régulièrement des inspections minutieuses.\r\nUtilisez des protections mentales : Si vous avez accès à des sorts de protection mentale ou des artefacts magiques pour repousser l’influence psychique, utilisez-les contre le Furmidon. Ses attaques mentales peuvent être réduites ou neutralisées par ces protections.\r\nÉvitez les zones sombres et humides : Le Furmidon préfère les environnements humides et obscurs. Si vous devez pénétrer dans des grottes ou des lacs souterrains, assurez-vous d’être équipé de lumière forte et évitez les endroits trop sombres ou stagnants.', '2025-03-17 10:46:53', '2025-03-17 10:46:53');
INSERT INTO `bestiaryMonsters` (`monsterID`, `monsterName`, `monsterHabitatID`, `monsterAreaID`, `monsterDangerID`, `monsterMasterID`, `monsterRankID`, `monsterTypeID`, `monsterPicture`, `monsterDescription`, `monsterBehavior`, `monsterStrengthes`, `monsterWeaknesses`, `monsterAdvice`, `monsterDateCreation`, `monsterDateModification`) VALUES
(87, 'Racnar', 52, 1, 2, 79, 508, 84, 'monster_67d7f04d368cc.png', 'Le Racnar est un humanoïde mutant fait principalement de racines et de végétation dense. Il mesure environ 1,7 mètres de haut, avec un corps robuste, formé de branchages et de racines s&#039;enroulant autour de sa structure osseuse, donnant une apparence organique et sauvage. Sa peau est faite de mousse et de lierre, tandis que son visage est partiellement recouvert par des masses de racines tordues, ne laissant apparaître que deux yeux bleus brillants qui semblent brûler d&#039;une énergie étrange.\r\n\r\nSes bras et jambes sont larges et puissants, avec des mains terminées par des griffes de racines rugueuses, capables de percer les armures et les peaux les plus dures. L&#039;ensemble de son corps semble être en constante évolution, comme si ses racines poussaient et se réarrangeaient à mesure qu’il se déplaçait dans son environnement.\r\n\r\nLe Racnar incarne la fusion du végétal et du mal, un être vivant d’apparence naturelle, mais qui est en réalité une mutation déformée créée par les forces corrompues des Ruines Oubliées. Ses racines ne sont pas seulement un moyen de se déplacer ou de se défendre, mais aussi une forme de connexion avec la terre, ce qui lui permet de manipuler l&#039;environnement naturel autour de lui.', 'Le Racnar est une créature d&#039;une intelligence primitive mais d&#039;une grande agilité. Il passe la plupart de son temps à errer dans les ruines oubliées, là où la nature a été transformée par la mutation, où les forêts et les racines se mêlent avec les structures en ruine. Il se déplace lentement et semble s&#039;intégrer parfaitement à son environnement, imitant les plantes et les arbustes autour de lui pour passer inaperçu.\r\n\r\nLorsqu&#039;il chasse ou se défend, il utilise ses racines comme des tentacules, les allongeant pour attraper ses proies ou attaquer à distance. Lorsqu&#039;il est menacé ou en colère, il peut faire pousser de nouvelles racines à une vitesse incroyable, envoyant des vignes acérées pour piéger ses ennemis ou les écraser sous des blocs de pierres arrachées du sol.\r\n\r\nLe Racnar est aussi capable de se camoufler dans son environnement, se fondant dans les racines et les arbres morts des ruines oubliées, attendant que sa victime s’approche pour lui sauter dessus avec une force brute et inattendue.', '[\"Manipulation des racines et de l\'environnement\", \"Grande force physique\", \"Résilience et régénération\"]', '[\"Sensibilité au feu\", \"Poussée par la magie de purification\", \"Limité par son environnement\"]', 'Exploitez sa vulnérabilité au feu : Si vous vous retrouvez face à un Racnar, les armes enflammées ou les sorts de feu seront vos meilleurs alliés. Le feu brûlera ses racines et son corps végétal, rendant la créature beaucoup plus facile à affaiblir.\r\nNe combattez pas dans des environnements boisés : Évitez de combattre le Racnar dans les forêts ou les ruines où il peut se cacher et manipuler l&#039;environnement. Combattez dans un terrain dégagé où ses racines auront moins de prises pour se développer.\r\nUtilisez la magie purificatrice : La magie sacrée ou de purification peut perturber la mutation du Racnar et affaiblir ses pouvoirs. Si vous avez accès à ce type de magie, utilisez-la pour perturber son lien avec la terre et réduire sa capacité à manipuler les racines.', '2025-03-17 10:50:05', '2025-03-17 10:50:05'),
(88, 'Krish', 52, 1, 3, 80, 508, 81, 'monster_67d7f0c5c5758.png', 'Le Krish est une chauve-souris démoniaque d’une taille impressionnante, mesurant jusqu&#039;à 2,5 mètres d’envergure. Sa peau est de couleur noire charbon, presque comme de l’écorce d’obsidienne, avec des veines rouges vives parcourant son corps, pulsant comme si du sang bouillonnait sous sa peau. Ses ailes sont larges, faites d’une membrane fine et déchiquetée, se déployant dans des angles acérés, similaires à des draps déchirés. Les bords des ailes, eux, sont marqués par des dents d&#039;os et des griffes courbes, comme des serres tranchantes. Son visage est marqué par une expression terrifiante, avec des yeux jaunes luisants, pupilles fendues, et un large sourire déformé, tout de dents blanches et effrayantes, typique des démons.\r\n\r\nLe Krish a un corps musclé, malgré sa nature démoniaque, doté de griffes acérées et de crocs qui sont capables de déchirer la chair de ses ennemis avec une facilité mortelle. Sa tête présente un snout effilé, semblable à celui d&#039;une chauve-souris classique, mais avec des cornes incurvées au sommet de son crâne, marquant sa nature démoniaque. Il peut aussi émettre des sons ultrasoniques, qui peuvent désorienter ses victimes ou les paralyser momentanément.', 'Le Krish est une créature agressive, furtive et cauchemardesque, préfèrant chasser ses ennemis ou ses proies en solitaire plutôt qu’en groupe. Il est extrêmement intelligent, utilisant ses sens aiguisés et ses capacités de vol pour se déplacer rapidement dans les zones sombres et tordues des ruines oubliées. Lorsqu&#039;il traque une proie, il peut se cacher dans les recoins les plus sombres, se fondant dans l&#039;obscurité, puis attaquer soudainement en se précipitant avec une vitesse foudroyante.\r\n\r\nLe Krish n’hésite pas à utiliser des sons ultrasoniques pour désorienter ses victimes, les plongeant dans un état de confusion et d’anxiété avant de fondre sur elles pour infliger des blessures fatales. Il s’accroche généralement à ses proies après les avoir frappées et utilise ses griffes pour les déchirer en morceaux. Lorsqu&#039;il est menacé, il utilise ses capacités de vol pour se retirer dans les airs, se cachant dans des coins sombres, attendant que l&#039;ennemi se fasse une ouverture pour recommencer l&#039;attaque.', '[\"Agilité en vol \", \"Attaque sonore\", \"Capacités de régénération\"]', '[\"Vulnérabilité à la lumière intense\", \"Faiblesse au poison et à la toxicité\", \"Dépendance à l’obscurité\"]', 'Utilisez la lumière à votre avantage : Si vous combattez un Krish, essayez de le forcer à sortir de son habitat naturel. La lumière intense, comme des sorts lumineux ou des torches, peut le forcer à s&#039;éloigner et réduire son efficacité, le rendant plus vulnérable aux attaques.\r\nÉvitez de rester immobile dans des espaces confinés : Le Krish se déplace rapidement dans les espaces sombres. Évitez de rester dans des zones où il peut facilement vous atteindre sans pouvoir vous défendre. Préférez des espaces dégagés et essayez de détecter sa présence avant qu&#039;il n&#039;attaque.\r\nPréparez des sorts ou des armes soniques : Si vous avez accès à des armes soniques ou des sorts qui perturbent les capacités auditives, vous pouvez neutraliser ses attaques ultrasoniques et le rendre moins efficace.\r\nRestez mobile et actif : Le Krish préfère les attaques rapides et soudaines, il est donc essentiel de rester en mouvement pour éviter de devenir une cible facile.', '2025-03-17 10:52:05', '2025-03-17 10:52:05');

-- --------------------------------------------------------

--
-- Structure de la table `bestiaryMonstersSkills`
--

CREATE TABLE `bestiaryMonstersSkills` (
  `msMonsterID` int NOT NULL,
  `msSkillID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiaryMonstersSkills`
--

INSERT INTO `bestiaryMonstersSkills` (`msMonsterID`, `msSkillID`) VALUES
(50, 66),
(50, 67),
(52, 66),
(52, 67),
(52, 68),
(54, 66),
(54, 67),
(55, 71),
(56, 63),
(57, 66),
(58, 66),
(59, 62),
(64, 63),
(64, 65),
(70, 62),
(70, 63),
(70, 64),
(70, 65),
(71, 66),
(71, 68),
(72, 72),
(72, 73),
(72, 74),
(73, 62),
(73, 63),
(73, 65),
(74, 76),
(74, 77),
(74, 78),
(74, 91),
(74, 92),
(75, 66),
(75, 67),
(75, 68),
(76, 63),
(76, 64),
(76, 65),
(77, 79),
(77, 80),
(77, 81),
(78, 72),
(78, 87),
(78, 88),
(79, 89),
(80, 67),
(82, 76),
(82, 77),
(82, 78),
(83, 62),
(83, 63),
(84, 96),
(84, 97),
(86, 94),
(86, 95),
(87, 73),
(87, 87),
(88, 66),
(88, 68);

-- --------------------------------------------------------

--
-- Structure de la table `bestiaryRanks`
--

CREATE TABLE `bestiaryRanks` (
  `rankID` int NOT NULL,
  `rankValue` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rankOrder` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiaryRanks`
--

INSERT INTO `bestiaryRanks` (`rankID`, `rankValue`, `rankOrder`) VALUES
(1, 'Divins', 1),
(2, 'Lieutenants', 2),
(505, 'Élus', 3),
(508, 'Légionnaire', 4);

-- --------------------------------------------------------

--
-- Structure de la table `bestiarySafePlaces`
--

CREATE TABLE `bestiarySafePlaces` (
  `safePlaceID` int NOT NULL,
  `safePlaceName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `safePlacePicture` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiarySafePlaces`
--

INSERT INTO `bestiarySafePlaces` (`safePlaceID`, `safePlaceName`, `safePlacePicture`) VALUES
(6, 'Armurerie', 'safePlaces_67cf2918f1898.png'),
(7, 'Infirmerie', 'safePlaces_67cf29581fa8b.png'),
(8, 'Couchettes', 'safePlaces_67cf29d37d0ab.png');

-- --------------------------------------------------------

--
-- Structure de la table `bestiarySkills`
--

CREATE TABLE `bestiarySkills` (
  `skillID` int NOT NULL,
  `skillName` varchar(255) NOT NULL,
  `skillTypeID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiarySkills`
--

INSERT INTO `bestiarySkills` (`skillID`, `skillName`, `skillTypeID`) VALUES
(62, 'Passage éthéré ', 79),
(63, 'Absorbeur D&#039;énergie', 79),
(64, 'Cataliste éthérien', 79),
(65, 'Explosion éthérienne', 79),
(66, 'Pacte Démoniaque', 81),
(67, 'Invocation Démoniaque', 81),
(68, 'Feu Ardent', 81),
(69, 'Vomi Infecte', 82),
(72, 'Mutation Informe', 84),
(73, 'Régénération', 84),
(74, 'Spores Toxiques', 84),
(76, 'Canibalisme', 88),
(77, 'Rage', 88),
(78, 'Poursuite', 88),
(79, 'Vide Dévorant', 80),
(80, 'Annihilation Cosmique', 80),
(81, 'Ombres Affamées', 80),
(82, 'Horreur Indicible', 82),
(83, 'Mutation Rampante', 82),
(84, 'Cri De L&#039;Au-delà', 82),
(85, 'Impact Sismique', 83),
(86, 'Marteau Titanesque', 83),
(87, 'Dégénérescence Acide', 84),
(88, 'Bras Multiples', 84),
(89, 'Fusion Primaire', 86),
(90, 'Éveil Des Arcanes', 86),
(91, 'Morsure Contaminée', 88),
(92, 'Résurrection Macabre', 88),
(93, 'Ponction Vitale', 90),
(94, 'Esprit De La Ruche', 90),
(95, 'Contagion Rampante', 90),
(96, 'Spores Hallucinogènes', 91),
(97, 'Symbiose Forcée', 91),
(98, 'Éclosion Incontrôlée', 91),
(99, 'Drain D’Existence', 92),
(100, 'Marque Des Damnés', 92),
(101, 'Âmes Tourmentées', 92);

-- --------------------------------------------------------

--
-- Structure de la table `bestiarySlides`
--

CREATE TABLE `bestiarySlides` (
  `slideID` int NOT NULL,
  `slideMonsterID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bestiarySlides`
--

INSERT INTO `bestiarySlides` (`slideID`, `slideMonsterID`) VALUES
(24, 50),
(25, 51),
(26, 53),
(27, 54),
(28, 52),
(29, 57),
(30, 59),
(31, 61),
(36, 71),
(37, 72),
(38, 70),
(39, 73),
(40, 74);

-- --------------------------------------------------------

--
-- Structure de la table `bestiaryTypes`
--

CREATE TABLE `bestiaryTypes` (
  `typeID` int NOT NULL,
  `typeName` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiaryTypes`
--

INSERT INTO `bestiaryTypes` (`typeID`, `typeName`) VALUES
(79, 'éthéré'),
(80, 'Néant'),
(81, 'Démoniaque'),
(82, 'Abomination'),
(83, 'Colosse'),
(84, 'Mutant'),
(85, 'Psychique'),
(86, 'Élémentaire'),
(88, 'Zombie'),
(90, 'Parasitaire '),
(91, 'Fongique '),
(92, 'Nécrotique');

-- --------------------------------------------------------

--
-- Structure de la table `bestiaryUsers`
--

CREATE TABLE `bestiaryUsers` (
  `userID` int NOT NULL,
  `userIsAdmin` tinyint NOT NULL,
  `userFirstName` varchar(255) NOT NULL,
  `userLastName` varchar(255) NOT NULL,
  `userMail` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userDateCreation` datetime NOT NULL,
  `userDateModification` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bestiaryUsers`
--

INSERT INTO `bestiaryUsers` (`userID`, `userIsAdmin`, `userFirstName`, `userLastName`, `userMail`, `userPassword`, `userDateCreation`, `userDateModification`) VALUES
(1, 1, 'Axel', 'Hébert', 'a-hebert@hotmail.fr', '$2b$12$bjm2/dIVu3wYCHMrhTGi.OaEaH4gMSRh6A5mQt7Gw8kLVCSdZB.Se', '2025-02-18 12:24:03', '2025-02-18 12:24:03'),
(8, 1, 'test', 'test', 'test@test.fr', '$2y$10$YVlAnIBarT2O5fL7j9Gcxe43JBIPtpe.GJflH.kbiFtqD.Oz6czD2', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bestiaryAreas`
--
ALTER TABLE `bestiaryAreas`
  ADD PRIMARY KEY (`areaID`);

--
-- Index pour la table `bestiaryAreasHabitats`
--
ALTER TABLE `bestiaryAreasHabitats`
  ADD PRIMARY KEY (`ahID`);

--
-- Index pour la table `bestiaryAreasSafePlaces`
--
ALTER TABLE `bestiaryAreasSafePlaces`
  ADD PRIMARY KEY (`asID`);

--
-- Index pour la table `bestiaryDangers`
--
ALTER TABLE `bestiaryDangers`
  ADD PRIMARY KEY (`dangerID`);

--
-- Index pour la table `bestiaryGlossaryWords`
--
ALTER TABLE `bestiaryGlossaryWords`
  ADD PRIMARY KEY (`glossaryWordID`);

--
-- Index pour la table `bestiaryHabitats`
--
ALTER TABLE `bestiaryHabitats`
  ADD PRIMARY KEY (`habitatID`);

--
-- Index pour la table `bestiaryMonsters`
--
ALTER TABLE `bestiaryMonsters`
  ADD PRIMARY KEY (`monsterID`);

--
-- Index pour la table `bestiaryMonstersSkills`
--
ALTER TABLE `bestiaryMonstersSkills`
  ADD PRIMARY KEY (`msMonsterID`,`msSkillID`);

--
-- Index pour la table `bestiaryRanks`
--
ALTER TABLE `bestiaryRanks`
  ADD PRIMARY KEY (`rankID`);

--
-- Index pour la table `bestiarySafePlaces`
--
ALTER TABLE `bestiarySafePlaces`
  ADD PRIMARY KEY (`safePlaceID`);

--
-- Index pour la table `bestiarySkills`
--
ALTER TABLE `bestiarySkills`
  ADD PRIMARY KEY (`skillID`);

--
-- Index pour la table `bestiarySlides`
--
ALTER TABLE `bestiarySlides`
  ADD PRIMARY KEY (`slideID`,`slideMonsterID`);

--
-- Index pour la table `bestiaryTypes`
--
ALTER TABLE `bestiaryTypes`
  ADD PRIMARY KEY (`typeID`);

--
-- Index pour la table `bestiaryUsers`
--
ALTER TABLE `bestiaryUsers`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bestiaryAreas`
--
ALTER TABLE `bestiaryAreas`
  MODIFY `areaID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `bestiaryAreasHabitats`
--
ALTER TABLE `bestiaryAreasHabitats`
  MODIFY `ahID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- AUTO_INCREMENT pour la table `bestiaryAreasSafePlaces`
--
ALTER TABLE `bestiaryAreasSafePlaces`
  MODIFY `asID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT pour la table `bestiaryDangers`
--
ALTER TABLE `bestiaryDangers`
  MODIFY `dangerID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `bestiaryGlossaryWords`
--
ALTER TABLE `bestiaryGlossaryWords`
  MODIFY `glossaryWordID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `bestiaryHabitats`
--
ALTER TABLE `bestiaryHabitats`
  MODIFY `habitatID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `bestiaryMonsters`
--
ALTER TABLE `bestiaryMonsters`
  MODIFY `monsterID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT pour la table `bestiaryRanks`
--
ALTER TABLE `bestiaryRanks`
  MODIFY `rankID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=514;

--
-- AUTO_INCREMENT pour la table `bestiarySafePlaces`
--
ALTER TABLE `bestiarySafePlaces`
  MODIFY `safePlaceID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `bestiarySkills`
--
ALTER TABLE `bestiarySkills`
  MODIFY `skillID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT pour la table `bestiarySlides`
--
ALTER TABLE `bestiarySlides`
  MODIFY `slideID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `bestiaryTypes`
--
ALTER TABLE `bestiaryTypes`
  MODIFY `typeID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT pour la table `bestiaryUsers`
--
ALTER TABLE `bestiaryUsers`
  MODIFY `userID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
