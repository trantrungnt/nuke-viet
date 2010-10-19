<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @copyright 2009
 * @createdate 12/31/2009 0:51
 */

if ( ! defined( 'NV_IS_MOD_WEBLINKS' ) ) die( 'Stop!!!' );

function main_theme ( $array_cat, $array_cat_content )
{
    global $module_info, $global_config, $module_name, $module_file, $lang_module, $global_array_cat, $showdes, $showsub, $numsub, $numcat, $intro, $showcatimage, $numinsub;
    $xtpl = new XTemplate( "main_page.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'BASE_URL', NV_BASE_SITEURL );
    foreach ( $array_cat as $catid => $array_cat_i )
    {
        if ( ! empty( $array_cat_i ) && ! empty( $array_cat_content[$catid] ) )
        {
            $xtpl->assign( "CATE_TITLE", $array_cat_i['title'] );
            $xtpl->assign( 'LINK_URL_CATE', $array_cat_i['link'] );
            $i = 0;
            foreach ( $array_cat_i['subcat'] as $subcat )
            {
                $xtpl->assign( 'CATE_TITLE_SUB', $subcat['title'] );
                $xtpl->assign( 'LINK_URL_CATE_SUB', $subcat['link'] );
                $xtpl->parse( 'main.loop_tab_cate.loop_sub_title' );
                if ( $i == 2 )
                {
                    $xtpl->assign( 'NEXT_TITLE', $lang_module['next_title'] );
                    $xtpl->parse( 'main.loop_tab_cate.next' );
                    break;
                }
                $i ++;
            }
            if ( ! empty( $array_cat_content[$catid] ) )
            {
                foreach ( $array_cat_content[$catid] as $content )
                {
                    $xtpl->assign( 'WEBLINK_TITLE', $content['title'] );
                    $xtpl->assign( 'WEBLINK_VIEW', $content['link'] );
                    if ( $content['urlimg'] != '' )
                    {
                        if ( ! nv_is_url( $content['urlimg'] ) )
                        {
                            $content['urlimg'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $content['urlimg'];
                        }
                        $xtpl->assign( 'SRC_IMG', $content['urlimg'] );
                        $xtpl->parse( 'main.loop_tab_cate.have_data.img' );
                    }
                    else
                    {
                        $xtpl->assign( 'SRC_IMG', "" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_file . "/no_image.gif" );
                        $xtpl->parse( 'main.loop_tab_cate.have_data.img' );
                    }
                    $intro = strip_tags( $content['description'] );
                    $xtpl->assign( 'TEXT_HOME', nv_clean60( $intro, 200 ) . "..." );
                    $xtpl->assign( 'VIEW_TILTE', $lang_module['view_title'] );
                    $xtpl->assign( 'NUM_VIEW', $content['hits_total'] );
                    $dateup = date( 'd/m/Y', $content['add_time'] );
                    $xtpl->assign( 'DATE_UP', $dateup );
                    $xtpl->assign( 'LINK_VISIT', $content['linkvi'] );
                    $xtpl->assign( 'LINK_URL', nv_clean60( $content['url'], 70 ) . "..." );
                    if ( defined( 'NV_IS_ADMIN' ) )
                    {
                        $xtpl->assign( 'ADMIN_LINK', adminlink( $content['id'] ) );
                    }
                    $xtpl->parse( 'main.loop_tab_cate.have_data' );
                }
            }
            $xtpl->parse( 'main.loop_tab_cate' );
        }
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function viewcat ( $array_subcat, $array_cat, $items )
{
    global $module_info, $global_array_cat, $global_config, $module_name, $module_file, $lang_module, $numsubcat, $showcatimage, $numinsub;
    $xtpl = new XTemplate( "viewcat.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $width = round( 100 / $numsubcat, 0 );
    $xtpl->assign( "W", $width );
    foreach ( $array_cat as $array_cat_i )
    {
        $xtpl->assign( 'CAT', $array_cat_i );
        if ( ! empty( $array_cat_i['description'] ) )
        {
            $xtpl->parse( 'main.cat.showdes' );
        }
        $xtpl->parse( 'main.cat' );
    }
    if ( ! empty( $array_subcat ) )
    {
        $a = 1;
        foreach ( $array_subcat as $array_subcat_i )
        {
            $xtpl->assign( 'SUB', $array_subcat_i );
            if ( ( $showcatimage == 1 ) and ! empty( $array_subcat_i['catimage'] ) )
            {
                if ( file_exists( NV_UPLOADS_REAL_DIR . NV_UPLOADS_DIR . "/" . $array_subcat_i['catimage'] ) && $array_subcat_i['catimage'] != "" )
                {
                    $xtpl->assign( "IMG", "" . NV_BASE_SITEURL . "/" . $array_subcat_i['catimage'] . "" );
                }
            }
            else
            {
                $xtpl->assign( "IMG", "" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_file . "/no_image.gif" );
            }
            ( $numinsub == 1 ) ? $xtpl->parse( 'main.sub.loop.count_link' ) : "";
            $xtpl->assign( "FLOAT", ( $a % $numsubcat ) == false ? "fr" : "fl" );
            ( $a % $numsubcat ) == false ? $xtpl->parse( 'main.sub.loop.clear' ) : "";
            $xtpl->parse( 'main.sub.loop' );
            $a ++;
        }
        $xtpl->parse( 'main.sub' );
    }
    if ( ! empty( $items ) )
    {
        foreach ( $items as $items_i )
        {
            $items_i['add_time'] = nv_date( "H:i l - d/m/Y", $items_i['add_time'] );
            $items_i['description'] = strip_tags( $items_i['description'] );
            $items_i['description'] = _substr( $items_i['description'], 200 );
            if ( ! empty( $items_i['urlimg'] ) )
            {
                if ( ! nv_is_url( $items_i['urlimg'] ) )
                {
                    $items_i['urlimg'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $items_i['urlimg'];
                }
                $xtpl->assign( 'IMG', $items_i['urlimg'] );
            }
            else
            {
                $xtpl->assign( 'IMG', "" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_file . "/no_image.gif" );
            }
            $items_i['url'] = nv_clean60( $items_i['url'], 70 ) . "...";
            $xtpl->assign( 'ITEM', $items_i );
            if ( defined( 'NV_IS_ADMIN' ) )
            {
                $xtpl->assign( 'ADMIN_LINK', adminlink( $items_i['id'] ) );
            }
            $xtpl->parse( 'main.items.loop' );
        }
        $xtpl->parse( 'main.items' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function detail ( $row )
{
    global $module_info, $global_config, $module_name, $module_file, $global_array_cat, $lang_module;
    
    $xtpl = new XTemplate( "detail.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $row['add_time'] = nv_date( "H:i l - d/m/Y", $row['add_time'] );
    $row['edit_time'] = nv_date( "H:i l - d/m/Y", $row['edit_time'] );
    if ( $row['urlimg'] != "" )
    {
        if ( ! nv_is_url( $row['urlimg'] ) )
        {
            $row['urlimg'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $row['urlimg'];
        }
        $xtpl->assign( 'IMG', $row['urlimg'] );
        $xtpl->parse( 'main.img' );
    }
    else
    {
        $xtpl->assign( 'IMG', "" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_file . "/no_image.gif" );
        $xtpl->parse( 'main.img' );
    }
    $xtpl->assign( 'LANG', $lang_module );
    $row['url'] = nv_clean60( $row['url'], 60 ) . "...";
    $xtpl->assign( 'DETAIL', $row );
    ! empty( $row['description'] ) ? $xtpl->parse( 'main.des' ) : "";
    if ( defined( 'NV_IS_ADMIN' ) )
    {
        $xtpl->assign( 'ADMIN_LINK', adminlink( $row['id'] ) );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function report ( $row, $check )
{
    global $module_info, $lang_module, $global_config, $module_file;
    $xtpl = new XTemplate( "report.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $script_js = "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/mudim.js\"></script>";
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'ROW', $row );
    $xtpl->assign( 'SCRIPT_JS', $script_js );
    if ( ! empty( $row['error'] ) )
    {
        $xtpl->parse( 'main.error' );
    }
    if ( $check )
    {
        $xtpl->parse( 'main.close' );
        $xtpl->parse( 'main.success' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->out( 'main' );
}
?>