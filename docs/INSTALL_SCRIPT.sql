-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Mai 2018 um 18:17
-- Server-Version: 10.1.30-MariaDB
-- PHP-Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `gamify`
--

DELIMITER $$
--
-- Prozeduren
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `best_item` (IN `type` VARCHAR(64), IN `lim` INT)  BEGIN
  DECLARE item_type VARCHAR(64);
  DECLARE fix_attr VARCHAR(64);
  DECLARE factor_attr VARCHAR(64);

  -- Define Weapons
  IF type = "weapon" THEN
    SET item_type = '"sword", "bow", "axe"';
    SET fix_attr = 'fix_attack';
    SET factor_attr = 'factor_attack';
  END IF;

  -- Define Armors
  IF type = "armor" THEN
    SET item_type = '"armor"';
    SET fix_attr = 'fix_health';
    SET factor_attr = 'factor_health';
  END IF;

  -- Define Shields
  IF type = "shield" THEN
    SET item_type = '"shield", "helmet"';
    SET fix_attr = 'fix_defence';
    SET factor_attr = 'factor_defence';
  END IF;

  -- Define Shields
  IF type = "special" THEN
    SET item_type = '"specialfront", "specialback"';
    SET fix_attr = 'fix_agility';
    SET factor_attr = 'factor_agility';
  END IF;

  -- SQL Statement
  SET @sql = CONCAT('SELECT\r\n        player.id AS player_id,\r\n        player.name AS player_name,\r\n        player_item.name AS item_name,\r\n        (', fix_attr, ' + (', fix_attr, ' / 100 * ', factor_attr, ') + ((fix_luck / 100 * factor_luck) * 2)) AS "power",\r\n        player_item.id AS item_id\r\n    FROM player_item\r\n    LEFT JOIN player ON player.id = player_item.player_id\r\n    WHERE player_item.type IN (', item_type, ')\r\n    ORDER BY power DESC\r\n    LIMIT 0,', lim, ';');

  PREPARE stmt FROM @sql;
  EXECUTE stmt;
  DEALLOCATE PREPARE stmt;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_testplayer` ()  BEGIN
    DECLARE `_rollback` BOOL DEFAULT 0;
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET `_rollback` = 1;

    START TRANSACTION;

    -- Create Random Character
    SET @face = FLOOR(RAND() * 25) + 1;
    SET @hair = FLOOR(RAND() * 20) + 1;
    SET @body = FLOOR(RAND() * 5) + 1;
    SET @expr = FLOOR(RAND() * 3000);
    SET @name = CONCAT('BOT-', FLOOR(RAND() * 999) + 1000);
    SET @email = CONCAT(@name, '@demo.ch');

    -- Insert All TestData
    INSERT INTO account (email, password, fraction) VALUES (@email, 'e10adc3949ba59abbe56e057f20f883e', 'holy_knights');
    SET @account_id = (SELECT id FROM account ORDER BY id DESC LIMIT 1);

    INSERT INTO player (`account_id`, `name`, body_key, face_key, hair_key, experience) VALUES (@account_id, @name, @body, @face, @hair, @expr);
    SET @player_id = (SELECT id FROM player WHERE account_id = @account_id LIMIT 1);

    INSERT INTO player_quest (player_id, title, description, priority, end_timestamp, experience, base64_items) VALUES (@player_id, 'Herzlich Willkommen', '<p><b>Herzlich Willkommen&nbsp;bei Gamify</b></p><p>Dies ist Ihre erste Quest. Bitte erfÃ¼llen Sie alle Aufgaben um diese Quest erfolgreich zu beenden.</p><ol><li>&nbsp;Passen Sie die Config auf ihren Betrieb an (Sie finden die Config unter "lib/global.php"</li><li>Leider sind die meisten Sprites nicht Opensource und dÃ¼rfen durch uns auch nicht ausgeliefert werden deshalb mÃ¼ssen Sie an dieser stelle alle Images selber erstellen und in den Ordner "assets/images" laden.</li><li>Schliessen Sie dieses Ticket ab !</li></ol>', 0, 2527095905, 100, 'W10=');

    IF `_rollback` THEN
        ROLLBACK;
    ELSE
        COMMIT;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fraction` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `gained_exp` int(11) NOT NULL,
  `is_battle_8` tinyint(1) NOT NULL,
  `is_battle_4` tinyint(1) NOT NULL,
  `is_battle_2` tinyint(1) NOT NULL,
  `is_battle_1` int(11) NOT NULL,
  `is_battle_0` int(11) NOT NULL,
  `item_count_prio_0` int(11) NOT NULL,
  `item_count_prio_1` int(11) NOT NULL,
  `item_count_prio_2` int(11) NOT NULL,
  `item_count_prio_3` int(11) NOT NULL,
  `item_count_prio_4` int(11) NOT NULL,
  `item_count_prio_5` int(11) NOT NULL,
  `quest_count_prio_0` int(11) NOT NULL,
  `quest_count_prio_1` int(11) NOT NULL,
  `quest_count_prio_2` int(11) NOT NULL,
  `quest_count_prio_3` int(11) NOT NULL,
  `quest_count_canceled` int(11) NOT NULL,
  `quest_count_delegated` int(11) NOT NULL,
  `quest_count_created` int(11) NOT NULL,
  `login_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `daily_battle`
--

CREATE TABLE `daily_battle` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `fraction` varchar(255) NOT NULL,
  `battle_data_json` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `get_achievements`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `get_achievements` (
`player_id` int(11)
,`gained_exp` decimal(32,0)
,`8thfinal` decimal(25,0)
,`quaterfinals` decimal(25,0)
,`semifinals` decimal(25,0)
,`finals` decimal(32,0)
,`champion` decimal(32,0)
,`poor_item` decimal(32,0)
,`common_item` decimal(32,0)
,`uncommon_item` decimal(32,0)
,`epic_item` decimal(32,0)
,`legendary_item` decimal(32,0)
,`divine_item` decimal(32,0)
,`looted_items` decimal(37,0)
,`low_quest` decimal(32,0)
,`medium_quest` decimal(32,0)
,`high_quest` decimal(32,0)
,`superior_quest` decimal(32,0)
,`finished_quests` decimal(35,0)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `get_allplayer_infos`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `get_allplayer_infos` (
`id` int(11)
,`name` varchar(16)
,`email` varchar(255)
,`fraction` varchar(255)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `get_lastlogin`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `get_lastlogin` (
`id` int(11)
,`name` varchar(16)
,`last_login` date
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `get_queststatus`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `get_queststatus` (
`id` int(11)
,`name` varchar(16)
,`open_quests` bigint(21)
,`finished_quests` bigint(21)
,`fraction` varchar(255)
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `body_key` varchar(64) NOT NULL,
  `face_key` varchar(64) NOT NULL,
  `hair_key` varchar(64) NOT NULL,
  `experience` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `player_item`
--

CREATE TABLE `player_item` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `player_id` int(11) NOT NULL,
  `is_equiped` tinyint(1) NOT NULL,
  `rarity` int(11) NOT NULL,
  `type` varchar(64) NOT NULL,
  `image_key` varchar(64) NOT NULL,
  `fix_health` int(11) NOT NULL,
  `fix_attack` int(11) NOT NULL,
  `fix_defence` int(11) NOT NULL,
  `fix_agility` int(11) NOT NULL,
  `fix_luck` int(11) NOT NULL,
  `factor_health` int(11) NOT NULL,
  `factor_attack` int(11) NOT NULL,
  `factor_defence` int(11) NOT NULL,
  `factor_agility` int(11) NOT NULL,
  `factor_luck` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `player_quest`
--

CREATE TABLE `player_quest` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `priority` int(11) NOT NULL,
  `end_timestamp` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  `base64_items` text NOT NULL,
  `is_finish` tinyint(1) NOT NULL,
  `finish_timestamp` int(11) NOT NULL,
  `is_canceled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur des Views `get_achievements`
