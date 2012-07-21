<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Type: User Field
| Name: Multi Url
| Version: 1.01
| File Name: user_multiurl_include_var.php
| Author: Valerio Vendrame (lelebart)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (!function_exists("show_user_multi_url")) {
	function show_user_multi_url($input=null){
		if (!($input)) { return null; }
		if (is_string($input)) {
			$input = "<a href='".$input."' title='".phpentities($input)."' target='_blank'>".trimlink($input, 50)."</a>";
		}
		if (is_array($input)) {
			foreach ($input as $key => $value) { $input[$key] = show_user_multi_url($value); }
		}
		return $input;
	}
}
if (!function_exists("add_user_multi_url")) {
	function add_user_multi_url($input=null){
		if (!($input)) { return null; }
		if (is_string($input)) {
			if (!preg_match('#^([\r\n]*)(http://|https://)([^\s\'\"]*?)([\r\n]*)#si', $input)) {
				if (preg_match('#^([\r\n]*)(www.)([^\s\'\"]*?)([\r\n]*)#si', $input)) {
					$input = preg_replace('#([\r\n]*)(www.)([^\s\'\"]*?)([\r\n]*)#si', 'http://\2\3', $input);
				} else { $input = null; }
			}
		}
		if (is_array($input)) {
			foreach ($input as $key => $value) { 
				if (!empty($value)) {
					$input[$key] = add_user_multi_url($value);
				}
			}
		}
		return $input;		
	}
}
if (!function_exists("strip_user_multi_url")) {
	function strip_user_multi_url($input=null){
		if (!($input)) { return null; }
		$input = descript($input);
		$input = stripinput($input);
		$input = preg_replace("/ +/i","",$input);
		$input = str_replace(array("\t","\r\n"),array("","\n"),$input);
		$input = explode("\n",$input);
		$input = add_user_multi_url($input);
		$input = is_array($input) ? array_unique(array_filter($input)) : $input;
		$input = implode("\n",$input);
		return $input;
	}
}
if ($profile_method == "input") {
	$user_multi_url = !empty($user_data['user_multiurl']) ? unserialize(trim(base64_decode($user_data['user_multiurl']))) : "";
	$user_multi_url['visibility'] = isset($user_multi_url['visibility']) && !empty($user_multi_url['visibility']) ? 
		$user_multi_url['visibility'] : 1;
	$user_multi_url['urls'] = isset($user_multi_url['urls']) && !empty($user_multi_url['urls']) ? 
		$user_multi_url['urls'] : "";
	$visibility_opts = ""; $sel = ""; $user_groups = getusergroups(); unset($user_groups[0]); // remove guest!
	while(list($key, $user_group) = each($user_groups)){
		$sel = ($user_multi_url['visibility'] == $user_group['0'] ? " selected='selected'" : "");
		$visibility_opts .= "<option value='".$user_group['0']."'".$sel.">".$user_group['1']."</option>\n";
	}
	$user_multi_url_profile_message  = "<span class='small2'>";
	$user_multi_url_profile_message .= is_array($locale['uf_multi-url_profile_msg']) ?
		implode("</span><br />\n<span class='small2'>", array_filter($locale['uf_multi-url_profile_msg'])) :
		$locale['uf_multi-url_profile_msg'];
	$user_multi_url_profile_message .= "</span>";
	echo "<tr>\n<td class='tbl' style='white-space:nowrap;vertical-align:top;'>";
	echo $locale['uf_multi-url_profile']."<br />\n".$user_multi_url_profile_message."<br />\n";
	echo $locale['uf_multi-url_visibility']."<br />\n";
	echo "<select name='user_multiurl_visibility' class='textbox' style='float:right;'>\n".$visibility_opts."</select>";
	echo "</td>\n<td class='tbl'>\n";
	echo "<textarea id='user_multiurl' name='user_multiurl' cols='60' rows='5' class='textbox' style='width:295px;'>";
	echo $user_multi_url['urls']."</textarea>\n";
	echo "</td>\n</tr>\n";
	unset($user_multi_url,$visibility_opts,$sel,$user_groups,$user_multi_url_profile_message);
} elseif ($profile_method == "display") {
	$user_multi_url = $user_data['user_multiurl'];
	if (!empty($user_multi_url)){
		$user_multi_url = trim(base64_decode($user_multi_url));
		$user_multi_url = unserialize($user_multi_url);
		$user_multi_url['urls'] = explode("\n",$user_multi_url['urls']);
		$user_multi_url['urls'] = show_user_multi_url($user_multi_url['urls']);
		$user_multi_url['urls'] = implode("<br />",$user_multi_url['urls']);
		if ( !empty($user_multi_url['urls']) && 
		  ( ( iMEMBER && ($userdata['user_id'] == intval($_GET['lookup'])) ) || checkgroup($user_multi_url['visibility']) ) ) {
			echo "<tr>\n<td width='1%' class='tbl1' style='white-space:nowrap;vertical-align:top;'>";
			echo $locale['uf_multi-url_profile']."</td>\n";
			echo "<td align='left' class='tbl1'>".$user_multi_url['urls']."</td>\n</tr>\n";
		}
	} unset($user_multi_url);
} elseif ($profile_method == "validate_insert") {
	$db_fields .= ", user_multiurl";
	$user_multi_url = "";
	if (isset($_POST['user_multiurl']) && isset($_POST['user_multiurl_visibility'])) {
		$user_multi_url = array();
		$user_multi_url['urls'] = strip_user_multi_url($_POST['user_multiurl']);
		$user_multi_url['visibility'] = intval($_POST['user_multiurl_visibility']);
		$user_multi_url = serialize($user_multi_url);
		$user_multi_url = base64_encode($user_multi_url);
	} 
	$db_values .= ", '".$user_multi_url."'";
	unset($user_multi_url);
} elseif ($profile_method == "validate_update") {
	$user_multi_url = "";
	if (isset($_POST['user_multiurl']) && isset($_POST['user_multiurl_visibility'])) {
		$user_multi_url = array();
		$user_multi_url['urls'] = strip_user_multi_url($_POST['user_multiurl']);
		$user_multi_url['visibility'] = intval($_POST['user_multiurl_visibility']);
		$user_multi_url = serialize($user_multi_url);
		$user_multi_url = base64_encode($user_multi_url);
	}
	$db_values .= ", user_multiurl='".$user_multi_url."'";
	unset($user_multi_url);
} 

?>