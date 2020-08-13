/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100413
 Source Host           : localhost:3306
 Source Schema         : aix

 Target Server Type    : MySQL
 Target Server Version : 100413
 File Encoding         : 65001

 Date: 12/08/2020 20:03:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for courses
-- ----------------------------
DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of courses
-- ----------------------------
INSERT INTO `courses` VALUES (1, 'Administração', '2020-08-07 12:18:53', '2020-08-12 19:46:33');
INSERT INTO `courses` VALUES (2, 'Engenharia de Produção', '2020-08-07 12:18:53', '2020-08-07 12:18:53');
INSERT INTO `courses` VALUES (3, 'Sistemas de Informação', '2020-08-07 12:18:53', '2020-08-07 12:18:53');
INSERT INTO `courses` VALUES (4, 'Engenharia Elétrica', '2020-08-07 12:18:53', '2020-08-07 12:18:53');
INSERT INTO `courses` VALUES (5, 'Educação Física', '2020-08-07 12:18:54', '2020-08-07 12:18:54');
INSERT INTO `courses` VALUES (6, 'Fisioterapia', '2020-08-07 12:18:54', '2020-08-07 12:18:54');
INSERT INTO `courses` VALUES (7, 'Computação', '2020-08-09 00:22:32', '2020-08-09 00:22:32');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user` bigint UNSIGNED NOT NULL,
  `action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of logs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2020_01_17_183458_create_pages_table', 1);
INSERT INTO `migrations` VALUES (5, '2020_01_22_145913_create_banners_table', 1);
INSERT INTO `migrations` VALUES (6, '2020_01_23_153832_create_subitems_table', 1);
INSERT INTO `migrations` VALUES (7, '2020_01_24_142442_create_types_services_table', 1);
INSERT INTO `migrations` VALUES (8, '2020_01_24_182437_create_priorities_table', 1);
INSERT INTO `migrations` VALUES (9, '2020_01_26_113939_create_type_versions_table', 1);
INSERT INTO `migrations` VALUES (10, '2020_01_26_163018_create_categories_table', 1);
INSERT INTO `migrations` VALUES (11, '2020_01_27_220734_create_messages_table', 1);
INSERT INTO `migrations` VALUES (12, '2020_01_28_113734_create_bug_trackings_table', 2);
INSERT INTO `migrations` VALUES (13, '2020_01_28_195206_create_types_modules_table', 3);
INSERT INTO `migrations` VALUES (14, '2020_01_29_144618_create_modules_table', 4);
INSERT INTO `migrations` VALUES (15, '2020_01_29_233140_create_newsletter_table', 5);
INSERT INTO `migrations` VALUES (17, '2020_01_30_152953_create_type_documents_table', 7);
INSERT INTO `migrations` VALUES (19, '2020_01_30_155659_create_clients_table', 8);
INSERT INTO `migrations` VALUES (21, '2020_02_01_130006_create_parameter_sites_table', 10);
INSERT INTO `migrations` VALUES (22, '2020_02_03_213955_create_addresses_table', 11);
INSERT INTO `migrations` VALUES (23, '2020_02_03_233918_create_states_table', 12);
INSERT INTO `migrations` VALUES (24, '2020_02_06_134227_create_payment_methos_table', 13);
INSERT INTO `migrations` VALUES (25, '2020_02_06_140214_create_requests_status_table', 14);
INSERT INTO `migrations` VALUES (26, '2020_02_06_150000_create_requests_table', 14);
INSERT INTO `migrations` VALUES (27, '2020_02_06_210844_create_types_products_table', 15);
INSERT INTO `migrations` VALUES (28, '2020_02_07_155524_create_versions_table', 16);
INSERT INTO `migrations` VALUES (30, '2020_02_07_165524_create_products_table', 17);
INSERT INTO `migrations` VALUES (35, '2020_02_07_175524_create_products_items_table', 18);
INSERT INTO `migrations` VALUES (36, '2020_02_08_195828_create_requests_items_table', 18);
INSERT INTO `migrations` VALUES (38, '2020_02_09_144756_create_cart_table', 19);
INSERT INTO `migrations` VALUES (39, '2020_02_14_130320_create_cashier_system_table', 20);
INSERT INTO `migrations` VALUES (40, '2020_02_14_154740_create_school_system_table', 21);
INSERT INTO `migrations` VALUES (42, '2020_02_16_175754_create_param_admins_table', 22);
INSERT INTO `migrations` VALUES (43, '2020_02_17_195050_create_counters_table', 23);
INSERT INTO `migrations` VALUES (44, '2020_02_18_131918_create_counters_type_table', 24);
INSERT INTO `migrations` VALUES (45, '2020_02_18_132326_create_counters_types_table', 25);
INSERT INTO `migrations` VALUES (46, '2020_02_18_134439_create_counters_pages_table', 26);
INSERT INTO `migrations` VALUES (47, '2020_02_19_154350_create_counters_subitems_table', 27);
INSERT INTO `migrations` VALUES (48, '2020_02_19_205527_create_counters_banners_table', 28);
INSERT INTO `migrations` VALUES (49, '2020_02_19_222017_create_counters_permissions_table', 29);
INSERT INTO `migrations` VALUES (50, '2020_02_19_223833_create_permissions_table', 30);
INSERT INTO `migrations` VALUES (51, '2020_02_27_211555_create_domines_table', 31);

-- ----------------------------
-- Table structure for modules
-- ----------------------------
DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `typeModule` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `ordem` int NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `modules_typemodule_foreign`(`typeModule`) USING BTREE,
  CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`typeModule`) REFERENCES `type_modules` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of modules
