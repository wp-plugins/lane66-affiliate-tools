	<a href="admin.php?page=l66_SAS_feeds&l66sasinfo=min">load a shareasale datafeed</a>|<a href="admin.php?page=l66_SAS_feeds&l66sasinfo=max">enter login settings first</a>
	<?PHP if (isset($_GET['l66sasinfo'])) {update_option('l66-sasinfo',$_GET['l66sasinfo']);}
	// if set show login info
	if (get_option('l66-sasinfo','max') != "min")
	{ 
	?>	
	<div style="background-color:#EF7A7A">
	<hr>
	The shareasale lane66.com loaders will connect directly to the shareasale network to pull your datafeed information. Please provide the info requested below to start including shareasale feeds 
	into your warehouse, shops and posts. To get your token, read the token helper below, and then click to open the API center.
	<hr>
	</div>
	<h2>Lane66.com - shareasale configuration and tools</h2>
	<hr>
	<!-- SHAREASALE INFO REQUEST  ********************************************************* -->
	<?PHP
	if (isset($_POST['sasaffid'])) {update_option('sasaffid',$_POST['sasaffid']);}
	if (isset($_POST['sastoken'])) {update_option('sastoken',$_POST['sastoken']);}
	if (isset($_POST['saslogid'])) {update_option('saslogid',$_POST['saslogid']);}
	if (isset($_POST['saspassid'])) {update_option('saspassid',$_POST['saspassid']);}
	?>
	<form action="admin.php?page=l66_SAS_feeds" method="post">
	<table>
	<tr>
	<td width="450"> your shareasale login ID (so we can automate your FTP)</td><td><input name='saslogid' type='text' value="<? echo get_option('saslogid'); ?>" /></td>
	</tr><tr>
	<td width="450"> your shareasale login password (for FTP feeds)</td><td><input name='saspassid' type='text' value="<? echo get_option('saspassid'); ?>" /></td>
	</tr><tr>
	<td width="450"> your shareasale affiliate ID (e.g. 483683 - so we can pull feed-lists)</td><td><input name='sasaffid' type='text' value="<? echo get_option('sasaffid'); ?>" /></td>
	</tr><tr>
	<td width="450">Enter your API Token (click "open the shareasale api" below if needed)</td><td><input name='sastoken' type='text' value='<?PHP echo get_option('sastoken'); ?>' /></td>
	</tr><tr>
	</table>
	<INPUT TYPE=hidden NAME="closeapi" VALUE="close">
	<INPUT TYPE=hidden NAME="sasset" VALUE="go">
	<input type="submit" value="update my ID settings"/>
	</form>
	<?	
	if (isset($_POST['sasaffid'])) {update_option('sasaffid',$_POST['sasaffid']);}
	if (isset($_POST['sastoken'])) {update_option('sastoken',$_POST['sastoken']);}
	if (isset($_POST['saslogid'])) {update_option('saslogid',$_POST['saslogid']);}
	if (isset($_POST['saspassid'])) {update_option('saspassid',$_POST['saspassid']);}
	if (isset($_POST['sasset']) && $_POST['sasset'] == "go")
	{
	$dllink = "https://shareasale.com/x.cfm?action=merchantDataFeeds&affiliateId=".get_option('sasaffid')."&token=".get_option('sastoken')."&blnMemberOf=1&sortCol=30DayEpc&sortDir=asc&version=1.3";
	update_option('l66-sasdllink',$dllink);
	echo "<p align='center'><center><div style='background:#ff0;color: red;'><strong>ID settings updated</strong> - there is nothing left to do here... Click 'load a shareasale datafeed' in the upper left corner of your screen.</div>";
	}
	?>
	<!--  INFO REQUEST  ********************************************************* -->

	<hr>
	<h2>Shareasale API Token helper</h2>
	<?PHP 
	//if (isset($_POST['idsetting'])){echo "<p align='center'><center><div style='background:#ff0;color: red;'><strong>ID settings updated <a href='admin.php?page=set_feeds' title='start the feeding process'>Proceed to network & feed settings.</a></strong></div></p>";}
	// check for cURL support first
	if (l66_iscurlsupported()) 
		{
		echo "<font color='blue'> (cURL is supported on your system) ... it's a good thing !</font><br>";
		} 
	else 
		{
		echo "<b><font color='red'>WARNING !! cURL is NOT supported on your system.<br>
		<hr>THIS PLUGIN WILL WORK WITHOUT cURL , but it will be severely limited.<hr>
		Please contact your host and have cURL installed or switch hosts (Since practically every host provides cURL support, your host obviously sucks). If you 
		are a do-it-your-self kinda person you can reinstall PHP with cURL support. Visit http://www.haxx.se/curl.html or better yet http://php.net/manual/en/book.curl.php for more info</font>";
		}
			// get REAL visiting IP so user can set API
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,'http://lane66.com/support/myip.php');
			curl_setopt($ch,CURLOPT_FRESH_CONNECT,TRUE);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
			if(curl_exec($ch) === false) {echo "<br><font color='red'>Curl error !<br>This needs to be fixed first before you can proceed !</font> " . curl_error($ch);}
			$data = curl_exec($ch);
			curl_close($ch);
			echo "<br>One time setup !<br>
			To get things working correctly we will need to set your IP address in the shareasale API center, and retrieve a special code from the shareAsale API.
			<br>When you click the link below you will be taken to the shareasale API center. Log in if needed, then enter your IP address <b>".$data."</b> in the white boxes and get a token-key. (hit CREATE NEW TOKEN if needed). 
			Click update settings in the shareasale api center to save your settings.
			Then please COPY YOUR TOKEN CODE (ctrl+C) close the window, and copy your token-code above. Finally hit the 'update my ID settings' button.<br>";
			?>
			<hr><hr><br>
			<a class="thickbox" href="http://www.shareasale.com/a-apimanager.cfm?KeepThis=true&TB_iframe=true&height=600&width=1010"  width="100%" height="600">CLICK TO OPEN THE SHAREASALE API</a>

		
		
	<?PHP			
	}

