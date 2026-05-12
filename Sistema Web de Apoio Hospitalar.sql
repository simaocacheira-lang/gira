CREATE TABLE `utilizadores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255) UNIQUE NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL
);

CREATE TABLE `localizacoes` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `edificio` varchar(255) NOT NULL,
  `piso` varchar(255),
  `servico` varchar(255) NOT NULL,
  `sala` varchar(255)
);

CREATE TABLE `fornecedores` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nome_empresa` varchar(255) NOT NULL,
  `nif` varchar(255) UNIQUE,
  `telefone` varchar(255),
  `email` varchar(255),
  `morada` text,
  `website` varchar(255),
  `pessoa_contacto` varchar(255),
  `telefone_contacto` varchar(255),
  `tipo_fornecedor` varchar(255),
  `observacoes` text
);

CREATE TABLE `equipamentos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `codigo_interno` varchar(255) UNIQUE NOT NULL,
  `designacao` varchar(255) NOT NULL,
  `categoria` varchar(255),
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `numero_serie` varchar(255),
  `fabricante` varchar(255) NOT NULL,
  `data_aquisicao` date,
  `ano_fabrico` int,
  `custo_aquisicao` decimal(10,2),
  `tipo_entrada` ENUM ('Compra', 'Doação', 'Aluguer', 'Empréstimo') NOT NULL,
  `estado` ENUM ('Ativo', 'Em manutenção', 'Inativo', 'Em calibração', 'Em quarentena', 'Abatido') NOT NULL DEFAULT 'Ativo',
  `criticidade` ENUM ('Baixa', 'Média', 'Alta', 'Suporte de vida') NOT NULL,
  `id_localizacao` int NOT NULL,
  `id_equipamento_pai` int,
  `observacoes` text
);

CREATE TABLE `equipamentos_fornecedores` (
  `id_equipamento` int NOT NULL,
  `id_fornecedor` int NOT NULL,
  `tipo_relacao` varchar(255),
  PRIMARY KEY (`id_equipamento`, `id_fornecedor`)
);

CREATE TABLE `documentacao` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `tipo_documento` varchar(255),
  `nome_documento` varchar(255) NOT NULL,
  `data_documento` date,
  `data_validade` date,
  `caminho_ficheiro` varchar(255) NOT NULL,
  `id_equipamento` int NOT NULL,
  `id_fornecedor` int
);

CREATE TABLE `garantias_contratos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_equipamento` int NOT NULL,
  `id_fornecedor` int,
  `tipo_registo` ENUM ('Garantia', 'Contrato de Manutenção') NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `periodicidade` varchar(255),
  `observacoes` text
);

CREATE TABLE `conteudos_publicos` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `seccao` varchar(255) UNIQUE NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `texto` text,
  `caminho_imagem` varchar(255),
  `data_ultima_atualizacao` datetime
);

CREATE UNIQUE INDEX `equipamentos_index_0` ON `equipamentos` (`fabricante`, `modelo`, `numero_serie`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`id_localizacao`) REFERENCES `localizacoes` (`id`);

ALTER TABLE `equipamentos` ADD FOREIGN KEY (`id_equipamento_pai`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `equipamentos_fornecedores` ADD FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `equipamentos_fornecedores` ADD FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id`);

ALTER TABLE `documentacao` ADD FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `documentacao` ADD FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id`);

ALTER TABLE `garantias_contratos` ADD FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos` (`id`);

ALTER TABLE `garantias_contratos` ADD FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedores` (`id`);

