<?php

include 'config.php';
include_once "markdown_wrapper.php";

error_reporting(E_ALL);
ini_set('display_errors',1);

/**
 * Loads all files in content folder and sorts it by name
 * 
 * @todo Cache folder content into file?
 */
function loadContents() {
	$contents = array();
	$dirhandle = opendir(Config::$contentDir);
	while ($file = readdir($dirhandle)) {
		if (substr($file, 0, 1) == '.') {
			continue;
		}
		$contents[] = Config::$contentDir.'/'.$file;
	}
	rsort($contents);
	return $contents;
}

/**
 * Plugins loader
 */
function plugins() {
	$dir = opendir(Config::$pluginsDir);
	$first = true;
	while ($file = readdir($dir)) {
		if (substr($file, 0, 1) == '.' || substr(strtolower($file), -3) != 'php') continue;
		if (!$first) {
			echo '<hr />';
		}
		include('plugins/'.$file);
		$first = false;
	}
}

/**
 * Main flow controller
 * 
 * @todo Add pagination of main page
 */
function content() {
	$contents = loadContents();
	if (isset($_GET['param'])) {
		$found = false;
		foreach ($contents as $fileName) {
			if (preg_match('/'.$_GET['param'].'/', $fileName)) {
				$md = new MarkdownWrapper($fileName);
				echo $md->renderPost(false);
				$found = true;
				break;
			}
		}
		if (!$found) {
			$md = new MarkdownWrapper('resources/404.md');
			echo $md->renderPost(false);
		}
	} else {
		foreach ($contents as $fileName) {
			$md = new MarkdownWrapper($fileName);
			echo $md->renderPost(true);
		}
	}
}