if (get_option('l66-sasinfo','max') == "min")
	{ 
	?>
	<div style="padding-left:10px;background-color:lightyellow">
	<p align='center'><h2>ShareAsale subpage -> select from approved FTP feeds and post to database</h2>
	<iframe src="http://lane66.com/plugintop2-news.php" width="100%" height="30" scrolling="no">Your system does not support Iframes so you can not see the latest news</iframe>
	<hr>
	Below is a list of FTP datafeeds that you have been approved for. If you want more feeds in this list you must first ask your merchants if
	 they will grant you automated (FTP) access to their datafeeds. You can use the "get more FTP" tool in the menu to request more ftp access.
	<hr>
	Please select a feed from the dropdown-list and click the "select this feed" button ! This will:<br>
	- contact shareasale<br>
	- request the datafeed<br>
	- read the products in the datafeed<br>
	- add the products along with all their info into your database<br>
	</div>
	<hr>
	<h2>Select from FTP approved datafeeds</h2>
	<form name="feeder" action="admin.php?page=l66_SAS_feeds" method="post"> 
	load: <select option name="gofeed">
	<?PHP
	// set some variables
	$dlink = get_option('l66-sasdllink');
	$fp = fopen($dlink, "r") ;
	$I=0;
	echo "<option>Select a feed below</option>";
	 while ($rsItem = fgetcsv($fp, 100000, "|")) 
		{	
			if ($rsItem[3] == "1") 
			{ 
		echo "<option>".$rsItem[0]."-".$rsItem[1]."_".$rsItem[2]."_".$rsItem[3]."_".$rsItem[4]."</option>";
		$I++;
			}
		}
	?>
	</select> and refresh :  
	<select option name="timetoupdate">
	<option value="31449600">1. once a year</option>
	<option value="7862400" selected>2. once a quarter</option>
	<option value="2620800">3. once a month</option>
	<option value="604800">4. once a week</option>
	<option value="86400">5. once a day **</option>
	</select> - 
	<INPUT TYPE=hidden NAME="fselect" VALUE="1">
	<input type="submit" value="select this feed"/><br>
	<?PHP
	echo "you currently have <b><font color='blue'>".$I."</font></b> feeds to choose from.";
	if ($I == 0){echo "<font color='red'><br>I ran into a problem !! I Could not retrieve the current data from the shareasale server !<br>
	DID YOU :<br>- Fill out your password, login and API token in the shareasale setup ? <b><- Most likely problem - please double-check your credentials</b><br>- Make sure you have FTP access to datafeeds ?<br>- Check to see that you can connect to the internet ?<br>
	- sign up with merchants for FTP access ?<br><hr><b>You can safely proceed with the other options in the plugin menu</b></font>";}
	fclose($fp) or exit("<font color='red'><br>I ran into a problem !! I Could not retrieve the current data from the shareasale server !<br>
	DID YOU :<br>- sign up with merchants for FTP access ?<br>- Fill out your password, login and API token in the shareasale setup ? <b><- Most likely problem - please double-check your credentials</b><br>- Make sure you have FTP access to datafeeds ?<br>- Check to see that you can connect to the internet ?<br>
	<hr><b>You can safely proceed with the other options in the plugin menu</b></font>");
	echo "<hr><h3>Database Statistics</h3>";
	global $wpdb;
	$table_name = $wpdb->prefix ."lane66_feeds";
	//$query = "SELECT * FROM " . $wpdb->prefix . "multifeed_urlsx ORDER by count DESC LIMIT 0,5";
	$maxprod = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name;"));
	echo "There are currently <font color='blue'>".$maxprod."</font> products available in the warehouse / database.<br>";
	$maxmerch = $wpdb->get_var("SELECT COUNT(DISTINCT merchantid) FROM $table_name");
	echo "These combined products are from <font color='blue'>".$maxmerch."</font> different feeds/merchants.<br>";
	
	if (isset($_POST['timetoupdate'])) 
		{ $updatetime = time() + $_POST['timetoupdate'] ; }
		else
		{ $updatetime = time() + 2620800 ; } // default to once a month
		$updatetime = (int)$updatetime;
		
		
	if (isset($_POST['fselect']))
		{
		?><div style="width:90%;background-color:lightyellow;height:300px;overflow:scroll"><?PHP
	// check if DB is set up - otherwise run setup
		
		$shard = explode ("-",$_POST['gofeed']);
		echo "<hr>".$shard[0]."<hr>";
		$server_file = "ftp://".get_option('saslogid').":".get_option('saspassid')."@datafeeds.shareasale.com/".$shard[0]."/".$shard[0].".txt";
		$sf = @fopen($server_file, "r") or exit("unable to open file ($server_file) are you sure you set your ShareAsale password and login correct ?");
		$I=0;
		while ($rsItem = fgetcsv($sf, 100000, "|")) 
			{	
			$I++;
			$rsItem[3] = preg_replace("/[^A-Za-z0-9]/","",$rsItem[3]);
			$rsItem[4] = str_replace('YOURUSERID',get_option('sasaffid','438368'),$rsItem[4]);
			$data_array = array
			(
			'network' => 'shareasale',
			'merchantid' => $rsItem[2], //3	MerchantID	Integer	8 bytes	MerchantID number
			'feedname' => $rsItem[3], // 4	Merchant	Text	255 characters	Merchant Name		
			'sku' => $rsItem[26], //27 SKU Text 255 characters	Merchant SKU for this product. This is a unique value, and can be used to generate a primary key.		
			'title' => $rsItem[1], // 2	Name	Text	255 characters	Product Name
			'descr' => $rsItem[11], // 12	Description	Text	No character limit	Product Description (HTML allowed)	
			'cat' => $rsItem[9], // 10	Category	Text	50 characters	ShareASale defined Category
			'cat2' => $rsItem[10], // 11	Subcategory	Text	50 characters	ShareASale defined Subcategory
			'cat3' => $rsItem[21], // 22	MerchantCategory	Text	255 characters	Merchant defined category
			'tags' => '',
			'link' => $rsItem[4], // 5	Link	URL	255 characters	URL to the product's page
			'image' => $rsItem[6], // 7	BigImage	URL	255 characters	URL to the product's large image
			'price' => $rsItem[7], // 8	Price	Numeric	2 decimal places	Product price
			'retailprice' => $rsItem[8], // 9	RetailPrice	Numeric	2 decimal places	Product full retail price (or MSRP)
			'currency' => '',
			//'cust1' => $rsItem[26], 
			//'cust2' => $rsItem[26],
			//'cust3' => $rsItem[26],
			'timein' => time(), // time since epoch
			'timeupdate' => $updatetime
			);
	/*		MINUS 1
	id mediumint(9) NOT NULL AUTO_INCREMENT,
		  network VARCHAR(14) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  merchantid VARCHAR(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  feedname VARCHAR(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  sku VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  title VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  descr VARCHAR(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cat VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cat2 VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cat3 VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  tags VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  link VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  image VARCHAR(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  price VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  retailprice VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  currency VARCHAR(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cust1 VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cust2 VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  cust3 VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		  timein bigint(11) DEFAULT '0' NOT NULL,
		  timeupdate bigint(11) DEFAULT '0' NOT NULL,
	Column Order	Data	Data Type	Max Length	Description
	1	ProductID	Integer	8 bytes	ShareASale generated ID for use in conjunction with our online tools. Should not be used as a primary key.
	2	Name	Text	255 characters	Product Name
	3	MerchantID	Integer	8 bytes	MerchantID number
	4	Merchant	Text	255 characters	Merchant Name
	5	Link	URL	255 characters	URL to the product's page
	6	Thumbnail	URL	255 characters	URL to the products thumbnail image
	7	BigImage	URL	255 characters	URL to the product's large image
	8	Price	Numeric	2 decimal places	Product price
	9	RetailPrice	Numeric	2 decimal places	Product full retail price (or MSRP)
	10	Category	Text	50 characters	ShareASale defined Category
	11	Subcategory	Text	50 characters	ShareASale defined Subcategory
	12	Description	Text	No character limit	Product Description (HTML allowed)
	13	Custom1	Text	255 characters	Merchant Defined Data
	14	Custom2	Text	255 characters	Merchant Defined Data
	15	Custom3	Text	255 characters	Merchant Defined Data
	16	Custom4	Text	255 characters	Merchant Defined Data
	17	Custom5	Text	255 characters	Merchant Defined Data
	18	Lastupdated	DateTime	N/A	Last updated date
	19	Status	Text	50 characters	Stock Status. instock refers to product in stock
	20	Manufacturer	Text	255 characters	Product Manufacturer
	21	PartNumber	Text	255 characters	Manufacture's part number
	22	MerchantCategory	Text	255 characters	Merchant defined category
	23	MerchantSubcategory	Text	255 characters	Merchant defined subcategory
	24	ShortDescription	Text	255 characters	Short description (no HTML)
	25	ISBN	Text	25 characters	Product ISBN number
	26	UPC	Text	25 characters	Product UPC
	The following columns will be added on August 1st, 2009
	27	SKU	Text	255 characters	Merchant SKU for this product. This is a unique value, and can be used to generate a primary key.
	28	CrossSell	Text	255 characters	Comma separated list of SKU values that cross sell with the product.
	29	MerchantGroup	Text	255 characters	3rd level category (sub subcategory) for the product
	30	MerchantSubgroup	Text	255 characters	4th level cateogy (sub sub subcategory) for the product.
	31	CompatibleWith	Text	255 characters	Comma separated list of compatible items in format of Manufacturer~PartNumber.
	32	CompareTo	Text	255 characters	Comma separated list of items this product can replace in format of Manufacturer~PartNumber.
	33	QuantityDiscount	Text	255 characters	Comma separated list in the format of minQuantity~maxQuantity~itemCost. Blank Max Quantity represents a top tier.
	34	Bestseller	Bit	1	A 1 indicates a best selling product. Null values or zero are non-bestsellers.
	35	AddToCartURL	URL	255 characters	URL that adds this product directly into the shopping cart.
	36	ReviewsRSSURL	URL	255 characters	URL to RSS formatted reviews for this product.
	37	Option1	Text	255 characters	Comma separated list of product options in the format optionName~priceChangeInDollarsPerUnit.
	38	Option2	Text	255 characters	Comma separated list of product options in the format optionName~priceChangeInDollarsPerUnit.
	39	Option3	Text	255 characters	Comma separated list of product options in the format optionName~priceChangeInDollarsPerUnit.
	40	Option4	Text	255 characters	Comma separated list of product options in the format optionName~priceChangeInDollarsPerUnit.
	41	Option5	Text	255 characters	Comma separated list of product options in the format optionName~priceChangeInDollarsPerUnit.
	42	ReservedForFutureUse	-	-	Reserved for future use.
	43	ReservedForFutureUse	-	-	Reserved for future use.
	44	ReservedForFutureUse	-	-	Reserved for future use.
	45	ReservedForFutureUse	-	-	Reserved for future use.
	46	ReservedForFutureUse	-	-	Reserved for future use.
	47	ReservedForFutureUse	-	-	Reserved for future use.
	48	ReservedForFutureUse	-	-	Reserved for future use.
	49	ReservedForFutureUse	-	-	Reserved for future use.
	50	ReservedForFutureUse	-	-	Reserved for future use.
	51	ReservedForFutureUse	-	-	Reserved for future use.
	*/
			
			
			//var_dump($data_array) only first 3;
			if ($I < 3) {
			foreach ($data_array as $key => $value) 
				{
				echo $key." - <font color='blue'>".$value."</font><br>";
				if ($key == "image") {echo "<img src='$value' width='150'><br>";}
				}
						}
				
			$table_name = $wpdb->prefix ."lane66_feeds";
			$wpdb->insert( $table_name, $data_array);
			}
			Echo "<h3>".$I." products were succesfully added to the warehouse";
		?></div><?PHP
		}

	?>
	<h2>Request more FTP access to datafeeds</h2>
	<div style="background-color:#EF7A7A">
	<hr>
	Below is a list of ShareAsale merchants that you have signed up with and that have approved you.<br>
	While you are approved you must still request FTP access to their datafeeds in a separate request.
	Simply select a merchant from the dropdown list and request FTP access to their feeds in the frame below. 
	Once FTP access is granted you will automatically see your feed in the main selection menu.
	<br>
	</div>
	Merchants that you did not apply for yet do not show up in this datafeed list. Simply log in to shareAsale and apply for regular access to as many merchants as you need. Then come back here and see their datafeeds appear.
	<hr>
	<?PHP
	$dlink = get_option('l66-sasdllink','empty');
	$chk = get_option('sasaffid','empty');
	if ($chk == "empty" || $dlink == "empty") {exit('<center><font color="red"><h2>I can not proceed,<br>you did not set your shareasale credentials in the SHAREaSALE setup screen yet !</h2></font>');}
	?>

	<form name="nogo_ftp" enctype="multipart/form-data" method="post"> 
	<select option name="nogofeed">
	<?PHP
	$dl = fopen($dlink, "r");
	$I=0;
	 while ($rsItem = fgetcsv($dl, 100000, "|")) 
	{		
		if ($rsItem[3] != "1") 
			{
		$rsItem[3] = "<b><font color='red'>".$rsItem[3]."</font></b>";$I++;
		echo "<option>".$rsItem[0]."-".$rsItem[1]."_".$rsItem[2]."_".$rsItem[3]."_".$rsItem[4]."</option>";
			}
	}

	fclose($dl); 
	?>
	<INPUT TYPE=hidden NAME="feedselect" VALUE="1">
	<input type="submit" value="select this feed to sign up for"/>
	<?

	if (isset($_POST['feedselect']) && $_POST['feedselect'] == "1")
	{
	$shard = explode ("-",$_POST['nogofeed']);
	echo "<hr>".$shard[0]." If needed, log in to shareasale in the box below. You will automatically be taken to the merchant's info to request FTP access.<hr>";
		//<a class="thickbox" href="http://www.shareasale.com/a-apimanager.cfm?KeepThis=true&TB_iframe=true&height=600&width=1010"  width="100%" height="600">CLICK TO OPEN THE SHAREASALE API</a>

	echo "<a class='thickbox' href='http://www.shareasale.com/a-datafeeds.cfm?keyword=".$shard[0]."&belong=1&category=&updatemonth=&updateday=&updateyear=&order=featureRank&sortorder=DESC&blnSubmit=1&KeepThis=true&TB_iframe=true&height=600&width=1010' width='100%' height='600'>click here now to open the merchant center</a>";
	}


	}
	
?>	
<hr>
Version 1.0 - 
Please note that shareasale only allows 200 requests a month on your API system. Every time you load a page in this plugin your API request counter will go down by 1 hit.
<hr>



