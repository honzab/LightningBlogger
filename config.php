<?php

/**
 * Config container class
 */
class Config {

	/**
	 * BaseUrl without trailing slash
	 * @var string
	 */
	public static $baseUrl = '/brucek.cz/h2';

	/**
	 * Website title, used in h1 and <title>
	 * @var string
	 */
	public static $title = 'Markdown Blogger';
	
	/**
	 * Name of the content directory
	 * @var string
	 */
	public static $contentDir = 'content';

	/**
	 * Name of the plugin directory
	 * @var string
	 */
	public static $pluginsDir = 'plugins';

	/**
	 * BaseUrl helper getter
	 * 
	 * @param  string $url Target url without base
	 * @return string
	 */
	public static function baseUrl($url='') {
		return self::$baseUrl.'/'.$url;
	}
}