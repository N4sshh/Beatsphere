-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2025 at 05:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beatsphere`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `suggested_by` varchar(255) DEFAULT NULL,
  `suggested_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `bio`, `image_url`, `suggested_by`, `suggested_at`) VALUES
('1977', 'Coldplay', 'Coldplay is a British rock band known for songs like Fix You and Viva La Vida.', 'https://n4sshh.github.io/Nash/Final%20Project%20Images/Coldplay.jpg', NULL, '2025-03-27 12:47:12'),
('1985', 'Bruno Mars', 'Bruno Mars is an American singer known for hit songs like Grenade and Uptown Funk.', 'https://n4sshh.github.io/Nash/Final%20Project%20Images/Bruno.jpg', NULL, '2025-03-27 12:47:12'),
('1986', 'Lady Gaga', 'Lady Gaga is an American singer known for Poker Face and Shallow.', 'https://n4sshh.github.io/Nash/Final%20Project%20Images/Lady%20Gaga.jpg', NULL, '2025-03-27 12:47:12'),
('1988', 'Adele', 'Adele is a British singer known for hits like Rolling in the Deep and Hello.', 'https://n4sshh.github.io/Nash/Final%20Project%20Images/Adele.jpg', NULL, '2025-03-27 12:47:12'),
('1991', 'Ed Sheeran', 'Ed Sheeran is a British singer-songwriter known for Shape of You and Thinking Out Loud.', 'https://n4sshh.github.io/Nash/Final%20Project%20Images/Ed%20Sheeran.jpg', NULL, '2025-03-27 12:47:12'),
('1996', 'LANY', 'LANY is an American indie pop band known for ILYSB and Malibu Nights.', 'https://n4sshh.github.io/Nash/Final%20Project%20Images/Lany.jpg', NULL, '2025-03-27 12:47:12');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `suggested_by` varchar(255) DEFAULT NULL,
  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `name`, `video`, `suggested_by`, `artist_id`) VALUES
