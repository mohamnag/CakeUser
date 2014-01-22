SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `asui` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `asui` ;

-- -----------------------------------------------------
-- Table `asui`.`acos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `asui`.`acos` ;

CREATE TABLE IF NOT EXISTS `asui`.`acos` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `model` VARCHAR(255) NULL DEFAULT '',
  `foreign_key` INT(10) UNSIGNED NULL DEFAULT NULL,
  `alias` VARCHAR(255) NULL DEFAULT '',
  `lft` INT(10) NULL DEFAULT NULL,
  `rght` INT(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_acos_acos1_idx` (`parent_id` ASC),
  CONSTRAINT `fk_acos_acos1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `asui`.`acos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `asui`.`aros`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `asui`.`aros` ;

CREATE TABLE IF NOT EXISTS `asui`.`aros` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `model` VARCHAR(255) NULL DEFAULT '',
  `foreign_key` INT(10) UNSIGNED NULL DEFAULT NULL,
  `alias` VARCHAR(255) NULL DEFAULT '',
  `lft` INT(10) NULL DEFAULT NULL,
  `rght` INT(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_aros_aros1_idx` (`parent_id` ASC),
  CONSTRAINT `fk_aros_aros1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `asui`.`aros` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `asui`.`aros_acos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `asui`.`aros_acos` ;

CREATE TABLE IF NOT EXISTS `asui`.`aros_acos` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `aro_id` INT(10) UNSIGNED NOT NULL,
  `aco_id` INT(10) UNSIGNED NOT NULL,
  `_create` CHAR(2) NOT NULL DEFAULT '0',
  `_read` CHAR(2) NOT NULL DEFAULT '0',
  `_update` CHAR(2) NOT NULL DEFAULT '0',
  `_delete` CHAR(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX `aro_ix` (`aro_id` ASC),
  INDEX `aco_ix` (`aco_id` ASC),
  CONSTRAINT `aros_fk`
    FOREIGN KEY (`aro_id`)
    REFERENCES `asui`.`aros` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `acos_fk`
    FOREIGN KEY (`aco_id`)
    REFERENCES `asui`.`acos` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `asui`.`user_groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `asui`.`user_groups` ;

CREATE TABLE IF NOT EXISTS `asui`.`user_groups` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `parent_id` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_groups_user_groups1_idx` (`parent_id` ASC),
  CONSTRAINT `fk_user_groups_user_groups1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `asui`.`user_groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `asui`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `asui`.`users` ;

CREATE TABLE IF NOT EXISTS `asui`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 0,
  `user_group_id` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_asui_users_asui_user_groups_idx` (`user_group_id` ASC),
  CONSTRAINT `fk_asui_users_asui_user_groups`
    FOREIGN KEY (`user_group_id`)
    REFERENCES `asui`.`user_groups` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `asui`.`aros`
-- -----------------------------------------------------
START TRANSACTION;
USE `asui`;
INSERT INTO `asui`.`aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES (1, NULL, 'UserGroup', 1, 'Registered Users', 1, 2);
INSERT INTO `asui`.`aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES (2, NULL, 'UserGroup', 2, 'Administrators', 3, 4);

COMMIT;


-- -----------------------------------------------------
-- Data for table `asui`.`user_groups`
-- -----------------------------------------------------
START TRANSACTION;
USE `asui`;
INSERT INTO `asui`.`user_groups` (`id`, `title`, `parent_id`) VALUES (1, 'Registered Users', NULL);
INSERT INTO `asui`.`user_groups` (`id`, `title`, `parent_id`) VALUES (2, 'Administrators', NULL);

COMMIT;

