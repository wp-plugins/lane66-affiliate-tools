<?PHP
// l66_functions
error_reporting(0);
// set some standard stuff
global $wpdb;
$table_name = $wpdb->prefix ."lane66_feeds";
wp_enqueue_style('thickbox'); // <!-- inserting style sheet for Thickbox.  -->
wp_enqueue_script('jquery'); // <!--  including jquery. -->
wp_enqueue_script('thickbox'); // thickbox javascript
// check and if needed build database table
function l66_checkdb()
{
global $wpdb;
   $table_name = $wpdb->prefix . "lane66_feeds";
   $check = mysql_query ("SELECT * FROM `$table_name` LIMIT 0,1");
   if(!$check)
    {	
		echo "<div style='background-color:red;color:white'>Writing tables ! This is a one-time process - reload page or just continue !</div>";
		 mysql_query("CREATE TABLE " . $table_name . " (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  network VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  merchantid VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  feedname VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  sku VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	  
		  title VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  descr TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cat TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cat2 TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cat3 TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  tags TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  link TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  image TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  price TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  retailprice VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  currency VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cust1 VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cust2 VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cust3 VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  timein int(10) DEFAULT '0' NOT NULL,
		  timeupdate int(10) DEFAULT '0' NOT NULL,
		  manual TINYINT(2) DEFAULT '0' NOT NULL,
		  UNIQUE KEY id (id),
		  UNIQUE KEY title (title)
		)") 
		or die(mysql_error());
	}
}
//  CONSTRAINT key_unique UNIQUE(sku),
///////////////////////////////////////////////////////////////////////////////////////////////////////


function l66_iscurlsupported(){
if (in_array ('curl', get_loaded_extensions())) {
return true;
}
else{
return false;
}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////

function l66_shortcode($atts)
{
	ob_start();
$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$W = 0;
$brand = 0;
global $wpdb;
$table_name = $wpdb->prefix ."lane66_feeds";
$keyword = $atts['key'];
if ($keyword == "notset") {$keyword = ""; $sqlsearch = "";} else
{$sqlsearch = "AND (title LIKE '%$keyword%' OR descr like '%$keyword%')";}

																						//echo "KEYWORD".$keyword;
$thefeeds = $atts['feeds'];
$thefeeds = str_replace("+"," ",$thefeeds);
$thefeeds = str_replace(",","' or feedname = '",$thefeeds); // 'Online Sports' or 'Young Lovers'
																						//echo "<br>feeds : ".$thefeeds."<hr>";
$limit = $atts['product']; $limit = (int)$limit;// amt of prods
																						//echo "limits".$limit."<hr>";
$order = $atts['order']; 
if ($order == "ltoh") {$order = "ORDER BY price ASC";}
if ($order == "htol") {$order = "ORDER BY price DESC";}
if ($order == "alpha") {$order = "ORDER BY title ASC";}
if ($order == "alpha2") {$order = "ORDER BY title DESC";}
																						//echo "order".$order."<hr>";
$layout = $atts['layout'];

// run DB query
//$view = $wpdb->get_results("SELECT * FROM $table_name  WHERE title,descr LIKE '%$keyword%' AND feedname = '$thefeeds' $order LIMIT $limit"); 
// fetch layout
if ((get_option('l66_freebie_count') > 42000) && (get_option('l66_modus')!= "PREMIUM") )
{echo "This account was overextended. Please <a href='http://portaljumper.com/shop'>upgrade</a> or stop using lane66 !";} else
{@include "layout/layout".$layout.".php"; }
if ($brand == 0) {echo "<hr><div style='clear:both;text-align:center;color:#BDBDBD'>Created with <a href='http://lane66.com'>lane66.com</a> affiliate tools PRO-series</div>";
$brand = 0;}
$list = ob_get_clean();
	return $list;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
function l66_check() {
$who = get_bloginfo('url');
$version = get_option('l66_version');
$adm = get_option('admin_email');
$bl = get_bloginfo('wpurl');
$chk = "http://lane66.com/l66/gopro2.php?iam=".$bl."&req=1&adm=".$adm."&ver=".$version."&who=".$who;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$chk);
curl_setopt($ch,CURLOPT_FRESH_CONNECT,TRUE);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,8);
//if(curl_exec($ch) === false) {echo "<br><font color='red'>Curl error ! This needs to be fixed first before you can proceed ! (But first we suggest you re-try again, sometimes your system is just too slow to respond and I throw an erroneous error.)</font> " . curl_error($ch);}
$dat = curl_exec($ch);
curl_close($ch);
$dat = trim($dat);
$dat = explode("|",$dat);
update_option('l66_modus',$dat[0]);
update_option('l66_freebie_count',$dat[1]);
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
/*
global $wpdb;
	class wm_mypost 
	{
		var $post_content;
		var $post_title;    
		var $post_status;    
		var $post_author = 1;			
	}
*/
///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////

function l66_category_exists($cat_name, $parent = 0) {
	$id = term_exists($cat_name, 'category', $parent);
	if ( is_array($id) )
		$id = $id['term_id'];
	return $id;
}


function l66_create_category( $cat_name, $parent = 0 ) {
	if ( $id = l66_category_exists($cat_name, $parent) )
		return $id;

	return l66_insert_category( array('cat_name' => $cat_name, 'category_parent' => $parent) );
}

function l66_insert_category($catarr, $wp_error = false) {
	$cat_defaults = array('cat_ID' => 0, 'taxonomy' => 'category', 'cat_name' => '', 'category_description' => '', 'category_nicename' => '', 'category_parent' => '');
	$catarr = wp_parse_args($catarr, $cat_defaults);
	extract($catarr, EXTR_SKIP);

	if ( trim( $cat_name ) == '' ) {
		if ( ! $wp_error )
			return 0;
		else
			return new WP_Error( 'cat_name', __('You did not enter a category name.') );
	}

	$cat_ID = (int) $cat_ID;

	// Are we updating or creating?
	if ( !empty ($cat_ID) )
		$update = true;
	else
		$update = false;

	$name = $cat_name;
	$description = $category_description;
	$slug = $category_nicename;
	$parent = $category_parent;

	$parent = (int) $parent;
	if ( $parent < 0 )
		$parent = 0;

	if ( empty($parent) || !category_exists( $parent ) || ($cat_ID && cat_is_ancestor_of($cat_ID, $parent) ) )
		$parent = 0;

	$args = compact('name', 'slug', 'parent', 'description');

	if ( $update )
		$cat_ID = wp_update_term($cat_ID, $taxonomy, $args);
	else
		$cat_ID = wp_insert_term($cat_name, $taxonomy, $args);

	if ( is_wp_error($cat_ID) ) {
		if ( $wp_error )
			return $cat_ID;
		else
			return 0;
	}

	return $cat_ID['term_id'];
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
