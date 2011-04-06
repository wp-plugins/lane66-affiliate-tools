<?PHP
// this is layout 5 - a default superpage for lane66.com's AFFILIATE PRO wordpress plugin
// get more layouts from http://lane66.com or build your own and submit it to lane66.com
// layout by Pete Scheepens - lane66.com
global $wpdb;
$table_name = $wpdb->prefix . "lane66_feeds";
$view = $wpdb->get_results("SELECT * FROM $table_name WHERE ( feedname =  '$thefeeds' ) $sqlsearch $order LIMIT $limit"); 		
		foreach ($view as $row) 
	{
	

			?>
			<div style="float:left;text-align:center;width:150px;height:210px;background-color:white;">
			<div style="float:left;text-align:center;background:white;overflow:hidden;width:120px;height:180px;padding:8px;border:2px solid #ccc;-moz-border-radius:32px;-webkit-border-radius:30px;background-color:white;">
			<div style="float:left;text-align:center;width:104px;height:100px;background-color:white;">
			<a href="<?PHP echo $row->link ; ?>" title="<?PHP echo $row->title ; ?>">
			<img src="<?PHP echo $row->image ; ?>" alt="clickable html round image" style="width:100px;height:100px;padding:8px;background:#fff;border:2px solid #ccc;-moz-border-radius:32px;-webkit-border-radius:30px;" onError="this.src='http://lane66.com/pics/noim.jpg'"/>
			</a>			
			</div>
			<div style="color:black;text-align:center;text-size:11px;font-weight:900;">
			<A href="<?PHP echo $row->link ; ?>" title="<?PHP echo $row->title ; ?>">
			<?PHP echo $row->currency . $row->price ; ?>
			</a>
			</div>
			<div style="text-align:center;text-size:11px">
			<A href="<?PHP echo $row->link ; ?>" title="<?PHP echo $row->descr ; ?>">
			<?PHP echo $row->title ; ?>
			</a>
			</div>
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

echo "<div style='clear:both;height:1'>hit</div>";	