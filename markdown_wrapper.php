<?php

/**
 * Requires Markdown Extra 1.2.5
 * @see  http://michelf.com/projects/php-markdown/
 */
require "markdown.php";

/**
 * Markdown wrapper class
 */
class MarkdownWrapper {

	private $filename;
	private $meta = array();

	public function __construct($fileName) {
		$this->filename = $fileName;
		$this->meta = $this->getMeta();
	}

	public function getUrl() {
		return $this->meta['url'];
	}

	public function getTime() {
		return $this->meta['time'];
	}

	private function getPreviewText() {
		$file_content = file_get_contents($this->filename);
		$pos = strpos($file_content, "\n\n", min(100, strlen($file_content)-1));
		return substr($file_content, 0, $pos);
	}

	private function getText() {
		return file_get_contents($this->filename);
	}

	private function getMeta() {
		$date = array();
		$meta = array();
		if (preg_match('/([0-9]{4})([0-9]{2})([0-9]{2})\-([0-9]{2})([0-9]{2})\-(.*)\.([A-z]+)/', $this->filename, $date)) {
			$meta['time'] = strtotime($date[3].'.'.$date[2].'.'.$date[1].' '.$date[4].':'.$date[5]);
		}
		$meta['url'] = $date[6];
		return $meta;
	}

	public function html($preview) {
		$md = preg_replace_callback("/(\<\/?h)([0-9])(>)/", function($m) {
			return $m[1].++$m[2].$m[3];
		}, $preview ? Markdown($this->getPreviewText()) : Markdown($this->getText()));
		
		preg_match('/<h2>(.*)<\/h2>/', $md, $matches);
		if (count($matches) > 1) {
			$this->meta['name'] = $matches[1];
		} else {
			$this->meta['name'] = '';
		}
		return $md;
	}

	public function renderPost($preview=false) {
		$my_html = $this->html($preview);
		$post = '<div class="post"><span class="date">'.date('d.m.Y', $this->getTime()).'</span><div>';
		$post .= $my_html;
		$post .= '<div class="readmore">';
		if ($preview) {
			$post .= '<a href="'.Config::baseUrl($this->getUrl()).'">read more..</a>';
		}
		$post .= '&nbsp;</div>';
		$post .= '<div class="cleaner"><!-- --></div>';
		$post .= '</div></div>';
		return $post;
	}
}