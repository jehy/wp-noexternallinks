<?php
if(strpos(getcwd(),'wp-content/plugins/wp-noexternallinks'))
  die('Error: Plugin "wp-noexternallinks" does not support standalone calls, damned hacker.');

new wp_noexternallinks_admin();
class wp_noexternallinks_admin extends wp_noexternallinks
{
function wp_noexternallinks_admin()
{
  $this->init_lang();
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
  # return $mydata;
}
function add_custom_box($page,$context)
{
  add_meta_box( 'wp_noextrenallinks_sectionid1', WPNEL_PERPOST_SETTINGS,array($this,'inner_custom_box1'), 'post', 'advanced' );
  add_meta_box( 'wp_noextrenallinks_sectionid1', WPNEL_PERPOST_SETTINGS,array($this,'inner_custom_box1'), 'page', 'advanced' );
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
  echo'>'.WPNEL_DEFAULT_POLICY.'<br><input type="radio" name="wp_noextrenallinks_mask_links" value="2"';
  if($mask==2)echo' checked';
  echo '>'.WPNEL_DONT_MASK;
}

function Activate()
{
  $mask_mine=get_option('noexternallinks_mask_mine');
  $mask_comment=get_option('noexternallinks_mask_comment');
  $mask_author=get_option('noexternallinks_mask_author');

  $add_nofollow=get_option('noexternallinks_add_nofollow');
  $add_blank=get_option('noexternallinks_add_blank');
  $put_noindex=get_option('noexternallinks_put_noindex');
  $disable_mask_links=get_option('noexternallinks_disable_mask_links');

  $this->LINK_SEP=get_option('noexternallinks_link_separator');
  if($this->LINK_SEP===FALSE)
  	add_option('noexternallinks_link_separator','goto', 'link separator');

  if($mask_mine===FALSE)
  	add_option('noexternallinks_mask_mine','1', 'if i must mask links in your content');
  if($mask_comment===FALSE)
  	add_option('noexternallinks_mask_comment','1', 'if i must mask links in coments');
  if($mask_author===FALSE)
  	add_option('noexternallinks_mask_author', '1', 'if i must mask links in authors');

  if($add_nofollow===FALSE)
  	add_option('noexternallinks_add_nofollow', '1', 'if i must add rel=nofollow');
  if($add_blank===FALSE)
  	add_option('noexternallinks_add_blank', '1', 'if i must mask add target="_blank"');
  if($put_noindex===FALSE)
  	add_option('noexternallinks_put_noindex', '0', 'if i must add noindex tag to links');
  if($disable_mask_links===FALSE)
  	add_option('noexternallinks_disable_mask_links', '0', 'if i shouldn`t mask urls');
}

function DeActivate()
{
  delete_option('noexternallinks_mask_mine');
  delete_option('noexternallinks_mask_comment');
  delete_option('noexternallinks_mask_author');

  delete_option('noexternallinks_add_blank');
  delete_option('noexternallinks_add_nofollow');
  delete_option('noexternallinks_put_noindex');
  delete_option('noexternallinks_disable_mask_links');

  delete_option('noexternallinks_exclude_links');
  delete_option('noexternallinks_link_separator');
}


function update()
{
global $_REQUEST;
    update_option('noexternallinks_mask_mine',$_REQUEST['noexternallinks_mask_mine']);
    update_option('noexternallinks_mask_comment',$_REQUEST['noexternallinks_mask_comment']);
    update_option('noexternallinks_mask_author',$_REQUEST['noexternallinks_mask_author']);
    update_option('noexternallinks_exclude_links',$_REQUEST['noexternallinks_exclude_links']);
    update_option('noexternallinks_add_nofollow',$_REQUEST['noexternallinks_add_nofollow']);
    update_option('noexternallinks_add_blank',$_REQUEST['noexternallinks_add_blank']);
    update_option('noexternallinks_put_noindex',$_REQUEST['noexternallinks_put_noindex']);
    update_option('noexternallinks_disable_mask_links',$_REQUEST['noexternallinks_disable_mask_links']);
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

function option_page()
{
	$mask_mine=get_option('noexternallinks_mask_mine');
	$mask_comment=get_option('noexternallinks_mask_comment');
	$mask_author=get_option('noexternallinks_mask_author');
	$add_nofollow=get_option('noexternallinks_add_nofollow');
	$add_blank=get_option('noexternallinks_add_blank');
	$put_noindex=get_option('noexternallinks_put_noindex');
	$disable_mask_links=get_option('noexternallinks_disable_mask_links');
?>
	<form method="post" action="">
		<?php wp_nonce_field('update-options'); ?>
		<div style="float:right;margin-right:2em;">
			<b>WP NoExternalLinks <?php echo WPNEL_VERSION;?></b><br>
			<a href="http://jehy.ru/wp-plugins.en.html" target="_blank"><?php echo WPNEL_PLUGIN_HOMEPAGE;?></a><br />
			<a href="http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/" target="_blank"><?php echo WPNEL_FEEDBACK;?></a>
		</div>
		<?php echo WPNEL_DEFAULT_OPTIONS;?><br><br>
			<input type="checkbox" name="noexternallinks_mask_mine" value="1"<?php if($mask_mine==1) echo ' checked';?>><?php echo WPNEL_MASK_LINKS_IN_POSTS;?><br><br>
	<input type="checkbox" name="noexternallinks_mask_comment" value="1"<?php if($mask_comment==1) echo ' checked';?>><?php echo WPNEL_MASK_LINKS_IN_COMMENTS;?><br><br>
	<input type="checkbox" name="noexternallinks_mask_author" value="1"<?php if($mask_author==1) echo ' checked';?>><?php echo WPNEL_MASK_LINKS_IN_AUTHORS;?><br><br>
				<font color="red">NEW!!!</font><br>
	<input type="checkbox" name="noexternallinks_add_nofollow" value="1"<?php if($add_nofollow==1) echo ' checked';?>><?php echo WPNEL_ADD_NOFOLLOW;?><br><br>
			<input type="checkbox" name="noexternallinks_add_blank" value="1"<?php if($add_blank==1) echo ' checked';?>><?php echo WPNEL_ADD_BLANK;?><br><br>
			<input type="checkbox" name="noexternallinks_put_noindex" value="1"<?php if($put_noindex==1) echo ' checked';?>><?php echo WPNEL_PUT_NOINDEX;?><br><br>
			<input type="checkbox" name="noexternallinks_disable_mask_links" value="1"<?php if($disable_mask_links==1) echo ' checked';?>><?php echo WPNEL_DISABLE_MASK_LINKS;?><br><br><hr>
<?php echo WPNEL_EXCLUDE_URLS;?><br>
	<textarea cols="70" rows="5" name="noexternallinks_exclude_links"><?php echo get_option('noexternallinks_exclude_links');?></textarea>
		<div align="right"><input type="submit" name="submit" value="<?php _e('Save Changes') ?>" class="button-primary"/>
</div></div>
	</form><p style="font-size:smaller;"><?php echo WPNEL_HINT;?></p>
<?php
}


function admin_options()
{
global $_REQUEST;
	echo '<div class="wrap"><h2>WP-NoExternalLinks '.WPNEL_VERSION.'</h2>';
	if($_REQUEST['submit'])
		$this->update();
	$this->option_page();
	echo '</div>';
}
}


?>