--
DROP TABLE IF EXISTS `get_achievements`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `get_achievements`  AS  select `activity_log`.`player_id` AS `player_id`,sum(`activity_log`.`gained_exp`) AS `gained_exp`,sum(`activity_log`.`is_battle_8`) AS `8thfinal`,sum(`activity_log`.`is_battle_4`) AS `quaterfinals`,sum(`activity_log`.`is_battle_2`) AS `semifinals`,sum(`activity_log`.`is_battle_1`) AS `finals`,sum(`activity_log`.`is_battle_0`) AS `champion`,sum(`activity_log`.`item_count_prio_0`) AS `poor_item`,sum(`activity_log`.`item_count_prio_1`) AS `common_item`,sum(`activity_log`.`item_count_prio_2`) AS `uncommon_item`,sum(`activity_log`.`item_count_prio_3`) AS `epic_item`,sum(`activity_log`.`item_count_prio_4`) AS `legendary_item`,sum(`activity_log`.`item_count_prio_5`) AS `divine_item`,(((((sum(`activity_log`.`item_count_prio_0`) + sum(`activity_log`.`item_count_prio_1`)) + sum(`activity_log`.`item_count_prio_2`)) + sum(`activity_log`.`item_count_prio_3`)) + sum(`activity_log`.`item_count_prio_4`)) + sum(`activity_log`.`item_count_prio_5`)) AS `looted_items`,sum(`activity_log`.`quest_count_prio_0`) AS `low_quest`,sum(`activity_log`.`quest_count_prio_1`) AS `medium_quest`,sum(`activity_log`.`quest_count_prio_2`) AS `high_quest`,sum(`activity_log`.`quest_count_prio_3`) AS `superior_quest`,(((sum(`activity_log`.`quest_count_prio_0`) + sum(`activity_log`.`quest_count_prio_1`)) + sum(`activity_log`.`quest_count_prio_2`)) + sum(`activity_log`.`quest_count_prio_3`)) AS `finished_quests` from `activity_log` group by `activity_log`.`player_id` ;

