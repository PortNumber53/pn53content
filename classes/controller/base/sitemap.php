<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 10/7/12 11:57 PM
 * Package: Package_Name
 */

class Controller_Base_Sitemap extends Controller
{

	public function action_generate()
	{
		$name = $this->request->param('name');
		$page = $this->request->param('page');
		$format = $this->request->param('format');

		$url_array = array();
		switch ($name)
		{
			case 'general':
				$content = new Model_Content();
				$data = $content->get_posts(1000, $page, 1000);

				foreach ($data as $each)
				{
					$url_array[] = $each['url'];
				}

				break;
			default:
				$image = new Model_Image();
				$data = $image->get_urls(100, $page, 1000);
				foreach ($data as $each)
				{
					$url_array[] = $each['_id'];
				}
		}
		switch ($format)
		{
			case "xml":
				$this->response->headers('Content-type', 'application/rss+xml');
				break;
			default:
			//	$this->response->headers('Content-type', 'plain/text');
		}

		$this->response->body( View::factory('seo/sitemap/' . $format, array(
			'url_array' => $url_array,
		))->render() );
	}

}