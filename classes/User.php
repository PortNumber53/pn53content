<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 9/15/12 5:11 PM
 * Package: Package_Name
 */

class User
{
	static $user_data		= null;
	static $user_profile	= null;
	static $is_admin		= FALSE;
	static $admins			= NULL;

	static public function is_logged()
	{
		if (empty(self::$user_data))
		{
			self::$user_data = json_decode(Cookie::get('user'), TRUE);
		}
		return self::$user_data;
	}

	static public function log_out()
	{
		self::$user_data = null;
		self::$user_profile = null;
		Cookie::set('user', null);
		Cookie::delete('user');
	}

	static public function admins()
	{
		if (self::$admins === NULL)
		{
			self::$admins = Kohana::$config->load('facebook.admins');
		}
		return self::$admins;
	}


	static public function login($username, $password, $remember_me, &$error = null)
	{
		$output = TRUE;

		$data = array(
			'username' => $username,
			'password' => self::hash_password($password),
			'remember_me' => $remember_me,
		);

		$user = new Model_User();
		if ($result = $user->login($data))
		{
			if ($result['error'])
			{
				$output = FALSE;
				$error =  $result['error_message'];
			}
			else
			{
				$output = $result;
			}
		}
		else
		{
			$output = FALSE;
			$error = 'Wrong username/password. Please try again';
		}

		return $output;
	}


	static private function hash_password($input)
	{
		return md5($input);
	}
}
