-- --------------------------------------------------------
-- Host:                         192.168.200.232
-- Server version:               5.5.31-0+wheezy1-log - (Debian)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2014-02-28 17:45:20
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for andre_newCore
CREATE DATABASE IF NOT EXISTS `andre_newCore` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `andre_newCore`;


-- Dumping structure for table andre_newCore.acos
CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `apelido` varchar(250) DEFAULT NULL,
  `aliasMenu` varchar(100) DEFAULT NULL,
  `menugroup_id` int(11) DEFAULT NULL,
  `descricao` varchar(250) DEFAULT NULL,
  `aliasMetodo` varchar(250) DEFAULT NULL,
  `menuEsquerdo` char(1) NOT NULL DEFAULT 'N',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int(11) NOT NULL,
  `menuSuperior` char(1) DEFAULT 'N',
  `ordem_menu` int(10) DEFAULT NULL,
  `parametro` varchar(1) NOT NULL DEFAULT 'Y' COMMENT 'Se o metodo possui parametros, não estará acessível nos menus esquerdo e superior',
  `restrito` varchar(1) NOT NULL DEFAULT 'Y' COMMENT 'Se o método é restrito ou não ao supersuário',
  `module_id` int(11) DEFAULT NULL COMMENT 'Módulo ao qual pertence o action',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=233 DEFAULT CHARSET=utf8;

