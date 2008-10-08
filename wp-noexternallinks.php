<?php
include ('lang.eng.inc');
DEFINE(WPNEL_VERSION,'0.02');
/*
Plugin Name: WP-NoExternalLinks
Plugin URI: http://jehy.ru/wp-plugins.en.html
Description: This plugin will allow you to mask all external links to internal. Your own posts, comments pages, authors pages... To set up, visit <a href="options-general.php?page=wp-noexternallinks/wp-noexternallinks.php">configuration panel</a>. 
Version: 0.02
Author: Jehy
Author URI: http://jehy.ru/index.en.html
Update Server: http://jehy.ru/wp-plugins.en.html
Min WP Version: 2.5
Max WP Version: 2.6.1
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
if($HTTP_POST_VARS['action']=='wp_noextrenallinks_update'||$_POST['action']=='wp_noextrenallinks_update'||$action=='wp_noextrenallinks_update')
	wp_noextrenallinks_update();


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
	return $content;
}


function wp_noextrenallinks_update()
{
global $noexternallinks_gotopath,$HTTP_POST_VARS,$_POST;
	#############################
	$gotopath='';
	if($noexternallinks_gotopath)$gotopath=$noexternallinks_gotopath;
	elseif($HTTP_POST_VARS['noexternallinks_gotopath'])$gotopath=$HTTP_POST_VARS['noexternallinks_gotopath'];
	elseif($_POST['noexternallinks_gotopath'])$gotopath=$_POST['noexternallinks_gotopath'];
	
	############################
	if($noexternallinks_mask_mine||$HTTP_POST_VARS['noexternallinks_mask_mine']||$_POST['noexternallinks_mask_mine'])$mask_mine=1;
	else $mask_mine=0;
	#########################
	if($noexternallinks_mask_comment||$HTTP_POST_VARS['noexternallinks_mask_comment']||$_POST['noexternallinks_mask_comment'])$mask_comment=1;
	else $mask_comment=0;
	#########################
	if($noexternallinks_mask_author||$HTTP_POST_VARS['noexternallinks_mask_author']||$_POST['noexternallinks_mask_author'])$mask_author=1;
	else $mask_author=0;
	########################
	#echo $mask_mine;die;
    update_option("noexternallinks_gotopath",$gotopath);
    update_option("noexternallinks_mask_mine",$mask_mine);
    update_option("noexternallinks_mask_comment",$mask_comment);
    update_option("noexternallinks_mask_author",$mask_author);
}

//Add to admin menu
function wp_noextrenallinks_add_new_menu() {
	add_options_page('WP NoExternalLinks Config', 'WP NoExternalLinks', 9, __FILE__, 'wp_noextrenallinks_option_page');
}


function wp_noextrenallinks_option_page()
{
	#Init
	#die(get_option('noexternallinks_mask_mine').get_option('noexternallinks_mask_comment'));
	if(FALSE===$mask_mine=get_option('noexternallinks_mask_mine'))
		$mask_mine=1;
	if(FALSE===$mask_comment=get_option('noexternallinks_mask_comment'))
		$mask_comment=1;
	if(FALSE===$mask_author=get_option('noexternallinks_mask_author'))
		$mask_author=1;
?><div style="margin-left: 1em;">
	<h2>WP NoExternalLinks <?php echo WPNEL_CONFIGURATION;?></h2><br />
	<form name="form1" method="post" action="<?php echo $location ?>">
		<?php wp_nonce_field('update-options'); ?>
		<input name="action" type="hidden" value="wp_noextrenallinks_update">

		<div style="float:right; text-align:left;margin-right:1em;">
			<b>WP NoExternalLinks <?php echo WPNEL_VERSION;?></b><br>
			<a href="http://jehy.ru/wp-plugins.en.html" target="_blank"><?php echo WPNEL_PLUGIN_HOMEPAGE;?></a><br />
			<a href="http://jehy.ru/articles/2008/10/05/wordpress-plugin-no-external-links/" target="_blank"><?php echo WPNEL_FEEDBACK;?></a>
		</div>
		<div style="width:70%; border:1px solid #666; padding:10px; background-color:#CECECE;">
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
		<div align="right">
		<input type="submit" style="background-color: #CACACA;" name="Submit" value="<?php echo WPNEL_SAVE_CHANGES;?>"></div></div>
	</form><p style="font-size:smaller;"><?php echo WPNEL_HINT;?></p></div>
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
add_action('admin_menu', 'wp_noextrenallinks_add_new_menu'); 

?>