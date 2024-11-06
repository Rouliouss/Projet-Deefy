-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 06 nov. 2024 à 12:07
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `deefy`
--

-- --------------------------------------------------------

--
-- Structure de la table `playlist`
--

CREATE TABLE `playlist` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `playlist`
--

INSERT INTO `playlist` (`id`, `nom`) VALUES
(1, 'Best of rock'),
(2, 'Musique classique'),
(3, 'Best of country music'),
(4, 'Best of Elvis Presley');

-- --------------------------------------------------------

--
-- Structure de la table `playlist2track`
--

CREATE TABLE `playlist2track` (
  `id_pl` int(11) NOT NULL,
  `id_track` int(11) NOT NULL,
  `no_piste_dans_liste` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `playlist2track`
--

INSERT INTO `playlist2track` (`id_pl`, `id_track`, `no_piste_dans_liste`) VALUES
(1, 1, 1),
(1, 2, 2),
(2, 3, 1),
(2, 4, 2),
(3, 5, 1),
(3, 6, 2),
(4, 7, 1),
(4, 8, 2);

-- --------------------------------------------------------

--
-- Structure de la table `track`
--

CREATE TABLE `track` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `genre` varchar(30) DEFAULT NULL,
  `duree` int(3) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `artiste_album` varchar(30) DEFAULT NULL,
  `titre_album` varchar(30) DEFAULT NULL,
  `annee_album` int(4) DEFAULT NULL,
  `numero_album` int(11) DEFAULT NULL,
  `auteur_podcast` varchar(100) DEFAULT NULL,
  `date_posdcast` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `track`
--

INSERT INTO `track` (`id`, `titre`, `genre`, `duree`, `filename`, `type`, `artiste_album`, `titre_album`, `annee_album`, `numero_album`, `auteur_podcast`, `date_posdcast`) VALUES
(1, 'Wish You Were Here', 'rock', 334, 'pink_wish.mp3', 'A', 'Pink Floyd', 'Wish You Were Here', 1975, 1, NULL, NULL),
(2, 'Samba Pati', 'rock', 300, 'santana_abra.mp3', 'A', 'Santana', 'Abraxas', 1970, 1, NULL, NULL),
(3, 'Danube Bleu', 'musique classique', 300, 'straus_danube.mp3', 'A', 'Johann Strauss', 'Valses', 2000, 1, NULL, NULL),
(4, 'Lettre à Elise', 'musique classique', 400, 'beethoven_elise.mp3', 'A', 'Beethoven', 'Piano', 1966, 1, NULL, NULL),
(5, 'Annie song', 'country', 200, 'denver_annie.mp3', 'A', 'John Denver', 'Best of J. Denver', 2001, 1, NULL, NULL),
(6, 'Tequila sunrise', 'country', 300, 'eagles_teq.mp3', 'A', 'Eagles', 'Best of Eagles', 2007, 1, NULL, NULL),
(7, 'In the ghetto', 'country', 200, 'elvis_annie.mp3', 'A', 'Elvis Presley', 'Best of E. Presley', 2002, 1, NULL, NULL),
(8, 'La vie des papillons', 'docu', 200, 'papillons.mp3', 'P', NULL, NULL, NULL, NULL, 'Bolo', '2004-10-12'),
(9, 'La vie des libellules', 'docu', 200, 'libellules.mp3', 'P', NULL, NULL, NULL, NULL, 'Bolo', '2004-10-12');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `passwd` varchar(256) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `passwd`, `role`) VALUES
(1, 'user1@mail.com', '$2y$12$e9DCiDKOGpVs9s.9u2ENEOiq7wGvx7sngyhPvKXo2mUbI3ulGWOdC', 1),
(2, 'user2@mail.com', '$2y$12$4EuAiwZCaMouBpquSVoiaOnQTQTconCP9rEev6DMiugDmqivxJ3AG', 1),
(3, 'user3@mail.com', '$2y$12$5dDqgRbmCN35XzhniJPJ1ejM5GIpBMzRizP730IDEHsSNAu24850S', 1),
(4, 'user4@mail.com', '$2y$12$ltC0A0zZkD87pZ8K0e6TYOJPJeN/GcTSkUbpqq0kBvx6XdpFqzzqq', 1),
(5, 'admin@mail.com', '$2y$12$JtV1W6MOy/kGILbNwGR2lOqBn8PAO3Z6MupGhXpmkeCXUPQ/wzD8a', 100),
(6, 'test@test.com', '$2y$10$fvT0j9Kid4ff/swUuqdJqOI8gBDVL4e.blMIhvAtlXi3izRJvvrJS', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user2playlist`
--

CREATE TABLE `user2playlist` (
  `id_user` int(11) NOT NULL,
  `id_pl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `user2playlist`
--

INSERT INTO `user2playlist` (`id_user`, `id_pl`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `playlist2track`
--
ALTER TABLE `playlist2track`
  ADD PRIMARY KEY (`id_pl`,`id_track`),
  ADD KEY `id_track` (`id_track`);

--
-- Index pour la table `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user2playlist`
--
ALTER TABLE `user2playlist`
  ADD PRIMARY KEY (`id_user`,`id_pl`),
  ADD KEY `id_pl` (`id_pl`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `track`
--
ALTER TABLE `track`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `playlist2track`
--
ALTER TABLE `playlist2track`
  ADD CONSTRAINT `playlist2track_ibfk_1` FOREIGN KEY (`id_pl`) REFERENCES `playlist` (`id`),
  ADD CONSTRAINT `playlist2track_ibfk_2` FOREIGN KEY (`id_track`) REFERENCES `track` (`id`);

--
-- Contraintes pour la table `user2playlist`
--
ALTER TABLE `user2playlist`
  ADD CONSTRAINT `user2playlist_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user2playlist_ibfk_2` FOREIGN KEY (`id_pl`) REFERENCES `playlist` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
