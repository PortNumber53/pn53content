<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/15/12 2:26 PM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

class Controller_Base_Website extends Controller_Template
{
	public $template_name = '';
	public $template_file = '';

	public $breadcrumb = array();
	public $content = '{CONTENT}';

	public $auth_required = false;
	public $auth_actions = array();

	public $output = null;

	public $facebook            = array();
	public $facebook_stuff      = array();

	public function __construct(Request $request, Response $response)
	{
		Cookie::$salt = '123123';

		$debug = Kohana::$config->load('website.debug');
		$this->facebook_stuff = Kohana::$config->load('website.facebook');
		View::bind_global('debug', $debug);
		$session = Session::instance();
		Cookie::$salt = Kohana::$config->load('website.cookie_salt').'123123';

		parent::__construct($request, $response);
		//If a user is not logged in and authentication is required:
		if ($this->auth_required && ! $this->user)
			$this->request->redirect('login?url='.Url::site(Request::current()->uri()));

		if (in_array($this->request->action(), $this->auth_actions))
		{
			if ( ! $this->user)
			{
				echo $this->request->action() . ' requires Authentication!';
				$this->request->redirect('login?url='.Url::site(Request::current()->uri()));
			}
			$this->template_file = 'backend';
		};

		if ($this->request->is_ajax())
		{
			$this->auto_render = false;
			$this->request->action('ajax_'.$this->request->action());
		}
	}

	public function before()
	{
		if (empty($this->template_name))
		{
			$this->template_name = Kohana::$config->load('website.template.frontend.name');
		}

		if (empty($this->template_file))
		{
			$this->template_file = 'frontend';
		}
		$this->template = 'template/' . $this->template_name . '/' . $this->template_file;

		//View::$template_name = $this->template_name;

		parent::before();

		if ($this->facebook_stuff['enabled'])
		{
			$facebook_config = Kohana::$config->load('facebook');
			$this->facebook = new Facebook(array(
				'appId'         => $facebook_config['APPID'],
				'secret'        => $facebook_config['APPSECRET'],
				'cookie'        => $facebook_config['COOKIE'],
			));
			//Facebook Authentication part
			User::$user_data        = $this->facebook->getUser();
			$this->facebook_stuff['login_url']   = $this->facebook->getLoginUrl(array(
				'scope'         => $facebook_config['PERMISSION'],
				'redirect_uri'  => $facebook_config['BASEURL']
			));
			$this->facebook_stuff['logout_url']  = $this->facebook->getLogoutUrl();

			if (User::$user_data)
			{
				try
				{
					User::$user_profile = $this->facebook->api('/me');
					Cookie::set('user', json_encode(User::$user_profile));
				}
				catch (FacebookApiException $e)
				{
					User::log_out();
				}
			}
			/*
	   //Facebook Authentication part
	   $user       = $facebook->getUser();
	   $loginUrl   = $facebook->getLoginUrl(
			   array(
				   'scope'         => 'email,offline_access,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown',
				   'redirect_uri'  => $fbconfig['baseurl']
			   )
	   );

	   $logoutUrl  = $facebook->getLogoutUrl();
	   if ($user) {
		 try {
		   // Proceed knowing you have a logged in user who's authenticated.
		   $user_profile = $facebook->api('/me');
		 } catch (FacebookApiException $e) {
		   //you should use error_log($e); instead of printing the info on browser
		   d($e);  // d is a debug function defined at the end of this file
		   $user = null;
		 }
	   }
   */


			if (User::$user_profile)
			{
				if (! empty(User::$user_profile['id']))
				{
					if (in_array(User::$user_profile['id'], User::admins() ))
					{
						User::$is_admin = TRUE;
					}
				}
			}


		}

		if ($this->auto_render)
		{
			View::set_global('param', Request::current()->param());
			View::$template_name = $this->template_name;
			View::set_global('title', '');
			View::set_global('content', '');
			View::set_global('language', Kohana::$config->load('contentus.default_language'));
			View::set_global('body_class', '');
			View::set_global('meta', array());

			View::set_global('styles', array());
			View::set_global('scripts', array());

			View::add_global('og:tags', array(
				'og:site_name' => Kohana::$config->load('site_settings.site_name'),
				'og:url' => URL::site(Request::factory()->current()->uri(), true),
				'fb:app_id' => Kohana::$config->load('facebook.APPID'),
			));

			$this->breadcrumb = array(
				0 => array(
					'active'    => true,
					'label'     => __('Home'),
					'link'      => Url::site('/'),
				),
			);
		}
	}

	public function after()
	{
		View::bind_global('user_data', User::$user_data);
		View::bind_global('user_profile', User::$user_profile);
		View::bind_global('is_admin', User::$is_admin);
		View::bind_global('facebook_stuff', $this->facebook_stuff);



		if ($this->auto_render)
		{
			View::bind_global('user', $this->user);
			View::set_global('current_url', Url::site(Request::factory()->current()->uri(), true));

			$cps_config = Kohana::$config->load('website')->as_array();

			$styles = Arr::path($cps_config, 'template.style', array());
			$scripts = Arr::path($cps_config, 'template.script', array());

			$custom_styles = Arr::path($cps_config, 'template.' . $this->template_file . '.style', array());
			$custom_scripts = Arr::path($cps_config, 'template.' . $this->template_file . '.script', array());

			View::set_global('styles', array_merge($this->template->styles, $styles, $custom_styles));
			View::set_global('scripts', array_keys(array_merge($this->template->scripts, $scripts, $custom_scripts)));

			$site_settings = Kohana::$config->load('website');
			View::bind_global('site_settings', $site_settings);

			View::bind_global('breadcrumb', $this->breadcrumb);
			View::bind_global('content', $this->content);
		}
		else
		{
			$this->response->headers('Content-Type', 'application/json');
			$this->response->body(json_encode($this->output));
		}
		parent::after();
	}

}