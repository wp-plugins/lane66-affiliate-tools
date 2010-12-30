<?PHP
// lane66.com - post builder
include_once('l66_functions.php');
$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

?>
<iframe src="http://lane66.com/plugintop2-news.php" width="100%" height="30" scrolling="no">Your system does not support Iframes so you can not see the latest news</iframe>
<hr>
<div style="padding-left:10px;background-color:lightgreen">
<h2>lane66.com's - convert products to posts</h2>
This is where your can select products from your warehouse and convert them to posts!<br>
While posts are static in the fact that your information will no longer update when the products in your warehouse change, there are still many
 benefits in converting (some products) to posts.<br>
<br>- Converted products act exactly like any other post you write in WordPress
<br>- Any plugin that manipulates posts will also manipulate your converted products (randomizer, related products etc.)
<br>- Posts can have tags and categories and can put focus on individual products.
</div>
<hr>
<?
// set vars and read the db
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





// check is form was filled out // create a page if form is done
if (isset($_POST['post1'])) 
		{
		echo "<div style='width:100%;background-color:#CEF6CE;height:200px;overflow:scroll'>";
		// setting vars
		echo "<h2>Now creating new posts ! </h2>";
		$key = $_POST['shopkeyw'];
		$keyword = $key;
		if (empty($key)) {$key = "NOT SET, Selecting all";}
		echo "Your posts are filtered on keyword <font color='red'><b>".$key."</b></font><br>";		
		echo "The feeds included in your query are : <br>";
		$vals=$_POST['incfeed'];
		foreach ($vals as $feeds) 
			{
			echo "<font color='red'><b>".$feeds."</b></font><br>";
			$thefeeds.=$feeds.",";
			}
		$thefeeds = str_replace(",","' or '",$thefeeds);
		$limit = $_POST['product'];
		global $wpdb;
		$table_name = $wpdb->prefix ."lane66_feeds";
		echo "SELECT * FROM $table_name  WHERE title LIKE '%$keyword%' AND feedname = '$thefeeds' $order LIMIT $limit";
		// DB query
		$view = $wpdb->get_results("SELECT * FROM $table_name  WHERE title LIKE '%$keyword%' AND feedname = '$thefeeds' $order LIMIT $limit"); 

		$I = 0 ;
		foreach ($view as $row) 
		{
		/*
		$content = "<DIV style='font-family:times new roman;font-size:10pt;float:left;height:200px;overflow:hidden;width:300px'>
				<DIV style='text-align:center;font-size:12pt;font-weight:bold;width:98%;height:23px;overflow:hidden;background-color:yellow;'>
				$row->title
				</div>
					<DIV style='float:left;width:30%;height:130px;overflow:hidden'>
			
					<A href='$row->link'><img src='$row->image' width='80'></a>
			
					</div>
					<DIV style='float:left;width:70%;height:130px;overflow:hidden'>
					$row->descr
					</div>
				<DIV style='font-size:14pt;text-align:right;color:red;width:98%;height:20px;overflow:hidden;background-color:lightyellow;'>
				Price : <A href='$row->link'>$row->currency $row->price</a>
				</div>	
				
			</div>";
		*/
		
		$content = "<center><A href='$row->link'><img src='$row->image' width='200'></a><hr>$row->descr<hr><br>Price : <A href='$row->link'>$row->currency $row->price</a></center>";
		$I++;
		// show progress
		echo "Now creating post numer $I with title $row->title<br>";
		// Create post object
			$my_post = array(
			'post_type' => 'post',
			'post_title' => $row->title,
			'post_content' => $content,
			'comment_status' => 'closed',
			'post_status' => 'publish',
			'post_author' => 1,
			'tags_input' => $_POST['tags'],
			);
		// Insert the post into the database
			$l66_post = wp_insert_post( $my_post );
			add_post_meta($l66_post, "_l66_network", $row->network);
			add_post_meta($l66_post, "_l66_feedname", $row->feedname);
			$l66_category = $row->cat.",".$row->cat2.",".$row->cat3;
			$l66_category = str_replace (">",",",$l66_category);
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
		echo "<hr><h2>We've created a total of $I posts</h2>";
		echo "</div>";
		
	}


?>
	<div style="padding-left:10px;background-color:lightgreen">
	<form action="admin.php?page=l66_postconvert" method="post"> 
	<table border='1'>
	<tr>
	
	<td width="350">
	
	If you want your posts to only reflect certain items<br>
	provide a keyword here, otherwise leave blank -><br>
	<input type="text" name="shopkeyw" /><hr>
	(optional) Provide tags for your new posts -><br>
	(comma separated e.g. candles,soap)<br> 
	<input type="text" name="tags" /><hr>
	Would you like to enable comments on your posts ?<br>
	<input type="radio" name="comment" value="on"> yes 
	<input type="radio" name="comment" value="off" checked> No<hr>
	How many posts would you to create ? (max.)<br>
	<input type="radio" name="product" value="1"> 1 
	<input type="radio" name="product" value="10" checked> 10
	<input type="radio" name="product" value="20" > 20 
	<input type="radio" name="product" value="100"
	<?PHP if (get_option('l66_mode') == "freebie") {?>
	onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')"
	<?PHP ;} ?>
	> 100
	<input type="radio" name="product" value="999999"
	<?PHP if (get_option('l66_mode') == "freebie") {?>
	onClick="this.checked=false; alert('Sorry, this option is not available in the free version. Please consider upgrading to PREMIUM membership. You can do so on the bottom of this screen.')"
	<?PHP ;} ?>
	> all of them
	<hr>
	</td><td>
	Now tell us from which feeds I can select products to build posts -><br /> 
<?PHP
foreach ($distinct as $entry) 
		{
	echo "<input type='checkbox' name='incfeed[]' value='".$entry->feedname."' />".$entry->feedname." (".$entry->network.")<br>" ;
		}
?>
	<br>
	</td></tr></table>
	<INPUT TYPE=hidden NAME="post1" VALUE="1">
	<input type="submit" value="Build posts with these settings"/><br>
	
	
</div>



<?PHP include ('l66_footer.php'); ?>	

