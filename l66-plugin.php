<?php
/*
Plugin Name: lane66.com affiliate tools CORE
Plugin URI: http://lane66.com
Description: This is the affiliate tools pro CORE by lane66.com. With the core you can upload your own csv feeds and create shop-pages and product posts. While the core is functional we highly recommend adding specialised add-on's for networks you use often. <strong><a href="http://lane66.com">Visit http://lane66.com for more add-on's, widgets, loaders, API connectors and more.</a></strong>
Author: pete scheepens
Author URI: http://lane66.com
Version: 1.5.5
*/
update_option('l66_version','1.5.5');
include_once('l66_functions.php');
add_action('admin_menu', 'l66_page');
add_shortcode('l66', 'l66_shortcode');

if (!function_exists('l66_page'))
	{
	function l66_page()
		{
		add_menu_page('l66 Datafeeds', 'L66 affiliate', 'administrator', 'l66-admin', 'l66_info');
		add_submenu_page('l66-admin', 'lane66.com shops', 'build a shop', 'administrator', 'l66_pagebuilder', 'l66_pagebuilder');	
		add_submenu_page('l66-admin', 'lane66.com posts', 'convert to post', 'administrator', 'l66_postconvert', 'l66_postconvert');
		add_submenu_page('l66-admin', 'lane66.com upload', 'upload my own csv', 'administrator', 'l66_upload_csv', 'l66_upload_csv');		
		add_submenu_page('l66-admin', 'lane66.com adbuilder', 'linksalt adbuilder', 'administrator', 'l66_linksalt', 'l66_linksalt');	
		add_submenu_page('l66-admin', 'lane66.com database tools', 'LANE66.com tools', 'administrator', 'l66_db_tools', 'l66_db_tools');	
		}
	}

if (!function_exists('l66_pagebuilder'))
	{
	function l66_pagebuilder() 
		{
			include"l66_pagebuilder.php";
		}
	}
	
if (!function_exists('l66_postconvert'))
	{	
	function l66_postconvert() 
		{
			include"l66_postconvert.php";
		}
	}
	
if (!function_exists('l66_upload_csv'))
	{	
	function l66_upload_csv() 
		{
			include"l66_upload_csv.php";
		}
	}

if (!function_exists('l66_linksalt'))
	{	
	function l66_linksalt() 
		{
			include"l66_linksalt.php";
		}
	}
	
if (!function_exists('l66_info'))
	{	
	function l66_info() 
		{
			include"l66_infopage.php";
		}
	}
	
if (!function_exists('l66_tools'))
	{
	function l66_db_tools() 
		{
		   include"l66_db_tools.php";
		}
	}

?>
