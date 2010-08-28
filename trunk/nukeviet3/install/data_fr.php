<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 31/05/2010, 00:36
 */

function nv_create_table_news ( $catid )
{
    global $db, $db_config;
    $db->sql_query( "SET SQL_QUOTE_SHOW_CREATE = 1" );
    $result = $db->sql_query( "SHOW CREATE TABLE `" . $db_config['prefix'] . "_fr_news_rows`" );
    $show = $db->sql_fetchrow( $result );
    $db->sql_freeresult( $result );
    $show = preg_replace( '/(KEY[^\(]+)(\([^\)]+\))[\s\r\n\t]+(USING BTREE)/i', '\\1\\3 \\2', $show[1] );
    $sql = preg_replace( '/(default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP|DEFAULT CHARSET=\w+|COLLATE=\w+|character set \w+|collate \w+|AUTO_INCREMENT=\w+)/i', ' \\1', $show );
    $sql = str_replace( $db_config['prefix'] . "_fr_news_rows", $db_config['prefix'] . "_fr_news_" . $catid, $sql );
    $db->sql_query( $sql );
}

$sql_create_table = array();
$sql_create_table[] = "TRUNCATE TABLE `" . $db_config['prefix'] . "_fr_modules`";
$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_fr_modules` (`title`, `module_file`, `module_data`, `custom_title`, `set_time`, `admin_file`, `theme`, `keywords`, `groups_view`, `in_menu`, `weight`, `submenu`, `act`, `admins`) VALUES
('about', 'about', 'about', 'À propos', 1276333182, 1, '', '', '0', 1, 1, 1, 1, ''), 
('news', 'news', 'news', 'News', 1270400000, 1, '', '', '0', 1, 2, 1, 1, ''), 
('users', 'users', 'users', 'Compte d&#039;utilisateur', 1274080277, 1, '', '', '0', 1, 7, 1, 1, ''), 
('contact', 'contact', 'contact', 'Contact', 1275351337, 1, '', '', '0', 1, 8, 1, 1, ''), 
('statistics', 'statistics', 'statistics', 'Statistiques', 1276520928, 0, '', '', '0', 1, 9, 0, 1, ''),
('banners', 'banners', 'banners', 'Publicité', 1270400000, 1, '', '', '0', 0, 5, 1, 1, ''), 
('search', 'search', 'search', 'Recherche', 1273474173, 0, '', '', '0', 0, 10, 0, 1, ''), 
('download', 'download', 'download', 'Télécharger', 1280638246, 1, '', '', '0', 1, 3, 1, 1, ''), 
('weblinks', 'weblinks', 'weblinks', 'Liens Webs', 1280638247, 1, '', '', '0', 1, 4, 1, 1, ''), 
('rss', 'rss', 'rss', 'Rss', 1280638250, 0, '', '', '0', 0, 11, 1, 1, ''), 
('voting', 'voting', 'voting', 'Sondage', 1280638417, 1, '', '', '0', 0, 6, 0, 1, '')";

$sql_create_table[] = "TRUNCATE TABLE `" . $db_config['prefix'] . "_fr_modfuncs`";
$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_fr_modfuncs` (`func_id`, `func_name`, `func_custom_name`, `in_module`, `show_func`, `in_submenu`, `subweight`, `layout`, `setting`) VALUES
(1, 'main', 'Main', 'about', 1, 0, 1, 'left-body-right', ''), 
(2, 'comment', 'Comment', 'news', 0, 0, 0, 'left-body-right', ''), 
(3, 'detail', 'Detail', 'news', 1, 0, 4, 'left-body-right', ''), 
(4, 'main', 'Main', 'news', 1, 0, 1, 'left-body-right', ''), 
(7, 'rating', 'Rating', 'news', 0, 0, 0, 'left-body-right', ''), 
(8, 'savefile', 'Savefile', 'news', 0, 0, 0, 'left-body-right', ''), 
(9, 'search', 'Search', 'news', 1, 0, 5, 'left-body-right', ''), 
(10, 'sendmail', 'Sendmail', 'news', 0, 0, 0, 'left-body-right', ''), 
(11, 'topic', 'Topic', 'news', 1, 0, 3, 'left-body-right', ''), 
(12, 'viewcat', 'Viewcat', 'news', 1, 0, 2, 'left-body-right', ''), 
(13, 'down', 'Down', 'download', 1, 0, 2, 'left-body-right', ''), 
(14, 'getcomment', 'Getcomment', 'download', 0, 0, 0, 'left-body-right', ''), 
(15, 'main', 'Main', 'download', 1, 0, 1, 'left-body-right', ''), 
(16, 'report', 'Report', 'download', 1, 0, 4, 'left-body-right', ''), 
(17, 'upload', 'Upload', 'download', 1, 0, 3, 'left-body-right', ''), 
(20, 'detail', 'Detail', 'weblinks', 1, 0, 3, 'left-body-right', ''), 
(21, 'link', 'Link', 'weblinks', 0, 0, 0, 'left-body-right', ''), 
(22, 'main', 'Main', 'weblinks', 1, 0, 1, 'left-body-right', ''), 
(23, 'reportlink', 'Reportlink', 'weblinks', 0, 0, 0, 'left-body-right', ''), 
(24, 'viewcat', 'Viewcat', 'weblinks', 1, 0, 2, 'left-body-right', ''), 
(25, 'visitlink', 'Visitlink', 'weblinks', 0, 0, 0, 'left-body-right', ''), 
(26, 'active', 'Active', 'users', 1, 0, 7, 'left-body-right', ''), 
(27, 'changepass', 'Changer mot de passe', 'users', 1, 1, 6, 'left-body-right', ''), 
(28, 'editinfo', 'Editinfo', 'users', 1, 0, 8, 'left-body-right', ''), 
(29, 'login', 'Se connecter', 'users', 1, 1, 2, 'left-body-right', ''), 
(30, 'logout', 'Logout', 'users', 1, 0, 3, 'left-body-right', ''), 
(31, 'lostactivelink', 'Lostactivelink', 'users', 1, 0, 9, 'left-body-right', ''), 
(32, 'lostpass', 'Mot de passe oublié?', 'users', 1, 1, 5, 'left-body-right', ''), 
(33, 'main', 'Main', 'users', 1, 0, 1, 'left-body-right', ''), 
(34, 'register', 'S\'inscrire', 'users', 1, 1, 4, 'left-body-right', ''), 
(35, 'main', 'Main', 'contact', 1, 0, 1, 'left-body-right', ''), 
(36, 'allbots', 'Par Moteur de recherche', 'statistics', 1, 1, 6, 'left-body', ''), 
(37, 'allbrowsers', 'Par Navigateur', 'statistics', 1, 1, 4, 'left-body', ''), 
(38, 'allcountries', 'Par Pays', 'statistics', 1, 1, 3, 'left-body', ''), 
(39, 'allos', 'Par Système d\'exploitation', 'statistics', 1, 1, 5, 'left-body', ''), 
(40, 'allreferers', 'Par Site', 'statistics', 1, 1, 2, 'left-body', ''), 
(41, 'main', 'Main', 'statistics', 1, 0, 1, 'left-body', ''), 
(42, 'referer', 'referer', 'statistics', 1, 0, 7, 'left-body', ''), 
(43, 'main', 'Main', 'voting', 0, 0, 0, 'left-body-right', ''), 
(44, 'result', 'Result', 'voting', 0, 0, 0, 'left-body-right', ''), 
(45, 'click', 'Click', 'banners', 0, 0, 0, 'left-body-right', ''), 
(46, 'main', 'Main', 'banners', 1, 0, 1, 'left-body-right', ''), 
(47, 'adv', 'Adv', 'search', 0, 0, 0, 'left-body-right', ''), 
(48, 'main', 'Main', 'search', 1, 0, 1, 'left-body-right', ''), 
(49, 'print', 'Print', 'news', 0, 0, 0, '', ''), 
(50, 'postcomment', 'Postcomment', 'news', 0, 0, 0, '', ''), 
(51, 'openid', 'OpenID', 'users', 1, 1, 6, 'left-body-right', ''), 
(54, 'main', 'Main', 'rss', 1, 0, 1, 'left-body-right', ''), 
(55, 'rss', 'Rss', 'news', 0, 0, 0, '', ''), 
(56, 'rss', 'Rss', 'download', 0, 0, 0, 'left-body-right', ''), 
(57, 'rss', 'Rss', 'weblinks', 0, 0, 0, 'left-body-right', '')";

