-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema louerbd
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `louerbd`;
CREATE SCHEMA IF NOT EXISTS `louerbd` DEFAULT CHARACTER SET latin1 ;

USE `louerbd` ;

-- -----------------------------------------------------
-- Criar usuário e dar permissões
-- -----------------------------------------------------

-- Criação do usuário (substitua a senha pelo que você quiser)
CREATE USER 'loueruser'@'127.0.0.1' IDENTIFIED BY 'kivicaLOUER';

-- Permissões completas para esse banco de dados
GRANT ALL PRIVILEGES ON louerbd.* TO 'loueruser'@'127.0.0.1';

-- Aplicar permissões
FLUSH PRIVILEGES;


-- -----------------------------------------------------
-- Table `louerbd`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `louerbd`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `imagem` LONGBLOB,
  `tipo` ENUM('Cliente', 'Fornecedor', 'Gerente') NOT NULL,
  `cpf` VARCHAR(14) NULL DEFAULT NULL,
  `cnpj` VARCHAR(14) NULL DEFAULT NULL,
  `cidade` VARCHAR(100) NULL DEFAULT NULL,
  `telefone` VARCHAR(20) NULL DEFAULT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `cep` VARCHAR(9) NULL DEFAULT NULL,
  `bairro` VARCHAR(100) NULL DEFAULT NULL,
  `rua` VARCHAR(100) NULL DEFAULT NULL,
  `numero` VARCHAR(10) NULL DEFAULT NULL,
  `complemento` VARCHAR(100) NULL DEFAULT NULL,
  `conta_ativa` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email` (`email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `louerbd`.`produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `louerbd`.`produto` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(11) NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `tipo` ENUM('Espaco', 'Equipamento') NOT NULL,
  `valor_dia` DECIMAL(10,2) NULL DEFAULT NULL,
  `dias_disponiveis` SET('Dom','Seg','Ter','Qua','Qui','Sex','Sab'),
  `politica_cancelamento` TEXT NULL DEFAULT NULL,
  `cidade` VARCHAR(100) NULL DEFAULT NULL,
  `cep` VARCHAR(9) NULL DEFAULT NULL,
  `bairro` VARCHAR(100) NULL DEFAULT NULL,
  `rua` VARCHAR(100) NULL DEFAULT NULL,
  `numero` INT(10) NULL DEFAULT NULL,
  `complemento` VARCHAR(100) NULL DEFAULT NULL,
  `ativo` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `id_usuario` (`id_usuario` ASC),
  CONSTRAINT `produto_ibfk_1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `louerbd`.`usuario` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;
