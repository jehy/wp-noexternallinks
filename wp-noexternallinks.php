<?php
if(strpos(getcwd(),'wp-content/plugins/wp-noexternallinks'))
	die('Error: Plugin "wp-noexternallinks" does not support standalone calls, damned hacker.');
DEFINE(WPNEL_VERSION,'2.02');
/*
Plugin Name: WP No External Links
Plugin URI: http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/
Description: This plugin will allow you to mask all external links to internal, or to hide them. Your own posts, comments pages, authors pages... To set up, visit <a href="options-general.php?page=wp-noexternallinks/wp-noexternallinks.php">configuration panel</a>. 
Version: 2.02
Author: Jehy
Author URI: http://jehy.ru/index.en.html
Update Server: http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/
Min WP Version: 2.6
Max WP Version: 2.7.1
*/

/*  Copyright 2008  Jehy  (email : jehy@valar.ru)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

#DEFINE (NOEXTERNALLINKS_DEFAULT_FILEPATH,get_option('siteurl') .'/'. PLUGINDIR .'/'. plugin_basename( dirname(__FILE__) ) .'/goto.php?');
$wp_noexternallinks_exclude_links=array();



add_action('save_post', 'wp_noextrenallinks_save_postdata');
add_action('do_meta_boxes', 'wp_noextrenallinks_add_custom_box', 15, 2);

function wp_noextrenallinks_save_postdata( $post_id ) {


  if ( !wp_verify_nonce( $_REQUEST['wp_noextrenallinks_noncename'], plugin_basename(__FILE__) )) {
    return $post_id;
  }

  if ( 'page' == $_REQUEST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ))
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ))
      return $post_id;
  }
  update_post_meta($post_id, 'wp_noextrenallinks_mask_links', $_REQUEST['wp_noextrenallinks_mask_links']);
  # return $mydata;
}
function wp_noextrenallinks_add_custom_box($page,$context)
{
wp_noexternallinks_init_lang();
add_meta_box( 'wp_noextrenallinks_sectionid1', WPNEL_PERPOST_SETTINGS, 
                'wp_noextrenallinks_inner_custom_box1', 'post', 'advanced' );
add_meta_box( 'wp_noextrenallinks_sectionid1', WPNEL_PERPOST_SETTINGS, 
                'wp_noextrenallinks_inner_custom_box1', 'page', 'advanced' );
}


function wp_noextrenallinks_inner_custom_box1() {
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

function wp_noextrenallinks_Activate()
{
#add_option('noexternallinks_gotopath',NOEXTERNALLINKS_DEFAULT_FILEPATH, 'path to goto file');

$mask_mine=get_option('noexternallinks_mask_mine');
$mask_comment=get_option('noexternallinks_mask_comment');
$mask_author=get_option('noexternallinks_mask_author');

$add_nofollow=get_option('noexternallinks_add_nofollow');
$add_blank=get_option('noexternallinks_add_blank');
$put_noindex=get_option('noexternallinks_put_noindex');
$disable_mask_links=get_option('noexternallinks_disable_mask_links');

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
	add_option('noexternallinks_put_noindex', '1', 'if i must add noindex tag to links');
if($disable_mask_links===FALSE)
	add_option('noexternallinks_disable_mask_links', '1', 'if i shouldn`t mask urls');


#add_option('noexternallinks_lang', 'eng', 'language settings');
}

function wp_noextrenallinks_DeActivate()
{
#delete_option('noexternallinks_gotopath');
delete_option('noexternallinks_mask_mine');
delete_option('noexternallinks_mask_comment');
delete_option('noexternallinks_mask_author');
#delete_option('noexternallinks_lang');
}


function wp_noextrenallinks_Redirect()
{
  global $_REQUEST;
 $goto=''; 
 $p=strpos($_SERVER['REQUEST_URI'],'/goto/');
  if($_REQUEST['goto'])
  	$goto=$_REQUEST['goto'];
  elseif($p!==FALSE)
  {
  	$goto=substr($_SERVER['REQUEST_URI'],$p+6);
  }
  else
  {
  	$url=$_SERVER['REQUEST_URI'];
  	$url=explode('/',$url);
  	if($url[sizeof($url)-2]=='goto')
  		$goto=$url[sizeof($url)-1];
  }
  if($goto)
    wp_noextrenallinks_redirect2($goto);
}

function wp_noextrenallinks_redirect2($url)
{global $wp_rewrite;

wp_noexternallinks_init_lang();
if(!$wp_rewrite->using_permalinks())
  $url=urldecode($url);
header('Content-type: text/html; charset="utf-8"',true);
if($url)
	@header('Location: '.$url);
?>
<html><head><title><?php echo WPNEL_REDIRECTING;?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="robots" content="noindex,nofollow" />
<?php if($url) echo '<meta http-equiv="refresh" content="0; url='.$url.';" />'; ?>
</head><body style="margin:0;"><div align="center" style="margin-top: 15em;">
<?php if($url)
  echo WPNEL_REDIRECT1.'<a href="'.$url.'">'.WPNEL_REDIRECT2.'</a>'.WPNEL_REDIRECT3.$url.WPNEL_REDIRECT4;
else echo (WPNEL_NO_REDIRECT);?>
</div></body></html><?php die;
}


function parse_noexternallinks($matches)
{
  global $wp_rewrite,$wp_noexternallinks_exclude_links,$wp_noexternallinks_if_blank,$wp_noexternallinks_if_nofollow,$wp_noexternallinks_disable_masking,$wp_noexternallinks_put_noindex;
  if(!$wp_rewrite->using_permalinks())
    $sep='?goto=';
  else
  	  $sep='/goto/';
  if($wp_noexternallinks_if_blank)
  	  $ifblank=' target="_blank"';
  if($wp_noexternallinks_if_nofollow)
  	  $ifnofollow=' rel="nofollow"';
  
  #no masking for those urls:
  for($i=0;$i<sizeof($wp_noexternallinks_exclude_links);$i++)
  	  if($wp_noexternallinks_exclude_links[$i])
        if(strpos($matches[2] . '//' .$matches[3],$wp_noexternallinks_exclude_links[$i])===0)#if begins with		
          return '<a'.$ifblank.' href="' . $matches[2] . '//' . $matches[3] . '" ' . $matches[1] . $matches[4] . '>' . $matches[5] . '</a>';
  
  #mask all others!
  	$url=($matches[2] . '//' . $matches[3]);
  if($wp_noexternallinks_disable_masking)
  	  ;
  else
  {
  	if(!$wp_rewrite->using_permalinks())
  	  $url=urlencode($url);
  	$url=get_option('siteurl').$sep.$url;
  }
  $link='<a'.$ifblank.$ifnofollow.' href="'.$url.'" '.$matches[1].$matches[4].'>'.$matches[5].'</a>';
  if($wp_noexternallinks_put_noindex)
  	$link='<noindex>'.$link.'</noindex>';
  return $link;
}


function wp_noextrenallinks($content)
{
  global $wp_noexternallinks_exclude_links,$wp_noexternallinks_if_blank,$wp_noexternallinks_if_nofollow,$wp_noexternallinks_disable_masking,$wp_noexternallinks_put_noindex,$post;
  
  
  $mask = get_post_meta($post->ID, 'wp_noextrenallinks_mask_links', true);
  if($mask==2)
  	  return $content;
  if(!sizeof($wp_noexternallinks_exclude_links))
  {
	$site=get_option('siteurl');
	$p=strpos($site,'/',7);
	if($p)$site=substr($site,0,$p);#site root is excluded
	
	$exclude=get_option('noexternallinks_exclude_links');
	$wp_noexternallinks_exclude_links=@explode("\n",$exclude);
	$wp_noexternallinks_exclude_links[]=$site;
  }
  $wp_noexternallinks_if_blank=get_option('noexternallinks_add_blank');
  $wp_noexternallinks_if_nofollow=get_option('noexternallinks_add_nofollow');
  $wp_noexternallinks_put_noindex=get_option('noexternallinks_put_noindex');
  $wp_noexternallinks_disable_masking=get_option('noexternallinks_disable_mask_links');
  
  $pattern = '/<a (.*?)href=[\"\'](.*?)\/\/(.*?)[\"\'](.*?)>(.*?)<\/a>/i';
  $content = preg_replace_callback($pattern,'parse_noexternallinks',$content);
  return $content;
	
}


function wp_noextrenallinks_update()
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


function wp_noexternallinks_init_lang()
{
  if(in_array(WPLANG,array('ru','RU','ru_RU')))#ru_RU))
    $lang='rus';
  else
    $lang='eng';
  include_once('lang/lang.'.$lang.'.inc');
}
	
function wp_noextrenallinks_option_page()
{
	wp_noexternallinks_init_lang();
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
		<?php/*<div class="form-table" style="width:70%; border:1px solid #666; padding:10px; background-color:#CECECE;">
			<h3><?php echo WPNEL_LANGUAGE;?></i>:</h3>
			<?php
$dir='../wp-content/plugins/wp-noexternallinks/lang/';
 if(file_exists($dir)&&@is_dir($dir))
{echo'<select name="noexternallinks_lang">';
  $d = dir($dir);
  while (false !== ($entry = $d->read()))
    if(is_file($dir.$entry))
  {
  	  $entry=explode('.',$entry);
      echo '<option';
      if($lang==$entry[1])echo' selected';
      echo ' value="'.$entry[1].'">'.$entry[1].'</option>';
  }
  $d->close();
  echo '</select>';
}
else echo '<font color="red">Crytical error: can not find language files directory!!!</font>';
	?><br />
			
			<h3><?php echo WPNEL_PATH_TO_GOTO;?></i>:</h3>
			<input name="noexternallinks_gotopath" value="<?php echo get_option('noexternallinks_gotopath');?>" type="text" style="width:90%;" /><br />
				
			<div style="font-size:smaller;"><?php echo WPNEL_DEFAULT;?>:<br><?php echo NOEXTERNALLINKS_DEFAULT_FILEPATH;?><br><?php echo WPNEL_IF_MODE_REWRITE;?>:
			<ul>
			<li><?php echo WPNEL_PUT_HERE_SMTH_LIKE;?> "<?php echo $s=get_option('siteurl').'/goto/';?>"</li>
			<li><?php echo WPNEL_PUT_LINE_LIKE;?> "RewriteRule ^<?$p=@strpos($s,'/',7);if($p)echo substr($s,$p+1);?>(.*) http://$1 [R=301,L]" <?php echo WPNEL_TO_YOUR_FILE;?> .htaccess</li></ul>
			<?php echo WPNEL_THEN_APACHE_LEVEL_REDIRECT;?>
			</div>*/?><?php echo WPNEL_DEFAULT_OPTIONS;?><br><br>
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
		<div align="right"><input type="submit" name="submit" value="<?php _e('Save Changes') ?>" />
