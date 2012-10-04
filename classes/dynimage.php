<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/26/12 1:29 AM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

abstract class Dynimage {

	const RESIZE_FULL = 'full';
	const RESIZE_ASPECT = 'aspect';
	const RESIZE_STRETCH = 'stretch';

	protected static $config = array();

	public function __construct()
	{
		//echo "CONSTRUCTOR<br />";
	}

	public static function factory()
	{
		self::$config = Kohana::$config->load('website')->as_array();
	}

	public static function check_upload_folder()
	{
		if (empty(self::$config))
		{
			self::factory();
		}
		//self::$config = Kohana::$config->load('dynimage')->as_array();

		if ( ! is_dir($source_folder = self::$config['upload_folder']))
		{
			return false;
		}
		return $source_folder;
	}

	public static function get_file_full_path($relative_path)
	{
		if (!is_file($full_path = self::$config['upload_folder'] . $relative_path))
		{
			return false;
		}
		return $full_path;
	}
}
