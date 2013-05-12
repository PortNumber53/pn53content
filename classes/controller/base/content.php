<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 9/15/12 2:27 PM
 * Package: Package_Name
 */

class Controller_Base_Content  extends Controller_Base_Website
{

	public function action_index()
	{
		$this->action_view();
	}

	public function action_view()
	{
		$request = Request::current()->param('request', '/');
		if (!empty($request) && $request!=="/")
		{
			$request .= '.html';
		}

		$content_model = new Model_Content();
		$content_data = $content_model->get_post_by_url('/'.$request);

		if ($content_data)
		{
			View::set_global('content_data', $content_data);
			View::set_global('main', View::factory('content/main')->render() );
		}
		else
		{
			View::set_global('content_data', $content_data);
			View::set_global('main', View::factory('template/default/http/404')->render() );
		}
	}

	public function action_edit()
	{
		$request = Request::current()->param('request', '/');
		if (!empty($request) && $request!=="/")
		{
			$request .= '.html';
		}

		$content_model = new Model_Content();
		$content_data = $content_model->get_post_by_url('/'.$request);

		View::set_global('content_data', $content_data);
		View::set_global('main', 'content/edit');
	}


	public function action_ajax_save()
	{
		$_id = $this->request->post('_id');
		$title = $this->request->post('title');
		$description = $this->request->post('description');
		$keywords = $this->request->post('keywords');

		$sections = array();
		$section_titles = $this->request->post('section_title');
		$section_contents = $this->request->post('section_content');
		$section_images = $this->request->post('image_path');
		$sections = array();
		$max = count($section_titles);
		for ($counter = 0; $counter < $max; $counter++)
		{
			$sections[] = array(
				'title' => $section_titles[$counter],
				'content' => $section_contents[$counter],
				'image' => $section_images[$counter],
			);
		}
		$data = array(
			'_id' => $_id,
			'type' => 'article',
			'url' => $_id,
			'title' => $title,
			'description' => $description,
			'keywords' => $keywords,
			'sections' => $sections,
		);

		$content = new Model_Content();
		$result = $content->save($data);

		$this->output = $data;
	}

}