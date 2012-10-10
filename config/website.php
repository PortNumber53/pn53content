<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/15/12 3:36 PM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

return array(
	'cookie_salt' => 'Set to something secure',

	'site_name' => 'Sample website',

	'template' => array(
		'selected' => 'default',
		'frontend' => array(
			'name' => 'default',
			'style' => array(
				Url::site('template/default/css/style.css', TRUE) => 'screen',
				Url::site('template/default/css/gallery.css', TRUE) => 'screen',
			),
			'script' => array(
				Url::site('/media/library/ckeditor/ckeditor.js', TRUE) => TRUE,
				Url::site('/script/ckeditor_config.js', TRUE) => TRUE,
				Url::site('/media/library/ckeditor/adapters/jquery.js', TRUE) => TRUE,
				//Url::site('/media/library/js/jquery.filedrop.js', TRUE) => TRUE,
				Url::site('/media/library/knockoutjs/knockout-2.1.0.js', TRUE) => TRUE,
				Url::site('/media/library/js/jquery.filedrop.js', TRUE) => TRUE,
				Url::site('/script/common.js', TRUE) => TRUE,
			),
		),
		'backend' => array(
			'name' => 'default',
			'style' => array(
				Url::site('template/default/css/style.css', TRUE) => 'screen',
				Url::site('template/default/css/gallery.css', TRUE) => 'screen',
				Url::site('template/default/css/upload.css', TRUE) => 'screen',
			),
			'script' => array(
				//Url::site('/media/library/ckeditor/ckeditor.js', TRUE) => TRUE,
				//Url::site('/script/ckeditor_config.js', TRUE) => TRUE,
				//Url::site('/media/library/ckeditor/adapters/jquery.js', TRUE) => TRUE,
				//Url::site('/media/library/js/jquery.filedrop.js', TRUE) => TRUE,
				Url::site('/media/library/knockoutjs/knockout-2.1.0.js', TRUE) => TRUE,
				Url::site('/media/library/js/jquery.filedrop.js', TRUE) => TRUE,
				Url::site('/script/common.js', TRUE) => TRUE,
			),
			'gallery' => array(
				'thumbnail' => array(
					'width' => 320,
					'height' => 240,
				),
			),
		),
	),

	'facebook' => array(
		'enabled' => FALSE,
	),

	'default_language' => 'en-us',


	'upload_folder' => DOCROOT . '../upload/',
);