-- --------------------------------------------------------

--
-- Struktur des Views `get_allplayer_infos`
--
DROP TABLE IF EXISTS `get_allplayer_infos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `get_allplayer_infos`  AS  select `player`.`id` AS `id`,`player`.`name` AS `name`,`account`.`email` AS `email`,`account`.`fraction` AS `fraction` from (`player` left join `account` on((`player`.`account_id` = `account`.`id`))) order by `account`.`fraction`,`player`.`name` ;

-- --------------------------------------------------------

--
-- Struktur des Views `get_lastlogin`
--
DROP TABLE IF EXISTS `get_lastlogin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `get_lastlogin`  AS  select `player`.`id` AS `id`,`player`.`name` AS `name`,(select max(`activity_log`.`date`) from `activity_log` where (`activity_log`.`player_id` = `player`.`id`)) AS `last_login` from `player` ;

-- --------------------------------------------------------

--
-- Struktur des Views `get_queststatus`
--
DROP TABLE IF EXISTS `get_queststatus`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `get_queststatus`  AS  select `player`.`id` AS `id`,`player`.`name` AS `name`,(select count(0) from `player_quest` where ((`player_quest`.`is_finish` = 0) and (`player_quest`.`player_id` = `player`.`id`))) AS `open_quests`,(select count(0) from `player_quest` where ((`player_quest`.`is_finish` = 1) and (`player_quest`.`player_id` = `player`.`id`))) AS `finished_quests`,`account`.`fraction` AS `fraction` from (`player` left join `account` on((`player`.`account_id` = `account`.`id`))) ;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `player_item`
--
ALTER TABLE `player_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Indizes für die Tabelle `player_quest`
--
ALTER TABLE `player_quest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `player_item`
--
ALTER TABLE `player_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `player_quest`
--
ALTER TABLE `player_quest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
