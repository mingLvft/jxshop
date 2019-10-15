/*
 Navicat Premium Data Transfer

 Source Server         : php_root
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : exam1

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 15/10/2019 14:35:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for em_admin
-- ----------------------------
DROP TABLE IF EXISTS `em_admin`;
CREATE TABLE `em_admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `tel` int(20) NOT NULL COMMENT '手机号',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态:1是,0否',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of em_admin
-- ----------------------------
INSERT INTO `em_admin` VALUES (4, 'admin', '123456', 2147483647, 1, '2019-10-08 21:21:11');
INSERT INTO `em_admin` VALUES (5, 'qwe', '123456', 2147483647, 1, '2019-10-09 08:39:47');
INSERT INTO `em_admin` VALUES (20, 'user', '123456', 153456454, 1, '2019-10-09 10:00:29');
INSERT INTO `em_admin` VALUES (30, 'li', '123456', 1234564, 1, '2019-10-09 10:10:29');
INSERT INTO `em_admin` VALUES (32, 'we', '123456', 123123, 1, '2019-10-09 10:24:57');
INSERT INTO `em_admin` VALUES (35, 'qq', '123456', 111, 1, '2019-10-10 08:42:30');

-- ----------------------------
-- Table structure for em_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `em_admin_role`;
CREATE TABLE `em_admin_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `role_id` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '角色ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of em_admin_role
-- ----------------------------
INSERT INTO `em_admin_role` VALUES (6, 20, '4');
INSERT INTO `em_admin_role` VALUES (11, 30, '4,5');
INSERT INTO `em_admin_role` VALUES (13, 32, '4,5');
INSERT INTO `em_admin_role` VALUES (16, 4, '1');
INSERT INTO `em_admin_role` VALUES (17, 5, '5');
INSERT INTO `em_admin_role` VALUES (18, 35, '4,5');

-- ----------------------------
-- Table structure for em_judge
-- ----------------------------
DROP TABLE IF EXISTS `em_judge`;
CREATE TABLE `em_judge`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id编号',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '题目',
  `right_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '正确答案',
  `status` smallint(4) NOT NULL DEFAULT 1 COMMENT '状态:1是,0否',
  `major_id` int(10) NOT NULL COMMENT '对应专业表的id',
  `subject_id` int(10) NOT NULL COMMENT '对应科目表的id',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '判断题' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of em_judge
-- ----------------------------
INSERT INTO `em_judge` VALUES (1, '这是题目 a', '1', 1, 4, 1, '2019-09-29 17:31:16');
INSERT INTO `em_judge` VALUES (2, '这是题目', '1', 1, 1, 2, '2019-09-29 17:31:57');
INSERT INTO `em_judge` VALUES (3, '这是题目', '1', 1, 3, 1, '2019-09-29 17:32:04');
INSERT INTO `em_judge` VALUES (4, '这是题目', '1', 0, 1, 1, '2019-09-29 17:32:23');
INSERT INTO `em_judge` VALUES (5, '啊   ', '0', 1, 1, 1, '2019-09-29 17:39:03');

-- ----------------------------
-- Table structure for em_major
-- ----------------------------
DROP TABLE IF EXISTS `em_major`;
CREATE TABLE `em_major`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id编号',
  `major_name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '专业名称',
  `status` smallint(4) NOT NULL DEFAULT 1 COMMENT '状态:1是,0否',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '专业表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of em_major
-- ----------------------------
INSERT INTO `em_major` VALUES (1, '软件开发', 1, '2019-09-28 16:41:52');
INSERT INTO `em_major` VALUES (2, 'ui设计', 1, '2019-09-28 20:44:41');
INSERT INTO `em_major` VALUES (3, '平面设计', 1, '2019-09-29 08:45:59');
INSERT INTO `em_major` VALUES (4, '电子商务', 1, '2019-09-29 08:46:00');

-- ----------------------------
-- Table structure for em_operation
-- ----------------------------
DROP TABLE IF EXISTS `em_operation`;
CREATE TABLE `em_operation`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id编号',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '题目',
  `status` smallint(4) NOT NULL DEFAULT 1 COMMENT '状态:1是,0否',
  `major_id` int(10) NOT NULL COMMENT '对应专业表的id',
  `subject_id` int(10) NOT NULL COMMENT '对应科目表的id',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '操作题' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of em_operation
-- ----------------------------
INSERT INTO `em_operation` VALUES (1, '操作题', 0, 1, 1, '2019-09-29 17:53:29');
INSERT INTO `em_operation` VALUES (2, '操作题', 1, 1, 1, '2019-09-29 17:53:39');
INSERT INTO `em_operation` VALUES (3, '操作题', 1, 2, 2, '2019-09-29 17:53:43');
INSERT INTO `em_operation` VALUES (4, '操作题 ', 1, 2, 2, '2019-09-29 17:53:49');

-- ----------------------------
-- Table structure for em_role
-- ----------------------------
DROP TABLE IF EXISTS `em_role`;
CREATE TABLE `em_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `role_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `content` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态:1是,0否',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of em_role
-- ----------------------------
INSERT INTO `em_role` VALUES (1, '超级管理员', '最高权限', 1, '2019-10-15 09:35:44');
INSERT INTO `em_role` VALUES (4, '学生管理员', '描述', 1, '2019-10-10 21:46:08');
INSERT INTO `em_role` VALUES (5, '分类管理员', '描述', 1, '2019-10-10 21:46:11');
INSERT INTO `em_role` VALUES (6, '专业管理员', '描述', 1, '2019-10-11 21:59:05');
INSERT INTO `em_role` VALUES (7, '商品管理员', '描述、。', 1, '2019-10-11 22:14:33');

-- ----------------------------
-- Table structure for em_role_rule
-- ----------------------------
DROP TABLE IF EXISTS `em_role_rule`;
CREATE TABLE `em_role_rule`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT 0 COMMENT '角色ID',
  `rule_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '权限ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of em_role_rule
-- ----------------------------
INSERT INTO `em_role_rule` VALUES (1, 6, '2,3,5');
INSERT INTO `em_role_rule` VALUES (2, 4, '3,4,5');
INSERT INTO `em_role_rule` VALUES (3, 5, '1,2,5');
INSERT INTO `em_role_rule` VALUES (4, 7, '1,3,4,5');

-- ----------------------------
-- Table structure for em_rule
-- ----------------------------
DROP TABLE IF EXISTS `em_rule`;
CREATE TABLE `em_rule`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '权限名称',
  `module_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模型名称',
  `controller_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '控制器名称',
  `action_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '方法名称',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '上级权限ID 0表示顶级权限',
  `is_show` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否导航菜单显示1  显示 0 不显示',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of em_rule
-- ----------------------------
INSERT INTO `em_rule` VALUES (1, '专业管理', 'admin', 'major', '#', 0, 1, '2019-10-10 22:38:11');
INSERT INTO `em_rule` VALUES (2, '专业添加', 'admin', 'major', 'add', 1, 1, '2019-10-10 22:51:37');
INSERT INTO `em_rule` VALUES (3, '专业编辑', 'admin', 'major', 'edit', 1, 1, '2019-10-10 22:52:11');
INSERT INTO `em_rule` VALUES (4, '专业删除', 'admin', 'major', 'del', 1, 1, '2019-10-11 08:41:45');
INSERT INTO `em_rule` VALUES (5, '专业列表', 'admin', 'major', 'index', 1, 1, '2019-10-15 10:05:55');

-- ----------------------------
-- Table structure for em_selection
-- ----------------------------
DROP TABLE IF EXISTS `em_selection`;
CREATE TABLE `em_selection`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id编号',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '题目',
  `A` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'A选项',
  `B` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'B选项',
  `C` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'C选项',
  `D` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'D选项',
  `right_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '正确答案',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态:1是,0否',
  `major_id` int(10) NOT NULL COMMENT '专业id',
  `subject_id` int(10) NOT NULL COMMENT '科目id',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '多选题' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of em_selection
-- ----------------------------
INSERT INTO `em_selection` VALUES (1, '这是题目  ', '选项', '选项', '选项', '选项', '答案', 1, 1, 1, '2019-09-28 11:33:55');
INSERT INTO `em_selection` VALUES (2, '的', '的', '的', '的', '的', '的', 1, 1, 1, '2019-09-28 15:28:35');
INSERT INTO `em_selection` VALUES (3, '阿萨德 ', '阿萨德', '阿萨德阿萨德阿三', '掉分速度', '斯蒂芬', '斯蒂芬', 0, 1, 2, '2019-09-28 16:04:46');
INSERT INTO `em_selection` VALUES (4, '多选题  ', '多选题', '多选题', '多选题', '多选题', '多选题', 1, 2, 3, '2019-09-29 15:27:47');

-- ----------------------------
-- Table structure for em_single
-- ----------------------------
DROP TABLE IF EXISTS `em_single`;
CREATE TABLE `em_single`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id编号',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '题目',
  `A` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'A选项',
  `B` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'B选项',
  `C` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'C选项',
  `D` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'D选项',
  `right_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '正确答案',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态:1是,0否',
  `major_id` int(10) NOT NULL COMMENT '专业id',
  `subject_id` int(10) NOT NULL COMMENT '科目id',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '单选题' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of em_single
-- ----------------------------
INSERT INTO `em_single` VALUES (1, '这是题目    ', '选项', '选项', '选项', '选项', '答案', 1, 2, 1, '2019-09-28 11:33:55');
INSERT INTO `em_single` VALUES (2, '的 ', '的', '的', '的', '的', '的', 1, 1, 2, '2019-09-28 15:28:35');
INSERT INTO `em_single` VALUES (3, '单选题', '单选题', '单选题', '单选题', '单选题', '单选题', 0, 2, 3, '2019-09-29 15:31:26');
INSERT INTO `em_single` VALUES (4, 'PHP考试题---单选题', '', '', '', '', '', 1, 2, 6, '2019-10-09 18:03:22');
INSERT INTO `em_single` VALUES (5, ' JavaScript脚本语言的前身是', 'Basic', 'Live Script', 'Oak', 'VBScript', 'B', 1, 2, 6, '2019-10-09 18:03:22');
INSERT INTO `em_single` VALUES (6, '使用CSS对文本进行修饰，若使文本闪烁，text-decoration的取值为', 'none', 'underline', 'overline', 'blink', 'D', 1, 2, 6, '2019-10-09 18:03:22');
INSERT INTO `em_single` VALUES (7, 'XML基于的标准是', 'HTML   ', 'MIME ', 'SGML', 'CGI', 'C', 1, 2, 6, '2019-10-09 18:03:22');
INSERT INTO `em_single` VALUES (8, '标记符title是放在标记符什么之间的', 'html与html ', 'head与head  ', 'body与body  ', 'head与body', 'B', 1, 2, 6, '2019-10-09 18:03:22');
INSERT INTO `em_single` VALUES (9, '＜img＞标记符中连接图片的参数是：', 'href  ', 'src', 'type', 'align', 'B', 1, 2, 6, '2019-10-09 18:03:22');
INSERT INTO `em_single` VALUES (10, ' JavaScript脚本语言的前身是', 'Basic', 'Live Script', 'Oak', 'VBScript', 'B', 1, 1, 1, '2019-10-10 14:37:16');
INSERT INTO `em_single` VALUES (11, '使用CSS对文本进行修饰，若使文本闪烁，text-decoration的取值为', 'none', 'underline', 'overline', 'blink', 'D', 1, 1, 1, '2019-10-10 14:37:16');
INSERT INTO `em_single` VALUES (12, 'XML基于的标准是', 'HTML   ', 'MIME ', 'SGML', 'CGI', 'C', 1, 1, 1, '2019-10-10 14:37:16');
INSERT INTO `em_single` VALUES (13, '标记符title是放在标记符什么之间的', 'html与html ', 'head与head  ', 'body与body  ', 'head与body', 'B', 1, 1, 1, '2019-10-10 14:37:16');
INSERT INTO `em_single` VALUES (14, '＜img＞标记符中连接图片的参数是：', 'href  ', 'src', 'type', 'align', 'B', 1, 1, 1, '2019-10-10 14:37:16');

-- ----------------------------
-- Table structure for em_students
-- ----------------------------
DROP TABLE IF EXISTS `em_students`;
CREATE TABLE `em_students`  (
  `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id编号',
  `id_card` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学生身份证',
  `username` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `sex` varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '性别',
  `password` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `tel` int(20) NOT NULL COMMENT '电话号码',
  `class_name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级',
  `class_teacher` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班主任',
  `status` smallint(4) NOT NULL DEFAULT 1 COMMENT '状态:1是,0否',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '学生表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of em_students
-- ----------------------------
INSERT INTO `em_students` VALUES (1, '123', '老李', '男', '123', 1000, '17软件3', '校长', 0, '2019-09-27 23:50:53');
INSERT INTO `em_students` VALUES (2, '1515121231151', '老狗', '女', '123456', 1000, '17软件3', '校长', 0, '2019-09-27 23:44:57');
INSERT INTO `em_students` VALUES (3, '5165564564', '老金', '男', '123456', 1000, '17软件3', '校长', 1, '2019-09-27 23:44:52');
INSERT INTO `em_students` VALUES (4, '132353453453', '阿三', '女', '123456', 1000, '17软件3', '校长', 1, '2019-09-28 00:16:24');
INSERT INTO `em_students` VALUES (5, '1561512315654', '阿长', '男', '123456', 1000, '17软件3', '校长', 1, '2019-09-28 00:15:42');
INSERT INTO `em_students` VALUES (6, '5103120123123', '老李', '男', '123456', 1000, '17软件3', '校长', 1, '2019-09-28 00:46:30');
INSERT INTO `em_students` VALUES (7, '1515121231151', '老狗', '男', '123456', 1000, '17软件3', '校长', 1, '2019-09-28 00:46:36');
INSERT INTO `em_students` VALUES (8, '12312425235', '玩儿是', '男', '123456', 1000, '17软件3', '校长', 1, '2019-09-28 00:53:33');
INSERT INTO `em_students` VALUES (9, '51013212312', '阿萨德', '男', '123456', 1000, '17软件3', '校长', 1, '2019-09-28 09:21:40');

-- ----------------------------
-- Table structure for em_subject
-- ----------------------------
DROP TABLE IF EXISTS `em_subject`;
CREATE TABLE `em_subject`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id编号',
  `subject_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '科目名称',
  `status` smallint(4) NOT NULL DEFAULT 1 COMMENT '状态:1是,0否',
  `major_id` int(10) NOT NULL COMMENT '关联专业表id',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '科目表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of em_subject
-- ----------------------------
INSERT INTO `em_subject` VALUES (1, '数学', 1, 1, '2019-09-29 08:55:16');
INSERT INTO `em_subject` VALUES (2, '英语', 1, 3, '2019-09-29 09:49:59');
INSERT INTO `em_subject` VALUES (3, '物理', 1, 2, '2019-09-29 09:54:46');
INSERT INTO `em_subject` VALUES (4, '化学', 1, 1, '2019-10-09 15:06:39');
INSERT INTO `em_subject` VALUES (5, '地理', 1, 4, '2019-10-09 15:59:11');
INSERT INTO `em_subject` VALUES (6, '数学', 1, 2, '2019-10-09 16:04:21');

SET FOREIGN_KEY_CHECKS = 1;
