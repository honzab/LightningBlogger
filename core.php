<?php

include_once "markdown.php";

$contents = array();
$contentFolder = 'content';

$dirhandle = opendir($contentFolder);
while ($file = readdir($dirhandle)) {
	if (substr($file, 0, 1) == '.') {
		continue;
	}
	$contents[] = $file;
}
usort($contents, 'compareDateFileNames');

function compareDateFileNames($a, $b) {
	$less = 1; $more = -1;
	$a_date = substr($a, 0, 8);
	$b_date = substr($b, 0, 8);
	if ($a_date < $b_date) {
		return $less;
	} else if ($a_date > $b_date) {
		return $more;
	}
	$a_time = substr($a, 9, 4);
	$b_time = substr($b, 9, 4);
	if ($a_time < $b_time) {
		return $less;
	} else if ($a_time > $b_time) {
		return $more;
	}
}

function renderPost($fileName, $preview=false) {
	$file_content = file_get_contents($fileName);

	if ($preview) {
		$pos = strpos($file_content, "\n\n", min(100, strlen($file_content)-1));
		
		if ($pos) {
			$file_content = substr($file_content, 0, $pos);
		}
	}

	$my_html = Markdown($file_content);

	$date = array();
	$dateHtml = $name = '';
	if (preg_match('/([0-9]{4})([0-9]{2})([0-9]{2})\-([0-9]{2})([0-9]{2})\-(.*)\.([A-z]+)/', $fileName, $date)) {
		$time = strtotime($date[3].'.'.$date[2].'.'.$date[1].' '.$date[4].':'.$date[5]);
		if ($time) {
			$dateHtml = '<span class="date">'.date('d.m.Y, H:i', $time).'</span>';
		}
		$name = $date[6];
	}

	echo '<div class="post">'.$dateHtml.'<div>';
	echo $my_html;
	echo '<div class="readmore">';
	if ($preview && $pos) {
		echo '<a href="'.baseurl($name).'">read more..</a>';
	}
	echo '&nbsp;</div>';
	echo '<div class="cleaner"><!-- --></div>';
	echo '</div></div>';
	unset($my_html);
}

if (isset($_GET['param'])) {
	$found = false;
	foreach ($contents as $fileName) {
		if (preg_match('/'.$_GET['param'].'/', $fileName)) {
			renderPost($contentFolder.'/'.$fileName, false);
			$found = true;
			break;
		}
	}
	if (!$found) {
		renderPost('resources/404.md');
	}
} else {
	foreach ($contents as $fileName) {
		renderPost($contentFolder.'/'.$fileName, true);
	}
}