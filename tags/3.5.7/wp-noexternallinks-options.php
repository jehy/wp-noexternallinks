<?php
if(!defined('DB_NAME'))
  die('Error: Plugin "wp-noexternallinks" does not support standalone calls, damned hacker.');

class wp_noexternallinks_admin extends wp_noexternallinks
{
function wp_noexternallinks_admin()
{
  $this->init_lang();
  $this->load_options();
  add_action('save_post', array($this,'save_postdata'));
  add_action('do_meta_boxes', array($this,'add_custom_box'), 15, 2);
  add_action('admin_menu', array($this,'modify_menu'));
  register_activation_hook(__FILE__,array($this,'activate'));
  #register_deactivation_hook(__FILE__,array($this,'wp_noextrenallinks_DeActivate'));
}

function save_postdata( $post_id )
{
  if ( !wp_verify_nonce( $_REQUEST['wp_noextrenallinks_noncename'], plugin_basename(__FILE__) ))
    return $post_id;

  if ( 'page' == $_REQUEST['post_type'] ){
    if ( !current_user_can( 'edit_page', $post_id ))
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ))
      return $post_id;
  }
  update_post_meta($post_id, 'wp_noextrenallinks_mask_links', $_REQUEST['wp_noextrenallinks_mask_links']);
}
function add_custom_box($page,$context)
{
  add_meta_box( 'wp_noextrenallinks_sectionid1', __('Link masking for this post','wpnoexternallinks'),array($this,'inner_custom_box1'), 'post', 'advanced' );
  add_meta_box( 'wp_noextrenallinks_sectionid1', __('Link masking for this post','wpnoexternallinks'),array($this,'inner_custom_box1'), 'page', 'advanced' );
}

function inner_custom_box1() {
	global $post;
  echo '<input type="hidden" name="wp_noextrenallinks_noncename" id="wp_noextrenallinks_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
  $mask = get_post_meta($post->ID, 'wp_noextrenallinks_mask_links', true);
  if($mask==='')
  	$mask=0;
  echo '<input type="radio" name="wp_noextrenallinks_mask_links" value="0"';
  if($mask==0)echo' checked';
  echo'>'.__('Use default policy from plugin settings','wpnoexternallinks').'<br><input type="radio" name="wp_noextrenallinks_mask_links" value="2"';
  if($mask==2)echo' checked';
  echo '>'.__('Don`t mask links','wpnoexternallinks');
}
/*
function Activate()
{
  #nothing now.
}

function DeActivate()
{
  #here could be option uninstall. But better not.
}
*/

function update()
{
    $this->options=$_REQUEST['options'];
    $this->update_options();
    echo '<div class="updated">'.__('Options updated.','wpnoexternallinks').'</div>';
    $this->load_options();
}


function modify_menu(){
	add_options_page(
		'NoExternalLinks&nbsp;<img src="'.plugin_dir_url( __FILE__ ).'externallink.png">',
		'NoExternalLinks&nbsp;<img src="'.plugin_dir_url( __FILE__ ).'externallink.png">',
		'manage_options',
		__FILE__,
		array($this,'admin_options')
		);
}

function view_stats()
{global $wpdb;
?>
	<form method="post" action="">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'];?>">
		<?php wp_nonce_field('update-options'); ?>
<a href="?page=<?php echo $_REQUEST['page'];?>" class="button-primary"><?php _e('View options','wpnoexternallinks');?></a>
<a href="http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/" class="button-primary"><?php _e('Feedback','wpnoexternallinks');?></a><br><br>
<?php
	
if(!$this->options['stats'])
{
_e('Statistic for plugin is disabled! Please, go to options page and enable it via checkbox "Log all outgoing clicks".','wpnoexternallinks');
echo'</form>';
}
else
{
if($_REQUEST['date1'])
		$date1=$_REQUEST['date1'];
else
	$date1=date('Y-m-d');
if($_REQUEST['date2'])
		$date2=$_REQUEST['date2'];
else
	$date2=date('Y-m-d');
_e('View stats from ','wpnoexternallinks');
?>
		<input type="text" name="date1" value="<?php echo $date1;?>"><?php _e(' to ','wpnoexternallinks');?><input type="text" name="date2" value="<?php echo $date2;?>"><input type="submit" value="<?php _e('View','wpnoexternallinks');?>" class="button-primary">
		</form><br><style>.urlul{padding:5px 0px 0px 25px;}</style>
<?php
	$sql='select * from '.$wpdb->prefix.'links_stats where `date` between "'.addslashes($date1).' 00:00:00" and "'.addslashes($date2).' 23:59:59"';
	$result=$wpdb->get_results($sql,ARRAY_A);
   if(is_array($result)&&sizeof($result))
   {
   	$out=array();
   	foreach($result as $row)
   	{
   		$nfo=parse_url($row['url']);
      if($row['url']&&$nfo['host'])
   		  $out[$nfo['host']][$row['url']]++;
   	}
   	foreach($out as $host=>$arr)
   	{
   		echo '<br>'.$host.'<ul class="urlul">';
   		foreach($arr as $url=>$outs)
   			echo '<li><a href="'.$url.'">'.$url.'</a> ('.$outs.')</li>';
   		echo '</ul>';
   	}
	}
   else
		_e('No statistic for given period.','wpnoexternallinks');
}
		
}

