-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:33060
-- Généré le : ven. 16 avr. 2021 à 15:44
-- Version du serveur :  5.7.29-0ubuntu0.18.04.1
-- Version de PHP : 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `snowtricks`
--

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `trick_id`, `content`, `date_comment`) VALUES
(17, 8, 20, 'Super Trick, accessible aux débutants', '2021-04-16 14:59:57'),
(18, 11, 20, 'C\'est vrai ! Je l\'ai passé à mes débuts', '2021-04-16 14:59:57'),
(19, 12, 20, 'Cool, ca me rassure !', '2021-04-16 15:02:46'),
(20, 8, 20, 'Pas de problème manon ! fais partager tes vidéos d\'essais', '2021-04-16 15:02:46'),
(23, 12, 20, 'oui je vais essayer, peut être que vous avez d\'autres astuces à partager ?', '2021-04-16 15:05:33'),
(24, 11, 20, 'Au début n\'essaye de faire le geste à la perfection, essaye de prendre de la hauteur et de visualiser ton atterrissage.', '2021-04-16 15:05:33'),
(25, 8, 20, 'Bon conseil Louis, essaye de sauter haut oui pour avoir le temps de faire le trick complet.', '2021-04-16 15:07:39'),
(26, 10, 20, 'Salut à tous ! ', '2021-04-16 15:07:39'),
(27, 8, 20, 'Salut Max, bienvenue à toi :D', '2021-04-16 15:08:36'),
(28, 10, 20, 'Merci je suis content de pouvoir partager ma passion avec vous', '2021-04-16 15:08:36'),
(29, 12, 20, 'Bienvenue Max !!!!!!!', '2021-04-16 15:10:38'),
(30, 11, 20, 'Manon pour débuter, je peux aussi te conseiller de t\'initier au 360 front', '2021-04-16 15:10:38');

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201103162902', '2020-11-03 16:31:17', 646),
('DoctrineMigrations\\Version20201105145745', '2020-11-05 14:58:07', 302),
('DoctrineMigrations\\Version20201117151924', '2020-11-17 15:20:01', 2047),
('DoctrineMigrations\\Version20201120152224', '2020-11-20 15:22:52', 2160),
('DoctrineMigrations\\Version20201125141630', '2020-11-25 14:16:58', 3254),
('DoctrineMigrations\\Version20201208135618', '2020-12-08 13:56:47', 2498),
('DoctrineMigrations\\Version20201214103104', '2020-12-14 13:37:45', 641),
('DoctrineMigrations\\Version20201214133734', '2020-12-14 13:50:39', 503),
('DoctrineMigrations\\Version20201214135624', '2020-12-14 13:57:40', 546),
('DoctrineMigrations\\Version20210317141050', '2021-03-17 14:11:16', 2025),
('DoctrineMigrations\\Version20210412084040', '2021-04-12 08:41:13', 1814),
('DoctrineMigrations\\Version20210414124907', '2021-04-14 12:49:25', 1271);

--
-- Déchargement des données de la table `group`
--

