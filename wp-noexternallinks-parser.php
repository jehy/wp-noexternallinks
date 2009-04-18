<?php

if(strpos(getcwd(),'wp-content/plugins/wp-noexternallinks'))
  die('Error: Plugin "wp-noexternallinks" does not support standalone calls, damned hacker.');
function wp_noextrenallinks_parser($matches)
{
  global $wp_rewrite,$wp_noexternallinks_parser;
  if(!$wp_rewrite->using_permalinks())
    $sep='?'.$wp_noexternallinks_parser->LINK_SEP.'=';
  else
      $sep='/'.$wp_noexternallinks_parser->LINK_SEP.'/';
  if($wp_noexternallinks_parser->if_blank&&
  (stripos($matches[2] . '//' .$matches[3],$wp_noexternallinks_parser->exclude_links[0])===FALSE))#do not add blank to internal links
      $ifblank=' target="_blank"';
  if($wp_noexternallinks_parser->if_nofollow&&
  (stripos($matches[2] . '//' .$matches[3],$wp_noexternallinks_parser->exclude_links[0])===FALSE))#do not add nofollow to internal links
      $ifnofollow=' rel="nofollow"';

  #no masking for those urls (0 is the own blog/site url):

  for($i=0;$i<sizeof($wp_noexternallinks_parser->exclude_links);$i++)
      if($wp_noexternallinks_parser->exclude_links[$i])
        if(stripos($matches[2] . '//' .$matches[3],$wp_noexternallinks_parser->exclude_links[$i])===0)#if begins with
          return '<a'.$ifblank.' href="' . $matches[2] . '//' . $matches[3] . '" ' . $matches[1] . $matches[4] . '>' . $matches[5] . '</a>';

    $url=($matches[2] . '//' . $matches[3]);
  if(!$wp_noexternallinks_parser->disable_masking)
  {
    if(!$wp_rewrite->using_permalinks())
      $url=urlencode($url);
    $url=$wp_noexternallinks_parser->site.$sep.$url;
  }
  $link='<a'.$ifblank.$ifnofollow.' href="'.$url.'" '.$matches[1].$matches[4].'>'.$matches[5].'</a>';
  if($wp_noexternallinks_parser->put_noindex)
    $link='<noindex>'.$link.'</noindex>';
  return $link;
}


class wp_noexternallinks_parser extends wp_noexternallinks
{
var $exclude_links,$if_blank,$if_nofollow,$disable_masking,$put_noindex,$site,$LINK_SEP;

function wp_noexternallinks_parser()#constructor
{
  add_filter('template_redirect',array($this,'Redirect'),1);#modify template
  $this->set_filters();

  #init options
  $this->exclude_links=array();
  $this->site=get_option('home');
  if(!$this->site)
    $this->site=get_option('siteurl');
  $p=strpos($this->site,'/',7);
  if($p)
    $this->exclude_links[]=substr($this->site,0,$p);#site root is excluded

  $exclude=get_option('noexternallinks_exclude_links');
  $exclude=@explode("\n",$exclude);
  for($i=0;$i<sizeof($exclude);$i++)
    $this->exclude_links[]=trim($exclude[$i]);

  $this->if_blank=get_option('noexternallinks_add_blank');
  $this->if_nofollow=get_option('noexternallinks_add_nofollow');
  $this->put_noindex=get_option('noexternallinks_put_noindex');
  $this->disable_masking=get_option('noexternallinks_disable_mask_links');
  $this->LINK_SEP=get_option('noexternallinks_link_separator');
  if(!$this->LINK_SEP)
    $this->LINK_SEP='goto';}
function Redirect()
{
  global $_REQUEST;
  $goto='';
  $p=strpos($_SERVER['REQUEST_URI'],'/'.$this->LINK_SEP.'/');
  if($_REQUEST[$this->LINK_SEP])
    $goto=$_REQUEST[$this->LINK_SEP];
  elseif($p!==FALSE)
    $goto=substr($_SERVER['REQUEST_URI'],$p+strlen($this->LINK_SEP)+2);
  else
  {
    $url=$_SERVER['REQUEST_URI'];
    $url=explode('/',$url);
    if($url[sizeof($url)-2]==$this->LINK_SEP)
      $goto=$url[sizeof($url)-1];
  }
  if($goto)
    $this->redirect2($goto);
}

function redirect2($url)
{  global $wp_rewrite;
  $this->init_lang();
  if(!$wp_rewrite->using_permalinks())
    $url=urldecode($url);
  header('Content-type: text/html; charset="utf-8"',true);
  if($url)
    @header('Location: '.$url);
?>
<html><head><title><?php echo WPNEL_REDIRECTING;?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="robots" content="noindex,nofollow" />
<?php if($url) echo '<meta http-equiv="refresh" content="0; url='.$url.';" />'; ?>
</head><body style="margin:0;"><div align="center" style="margin-top: 15em;">
<?php
if($url)
  echo WPNEL_REDIRECT1.'<a href="'.$url.'">'.WPNEL_REDIRECT2.'</a>'.WPNEL_REDIRECT3.$url.WPNEL_REDIRECT4;
else
  echo (WPNEL_NO_REDIRECT);?>
</div></body></html><?php die();
}


function filter($content)
{
  global $post,$wp_rewrite;
  $mask = get_post_meta($post->ID, 'wp_noextrenallinks_mask_links', true);
  if($mask==2)
      return $content;
  $pattern = '/<a (.*?)href=[\"\'](.*?)\/\/(.*?)[\"\'](.*?)>(.*?)<\/a>/i';
  $content = preg_replace_callback($pattern,'wp_noextrenallinks_parser',$content);
  return $content;

}


function set_filters()
{
  if(FALSE===$this->mask_mine=get_option('noexternallinks_mask_mine'))
    $this->mask_mine=1;
  if(FALSE===$this->mask_comment=get_option('noexternallinks_mask_comment'))
    $this->mask_comment=1;
  if(FALSE===$this->mask_author=get_option('noexternallinks_mask_author'))
    $this->mask_author=1;

  if($this->mask_mine)
    add_filter('the_content',array($this,'filter'),99);
  if($this->mask_comment)
  {
    add_filter('comment_text',array($this,'filter'),99);
    add_filter('comment_text_rss',array($this,'filter'),99);
    add_filter('comment_url',array($this,'filter'),99);
  }
  if($this->mask_author)
  {
    add_filter('get_comment_author_url_link',array($this,'filter'),99);
    add_filter('get_comment_author_link',array($this,'filter'),99);
    add_filter('get_comment_author_url',array($this,'filter'),99);
	}
}
}


$wp_noexternallinks_parser=new wp_noexternallinks_parser();
?>