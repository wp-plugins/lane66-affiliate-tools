<?php
$feedname = htmlspecialchars (strip_tags($_GET['f']));
$title = htmlspecialchars (strip_tags($_GET['t']));
$ty = htmlspecialchars (strip_tags($_GET['ty']));
if (isset($_GET['pr'])) {$pr = htmlspecialchars (strip_tags($_GET['pr']));} else {$pr = "wp_";}
$table_name = $pr ."lane66_feeds";
$track_table = $pr ."lane66_tracking";
$sql = "SELECT link FROM $table_name WHERE feedname='$feedname' AND title='$title'";
$result = mysql_query($sql) or die(mysql_error()); 
while($row = mysql_fetch_array( $result ))
{
$link = $row['link'];
}
$linktype = $link."|".$ty;
$insert = "INSERT INTO $track_table (date,linktype) VALUES (now(),'$linktype') ON DUPLICATE KEY UPDATE totalhits=totalhits+1,date=now() ";
mysql_query($insert);
header('Location: '.$link.'');

?>
<html>
<head><title>Redirecting...</title>
<meta http-equiv="refresh" content="0;url=<?php echo $link; ?>">
</head>
<body> 
  <a href="<?php echo $link; ?>">Please click here if you are not redirected ....</a>.
  
</body>
</html>
