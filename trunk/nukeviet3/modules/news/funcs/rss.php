<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES. All rights reserved
 * @Createdate Apr 20, 2010 10:47:41 AM
 */

if ( ! defined( 'NV_IS_MOD_NEWS' ) )
{
    die( 'Stop!!!' );
}

$channel = array();
$items = array();

$channel['title'] = $global_config['site_name'] . ' RSS: ' . $module_info['custom_title'];;
$channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name;
$channel['atomlink'] = NV_MY_DOMAIN . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=rss";
$channel['description'] = $global_config['site_description'];

$catid = 0;
if ( isset( $array_op[1] ) )
{
    $alias_cat_url = $array_op[1];
    $cattitle = "";
    foreach ( $global_array_cat as $catid_i => $array_cat_i )
    {
        if ( $alias_cat_url == $array_cat_i['alias'] )
        {
            $catid = $catid_i;
            break;
        }
    }
}
if ( ! empty( $catid ) )
{
    $channel['title'] = $global_config['site_name'] . ' RSS: ' . $module_info['custom_title'] . ' - ' . $global_array_cat[$catid]['title'];
    $channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=rss/" . $alias_cat_url;
    $channel['description'] = $global_array_cat[$catid]['description'];
    
    $sql = "SELECT id, listcatid, publtime, title, alias, hometext, homeimgfile FROM `" . NV_PREFIXLANG . "_" . $module_data . "_" . $catid . "` WHERE inhome='1' AND  publtime < " . NV_CURRENTTIME . " AND (exptime=0 OR exptime >" . NV_CURRENTTIME . ") ORDER BY publtime DESC LIMIT 30";
}
else
{
    $sql = "SELECT id, listcatid, publtime, title, alias, hometext, homeimgfile FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE inhome='1' AND  publtime < " . NV_CURRENTTIME . " AND (exptime=0 OR exptime >" . NV_CURRENTTIME . ") ORDER BY publtime DESC LIMIT 30";
}

$result = $db->sql_query( $sql );
while ( list( $id, $listcatid, $publtime, $title, $alias, $hometext, $homeimgfile ) = $db->sql_fetchrow( $result ) )
{
    $arr_catid = explode( ',', $listcatid );
    $catid_i = end( $arr_catid );
    $catalias = $global_array_cat[$catid_i]['alias'];
    $rimages = ( ! empty( $homeimgfile ) ) ? "<img src=\"" . NV_MY_DOMAIN . NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" . $homeimgfile . "\" width=\"100\" align=\"left\" border=\"0\">" : "";
    $items[] = array(  //
        'title' => $title, //
		'link' => NV_MY_DOMAIN . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $catalias . '/' . $alias . '-' . $id, //
		'guid' => $module_name . '_' . $id, //
		'description' => $rimages . $hometext, //
		'pubdate' => $publtime  //
    );
}

nv_rss_generate( $channel, $items );
die();
?>