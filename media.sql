/*
Navicat MySQL Data Transfer

Source Server         : Dev. Server
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : media

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2022-02-14 05:52:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for med_video
-- ----------------------------
DROP TABLE IF EXISTS `med_video`;
CREATE TABLE `med_video` (
  `vid_id` int(6) NOT NULL AUTO_INCREMENT,
  `vid_file` varchar(255) DEFAULT NULL,
  `vid_stat` int(1) NOT NULL DEFAULT 0,
  `vid_unit` char(3) DEFAULT '',
  `vid_uploader` varchar(30) DEFAULT NULL,
  `vid_date` datetime DEFAULT NULL,
  `vid_play` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`vid_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of med_video
-- ----------------------------
INSERT INTO `med_video` VALUES ('1', 'SMA_1644685321-yes_ah_kejeron.mp4', '0', 'SM', 'geosystem', '2022-02-13 00:02:01', '0');
INSERT INTO `med_video` VALUES ('2', 'SMP_1644685537-SMA_1644685321-yes_ah_kejeron.mp4', '1', 'SMP', 'geosystem', '2022-02-13 00:05:37', '0');
INSERT INTO `med_video` VALUES ('3', 'SD_1644686000-DEWA_Aku_Milikmu_Dewa.mp4', '0', 'SD', 'geosystem', '2022-02-13 00:13:20', '0');
INSERT INTO `med_video` VALUES ('4', 'SMP_1644686243-FATIN_Dear_God.mp4', '2', 'SMP', 'geosystem', '2022-02-13 00:17:23', '0');
INSERT INTO `med_video` VALUES ('5', 'TK_1644686293-yes_ah_kejeron.mp4', '0', 'TK', 'geosystem', '2022-02-13 00:18:13', '0');
INSERT INTO `med_video` VALUES ('6', 'SD_1644686813-FATIN_Dear_God.mp4', '0', 'SD', 'geosystem', '2022-02-13 00:26:53', '0');

-- ----------------------------
-- Table structure for reg_konfig
-- ----------------------------
DROP TABLE IF EXISTS `reg_konfig`;
CREATE TABLE `reg_konfig` (
  `kon_yayasan` varchar(255) DEFAULT NULL,
  `kon_kampus` varchar(255) DEFAULT NULL,
  `kon_alamat` varchar(255) DEFAULT NULL,
  `kon_email` varchar(50) DEFAULT NULL,
  `kon_web` varchar(50) DEFAULT NULL,
  `kon_tp` varchar(9) DEFAULT NULL,
  `kon_statjadwal` int(1) DEFAULT NULL,
  `mail_kb` varchar(50) DEFAULT NULL,
  `mail_tk` varchar(50) DEFAULT NULL,
  `mail_sd` varchar(50) DEFAULT NULL,
  `mail_smp` varchar(50) DEFAULT NULL,
  `mail_sma` varchar(50) DEFAULT NULL,
  `wa_kb` varchar(20) DEFAULT NULL,
  `wa_tk` varchar(20) DEFAULT NULL,
  `wa_sd` varchar(20) DEFAULT NULL,
  `wa_smp` varchar(20) DEFAULT NULL,
  `wa_sma` varchar(20) DEFAULT NULL,
  `kon_rekening` varchar(200) DEFAULT '',
  `kon_namarek` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of reg_konfig
-- ----------------------------
INSERT INTO `reg_konfig` VALUES ('Yayasan Widya Bhakti', 'Kampus Santa Angela Bandung', 'Jalan Merdeka No.24, Babakan Ciamis, Sumur Bandung, Kota Bandung, Jawa Barat 40117', 'widya.bhakti@santa-angela.sch.id', 'https://santa-angela.sch.id', '2023-2024', '1', 'kb@santa-angela.sch.id', 'tk@santa-angela.sch.id', 'sd@santa-angela.sch.id', 'smp@santa-angela.sch.id', 'sma@santa-angela.sch.id', '08811111111', '08822222222', '08833333333', '08844444444', '08855555555', 'Bank BCA - Asia Afrika Bandung No. Rek. : 0088123401', 'Yay. Widya Bhakti');

-- ----------------------------
-- Table structure for reg_user
-- ----------------------------
DROP TABLE IF EXISTS `reg_user`;
CREATE TABLE `reg_user` (
  `usr_idx` int(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `usr_login` varchar(20) NOT NULL,
  `usr_pass` varchar(255) NOT NULL,
  `usr_name` varchar(60) NOT NULL,
  `usr_grp` int(1) NOT NULL,
  `usr_unit` char(3) NOT NULL,
  `usr_stat` int(1) NOT NULL,
  `usr_ip` char(24) NOT NULL,
  `usr_via` char(24) NOT NULL,
  `usr_tgl` date NOT NULL,
  PRIMARY KEY (`usr_idx`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of reg_user
-- ----------------------------
INSERT INTO `reg_user` VALUES ('01', 'geosystem', 'e820d2534c65f7f7540e9b60ea2936f13870833d', 'System Administrator', '0', 'yay', '0', '127.0.0.1', 'localhost', '2022-02-13');
INSERT INTO `reg_user` VALUES ('03', 'admin.tk1', 'e828e0aee3e809fd7162aab2107bd93c0d26e227', 'Panitia PPDB TK 1', '1', 'tk', '0', '127.0.0.1', 'localhost', '2022-01-31');
