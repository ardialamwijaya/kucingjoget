/*
Navicat MySQL Data Transfer

Source Server         : 1.local 3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : kucingjoget

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-09-09 08:57:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `buy_trx`
-- ----------------------------
DROP TABLE IF EXISTS `buy_trx`;
CREATE TABLE `buy_trx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `signal_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `exchange` varchar(20) DEFAULT NULL,
  `buy_market_order_id` int(11) DEFAULT NULL,
  `coin` varchar(10) DEFAULT NULL,
  `buy_price` int(11) NOT NULL,
  `settled_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_allocated_balance` decimal(15,5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of buy_trx
-- ----------------------------
INSERT INTO `buy_trx` VALUES ('1', '2', '0', 'BINANCE', null, 'QSP/BTC', '0', '2018-07-12 18:54:10', '1', '0.00163');
INSERT INTO `buy_trx` VALUES ('2', '1970', '0', 'BINANCE', null, 'NAV/BTC', '0', '2018-07-12 18:54:16', '1', '0.00162');
INSERT INTO `buy_trx` VALUES ('3', '2', '0', 'BINANCE', null, 'QSP/BTC', '0', '2018-07-18 08:28:15', '1', '0.00137');
INSERT INTO `buy_trx` VALUES ('4', '1970', '0', 'BINANCE', null, 'NAV/BTC', '0', '2018-07-18 08:28:26', '1', '0.00136');
INSERT INTO `buy_trx` VALUES ('5', '1972', '0', 'BINANCE', null, 'DLT/BTC', '0', '2018-07-18 08:31:22', '1', '0.00136');
INSERT INTO `buy_trx` VALUES ('6', '1973', '0', 'BINANCE', null, 'QSP/BTC', '0', '2018-07-18 08:31:32', '1', '0.00136');

-- ----------------------------
-- Table structure for `exchanges`
-- ----------------------------
DROP TABLE IF EXISTS `exchanges`;
CREATE TABLE `exchanges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of exchanges
-- ----------------------------
INSERT INTO `exchanges` VALUES ('1', 'binance');

-- ----------------------------
-- Table structure for `markets`
-- ----------------------------
DROP TABLE IF EXISTS `markets`;
CREATE TABLE `markets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `symbol` varchar(10) DEFAULT NULL,
  `exchange_id` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=371 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of markets
-- ----------------------------
INSERT INTO `markets` VALUES ('1', 'ETH/BTC', '1');
INSERT INTO `markets` VALUES ('2', 'LTC/BTC', '1');
INSERT INTO `markets` VALUES ('3', 'BNB/BTC', '1');
INSERT INTO `markets` VALUES ('4', 'NEO/BTC', '1');
INSERT INTO `markets` VALUES ('5', 'QTUM/ETH', '1');
INSERT INTO `markets` VALUES ('6', 'EOS/ETH', '1');
INSERT INTO `markets` VALUES ('7', 'SNT/ETH', '1');
INSERT INTO `markets` VALUES ('8', 'BNT/ETH', '1');
INSERT INTO `markets` VALUES ('9', 'BCH/BTC', '1');
INSERT INTO `markets` VALUES ('10', 'GAS/BTC', '1');
INSERT INTO `markets` VALUES ('11', 'BNB/ETH', '1');
INSERT INTO `markets` VALUES ('12', 'BTC/USDT', '1');
INSERT INTO `markets` VALUES ('13', 'ETH/USDT', '1');
INSERT INTO `markets` VALUES ('14', 'HSR/BTC', '1');
INSERT INTO `markets` VALUES ('15', 'OAX/ETH', '1');
INSERT INTO `markets` VALUES ('16', 'DNT/ETH', '1');
INSERT INTO `markets` VALUES ('17', 'MCO/ETH', '1');
INSERT INTO `markets` VALUES ('18', 'ICN/ETH', '1');
INSERT INTO `markets` VALUES ('19', 'MCO/BTC', '1');
INSERT INTO `markets` VALUES ('20', 'WTC/BTC', '1');
INSERT INTO `markets` VALUES ('21', 'WTC/ETH', '1');
INSERT INTO `markets` VALUES ('22', 'LRC/BTC', '1');
INSERT INTO `markets` VALUES ('23', 'LRC/ETH', '1');
INSERT INTO `markets` VALUES ('24', 'QTUM/BTC', '1');
INSERT INTO `markets` VALUES ('25', 'YOYOW/BTC', '1');
INSERT INTO `markets` VALUES ('26', 'OMG/BTC', '1');
INSERT INTO `markets` VALUES ('27', 'OMG/ETH', '1');
INSERT INTO `markets` VALUES ('28', 'ZRX/BTC', '1');
INSERT INTO `markets` VALUES ('29', 'ZRX/ETH', '1');
INSERT INTO `markets` VALUES ('30', 'STRAT/BTC', '1');
INSERT INTO `markets` VALUES ('31', 'STRAT/ETH', '1');
INSERT INTO `markets` VALUES ('32', 'SNGLS/BTC', '1');
INSERT INTO `markets` VALUES ('33', 'SNGLS/ETH', '1');
INSERT INTO `markets` VALUES ('34', 'BQX/BTC', '1');
INSERT INTO `markets` VALUES ('35', 'BQX/ETH', '1');
INSERT INTO `markets` VALUES ('36', 'KNC/BTC', '1');
INSERT INTO `markets` VALUES ('37', 'KNC/ETH', '1');
INSERT INTO `markets` VALUES ('38', 'FUN/BTC', '1');
INSERT INTO `markets` VALUES ('39', 'FUN/ETH', '1');
INSERT INTO `markets` VALUES ('40', 'SNM/BTC', '1');
INSERT INTO `markets` VALUES ('41', 'SNM/ETH', '1');
INSERT INTO `markets` VALUES ('42', 'NEO/ETH', '1');
INSERT INTO `markets` VALUES ('43', 'IOTA/BTC', '1');
INSERT INTO `markets` VALUES ('44', 'IOTA/ETH', '1');
INSERT INTO `markets` VALUES ('45', 'LINK/BTC', '1');
INSERT INTO `markets` VALUES ('46', 'LINK/ETH', '1');
INSERT INTO `markets` VALUES ('47', 'XVG/BTC', '1');
INSERT INTO `markets` VALUES ('48', 'XVG/ETH', '1');
INSERT INTO `markets` VALUES ('49', 'SALT/BTC', '1');
INSERT INTO `markets` VALUES ('50', 'SALT/ETH', '1');
INSERT INTO `markets` VALUES ('51', 'MDA/BTC', '1');
INSERT INTO `markets` VALUES ('52', 'MDA/ETH', '1');
INSERT INTO `markets` VALUES ('53', 'MTL/BTC', '1');
INSERT INTO `markets` VALUES ('54', 'MTL/ETH', '1');
INSERT INTO `markets` VALUES ('55', 'SUB/BTC', '1');
INSERT INTO `markets` VALUES ('56', 'SUB/ETH', '1');
INSERT INTO `markets` VALUES ('57', 'EOS/BTC', '1');
INSERT INTO `markets` VALUES ('58', 'SNT/BTC', '1');
INSERT INTO `markets` VALUES ('59', 'ETC/ETH', '1');
INSERT INTO `markets` VALUES ('60', 'ETC/BTC', '1');
INSERT INTO `markets` VALUES ('61', 'MTH/BTC', '1');
INSERT INTO `markets` VALUES ('62', 'MTH/ETH', '1');
INSERT INTO `markets` VALUES ('63', 'ENG/BTC', '1');
INSERT INTO `markets` VALUES ('64', 'ENG/ETH', '1');
INSERT INTO `markets` VALUES ('65', 'DNT/BTC', '1');
INSERT INTO `markets` VALUES ('66', 'ZEC/BTC', '1');
INSERT INTO `markets` VALUES ('67', 'ZEC/ETH', '1');
INSERT INTO `markets` VALUES ('68', 'BNT/BTC', '1');
INSERT INTO `markets` VALUES ('69', 'AST/BTC', '1');
INSERT INTO `markets` VALUES ('70', 'AST/ETH', '1');
INSERT INTO `markets` VALUES ('71', 'DASH/BTC', '1');
INSERT INTO `markets` VALUES ('72', 'DASH/ETH', '1');
INSERT INTO `markets` VALUES ('73', 'OAX/BTC', '1');
INSERT INTO `markets` VALUES ('74', 'ICN/BTC', '1');
INSERT INTO `markets` VALUES ('75', 'BTG/BTC', '1');
INSERT INTO `markets` VALUES ('76', 'BTG/ETH', '1');
INSERT INTO `markets` VALUES ('77', 'EVX/BTC', '1');
INSERT INTO `markets` VALUES ('78', 'EVX/ETH', '1');
INSERT INTO `markets` VALUES ('79', 'REQ/BTC', '1');
INSERT INTO `markets` VALUES ('80', 'REQ/ETH', '1');
INSERT INTO `markets` VALUES ('81', 'VIB/BTC', '1');
INSERT INTO `markets` VALUES ('82', 'VIB/ETH', '1');
INSERT INTO `markets` VALUES ('83', 'HSR/ETH', '1');
INSERT INTO `markets` VALUES ('84', 'TRX/BTC', '1');
INSERT INTO `markets` VALUES ('85', 'TRX/ETH', '1');
INSERT INTO `markets` VALUES ('86', 'POWR/BTC', '1');
INSERT INTO `markets` VALUES ('87', 'POWR/ETH', '1');
INSERT INTO `markets` VALUES ('88', 'ARK/BTC', '1');
INSERT INTO `markets` VALUES ('89', 'ARK/ETH', '1');
INSERT INTO `markets` VALUES ('90', 'YOYOW/ETH', '1');
INSERT INTO `markets` VALUES ('91', 'XRP/BTC', '1');
INSERT INTO `markets` VALUES ('92', 'XRP/ETH', '1');
INSERT INTO `markets` VALUES ('93', 'MOD/BTC', '1');
INSERT INTO `markets` VALUES ('94', 'MOD/ETH', '1');
INSERT INTO `markets` VALUES ('95', 'ENJ/BTC', '1');
INSERT INTO `markets` VALUES ('96', 'ENJ/ETH', '1');
INSERT INTO `markets` VALUES ('97', 'STORJ/BTC', '1');
INSERT INTO `markets` VALUES ('98', 'STORJ/ETH', '1');
INSERT INTO `markets` VALUES ('99', 'BNB/USDT', '1');
INSERT INTO `markets` VALUES ('100', 'VEN/BNB', '1');
INSERT INTO `markets` VALUES ('101', 'YOYOW/BNB', '1');
INSERT INTO `markets` VALUES ('102', 'POWR/BNB', '1');
INSERT INTO `markets` VALUES ('103', 'VEN/BTC', '1');
INSERT INTO `markets` VALUES ('104', 'VEN/ETH', '1');
INSERT INTO `markets` VALUES ('105', 'KMD/BTC', '1');
INSERT INTO `markets` VALUES ('106', 'KMD/ETH', '1');
INSERT INTO `markets` VALUES ('107', 'NULS/BNB', '1');
INSERT INTO `markets` VALUES ('108', 'RCN/BTC', '1');
INSERT INTO `markets` VALUES ('109', 'RCN/ETH', '1');
INSERT INTO `markets` VALUES ('110', 'RCN/BNB', '1');
INSERT INTO `markets` VALUES ('111', 'NULS/BTC', '1');
INSERT INTO `markets` VALUES ('112', 'NULS/ETH', '1');
INSERT INTO `markets` VALUES ('113', 'RDN/BTC', '1');
INSERT INTO `markets` VALUES ('114', 'RDN/ETH', '1');
INSERT INTO `markets` VALUES ('115', 'RDN/BNB', '1');
INSERT INTO `markets` VALUES ('116', 'XMR/BTC', '1');
INSERT INTO `markets` VALUES ('117', 'XMR/ETH', '1');
INSERT INTO `markets` VALUES ('118', 'DLT/BNB', '1');
INSERT INTO `markets` VALUES ('119', 'WTC/BNB', '1');
INSERT INTO `markets` VALUES ('120', 'DLT/BTC', '1');
INSERT INTO `markets` VALUES ('121', 'DLT/ETH', '1');
INSERT INTO `markets` VALUES ('122', 'AMB/BTC', '1');
INSERT INTO `markets` VALUES ('123', 'AMB/ETH', '1');
INSERT INTO `markets` VALUES ('124', 'AMB/BNB', '1');
INSERT INTO `markets` VALUES ('125', 'BCH/ETH', '1');
INSERT INTO `markets` VALUES ('126', 'BCH/USDT', '1');
INSERT INTO `markets` VALUES ('127', 'BCH/BNB', '1');
INSERT INTO `markets` VALUES ('128', 'BAT/BTC', '1');
INSERT INTO `markets` VALUES ('129', 'BAT/ETH', '1');
INSERT INTO `markets` VALUES ('130', 'BAT/BNB', '1');
INSERT INTO `markets` VALUES ('131', 'BCPT/BTC', '1');
INSERT INTO `markets` VALUES ('132', 'BCPT/ETH', '1');
INSERT INTO `markets` VALUES ('133', 'BCPT/BNB', '1');
INSERT INTO `markets` VALUES ('134', 'ARN/BTC', '1');
INSERT INTO `markets` VALUES ('135', 'ARN/ETH', '1');
INSERT INTO `markets` VALUES ('136', 'GVT/BTC', '1');
INSERT INTO `markets` VALUES ('137', 'GVT/ETH', '1');
INSERT INTO `markets` VALUES ('138', 'CDT/BTC', '1');
INSERT INTO `markets` VALUES ('139', 'CDT/ETH', '1');
INSERT INTO `markets` VALUES ('140', 'GXS/BTC', '1');
INSERT INTO `markets` VALUES ('141', 'GXS/ETH', '1');
INSERT INTO `markets` VALUES ('142', 'NEO/USDT', '1');
INSERT INTO `markets` VALUES ('143', 'NEO/BNB', '1');
INSERT INTO `markets` VALUES ('144', 'POE/BTC', '1');
INSERT INTO `markets` VALUES ('145', 'POE/ETH', '1');
INSERT INTO `markets` VALUES ('146', 'QSP/BTC', '1');
INSERT INTO `markets` VALUES ('147', 'QSP/ETH', '1');
INSERT INTO `markets` VALUES ('148', 'QSP/BNB', '1');
INSERT INTO `markets` VALUES ('149', 'BTS/BTC', '1');
INSERT INTO `markets` VALUES ('150', 'BTS/ETH', '1');
INSERT INTO `markets` VALUES ('151', 'BTS/BNB', '1');
INSERT INTO `markets` VALUES ('152', 'XZC/BTC', '1');
INSERT INTO `markets` VALUES ('153', 'XZC/ETH', '1');
INSERT INTO `markets` VALUES ('154', 'XZC/BNB', '1');
INSERT INTO `markets` VALUES ('155', 'LSK/BTC', '1');
INSERT INTO `markets` VALUES ('156', 'LSK/ETH', '1');
INSERT INTO `markets` VALUES ('157', 'LSK/BNB', '1');
INSERT INTO `markets` VALUES ('158', 'TNT/BTC', '1');
INSERT INTO `markets` VALUES ('159', 'TNT/ETH', '1');
INSERT INTO `markets` VALUES ('160', 'FUEL/BTC', '1');
INSERT INTO `markets` VALUES ('161', 'FUEL/ETH', '1');
INSERT INTO `markets` VALUES ('162', 'MANA/BTC', '1');
INSERT INTO `markets` VALUES ('163', 'MANA/ETH', '1');
INSERT INTO `markets` VALUES ('164', 'BCD/BTC', '1');
INSERT INTO `markets` VALUES ('165', 'BCD/ETH', '1');
INSERT INTO `markets` VALUES ('166', 'DGD/BTC', '1');
INSERT INTO `markets` VALUES ('167', 'DGD/ETH', '1');
INSERT INTO `markets` VALUES ('168', 'IOTA/BNB', '1');
INSERT INTO `markets` VALUES ('169', 'ADX/BTC', '1');
INSERT INTO `markets` VALUES ('170', 'ADX/ETH', '1');
INSERT INTO `markets` VALUES ('171', 'ADX/BNB', '1');
INSERT INTO `markets` VALUES ('172', 'ADA/BTC', '1');
INSERT INTO `markets` VALUES ('173', 'ADA/ETH', '1');
INSERT INTO `markets` VALUES ('174', 'PPT/BTC', '1');
INSERT INTO `markets` VALUES ('175', 'PPT/ETH', '1');
INSERT INTO `markets` VALUES ('176', 'CMT/BTC', '1');
INSERT INTO `markets` VALUES ('177', 'CMT/ETH', '1');
INSERT INTO `markets` VALUES ('178', 'CMT/BNB', '1');
INSERT INTO `markets` VALUES ('179', 'XLM/BTC', '1');
INSERT INTO `markets` VALUES ('180', 'XLM/ETH', '1');
INSERT INTO `markets` VALUES ('181', 'XLM/BNB', '1');
INSERT INTO `markets` VALUES ('182', 'CND/BTC', '1');
INSERT INTO `markets` VALUES ('183', 'CND/ETH', '1');
INSERT INTO `markets` VALUES ('184', 'CND/BNB', '1');
INSERT INTO `markets` VALUES ('185', 'LEND/BTC', '1');
INSERT INTO `markets` VALUES ('186', 'LEND/ETH', '1');
INSERT INTO `markets` VALUES ('187', 'WABI/BTC', '1');
INSERT INTO `markets` VALUES ('188', 'WABI/ETH', '1');
INSERT INTO `markets` VALUES ('189', 'WABI/BNB', '1');
INSERT INTO `markets` VALUES ('190', 'LTC/ETH', '1');
INSERT INTO `markets` VALUES ('191', 'LTC/USDT', '1');
INSERT INTO `markets` VALUES ('192', 'LTC/BNB', '1');
INSERT INTO `markets` VALUES ('193', 'TNB/BTC', '1');
INSERT INTO `markets` VALUES ('194', 'TNB/ETH', '1');
INSERT INTO `markets` VALUES ('195', 'WAVES/BTC', '1');
INSERT INTO `markets` VALUES ('196', 'WAVES/ETH', '1');
INSERT INTO `markets` VALUES ('197', 'WAVES/BNB', '1');
INSERT INTO `markets` VALUES ('198', 'GTO/BTC', '1');
INSERT INTO `markets` VALUES ('199', 'GTO/ETH', '1');
INSERT INTO `markets` VALUES ('200', 'GTO/BNB', '1');
INSERT INTO `markets` VALUES ('201', 'ICX/BTC', '1');
INSERT INTO `markets` VALUES ('202', 'ICX/ETH', '1');
INSERT INTO `markets` VALUES ('203', 'ICX/BNB', '1');
INSERT INTO `markets` VALUES ('204', 'OST/BTC', '1');
INSERT INTO `markets` VALUES ('205', 'OST/ETH', '1');
INSERT INTO `markets` VALUES ('206', 'OST/BNB', '1');
INSERT INTO `markets` VALUES ('207', 'ELF/BTC', '1');
INSERT INTO `markets` VALUES ('208', 'ELF/ETH', '1');
INSERT INTO `markets` VALUES ('209', 'AION/BTC', '1');
INSERT INTO `markets` VALUES ('210', 'AION/ETH', '1');
INSERT INTO `markets` VALUES ('211', 'AION/BNB', '1');
INSERT INTO `markets` VALUES ('212', 'NEBL/BTC', '1');
INSERT INTO `markets` VALUES ('213', 'NEBL/ETH', '1');
INSERT INTO `markets` VALUES ('214', 'NEBL/BNB', '1');
INSERT INTO `markets` VALUES ('215', 'BRD/BTC', '1');
INSERT INTO `markets` VALUES ('216', 'BRD/ETH', '1');
INSERT INTO `markets` VALUES ('217', 'BRD/BNB', '1');
INSERT INTO `markets` VALUES ('218', 'MCO/BNB', '1');
INSERT INTO `markets` VALUES ('219', 'EDO/BTC', '1');
INSERT INTO `markets` VALUES ('220', 'EDO/ETH', '1');
INSERT INTO `markets` VALUES ('221', 'WINGS/BTC', '1');
INSERT INTO `markets` VALUES ('222', 'WINGS/ETH', '1');
INSERT INTO `markets` VALUES ('223', 'NAV/BTC', '1');
INSERT INTO `markets` VALUES ('224', 'NAV/ETH', '1');
INSERT INTO `markets` VALUES ('225', 'NAV/BNB', '1');
INSERT INTO `markets` VALUES ('226', 'LUN/BTC', '1');
INSERT INTO `markets` VALUES ('227', 'LUN/ETH', '1');
INSERT INTO `markets` VALUES ('228', 'TRIG/BTC', '1');
INSERT INTO `markets` VALUES ('229', 'TRIG/ETH', '1');
INSERT INTO `markets` VALUES ('230', 'TRIG/BNB', '1');
INSERT INTO `markets` VALUES ('231', 'APPC/BTC', '1');
INSERT INTO `markets` VALUES ('232', 'APPC/ETH', '1');
INSERT INTO `markets` VALUES ('233', 'APPC/BNB', '1');
INSERT INTO `markets` VALUES ('234', 'VIBE/BTC', '1');
INSERT INTO `markets` VALUES ('235', 'VIBE/ETH', '1');
INSERT INTO `markets` VALUES ('236', 'RLC/BTC', '1');
INSERT INTO `markets` VALUES ('237', 'RLC/ETH', '1');
INSERT INTO `markets` VALUES ('238', 'RLC/BNB', '1');
INSERT INTO `markets` VALUES ('239', 'INS/BTC', '1');
INSERT INTO `markets` VALUES ('240', 'INS/ETH', '1');
INSERT INTO `markets` VALUES ('241', 'PIVX/BTC', '1');
INSERT INTO `markets` VALUES ('242', 'PIVX/ETH', '1');
INSERT INTO `markets` VALUES ('243', 'PIVX/BNB', '1');
INSERT INTO `markets` VALUES ('244', 'IOST/BTC', '1');
INSERT INTO `markets` VALUES ('245', 'IOST/ETH', '1');
INSERT INTO `markets` VALUES ('246', 'CHAT/BTC', '1');
INSERT INTO `markets` VALUES ('247', 'CHAT/ETH', '1');
INSERT INTO `markets` VALUES ('248', 'STEEM/BTC', '1');
INSERT INTO `markets` VALUES ('249', 'STEEM/ETH', '1');
INSERT INTO `markets` VALUES ('250', 'STEEM/BNB', '1');
INSERT INTO `markets` VALUES ('251', 'XRB/BTC', '1');
INSERT INTO `markets` VALUES ('252', 'XRB/ETH', '1');
INSERT INTO `markets` VALUES ('253', 'XRB/BNB', '1');
INSERT INTO `markets` VALUES ('254', 'VIA/BTC', '1');
INSERT INTO `markets` VALUES ('255', 'VIA/ETH', '1');
INSERT INTO `markets` VALUES ('256', 'VIA/BNB', '1');
INSERT INTO `markets` VALUES ('257', 'BLZ/BTC', '1');
INSERT INTO `markets` VALUES ('258', 'BLZ/ETH', '1');
INSERT INTO `markets` VALUES ('259', 'BLZ/BNB', '1');
INSERT INTO `markets` VALUES ('260', 'AE/BTC', '1');
INSERT INTO `markets` VALUES ('261', 'AE/ETH', '1');
INSERT INTO `markets` VALUES ('262', 'AE/BNB', '1');
INSERT INTO `markets` VALUES ('263', 'RPX/BTC', '1');
INSERT INTO `markets` VALUES ('264', 'RPX/ETH', '1');
INSERT INTO `markets` VALUES ('265', 'RPX/BNB', '1');
INSERT INTO `markets` VALUES ('266', 'NCASH/BTC', '1');
INSERT INTO `markets` VALUES ('267', 'NCASH/ETH', '1');
INSERT INTO `markets` VALUES ('268', 'NCASH/BNB', '1');
INSERT INTO `markets` VALUES ('269', 'POA/BTC', '1');
INSERT INTO `markets` VALUES ('270', 'POA/ETH', '1');
INSERT INTO `markets` VALUES ('271', 'POA/BNB', '1');
INSERT INTO `markets` VALUES ('272', 'ZIL/BTC', '1');
INSERT INTO `markets` VALUES ('273', 'ZIL/ETH', '1');
INSERT INTO `markets` VALUES ('274', 'ZIL/BNB', '1');
INSERT INTO `markets` VALUES ('275', 'ONT/BTC', '1');
INSERT INTO `markets` VALUES ('276', 'ONT/ETH', '1');
INSERT INTO `markets` VALUES ('277', 'ONT/BNB', '1');
INSERT INTO `markets` VALUES ('278', 'STORM/BTC', '1');
INSERT INTO `markets` VALUES ('279', 'STORM/ETH', '1');
INSERT INTO `markets` VALUES ('280', 'STORM/BNB', '1');
INSERT INTO `markets` VALUES ('281', 'QTUM/BNB', '1');
INSERT INTO `markets` VALUES ('282', 'QTUM/USDT', '1');
INSERT INTO `markets` VALUES ('283', 'XEM/BTC', '1');
INSERT INTO `markets` VALUES ('284', 'XEM/ETH', '1');
INSERT INTO `markets` VALUES ('285', 'XEM/BNB', '1');
INSERT INTO `markets` VALUES ('286', 'WAN/BTC', '1');
INSERT INTO `markets` VALUES ('287', 'WAN/ETH', '1');
INSERT INTO `markets` VALUES ('288', 'WAN/BNB', '1');
INSERT INTO `markets` VALUES ('289', 'WPR/BTC', '1');
INSERT INTO `markets` VALUES ('290', 'WPR/ETH', '1');
INSERT INTO `markets` VALUES ('291', 'QLC/BTC', '1');
INSERT INTO `markets` VALUES ('292', 'QLC/ETH', '1');
INSERT INTO `markets` VALUES ('293', 'SYS/BTC', '1');
INSERT INTO `markets` VALUES ('294', 'SYS/ETH', '1');
INSERT INTO `markets` VALUES ('295', 'SYS/BNB', '1');
INSERT INTO `markets` VALUES ('296', 'QLC/BNB', '1');
INSERT INTO `markets` VALUES ('297', 'GRS/BTC', '1');
INSERT INTO `markets` VALUES ('298', 'GRS/ETH', '1');
INSERT INTO `markets` VALUES ('299', 'ADA/USDT', '1');
INSERT INTO `markets` VALUES ('300', 'ADA/BNB', '1');
INSERT INTO `markets` VALUES ('301', 'CLOAK/BTC', '1');
INSERT INTO `markets` VALUES ('302', 'CLOAK/ETH', '1');
INSERT INTO `markets` VALUES ('303', 'GNT/BTC', '1');
INSERT INTO `markets` VALUES ('304', 'GNT/ETH', '1');
INSERT INTO `markets` VALUES ('305', 'GNT/BNB', '1');
INSERT INTO `markets` VALUES ('306', 'LOOM/BTC', '1');
INSERT INTO `markets` VALUES ('307', 'LOOM/ETH', '1');
INSERT INTO `markets` VALUES ('308', 'LOOM/BNB', '1');
INSERT INTO `markets` VALUES ('309', 'XRP/USDT', '1');
INSERT INTO `markets` VALUES ('310', 'BCN/BTC', '1');
INSERT INTO `markets` VALUES ('311', 'BCN/ETH', '1');
INSERT INTO `markets` VALUES ('312', 'BCN/BNB', '1');
INSERT INTO `markets` VALUES ('313', 'REP/BTC', '1');
INSERT INTO `markets` VALUES ('314', 'REP/ETH', '1');
INSERT INTO `markets` VALUES ('315', 'REP/BNB', '1');
INSERT INTO `markets` VALUES ('316', 'TUSD/BTC', '1');
INSERT INTO `markets` VALUES ('317', 'TUSD/ETH', '1');
INSERT INTO `markets` VALUES ('318', 'TUSD/BNB', '1');
INSERT INTO `markets` VALUES ('319', 'ZEN/BTC', '1');
INSERT INTO `markets` VALUES ('320', 'ZEN/ETH', '1');
INSERT INTO `markets` VALUES ('321', 'ZEN/BNB', '1');
INSERT INTO `markets` VALUES ('322', 'SKY/BTC', '1');
INSERT INTO `markets` VALUES ('323', 'SKY/ETH', '1');
INSERT INTO `markets` VALUES ('324', 'SKY/BNB', '1');
INSERT INTO `markets` VALUES ('325', 'EOS/USDT', '1');
INSERT INTO `markets` VALUES ('326', 'EOS/BNB', '1');
INSERT INTO `markets` VALUES ('327', 'CVC/BTC', '1');
INSERT INTO `markets` VALUES ('328', 'CVC/ETH', '1');
INSERT INTO `markets` VALUES ('329', 'CVC/BNB', '1');
INSERT INTO `markets` VALUES ('330', 'THETA/BTC', '1');
INSERT INTO `markets` VALUES ('331', 'THETA/ETH', '1');
INSERT INTO `markets` VALUES ('332', 'THETA/BNB', '1');
INSERT INTO `markets` VALUES ('333', 'XRP/BNB', '1');
INSERT INTO `markets` VALUES ('334', 'TUSD/USDT', '1');
INSERT INTO `markets` VALUES ('335', 'IOTA/USDT', '1');
INSERT INTO `markets` VALUES ('336', 'XLM/USDT', '1');
INSERT INTO `markets` VALUES ('337', 'IOTX/BTC', '1');
INSERT INTO `markets` VALUES ('338', 'IOTX/ETH', '1');
INSERT INTO `markets` VALUES ('339', 'QKC/BTC', '1');
INSERT INTO `markets` VALUES ('340', 'QKC/ETH', '1');
INSERT INTO `markets` VALUES ('341', 'AGI/BTC', '1');
INSERT INTO `markets` VALUES ('342', 'AGI/ETH', '1');
INSERT INTO `markets` VALUES ('343', 'AGI/BNB', '1');
INSERT INTO `markets` VALUES ('344', 'NXS/BTC', '1');
INSERT INTO `markets` VALUES ('345', 'NXS/ETH', '1');
INSERT INTO `markets` VALUES ('346', 'NXS/BNB', '1');
INSERT INTO `markets` VALUES ('347', 'ENJ/BNB', '1');
INSERT INTO `markets` VALUES ('348', 'DATA/BTC', '1');
INSERT INTO `markets` VALUES ('349', 'DATA/ETH', '1');
INSERT INTO `markets` VALUES ('350', 'ONT/USDT', '1');
INSERT INTO `markets` VALUES ('351', 'TRX/USDT', '1');
INSERT INTO `markets` VALUES ('352', 'ETC/USDT', '1');
INSERT INTO `markets` VALUES ('353', 'ETC/BNB', '1');
INSERT INTO `markets` VALUES ('354', 'ICX/USDT', '1');
INSERT INTO `markets` VALUES ('355', 'SC/BTC', '1');
INSERT INTO `markets` VALUES ('356', 'SC/ETH', '1');
INSERT INTO `markets` VALUES ('357', 'SC/BNB', '1');
INSERT INTO `markets` VALUES ('358', 'NPXS/BTC', '1');
INSERT INTO `markets` VALUES ('359', 'NPXS/ETH', '1');
INSERT INTO `markets` VALUES ('360', 'VEN/USDT', '1');
INSERT INTO `markets` VALUES ('361', 'KEY/BTC', '1');
INSERT INTO `markets` VALUES ('362', 'KEY/ETH', '1');
INSERT INTO `markets` VALUES ('363', 'NAS/BTC', '1');
INSERT INTO `markets` VALUES ('364', 'NAS/ETH', '1');
INSERT INTO `markets` VALUES ('365', 'NAS/BNB', '1');
INSERT INTO `markets` VALUES ('366', 'MFT/BTC', '1');
INSERT INTO `markets` VALUES ('367', 'MFT/ETH', '1');
INSERT INTO `markets` VALUES ('368', 'MFT/BNB', '1');
INSERT INTO `markets` VALUES ('369', 'DENT/BTC', '1');
INSERT INTO `markets` VALUES ('370', 'DENT/ETH', '1');

-- ----------------------------
-- Table structure for `messages`
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text,
  `channel_id` int(11) DEFAULT NULL,
  `signal_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1306 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of messages
-- ----------------------------
INSERT INTO `messages` VALUES ('1301', '#ARK/ (BINANCE) BUY UNDER : 22001-23000 sell : 25000-28000-32000-39010', '1331154859', '46');
INSERT INTO `messages` VALUES ('1302', '#ARK/ (BINANCE) BUY UNDER : 22001-23000 sell : 25000-28000-32000-39010', '1331154859', '46');
INSERT INTO `messages` VALUES ('1303', '#ARK/ (BINANCE) BUY UNDER : 22001-23000 sell : 25000-28000-32000-39010', '1331154859', '46');
INSERT INTO `messages` VALUES ('1304', '#ARK/ (BINANCE) BUY UNDER : 22001-23000 sell : 25000-28000-32000-39010', '1331154859', '46');
INSERT INTO `messages` VALUES ('1305', '#ARK/ (BINANCE) BUY UNDER : 22001-23000 sell : 25000-28000-32000-39010', '1331154859', '46');

-- ----------------------------
-- Table structure for `pending_sell_trx`
-- ----------------------------
DROP TABLE IF EXISTS `pending_sell_trx`;
CREATE TABLE `pending_sell_trx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exchange` varchar(20) DEFAULT NULL,
  `signal_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `sell_limit_order_id` int(11) DEFAULT NULL,
  `coin` varchar(10) DEFAULT NULL,
  `target_price` int(11) DEFAULT NULL,
  `settled_date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_allocated_balance` decimal(10,0) DEFAULT NULL,
  `buy_market_order_id` int(11) DEFAULT NULL,
  `is_pending` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pending_sell_trx
-- ----------------------------
INSERT INTO `pending_sell_trx` VALUES ('1', 'BINANCE', '2', null, '0', 'QSP/BTC', '0', '2018-07-12 18:54:10', '1', '160', '0', '1');
INSERT INTO `pending_sell_trx` VALUES ('2', 'BINANCE', '1970', null, '0', 'NAV/BTC', '0', '2018-07-12 18:54:16', '1', '25', '0', '1');
INSERT INTO `pending_sell_trx` VALUES ('3', 'BINANCE', '2', null, '0', 'QSP/BTC', '0', '2018-07-18 08:28:15', '1', '121', '0', '1');
INSERT INTO `pending_sell_trx` VALUES ('4', 'BINANCE', '1970', null, '0', 'NAV/BTC', '0', '2018-07-18 08:28:26', '1', '20', '0', '1');
INSERT INTO `pending_sell_trx` VALUES ('5', 'BINANCE', '1972', null, '0', 'DLT/BTC', '0', '2018-07-18 08:31:22', '1', '95', '0', '1');
INSERT INTO `pending_sell_trx` VALUES ('6', 'BINANCE', '1973', null, '0', 'QSP/BTC', '0', '2018-07-18 08:31:32', '1', '120', '0', '1');

-- ----------------------------
-- Table structure for `sell_trx`
-- ----------------------------
DROP TABLE IF EXISTS `sell_trx`;
CREATE TABLE `sell_trx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `signal_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `exchange` varchar(20) DEFAULT NULL,
  `coin` varchar(10) DEFAULT NULL,
  `sold_price` int(11) NOT NULL,
  `settled_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_allocated_balance` decimal(15,5) NOT NULL,
  `fee` int(11) NOT NULL,
  `user_nett_profit` decimal(15,5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sell_trx
-- ----------------------------
INSERT INTO `sell_trx` VALUES ('1', '2', '0', 'binance', 'QSP/BTC', '0', '2018-07-12 18:54:10', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('2', '2', '0', 'binance', 'QSP/BTC', '0', '2018-07-12 18:54:10', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('3', '2', '0', 'binance', 'QSP/BTC', '0', '2018-07-18 08:28:15', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('4', '1970', '0', 'binance', 'NAV/BTC', '0', '2018-07-12 18:54:16', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('5', '1970', '0', 'binance', 'NAV/BTC', '0', '2018-07-18 08:28:26', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('6', '2', '0', 'binance', 'QSP/BTC', '0', '2018-07-12 18:54:10', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('7', '2', '0', 'binance', 'QSP/BTC', '0', '2018-07-18 08:28:15', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('8', '2', '0', 'binance', 'QSP/BTC', '0', '2018-07-12 18:54:10', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('9', '2', '0', 'binance', 'QSP/BTC', '0', '2018-07-18 08:28:15', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('10', '1970', '0', 'binance', 'NAV/BTC', '0', '2018-07-12 18:54:16', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('11', '1970', '0', 'binance', 'NAV/BTC', '0', '2018-07-12 18:54:16', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('12', '1970', '0', 'binance', 'NAV/BTC', '0', '2018-07-18 08:28:26', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('13', '1970', '0', 'binance', 'NAV/BTC', '0', '2018-07-18 08:28:26', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('14', '2', '0', 'binance', 'QSP/BTC', '0', '2018-07-12 18:54:10', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('15', '1972', '0', 'binance', 'DLT/BTC', '0', '2018-07-18 08:31:22', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('16', '2', '0', 'binance', 'QSP/BTC', '0', '2018-07-18 08:28:15', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('17', '1973', '0', 'binance', 'QSP/BTC', '0', '2018-07-18 08:31:32', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('18', '1970', '0', 'binance', 'NAV/BTC', '0', '2018-07-12 18:54:16', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('19', '1970', '0', 'binance', 'NAV/BTC', '0', '2018-07-18 08:28:26', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('20', '1972', '0', 'binance', 'DLT/BTC', '0', '2018-07-18 08:31:22', '1', '0.00000', '0', '0.00000');
INSERT INTO `sell_trx` VALUES ('21', '1973', '0', 'binance', 'QSP/BTC', '0', '2018-07-18 08:31:32', '1', '0.00000', '0', '0.00000');

-- ----------------------------
-- Table structure for `signals`
-- ----------------------------
DROP TABLE IF EXISTS `signals`;
CREATE TABLE `signals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `signal_id` bigint(11) NOT NULL,
  `channel_id` bigint(11) NOT NULL,
  `exchange` varchar(20) NOT NULL,
  `coin` varchar(20) NOT NULL,
  `received_date` datetime NOT NULL,
  `signal_buy_value` decimal(10,0) NOT NULL,
  `signal_sell_value` decimal(10,0) NOT NULL,
  `is_processed` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of signals
-- ----------------------------
INSERT INTO `signals` VALUES ('1', '2', '1268010485', 'BINANCE', 'qsp', '2018-07-08 16:55:01', '200', '220', '1', '');
INSERT INTO `signals` VALUES ('2', '1970', '1268010485', 'BINANCE', 'NAV', '2018-07-10 13:57:42', '6700', '7370', '1', '');
INSERT INTO `signals` VALUES ('3', '1971', '1268010485', 'BINANCE', 'DSH', '2018-07-18 08:18:03', '3300', '3630', '-1', 'signal invalid, too long to wait for buy (7days ago)');
INSERT INTO `signals` VALUES ('4', '1972', '1268010485', 'BINANCE', 'DLT', '2018-07-18 08:18:51', '1170', '1287', '1', '');
INSERT INTO `signals` VALUES ('5', '1973', '1268010485', 'BINANCE', 'QSP', '2018-07-18 08:20:47', '3300', '3630', '1', '');
INSERT INTO `signals` VALUES ('6', '1974', '1268010485', 'BINANCE', 'LUN', '2018-07-30 10:07:23', '860', '946', '0', '');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------

-- ----------------------------
-- Table structure for `user_balance`
-- ----------------------------
DROP TABLE IF EXISTS `user_balance`;
CREATE TABLE `user_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `balance` decimal(15,5) NOT NULL,
  `signal_id` int(11) NOT NULL,
  `user_profit` decimal(15,5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_balance
-- ----------------------------
INSERT INTO `user_balance` VALUES ('1', '1', '21654400.00000', '0', '0.00000');

-- ----------------------------
-- Table structure for `user_exchange`
-- ----------------------------
DROP TABLE IF EXISTS `user_exchange`;
CREATE TABLE `user_exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `exchange_id` int(11) NOT NULL,
  `n` varchar(255) NOT NULL,
  `a` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_exchange
-- ----------------------------
INSERT INTO `user_exchange` VALUES ('3', '1', '1', 'zwhEjpIR3XzbQShM5p9jMNmPUOphCTehHEup1G6DlB9wA8wpdmjc7tTsUiHhCtiF1', 'UGVyb7Txko0t16DbCKjTxi1sI9fM2LK3oRf4WaRCTo6DIJVYSQySV5KOSVmyxzmU1');
