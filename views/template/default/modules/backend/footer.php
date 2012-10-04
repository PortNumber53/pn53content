<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/19/12 12:22 AM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

?>

<br /><br /><br />
<div class="navbar navbar-inverse navbar-fixed-bottom">
	<div class="navbar-inner">
		<a class="brand" href="#">Title</a>
		<ul class="nav">
			<li class="active"><a href="#">Home</a></li>
			<li><a href="<?php echo Url::site( Route::get('backend-actions')->uri(array('controller'=>'gallery', 'action'=>'dashboard',)), TRUE ); ?>">Dashboard</a></li>
			<li><a href="<?php echo Url::site( Route::get('backend-actions')->uri(array('controller'=>'gallery', 'action'=>'upload',)), TRUE ); ?>">Upload</a></li>
			<li><a href="<?php echo Url::site( Route::get('backend-actions')->uri(array('controller'=>'gallery', 'action'=>'tagger',)), TRUE ); ?>">Manage Tags</a></li>
			<li>
				<form class="navbar-search pull-left">
					<input type="text" class="search-query" placeholder="Search">
				</form>
			</li>
		</ul>
	</div>
</div>