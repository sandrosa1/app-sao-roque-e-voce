
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
  `site` VARCHAR(245) NULL,
  `visualizacao` INT NULL,
  `totalCusto` INT NULL,
  `totalAvaliacao` INT NULL,
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
  `domingo` VARCHAR(14) NULL,
  `feriado` VARCHAR(14) NULL,
  `img2` VARCHAR(150) NULL,
  `img3` VARCHAR(150) NULL,
  `descricao` TEXT(1000) NULL,
  PRIMARY KEY (`idAppComercio`),
  UNIQUE INDEX `idApp_UNIQUE` (`idApp` ASC) VISIBLE,);

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
  `domingo` VARCHAR(14) NULL,
  `feriado` VARCHAR(14) NULL,
  `img2` VARCHAR(150) NULL,
  `img3` VARCHAR(150) NULL,
  `descricao` TEXT(1000) NULL,
  PRIMARY KEY (`idAppEvento`),
  UNIQUE INDEX `idApp_UNIQUE` (`idApp` ASC) VISIBLE);


  CREATE TABLE `sistema`.`appGastronomia` (
  `idAppGastronomia` INT NOT NULL AUTO_INCREMENT,
  `idApp` INT NOT NULL,
  `estacionamento` INT(1) NULL,
  `acessibilidade` INT(1) NULL,
  `wiFi` INT(1) NULL,
  `brinquedos` INT(1) NULL,
  `restaurante` INT(1) NULL,
  `emporio` INT(1) NULL,
  `adega` INT(1) NULL,
  `bebidas` INT(1) NULL,
  `sorveteria` INT(1) NULL,
  `entregaDomicilio` INT(1) NULL,
  `whatsapp` INT(1) NULL,
  `semana` VARCHAR(14) NULL,
  `sabado` VARCHAR(14) NULL,
  `domingo` VARCHAR(14) NULL,
  `feriado` VARCHAR(14) NULL,
  `img2` VARCHAR(150) NULL,
  `img3` VARCHAR(150) NULL,
  `descricao` TEXT(1000) NULL,
  PRIMARY KEY (`idAppGastronomia`),
  UNIQUE INDEX `idApp_UNIQUE` (`idApp` ASC) VISIBLE);


   CREATE TABLE `sistema`.`appHospedagem` (
  `idAppHospedagem` INT NOT NULL AUTO_INCREMENT,
  `idApp` INT NOT NULL,
  `estacionamento` INT(1) NULL,
  `brinquedos` INT(1) NULL,
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
  `domingo` VARCHAR(14) NULL,
  `feriado` VARCHAR(14) NULL,
  `img2` VARCHAR(150) NULL,
  `img3` VARCHAR(150) NULL,
  `descricao` TEXT(1000) NULL,
  PRIMARY KEY (`idAppHospedagem`),
  UNIQUE INDEX `idApp_UNIQUE` (`idApp` ASC) VISIBLE);

   CREATE TABLE `sistema`.`appServico` (
  `idAppServico` INT NOT NULL AUTO_INCREMENT,
  `idApp` INT NOT NULL,
  `estacionamento` INT(1) NULL,
  `acessibilidade` INT(1) NULL,
  `entregaDomicilio` INT(1) NULL,
  `whatsapp` INT(1) NULL,
  `semana` VARCHAR(14) NULL,
  `sabado` VARCHAR(14) NULL,
  `domingo` VARCHAR(14) NULL,
  `feriado` VARCHAR(14) NULL,
  `logo` VARCHAR(150) NULL,
  `img2` VARCHAR(150) NULL,
  `img3` VARCHAR(150) NULL,
  `descricao` TEXT(1000) NULL,
  PRIMARY KEY (`idAppServico`),
  UNIQUE INDEX `idApp_UNIQUE` (`idApp` ASC) VISIBLE);



  CREATE TABLE `sistema`.`appTurismo` (
  `idAppTurismo` INT NOT NULL AUTO_INCREMENT,
  `idApp` INT NOT NULL,
  `estacionamento` INT(1) NULL,
  `acessibilidade` INT(1) NULL,
  `wiFi` INT(1) NULL,
  `trilhas` INT(1) NULL,
  `restaurante` INT(1) NULL,
  `brinquedos` INT(1) NULL,
  `natureza` INT(1) NULL,
  `bebidas` INT(1) NULL,
  `sorveteria` INT(1) NULL,
  `musica` INT(1) NULL,
  `semana` VARCHAR(14) NULL,
  `sabado` VARCHAR(14) NULL,
  `domingo` VARCHAR(14) NULL,
  `feriado` VARCHAR(14) NULL,
  `img2` VARCHAR(150) NULL,
  `img3` VARCHAR(150) NULL,
  `descricao` TEXT(1000) NULL,
  PRIMARY KEY (`idAppTurismo`),
  UNIQUE INDEX `idApp_UNIQUE` (`idApp` ASC) VISIBLE);

  CREATE TABLE `sistema`.`appHelp` (
  `idAppHelp` INT NOT NULL AUTO_INCREMENT,
  `wordBlock` MEDIUMTEXT NULL,
  PRIMARY KEY (`idAppHelp`));


