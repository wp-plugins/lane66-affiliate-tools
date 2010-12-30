<?PHP 
// l66 footer
// credits and upgrade options
$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
?>
<hr>
<div style="float:left;width:100px">
<a href="http://lane66.com" target="_blank"><img src='<?PHP echo $x."pics/fm.jpg"; ?>' width='85' height='85' title='Lane66.com was made possible in part by team feed-monster from http://portaljumper.com'>
</a></div>
<div style="float:left;width:70%">
<p align="center"><b>Version 0.3.1</b> | lane66.com - affiliate tools PRO | Project-leader: Pete Scheepens</p>
<small><font color='#95B9C7'>While our tools are available free of charge and are fully functional out of the box, we do provide enhanced functionality for our premium members.
To upgrade to premium member status simply hit the shopping cart to the right. Besides premium membership additional (free) power-tools and add-on's are also available through
our website at <a href="http://lane66.com" target="_blank">lane66.com</a></font></small>
</div>
<div style="float:left"><center>
Go premium and<br>boost your earnings !<br>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="9SWRCQWWT45VG">
<table>
<tr><td><input type="hidden" name="on0" value="enter your blog url"></td></tr>
<tr><td><input type="text" name="os0" size="30" maxlength="90" value="<?php bloginfo('wpurl'); ?>"></td></tr>
</table>
<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="go premium and boost your income.">
<img alt="" border="0" src="https://www.paypal.com/nl_NL/i/scr/pixel.gif" width="1" height="1">
</form>


</div>