<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/26/12 1:29 AM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

class Controller_Base_Dynimage extends Controller
{

	public function action_static()
	{
		$path = $this->request->param('path', '');
		$format = $this->request->param('format', '');
		$width = (int) $this->request->param('width', 0);
		$height = (int) $this->request->param('height', 0);
		$method = $this->request->param('method', Dynimage::RESIZE_FULL);
		if ($width == 0 && $height == 0)
		{
			$method = 'full';
		}

		if ($source_folder = Dynimage::check_upload_folder())
		{
			//echo 'Can upload<br /> ' . $source_folder;
		}
		$file_info = array('path' => $path, 'source_folder'=>$source_folder);
		$target_file = '';
		switch ($format)
		{
			case 'gif':
				$this->response->headers('Content-type', 'image/gif');
				$filename = $path . '.gif';
				$target_file = Dynimage::get_file_full_path($filename);
				$handle = fopen($target_file, 'r');
				while ( ! feof($handle))
				{
					$block = fread($handle, 4096);
					echo $block;
				}
				break;

			case 'jpeg':
			case 'jpg':
			case 'png':
				$this->response->headers('Content-type', 'image/' . $format);
				$filename = $path . '.' . $format;
				$target_file = Dynimage::get_file_full_path($filename);

				$image = Image::factory($target_file, 'gd');
				switch ($method)
				{
					case 'stretch':
						$image->resize($width, $height);
						break;
					case 'aspect':
						//$image->newImage($width, $height, 'none');
						$src_width = $image->width;
						$src_height = $image->height;

						$ratio_x = ($width / $src_width);
						$ratio_y = ($height / $src_height);
						if ($ratio_x < $ratio_y)
						{
							$new_width = (int) $width;
							$new_height = (int) ($src_height * $ratio_y);
						}
						else
						{
							$new_width = (int) ($src_width * $ratio_y);
							$new_height = (int) $height;
						}
						//echo $new_width, $new_height;
						$image->resize($new_width, $new_height, true);
						break;
					case 'full':
					default:
						$image = Image::factory($target_file);
						$width = $image->width;
						$height = $image->height;
						break;
				}
				echo $image->render();
				break;
			default:
				$this->request->body('Unsupported image format.');
				break;
		}
		if ($target_file == '' && $width == 0 && $height == 0)
		{
			$this->response->headers('Content-type', 'text/plain');
			$this->response->body('Invalid parameters.');
		}
	}

	public function action_upload()
	{
		$output = array();
		//var_dump($_FILES);
		//var_dump($_POST);
		//die;

		$upload_folder = Dynimage::check_upload_folder();
		if ($this->request->method() == HTTP_Request::POST)
		{
			//move file
			$files = Validation::factory($_FILES)->as_array();
			$output = array_merge($output, $files);

			$kohana_file = array(
				'name' => $files['image']['name'],
				'type' => $files['image']['type'],
				'tmp_name' => $files['image']['tmp_name'],
				'error' => $files['image']['error'],
				'size' => $files['image']['size'],
			);
			$hash = md5($kohana_file['name']);
			$folder1 = substr($hash, 0, 16);
			$folder2 = substr($hash, 16);

			if (!is_dir($upload_folder . '/' . $folder1))
			{
				mkdir($upload_folder . '/' . $folder1);
			}
			if (!is_dir($upload_folder . '/' . $folder1 . '/' . $folder2))
			{
				mkdir($upload_folder . '/' . $folder1 . '/' . $folder2);
			}

			$return = Upload::save($kohana_file, $files['image']['name'], $upload_folder . '/' . $folder1 . '/' . $folder2 . '/');
			if ($return)
			{
				$pos = strpos($return, '/upload/');
				$return = substr($return, $pos+8);
				$output['image_path'] = $return;
			}

		}
		else
		{
			$output['alert'] = 'Something went wrong!';
		}

		$this->response->body( json_encode($output) );
	}


	public function action_ajax_upload()
	{
		$this->response->body('{"message":"ajax_upload"}');
	}


}