CREATE TABLE `sistema`.`forum` (
`idforum` INT NOT NULL AUTO_INCREMENT,
`idApp` INT NULL,
`idUsuario` INT NULL,
`nome` VARCHAR(45) NULL,
`comentario` VARCHAR(500) NULL,
`utilSim` INT NULL,
`utilNao` INT NULL,
`data` DATETIME NULL,
`avaliacao` INT NULL,
PRIMARY KEY (`idforum`),
UNIQUE INDEX `idforum_UNIQUE` (`idforum` ASC) VISIBLE,
UNIQUE INDEX `idUsuario_UNIQUE` (`idUsuario` ASC) VISIBLE);

INSERT INTO `sistema`.`forum` (`idforum`, `idApp`, `idUsuario`, `nome`, `comentario`, `utilSim`, `utilNao`, `data`, `avaliacao`) VALUES ('2', '21', '2', 'José Carlos Rodrigues', 'Loja muito organizada, atendentes com dominio do assunto, presentes de qualidade', '1', '0', '2022-02-09 21:22:12', '4');



CREATE TABLE `sistema`.`usuario` (
`idusuario` INT NOT NULL AUTO_INCREMENT,
`usuarioNome` VARCHAR(50) NULL,
`sobreNome` VARCHAR(4100) NULL,
`usuarioDataNascimento` VARCHAR(10) NULL,
`usuarioEmail` VARCHAR(255) NULL,
`usuarioSenha` VARCHAR(255) NULL,
`alertNovidade` INT NULL,
`dicasPontosTuristicos` INT NULL,
`dicasRestaurantes` INT NULL,
`dicasHospedagens` INT NULL,
`alertaEventos` INT NULL,
`ativaLocalizacao` INT NULL,
PRIMARY KEY (`idusuario`),
UNIQUE INDEX `idusuario_UNIQUE` (`idusuario` ASC) VISIBLE,
UNIQUE INDEX `usuarioEmail_UNIQUE` (`usuarioEmail` ASC) VISIBLE);

INSERT INTO `sistema`.`usuario` (`idusuario`, `usuarioNome`, `sobreNome`, `usuarioDataNascimento`, `usuarioEmail`, `usuarioSenha`, `alertNovidade`, `dicasPontosTuristicos`, `dicasRestaurantes`, `dicasHospedagens`, `alertaEventos`, `ativaLocalizacao`) VALUES ('2', 'José', 'Carlos Rodrigues', '31/12/1987', 'jose@gmail.com', '123456', '0', '0', '1', '1', '1', '1');
INSERT INTO `sistema`.`usuario` (`idusuario`, `usuarioNome`, `sobreNome`, `usuarioDataNascimento`, `usuarioEmail`, `usuarioSenha`, `alertNovidade`, `dicasPontosTuristicos`, `dicasRestaurantes`, `dicasHospedagens`, `alertaEventos`, `ativaLocalizacao`) VALUES ('3', 'Marcia', 'Laravel', '28/02/1978', 'laravel@gmail.com', '123456', '0', '0', '0', '1', '1', '1');