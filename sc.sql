-- phpMyAdmin SQL Dump
-- version 3.1.4
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 18 Mai 2009 à 04:36
-- Version du serveur: 5.1.32
-- Version de PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `immo`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnements`
--

CREATE TABLE IF NOT EXISTS `abonnements` (
  `id_abonnement` int(11) NOT NULL AUTO_INCREMENT,
  `email_user` varchar(62) DEFAULT NULL,
  `nbr_jours` int(11) DEFAULT NULL,
  `prix` double(15,2) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT NULL,
  `date_abonnement` datetime NOT NULL,
  PRIMARY KEY (`id_abonnement`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `abonnements`
--

INSERT INTO `abonnements` (`id_abonnement`, `email_user`, `nbr_jours`, `prix`, `statut`, `date_abonnement`) VALUES
(1, 'ouardisoft@live.fr', 1, 3.00, 1, '2009-05-12 01:56:11'),
(2, 'ouardisoft@live.fr', 1, 1.00, 1, '2009-05-10 03:57:55');

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

CREATE TABLE IF NOT EXISTS `annonces` (
  `id_annonce` int(11) NOT NULL AUTO_INCREMENT,
  `id_type_bien` int(11) NOT NULL,
  `id_cat_bien` int(11) NOT NULL,
  `email_user` varchar(62) NOT NULL,
  `nbr_pieces` int(11) DEFAULT NULL,
  `surface` varchar(10) DEFAULT NULL,
  `prix` decimal(15,2) DEFAULT NULL,
  `adresse_bien` varchar(100) DEFAULT NULL,
  `cp_bien` varchar(60) DEFAULT NULL,
  `ville_bien` varchar(60) DEFAULT NULL,
  `pays_bien` varchar(60) DEFAULT NULL,
  `tel_contact` varchar(32) DEFAULT NULL,
  `email_contact` varchar(62) DEFAULT NULL,
  `titre_annonce` text,
  `contenu_annonce` text,
  `date_insertion_annonce` datetime NOT NULL,
  `date_modif_annonce` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_annonce`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `annonces`
--

INSERT INTO `annonces` (`id_annonce`, `id_type_bien`, `id_cat_bien`, `email_user`, `nbr_pieces`, `surface`, `prix`, `adresse_bien`, `cp_bien`, `ville_bien`, `pays_bien`, `tel_contact`, `email_contact`, `titre_annonce`, `contenu_annonce`, `date_insertion_annonce`, `date_modif_annonce`, `active`) VALUES
(3, 2, 2, 'ouardisoft@live.fr', 0, '', 0.00, '', '', 'kénitra', 'MA', '', '', 'villa à eljadida à louer', 'villa villa villa à ''c''', '2009-04-12 19:24:17', '2009-05-15 21:34:18', 0),
(7, 1, 1, 'ouardisoft@live.fr', 3, '100', 100000.00, 'bloc m oule doujis', '14000', 'kenitra', 'MA', '', '', 'villa gh', 'uhaakjh kjha', '2009-04-14 19:52:14', '2009-04-16 05:25:55', 1),
(9, 1, 1, 'ouardisoft@live.fr', 0, '', 0.00, '', '', 'eljadida', '', '', '', 'app à  eljadida', 'c''est moi', '2009-04-17 15:34:26', '2009-05-15 21:35:25', 0),
(10, 8, 1, 'ouardisoft@live.fr', 4, '1000', 600000.00, 'blc mlkj kjlh', '24000', 'eljadida', 'MA', '09999999', 'ouardisoft@yahoo.fr', 'maison à vendre', 'dkjlz dklzhj dkjlzdl edj', '2009-04-19 18:32:36', '2009-05-15 21:35:46', 0);

-- --------------------------------------------------------

--
-- Structure de la table `categories_bien`
--

