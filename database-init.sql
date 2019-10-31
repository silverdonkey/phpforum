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

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1, 'test01@web.de', 'Max', 'Mustermann'),
                          (2, 'test02@web.de', 'John', 'Doh'),
                          (3, 'test03@web.de', 'Doris', 'Schroeder');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
