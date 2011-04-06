<?PHP
// this is layout1 - a default layout for lane66.com's AFFILIATE PRO wordpress plugin
// get more layouts from http://lane66.com or build your own and submit it to lane66.com
// layout by Pete Scheepens - lane66.com
echo "<div style='clear:both;height:1'></div>";
global $wpdb;
$table_name = $wpdb->prefix . "lane66_feeds";
$view = $wpdb->get_results("SELECT * FROM $table_name WHERE ( feedname =  '$thefeeds' ) $sqlsearch $order LIMIT $limit"); 

		foreach ($view as $row) 
	{
	

			?>
			<DIV style="font-family:times new roman;font-size:10pt;float:left;height:200px;overflow:hidden;width:300px">
				<DIV style="text-align:center;font-size:12pt;font-weight:bold;width:98%;height:23px;overflow:hidden;background-color:#153E7E;color:#5CB3FF"> <!-- title bar -->
				<A href="<?PHP echo $row->link ; ?>"><?PHP echo $row->title ; ?></a>
				</div>
					
					<DIV style="float:left;width:200px;height:130px;overflow:hidden"> <!-- right center box -->
					<?PHP echo strip_tags($row->descr) ; ?>
					</div>
					<DIV style="float:left;width:100px;height:130px;overflow:hidden"> <!-- left picture box -->
			
					<A href="<?PHP echo $row->link ; ?>"><img src="<?PHP echo $row->image ; ?>" width="94" onError="this.src='http://lane66.com/pics/noim.jpg'"></a>
			
					</div>
				<DIV style="font-size:14pt;text-align:right;color:#FDD017;width:98%;height:20px;overflow:hidden;background-color:#2B547E;"> <!-- bottom bar -->
				<?PHP if (get_option('l66_modus') != "PREMIUM") 
				{echo "<div style='float:left;font-size:12pt;font-weight:200;color:#BDBDBD'><a href='http://lane66.com' alt='built with the free version of lane66.com affiliate tools PRO-series' title='This product and website was built with the free version of lane66.com affiliate tools PRO-series. Click this link now to get your personal copy'><font color='#8598AB'>lane66.com</font></a></div>";} ?>
				
				Price : <A href="<?PHP echo $row->link ; ?>" ><font color='#FFF380'><?PHP echo $row->currency." ".$row->price; ?></font></a>
				</div>	
				
			</div>
			<?PHP
	}
	
if (get_option('l66_modus') != "PREMIUM") 
{
echo "<div style='clear:both;height:1'></div>";	
echo "<hr><div style='clear:both;text-align:center;color:#BDBDBD'>Created with <a href='http://lane66.com'>lane66.com</a> affiliate tools PRO-series</div>";
$brand=1;
}
echo "<div style='clear:both;height:1'></div>";	