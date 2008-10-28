<?php
#$lang=get_option('noexternallinks_lang');
#if(!$lang)
$lang='eng';
include('lang/lang.'.htmlspecialchars($lang).'.inc');
header('Content-type: text/html; charset="utf-8"',true);
$url=$_SERVER['QUERY_STRING'];
if($url)
{
	$url='http://'.urldecode($url);
	@header('Location: '.$url);
}
?>
<html>
	<head>
		<title><?php echo WPNEL_REDIRECTING;?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="robots" content="noindex,nofollow" />
		<?php if($url) echo '<meta http-equiv="refresh" content="0; url='.$url.';" />'; ?>
	</head>
	<body style="margin:0;">
	<div align="center" style="margin-top: 15em;">
<?php if($url)
{
	echo WPNEL_REDIRECT1.'<a href="'.$url.'">'.WPNEL_REDIRECT2.'</a>'.WPNEL_REDIRECT3.$url.WPNEL_REDIRECT4;
}
 else echo (WPNEL_NO_REDIRECT);?>
	</div>
	</body>
</html>
