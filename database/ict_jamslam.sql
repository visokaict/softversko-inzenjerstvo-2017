-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2018 at 05:35 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ict_jamslam`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `idComment` int(32) NOT NULL,
  `text` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idUserCreator` int(32) NOT NULL,
  `createdAt` int(15) NOT NULL,
  `editedAt` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `downloadfiles`
--

CREATE TABLE `downloadfiles` (
  `idDownloadFile` int(32) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamebadges`
--

CREATE TABLE `gamebadges` (
  `idGameBadges` int(32) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idImage` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamecategories`
--

CREATE TABLE `gamecategories` (
  `idGameCategory` int(32) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamecriteries`
--

CREATE TABLE `gamecriteries` (
  `idGameCriteria` int(32) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamejams`
--

CREATE TABLE `gamejams` (
  `idGameJam` int(32) NOT NULL,
  `title` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idCoverImage` int(32) NOT NULL,
  `startDate` int(15) NOT NULL,
  `endDate` int(15) NOT NULL,
  `votingEndDate` int(15) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lockSubmissionAfterSubmitting` int(1) NOT NULL,
  `othersCanVote` int(1) NOT NULL,
  `isBlocked` int(1) NOT NULL,
  `idUserCreator` int(32) NOT NULL,
  `numOfViews` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamejams_criterias`
--

CREATE TABLE `gamejams_criterias` (
  `idGameJamCriteria` int(32) NOT NULL,
  `idGameJam` int(32) NOT NULL,
  `idCriteria` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamejams_participants`
--

CREATE TABLE `gamejams_participants` (
  `idGameJamParticipant` int(32) NOT NULL,
  `idUser` int(32) NOT NULL,
  `idGameJam` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamesubmissions`
--

CREATE TABLE `gamesubmissions` (
  `idGameSubmission` int(32) NOT NULL,
  `idGameJam` int(32) NOT NULL,
  `idTeaserImage` int(32) NOT NULL,
  `idCoverImage` int(32) NOT NULL,
  `idUserCreator` int(32) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` int(15) NOT NULL,
  `editedAt` int(15) NOT NULL,
  `numOfViews` int(64) NOT NULL,
  `numOfDownloads` int(64) NOT NULL,
  `isBlocked` int(1) NOT NULL,
  `numberOfVotes` int(64) NOT NULL,
  `sumOfVotes` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamesubmissions_badges`
--

CREATE TABLE `gamesubmissions_badges` (
  `idGameSubmissionsBadge` int(32) NOT NULL,
  `idGameSubmission` int(32) NOT NULL,
  `idBadge` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamesubmissions_categories`
--

CREATE TABLE `gamesubmissions_categories` (
  `idGameSubmissionCategory` int(32) NOT NULL,
  `idGameSubmission` int(32) NOT NULL,
  `idCategory` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamesubmissions_comments`
--

CREATE TABLE `gamesubmissions_comments` (
  `idGameSubmissionComment` int(32) NOT NULL,
  `idGameSubmission` int(32) NOT NULL,
  `idComment` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamesubmissions_downloadfiles`
--

CREATE TABLE `gamesubmissions_downloadfiles` (
  `idGameSubmissionDownloadFile` int(32) NOT NULL,
  `idGameSubmission` int(32) NOT NULL,
  `idDownloadFile` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamesubmissions_reports`
--

CREATE TABLE `gamesubmissions_reports` (
  `idGameSubmissionReport` int(32) NOT NULL,
  `idGameSubmission` int(32) NOT NULL,
  `idReport` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamesubmissions_screenshots`
--

CREATE TABLE `gamesubmissions_screenshots` (
  `idGameSubmissionScreenShot` int(32) NOT NULL,
  `idGameSubmission` int(32) NOT NULL,
  `idImage` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamesubmissions_votes`
--

CREATE TABLE `gamesubmissions_votes` (
  `idGameSubmissionVote` int(32) NOT NULL,
  `idUserVoter` int(32) NOT NULL,
  `rating` int(6) NOT NULL,
  `idGameSubmission` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `imagecategories`
--

CREATE TABLE `imagecategories` (
  `idImageCategory` int(32) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `idImage` int(32) NOT NULL,
  `idImageCategory` int(32) NOT NULL,
  `alt` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pollanswers`
--

CREATE TABLE `pollanswers` (
  `idPollAnswer` int(32) NOT NULL,
  `text` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idPollQuestion` int(32) NOT NULL,
  `numberOfVotes` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pollquestions`
--

CREATE TABLE `pollquestions` (
  `idPollQuestion` int(32) NOT NULL,
  `text` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pollvotes`
--

CREATE TABLE `pollvotes` (
  `idPollVotes` int(32) NOT NULL,
  `idUserVoter` int(32) NOT NULL,
  `idPollAnswer` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `idReport` int(32) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idUserCreator` int(32) NOT NULL,
  `createdAt` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `idRole` int(32) NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isAvailableForUser` int(1) NOT NULL DEFAULT '1',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`idRole`, `name`, `text`, `isAvailableForUser`, `description`) VALUES
(1, 'admin', 'Administrator', 0, 'User with this role can manage everyting on website.'),
(2, 'jamMaker', 'Jam Maker', 1, 'User with this role can Host game jams.'),
(3, 'jamDeveloper', 'Jam Developer', 1, 'User with this role can create Game submission.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUser` int(32) NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` int(15) NOT NULL,
  `updatedAt` int(15) NOT NULL,
  `avatarImagePath` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isBanned` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `email`, `username`, `password`, `createdAt`, `updatedAt`, `avatarImagePath`, `isBanned`) VALUES
(1, 'goran@gmail.com', 'goran', '336eaae94eec2c96eebec51af6f1a7fd', 1527343576, 1527343576, 'https://api.adorable.io/avatars/285/goran@gmail.com', 0),
(2, 'nikola@gmail.com', 'nikola', '5f4dcc3b5aa765d61d8327deb882cf99', 1527343576, 1527343576, 'https://api.adorable.io/avatars/285/nikola@gmail.com', 0),
(3, 'test1@gmail.com', 'test1', 'cc03e747a6afbbcbf8be7668acfebee5', 1527348467, 1527348467, 'https://api.adorable.io/avatars/285/test1@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `idUserRoles` int(32) NOT NULL,
  `idUser` int(32) NOT NULL,
  `idRole` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`idUserRoles`, `idUser`, `idRole`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 1),
(5, 2, 2),
(6, 2, 3),
(7, 3, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`idComment`);

--
-- Indexes for table `downloadfiles`
--
ALTER TABLE `downloadfiles`
  ADD PRIMARY KEY (`idDownloadFile`);

--
-- Indexes for table `gamebadges`
--
ALTER TABLE `gamebadges`
  ADD PRIMARY KEY (`idGameBadges`),
  ADD KEY `fk_gamebages_images` (`idImage`);

--
-- Indexes for table `gamecategories`
--
ALTER TABLE `gamecategories`
  ADD PRIMARY KEY (`idGameCategory`);

--
-- Indexes for table `gamecriteries`
--
ALTER TABLE `gamecriteries`
  ADD PRIMARY KEY (`idGameCriteria`);

--
-- Indexes for table `gamejams`
--
ALTER TABLE `gamejams`
  ADD PRIMARY KEY (`idGameJam`),
  ADD KEY `fk_gamejams_coverimage` (`idCoverImage`),
  ADD KEY `fk_gamejams_usercreator` (`idUserCreator`);

--
-- Indexes for table `gamejams_criterias`
--
ALTER TABLE `gamejams_criterias`
  ADD PRIMARY KEY (`idGameJamCriteria`),
  ADD KEY `fk_gamejamcriteria_gamejam` (`idGameJam`),
  ADD KEY `fk_gamejamscriteria_gamecriteries` (`idCriteria`);

--
-- Indexes for table `gamejams_participants`
--
ALTER TABLE `gamejams_participants`
  ADD PRIMARY KEY (`idGameJamParticipant`),
  ADD KEY `fk_gamejamsparticipants_gamejams` (`idGameJam`),
  ADD KEY `fk_gamejamsparticipants_users` (`idUser`);

--
-- Indexes for table `gamesubmissions`
--
ALTER TABLE `gamesubmissions`
  ADD PRIMARY KEY (`idGameSubmission`),
  ADD KEY `fk_gamesubmission_gamejams` (`idGameJam`),
  ADD KEY `fk_gamesubmission_coverimage` (`idCoverImage`),
  ADD KEY `fk_gamesubmission_teaserimage` (`idTeaserImage`),
  ADD KEY `fk_gamesubmission_user` (`idUserCreator`);

--
-- Indexes for table `gamesubmissions_badges`
--
ALTER TABLE `gamesubmissions_badges`
  ADD PRIMARY KEY (`idGameSubmissionsBadge`),
  ADD KEY `fk_gamesubmissionbages_gamesubmission` (`idGameSubmission`),
  ADD KEY `fk_gamesubmissionbages_gamebage` (`idBadge`);

--
-- Indexes for table `gamesubmissions_categories`
--
ALTER TABLE `gamesubmissions_categories`
  ADD PRIMARY KEY (`idGameSubmissionCategory`),
  ADD KEY `fk_gamesubmissioncategories_gamecategories` (`idCategory`),
  ADD KEY `fk_gamesubmissioncategories_gamesubmission` (`idGameSubmission`);

--
-- Indexes for table `gamesubmissions_comments`
--
ALTER TABLE `gamesubmissions_comments`
  ADD PRIMARY KEY (`idGameSubmissionComment`),
  ADD KEY `fk_gamesubmissioncomment_gamesubmission` (`idGameSubmission`),
  ADD KEY `fk_gamesubmissioncomment_comment` (`idComment`);

--
-- Indexes for table `gamesubmissions_downloadfiles`
--
ALTER TABLE `gamesubmissions_downloadfiles`
  ADD PRIMARY KEY (`idGameSubmissionDownloadFile`),
  ADD KEY `fk_gamesubmissionsdownloadfile_gamesubmission` (`idGameSubmission`),
  ADD KEY `fk_gamesubmissionsdownloadfile_downloadfiles` (`idDownloadFile`);

--
-- Indexes for table `gamesubmissions_reports`
--
ALTER TABLE `gamesubmissions_reports`
  ADD PRIMARY KEY (`idGameSubmissionReport`),
  ADD KEY `fk_gamesubmissionreports_gamesubmission` (`idGameSubmission`),
  ADD KEY `fk_gamesubmissionreports_reports` (`idReport`);

--
-- Indexes for table `gamesubmissions_screenshots`
--
ALTER TABLE `gamesubmissions_screenshots`
  ADD PRIMARY KEY (`idGameSubmissionScreenShot`),
  ADD KEY `fk_gamesubmissionsscreenshot_gamesubmission` (`idGameSubmission`),
  ADD KEY `fk_gamesubmissionsscreenshot_image` (`idImage`);

--
-- Indexes for table `gamesubmissions_votes`
--
ALTER TABLE `gamesubmissions_votes`
  ADD PRIMARY KEY (`idGameSubmissionVote`),
  ADD KEY `fk_gamesubmissionvotes_users` (`idUserVoter`),
  ADD KEY `fk_gamesubmissionvotes_gamesubmission` (`idGameSubmission`);

--
-- Indexes for table `imagecategories`
--
ALTER TABLE `imagecategories`
  ADD PRIMARY KEY (`idImageCategory`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`idImage`),
  ADD KEY `fk_images_imagecategory` (`idImageCategory`);

--
-- Indexes for table `pollanswers`
--
ALTER TABLE `pollanswers`
  ADD PRIMARY KEY (`idPollAnswer`),
  ADD KEY `fk_pollanswers_pollquestion` (`idPollQuestion`);

--
-- Indexes for table `pollquestions`
--
ALTER TABLE `pollquestions`
  ADD PRIMARY KEY (`idPollQuestion`);

--
-- Indexes for table `pollvotes`
--
ALTER TABLE `pollvotes`
  ADD PRIMARY KEY (`idPollVotes`),
  ADD KEY `fk_pollvotes_users` (`idUserVoter`),
  ADD KEY `fk_pollvotes_pollanswers` (`idPollAnswer`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`idReport`),
  ADD KEY `fk_reports_user` (`idUserCreator`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRole`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`idUserRoles`),
  ADD KEY `fk_usersroles_users` (`idUser`),
  ADD KEY `fk_usersroles_roles` (`idRole`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `idComment` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `downloadfiles`
--
ALTER TABLE `downloadfiles`
  MODIFY `idDownloadFile` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamebadges`
--
ALTER TABLE `gamebadges`
  MODIFY `idGameBadges` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamecategories`
--
ALTER TABLE `gamecategories`
  MODIFY `idGameCategory` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamecriteries`
--
ALTER TABLE `gamecriteries`
  MODIFY `idGameCriteria` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamejams`
--
ALTER TABLE `gamejams`
  MODIFY `idGameJam` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamejams_criterias`
--
ALTER TABLE `gamejams_criterias`
  MODIFY `idGameJamCriteria` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamejams_participants`
--
ALTER TABLE `gamejams_participants`
  MODIFY `idGameJamParticipant` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamesubmissions`
--
ALTER TABLE `gamesubmissions`
  MODIFY `idGameSubmission` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamesubmissions_badges`
--
ALTER TABLE `gamesubmissions_badges`
  MODIFY `idGameSubmissionsBadge` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamesubmissions_categories`
--
ALTER TABLE `gamesubmissions_categories`
  MODIFY `idGameSubmissionCategory` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamesubmissions_comments`
--
ALTER TABLE `gamesubmissions_comments`
  MODIFY `idGameSubmissionComment` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamesubmissions_downloadfiles`
--
ALTER TABLE `gamesubmissions_downloadfiles`
  MODIFY `idGameSubmissionDownloadFile` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamesubmissions_reports`
--
ALTER TABLE `gamesubmissions_reports`
  MODIFY `idGameSubmissionReport` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamesubmissions_screenshots`
--
ALTER TABLE `gamesubmissions_screenshots`
  MODIFY `idGameSubmissionScreenShot` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamesubmissions_votes`
--
ALTER TABLE `gamesubmissions_votes`
  MODIFY `idGameSubmissionVote` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imagecategories`
--
ALTER TABLE `imagecategories`
  MODIFY `idImageCategory` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `idImage` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pollanswers`
--
ALTER TABLE `pollanswers`
  MODIFY `idPollAnswer` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pollquestions`
--
ALTER TABLE `pollquestions`
  MODIFY `idPollQuestion` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pollvotes`
--
ALTER TABLE `pollvotes`
  MODIFY `idPollVotes` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `idReport` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `idRole` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `idUserRoles` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gamebadges`
--
ALTER TABLE `gamebadges`
  ADD CONSTRAINT `fk_gamebages_images` FOREIGN KEY (`idImage`) REFERENCES `images` (`idImage`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gamejams`
--
ALTER TABLE `gamejams`
  ADD CONSTRAINT `fk_gamejams_coverimage` FOREIGN KEY (`idCoverImage`) REFERENCES `images` (`idImage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamejams_usercreator` FOREIGN KEY (`idUserCreator`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gamejams_criterias`
--
ALTER TABLE `gamejams_criterias`
  ADD CONSTRAINT `fk_gamejamcriteria_gamejam` FOREIGN KEY (`idGameJam`) REFERENCES `gamejams` (`idGameJam`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamejamscriteria_gamecriteries` FOREIGN KEY (`idCriteria`) REFERENCES `gamecriteries` (`idGameCriteria`);

--
-- Constraints for table `gamejams_participants`
--
ALTER TABLE `gamejams_participants`
  ADD CONSTRAINT `fk_gamejamsparticipants_gamejams` FOREIGN KEY (`idGameJam`) REFERENCES `gamejams` (`idGameJam`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamejamsparticipants_users` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gamesubmissions`
--
ALTER TABLE `gamesubmissions`
  ADD CONSTRAINT `fk_gamesubmission_coverimage` FOREIGN KEY (`idCoverImage`) REFERENCES `images` (`idImage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamesubmission_gamejams` FOREIGN KEY (`idGameJam`) REFERENCES `gamejams` (`idGameJam`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamesubmission_teaserimage` FOREIGN KEY (`idTeaserImage`) REFERENCES `images` (`idImage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamesubmission_user` FOREIGN KEY (`idUserCreator`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gamesubmissions_badges`
--
ALTER TABLE `gamesubmissions_badges`
  ADD CONSTRAINT `fk_gamesubmissionbages_gamebage` FOREIGN KEY (`idBadge`) REFERENCES `gamebadges` (`idGameBadges`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamesubmissionbages_gamesubmission` FOREIGN KEY (`idGameSubmission`) REFERENCES `gamesubmissions` (`idGameSubmission`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gamesubmissions_categories`
--
ALTER TABLE `gamesubmissions_categories`
  ADD CONSTRAINT `fk_gamesubmissioncategories_gamecategories` FOREIGN KEY (`idCategory`) REFERENCES `gamecategories` (`idGameCategory`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamesubmissioncategories_gamesubmission` FOREIGN KEY (`idGameSubmission`) REFERENCES `gamesubmissions` (`idGameSubmission`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gamesubmissions_comments`
--
ALTER TABLE `gamesubmissions_comments`
  ADD CONSTRAINT `fk_gamesubmissioncomment_comment` FOREIGN KEY (`idComment`) REFERENCES `comments` (`idComment`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamesubmissioncomment_gamesubmission` FOREIGN KEY (`idGameSubmission`) REFERENCES `gamesubmissions` (`idGameSubmission`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gamesubmissions_downloadfiles`
--
ALTER TABLE `gamesubmissions_downloadfiles`
  ADD CONSTRAINT `fk_gamesubmissionsdownloadfile_downloadfiles` FOREIGN KEY (`idDownloadFile`) REFERENCES `downloadfiles` (`idDownloadFile`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamesubmissionsdownloadfile_gamesubmission` FOREIGN KEY (`idGameSubmission`) REFERENCES `gamesubmissions` (`idGameSubmission`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gamesubmissions_reports`
--
ALTER TABLE `gamesubmissions_reports`
  ADD CONSTRAINT `fk_gamesubmissionreports_gamesubmission` FOREIGN KEY (`idGameSubmission`) REFERENCES `gamesubmissions` (`idGameSubmission`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamesubmissionreports_reports` FOREIGN KEY (`idReport`) REFERENCES `reports` (`idReport`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gamesubmissions_screenshots`
--
ALTER TABLE `gamesubmissions_screenshots`
  ADD CONSTRAINT `fk_gamesubmissionsscreenshot_gamesubmission` FOREIGN KEY (`idGameSubmission`) REFERENCES `gamesubmissions` (`idGameSubmission`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamesubmissionsscreenshot_image` FOREIGN KEY (`idImage`) REFERENCES `images` (`idImage`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gamesubmissions_votes`
--
ALTER TABLE `gamesubmissions_votes`
  ADD CONSTRAINT `fk_gamesubmissionvotes_gamesubmission` FOREIGN KEY (`idGameSubmission`) REFERENCES `gamesubmissions` (`idGameSubmission`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gamesubmissionvotes_users` FOREIGN KEY (`idUserVoter`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_imagecategory` FOREIGN KEY (`idImageCategory`) REFERENCES `imagecategories` (`idImageCategory`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pollanswers`
--
ALTER TABLE `pollanswers`
  ADD CONSTRAINT `fk_pollanswers_pollquestion` FOREIGN KEY (`idPollQuestion`) REFERENCES `pollquestions` (`idPollQuestion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pollvotes`
--
ALTER TABLE `pollvotes`
  ADD CONSTRAINT `fk_pollvotes_pollanswers` FOREIGN KEY (`idPollAnswer`) REFERENCES `pollanswers` (`idPollAnswer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pollvotes_users` FOREIGN KEY (`idUserVoter`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `fk_reports_user` FOREIGN KEY (`idUserCreator`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `fk_usersroles_roles` FOREIGN KEY (`idRole`) REFERENCES `roles` (`idRole`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usersroles_users` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
