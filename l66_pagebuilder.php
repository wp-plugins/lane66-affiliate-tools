<style type="text/css">			
			.round {
			width:98%;
			-moz-border-radius: 10px;
			border-radius: 10px;
			border: 4px solid #ccc;
			padding: 3px;
			}
			.titlebox{
			float:left;
			padding:0 5px;
			margin:-10px 0 0 30px;
			background:#ccc;
			color:white;
			font-weight:900;
			}
			</style>
	<br>
	<div class="round">
	<div class="titlebox">Build a shop filled with products</div>
	<br>
<?PHP
// lane66.com - pagebuilder
include_once('l66_functions.php');
if (function_exists('l66_checkdb')) {l66_checkdb();}
$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
if (isset($_GET['l66info'])) {update_option('l66-info',$_GET['l66info']);}
$chk = $x."pics/chkgrn.gif";
if (get_option('l66-info','max') == "min"){ echo "<img src=$chk> " ; } ?>	
<a href="admin.php?page=l66_pagebuilder&l66info=min"><font color='green'>less info</font></a>|
<?PHP if (get_option('l66-info','max') == "max"){ echo "<img src=$chk> " ; } ?>
<a href="admin.php?page=l66_pagebuilder&l66info=max">show help & info</a>

<iframe src="http://lane66.com/l66/plugintop2-news.php" width="100%" height="30" scrolling="no">Your system does not support Iframes so you can not see the latest news</iframe>
<hr>
<div style="padding-left:10px;background-color:lightgreen">
<h2>lane66.com's pagebuilder</h2>
This is where your shops are built !<br>
	<?PHP if (get_option('l66-info','max') == "max")
		{ 
		?>
		<font color='green'><h3>Close additional info & de-clutter by clicking 'less info' on the top left corner of your screen'</h3></font>
		With the tools below you can create one or more pages in your blog that shows off your affiliate products ! Either :<br>
		<br>1. build a page around a keyword (e.g. "Shoes" to build a shoe-store), 
		<br>2. select and combine certain merchants or datafeeds to show in your affiliate page
		<br>3. show all your products in the shop and let customers select and find products with the search-options
		<center><object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/iVMKelEETyQ?fs=1&amp;hl=nl_NL"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/iVMKelEETyQ?fs=1&amp;hl=nl_NL" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>
		<?PHP 
		} ?>

</div>