$sql_create_table[] = "TRUNCATE TABLE `" . $db_config['prefix'] . "_fr_blocks`";
$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_fr_blocks` (`bid`, `groupbl`, `title`, `link`, `type`, `file_path`, `theme`, `template`, `position`, `exp_time`, `active`, `groups_view`, `module`, `all_func`, `func_id`, `weight`) VALUES
(1, 1, 'Menu', '', 'file', 'module.block_category.php', 'default', '', '[LEFT]', 0, '1', '0', 'news', 0, 4, 1), 
(2, 1, 'Menu', '', 'file', 'module.block_category.php', 'default', '', '[LEFT]', 0, '1', '0', 'news', 0, 12, 1), 
(3, 1, 'Menu', '', 'file', 'module.block_category.php', 'default', '', '[LEFT]', 0, '1', '0', 'news', 0, 11, 1), 
(4, 1, 'Menu', '', 'file', 'module.block_category.php', 'default', '', '[LEFT]', 0, '1', '0', 'news', 0, 3, 1), 
(5, 1, 'Menu', '', 'file', 'module.block_category.php', 'default', '', '[LEFT]', 0, '1', '0', 'news', 0, 9, 1), 
(6, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 1, 1), 
(7, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 46, 1), 
(8, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 35, 1), 
(9, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 15, 1), 
(12, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 13, 1), 
(13, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 17, 1), 
(14, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 16, 1), 
(15, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 4, 2), 
(16, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 12, 2), 
(17, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 11, 2), 
(18, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 3, 2), 
(19, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 9, 2), 
(20, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 48, 1), 
(21, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 41, 1), 
(22, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 40, 1), 
(23, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 38, 1), 
(24, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 37, 1), 
(25, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 39, 1), 
(26, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 36, 1), 
(27, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 42, 1), 
(28, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 33, 1), 
(29, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 29, 1), 
(30, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 30, 1), 
(31, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 34, 1), 
(32, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 32, 1), 
(33, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 27, 1), 
(34, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 26, 1), 
(35, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 28, 1), 
(36, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 31, 1), 
(37, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 22, 1), 
(38, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 24, 1), 
(39, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 20, 1), 
(40, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 1, 2), 
(41, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 46, 2), 
(42, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 35, 2), 
(43, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 15, 2), 
(46, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 13, 2), 
(47, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 17, 2), 
(48, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 16, 2), 
(49, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 4, 3), 
(50, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 12, 3), 
(51, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 11, 3), 
(52, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 3, 3), 
(53, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 9, 3), 
(54, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 48, 2), 
(55, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 41, 2), 
(56, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 40, 2), 
(57, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 38, 2), 
(58, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 37, 2), 
(59, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 39, 2), 
(60, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 36, 2), 
(61, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 42, 2), 
(62, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 33, 2), 
(63, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 29, 2), 
(64, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 30, 2), 
(65, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 34, 2), 
(66, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 32, 2), 
(67, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 27, 2), 
(68, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 26, 2), 
(69, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 28, 2), 
(70, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 31, 2), 
(71, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 22, 2), 
(72, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 24, 2), 
(73, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 20, 2), 
(74, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 1, 1), 
(75, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 46, 1), 
(76, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 35, 1), 
(77, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 15, 1), 
(80, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 13, 1), 
(81, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 17, 1), 
(82, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 16, 1), 
(83, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 4, 1), 
(84, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 12, 1), 
(85, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 11, 1), 
(86, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 3, 1), 
(87, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 9, 1), 
(88, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 48, 1), 
(89, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 41, 1), 
(90, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 40, 1), 
(91, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 38, 1), 
(92, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 37, 1), 
(93, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 39, 1), 
(94, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 36, 1), 
(95, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 42, 1), 
(96, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 33, 1), 
(97, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 29, 1), 
(98, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 30, 1), 
(99, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 34, 1), 
(100, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 32, 1), 
(101, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 27, 1), 
(102, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 26, 1), 
(103, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 28, 1), 
(104, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 31, 1), 
(105, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 22, 1), 
(106, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 24, 1), 
(107, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 20, 1), 
(108, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 1, 3), 
(109, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 46, 3), 
(110, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 35, 3), 
(111, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 15, 3), 
(114, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 13, 3), 
(115, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 17, 3), 
(116, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 16, 3), 
(117, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 4, 3), 
(118, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 12, 3), 
(119, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 11, 3), 
(120, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 3, 3), 
(121, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 9, 3), 
(122, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 48, 3), 
(123, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 41, 3), 
(124, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 40, 3), 
(125, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 38, 3), 
(126, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 37, 3), 
(127, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 39, 3), 
(128, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 36, 3), 
(129, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 42, 3), 
(130, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 33, 3), 
(131, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 29, 3), 
(132, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 30, 3), 
(133, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 34, 3), 
(134, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 32, 3), 
(135, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 27, 3), 
(136, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 26, 3), 
(137, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 28, 3), 
(138, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 31, 3), 
(139, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 22, 3), 
(140, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 24, 3), 
(141, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 20, 3), 
(142, 6, 'Hot news', '', 'file', 'module.block_headline.php', 'default', 'no_title', '[TOP]', 0, '1', '0', 'news', 0, 4, 1), 
(143, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 1, 1), 
(144, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 46, 1), 
(145, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 35, 1), 
(146, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 15, 1), 
(149, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 13, 1), 
(150, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 17, 1), 
(151, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 16, 1), 
(152, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 4, 2), 
(153, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 12, 1), 
(154, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 11, 1), 
(155, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 3, 1), 
(156, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 9, 1), 
(157, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 48, 1), 
(158, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 41, 1), 
(159, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 40, 1), 
(160, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 38, 1), 
(161, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 37, 1), 
(162, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 39, 1), 
(163, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 36, 1), 
(164, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 42, 1), 
(165, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 33, 1), 
(166, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 29, 1), 
(167, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 30, 1), 
(168, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 34, 1), 
(169, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 32, 1), 
(170, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 27, 1), 
(171, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 26, 1), 
(172, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 28, 1), 
(173, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 31, 1), 
(174, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 22, 1), 
(175, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 24, 1), 
(176, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 20, 1), 
(177, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 1, 2), 
(178, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 46, 2), 
(179, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 35, 2), 
(180, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 15, 2), 
(183, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 13, 2), 
(184, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 17, 2), 
(185, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 16, 2), 
(186, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 4, 2), 
(187, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 12, 2), 
(188, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 11, 2), 
(189, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 3, 2), 
(190, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 9, 2), 
(191, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 48, 2), 
(192, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 41, 2), 
(193, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 40, 2), 
(194, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 38, 2), 
(195, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 37, 2), 
(196, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 39, 2), 
(197, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 36, 2), 
(198, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 42, 2), 
(199, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 33, 2), 
(200, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 29, 2), 
(201, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 30, 2), 
(202, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 34, 2), 
(203, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 32, 2), 
(204, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 27, 2), 
(205, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 26, 2), 
(206, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 28, 2), 
(207, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 31, 2), 
(208, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 22, 2), 
(209, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 24, 2), 
(210, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 20, 3), 
(212, 2, 'Statistiques', '', 'file', 'global.counter.php', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 51, 1), 
(214, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 51, 2), 
(216, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 51, 1), 
(218, 5, 'Sondage', '', 'file', 'global.voting.php', 'default', '', '[RIGHT]', 0, '1', '0', 'global', 1, 51, 2), 
(220, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 51, 1), 
(222, 8, 'Identification', '', 'file', 'global.login.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 51, 3), 
(223, 4, 'À Propos', '', 'file', 'global.about.php', 'default', 'orange', '[RIGHT]', 0, '1', '0', 'global', 1, 54, 1), 
(224, 7, 'Publicité du centre', '', 'banner', '1', 'default', 'no_title', '[TOP]', 0, '1', '0', '', 1, 54, 1), 
(225, 3, 'Publicité à côté', '', 'banner', '2', 'default', '', '[LEFT]', 0, '1', '0', 'global', 1, 54, 1)";

$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_fr_news_cat` VALUES
(1, 0, 'News', 'News', '', '', '', 1, 1, 0, 'viewcat_page_new', 3, '5,6,7', 1, 3, '', '', 1280644983, 1280927178, 1306644983, 0, ''), 
(2, 0, 'Produits', 'Produits', '', '', '', 2, 5, 0, 'viewcat_page_new', 0, '', 1, 3, '', '', 1280644996, 1280644996, 1306644996, 0, ''), 
(3, 0, 'Partenaires', 'Partenaires', '', '', '', 3, 6, 0, 'viewcat_page_new', 0, '', 1, 3, '', '', 1280645023, 1280645023, 1306645023, 0, ''), 
(4, 0, 'Recrutement', 'Recruitement', '', '', '', 4, 7, 0, 'viewcat_page_new', 0, '', 1, 3, '', '', 1280649352, 1280649900, 1306649352, 0, ''), 
(5, 1, 'News Interne', 'News-Interne', '', '', '', 1, 2, 1, 'viewcat_page_new', 0, '', 1, 3, '', '', 1280927318, 1280927318, 1306927318, 0, ''), 
(6, 1, 'Nouvelles Technologies', 'Nouvelles-Technologies', '', '', '', 2, 3, 1, 'viewcat_page_new', 0, '', 1, 3, '', '', 1280927364, 1280927364, 1306927364, 0, ''), 
(7, 1, 'Espace presse', 'Espace-presse', '', '', '', 3, 4, 1, 'viewcat_page_new', 0, '', 1, 3, '', '', 1280928740, 1280928740, 1306928740, 0, '')";

