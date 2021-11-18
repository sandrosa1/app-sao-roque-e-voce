
-- ////////////////////////////////////////////////////////////CLIENTES/////////////////////////////////////////////////////--

  CREATE TABLE IF NOT EXISTS `sistema`.`customer` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `cpf` VARCHAR(14) NULL,
  `email` varchar(255) NOT NULL,
  `phone` VARCHAR(15) NULL,
  `password` varchar(90) NOT NULL,
  `birthDate` varchar(15) NOT NULL,
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `permission` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

-- Exemplo
 INSERT INTO `sistema`.`customer` (`name`, `cpf`, `email`, `phone`, `password`, `birthdate`, `createDate`, `permission`, `status`) VALUES
  ('Sandro', '288.666.888-33', 'sandrosa1@gmail.com', '(11)95154-3859', '123', '15/03/1976', '2021-10-24 22:28:18', 'user', 'confirmation');

  CREATE TABLE IF NOT EXISTS `sistema`.`attempt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) CHARACTER SET latin1 NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `sistema`.`confirmation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(90) NOT NULL,
  `token` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;