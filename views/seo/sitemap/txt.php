<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 10/8/12 12:24 AM
 * Package: Package_Name
 */

foreach ($url_array as $url)
{
	echo Url::site($url, TRUE) . "\n";
}
