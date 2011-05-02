<?PHP
// info page for l66 loader
include_once('l66_functions.php');
if (function_exists('l66_checkdb')) {l66_checkdb();}
$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$bl = get_bloginfo('wpurl');
echo "<small>Site $bl is currently operating in <font color='blue'>".get_option('l66_modus')."</font> mode !</small>";

?>
<center><h2>Lane66.com professional affiliate tools</h2><h4>1.-> configuration 2.-> Feeders 3.-> builders</h4></center>
<hr>
<div style="float:left">
<a href="http://portaljumper.com" target="_blank"><img src='<?PHP echo $x."pics/fm.jpg"; ?>' width='65' height='65' title='Lane66.com was made possible in part by team feed-monster from http://portaljumper.com'></a>
</div>
Congratulations on making the choice to start earning an income through affiliate marketing. We're here to help with our
 professional affiliate tools, based on real-world experience. The teams that brought you affiliate plugins 
 for WordPress like feed-monster, sharasale loaders, widgets etc. have combined forces and have raised the bar.
 <hr>
 <h3>using the lane66 tools -> putting products in your warehouse</h3>
 The lane66 plugins consist of logical and color-coded steps to automate your datafeed affiliate shops.<br>
 * Throughout this plugin you will find red-colored <font color='red'>Configuration pages</font>. There you perform one-time
 setups for passwords, tokens, preferences etc.<br>
 * <font color='orange'>Feeder-pages</font> are yellow/orange colored. On these pages you find tools to pump datafeeds into your lane66 database. The CORE already contains CSV upload options 
 but you can get many add-on's and various affiliate network tools to automatically put datafeeds or "products" into your database or "warehouse". Most of these tools make direct contact
 with your information on the network servers. Visit lane66.com for more info on these tools and add-on's.<br> 
 * Once products are loaded into your warehouse you can instantly build using <font color='green'>(green) builder pages.</font> The builder pages can make
  many-products-on-a-page shops with unlimited layouts, or they can turn your database products in to wordpress posts. Either all at once, or through calm dripfeeds.
  Enhanced use of lane66 widgets will really jumpstart your earnings. Find some free ones at lane66.com too.
 <h3>Using products to build a shop</h3>
 To build a "shop" (or a wordpress page with products) you need to first have products in your warehouse. You can start building as many shops as you
  want by using our "build a shop" tool that is standard issue with the CORE module. You can select products based on keywords, datafeeds or merchants and set a whole range of other options.
 <h3>Using products to build posts</h3>
 You can also take products from your warehouse and turn them into genuine wordpress posts. These posts act and look exactly the same as 
 any other post you would write in WordPress. These posts can be manipulated by your favorite themes or 3rd party plugins, giving you the power of 100.000 developers and their products.
<h3>Many extra features</h3>
Of course you will find many extra's peppered throughout our plugin. Just go explore and find: Different lay-outs, 
API connectors, and extended feed settings. Most importantly you may find proof of a very active support team that will listen
 to your requests and will build features you request into the new versions as they constantly develop further.
 <p align='center'><b>For the latest developments please visit lane66.com</b></p>
 
<?PHP include ('l66_footer.php'); ?>