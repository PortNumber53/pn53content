<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 10/7/12 11:57 PM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

class Controller_Base_Robots extends Controller
{

	public function action_index() {
		$view_html = View::factory('seo/robots.txt')->render();

		$this->response->headers('Content-type', 'text/plain');
		$this->response->headers('Content-length', strlen($view_html));
		$this->response->body( $view_html );
	}

}