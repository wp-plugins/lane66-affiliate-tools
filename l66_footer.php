<?PHP 
// l66 footer
// credits and upgrade options
$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
?>
<div style="clear:both"></div>
<hr>
<?PHP 
if (get_option('l66_modus') == "freebie") 
	{ 
	echo "You are registered as a freebie user. You've put a load on our system ".get_option('l66_freebie_count','a lot of'). " times. Would you consider upgrading to PREMIUM please ?<hr>";
	}
	else
	{
	echo "Thank you so much for your PREMIUM membership support ! Please let us know if we can be of assistance (or tell others about us if you are completely satisfied !)<hr>";
	}
if ((get_option('l66_freebie_count') > 20000) && (get_option('l66_modus') == "freebie"))
	{
	echo "WOW, you have actually used and strained our system more than ". get_option('l66_freebie_count','a lot of') . " times and you are a freebie. We like you a lot, but we need to pay our bills too !<br>
We really think that if you use our system this often you should upgrade this URL to premium !<br>
By now you should now what our system can and cannot do so we really need you to make a decision.
<br>When you continue to strain our system in freebie mode this much we have no choice but to delete your account.
<br>Please consider joining us as we can help eachother become supreme affiliate marketeers.
<hr>";
	}	
?>
<div style="float:left;width:100px">
<a href="http://lane66.com" target="_blank"><img src='<?PHP echo $x."pics/fm.jpg"; ?>' width='85' height='85' title='Lane66.com was made possible in part by team feed-monster from http://portaljumper.com'>
</a></div>
<div style="float:left;width:70%;text-align:center">
<p align="center">
<font color="purple">It has been announced many times > When version 1.0 came around our prices increased (for NEW members). Surprised about this increase ? As an absolute last chance to upgrade at old prices use the <a href="http://lane66.com/affiliates/84/go-premium-and-join-the-top-affiliate-earners/">upgrade feature on our website</a>, we'll keep it there for a few more days ! (at 9,- / mo.).</font><br><hr>
<b>Version 0.1.0</b> | lane66.com - affiliate tools PRO | Project-leader: <a href="http://lane66.com/forum" target="_blank" title="get hold of pete by writing in the forum. Simply click and a new page will open up.">Pete Scheepens</a></p>
<small><font color='#95B9C7'>While our tools are available free of charge and are functional out of the box the freebie mode should not be relied on for actual marketing efforts.If you are serious about your income we highly recommend you upgrade to enhanced functionality as a premium member. The lane66.com plugin series is geared towards the moderate to professional affiliate marketeer. We spent many hours providing these tools for you. If you use them to make money, we feel you should return the favor and upgrade.
To upgrade to premium member status simply hit the shopping cart to the right. Besides <a href="http://lane66.com/affiliates/84/go-premium-and-join-the-top-affiliate-earners/" title="Premium members earn more money - it's a statistical fact">premium membership</a> additional (free) power-tools and <a href="http://lane66.com/tools/add-ons-extensions/" title="Increase your earnings with proven moneymaking add-on's" >add-on's</a> are also available through
our website at <a href="http://lane66.com" target="_blank" title="home of the award winning plugins">lane66.com</a></font></small>
</div>
<div style="float:left;text-align:center">

Go premium fur just 19,-/mo.<br>and boost your earnings !<br>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<!-- <input type="hidden" name="hosted_button_id" value="9SWRCQWWT45VG"> 9/mo -->
<input type="hidden" name="hosted_button_id" value="KVEFCLLMVF5SE">
<table>
<tr><td><input type="hidden" name="on0" value="enter your blog url"></td></tr>
<tr><td><input type="text" name="os0" size="30" maxlength="90" value="<?php bloginfo('wpurl'); ?>"></td></tr>
</table>
<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="go premium and boost your income.">
<img alt="" border="0" src="https://www.paypal.com/nl_NL/i/scr/pixel.gif" width="1" height="1">
</form>
</div>