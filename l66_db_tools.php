<iframe src="http://lane66.com/l66/plugintop2-news.php" width="100%" height="30" scrolling="no">Your system does not support Iframes so you can not see the latest news</iframe>
<hr>
<?PHP
// lane66.com database tools - by Pete Scheepens 
include_once('l66_functions.php');


echo "<h2>You are currently operating in <font color='blue'>".get_option('l66_modus')."</font> mode !</h2>";



global $wpdb;
$table_name = $wpdb->prefix ."lane66_feeds";
$nums = $wpdb->get_var("SELECT COUNT(*) FROM $table_name"); // find total number of products
$maxmerch = $wpdb->get_var("SELECT COUNT(DISTINCT feedname) FROM $table_name"); // number of distinct feeds
$view = $wpdb->get_results("SELECT DISTINCT feedname,network FROM $table_name "); // select distinct feeds
$nums = (int)$nums;
echo "total number of products in the lane66 warehouse :<font color='blue'> $nums </font><br>";
echo "These combined products are from <font color='blue'> $maxmerch </font> different feeds/merchants.<br>";
?>
<p align='center'><center>
						<div style="width:650px;text-align:left;height:100px;padding:5px;overflow:auto;border:1px solid #ccc">
						<form name="l66_db_tools1" enctype="multipart/form-data" method="post" action="admin.php?page=l66_db_tools">
			<?PHP 
										

			foreach ($view as $row) 
					{
				echo "<input type='checkbox' name='list1[]' value='$row->feedname'> delete -> ";
				echo "<font color='blue'> ".$row->feedname." (".$row->network.")</font>";
				$prods = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE feedname='$row->feedname'"); // number of distinct feeds
				echo " $prods products. <br>";
					}		
			?>
						</div>
						<input type="hidden" name="deletefeed" value="Y">
						<?PHP 
						if (get_option('l66_modus') != "freebie") {?> <input type="submit" name="Submit" value="<?php _e('delete these feeds from the database')?>" /> <?PHP ;} 
						else {echo "<font color='blue'>Sorry, premium members only !</font>";}
						?>
						
						</form>	
			<?PHP
			if (isset($_POST['list1']) && $_POST['deletefeed'] == "Y") 
			{foreach ($_POST['list1'] as $delete) {echo "<br><font color='red'><b>I JUST DELETED </b> : ".$delete." RELOAD PAGE TO SEE NEW STATS.</font>"; $wpdb->query("DELETE FROM `$table_name` WHERE feedname='$delete' ");} }
			?>		
<hr>

Click the button below to wipe the entire lane66.com database clean.<br><b><font color='red'>**** WARNING ****</font></b><br> there will be NO way back once you click this button. All your affiliate products will instantly be removed.<br>
<form name="kill_table" enctype="multipart/form-data" method="post">
<input type="hidden" name="killit" value="Y" >
<?PHP 
if (get_option('l66_modus') != "freebie") {?> <input type="submit" name="Submit" value="<?php _e('Destroy and remove all products from the affiliate database ?')?>"> <?PHP ;} 
else {echo "<font color='blue'>Sorry, premium members only !</font>";}
?>
</form>	
<?PHP
if (isset($_POST['killit']) && $_POST['killit'] == "Y") {$wpdb->query("TRUNCATE `$table_name`"); echo "I've deleted all your products. Your lane66.com database is now EMPTY !<br>You might as well leave this page since you chose to destroy everything.<br>Really.... there is nothing left to do here ...";}
?>
</p>

<!-- check upload directory for files -->
<HR>
Below is a list of items in your upload directory (As also used by the "upload my own csv" tool). Select items some to delete them.<br>

						
						<?PHP
						// check other files in directory and use selector
							$uploads = wp_upload_dir();
							 echo "content of ".$uploads['path'];
						?>
						<div style="width:450px;text-align:left;height:100px;padding:5px;overflow:auto;border:1px solid #ccc">
						<form name="l66_db_tools" enctype="multipart/form-data" method="post" action="admin.php?page=l66_db_tools"><?PHP	 
							if ($dir = opendir($uploads['path']))
							{
								 while (false !== ($olderfile = readdir($dir))) 
								{
									if ($olderfile != "." && $olderfile != "..") echo "<input type='checkbox' name='list[]' value='$olderfile'>$olderfile<br>";
								}

							}
							closedir($dir);
						?>
						</div>
						<input type="hidden" name="delete" value="Y">
						<input type="submit" name="Submit" value="<?php _e('delete these items from the upload directory')?>" />
						</form>	
						<?PHP
						if (isset($_POST['list']) && $_POST['delete'] == "Y") 
						{foreach ($_POST['list'] as $delete) {echo "<br><b>now deleting</b> :".$uploads['path']."/".$delete; @unlink ($uploads['path']."/".$delete);} }
						
include ('l66_footer.php'); ?>	
<div style="clear:both">
<h3>Our "site-in-a-box" - You can post all lane66.com related posts here !</h3>
<iframe src="http://lane66.com/forum" width="100%" height="2000" scrolling="no"></iframe>	
</div>				