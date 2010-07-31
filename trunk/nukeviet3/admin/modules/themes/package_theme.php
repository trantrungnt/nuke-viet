<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate 2-2-2010 12:55
 */
if ( ! defined( 'NV_IS_FILE_THEMES' ) ) die( 'Stop!!!' );
$title = $note = $module_file = "";
$page_title = $lang_module['autoinstall_method_packet'];
if ( $nv_Request->isset_request( 'op', 'post' ) )
{
    $themename = $nv_Request->get_string( 'themename', 'post' );
    $tempfolder = NV_ROOTDIR . '/' . NV_TEMP_DIR;
    //theme folder
    if ( file_exists( NV_ROOTDIR . '/themes/' . $themename . '/' ) )
    {
        $themefolder[] = NV_ROOTDIR . '/themes/' . $themename . '/';
    }
    if ( file_exists( NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $themename . '.zip' ) )
    {
        @unlink( NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $themename . '.zip' );
    }
    
    require_once NV_ROOTDIR . '/includes/class/pclzip.class.php';
    $zip = new PclZip( NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $themename . '.zip' );
    $zip->create( $themefolder, PCLZIP_OPT_REMOVE_PATH, NV_ROOTDIR . '/themes' );
    $filesize = @filesize( NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $themename . '.zip' );
    $filesize = ( round( $filesize / 1024, 2 ) > 1024 ) ? ( ( round( $filesize / ( pow( 1024, 2 ) ), 2 ) ) > 1024 ) ? ( round( $filesize / ( pow( 1024, 3 ) ), 2 ) ) . 'GB' : ( round( $filesize / ( pow( 1024, 2 ) ), 2 ) ) . 'MB' : round( $filesize / 1024, 2 ) . ' KB';
    echo '<a href="' . NV_BASE_SITEURL . '' . NV_TEMP_DIR . '/' . $themename . '.zip"><span style="font-size:16px;color:red">' . $themename . '.zip' . ' - ' . $filesize . '</span></a>';
}
else
{
    $op = $nv_Request->get_string( 'op', 'get' );
    $contents .= "<form name='install_theme' enctype='multipart/form-data' action=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "\" method=\"post\">";
    $contents .= "<table summary=\"\" class=\"tab1\">\n";
    $contents .= "<tbody class=\"second\">";
    $contents .= "<tr>";
    $contents .= "<td align=\"center\" colspan='2'><strong>" . $lang_module['autoinstall_package_select'] . ": </strong>\n";
    $contents .= "<input type='hidden' name='" . NV_OP_VARIABLE . "' value='" . $op . "'/>";
    $contents .= "<select name=\"themename\">\n";
    $contents .= "<option value=\"0\">" . $lang_module['autoinstall_method_none'] . "</option>\n";
    $theme_list = nv_scandir( NV_ROOTDIR . "/themes/", $global_config['check_theme'] );
    foreach ( $theme_list as $value )
    {
        $contents .= "<option value=\"" . $value . "\">" . $value . "</option>\n";
    }
    $contents .= "</select>\n";
    $contents .= "</td>";
    $contents .= "</tr>";
    $contents .= "</tbody>";
    $contents .= "<tr>";
    $contents .= "<td colspan='2' align='center'>";
    $contents .= "<input name=\"continue\" type=\"button\" value=\"" . $lang_module['autoinstall_continue'] . "\" />\n";
    $contents .= "<input name=\"back\" type=\"button\" value=\"" . $lang_module['autoinstall_back'] . "\" />\n";
    $contents .= "</td>";
    $contents .= "</tr>";
    $contents .= "<tbody class=\"second\">";
    $contents .= "<tr>";
    $contents .= "<td colspan='2' align='center'>";
    $contents .= "<p id='message' style='color:red;display:none'></p>";
    $contents .= "</td>";
    $contents .= "</tr>";
    $contents .= "</tbody>";
    $contents .= "</table>";
    $contents .= "</form>";
    $contents .= '
<script type="text/javascript">
 $(function(){
 	$("input[name=continue]").click(function(){
 		var themename = $("select[name=themename]").val();
 		if (themename!=0){
 			$("#message").html("<img src=\'../images/load_bar.gif\'/>' . $lang_module['autoinstall_package_processing'] . '");
 			$("#message").fadeIn();
 			$("input[name=continue]").attr("disabled","disabled");
 			$("input[name=back]").attr("disabled","disabled");
 			$("#step1").slideUp();
			$.ajax({	
				type: "POST",
				url: "' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '",
				data: "themename="+ themename+"&' . NV_OP_VARIABLE . '=' . $op . '",
				success: function(data){				
					$("input[name=back]").removeAttr("disabled");
					$("input[name=continue]").removeAttr("disabled");
					$("#message").html(data);
				}
			});
 		} else {
 			alert("' . $lang_module['autoinstall_package_noselect'] . '");
 			return false;
 		}
 	});
 	$("input[name=back]").click(function(){
 		$("#content").slideUp();
		$("#step1").slideDown();
 	});

 });
</script>
';
    echo $contents;
}
?>