$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_fr_news_rows` VALUES
(1, '1,2', 0, 1, '', 0, 1280645699, 1280751776, 1, 1280645640, 0, 2, 'Nukeviet 3.0', 'Nukeviet-3-0', 'NukeViet 3 est une nouvelle génération de Système de Gestion de Contenu développée par les Vietnamiens. Pour la première fois au Vietnam, un noyau de Open Source ouverte est investi professionnelement en financement, en ressources humaines et en temps. Le résultat est que 100% de ligne de code de NukeViet est écrit entièrement neuf. Nukeviet 3.0 utilise XHTML, CSS et jQuery avec Xtemplate permettant une application souple de Ajax, même au niveau de noyau.', '2010_05/nukeviet3.jpg', '', 'thumb/nukeviet3.jpg|block/nukeviet3.jpg', 1, '<p> Profiter les fruits de Open Source, mais chaque ligne de code de NukeViet est écrit manuellement. NukeViet 3 n&#039;utilise aucune plateforme. Cela signifie que Nukeviet 3 est complètement indépendant dans son développemnt. Il est très facile à lire, à comprendre le code de NukeViet pour programmer tout seul si vous avez les connaissances de base sur PHP et MySQL. NukeViet 3.0 est complètement ouvert et facile à apprendre pour tous ceux qui veulent étudier le code de NukeViet.</p><p> Hériter la simplicité de Nukeviet mais NukeViet 3 n&#039;oublie pas de se renouveller. Le système de Nukeviet 3 supporte le multi-noyau du module. Nous appelons cela la technologie de virtualisation de module. Cette technologie permet aux utilisateurs de créer automatiquement de milliers de modules sans toucher une seule ligne de code. Le module né de cette technologie est appelé module virtuel. Il est cloné à partir de n&#039;importe quel module du système de NukeViet si ce module-ci permet la création des modules virtuels.</p><p> NukeViet 3 prend en charge l&#039;installation automatique de modules, de blocks, de thèmes dans la section d&#039;administration, les utilisateurs peuvent installer le module sans faire de tâches complexes. NukeViet 3.0 permet également le paquetage des modules pour partager aux autres utilisateus.</p><p> Le multi-langage de NukeViet 3 est parfait avec le multi-langage de l&#039;interface et celui de données. NukeViet 3.0 supporte aux administrateurs de créer facilement de nouvelles langues pour le site. Le paquetage des fichiers de langue est également supporté pour faciliter la contribution du travai à la communauté.</p>', 0, 1, 2, 1, '0|0', 1, 1, 1, 2, 0, 0, 'de, est'), 
(2, '2', 0, 1, '', 0, 1280645876, 1280751372, 1, 1280645820, 0, 2, 'NukeViet', 'NukeViet', 'NukeViet est un système de gestion de contenu open source. Les utilisateurs l’appellent habituellement Portail parce qu&#039;il est capable d&#039;intégrer plusieurs applications sur le Web. Nguyễn Anh Tú, un ex-étudiant vietnamien en Russie, avec la communauté a développé NukeViet en une application purement vietnamienne en basant sur PHP-Nuke.', '2010_05/1243187502.jpg', '', 'thumb/1243187502.jpg|block/1243187502.jpg', 1, '<p> Similaire à PHP-Nuke, NukeViet est écrit en langage PHP et utilise la base de données MySQL, permet aux utilisateurs de publier, de gérer facilement leur contenu sur Internet ou Intranet.</p><p> <strong>* Fonctionnalités de base de NukeViet: </strong></p><p> - News: Gestion d’articles: créer les articles multi-niveau, générer la page d’impression, permettre le téléchargement, les commentaires.</p><p> -&nbsp; Download: Gestion de téléchargement des fichier</p><p> - Vote: sondage</p><p> - Contact</p><p> -&nbsp; Search: Rechercher</p><p> -&nbsp; RSS</p><p> <strong>* Caractéristiques: </strong></p><p> - Supporter le multi-langage</p><p> - Permettre le changement de l’interface (theme)</p><p> - Monter le pare-feu pour limiter DDOS ...</p><p> Nukeviet est utilisé dans de nombreux sites Web, de sites personnels aux sites professionnels. Il offre de nombreux services et applications grâce à la capacité d&#039;accroître la fonctionnalité en installant des modules, blocks additionnels ... Cependant, Nukeviet est utilisé principalement pour les sites d’actualités vietnamiens par ce que son module News conforme bien aux exigences et habitudes des Vietnamiens. Il est très facile d’installer, de gérer Nukeviet, même avec les débutants, il est donc un système favorable des amateurs.</p><p> NukeViet est open source, et totalement gratuit pour tout de monde de tous les pays. Toutefois, les Vietnamiens sont les utilisateurs principales en raison des caractéristiques de la code source (provenant de PHP-Nuke) et de la politique des développeurs &quot;Système de Portail Pour les Vietnamiens&quot;.</p>', 0, 1, 2, 1, '0|0', 1, 1, 1, 3, 0, 0, 'de, en'), 
(3, '3', 0, 1, '', 0, 1280646202, 1280751407, 1, 1280646180, 0, 2, 'VINADES', 'VINADES', 'Pour professionaliser la publication de NukeViet,  l&#039;administration de NukeViet a décidé de créer une société spécialisant la  gestion de NukeViet avec la raison sociale en vietnamien “Công ty cổ phần Phát triển Nguồn mở Việt Nam”, en anglais &quot;VIET NAM OPEN SOURCE DEVELOPMENT JOINT STOCK COMPANY&quot; et en abrégé VINADES.,JSC.', '2010_05/nangly.jpg', '', 'thumb/nangly.jpg|block/nangly.jpg', 1, '<p> Cette société est ouverte officiellement au&nbsp; 25-2-2010 avec le bureau à&nbsp; 67B/35 Khương Hạ, Khương Đình, Thanh Xuân, Hà Nội. Son but est de développer et de diffuser NukeViet au Vietnam.<br  /> <br  /> D&#039;après M. Nguyễn Anh Tú, président de VINADES, cette société développera le source de NukeViet sous forme open source, professionnel, et totalement gratuit selon l&#039;esprit mondial de open source.<br  /> <br  /> NukeViet est un système de gestion de contenu open source (Open Source Content Management System) purement vietnamien développé à la base de PHP-Nuke et base de données MySQL. Les utilisateurs l&#039;appellent habituellement Portail par ce qu&#039;ils puissent intégrer de multiples applications permettant la publication et la gestion facile de contenu sur l&#039;internet ou sur l&#039;intranet.</p><p> NukeViet peut fournir plusieurs services et appliations grace aux modules, blocks... L&#039;installation, la gestion de NukeViet 3 est très facile,&nbsp; même avec les débutants.</p><p> Depuis quelques années, NukeViet est devenu une application Open Source tres familière de la communauté informatique du Vietnam. Nukeviet est utilisé dans presque toutes les domaines, de l&#039;actualité, de la commerce électronique, de site personnel aux site professionel.</p><p> Pour avoir les details plus amples sur NukeViet, veuillez consulter le site http://nukeviet.vn.</p>', 0, 1, 2, 1, '0|0', 1, 1, 1, 3, 0, 0, 'de nukeviet, de'), 
(4, '4', 0, 1, '', 0, 1280650419, 1280751748, 1, 1280650380, 0, 2, 'Recrutement et la formation des enseignants', 'Recrutement-et-la-formation-des-enseignants', 'A l’issue d’une série de consultations avec les organisations représentatives des personnels de l’éducation nationale et de l’enseignement supérieur sur la réforme du recrutement et de la formation des enseignants, le ministre de l’Éducation nationale et la ministre de l’Enseignement supérieur et de la Recherche apportent plusieurs éléments d’information complémentaires.', '2010_05/hoptac.jpg', '', 'thumb/hoptac.jpg|block/hoptac.jpg', 1, '<p> Ils précisent, notamment, les modalités concrètes de concertation qui conduiront à la mise en place de la réforme définitive au cours de l’année 2010/2011. Le processus de concertation avec les organisations représentatives reposera notamment sur trois groupes de travail ch@rgés d’étudier :<br  /> <br  /> &nbsp;&nbsp;&nbsp; * Les concours de recrutement<br  /> &nbsp;&nbsp;&nbsp; * Le cadrage des masters et leur articulation avec les concours<br  /> &nbsp;&nbsp;&nbsp; * L’organisation et le contenu de la période de formation continuée pendant l’année de fonctionnaire stagiaire à l’issue du concours<br  /> <br  /> Une commission de concertation sur la réforme du recrutement et de la formation sera également mise en place avec des acteurs universitaires. Le recteur Marois et le président Filatre en assureront la coprésidence. Ils feront très rapidement des propositions aux ministres sur la composition et le fonctionnement de cette commission qui consultera régulièrement les organisations représentatives.<br  /> <br  /> Les ministres ont également détaillé les conditions de mise en oeuvre du processus de mastérisation de la formation des enseignants et des conseillers principaux d’éducation (C.P.E.), qui sera engagé dès l’année prochaine.<br  /> <br  /> Ils confirment que, pour la session 2010, les contenus des concours resteront en l’état. Par ailleurs, pour s’inscrire aux concours de la session 2010, les étudiants devront :<br  /> <br  /> &nbsp;&nbsp;&nbsp; * Soit déjà être titulaires d’un master ou inscrits en M2 à la rentrée universitaire 2009 ;<br  /> &nbsp;&nbsp;&nbsp; * Soit, à titre exceptionnel et dérogatoire, pour la seule session 2010 des concours :<br  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - avoir été présents aux épreuves d’admissibilité de la session 2009<br  /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - ou bien, être inscrits en M1 dans une composante universitaire à la rentrée 2009.<br  /> <br  /> Pour l’année transitoire 2009 - 2010 l’inscription en I.U.F.M. vaudra également inscription en M1 par convention avec les universités afin de favoriser le processus de mastérisation. En cas de réussite à un concours de la session 2010, le bénéfice du concours sera garanti pendant un an à ces candidats inscrits en M1. Ils seront recrutés comme enseignant stagiaire pour la rentrée scolaire 2011 sous réserve de l’obtention de leur M2 à l’issue de l’année universitaire 2010-2011.<br  /> <br  /> Dès septembre 2009, des stages de pratique accompagnée ou en responsabilité rémunérés seront mis en place afin d’engager le processus de préprofessionnalisation lié à la mastérisation.<br  /> <br  /> Dès la prochaine rentrée universitaire, les étudiants se destinant au métier d’enseignant pourront également bénéficier d’un dispositif d’aides complémentaires mis en oeuvre par le ministère de l’Éducation Nationale.<br  /> <br  /> A la rentrée 2010, un tiers de l’obligation de service des nouveaux enseignants, recrutés lors de la session 2010 des concours, sera consacré à une formation continue renforcée, prenant la forme d’un tutorat et d’une formation universitaire à visée disciplinaire ou professionnelle.<br  /> <br  /> Enfin, la discussion sur la revalorisation du salaire des nouveaux enseignants sera conduite en parallèle pour être applicable aux lauréats des concours de la session 2010.</p>', 0, 1, 2, 1, '0|0', 1, 1, 1, 4, 0, 0, 'et de, de, la, et')";

$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_fr_news_block_cat` (`bid`, `adddefault`, `number`, `title`, `alias`, `image`, `thumbnail`, `description`, `weight`, `keywords`, `add_time`, `edit_time`) VALUES
(1, 0, 4, 'Populairs', 'Populairs', '', '', 'Block Populairs', 1, '', 1279945710, 1279956943),
(2, 1, 4, 'Récents', 'Recents', '', '', 'Block Récents', 2, '', 1279945725, 1279956445)";

