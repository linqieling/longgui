CREATE TABLE IF NOT EXISTS `hd_msg_board_list` (
  `mb_id` int(11) NOT NULL AUTO_INCREMENT,
  `mpid` int(11) NOT NULL,
  `openid` varchar(64) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `content` text(0) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0：未回复/1:已回复',
  `dateline` int(10) NOT NULL,
  PRIMARY KEY (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `hd_msg_board_replie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` int(11) NOT NULL,
  `mpid` int(11) NOT NULL,
  `tuid` int(10) NOT NULL,
  `tname` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0：后台/1:用户(预留)',
  `content` text(0) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
