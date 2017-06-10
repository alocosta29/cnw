DROP TABLE IF EXISTS `ads_keywords`;
DROP TABLE IF EXISTS `ads_ads`;
DROP TABLE IF EXISTS `ads_types`;
DROP TABLE IF EXISTS `ads_categories`;

CREATE TABLE IF NOT EXISTS `ads_types` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `max_width` INT(11) NULL DEFAULT NULL,
  `min_width` INT(11) NULL DEFAULT NULL,
  `max_height` INT(11) NULL DEFAULT NULL,
  `min_height` INT(11) NULL DEFAULT NULL,
  `tipo` VARCHAR(200) NULL DEFAULT NULL,
  `alias` VARCHAR(200) NOT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `created` DATETIME NULL DEFAULT NULL,
  `createdby` INT(11) NULL DEFAULT NULL,
  `modified` DATETIME NULL DEFAULT NULL,
  `modifiedby` INT(11) NULL DEFAULT NULL,
  `isactive` CHAR(1) NULL DEFAULT 'Y',
  `isdeleted` CHAR(1) NULL DEFAULT 'N',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `ads_ads` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `type_id` INT(11) NOT NULL,
  `caderno_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `imagem` VARCHAR(250) NOT NULL,
  `link` TEXT NOT NULL,
  `data_inicio` DATETIME NULL DEFAULT NULL,
  `data_fim` DATETIME NULL DEFAULT NULL,
  `approvedby` INT(11) NULL DEFAULT NULL,
  `disapprovedby` INT(11) NULL DEFAULT NULL,
  `versao` INT(11) NULL DEFAULT '1',
`comments` TEXT NULL DEFAULT NULL,
  `status` CHAR(1) NULL DEFAULT 'R' COMMENT 'P -> Publicado/Programado\nR -> Rascunho\nN -> Reprovado\nA -> Em análise\nO -> Oculta(para casos de desligamento de colunista, em que for necessário tal ação)',
  `isdeleted` CHAR(1) NULL DEFAULT 'N',
  PRIMARY KEY (`id`, `type_id`, `caderno_id`, `user_id`),
  INDEX `fk_ads_ads_ads_types1_idx` (`type_id` ASC),
  INDEX `fk_ads_ads_cw_cadernos1_idx` (`caderno_id` ASC),
  INDEX `fk_ads_ads_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_ads_ads_ads_types1`
    FOREIGN KEY (`type_id`)
    REFERENCES `ads_types` (`id`)
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
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
