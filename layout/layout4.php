<?PHP
// this is layout 4 - a default superpage for lane66.com's AFFILIATE PRO wordpress plugin
// get more layouts from http://lane66.com or build your own and submit it to lane66.com
// layout by Pete Scheepens - lane66.com
global $wpdb;
$table_name = $wpdb->prefix . "lane66_feeds";
$view = $wpdb->get_results("SELECT * FROM $table_name WHERE ( feedname =  '$thefeeds' ) $sqlsearch $order LIMIT $limit"); 
// searchboxes			
		foreach ($view as $row) 
	{

			?>
			<DIV style="text-align:center;font-family:serif;font-size:small;float:left;height:200px;overflow:hidden;width:160px">
				
					<DIV style="text-align:center;height:170px;overflow:hidden"> <!-- left picture box -->
			
					<A href="<?PHP echo $row->link ; ?>"><img src="<?PHP echo $row->image ; ?>" width="148" onError="this.src='http://lane66.com/pics/noim.jpg'"></a>
			
					</div>
					<DIV style="width:160px;height:30px;overflow:hidden;padding:5px;"> <!-- right center box -->
					<A href="<?PHP echo $row->link ; ?>"><?PHP echo $row->title ; ?></a>
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
$brand=0;
echo "<div style='clear:both;height:1'></div>";	