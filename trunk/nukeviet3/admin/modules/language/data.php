<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-2-2010 12:55
 */

if ( ! defined( 'NV_IS_FILE_LANG' ) ) die( 'Stop!!!' );
$page_title = $lang_module['nv_lang_data'];
$sql = "SELECT lang, setup FROM `" . $db_config['prefix'] . "_setup_language`";
$result = $db->sql_query( $sql );
$array_lang_setup = array();
while ( $row = $db->sql_fetchrow( $result ) )
{
    $array_lang_setup[$row['lang']] = intval( $row['setup'] );
}

$keylang = filter_text_input( 'keylang', 'get', '' );
$checksess = filter_text_input( 'checksess', 'get', '' );
$keylang = filter_text_input( 'keylang', 'get', '', 1, 2 );

if ( $checksess == md5( $keylang . session_id() ) and in_array( $keylang, $global_config['allow_adminlangs'] ) )
{
    if ( isset( $array_lang_setup[$keylang] ) and $array_lang_setup[$keylang] == 1 )
    {
        info_die( $lang_module['nv_data_setup'] );
    }
    else
    {
        
        list( $site_theme ) = $db->sql_fetchrow( $db->sql_query( "SELECT `config_value` FROM `" . NV_CONFIG_GLOBALTABLE . "` where `lang`='" . $global_config['site_lang'] . "' AND `module`='global' AND `config_name`='site_theme'" ) );
        $global_config['site_theme'] = $site_theme;
        require_once ( NV_ROOTDIR . '/includes/sqldata.php' );
        $sql_create_table = nv_create_table_sys( $keylang );
        foreach ( $sql_create_table as $query )
        {
            $db->sql_query( $query );
        }
        
        if ( ! $db->sql_query( "INSERT INTO `" . $db_config['prefix'] . "_setup_language` (`lang`, `setup`) VALUES ('" . $keylang . "', '1')" ) )
        {
            $db->sql_query( "UPDATE `" . $db_config['prefix'] . "_setup_language` SET `setup` = '1' WHERE `lang` = '" . $keylang . "'" );
        }
        $db->sql_query( "UPDATE `" . $db_config['prefix'] . "_" . $keylang . "_modules` SET `act` = '0'" );
        
        $nv_Request->set_Cookie( 'data_lang', $keylang, NV_LIVE_COOKIE_TIME );
        $contents_setup = "<br><br><center><br><b>" . $lang_module['nv_data_setup_ok'] . "</b></center>";
        $contents_setup .= "<META HTTP-EQUIV=\"refresh\" content=\"5;URL=" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=settings&" . NV_OP_VARIABLE . "=main\">";
        
        include ( NV_ROOTDIR . "/includes/header.php" );
        $contents_setup = nv_admin_theme( $contents_setup );
        if ( defined( 'NV_MODULE_SETUP_DEFAULT' ) )
        {
            $lang_module['modules'] = "";
            $lang_module['vmodule_add'] = "";
            $lang_module['blocks'] = "";
            $lang_module['autoinstall'] = "";
            $lang_global['mod_modules'] = "";
            
            require_once ( NV_ROOTDIR . "/" . NV_ADMINDIR . "/modules/modules/functions.php" );
            
            $array_module_setup = explode( ",", NV_MODULE_SETUP_DEFAULT );
            foreach ( $array_module_setup as $setmodule )
            {
                $sm = nv_setup_data_module( $keylang, $setmodule );
                if ( $sm == "OK_" . $setmodule )
                {
                    $db->sql_query( "UPDATE `" . $db_config['prefix'] . "_" . $keylang . "_modules` SET `act` = '1'WHERE `title`='" . $setmodule . "'" );
                }
            }
            $db->sql_query( "DELETE FROM `" . $db_config['prefix'] . "_" . $keylang . "_modules` WHERE `act` = '0'" );
        }
        include ( NV_ROOTDIR . "/includes/footer.php" );
        exit();
    }
}
elseif ( $keylang != "" )
{
    nv_change_log_admin( "ERROR Setup lang " . $keylang );
}

$contents .= "<table summary=\"\" class=\"tab1\">\n";
$contents .= "  <thead>\n";
$contents .= "  <tr>";
$contents .= "      <td>" . $lang_module['nv_lang_key'] . "</td>";
$contents .= "      <td>" . $lang_module['nv_lang_name'] . "</td>";
$contents .= "      <td></td>";
$contents .= "  </thead>\n";
$contents .= "  </tr>";
$a = 0;
foreach ( $global_config['allow_adminlangs'] as $keylang )
{
    if ( isset( $array_lang_setup[$keylang] ) and $array_lang_setup[$keylang] == 1 )
    {
        $setup = $lang_module['nv_setup'];
    }
    else
    {
        $setup = "<span class=\"default_icon\"><a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&keylang=" . $keylang . "&amp;checksess=" . md5( $keylang . session_id() ) . "\">" . $lang_module['nv_setup_new'] . "</a></span>";
    }
    $class = ( $a % 2 ) ? " class=\"second\"" : "";
    $contents .= "<tbody" . $class . ">\n";
    $contents .= "  <tr>";
    $contents .= "      <td>" . $keylang . "</td>";
    $contents .= "      <td>" . $language_array[$keylang]['name'] . "</td>";
    $contents .= "      <td>" . $setup . "</td>";
    $contents .= "  </tr>";
    $contents .= "  </tbody>\n";
    $a ++;
}
$contents .= "  </table>\n";

$contents .= "<div class=\"quote\" style=\"width:97.5%;\">\n";
$contents .= "<blockquote><span>" . $lang_module['nv_data_note'] . "</span></blockquote>\n";
$contents .= "</div>\n";
$contents .= "<div class=\"clear\"></div>\n";

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
?>