<?PHP
// set vars and read the db
global $wpdb;
$table_name = $wpdb->prefix ."lane66_feeds";
$nums = $wpdb->get_var("SELECT COUNT(*) FROM $table_name"); // find total number of products
$view = $wpdb->get_results("SELECT DISTINCT feedname,network FROM $table_name "); // select distinct feeds
$nums = (int)$nums;
if ($nums < 10) {exit ("<a href='http://portaljumper.com' target='_blank'><img src='".$x."pics/fm.jpg' width='64' height='64' title='Made possible in part by team feed-monster from http://portaljumper.com'></a><font color='red'><h3>Oh No ! You have less than 10 products in your 'warehouse'. Not enough to build a page right now !</h3>
You should try to add more datafeeds to your warehouse first.<br>Why not try uploading your own CSV Datafeed, or maybe use one of the automated datafeed loaders!<br>
Once you have more products in your warehouse, come back here and build some cool sales-pages and shops !</font>");}
echo "<img src='".$x."pics/fm.jpg' width='16' height='16' title='Made possible in part by team feed-monster from http://portaljumper.com'><b> Congrats ! You currently have ".$nums." products in your warehouse</b>. More than enough to build a shop !";


// check is form was filled out // create a page if form is done
if (isset($_POST['select1'])) 
		{
		if (empty($_POST['incfeed']))
		{echo "<hr><font color='red'><b>you did not select any products to be included in your shop</b></font>";}
		else
		{
		if (empty($_POST['shoptitle']))	{$_POST['shoptitle'] = "lane66.com shops";}	
		echo "<h2>CHECK IT OUT ! A new page named <font color='blue'>".$_POST['shoptitle']."</font> was created ! </h2>";
		$key = $_POST['shopkeyw'];
		if (empty($key)) {$key='notset';}
		echo "<b>The keyword (if any) for this shop is </b><font color='red'><b>".$key."</b></font><br>";
		echo "<b>The feeds included are : </b><br>";
		foreach ($_POST['incfeed'] as $feeds) 
			{
			echo "<font color='red'><b>$feeds</b></font><br>";
			$thefeeds.=$feeds.",";
			}

		$thefeeds = str_replace(" ","+",$thefeeds);
	
		$content = "[l66 key=".$key." feeds=".$thefeeds." product=".$_POST['product']." order=".$_POST['order']." layout=".$_POST['layout']."]";
		
		// Create post object
			$my_post = array(
			'post_type' => 'page',
			'post_title' => $_POST['shoptitle'],
			'post_content' => $content,
			'comment_status' => $_POST['comment'],
			'post_status' => 'publish',
			'post_author' => 1,  );
		// Insert the post into the database
			$pageID = wp_insert_post( $my_post );
			echo "<br><b>Note that the actual URl to your new page depends on your permalink settings.</b><br>Your new page can be found here : ";
$permalink = get_permalink( $pageID ); echo "<a href='$permalink' target='_BLANK'>$permalink</a>";
		}
		}


?>
		<div style="background-color:#CEF6CE;width:100%;height:250px">
			<div style="float:left;background-color:#CEF6CE;width:50%;height:250px">
				<form action="admin.php?page=l66_pagebuilder" method="post"> 
				Your new shop acts as a PAGE in wordpress.<br>
				Please provide a title for your new shop -><br> 
				<input type="text" name="shoptitle" /><hr>
				If you want your shop to only show certain items<br>
				provide a keyword here, otherwise leave blank -><br>
				<input type="text" name="shopkeyw" /><hr>
				Would you like to enable comments on your shop ?<br>
				<input type="radio" name="comment" value="open"> yes 
				<input type="radio" name="comment" value="closed" checked> No<hr>
				How many products would you like in your shop ?<br>
				<input type="radio" name="product" value="4"> 4 
				<input type="radio" name="product" value="10" checked> 10
				<input type="radio" name="product" value="12"> 12
				<input type="radio" name="product" value="20" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')" <?PHP ;} ?>
				> 20 
				<input type="radio" name="product" value="100" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')" <?PHP ;} ?>
				> 100
				<input type="radio" name="product" value="999999" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')" <?PHP ;} ?>
				> all of them **
				<hr><br>
			</div>
			
			<div style="float:left;background-color:#CEF6CE;height:50px">
				Show your products in which order ?<br>
				<input type="radio" name="order" value="ltoh" checked> low to high price
				<input type="radio" name="order" value="htol"> high to low price 
				<input type="radio" name="order" value="alpha"> A - Z
				<input type="radio" name="order" value="alpha2"> Z - A
				<hr>
				
				<div>
					Now tell us which feeds you want to include in your shop -><br /> 
				</div>
				
				<div style="height:180px;overflow:scroll;background-color:lightgreen;">
					<?PHP
					foreach ($view as $row) 
							{
						echo "<input type='checkbox' name='incfeed[]' value='".$row->feedname."' />".$row->feedname." (".$row->network.")<br>" ;
							}
					?>
						<br>
				</div>
			</div>
		</div>

		<div style="clear:both;background-color:#CEF6CE">

		<?PHP
		// go fetch available layouts and return as form function
		$bl = get_bloginfo('wpurl');
		$view = 1;
		if (get_option('l66_modus') != "PREMIUM") $view=2;
		$lay = "http://lane66.com/l66/layouttry.php?iam=".$bl."&view=$view";
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$lay);
		curl_setopt($ch,CURLOPT_FRESH_CONNECT,TRUE);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,12);
		if(curl_exec($ch) === false) {echo "<br><font color='red'>Curl error !<br>This needs to be fixed first before you can proceed !</font> " . curl_error($ch);}
		$layouts = curl_exec($ch);
		curl_close($ch);
		echo $layouts;
		?>
		<INPUT TYPE=hidden NAME="select1" VALUE="1">
			<input type="submit" style="background-color:yellow;" value="Build a shop-page with these settings"/><br>
		</div>
<br>
</div>




	




<div style="clear:both"></div>
<?PHP include ('l66_footer.php'); ?>	

