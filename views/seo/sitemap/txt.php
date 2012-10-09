<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 10/8/12 12:24 AM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

foreach ($url_array as $url)
{
	echo Url::site($url, TRUE) . "\n";
}