(1, 'James Blunt - You\'re Beautiful', 'https://raw.githubusercontent.com/N4sshh/Nash/main/music%20videos/James%20Blunt%20-%20You\'re%20Beautiful%20(Official%20Music%20Video)%20%5B4K%5D.mp4', NULL, 0),
(2, 'Lady Gaga - Judas', 'https://raw.githubusercontent.com/N4sshh/Nash/main/music%20videos/Lady%20Gaga%20-%20Judas%20(Official%20Music%20Video).mp4', NULL, 0),
(3, 'Goo Goo Dolls - Iris', 'https://raw.githubusercontent.com/N4sshh/Nash/main/music%20videos/Goo%20Goo%20Dolls%20%E2%80%93%20Iris%20%5BOfficial%20Music%20Video%5D%20%5B4K%20Remaster%5D.mp4', NULL, 0),
(4, 'The Walters - I Love You So', 'https://raw.githubusercontent.com/N4sshh/Nash/main/music%20videos/The%20Walters%20--%20I%20Love%20You%20So.mp4', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `songs_pop`
--

CREATE TABLE `songs_pop` (
  `id` int(11) NOT NULL,
  `artist_id` varchar(50) DEFAULT NULL,
  `song_name` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs_pop`
--

INSERT INTO `songs_pop` (`id`, `artist_id`, `song_name`, `video_url`) VALUES
(319, '1985', 'Grenade', 'https://github.com/N4sshh/Nash/raw/main/Bruno%20Mars%20MP4/Bruno%20Mars%20-%20Grenade%20(Official%20Music%20Video).mp4'),
(320, '1985', 'It Will Rain', 'https://github.com/N4sshh/Nash/raw/main/Bruno%20Mars%20MP4/Bruno%20Mars%20-%20It%20Will%20Rain%20(Official%20Music%20Video).mp4'),
(321, '1985', 'Just The Way You Are', 'https://github.com/N4sshh/Nash/raw/main/Bruno%20Mars%20MP4/Bruno%20Mars%20-%20Just%20The%20Way%20You%20Are%20(Official%20Music%20Video).mp4'),
(322, '1985', 'Locked Out Of Heaven', 'https://github.com/N4sshh/Nash/raw/main/Bruno%20Mars%20MP4/Bruno%20Mars%20-%20Locked%20Out%20Of%20Heaven%20(Official%20Music%20Video).mp4'),
(323, '1985', 'When I Was Your Man', 'https://github.com/N4sshh/Nash/raw/main/Bruno%20Mars%20MP4/Bruno%20Mars%20-%20When%20I%20Was%20Your%20Man%20(Official%20Music%20Video).mp4'),
(324, '1985', 'Uptown Funk', 'https://n4sshh.github.io/Nash/Bruno%20Mars%20MP4/Mark%20Ronson%20-%20Uptown%20Funk%20(Official%20Video)%20ft.%20Bruno%20Mars.mp4'),
(325, '1977', 'Something Just Like This', 'https://n4sshh.github.io/Nash/Coldplay%20MP4/Coldplay%20&%20The%20Chainsmokers%20-%20Something%20Just%20Like%20This%20[Tokyo%20Remix]%20(Official%20Audio).mp4'),
(326, '1977', 'A Sky Full Of Stars', 'https://n4sshh.github.io/Nash/Coldplay%20MP4/Coldplay%20-%20A%20Sky%20Full%20Of%20Stars%20(Official%20Video).mp4'),
(327, '1977', 'Fix You', 'https://n4sshh.github.io/Nash/Coldplay%20MP4/Coldplay%20-%20Fix%20You%20(Official%20Video).mp4'),
(328, '1977', 'Hymn For The Weekend', 'https://n4sshh.github.io/Nash/Coldplay%20MP4/Coldplay%20-%20Hymn%20For%20The%20Weekend%20(Official%20Video).mp4'),
(329, '1977', 'The Scientist', 'https://n4sshh.github.io/Nash/Coldplay%20MP4/Coldplay%20-%20The%20Scientist%20(Official%204K%20Video).mp4'),
(330, '1977', 'Yellow', 'https://n4sshh.github.io/Nash/Coldplay%20MP4/Coldplay%20-%20Yellow%20(Official%20Video).mp4'),
(331, '1988', 'Chasing Pavements', 'https://n4sshh.github.io/Nash/Adele%20MP4/Adele%20-%20Chasing%20Pavements%20(Official%20Music%20Video).mp4'),
(332, '1988', 'Easy On Me', 'https://n4sshh.github.io/Nash/Adele%20MP4/Adele%20-%20Easy%20On%20Me%20(Official%20Video).mp4'),
(333, '1988', 'Hello', 'https://n4sshh.github.io/Nash/Adele%20MP4/Adele%20-%20Hello%20(Official%20Music%20Video).mp4'),
(334, '1988', 'Rolling in the Deep', 'https://n4sshh.github.io/Nash/Adele%20MP4/Adele%20-%20Rolling%20in%20the%20Deep%20(Official%20Music%20Video).mp4'),
(335, '1988', 'Set Fire To The Rain', 'https://n4sshh.github.io/Nash/Adele%20MP4/Adele%20-%20Set%20Fire%20To%20The%20Rain%20(Official%20Music%20Video).mp4'),
(336, '1988', 'Someone Like You', 'https://n4sshh.github.io/Nash/Adele%20MP4/Adele%20-%20Someone%20Like%20You%20(Official%20Music%20Video).mp4'),
(337, '1991', 'Bad Habits', 'https://n4sshh.github.io/Nash/EdSheeran%20MP4/Ed%20Sheeran%20-%20Bad%20Habits%20[Official%20Video].mp4'),
(338, '1991', 'Happier', 'https://n4sshh.github.io/Nash/EdSheeran%20MP4/Ed%20Sheeran%20-%20Happier%20(Official%20Music%20Video).mp4'),
(339, '1991', 'Perfect', 'https://n4sshh.github.io/Nash/EdSheeran%20MP4/Ed%20Sheeran%20-%20Perfect%20(Official%20Music%20Video).mp4'),
(340, '1991', 'Photograph', 'https://n4sshh.github.io/Nash/EdSheeran%20MP4/Ed%20Sheeran%20-%20Photograph%20(Official%20Music%20Video).mp4'),
(341, '1991', 'Shape of You', 'https://n4sshh.github.io/Nash/EdSheeran%20MP4/Ed%20Sheeran%20-%20Shape%20of%20You%20(Official%20Music%20Video).mp4'),
(342, '1991', 'Thinking Out Loud', 'https://n4sshh.github.io/Nash/EdSheeran%20MP4/Ed%20Sheeran%20-%20Thinking%20Out%20Loud%20(Official%20Music%20Video).mp4'),
(343, '1986', 'Poker Face', 'https://n4sshh.github.io/Nash/LadyGaga%20MP4/Lady%20Gaga%20-%20Poker%20Face%20(Official%20Music%20Video)%20-%20LadyGagaVEVO%20(720p,%20h264).mp4'),
(344, '1986', 'Shallow', 'https://n4sshh.github.io/Nash/LadyGaga%20MP4/Lady%20Gaga,%20Bradley%20Cooper%20-%20Shallow%20(from%20A%20Star%20Is%20Born)%20(Official%20Music%20Video).mp4'),
(345, '1986', 'Die With A Smile', 'https://n4sshh.github.io/Nash/LadyGaga%20MP4/Lady%20Gaga,%20Bruno%20Mars%20-%20Die%20With%20A%20Smile%20(Official%20Music%20Video).mp4'),
(346, '1986', 'Alejandro', 'https://n4sshh.github.io/Nash/LadyGaga%20MP4/Lady%20Gaga%20-%20Alejandro%20(Official%20Music%20Video).mp4'),
(347, '1986', 'Born This Way', 'https://n4sshh.github.io/Nash/LadyGaga%20MP4/Lady%20Gaga%20-%20Born%20This%20Way%20(Official%20Music%20Video).mp4'),
(348, '1986', 'Paparazzi', 'https://n4sshh.github.io/Nash/LadyGaga%20MP4/Lady%20Gaga%20-%20Paparazzi%20(Official%20Music%20Video).mp4'),
(349, '1996', 'Alonica', 'https://n4sshh.github.io/Nash/Lany%20MP4/LANY%20-%20Alonica%20(Official%20Music%20Video).mp4'),
(350, '1996', 'Good Girls', 'https://n4sshh.github.io/Nash/Lany%20MP4/LANY%20-%20Good%20Girls%20(Official%20Video).mp4'),
(351, '1996', 'Malibu Nights', 'https://n4sshh.github.io/Nash/Lany%20MP4/LANY%20-%20Malibu%20Nights%20(Official%20Video).mp4'),
(352, '1996', 'Super Far', 'https://n4sshh.github.io/Nash/Lany%20MP4/LANY%20-%20Super%20Far%20(Official%20Video).mp4'),
(353, '1996', 'Thick And Thin', 'https://n4sshh.github.io/Nash/Lany%20MP4/LANY%20-%20Thick%20And%20Thin%20(Official%20Video).mp4'),
(354, '1996', 'XXL', 'https://n4sshh.github.io/Nash/Lany%20MP4/LANY%20-%20XXL%20(Official%20Music%20Video).mp4');

-- --------------------------------------------------------

--
-- Table structure for table `suggested_artists`
--

CREATE TABLE `suggested_artists` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `suggested_by` varchar(100) DEFAULT NULL,
  `suggested_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suggested_artists`
--

INSERT INTO `suggested_artists` (`id`, `name`, `bio`, `image_url`, `suggested_by`, `suggested_at`) VALUES
(1, 'Paloma Faith', 'Paloma Faith Blomfield   is an English singer, songwriter, and actress.', 'https://n4sshh.github.io/Nash/PalomaFaith.jpg', 'Nash', '2025-03-27 13:52:13');

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

CREATE TABLE `suggestions` (
  `id` int(11) NOT NULL,
  `song_name` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `artist_id` varchar(50) DEFAULT NULL,
  `suggested_by` varchar(100) DEFAULT NULL,
  `suggested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `suggested_artist_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suggestions`
--

INSERT INTO `suggestions` (`id`, `song_name`, `video_url`, `artist_id`, `suggested_by`, `suggested_at`, `suggested_artist_id`) VALUES
(11, 'Bruno Mars - The Lazy Song (Official Music Video)', 'https://www.youtube.com/watch?v=fLexgOxsZu0', '1985', 'Nash', '2025-03-02 06:30:15', NULL),
(12, 'Lady Gaga - Abracadabra (Official Music Video)', 'https://www.youtube.com/watch?v=vBynw9Isr28', '1986', 'Nash', '2025-03-02 10:52:19', NULL),
(13, 'Coldplay - Paradise (Official Video)', 'https://www.youtube.com/watch?v=1G4isv_Fylg', '1977', 'Nash', '2025-03-02 10:52:52', NULL),
(14, 'Adele - Send My Love (To Your New Lover)', 'https://www.youtube.com/watch?v=fk4BbF7B29w', '1988', 'Nash', '2025-03-02 10:53:29', NULL),
(15, 'Ed Sheeran - Shape of You (Official Music Video)', 'https://www.youtube.com/watch?v=JGwWNGJdvx8', '1991', 'Nash', '2025-03-02 10:54:01', NULL),
(16, 'LANY - \'Cause You Have To (Official Lyric Video)', 'https://www.youtube.com/watch?v=9t3xxOAMh4Q', '1996', 'Nash', '2025-03-02 10:54:38', NULL),
(17, 'LANY - dna (official lyric video)', 'https://www.youtube.com/watch?v=EDOzUWDAeQA&ab_channel=LANY', '1996', 'Nash', '2025-03-03 06:05:15', NULL),
(18, 'Paloma Faith - Only Love Can Hurt Like This (Official Video)', 'https://www.youtube.com/watch?v=PaKr9gWqwl4', '1', 'Nash', '2025-03-27 13:52:13', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs_pop`
--
ALTER TABLE `songs_pop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_artist_id` (`artist_id`);

--
-- Indexes for table `suggested_artists`
--
ALTER TABLE `suggested_artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `fk_suggested_artist` (`suggested_artist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `songs_pop`
--
ALTER TABLE `songs_pop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;

--
-- AUTO_INCREMENT for table `suggested_artists`
--
ALTER TABLE `suggested_artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `songs_pop`
--
ALTER TABLE `songs_pop`
  ADD CONSTRAINT `fk_artist_id` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`);

--
-- Constraints for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD CONSTRAINT `fk_suggested_artist` FOREIGN KEY (`suggested_artist_id`) REFERENCES `suggested_artists` (`id`),
  ADD CONSTRAINT `suggestions_ibfk_1` FOREIGN KEY (`suggested_artist_id`) REFERENCES `suggested_artists` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
