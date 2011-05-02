<?PHP 
// l66 footer
// credits and upgrade options
$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

?>
<div style="clear:both"></div>
<hr>
<?PHP 
if (get_option('l66_modus') != "PREMIUM") 
	{ 
	echo "You are registered as a freebie user. You've put a load on our system ".get_option('l66_freebie_count','a lot of'). " times. Would you consider upgrading to PREMIUM please ?<hr>";
	}
	else
	{
	echo "Thank you so much for your PREMIUM membership support ! Please let us know if we can be of assistance (or tell others about us if you are completely satisfied !)<hr>";
	}
if ((get_option('l66_freebie_count') > 15000) && (get_option('l66_modus') != "PREMIUM") )
	{
	echo "<p align='center'>We see you really like this plugin a lot. It's a shame you are still a freebie member, because our PREMIUM membership has so much more to offer, and you would actually support the 
	development of this plugin being a premium member. <br>
	If you really do not want to upgrade to premium, would you at least consider telling other people how much you like this plugin ? Maybe you could give back a bit by making some advertisement for us. We thank you in advance.	
</p><hr>";
	}		
	
if ((get_option('l66_freebie_count') > 30000) && (get_option('l66_modus')!= "PREMIUM") )
	{
	echo "<p align='center'><b>WOW, <font color='red'>you have now actually used and strained our system more than ". get_option('l66_freebie_count','a lot of') . " times</font> and you are operating as a freebie. We like you a lot, but we need to pay our bills too !<br>
We really think that if you use our system this often you should upgrade this URL to premium !<br>
By now you should now what our system can and cannot do so we really need you to make a decision.
<br>When you continue to strain our system in freebie mode this much we are going to have to contrain your account.
<br>Please consider joining us as we can help eachother to be succesful.</b></p>
<hr>";
	}	
?>
<div style="float:left;width:100px">
<a href="http://lane66.com" target="_blank"><img src='<?PHP echo $x."pics/fm.jpg"; ?>' width='85' height='85' title='Lane66.com was made possible in part by team feed-monster from http://portaljumper.com'>
</a></div>
<div style="float:left;width:70%;text-align:center">
<p align="center">
<b>Version 1.5.5</b> | lane66.com - affiliate tools PRO | Project-leader: <a href="http://portaljumper.com/discuss" target="_blank" title="get hold of pete by writing in the forum. Simply click and a new page will open up.">Pete Scheepens</a></p>
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
<div style="clear:both;text-align:center;text-size:11px">
<hr>Every now and then you land a big commission on a single click. It's like winning the lottery or jack-pot.<br>
Just as people tip their dealers on a big winning, you can tip the developers that helped you with this software ..<br>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="HXXP6BSWTF2YQ">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/nl_NL/i/scr/pixel.gif" width="1" height="1">
</form>
</div>

<div style="text-align:center;width:100%">
You know the affiliate game ... you love lane66.com ... why not make some real money with us !<br> <a href="http://portaljumper.com/wp-content/plugins/wp-affiliate-platform/affiliates/"
 title="high payouts and a 1 year cookie time !" target="_blank"> >>>>>>> Become a lane66.com affiliate <<<<<<<<< </a>
<br>
<center><br>Below is a live example of a linksalt.com ad. linksalt provides affiliate ads with YOUR ID in it.<br>Try it now, it's free. Linksalt.com is sponsored by lane66.com and is provided as part of this plugin <br>
<iframe src='http://linksalt.com/admaker.php?adsize=200-200-special&network=clixgalore&searchword=&affid=&feed=18004Champagne&co1=FFFFFF&co2=FFFFFF' width='200' height='200' border='0' frameborder='0' scrolling='no' marginheight='0' marginwidth='0'></iframe></center>			
</div>