$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_fr_news_block` (`bid`, `id`, `weight`) VALUES
(1, 2, 2),
(1, 1, 1)";

$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_fr_voting` VALUES
(1, 'Qu&#039;est ce que NukeViet 3.0?', 1, 1, 0, '0', 1275318563, 0, 1)";

$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_fr_voting_rows` VALUES
(1, 1, 'Une code source de web tout neuve', 0), 
(2, 1, 'Open source, libre et gratuit', 0), 
(3, 1, 'Utilise xHTML, CSS et supporte Ajax', 0), 
(4, 1, 'Toutes ces réponses', 1)";

$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_fr_about` VALUES
(1, 'Qu’est ce que Nukeviet?', 'Qu-est-ce-que-Nukeviet', '<p> NukeViet est un système de gestion de contenu open source. Les utilisateurs l’appellent habituellement Portail parce qu&#039;il est capable d&#039;intégrer plusieurs applications sur le Web. Nguyễn Anh Tú, un ex-étudiant vietnamien en Russie, avec la communauté a développé NukeViet en une application purement vietnamienne en basant sur PHP-Nuke. Similaire à PHP-Nuke, NukeViet est écrit en langage PHP et utilise la base de données MySQL, permet aux utilisateurs de publier, de gérer facilement leur contenu sur Internet ou Intranet.<br  />  </p><p> <strong>* Fonctionnalités de base de NukeViet: </strong></p><p> - News: Gestion d’articles: créer les articles multi-niveau, générer la page d’impression, permettre le téléchargement, les commentaires.</p><p> -&nbsp; Download: Gestion de téléchargement des fichier</p><p> - Vote: sondage</p><p> - Contact</p><p> -&nbsp; Search: Rechercher</p><p> -&nbsp; RSS</p><p> <strong>* Caractéristiques: </strong></p><p> - Supporter le multi-langage</p><p> - Permettre le changement de l’interface (theme)</p><p> - Monter le pare-feu pour limiter DDOS ...</p><p> Nukeviet est utilisé dans de nombreux sites Web, de sites personnels aux sites professionnels. Il offre de nombreux services et applications grâce à la capacité d&#039;accroître la fonctionnalité en installant des modules, blocks additionnels ... Cependant, Nukeviet est utilisé principalement pour les sites d’actualités vietnamiens par ce que son module News conforme bien aux exigences et habitudes des Vietnamiens. Il est très facile d’installer, de gérer Nukeviet, même avec les débutants, il est donc un système favorable des amateurs.</p><p> NukeViet est open source, et totalement gratuit pour tout de monde de tous les pays. Toutefois, les Vietnamiens sont les utilisateurs principales en raison des caractéristiques de la code source (provenant de PHP-Nuke) et de la politique des développeurs &quot;Système de Portail Pour les Vietnamiens&quot;.</p>', 1, 1, 1280634933, 1280634933, 1), 
(2, 'Introduction de NukeViet 3', 'Introduction-de-NukeViet-3', '<p> NukeViet 3 est une nouvelle génération de Système de Gestion de Contenu développée par les Vietnamiens. Pour la première fois au Vietnam, un noyau de Open Source ouverte est investi professionnelement en financement, en ressources humaines et en temps. Le résultat est que 100% de ligne de code de NukeViet est écrit entièrement neuf. Nukeviet 3.0 utilise XHTML, CSS et jQuery avec Xtemplate permettant une application souple de Ajax, même au niveau de noyau.</p><p> Profiter les fruits de Open Source, mais chaque ligne de code de NukeViet est écrit manuellement. NukeViet 3 n&#039;utilise aucune plateforme. Cela signifie que Nukeviet 3 est complètement indépendant dans son développemnt. Il est très facile à lire, à comprendre le code de NukeViet pour programmer tout seul si vous avez les connaissances de base sur PHP et MySQL. NukeViet 3.0 est complètement ouvert et facile à apprendre pour tous ceux qui veulent étudier le code de NukeViet.</p><p> Hériter la simplicité de Nukeviet mais NukeViet 3 n&#039;oublie pas de se renouveller. Le système de Nukeviet 3 supporte le multi-noyau du module. Nous appelons cela la technologie de virtualisation de module. Cette technologie permet aux utilisateurs de créer automatiquement de milliers de modules sans toucher une seule ligne de code. Le module né de cette technologie est appelé module virtuel. Il est cloné à partir de n&#039;importe quel module du système de NukeViet si ce module-ci permet la création des modules virtuels.</p><p> NukeViet 3 prend en charge l&#039;installation automatique de modules, de blocks, de thèmes dans la section d&#039;administration, les utilisateurs peuvent installer le module sans faire de tâches complexes. NukeViet 3.0 permet également le paquetage des modules pour partager aux autres utilisateus.</p><p> Le multi-langage de NukeViet 3 est parfait avec le multi-langage de l&#039;interface et celui de données. NukeViet 3.0 supporte aux administrateurs de créer facilement de nouvelles langues pour le site. Le paquetage des fichiers de langue est également supporté pour faciliter la contribution du travai à la communauté.</p><p> L&#039;histoire de NukeViet sera encore très longue&nbsp; par ce qu’une variété de fonctionnalités avancées sont encore en cours d&#039;élaboration.</p><p> Utilisez et diffusez NukeViet 3 pour jouir les récents fruits de la technologies de web open source.</p><p> Enfin, NukeViet 3 est un cadeau que VINADES voudrait envoyer à la communauté pour remercier son soutient. NukeViet retourne maintenant à la communauté dans l’espoir à son développement continu.</p><p> Si vous intéressez à NukeViet, n’hésitez pas à nous joindre au Forum de NukeViet.Vn.</p>', 3, 1, 1280637520, 1280637520, 1), 
(3, 'Ouverture de VINADES', 'Ouverture-de-VINADES', '<p> Depuis quelques années, NukeViet est devenu une application Open Source tres familière de la communauté informatique du Vietnam. Étant donnée qu&#039;il n&#039;y a pas encore les activités officielles, Nukeviet est utilisé dans presque toutes les domaines, de l&#039;actualité, de la commerce électronique, de site personnel aux site professionle.<br  />  </p><p> Pour professionaliser la publication de NukeViet,&nbsp; l&#039;administration de NukeViet a décidé de créer une société spécialisant la&nbsp; gestion de NukeViet avec la raison sociale en vietnamien “Công ty cổ phần Phát triển Nguồn mở Việt Nam”, en anglais &quot;VIET NAM OPEN SOURCE DEVELOPMENT JOINT STOCK COMPANY&quot; et en abrégé VINADES.,JSC. Cette société est ouverte officiellement au&nbsp; 25-2-2010 avec le bureau à&nbsp; 67B/35 Khương Hạ, Khương Đình, Thanh Xuân, Hà Nội. Son but est de développer et de diffuser NukeViet au Vietnam.<br  /> <br  /> D&#039;après M. Nguyễn Anh Tú, président de VINADES, cette société développera le source de NukeViet sous forme open source, professionnel, et totalement gratuit selon l&#039;esprit mondial de open source.<br  /> <br  /> NukeViet est un système de gestion de contenu open source (Open Source Content Management System) purement vietnamien développé à la base de PHP-Nuke et base de données MySQL. Les utilisateurs l&#039;appellent habituellement Portail par ce qu&#039;ils puissent intégrer de multiples applications permettant la publication et la gestion facile de contenu sur l&#039;internet ou sur l&#039;intranet.</p><p> <br  /> NukeViet peut fournir plusieurs services et appliations grace aux modules, blocks... L&#039;installation, la gestion de NukeViet 3 est très facile,&nbsp; même avec les débutants.</p><p> Pour avoir les details plus amples sur NukeViet, veuillez consulter le site http://nukeviet.vn.</p>', 2, 1, 1280637944, 1280637944, 1)";

