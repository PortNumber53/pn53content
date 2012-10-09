<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 10/5/12 11:03 PM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

class Controller_Base_Gallery extends Controller_Base_Website
{

	public function action_browse()
	{
		$gallery = new Model_Image();

		$image_list = $gallery->get_posts();

		//Get tags
		foreach ($image_list as &$item)
		{
			$item['tags'] = empty($item['tags']) ? array() : $item['tags'];
		}

		View::set_global('image_list', $image_list);
		View::set_global('main', 'gallery/browse');
	}

}