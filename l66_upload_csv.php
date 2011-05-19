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

	<div class="round">
	<div class="titlebox">STEP 1.> provide a datafeed feed</div>
	<br>
	<?PHP
	// wp plugin - upload your own csv datafeed
	// lane66.com - designed and developed by Pete Scheepens - all intellectual property rights reserved.
	if (function_exists('l66_check')) {l66_check();}
	if (function_exists('l66_checkdb')) {l66_checkdb();}
	include_once('l66_functions.php');
	$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
	$upload_dir = wp_upload_dir();
	if (!empty($upload_dir['error'])) echo "<hr>It appears there may be a problem with your directory permissions. I can not write datafeeds to the upload directory !".$upload_dir['error']."<hr>";
	if (isset($_GET['l66info'])) {update_option('l66-info',$_GET['l66info']);}
	if (function_exists('l66_checkdb')) {l66_checkdb();}

	// no clue why, but WP seems to not allow csv on certain (virgin) installs. The function below should not be needed but it bypasses some quirks.
	function l66_custom_upload_mimes ( $existing_mimes=array() ) 
			{ 
				$existing_mimes['csv'] = 'text/csv';
				$existing_mimes['txt'] = 'text/csv';
				$existing_mimes['gz'] = 'application/x-gzip';
				$existing_mimes['gzip'] = 'application/x-gzip';	
				return $existing_mimes;
			}
	add_filter('upload_mimes', 'l66_custom_upload_mimes');

	//

	if (isset($_POST['preset'])) {update_option('l66-separate',stripslashes($_POST['preset']));}
	$del = get_option('l66-separate',"|");
	$chk = $x."pics/chkgrn.gif";
	if (get_option('l66-info','max') == "min"){ echo "<img src=$chk> " ; } ?>	
	<a href="admin.php?page=l66_upload_csv&l66info=min"><font color='green'>less info</font></a>|
	<?PHP if (get_option('l66-info','max') == "max"){ echo "<img src=$chk> " ; } ?>
	<a href="admin.php?page=l66_upload_csv&l66info=max">show help & info</a>
	<iframe src="http://lane66.com/l66/plugintop2-news.php" width="100%" height="30" scrolling="no">Your system does not support Iframes so you can not see the latest news</iframe>

		<div style="padding-left:10px;background-color:lightyellow">
			<h2>lane66.com - upload your own csv file | convert feeds to warehouse products</h2>	
			<?PHP

		// check where feed comes from and push it into db-option
		if( $_POST['upload'] == 'Y' ) 
			{
				if ( $_POST['flush'] == 'YES' ) 
					{
					update_option( "l66_file_location", 'NOTHING WHATSOEVER ... why not load a datafile to get started ?' );
					}		
				
				elseif( $_POST['remote'] == 'YES' ) 
					{
					if (get_option('l66_modus') != "PREMIUM") {echo "<center><font color='red'><h2>I am sorry, 
					but I hope you did not seriously think this was a freebie option</h2>. You really have to be a PREMIUM member to use the remote file function</font><br>";}
					else 
						{
						if (!copy($_POST['url_file'], $upload_dir['path']."/last_uploaded_file.txt")) { echo "failed to copy $file...\n";}
						$file_location = $upload_dir['path']."/last_uploaded_file.txt";
						update_option( "l66_file_location", $file_location );
						}
					}

				elseif($_FILES['sponsor_file']['error'] === 0) 
					{
					// local file loading
						$upload = wp_upload_bits($_FILES["sponsor_file"]["name"], null, file_get_contents($_FILES["sponsor_file"]["tmp_name"]));
						$file_location = $upload[file];

						update_option( "l66_file_location", $file_location );
						if ((substr($file_location,-3) != "txt") && (substr($file_location,-3) != "csv") && (substr($file_location,-3) != ".gz"))// nogo on zip
							{
							exit ('<font color="red">I am not clear on this file. Please upload files with .txt , .GZ or .csv extensions only !</font>');
							}			
					}
			}


			if (get_option('l66-info','max') == "max")
			{ 
			echo
			"<font color='green'>
			Green text is here for beginners. Need less clutter ? Click the 'less info' button on the top left of your screen to hide all green text<br>
			Locate your own CSV datafile on your computer and upload it to the warehouse. Once your datafeed is converted and the products have
			 been placed in the warehouse (database) you can build fancy shops with them or convert them to pretty posts by using the appropriate menu-options.<hr>	 
			 </font>";
			}
			if ((get_option('l66_freebie_count') > 40000) && (get_option('l66_modus')!= "PREMIUM") )
			{echo "<CENTER><h3> YOU HAVE BEEN FLAGGED FOR ACCOUNT BLOCKING !<br>YOU HAVE NOW USED OR SERVER ".get_option('l66_freebie_count')." TIMES<br> AND ARE still OPERATING IN FREEBIE MODE<br>
			<br>AN ADMINISTRATOR HAS BEEN NOTIFIED<br> ABOUT YOUR USE OF THE SYSTEM.<br> THE ADMINISTRATOR MAY DETERMINE THAT<br> YOUR ACCOUNT IS TO BE BLOCKED !<br>Please swith to PREMIUM mode or stop using our system !</h3>";
			}
			?>
		 </div>
		<div style="background-color:lightyellow;padding:3px 0px 3px;text-align:center;">

		Select a datafeed stored on your computer ! I can deal with .txt .csv or .gz files (I'll automatically unzip files too).<br>
		<?PHP echo "your php.ini allows a maximum of ".ini_get('post_max_size')." for post-size and a max of ".ini_get('upload_max_filesize')." for upload. Do NOT try to load larger files !"; ?><br>
					<div style="float:left;width:33%">
						<!-- form for upload -->
						<h3>Load a local file</h3>
						<form name="l66_upload_file" enctype="multipart/form-data" method="post">
							<input type="hidden" name="upload" value="Y">
							<input type="file" name="sponsor_file"><br>
							<input type="submit" style="background-color:yellow" name="Submit" value="<?php _e('Upload my data file!')?>" >
						</form>
					</div>
					<div style="float:left;width:33%">
						<h3>Load a remote file</h3>
						<form name="l66_upload_file2" enctype="multipart/form-data" method="post">
							<input type="hidden" name="upload" value="Y">
							<input type="text" size="40" name="url_file" value= "premium members only ....">
							<input type="hidden" name="remote" value = "YES" ><br>
							<input type="submit" style="background-color:yellow" name="Submit" value="<?php _e('use remote file')?>" >
						</form>
					</div>
					<div style="float:left;width:33%">
								<h3>Panic ! I've been bad</h3>
								If your page locks us you may have tried to load a file which was too big in size. Hit the reset button below to restore defaults.
						<form name="l66_upload_file3" enctype="multipart/form-data" method="post">
							<input type="hidden" name="upload" value="Y">
							<input type="hidden" name="flush" value = "YES" >
							<input type="submit" style="background-color:lightgreen" name="Submit" value="<?php _e('reset')?>" >
						</form>
					</div>	
		</div>


		<div style="clear:both;text-align:center;">
			<?PHP 
			$display_fl = get_option( "l66_file_location" ); echo"<small>Now working with: $display_fl </small>"; 
			?>

		<?php 
			if (get_option('l66-info','max') == "max")
			{ 
			echo"<font color='green'>
			<h3>Close additional info & de-clutter by clicking 'less info' on the top left corner of your screen'</h3>
			<br>=-> Select a delimiter below and click 'change delimiter !'
			<br>=-> Match your columns ... Many times the column order or column names in your feed do not match. Below you can select the columns from your datafile and match them with the correct database entries. If you do not like the choices that
			your datafeed provides you or if you want to overrule a certain field you can use the manual override boxes. Anything you type in the manual override boxes will be fixed in place for
			 this entire datafeed. (It's great for setting tags or replacing links with 1 fixed link etc. Be creative ....<hr width='40%'>
			 <b>How to upload standard feeds</b>   |   <b>More about some tricky feeds</b><br>
			 <object width='320' class='thickbox' height='195'><param name='movie' value='http://www.youtube.com/v/JhhlzKTY8ng'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/JhhlzKTY8ng' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='320' height='195'></embed></object>
			 <object width='320' class='thickbox' height='195'><param name='movie' value='http://www.youtube.com/v/y0VMa9SYozM'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/y0VMa9SYozM' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='320' height='195'></embed></object>	 
			<hr>
			 <h3>Close additional info & de-clutter by clicking 'less info' on the top left corner of your screen'</h3>
			 </font>
			";
			}
		?>
		</div>
	</div>
<br>
	<div class="round">
			<div class="titlebox">STEP 2.> check your delimiter</div>
		<br>
		<?PHP	
		// show preview of columns
				$file = get_option( "l66_file_location",$x."/demo.csv");
				if (substr($file,-2) == "gz"){$content = gzfile($file);} else {$content = file($file);}
				if (get_option('l66-info','max') == "max") { echo "<br><b>Here is the first line from your CSV file. Please tell me what character is used to delimit or separate the fields.</b><br>"; }
				$content = str_replace("\t","{tab}",$content);
				echo "<br><b><font color='blue'>".substr($content[0],0,90).".......</b></font>";
		?>

						
		<!-- delimiter form -->			
		<form name="read_csv" enctype="multipart/form-data" method="post" action="admin.php?page=l66_upload_csv">				

		Currently selected : <font color='blue'><b> <?PHP echo $del; ?> </b></font> Now Look above and tell me how this feed is separated:
		<select name="preset">
		<option value="|" selected> a single pipe | </option>
		<option value=";">a semi-colon ; </option>
		<option value="tab">a tab-space TAB </option>
		<option value=",">A comma , </option>
		</select>
		<input type="submit" style="background-color:yellow" name="Submit" value="<?php _e('change delimiter !')?>" />	
		</form>
		<!-- end delimiter form -->			
		 <form name="read_csv" enctype="multipart/form-data" method="post">
	</div>
<br>
	<div class="round">
				<div class="titlebox">STEP 3.> Match columns and fill database.</div>
	<br>			
	Please note: Hitting the checkbox in the red area below will push the feed directly into the database. 
	<?PHP if (get_option('l66-info','max') == "max")
	{ echo "<font color='green'><br>Please hit 'Process feed!' without checking the box as much as needed until you are satisfied with your preview (Do it now!) When your preview is good, check the box and hit 'Proceed..' again to fill database.</font><br>";}	
	?>
	<div style="font-size:11px;text-align:center">CSV loader becomes more intelligent with every version, but we need your help. Have a feed that is not automatically recognised below ?<br> <a href='http://portaljumper.com/discuss/index.php?action=post;board=3.0'>Send us the first line</a> of the datafeed and we'll make sure lane66.com becomes more intelligent</div>


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
	<?PHP for ($c=0; $c < 18; $c++)
		{
		?> <div style="height:26px"> <?PHP
		echo $c."<br>";
		?></div>
		<?PHP } ?>
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
					
							//if (!empty($rule[$A])) {if ($rule[$A] == $c) {$select = "selected";} else {$select = "";}}
							//else
							if ($_POST['col'.$A] == $c) {$select = "selected";} else
								{
							$sku = array("sku", "SKU", "identifier", "product ID","MerchantProductNumber"); // 3 = sku
							if ($A == 3) {if (in_array($csv_columns[$c],$sku)) {$select = "selected";} }
							$title = array("title", "Title","name","NAME","Product_Name","ProductName"); // 4 = title array
							if ($A == 4) {if (in_array($csv_columns[$c],$title)) {$select = "selected";} }
							$desc = array("desc", "Desc", "Description","description", "DESCRIPTION","Product_Desc","ProductLongDescription"); // 5 = description
							if ($A == 5) {if (in_array($csv_columns[$c],$desc)) {$select = "selected";} }
							$cat = array("cat", "cats", "Category","category","Categories","categories","c0","ADVERTISERCATEGORY","Product_Category"); // 
							if ($A == 6) {if (in_array($csv_columns[$c],$cat)) {$select = "selected";} }
							$cat = array("cat2", "cats2","subcategory","Category2","Categories2","categories2","c1","THIRDPARTYCATEGORY"); // 
							if ($A == 7) {if (in_array($csv_columns[$c],$cat)) {$select = "selected";} }
							$cat = array("cat3", "cats3", "merchantcategory","Categories3","thirdcategory"); // 
							if ($A == 8) {if (in_array($csv_columns[$c],$cat)) {$select = "selected";} }
							$cat = array("tag", "tags", "keyword","keywords","KEYWORDS"); // 
							if ($A == 9) {if (in_array($csv_columns[$c],$cat)) {$select = "selected";} }
							$lin = array("productURL", "product","BUYURL","url", "Product_Tracking_URL","ZanoxProductLink"); // 
							if ($A == 10) {if (in_array($csv_columns[$c],$lin)) {$select = "selected";} }
							$img = array("image", "imageURL","IMAGEURL","image","Product_Image_URL","ImageSmallURL"); // 
							if ($A == 11) {if (in_array($csv_columns[$c],$img)) {$select = "selected";} }
							$pri = array("price", "Price","PRICE", "Product_Price","ProductPrice"); // 
							if ($A == 12) {if (in_array($csv_columns[$c],$pri)) {$select = "selected";} }
							$pri = array("retailprice", "msrp","oldprice","RETAILPRICE","price_old", "Product_Sale_Price","FromPrice"); // 
							if ($A == 13) {if (in_array($csv_columns[$c],$pri)) {$select = "selected";} }
							$pri = array("currency", "CURRENCY","curr", "Product_Currency","CurrencySymbolOfPrice"); // 
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
	// debug echo "post col 16 =".$_POST['col16'];
					// check the checkbox and go preview or go for real
					if ($_POST['forreal'] != "yes")
					{
					
	echo "<b>Preview fields + images</b><hr>";
	?>		
	<div style="float:left;width:400px;height:510px;font-weight:300;font-size:10px;overflow:scroll;background-color:lightyellow"> 	
		<?PHP
	if (substr($file,-2) == "gz")
	{gzclose($csv_col);} else
	{fclose($csv_col);}	

	// PREVIEW ONE TIME	

	$file = get_option( "l66_file_location" );
	if (substr($file,-2) == "gz")
	{$csv_col = gzopen($file, "r") or exit("unable to open file ($file_location)");} else
	{$csv_col = fopen($file, "r") or exit("unable to open file ($file_location)");}	
	if ($del == "tab") $del = "\t";
	$I=0 ;
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
	// debug echo "array 2 =".$data_array['cust2'];
		if ($I > 6) {break;} // kill the loop on the third line - we're just preview

		// print the preview data on the second line
		if ($I > 1) {		
							echo "<h3>Now previewing image $I </h3><hr>";
							foreach ($data_array as $key => $value) 
							{
							echo "<div style='text-align:left;'>".$key." - <font color='blue'>".substr($value,0,50)."</font></div>";
							if ($key == "image") {if (!empty($value)) echo "<div style='background-color:white;'>Found something; maybe it's an image !<br><img src='$value' width='100'></div>";}
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
					} 
					else 
					{
					// go for real this time
					if (function_exists('l66_checkdb')) {l66_checkdb();}
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

		if ($I > 1 && $I < 4 ) {		
							echo "<h3>Entering into database : </h3><hr>";
							foreach ($data_array as $key => $value) 
							{
							echo "<div style='height:26px'>".$key." - <font color='blue'>".substr($value,0,32)."</font></div>";
							if ($key == "image") {if (!empty($value)) echo "<div><img src='$value' width='200'></div>";}
							}	
					}
					
			// input
			global $wpdb;		
			$table_name = $wpdb->prefix ."lane66_feeds";
			 //$wpdb->show_errors();
			 $wpdb->hide_errors();
		if ($I > 1 ){$wpdb->insert( $table_name, $data_array);}
		}
			Echo "<small>I have processed ".$I." products and attempted to write them to the lane66 database. While I kept counting on duplicate posts, I did not enter any duplicates
			into the database.<hr>You can now choose to either:<br>- push some more feeds into the warehouse<br>- convert some products to pages<br>- convert some products to posts<br>- have a break and drink some ...</small>";
			if (substr($file,-2) == "gz")
			{gzclose($csv_col);} else
			{fclose($csv_col);}	

	?>
	<br /><br />
	</div>
	<br /><hr />
</div>	
<?PHP }

if (get_option('l66-info','max') == "max")
{ echo "<div style='clear:both;color:green'><br>While the plugin is fairly good trying to match columns from your csv file to the correct database field this process still requires a MANUAL CHECK. Please make sure you match the database fields from the first column with the appropriate columns in your datafeed by clicking on the little black triangles and selecting the correct column names.</div><br>";}	
	

include ('l66_footer.php'); 

