-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema louerbd
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema louerbd
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `louerbd`;
CREATE SCHEMA IF NOT EXISTS `louerbd` DEFAULT CHARACTER SET latin1 ;
USE `louerbd` ;

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
  `data_solicitado` DATE NULL DEFAULT CURRENT_TIMESTAMP(),
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
  `sobrenome_pagador` VARCHAR(100) NULL DEFAULT NULL,
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
-- Data for tables 
-- -----------------------------------------------------
START TRANSACTION;
USE `louerbd`;
-- ----------data: formapagamento
INSERT INTO `louerbd`.`formapagamento` (`id`, `forma`) VALUES (1, 'DINHEIRO');
INSERT INTO `louerbd`.`formapagamento` (`id`, `forma`) VALUES (2, 'CARTAO');

-- ----------data: tags
INSERT INTO `louerbd`.`tags` (`nome`) VALUES ('Quadra');
INSERT INTO `louerbd`.`tags` (`nome`) VALUES ('Musical');
INSERT INTO `louerbd`.`tags` (`nome`) VALUES ('Ao ar livre');
INSERT INTO `louerbd`.`tags` (`nome`) VALUES ('Esporte');
INSERT INTO `louerbd`.`tags` (`nome`) VALUES ('Roupa');
INSERT INTO `louerbd`.`tags` (`nome`) VALUES ('Fotográfico');
INSERT INTO `louerbd`.`tags` (`nome`) VALUES ('Escolar');

-- ---------- Inserir fornecedores ----------
INSERT INTO usuario (nome, tipo, cpf, cidade, telefone, email, senha) VALUES
('Fornecedor1', 'Fornecedor', '11111111111', 'CidadeA', '27999990001', 'fornecedor1@gmail.com', '123456'),
('Fornecedor2', 'Fornecedor', '22222222222', 'CidadeB', '27999990002', 'fornecedor2@gmail.com', '123456'),
('Fornecedor3', 'Fornecedor', '33333333333', 'CidadeC', '27999990003', 'fornecedor3@gmail.com', '123456'),
('Fornecedor4', 'Fornecedor', '44444444444', 'CidadeD', '27999990004', 'fornecedor4@gmail.com', '123456'),
('Carol', 'Fornecedor', '19919919922', 'Colatina', '27996937991', 'carol@gmail.com', '1234567');

-- ---------- Inserir clientes ----------
INSERT INTO usuario (nome, tipo, cpf, cidade, telefone, email, senha) VALUES
('Cliente1', 'Cliente', '55555555555', 'CidadeA', '27999990005', 'cliente1@gmail.com', '123456'),
('Cliente2', 'Cliente', '66666666666', 'CidadeB', '27999990006', 'cliente2@gmail.com', '123456');

-- ---------- Inserir produtos ----------
-- Produtos do Fornecedor1 (id_usuario = 1)
INSERT INTO produto (id_usuario, nome, descricao, tipo, valor_dia, dias_disponiveis, cidade) VALUES
(1, 'Produto1_F1', 'Descrição Produto 1 Fornecedor 1', 'Equipamento', 50.00, 'Seg,Ter', 'CidadeA'),
(1, 'Produto2_F1', 'Descrição Produto 2 Fornecedor 1', 'Espaco', 100.00, 'Qua,Qui', 'CidadeA');

-- Produtos do Fornecedor2 (id_usuario = 2)
INSERT INTO produto (id_usuario, nome, descricao, tipo, valor_dia, dias_disponiveis, cidade) VALUES
(2, 'Produto1_F2', 'Descrição Produto 1 Fornecedor 2', 'Equipamento', 60.00, 'Seg,Qua', 'CidadeB'),
(2, 'Produto2_F2', 'Descrição Produto 2 Fornecedor 2', 'Espaco', 120.00, 'Ter,Qui', 'CidadeB');

-- Produtos do Fornecedor3 (id_usuario = 3)
INSERT INTO produto (id_usuario, nome, descricao, tipo, valor_dia, dias_disponiveis, cidade) VALUES
(3, 'Produto1_F3', 'Descrição Produto 1 Fornecedor 3', 'Equipamento', 70.00, 'Seg,Sex', 'CidadeC'),
(3, 'Produto2_F3', 'Descrição Produto 2 Fornecedor 3', 'Espaco', 130.00, 'Qua,Qui', 'CidadeC');

