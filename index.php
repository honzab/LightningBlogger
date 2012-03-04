<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$baseUrl = 'http://test.brucek.cz';

function baseurl($str='') {
	global $baseUrl;
	return $baseUrl.'/'.$str;
}
?>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<script type="text/javascript" src="resources/sh_main.min.js"></script>
		<script type="text/javascript" src="resources/sh_php.js"></script>
		<link type="text/css" rel="stylesheet" href="resources/style.css" />
		<link type="text/css" rel="stylesheet" href="resources/sh_typical.min.css" />
		<title>Testing page</title>
	</head>

	<body onload="sh_highlightDocument('resources/', '.js');">
		<h1><a href="<?php echo baseurl(); ?>">honza.brucek.cz</a></h1>
		<hr />
		<div id="content">
			<?php include('core.php'); ?>
		</div>
		<div id="plugins">
			<?php
				$dir = opendir('plugins');
				$first = true;
				while ($file = readdir($dir)) {
					if (substr($file, 0, 1) == '.' || substr(strtolower($file), -3) != 'php') continue;
					if (!$first) {
						echo '<hr />';
					}
					include('plugins/'.$file);
					$first = false;
				}
			?>
		</div>

		<script type="text/javascript">
		  WebFontConfig = {
		    google: { families: [ 'Fugaz+One::latin', 'Exo::latin,latin-ext' ] }
		  };
		  (function() {
		    var wf = document.createElement('script');
		    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
		      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
		    wf.type = 'text/javascript';
		    wf.async = 'true';
		    var s = document.getElementsByTagName('script')[0];
		    s.parentNode.insertBefore(wf, s);
		  })(); </script>

	</body>
</html>