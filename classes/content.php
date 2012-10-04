<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/15/12 5:10 PM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

class Content
{
	const TYPE_UNKNOWN = 'unknown';
	const TYPE_HOMEPAGE = 'homepage';
	const TYPE_ARTICLE = 'article';
	const TYPE_DOCUMENT = 'document';
	const TYPE_IMAGE = 'image';

	static public function Remove_format($input)
	{
		if (substr($input, -5) == '.html')
		{
			return substr($input, 0, -5);
		}
		else
		{
			return $input;
		}
	}

	public static function sections_to_json(&$post)
	{
		//$section_title = array();
		//$section_content = array();
		//$section_picture = array();
		//$data = json_decode($post['sections'], true);

		//for ($counter = 0; $counter < count($data); $counter++)
		//{
		//$section_title[] = $data[$counter]['title'];
		//$section_content[] = $data[$counter]['content'];
//			$section_picture[] = $data[$counter]['picture'];
		//}
		//$post['section_title'] = $section_title;
		//$post['section_content'] = $section_content;
		//$post['section_picture'] = $section_picture;
		//unset($post['content']);

		//echo "<pre>";print_r($post);echo"</pre>";die;
		//$post['sections'] = json_decode($post['sections'], true);
	}




	static private $_current_time = null;
	static public function current_time()
	{
		if (empty(self::$_current_time))
		{
			echo "setup date/time<br>";
			self::$_current_time = date('Y-m-d H:i:s');
		}
		return self::$_current_time;
	}

}