-- ----------------------------
INSERT INTO `modules` VALUES (14, 6, 'Cursos', 'cursos', NULL, '1', '2020-01-29 21:42:19', '2020-08-08 14:07:59');
INSERT INTO `modules` VALUES (15, 6, 'Alunos', 'alunos', NULL, '1', '2020-01-29 21:43:27', '2020-08-08 14:08:05');
INSERT INTO `modules` VALUES (26, 7, 'Usuários', 'usuarios', NULL, '1', '2020-01-29 21:52:10', '2020-08-08 14:08:20');
INSERT INTO `modules` VALUES (27, 7, 'Tipos de Módulo', 'tiposModulo', NULL, '1', '2020-01-29 21:53:08', '2020-08-08 14:08:37');
INSERT INTO `modules` VALUES (28, 7, 'Módulos', 'modulos', NULL, '1', '2020-01-29 21:53:52', '2020-08-08 14:08:46');
INSERT INTO `modules` VALUES (29, 7, 'Permissão', 'permissao', NULL, '1', '2020-01-29 21:54:24', '2020-08-08 14:08:54');
INSERT INTO `modules` VALUES (31, 7, 'Logs de Acesso', 'logsAcesso', NULL, '1', '2020-02-19 22:16:43', '2020-08-08 14:08:59');
INSERT INTO `modules` VALUES (32, 7, 'Usuários Pré Cadastrados', 'usuarios-pre', NULL, '1', '2020-04-13 11:37:22', '2020-08-08 14:09:06');
INSERT INTO `modules` VALUES (33, 6, 'Alunos X Curso', 'alunosCurso', NULL, '1', '2020-08-06 12:42:42', '2020-08-08 16:01:50');
INSERT INTO `modules` VALUES (34, 6, 'Versão', 'versao', NULL, '1', '2020-08-08 14:09:42', '2020-08-08 16:02:05');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user` bigint UNSIGNED NOT NULL,
  `module` bigint UNSIGNED NOT NULL,
  `view` int NOT NULL,
  `register` int NOT NULL,
  `delete` int NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 83 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 1, 1, 1, 1, 1, '2020-02-20 02:07:33', '2020-02-20 02:07:33');
INSERT INTO `permissions` VALUES (2, 1, 1, 1, 0, 0, '2020-02-20 02:07:56', '2020-02-20 02:07:56');
INSERT INTO `permissions` VALUES (3, 1, 1, 1, 0, 0, '2020-02-20 02:08:46', '2020-02-20 02:08:46');
INSERT INTO `permissions` VALUES (4, 1, 1, 1, 0, 0, '2020-02-20 02:18:12', '2020-02-20 02:18:12');
INSERT INTO `permissions` VALUES (5, 1, 1, 1, 0, 0, '2020-02-20 02:18:41', '2020-02-20 02:18:41');
INSERT INTO `permissions` VALUES (6, 1, 1, 1, 0, 0, '2020-02-20 02:18:50', '2020-02-20 02:18:50');
INSERT INTO `permissions` VALUES (7, 1, 1, 1, 0, 0, '2020-02-20 02:19:45', '2020-02-20 02:19:45');
INSERT INTO `permissions` VALUES (8, 1, 1, 1, 0, 0, '2020-02-20 02:20:51', '2020-02-20 02:20:51');
INSERT INTO `permissions` VALUES (9, 2, 1, 1, 1, 1, '2020-02-20 02:30:34', '2020-02-20 02:30:34');
INSERT INTO `permissions` VALUES (10, 1, 2, 1, 1, 1, '2020-02-20 12:16:12', '2020-02-20 12:16:12');
INSERT INTO `permissions` VALUES (11, 1, 3, 1, 1, 1, '2020-02-20 12:16:20', '2020-02-20 12:16:20');
INSERT INTO `permissions` VALUES (12, 1, 4, 1, 1, 1, '2020-02-20 12:16:26', '2020-02-20 12:16:26');
INSERT INTO `permissions` VALUES (13, 1, 5, 1, 1, 1, '2020-02-20 12:16:47', '2020-02-20 12:16:47');
INSERT INTO `permissions` VALUES (14, 1, 6, 1, 1, 1, '2020-02-20 12:18:15', '2020-02-20 12:18:15');
INSERT INTO `permissions` VALUES (16, 1, 30, 1, 1, 1, '2020-02-20 12:18:23', '2020-02-20 12:18:23');
INSERT INTO `permissions` VALUES (18, 1, 7, 1, 1, 1, '2020-02-20 12:18:28', '2020-02-20 12:18:28');
INSERT INTO `permissions` VALUES (20, 1, 8, 1, 1, 1, '2020-02-20 12:18:33', '2020-02-20 12:18:33');
INSERT INTO `permissions` VALUES (21, 1, 9, 1, 1, 1, '2020-02-20 12:18:38', '2020-02-20 12:18:38');
INSERT INTO `permissions` VALUES (22, 1, 10, 1, 1, 1, '2020-02-20 12:18:41', '2020-02-20 12:18:41');
INSERT INTO `permissions` VALUES (23, 1, 11, 1, 1, 1, '2020-02-20 12:18:46', '2020-02-20 12:18:46');
INSERT INTO `permissions` VALUES (24, 1, 12, 1, 1, 1, '2020-02-20 12:18:52', '2020-02-20 12:18:52');
INSERT INTO `permissions` VALUES (25, 1, 13, 1, 1, 1, '2020-02-20 12:19:19', '2020-02-20 12:19:19');
INSERT INTO `permissions` VALUES (26, 1, 14, 1, 1, 1, '2020-02-20 12:19:28', '2020-02-20 12:19:28');
INSERT INTO `permissions` VALUES (27, 1, 15, 1, 1, 1, '2020-02-20 12:19:33', '2020-02-20 12:19:33');
INSERT INTO `permissions` VALUES (28, 1, 16, 1, 1, 1, '2020-02-20 12:19:39', '2020-02-20 12:19:39');
INSERT INTO `permissions` VALUES (29, 1, 17, 1, 1, 1, '2020-02-20 12:19:45', '2020-02-20 12:19:45');
INSERT INTO `permissions` VALUES (30, 1, 18, 1, 1, 1, '2020-02-20 12:19:49', '2020-02-20 12:19:49');
INSERT INTO `permissions` VALUES (31, 1, 19, 1, 1, 1, '2020-02-20 12:19:55', '2020-02-20 12:19:55');
INSERT INTO `permissions` VALUES (32, 1, 20, 1, 1, 1, '2020-02-20 12:20:01', '2020-02-20 12:20:01');
INSERT INTO `permissions` VALUES (33, 1, 21, 1, 1, 1, '2020-02-20 12:20:06', '2020-02-20 12:20:06');
INSERT INTO `permissions` VALUES (34, 1, 22, 1, 1, 1, '2020-02-20 12:20:17', '2020-02-20 12:20:17');
INSERT INTO `permissions` VALUES (35, 1, 24, 1, 1, 1, '2020-02-20 12:20:24', '2020-02-20 12:20:24');
INSERT INTO `permissions` VALUES (36, 1, 26, 1, 1, 1, '2020-02-20 12:20:32', '2020-02-20 12:20:32');
INSERT INTO `permissions` VALUES (37, 1, 27, 1, 1, 1, '2020-02-20 12:20:36', '2020-02-20 12:20:36');
INSERT INTO `permissions` VALUES (38, 1, 28, 1, 1, 1, '2020-02-20 12:20:41', '2020-02-20 12:20:41');
INSERT INTO `permissions` VALUES (39, 1, 29, 1, 1, 1, '2020-02-20 12:20:47', '2020-02-20 12:20:47');
INSERT INTO `permissions` VALUES (40, 1, 31, 1, 1, 1, '2020-02-20 12:20:52', '2020-02-20 12:20:52');
INSERT INTO `permissions` VALUES (41, 2, 2, 1, 1, 1, '2020-02-20 12:21:28', '2020-02-20 12:21:28');
INSERT INTO `permissions` VALUES (42, 2, 3, 1, 1, 1, '2020-02-20 12:21:36', '2020-02-20 12:21:36');
INSERT INTO `permissions` VALUES (43, 2, 4, 1, 1, 1, '2020-02-20 12:21:42', '2020-02-20 12:21:42');
INSERT INTO `permissions` VALUES (44, 2, 5, 1, 1, 1, '2020-02-20 12:21:49', '2020-02-20 12:21:49');
INSERT INTO `permissions` VALUES (45, 2, 6, 1, 1, 1, '2020-02-20 12:21:51', '2020-02-20 12:21:51');
INSERT INTO `permissions` VALUES (46, 2, 30, 1, 1, 1, '2020-02-20 12:21:51', '2020-02-20 12:21:51');
INSERT INTO `permissions` VALUES (47, 2, 7, 1, 1, 1, '2020-02-20 12:22:01', '2020-02-20 12:22:01');
INSERT INTO `permissions` VALUES (48, 2, 8, 1, 1, 1, '2020-02-20 12:22:06', '2020-02-20 12:22:06');
INSERT INTO `permissions` VALUES (49, 2, 9, 1, 1, 1, '2020-02-20 12:22:11', '2020-02-20 12:22:11');
INSERT INTO `permissions` VALUES (50, 2, 10, 1, 1, 1, '2020-02-20 12:22:18', '2020-02-20 12:22:18');
INSERT INTO `permissions` VALUES (51, 2, 11, 1, 1, 1, '2020-02-20 12:22:23', '2020-02-20 12:22:23');
INSERT INTO `permissions` VALUES (52, 2, 12, 1, 1, 1, '2020-02-20 12:22:24', '2020-02-20 12:22:24');
INSERT INTO `permissions` VALUES (53, 2, 13, 1, 1, 1, '2020-02-20 12:22:25', '2020-02-20 12:22:25');
INSERT INTO `permissions` VALUES (54, 2, 14, 1, 1, 1, '2020-02-20 12:22:37', '2020-02-20 12:22:37');
INSERT INTO `permissions` VALUES (55, 2, 15, 1, 1, 1, '2020-02-20 12:24:07', '2020-02-20 12:24:07');
INSERT INTO `permissions` VALUES (56, 2, 16, 1, 1, 1, '2020-02-20 12:24:12', '2020-02-20 12:24:12');
INSERT INTO `permissions` VALUES (57, 2, 17, 1, 1, 1, '2020-02-20 12:24:17', '2020-02-20 12:24:17');
INSERT INTO `permissions` VALUES (58, 2, 18, 1, 1, 1, '2020-02-20 12:24:23', '2020-02-20 12:24:23');
INSERT INTO `permissions` VALUES (59, 2, 19, 1, 1, 1, '2020-02-20 12:24:31', '2020-02-20 12:24:31');
INSERT INTO `permissions` VALUES (60, 2, 20, 1, 1, 1, '2020-02-20 12:24:38', '2020-02-20 12:24:38');
INSERT INTO `permissions` VALUES (61, 2, 21, 1, 1, 1, '2020-02-20 12:24:45', '2020-02-20 12:24:45');
INSERT INTO `permissions` VALUES (62, 2, 22, 1, 1, 1, '2020-02-20 12:24:46', '2020-02-20 12:24:46');
INSERT INTO `permissions` VALUES (63, 2, 24, 0, 0, 0, '2020-02-20 12:24:47', '2020-02-20 12:24:47');
INSERT INTO `permissions` VALUES (64, 2, 26, 1, 1, 1, '2020-02-20 12:24:58', '2020-02-20 12:24:58');
INSERT INTO `permissions` VALUES (65, 2, 31, 1, 1, 1, '2020-02-20 12:25:04', '2020-02-20 12:25:04');
INSERT INTO `permissions` VALUES (70, 1, 32, 1, 1, 1, '2020-04-13 13:23:43', '2020-04-13 13:23:43');
INSERT INTO `permissions` VALUES (71, 1, 33, 1, 1, 1, '2020-08-06 12:43:14', '2020-08-06 12:43:14');
INSERT INTO `permissions` VALUES (72, 3, 14, 1, 1, 1, '2020-08-06 12:49:33', '2020-08-06 12:49:33');
INSERT INTO `permissions` VALUES (73, 3, 15, 1, 1, 1, '2020-08-06 12:49:53', '2020-08-06 12:49:53');
INSERT INTO `permissions` VALUES (74, 3, 33, 1, 1, 1, '2020-08-06 12:49:59', '2020-08-06 12:49:59');
INSERT INTO `permissions` VALUES (75, 3, 26, 1, 1, 1, '2020-08-06 12:50:04', '2020-08-06 12:50:04');
INSERT INTO `permissions` VALUES (76, 3, 27, 1, 1, 1, '2020-08-06 12:50:16', '2020-08-06 12:50:16');
INSERT INTO `permissions` VALUES (77, 3, 28, 1, 1, 1, '2020-08-06 12:50:22', '2020-08-06 12:50:22');
INSERT INTO `permissions` VALUES (78, 3, 29, 1, 1, 1, '2020-08-06 12:50:29', '2020-08-06 12:50:29');
INSERT INTO `permissions` VALUES (79, 3, 31, 1, 1, 1, '2020-08-06 12:50:35', '2020-08-06 12:50:35');
INSERT INTO `permissions` VALUES (80, 3, 32, 1, 1, 1, '2020-08-06 12:50:41', '2020-08-06 12:50:41');
INSERT INTO `permissions` VALUES (81, 1, 34, 1, 1, 1, '2020-08-08 14:09:54', '2020-08-08 14:09:54');
INSERT INTO `permissions` VALUES (82, 3, 34, 1, 1, 1, '2020-08-08 20:14:32', '2020-08-08 20:14:32');

-- ----------------------------
-- Table structure for states
-- ----------------------------
DROP TABLE IF EXISTS `states`;
CREATE TABLE `states`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sigla` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of states
-- ----------------------------
INSERT INTO `states` VALUES (1, 'AC', 'Acre', NULL, NULL);
INSERT INTO `states` VALUES (2, 'AL', 'Alagoas', NULL, NULL);
INSERT INTO `states` VALUES (3, 'AM', 'Amazonas', NULL, NULL);
INSERT INTO `states` VALUES (4, 'AP', 'Amapá', NULL, NULL);
INSERT INTO `states` VALUES (5, 'BA', 'Bahia', NULL, NULL);
INSERT INTO `states` VALUES (6, 'CE', 'Ceará', NULL, NULL);
INSERT INTO `states` VALUES (7, 'DF', 'Distrito Federal', NULL, NULL);
INSERT INTO `states` VALUES (8, 'ES', 'Espírito Santo', NULL, NULL);
INSERT INTO `states` VALUES (9, 'GO', 'Goiás', NULL, NULL);
INSERT INTO `states` VALUES (10, 'MA', 'Maranhão', NULL, NULL);
INSERT INTO `states` VALUES (11, 'MG', 'Minas Gerais', NULL, NULL);
INSERT INTO `states` VALUES (12, 'MS', 'Mato Grosso do Sul', NULL, NULL);
INSERT INTO `states` VALUES (13, 'MT', 'Mato Grosso', NULL, NULL);
INSERT INTO `states` VALUES (14, 'PA', 'Pará', NULL, NULL);
INSERT INTO `states` VALUES (15, 'PB', 'Paraíba', NULL, NULL);
INSERT INTO `states` VALUES (16, 'PE', 'Pernambuco', NULL, NULL);
INSERT INTO `states` VALUES (17, 'PI', 'Piauí', NULL, NULL);
INSERT INTO `states` VALUES (18, 'PR', 'Paraná', NULL, NULL);
INSERT INTO `states` VALUES (19, 'RJ', 'Rio de Janeiro', NULL, NULL);
INSERT INTO `states` VALUES (20, 'RN', 'Rio Grande do Norte', NULL, NULL);
INSERT INTO `states` VALUES (21, 'RO', 'Rondônia', NULL, NULL);
INSERT INTO `states` VALUES (22, 'RR', 'Roraima', NULL, NULL);
INSERT INTO `states` VALUES (23, 'RS', 'Rio Grande do Sul', NULL, NULL);
INSERT INTO `states` VALUES (24, 'SC', 'Santa Catarina', NULL, NULL);
INSERT INTO `states` VALUES (25, 'SE', 'Sergipe', NULL, NULL);
INSERT INTO `states` VALUES (26, 'SP', 'São Paulo', NULL, NULL);
INSERT INTO `states` VALUES (27, 'TO', 'Tocantins', NULL, NULL);

