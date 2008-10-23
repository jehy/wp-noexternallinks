<?php
if(strpos(getcwd(),'wp-content/plugins/wp-noexternallinks'))
	die('Error: Plugin does not support standalone calls, damned hacker.');
DEFINE(WPNEL_VERSION,'0.05');
/*
Plugin Name: WP No External Links
Plugin URI: http://jehy.ru/wp-plugins.en.html
Description: This plugin will allow you to mask all external links to internal. Your own posts, comments pages, authors pages... To set up, visit <a href="options-general.php?page=wp-noexternallinks/wp-noexternallinks.php">configuration panel</a>. 
Version: 0.05
Author: Jehy
Author URI: http://jehy.ru/index.en.html
Update Server: http://jehy.ru/wp-plugins.en.html
Min WP Version: 2.5
Max WP Version: 2.6.2
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

DEFINE (NOEXTERNALLINKS_DEFAULT_FILEPATH,get_option('siteurl') .'/'. PLUGINDIR .'/'. plugin_basename( dirname(__FILE__) ) .'/goto.php?');

function wp_noextrenallinks_Activate()
{
add_option('noexternallinks_gotopath',NOEXTERNALLINKS_DEFAULT_FILEPATH, 'path to goto file');
add_option('noexternallinks_mask_mine','1', 'if i must mask links in your content');
add_option('noexternallinks_mask_comment','1', 'if i must mask links in coments');
add_option('noexternallinks_mask_author', '1', 'if i must mask links in authors');
add_option('noexternallinks_lang', 'eng', 'language settings');
}

function wp_noextrenallinks_DeActivate()
{
delete_option('noexternallinks_gotopath');
delete_option('noexternallinks_mask_mine');
delete_option('noexternallinks_mask_comment');
delete_option('noexternallinks_mask_author');
delete_option('noexternallinks_lang');
}


function jehy_noextrenallinks($content)
{
	$site=get_option('siteurl');
	$p=strpos($site,'/',7);
	if($p)$site=substr($site,0,$p);
	if (!$goto =get_option('noexternallinks_gotopath'))
		$goto = NOEXTERNALLINKS_DEFAULT_FILEPATH;
	$p=0;
	while(true)
	{
		$p=strpos($content,'href',$p);
		if($p===FALSE)break;
		else
		{
			$p=strpos($content,'http://',$p);
			if($p===FALSE)
				$p+=4;
			else
			{
				$p+=7;
				$p2=strlen($content);
				$e=array();
				$e[]=strpos($content,'"',$p);
				$e[]=strpos($content,"'",$p);
				$e[]=strpos($content,'>',$p);
				for($i=0;$i<sizeof($e);$i++)
					if (($e[$i]<$p2)and($e[$i]!=0)and($e[$i]>$p))
						$p2=$e[$i];
				if($p2<=$p)
					$p+=4;
				else
				{
					$link=substr($content,$p-7,$p2-$p+7);
					$link=str_replace(array("'",'"',' '),'',$link);
					if(substr($link,0,strlen($site))==$site)
						;
					else
						$content=substr($content,0,$p-7).$goto.substr($content,$p);
					$p=$p2;
				}
			}
		}
	}
	return $content;
}


function wp_noextrenallinks_update()
{
global $_REQUEST;
	$gotopath=$_REQUEST['noexternallinks_gotopath'];
	$lang=$_REQUEST['noexternallinks_lang'];
	if($_REQUEST['noexternallinks_mask_mine'])
		$mask_mine=1;
	else $mask_mine=0;
	if($_REQUEST['noexternallinks_mask_comment'])
		$mask_comment=1;
	else $mask_comment=0;
	if($_REQUEST['noexternallinks_mask_author'])
		$mask_author=1;
	else $mask_author=0;
    update_option('noexternallinks_gotopath',$gotopath);
    update_option('noexternallinks_lang',$lang);
    update_option('noexternallinks_mask_mine',$mask_mine);
    update_option('noexternallinks_mask_comment',$mask_comment);
    update_option('noexternallinks_mask_author',$mask_author);
}

//Add to admin menu
#function wp_noextrenallinks_add_new_menu() {
#	add_options_page('WP NoExternalLinks Config', 'WP NoExternalLinks', 9, __FILE__, #'wp_noextrenallinks_option_page');
#}


function wp_noextrenallinks_option_page()
{
	$lang=get_option('noexternallinks_lang');
	if(!$lang)$lang='eng';
	include('lang/lang.'.htmlspecialchars($lang).'.inc');
		
	#Init
	#die(get_option('noexternallinks_mask_mine').get_option('noexternallinks_mask_comment'));
	if(FALSE===$mask_mine=get_option('noexternallinks_mask_mine'))
		$mask_mine=1;
	if(FALSE===$mask_comment=get_option('noexternallinks_mask_comment'))
		$mask_comment=1;
	if(FALSE===$mask_author=get_option('noexternallinks_mask_author'))
		$mask_author=1;
?>
	<form method="post" action="<?php echo $location;?>">
		<?php wp_nonce_field('update-options'); ?>
		<div style="float:right;margin-right:2em;">
			<b>WP NoExternalLinks <?php echo WPNEL_VERSION;?></b><br>
			<a href="http://jehy.ru/wp-plugins.en.html" target="_blank"><?php echo WPNEL_PLUGIN_HOMEPAGE;?></a><br />
			<a href="http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/" target="_blank"><?php echo WPNEL_FEEDBACK;?></a>
		</div>
		<div class="form-table" style="width:70%; border:1px solid #666; padding:10px; background-color:#CECECE;">
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
			</div>
			<input type="checkbox" name="noexternallinks_mask_mine" value="1"<?php if($mask_mine==1) echo ' checked';?>><b><?php echo WPNEL_MASK_LINKS_IN_POSTS;?></b><br><br>
			<input type="checkbox" name="noexternallinks_mask_comment" value="1"<?php if($mask_comment==1) echo ' checked';?>><b><?php echo WPNEL_MASK_LINKS_IN_COMMENTS;?></b><br><br>
			<input type="checkbox" name="noexternallinks_mask_author" value="1"<?php if($mask_author==1) echo ' checked';?>><b><?php echo WPNEL_MASK_LINKS_IN_AUTHORS;?></b><br><br>
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
		add_filter('the_content','jehy_noextrenallinks');
	if($mask_comment)
	{
		add_filter('comment_text','jehy_noextrenallinks');
		add_filter('comment_text_rss','jehy_noextrenallinks');
		add_filter('comment_url','jehy_noextrenallinks');
	}
	if($mask_author)
	{
		add_filter('get_comment_author_url_link','jehy_noextrenallinks');
		add_filter('get_comment_author_link','jehy_noextrenallinks');
		add_filter('get_comment_author_url','jehy_noextrenallinks');
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
?>