-- Produtos do Fornecedor4 (id_usuario = 4)
INSERT INTO produto (id_usuario, nome, descricao, tipo, valor_dia, dias_disponiveis, cidade) VALUES
(4, 'Produto1_F4', 'Descrição Produto 1 Fornecedor 4', 'Equipamento', 80.00, 'Seg,Ter', 'CidadeD'),
(4, 'Produto2_F4', 'Descrição Produto 2 Fornecedor 4', 'Espaco', 150.00, 'Qua,Sex', 'CidadeD');

-- ---------- Inserir tags para cada produto ----------
-- Considerando ids das tags já existentes: 1 a 7
INSERT INTO tags_has_produto (tags_id, produto_id) VALUES
(1, 1), (2, 2), (3, 3), (4, 4), (5, 5), (6, 6), (7, 7), (1, 8);

-- ---------- Inserir imagens ----------


-- ---------- Disponibilidades Produto1_F1 (id=1) ----------
INSERT INTO disponibilidades (id_produto, data_disponivel) VALUES
(1,'2025-09-01'),(1,'2025-09-02'),(1,'2025-09-08'),(1,'2025-09-09'),
(1,'2025-09-15'),(1,'2025-09-16'),(1,'2025-09-22'),(1,'2025-09-23');

-- ---------- Disponibilidades Produto2_F1 (id=2) ----------
INSERT INTO disponibilidades (id_produto, data_disponivel) VALUES
(2,'2025-09-03'),(2,'2025-09-04'),(2,'2025-09-10'),(2,'2025-09-11'),
(2,'2025-09-17'),(2,'2025-09-18'),(2,'2025-09-24'),(2,'2025-09-25');

-- ---------- Disponibilidades Produto1_F2 (id=3) ----------
INSERT INTO disponibilidades (id_produto, data_disponivel) VALUES
(3,'2025-09-05'),(3,'2025-09-06'),(3,'2025-09-12'),(3,'2025-09-13'),
(3,'2025-09-19'),(3,'2025-09-20'),(3,'2025-09-26'),(3,'2025-09-27');

-- ---------- Disponibilidades Produto2_F2 (id=4) ----------
INSERT INTO disponibilidades (id_produto, data_disponivel) VALUES
(4,'2025-09-07'),(4,'2025-09-08'),(4,'2025-09-14'),(4,'2025-09-15'),
(4,'2025-09-21'),(4,'2025-09-22'),(4,'2025-09-28'),(4,'2025-09-29');

-- ---------- Disponibilidades Produto1_F3 (id=5) ----------
INSERT INTO disponibilidades (id_produto, data_disponivel) VALUES
(5,'2025-09-01'),(5,'2025-09-03'),(5,'2025-09-08'),(5,'2025-09-10'),
(5,'2025-09-15'),(5,'2025-09-17'),(5,'2025-09-22'),(5,'2025-09-24');

-- ---------- Disponibilidades Produto2_F3 (id=6) ----------
INSERT INTO disponibilidades (id_produto, data_disponivel) VALUES
(6,'2025-09-02'),(6,'2025-09-04'),(6,'2025-09-09'),(6,'2025-09-11'),
(6,'2025-09-16'),(6,'2025-09-18'),(6,'2025-09-23'),(6,'2025-09-25');

-- ---------- Disponibilidades Produto1_F4 (id=7) ----------
INSERT INTO disponibilidades (id_produto, data_disponivel) VALUES
(7,'2025-09-01'),(7,'2025-09-02'),(7,'2025-09-03'),(7,'2025-09-04'),
(7,'2025-09-05'),(7,'2025-09-06'),(7,'2025-09-07'),(7,'2025-09-08');

-- ---------- Disponibilidades Produto2_F4 (id=8) ----------
INSERT INTO disponibilidades (id_produto, data_disponivel) VALUES
(8,'2025-09-09'),(8,'2025-09-10'),(8,'2025-09-11'),(8,'2025-09-12'),
(8,'2025-09-13'),(8,'2025-09-14'),(8,'2025-09-15'),(8,'2025-09-16');
COMMIT;

