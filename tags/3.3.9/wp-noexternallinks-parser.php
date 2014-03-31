<?php
if(!defined('DB_NAME'))
  die('Error: Plugin "wp-noexternallinks" does not support standalone calls, damned hacker.');


class wp_noexternallinks_parser extends wp_noexternallinks
{

function debug_info($info,$return=0)
{
  if($this->options['debug'])
  {
   	$t="\n<!--wpnoexternallinks debug:\n".$info."\n-->";
     if($return)
       return $t;
     else
       echo $t;
  }
}

function wp_noextrenallinks_parser($matches)
{
  global $wp_rewrite,$wpdb;
  #checking for entry in exclusion list
  $path=$matches[3];
  if($p=strpos($path,'/'))
    $path=substr($path,0,$p);
  $check_allowed=$matches[2] . '//' .$path;
  $this->debug_info('Parser called. Parsing argument '.var_export($matches,1)."\nMade url ".$check_allowed);
  foreach($this->options['exclude_links_'] as $val)
    if(stripos($val,$check_allowed)===0)
      return $matches[0];
  $this->debug_info('Not in exclusion list, masking...');
  
  #checking for different options, setting other
  if(!$wp_rewrite->using_permalinks())
    $sep='?'.$this->options['LINK_SEP'].'=';
  else
    $sep='/'.$this->options['LINK_SEP'].'/';
  if($this->options['add_blank'])
      $ifblank=' target="_blank"';
  if($this->options['add_nofollow'])
      $ifnofollow=' rel="nofollow"';

    $url=($matches[2] . '//' . $matches[3]);
  
  /*masking url with numbers*/
  if(!$this->options['disable_mask_links'])
  {
    if($this->options['base64'])
    {
      $url=base64_encode($url);
    }
    elseif($this->options['maskurl'])
    {
  	  $sql='select id from '.$wpdb->prefix.'masklinks where url="'.addslashes($url).'" limit 1';
  	  $result=@mysql_query($sql);
    	if(!$result && @mysql_errno()==1146)//no table found
    	{
    	  /*create masklink table*/
    	  echo'<font color="red">'.__('Failed to make masked link. Trying to create table.').'</font>';
    	  $sql2='CREATE TABLE '.$wpdb->prefix.'masklinks(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,`url` VARCHAR(255),  PRIMARY KEY (`id`))';
     		@mysql_query($sql2);
     		if(@mysql_errno())
         {
     			echo '<br>'.__('Failed to create table. Please, check mysql permissions.','wpnoexternallinks');
            $this->debug_info(__('Failed SQL: ').'<br>'.$sql2.'<br>'.__('Error was:').'<br>'.mysql_error());
         }
     		else
     		{
     		  echo '<br>'.__('Table created.','wpnoexternallinks');
     		  $result=@mysql_query($sql);
     		}
    	}
    	if(!@mysql_num_rows($result))
    	{
    		$sql='INSERT INTO '.$wpdb->prefix.'masklinks VALUES("","'.addslashes($url).'")';
        @mysql_query($sql);
    		$row=array();
    		$row[0]=@mysql_insert_id();
    	}
    	else
    		$row=@mysql_fetch_row($result);
      if($row[0])
    	  $url=$row[0];
      
    }
    
    if(!$wp_rewrite->using_permalinks())
      $url=urlencode($url);
    //add "/" to site url- some servers dont't work with urls like xxx.ru?goto, but with xxx.ru/?goto
    if($this->options['site'][strlen($this->options['site'])-1]!='/')
      $this->options['site'].='/';
    if($sep[0]=='/')#to not create double backslashes
      $sep=substr($sep,1);
    $url=$this->options['site'].$sep.$url;
  }
  if($this->options['remove_links'])
    return '<span class="waslinkname">'.$matches[5].'</span>';
  if($this->options['link2text'])
    return '<span class="waslinkname">'.$matches[5].'</span> ^(<span class="waslinkurl">'.$url.')</span>';
  $link='<a'.$ifblank.$ifnofollow.' href="'.$url.'" '.$matches[1].$matches[4].'>'.$matches[5].'</a>';
  if($this->options['put_noindex'])
    $link='<noindex>'.$link.'</noindex>';
  return $link;
}


function wp_noexternallinks_parser()
{  $this->load_options();  $this->set_filters();  add_filter('template_redirect',array($this,'Redirect'),1);  $this->debug_info("Options: \n".var_export($this->options, true));}
function Redirect()
{
  $goto='';
  $p=strpos($_SERVER['REQUEST_URI'],'/'.$this->options['LINK_SEP'].'/');
  if(@$_REQUEST[$this->options['LINK_SEP']])
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
{  global $wp_rewrite,$wpdb,$hyper_cache_stop;
  if($this->options['base64'])
  {
    $url=base64_decode($url);
  }
  elseif($this->options['maskurl'])
  {
    $sql='select url from '.$wpdb->prefix.'masklinks where id="'.addslashes($url).'" limit 1';
    $result=@mysql_query($sql);
    if(@mysql_num_rows($result))
    {
      $row=@mysql_fetch_row($result);
      if($row[0])
        $url=$row[0];
    }
  }
  
  if($this->options['stats'])
  {
    
    //disable Hyper Cache plugin (http://www.satollo.net/plugins/hyper-cache) from caching this page (otherwise, statistics won't work):
    $hyper_cache_stop = true;
    
  	$sql='INSERT INTO '.$wpdb->prefix.'links_stats VALUES("","'.addslashes($url).'",NOW())';
  	@mysql_query($sql);
  	if(mysql_errno())
  	{
      $this->debug_info(__('Failed SQL: ').'<br>'.$sql.'<br>'.__('Error was:').'<br>'.mysql_error());
  		echo'<font color="red">'.__('Failed to save statistic data. Trying to create table.').'</font>';
  		$sql2='CREATE TABLE '.$wpdb->prefix.'links_stats(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,`url` VARCHAR(255), `date` DATETIME, PRIMARY KEY (`id`))';
   		@mysql_query($sql2);
   		if(mysql_errno())
         {
   			echo '<br>'.__('Failed to create table. Please, check mysql permissions.','wpnoexternallinks');
            $this->debug_info(__('Failed SQL: ').'<br>'.$sql2.'<br>'.__('Error was:').'<br>'.mysql_error());
         }
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
  $url=str_ireplace('&#038;','&',$url);
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
  $this->debug_info("Processing text (htmlspecialchars on it to stay like comment): \n".htmlspecialchars($content));
  if(function_exists('is_feed') && is_feed())
  {
	 $this->debug_info('It is feed, no processing');
    return $content;
  }
  $pattern = '/<a (.*?)href=[\"\'](.*?)\/\/(.*?)[\"\'](.*?)>(.*?)<\/a>/i';
  $content = preg_replace_callback($pattern,array($this,'wp_noextrenallinks_parser'),$content);
  $this->debug_info("Filter returned(htmlspecialchars on it to stay like comment): \n".htmlspecialchars($content));
  return $content;
}

function chk_post($content)
{
  global $post;
  $this->debug_info("Checking post for meta.");
  $mask = get_post_meta($post->ID, 'wp_noextrenallinks_mask_links', true);
  if($mask==2 )/*nomask*/
  {
   $this->debug_info("Meta nomask. No masking will be applied");
  	return $content;
  }
  else
  {
  	$this->debug_info("Filter will be applied");
  	return $this->filter($content);
  }
}

function fullmask_begin()
{
	$a=ob_start(array($this,'fullmask_end'));
  if(!$a)
  	  echo '<font color="red">'.__('Can not get output buffer!').__('WP_NoExternalLinks Can`t use output buffer. Please, disable full masking and use other filters.','wpnoexternallinks').'</font>';
	if($this->options['debug'])
  	  $this->debug_info("Starting full mask.");
}
function fullmask_end($text)
{
  global $post;
  $r='';
  $r.=$this->debug_info("Full mask finished. Applying filter",1);
  if(!$text)
  	  $r.= '<font color="red">'.__('Output buffer empty!').__('WP_NoExternalLinks Can`t use output buffer. Please, disable full masking and use other filters.','wpnoexternallinks',1).'</font>';
  else
  {
  	 $r.=$this->debug_info("Processing text (htmlspecialchars on it to stay like comment): \n".htmlspecialchars($text),1);
    if(is_object($post) && (get_post_meta($post->ID, 'wp_noextrenallinks_mask_links', true)==2))
      $r.= $text;
    elseif(function_exists('is_feed') && is_feed())
      $r.= $text;
    else
      $r.= $this->filter($text);
  }
  $r.=$this->debug_info("Full mask output finished",1);
  return $r;
}

function set_filters()
{
  if($this->options['noforauth'])
  {
    $this->debug_info("Masking is enabled only for non logged in users");
    if(!function_exists('is_user_logged_in'))
    {
      $this->debug_info("'is_user_logged_in' function not found! Trying to include its file");
      $path=constant('ABSPATH').'wp-includes/pluggable.php';
      if(file_exists($path))  
        require_once($path);
      else
        $this->debug_info("pluggable file not found! Not gonna include.");
    }
    if(is_user_logged_in())
    {
      $this->debug_info("User is authorised, we're not doing anything");
      return;
    }
  }
  if($this->options['fullmask'])
  {
      $this->debug_info("Setting fullmask filters");
      $this->fullmask_begin();
  }
  else
  {
    $this->debug_info("Setting per element filters");
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