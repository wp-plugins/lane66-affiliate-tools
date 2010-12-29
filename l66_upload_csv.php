<?PHP
// wp plugin - upload your own csv datafeed
// lane66.com - designed and developed by Pete Scheepens - all intellectual property rights reserved.
include_once('l66_functions.php');
$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
?>

<?PHP if (isset($_POST['preset'])) {update_option('l66-separate',stripslashes($_POST['preset']));}
$del = get_option('l66-separate',"|");
?>
<iframe src="http://lane66.com/plugintop2-news.php" width="100%" height="30" scrolling="no">Your system does not support Iframes so you can not see the latest news</iframe>
<hr>
<div style="padding-left:10px;background-color:lightyellow">
	<h2>lane66.com - upload your own csv file | convert feeds to warehouse products</h2>
	Locate your own CSV datafile on your computer and upload it to the warehouse. Once your datafeed is converted and the products have
	 been placed in the warehouse (database) you can build fancy shops with them or convert them to pretty posts by using the appropriate menu-options.<hr>	 
	 </div>
<div style="float:left;background-color:yellow;height:32px;padding:1px 20px;">
	<!-- form for upload -->
	<form name="l66_upload_file" enctype="multipart/form-data" method="post">
		<input type="hidden" name="upload" value="Y">
		<input type="file" name="sponsor_file">
		
			<input type="submit" name="Submit" value="<?php _e('Upload my csv file!')?>" >
	</form>
</div>
<div style="float:left;background-color:yellow;height:32px;padding:1px 5px;">
- OR - 
</div>	
<div style="float:left;background-color:yellow;height:32px;padding:1px 20px;">
						<!-- form for previous files --> 
						
						<form name="l66_upload_file" enctype="multipart/form-data" method="post">
						<select name='fexist'>
						<?PHP
						// check other files in directory and use selector
								$uploads = wp_upload_dir();
							 echo $uploads['path'];
							 
							if ($dir = opendir($uploads['path']))
							{
							echo " directory is $dir\n";
								 while (false !== ($olderfile = readdir($dir))) 
								{
									if ($olderfile != "." && $olderfile != "..") echo "<option value='$olderfile'>$olderfile</option>";
								}

							}
							closedir($dir);
						?>
						</select>
						<input type="hidden" name="before" value="Y">
						<input type="submit" name="Submit" value="<?php _e('use an existing file')?>" />
						</form>	
</div>
<div style="clear:both"><div>	
	<?php
	
// upload a CSV feed into the warehouse
if( $_POST['upload'] == 'Y' ) 
	{
		if($_FILES['sponsor_file']['error'] === 0) 
		{
			$upload = wp_upload_bits($_FILES["sponsor_file"]["name"], null, file_get_contents($_FILES["sponsor_file"]["tmp_name"]));
			$file_location = $upload[file];
   	  		update_option( "l66_file_location", $file_location );
			if (substr($file_location,-3) == "zip") // nogo on zip
			{exit ('<font color="red">I am not clear on this file. Please upload files with .txt , .GZ or .csv extensions only !</font>');}
			echo "<h2>File uploaded Successfully</h2>";
		}
	}
if( $_POST['before'] == 'Y' ) 
	{
	$file_location = $uploads['path']."/".$_POST['fexist'];
	echo $file_location;
	update_option( "l66_file_location", $file_location );
	if (substr($file_location,-3) == "zip") // nogo on zip
	{exit ('<font color="red">I am not clear on this file. Please upload files with .txt , .GZ or .csv extensions only !</font>');}
	echo "<h2>File uploaded Successfully</h2>";
	}
	// determine separator
	
	?>
						
								
	

