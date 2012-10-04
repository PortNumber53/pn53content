<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/30/12 11:51 PM
 * Package: Package_Name
 * Description: something meaningful about the file
 */
class Controller_Service_Tag extends Controller_Service_Service {


	public function action_add()
	{
		$this->auto_render = FALSE;

		$new_tag = empty($_POST['new_tag']) ? '' : $_POST['new_tag'];

		//echo "hello $new_tag";
	}

	public function action_ajax_add()
	{
		$error = 0;
		$message = "";

		$this->auto_render = FALSE;

		$new_tag = empty($_POST['new_tag']) ? '' : $_POST['new_tag'];
		$old_tag = empty($_POST['old_tag']) ? '' : $_POST['old_tag'];
		$_id = empty($_POST['_id']) ? '' : $_POST['_id'];
		$image = new Model_Image();
		$data = $image->get_post_by_id($_id);

		if (! empty($old_tag))
		{
			//Replace on of the tags
			for ($i = 0; $i < count($data['tags']); $i++)
			{
				if ($data['tags'][$i] == $old_tag)
				{
					//echo "unsetting $old_tag\n";
					unset($data['tags'][$i]);
				}
			}
			//var_dump($data['tags']);
		}

		$tags = explode(',', $new_tag);

		foreach ($tags as &$tag)
		{
			unset($tag);
		}

		if ($data)
		{
			$data['tags'] = array_merge(empty($data['tags']) ? array() : $data['tags'], $tags);
			$image->save($data);
			$return_tags = implode(',', $data['tags']);
		}

		//echo "hello $new_tag";
		echo json_encode(array(
			'error' => $error,
			'message' => $message,
			'return_tags' => $return_tags,
		));
		exit;
	}


	public function action_ajax_remove()
	{
		$error = 0;
		$message = "";

		$this->auto_render = FALSE;

		$delete_tag = empty($_POST['delete_tag']) ? '' : $_POST['delete_tag'];
		$_id = empty($_POST['_id']) ? '' : $_POST['_id'];
		$image = new Model_Image();
		$data = $image->get_post_by_id($_id);

		if ($data)
		{
			foreach ($data['tags'] as $key=>$value)
			{
				if ($value == $delete_tag)
				{
					unset($data['tags'][$key]);
				}
			}
			$image->save($data);
			$return_tags = implode(',', $data['tags']);
		}

		//echo "hello $new_tag";
		echo json_encode(array(
			'error' => $error,
			'message' => $message,
			'return_tags' => $return_tags,
		));
		exit;
	}

}
