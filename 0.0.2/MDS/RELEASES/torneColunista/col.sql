CREATE TABLE IF NOT EXISTS `cwcol_terms` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `texto` LONGTEXT NOT NULL COMMENT '',
  `created` DATETIME NULL COMMENT '',
  `createdby` INT(11) NULL COMMENT '',
  `isactive` CHAR(1) NULL DEFAULT 'Y' COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `cwcol_cadastros` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nome` VARCHAR(250) NULL DEFAULT NULL COMMENT '',
  `email` VARCHAR(250) NULL DEFAULT NULL COMMENT '',
  `mensagem` LONGTEXT NULL DEFAULT NULL COMMENT '',
  `status` CHAR(1) NULL DEFAULT 'N' COMMENT 'N-> Não avaliado, A -> Aprovado, R -> Reprovado, I -> Cadastro incompleto, F -> Finalizado',
  `obs_status` TEXT NULL COMMENT '',
  `person_id` INT(11) NULL DEFAULT NULL COMMENT '',
  `createdby` INT(11) NULL DEFAULT NULL COMMENT '',
  `created` DATETIME NULL DEFAULT NULL COMMENT '',
  `modified` DATETIME NULL DEFAULT NULL COMMENT '',
  `modifiedby` INT(11) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `cwcol_status_terms` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `cadastro_id` INT(11) NOT NULL COMMENT '',
  `aceite_termo` VARCHAR(1) NOT NULL DEFAULT 'N' COMMENT 'Informa se o termo foi aceito.\nS-> Sim\nN -> Não',
  `term_id` INT(11) NOT NULL COMMENT '',
  `text_term` LONGTEXT NULL COMMENT '',
  `created` DATETIME NULL COMMENT '',
  PRIMARY KEY (`id`, `cadastro_id`, `term_id`)  COMMENT '',
  INDEX `fk_cwcol_status_terms_cwcol_cadastros1_idx` (`cadastro_id` ASC)  COMMENT '',
  INDEX `fk_cwcol_status_terms_cwcol_terms1_idx` (`term_id` ASC)  COMMENT '',
  CONSTRAINT `fk_cwcol_status_terms_cwcol_cadastros1`
    FOREIGN KEY (`cadastro_id`)
    REFERENCES `cwcol_cadastros` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cwcol_status_terms_cwcol_terms1`
    FOREIGN KEY (`term_id`)
    REFERENCES `cwcol_terms` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `cwcol_alert_requests` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `cadastro_id` INT(11) NULL DEFAULT NULL COMMENT '',
  `user_id` INT(11) NULL DEFAULT NULL COMMENT '',
  `mail_send` CHAR(1) NULL DEFAULT 'Y' COMMENT '',
  `created` DATE NULL COMMENT '',
  `type` CHAR(1) NULL DEFAULT 'A' COMMENT '\'A -> aprovação do cadastro, B-> Login criado e ativo\'',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_cwcol_alert_requests_cwcol_cadastros1_idx` (`cadastro_id` ASC)  COMMENT '',
  INDEX `fk_cwcol_alert_requests_users1_idx` (`user_id` ASC)  COMMENT '',
  CONSTRAINT `fk_cwcol_alert_requests_cwcol_cadastros1`
    FOREIGN KEY (`cadastro_id`)
    REFERENCES `cwcol_cadastros` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cwcol_alert_requests_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `cwcol_cadastros_cadernos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `cadastro_id` INT(11) NOT NULL COMMENT '',
  `caderno_id` INT(11) NOT NULL COMMENT '',
  PRIMARY KEY (`id`, `cadastro_id`, `caderno_id`)  COMMENT '',
  INDEX `fk_cwcol_cadastros_has_cw_cadernos_cw_cadernos1_idx` (`caderno_id` ASC)  COMMENT '',
  INDEX `fk_cwcol_cadastros_has_cw_cadernos_cwcol_cadastros1_idx` (`cadastro_id` ASC)  COMMENT '',
  CONSTRAINT `fk_cwcol_cadastros_has_cw_cadernos_cw_cadernos1`
    FOREIGN KEY (`caderno_id`)
    REFERENCES `cw_cadernos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cwcol_cadastros_has_cw_cadernos_cwcol_cadastros1`
    FOREIGN KEY (`cadastro_id`)
    REFERENCES `cwcol_cadastros` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

ALTER TABLE `users`
	ADD COLUMN `type_register` CHAR(1) NULL DEFAULT 'M' COMMENT 'M->Manual, S-> Site' AFTER `pass_register`;

ALTER TABLE `cwcol_cadastros_cadernos`
	ADD COLUMN `status` CHAR(1) NULL DEFAULT 'N' COMMENT 'N-> Não avaliado, R->Reprovado, A -> Aprovado, P -> Para análise ' AFTER `caderno_id`;

ALTER TABLE `cwcol_alert_requests`
	ADD COLUMN `type` CHAR(1) NOT NULL DEFAULT 'A' COMMENT 'A -> Aviso sobre aprovação, B-> Aviso para fazer primeiro login ' AFTER `created`;

