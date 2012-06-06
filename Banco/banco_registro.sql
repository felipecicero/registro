SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

-- -----------------------------------------------------
-- Table `Registro`.`car_situacoes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_situacoes` (
  `idSituacoes` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`idsituacoes`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Registro`.`car_pedidos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_pedidos` (
  `idPedido` INT NOT NULL AUTO_INCREMENT ,
  `datapedido` TIMESTAMP NOT NULL ,
  `tipodocumentorequerente` ENUM('1','2','5') NULL ,
  `documentorequerente` VARCHAR(14) NULL ,
  `requerente` VARCHAR(50) NOT NULL ,
  `telefone` VARCHAR(50) NULL ,
  `dataprevista` DATE NULL ,
  `datacancelamento` DATE NULL ,
  `valorpedido` DOUBLE NOT NULL ,
  `valordeposito` DOUBLE NULL ,
  `valorreceber` DOUBLE NOT NULL ,
  `idSituacoes` INT NOT NULL ,
  PRIMARY KEY (`idPedido`) ,
  INDEX `fk_pedidos_situacoes1` (`idSituacoes` ASC) ,
    FOREIGN KEY (`idSituacoes`) REFERENCES `car_situacoes` (`idSituacoes`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Registro`.`car_natureza`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_natureza` (
  `idNatureza` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`idNatureza`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Registro`.`car_tipodocumentos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_tipodocumentos` (
  `idTipodocumentos` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(50) NOT NULL ,
  `natureza` VARCHAR(45) NOT NULL ,
  `idNatureza` INT NOT NULL ,
  PRIMARY KEY (`idTipodocumentos`) ,
  INDEX `fk_car_tipodocumentos_car_natureza1` (`idNatureza` ASC) ,
    FOREIGN KEY (`idNatureza`) REFERENCES `car_natureza` (`idNatureza`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Registro`.`car_vigencia`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_vigencia` (
  `idVigencia` INT NOT NULL AUTO_INCREMENT ,
  `data` DATE NOT NULL ,
  PRIMARY KEY (`idVigencia`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Registro`.`car_emolumentos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_emolumentos` (
  `idEmolumentos` INT NOT NULL AUTO_INCREMENT ,
  `valorinicial` DOUBLE NOT NULL ,
  `valorfinal` DOUBLE NOT NULL ,
  `emolumentos` DOUBLE NOT NULL ,
  `idVigencia` INT NOT NULL ,
  `idTipodocumentos` INT NOT NULL ,
  PRIMARY KEY (`idEmolumentos`) ,
  INDEX `fk_car_emolumentos_car_vigencia1` (`idVigencia` ASC) ,
  INDEX `fk_car_emolumentos_car_tipodocumentos1` (`idTipodocumentos` ASC) ,
    FOREIGN KEY (`idVigencia`) REFERENCES `car_vigencia` (`idVigencia`),
    FOREIGN KEY (`idTipodocumentos`) REFERENCES `car_tipodocumentos` (`idTipodocumentos`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Registro`.`car_pessoas`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_pessoas` (
  `idPessoas` INT NOT NULL AUTO_INCREMENT ,
  `tipodocumento` ENUM('1','2','3','4','5') NULL ,
  `documento` VARCHAR(45) NULL ,
  `nome` VARCHAR(50) NULL ,
  PRIMARY KEY (`idPessoas`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Registro`.`car_itempedidos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_itempedidos` (
  `idItempedido` INT NOT NULL AUTO_INCREMENT ,
  `datasituacao` DATE NULL ,
  `idEmolumentos` INT NOT NULL ,
  `numeropaginas` INT NOT NULL ,
  `numerovias` VARCHAR(45) NULL ,
  `quantidadepessoasnotificadas` INT NULL ,
  `valordocumento` DOUBLE NULL ,
  `outrasdespesas` DOUBLE NULL ,
  `notificante_fkpessoas` INT NULL ,
  `notificado_fkpessoas` INT NULL ,
  `motivo` BLOB NULL ,
  `idPedido` INT NOT NULL ,
  `idSituacoes` INT NOT NULL ,
  `idTipodocumentos` INT NOT NULL ,
  `idPessoasnotificado` INT NOT NULL ,
  `idPessoasnotificante` INT NOT NULL ,
  PRIMARY KEY (`idItempedido`) ,
  INDEX `fk_itempedido_pedido` (`idPedido` ASC) ,
  INDEX `fk_itempedidos_situacoes1` (`idSituacoes` ASC) ,
  INDEX `fk_car_itempedidos_car_tipodocumentos1` (`idTipodocumentos` ASC) ,
  INDEX `fk_car_itempedidos_car_emolumentos1` (`idEmolumentos` ASC) ,
  INDEX `fk_car_itempedidos_car_pessoas1` (`idPessoasnotificado` ASC) ,
  INDEX `fk_car_itempedidos_car_pessoas2` (`idPessoasnotificante` ASC) ,
    FOREIGN KEY (`idPedido`) REFERENCES `car_pedidos` (`idPedido`),
    FOREIGN KEY (`idSituacoes`) REFERENCES `car_situacoes` (`idSituacoes`),
    FOREIGN KEY (`idTipodocumentos`) REFERENCES `car_tipodocumentos` (`idTipodocumentos`),
    FOREIGN KEY (`idEmolumentos`) REFERENCES `car_emolumentos` (`idEmolumentos`),
    FOREIGN KEY (`idPessoasnotificado`) REFERENCES `car_pessoas` (`idPessoas`),
    FOREIGN KEY (`idPessoasnotificante`) REFERENCES `car_pessoas` (`idPessoas`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Registro`.`car_selos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_selos` (
  `idSelos` INT NOT NULL ,
  `tipo` VARCHAR(50) NULL ,
  `serie` VARCHAR(5) NULL ,
  `numeroinicial` INT NULL ,
  `numerofinal` INT NULL ,
  `notafiscal` INT NULL ,
  `data_nota` DATE NULL ,
  `data_inclusao` TIMESTAMP NULL ,
  PRIMARY KEY (`idSelos`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Registro`.`car_controleselos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_controleselos` (
  `idControleselos` INT NOT NULL ,
  `numero` INT NOT NULL ,
  `idSelos` INT NOT NULL ,
  PRIMARY KEY (`idControleselos`) ,
  INDEX `fk_car_controleselos_car_selos1` (`idSelos` ASC) ,
    FOREIGN KEY (`idSelos`) REFERENCES `car_selos` (`idSelos`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Registro`.`car_registro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_registro` (
  `idRegistro` INT NOT NULL AUTO_INCREMENT,
  `idProtocolo` INT NOT NULL ,
  `idItempedido` INT NOT NULL ,
  `livro` VARCHAR(1) NOT NULL ,
  `observacao` BLOB NULL ,
  `idSituacoes` INT NOT NULL ,
  `data` DATE NULL ,
  `idControleselos` INT NOT NULL ,
  PRIMARY KEY (`idRegistro`, `idSituacoes`) ,
  INDEX `fk_registro_car_itempedidos1` (`idItempedido` ASC) ,
  INDEX `fk_car_registro_car_situacoes1` (`idSituacoes` ASC) ,
  INDEX `fk_car_registro_car_controleselos1` (`idControleselos` ASC) ,
  INDEX `fk_car_registro_car_protocolo1` (`idProtocolo` ASC) ,
    FOREIGN KEY (`idItempedido`) REFERENCES `car_itempedidos` (`idItempedido`),
    FOREIGN KEY (`idSituacoes`) REFERENCES `car_situacoes` (`idSituacoes`),
    FOREIGN KEY (`idControleselos`) REFERENCES `car_controleselos` (`idControleselos`),
	FOREIGN KEY (`idProtocolo`) REFERENCES `car_protocolo` (`idProtocolo`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Registro`.`car_protocolo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_protocolo` (
  `idProtocolo` INT NOT NULL AUTO_INCREMENT ,
  `data` DATE NULL ,
  PRIMARY KEY (`idProtocolo`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Registro`.`car_pessoascitadas`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_pessoascitadas` (
  `idPessoascitadas` INT NOT NULL AUTO_INCREMENT ,
  `idPessoas` INT NOT NULL ,
  `idRegistro` INT NOT NULL ,
  `notificar` ENUM('1','2') NOT NULL ,
  PRIMARY KEY (`idPessoascitadas`) ,
  INDEX `fk_car_pessoascitadas_car_pessoas1` (`idPessoas` ASC) ,
  INDEX `fk_car_pessoascitadas_car_registro1` (`idRegistro` ASC) ,
    FOREIGN KEY (`idPessoas`) REFERENCES `car_pessoas` (`idPessoas`),
    FOREIGN KEY (`idRegistro`) REFERENCES `car_registro` (`idRegistro`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Registro`.`car_pedidocertidao`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `car_pedidocertidao` (
  `idPedidocertidao` INT NOT NULL AUTO_INCREMENT ,
  `datasituacao` DATE NULL ,
  `datapedido` TIMESTAMP NULL ,
  `idSituacoes` INT NOT NULL ,
  `idPessoas` INT NOT NULL ,
  PRIMARY KEY (`idPedidocertidao`) ,
  INDEX `fk_car_pedidocertidao_car_situacoes1` (`idSituacoes` ASC) ,
  INDEX `fk_car_pedidocertidao_car_pessoas1` (`idPessoas` ASC) ,
    FOREIGN KEY (`idSituacoes`) REFERENCES `car_situacoes` (`idSituacoes`),
    FOREIGN KEY (`idPessoas`) REFERENCES `car_pessoas` (`idPessoas`))
ENGINE = InnoDB;




-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_abrangencia`
--

CREATE TABLE IF NOT EXISTS `car_abrangencia` (
  `idFaixacep` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idCidade` int(10) unsigned NOT NULL,
  `inicio` int(10) unsigned DEFAULT NULL,
  `limite` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idFaixacep`),
  KEY `cap_faixadecep_FK_cidades` (`idCidade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_aceites`
--

CREATE TABLE IF NOT EXISTS `car_aceites` (
  `idAceite` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `idProtesto` int(10) unsigned NOT NULL,
  `idAlegacao` int(10) unsigned NOT NULL DEFAULT '0',
  `data_envio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `arquivo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idAceite`),
  KEY `cap_aceites_FK_usuarios` (`idUsuario`),
  KEY `cap_aceites_FK_titulos` (`idProtesto`),
  KEY `idAlegacao` (`idAlegacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_agencias`
--

CREATE TABLE IF NOT EXISTS `car_agencias` (
  `idAgencia` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idBanco` int(10) unsigned NOT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idAgencia`),
  KEY `cap_agencias_FK_bancos` (`idBanco`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_alegacoes`
--

CREATE TABLE IF NOT EXISTS `car_alegacoes` (
  `idAlegacao` int(10) NOT NULL AUTO_INCREMENT,
  `alegacao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idAlegacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Estrutura da tabela `cap_amigos`
--

CREATE TABLE IF NOT EXISTS `car_amigos` (
  `idAmigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idEndereco` int(10) DEFAULT NULL,
  `documento` varchar(14) DEFAULT NULL,
  `tipo_documento` int(10) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `celular` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `observacoes` text,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idAmigo`),
  KEY `idEndereco` (`idEndereco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_arquivos`
--

CREATE TABLE IF NOT EXISTS `car_arquivos` (
  `idArquivo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `arquivo` varchar(50) NOT NULL,
  `tipo` int(10) unsigned DEFAULT NULL,
  `data_envio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idArquivo`,`idUsuario`),
  KEY `cap_arquivo_FK_usuarios` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;


-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_autoridades`
--

CREATE TABLE IF NOT EXISTS `car_autoridades` (
  `idAutoridade` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idAutoridade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_bancos`
--

CREATE TABLE IF NOT EXISTS `car_bancos` (
  `idBanco` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(5) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idBanco`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Estrutura da tabela `cap_boletos`
--

CREATE TABLE IF NOT EXISTS `car_boletos` (
  `idBoleto` int(10) NOT NULL AUTO_INCREMENT,
  `agencia` int(3) NOT NULL,
  `banco` varchar(20) NOT NULL,
  `quantitulos` int(8) NOT NULL,
  `valortotal` double NOT NULL,
  `valorpago` double NOT NULL,
  `idArquivo` int(11) NOT NULL,
  PRIMARY KEY (`idBoleto`),
  KEY `idArquivo` (`idArquivo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;


--
-- Estrutura da tabela `cap_cabecalhos`
--

CREATE TABLE IF NOT EXISTS `car_cabecalhos` (
  `idCabecalho` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idPortador` int(10) unsigned NOT NULL DEFAULT '0',
  `idregistro` int(10) unsigned DEFAULT NULL,
  `datamovimento` date DEFAULT NULL,
  `idtransacao_remetente` varchar(3) DEFAULT NULL,
  `idtransacao_destinatario` varchar(3) DEFAULT NULL,
  `idtransacao_tipo` varchar(3) DEFAULT NULL,
  `numerosequencialremessa` int(10) unsigned DEFAULT NULL,
  `quantidaderegistrosremessa` int(10) unsigned DEFAULT NULL,
  `quantidadetitulosremessa` int(10) unsigned DEFAULT NULL,
  `quantidadeindicacoesremessa` int(10) unsigned DEFAULT NULL,
  `quantidadeoriginaisremessa` int(10) unsigned DEFAULT NULL,
  `idagenciacentralizadora` varchar(6) DEFAULT NULL,
  `versaolayout` int(10) unsigned DEFAULT NULL,
  `codigomunicipiopracapagamento` int(10) unsigned DEFAULT NULL,
  `numerosequencialarquivo` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idCabecalho`,`idPortador`),
  KEY `idPortador` (`idPortador`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_cartorio`
--

CREATE TABLE IF NOT EXISTS `car_cartorio` (
  `idCartorio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idEndereco` int(10) unsigned NOT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `nomefantasia` varchar(50) DEFAULT NULL,
  `cnpj` varchar(14) DEFAULT NULL,
  `codigo` int(10) unsigned DEFAULT NULL,
  `telefone` varchar(14) DEFAULT NULL,
  `site` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `idAgencia` int(11) DEFAULT NULL,
  `conta` varchar(20) DEFAULT NULL,
  `carteira` varchar(3) DEFAULT NULL,
  `tabeliao` varchar(50) DEFAULT NULL,
  `substituto` varchar(50) DEFAULT NULL,
  `escrevente` varchar(50) DEFAULT NULL,
  `notificacao` int(10) DEFAULT NULL,
  `razao` varchar(30) DEFAULT NULL,
  `codigo_empresa` int(10) DEFAULT NULL,
  PRIMARY KEY (`idCartorio`,`idEndereco`),
  KEY `cap_cartorio_FK_enderecos` (`idEndereco`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_cidades`
--

CREATE TABLE IF NOT EXISTS `car_cidades` (
  `idCidade` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idEstado` int(10) unsigned NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idCidade`),
  KEY `cap_cidades_FK_estados` (`idEstado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11241 ;



--
-- Estrutura da tabela `cap_controleselos`
--

CREATE TABLE IF NOT EXISTS `car_controleselos` (
  `idControleSelo` int(10) NOT NULL AUTO_INCREMENT,
  `idProtesto` int(10) DEFAULT NULL,
  `idSituacao` int(10) DEFAULT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `data_utilizacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idControleSelo`),
  UNIQUE KEY `numero` (`numero`),
  KEY `idProtesto` (`idProtesto`),
  KEY `idSituacao` (`idSituacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=444 ;



--
-- Estrutura da tabela `cap_custas`
--

CREATE TABLE IF NOT EXISTS `car_custas` (
  `idCusta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idVigencia` int(10) unsigned NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `valor` double DEFAULT NULL,
  PRIMARY KEY (`idCusta`),
  KEY `cap_custas_FK_vigencia` (`idVigencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_editais`
--

CREATE TABLE IF NOT EXISTS `car_editais` (
  `idEdital` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idProtesto` int(10) unsigned NOT NULL,
  `data_edital` date DEFAULT NULL,
  PRIMARY KEY (`idEdital`),
  UNIQUE KEY `idProtesto` (`idProtesto`),
  KEY `cap_editais_FK_protestos` (`idProtesto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Estrutura da tabela `cap_emolumentos`
--

CREATE TABLE IF NOT EXISTS `car_emolumentos` (
  `idEmolumento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idVigencia` int(10) unsigned NOT NULL,
  `valor_inicial` double DEFAULT NULL,
  `valor_final` double DEFAULT NULL,
  `emolumento` double DEFAULT NULL,
  PRIMARY KEY (`idEmolumento`),
  KEY `cap_emolumentos_FK_vigencia` (`idVigencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;


--
-- Estrutura da tabela `cap_enderecos`
--

CREATE TABLE IF NOT EXISTS `car_enderecos` (
  `idEndereco` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idCidade` int(10) unsigned NOT NULL,
  `rua` varchar(45) DEFAULT NULL,
  `numero` varchar(15) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `cep` int(11) DEFAULT NULL,
  `bairro` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idEndereco`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Estrutura da tabela `cap_especietitulos`
--

CREATE TABLE IF NOT EXISTS `car_especietitulos` (
  `idEspecietitulo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(3) DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idEspecietitulo`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;


--
-- Estrutura da tabela `cap_estados`
--

CREATE TABLE IF NOT EXISTS `car_estados` (
  `idEstado` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `sigla` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`idEstado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;




CREATE TABLE IF NOT EXISTS `car_feriados` (
  `idFeriado` int(10) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idFeriado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;



--
-- Estrutura da tabela `cap_historico`
--

CREATE TABLE IF NOT EXISTS `car_historico` (
  `idHistorico` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idSituacao` int(10) unsigned NOT NULL,
  `idTitulo` int(10) unsigned NOT NULL,
  `idProtesto` int(10) unsigned NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `data_historico` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idHistorico`,`idSituacao`,`idTitulo`,`idProtesto`),
  KEY `cap_historico_FK_titulo` (`idTitulo`,`idSituacao`),
  KEY `cap_historico_FK_protesto` (`idProtesto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1099 ;


CREATE TABLE IF NOT EXISTS `car_livro` (
  `idLivro` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folha` int(10) unsigned DEFAULT NULL,
  `livro` int(10) unsigned DEFAULT NULL,
  `data_protesto` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idLivro`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;


--
-- Estrutura da tabela `cap_logs`
--

CREATE TABLE IF NOT EXISTS `car_logs` (
  `idLog` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) unsigned NOT NULL,
  `descricao` text,
  `data_log` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idLog`),
  KEY `cap_logs_FK_cap_usuarios` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


-- Estrutura da tabela `cap_pessoa`
--

CREATE TABLE IF NOT EXISTS `car_pessoa` (
  `idPessoa` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_identificacao` varchar(3) DEFAULT NULL,
  `numeroidentificacao` varchar(14) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `idEndereco` int(10) unsigned NOT NULL,
  `idAgencia` int(10) unsigned NOT NULL,
  `observacoes` text NOT NULL,
  PRIMARY KEY (`idPessoa`),
  KEY `cap_pessoa_FK_agencias` (`idAgencia`),
  KEY `cap_pessoa_FK_ruas` (`idEndereco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_portadores`
--

CREATE TABLE IF NOT EXISTS `car_portadores` (
  `idPortador` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numerocodigoportador` int(10) unsigned DEFAULT NULL,
  `nomeportador` varchar(40) DEFAULT NULL,
  `idagenciacentralizadora` int(10) DEFAULT NULL,
  PRIMARY KEY (`idPortador`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


--
-- Estrutura da tabela `cap_protestos`
--

CREATE TABLE IF NOT EXISTS `car_protestos` (
  `idProtesto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idVigencia` int(10) unsigned NOT NULL DEFAULT '0',
  `idArquivo` int(10) unsigned NOT NULL,
  `idTitulo` int(10) unsigned NOT NULL,
  `idLivro` int(10) unsigned DEFAULT NULL,
  `data_entrada` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `idProtocolo` int(10) NOT NULL,
  PRIMARY KEY (`idProtesto`,`idVigencia`),
  UNIQUE KEY `idLivro` (`idLivro`),
  KEY `cap_protestos_FK_arquivos` (`idArquivo`),
  KEY `cap_protestos_FK_titulo` (`idTitulo`),
  KEY `cap_protestos_FK_vigencias` (`idVigencia`),
  KEY `idProtocolo` (`idProtocolo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;


CREATE TABLE IF NOT EXISTS `car_protocolos` (
  `idProtocolo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `protocolo` int(10) DEFAULT NULL,
  `situacao` int(10) unsigned DEFAULT NULL,
  `data_protocolo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idProtocolo`),
  UNIQUE KEY `protocolo` (`protocolo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cap_selos`
--

CREATE TABLE IF NOT EXISTS `car_selos` (
  `idSelo` int(10) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL DEFAULT '0',
  `serie` varchar(5) DEFAULT NULL,
  `numeroinicial` int(10) DEFAULT NULL,
  `numerofinal` int(10) DEFAULT NULL,
  `notafiscal` int(10) DEFAULT NULL,
  `data_nota` date DEFAULT NULL,
  `data_inclusao` timestamp NULL DEFAULT NULL,
  `quantidade` int(11) DEFAULT '0',
  PRIMARY KEY (`idSelo`),
  UNIQUE KEY `serie` (`serie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


--
-- Estrutura da tabela `cap_situacao`
--

CREATE TABLE IF NOT EXISTS `car_situacao` (
  `idSituacao` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(2) NOT NULL DEFAULT '0',
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idSituacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;


--
-- Estrutura da tabela `cap_usuarios`
--

CREATE TABLE IF NOT EXISTS `car_usuarios` (
  `idUsuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idPapel` int(10) unsigned NOT NULL DEFAULT '1',
  `email` varchar(100) DEFAULT NULL,
  `login` varchar(20) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `telefone` varchar(14) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT NULL,
  `data_ultimoacesso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`),
  KEY `idPerfil` (`idPapel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Estrutura da tabela `cap_vigencias`
--

CREATE TABLE IF NOT EXISTS `car_vigencias` (
  `idVigencia` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vigencia` date DEFAULT NULL,
  PRIMARY KEY (`idVigencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Estrutura da tabela `cart_papeis`
--

CREATE TABLE IF NOT EXISTS `cart_papeis` (
  `idPapel` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `papel` varchar(25) DEFAULT NULL,
  `descricao` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`idPapel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


-- --------------------------------------------------------

--
-- Estrutura da tabela `cart_permissoes`
--

CREATE TABLE IF NOT EXISTS `cart_permissoes` (
  `idPermissao` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idPapel` int(10) unsigned NOT NULL,
  `idRecurso` int(10) unsigned DEFAULT NULL,
  `permissao` enum('allow','deny') NOT NULL,
  PRIMARY KEY (`idPermissao`),
  KEY `idPapel` (`idPapel`),
  KEY `idRecurso` (`idRecurso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cart_recursos`
--

CREATE TABLE IF NOT EXISTS `cart_recursos` (
  `idRecurso` int(10) NOT NULL AUTO_INCREMENT,
  `recurso` varchar(100) DEFAULT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `idPai` int(10) DEFAULT '0',
  PRIMARY KEY (`idRecurso`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