function option_page()
{
?><p><?php _e('That plugins allows you to mask all external links and make them internal or hidden - using PHP redirect or special link tags and attributes. Yeah, by the way - it does not change anything in the base - only replaces links on output. If you disabled this plugin and still have links masked - it is your caching plugin`s fault!','wpnoexternallinks');?></p>
<p>
<?php echo __('If you need to make custom modifications for plugin - you can simply extend it, according to','wpnoexternallinks').' <a href="http://jehy.ru/articles/2014/12/08/custom-parser-for-wp-noexternallinks/">'.__('this article.','wpnoexternallinks').'</a>';?>
</p>
	<form method="post" action="">
		<?php wp_nonce_field('update-options'); ?>
<a href="?page=<?php echo $_REQUEST['page'];?>&action=stats" class="button-primary"><?php _e('View Stats','wpnoexternallinks');?></a>
<a href="http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/" class="button-primary"><?php _e('Feedback','wpnoexternallinks');?></a><br>
<?php echo '<h2>'.__('Global links masking settings','wpnoexternallinks').'</h2>'.'('.__('You can also disable plugin on per-post basis','wpnoexternallinks').')';?><br><br>
<?php
$opt=$this->GetOptionInfo();
echo '<h3>'.__('Choose masking type','wpnoexternallinks').'</h3><p>'.__('Default masking type is via 302 redirects. Please choose one of the following mods if you do not like it:','wpnoexternallinks').'</p>';
$this->show_option_group($opt,'type');
echo '<h3>'.__('What to mask','wpnoexternallinks').'</h3>';
$this->show_option_group($opt,'what');
echo '<h3>'.__('What to exclude from masking','wpnoexternallinks').'</h3>';
$this->show_option_group($opt,'exclude');
echo '<h3>'.__('Common configuration','wpnoexternallinks').'</h3>';
$this->show_option_group($opt,'common');
echo '<h3>'.__('Link encoding','wpnoexternallinks').'</h3><p>'.__('Those options are not secure enough if you want to protect your data from someone but are quite enough to make link not human-readable. Please choose one of them:','wpnoexternallinks').'</p>';
$this->show_option_group($opt,'encode');
echo '<h3>'.__('Configuration for javascript redirects (if enabled)','wpnoexternallinks').'</h3>';
$this->show_option_group($opt,'java');

?><input type="submit" name="submit" value="<?php _e('Save Changes','wpnoexternallinks') ?>" class="button-primary"/>
</form>
<?php
}
function show_option_group($opt,$name)
{
  foreach($opt as $arr)
  {
    if($arr['grp']===$name)
	  {
      $this->show_option($arr);
	    echo '<br>';
    }
  }
}
function show_option($arr)
{
  if($arr['type']=='chk')
	{
		echo'<br><input type="checkbox" name="options['.$arr['new_name'].']" value="1"';
		if($this->options[$arr['new_name']])
			echo' checked';
		echo'>'.$arr['name'];
	}
	elseif($arr['type']=='txt')
	{
		echo'<br>'.$arr['name'].':<br><input type="text" name="options['.$arr['new_name'].']" value="'.$this->options[$arr['new_name']].'">';
	}
	elseif($arr['type']=='text')
	{
		echo '<p>'.$arr['name'].':</p>';
		echo'<textarea name="options['.$arr['new_name'].']" class="large-text code" rows="6" cols="50">'.$this->options[$arr['new_name']].'</textarea>';
	}
}
function admin_options()
{
	echo '<div class="wrap"><h2>WP-NoExternalLinks</h2>';
	if($_REQUEST['submit'])
		$this->update();
	if($_REQUEST['action']=='stats')
		$this->view_stats();
	else
		$this->option_page();
	echo '</div>';
}
}
?>