<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/19/12 12:14 AM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

class Controller_Backend_Base_Backend extends Controller_Base_Website {

	public $template_file = 'backend';


	public function action_dashboard()
	{
		View::set_global('main', 'modules/backend/dashboard');
	}

}