<hr>
<?php $display_fl = get_option( "l66_file_location" ); echo"<b>Now working with: $display_fl</b>";?>
<br>=-> Select a delimiter below and click "change delimiter !"
<br>=-> Match your columns ... Many times the column order or column names in your feed do not match. Below you can select the columns from your datafile and match them with the correct database entries. If you do not like the choices that
your datafeed provides you or if you want to overrule a certain field you can use the manual override boxes. Anything you type in the manual override boxes will be fixed in place for
 this entire datafeed. (It's great for setting tags or replacing links with 1 fixed link etc. Be creative ....<hr>
<?PHP
				// show preview of columns
						$file = get_option( "l66_file_location" );
						if (substr($file,-2) == "gz"){$content = gzfile($file);} else {$content = file($file);}
						echo "<b>Here is the first line from your CSV file. Please tell me what character is used to delimit the fields</b><br>";
						$content = str_replace("\t","{tab}",$content);
						echo "<font color='blue'>".substr($content[0],0,70).".......</font>";
				?>	
<form name="read_csv" enctype="multipart/form-data" method="post" action="admin.php?page=l66_upload_csv">				
Currently selected : <font color='blue'><b> <?PHP echo $del; ?> </b></font> Now Look above and tell me how this feed is separated:
<select name="preset">
<option value="|" selected> a single pipe | </option>
<option value=";">a semi-colon ; </option>
<option value="tab">a tab-space TAB </option>
<option value=",">A comma , </option>
</select>
<input type="submit" name="Submit" value="<?php _e('change delimiter !')?>" />	
</form>

 <form name="read_csv" enctype="multipart/form-data" method="post">
<div width=100%>
<hr>
Please note: Hitting the checkbox in the red area will push the feed directly into the database. Please hit "Process feed!" without checking the box
 as much as needed until you are satisfied with your preview (Do it now!) When your preview is good, check the box and hit "Proceed.." again to fill database.	
<hr>
 <div style="float:left;width:100px;overflow:hidden;font-weight:bold;font-size:14px;background-color:lightyellow">
<b>database</b><hr>
<div style="height:26px;color:red">Network</div>
<div style="height:26px;color:lightgray">Merchantid</div>
<div style="height:26px;color:red">Feedname</div>
<div style="height:26px">SKU</div>
<div style="height:26px">Title</div>
<div style="height:26px">Description</div>
<div style="height:26px">Category 1</div>
<div style="height:26px">Category 2</div>
<div style="height:26px">Category 3</div>
<div style="height:26px">Tags</div>
<div style="height:26px">Link</div>
<div style="height:26px">Image</div>
<div style="height:26px">Price</div>
<div style="height:26px">Retailprice</div>
<div style="height:26px">Currency</div>
<div style="height:26px">Cust 1</div>
<div style="height:26px">Cust 2</div>
<div style="height:26px">Cust 3</div>
</div>

<!-- just numbers -->
<div style="float:left;width:20px"> 
<b>#</b><hr>
<? for ($c=0; $c < 18; $c++)
	{
	?> <div style="height:26px"> <?
	echo $c."<br>";
	?></div>
	<? } ?>
</div>



	
	
	<?PHP
					// fetching preset selectors
						if ($preset2 > 2) {	
							$loop=0; 
							while ($loop < 18)
							{
							global $rule;
							$rule[$loop] = $_POST["col".$loop];
							//echo $loop."-".$rule[$loop]."<br>";
							$loop++;	
							};	
								} 
?>	
	
	<div style="float:left"> 
	<b>Your CSV file</b><hr>
	<div style="height:26px">
    <b>enter a networkname --></b>
	</div>
	<div style="height:26px">
	<b>optional / leave blank --></b>
	</div>
	<div style="height:26px">
	<b>enter a feedname --></b>
	</div>
	<?PHP 	
	$A=3; 
	while ($A < 18) 
	{ 
	?>	
	<div style="height:26px">
	<select name="<?PHP echo 'col'.$A; ?>">
	<?PHP 
		$file = get_option( "l66_file_location" );
		if (substr($file,-2) == "gz")
		{$csv_col = gzopen($file, "r") or exit("unable to open file ($file_location)");}else
		{$csv_col = fopen($file, "r") or exit("unable to open file ($file_location)");}
		if ($del == "tab") $del = "\t";
		while ($csv_columns = fgetcsv($csv_col, 100000, $del,'"')) 
			{
			$num = count($csv_columns);
			echo '<option value="99" "selected">SELECT something or write -></option>';	
			for ($c=0; $c < $num; $c++)
				{
				$csv_columns[$c] = substr($csv_columns[$c],0,30);
				
						if (!empty($rule[$A])) {if ($rule[$A] == $c) {$select = "selected";} else {$select = "";}}
						else
							{
						$sku = array("sku", "SKU", "identifier"); // 3 = sku
						if ($A == 3) {if (in_array($csv_columns[$c],$sku)) {$select = "selected";} }
						$title = array("title", "Title","name","NAME"); // 4 = title array
						if ($A == 4) {if (in_array($csv_columns[$c],$title)) {$select = "selected";} }
						$desc = array("desc", "Desc", "Description","description", "DESCRIPTION"); // 5 = description
						if ($A == 5) {if (in_array($csv_columns[$c],$desc)) {$select = "selected";} }
						$cat = array("cat", "cats", "Category","category","Categories","categories","c0","ADVERTISERCATEGORY"); // 
						if ($A == 6) {if (in_array($csv_columns[$c],$cat)) {$select = "selected";} }
						$cat = array("cat2", "cats2","subcategory","Category2","Categories2","categories2","c1","THIRDPARTYCATEGORY"); // 
						if ($A == 7) {if (in_array($csv_columns[$c],$cat)) {$select = "selected";} }
						$cat = array("cat3", "cats3", "merchantcategory","Categories3","thirdcategory"); // 
						if ($A == 8) {if (in_array($csv_columns[$c],$cat)) {$select = "selected";} }
						$cat = array("tag", "tags", "keyword","keywords","KEYWORDS"); // 
						if ($A == 9) {if (in_array($csv_columns[$c],$cat)) {$select = "selected";} }
						$lin = array("productURL", "product","BUYURL","url"); // 
						if ($A == 10) {if (in_array($csv_columns[$c],$lin)) {$select = "selected";} }
						$img = array("image", "imageURL","IMAGEURL","image"); // 
						if ($A == 11) {if (in_array($csv_columns[$c],$img)) {$select = "selected";} }
						$pri = array("price", "Price","PRICE"); // 
						if ($A == 12) {if (in_array($csv_columns[$c],$pri)) {$select = "selected";} }
						$pri = array("retailprice", "msrp","oldprice","RETAILPRICE","price_old"); // 
						if ($A == 13) {if (in_array($csv_columns[$c],$pri)) {$select = "selected";} }
						$pri = array("currency", "CURRENCY","curr"); // 
						if ($A == 14) {if (in_array($csv_columns[$c],$pri)) {$select = "selected";} }
							}
						echo "<option value='".$c."' ".$select.">".$c . "." . $csv_columns[$c] . "</option><br />\n";
						$select = "";
						
				}
			break;
			}
	?>
	</select>
	</div>
	<?PHP 
	$A++; 
	} 
	?>
	<!-- selector loops end here -->
	</div>	
	<div style="float:left"> 	
	<b>manual override</b><hr>	
							<?php
							// clean userinput and show sanatised version
							$clean = 0;
							while ($clean < 18){$_POST["override".$clean] = preg_replace("/[^A-Za-z0-9]/","",$_POST["override".$clean]);$clean++;}
							?>
	<div style="height:26px">
	<input type="text" name="override0" value="<?PHP echo $_POST['override0']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override1" value="<?PHP echo $_POST['override1']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override2" value="<?PHP echo $_POST['override2']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override3" value="<?PHP echo $_POST['override3']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override4" value="<?PHP echo $_POST['override4']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override5" value="<?PHP echo $_POST['override5']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override6" value="<?PHP echo $_POST['override6']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override7" value="<?PHP echo $_POST['override7']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override8" value="<?PHP echo $_POST['override8']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override9" value="<?PHP echo $_POST['override9']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override10" value="<?PHP echo $_POST['override10']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override11" value="<?PHP echo $_POST['override11']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override12" value="<?PHP echo $_POST['override12']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override13" value="<?PHP echo $_POST['override13']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override14" value="<?PHP echo $_POST['override14']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override15" value="<?PHP echo $_POST['override15']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override16" value="<?PHP echo $_POST['override16']; ?>">
	</div>
	<div style="height:26px">
	<input type="text" name="override17" value="<?PHP echo $_POST['override17']; ?>">
	</div>
	<div style="background-color:red">
	<input type="checkbox" name="forreal" value="yes">to database<br>
	</div>
	<input type="submit" name="Submit" value="<?php _e('process feed !')?>" />
	</form>
	</div>


	
				<?PHP
				// check the checkbox and go preview or go for real
				if ($_POST['forreal'] != "yes")
				{
				?>
<div style="float:left;width:400px;font-weight:bold;font-size:14px;overflow:hidden;background-color:lightyellow"> 	
	<?PHP
if (substr($file,-2) == "gz")
{gzclose($csv_col);} else
{fclose($csv_col);}	

// PREVIEW ONE TIME	
echo "<b>Preview 3rd post + image</b><hr>";
$file = get_option( "l66_file_location" );
if (substr($file,-2) == "gz")
{$csv_col = gzopen($file, "r") or exit("unable to open file ($file_location)");} else
{$csv_col = fopen($file, "r") or exit("unable to open file ($file_location)");}	
if ($del == "tab") $del = "\t";
while ($rsItem = fgetcsv($csv_col, 100000, $del)) 
	{	
	
	$I++;

							// clean userinput and show sanatised version
							$clean = 0;
							while ($clean < 18){$_POST["override".$clean] = preg_replace("/[^A-Za-z0-9]/","",$_POST["override".$clean]);$clean++;}
						
		$data_array = array(); // initialise array empty	
		$data_array['network'] = $_POST['override0'];
		$data_array['merchantid'] = $_POST['override1'];
		$data_array['feedname'] = $_POST['override2'];		
		if (empty($_POST['override3'])) {$data_array['sku'] = $rsItem[$_POST['col3']];} else {$data_array['sku'] = $_POST['override3'];}			
		if (empty($_POST['override4'])) {$data_array['title'] = $rsItem[$_POST['col4']];} else {$data_array['title'] = $_POST['override4'];}			
		if (empty($_POST['override5'])) {$data_array['descr'] = $rsItem[$_POST['col5']];} else {$data_array['descr'] = $_POST['override5'];}			
		if (empty($_POST['override6'])) {$data_array['cat'] = $rsItem[$_POST['col6']];} else {$data_array['cat'] = $_POST['override6'];}			
		if (empty($_POST['override7'])) {$data_array['cat2'] = $rsItem[$_POST['col7']];} else {$data_array['cat2'] = $_POST['override7'];}			
		if (empty($_POST['override8'])) {$data_array['cat3'] = $rsItem[$_POST['col8']];} else {$data_array['cat3'] = $_POST['override8'];}			
		if (empty($_POST['override9'])) {$data_array['tags'] = $rsItem[$_POST['col9']];} else {$data_array['tags'] = $_POST['override9'];}			
		if (empty($_POST['override10'])) {$data_array['link'] = $rsItem[$_POST['col10']];} else {$data_array['link'] = $_POST['override10'];}			
		if (empty($_POST['override11'])) {$data_array['image'] = $rsItem[$_POST['col11']];} else {$data_array['image'] = $_POST['override11'];}			
		if (empty($_POST['override12'])) {$data_array['price'] = $rsItem[$_POST['col12']];} else {$data_array['price'] = $_POST['override12'];}			
		if (empty($_POST['override13'])) {$data_array['retailprice'] = $rsItem[$_POST['col13']];} else {$data_array['retailprice'] = $_POST['override13'];}			
		if (empty($_POST['override14'])) {$data_array['currency'] = $rsItem[$_POST['col14']];} else {$data_array['currency'] = $_POST['override14'];}			
		if (empty($_POST['override15'])) {$data_array['cust1'] = $rsItem[$_POST['col15']];} else {$data_array['cust1'] = $_POST['override15'];}			
		if (empty($_POST['override16'])) {$data_array['cust2'] = $rsItem[$_POST['col16']];} else {$data_array['cust2'] = $_POST['override16'];}			
		if (empty($_POST['override17'])) {$data_array['cust3'] = $rsItem[$_POST['col17']];} else {$data_array['cust3'] = $_POST['override17'];}	
		// no timed updates on manual feeds
		//$data_array['timein'] = time();
		//$data_array['timeupdate'] = $updatetime;

	if ($I > 2) {break;} // kill the loop on the third line - we're just preview

	// print the preview data on the second line
	if ($I > 1) {		foreach ($data_array as $key => $value) 
						{
						echo "<div style='height:26px'>".$key." - <font color='blue'>".substr($value,0,32)."</font></div>";
						if ($key == "image") {if (!empty($value)) echo "<div style='position:absolute;right:0px;bottom:-250px;'><img src='$value' width='200'></div>";}
						}	
				}
	}
		if (substr($file,-2) == "gz")
		{gzclose($csv_col);} else
		{fclose($csv_col);}	

?>
</div>	
				<?PHP 
				// end preview loop
				} else {
				// go for real this time
				?>
<div style="float:left;width:400px;height:500px;font-weight:bold;font-size:14px;overflow:scroll;background-color:yellow"> 	
	<?PHP
if (substr($file,-2) == "gz")
{gzclose($csv_col);} else
{fclose($csv_col);}	
if (empty($_POST['override0']) || empty($_POST['override2'])) 
{exit ("<font color='red'><b>You can not proceed until you have at least provided a Network, a Feed Name and have hit the 'preview feed' button. Please enter data or hit 'preview feed' to clear this screen</font>");}
// PREVIEW ONE TIME	
echo "<div style='background-color:yellow;color:red;font-weight:bold'>NOW PARSING POSTS</div><hr>";
$file = get_option( "l66_file_location" );
if (substr($file,-2) == "gz")
{$csv_col = gzopen($file, "r") or exit("unable to open file ($file_location)");} else
{$csv_col = fopen($file, "r") or exit("unable to open file ($file_location)");}	
if ($del == "tab") $del = "\t";
$I = 0;
while ($rsItem = fgetcsv($csv_col, 100000, $del)) 
	{	
	
	$I++;

							// clean userinput and show sanatised version
							$clean = 0;
							while ($clean < 18){$_POST["override".$clean] = preg_replace("/[^A-Za-z0-9]/","",$_POST["override".$clean]);$clean++;}
						
		$data_array = array(); // initialise array empty	
		$data_array['network'] = $_POST['override0'];
		$data_array['merchantid'] = $_POST['override1'];
		$data_array['feedname'] = $_POST['override2'];		
		if (empty($_POST['override3'])) {$data_array['sku'] = $rsItem[$_POST['col3']];} else {$data_array['sku'] = $_POST['override3'];}			
		if (empty($_POST['override4'])) {$data_array['title'] = $rsItem[$_POST['col4']];} else {$data_array['title'] = $_POST['override4'];}			
		if (empty($_POST['override5'])) {$data_array['descr'] = $rsItem[$_POST['col5']];} else {$data_array['descr'] = $_POST['override5'];}			
		if (empty($_POST['override6'])) {$data_array['cat'] = $rsItem[$_POST['col6']];} else {$data_array['cat'] = $_POST['override6'];}			
		if (empty($_POST['override7'])) {$data_array['cat2'] = $rsItem[$_POST['col7']];} else {$data_array['cat2'] = $_POST['override7'];}			
		if (empty($_POST['override8'])) {$data_array['cat3'] = $rsItem[$_POST['col8']];} else {$data_array['cat3'] = $_POST['override8'];}			
		if (empty($_POST['override9'])) {$data_array['tags'] = $rsItem[$_POST['col9']];} else {$data_array['tags'] = $_POST['override9'];}			
		if (empty($_POST['override10'])) {$data_array['link'] = $rsItem[$_POST['col10']];} else {$data_array['link'] = $_POST['override10'];}			
		if (empty($_POST['override11'])) {$data_array['image'] = $rsItem[$_POST['col11']];} else {$data_array['image'] = $_POST['override11'];}			
		if (empty($_POST['override12'])) {$data_array['price'] = $rsItem[$_POST['col12']];} else {$data_array['price'] = $_POST['override12'];}			
		if (empty($_POST['override13'])) {$data_array['retailprice'] = $rsItem[$_POST['col13']];} else {$data_array['retailprice'] = $_POST['override13'];}			
		if (empty($_POST['override14'])) {$data_array['currency'] = $rsItem[$_POST['col14']];} else {$data_array['currency'] = $_POST['override14'];}			
		if (empty($_POST['override15'])) {$data_array['cust1'] = $rsItem[$_POST['col15']];} else {$data_array['cust1'] = $_POST['override15'];}			
		if (empty($_POST['override16'])) {$data_array['cust2'] = $rsItem[$_POST['col16']];} else {$data_array['cust2'] = $_POST['override16'];}			
		if (empty($_POST['override17'])) {$data_array['cust3'] = $rsItem[$_POST['col17']];} else {$data_array['cust3'] = $_POST['override17'];}	

	if ($I > 1 && $I < 4 ) {		foreach ($data_array as $key => $value) 
						{
						echo "<div style='height:26px'>".$key." - <font color='blue'>".substr($value,0,32)."</font></div>";
						if ($key == "image") {if (!empty($value)) echo "<div><img src='$value' width='200'></div>";}
						}	
				}
				
		// input
		global $wpdb;		
		$table_name = $wpdb->prefix ."lane66_feeds";
		 //$wpdb->show_errors();
	if ($I > 1 ){$wpdb->insert( $table_name, $data_array);}
	}
		Echo "<h3>There were ".$I." products added to the warehouse";
		if (substr($file,-2) == "gz")
		{gzclose($csv_col);} else
		{fclose($csv_col);}	

?>
</div>	
<?PHP }