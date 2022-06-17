/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80026
 Source Host           : localhost:3306
 Source Schema         : tes

 Target Server Type    : MySQL
 Target Server Version : 80026
 File Encoding         : 65001

 Date: 17/06/2022 21:43:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for event
-- ----------------------------
DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `event` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of event
-- ----------------------------
BEGIN;
INSERT INTO `event` (`event_id`, `event`) VALUES (1, 'event 1');
INSERT INTO `event` (`event_id`, `event`) VALUES (2, 'event 2');
INSERT INTO `event` (`event_id`, `event`) VALUES (3, 'event 3');
COMMIT;

-- ----------------------------
-- Table structure for event_ticket
-- ----------------------------
DROP TABLE IF EXISTS `event_ticket`;
CREATE TABLE `event_ticket` (
  `event_ticket_id` int NOT NULL AUTO_INCREMENT,
  `event_id` int DEFAULT NULL,
  `ticket_code` varchar(10) NOT NULL,
  `status` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_ticket_id`) USING BTREE,
  UNIQUE KEY `ticket_code` (`ticket_code`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_ticket_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1210930 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of event_ticket
-- ----------------------------
BEGIN;
INSERT INTO `event_ticket` (`event_ticket_id`, `event_id`, `ticket_code`, `status`, `created_at`, `updated_at`) VALUES (1, 1, 'code1', 1, '2022-06-17 14:00:37', '2022-06-17 14:00:37');
INSERT INTO `event_ticket` (`event_ticket_id`, `event_id`, `ticket_code`, `status`, `created_at`, `updated_at`) VALUES (2, 1, 'code2', 1, '2022-06-17 14:00:38', '2022-06-17 14:00:38');
INSERT INTO `event_ticket` (`event_ticket_id`, `event_id`, `ticket_code`, `status`, `created_at`, `updated_at`) VALUES (3, 2, 'code3', 1, '2022-06-17 14:00:25', '2022-06-17 14:00:25');
INSERT INTO `event_ticket` (`event_ticket_id`, `event_id`, `ticket_code`, `status`, `created_at`, `updated_at`) VALUES (4, 2, 'code4', 1, '2022-06-17 14:00:26', '2022-06-17 14:00:26');
INSERT INTO `event_ticket` (`event_ticket_id`, `event_id`, `ticket_code`, `status`, `created_at`, `updated_at`) VALUES (5, 3, 'code5', 2, '2022-06-17 14:35:45', '2022-06-17 14:35:45');
COMMIT;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `username` varchar(16) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
BEGIN;
INSERT INTO `user` (`username`, `password`) VALUES ('detik.com', '$2y$10$IUI8P/5.nIWw5hxBEGlW..l.031Fj6p2wjC9gz.O.bnzKDamAn9.q');
COMMIT;

-- ----------------------------
-- Procedure structure for fn_ticket_generate
-- ----------------------------
DROP PROCEDURE IF EXISTS `fn_ticket_generate`;
delimiter ;;
CREATE PROCEDURE `fn_ticket_generate`(in in_event_id int, in in_total int)
BEGIN

	declare is_event_valid int default 0;
	declare i int default 1;

 	select count(event_id) into is_event_valid from `event` limit 1;
	
	if (is_event_valid) then 
		start transaction;
			-- kita looping sebanyak total;
			generate: while (i <= in_total) 
			DO
				-- masukin codenya 
				insert into `event_ticket` (`event_id`, `ticket_code`) values (in_event_id, concat('DTK', left(uuid(), 7)));
						
				SET i = i+1;
			end while;

		commit;
	else 
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Event ID tidak tersedia, cek kembali eventnya sob !';
	end if;

	
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
