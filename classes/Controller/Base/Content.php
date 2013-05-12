<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 9/15/12 2:27 PM
 * Package: Package_Name
 */

class Controller_Base_Content extends Controller_Base_Website
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


	public function action_view()
	{
		$content_model = new Model_Content();
		$content_data = $content_model->get_post_by_id(self::$url);

		$canonical_url = URL::site(Route::get('html-content')->uri(array(
			'request'=> self::$original_request,
			'type'=>'document',
		)), TRUE);

		View::add_global('og:tags', 'og:url', $canonical_url);
		View::set_global('canonical_url', $canonical_url);
		if ($content_data)
		{
			if (! empty($content_data['open_graph']))
			{
				foreach ($content_data['open_graph'] as $key=>$value)
				{
					switch ($value['type'])
					{
						case "url":
							$tag_value = URL::site($value['value'], TRUE);
							break;
						default:
							$tag_value = '';
					}
					View::add_global('og:tags', 'og:' . $value['tag'], $tag_value);
				}
			}
			View::set_global('page_title', __(empty($content_data['title']) ? '' : $content_data['title']));
			if ( ! empty($content_data['description']))
			{
				View::add_global('og:tags', 'og:description', $content_data['description']);
			}

			View::set_global('breadcrumbs', array(
				__('Home') => URL::Site('/', TRUE),
				$content_data['title'] => URL::Site(Route::get('html-content')->uri(array('request'=>self::$original_request,)), TRUE),

			));
			View::add_global('og:tags', 'og:title', !empty($content_data['title']) ? $content_data['title'] : $image_data['original_name']);
			View::set_global('content_data', $content_data);
			View::set_global('main', 'content/main' );
		}
		else
		{
			View::set_global('main', 'template/default/http/404' );
		}
	}


	public function action_document()
	{
		$content_model = new Model_Content();

		$content_data = $content_model->get_post_by_url(self::$url);

		View::add_global('og:tags', 'og:url', URL::site(Route::get('browse-content')->uri(array(
			'request'=> '/',
			'type'=>'document',
		)), TRUE));
		if ($content_data)
		{
			View::set_global('breadcrumbs', array(
				__('Home') => URL::Site(Route::get('browse-content')->uri(array('controller'=>'content', 'action'=>'view', 'request'=>'frontpage', )), TRUE),
				$content_data['title'] => URL::Site(Route::get('browse-content')->uri(array('request'=>self::$url,)), TRUE),

			));
			View::add_global('og:tags', 'og:title', !empty($content_data['title']) ? $content_data['title'] : $image_data['original_name']);
			var_dump($content_data);
			if (! empty($content_data['open_graph']))
			{
				foreach ($content_data['open_graph'] as $key=>$value)
				{
					switch ($value['type'])
					{
						case "url":
							$tag_value = URL::site($value['value'], TRUE);
							break;
						default:
							$tag_value = '';
					}
					echo 'og:' . $value['tag'];
					View::add_global('og:tags', 'og:' . $value['tag'], $tag_value);
				}
			}
			View::set_global('content_data', $content_data);
			View::set_global('main', View::factory('content/main')->render() );
		}
		else
		{
			//echo "DID NOT FIND $request"; die();
			HTTP::redirect('/');
			//View::add_global('og:tags', 'og:title', Arr::path(self::$settings, 'site_name'));
			View::set_global('main', 'content/not_found');
//					View::add_global('og:tags', 'og:url', URL::site(Route::get('browse-content')->uri(array(
//						'request'=> '/',
//						'type'=>'document',
//						)), TRUE));
		}
	}


	public function action_image()
	{
		View::set_global('breadcrumbs', array(
			__('Home') => URL::Site(Route::get('browse-content')->uri(array('controller'=>'content', 'action'=>'view', 'request'=>'frontpage', )), TRUE),
			__('Gallery') => URL::Site(Route::get('browse-content')->uri(array('controller'=>'gallery', 'action'=>'browse', 'request'=>'browse-p1', )), TRUE),
		));
		self::$url = str_replace('_', '.', self::$url);
		$image_model = new Model_Image();

		$image_id = str_replace('.html', '', self::$url);
		if (substr($image_id, 0, 1) == '/')
		{
			$image_id = substr($image_id, 1);
		}

		$image_data = $image_model->get_post_by_id($image_id);
		if (! $image_data)
		{
			$image_data = $image_model->get_post_by_id("/$image_id");
		}


		//var_dump($image_data);
		if ($image_data)
		{
			if (!empty($image_data['sections'][0]['image']))
			{
				View::add_global('og:tags', 'og:image', URL::site($image_data['sections'][0]['image']));
			}
			else
			{
				View::add_global('og:tags', 'og:image', URL::site('/no_image.gif', TRUE));
			}

			if (!empty($image_data['open_graph']) && is_array($image_data['open_graph']))
			{
				foreach ($image_data['open_graph'] as $og_item)
				{
					list($tag, $value) = explode("=", $og_item);
					View::set_global('og:'.$tag, $value);
				}
			}

			$canonical_url = URL::site(Route::get('browse-content')->uri(array(
				'request' => substr($image_data['_id'], 0, -4).'.'.substr($image_data['_id'], -3),
				'action' => 'image',
			)), TRUE);
			$image_data['canonical_url'] = $canonical_url;
			//View::set_global('canonical_url', $canonical_url);



			View::add_global('meta', 'keywords', implode(',', !empty($image_data['tags'])?$image_data['tags']:array()));
			View::add_global('og:tags', 'og:keywords', implode(',', !empty($image_data['tags'])?$image_data['tags']:array()));
			View::add_global('og:tags', 'thumbitt:keywords', implode(',', !empty($image_data['tags'])?$image_data['tags']:array()));
			View::set_global('image_data', $image_data);
			View::set_global('main', View::factory('content/image')->render() );

			View::add_global('og:tags', 'og:title', !empty($image_data['title']) ? $image_data['title'] : $image_data['original_name']);
			View::add_global('og:tags', 'og:type', "image");

			View::add_global('og:tags', 'og:image', URL::site(Route::get('dynimage')->uri(array(
				'path' => substr($image_data['_id'], 0, -4),
				'format' => substr($image_data['_id'], -3),
				'width' => 50,
				'height' => 50,
			)), TRUE));
			View::add_global('og:tags', 'og:image:type', $image_data['mimetype']);
			View::add_global('og:tags', 'og:image:width', Arr::path(self::$settings, 'template.frontend.thumbitt.meta.thumbnail.width'));
			View::add_global('og:tags', 'og:image:height', Arr::path(self::$settings, 'template.frontend.thumbitt.meta.thumbnail.height'));

			$canonical_url = URL::site(Route::get('browse-content')->uri(array(
				'request'=>$image_data['_id'],
				'type'=>'image',
			)), TRUE);
			View::add_global('og:tags', 'og:url', $canonical_url);
			View::set_global('canonical_url', $canonical_url);


			$page_title = !empty($image_data['title']) ? $image_data['title'] : $image_data['original_name'];
			View::bind_global('page_title', $page_title);

			View::set_global('breadcrumbs', array(
				__('Home') => URL::Site(Route::get('browse-content')->uri(array('controller'=>'content', 'action'=>'view', 'request'=>'frontpage', )), TRUE),
				__('Gallery') => URL::Site(Route::get('browse-content')->uri(array('controller'=>'gallery', 'action'=>'browse', 'request'=>'browse-p1', )), TRUE),
				$page_title => $image_data['canonical_url'],
			));

		}
	}












	public function action_gallery()
	{
		$page = Request::current()->param('page', 1);
		$layout = Request::current()->param('layout', 'blog');
		$current_canonical = URL::Site(Route::get('paged')->uri(array('action'=>'gallery', 'layout'=>$layout, 'page'=>$page, )), TRUE);

		View::set_global('page_title', __('Gallery Page ' . $page));

		$item_per_page = Website::factory()->template('gallery.items_per_page');
		$gallery = new Model_Image();
		//$page = isset($_GET['page']) ? $_GET['page'] : 1;
		//$page = Request::current()->param('page', 1);
		//$layout = Request::current()->param('layout');

		View::set_global('breadcrumbs', array(
			__('Home')          => URL::Site(Route::get('browse-content')->uri(array('controller'=>'content', 'action'=>'view', 'request'=>'frontpage', )), TRUE),
			__('Gallery')       => URL::Site(Route::get('browse-content')->uri(array('controller'=>'gallery', 'action'=>'browse', 'request'=>'browse-p1', )), TRUE),
			__('Page ') . $page => $current_canonical,
		));
		//				return 'x-'.$page.URL::site(Request::current()->uri(array($this->config['current_page']['key'] => $page))).URL::query();

		View::add_global('og:tags', 'og:type', "Website");
		View::add_global('og:tags', 'og:url', $current_canonical);


		//echo"<pre>";print_r(Request::current());echo"</pre>";

		$query = array(
			array('nsfw', '=', '0'),
		);
		$image_list = $gallery->filter($query, $page, $item_per_page);

		$pagination = Pagination::factory(array(
			'total_items'       => $image_list['count'],
			//'total_pages'       => (int) count($image_list) / $item_per_page,
			'items_per_page'    => $item_per_page,
			'current_page'      => 'page',
			'first_page_in_url' => TRUE,
			'auto_hide'         => TRUE,
			//'view'              => 'pagination/floating',
			'current_page'      => array(
				'source' => 'route',
				'key'    => 'page',
			),
			//'uri_segment'       => 'page'
		));
		$pagination_links = $pagination->render();
		//var_dump($pagination_links);

		View::set_global('image_list', $image_list);
		View::set_global('item_per_page', $item_per_page);
		View::set_global('page', $page);
		View::set_global('pagination_links', $pagination_links);

		View::set_global('main', View::factory('gallery/blog')->render() );

	}












	public function action_detail()
	{
		$request = Request::current()->param('request', '/');
		$type = Request::current()->param('type', 'document');


		View::add_global('og:tags', 'og:type', "Website");
//		View::add_global('og:tags', 'og:title', Arr::path(sefl::$settings, 'site_name') );

		//echo "TYPE: $type<br>";
		switch ($type)
		{
			case "gallery":
				View::set_global('breadcrumbs', array(
					__('Home') => URL::Site(Route::get('browse-content')->uri(array('controller'=>'content', 'action'=>'view', 'request'=>'frontpage', )), TRUE),
					__('Gallery') => URL::Site(Route::get('browse-content')->uri(array('controller'=>'gallery', 'action'=>'browse', 'request'=>'browse-p1', )), TRUE),
				));


				View::set_global('main', View::factory('content/gallery')->render() );


				break;
			case "image":
				View::set_global('breadcrumbs', array(
					__('Home') => URL::Site(Route::get('browse-content')->uri(array('controller'=>'content', 'action'=>'view', 'request'=>'frontpage', )), TRUE),
					__('Gallery') => URL::Site(Route::get('browse-content')->uri(array('controller'=>'gallery', 'action'=>'browse', 'request'=>'browse-p1', )), TRUE),
				));
				$request = str_replace('_', '.', $request);
				$image_model = new Model_Image();
				$image_data = $image_model->get_post_by_id($request);

				if ($image_data)
				{
					if (!empty($image_data['sections'][0]['image']))
					{
						View::add_global('og:tags', 'og:image', URL::site($image_data['sections'][0]['image']));
					}
					else
					{
						View::add_global('og:tags', 'og:image', URL::site('/no_image.gif', TRUE));
					}

					if (!empty($image_data['open_graph']) && is_array($image_data['open_graph']))
					{
						foreach ($image_data['open_graph'] as $og_item)
						{
							list($tag, $value) = explode("=", $og_item);
							View::set_global('og:'.$tag, $value);
						}
					}


					View::add_global('meta', 'keywords', implode(',', !empty($image_data['tags'])?$image_data['tags']:array()));
					View::add_global('og:tags', 'og:keywords', implode(',', !empty($image_data['tags'])?$image_data['tags']:array()));
					View::add_global('og:tags', 'thumbitt:keywords', implode(',', !empty($image_data['tags'])?$image_data['tags']:array()));
					View::set_global('image_data', $image_data);
					View::set_global('main', 'content/image');

					View::add_global('og:tags', 'og:title', !empty($image_data['title']) ? $image_data['title'] : $image_data['original_name']);
					View::add_global('og:tags', 'og:type', "image");

					View::add_global('og:tags', 'og:image', URL::site(Route::get('dynimage')->uri(array(
						'path' => substr($image_data['_id'], 0, -4),
						'format' => substr($image_data['_id'], -3),
					)), TRUE));
					View::add_global('og:tags', 'og:image:type', $image_data['mimetype']);
					View::add_global('og:tags', 'og:image:width', Arr::path(self::$settings, 'template.frontend.meta.thumbnail.width'));
					View::add_global('og:tags', 'og:image:height', Arr::path(self::$settings, 'template.frontend.meta.thumbnail.height'));

					$canonical_url = URL::site(Route::get('browse-content')->uri(array(
						'request'=>$image_data['_id'],
						'type'=>'image',
					)), TRUE);
					View::add_global('og:tags', 'og:url', $canonical_url);
					View::set_global('canonical_url', $canonical_url);


					$page_title = !empty($image_data['title']) ? $image_data['title'] : $image_data['original_name'];
					View::bind_global('page_title', $page_title);

					View::set_global('breadcrumbs', array(
						__('Home') => URL::Site(Route::get('browse-content')->uri(array('controller'=>'content', 'action'=>'view',)), TRUE),
						__('Gallery') => URL::Site(Route::get('browse-content')->uri(array('controller'=>'gallery', 'action'=>'browse',)), TRUE),
						$page_title => URL::site(Route::get('browse-content')->uri(array(
							'request' => substr($image_data['_id'], 0, -4).'.'.substr($image_data['_id'], -3),
							'type' => 'image',
						), TRUE))
					));

				}
				break;
			default:
			case "document":

				break;
		}
	}


}
