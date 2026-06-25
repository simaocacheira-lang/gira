-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           8.4.3 - MySQL Community Server - GPL
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- A despejar estrutura para tabela gira_inventario.artigos_armazem
CREATE TABLE IF NOT EXISTS `artigos_armazem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `referencia` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantidade_atual` int NOT NULL DEFAULT '0',
  `quantidade_minima` int NOT NULL DEFAULT '5',
  `fornecedor_id` int DEFAULT NULL,
  `quantidade_em_transito` int NOT NULL DEFAULT '0',
  `apagado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `referencia` (`referencia`),
  KEY `fornecedor_id` (`fornecedor_id`),
  CONSTRAINT `artigos_armazem_ibfk_1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.artigos_armazem: ~6 rows (aproximadamente)
INSERT INTO `artigos_armazem` (`id`, `referencia`, `nome`, `categoria`, `quantidade_atual`, `quantidade_minima`, `fornecedor_id`, `quantidade_em_transito`, `apagado_em`) VALUES
	(1, 'REF-SPO2-AD', 'Sensor de SpO2 Reutilizável (Adulto)', 'Consumíveis Clínicos', 45, 20, 2, 0, NULL),
	(2, 'REF-SPO2-PED', 'Sensor de SpO2 Reutilizável (Pediátrico)', 'Consumíveis Clínicos', 8, 15, 2, 0, NULL),
	(3, 'REF-HMEF-01', 'Filtro Permutador HMEF Adulto', 'Consumíveis Clínicos', 5, 100, 1, 0, NULL),
	(4, 'REF-CABO-3V', 'Cabo ECG 3 Vias', 'Peças de Reparação', 22, 10, 2, 0, NULL),
	(5, 'REF-CABO-5V', 'Cabo ECG 5 Vias', 'Peças de Reparação', 14, 10, 2, 0, NULL),
	(6, 'REF-BAT-LP', 'Bateria Ion-Lítio 12V (LIFEPAK)', 'Peças de Reparação', 1, 4, 5, 0, NULL),
	(7, 'REF-GEL-ECO', 'Gel para Ecografia (Frasco 5L)', 'Consumíveis Clínicos', 2, 5, 6, 0, NULL),
	(8, 'REF-PAPEL-ECG', 'Papel Térmico para ECG (Rolo)', 'Consumíveis Clínicos', 85, 30, 6, 0, NULL),
	(9, 'REF-NIBP-AD', 'Manguito NIBP (Adulto Normal)', 'Consumíveis Clínicos', 30, 15, 7, 0, NULL),
	(10, 'REF-NIBP-OB', 'Manguito NIBP (Adulto Obeso)', 'Consumíveis Clínicos', 12, 10, 7, 0, NULL),
	(11, 'REF-CEL-O2', 'Célula de Oxigénio O2 Sensor', 'Peças de Reparação', 4, 10, 1, 0, NULL);