-- ----------------------------
-- Table structure for students
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `registration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '0',
  `zip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `complement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `neighborhood` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `state` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `course` bigint NULL DEFAULT NULL,
  `turma` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 212 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of students
-- ----------------------------
INSERT INTO `students` VALUES (1, '1', 'Daniel Gontijo Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'M', NULL, '2020-08-09 00:27:30', '2020-08-12 19:42:33');
INSERT INTO `students` VALUES (2, '2', 'Breno Amaral Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'M', NULL, '2020-08-09 00:27:30', '2020-08-09 00:27:30');
INSERT INTO `students` VALUES (3, '3', 'Letícia Melo de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'M', NULL, '2020-08-09 00:27:31', '2020-08-09 00:27:31');
INSERT INTO `students` VALUES (4, '4', 'Andréia Oliveira Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'M', NULL, '2020-08-09 00:27:32', '2020-08-09 00:27:32');
INSERT INTO `students` VALUES (5, '5', 'Andréia Marcandier Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'M', NULL, '2020-08-09 00:27:32', '2020-08-09 00:27:32');
INSERT INTO `students` VALUES (6, '6', 'Artur de Sá Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'M', NULL, '2020-08-09 00:27:32', '2020-08-09 00:27:32');
INSERT INTO `students` VALUES (7, '7', 'Daniel Oliveira Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'M', NULL, '2020-08-09 00:27:33', '2020-08-09 00:27:33');
INSERT INTO `students` VALUES (8, '8', 'Isabela Melo de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'M', NULL, '2020-08-09 00:27:33', '2020-08-09 00:27:33');
INSERT INTO `students` VALUES (9, '9', 'Tatiana Oliveira Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'M', NULL, '2020-08-09 00:27:33', '2020-08-09 00:27:33');
INSERT INTO `students` VALUES (10, '10', 'Andréia Marcandier Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'M', NULL, '2020-08-09 00:27:33', '2020-08-09 00:27:33');
INSERT INTO `students` VALUES (11, '11', 'Artur Andrade Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'T', NULL, '2020-08-09 00:27:33', '2020-08-09 00:27:33');
INSERT INTO `students` VALUES (12, '12', 'Henrique Melo Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'T', NULL, '2020-08-09 00:27:34', '2020-08-09 00:27:34');
INSERT INTO `students` VALUES (13, '13', 'Artur Oliveira Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'T', NULL, '2020-08-09 00:27:34', '2020-08-09 00:27:34');
INSERT INTO `students` VALUES (14, '14', 'Isabela Gontijo Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'T', NULL, '2020-08-09 00:27:34', '2020-08-09 00:27:34');
INSERT INTO `students` VALUES (15, '15', 'Isabela Gontijo Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'T', NULL, '2020-08-09 00:27:34', '2020-08-09 00:27:34');
INSERT INTO `students` VALUES (16, '16', 'Andréia Gonçalves Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'T', NULL, '2020-08-09 00:27:35', '2020-08-09 00:27:35');
INSERT INTO `students` VALUES (17, '17', 'Henrique Silva Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'T', NULL, '2020-08-09 00:27:35', '2020-08-09 00:27:35');
INSERT INTO `students` VALUES (18, '18', 'Letícia Marques Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'T', NULL, '2020-08-09 00:27:35', '2020-08-09 00:27:35');
INSERT INTO `students` VALUES (19, '19', 'Tatiana Marcandier Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'T', NULL, '2020-08-09 00:27:35', '2020-08-09 00:27:35');
INSERT INTO `students` VALUES (20, '20', 'Isabela Gonçalves Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'T', NULL, '2020-08-09 00:27:35', '2020-08-09 00:27:35');
INSERT INTO `students` VALUES (21, '21', 'Breno Marques Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'N', NULL, '2020-08-09 00:27:35', '2020-08-09 00:27:35');
INSERT INTO `students` VALUES (22, '22', 'Breno Amaral de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'N', NULL, '2020-08-09 00:27:36', '2020-08-09 00:27:36');
INSERT INTO `students` VALUES (23, '23', 'Tatiana Marques Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'N', NULL, '2020-08-09 00:27:36', '2020-08-09 00:27:36');
INSERT INTO `students` VALUES (24, '24', 'Rogério Silva Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'N', NULL, '2020-08-09 00:27:36', '2020-08-09 00:27:36');
INSERT INTO `students` VALUES (25, '25', 'Daniel Marques de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'N', NULL, '2020-08-09 00:27:36', '2020-08-09 00:27:36');
INSERT INTO `students` VALUES (26, '26', 'Rogério Oliveira Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'N', NULL, '2020-08-09 00:27:36', '2020-08-09 00:27:36');
INSERT INTO `students` VALUES (27, '27', 'Rogério Amaral Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'N', NULL, '2020-08-09 00:27:36', '2020-08-09 00:27:36');
INSERT INTO `students` VALUES (28, '28', 'Henrique Marques Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'N', NULL, '2020-08-09 00:27:37', '2020-08-09 00:27:37');
INSERT INTO `students` VALUES (29, '29', 'Isabela de Sá de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'N', NULL, '2020-08-09 00:27:37', '2020-08-09 00:27:37');
INSERT INTO `students` VALUES (30, '30', 'Mônica Marques Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 1, 'N', NULL, '2020-08-09 00:27:37', '2020-08-09 00:27:37');
INSERT INTO `students` VALUES (31, '31', 'Isabela de Sá de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'M', NULL, '2020-08-09 00:27:37', '2020-08-09 00:27:37');
INSERT INTO `students` VALUES (32, '32', 'Isabela de Sá Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'M', NULL, '2020-08-09 00:27:37', '2020-08-09 00:27:37');
INSERT INTO `students` VALUES (33, '33', 'Mônica Oliveira Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'M', NULL, '2020-08-09 00:27:38', '2020-08-09 00:27:38');
INSERT INTO `students` VALUES (34, '34', 'Breno Gontijo Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'M', NULL, '2020-08-09 00:27:38', '2020-08-09 00:27:38');
INSERT INTO `students` VALUES (35, '35', 'Letícia de Sá Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'M', NULL, '2020-08-09 00:27:38', '2020-08-09 00:27:38');
INSERT INTO `students` VALUES (36, '36', 'Andréia Silva Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'M', NULL, '2020-08-09 00:27:38', '2020-08-09 00:27:38');
INSERT INTO `students` VALUES (37, '37', 'Daniel Melo Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'M', NULL, '2020-08-09 00:27:38', '2020-08-09 00:27:38');
INSERT INTO `students` VALUES (38, '38', 'Tatiana Silva Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'M', NULL, '2020-08-09 00:27:39', '2020-08-09 00:27:39');
INSERT INTO `students` VALUES (39, '39', 'Tatiana Marques Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'M', NULL, '2020-08-09 00:27:39', '2020-08-09 00:27:39');
INSERT INTO `students` VALUES (40, '40', 'Letícia Oliveira Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'M', NULL, '2020-08-09 00:27:39', '2020-08-09 00:27:39');
INSERT INTO `students` VALUES (41, '41', 'Artur Marques Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'T', NULL, '2020-08-09 00:27:39', '2020-08-09 00:27:39');
INSERT INTO `students` VALUES (42, '42', 'Andréia Silva Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'T', NULL, '2020-08-09 00:27:39', '2020-08-09 00:27:39');
INSERT INTO `students` VALUES (43, '43', 'Artur Gontijo Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'T', NULL, '2020-08-09 00:27:39', '2020-08-09 00:27:39');
INSERT INTO `students` VALUES (44, '44', 'Henrique Andrade Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'T', NULL, '2020-08-09 00:27:40', '2020-08-09 00:27:40');
INSERT INTO `students` VALUES (45, '45', 'Isabela Oliveira Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'T', NULL, '2020-08-09 00:27:40', '2020-08-09 00:27:40');
INSERT INTO `students` VALUES (46, '46', 'Tatiana Marcandier Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'T', NULL, '2020-08-09 00:27:40', '2020-08-09 00:27:40');
INSERT INTO `students` VALUES (47, '47', 'Letícia Marcandier Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'T', NULL, '2020-08-09 00:27:40', '2020-08-09 00:27:40');
INSERT INTO `students` VALUES (48, '48', 'Daniel Amaral Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'T', NULL, '2020-08-09 00:27:40', '2020-08-09 00:27:40');
INSERT INTO `students` VALUES (49, '49', 'Daniel Gonçalves Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'T', NULL, '2020-08-09 00:27:40', '2020-08-09 00:27:40');
INSERT INTO `students` VALUES (50, '50', 'Henrique Andrade Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'T', NULL, '2020-08-09 00:27:40', '2020-08-09 00:27:40');
INSERT INTO `students` VALUES (51, '51', 'Henrique Amaral Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'N', NULL, '2020-08-09 00:27:40', '2020-08-09 00:27:40');
INSERT INTO `students` VALUES (52, '52', 'Henrique Marcandier Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'N', NULL, '2020-08-09 00:27:40', '2020-08-09 00:27:40');
INSERT INTO `students` VALUES (53, '53', 'Breno Marcandier Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'N', NULL, '2020-08-09 00:27:40', '2020-08-09 00:27:40');
INSERT INTO `students` VALUES (54, '54', 'Mônica Oliveira Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'N', NULL, '2020-08-09 00:27:40', '2020-08-09 00:27:40');
INSERT INTO `students` VALUES (55, '55', 'Tatiana Andrade de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'N', NULL, '2020-08-09 00:27:41', '2020-08-09 00:27:41');
INSERT INTO `students` VALUES (56, '56', 'Letícia Andrade Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'N', NULL, '2020-08-09 00:27:41', '2020-08-09 00:27:41');
INSERT INTO `students` VALUES (57, '57', 'Artur Gontijo Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'N', NULL, '2020-08-09 00:27:41', '2020-08-09 00:27:41');
INSERT INTO `students` VALUES (58, '58', 'Mônica de Sá de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'N', NULL, '2020-08-09 00:27:41', '2020-08-09 00:27:41');
INSERT INTO `students` VALUES (59, '59', 'Andréia Melo Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'N', NULL, '2020-08-09 00:27:42', '2020-08-09 00:27:42');
INSERT INTO `students` VALUES (60, '60', 'Andréia Gonçalves Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 2, 'N', NULL, '2020-08-09 00:27:42', '2020-08-09 00:27:42');
INSERT INTO `students` VALUES (61, '61', 'Henrique Andrade Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'M', NULL, '2020-08-09 00:27:42', '2020-08-09 00:27:42');
INSERT INTO `students` VALUES (62, '62', 'Tatiana Gonçalves Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'M', NULL, '2020-08-09 00:27:42', '2020-08-09 00:27:42');
INSERT INTO `students` VALUES (63, '63', 'Tatiana Marcandier Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'M', NULL, '2020-08-09 00:27:42', '2020-08-09 00:27:42');
INSERT INTO `students` VALUES (64, '64', 'Andréia Silva Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'M', NULL, '2020-08-09 00:27:42', '2020-08-09 00:27:42');
INSERT INTO `students` VALUES (65, '65', 'Henrique Melo Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'M', NULL, '2020-08-09 00:27:42', '2020-08-09 00:27:42');
INSERT INTO `students` VALUES (66, '66', 'Mônica de Sá Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'M', NULL, '2020-08-09 00:27:43', '2020-08-09 00:27:43');
INSERT INTO `students` VALUES (67, '67', 'Artur Amaral de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'M', NULL, '2020-08-09 00:27:43', '2020-08-09 00:27:43');
INSERT INTO `students` VALUES (68, '68', 'Daniel Melo Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'M', NULL, '2020-08-09 00:27:43', '2020-08-09 00:27:43');
INSERT INTO `students` VALUES (69, '69', 'Henrique Silva Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'M', NULL, '2020-08-09 00:27:43', '2020-08-09 00:27:43');
INSERT INTO `students` VALUES (70, '70', 'Tatiana de Sá Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'M', NULL, '2020-08-09 00:27:43', '2020-08-09 00:27:43');
INSERT INTO `students` VALUES (71, '71', 'Henrique Marcandier Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'T', NULL, '2020-08-09 00:27:43', '2020-08-09 00:27:43');
INSERT INTO `students` VALUES (72, '72', 'Breno Gontijo Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'T', NULL, '2020-08-09 00:27:43', '2020-08-09 00:27:43');
INSERT INTO `students` VALUES (73, '73', 'Tatiana Oliveira Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'T', NULL, '2020-08-09 00:27:43', '2020-08-09 00:27:43');
INSERT INTO `students` VALUES (74, '74', 'Daniel de Sá Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'T', NULL, '2020-08-09 00:27:43', '2020-08-09 00:27:43');
INSERT INTO `students` VALUES (75, '75', 'Mônica Marcandier de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'T', NULL, '2020-08-09 00:27:43', '2020-08-09 00:27:43');
INSERT INTO `students` VALUES (76, '76', 'Daniel Gontijo Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'T', NULL, '2020-08-09 00:27:43', '2020-08-09 00:27:43');
INSERT INTO `students` VALUES (77, '77', 'Letícia de Sá Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'T', NULL, '2020-08-09 00:27:44', '2020-08-09 00:27:44');
INSERT INTO `students` VALUES (78, '78', 'Rogério Amaral Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'T', NULL, '2020-08-09 00:27:44', '2020-08-09 00:27:44');
INSERT INTO `students` VALUES (79, '79', 'Rogério Gontijo Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'T', NULL, '2020-08-09 00:27:44', '2020-08-09 00:27:44');
INSERT INTO `students` VALUES (80, '80', 'Tatiana Silva Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'T', NULL, '2020-08-09 00:27:44', '2020-08-09 00:27:44');
INSERT INTO `students` VALUES (81, '81', 'Artur Oliveira Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'N', NULL, '2020-08-09 00:27:44', '2020-08-09 00:27:44');
INSERT INTO `students` VALUES (82, '82', 'Breno Silva Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'N', NULL, '2020-08-09 00:27:44', '2020-08-09 00:27:44');
INSERT INTO `students` VALUES (83, '83', 'Artur Gontijo Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'N', NULL, '2020-08-09 00:27:44', '2020-08-09 00:27:44');
INSERT INTO `students` VALUES (84, '84', 'Letícia de Sá Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'N', NULL, '2020-08-09 00:27:44', '2020-08-09 00:27:44');
INSERT INTO `students` VALUES (85, '85', 'Mônica Melo Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'N', NULL, '2020-08-09 00:27:44', '2020-08-09 00:27:44');
INSERT INTO `students` VALUES (86, '86', 'Daniel Melo Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'N', NULL, '2020-08-09 00:27:44', '2020-08-09 00:27:44');
INSERT INTO `students` VALUES (87, '87', 'Breno Oliveira Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'N', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (88, '88', 'Letícia Marcandier Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'N', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (89, '89', 'Breno Melo Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'N', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (90, '90', 'Andréia Amaral de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 3, 'N', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (91, '91', 'Artur Gontijo Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'M', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (92, '92', 'Letícia Gonçalves Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'M', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (93, '93', 'Mônica Marcandier Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'M', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (94, '94', 'Henrique Oliveira Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'M', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (95, '95', 'Rogério Andrade Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'M', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (96, '96', 'Andréia Melo Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'M', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (97, '97', 'Rogério de Sá Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'M', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (98, '98', 'Artur Oliveira Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'M', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (99, '99', 'Andréia Amaral Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'M', NULL, '2020-08-09 00:27:45', '2020-08-09 00:27:45');
INSERT INTO `students` VALUES (100, '100', 'Mônica Marques Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'M', NULL, '2020-08-09 00:27:46', '2020-08-09 00:27:46');
INSERT INTO `students` VALUES (101, '101', 'Henrique Andrade Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'T', NULL, '2020-08-09 00:27:46', '2020-08-09 00:27:46');
INSERT INTO `students` VALUES (102, '102', 'Isabela Melo de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'T', NULL, '2020-08-09 00:27:46', '2020-08-09 00:27:46');
INSERT INTO `students` VALUES (103, '103', 'Mônica Gonçalves Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'T', NULL, '2020-08-09 00:27:46', '2020-08-09 00:27:46');
INSERT INTO `students` VALUES (104, '104', 'Artur Gontijo Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'T', NULL, '2020-08-09 00:27:46', '2020-08-09 00:27:46');
INSERT INTO `students` VALUES (105, '105', 'Henrique Oliveira Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'T', NULL, '2020-08-09 00:27:46', '2020-08-09 00:27:46');
INSERT INTO `students` VALUES (106, '106', 'Isabela Gonçalves Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'T', NULL, '2020-08-09 00:27:46', '2020-08-09 00:27:46');
INSERT INTO `students` VALUES (107, '107', 'Artur Andrade Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'T', NULL, '2020-08-09 00:27:46', '2020-08-09 00:27:46');
INSERT INTO `students` VALUES (108, '108', 'Rogério Amaral Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'T', NULL, '2020-08-09 00:27:46', '2020-08-09 00:27:46');
INSERT INTO `students` VALUES (109, '109', 'Artur Marques Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'T', NULL, '2020-08-09 00:27:47', '2020-08-09 00:27:47');
INSERT INTO `students` VALUES (110, '110', 'Tatiana Oliveira Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'T', NULL, '2020-08-09 00:27:47', '2020-08-09 00:27:47');
INSERT INTO `students` VALUES (111, '111', 'Artur de Sá Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'N', NULL, '2020-08-09 00:27:47', '2020-08-09 00:27:47');
INSERT INTO `students` VALUES (112, '112', 'Daniel Marques Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'N', NULL, '2020-08-09 00:27:47', '2020-08-09 00:27:47');
INSERT INTO `students` VALUES (113, '113', 'Daniel Silva Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'N', NULL, '2020-08-09 00:27:47', '2020-08-09 00:27:47');
INSERT INTO `students` VALUES (114, '114', 'Andréia Marques de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'N', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (115, '115', 'Daniel Gonçalves Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'N', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (116, '116', 'Rogério Silva de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'N', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (117, '117', 'Andréia Melo Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'N', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (118, '118', 'Andréia Marques Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'N', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (119, '119', 'Isabela Silva Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'N', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (120, '120', 'Isabela Marcandier Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 4, 'N', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (121, '121', 'Henrique Andrade Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'M', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (122, '122', 'Mônica Marcandier Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'M', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (123, '123', 'Breno Marques Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'M', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (124, '124', 'Isabela de Sá Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'M', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (125, '125', 'Isabela Amaral Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'M', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (126, '126', 'Rogério Gonçalves Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'M', NULL, '2020-08-09 00:27:48', '2020-08-09 00:27:48');
INSERT INTO `students` VALUES (127, '127', 'Isabela Gontijo Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'M', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (128, '128', 'Breno Amaral Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'M', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (129, '129', 'Tatiana Melo Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'M', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (130, '130', 'Letícia Marques Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'M', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (131, '131', 'Artur Melo Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'T', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (132, '132', 'Mônica Marcandier Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'T', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (133, '133', 'Artur Marcandier de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'T', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (134, '134', 'Andréia Silva Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'T', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (135, '135', 'Letícia Andrade Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'T', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (136, '136', 'Henrique Gonçalves Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'T', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (137, '137', 'Letícia Andrade Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'T', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (138, '138', 'Isabela Oliveira Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'T', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (139, '139', 'Artur de Sá Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'T', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (140, '140', 'Andréia Gontijo de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'T', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (141, '141', 'Henrique Marques de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'N', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (142, '142', 'Breno Silva Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'N', NULL, '2020-08-09 00:27:49', '2020-08-09 00:27:49');
INSERT INTO `students` VALUES (143, '143', 'Mônica Andrade Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'N', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (144, '144', 'Artur Andrade Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'N', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (145, '145', 'Mônica Marcandier Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'N', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (146, '146', 'Isabela Melo Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'N', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (147, '147', 'Daniel Marques Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'N', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (148, '148', 'Artur Gontijo Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'N', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (149, '149', 'Rogério de Sá Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'N', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (150, '150', 'Rogério Gonçalves Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 5, 'N', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (151, '151', 'Isabela de Sá Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'M', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (152, '152', 'Rogério Marcandier Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'M', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (153, '153', 'Rogério Gonçalves Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'M', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (154, '154', 'Mônica Andrade Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'M', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (155, '155', 'Tatiana Oliveira Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'M', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (156, '156', 'Letícia Oliveira Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'M', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (157, '157', 'Letícia Gontijo Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'M', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (158, '158', 'Artur Gontijo Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'M', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (159, '159', 'Artur Marcandier Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'M', NULL, '2020-08-09 00:27:50', '2020-08-09 00:27:50');
INSERT INTO `students` VALUES (160, '160', 'Mônica Gonçalves Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'M', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (161, '161', 'Tatiana Gonçalves de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'T', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (162, '162', 'Artur Silva Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'T', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (163, '163', 'Artur Marques Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'T', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (164, '164', 'Letícia Oliveira Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'T', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (165, '165', 'Daniel Marques de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'T', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (166, '166', 'Isabela Amaral Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'T', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (167, '167', 'Tatiana de Sá Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'T', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (168, '168', 'Rogério Silva Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'T', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (169, '169', 'Letícia de Sá Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'T', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (170, '170', 'Tatiana Melo Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'T', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (171, '171', 'Mônica Amaral Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'N', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (172, '172', 'Letícia Melo Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'N', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (173, '173', 'Andréia Oliveira Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'N', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (174, '174', 'Letícia Gontijo Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'N', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (175, '175', 'Andréia Marcandier Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'N', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (176, '176', 'Mônica Marques Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'N', NULL, '2020-08-09 00:27:51', '2020-08-09 00:27:51');
INSERT INTO `students` VALUES (177, '177', 'Henrique Amaral Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'N', NULL, '2020-08-09 00:27:52', '2020-08-09 00:27:52');
INSERT INTO `students` VALUES (178, '178', 'Artur Marcandier Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'N', NULL, '2020-08-09 00:27:52', '2020-08-09 00:27:52');
INSERT INTO `students` VALUES (179, '179', 'Artur Amaral Melo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'N', NULL, '2020-08-09 00:27:52', '2020-08-09 00:27:52');
INSERT INTO `students` VALUES (180, '180', 'Artur Marques Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 6, 'N', NULL, '2020-08-09 00:27:52', '2020-08-09 00:27:52');
INSERT INTO `students` VALUES (181, '181', 'Isabela Melo Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'M', NULL, '2020-08-09 00:27:52', '2020-08-09 00:27:52');
INSERT INTO `students` VALUES (182, '182', 'Henrique de Sá de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'M', NULL, '2020-08-09 00:27:52', '2020-08-09 00:27:52');
INSERT INTO `students` VALUES (183, '183', 'Daniel Marques Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'M', NULL, '2020-08-09 00:27:52', '2020-08-09 00:27:52');
INSERT INTO `students` VALUES (184, '184', 'Artur de Sá Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'M', NULL, '2020-08-09 00:27:52', '2020-08-09 00:27:52');
INSERT INTO `students` VALUES (185, '185', 'Breno Gonçalves de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'M', NULL, '2020-08-09 00:27:53', '2020-08-09 00:27:53');
INSERT INTO `students` VALUES (186, '186', 'Andréia de Sá Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'M', NULL, '2020-08-09 00:27:53', '2020-08-09 00:27:53');
INSERT INTO `students` VALUES (187, '187', 'Artur Amaral Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'M', NULL, '2020-08-09 00:27:53', '2020-08-09 00:27:53');
INSERT INTO `students` VALUES (188, '188', 'Breno de Sá Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'M', NULL, '2020-08-09 00:27:53', '2020-08-09 00:27:53');
INSERT INTO `students` VALUES (189, '189', 'Tatiana Silva Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'M', NULL, '2020-08-09 00:27:53', '2020-08-09 00:27:53');
INSERT INTO `students` VALUES (190, '190', 'Artur Amaral Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'M', NULL, '2020-08-09 00:27:53', '2020-08-09 00:27:53');
INSERT INTO `students` VALUES (191, '191', 'Letícia Amaral Gontijo', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'T', NULL, '2020-08-09 00:27:53', '2020-08-09 00:27:53');
INSERT INTO `students` VALUES (192, '192', 'Isabela Melo Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'T', NULL, '2020-08-09 00:27:53', '2020-08-09 00:27:53');
INSERT INTO `students` VALUES (193, '193', 'Andréia Oliveira de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'T', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (194, '194', 'Tatiana Amaral Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'T', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (195, '195', 'Andréia Gonçalves Oliveira', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'T', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (196, '196', 'Mônica Melo Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'T', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (197, '197', 'Henrique Melo Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'T', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (198, '198', 'Mônica Andrade Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'T', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (199, '199', 'Tatiana Melo Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'T', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (200, '200', 'Andréia Silva Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'T', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (201, '201', 'Rogério Gonçalves de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'N', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (202, '202', 'Artur Marques Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'N', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (203, '203', 'Mônica Andrade de Sá', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'N', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (204, '204', 'Tatiana Marques Silva', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'N', NULL, '2020-08-09 00:27:54', '2020-08-09 00:27:54');
INSERT INTO `students` VALUES (205, '205', 'Rogério Andrade Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'N', NULL, '2020-08-09 00:27:55', '2020-08-09 00:27:55');
INSERT INTO `students` VALUES (206, '206', 'Daniel Andrade Amaral', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'N', NULL, '2020-08-09 00:27:55', '2020-08-09 00:27:55');
INSERT INTO `students` VALUES (207, '207', 'Isabela Silva Andrade', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'N', NULL, '2020-08-09 00:27:55', '2020-08-09 00:27:55');
INSERT INTO `students` VALUES (208, '208', 'Tatiana Gontijo Gonçalves', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'N', NULL, '2020-08-09 00:27:55', '2020-08-09 00:27:55');
INSERT INTO `students` VALUES (209, '209', 'Daniel de Sá Marques', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'N', NULL, '2020-08-09 00:27:55', '2020-08-09 00:27:55');
INSERT INTO `students` VALUES (210, '210', 'Isabela Marcandier Marcandier', '1', '30421-108', 'Rua Geraldo Bicalho', '66', 'ap 101', 'Nova Suíssa', 'Belo Horizonte', 'MG', 7, 'N', NULL, '2020-08-09 00:27:55', '2020-08-09 00:27:55');

-- ----------------------------
-- Table structure for type_modules
-- ----------------------------
DROP TABLE IF EXISTS `type_modules`;
CREATE TABLE `type_modules`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of type_modules
-- ----------------------------
INSERT INTO `type_modules` VALUES (1, 'Página Inicial', '1', '2020-01-29 12:56:49', '2020-01-29 12:56:49');
INSERT INTO `type_modules` VALUES (6, 'Cadastros', '1', '2020-01-29 13:37:30', '2020-08-08 14:07:02');
INSERT INTO `type_modules` VALUES (7, 'Usuário', '1', '2020-08-08 14:07:17', '2020-08-08 14:07:17');

-- ----------------------------
-- Table structure for user_pres
-- ----------------------------
DROP TABLE IF EXISTS `user_pres`;
CREATE TABLE `user_pres`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_pres
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Henrique', 'henrique.marcandier@gmail.com', NULL, '3aa002e8906a4caeeb1daff642af9d04', 'usuarios1.png', '', '2020-01-22 22:41:52', '2020-08-12 19:38:31');
INSERT INTO `users` VALUES (3, 'AIX Sistemas', 'aix@bhcommerce.com.br', NULL, '3f6708690bc47437c42b9d425d737185', 'usuarios3.png', NULL, '2020-04-13 23:19:41', '2020-08-12 19:39:15');

-- ----------------------------
-- Table structure for versions
-- ----------------------------
DROP TABLE IF EXISTS `versions`;
CREATE TABLE `versions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of versions
-- ----------------------------
INSERT INTO `versions` VALUES (1, '1.0', 'versao1.png', '2020-08-06', 'Versão Inicial do Sistema da AIX da BH Commerce', '2020-02-16 17:29:04', '2020-08-12 19:55:48');

SET FOREIGN_KEY_CHECKS = 1;
