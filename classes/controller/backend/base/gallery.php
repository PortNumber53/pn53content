<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 9/21/12 11:57 PM
 * Package: Package_Name
 */

class Controller_Backend_Base_Gallery extends Controller_Backend_Base_Backend {

	public function action_upload()
	{
		View::set_global('main', 'gallery/backend/dropbox');
	}


	public function action_dashboard()
	{
		$image_list = array();
		$gallery = new Model_Image();

		$image_list = $gallery->get_posts();
		//$image_list = array_chunk($image_list, 15, TRUE);
		//echo"<pre>";var_dump($image_list);die();

		//Get tags
		foreach ($image_list as &$item)
		{
			$item['tags'] = empty($item['tags']) ? array() : $item['tags'];
		}

		View::set_global('image_list', $image_list);
		View::set_global('main', 'gallery/backend/dashboard');
	}




	public function action_tagger()
	{
		$image_list = array();
		$gallery = new Model_Image();

		$image_list = $gallery->get_posts();
		//$image_list = array_chunk($image_list, 15, TRUE);
		//echo"<pre>";var_dump($image_list);die();

		//Get tags
		foreach ($image_list as &$item)
		{
			$item['tags'] = rand()*912837982 . ', ' . rand()*912837982 . ', ' . rand()*912837982;
		}

		View::set_global('image_list', $image_list);
		View::set_global('main', 'gallery/backend/tagger');
	}
}
