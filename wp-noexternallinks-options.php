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
  register_activation_hook(__FILE__,array($this,'wp_noextrenallinks_Activate'));
  register_deactivation_hook(__FILE__,array($this,'wp_noextrenallinks_DeActivate'));
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

function Activate()
{
  /*nothing now.*/
}

function DeActivate()
{
  #here could be option uninstall. But better not.
}


function update()
{
    $this->options=$_REQUEST['options'];
    $this->update_options();
    $this->load_options();
}


function modify_menu(){
	add_options_page(
		'WP-NoExternalLinks',
		'WP-NoExternalLinks',
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
		<div style="float:right;margin-right:2em;background-color:#CCCCCC;padding:5px;">
			<b>WP NoExternalLinks Stats</b><br>
			<a href="http://jehy.ru/wp-plugins.en.html" target="_blank"><?php _e('Plugin home page','wpnoexternallinks');?></a><br />
			<a href="http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/" target="_blank"><?php _e('Feedback','wpnoexternallinks');?></a>
		</div>
<a href="?page=<?php echo $_REQUEST['page'];?>"><?php _e('View options','wpnoexternallinks');?></a><br>
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
		</form>
<?php
	$sql='select * from '.$wpdb->prefix.'links_stats where `date` between "'.$date1.' 00:00:00" and "'.$date2.' 23:59:59"';
	$result=@mysql_query($sql);
	$out=array();
	while($row=@mysql_fetch_array($result))
	{
		$nfo=parse_url($row['url']);
		$out[$nfo['host']][$row['url']]++;
	}
	foreach($out as $host=>$arr)
	{
		echo '<br>'.$host.'<ul>';
		foreach($arr as $url=>$outs)
			echo '<li><a href="'.$url.'">'.$url.'</a> ('.$outs.')</li>';
		echo '</ul>';
	}
	if(!sizeof($out))
		_e('No statistic for given period.','wpnoexternallinks');
}
		
}

function option_page()
{
?><p style="font-size:smaller;"><?php _e('That plugins allows you to mask all external links and make them internal or hidden - using PHP redirect or special link tags and attributes. Yeah, by the way - it does not change anything in the base - only replaces links on output.<br>P.S. It doesn`t mask internal and excluded links.','wpnoexternallinks');?></p>
	<form method="post" action="">
		<?php wp_nonce_field('update-options'); ?>
		<div style="float:right;margin-right:2em;background-color:#CCCCCC;padding:5px;">
			<b>WP NoExternalLinks</b><br>
			<a href="http://jehy.ru/wp-plugins.en.html" target="_blank"><?php _e('Plugin home page','wpnoexternallinks');?></a><br />
			<a href="http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/" target="_blank"><?php _e('Feedback','wpnoexternallinks');?></a>
		</div>
<a href="?page=<?php echo $_REQUEST['page'];?>&action=stats"><?php _e('View Stats','wpnoexternallinks');?></a><br>
<?php _e('<h3>Global links masking settings</h3>(You can also disable plugin on per-post basis)','wpnoexternallinks');?><br><br>
<?php
$opt=$this->GetOptionInfo();
foreach($opt as $i=>$arr)
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
		echo '<br>'.$arr['name'].':<br>';
		echo'<textarea name="options['.$arr['new_name'].']" style="width: 400px;height:100px;">'.$this->options[$arr['new_name']].'</textarea>';
	}
	echo '<br>';
}

?>			
			
		<div align="right"><input type="submit" name="submit" value="<?php _e('Save Changes') ?>" class="button-primary"/>
</div>
	</form>
<?php
}


function admin_options()
{
global $_REQUEST;
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


new wp_noexternallinks_admin();
?>