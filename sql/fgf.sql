-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 27 Novembre 2013 à 18:19
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `fgf`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `desccat` varchar(255) NOT NULL,
  `typecat` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `desccat`, `typecat`) VALUES
(1, '3D', '3d', 'tous mes creations musical, composition a la guitare personnel et avec des amis.', 'project'),
(2, '2D', '2d', 'quelq jeux video a ne pas manquer pour bien faire fodrai que je mette autre chose que jeux video.', 'project'),
(3, 'Anime', 'anime', 'de merme j''aurais du changer le titre en 2d ou 3d pour etre plus en raport avec mon univaire.', 'project'),
(4, 'A Propos', 'a-propos', 'toutes nouvelles informations sur le site, ou autre', 'post'),
(5, 'Mes Liens', 'mes-liens', 'toutes les liens de mes amis et d''autre site interessant', 'post');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `created` datetime NOT NULL,
  `posts_id` int(11) DEFAULT NULL,
  `projects_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `pseudo`, `mail`, `content`, `created`, `posts_id`, `projects_id`) VALUES
(1, 'fdsfdssdf', 'fdsfdssdfdf@gmail.com', 'fdsfdsdffsd', '2013-06-16 12:22:58', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `configs`
--

CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

CREATE TABLE IF NOT EXISTS `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_medias_posts` (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- Contenu de la table `medias`
--

INSERT INTO `medias` (`id`, `name`, `file`, `post_id`, `type`) VALUES
(1, '', '2013-11/AntiLoxy_51a3b38ba95265.62198136.jpg', 1, 'img'),
(99, '', '2013-11/race-chat-siamois.jpg', 117, 'img'),
(96, '', '2013-11/ZBrush ScreenGrab02.jpg', 118, 'img'),
(97, '', '2013-11/ZBrush ScreenGrab03.jpg', 118, 'img'),
(98, '', '2013-11/2012-08-28 17.15.44.jpg', 118, 'img'),
(95, '', '2013-11/ZBrush ScreenGrab01.jpg', 118, 'img');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  `created` date DEFAULT NULL,
  `online` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_users1` (`user_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=119 ;

--
-- Contenu de la table `posts`
--

INSERT INTO `posts` (`id`, `name`, `content`, `created`, `online`, `type`, `slug`, `user_id`, `category_id`) VALUES
(2, 'A propos', '<h1>A propos</h1>\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla in accumsan justo. Integer nec urna quam. Nunc ut dui elit, eu facilisis nisl. Pellentesque varius tellus vel felis condimentum iaculis. Vestibulum ultrices turpis eu tellus eleifend scelerisque. Donec vitae odio dui, vel bibendum odio. Praesent vestibulum turpis at massa sollicitudin imperdiet. Fusce pulvinar, elit id facilisis vestibulum, urna dolor auctor lorem, non fringilla neque erat sit amet purus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur posuere magna ut eros tincidunt tristique. Praesent eros ligula, volutpat et hendrerit a, interdum ut libero. Nullam metus lacus, tincidunt egestas sagittis ut, ultricies eu tellus. Vivamus consequat lectus sed magna sodales non lobortis libero interdum.</p>\n<blockquote>\n<p>Quisque et risus purus. Integer varius, neque in egestas hendrerit, purus orci suscipit est, ac vehicula.</p>\n<small>Maitre yoda</small></blockquote>\n<ul>\n<li>Aliquam dapibus ligula at leo luctus feugiat.</li>\n<li>Etiam egestas commodo lacus, ut euismod lectus dignissim quis.</li>\n</ul>\n<ul>\n<li>Praesent sed risus a turpis vehicula lobortis.</li>\n<li>Nullam luctus ullamcorper arcu, interdum hendrerit sapien suscipit in.</li>\n<li>Phasellus adipiscing elementum ipsum, eu pharetra sapien aliquam eu.</li>\n</ul>\n<p>Nunc est risus, dapibus ut iaculis at, aliquam non libero. Curabitur ipsum elit, volutpat quis fringilla sed, aliquet sit amet est. Aenean est nulla, ullamcorper id viverra quis, vestibulum nec nisl. Maecenas eget nisi elit. Cras tempor porta sapien ut volutpat. Sed sodales tortor et nulla aliquam fermentum. Pellentesque eu quam arcu, lacinia ultricies lectus. Nunc interdum aliquam blandit.</p>\n<p>In accumsan facilisis tempus. Quisque elit nunc, cursus quis ullamcorper in, ultrices et est. Proin lectus ipsum, eleifend at iaculis quis, tincidunt vitae sem. Mauris vel est felis, ut pharetra lorem. Donec nunc magna, eleifend vitae sagittis at, blandit id elit. Mauris pellentesque ligula id dui condimentum ut gravida mi accumsan. Nullam tincidunt urna eros, et ultricies dolor. Aenean sit amet adipiscing tortor.</p>\n<p>Nam nibh nunc, cursus a blandit id, vestibulum sed lectus. Praesent quis neque ipsum. Aliquam arcu quam, condimentum quis consequat et, ultricies eget ligula. Cras sed metus laoreet orci dignissim pharetra. Suspendisse varius, mauris ut egestas placerat, nunc mauris vestibulum risus, et porttitor ante arcu sit amet lorem. Nulla laoreet urna quis augue blandit venenatis. Donec ullamcorper, augue ac vestibulum semper, lorem leo pharetra urna, nec imperdiet leo lorem sit amet dui. Pellentesque cursus nunc in lacus bibendum sit amet sagittis velit fringilla. Mauris ornare justo dui, at mattis felis. Duis orci purus, tincidunt vel eleifend sit amet, rutrum tempor massa. Praesent nec dui mauris. Sed viverra venenatis pellentesque. Phasellus sodales odio vel nunc molestie sed placerat ipsum sollicitudin. Integer quam lacus, dignissim vel vulputate vitae, aliquam quis velit.</p>', '2011-09-15', 1, 'page', 'a-propos', 0, 0),
(118, 'project demo', '<div id="lipsum">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque suscipit arcu ac ullamcorper auctor. Vivamus varius venenatis justo, non mattis mauris dictum sit amet. Curabitur molestie, leo sodales eleifend dictum, arcu dui porta metus, nec dignissim arcu leo sit amet eros. Suspendisse auctor commodo nisl, vitae mattis risus congue sed. Etiam elementum justo quis risus laoreet imperdiet. Proin sed dictum sem, ut aliquam libero. Quisque sed varius turpis, ac euismod neque. Etiam molestie auctor dui condimentum rutrum. Maecenas varius dapibus lacus ut vulputate.</p>\r\n<p>Etiam vehicula aliquet eros quis adipiscing. Maecenas euismod metus at metus mollis, sit amet tincidunt dui lobortis. Phasellus diam diam, fringilla in libero non, ultrices lobortis odio. Curabitur posuere lobortis ligula. Vivamus tempus fermentum justo, a volutpat risus dictum ac. In tristique odio consectetur nibh sodales porta. Nullam in aliquam arcu. Suspendisse et tempus eros. Curabitur eget lacinia turpis. Praesent a ante eu urna feugiat auctor. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec a blandit velit. Quisque posuere cursus eros, ut gravida dui sodales ac.</p>\r\n<p>Aliquam tincidunt laoreet arcu, a posuere orci iaculis nec. Aliquam mollis eu quam non aliquam. Fusce posuere ipsum eu dui fringilla pharetra. Donec eu nunc feugiat, feugiat lacus et, aliquam erat. Mauris id viverra mi. Morbi ac justo iaculis, sagittis nisi et, rhoncus nisl. Duis tincidunt, risus a pretium posuere, orci dolor elementum lorem, et venenatis elit erat ac mauris. Aliquam quis nulla fermentum, pellentesque libero et, convallis erat. Donec ullamcorper lobortis quam, lacinia congue libero fringilla vitae. Fusce lacus dui, vestibulum quis iaculis id, auctor non tellus. Vivamus a lectus at ipsum posuere adipiscing consectetur vitae massa.</p>\r\n<p>Etiam nec urna at orci molestie rutrum vitae quis nisi. Morbi sed semper odio. Cras consectetur porttitor justo, a cursus nisl vestibulum sit amet. Sed pharetra elit ornare, mattis diam at, gravida nunc. Nunc sem eros, sodales sed orci id, lacinia lacinia dui. Nullam fringilla magna diam, id elementum sem luctus ut. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut volutpat sapien non urna sollicitudin, nec sagittis tortor congue. Nam eleifend venenatis nulla venenatis gravida. Donec ut nisl bibendum, accumsan metus in, facilisis lorem. Nam venenatis urna a libero ultrices, id interdum enim hendrerit. In a tortor sed nunc semper porttitor. Sed tempor tortor sed urna laoreet, at adipiscing lorem lacinia. Suspendisse magna nulla, mollis ut pellentesque pretium, egestas quis massa. In at euismod tortor. Integer feugiat quam nisi, cursus eleifend augue ultricies id.</p>\r\n<p>Nam cursus ultricies erat non interdum. Proin eu massa turpis. Proin tortor enim, sodales sit amet rhoncus ut, faucibus sit amet nibh. Integer a sem vel dolor vulputate gravida eget vitae erat. Nam vehicula tincidunt diam ac scelerisque. Praesent ac mauris urna. Vestibulum quam elit, mollis vitae nisl ac, pulvinar interdum augue. Nunc augue tortor, sodales at enim sed, feugiat luctus erat. In est metus, convallis ac aliquet eget, eleifend in erat. Sed id dolor nunc. Quisque quis erat eu arcu tempus scelerisque eget eget urna.</p>\r\n</div>\r\n<div id="generated">5 paragraphes, 496 mots, 3269 caract&egrave;res de&nbsp;<a title="Lorem Ipsum" href="http://fr.lipsum.com/">Lorem Ipsum</a>&nbsp;g&eacute;n&eacute;r&eacute;</div>', '2013-10-04', 1, 'project', 'project-demo', NULL, 1),
(117, 'article demo', '<p><img style="float: right;" src="/fgf/img/2013-11/race-chat-siamois.jpg" alt="" width="629" height="470" />Voila un article de demonstration,</p>\r\n<div class="wrap2">\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>La grande porte s&rsquo;ouvrit lourdement en coulissant</li>\r\n<li>Tout les dix m&egrave;tres, une pancarte indiquait que ce</li>\r\n<li>C&rsquo;est comme &ccedil;a qu&rsquo;il se voyait &agrave; cette &eacute;poque. Un</li>\r\n<li>Comme je viens de te le dire Florence, ce n&rsquo;est</li>\r\n<li>Ca ne servira &agrave; rien, repris Pr&eacute;lude. J&rsquo;ai en</li>\r\n<li>Mais l''Intelligence Artificielle n''apportait pas</li>\r\n<li>Un long silence se fit dans la voiture. Le</li>\r\n<li>Ne t&rsquo;inqui&egrave;te pas, elle n&rsquo;a rien pour l&rsquo;instant.</li>\r\n<li>Le militaire regagna sa voiture et la barri&egrave;re</li>\r\n<li>Ne t&rsquo;inqui&egrave;te pas, elle n&rsquo;a rien pour l&rsquo;instant.</li>\r\n</ul>\r\n<div id="TheTexte" class="Texte">\r\n<p>Eux portables de une maximum.</p>\r\n</div>\r\n<p>Ce texte a &eacute;t&eacute; g&eacute;n&eacute;r&eacute; al&eacute;atoirement &agrave; partir&nbsp;<a href="http://prelude.riendetel.com/livre.php">du roman "Pr&eacute;lude" disponible ici</a>. Si vous utilisez cette partie de texte, vous devez obligatoirement sp&eacute;cifier la provenance et faire un lien vers le site de l''auteur de ce roman :&nbsp;<a href="http://prelude.riendetel.com/">F. Pr&eacute;lude</a>(http://prelude.riendetel.com)</p>\r\n<p>&nbsp;</p>\r\n<p>Le g&eacute;n&eacute;ral sorti un badge et se dirigea vers l&rsquo;une des portes entour&eacute;es de peinture jaune. Il glissa le badge dans la fente situ&eacute;e &agrave; droite. La porte s&rsquo;ouvrit. Une dizaine de militaires arm&eacute;es jusqu&rsquo;aux dents &eacute;taient post&eacute;es derri&egrave;re.</p>\r\n<p>D&rsquo;ailleurs, le Dr. Ne savait pas vraiment comment son processeur pouvait fonctionner. D&rsquo;une architecture trop complexe, le Dr. S&rsquo;&eacute;tait repos&eacute; sur les tests effectu&eacute;s. Tests tr&egrave;s l&eacute;g&egrave;rement modifi&eacute;s par Pr&eacute;lude afin de cacher certaines fonctions du processeur.</p>\r\n<p>Internet n&rsquo;est pas le seul r&eacute;seau. Il existe un autre r&eacute;seau plus performant. Je ne t&rsquo;apprendrais rien en te disant qu&rsquo;Internet a &eacute;t&eacute; cr&eacute;e par l&rsquo;arm&eacute;e Am&eacute;ricaine dans un but militaire. Internet n&rsquo;&eacute;tait que le prototype. Un autre r&eacute;seau a &eacute;t&eacute; cr&eacute;&eacute; pour les militaires. Compl&egrave;tement ind&eacute;pendant d&rsquo;Internet. Tirant des le&ccedil;ons du premier r&eacute;seau, le petit fr&egrave;re d&rsquo;Internet est devenue un grand fr&egrave;re.</p>\r\n<div class="title">&nbsp;</div>\r\n</div>', '2013-11-22', 1, 'post', 'article-demo', NULL, 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role`) VALUES
(1, 'admin', '6aca089c67356e200484fd7adfb14fdbdb152af0', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
