<?php
$url=$QUERY_STRING;
if($url)$url='http://'.$url;
if($url) @header("Location: ".$url."");
?>
<html>
	<head>
		<title>Redirecting...</title>
		<meta name="robots" content="noindex,nofollow" />
		<?php if($url) echo '<meta http-equiv="refresh" content="0; url='.$url.';" />'; ?>
	</head>
	<body style="margin:0;">
		You were going to the redirect link, but something did not work properly.<br>Please, click <a href="<?php echo $url?>">HERE</a> to go to <?php echo $url?> manually.
	</body>
</html>
