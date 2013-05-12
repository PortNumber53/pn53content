<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 5/12/13
 * Time: 3:03 AM
 *
 */

class Controller_Backend_Base_Content extends Controller_Backend_Base_Website
{
	public static $original_request = NULL;
	public static $url = NULL;

	public function before()
	{
		self::$original_request = self::$url = Request::current()->param('request', '/');
		if (!empty(self::$url ) && self::$url   !== "/")
		{
			self::$url .= '.html';
		}
		if (self::$url !== "/")
		{
			self::$url = '/' . self::$url ;
		}
		parent::before();

		View::set_global('main', 'content/not_found');
	}

	public function action_edit()
	{
		$content_model = new Model_Content();
		//echo "searching: ".self::$url."<br>";
		$content_data = $content_model->get_post_by_id(self::$url);
		//var_dump($content_data);

		$canonical_url = URL::site(Route::get('html-content')->uri(array(
			'request' => self::$original_request,
			'type'    => 'document',
		)), TRUE);

		View::add_global('og:tags', 'og:url', $canonical_url);
		View::set_global('canonical_url', $canonical_url);
		if ($content_data)
		{
			View::set_global('page_title', __('Editing: ') . (empty($content_data['title']) ? '' : $content_data['title']));

		}
		else
		{
			$content_data['manual_url'] = TRUE;
			$content_data['url'] = str_replace(':edit', '', Request::detect_uri());
		}
		if (substr($content_data['url'], 0, 1) == '/')
		{
			$content_data['url'] = substr($content_data['url'], 1);
		}

		View::set_global('content_data', $content_data);
		View::set_global('main', View::factory('content/backend/edit')->render());
	}

}