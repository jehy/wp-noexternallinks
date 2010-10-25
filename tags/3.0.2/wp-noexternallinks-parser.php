<?php
if(!defined('DB_NAME'))
  die('Error: Plugin "wp-noexternallinks" does not support standalone calls, damned hacker.');
function wp_noextrenallinks_parser($matches)
{
  global $wp_rewrite,$wp_noexternallinks_parser;
  if(!$wp_rewrite->using_permalinks())
    $sep='?'.$wp_noexternallinks_parser->options['LINK_SEP'].'=';
  else
      $sep='/'.$wp_noexternallinks_parser->options['LINK_SEP'].'/';
  if($wp_noexternallinks_parser->options['add_blank']&&
  (stripos($matches[2] . '//' .$matches[3],$wp_noexternallinks_parser->options['exclude_links_'][0])===FALSE))#do not add blank to internal links
      $ifblank=' target="_blank"';
  if($wp_noexternallinks_parser->options['add_nofollow']&&
  (stripos($matches[2] . '//' .$matches[3],$wp_noexternallinks_parser->options['exclude_links_'][0])===FALSE))#do not add nofollow to internal links
      $ifnofollow=' rel="nofollow"';

  #no masking for those urls (0 is the own blog/site url):

  for($i=0;$i<sizeof($wp_noexternallinks_parser->options['exclude_links_']);$i++)
      if($wp_noexternallinks_parser->options['exclude_links_'][$i])
        if(stripos($matches[2] . '//' .$matches[3],$wp_noexternallinks_parser->options['exclude_links_'][$i])===0)#if begins with
          return '<a'.$ifblank.' href="' . $matches[2] . '//' . $matches[3] . '" ' . $matches[1] . $matches[4] . '>' . $matches[5] . '</a>';

    $url=($matches[2] . '//' . $matches[3]);
  if(!$wp_noexternallinks_parser->options['disable_mask_links'])
  {
    if(!$wp_rewrite->using_permalinks())
      $url=urlencode($url);
    $url=$wp_noexternallinks_parser->options['site'].$sep.$url;
  }
  $link='<a'.$ifblank.$ifnofollow.' href="'.$url.'" '.$matches[1].$matches[4].'>'.$matches[5].'</a>';
  if($wp_noexternallinks_parser->options['put_noindex'])
    $link='<noindex>'.$link.'</noindex>';
  return $link;
}


class wp_noexternallinks_parser extends wp_noexternallinks
{

function wp_noexternallinks_parser()#constructor
{  $this->load_options();  $this->set_filters();  add_filter('template_redirect',array($this,'Redirect'),1);#modify template}
function Redirect()
{
  $goto='';
  $p=strpos($_SERVER['REQUEST_URI'],'/'.$this->options['LINK_SEP'].'/');
  if($_REQUEST[$this->options['LINK_SEP']])
    $goto=$_REQUEST[$this->options['LINK_SEP']];
  elseif($p!==FALSE)
    $goto=substr($_SERVER['REQUEST_URI'],$p+strlen($this->options['LINK_SEP'])+2);
  else
  {
    $url=$_SERVER['REQUEST_URI'];
    $url=explode('/',$url);
    if($url[sizeof($url)-2]==$this->options['LINK_SEP'])
      $goto=$url[sizeof($url)-1];
  }
  if(!strpos($goto,'://'))
  	  $goto=str_replace(':/','://',$goto);
  if($goto)
    $this->redirect2($goto);
}

function redirect2($url)
{  global $wp_rewrite,$wpdb;
  
  if($this->options['stats'])
  {
  	$sql='INSERT INTO '.$wpdb->prefix.'links_stats VALUES("","'.addslashes($url).'",NOW())';
  	@mysql_query($sql);
  	echo mysql_error();
  	if(mysql_errno())
  	{
  		echo'<font color="red">'.__('Failed to save statistic data. Trying to create table.').'</font>';
  		$sql2='CREATE TABLE '.$wpdb->prefix.'links_stats(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,`url` VARCHAR(255), `date` DATETIME, PRIMARY KEY (`id`))';
   		@mysql_query($sql2);
  	echo mysql_error().'<br>'.$sql2;
   		if(mysql_errno())
   			echo '<br>'.__('Failed to create table. Please, check mysql permissions.','wpnoexternallinks');
   		else
   		{
   			echo '<br>'.__('Table created.','wpnoexternallinks');
   			@mysql_query($sql);
   		}
  	}
  
  }
  
  
  $this->init_lang();
  if(!$wp_rewrite->using_permalinks())
    $url=urldecode($url);
  header('Content-type: text/html; charset="utf-8"',true);
  if(!$this->options['no302']&&$url)
    @header('Location: '.$url);
?>
<html><head><title><?php _e('Redirecting...','wpnoexternallinks');?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow" />
<?php if($url) echo '<meta http-equiv="refresh" content="';
if($this->options['redtime'])
	echo $this->options['redtime'];
else echo '0';
echo'; url='.$url.'" />'; ?>
</head><body style="margin:0;"><div align="center" style="margin-top: 15em;">
<?php
if($this->options['redtxt']&&$url)
	echo str_replace('LINKURL',$url,$this->options['redtxt']);
elseif($url)
  echo __('You were going to the redirect link, but something did not work properly.<br>Please, click ','wpnoexternallinks').'<a href="'.$url.'">'.__('HERE ','wpnoexternallinks').'</a>'.__(' to go to ','wpnoexternallinks').$url.__(' manually. ','wpnoexternallinks');
else
  _e('Sorry, no url redirect specified. Can`t complete request.','wpnoexternallinks');?>
</div></body></html><?php die();
}


function filter($content)
{
  if($this->options['noforauth']&&is_user_logged_in())
    return $content;
  $pattern = '/<a (.*?)href=[\"\'](.*?)\/\/(.*?)[\"\'](.*?)>(.*?)<\/a>/i';
  $content = preg_replace_callback($pattern,'wp_noextrenallinks_parser',$content);
  return $content;
}

function chk_post($content)
{
  global $post;
  $mask = get_post_meta($post->ID, 'wp_noextrenallinks_mask_links', true);
  if($mask==2)//nomask
  	return $content;
  else
  	return $this->filter($content);
}

function fullmask_begin()
{
	ob_start();
}
function fullmask_end()
{
  $text=ob_get_contents();
  ob_end_clean();
  if(!$text)
  	  echo '<font color="red">'.__('Can not use output buffer. Please, disable full masking in WP_NoExternalLinks and use other filters.','wpnoexternallinks').'</font>';
  else
  {
    echo $this->filter($text);
  }
  echo'<!--WP_NoExternalLinks finished-->';
}

function set_filters()
{
  if($this->options['fullmask'])
  {
  	  add_action('init',array($this,'fullmask_begin'),1);
  	  add_action('wp_print_footer_scripts',array($this,'fullmask_end'),99);
  }
  else
  {
    if($this->options['mask_mine'])
    {
      add_filter('the_content',array($this,'chk_post'),99);
      add_filter('the_excerpt',array($this,'chk_post'),99);
    }
    if($this->options['mask_comment'])
    {
      add_filter('comment_text',array($this,'filter'),99);
      add_filter('comment_text_rss',array($this,'filter'),99);
      add_filter('comment_url',array($this,'filter'),99);
    }
    if($this->options['mask_author'])
    {
      add_filter('get_comment_author_url_link',array($this,'filter'),99);
      add_filter('get_comment_author_link',array($this,'filter'),99);
      add_filter('get_comment_author_url',array($this,'filter'),99);
  	}
  }
}
}


$wp_noexternallinks_parser=new wp_noexternallinks_parser();
?>