$disable_site_content = "Notre site est fermé temporairement pour la maintenance. Veuillez revenir plus tard. Merci!";
$copyright = "Veuillez citer le lien vers l&#039;article original si vous le reproduisez sur un autre site. Merci.";
$site_description = "NUKEVIET CMS 3.0 Developé par Vinades.,Jsc";

$sql_create_table[] = "UPDATE `" . $db_config['prefix'] . "_config` SET `config_value` =  " . $db->dbescape_string( $site_description ) . " WHERE `module` =  'global' AND `config_name` = 'site_description' AND `lang`='fr'";
$sql_create_table[] = "UPDATE `" . $db_config['prefix'] . "_config` SET `config_value` =  " . $db->dbescape_string( $disable_site_content ) . " WHERE `module` =  'global' AND `config_name` = 'disable_site_content' AND `lang`='fr'";
$sql_create_table[] = "UPDATE `" . $db_config['prefix'] . "_config` SET `config_value` =  " . $db->dbescape_string( $copyright ) . " WHERE `module` =  'news' AND `config_name` = 'copyright' AND `lang`='fr'";

$sql_create_table[] = "TRUNCATE TABLE `" . $db_config['prefix'] . "_banners_plans`";
$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_banners_plans` VALUES
(1, '', 'Publicité du centre', '', 'sequential', 510, 100, 1), 
(2, '', 'Publicité à côté', '', 'sequential', 190, 500, 1)";

$sql_create_table[] = "TRUNCATE TABLE `" . $db_config['prefix'] . "_banners_rows`";

$sql_create_table[] = "INSERT INTO `" . $db_config['prefix'] . "_banners_rows` VALUES
(1, 'Ministère des affaires étrangers', 2, 0, 'uploads/banners/bongoaigiao.jpg', 'jpg', 'image/jpeg', 160, 54, '', 'http://www.mofa.gov.vn', '', '', '', 1275296773, 1275296773, 0, 1, 1), 
(2, 'vinades', 2, 0, 'uploads/banners/vinades.jpg', 'jpg', 'image/jpeg', 190, 454, '', 'http://vinades.vn', '', '', '', 1275321220, 1275321220, 0, 0, 1), 
(3, 'Publicité du centre', 1, 0, 'uploads/banners/vndads___05.jpg', 'jpg', 'image/jpeg', 470, 60, '', 'http://vinades.vn', '', '', '', 1275321716, 1275321716, 0, 0, 1)";

$array_cron_name = array();
$array_cron_name[1] = 'Supprimer les anciens registres du status en ligne dans la base de données';
$array_cron_name[2] = 'Sauvegarder automatique la base de données';
$array_cron_name[3] = 'Supprimer les fichiers temporaires du répertoire tmp';
$array_cron_name[4] = 'Supprimer les fichiers ip_logs expirés';
$array_cron_name[5] = 'Supprimer les fichiers error_log expirés';
$array_cron_name[6] = 'Envoyer à l\'administrateur l\'e-mail des notifications d\'erreurs';
$array_cron_name[7] = 'Supprimer les referers expirés';

$result = $db->sql_query( "SELECT `id`, `run_func` FROM `" . $db_config['prefix'] . "_cronjobs` ORDER BY `id` ASC" );
while ( list( $id, $run_func ) = $db->sql_fetchrow( $result ) )
{
    $cron_name = ( isset( $array_cron_name[$id] ) ) ? $array_cron_name[$id] : $run_func;
    $sql_create_table[] = "UPDATE `" . $db_config['prefix'] . "_cronjobs` SET `" . $lang_data . "_cron_name` =  " . $db->dbescape_string( $cron_name ) . " WHERE `id`=" . $id;
}
$db->sql_freeresult();
?>
