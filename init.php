<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 9/15/12 2:14 PM
 * Package: PN53Content routes
 */

if (! Route::$cache)
{
	Route::set('user-actions', '<action>',
		array(
			'action' => '(reset_password|sign_up|login|profile|logout)',
		))
		->defaults(array(
			'controller' => 'Account',
			'action'     => 'profile',
		));

/*
	Route::set('browse-content', '<request>.html',
		array(
			'request' => '[a-zA-Z0-9_\/\.=-]+',
		))
		->defaults(array(
		'controller' => 'contentus',
		'action'     => 'view',
	));
*/

	Route::set('facebook-actions', 'canvas(/<controller>(/<action>))',
		array(
			'request' => '[a-zA-Z0-9_\/\.=-]+',
		))
		->defaults(array(
		'controller' => 'canvas',
		'action'     => 'index',
	));


	Route::set('dynimage', '(<language>/)<path>(:<width>x<height>)(:<method>).<format>',
		array(
			'language' => '(pt-br)',
			'path' => '[a-zA-Z0-9_/\-]+',
			'format' => '(jpeg|jpg|gif|png|bmp|image)',
			'width' => '[0-9]+',
			'height' => '[0-9]+',
			'method' => '(full|stretch|aspect)',
		))
		->defaults(array(
		'controller' => 'dynimage',
		'method' => 'aspect',
		'action' => 'static',
	));



	Route::set('image-handler', 'service/<controller>:<action>',
		array(
			'controller'    => '(dynimage)',
			'action'        => '(upload)',
		))
		->defaults(array(
		'controller' => 'dynimage',
		'action'     => 'upload',
	));


	Route::set('backend-actions', 'backend(/<controller>(/<action>))',
		array(
		))
		->defaults(array(
		'directory'  => 'backend',
		'controller' => 'backend',
		'action'     => 'dashboard',
	));


	Route::set('service-actions', 'service(/<controller>(/<action>))',
		array(
		))
		->defaults(array(
		'directory'  => 'service',
		'controller' => 'service',
		'action'     => 'dashboard',
	));

	Route::set('sitemap', 'sitemap/<name>:<page>.<format>',
		array(
			'name' => '[a-zA-Z0-9_/\-]+',
			'page' => '[0-9]+',
			'format' => '(xml|txt)',
		))
		->defaults(array(
		'controller' => 'sitemap',
		'action' => 'generate',
		'page' => 1,
	));

	Route::set('seo-robots', 'robots.txt')
		->defaults(array(
		'controller' => 'robots',
		'action' => 'index',
	));

	Route::set('html-content', '(<request>.html)(<override>)',
		array(
			'request'       => '[a-zA-Z0-9_/\-]+',
			'override'      => '(:edit)',
		))->filter(function($route, $params, $request)
		{
			// Prefix the method to the action name
			if ( ! empty($params['override']) && $params['override'] == ':edit')
			{
				$params['action'] = 'edit';
				$params['directory'] = 'Backend';
			}
			//$params['action'] = strtolower($request->method()).'_'.$params['action'];
			return $params; // Returning an array will replace the parameters
		})
		->defaults(array(
			'controller' => 'Content',
			'action'     => 'view',
		));

}