</div></div>
	</form><p style="font-size:smaller;"><?php echo WPNEL_HINT;?></p>
<?php
}



function wp_noextrenallinks_set_filters()
{
	if(FALSE===$mask_mine=get_option('noexternallinks_mask_mine'))
		$mask_mine=1;
	if(FALSE===$mask_comment=get_option('noexternallinks_mask_comment'))
		$mask_comment=1;
	if(FALSE===$mask_author=get_option('noexternallinks_mask_author'))
		$mask_author=1;

	if($mask_mine)
		add_filter('the_content','wp_noextrenallinks',99);
	if($mask_comment)
	{
		add_filter('comment_text','wp_noextrenallinks',99);
		add_filter('comment_text_rss','wp_noextrenallinks',99);
		add_filter('comment_url','wp_noextrenallinks',99);
	}
	if($mask_author)
	{
		add_filter('get_comment_author_url_link','wp_noextrenallinks',99);
		add_filter('get_comment_author_link','wp_noextrenallinks',99);
		add_filter('get_comment_author_url','wp_noextrenallinks',99);
	}
}
wp_noextrenallinks_set_filters();

function wp_noextrenallinks_admin_options()
{
global $_REQUEST;
	echo '<div class="wrap"><h2>WP-NoExternalLinks '.WPNEL_VERSION.'</h2>';
	if($_REQUEST['submit'])
		wp_noextrenallinks_update();
	wp_noextrenallinks_option_page();	
	echo '</div>';
}


function wp_noextrenallinks_modify_menu(){
	add_options_page(
		'WP-NoExternalLinks',
		'WP-NoExternalLinks',
		'manage_options',
		__FILE__,
		'wp_noextrenallinks_admin_options'
		);
}
add_action('admin_menu', 'wp_noextrenallinks_modify_menu');
register_activation_hook(__FILE__,'wp_noextrenallinks_Activate');
register_deactivation_hook(__FILE__,'wp_noextrenallinks_DeActivate');
add_filter('template_redirect','wp_noextrenallinks_Redirect',1);#modify template
?>