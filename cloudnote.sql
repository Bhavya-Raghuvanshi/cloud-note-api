DROP DATABASE IF EXISTS `cloudnote`;
CREATE DATABASE `cloudnote`;
USE `cloudnote`;

 
CREATE TABLE `users`
(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `email` VARCHAR(255) NOT NULL,
    `passwordHash` VARCHAR(500) DEFAULT NULL,
    `signedUpOnTimestamp` TIMESTAMP NOT NULL,
);

 
CREATE TABLE `notes` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` longtext NOT NULL,
  `createTime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editedTime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,    
  `isArchived` tinyint(1) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `preArchived` tinyint(1) NOT NULL,
  `noteColor` VARCHAR(10) DEFAULT NULL;
  
  `userId` INT NOT NULL,
  CONSTRAINT `fkUserIdinNotes` FOREIGN KEY (`userId`) REFERENCES `users`(`id`)
);


CREATE TABLE `userProfiles`
(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `occupation` VARCHAR(255) NOT NULL,
    `about` longtext NOT NULL,
    `contact` VARCHAR(10) NOT NULL,
    `location` VARCHAR(255) NOT NULL,
    `avatarFileName` VARCHAR(255) DEFAULT NULL,

    `userId` INT NOT NULL,
    CONSTRAINT `fkUserIdinUserProfiles` FOREIGN KEY (`userId`) REFERENCES `users`(`id`)
);