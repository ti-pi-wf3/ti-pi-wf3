-- MySQL Script generated by MySQL Workbench
-- Tue Jul 20 16:40:53 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema TIPI
-- -----------------------------------------------------
-- Les plus beaux 5

-- -----------------------------------------------------
-- Schema TIPI
--
-- Les plus beaux 5
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `TIPI` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `TIPI` ;

-- -----------------------------------------------------
-- Table `TIPI`.`TRIBE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TIPI`.`TRIBE` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tribeName` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `tribeName_UNIQUE` (`tribeName` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TIPI`.`USER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TIPI`.`USER` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tribeId` INT NOT NULL,
  `role` VARCHAR(45) NOT NULL DEFAULT 'user',
  `sexe` ENUM('f', 'm', 'u') NOT NULL DEFAULT 'u',
  `password` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  `firstName` VARCHAR(255) NOT NULL,
  `lastName` VARCHAR(255) NOT NULL,
  `maidenName` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  `birthDate` INT NOT NULL,
  `phone` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `tribeId_idx` (`tribeId` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
  CONSTRAINT `tribeId`
    FOREIGN KEY (`tribeId`)
    REFERENCES `TIPI`.`TRIBE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TIPI`.`REPERTOIRE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TIPI`.`REPERTOIRE` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `firstName` VARCHAR(255) NOT NULL,
  `lastName` VARCHAR(255) NOT NULL,
  `adress` VARCHAR(255) NOT NULL,
  `country` VARCHAR(255) NULL,
  `postalCode` INT NULL,
  `phoneHome` INT NULL,
  `indPhoneHome` VARCHAR(255) NULL,
  `phone` INT NULL,
  `indPhone` VARCHAR(255) NULL,
  `phonePro` INT NULL,
  `indPhonePro` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  `emailPro` VARCHAR(255) NULL,
  `picture` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX `userId_idx` (`userId` ASC) VISIBLE,
  CONSTRAINT `userId`
    FOREIGN KEY (`userId`)
    REFERENCES `TIPI`.`USER` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TIPI`.`TODOLIST`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TIPI`.`TODOLIST` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `date` DATETIME NOT NULL,
  `titleGrade` VARCHAR(255) NOT NULL,
  `grade` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `userId_idx` (`userId` ASC) VISIBLE,
  CONSTRAINT `userId`
    FOREIGN KEY (`userId`)
    REFERENCES `TIPI`.`USER` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TIPI`.`COUNCIL`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TIPI`.`COUNCIL` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `titleCouncilTribe` VARCHAR(255) NOT NULL,
  `comments` TEXT NOT NULL,
  `dateStart` DATE NOT NULL,
  `dateEnd` DATE NOT NULL,
  `hourStart` TIME NOT NULL,
  `hourEnd` TIME NULL,
  PRIMARY KEY (`id`),
  INDEX `userId_idx` (`userId` ASC) VISIBLE,
  CONSTRAINT `userId`
    FOREIGN KEY (`userId`)
    REFERENCES `TIPI`.`USER` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TIPI`.`categoryArticle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TIPI`.`categoryArticle` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titleCategoryArticle` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TIPI`.`LIST`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TIPI`.`LIST` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `titleList` VARCHAR(255) NOT NULL,
  `date` DATETIME NOT NULL,
  `article` VARCHAR(45) NOT NULL,
  `quantity` INT NULL,
  `valid` INT NULL,
  `lock` INT NULL,
  `titleCategoryArticleId` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `userId_idx` (`userId` ASC) VISIBLE,
  INDEX `titleCategoryArticleId_idx` (`titleCategoryArticleId` ASC) VISIBLE,
  CONSTRAINT `userId`
    FOREIGN KEY (`userId`)
    REFERENCES `TIPI`.`USER` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `titleCategoryArticleId`
    FOREIGN KEY (`titleCategoryArticleId`)
    REFERENCES `TIPI`.`categoryArticle` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TIPI`.`ARTICLE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TIPI`.`ARTICLE` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `categoryArticleId` INT NOT NULL,
  `titleArticle` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `categoryArticleId_idx` (`categoryArticleId` ASC) VISIBLE,
  CONSTRAINT `categoryArticleId`
    FOREIGN KEY (`categoryArticleId`)
    REFERENCES `TIPI`.`categoryArticle` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TIPI`.`TYPE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TIPI`.`TYPE` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TIPI`.`DOCUMENTS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TIPI`.`DOCUMENTS` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `typeId` INT NOT NULL,
  `date` DATETIME NOT NULL,
  `fileId` INT NOT NULL,
  `titleDocument` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `userId_idx` (`userId` ASC) VISIBLE,
  INDEX `typeId_idx` (`typeId` ASC) VISIBLE,
  CONSTRAINT `userId`
    FOREIGN KEY (`userId`)
    REFERENCES `TIPI`.`USER` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `typeId`
    FOREIGN KEY (`typeId`)
    REFERENCES `TIPI`.`TYPE` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `TIPI`.`FILE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TIPI`.`FILE` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titleFile` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `file` VARCHAR(255) NOT NULL,
  `date` DATETIME NOT NULL,
  `documentId` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `documentId_idx` (`documentId` ASC) VISIBLE,
  CONSTRAINT `documentId`
    FOREIGN KEY (`documentId`)
    REFERENCES `TIPI`.`DOCUMENTS` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
