/*Create a schema called Viper and execute this script*/

CREATE  TABLE `viper`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nick` VARCHAR(128) NOT NULL ,
  `login` VARCHAR(128) NULL ,
  `password` VARCHAR(128) NULL ,
  `flags` VARCHAR(30) NULL ,
  `rank` VARCHAR(10) NULL ,
  `active` VARCHAR(5) NOT NULL DEFAULT 'false' ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `nick_UNIQUE` (`nick` ASC) ,
  UNIQUE INDEX `login_UNIQUE` (`login` ASC) );