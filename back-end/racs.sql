
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

--///////////////////////////////////////////RACS////////////////////////////////////////////////////

  CREATE TABLE IF NOT EXISTS `sistema`.`racs` (
  `idRoot` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `nickName` varchar(90) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(90) NOT NULL,
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `permission` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`idRoot`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;


 INSERT INTO `racs` (`name`, `nickName`, `email`,`password`, `createDate`, `permission`, `status`) VALUES
            ('Sandro Amancio', 'Sandro-Sa', 'mueuemail@gmail.com','minhahashsenha','2021-10-24 22:28:18', 'admin', 'active');

--/////////////////////////////////////////////APP///////////////////////////////////////////

CREATE TABLE `sistema`.`app` (
  `idApp` INT NOT NULL ,
  `nomeFantasia` VARCHAR(100) NOT NULL,
  `segmento` VARCHAR(45) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `email` VARCHAR(145) NOT NULL,
  `telefone` VARCHAR(16) NULL,
  `celular` VARCHAR(17) NULL,
  `cep` VARCHAR(9) NOT NULL,
  `logradouro` VARCHAR(245) NOT NULL,
  `numero` VARCHAR(20) NOT NULL,
  `bairro` VARCHAR(45) NOT NULL,
  `localidade` VARCHAR(9) NULL,
  `chaves` VARCHAR(245) NULL,
  `visualizacao` INT NULL,
  `totalCusto` INT NULL,
  `totalvaliacao` INT NULL,
  `custo` INT NULL,
  `avaliacao` INT NULL,
  `img1` VARCHAR(255) NULL,
  `adicionais` VARCHAR(245) NULL,
  PRIMARY KEY (`idApp`),
  UNIQUE INDEX `idApp_UNIQUE` (`idApp` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
  UNIQUE INDEX `telefone_UNIQUE` (`telefone` ASC) VISIBLE,
  UNIQUE INDEX `celular_UNIQUE` (`celular` ASC) VISIBLE);



CREATE TABLE `sistema`.`appComercio` (
  `idAppComercio` INT NOT NULL AUTO_INCREMENT,
  `idApp` INT NOT NULL,
  `estacionamento` INT(1) NULL,
  `acessibilidade` INT(1) NULL,
  `entregaDomicilio` INT(1) NULL,
  `whatsapp` INT(1) NULL,
  `semana` VARCHAR(14) NULL,
  `sabado` VARCHAR(14) NULL,
  `domigo` VARCHAR(14) NULL,
  `feriado` VARCHAR(14) NULL,
  `img2` VARCHAR(150) NULL,
  `img3` VARCHAR(150) NULL,
  `descricao` TEXT(1000) NULL,
  PRIMARY KEY (`idAppComercio`));

  CREATE TABLE `sistema`.`appEvento` (
  `idAppEvento` INT NOT NULL AUTO_INCREMENT,
  `idApp` INT NOT NULL,
  `estacionamento` INT(1) NULL,
  `acessibilidade` INT(1) NULL,
  `wiFi` INT(1) NULL,
  `trilhas` INT(1) NULL,
  `refeicao` INT(1) NULL,
  `emporio` INT(1) NULL,
  `adega` INT(1) NULL,
  `bebidas` INT(1) NULL,
  `sorveteria` INT(1) NULL,
  `musica` INT(1) NULL,
  `whatsapp` INT(1) NULL,
  `semana` VARCHAR(14) NULL,
  `sabado` VARCHAR(14) NULL,
  `domigo` VARCHAR(14) NULL,
  `feriado` VARCHAR(14) NULL,
  `img2` VARCHAR(150) NULL,
  `img3` VARCHAR(150) NULL,
  `descricao` TEXT(1000) NULL,
  PRIMARY KEY (`idAppEvento`));

  CREATE TABLE `sistema`.`appGastronomia` (
  `idAppGastronomia` INT NOT NULL AUTO_INCREMENT,
  `idApp` INT NOT NULL,
  `estacionamento` INT(1) NULL,
  `acessibilidade` INT(1) NULL,
  `wiFi` INT(1) NULL,
  `briquedos` INT(1) NULL,
  `restaurante` INT(1) NULL,
  `emporio` INT(1) NULL,
  `adega` INT(1) NULL,
  `bebidas` INT(1) NULL,
  `sorveteria` INT(1) NULL,
  `entregaDomicilio` INT(1) NULL,
  `whatsapp` INT(1) NULL,
  `semana` VARCHAR(14) NULL,
  `sabado` VARCHAR(14) NULL,
  `domigo` VARCHAR(14) NULL,
  `feriado` VARCHAR(14) NULL,
  `img2` VARCHAR(150) NULL,
  `img3` VARCHAR(150) NULL,
  `descricao` TEXT(1000) NULL,
  PRIMARY KEY (`idAppGastronomia`));

   CREATE TABLE `sistema`.`appHospedagem` (
  `idAppHospedagem` INT NOT NULL AUTO_INCREMENT,
  `idApp` INT NOT NULL,
  `estacionamento` INT(1) NULL,
  `briquedos` INT(1) NULL,
  `restaurante` INT(1) NULL,
  `arCondicionado` INT(1) NULL,
  `wiFi` INT(1) NULL,
  `academia` INT(1) NULL,
  `piscina` INT(1) NULL,
  `refeicao` INT(1) NULL,
  `emporio` INT(1) NULL,
  `adega` INT(1) NULL,
  `bebidas` INT(1) NULL,
  `sorveteria` INT(1) NULL,
  `whatsapp` INT(1) NULL,
  `semana` VARCHAR(14) NULL,
  `sabado` VARCHAR(14) NULL,
  `domigo` VARCHAR(14) NULL,
  `feriado` VARCHAR(14) NULL,
  `img2` VARCHAR(150) NULL,
  `img3` VARCHAR(150) NULL,
  `descricao` TEXT(1000) NULL,
  PRIMARY KEY (`idAppHospedagem`));
