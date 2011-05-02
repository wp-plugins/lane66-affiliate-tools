<?PHP
// lane66.com - post builder
		
include_once('l66_functions.php');
$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
if (function_exists('l66_checkdb')) {l66_checkdb();}

?>

		<script>			
		function clearText(thefield){
		if (thefield.defaultValue==thefield.value)
		thefield.value = ""
		} 
		</script>
<a href="admin.php?page=l66_postconvert&l66info=min"><font color='green'>less info</font></a>|<a href="admin.php?page=l66_postconvert&l66info=max">show help & info</a>
<?PHP if (isset($_GET['l66info'])) {update_option('l66-info',$_GET['l66info']);} ?>



<iframe src="http://lane66.com/l66/plugintop2-news.php" width="100%" height="30" scrolling="no">Your system does not support Iframes so you can not see the latest news</iframe>
<hr>
<?PHP if (get_option('l66-info','max') == "max"){ echo "
<div style='padding-left:10px;background-color:lightgreen'>
<h2>lane66.com's - convert products to posts</h2>
This is where your can select products from your warehouse and convert them to posts!<br>
While posts are static in the fact that your information will no longer update when the products in your warehouse change, there are still many
 benefits in converting (some products) to posts.<br>
<br>- Converted products act exactly like any other post you write in WordPress
<br>- Any plugin that manipulates posts will also manipulate your converted products (randomizer, related products etc.)
<br>- Posts can have tags and categories and can put focus on individual products.
</div>
<hr>
";}

global $wpdb;
$table_name = $wpdb->prefix ."lane66_feeds";
$nums = $wpdb->get_var("SELECT COUNT(*) FROM $table_name"); // find total number of products
$distinct = $wpdb->get_results("SELECT DISTINCT feedname,network FROM $table_name "); // select distinct feeds
$nums = (int)$nums;
if ($nums < 10) {exit ("<a href='http://portaljumper.com' target='_blank'><img src='".$x."pics/fm.jpg' width='64' height='64' title='Made possible in part by team feed-monster from http://portaljumper.com'></a><font color='red'><h3>Oh No ! You have less than 10 products in your 'warehouse'. Not enough to build a page right now !</h3>
You should try to add more datafeeds to your warehouse first.<br>Why not try uploading your own CSV Datafeed, or maybe use one of the automated datafeed loaders!<br>
Once you have more products in your warehouse, come back here and convert some cool posts !</font>");}
echo "<b>Congrats ! You currently have ".$nums." products in your warehouse</b>. More than enough to start converting products to posts !";
echo "<hr>" ;

if (get_option('l66-info','max') == "max"){ echo "
If you select to create a large number of posts and your server runs a little slow, your plugin may run out of time and throw an error.
In that case simply rebuild posts with the same settings. The built-in filters will automatically check and skip/prevent duplicate postings.
If you need more products to select from, use the built-in csv uploader or grab a dedicated add-on that can pull feeds directly from your affiliate networks.

<br>";}



// check is form was filled out // create a page if form is done
if (isset($_POST['post1'])) 
		{
		echo "<div style='width:100%;background-color:#CEF6CE;height:200px;overflow:scroll'>";
		// setting vars
		echo "<h2>Now creating new posts ! </h2>";
		$picsize = $_POST['picsize'];
		$key = $_POST['shopkeyw'];
		$keyword = $key;
		if (empty($key)) {$key = "NOT SET, Selecting all";}
		echo "Your posts are filtered on keyword <font color='red'><b>".$key."</b></font><br>";		
		echo "The feeds included in your query are : ";
		$vals=$_POST['incfeed'];
		if (empty($vals)) 
			{
			echo'<h2><font color="red">you did not select any feeds that I can choose from ! Please try again.</font></h2>';echo "</div>";
			}
		else
			{
			foreach ($vals as $feeds) 
				{
				echo "<font color='red'><b>".$feeds."</b></font><br>";
				$thefeeds.=$feeds.",";
				}
			$thefeeds = str_replace(",","' or '",$thefeeds);
			$limit = $_POST['product'];
			global $wpdb;
			$table_name = $wpdb->prefix ."lane66_feeds";
			// DB query
			$view = $wpdb->get_results("SELECT * FROM $table_name  WHERE title LIKE '%$keyword%' AND feedname = '$thefeeds' $order "); 
			// $view = $wpdb->get_results("SELECT * FROM $table_name  WHERE title LIKE '%$keyword%' AND feedname = '$thefeeds' $order LIMIT $limit"); 

			$I = 0 ;
			
			foreach ($view as $row) 
			{
			
			$content = "<div style='width:100%;overflow:hidden;text-align:center;'><A href='$row->link' title='$row->descr'><img src='$row->image' width='$picsize' alt='lane66.com datafeed loader'></a><hr>$row->descr<hr><br>Price : <A href='$row->link' title='$row->title'>$row->currency $row->price</a></div>";
			
			if (get_option('l66_modus') != "PREMIUM") 
				{
				$content.="<hr><div style='text-align:center;color:#BDBDBD;font-size:10px;'>I am using a free version of <a href='http://lane66.com' title='lane66.com builds professional affiliate plugins to help you make money with datafeeds. Most of their plugins are free. Visit them now ....'>lane66.com</a> affiliate tools PRO-series</div>";
				}
				
				// skipnopic skip

				$user_count = $wpdb->get_var($wpdb->prepare("SELECT id FROM $wpdb->posts WHERE post_title = '$row->title' ;"));
				
				if ($user_count > 0) {echo "<font color='green'>skipping post - duplicate post titled $row->title was found<br></font>" ;}	
				elseif (($_POST['skipnopic'] == "off") || ($_POST['skipnopic'] == "on" && (!empty($row->image))))
					{
						// increase count
						$I++;
						// show progress
						echo "<b>Now creating post numer $I with title $row->title</b><br>";
						// Create post object
							$my_post = array(
							'post_type' => 'post',
							'post_title' => $row->title,
							'post_content' => $content,
							'comment_status' => $_POST['comment'],
							'post_status' => $_POST['l66-status'],
							'post_author' => 1,
							'tags_input' => $_POST['tags'],
							);
						// Insert the post into the database
							$l66_post = wp_insert_post( $my_post );
							add_post_meta($l66_post, "_l66_network", $row->network);
							add_post_meta($l66_post, "_l66_feedname", $row->feedname);
							$l66_category = $row->cat.",".$row->cat2.",".$row->cat3;
							$l66_category = str_replace (">",",",$l66_category);
							$l66_category = str_replace ("/",",",$l66_category);
							$l66_category = preg_replace('/[^A-Za-z0-9,>< ]/', '', $l66_category);
								$cattoadd = explode (",",$l66_category);
									$cattoaddtemp2 = array("");
									foreach($cattoadd as $i => $v) 
									{
										$v=trim($v);
										if(empty($v)) 
											{
											unset($cattoadd[$i]);
											}	
										l66_create_category($v);
										$cattoaddtemp1 = array($v);
										$cattoaddtemp2 = array_merge((array)$cattoaddtemp1,(array)$cattoaddtemp2);				
									}
									
									$ok = wp_set_object_terms($l66_post, $cattoaddtemp2, 'category');
					
					
					
					
					
					
					
					}
			if ($I == $limit) break;
			set_time_limit(0);		
			}
			
			
			
			
					if ($I == 0) 
					{
					echo "<hr><h3>Sorry ! I could not find any products matching your request.</h3>";
					}
					else
					{
					echo "<hr><h2>We've created a total of $I posts</h2>";
					}
			echo "</div>";
			
			
			// ok to run if feeds selected
			}
		
	}


?>
	<div style="padding-left:10px;background-color:lightgreen">
	<form action="admin.php?page=l66_postconvert" method="post"> 
	<div style="float:left;width:350px">
	
	If you want your posts to only reflect certain items<br>
	provide a keyword here, otherwise leave blank -><br>
	<input type="text" name="shopkeyw" size="40"/><hr>
	(optional) Provide tags for your new posts -><br>
	(comma separated e.g. candles,soap)<br> 		
	<input type="text" name="tags" value="lane66.com,portaljumper.com" size="40" onFocus="clearText(this)"/> <hr>
	Would you like to enable comments on your posts ?<br>
	<input type="radio" name="comment" value="open"> yes 
	<input type="radio" name="comment" value="closed" checked> No<hr>
	ignore/skip products that do not have images ?<br>
	<input type="radio" name="skipnopic" value="on" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')"<?PHP ;} ?>> yes 
	<input type="radio" name="skipnopic" value="off" checked> No<hr>
	What size should the images be ? (in pixels wide)<br>
	<input type="radio" name="picsize" value="150"> 150px 
	<input type="radio" name="picsize" value="200" checked> 200px
	<input type="radio" name="picsize" value="250" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')" <?PHP ;} ?> > 250px 
	<input type="radio" name="picsize" value="400" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')" <?PHP ;} ?> > 400
	<input type="radio" name="picsize" value="FULL" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')" <?PHP ;} ?> > FULL
	<hr>
	what status should the new posts have ?<br>
	<input type="radio" name="l66-status" value="publish" checked> publish 
	<input type="radio" name="l66-status" value="pending" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')"<?PHP ;} ?>> pending review
	<input type="radio" name="l66-status" value="draft" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')"<?PHP ;} ?>> draft 
	<input type="radio" name="l66-status" value="private" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')"<?PHP ;} ?>> private 
	<hr>
	How many posts should I create ? (max.)<br>
	<input type="radio" name="product" value="1"> 1 
	<input type="radio" name="product" value="10" checked> 10
	<input type="radio" name="product" value="20" > 20 
	<input type="radio" name="product" value="100" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')" <?PHP ;} ?> > 100
	<input type="radio" name="product" value="999999" <?PHP if (get_option('l66_modus') != "PREMIUM") {?> onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')" <?PHP ;} ?> > all of them
	</div>
		<div style="float:left">
			<div>
			<h3>Select some feeds from which I can select products to build posts -></h3> 
			</div>
				<div style="margin-left:20px;height:300px;overflow:scroll;background-color:#F8ECE0">
				<?PHP
				foreach ($distinct as $entry) 
						{
					echo "<input type='checkbox' name='incfeed[]' value='".$entry->feedname."' />".$entry->feedname." (".$entry->network.")<br>" ;
						}
				?>
				</div>
		</div>
	
	<div style="clear:both;text-align:center;">
	<?PHP if ((get_option('l66_freebie_count') > 50000) && (get_option('l66_modus')!= "PREMIUM") )
	{echo "50.000 hits in freebie mode ? Come on .... that's system abuse. I am now blocking options. Please upgrade to premium !";} else { ?>
	<INPUT TYPE=hidden NAME="post1" VALUE="1">
	<input type="submit" style="background-color:yellow;" value="Build posts with these settings"/><br>
	<?PHP ;} ?>
	</div>
	
</div>



<?PHP include ('l66_footer.php'); ?>	

