<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-9-2010 14:43
 */
if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( $nv_Request->isset_request( 'checkss', 'get' ) and $nv_Request->get_string( 'checkss', 'get' ) == md5( $global_config['sitekey'] . session_id() ) )
{
    $listid = $nv_Request->get_string( 'listid', 'get' );
    $id_array = array_map( "intval", explode( ",", $listid ) );
    $sql = "SELECT `id`, `listcatid`, `exptime`  FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE `id` in (" . implode( ",", $id_array ) . ")";
    $result = $db->sql_query( $sql );
    while ( list( $id, $listcatid, $exptime ) = $db->sql_fetchrow( $result ) )
    {
        if ( $exptime == 0 or $exptime > NV_CURRENTTIME )
        {
            nv_save_log_content ( $id );
            $db->sql_query( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_rows` SET `exptime` = '" . NV_CURRENTTIME . "' WHERE `id` =" . $id . "" );
            $arr_catid = array_map( "intval", explode( ",", $listcatid ) );
            foreach ( $arr_catid as $catid_i )
            {
                $db->sql_query( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_" . $catid_i . "` SET `exptime` = '" . NV_CURRENTTIME . "' WHERE `id` =" . $id . "" );
            }
        }
    }
    nv_del_cache_module();
}
Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "" );
die();
?>