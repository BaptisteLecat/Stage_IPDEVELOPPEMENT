-- phpMyAdmin SQL Dump
-- version 4.6.6deb4+deb9u2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Jeu 18 Février 2021 à 14:52
-- Version du serveur :  10.1.47-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-37+0~20201103.43+debian9~1.gbp25a3d7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `doli-dev01`
--

-- --------------------------------------------------------

--
-- Structure de la table `llx_dns_fields`
--

CREATE TABLE `llx_dns_fields` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `regex` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `llx_dns_mx`
--

CREATE TABLE `llx_dns_mx` (
  `id` int(11) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `llx_dns_records`
--

CREATE TABLE `llx_dns_records` (
  `id` int(11) NOT NULL,
  `subDomain` varchar(255) NOT NULL,
  `target` text NOT NULL,
  `deleted_on` timestamp NULL DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `domain_id` int(11) NOT NULL,
  `dns_field_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `llx_dns_standard`
--

CREATE TABLE `llx_dns_standard` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `llx_domaines`
--

CREATE TABLE `llx_domaines` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `server_dns` varchar(255) NOT NULL,
  `manage_dns` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_on` datetime DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `llx_dns_fields`
--
ALTER TABLE `llx_dns_fields`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `llx_dns_mx`
--
ALTER TABLE `llx_dns_mx`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `llx_dns_records`
--
ALTER TABLE `llx_dns_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `constraint_domainId` (`domain_id`),
  ADD KEY `constraint_champDNSId` (`dns_field_id`);

--
-- Index pour la table `llx_dns_standard`
--
ALTER TABLE `llx_dns_standard`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `llx_domaines`
--
ALTER TABLE `llx_domaines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `constraint_clientId` (`client_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `llx_dns_fields`
--
ALTER TABLE `llx_dns_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `llx_dns_mx`
--
ALTER TABLE `llx_dns_mx`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `llx_dns_records`
--
ALTER TABLE `llx_dns_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `llx_dns_standard`
--
ALTER TABLE `llx_dns_standard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `llx_domaines`
--
ALTER TABLE `llx_domaines`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `llx_dns_mx`
--
ALTER TABLE `llx_dns_mx`
  ADD CONSTRAINT `heritage_DNSMX` FOREIGN KEY (`id`) REFERENCES `llx_dns_records` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `llx_dns_records`
--
ALTER TABLE `llx_dns_records`
  ADD CONSTRAINT `constraint_champDNSId` FOREIGN KEY (`dns_field_id`) REFERENCES `llx_dns_fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_domainId` FOREIGN KEY (`domain_id`) REFERENCES `llx_domaines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `llx_dns_standard`
--
ALTER TABLE `llx_dns_standard`
  ADD CONSTRAINT `heritage_DNSSTANDARD` FOREIGN KEY (`id`) REFERENCES `llx_dns_records` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `llx_domaines`
--
ALTER TABLE `llx_domaines`
  ADD CONSTRAINT `constraint_clientId` FOREIGN KEY (`client_id`) REFERENCES `llx_societe` (`rowid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
