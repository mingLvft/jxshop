/*
 Navicat Premium Data Transfer

 Source Server         : php_root
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : jxshop

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 21/09/2019 14:50:31
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for jx_admin
-- ----------------------------
DROP TABLE IF EXISTS `jx_admin`;
CREATE TABLE `jx_admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_admin
-- ----------------------------
INSERT INTO `jx_admin` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `jx_admin` VALUES (2, 'zhang', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `jx_admin` VALUES (3, 'li', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for jx_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `jx_admin_role`;
CREATE TABLE `jx_admin_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `role_id` int(11) NOT NULL DEFAULT 0 COMMENT '角色ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_admin_role
-- ----------------------------
INSERT INTO `jx_admin_role` VALUES (1, 1, 1);
INSERT INTO `jx_admin_role` VALUES (2, 2, 2);
INSERT INTO `jx_admin_role` VALUES (3, 3, 3);

-- ----------------------------
-- Table structure for jx_attribute
-- ----------------------------
DROP TABLE IF EXISTS `jx_attribute`;
CREATE TABLE `jx_attribute`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '属性名称',
  `type_id` int(11) NOT NULL DEFAULT 0 COMMENT '属性所对应的类型',
  `attr_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '表示属性的类型 1表示唯一 2表示单选',
  `attr_input_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '表示属性值的录入方法 1表示手工输入 2表示列表选择',
  `attr_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '列表选择的默认值 多个值之间使用逗号隔开',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_attribute
-- ----------------------------
INSERT INTO `jx_attribute` VALUES (1, '屏幕大小', 2, 1, 1, '');
INSERT INTO `jx_attribute` VALUES (2, '内存', 2, 2, 2, '4g,8g,16g');
INSERT INTO `jx_attribute` VALUES (3, '待机时间', 1, 1, 1, '');
INSERT INTO `jx_attribute` VALUES (4, '网络格式', 1, 2, 2, '电信,移动,联通');

-- ----------------------------
-- Table structure for jx_cart
-- ----------------------------
DROP TABLE IF EXISTS `jx_cart`;
CREATE TABLE `jx_cart`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '登录的用户id',
  `goods_id` int(11) NOT NULL DEFAULT 0 COMMENT '商品id',
  `goods_attr_ids` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品属性id每个属性逗号隔开,关联jx_goods_attr表中的id',
  `goods_count` int(11) NOT NULL DEFAULT 0 COMMENT '商品购买数量',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for jx_category
-- ----------------------------
DROP TABLE IF EXISTS `jx_category`;
CREATE TABLE `jx_category`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cname` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` smallint(6) NOT NULL DEFAULT 0 COMMENT '分类的父分类ID',
  `isrec` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否推荐 0表示不推荐1表示推荐',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_category
-- ----------------------------
INSERT INTO `jx_category` VALUES (1, '手机', 0, 0);
INSERT INTO `jx_category` VALUES (2, '手机品牌', 1, 1);
INSERT INTO `jx_category` VALUES (3, '食品', 0, 0);
INSERT INTO `jx_category` VALUES (4, '辣条', 3, 1);
INSERT INTO `jx_category` VALUES (5, '牛肉条', 3, 1);
INSERT INTO `jx_category` VALUES (6, '家用电器', 0, 0);
INSERT INTO `jx_category` VALUES (7, '电冰箱', 6, 0);
INSERT INTO `jx_category` VALUES (8, '洗衣机', 6, 0);
INSERT INTO `jx_category` VALUES (9, '手机通讯', 1, 0);
INSERT INTO `jx_category` VALUES (10, '手机配件', 1, 0);
INSERT INTO `jx_category` VALUES (11, '苹果手机', 2, 0);
INSERT INTO `jx_category` VALUES (12, '华为手机', 2, 0);

-- ----------------------------
-- Table structure for jx_comment
-- ----------------------------
DROP TABLE IF EXISTS `jx_comment`;
CREATE TABLE `jx_comment`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `user_id` int(8) UNSIGNED NOT NULL COMMENT '会员id',
  `goods_id` int(8) UNSIGNED NOT NULL COMMENT '商品id',
  `addtime` int(10) UNSIGNED NOT NULL COMMENT '评论时间',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评论的内容',
  `star` tinyint(1) UNSIGNED NOT NULL COMMENT '评论的分值',
  `good_number` int(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '有用的数字',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `goods_id`(`goods_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '评论' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jx_comment
-- ----------------------------
INSERT INTO `jx_comment` VALUES (1, 1, 1, 1568877430, 'asdasd', 5, 26);
INSERT INTO `jx_comment` VALUES (2, 1, 1, 1568878801, '东方闪电', 4, 15);
INSERT INTO `jx_comment` VALUES (3, 1, 1, 1568878996, '阿三大声道', 5, 1);
INSERT INTO `jx_comment` VALUES (4, 1, 1, 1568880290, '123', 0, 0);
INSERT INTO `jx_comment` VALUES (10, 1, 1, 1568948819, '阿萨德', 5, 0);
INSERT INTO `jx_comment` VALUES (9, 1, 1, 1568904364, 'sdfsdf', 0, 0);

-- ----------------------------
-- Table structure for jx_goods
-- ----------------------------
DROP TABLE IF EXISTS `jx_goods`;
CREATE TABLE `jx_goods`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_sn` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品货号',
  `cate_id` smallint(6) NOT NULL DEFAULT 0 COMMENT '商品分类ID 对于category表中的ID字段',
  `market_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '市场售价',
  `shop_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '本店售价',
  `goods_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品缩略图',
  `goods_thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品缩略小图',
  `goods_body` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品描述',
  `is_hot` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否热卖 1表示热卖 0表示不是',
  `is_rec` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否推荐 1表示推荐 0表示不推荐',
  `is_new` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否新品 1表示新品 0表示不是',
  `addtime` int(11) NOT NULL DEFAULT 0 COMMENT '添加时间',
  `isdel` tinyint(4) NOT NULL DEFAULT 1 COMMENT '表示商品是否删除 1正常 0删除状态',
  `is_sale` tinyint(4) NOT NULL DEFAULT 1 COMMENT '商品是否销售 1销售 0下架状态',
  `type_id` int(11) NOT NULL COMMENT '商品对应的类型ID',
  `goods_number` int(11) NOT NULL DEFAULT 0 COMMENT '商品个数',
  `cx_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '促销价格',
  `start` int(11) NOT NULL DEFAULT 0 COMMENT '开始时间',
  `end` int(11) NOT NULL DEFAULT 0 COMMENT '结束时间',
  `plcount` int(11) NOT NULL DEFAULT 0 COMMENT '评论总数量',
  `sale_number` int(11) NOT NULL DEFAULT 0 COMMENT '总销量',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `goods_sn`(`goods_sn`) USING BTREE,
  INDEX `goods_name`(`goods_name`) USING BTREE,
  INDEX `isdel`(`isdel`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_goods
-- ----------------------------
INSERT INTO `jx_goods` VALUES (1, '小辣椒 红辣椒4A 高配版 4GB+32GB 全网通 黑色 ', 'JX597415b2f122f', 1, 1900.00, 799.00, 'Uploads/2017-07-23/597415b2f1b8d.jpg', 'Uploads/2017-07-23/thumb_597415b2f1b8d.jpg', '&lt;p&gt;小辣椒 红辣椒4A 高配版 4GB+32GB 全网通 黑色 移动联通电信4G手机 双卡双待&lt;/p&gt;', 1, 0, 0, 1500779954, 1, 1, 0, 271, 300.00, 1568304000, 1599926400, 1, 0);
INSERT INTO `jx_goods` VALUES (2, 'Apple iPhone 6 32GB 金色 移动联通电信4G手机', 'JX597415fa7d456', 2, 25787.00, 2578.00, 'Uploads/2017-07-23/597415fa7dc78.jpg', 'Uploads/2017-07-23/thumb_597415fa7dc78.jpg', '&lt;p&gt;2578&lt;/p&gt;', 0, 0, 1, 1500780026, 1, 1, 3, 300, 0.00, 0, 0, 0, 0);
INSERT INTO `jx_goods` VALUES (3, '荣耀 畅玩6X 4GB 64GB 全网通4G手机 尊享版 冰河银', 'JX5974163c73424', 11, 6000.00, 100.00, 'Uploads/2017-07-23/5974163c73d2a.jpg', 'Uploads/2017-07-23/thumb_5974163c73d2a.jpg', '&lt;p&gt;&lt;span style=&quot;color: rgb(102, 102, 102); font-family: Arial, &amp;#39;microsoft yahei&amp;#39;; font-weight: bold; line-height: 28px; background-color: rgb(255, 255, 255);&quot;&gt;荣耀 畅玩6X 4GB 64GB 全网通4G手机 尊享版 冰河银&lt;/span&gt;&lt;/p&gt;', 0, 1, 0, 1500780092, 1, 1, 3, 0, 0.00, 0, 0, 0, 0);
INSERT INTO `jx_goods` VALUES (4, '小米Max2 全网通 4GB+64GB 金色 移动联通电信4G手机 ', 'JX5974166b57053', 1, 2799.00, 1699.00, 'Uploads/2017-07-23/5974166b57889.jpg', 'Uploads/2017-07-23/thumb_5974166b57889.jpg', '&lt;p&gt;&lt;span style=&quot;color: rgb(102, 102, 102); font-family: Arial, &amp;#39;microsoft yahei&amp;#39;; font-weight: bold; line-height: 28px; background-color: rgb(255, 255, 255);&quot;&gt;小米Max2 全网通 4GB+64GB 金色 移动联通电信4G手机 双卡双待&lt;/span&gt;&lt;/p&gt;', 0, 0, 1, 1500780139, 1, 1, 3, 0, 0.00, 0, 0, 0, 0);
INSERT INTO `jx_goods` VALUES (5, '华为 HUAWEI P10 全网通 4GB+64GB 草木绿 ', 'JX5974169943cf3', 1, 6000.00, 100.00, 'Uploads/2017-07-23/5974169944be9.jpg', 'Uploads/2017-07-23/thumb_5974169944be9.jpg', '&lt;p&gt;&lt;span style=&quot;color: rgb(102, 102, 102); font-family: Arial, &amp;#39;microsoft yahei&amp;#39;; font-weight: bold; line-height: 28px; background-color: rgb(255, 255, 255);&quot;&gt;华为 HUAWEI P10 全网通 4GB+64GB 草木绿 移动联通电信4G手机 双卡双待&lt;/span&gt;&lt;/p&gt;', 0, 1, 0, 1500780185, 1, 1, 0, 0, 0.00, 0, 0, 0, 0);
INSERT INTO `jx_goods` VALUES (6, '小米手机', 'JX5d7b652164869', 1, 5000.00, 100.00, 'Uploads/2017-07-23/5974169944be9.jpg', 'Uploads/2017-07-23/thumb_5974169944be9.jpg', '', 0, 0, 0, 1568367905, 1, 1, 0, 0, 2000.00, 1568304000, 1599926400, 0, 0);

-- ----------------------------
-- Table structure for jx_goods_attr
-- ----------------------------
DROP TABLE IF EXISTS `jx_goods_attr`;
CREATE TABLE `jx_goods_attr`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL DEFAULT 0 COMMENT '商品ID',
  `attr_id` int(11) NOT NULL DEFAULT 0 COMMENT '属性ID',
  `attr_values` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '属性值',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_goods_attr
-- ----------------------------
INSERT INTO `jx_goods_attr` VALUES (1, 2, 3, '7h');
INSERT INTO `jx_goods_attr` VALUES (2, 2, 4, '电信');
INSERT INTO `jx_goods_attr` VALUES (4, 1, 1, '400cm');
INSERT INTO `jx_goods_attr` VALUES (5, 1, 2, '4g');
INSERT INTO `jx_goods_attr` VALUES (6, 1, 2, '8g');
INSERT INTO `jx_goods_attr` VALUES (7, 1, 2, '16g');
INSERT INTO `jx_goods_attr` VALUES (8, 1, 3, '7h1');
INSERT INTO `jx_goods_attr` VALUES (9, 1, 4, '电信');
INSERT INTO `jx_goods_attr` VALUES (10, 1, 4, '移动');

-- ----------------------------
-- Table structure for jx_goods_cate
-- ----------------------------
DROP TABLE IF EXISTS `jx_goods_cate`;
CREATE TABLE `jx_goods_cate`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL DEFAULT 0 COMMENT '商品ID标识',
  `cate_id` smallint(6) NOT NULL DEFAULT 0 COMMENT '分类ID标识',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_goods_cate
-- ----------------------------
INSERT INTO `jx_goods_cate` VALUES (1, 1, 9);
INSERT INTO `jx_goods_cate` VALUES (2, 2, 10);
INSERT INTO `jx_goods_cate` VALUES (3, 3, 10);
INSERT INTO `jx_goods_cate` VALUES (6, 4, 2);
INSERT INTO `jx_goods_cate` VALUES (7, 5, 1);
INSERT INTO `jx_goods_cate` VALUES (16, 6, 2);
INSERT INTO `jx_goods_cate` VALUES (17, 7, 1);

-- ----------------------------
-- Table structure for jx_goods_img
-- ----------------------------
DROP TABLE IF EXISTS `jx_goods_img`;
CREATE TABLE `jx_goods_img`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL DEFAULT 0 COMMENT '商品ID',
  `goods_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '相册图片',
  `goods_thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '相册小图',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_goods_img
-- ----------------------------
INSERT INTO `jx_goods_img` VALUES (1, 3, 'Uploads/2017-07-23/597415b319bcd.jpg', 'Uploads/2017-07-23/thumb_597415b319bcd.jpg');
INSERT INTO `jx_goods_img` VALUES (2, 3, 'Uploads/2017-07-23/597415b31ab47.jpg', 'Uploads/2017-07-23/thumb_597415b31ab47.jpg');
INSERT INTO `jx_goods_img` VALUES (3, 2, 'Uploads/2017-07-23/597415fa9f50b.jpg', 'Uploads/2017-07-23/thumb_597415fa9f50b.jpg');
INSERT INTO `jx_goods_img` VALUES (4, 2, 'Uploads/2017-07-23/597415faa039a.jpg', 'Uploads/2017-07-23/thumb_597415faa039a.jpg');
INSERT INTO `jx_goods_img` VALUES (5, 2, 'Uploads/2017-07-23/597415faa11d1.jpg', 'Uploads/2017-07-23/thumb_597415faa11d1.jpg');
INSERT INTO `jx_goods_img` VALUES (6, 3, 'Uploads/2017-07-23/5974163c8dd1e.jpg', 'Uploads/2017-07-23/thumb_5974163c8dd1e.jpg');
INSERT INTO `jx_goods_img` VALUES (7, 3, 'Uploads/2017-07-23/5974163c8ed09.jpg', 'Uploads/2017-07-23/thumb_5974163c8ed09.jpg');
INSERT INTO `jx_goods_img` VALUES (8, 1, 'Uploads/2017-07-23/597415b319bcd.jpg', 'Uploads/2017-07-23/thumb_597415b319bcd.jpg');
INSERT INTO `jx_goods_img` VALUES (10, 4, 'Uploads/2017-07-23/5974166b6ba48.jpg', 'Uploads/2017-07-23/thumb_5974166b6ba48.jpg');
INSERT INTO `jx_goods_img` VALUES (11, 4, 'Uploads/2017-07-23/597415faa11d1.jpg', 'Uploads/2017-07-23/thumb_597415faa11d1.jpg');
INSERT INTO `jx_goods_img` VALUES (12, 5, 'Uploads/2017-07-23/597415b319bcd.jpg', 'Uploads/2017-07-23/thumb_597415b319bcd.jpg');
INSERT INTO `jx_goods_img` VALUES (13, 5, 'Uploads/2017-07-23/5974166b6ba48.jpg', 'Uploads/2017-07-23/thumb_5974166b6ba48.jpg');

-- ----------------------------
-- Table structure for jx_goods_number
-- ----------------------------
DROP TABLE IF EXISTS `jx_goods_number`;
CREATE TABLE `jx_goods_number`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品的id',
  `goods_attr_ids` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '属性信息多个属性使用逗号隔开',
  `goods_number` int(11) NOT NULL DEFAULT 0 COMMENT '货品的库存',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jx_goods_number
-- ----------------------------
INSERT INTO `jx_goods_number` VALUES (1, 1, '5,9', 83);
INSERT INTO `jx_goods_number` VALUES (2, 1, '6,9', 198);

-- ----------------------------
-- Table structure for jx_impression
-- ----------------------------
DROP TABLE IF EXISTS `jx_impression`;
CREATE TABLE `jx_impression`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品id',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '印象名称',
  `count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '印象出现的次数',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `goods_id`(`goods_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '印象' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jx_impression
-- ----------------------------
INSERT INTO `jx_impression` VALUES (1, 1, '高端', 5);
INSERT INTO `jx_impression` VALUES (2, 1, '大气', 3);
INSERT INTO `jx_impression` VALUES (3, 1, '上档次', 2);

-- ----------------------------
-- Table structure for jx_order
-- ----------------------------
DROP TABLE IF EXISTS `jx_order`;
CREATE TABLE `jx_order`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `user_id` int(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '会员id',
  `total_price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '定单总价',
  `pay_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '支付状态 1、已经支付0 未支付',
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `address` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '收货人详细地址',
  `tel` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '收货人电话',
  `addtime` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '下单时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `addtime`(`addtime`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '定单' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jx_order
-- ----------------------------
INSERT INTO `jx_order` VALUES (20, 1, 2100.00, 1, '张', '花果山', '1532545641', 1568775403);
INSERT INTO `jx_order` VALUES (30, 1, 900.00, 1, '测试', '白云山', '1532545641', 1568856840);
INSERT INTO `jx_order` VALUES (29, 1, 600.00, 1, '阿萨德', '白云山', '10000', 1568796526);

-- ----------------------------
-- Table structure for jx_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `jx_order_goods`;
CREATE TABLE `jx_order_goods`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `order_id` int(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '定单Id',
  `goods_id` int(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '商品Id',
  `goods_attr_ids` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '商品属性Id',
  `price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '商品的价格',
  `goods_count` int(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '购买数量',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE,
  INDEX `goods_id`(`goods_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '定单商品' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jx_order_goods
-- ----------------------------
INSERT INTO `jx_order_goods` VALUES (16, 20, 1, '5,9', 300.00, 5);
INSERT INTO `jx_order_goods` VALUES (29, 30, 1, '5,9', 300.00, 3);
INSERT INTO `jx_order_goods` VALUES (28, 29, 1, '5,9', 300.00, 2);

-- ----------------------------
-- Table structure for jx_role
-- ----------------------------
DROP TABLE IF EXISTS `jx_role`;
CREATE TABLE `jx_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_role
-- ----------------------------
INSERT INTO `jx_role` VALUES (1, '超级管理员');
INSERT INTO `jx_role` VALUES (2, '分类管理员');
INSERT INTO `jx_role` VALUES (3, '商品管理员');

-- ----------------------------
-- Table structure for jx_role_rule
-- ----------------------------
DROP TABLE IF EXISTS `jx_role_rule`;
CREATE TABLE `jx_role_rule`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT 0 COMMENT '角色ID',
  `rule_id` int(11) NOT NULL DEFAULT 0 COMMENT '权限ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_role_rule
-- ----------------------------
INSERT INTO `jx_role_rule` VALUES (1, 3, 1);
INSERT INTO `jx_role_rule` VALUES (2, 3, 2);
INSERT INTO `jx_role_rule` VALUES (3, 3, 3);
INSERT INTO `jx_role_rule` VALUES (4, 3, 4);
INSERT INTO `jx_role_rule` VALUES (5, 3, 5);
INSERT INTO `jx_role_rule` VALUES (6, 3, 6);
INSERT INTO `jx_role_rule` VALUES (7, 3, 7);
INSERT INTO `jx_role_rule` VALUES (8, 3, 8);
INSERT INTO `jx_role_rule` VALUES (9, 2, 9);
INSERT INTO `jx_role_rule` VALUES (10, 2, 10);
INSERT INTO `jx_role_rule` VALUES (11, 2, 11);

-- ----------------------------
-- Table structure for jx_rule
-- ----------------------------
DROP TABLE IF EXISTS `jx_rule`;
CREATE TABLE `jx_rule`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '权限名称',
  `module_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模型名称',
  `controller_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '控制器名称',
  `action_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '方法名称',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '上级权限ID 0表示顶级权限',
  `is_show` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否导航菜单显示1  显示 0 不显示',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_rule
-- ----------------------------
INSERT INTO `jx_rule` VALUES (1, '商品管理', 'admin', 'goods', '#', 0, 1);
INSERT INTO `jx_rule` VALUES (2, '商品列表', 'admin', 'goods', 'index', 1, 1);
INSERT INTO `jx_rule` VALUES (3, '商品删除', 'admin', 'goods', 'dels', 1, 0);
INSERT INTO `jx_rule` VALUES (4, '商品添加', 'admin', 'goods', 'add', 1, 1);
INSERT INTO `jx_rule` VALUES (5, '商品编辑', 'admin', 'goods', 'edit', 1, 0);
INSERT INTO `jx_rule` VALUES (6, '商品回收站', 'admin', 'goods', 'trash', 1, 1);
INSERT INTO `jx_rule` VALUES (7, '商品还原', 'admin', 'goods', 'recover', 1, 0);
INSERT INTO `jx_rule` VALUES (8, '商品彻底删除', 'admin', 'goods', 'remove', 1, 0);
INSERT INTO `jx_rule` VALUES (9, '分类管理', 'admin', 'category', '#', 0, 1);
INSERT INTO `jx_rule` VALUES (10, '添加分类', 'admin', 'category', 'add', 9, 1);
INSERT INTO `jx_rule` VALUES (11, '分类列表', 'admin', 'category', 'index', 9, 1);

-- ----------------------------
-- Table structure for jx_type
-- ----------------------------
DROP TABLE IF EXISTS `jx_type`;
CREATE TABLE `jx_type`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '类型名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_type
-- ----------------------------
INSERT INTO `jx_type` VALUES (1, '手机');
INSERT INTO `jx_type` VALUES (2, '电脑');

-- ----------------------------
-- Table structure for jx_user
-- ----------------------------
DROP TABLE IF EXISTS `jx_user`;
CREATE TABLE `jx_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `salt` char(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '盐',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of jx_user
-- ----------------------------
INSERT INTO `jx_user` VALUES (1, 'admin', '889cc821cb8b9da786ee2dde662f476c', '458950');

SET FOREIGN_KEY_CHECKS = 1;
