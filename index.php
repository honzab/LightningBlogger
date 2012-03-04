<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include 'core.php'; ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<script type="text/javascript" src="<?php echo Config::baseUrl('resources/sh_main.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo Config::baseUrl('resources/sh_php.js'); ?>"></script>
		<link type="text/css" rel="stylesheet" href="<?php echo Config::baseUrl('resources/style.css'); ?>" />
		<link type="text/css" rel="stylesheet" href="<?php echo Config::baseUrl('resources/sh_typical.min.css'); ?>" />
		<title><?php echo Config::$title; ?></title>
	</head>

	<body onload="sh_highlightDocument('resources/', '.js');">
		<h1><a href="<?php echo Config::baseUrl(); ?>"><?php echo Config::$title; ?></a></h1>
		<hr />
		<div id="content">
			<?php content(); ?>
		</div>
		<div id="plugins">
			<?php plugins(); ?>
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