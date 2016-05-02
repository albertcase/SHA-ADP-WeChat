DROP TABLE IF EXISTS `wechat_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mOrder` enum('0','1','2','3') DEFAULT '0',
  `subOrder` enum('0','1','2','3','4','5') DEFAULT '0',
  `menuName` varchar(80) NOT NULL,
  `event` varchar(50) NOT NULL,
  `eventKey` varchar(50) DEFAULT NULL,
  `eventUrl` varchar(255) DEFAULT NULL,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `eventkey` (`eventkey`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wechat_menu_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat_menu_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menuId` int(11) NOT NULL,
  `getMsgType` varchar(50) NOT NULL,
  `getContent` varchar(250) NOT NULL,
  `getEvent` varchar(100) NOT NULL,
  `getEventKey` varchar(255) NOT NULL,
  `getTicket` varchar(255) NOT NULL,
  `MsgType` varchar(50) NOT NULL,
  `Content` longtext NOT NULL,
  `MediaId` varchar(250) NOT NULL,
  `Title` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `PicUrl` varchar(255) NOT NULL,
  `Url` varchar(255) NOT NULL,
  `MusicURL` varchar(255) NOT NULL,
  `HQMusicUrl` varchar(255) NOT NULL,
  `ThumbMediaId` varchar(255) NOT NULL,
  `otherStr` varchar(255) NOT NULL,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wechat_getmsglog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat_getmsglog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL,
  `msgType` varchar(50) NOT NULL,
  `msgXml` longtext NOT NULL,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
