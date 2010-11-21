<?php

/**
 * @Project No project loaded
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 20/11/2010, 12:10
 */

if ( ! defined( "NV_CSSFILE" ) ) die();

$expire = 60 * 60 * 24; //file CSS duoc luu 1 ngay

$module = ( isset( $_GET['mod'] ) and preg_match( "/^[a-z0-9\-]+$/", $_GET['mod'] ) ) ? $_GET['mod'] : "";

/**
 * checkLastMod()
 * 
 * @param mixed $lastmod
 * @param mixed $files
 * @return void
 */
function checkLastMod( $lastmod, $files )
{
    if ( isset( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) )
    {
        $modsince = strtotime( $_SERVER['HTTP_IF_MODIFIED_SINCE'] );
        if ( $modsince != -1 && $modsince == $lastmod )
        {
            header( "HTTP/1.0 304 Not Modified" );
            header( 'Content-Length: 0' );
            exit();
        }
    }
    else
    {
        $hash = $lastmod . '-' . md5( $files );

        if ( isset( $_SERVER['HTTP_IF_NONE_MATCH'] ) && stripslashes( $_SERVER['HTTP_IF_NONE_MATCH'] ) == '"' . $hash . '"' )
        {
            header( "HTTP/1.0 304 Not Modified" );
            header( 'Content-Length: 0' );
            exit();
        }

        header( "Etag: \"" . $hash . "\"" );
    }
}

/**
 * callback()
 * 
 * @param mixed $matches
 * @return
 */
function callback( $matches )
{
    global $cssdir, $realPathCssModDir;

    $m2 = str_replace( '\\', '/', realpath( $realPathCssModDir . "/" . $matches[2] ) );
    $dir = str_replace( '\\', '/', $cssdir );
    $m2 = explode( "/", $m2 );
    $dir = explode( "/", $dir );
    $relative = array();
    foreach ( $dir as $index => $part )
    {
        if ( isset( $m2[$index] ) && $m2[$index] == $part )
        {
            continue;
        }

        $relative[] = '..';
    }

    foreach ( $m2 as $index => $part )
    {
        if ( isset( $dir[$index] ) && $dir[$index] == $part )
        {
            continue;
        }

        $relative[] = $part;
    }

    $relative = implode( "/", $relative );

    return $matches[1] . $relative . $matches[4];
}

$cssModContent = "";

$lastmod = 0;
$files = "";

foreach ( $cssFiles as $file )
{
    $files .= $cssdir . "/" . $file;
    $filemtime = filemtime( $cssdir . "/" . $file );
    $lastmod = max( $lastmod, $filemtime );
}

$is_checkLastmod = false;

if ( ! empty( $module ) )
{
    $template = ( isset( $_GET['templ'] ) and preg_match( "/^[a-z0-9\-]+$/", $_GET['templ'] ) ) ? $_GET['templ'] : "";
    $modCssDir = ! empty( $template ) ? "../../" . $template . "/css" : "";
    $realPathCssModDir = ! empty( $modCssDir ) ? realpath( $cssdir . "/" . $modCssDir ) : $cssdir;

    $cssModFile = "";
    if ( file_exists( $realPathCssModDir . '/' . $module . '.css' ) )
    {
        $cssModFile = $realPathCssModDir . '/' . $module . '.css';
    } elseif ( file_exists( $realPathCssModDir . '/' . $module . '.css.php' ) )
    {
        $cssModFile = $realPathCssModDir . '/' . $module . '.css.php';
    }

    if ( ! empty( $cssModFile ) )
    {
        $is_checkLastmod = true;
        $files .= $cssModFile;
        $filemtime = filemtime( $cssModFile );
        $lastmod = max( $lastmod, $filemtime );
        checkLastMod( $lastmod, $files );

        ob_start();
        include ( $cssModFile );
        $cssModContent = ob_get_contents();
        ob_end_clean();

        if ( $realPathCssModDir != $cssdir )
        {
            $cssModContent = preg_replace( "/url[\s]*\([\s]*\'(.*)?\'[\s]*\)/", "url($1)", $cssModContent ); //xoa cac dau ngoac don
            $cssModContent = preg_replace_callback( "/(url\()((?!http(s?)|ftp\:\/\/)[^\)]+)(\))/", "callback", $cssModContent );
        }
    }
}

if ( ! $is_checkLastmod )
{
    checkLastMod( $lastmod, $files );
}

ob_start();
foreach ( $cssFiles as $file )
{
    include ( $cssdir . "/" . $file );
}
$cssContent = ob_get_contents();
ob_end_clean();

$cssContent = preg_replace( "/url[\s]*\([\s]*\'(.*)?\'[\s]*\)/", "url($1)", $cssContent ); //xoa cac dau ngoac don
$cssContent .= $cssModContent;

$cssContent = preg_replace( "/\/\*(.*)?\*\//Usi", "", $cssContent ); //xoa chu thich
$cssContent = str_replace( array( "\n ", "\n", "\t" ), " ", $cssContent ); //xoa xuong dong, dau cach TAB
$cssContent = preg_replace( "/[\s]+/", " ", $cssContent ); //Xoa khoang trang
$cssContent = preg_replace( array( "/[\s]*[\;]+[\s]*\}/", "/[\s]*[\;]+[\s]*/", "/[\s]*[\}]+[\s]*/", "/[\s]*[\{]+[\s]*/", "/[\s]*[\:]+[\s]*/", "/[\s]*[\,]+[\s]*/" ), array( "}", ";", "}", "{", ":", "," ), $cssContent );
$cssContent = preg_replace( "/[^\}]+\{[\s|\;]*\}[\s]*/", "", $cssContent ); //Xoa nhung css khong co noi dung

$currenttime = time();

ob_start( "ob_gzhandler" );
@header( "Content-Type: text/css; charset=utf-8" );
@header( 'Cache-Control: public; max-age=' . $expire );
@header( 'Last-Modified: ' . gmdate( "D, d M Y H:i:s", $lastmod ) . " GMT" );
@header( "expires: " . gmdate( "D, d M Y H:i:s", $currenttime + $expire ) . " GMT" );

echo $cssContent;

?>