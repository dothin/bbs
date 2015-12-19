-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-12-19 15:38:05
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bbs`
--

-- --------------------------------------------------------

--
-- 表的结构 `bbs_article`
--

CREATE TABLE IF NOT EXISTS `bbs_article` (
  `bbs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '帖子id',
  `bbs_reid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '主题id',
  `bbs_username` varchar(20) NOT NULL COMMENT '发帖人',
  `bbs_type` tinyint(2) unsigned NOT NULL COMMENT '帖子类型',
  `bbs_title` varchar(40) NOT NULL COMMENT '帖子标题',
  `bbs_content` text NOT NULL COMMENT '帖子内容',
  `bbs_readcount` mediumint(8) unsigned NOT NULL COMMENT '阅读量',
  `bbs_commentcount` mediumint(8) unsigned NOT NULL COMMENT '评论量',
  `bbs_nice` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '精华帖',
  `bbs_last_modify_date` datetime NOT NULL COMMENT '最后修改时间',
  `bbs_date` datetime NOT NULL COMMENT '发帖时间',
  PRIMARY KEY (`bbs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- 转存表中的数据 `bbs_article`
--

INSERT INTO `bbs_article` (`bbs_id`, `bbs_reid`, `bbs_username`, `bbs_type`, `bbs_title`, `bbs_content`, `bbs_readcount`, `bbs_commentcount`, `bbs_nice`, `bbs_last_modify_date`, `bbs_date`) VALUES
(2, 0, '石昊', 7, '你好石昊', '你好石昊你好石昊你好石昊你好石昊你好石昊你好石昊', 1, 0, 0, '0000-00-00 00:00:00', '2015-12-14 21:08:01'),
(3, 0, '石昊', 8, '我是荒天帝', '我是石昊我是荒天帝，你是谁', 2, 0, 0, '0000-00-00 00:00:00', '2015-12-14 21:10:14'),
(4, 0, '石昊', 8, '我是荒天帝，你是谁', '李克强主持的上合总理会有啥讲究？\r\n探营世界互联网大会：乌镇一日街拍见闻  互联网大会专题\r\n银联发布官方移动支付 能否成功反击支付宝们\r\n银联或牵手Apple Pay  很难打败第三方支付  银联线下渠道有优势\r\n北京高院：薄谷开来与刘志军已被减刑至无期\r\n黄光裕获得两次改造积极分子 被建议再减刑一年\r\n天津港爆炸调查：官商勾连行为脱缰等是根源\r\n江苏全境遭雾霾袭城 官方:北方污染输送为主因\r\n环保部：一钢独大或一煤独大是华北空气污染主因\r\n中国第16集团军新规：亲兄弟禁分到同一战车', 5, 0, 0, '0000-00-00 00:00:00', '2015-12-14 21:50:53'),
(5, 0, '石昊', 1, '发帖测试功能', '[size=24]字体大小[/size]\r\n[b]加粗[/b]\r\n[i]倾斜[/i]\r\n[u]下划线[/u]\r\n[s]删除线[/s]\r\n[color=#808000]颜色[/color]\r\n[url]http://www.baidu.com[/url]\r\n[email]1286513426@qq.com[/email][img]emoji/2/1.gif[/img]\r\n[flash]http://player.youku.com/player.php/sid/XMTQxMjAxMjg0NA==/v.swf[/flash]', 36, 0, 0, '0000-00-00 00:00:00', '2015-12-14 22:02:26'),
(6, 0, '石昊', 2, '我是叶凡，我是叶天帝，你是石昊？', '我是叶凡，我是叶天帝，你是石昊？我是叶凡，我是叶天帝，你是石昊？[b]我是叶凡，我是叶天帝，你是石昊？我是叶凡，我是叶天帝，你是石昊？[/b][color=#f00]我是叶凡，我是叶天帝，你是石昊？我是叶凡，我是叶天帝，你是石昊？[/color][img]emoji/3/5.gif[/img][img]emoji/2/6.gif[/img][img]emoji/1/11.gif[/img]', 7, 0, 0, '0000-00-00 00:00:00', '2015-12-14 22:29:28'),
(7, 0, '石昊', 4, '我我是叶天帝是叶凡，你是石昊？', '我我是叶天帝是叶凡我我是叶天帝是叶凡我我是叶天帝是叶凡我我是叶天帝是叶凡我我是叶天帝是叶凡我我是叶天帝是叶凡[img]emoji/1/2.gif[/img][img]emoji/3/1.gif[/img][img]emoji/1/7.gif[/img][color=#f00]我我是叶天帝是叶凡我我是叶天帝是叶凡我我是叶天帝是叶凡我我是叶天帝是叶凡我我是叶[/color]', 256, 15, 1, '2015-12-15 17:19:40', '2015-12-14 22:30:23'),
(8, 0, '石昊', 1, '很大发大水发大厦很大送货单等哈', '很大发大水发大厦很大送货单等哈很大发大水发大厦很大送货单等哈很大发大水发大厦很大送货单等哈', 39, 0, 0, '0000-00-00 00:00:00', '2015-12-14 22:30:44'),
(9, 0, '石昊', 1, 'rerererererererererererererere', 'rererererererererererererererererererererererererererererererererererererererererererererererererere[img]emoji/2/2.gif[/img]', 28, 2, 0, '0000-00-00 00:00:00', '2015-12-14 22:31:02'),
(15, 7, '路飞', 1, '我我是叶天帝是叶凡，你是石昊？', 'fdasfdsaf', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 00:18:40'),
(16, 7, '路飞', 1, '我我是叶天帝是叶凡，你是石昊？', '我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？[img]emoji/3/2.gif[/img][img]emoji/2/2.gif[/img][img]emoji/1/6.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 00:19:46'),
(17, 7, '波波', 1, '我我是叶天帝是叶凡，你是石昊？', '我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？[img]emoji/3/1.gif[/img][img]emoji/2/2.gif[/img][img]emoji/3/6.gif[/img][img]emoji/3/5.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 00:21:02'),
(18, 7, '波波', 1, '我我是叶天帝是叶凡，你是石昊？', '我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？[img]emoji/2/2.gif[/img][img]emoji/2/6.gif[/img][img]emoji/2/7.gif[/img][img]emoji/1/7.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 00:21:18'),
(19, 7, '佐助', 1, '我我是叶天帝是叶凡，你是石昊？', '我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？[img]emoji/1/1.gif[/img][img]emoji/1/2.gif[/img][img]emoji/1/3.gif[/img][img]emoji/1/11.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 00:22:52'),
(20, 7, '佐助', 1, '我我是叶天帝是叶凡，你是石昊？', '我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？[img]emoji/1/6.gif[/img][img]emoji/1/8.gif[/img][img]emoji/1/10.gif[/img]我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 00:23:11'),
(21, 7, '石日天', 1, '我我是叶天帝是叶凡，你是石昊？', '我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 00:23:43'),
(22, 7, '石日天', 1, '我我是叶天帝是叶凡，你是石昊？', '我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？[img]emoji/2/6.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 00:23:52'),
(23, 7, '索罗', 1, '我我是叶天帝是叶凡，你是石昊？', '我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 00:24:27'),
(24, 7, '索罗', 1, '我我是叶天帝是叶凡，你是石昊？', '我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？我我是叶天帝是叶凡，你是石昊？[img]emoji/2/6.gif[/img][img]emoji/1/6.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 00:24:36'),
(25, 9, '石昊', 1, 'rerererererererererererererere', 'fdasfdsafdsa', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 13:23:33'),
(26, 9, '石昊', 1, 'rerererererererererererererere', 'fdasfdsa', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 13:51:48'),
(27, 7, '石昊', 1, '我我是叶天帝是叶凡，你是石昊？', 'fdsafdsafdsa', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 13:54:05'),
(28, 0, '石日天', 7, '我是石日天', '[img]emoji/3/2.gif[/img][img]emoji/2/1.gif[/img]我是石日天我是石日天我是石日天我是石日天', 22, 2, 0, '0000-00-00 00:00:00', '2015-12-15 16:24:27'),
(29, 28, '石昊', 7, '我是石日天', '我是石日天我是石日天我是石日天我是石日天[img]emoji/2/2.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 16:24:44'),
(30, 28, '石昊', 7, '我是石日天', '我是石日天我是石日天我是石日天我是石日天[img]emoji/2/2.gif[/img][color=#f60]我是石日天我是石日天我是石日天我是石日天[/color]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 16:27:02'),
(31, 7, '石日天', 1, '我我是叶天帝是叶凡，你是石昊？', 'hehehehe[img]emoji/3/2.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 17:16:24'),
(32, 7, '石昊', 1, '回复9楼的石日天', '回复9楼的石日天回复9楼的石日天[img]emoji/2/2.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 18:06:29'),
(33, 7, '石昊', 1, '回复楼主石昊', '楼主你好[img]emoji/1/7.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 18:21:35'),
(34, 0, '石日天', 7, '我是石日天，你是谁', '我是石日天，你是谁我是石日天，你是谁[img]emoji/2/2.gif[/img][color=#396]我是石日天，你是谁[/color]', 1, 0, 0, '0000-00-00 00:00:00', '2015-12-15 18:24:13'),
(35, 0, '索罗', 8, '我是索罗', '[img]emoji/2/1.gif[/img]我是索罗我是索罗我是索罗我是索罗我是索罗[img]emoji/1/2.gif[/img]', 1, 0, 0, '0000-00-00 00:00:00', '2015-12-15 18:24:58'),
(36, 0, '索罗', 1, '我是索罗', '[img]emoji/3/2.gif[/img]发顺丰多撒谎单阿范德萨发的', 1, 0, 0, '0000-00-00 00:00:00', '2015-12-15 19:33:49'),
(37, 0, '土匪', 1, '我是土匪', '[img]emoji/2/2.gif[/img]我是土匪', 3, 1, 0, '0000-00-00 00:00:00', '2015-12-15 19:35:46'),
(38, 0, '土匪', 3, '我是土匪我是土匪我是土匪', '我是土匪我是土匪我是土匪我是土匪我是土匪[img]emoji/2/1.gif[/img][img]emoji/1/2.gif[/img][img]emoji/1/2.gif[/img][img]emoji/1/7.gif[/img]', 21, 3, 1, '2015-12-19 20:34:59', '2015-12-15 19:37:14'),
(39, 38, '石昊', 2, '我是土匪我是土匪我是土匪', '我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪[img]emoji/3/6.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 19:38:21'),
(40, 7, '石昊', 1, '回复3楼的路飞', 'woshinini[img]emoji/3/2.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 20:17:25'),
(41, 0, '叶天帝', 7, '我是叶凡', '[color=#396]我是叶凡我是叶凡我是叶凡我是叶凡我是叶凡[/color]', 5, 2, 0, '0000-00-00 00:00:00', '2015-12-15 20:25:52'),
(42, 38, '石昊', 2, '我是土匪我是土匪我是土匪', '我是石昊，我是荒天帝我是石昊，我是荒天帝我是石昊，我是荒天帝[img]emoji/2/2.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 20:29:40'),
(43, 38, '石昊', 2, '我是土匪我是土匪我是土匪', '我是石昊，我是荒天帝我是石昊，我是荒天帝我是石昊，我是荒天帝[img]emoji/3/6.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 20:30:18'),
(44, 41, '石昊', 7, '我是叶凡', '我是石昊我是石昊[img]emoji/2/3.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 20:39:21'),
(45, 41, '石昊', 7, '回复楼主叶天帝', '我是石昊我是石昊', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 20:39:53'),
(46, 37, '石昊', 1, '我是土匪', '我是土匪我是土匪我是土匪我是土匪[img]emoji/2/2.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 20:47:31'),
(47, 0, '石昊', 7, '我是土匪我是土匪', '[img]emoji/2/2.gif[/img]我是土匪我是土匪我是土匪我是土匪我是土匪', 3, 1, 0, '0000-00-00 00:00:00', '2015-12-15 20:47:48'),
(48, 0, '石昊', 1, '我是土匪我是土匪我是土匪我是土匪', '我是土匪我是土匪我是土匪[img]emoji/2/2.gif[/img][img]emoji/3/2.gif[/img]', 35, 4, 1, '0000-00-00 00:00:00', '2015-12-15 20:48:49'),
(49, 48, '叶天帝', 1, '我是土匪我是土匪我是土匪我是土匪', '我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪[img]emoji/3/6.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 20:53:45'),
(50, 48, '叶天帝', 1, '我是土匪我是土匪我是土匪我是土匪', '我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪我是土匪[img]emoji/2/2.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 20:54:16'),
(51, 48, '石昊', 1, '回复楼主石昊', 'fdasfdasfdsafdsa', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 23:26:07'),
(52, 48, '石昊', 1, '回复楼主石昊', 'fdasfdsa', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 23:27:16'),
(53, 47, '石昊', 7, '回复楼主石昊', 'fdsafdsa', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-15 23:30:38'),
(54, 0, '石昊', 8, '测试', '[img]emoji/2/1.gif[/img][img]emoji/2/1.gif[/img][img]emoji/2/1.gif[/img][img]emoji/2/1.gif[/img]', 21, 2, 0, '0000-00-00 00:00:00', '2015-12-17 22:46:14'),
(55, 54, '石日天', 8, '测试', '发大水发大厦', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-17 23:34:06'),
(56, 54, '石日天', 8, '测试', '佛挡杀佛', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-17 23:37:48'),
(57, 0, '石日天', 1, 'fdafdsafd', '范德萨范德萨范德萨[img]emoji/2/1.gif[/img]', 12, 1, 0, '0000-00-00 00:00:00', '2015-12-17 23:43:06'),
(58, 0, '石昊', 1, 'fdasfdsaf', 'dsafdsafdfdsafdsa', 22, 2, 0, '0000-00-00 00:00:00', '2015-12-17 23:46:06'),
(59, 58, '石日天', 1, 'fdasfdsaf', '发大水发大厦', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-17 23:46:16'),
(60, 58, '石昊', 1, '回复2楼的石日天', 'fdasfdsafdsafdsafd', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-17 23:46:29'),
(61, 57, '石昊', 1, 'fdafdsafd', 'fdasf ', 0, 0, 0, '0000-00-00 00:00:00', '2015-12-17 23:48:09'),
(62, 0, '石日天', 1, '乐乐乐', '发大水发大厦[img]emoji/2/2.gif[/img]', 6, 0, 0, '0000-00-00 00:00:00', '2015-12-18 00:05:07');

-- --------------------------------------------------------

--
-- 表的结构 `bbs_flower`
--

CREATE TABLE IF NOT EXISTS `bbs_flower` (
  `bbs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '花朵id',
  `bbs_touser` varchar(20) NOT NULL COMMENT '收花方',
  `bbs_fromuser` varchar(20) NOT NULL COMMENT '送花方',
  `bbs_flower` mediumint(8) unsigned NOT NULL COMMENT '花朵数量',
  `bbs_content` varchar(200) NOT NULL COMMENT '送花备注',
  `bbs_date` datetime NOT NULL COMMENT '送花时间',
  PRIMARY KEY (`bbs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `bbs_flower`
--

INSERT INTO `bbs_flower` (`bbs_id`, `bbs_touser`, `bbs_fromuser`, `bbs_flower`, `bbs_content`, `bbs_date`) VALUES
(1, '索罗', '石昊', 20, '你好索罗', '2015-12-13 20:38:41'),
(2, '石昊', '路飞', 99, '石昊你好', '2015-12-13 20:40:38'),
(4, '石昊', '叶天帝', 7, '石昊你好我是叶凡', '2015-12-13 21:03:42'),
(5, '石昊', '叶天帝', 10, 'fdfd', '2015-12-13 21:18:51'),
(6, '石日天', '石昊', 20, 'fdfd', '2015-12-13 22:28:36'),
(7, '石昊', '路飞', 9, 'fdfdd', '2015-12-14 21:47:24'),
(8, '石昊[楼主]', '石日天', 1, '回答', '2015-12-17 23:40:38'),
(9, '石日天', '石日天', 1, '发大水发大厦', '2015-12-17 23:41:41'),
(10, '石日天', '石昊', 1, 'fdasfdsa', '2015-12-17 23:48:28'),
(11, '曹操', '石昊', 1, '发货的', '2015-12-18 19:32:47');

-- --------------------------------------------------------

--
-- 表的结构 `bbs_friend`
--

CREATE TABLE IF NOT EXISTS `bbs_friend` (
  `bbs_id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '好友id',
  `bbs_touser` varchar(20) NOT NULL COMMENT '被添加方',
  `bbs_fromuser` varchar(20) NOT NULL COMMENT '添加方',
  `bbs_content` varchar(200) NOT NULL COMMENT '验证信息',
  `bbs_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '添加状态',
  `bbs_date` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`bbs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `bbs_friend`
--

INSERT INTO `bbs_friend` (`bbs_id`, `bbs_touser`, `bbs_fromuser`, `bbs_content`, `bbs_state`, `bbs_date`) VALUES
(1, '灵儿', '路飞', '灵儿你好，我想和你交朋友', 0, '2015-12-09 18:43:32'),
(2, '火灵儿', '路飞', '火灵儿你好，我非常想和你交朋友', 0, '2015-12-09 19:04:59'),
(3, '石昊', '路飞', '是好事好', 1, '2015-12-09 19:09:21'),
(5, '灵儿', '石昊', '你好美女，我想和你交朋友！！', 0, '2015-12-09 19:20:36'),
(6, '云曦', '石昊', '你好美女，我想和你交朋友！！', 0, '2015-12-09 19:20:45'),
(7, '火灵儿', '石昊', '你好美女，我想和你交朋友！！', 0, '2015-12-09 19:20:53'),
(8, '索罗', '石昊', '你好美女，我想和你交朋友！！', 1, '2015-12-09 19:21:01'),
(9, '叶天帝', '石昊', '你好美女，我想和你交朋友！！', 0, '2015-12-09 19:21:20'),
(10, '石昊', '荒天帝', '你好美女，我想和你交朋友！！', 1, '2015-12-09 19:22:52'),
(12, '石昊', 'admins', '石昊你好，我们交个朋友好吗？？？？？？？？？？？', 1, '2015-12-09 20:05:28'),
(13, '波波', '石昊', '波波，我想和你交朋友', 1, '2015-12-10 12:34:16'),
(14, '石昊', 'dothin', '石昊，你好，我想和你家朋友', 0, '2015-12-10 12:43:56'),
(15, '石昊', '路飞飞', '石昊你好', 0, '2015-12-10 12:59:45'),
(16, '石日天', '石昊', '日天石你好', 1, '2015-12-13 22:28:09');

-- --------------------------------------------------------

--
-- 表的结构 `bbs_message`
--

CREATE TABLE IF NOT EXISTS `bbs_message` (
  `bbs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '私信id',
  `bbs_touser` varchar(20) NOT NULL COMMENT '收信人',
  `bbs_fromuser` varchar(20) NOT NULL COMMENT '发信人',
  `bbs_content` varchar(200) NOT NULL COMMENT '私信内容',
  `bbs_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '私信状态',
  `bbs_date` datetime NOT NULL COMMENT '发私信时间',
  PRIMARY KEY (`bbs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- 转存表中的数据 `bbs_message`
--

INSERT INTO `bbs_message` (`bbs_id`, `bbs_touser`, `bbs_fromuser`, `bbs_content`, `bbs_state`, `bbs_date`) VALUES
(5, '石昊', '火灵儿', '石昊你好，我们交个朋友吧！！！', 1, '2015-12-08 23:17:31'),
(7, '石昊', '荒天帝', '小石，我是荒天帝', 0, '2015-12-08 23:22:45'),
(8, '石昊', '荒天帝', '小石，我是荒天帝', 0, '2015-12-08 23:22:54'),
(9, '石昊', '荒天帝', '小石，我是荒天帝', 1, '2015-12-08 23:23:04'),
(10, '石昊', '云曦', '小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼小傻逼', 1, '2015-12-08 23:24:18'),
(13, '石昊', '路飞', '石昊你好，我是路飞', 1, '2015-12-08 23:26:33'),
(14, '石昊', '路飞', '石昊你好，我是路飞', 1, '2015-12-08 23:26:43'),
(23, '灵儿', '路飞', '灵儿你好，我想和你交朋友', 1, '2015-12-09 18:38:02'),
(24, '火灵儿', '路飞', '火灵儿你好，我非常想和你交朋友', 0, '2015-12-09 19:04:49'),
(25, 'dothin', '石昊', '111', 1, '2015-12-10 12:42:16'),
(26, '叶天帝', '石昊', '路飞你好', 1, '2015-12-13 20:57:17'),
(27, '路飞', '石昊', '路飞你好', 1, '2015-12-13 20:58:15'),
(28, '石昊', '叶天帝', '石昊你好', 0, '2015-12-13 21:18:22'),
(29, '石日天', '石昊', '石日天你好', 1, '2015-12-13 22:27:17'),
(30, '石昊', '路飞', 'nihoashiao', 0, '2015-12-14 21:46:56'),
(31, '土匪', '石昊', 'fdasfdsa', 0, '2015-12-15 23:19:42'),
(32, '土匪', '石昊', 'fdasfdsaf', 0, '2015-12-15 23:25:54'),
(33, '曹操', '石日天', '佛挡杀佛的', 0, '2015-12-17 22:56:50'),
(34, '艾斯', '石日天', '很大送货单', 0, '2015-12-17 23:32:38'),
(35, '石昊', '石日天', '很大发顺丰', 1, '2015-12-17 23:32:49'),
(36, '曹操', '石日天', '很大送货单', 0, '2015-12-17 23:33:56'),
(43, '石日天', '石昊', 'fdasfdsafds', 0, '2015-12-17 23:46:38'),
(44, '石昊', '石日天', 'fdfdfdfd', 0, '2015-12-17 23:54:45'),
(46, '石昊', '石日天', 'fdfdfdfdfd', 0, '2015-12-18 00:01:18'),
(47, '石日天', '石昊', 'fdfdfdfd', 0, '2015-12-18 00:01:31');

-- --------------------------------------------------------

--
-- 表的结构 `bbs_photo`
--

CREATE TABLE IF NOT EXISTS `bbs_photo` (
  `bbs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片id',
  `bbs_name` varchar(20) NOT NULL COMMENT '图片名称',
  `bbs_url` varchar(200) NOT NULL COMMENT '图片地址',
  `bbs_content` varchar(200) DEFAULT NULL COMMENT '图片描述',
  `bbs_sid` mediumint(8) unsigned NOT NULL COMMENT '图片所在目录',
  `bbs_username` varchar(20) NOT NULL COMMENT '上传者',
  `bbs_readcount` mediumint(8) NOT NULL DEFAULT '0' COMMENT '图片阅读量',
  `bbs_commentcount` mediumint(8) NOT NULL DEFAULT '0' COMMENT '图片评论量',
  `bbs_date` datetime NOT NULL COMMENT '图片创建时间',
  PRIMARY KEY (`bbs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `bbs_photo`
--

INSERT INTO `bbs_photo` (`bbs_id`, `bbs_name`, `bbs_url`, `bbs_content`, `bbs_sid`, `bbs_username`, `bbs_readcount`, `bbs_commentcount`, `bbs_date`) VALUES
(1, '哈达哈达', 'photo/1450455815/1450509252.png', '', 4, '石昊', 5, 0, '2015-12-19 15:14:29'),
(2, '图片一', 'photo/1450455815/1450509552.png', '', 4, '石昊', 13, 0, '2015-12-19 15:19:33'),
(3, '好打发多少', 'photo/1450501251/1450511593.jpg', '发送佛挡杀佛大发送佛挡杀佛大发送佛挡杀佛大发送佛挡杀佛大发送佛挡杀佛大', 8, '石昊', 1, 0, '2015-12-19 15:53:27'),
(4, '发送佛挡杀佛大发送佛挡杀佛大', 'photo/1450501251/1450511617.jpg', '发送佛挡杀佛大发送佛挡杀佛大发送佛挡杀佛大发送佛挡杀佛大发送佛挡杀佛大发送佛挡杀佛大', 8, '石昊', 0, 0, '2015-12-19 15:53:42'),
(5, '很大送货单', 'photo/1450501251/1450511637.jpg', '发送佛挡杀佛', 8, '石昊', 0, 0, '2015-12-19 15:54:01'),
(6, '讨论问题了', 'photo/1450501251/1450511651.jpg', '归属感和第三个', 8, '石昊', 1, 0, '2015-12-19 15:54:21'),
(7, '和股东会搞活动和', 'photo/1450501251/1450511670.jpg', ' 滑菇烩蛋黄滑菇烩蛋黄更', 8, '石昊', 5, 0, '2015-12-19 15:54:38'),
(8, '供货商的搞活动', 'photo/1450501251/1450511742.jpg', '搞活动帅哥范德萨', 8, '石昊', 5, 0, '2015-12-19 15:55:47'),
(9, '石昊石昊石昊', 'photo/1450501251/1450511803.jpg', '石昊石昊石昊石昊石昊', 8, '石昊', 10, 0, '2015-12-19 15:56:47'),
(10, '石昊石昊石昊石昊石昊', 'photo/1450501251/1450511815.jpg', '石昊石昊石昊石昊石昊石昊石昊石昊石昊石昊石昊石昊石昊', 8, '石昊', 12, 0, '2015-12-19 15:57:00'),
(11, '石日天石日天石日天', 'photo/1450501251/1450511828.jpg', '石日天石日天石日天石日天石日天', 8, '石昊', 11, 0, '2015-12-19 15:57:15'),
(12, '佛挡杀佛的', 'photo/1450501251/1450513248.jpg', '发送打范德萨', 8, '石昊', 83, 9, '2015-12-19 16:20:53'),
(14, '哈哈送货单上', 'photo/1450501251/1450522625.jpg', '哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上哈哈送货单上', 8, '石昊', 1, 0, '2015-12-19 18:57:16');

-- --------------------------------------------------------

--
-- 表的结构 `bbs_photo_comment`
--

CREATE TABLE IF NOT EXISTS `bbs_photo_comment` (
  `bbs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片评论ID',
  `bbs_title` varchar(20) NOT NULL COMMENT '评论标题',
  `bbs_content` text NOT NULL COMMENT '评论内容',
  `bbs_sid` mediumint(8) unsigned NOT NULL COMMENT '图片ID',
  `bbs_username` varchar(20) NOT NULL COMMENT '评论者',
  `bbs_date` datetime NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`bbs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `bbs_photo_comment`
--

INSERT INTO `bbs_photo_comment` (`bbs_id`, `bbs_title`, `bbs_content`, `bbs_sid`, `bbs_username`, `bbs_date`) VALUES
(1, '佛挡杀佛的', '[img]emoji/3/2.gif[/img][img]emoji/2/8.gif[/img]', 12, '石昊', '2015-12-19 17:06:54'),
(2, '佛挡杀佛的', '很大发顺丰的[img]emoji/3/1.gif[/img]', 12, '石昊', '2015-12-19 17:08:00'),
(3, '佛挡杀佛的', '[img]emoji/1/2.gif[/img][img]emoji/1/6.gif[/img]', 12, '石昊', '2015-12-19 17:08:08'),
(4, '佛挡杀佛的', '[img]emoji/2/6.gif[/img][img]emoji/2/1.gif[/img]', 12, '石昊', '2015-12-19 17:08:14'),
(5, '佛挡杀佛的', '[img]emoji/3/2.gif[/img][img]emoji/3/5.gif[/img]', 12, '石昊', '2015-12-19 17:08:20'),
(6, '佛挡杀佛的', '[img]emoji/1/7.gif[/img][img]emoji/1/11.gif[/img]', 12, '石昊', '2015-12-19 17:08:25'),
(7, '佛挡杀佛的', '[img]emoji/1/2.gif[/img][img]emoji/1/8.gif[/img]', 12, '石昊', '2015-12-19 17:08:31'),
(8, '佛挡杀佛的', '[img]emoji/3/2.gif[/img][img]emoji/1/2.gif[/img]', 12, '石昊', '2015-12-19 17:08:37'),
(9, '佛挡杀佛的', '[img]emoji/3/2.gif[/img][img]emoji/3/2.gif[/img][img]emoji/3/2.gif[/img]', 12, '石日天', '2015-12-19 17:21:56');

-- --------------------------------------------------------

--
-- 表的结构 `bbs_photo_dir`
--

CREATE TABLE IF NOT EXISTS `bbs_photo_dir` (
  `bbs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'dirID',
  `bbs_name` varchar(20) NOT NULL COMMENT '相册目录名',
  `bbs_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '相册类型',
  `bbs_password` char(40) DEFAULT NULL COMMENT '相册密码',
  `bbs_content` varchar(200) DEFAULT NULL COMMENT '相册描述',
  `bbs_cover` varchar(200) DEFAULT NULL COMMENT '相册封面',
  `bbs_dir` varchar(200) NOT NULL COMMENT '相册的物理地址',
  `bbs_date` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`bbs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `bbs_photo_dir`
--

INSERT INTO `bbs_photo_dir` (`bbs_id`, `bbs_name`, `bbs_type`, `bbs_password`, `bbs_content`, `bbs_cover`, `bbs_dir`, `bbs_date`) VALUES
(2, '游戏宣传', 1, '7c4a8d09ca3762af61e59520943dc26494f8941b', '游戏宣传游戏宣传游戏宣传', 'images/photo/photo (5).jpg', 'photo/1450455655', '2015-12-19 00:20:55'),
(4, '诱惑', 0, NULL, '诱惑', 'images/photo/photo (10).jpg', 'photo/1450455815', '2015-12-19 00:23:35'),
(8, '波波', 1, '7c4a8d09ca3762af61e59520943dc26494f8941b', '波波', 'images/photo/photo (1).jpg', 'photo/1450501251', '2015-12-19 13:00:51');

-- --------------------------------------------------------

--
-- 表的结构 `bbs_system`
--

CREATE TABLE IF NOT EXISTS `bbs_system` (
  `bbs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `bbs_webname` varchar(20) NOT NULL COMMENT '网站名称',
  `bbs_article_num` varchar(20) NOT NULL DEFAULT '0' COMMENT '首页最新主题分页数',
  `bbs_blog_num` varchar(20) NOT NULL DEFAULT '0' COMMENT '博友分页数',
  `bbs_photo_num` varchar(20) NOT NULL DEFAULT '0' COMMENT '相册分页数',
  `bbs_hot_num` varchar(20) NOT NULL DEFAULT '0' COMMENT '首页主题排行列表数',
  `bbs_newuser_num` varchar(20) NOT NULL DEFAULT '0' COMMENT '首页新晋会员列表数',
  `bbs_skin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '网站皮肤',
  `bbs_string` text NOT NULL COMMENT '网站敏感字符串过滤',
  `bbs_post_time` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发帖限制间隔时间',
  `bbs_repost_time` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '回帖间隔时间限制',
  `bbs_code` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用验证码',
  `bbs_register` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用注册功能',
  `bbs_last_modify_date` datetime NOT NULL COMMENT '最后修改时间',
  `bbs_modify_user` varchar(20) DEFAULT NULL COMMENT '最后修改人',
  PRIMARY KEY (`bbs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `bbs_system`
--

INSERT INTO `bbs_system` (`bbs_id`, `bbs_webname`, `bbs_article_num`, `bbs_blog_num`, `bbs_photo_num`, `bbs_hot_num`, `bbs_newuser_num`, `bbs_skin`, `bbs_string`, `bbs_post_time`, `bbs_repost_time`, `bbs_code`, `bbs_register`, `bbs_last_modify_date`, `bbs_modify_user`) VALUES
(1, '毕业设计--bbs', '10', '12', '4', '10', '5', 1, '傻逼|日龙包', 60, 30, 0, 1, '2015-12-19 16:14:31', '石昊');

-- --------------------------------------------------------

--
-- 表的结构 `bbs_users`
--

CREATE TABLE IF NOT EXISTS `bbs_users` (
  `bbs_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户自动编号',
  `bbs_uniqid` char(40) NOT NULL COMMENT '验证身份的唯一标识符',
  `bbs_active` char(40) NOT NULL COMMENT '激活登录的唯一标识符',
  `bbs_username` varchar(20) NOT NULL COMMENT '用户名',
  `bbs_password` char(40) NOT NULL COMMENT '密码',
  `bbs_question` varchar(20) NOT NULL COMMENT '密码提示',
  `bbs_answer` char(40) NOT NULL COMMENT '密码回答',
  `bbs_sex` char(1) NOT NULL COMMENT '性别',
  `bbs_photo` varchar(30) NOT NULL COMMENT '头像',
  `bbs_level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '会员等级',
  `bbs_email` varchar(40) NOT NULL COMMENT '邮箱',
  `bbs_qq` varchar(10) DEFAULT NULL COMMENT 'QQ',
  `bbs_url` varchar(40) DEFAULT NULL COMMENT '个人主页地址',
  `bbs_switch` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '个性签名开关',
  `bbs_signature` varchar(200) DEFAULT NULL COMMENT '个性签名内容',
  `bbs_post_time` varchar(20) DEFAULT '0' COMMENT '发帖时间戳',
  `bbs_repost_time` varchar(20) NOT NULL DEFAULT '0' COMMENT '回帖时间戳',
  `bbs_reg_time` datetime NOT NULL COMMENT '注册时间',
  `bbs_last_time` datetime NOT NULL COMMENT '最后登录时间',
  `bbs_last_ip` varchar(20) NOT NULL COMMENT '最后登录的IP',
  `bbs_login_count` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  PRIMARY KEY (`bbs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户信息表' AUTO_INCREMENT=58 ;

--
-- 转存表中的数据 `bbs_users`
--

INSERT INTO `bbs_users` (`bbs_id`, `bbs_uniqid`, `bbs_active`, `bbs_username`, `bbs_password`, `bbs_question`, `bbs_answer`, `bbs_sex`, `bbs_photo`, `bbs_level`, `bbs_email`, `bbs_qq`, `bbs_url`, `bbs_switch`, `bbs_signature`, `bbs_post_time`, `bbs_repost_time`, `bbs_reg_time`, `bbs_last_time`, `bbs_last_ip`, `bbs_login_count`) VALUES
(1, '2496826aa72b5ddb242bb2f1c51619d942be8fba', '', '石昊', 'b216fd63e5f3a5ef423bbe9852426a51f7486ac6', '石昊', 'f35324f1c2398e6d197c2ddcd4c9de369d1a9ff4', '男', 'images/photo/photo (2).jpg', 1, '123456789@qq.com', '45645633', 'http://www.globcn.com', 1, '我是石昊，我是荒天帝', '1450367166', '1450367289', '2015-12-06 14:58:06', '2015-12-19 18:24:38', '127.0.0.1', 43),
(33, 'df1b620362eaa3c0aa77761a380da117498f94c0', '', '叶凡', 'f475e7dc81e05984be070af842846137464c6d1b', '叶凡', 'c01b75e6393e2bf0c104112b889ffe585084336e', '男', 'images/photo/photo (1).jpg', 0, '432432@qq.com', '', '', 0, NULL, '0', '0', '2015-12-06 15:04:19', '2015-12-06 15:04:19', '127.0.0.1', 0),
(34, 'f32e1f4459618f7cf5e98bb01ed8d2f43c4fcefc', '', '月婵', '73406872c52a4736b6db379061332ffaae7bbf98', '月婵', '6309114c6e6048304a66ffe1409eb071281eef24', '女', 'images/photo/photo (1).jpg', 0, '432432@qq.com', '', '', 0, NULL, '0', '0', '2015-12-06 15:07:33', '2015-12-06 15:07:33', '127.0.0.1', 0),
(35, '33656fdc3635104d9890a67634e1283a6bdacc1e', '', '黑皇', 'a68cd2408f1cdf0b975e2f95b7b26a9f5ac7582a', '黑皇', 'eccea58dd05464a24f38fdeb4f9a2a32e1ed2f4a', '男', 'images/photo/photo (1).jpg', 0, '432432@qq.com', '434343433', '', 0, NULL, '0', '0', '2015-12-06 15:10:59', '2015-12-06 15:10:59', '127.0.0.1', 0),
(36, '483f427205694055af5a63370b57bb2ebf6866d2', '', '盖九幽', '62db389d12e4faf1722bdf6bf97000305a15c86a', '盖九幽', '293aeeaab00b01c289ae04feff0e0ea0b5430803', '男', 'images/photo/photo (1).jpg', 0, '432432@qq.com', '', '', 0, NULL, '0', '0', '2015-12-06 15:12:25', '2015-12-06 15:12:25', '127.0.0.1', 0),
(37, 'ab803ccc72191b72ec7af46685f40faa05fcde85', '', 'dothin', 'a66ef7d2a64476dc59e1696f8ed4fdc0f795f6e6', 'dothin是', 'a66ef7d2a64476dc59e1696f8ed4fdc0f795f6e6', '男', 'images/photo/photo (1).jpg', 0, '43143213@qq.com', '4343434343', '', 0, NULL, '0', '0', '2015-12-06 15:13:31', '2015-12-10 12:43:11', '127.0.0.1', 1),
(38, '9f0a47a7fca08d4b2fff9017823d62e32652b029', '', 'admins', 'c5a2dc3dcb24a8c9c790110e437b2a1960cba13e', 'admin', 'c5a2dc3dcb24a8c9c790110e437b2a1960cba13e', '男', 'images/photo/photo (1).jpg', 0, '1286513426@qq.com', '434343433', '', 0, NULL, '0', '0', '2015-12-06 15:14:52', '2015-12-09 20:05:03', '127.0.0.1', 1),
(39, '312880766303b4b533c5cdb61700e92464f41ab5', '', '好人', '8ba384caeaa499905c4d5d9d6e74cf96481679d0', '好人', 'ae716276b0e106c0cc7630214ea5102cf8a18c7a', '男', 'images/photo/photo (1).jpg', 0, '434334@qq.com', '', '', 0, NULL, '0', '0', '2015-12-06 15:15:40', '2015-12-06 15:15:40', '127.0.0.1', 0),
(40, '132d617ca899a8d759418188e24f41220b4b955e', '', '波波', '829db66445de16fc9447f8f7661d8e0b059b8721', '波波波', 'e2339b985a9dd727ed0a08d1d8253c01bbd98a15', '男', 'images/photo/photo (6).jpg', 0, '434334@qq.com', '', '', 0, NULL, '0', '0', '2015-12-06 16:16:27', '2015-12-15 00:20:45', '127.0.0.1', 2),
(41, '5454fff87813fbd6b881d96bd5b3af6dfda97614', '', '荒天帝', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '601f1889667efaebb33b8c12572835da3f027f78', '男', 'images/photo/photo (2).jpg', 0, '434334@qq.com', '', '', 0, NULL, '0', '0', '2015-12-06 20:06:30', '2015-12-09 19:22:41', '127.0.0.1', 2),
(42, '407646069b8d5aa5ff57dd88a4d1ef974639e650', '', '叶天帝', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'f0f8e902ca7a41c634c5c8247d4b94f2c9b351fb', '男', 'images/photo/photo (8).jpg', 0, '434334@qq.com', '', '', 0, NULL, '0', '1450184056', '2015-12-06 20:07:07', '2015-12-15 20:25:30', '127.0.0.1', 3),
(43, 'f4bd2db6e353b748659c5ac70ab93323ca45dfea', '', '路飞', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '79add1c86a6c628d05f9f0a976a55a53e5284884', '男', 'images/photo/photo (1).jpg', 0, '434334@qq.com', '', '', 0, NULL, '0', '0', '2015-12-06 20:07:55', '2015-12-15 00:08:12', '127.0.0.1', 7),
(44, '0cf128cb036a299ff6aca420a82504eb4c0fc1df', '', '索罗', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '12bedeb82f3290d9f672e48e4650cb57065520ad', '男', 'images/photo/photo (1).jpg', 0, '434334@qq.com', '', 'http://www.blogcn.com', 1, '我是索罗我是索罗我是索罗我是索罗我是索罗我是索罗我是索罗我是索罗', '0', '0', '2015-12-06 20:08:20', '2015-12-15 18:24:31', '127.0.0.1', 3),
(45, '09e440dd1d5bff51c9015210ea70310f3ad45284', '', '火灵儿', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '91dfde1d6e005e422f64a59776234f1f4c80b5e4', '女', 'images/photo/photo (3).jpg', 0, '434334@qq.com', '', '', 0, NULL, '0', '0', '2015-12-06 20:53:34', '2015-12-08 23:16:47', '127.0.0.1', 1),
(46, '80a5cee45862045d6546400f5c7e0d27a5078321', '', '云曦', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '女', 'images/photo/photo (11).jpg', 0, '434334@qq.com', '', '', 0, NULL, '0', '0', '2015-12-06 20:54:08', '2015-12-08 23:23:54', '127.0.0.1', 1),
(47, '29270ee5751766be9ea11a80e3a9735666fe60e6', '', '灵儿', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '女', 'images/photo/photo (12).jpg', 0, '434334@qq.com', '', '', 0, NULL, '0', '0', '2015-12-06 20:54:39', '2015-12-06 20:54:39', '127.0.0.1', 0),
(49, '59483db4ed4ff36429d0278c6c26999923d150e0', '', '艾斯', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', 'images/photo/photo (5).jpg', 0, '434334@qq.com', '', '', 0, NULL, '0', '0', '2015-12-10 13:07:16', '2015-12-10 13:07:16', '127.0.0.1', 0),
(50, '7739a065de886100f4eae2ec77188fe138ac2552', '', '土匪', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', 'images/photo/photo (10).jpg', 0, '434334@qq.com', '456456', 'http://www.baidu.com', 0, NULL, '0', '0', '2015-12-13 21:57:54', '2015-12-15 19:35:21', '127.0.0.1', 1),
(51, 'f95d39788bf8b4d312527f38874e09d4baf9368f', '', '佐助', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '男', 'images/photo/photo (4).jpg', 0, '432432@qq.com', '434343433', 'http://www.blogcn.com', 0, NULL, '0', '0', '2015-12-13 22:02:55', '2015-12-15 00:22:34', '127.0.0.1', 1),
(52, 'd1dd4af30cb2f814237c911381967cdcaff4cfcd', '', '石日天', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123', '51eac6b471a284d3341d8c0c63d0f1a286262a18', '男', 'images/photo/photo (2).jpg', 0, '432432@qq.com', '434343433', 'http://www.baidu.com', 0, NULL, '1450368307', '1450367176', '2015-12-13 22:25:39', '2015-12-19 19:16:01', '127.0.0.1', 19),
(53, '94b596a93c3dd12b7fde5ccaea7bfbe244985627', '', '赵日天', '7c4a8d09ca3762af61e59520943dc26494f8941b', '132', 'a8803f9ed887f2bdaff770a533cf2f251187a94f', '男', 'images/photo/photo (2).jpg', 0, '432432@qq.com', '434343433', 'http://www.baidu.com', 0, NULL, '0', '0', '2015-12-16 13:56:42', '2015-12-16 13:56:42', '127.0.0.1', 0),
(54, '60193876905de049ffff75b8fb6f5cdea8b3a36b', '', '曹操', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123', 'ffa1bf95b83ed878c70b031085efc971d074363c', '男', 'images/photo/photo (1).jpg', 0, '432432@qq.com', '', '', 0, NULL, '0', '0', '2015-12-17 00:07:07', '2015-12-17 00:07:07', '127.0.0.1', 0),
(55, '1e237792e8bd592974febe8cdb58423a4ee3169b', '', '摇光', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', 'images/photo/photo (1).jpg', 0, '43143213@qq.com', '', '', 0, NULL, '0', '0', '2015-12-18 12:50:42', '2015-12-18 12:50:42', '127.0.0.1', 0),
(57, 'db50c7ebf6b2a40c207d8b863cc5156c807e7ac2', '664b0e7b9a1e2376f2fd77ec7a26d67a3dad195c', '日天', '7c4a8d09ca3762af61e59520943dc26494f8941b', '发的发大厦', '2a96abcf2654e6c7419c65a883ddd1520cca1cc5', '男', 'images/photo/photo (1).jpg', 0, '434334@qq.com', '', '', 0, NULL, '0', '0', '2015-12-18 20:44:35', '2015-12-18 20:44:35', '127.0.0.1', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
