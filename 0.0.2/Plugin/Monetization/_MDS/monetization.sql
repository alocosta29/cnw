CREATE TABLE IF NOT EXISTS `ads_types` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `max_width` INT(11) NULL COMMENT '',
  `min_width` INT(11) NULL COMMENT '',
  `max_height` INT(11) NULL COMMENT '',
  `min_height` INT(11) NULL COMMENT '',
  `tipo` VARCHAR(200) NULL COMMENT '',
 `alias` VARCHAR(200) NOT NULL COMMENT '',
  `descricao` TEXT NULL COMMENT '',
  `created` DATETIME NULL COMMENT '',
  `createdby` INT(11) NULL COMMENT '',
  `modified` DATETIME NULL COMMENT '',
  `modifiedby` INT(11) NULL COMMENT '',
  `isactive` CHAR(1) NULL DEFAULT 'Y' COMMENT '',
  `isdeleted` CHAR(1) NULL DEFAULT 'N' COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `ads_categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `nome` VARCHAR(250) NOT NULL COMMENT '',
  `created` DATETIME NULL COMMENT '',
  `createdby` INT(11) NULL COMMENT '',
  `modified` DATETIME NULL COMMENT '',
  `modifiedby` INT(11) NULL COMMENT '',
  `isdeleted` CHAR(1) NULL DEFAULT 'N' COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `ads_ads` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `type_id` INT(11) NOT NULL COMMENT '',
  `categorie_id` INT(11) NOT NULL COMMENT '',
  `caderno_id` INT(11) NOT NULL COMMENT '',
  `user_id` INT(11) NOT NULL COMMENT '',
  `keywords` TEXT NULL COMMENT '',
  `imagem` VARCHAR(250) NOT NULL COMMENT '',
  `link` TEXT NOT NULL COMMENT '',
  `data_inicio` DATETIME NULL COMMENT '',
  `data_fim` DATETIME NULL COMMENT '',
  `approvedby` INT(11) NULL COMMENT '',
  `disapprovedby` INT(11) NULL COMMENT '',
  `status` CHAR(1) NULL DEFAULT 'R' COMMENT 'P -> Publicado/Programado\nR -> Rascunho\nN -> Reprovado\nA -> Em análise\nO -> Oculta(para casos de desligamento de colunista, em que for necessário tal ação)',
  `isdeleted` CHAR(1) NULL COMMENT '',
  PRIMARY KEY (`id`, `type_id`, `categorie_id`, `caderno_id`, `user_id`)  COMMENT '',
  INDEX `fk_ads_ads_ads_types1_idx` (`type_id` ASC)  COMMENT '',
  INDEX `fk_ads_ads_ads_categories1_idx` (`categorie_id` ASC)  COMMENT '',
  INDEX `fk_ads_ads_cw_cadernos1_idx` (`caderno_id` ASC)  COMMENT '',
  INDEX `fk_ads_ads_users1_idx` (`user_id` ASC)  COMMENT '',
  CONSTRAINT `fk_ads_ads_ads_types1`
    FOREIGN KEY (`type_id`)
    REFERENCES `ads_types` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ads_ads_ads_categories1`
    FOREIGN KEY (`categorie_id`)
    REFERENCES `ads_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ads_ads_cw_cadernos1`
    FOREIGN KEY (`caderno_id`)
    REFERENCES `cw_cadernos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ads_ads_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