CREATE TABLE IF NOT EXISTS `categories_bien` (
  `id_cat_bien` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_cat_bien` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_cat_bien`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `categories_bien`
--

INSERT INTO `categories_bien` (`id_cat_bien`, `libelle_cat_bien`) VALUES
(1, 'Achat'),
(2, 'Location'),
(3, 'Location de vacances');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `email_user` varchar(62) NOT NULL,
  `psw_user` varchar(42) DEFAULT NULL,
  `nom_client` varchar(32) DEFAULT NULL,
  `prenom_client` varchar(32) DEFAULT NULL,
  `cp_client` varchar(60) DEFAULT NULL,
  `adresse_client` varchar(100) DEFAULT NULL,
  `ville_client` varchar(60) DEFAULT NULL,
  `pays_client` varchar(60) DEFAULT NULL,
  `tel_client` varchar(32) DEFAULT NULL,
  `fax_client` varchar(32) DEFAULT NULL,
  `profession_client` varchar(62) DEFAULT NULL,
  `date_insc_client` date DEFAULT NULL,
  PRIMARY KEY (`email_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`email_user`, `psw_user`, `nom_client`, `prenom_client`, `cp_client`, `adresse_client`, `ville_client`, `pays_client`, `tel_client`, `fax_client`, `profession_client`, `date_insc_client`) VALUES
('elasri_hajar@hotmail.com', 'testpsw', 'hajar', 'elasri', '24', 'oum rabii ', 'el jadida', 'MA', '0611 33 98 64', NULL, NULL, '2009-04-11'),
('ouardi1984@yahoo.fr', '01034819', 'abdou', 'ouardi', '14000', 'bloc m iur', 'kenitra', 'MA', '09238938393', NULL, NULL, '2009-04-11'),
('ouardisoft@live.fr', 'ouardisoft', 'lll', '', '19000', '', '', 'MA', '', NULL, NULL, '2009-04-11'),
('hajardba@yahoo.fr', 'hajardba', 'jiji', 'elasri', '23333', 'adresse ', 'kenitra', 'MA', '0333332222', NULL, NULL, '2009-04-14'),
('ouardisoft@yahoo.fr', 'llllll', 'Louardi', 'Abdeltif', '14000', 'Bloc m ouled oujih', 'Kénitra', 'MA', '192029292', NULL, NULL, '2009-04-14'),
('ouar@sss.fr', 'ouardi', 'abdou', 'ouardi', '14000', 'aanfdpo fi ofiu ', 'kenitra', 'MA', '12020020202', NULL, NULL, '2009-04-14'),
('sdggdfg@frfr.fr', 'aaaaaa', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('aaaa@aaa.fr', 'aaaaaa', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('aaaa@eeee.fr', 'pppppp', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('dddd@ddd.fr', 'dddddd', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('dddd@ddddd.fr', 'dddddd', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('dddd@dddddd.fr', 'dddddd', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('ouardi@eeee.fr', 'pppppp', '', '', '', '', '', 'MA', '01010101010', NULL, NULL, '2009-04-14'),
('ouardi@eeree.fr', 'pppppp', '', '', '', '', '', 'MA', '01010101010', NULL, NULL, '2009-04-14'),
('rrrrr@rrrr.gt', 'mmmmmm', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('ffff@fff.fr', 'pppppp', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('ffff@ffff.fr', 'pppppp', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('ffff@rrr.fr', 'mmmmmm', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('aaa@aaaa.fr', 'aaaaaa', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('aaa@rrff.fr', 'dddddd', '', '', '', '', '', 'MA', '', NULL, NULL, '2009-04-14'),
('jiji@jiji.com', 'jijikoko', 'hug', 'lllljjj', '222', 'lllpljg', 'nbjhgyf', 'MA', '999999999999', NULL, NULL, '2009-04-14');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `idC` tinyint(4) NOT NULL AUTO_INCREMENT,
  `emailC` varchar(62) NOT NULL,
  `sujetC` varchar(100) NOT NULL,
  `textC` text NOT NULL,
  `dateC` datetime NOT NULL,
  `contactProbleme` varchar(50) NOT NULL,
  PRIMARY KEY (`idC`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `contact`
--

-- --------------------------------------------------------

--
-- Structure de la table `erreur`
--

CREATE TABLE IF NOT EXISTS `erreur` (
  `id_erreur` int(11) NOT NULL AUTO_INCREMENT,
  `erreur` text NOT NULL,
  `date_erreur` datetime NOT NULL,
  PRIMARY KEY (`id_erreur`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `erreur`
--

INSERT INTO `erreur` (`id_erreur`, `erreur`, `date_erreur`) VALUES
(1, 'paymentPending<br />', '2009-05-13 01:20:07'),
(2, 'paymentPending<br />', '2009-05-13 01:34:30');

-- --------------------------------------------------------

--
-- Structure de la table `images_bien`
--

CREATE TABLE IF NOT EXISTS `images_bien` (
  `id_image` int(11) NOT NULL AUTO_INCREMENT,
  `id_annonce` int(11) NOT NULL,
  `nom_image` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_image`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Contenu de la table `images_bien`
--

INSERT INTO `images_bien` (`id_image`, `id_annonce`, `nom_image`) VALUES
(36, 10, '102.png'),
(31, 6, '61.png'),
(24, 9, '93.jpg'),
(38, 2, '22.JPG'),
(8, 4, '41.JPG'),
(33, 9, '92.png'),
(35, 10, '101.png'),
(14, 6, '61.JPG'),
(34, 3, '31.png'),
(39, 2, '23.JPG'),
(40, 2, '24.JPG');

-- --------------------------------------------------------

--
-- Structure de la table `possede_prop_bien`
--

CREATE TABLE IF NOT EXISTS `possede_prop_bien` (
  `id_annonce` int(11) NOT NULL,
  `id_propriete` int(11) NOT NULL,
  PRIMARY KEY (`id_annonce`,`id_propriete`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `possede_prop_bien`
--

INSERT INTO `possede_prop_bien` (`id_annonce`, `id_propriete`) VALUES
(9, 1),
(9, 2),
(10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `proprietes_bien`
--

CREATE TABLE IF NOT EXISTS `proprietes_bien` (
  `id_propriete` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_propriete` varchar(30) DEFAULT NULL,
  `statut_propriete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_propriete`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `proprietes_bien`
--

INSERT INTO `proprietes_bien` (`id_propriete`, `libelle_propriete`, `statut_propriete`) VALUES
(1, 'Garage', 0),
(2, 'Terasse', 0),
(3, 'Bien neuf', 0),
(4, 'Parking', 0),
(5, 'Bien meublé', 0),
(6, 'Balcon', 0);

-- --------------------------------------------------------

--
-- Structure de la table `types_bien`
--

CREATE TABLE IF NOT EXISTS `types_bien` (
  `id_type_bien` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_type_bien` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id_type_bien`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `types_bien`
--

INSERT INTO `types_bien` (`id_type_bien`, `libelle_type_bien`) VALUES
(1, 'Appartement'),
(2, 'Villa'),
(3, 'Maison'),
(4, 'Immeuble'),
(5, 'Terrain'),
(6, 'Propriétés Agricoles'),
(7, 'Parking'),
(8, 'Résidence avec services'),
(9, 'Fermette'),
(10, 'Bungalow'),
(11, 'Châlet'),
(12, 'Magazin'),
(13, 'Local Commercial'),
(14, 'Garage'),
(15, 'Boutique'),
(16, 'Fond Commercial');