-- Dumping data for table andre_newCore.acos: 76 rows
/*!40000 ALTER TABLE `acos` DISABLE KEYS */;
INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `apelido`, `aliasMenu`, `menugroup_id`, `descricao`, `aliasMetodo`, `menuEsquerdo`, `lft`, `rght`, `created`, `createdby`, `modified`, `modifiedby`, `menuSuperior`, `ordem_menu`, `parametro`, `restrito`, `module_id`) VALUES
	(1, NULL, NULL, NULL, 'controllers', NULL, NULL, NULL, NULL, NULL, '1', 1, 152, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(3, 1, NULL, NULL, 'Pages', NULL, NULL, NULL, NULL, NULL, '1', 2, 5, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(4, 3, NULL, NULL, 'display', NULL, NULL, NULL, NULL, NULL, '1', 3, 4, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(11, 1, NULL, NULL, 'AclExtras', NULL, NULL, NULL, NULL, NULL, '1', 6, 7, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(12, 1, NULL, NULL, 'Manager', NULL, NULL, NULL, NULL, NULL, '1', 8, 151, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(13, 12, NULL, NULL, 'Acos', NULL, NULL, NULL, NULL, NULL, '1', 9, 28, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(14, 13, NULL, NULL, 'admin_add', '', NULL, NULL, NULL, NULL, '1', 10, 11, NULL, 0, '2013-07-10 08:43:54', 19, NULL, NULL, 'Y', 'Y', 0),
	(15, 13, NULL, NULL, 'admin_index', '', NULL, NULL, NULL, NULL, '1', 12, 13, NULL, 0, '2013-07-10 08:43:06', 19, NULL, NULL, 'Y', 'Y', 0),
	(16, 13, NULL, NULL, 'admin_synchronize', NULL, NULL, NULL, NULL, NULL, '1', 14, 15, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(93, 13, NULL, NULL, 'admin_acosObsoletos', '', NULL, NULL, NULL, NULL, '1', 18, 19, NULL, 0, '2013-07-10 08:44:24', 19, NULL, NULL, 'Y', 'Y', 0),
	(19, 13, NULL, NULL, 'admin_list', NULL, NULL, NULL, NULL, NULL, '1', 16, 17, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(200, 192, NULL, NULL, 'enableConfigmail', NULL, NULL, NULL, NULL, NULL, '1', 108, 109, '2013-07-12 11:24:32', 19, '2013-07-12 11:24:32', 19, NULL, NULL, 'Y', 'Y', 0),
	(197, 192, NULL, NULL, 'admin_delete', NULL, NULL, NULL, NULL, NULL, '1', 102, 103, '2013-07-12 09:45:40', 19, '2013-07-12 09:45:40', 19, NULL, NULL, 'Y', 'Y', 0),
	(196, 192, NULL, NULL, 'admin_edit', NULL, NULL, NULL, NULL, NULL, '1', 100, 101, '2013-07-12 09:45:40', 19, '2013-07-12 09:45:40', 19, NULL, NULL, 'Y', 'Y', 0),
	(195, 192, NULL, NULL, 'admin_add', NULL, NULL, NULL, NULL, NULL, '1', 98, 99, '2013-07-12 09:45:40', 19, '2013-07-12 09:45:40', 19, NULL, NULL, 'Y', 'Y', 0),
	(198, 192, NULL, NULL, 'admin_view', NULL, NULL, NULL, NULL, NULL, '1', 104, 105, '2013-07-12 10:08:56', 19, '2013-07-12 10:08:56', 19, NULL, NULL, 'Y', 'Y', 0),
	(199, 192, NULL, NULL, 'disableConfigmail', NULL, NULL, NULL, NULL, NULL, '1', 106, 107, '2013-07-12 11:24:31', 19, '2013-07-12 11:24:31', 19, NULL, NULL, 'Y', 'Y', 0),
	(38, 12, NULL, NULL, 'CepEnderecos', NULL, NULL, NULL, NULL, NULL, '1', 29, 32, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(193, 192, NULL, NULL, 'admin_index', NULL, 'Configuração de e-mail', NULL, 'Configura a conta e forma de envio de e-mail no site', 'Configuração de e-mail', '1', 96, 97, '2013-07-12 09:45:40', 19, '2014-01-27 15:26:07', 19, NULL, NULL, 'N', 'Y', 3),
	(192, 12, NULL, NULL, 'Configmails', NULL, NULL, NULL, NULL, NULL, '1', 95, 110, '2013-07-12 09:45:39', 19, '2013-07-12 09:45:39', 19, NULL, NULL, 'Y', 'Y', 0),
	(226, 12, NULL, NULL, 'Permissions', NULL, NULL, NULL, NULL, NULL, 'N', 141, 150, '2014-02-17 15:56:08', 19, '2014-02-17 15:56:08', 19, 'N', NULL, 'Y', 'Y', 0),
	(123, 120, NULL, NULL, 'admin_edit', 'Editar perfil', NULL, NULL, NULL, NULL, '1', 72, 73, NULL, 0, '2013-07-10 15:44:56', 19, NULL, NULL, 'Y', 'Y', 0),
	(120, 12, NULL, NULL, 'Persons', NULL, NULL, NULL, NULL, NULL, '1', 71, 76, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(83, 12, NULL, NULL, 'Users', NULL, NULL, NULL, NULL, NULL, '1', 33, 60, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(84, 83, NULL, NULL, 'admin_index', '', NULL, NULL, NULL, NULL, '1', 34, 35, NULL, 0, '2013-07-04 15:28:27', 11, NULL, NULL, 'Y', 'Y', 0),
	(86, 83, NULL, NULL, 'admin_logout', NULL, NULL, NULL, NULL, NULL, '1', 36, 37, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(88, 83, NULL, NULL, 'admin_login', NULL, NULL, NULL, NULL, NULL, '1', 38, 39, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(178, 83, NULL, NULL, 'admin_disablelist', '', NULL, NULL, NULL, NULL, '1', 46, 47, NULL, 0, '2013-07-10 08:40:12', 19, NULL, NULL, 'Y', 'Y', 0),
	(177, 83, NULL, NULL, 'admin_disableuser', 'Desativar usuário', NULL, NULL, NULL, NULL, '1', 44, 45, NULL, 0, '2013-07-11 10:46:44', 19, NULL, NULL, 'Y', 'Y', 0),
	(94, 13, NULL, NULL, 'admin_novoAco', '', NULL, NULL, NULL, NULL, '1', 20, 21, NULL, 0, '2013-07-10 08:44:35', 19, NULL, NULL, 'Y', 'Y', 0),
	(117, 13, NULL, NULL, 'admin_add_apelido', NULL, NULL, NULL, NULL, NULL, '1', 22, 23, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(105, 12, NULL, NULL, 'Aros', NULL, NULL, NULL, NULL, NULL, '1', 61, 70, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(106, 105, NULL, NULL, 'admin_add', '', 'Criar novo papel/grupo', 5, 'Criar grupos(papéis) para usuários do sistema', 'Criar Grupo', 'N', 62, 63, NULL, 0, '2014-02-17 15:52:09', 19, 'Y', 2, 'N', 'N', 3),
	(107, 105, NULL, NULL, 'add_aro', NULL, NULL, NULL, NULL, NULL, '1', 64, 65, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(109, 105, NULL, NULL, 'admin_index', '', 'Listar papéis(grupos)', 5, 'Listagem de grupos de acesso do sistema', 'Grupos', 'N', 66, 67, NULL, 0, '2014-02-17 15:51:53', 19, 'Y', 2, 'N', 'N', 3),
	(111, 105, NULL, NULL, 'admin_edit', 'Editar grupo/papel', NULL, NULL, NULL, NULL, '1', 68, 69, NULL, 0, '2013-07-10 15:46:52', 19, NULL, NULL, 'Y', 'Y', 0),
	(147, 12, NULL, NULL, 'Menugroups', NULL, NULL, NULL, NULL, NULL, '1', 81, 94, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(231, 147, NULL, NULL, 'admin_configMenu', NULL, 'Configuração do menu', 8, 'A tela exibe os módulos com as funções e opções para configuração do item do menu', 'Configura itens de menu', 'Y', 92, 93, '2014-02-21 10:05:52', 19, '2014-02-21 10:15:43', 19, 'Y', 1, 'N', 'N', 3),
	(125, 38, NULL, NULL, 'ajaxMsg', NULL, NULL, NULL, NULL, NULL, '1', 30, 31, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(144, 12, NULL, NULL, 'Roles', NULL, NULL, NULL, NULL, NULL, '1', 77, 80, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(132, 83, NULL, NULL, 'admin_add', NULL, NULL, NULL, NULL, NULL, '1', 40, 41, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(133, 120, NULL, NULL, 'admin_view', 'Visualizar perfil', NULL, NULL, NULL, NULL, '1', 74, 75, NULL, 0, '2013-07-10 15:43:50', 19, NULL, NULL, 'Y', 'Y', 0),
	(146, 144, NULL, NULL, 'admin_delete', 'Deletar grupo/papel', NULL, NULL, NULL, NULL, '1', 78, 79, NULL, 0, '2013-07-10 10:12:24', 19, NULL, NULL, 'Y', 'Y', 0),
	(153, 147, NULL, NULL, 'admin_index', NULL, NULL, NULL, NULL, NULL, '1', 82, 83, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(154, 147, NULL, NULL, 'admin_view', NULL, NULL, NULL, NULL, NULL, '1', 84, 85, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(155, 147, NULL, NULL, 'admin_add', NULL, NULL, NULL, NULL, NULL, '1', 86, 87, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(156, 147, NULL, NULL, 'admin_edit', NULL, NULL, NULL, NULL, NULL, '1', 88, 89, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(157, 147, NULL, NULL, 'admin_delete', NULL, NULL, NULL, NULL, NULL, '1', 90, 91, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(179, 83, NULL, NULL, 'admin_reactivate', NULL, NULL, NULL, NULL, NULL, '1', 48, 49, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(176, 83, NULL, NULL, 'admin_trocarsenha', '', 'Alterar minha senha', NULL, 'Troca senha do usuário logado', 'Alterar minha senha', '1', 42, 43, NULL, 0, '2014-02-18 17:03:55', 19, NULL, NULL, 'Y', 'N', 1),
	(180, 83, NULL, NULL, 'admin_view', NULL, NULL, NULL, NULL, NULL, '1', 50, 51, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(181, 83, NULL, NULL, 'admin_edit', NULL, NULL, NULL, NULL, NULL, '1', 52, 53, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(182, 83, NULL, NULL, 'admin_delete', NULL, NULL, NULL, NULL, NULL, '1', 54, 55, NULL, 0, NULL, 0, NULL, NULL, 'Y', 'Y', 0),
	(183, 83, NULL, NULL, 'admin_list', '', NULL, NULL, NULL, NULL, '1', 56, 57, '2013-07-03 11:34:55', 11, '2013-07-10 08:40:03', 19, NULL, NULL, 'Y', 'Y', 0),
	(184, 83, NULL, NULL, 'exibeMenu', NULL, NULL, NULL, NULL, NULL, '1', 58, 59, '2013-07-04 13:10:59', 11, '2013-07-04 13:10:59', 11, NULL, NULL, 'Y', 'Y', 0),
	(201, 12, NULL, NULL, 'Holidays', NULL, NULL, NULL, NULL, NULL, '1', 111, 120, '2013-07-17 14:28:22', 19, '2013-07-17 14:28:22', 19, NULL, NULL, 'Y', 'Y', 0),
	(202, 201, NULL, NULL, 'admin_index', NULL, 'Configuração de feriados', 4, 'Lista os feriados já configurados no sistema', 'Configuração de feriados', 'Y', 112, 113, '2013-07-17 14:28:23', 19, '2014-02-20 17:02:52', 19, 'Y', 2, 'N', 'N', 3),
	(203, 201, NULL, NULL, 'admin_add', 'Adicionar feriado', 'Adicionar feriado', 4, 'Configura no sistema datas de feriados', 'Adicionar feriado', 'Y', 114, 115, '2013-07-17 14:28:23', 19, '2014-02-20 17:02:38', 19, 'Y', 1, 'N', 'N', 3),
	(204, 201, NULL, NULL, 'admin_edit', 'Editar feriado', 'Editar cadastro de feriado', NULL, 'Edita um registro de feriado', 'Editar cadastro de feriado', '1', 116, 117, '2013-07-17 14:28:23', 19, '2014-01-27 10:58:21', 19, NULL, NULL, 'Y', 'N', 3),
	(205, 201, NULL, NULL, 'admin_delete', 'Deletar feriado', NULL, NULL, NULL, NULL, '1', 118, 119, '2013-07-17 14:28:24', 19, '2013-07-17 14:31:12', 19, NULL, NULL, 'Y', 'Y', 0),
	(206, 13, NULL, NULL, 'admin_configMenu', NULL, 'Configurar menu', NULL, 'Configuração de menu para o item selecionado', 'Configurar menu', 'N', 24, 25, '2013-12-23 15:50:30', 19, '2014-02-20 14:35:43', 19, 'N', NULL, 'Y', 'N', 3),
	(207, 12, NULL, NULL, 'ProfileUsers', NULL, NULL, NULL, NULL, NULL, 'N', 121, 130, '2014-01-16 09:41:20', 19, '2014-01-16 09:41:20', 19, 'N', NULL, 'Y', 'Y', 0),
	(208, 207, NULL, NULL, 'cadastraUsuario', NULL, 'Cadastrar usuário no sistema', NULL, 'Cadastra usuário para perfil selecionado', 'Cadastrar usuário no sistema', 'N', 122, 123, '2014-01-16 09:41:20', 19, '2014-02-20 11:02:57', 19, 'N', NULL, 'N', 'N', 1),
	(209, 207, NULL, NULL, 'admin_verificaCpf', NULL, 'Novo usuário', 3, 'Verifica se o usuário ja possui algum cadastro na empresa', 'Consultar cpf de usuário', 'Y', 124, 125, '2014-01-16 09:41:20', 19, '2014-02-20 16:48:40', 19, 'Y', 1, 'N', 'Y', 1),
	(210, 207, NULL, NULL, 'admin_cadastraPerfil', NULL, 'Cadastrar usuário', 3, 'Formulário de cadastro de usuários do sistema. ', 'Cadastrar dados de usuário', 'N', 126, 127, '2014-01-16 09:41:20', 19, '2014-02-20 16:48:51', 19, 'N', 1, 'N', 'N', 1),
	(211, 207, NULL, NULL, 'admin_consultaUsuarios', NULL, 'Consultar usuários', 3, 'Consulta usuários cadastrados no sistema', 'Consultar usuários', 'Y', 128, 129, '2014-01-16 09:41:20', 19, '2014-02-20 16:35:44', 19, 'Y', 2, 'N', 'N', 1),
	(212, 13, NULL, NULL, 'admin_configAco', NULL, NULL, NULL, NULL, NULL, 'N', 26, 27, '2014-01-22 15:00:50', 19, '2014-01-22 15:00:50', 19, 'N', NULL, 'Y', 'Y', 0),
	(213, 12, NULL, NULL, 'Modules', NULL, NULL, NULL, NULL, NULL, 'N', 131, 140, '2014-01-22 15:57:51', 19, '2014-01-22 15:57:51', 19, 'N', NULL, 'Y', 'Y', 0),
	(214, 213, NULL, NULL, 'admin_index', NULL, NULL, NULL, NULL, NULL, 'N', 132, 133, '2014-01-22 15:57:51', 19, '2014-01-22 15:57:51', 19, 'N', NULL, 'Y', 'Y', 0),
	(215, 213, NULL, NULL, 'admin_add', NULL, NULL, NULL, NULL, NULL, 'N', 134, 135, '2014-01-22 15:57:51', 19, '2014-01-22 15:57:51', 19, 'N', NULL, 'Y', 'Y', 0),
	(216, 213, NULL, NULL, 'admin_edit', NULL, NULL, NULL, NULL, NULL, 'N', 136, 137, '2014-01-22 15:57:51', 19, '2014-01-22 15:57:51', 19, 'N', NULL, 'Y', 'Y', 0),
	(217, 213, NULL, NULL, 'admin_delete', NULL, NULL, NULL, NULL, NULL, 'N', 138, 139, '2014-01-22 16:24:59', 19, '2014-01-22 16:24:59', 19, 'N', NULL, 'Y', 'Y', 0),
	(227, 226, NULL, NULL, 'admin_index', NULL, NULL, NULL, NULL, NULL, 'N', 142, 143, '2014-02-17 15:56:08', 19, '2014-02-17 15:56:08', 19, 'N', NULL, 'Y', 'Y', 0),
	(228, 226, NULL, NULL, 'admin_changePermission', NULL, NULL, NULL, NULL, NULL, 'N', 144, 145, '2014-02-19 15:05:38', 19, '2014-02-19 15:05:38', 19, 'N', NULL, 'Y', 'Y', NULL),
	(229, 226, NULL, NULL, 'allow', NULL, NULL, NULL, NULL, NULL, 'N', 146, 147, '2014-02-19 17:04:38', 19, '2014-02-19 17:04:38', 19, 'N', NULL, 'Y', 'Y', NULL),
	(230, 226, NULL, NULL, 'setAroAco', NULL, NULL, NULL, NULL, NULL, 'N', 148, 149, '2014-02-19 17:04:38', 19, '2014-02-19 17:04:38', 19, 'N', NULL, 'Y', 'Y', NULL);
/*!40000 ALTER TABLE `acos` ENABLE KEYS */;


-- Dumping structure for table andre_newCore.aros
CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- Dumping data for table andre_newCore.aros: 6 rows
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;
INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`, `created`, `createdby`, `modified`, `modifiedby`) VALUES
	(1, NULL, NULL, NULL, 'Roles', 1, 42, NULL, 0, NULL, 0),
	(2, 1, 'Role', 1, NULL, 2, 3, NULL, 0, NULL, 0),
	(3, 1, 'Role', 2, NULL, 4, 5, NULL, 0, NULL, 0),
	(4, 1, 'Role', 3, NULL, 20, 21, NULL, 0, NULL, 0),
	(42, 1, 'Role', 41, NULL, 40, 41, NULL, 0, NULL, 0),
	(43, 1, 'Role', 42, NULL, 43, 44, '2013-07-05 11:21:50', 19, '2013-07-05 14:32:00', 19);
/*!40000 ALTER TABLE `aros` ENABLE KEYS */;


-- Dumping structure for table andre_newCore.aros_acos
CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;

-- Dumping data for table andre_newCore.aros_acos: 64 rows
/*!40000 ALTER TABLE `aros_acos` DISABLE KEYS */;
INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`, `created`, `createdby`, `modified`, `modifiedby`) VALUES
	(37, 3, 106, '1', '1', '1', '1', NULL, 0, NULL, 0),
	(42, 42, 12, '1', '1', '1', '1', NULL, 0, NULL, 0),
	(35, 3, 111, '1', '1', '1', '1', NULL, 0, '2013-07-10 15:46:52', 19),
	(34, 3, 109, '1', '1', '1', '1', NULL, 0, NULL, 0),
	(32, 3, 15, '1', '1', '1', '1', NULL, 0, NULL, 0),
	(29, 3, 133, '1', '1', '1', '1', NULL, 0, '2013-07-10 15:43:50', 19),
	(28, 3, 132, '1', '1', '1', '1', NULL, 0, NULL, 0),
	(110, 42, 210, '1', '1', '1', '1', '2014-02-21 14:19:25', 19, '2014-02-21 14:19:25', 19),
	(27, 3, 84, '1', '1', '1', '1', NULL, 0, '2013-07-10 09:52:04', 19),
	(48, 3, 176, '1', '1', '1', '1', '2013-07-05 16:23:12', 19, '2013-07-05 16:23:12', 19),
	(109, 2, 231, '0', '0', '0', '0', '2014-02-21 10:15:09', 19, '2014-02-21 10:15:09', 19),
	(90, 2, 210, '0', '0', '0', '0', '2014-01-27 15:04:28', 19, '2014-02-20 11:02:38', 19),
	(47, 3, 123, '1', '1', '1', '1', NULL, 0, '2013-07-10 15:44:56', 19),
	(49, 3, 183, '1', '1', '1', '1', '2013-07-05 16:48:23', 19, '2013-07-05 16:48:23', 19),
	(50, 3, 178, '1', '1', '1', '1', '2013-07-05 17:25:10', 19, '2013-07-05 17:25:10', 19),
	(51, 3, 94, '1', '1', '1', '1', '2013-07-05 17:26:56', 19, '2013-07-05 17:26:56', 19),
	(52, 3, 181, '1', '1', '1', '1', '2013-07-09 11:38:04', 19, '2013-07-09 11:38:04', 19),
	(53, 3, 179, '1', '1', '1', '1', '2013-07-10 10:06:00', 19, '2013-07-10 10:06:00', 19),
	(54, 3, 146, '1', '1', '1', '1', '2013-07-10 10:12:24', 19, '2013-07-10 10:12:24', 19),
	(93, 2, 109, '0', '0', '0', '0', '2014-02-17 15:43:02', 19, '2014-02-17 15:43:02', 19),
	(57, 42, 176, '0', '0', '0', '0', '2013-07-10 14:23:39', 19, '2014-02-21 09:47:52', 19),
	(58, 42, 123, '0', '0', '0', '0', '2013-07-10 16:06:24', 19, '2013-07-11 17:32:39', 12),
	(59, 42, 183, '0', '0', '0', '0', '2013-07-10 17:24:04', 12, '2013-07-12 13:25:13', 12),
	(108, 42, 206, '0', '0', '0', '0', '2014-02-20 17:28:41', 19, '2014-02-20 17:32:01', 19),
	(61, 42, 146, '0', '0', '0', '0', '2013-07-10 17:34:24', 12, '2013-07-12 13:25:27', 12),
	(62, 42, 178, '0', '0', '0', '0', '2013-07-10 17:46:14', 12, '2013-07-12 14:43:46', 12),
	(63, 42, 133, '1', '1', '1', '1', '2013-07-10 17:46:28', 12, '2013-07-12 13:26:04', 12),
	(64, 3, 177, '1', '1', '1', '1', '2013-07-11 10:46:44', 19, '2013-07-11 10:46:44', 19),
	(65, 42, 177, '0', '0', '0', '0', '2013-07-11 10:47:42', 19, '2013-07-12 14:48:33', 12),
	(66, 43, 183, '0', '0', '0', '0', '2013-07-11 11:01:55', 12, '2013-07-11 11:24:38', 12),
	(67, 43, 178, '0', '0', '0', '0', '2013-07-11 11:04:51', 12, '2013-07-11 11:24:34', 12),
	(68, 43, 176, '1', '1', '1', '1', '2013-07-11 11:04:56', 12, '2014-02-19 17:05:10', 19),
	(70, 43, 109, '0', '0', '0', '0', '2013-07-11 11:05:05', 12, '2014-02-19 17:34:44', 19),
	(71, 43, 106, '0', '0', '0', '0', '2013-07-11 11:05:10', 12, '2014-02-19 17:36:23', 19),
	(107, 2, 206, '0', '0', '0', '0', '2014-02-20 14:35:43', 19, '2014-02-20 14:35:43', 19),
	(92, 2, 208, '0', '0', '0', '0', '2014-01-27 15:07:29', 19, '2014-02-20 11:02:57', 19),
	(74, 43, 123, '0', '0', '0', '0', '2013-07-11 11:05:24', 12, '2013-07-11 11:25:11', 12),
	(75, 43, 177, '0', '0', '0', '0', '2013-07-11 11:05:28', 12, '2013-07-11 14:13:44', 19),
	(76, 43, 111, '0', '0', '0', '0', '2013-07-11 11:05:34', 12, '2013-07-11 14:13:39', 19),
	(77, 43, 133, '0', '0', '0', '0', '2013-07-11 11:05:39', 12, '2013-07-11 14:14:06', 19),
	(78, 43, 146, '0', '0', '0', '0', '2013-07-11 11:05:43', 12, '2013-07-11 14:13:56', 19),
	(91, 2, 209, '1', '1', '1', '1', '2014-01-27 15:05:41', 19, '2014-01-27 15:07:43', 19),
	(81, 42, 111, '0', '0', '0', '0', '2013-07-11 16:53:49', 12, '2013-07-12 13:25:23', 12),
	(82, 42, 109, '0', '0', '0', '0', '2013-07-11 17:32:27', 12, '2014-02-20 15:08:27', 19),
	(83, 3, 196, '1', '1', '1', '1', '2013-07-12 10:19:37', 19, '2013-07-12 10:19:37', 19),
	(84, 3, 205, '1', '1', '1', '1', '2013-07-17 14:31:12', 19, '2013-07-17 14:31:12', 19),
	(85, 3, 204, '1', '1', '1', '1', '2013-07-17 14:31:27', 19, '2013-07-17 14:31:27', 19),
	(86, 3, 203, '1', '1', '1', '1', '2013-07-17 14:31:44', 19, '2013-07-17 14:31:44', 19),
	(87, 3, 202, '1', '1', '1', '1', '2013-07-17 14:32:02', 19, '2013-07-17 14:32:02', 19),
	(88, 0, 0, '0', '0', '0', '0', '2014-01-27 13:22:40', 19, '2014-01-27 13:22:40', 19),
	(89, 2, 211, '0', '0', '0', '0', '2014-01-27 13:37:40', 19, '2014-01-27 13:37:40', 19),
	(94, 2, 106, '0', '0', '0', '0', '2014-02-17 15:49:22', 19, '2014-02-17 15:49:22', 19),
	(95, 2, 176, '0', '0', '0', '0', '2014-02-18 17:03:30', 19, '2014-02-18 17:03:55', 19),
	(96, 42, 106, '0', '0', '0', '0', '2014-02-19 16:21:29', 19, '2014-02-20 09:54:53', 19),
	(97, 42, 193, '0', '0', '0', '0', '2014-02-19 16:30:19', 19, '2014-02-20 09:58:00', 19),
	(98, 42, 211, '0', '0', '0', '0', '2014-02-19 16:30:40', 19, '2014-02-21 09:15:57', 19),
	(99, 42, 209, '0', '0', '0', '0', '2014-02-19 16:30:48', 19, '2014-02-21 10:07:18', 19),
	(100, 43, 203, '0', '0', '0', '0', '2014-02-19 17:04:48', 19, '2014-02-19 17:05:00', 19),
	(101, 43, 204, '0', '0', '0', '0', '2014-02-19 17:04:54', 19, '2014-02-19 17:35:52', 19),
	(102, 43, 193, '0', '0', '0', '0', '2014-02-19 17:05:55', 19, '2014-02-19 17:36:19', 19),
	(103, 43, 202, '0', '0', '0', '0', '2014-02-19 17:14:54', 19, '2014-02-19 17:21:36', 19),
	(104, 42, 202, '0', '0', '0', '0', '2014-02-20 09:13:13', 19, '2014-02-21 09:47:43', 19),
	(105, 42, 204, '0', '0', '0', '0', '2014-02-20 09:13:19', 19, '2014-02-20 09:54:31', 19),
	(106, 42, 203, '0', '0', '0', '0', '2014-02-20 09:57:24', 19, '2014-02-21 10:29:40', 19);
/*!40000 ALTER TABLE `aros_acos` ENABLE KEYS */;


-- Dumping structure for table andre_newCore.configmails
CREATE TABLE IF NOT EXISTS `configmails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transport` varchar(50) NOT NULL,
  `from` varchar(50) NOT NULL,
  `host` varchar(50) DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `timeout` varchar(50) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `client` varchar(50) DEFAULT NULL,
  `emailFormat` varchar(50) NOT NULL,
  `log` tinyint(1) NOT NULL,
  `charset` varchar(50) NOT NULL,
  `headerCharset` varchar(50) NOT NULL,
  `attachments` varchar(50) DEFAULT NULL,
  `tls` tinyint(1) NOT NULL,
  `template` varchar(200) DEFAULT NULL,
  `isdeleted` char(1) NOT NULL DEFAULT 'N',
  `created` datetime DEFAULT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table andre_newCore.configmails: 2 rows
/*!40000 ALTER TABLE `configmails` DISABLE KEYS */;
INSERT INTO `configmails` (`id`, `transport`, `from`, `host`, `port`, `timeout`, `username`, `password`, `client`, `emailFormat`, `log`, `charset`, `headerCharset`, `attachments`, `tls`, `template`, `isdeleted`, `created`, `createdby`, `modified`, `modifiedby`) VALUES
	(1, 'Mail', 'sac@virtualtelecom.com.br', '', NULL, '', '', '', '', 'both', 0, 'utf-8', 'utf-8', NULL, 0, NULL, 'N', NULL, 0, NULL, 0),
	(2, 'Smtp', 'andreluis@virtualtelecom.com.br', 'smtp.virtualtelecom.com.br', 25, '30', 'andreluis@virtualtelecom.com.br', '', '', 'both', 0, 'utf-8', 'utf-8', NULL, 0, NULL, 'Y', '2013-07-12 10:53:08', 19, '2013-07-12 11:30:46', 19);
/*!40000 ALTER TABLE `configmails` ENABLE KEYS */;


-- Dumping structure for table andre_newCore.menugroups
CREATE TABLE IF NOT EXISTS `menugroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(200) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `isdeleted` varchar(45) DEFAULT 'N',
  `created` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menugroups_menugroups` (`parent_id`),
  CONSTRAINT `fk_menugroups_menugroups` FOREIGN KEY (`parent_id`) REFERENCES `menugroups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table andre_newCore.menugroups: ~6 rows (approximately)
/*!40000 ALTER TABLE `menugroups` DISABLE KEYS */;
INSERT INTO `menugroups` (`id`, `grupo`, `parent_id`, `isdeleted`, `created`, `createdby`, `modified`, `modifiedby`, `ordem`) VALUES
	(1, 'Sistema', NULL, 'N', '2014-01-07 17:31:22', 19, '2014-01-07 17:31:22', 19, 10),
	(3, 'Usuários', NULL, 'N', '2014-01-16 11:12:34', 19, '2014-01-16 11:35:37', 19, 1),
	(4, 'Feriados', 1, 'N', '2014-01-27 16:08:31', 19, '2014-02-18 13:30:12', 19, 1),
	(5, 'Grupos', 1, 'N', '2014-01-27 16:08:57', 19, '2014-01-27 16:08:57', 19, 2),
	(7, 'teste', 1, 'N', '2014-02-20 13:01:03', 19, '2014-02-20 13:01:03', 19, 3),
	(8, 'Menu', 1, 'N', '2014-02-21 10:01:30', 19, '2014-02-21 10:01:30', 19, 3);
/*!40000 ALTER TABLE `menugroups` ENABLE KEYS */;


-- Dumping structure for table andre_newCore.modules
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` char(100) NOT NULL,
  `alias` char(100) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  `isdeleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table andre_newCore.modules: ~3 rows (approximately)
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` (`id`, `nome`, `alias`, `created`, `createdby`, `modified`, `modifiedby`, `isdeleted`) VALUES
	(1, 'Gerenciamento de usuários', 'usuarios', '2014-01-22 17:06:16', 19, '2014-01-22 17:06:16', 19, 'N'),
	(2, 'Gerenciamento de permissões(acos)', 'permissoes', '2014-01-22 17:33:50', 19, '2014-02-19 14:28:35', 19, 'Y'),
	(3, 'Configurações de sistema', 'sistema', '2014-01-24 11:02:37', 19, '2014-01-24 11:02:37', 19, 'N');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;


-- Dumping structure for table andre_newCore.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` char(40) CHARACTER SET utf8 NOT NULL,
  `role` char(40) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int(11) NOT NULL,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `isdeleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Dumping data for table andre_newCore.roles: 5 rows
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `alias`, `role`, `created`, `createdby`, `modified`, `modifiedby`, `isactive`, `isdeleted`) VALUES
	(1, 'Programador', 'Programador', NULL, 0, NULL, 0, 'Y', 'N'),
	(2, 'Administrador', 'Administrador', NULL, 0, NULL, 0, 'Y', 'N'),
	(3, 'Público', 'Público', NULL, 0, NULL, 0, 'Y', 'N'),
	(41, 'Administrador II', 'Administrador II', NULL, 0, NULL, 0, 'Y', 'N'),
	(42, 'Recepção', 'recepcao', '2013-07-05 11:21:49', 19, '2013-07-10 10:12:35', 12, 'Y', 'N');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;


-- Dumping structure for table andre_newCore.roles_users
CREATE TABLE IF NOT EXISTS `roles_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modifiedby` int(11) NOT NULL,
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `isdeleted` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Dumping data for table andre_newCore.roles_users: 4 rows
/*!40000 ALTER TABLE `roles_users` DISABLE KEYS */;
INSERT INTO `roles_users` (`id`, `role_id`, `user_id`, `created`, `createdby`, `modified`, `modifiedby`, `isactive`, `isdeleted`) VALUES
	(1, 1, 11, NULL, 0, NULL, 0, 'Y', 'N'),
	(14, 2, 12, '2013-07-05 10:36:52', 19, '2014-02-20 17:08:02', 19, 'Y', 'N'),
	(12, 1, 19, '2013-07-05 09:41:13', 11, '2013-07-05 09:41:13', 11, 'Y', 'N'),
	(16, 41, 13, '2013-07-12 13:23:43', 12, '2013-07-12 13:23:43', 12, 'Y', 'N');
/*!40000 ALTER TABLE `roles_users` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