INSERT INTO `group` (`id`, `name`, `label`) VALUES
(1, 'grabs', 'Grabs'),
(2, 'rotations', 'Rotations'),
(3, 'flips', 'Flips'),
(4, 'rotations_desaxes', 'Rotations désaxées'),
(5, 'slides', 'Slides'),
(6, 'one_foot_tricks', 'One foot trick'),
(7, 'old_school', 'Old school');

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`id`, `trick_id_id`, `path`) VALUES
(6, 3, '6.jpg'),
(21, 2, 'wpid-how-to-frontside-360-snowboard-8001-60744fe43113f.jpeg'),
(22, 2, 'telechargement-60744ffb006da.jpeg'),
(23, 1, 'telechargement-1-6074507e1e1c4.jpeg'),
(24, 1, 'telechargement-2-60745091abed9.jpeg'),
(43, 20, 'shifty-6079512543273.jpeg'),
(44, 20, 'shifty2-60795138dbd0c.jpeg'),
(45, 19, '50501-60795255bbdf3.jpeg'),
(46, 18, 'methodair1-607954edd4236.jpeg'),
(47, 18, 'methodair2-607954fb79dca.jpeg'),
(48, 18, 'methodair4-6079550bf0346.jpeg'),
(49, 17, 'frontflip-607957cbac792.jpeg'),
(50, 17, 'frontflip2-607957da18df8.jpeg'),
(51, 16, 'lipslide-60795880ce10c.jpeg'),
(52, 16, 'lipslide2-6079589143eb0.jpeg'),
(53, 15, 'one-foot-trick-3-60795926d52c1.jpeg'),
(54, 15, 'onefoot-607959420246c.jpeg'),
(55, 14, 'noseslide-607959df45c7d.jpeg'),
(56, 14, 'noseslide-1-60795a21eefb4.jpeg'),
(57, 13, 'cork2-60795aafb4f79.png'),
(58, 13, 'cork-60795abeec174.jpeg'),
(59, 12, 'mctwist-60795b37bd32a.jpeg'),
(60, 12, 'mctwist2-60795b48b4f82.jpeg');

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `name`, `description`, `user_id_id`, `group_id_id`, `created_at`, `updated_at`) VALUES
(1, 'Japan Air', 'La main avant vient attraper la planche entre les deux fixations. Les genoux sont pliés et le corps s\'étire vers le haut.', 6, 1, '2021-04-12 11:03:47', NULL),
(2, '360 Front', 'Le 3.6 front ou 360 front est un tricks intéressant car on peut y mettre facilement beaucoup de style. C’est une rotation de 360 degrés du côté frontside ( à gauche pour les regular et à droite pour les goofy).', 6, 2, '2021-04-12 12:03:57', NULL),
(3, 'Nosegrab', 'Le but est d\'attraper l\'avant de votre planche avec la main avant. Pour monter le plus haut l\'avant, il suffit de tendre la jambe arrière et lever le genou avant.', 6, 1, '2021-04-13 11:04:06', NULL),
(12, 'Mc Twist', 'Le McTwist, créé par le rider Mike McGill, est venu et reparti alors que les tendances des figures de snow battent au rythme du sport. La version classique est essentiellement un arrière inversé 540 hors du mur. Comme beaucoup d\'autres tricks hors axe, il existe de nombreuses versions différentes suivant le rider.', 8, 3, '2021-04-13 11:04:12', '2021-04-16 09:38:26'),
(13, 'Cork', 'Le cork un flip hors axe lancé en arrière avec un spin (le plus souvent 540 ° ou «Rodeo 5»). «Corkscrew» ou «Cork»: Le skieur effectue une rotation horizontale distincte hors axe ou inversée. À aucun moment, les pieds du skieur ne doivent être au-dessus de sa tête. Double Cork ou «Dub Cork»: Le skieur effectue deux rotations hors axe distinctes.', 8, 4, '2021-04-13 11:04:19', '2021-04-16 09:36:06'),
(14, 'Nose slide', 'Le nose slide est comme son nom l\'indique le fait de \"slider\" sur l\'avant de la planche.', 8, 5, '2021-04-12 11:04:25', '2021-04-16 09:32:04'),
(15, 'One foot indy', 'Le one foot trick est un trick très dangereux, il s\'agit de détacher un pied et de tendre la jambe en arrière.', 8, 6, '2021-04-12 11:04:29', '2021-04-16 09:29:26'),
(16, 'Lipslide', 'Un slide effectué où le pied arrière du rider passe au-dessus du rail à l\'approche, avec son snowboard se déplaçant perpendiculairement le long du rail ou d\'un autre obstacle.  Lors de l\'exécution d\'un lipslide frontside, le snowboardeur fait face à la descente. Lors de l\'exécution d\'un lipslide arrière, un snowboardeur fait face à une montée.', 8, 5, '2021-04-13 11:04:34', '2021-04-16 09:26:41'),
(17, 'Front flip', 'salto avant sur un saut.', 8, 3, '2021-04-13 11:04:41', '2021-04-16 09:23:07'),
(18, 'Method air', 'Un trick fondamental effectué en pliant les genoux pour soulever la planche derrière le dos du rider et en saisissant le bord du talon du snowboard avec la main directrice.', 8, 1, '2021-04-13 11:04:45', '2021-04-16 09:06:41'),
(19, '50-50', 'Un slide dans lequel un rider glisse tout droit le long d\'un rail ou d\'un autre obstacle. Cette astuce a son origine dans le skateboard, où l\'astuce est exécutée avec les deux \"trucks\" du skateboard grinçant le long d\'un rail.', 8, 5, '2021-04-13 11:04:49', '2021-04-16 08:59:37'),
(20, 'Shifty', 'Un trick aérien dans lequel un snowboardeur se tord le corps, fait pivoter sa planche de 90 ° puis la ramène à sa position d\'origine avant l\'atterrissage. Cette astuce peut être exécutée avant ou arrière, et également en variation avec d\'autres astuces et pirouettes.', 8, 2, '2021-04-13 15:02:24', '2021-04-16 08:54:35');

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `status`, `hash`, `hash_pass`) VALUES
(1, 'lucile@test.com', '[]', 'lucile', 'lucile', 0, '', NULL),
(2, 'lulu@test.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$iKJ8JAIdjzJg9JBICD0f/w$LwZrnO/kcpe8HrDglzxSOgvmDKRpDgOloX49Lx8LxOs', 'lucile', 0, '', NULL),
(3, 'lima@fox.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$vZJ2UkUb/+zgVHx5yXVUhg$u4wMW+mxnE5VA4f8NgzrUQ6b8Pu5FVUIWbuiPcdmORY', 'lima fox', 1, '', NULL),
(4, 'vik@test.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$4yPkw8edGH3HxMxNmO0C0A$AJDdnj02hnqePMoEw8yLz/p4dPDXObTLMnfRpxsjzvY', 'vicky', 0, 'a9a1d5317a33ae8cef33961c34144f84', NULL),
(5, 'vik@vik.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$lwIsWnVBihSbyNNdHHXjQQ$WpOOYDoiKX+4IdNNjWgMgPoMDyvlpeWckSs9/kkeh8Y', 'vicky', 1, '8eefcfdf5990e441f0fb6f3fad709e21', NULL),
(6, 'lulu@lulu.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$2TggeuAh90/XvSXqCnLVeQ$Wf3UHEgcD5THO3G4BGYOtdOHG1Y0++Q08m2FFoieJ/c', 'lulu', 1, '621bf66ddb7c962aa0d22ac97d69b793', NULL),
(7, 'juju@test.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$o856gzvupF82Ah+1R7OFlQ$821ALSwQbYu3jrduU4MOwJMDVLn5fjxEWoXd6Kcfys8', 'juju', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01', NULL),
(8, 'limax@test.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$Cl9UjP1GUssVkbf0JBvoUg$w5tNRY6yPJuVb/jww1c8kxFKoZ3hQLzyS+dnM/JKPfI', 'limax', 1, 'e995f98d56967d946471af29d7bf99f1', '109a0ca3bc27f3e96597370d5c8cf03d'),
(9, 'lili@test.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$XBrhy8Y+rBaBzfQNjhP+IQ$UGtMq4+QupavRqHZWKTPzYPz9C7+6YFgm/Q2xrAkcGc', 'lili', 0, 'f033ab37c30201f73f142449d037028d', NULL),
(10, 'max@test.com', '[]', 'max123', 'Max', 1, 'fffffffffffffffffffffffffffffffffffffffffffffffffffff', NULL),
(11, 'Louis', '[]', 'louis123', 'Louis P.', 1, 'dddddddddddddddddddddddddddddddddddddd', NULL),
(12, 'manon@test.com', '[]', 'manon123', 'Manon la rideuse', 1, 'ssssssssssssssssssssssssssssssssssssssssssssss', NULL);

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `trick_id_id`, `link`) VALUES
(3, 12, 'https://www.youtube.com/embed/M0F8IcS0ssc'),
(4, 13, 'https://www.youtube.com/embed/qqNV0tI3Z4k'),
(5, 14, 'https://www.youtube.com/embed/5q2ivIXJx3U'),
(6, 15, 'https://www.youtube.com/embed/LWUfrwCofuA'),
(7, 17, 'https://www.youtube.com/embed/gMfmjr-kuOg'),
(8, 19, 'https://www.youtube.com/embed/e-7NgSu9SXg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
