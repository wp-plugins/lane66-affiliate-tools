<?php

if(class_exists('l66_widget_3') != true)
{
class l66_widget_3 extends WP_Widget
{
  function l66_widget_3()
  {
    $widget_ops = array('classname' => 'l66_widget_3', 'description' => 'Instead of a long list of categories, put them inside a scrolling box and save screen-space. Your visitors will thank you too.' );
    $this->WP_Widget('l66_widget_3', 'lane66.com category scrollbox', $widget_ops);
  }
 
  function form($occurence)
  {
    $occurence = wp_parse_args( (array) $occurence, array( 'title' => '' ) );
    $key = $occurence['title'];   
	$fromtop = (int)$occurence['high'];
  ?>
  This widget originally ships with lane66.com affiliate tools PRO CORE. More add-on's can be found at <a href="http://lane66.com/tools/add-ons-extensions/">lane66.com</a>.<hr>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">set a title (optional): <br>
  <input id="<?php echo $this->get_field_id('title'); ?>" size="20" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($key); ?>" /></label><small>widget title</small></p><hr>
  
  <p><label for="<?php echo $this->get_field_id('high'); ?>">Enter the height of your scrollbox in pixels (width is always 100% of your widgetspace): <br>
  <input id="<?php echo $this->get_field_id('high'); ?>" size="5" name="<?php echo $this->get_field_name('high'); ?>" type="text" value="<?php echo attribute_escape($fromtop); ?>" /></label><small> Numbers only (default = 200)</small></p><hr>
  <br>
  <DIV style="text-align:center;font-size:10px;padding:3px">
  sponsor: 
<a href="http://linksalt.com" title="the better paying adsense alternative" target="_blank">
linksalt.com
</a>		
</div>
  
  <?php
  }
 
  function update($new_occurence, $old_occurence)
  {
    $occurence = $old_occurence;
    $occurence['title'] = $new_occurence['title'];
	$occurence['high'] = $new_occurence['high'];
	$occurence['location'] = $new_occurence['location'];
    return $occurence;
  }
 
  function widget($args, $occurence)
  {
$fromtop = (int)$occurence['high'];
if (empty($fromtop)) $fromtop = 200;
$key = $occurence['title'];   
global $wpdb;
// echo $before_widget;
?>
<br>
<DIV style="text-align:center;font-weight:900;font-size:18px;padding:3px">
<?PHP echo $key; ?>		
</div>
<div style="border:0px;margin:-5px;padding:20px 5px;width:90%;height:<?PHP echo $fromtop; ?>px;overflow:auto;">
<?php wp_list_categories( 'title_li=' ); ?>
<br>
</div>
<DIV style="text-align:center;font-size:10px;padding:3px">
<a href="http://linksalt.com" title="the better paying adsense alternative" target="_blank">
linksalt.com
</a>		
</div>

<?
 // echo $after_widget;

  }
 
}
}
add_action( 'widgets_init', 'l66_load_widgets' );

/* Function that registers our widget. */
if(function_exists('l66_load_widgets') != true)
{
function l66_load_widgets() {
	register_widget('l66_widget_3');
}
}

