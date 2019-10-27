--
-- Forum Database: 'forumdb'
--

CREATE DATABASE IF NOT EXISTS `forumdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `forumdb`;

CREATE TABLE IF NOT EXISTS `user` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(64) NOT NULL,
    `first_name` VARCHAR(45) NULL,
    `last_name` VARCHAR(45) NULL,
    UNIQUE INDEX `email_UNIQUE` (`email` ASC),
    PRIMARY KEY (`id`)
)  ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS `post` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `subject` VARCHAR(128) NOT NULL,
    `content` TEXT NOT NULL,
    `user_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_posts_user_idx` (`user_id` ASC),
    CONSTRAINT `fk_posts_user` FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)  ENGINE=INNODB; -- AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `joke`
--

LOCK TABLES `joke` WRITE;
/*!40000 ALTER TABLE `joke` DISABLE KEYS */;
INSERT INTO `joke` VALUES (1,'!false - it\'s funny because it\'s true'),
(2,'Why was the empty array locked outside? It didn\'t have any keys');
/*!40000 ALTER TABLE `joke` ENABLE KEYS */;
UNLOCK TABLES;