-- -----------------------------------------------------
-- Table `louerbd`.`disponibilidades`
-- -----------------------------------------------------
CREATE TABLE disponibilidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    data_disponivel DATE NOT NULL,
    FOREIGN KEY (id_produto) REFERENCES produto(id) ON DELETE CASCADE,
    INDEX idx_produto_data (id_produto, data_disponivel)
);
-- -----------------------------------------------------
-- Table `louerbd`.`reserva`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `louerbd`.`reserva` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(11) NULL DEFAULT NULL,
  `id_produto` INT(11) NULL DEFAULT NULL,
  `data_reserva` DATE NOT NULL,
  `data_final` DATE NOT NULL,
  `valor_reserva` DECIMAL(10,2) NULL DEFAULT NULL,
  `status` ENUM('Solicitada', 'Aprovada', 'Recusada', 'Confirmada', 'Finalizada', 'Cancelada') NULL DEFAULT 'Solicitada',
  `cancelado_por` ENUM('Cliente', 'Fornecedor', 'Gerente') NULL DEFAULT NULL,
  `motivo_cancelamento` TEXT NULL DEFAULT NULL,
  -- `data_solicitado` DATE NULL DEFAULT CURRENT_TIMESTAMP(), 
  `data_aceito_negado` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `id_usuario` (`id_usuario` ASC),
  INDEX `id_produto` (`id_produto` ASC),
  CONSTRAINT `reserva_ibfk_1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `louerbd`.`usuario` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `reserva_ibfk_2`
    FOREIGN KEY (`id_produto`)
    REFERENCES `louerbd`.`produto` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `louerbd`.`avaliacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `louerbd`.`avaliacao` (
  `id_reserva` INT(11) NOT NULL,
  `tipo` ENUM('Cliente_para_Produto', 'Fornecedor_para_Cliente') NULL DEFAULT NULL,
  `nota` INT(11) NULL DEFAULT NULL,
  `comentario` TEXT NULL DEFAULT NULL,
  `data_avaliacao` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id_reserva`),
  INDEX `fk_avaliacao_reserva1_idx` (`id_reserva` ASC),
  CONSTRAINT `fk_avaliacao_reserva1`
    FOREIGN KEY (`id_reserva`)
    REFERENCES `louerbd`.`reserva` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `louerbd`.`formapagamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `louerbd`.`formapagamento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `forma` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `louerbd`.`imagem`
-- -----------------------------------------------------
CREATE TABLE imagem (
  id INT AUTO_INCREMENT PRIMARY KEY,
  dados LONGBLOB NOT NULL,
  tipo VARCHAR(50) NOT NULL,
  produto_id INT NOT NULL,
  FOREIGN KEY (produto_id) REFERENCES produto(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- -----------------------------------------------------
-- Table `louerbd`.`pagamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `louerbd`.`pagamento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `reserva_id` INT(11) NULL DEFAULT NULL,
  `forma_pagamento_id` INT(11) NULL DEFAULT NULL,
  `nome_pagador` VARCHAR(100) NULL DEFAULT NULL,
  `cpf_pagador` VARCHAR(14) NULL DEFAULT NULL,
  `valor_pago` DECIMAL(10,2) NULL DEFAULT NULL,
  `valor_estornado` DECIMAL(10,2) NULL DEFAULT NULL,
  `status_pagamento` ENUM('Pendente', 'Pago', 'Estornado') NULL DEFAULT NULL,
  `data_pagamento` DATETIME NULL DEFAULT NULL,
  `data_estorno` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `reserva_id` (`reserva_id` ASC),
  INDEX `forma_pagamento_id` (`forma_pagamento_id` ASC),
  CONSTRAINT `pagamento_ibfk_1`
    FOREIGN KEY (`reserva_id`)
    REFERENCES `louerbd`.`reserva` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `pagamento_ibfk_2`
    FOREIGN KEY (`forma_pagamento_id`)
    REFERENCES `louerbd`.`formapagamento` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `louerbd`.`tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `louerbd`.`tags` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `louerbd`.`tags_has_produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `louerbd`.`tags_has_produto` (
  `tags_id` INT NOT NULL,
  `produto_id` INT NOT NULL,
  PRIMARY KEY (`tags_id`, `produto_id`),
  INDEX `fk_tags_has_produto_produto1_idx` (`produto_id` ASC),
  INDEX `fk_tags_has_produto_tags1_idx` (`tags_id` ASC),
  CONSTRAINT `fk_tags_has_produto_tags1`
    FOREIGN KEY (`tags_id`)
    REFERENCES `louerbd`.`tags` (`id`),
  CONSTRAINT `fk_tags_has_produto_produto1`
    FOREIGN KEY (`produto_id`)
    REFERENCES `louerbd`.`produto` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE=InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Table `louerbd`.`favoritos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `louerbd`.`favoritos` (
  `id_usuario` INT(11) NOT NULL,
  `id_produto` INT(11) NOT NULL,
  PRIMARY KEY (`id_usuario`, `id_produto`),
  CONSTRAINT `idusuario_ibfk1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `louerbd`.`usuario`(`id`)
    ON DELETE CASCADE,
  CONSTRAINT `idproduto_ibfk2`
    FOREIGN KEY (`id_produto`)
    REFERENCES `louerbd`.`produto`(`id`)
    ON DELETE CASCADE
);
