<?PHP
// this is layout1 - a default layout for lane66.com's AFFILIATE PRO wordpress plugin
// get more layouts from http://lane66.com or build your own and submit it to lane66.com
// layout by Pete Scheepens - lane66.com
global $wpdb;
$table_name = $wpdb->prefix . "lane66_feeds";
$view = $wpdb->get_results("SELECT * FROM $table_name WHERE ( feedname =  '$thefeeds' ) $sqlsearch $order LIMIT $limit"); 
		foreach ($view as $row) 
	{
	

			?>
			<DIV style="text-align:center;font-family:serif;font-size:small;float:left;height:300px;overflow:hidden;width:200px">
				<DIV style="text-align:center;font-size:12pt;font-weight:bold;width:98%;height:23px;overflow:hidden;background-color:#F7BE81;color:#61380B"> <!-- title bar -->
				<A href="<?PHP echo $row->link ; ?>"><?PHP echo $row->title ; ?></a>
				</div>
					<DIV style="text-align:center;height:150px;overflow:hidden"> <!-- left picture box -->
			
					<A href="<?PHP echo $row->link ; ?>"><img src="<?PHP echo $row->image ; ?>" width="148" onError="this.src='http://lane66.com/pics/noim.jpg'"></a>
			
					</div>
					<DIV style="width:200px;height:82px;overflow:hidden;padding:5px;"> <!-- right center box -->
					<?PHP echo strip_tags($row->descr) ; ?>
					</div>
					
				<DIV style="text-align:center;font-size:12pt;text-align:left;color:#FDD017;width:98%;height:20px;overflow:hidden;background-color:#2A1B0A;"> <!-- bottom bar -->
				<?PHP if (get_option('l66_modus') != "PREMIUM") 
				{echo "<div style='float:right;font-size:10pt;font-weight:200;color:#BDBDBD'><a href='http://lane66.com' alt='lane66.com affiliate tools PRO-series' title='This product and website was built with the free version of lane66.com affiliate tools PRO-series. Click this link now to get your personal copy'><font color='#4E3211'>lane66</font></a></div>";} ?>
				
				
				Price : <A href="<?PHP echo $row->link ; ?>" ><font color='#FFF380'><?PHP echo $row->currency." ".$row->price; ?></font></a>
				</div>	
				<DIV style="text-align:center;width:200px;height:16px;overflow:hidden"> <!-- right center box -->
					<center><A href="<?PHP echo $row->link ; ?>"><b>Click Here ...</b></a>
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