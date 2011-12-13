-- phpMyAdmin SQL Dump
-- version 2.7.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Nov 09, 2006 at 09:05 AM
-- Server version: 4.1.13
-- PHP Version: 5.0.4
-- 
-- Database: `clander`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `{DBPREFIX}blogdata`
-- 

DROP TABLE IF EXISTS `{DBPREFIX}blogdata`;
CREATE TABLE `{DBPREFIX}blogdata` (
  `uid` int(255) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `blog_path` varchar(255) NOT NULL default '',
  `user` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `{DBPREFIX}blogdata`
-- 

INSERT INTO `{DBPREFIX}blogdata` (`uid`, `name`, `blog_path`, `user`, `url`) VALUES (1, 'Chris Lander''s test S9Y installation', '/home/clander/public_html/blog', 'clander', 'http://localhost/~clander/blog');

-- --------------------------------------------------------

-- 
-- Table structure for table `{DBPREFIX}templates`
-- 

DROP TABLE IF EXISTS `{DBPREFIX}templates`;
CREATE TABLE `{DBPREFIX}templates` (
  `id` int(255) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` varchar(255) default NULL,
  `template` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `{DBPREFIX}templates`
-- 

INSERT INTO `{DBPREFIX}templates` (`id`, `name`, `description`, `template`) VALUES (1, 'Apache', 'Suggested S9Y Apache configuration', '# {TPLDESC}\r\n#\r\n# Author: Chris Lander <clander@labbs.com>\r\n#\r\n# Last updated: 13th August 2006\r\n#\r\n# Created with {S9YCONF}\r\n#\r\n# {NOW}\r\n\r\n#\r\n# {BLOGNAME}\r\n#\r\n<Directory "{BLOGPATH}">\r\n AllowOverride All\r\n php_value include_path ".:{LIBDIR}:{LIBDIR}/{S9YDIR}:{LIBDIR}/{S9YDIR}/bundled-libs/:{BLOGPATH}/"\r\n php_admin_value open_basedir "{LIBDIR}:{LIBDIR}/{S9YDIR}:{BLOGPATH}/:/usr/bin/"\r\n php_admin_value post_max_size "10M"\r\n php_admin_value upload_max_filesize "10M"\r\n</Directory>'),
(2, 'Bash', 'S9Y shared install BASH script', '#!/bin/bash\r\n#\r\n# {TPLDESC}\r\n#\r\n# Author: Chris Lander <clander@labbs.com>\r\n#\r\n# Last updated: 13th August 2006\r\n#\r\n# Created with {S9YCONF}\r\n#\r\n# {NOW}\r\n\r\n#\r\n# {BLOGNAME}\r\n#\r\ncp -r {LIBDIR}/{S9YDIR}/deployment/* {BLOGPATH}\r\nln -s -d {LIBDIR}/{S9YDIR}/templates {BLOGPATH}/templates\r\nln -s -d {LIBDIR}/{S9YDIR}/htmlarea {BLOGPATH}/htmlarea\r\n#cp -r {LIBDIR}/{S9YDIR}/templates {BLOGPATH}/\r\n#cp -r {LIBDIR}/{S9YDIR}/htmlarea {BLOGPATH}/\r\n{SUDO} chown -R {BLOGUSER}:{WWWGROUP} {BLOGPATH}\r\n{SUDO} chown -R {BLOGUSER}:{WWWGROUP} {BLOGPATH}/*\r\n{SUDO} chmod u+rwx,g+rwx {BLOGPATH}\r\n{SUDO} chmod u+rwx,g+rwx {BLOGPATH}/{templates_c,uploads,archives}\r\n{SUDO} chown {WWWUSER}:{WWWGROUP} {BLOGPATH}/serendipity_config_local.inc.php\r\n{SUDO} chmod u+rwx,g-rwx,o-rwx {BLOGPATH}/serendipity_config_local.inc.php'),
(3, 'Copyright', 'An example of a copyright statement being used', 'S9Y_Conf is a tool to assist with the configuration and management of Serendipity installations\r\n\r\n{COPYRIGHT}');

-- --------------------------------------------------------

-- 
-- Table structure for table `{DBPREFIX}templatevars`
-- 

DROP TABLE IF EXISTS `{DBPREFIX}templatevars`;
CREATE TABLE `{DBPREFIX}templatevars` (
  `id` int(255) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `{DBPREFIX}templatevars`
-- 

INSERT INTO `{DBPREFIX}templatevars` (`id`, `name`, `value`) VALUES (1, 'SUDO', 'sudo -H -p ''Enter SuperUser Password: '''),
(2, 'LIBDIR', '/usr/local/lib'),
(3, 'S9YDIR', 's9y'),
(4, 'WWWGROUP', 'www'),
(5, 'WWWUSER', 'wwwrun'),
(6, 'COPYRIGHT', '&amp;copy; {YEAR1} - {YEAR2} LABBS Web Services'),
(7, 'YEAR1', '2006'),
(8, 'YEAR2', '2007');
