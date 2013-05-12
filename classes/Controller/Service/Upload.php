<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 9/19/12 1:36 AM
 * Package: Package_Name
 */

class Controller_Service_Upload extends Controller_Service_Base_Service {

	public $demo_mode = false;
	public $upload_dir = '';
	public $allowed_ext = array('jpg','jpeg','png','gif');

	public function action_image()
	{
		$this->upload_dir = realpath(DOCROOT.'../upload/').'/';
		if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
			$this->exit_status('Error! Wrong HTTP method!');
		}


		$this->auto_render = FALSE;

		if(array_key_exists('pic',$_FILES) && $_FILES['pic']['error'] == 0 ){

			$pic = $_FILES['pic'];

			if(!in_array($this->get_extension($pic['name']),$this->allowed_ext)){
				$this->exit_status('Only '.implode(',',$this->allowed_ext).' files are allowed!');
			}

			if($this->demo_mode){

				// File uploads are ignored. We only log them.

				$line = implode('		', array( date('r'), $_SERVER['REMOTE_ADDR'], $pic['size'], $pic['name']));
				file_put_contents('log.txt', $line.PHP_EOL, FILE_APPEND);

				$this->exit_status('Uploads are ignored in demo mode.');
			}


			// Move the uploaded file from the temporary
			// directory to the uploads folder:
			$file_contents = file_get_contents($pic['tmp_name']);
			$new_name = md5($file_contents);

			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mimetype = finfo_file($finfo, $pic['tmp_name']);
			switch ($mimetype)
			{
				case "image/gif": $extension = 'gif';
					break;
				case "image/png": $extension = 'png';
					break;
				case "image/jpeg": $extension = 'jpg';
					break;
				default: $extension = 'jpg';
			}
			//echo "$mimetype\n";
			$filesize = filesize($pic['tmp_name']);
			$md5_filesize = md5($filesize);
			$folder1 = substr($md5_filesize, 0, 16) . '/';
			$folder2 = substr($md5_filesize, 16) . '/';

			if (!is_dir($this->upload_dir.$folder1))
			{
				mkdir($this->upload_dir.$folder1);
			}
			if (!is_dir($this->upload_dir.$folder1.$folder2))
			{
				mkdir($this->upload_dir.$folder1.$folder2);
			}

			if (move_uploaded_file($pic['tmp_name'], $this->upload_dir.$folder1.$folder2.$new_name.'.'.$extension))
			{
				list($width, $height, $type, $attr) = getimagesize($this->upload_dir.$folder1.$folder2.$new_name.'.'.$extension);

				$_id = $folder1.$folder2.$new_name.'.'.$extension;
				$image = new Model_Image();
				$data = $image->get_post_by_id($_id);
				$data = array_merge(empty($data) ? array() :$data, array(
					'_id' => $_id,
					'filesize' => $filesize,
					'original_name' => $pic['name'],
					'mimetype' => $mimetype,
					'width' => $width,
					'height' => $height,
				));
				$image->save($data);
				$this->exit_status('File was uploaded successfully!');
			}

		}

		$this->exit_status('Something went wrong with your upload!');



	}



// Helper functions

	function exit_status($str){
		echo json_encode(array('status'=>$str));
		exit;
	}

	function get_extension($file_name){
		$ext = explode('.', $file_name);
		$ext = array_pop($ext);
		return strtolower($ext);
	}
}