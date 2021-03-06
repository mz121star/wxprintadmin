
DROP TABLE IF EXISTS `wx_user`;
CREATE TABLE `wx_user` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` varchar(250) NOT NULL,
  `user_pw` varchar(250) NOT NULL,
  `user_status` enum('1','0') NOT NULL,
  `user_type` tinyint(3) unsigned NOT NULL default 3 COMMENT '用户类型，1是后台管理员',
  PRIMARY KEY (`id`),
  UNIQUE KEY user_id (user_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表';

INSERT INTO `wx_user` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '1', 1);


DROP TABLE IF EXISTS `wx_print`;
CREATE TABLE `wx_print` (
  `id` int(11) NOT NULL auto_increment,
  `print_name` varchar(250) NOT NULL,
  `print_msg` varchar(250) NOT NULL,
  `print_content` text NOT NULL,
  `print_imgcode` varchar(250) NOT NULL,
  `print_callbackurl` varchar(250) NOT NULL default 'http://print.wx.dlwebs.com/wx_sample.php',
  `print_token` varchar(250) NOT NULL default 'dlwebs',
  `print_type` enum('1','2') NOT NULL COMMENT '打印终端类型，1是横屏，2是竖屏',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='设备表';