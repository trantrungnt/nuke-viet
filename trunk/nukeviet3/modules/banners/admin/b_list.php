<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3/15/2010 3:35
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );

$query = "SELECT `id`,`full_name` FROM `" . NV_BANNERS_CLIENTS_GLOBALTABLE . "` ORDER BY `login` ASC";
$result = $db->sql_query( $query );

$clients = array();
while ( $row = $db->sql_fetchrow( $result ) )
{
	$clients[$row['id']] = $row['full_name'];
}

$query = "SELECT `id`,`title`,`blang` FROM `" . NV_BANNERS_PLANS_GLOBALTABLE . "` ORDER BY `blang`, `title` ASC";
$result = $db->sql_query( $query );

$plans = array();
while ( $row = $db->sql_fetchrow( $result ) )
{
	$plans[$row['id']] = $row['title'] . " (" . ( ! empty( $row['blang'] ) ? $language_array[$row['blang']]['name'] : $lang_module['blang_all'] ) . ")";
}

$contents = array();

$query = "SELECT * FROM `" . NV_BANNERS_ROWS_GLOBALTABLE . "` WHERE ";
if ( in_array( $nv_Request->get_int( 'act', 'get' ), array( 2, 3, 4 ) ) )
{
	$query .= "`act`=" . $nv_Request->get_int( 'act', 'get' );
	$contents['caption'] = $lang_module['banners_list' . $nv_Request->get_int( 'act', 'get' )];
}
else
{
	$query .= "`act`=1";
	$contents['caption'] = $lang_module['banners_list1'];
}

if ( $nv_Request->get_bool( 'clid', 'get' ) and isset( $clients[$nv_Request->get_int( 'clid', 'get' )] ) )
{
	$query .= " AND `clid`=" . $nv_Request->get_int( 'clid', 'get' );
	$contents['caption'] .= " " . sprintf( $lang_module['banners_list_cl'], $clients[$nv_Request->get_int( 'clid', 'get' )] );
} elseif ( $nv_Request->get_bool( 'pid', 'get' ) and isset( $plans[$nv_Request->get_int( 'pid', 'get' )] ) )
{
	$query .= " AND `pid`=" . $nv_Request->get_int( 'pid', 'get' );
	$contents['caption'] .= " " . sprintf( $lang_module['banners_list_pl'], $plans[$nv_Request->get_int( 'pid', 'get' )] );
}

$query .= " ORDER BY `id` DESC";

$result = $db->sql_query( $query );

$contents['thead'] = array( $lang_module['title'], $lang_module['in_plan'], $lang_module['of_client'], $lang_module['publ_date'], $lang_module['exp_date'], $lang_module['is_act'], $lang_global['actions'] );
$contents['view'] = $lang_global['detail'];
$contents['edit'] = $lang_global['edit'];
$contents['del'] = $lang_global['delete'];
$contents['rows'] = array();
while ( $row = $db->sql_fetchrow( $result ) )
{
	$client = ! empty( $row['clid'] ) ? $clients[$row['clid']] : "";
	$contents['rows'][$row['id']]['title'] = $row['title'];
	$contents['rows'][$row['id']]['pid'] = array( NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=info_plan&amp;id=" . $row['pid'], $plans[$row['pid']] );
	$contents['rows'][$row['id']]['clid'] = ! empty( $client ) ? array( NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=info_client&amp;id=" . $row['clid'], $client ) : array();
	$contents['rows'][$row['id']]['publ_date'] = date( "d-m-Y", $row['publ_time'] );
	$contents['rows'][$row['id']]['exp_date'] = ! empty( $row['exp_time'] ) ? date( "d-m-Y", $row['exp_time'] ) : $lang_module['unlimited'];
	$contents['rows'][$row['id']]['act'] = array( 'act_' . $row['id'], $row['act'], "nv_b_chang_act(" . $row['id'] . ",'act_" . $row['id'] . "');" );
	$contents['rows'][$row['id']]['view'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=info_banner&amp;id=" . $row['id'];
	$contents['rows'][$row['id']]['edit'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=edit_banner&amp;id=" . $row['id'];
	$contents['rows'][$row['id']]['del'] = "nv_b_del(" . $row['id'] . ");";
}

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_b_list_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>