-- A despejar estrutura para tabela gira_inventario.conteudos_site
CREATE TABLE IF NOT EXISTS `conteudos_site` (
  `chave` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`chave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.conteudos_site: ~6 rows (aproximadamente)
INSERT INTO `conteudos_site` (`chave`, `texto`) VALUES
	('contacto_email', 'geral@gira.pt'),
	('contacto_morada', 'Rua Dr. António Bernardino de Almeida, 431, Porto, Portugal'),
	('contacto_telefone', '+351 228 340 500'),
	('hero_subtitulo', 'Plataforma integrada para controlo de equipamentos médicos, manutenções e gestão de armazém tecnológico.'),
	('hero_titulo', 'Gira'),
	('sobre_texto', 'O Gira é uma solução desenvolvida para otimizar o fluxo de trabalho da Engenharia Clínica, garantindo a rastreabilidade e segurança do parque tecnológico hospitalar.');

-- A despejar estrutura para tabela gira_inventario.documentos_equipamento
CREATE TABLE IF NOT EXISTS `documentos_equipamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `equipamento_id` int NOT NULL,
  `nome_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caminho_ficheiro` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_upload` datetime DEFAULT CURRENT_TIMESTAMP,
  `apagado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `equipamento_id` (`equipamento_id`),
  CONSTRAINT `documentos_equipamento_ibfk_1` FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.documentos_equipamento: ~5 rows (aproximadamente)
INSERT INTO `documentos_equipamento` (`id`, `equipamento_id`, `nome_documento`, `tipo_documento`, `caminho_ficheiro`, `data_upload`, `apagado_em`) VALUES
	(1, 1, 'Manual de Serviço V500', 'Manual Técnico', 'documentos/uploads/manual_v500.pdf', '2026-06-01 10:00:00', NULL),
	(2, 2, 'Certificado CE', 'Certificado Conformidade (CE)', 'documentos/uploads/cert_ce_mx700.pdf', '2026-06-05 11:30:00', NULL),
	(3, 3, 'Relatório de Proteção Radiológica', 'Guia de Calibração', 'documentos/uploads/rad_siemens.pdf', '2026-06-10 14:20:00', NULL),
	(4, 5, 'Esquema Elétrico', 'Manual Técnico', 'documentos/uploads/esq_lifepak.pdf', '2026-06-12 09:15:00', NULL);

-- A despejar estrutura para tabela gira_inventario.encomendas_armazem
CREATE TABLE IF NOT EXISTS `encomendas_armazem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `artigo_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `data_prevista` date NOT NULL,
  `notas` text COLLATE utf8mb4_unicode_ci,
  `estado` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Pendente',
  `data_pedido` datetime DEFAULT CURRENT_TIMESTAMP,
  `apagado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `artigo_id` (`artigo_id`),
  CONSTRAINT `encomendas_armazem_ibfk_1` FOREIGN KEY (`artigo_id`) REFERENCES `artigos_armazem` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.encomendas_armazem: ~7 rows (aproximadamente)
INSERT INTO `encomendas_armazem` (`id`, `artigo_id`, `quantidade`, `data_prevista`, `notas`, `estado`, `data_pedido`, `apagado_em`) VALUES
	(1, 3, 200, '2026-06-28', 'URGENTE: Rutura de stock no bloco operatório.', 'Pendente', '2026-06-21 15:15:00', NULL),
	(2, 6, 5, '2026-07-05', 'Substituição planeada de baterias dos desfibrilhadores do piso 0.', 'Pendente', '2026-06-22 10:30:00', NULL),
	(3, 7, 20, '2026-06-25', 'Reforço mensal de gel para a imagiologia.', 'Concluída', '2026-06-10 09:00:00', NULL),
	(4, 11, 15, '2026-07-10', 'Encomenda normal à Dräger.', 'Pendente', '2026-06-23 09:00:00', NULL);

-- A despejar estrutura para tabela gira_inventario.equipamentos
CREATE TABLE IF NOT EXISTS `equipamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo_ativo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_serie` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mac_address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classe_risco` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` enum('Operacional','Inoperacional','Manutenção') COLLATE utf8mb4_unicode_ci DEFAULT 'Operacional',
  `localizacao_id` int DEFAULT NULL,
  `fabricante_id` int DEFAULT NULL,
  `fornecedor_id` int DEFAULT NULL,
  `data_aquisicao` date DEFAULT NULL,
  `ano_fabrico` int DEFAULT NULL,
  `tipo_entrada` enum('Compra','Doação','Aluguer','Empréstimo') COLLATE utf8mb4_unicode_ci DEFAULT 'Compra',
  `custo_aquisicao` decimal(10,2) DEFAULT NULL,
  `fim_garantia` date DEFAULT NULL,
  `proxima_revisao` date DEFAULT NULL,
  `apagado_em` datetime DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_ativo` (`codigo_ativo`),
  KEY `localizacao_id` (`localizacao_id`),
  KEY `fornecedor_id` (`fornecedor_id`),
  KEY `fk_equip_fabricante` (`fabricante_id`),
  CONSTRAINT `equipamentos_ibfk_1` FOREIGN KEY (`localizacao_id`) REFERENCES `localizacoes` (`id`),
  CONSTRAINT `equipamentos_ibfk_2` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`),
  CONSTRAINT `fk_equip_fabricante` FOREIGN KEY (`fabricante_id`) REFERENCES `fornecedores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.equipamentos: ~11 rows (aproximadamente)
INSERT INTO `equipamentos` (`id`, `codigo_ativo`, `nome`, `categoria`, `marca`, `modelo`, `num_serie`, `mac_address`, `classe_risco`, `estado`, `localizacao_id`, `fabricante_id`, `fornecedor_id`, `data_aquisicao`, `ano_fabrico`, `tipo_entrada`, `custo_aquisicao`, `fim_garantia`, `proxima_revisao`, `apagado_em`, `observacoes`) VALUES
	(1, 'EQ-2026-A1B2', 'Ventilador Pulmonar', 'Suporte de Vida', 'Dräger', 'Evita V500', 'DRG-887766', '00:1A:2B:3C:4D:5E', 'Suporte de Vida', 'Operacional', 4, 1, 1, '2023-01-15', 2022, 'Compra', 25000.00, '2028-01-15', '2026-07-15', NULL, 'Equipamento crítico.'),
	(2, 'EQ-2026-C3D4', 'Monitor Multiparamétrico', 'Monitorização', 'Philips', 'IntelliVue MX700', 'PHL-112233', 'A1:B2:C3:D4:E5:F6', 'Médio/Alto Risco', 'Operacional', 1, 2, 2, '2024-05-20', 2024, 'Compra', 8500.00, '2027-05-20', '2026-11-20', NULL, 'Alocado à reanimação.'),
	(3, 'EQ-2026-E5F6', 'Aparelho de Raio-X Fixo', 'Diagnóstico', 'Siemens', 'Multix Impact', 'SIE-998877', NULL, 'Médio/Alto Risco', 'Operacional', 6, 3, 3, '2021-11-10', 2021, 'Compra', 85000.00, '2025-11-10', '2026-10-10', NULL, 'Contrato de manutenção ativo.'),
	(4, 'EQ-2026-G7H8', 'Bomba de Infusão Volumétrica', 'Terapia', 'B. Braun', 'Infusomat Space', 'BBR-332211', NULL, 'Baixo Risco', 'Operacional', 4, 4, 4, '2025-06-01', 2025, 'Empréstimo', 1200.00, '2027-06-01', '2027-01-10', NULL, 'Equipamento de empréstimo temporário.'),
	(5, 'EQ-2026-I9J0', 'Desfibrilhador Bifásico', 'Suporte de Vida', 'Medtronic', 'LIFEPAK 15', 'MED-554433', NULL, 'Suporte de Vida', 'Inoperacional', 1, 5, 5, '2020-02-28', 2019, 'Doação', 0.00, '2023-02-28', '2026-02-28', NULL, 'Avariado. Problema no condensador principal.'),
	(6, 'EQ-2026-K1L2', 'Monitor de Sinais Vitais', 'Monitorização', 'Mindray', 'BeneVision N12', 'MIN-998811', 'B2:C3:D4:E5:F6:A1', 'Médio/Alto Risco', 'Operacional', 2, 7, 7, '2023-08-14', 2023, 'Compra', 5400.00, '2026-08-14', '2026-08-14', NULL, NULL),
	(7, 'EQ-2026-M3N4', 'Incubadora Neonatal', 'Suporte de Vida', 'GE Healthcare', 'Giraffe OmniBed', 'GE-774411', NULL, 'Suporte de Vida', 'Operacional', 8, 6, 6, '2022-03-10', 2021, 'Compra', 32000.00, '2027-03-10', '2026-09-10', NULL, 'Verificar o sensor de humidade na próxima revisão.'),
	(8, 'EQ-2026-O5P6', 'Ecógrafo Portátil', 'Diagnóstico', 'Philips', 'Affiniti 70', 'PHL-ECO-445', 'C3:D4:E5:F6:A1:B2', 'Monitorização', 'Manutenção', 7, 2, 2, '2024-11-22', 2024, 'Compra', 45000.00, '2029-11-22', '2026-05-22', NULL, 'A aguardar sonda linear.'),
	(9, 'EQ-2026-Q7R8', 'Eletrocardiógrafo (ECG)', 'Diagnóstico', 'GE Healthcare', 'MAC 2000', 'GE-ECG-112', NULL, 'Monitorização', 'Operacional', 7, 6, 6, '2021-01-30', 2020, 'Compra', 3200.00, '2024-01-30', '2026-07-30', NULL, 'Garantia expirada.'),
	(10, 'EQ-2026-S9T0', 'Bomba Seringa', 'Terapia', 'B. Braun', 'Perfusor Space', 'BBR-990022', NULL, 'Baixo Risco', 'Operacional', 5, 4, 4, '2025-06-01', 2025, 'Empréstimo', 950.00, '2027-06-01', '2027-01-10', NULL, NULL),
	(11, 'EQ-2026-U1V2', 'Desfibrilhador DAE', 'Suporte de Vida', 'Nihon Kohden', 'TEC-5631', 'NHK-556677', NULL, 'Suporte de Vida', 'Operacional', 2, 8, 8, '2023-09-05', 2023, 'Compra', 2100.00, '2028-09-05', '2026-09-05', NULL, 'Bateria substituída recentemente.'),
	(12, 'EQ-2026-W3X4', 'Arco em C Cirúrgico', 'Diagnóstico', 'Siemens', 'Cios Select', 'SIE-C-999', NULL, 'Médio/Alto Risco', 'Operacional', 3, 3, 3, '2022-12-15', 2022, 'Compra', 110000.00, '2027-12-15', '2026-12-15', NULL, 'Radiação controlada.'),
	(13, 'EQ-2026-Y5Z6', 'Ventilador Pulmonar', 'Suporte de Vida', 'Dräger', 'Evita V600', 'DRG-V6-112', 'D4:E5:F6:A1:B2:C3', 'Suporte de Vida', 'Operacional', 5, 1, 1, '2024-02-10', 2024, 'Compra', 28000.00, '2029-02-10', '2026-08-10', NULL, NULL),
	(14, 'EQ-2026-A7B8', 'Monitor Multiparamétrico', 'Monitorização', 'Philips', 'IntelliVue MX700', 'PHL-112244', 'E5:F6:A1:B2:C3:D4', 'Médio/Alto Risco', 'Operacional', 5, 2, 2, '2024-05-20', 2024, 'Compra', 8500.00, '2027-05-20', '2026-11-20', NULL, NULL),
	(15, 'EQ-2026-C9D0', 'Máquina de Anestesia', 'Suporte de Vida', 'Dräger', 'Fabius Plus', 'DRG-FAB-777', NULL, 'Suporte de Vida', 'Inoperacional', 3, 1, 1, '2018-07-22', 2018, 'Compra', 35000.00, '2023-07-22', '2026-01-22', NULL, 'A aguardar aprovação de orçamento para reparação.');

-- A despejar estrutura para tabela gira_inventario.equipamento_artigo_armazem
CREATE TABLE IF NOT EXISTS `equipamento_artigo_armazem` (
  `equipamento_id` int NOT NULL,
  `artigo_id` int NOT NULL,
  PRIMARY KEY (`equipamento_id`,`artigo_id`),
  KEY `fk_ea_artigo` (`artigo_id`),
  CONSTRAINT `fk_ea_artigo` FOREIGN KEY (`artigo_id`) REFERENCES `artigos_armazem` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ea_equip` FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.equipamento_artigo_armazem: ~0 rows (aproximadamente)
INSERT INTO `equipamento_artigo_armazem` (`equipamento_id`, `artigo_id`) VALUES
	(2, 1),
	(6, 1),
	(14, 1),
	(7, 2),
	(1, 3),
	(13, 3),
	(15, 3),
	(5, 4),
	(6, 4),
	(11, 4),
	(2, 5),
	(14, 5),
	(5, 6),
	(8, 7),
	(9, 8),
	(2, 9),
	(6, 9),
	(14, 9),
	(2, 10),
	(14, 10),
	(1, 11),
	(13, 11),
	(15, 11);

-- A despejar estrutura para tabela gira_inventario.fornecedores
CREATE TABLE IF NOT EXISTS `fornecedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_empresa` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nif` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `especialidade` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Ativo',
  `email_suporte` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefone_suporte` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apagado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nif` (`nif`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.fornecedores: ~12 rows (aproximadamente)
INSERT INTO `fornecedores` (`id`, `nome_empresa`, `nif`, `especialidade`, `estado`, `email_suporte`, `telefone_suporte`, `apagado_em`) VALUES
	(1, 'Dräger Medical Portugal', '501234567', 'Ventilação e Suporte de Vida', 'Ativo', 'suporte@draeger.pt', '+351 210 000 001', NULL),
	(2, 'Philips Healthcare', '502345678', 'Monitores e Imagiologia', 'Ativo', 'helpdesk@philips.pt', '+351 210 000 002', NULL),
	(3, 'Siemens Healthineers', '503456789', 'Imagiologia e Diagnóstico', 'Ativo', 'tech@siemens.pt', '+351 210 000 003', NULL),
	(4, 'B. Braun Medical S.A.', '504567890', 'Bombas de Infusão', 'Ativo', 'suporte.pt@bbraun.com', '+351 210 000 004', NULL),
	(5, 'Medtronic Portugal', '505678901', 'Suporte de Vida e Cirurgia', 'Ativo', 'assistencia@medtronic.com', '+351 210 000 005', NULL),
	(6, 'GE Healthcare', '506789012', 'Imagiologia e Monitorização', 'Ativo', 'suporte@ge.com', '+351 210 000 006', NULL),
	(7, 'Mindray Portugal', '507890123', 'Monitores e Diagnóstico', 'Ativo', 'service.pt@mindray.com', '+351 210 000 007', NULL),
	(8, 'Nihon Kohden', '508901234', 'Cardiologia e Neurologia', 'Ativo', 'support@nihonkohden.com', '+351 210 000 008', NULL);

-- A despejar estrutura para tabela gira_inventario.localizacoes
CREATE TABLE IF NOT EXISTS `localizacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cod_sala` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detalhe` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `piso` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bloco` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apagado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cod_sala` (`cod_sala`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.localizacoes: ~7 rows (aproximadamente)
INSERT INTO `localizacoes` (`id`, `cod_sala`, `nome`, `detalhe`, `piso`, `bloco`, `apagado_em`) VALUES
	(1, 'URG-101', 'Serviço de Urgência', 'Box de Reanimação 1', 'Piso 0', 'Bloco Central', NULL),
	(2, 'URG-102', 'Serviço de Urgência', 'Sala de Triagem', 'Piso 0', 'Bloco Central', NULL),
	(3, 'BLO-205', 'Bloco Operatório', 'Sala de Cirurgia 3', 'Piso 2', 'Bloco Cirúrgico', NULL),
	(4, 'UCI-310', 'Cuidados Intensivos (UCI)', 'Cama 4', 'Piso 3', 'Ala Norte', NULL),
	(5, 'UCI-311', 'Cuidados Intensivos (UCI)', 'Cama 5', 'Piso 3', 'Ala Norte', NULL),
	(6, 'IMG-005', 'Imagiologia', 'Sala de Raio-X Fixo', 'Piso -1', 'Bloco Central', NULL),
	(7, 'CAR-401', 'Cardiologia', 'Laboratório de Ecocardiografia', 'Piso 4', 'Ala Sul', NULL),
	(8, 'PED-502', 'Pediatria / Neonatologia', 'Sala de Cuidados Intermédios', 'Piso 5', 'Ala Pediátrica', NULL);

-- A despejar estrutura para tabela gira_inventario.logs_auditoria
CREATE TABLE IF NOT EXISTS `logs_auditoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  `utilizador_id` int DEFAULT NULL,
  `acao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modulo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_origem` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tabela_afetada` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registo_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilizador_id` (`utilizador_id`),
  CONSTRAINT `logs_auditoria_ibfk_1` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.logs_auditoria: ~18 rows (aproximadamente)

-- A despejar estrutura para tabela gira_inventario.ordens_trabalho
CREATE TABLE IF NOT EXISTS `ordens_trabalho` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_ot` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `equipamento_id` int NOT NULL,
  `tipo_manutencao` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prioridade` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao_avaria` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_abertura` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Pendente',
  `relatorio_tecnico` text COLLATE utf8mb4_unicode_ci,
  `tempo_gasto` decimal(5,1) DEFAULT NULL,
  `data_fecho` datetime DEFAULT NULL,
  `apagado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_ot` (`numero_ot`),
  KEY `fk_ot_equipamento` (`equipamento_id`),
  CONSTRAINT `fk_ot_equipamento` FOREIGN KEY (`equipamento_id`) REFERENCES `equipamentos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.ordens_trabalho: ~11 rows (aproximadamente)
INSERT INTO `ordens_trabalho` (`id`, `numero_ot`, `equipamento_id`, `tipo_manutencao`, `prioridade`, `descricao_avaria`, `data_abertura`, `estado`, `relatorio_tecnico`, `tempo_gasto`, `data_fecho`, `apagado_em`) VALUES
	(1, 'OT-2026-0A1B', 5, 'Corretiva (Avaria)', 'Crítica', 'Desfibrilhador não carrega a bateria. Condensador apresenta falha de tensão E-201.', '2026-06-20 09:30:00', 'Pendente', NULL, NULL, NULL, NULL),
	(2, 'OT-2026-0C2D', 1, 'Preventiva Planeada', 'Média', 'Substituição das células de O2 e calibração de fluxo (Preventiva 3000h).', '2026-05-10 10:00:00', 'Concluída', 'Células de O2 substituídas. Testes de fuga elétrica realizados. Equipamento funcional.', 2.5, '2026-05-10 14:30:00', NULL),
	(3, 'OT-2026-0E3F', 8, 'Corretiva (Avaria)', 'Alta', 'Sonda linear apresenta artefactos na imagem. Cabo da sonda com sinais de desgaste.', '2026-06-21 14:15:00', 'Em Curso', NULL, NULL, NULL, NULL),
	(4, 'OT-2026-0G4H', 15, 'Corretiva (Avaria)', 'Alta', 'Máquina não passa no auto-teste matinal. Fuga no fole.', '2026-06-15 08:00:00', 'Pendente', NULL, NULL, NULL, NULL),
	(5, 'OT-2026-0I5J', 9, 'Preventiva Planeada', 'Baixa', 'Revisão anual obrigatória.', '2026-06-18 11:00:00', 'Concluída', 'Limpeza interna, calibração da impressora térmica. Tudo OK.', 1.0, '2026-06-18 12:30:00', NULL);

-- A despejar estrutura para tabela gira_inventario.perfis_acesso
CREATE TABLE IF NOT EXISTS `perfis_acesso` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_perfil` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_acesso` int NOT NULL DEFAULT '1',
  `apagado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.perfis_acesso: ~4 rows (aproximadamente)
INSERT INTO `perfis_acesso` (`id`, `nome_perfil`, `descricao`, `nivel_acesso`, `apagado_em`) VALUES
	(1, 'Administrador do Sistema', 'Acesso total a configurações e gestão do sistema Gira', 3, NULL),
	(2, 'Engenharia Clínica / Técnicos', 'Gestão operacional de equipamentos, manutenção e armazém', 2, NULL),
	(3, 'Direção Clínica / Médicos', 'Apenas leitura de inventário e emissão de O.T.s', 1, NULL),
	(4, 'Enfermagem', 'Acesso aos equipamentos do respetivo serviço', 1, NULL);

-- A despejar estrutura para tabela gira_inventario.utilizadores
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perfil_id` int NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Ativo',
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultimo_login` datetime DEFAULT NULL,
  `apagado_em` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cedula` (`cedula`),
  KEY `perfil_id` (`perfil_id`),
  CONSTRAINT `utilizadores_ibfk_1` FOREIGN KEY (`perfil_id`) REFERENCES `perfis_acesso` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- A despejar dados para tabela gira_inventario.utilizadores: ~4 rows (aproximadamente)
INSERT INTO `utilizadores` (`id`, `nome`, `cedula`, `email`, `password_hash`, `perfil_id`, `estado`, `data_criacao`, `ultimo_login`, `apagado_em`) VALUES
	(1, 'Simão Cacheira', 'ENG-001', 'admin@gira.pt', '$2y$10$4L.hpnuWg56JjRJrHX0hy.2CT6zwKZoC1LyyF3yBLwjFNcNGaWHtG', 1, 'Ativo', '2026-06-23 14:56:32', NULL, NULL),
	(2, 'Helena Barbosa', 'TEC-405', 'hbarbosa@gira.pt', '$2y$10$4L.hpnuWg56JjRJrHX0hy.2CT6zwKZoC1LyyF3yBLwjFNcNGaWHtG', 2, 'Ativo', '2026-06-23 14:56:32', NULL, NULL),
	(3, 'Inês Barros', 'MED-892', 'ibarros@gira.pt', '$2y$10$4L.hpnuWg56JjRJrHX0hy.2CT6zwKZoC1LyyF3yBLwjFNcNGaWHtG', 3, 'Ativo', '2026-06-23 14:56:32', NULL, NULL),
	(4, 'Dinis Martins', 'TEC-406', 'dmartins@gira.pt', '$2y$10$4L.hpnuWg56JjRJrHX0hy.2CT6zwKZoC1LyyF3yBLwjFNcNGaWHtG', 2, 'Ativo', '2026-06-23 14:56:32', NULL, NULL),
	(5, 'Mariana', 'ENF-112', 'mariana@gira.pt', '$2y$10$4L.hpnuWg56JjRJrHX0hy.2CT6zwKZoC1LyyF3yBLwjFNcNGaWHtG', 4, 'Ativo', '2026-06-23 14:56:32', NULL, NULL),
	(6, 'Afonso', 'MED-905', 'afonso@gira.pt', '$2y$10$4L.hpnuWg56JjRJrHX0hy.2CT6zwKZoC1LyyF3yBLwjFNcNGaWHtG', 3, 'Ativo', '2026-06-23 14:56:32', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
