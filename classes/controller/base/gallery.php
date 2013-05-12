<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 10/5/12 11:03 PM
 * Package: Package_Name
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