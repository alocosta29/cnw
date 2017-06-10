/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  andreluis
 * Created: 07/04/2017
 */

CREATE TABLE IF NOT EXISTS `cwcol_extras` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(250) NOT NULL,
  `descricao` TEXT NULL,
  `arquivo` VARCHAR(200) NOT NULL,
  `tipo_arquivo` VARCHAR(45) NOT NULL,
  `artigo_id` INT(11) NOT NULL,
  `caderno_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `person_id` INT(11) NOT NULL,
  `created` DATETIME NULL,
  `createdby` INT(11) NULL,
  `modified` DATETIME NULL,
  `modifiedby` INT(11) NULL,
  `isdeleted` CHAR(1) NULL DEFAULT 'N',
  PRIMARY KEY (`id`, `artigo_id`, `caderno_id`, `user_id`, `person_id`),
  CONSTRAINT `fk_cwcol_extras_cwcol_artigos1`
    FOREIGN KEY (`artigo_id` , `caderno_id` , `user_id` , `person_id`)
    REFERENCES `cwcol_artigos` (`id` , `caderno_id` , `user_id` , `person_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


ALTER TABLE `cw_cadernos`
	ADD COLUMN `url_post_form` TEXT NULL AFTER `url_form`;

UPDATE `cnw`.`cw_cadernos` SET `url_post_form`='//crescernaweb.us12.list-manage.com/subscribe/post?u=4e277bb73808e0f705ca82f10&amp;id=021547cd97' WHERE  `id`=4;
UPDATE `cnw`.`cw_cadernos` SET `url_post_form`='//crescernaweb.us12.list-manage.com/subscribe/post?u=4e277bb73808e0f705ca82f10&amp;id=6e619e8f10' WHERE  `id`=5;
UPDATE `cnw`.`cw_cadernos` SET `url_post_form`='//crescernaweb.us12.list-manage.com/subscribe/post?u=4e277bb73808e0f705ca82f10&amp;id=1641f26865' WHERE  `id`=6;
UPDATE `cnw`.`cw_cadernos` SET `url_form`='http://eepurl.com/ca5AUz' WHERE  `id`=4;
UPDATE `cnw`.`cw_cadernos` SET `url_form`='http://eepurl.com/ccxkqj' WHERE  `id`=6;
UPDATE `cnw`.`cw_cadernos` SET `url_form`='http://eepurl.com/ccxe01' WHERE  `id`=5;

