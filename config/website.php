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
				URL::site('/library/bootstrap/css/bootstrap.css', TRUE)   => 'screen',
				URL::site('template/default/css/style.css', TRUE)   => 'screen',
			),
			'script' => array(
				//URL::site('/media/library/ckeditor/ckeditor.js', TRUE) => TRUE,
				//URL::site('/script/ckeditor_config.js', TRUE) => TRUE,
				//URL::site('/media/library/ckeditor/adapters/jquery.js', TRUE) => TRUE,
				//URL::site('/media/library/js/jquery.filedrop.js', TRUE) => TRUE,
				URL::site('/library/boilerplate/js/vendor/modernizr-2.6.2.min.js', TRUE)          => TRUE,
				URL::site('/library/jquery/jquery-1.9.1.min.js', TRUE)          => TRUE,
				URL::site('/library/knockoutjs/knockout-2.2.1.js', TRUE) => TRUE,
				//URL::site('/library/js/jquery.filedrop.js', TRUE)        => TRUE,
				//URL::site('/library/js/jquery.lazyload.js', TRUE)        => TRUE,
				url::SITE('/library/ckeditor/ckeditor.js', TRUE) => TRUE,
				URL::site('/script/ckeditor_config.js', TRUE)                     => TRUE,
				URL::site('/script/common.js', TRUE)                     => TRUE,
			),
		),
		'backend' => array(
			'name' => 'default',
			'style' => array(
				URL::site('template/default/css/style.css', TRUE) => 'screen',
				URL::site('template/default/css/gallery.css', TRUE) => 'screen',
				URL::site('template/default/css/upload.css', TRUE) => 'screen',
			),
			'script' => array(
				URL::SITE('/library/jquery/jquery-1.9.1.min.js', TRUE) => TRUE,
				URL::SITE('/library/ckeditor/ckeditor.js', TRUE) => TRUE,
				URL::site('/script/ckeditor_config.js', TRUE)                     => TRUE,
				//URL::site('/media/library/ckeditor/adapters/jquery.js', TRUE) => TRUE,
				//URL::site('/media/library/js/jquery.filedrop.js', TRUE) => TRUE,
				URL::site('/library/knockoutjs/knockout-2.2.1.js', TRUE) => TRUE,
				URL::site('/library/js/jquery.filedrop.js', TRUE) => TRUE,
				URL::site('/script/common.js', TRUE) => TRUE,
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