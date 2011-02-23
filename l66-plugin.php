<?php
/*
Plugin Name: lane66.com affiliate tools CORE
Plugin URI: http://lane66.com
Description: This is the affiliate tools pro CORE by lane66.com. With the core you can upload your own csv feeds and create shop-pages and product posts. While the core is functional we highly recommend adding specialised add-on's for networks you use often. <strong><a href="http://lane66.com">Visit http://lane66.com for more add-on's, widgets, loaders, API connectors and more.</a></strong>
Author: pete scheepens
Author URI: http://lane66.com
Version: 0.9.7
*/
include_once('l66_functions.php');
//if (function_exists('l66_checkdb')) {l66_checkdb();}
//add_action('shutdown', 'l66_checkdb');
add_action('admin_menu', 'l66_page');
add_shortcode('l66', 'l66_shortcode');
function l66_page()
{
add_menu_page('l66 Datafeeds', 'L66 affiliate', 'administrator', 'l66-admin', 'l66_info');
add_submenu_page('l66-admin', 'lane66.com shops', 'build a shop', 'administrator', 'l66_pagebuilder', 'l66_pagebuilder');	
add_submenu_page('l66-admin', 'lane66.com posts', 'convert to post', 'administrator', 'l66_postconvert', 'l66_postconvert');
add_submenu_page('l66-admin', 'lane66.com upload', 'upload my own csv', 'administrator', 'l66_upload_csv', 'l66_upload_csv');		
//add_submenu_page('l66-admin', 'lane66.com shareasale main', 'SHAREaSALE setup', 'administrator', 'l66_SAS_tools', 'l66_SAS_main');	
//add_submenu_page('l66-admin', 'lane66.com shareasale select feed', '|->SAS add feeds', 'administrator', 'l66_SAS_feeds', 'l66_feed_page');
add_submenu_page('l66-admin', 'lane66.com database tools', 'LANE66.com tools', 'administrator', 'l66_db_tools', 'l66_db_tools');	
}
function l66_pagebuilder() {
	include"l66_pagebuilder.php";
}
function l66_postconvert() {
	include"l66_postconvert.php";
}
function l66_upload_csv() {
	include"l66_upload_csv.php";
}
function l66_info() {
	include"l66_infopage.php";
}
//function l66_SAS_main() {
//    include"l66_SAS_main.php";
//}
//function l66_feed_page() {
//    include"l66_feed_page.php";
//}
function l66_db_tools() {
   include"l66_db_tools.php";
}

?>
