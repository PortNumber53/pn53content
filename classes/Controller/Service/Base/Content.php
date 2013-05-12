<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 5/12/13
 * Time: 3:37 AM
 *
 */

class Controller_Service_Base_Content extends Controller_Service_Base_Service
{

	public function action_ajax_save()
	{
		$return = array();

		$json = json_decode(empty($_POST['json']) ? '' : $_POST['json'], TRUE);

		$title = $json['title'];

		//Try save
		$content_model = new Model_Content();
		$result = $content_model->save($json);

		//$return['content_id'] = 1;

		$return['data'] = $json;

		$this->output = $return;
	}

}