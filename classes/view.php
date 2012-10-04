<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/15/12 3:21 PM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

class View extends Kohana_View
{
	static public $template_name = '';
	static public $scripts = array();

	/**
	 * Sets the view filename.
	 *
	 *     $view->set_filename($file);
	 *
	 * @param   string  view filename
	 *
	 * @return  View
	 * @throws  View_Exception
	 */
	public function set_filename($file)
	{
		if (($path = Kohana::find_file('views', $file)) === FALSE)
		{
			if (($path = Kohana::find_file('views', 'template/' . self::$template_name . '/' . $file)) === FALSE)
			{
				throw new View_Exception('The requested view :file could not be found (template :template)', array(
					':file' => $file,
					':template' => self::$template_name,
				));

			}
		}

		// Store the file path locally
		$this->_file = $path;

		return $this;
	}

	/**
	 * Builds a global array, similar to [View::set], except that the
	 * array will be accessible to all views.
	 *
	 *     View::add_global($name, $value);
	 *
	 * @param   string  variable name or an array of variables
	 * @param   mixed   value
	 * @return  void
	 */
	public static function add_global($key, $subkey, $value = NULL)
	{

		if (is_array($subkey))
		{
			foreach ($subkey as $key2 => $value)
			{
				View::$_global_data[$key][$key2] = $value;
			}
		}
		else
		{
			View::$_global_data[$key][$subkey] = $value;
		}
	}

}