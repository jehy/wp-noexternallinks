<?php
include 'lang.eng.inc';
header('Content-type: text/html; charset="utf-8"',true);
$url=$QUERY_STRING;
if($url)$url='http://'.$url;
if($url) @header('Location: '.$url);
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
		<?php echo WPNEL_REDIRECT1;?> <a href="<?php echo $url?>"><?php echo WPNEL_REDIRECT2;?></a><?php echo WPNEL_REDIRECT3.$url.WPNEL_REDIRECT4;?> 
	</div>
	</body>
</html>
