<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3-6-2010 0:14
 */
if ( ! defined( 'NV_IS_MOD_NEWS' ) ) die( 'Stop!!!' );
if ( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );
$contents = "";
$array_point = array( 
    1, 2, 3, 4, 5 
);
$id = $nv_Request->get_int( 'id', 'post', 0 );
$point = $nv_Request->get_int( 'point', 'post', 0 );
$checkss = filter_text_input( 'checkss', 'post' );
$time_set = $nv_Request->get_int( $module_name . '_' . $op . '_' . $id, 'session', 0 );
if ( $id > 0 and in_array( $point, $array_point ) and $checkss == md5( $id . session_id() . $global_config['sitekey'] ) and empty( $time_set ) )
{
    $nv_Request->set_Session( $module_name . '_' . $op . '_' . $id, NV_CURRENTTIME );
    $query = $db->sql_query( "SELECT listcatid, allowed_rating, ratingdetail FROM `" . NV_PREFIXLANG . "_" . $module_data . "_rows` WHERE `id` = " . $id . " AND `status`=1 AND `publtime` < " . NV_CURRENTTIME . " AND (`exptime`=0 OR `exptime`>" . NV_CURRENTTIME . ")" );
    $row = $db->sql_fetchrow( $query );
    if ( isset( $row['allowed_rating'] ) and $row['allowed_rating'] == 1 )
    {
        $ratingdetail = array_map( "intval", explode( "|", $row['ratingdetail'] ) );
        $rating['total'] = $ratingdetail[0] + $point;
        $rating['click'] = $ratingdetail[1] + 1;
        $rating['points'] = round( $rating['total'] / $rating['click'] );
        $ratingdetail = $rating['total'] . '|' . $rating['click'];
        $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_rows` SET `ratingdetail`=" . $db->dbescape( $ratingdetail ) . " WHERE `id`=" . $id;
        $db->sql_query( $query );
        $array_catid = explode( ",", $row['listcatid'] );
        foreach ( $array_catid as $catid_i )
        {
            $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_" . $catid_i . "` SET `ratingdetail`=" . $db->dbescape( $ratingdetail ) . " WHERE `id`=" . $id;
            $db->sql_query( $query );
        }
        $contents = sprintf( $lang_module['stringrating'], $rating['total'], $rating['click'] );
    }
}
include ( NV_ROOTDIR . "/includes/header.php" );
echo $contents;
include ( NV_ROOTDIR . "/includes/footer.php" );
?>