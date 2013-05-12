<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 9/15/12 5:14 PM
 * Package: Package_Name
 */

?>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="<?php echo URL::Site(Route::get('default')->uri(array('controller'=>'content', 'action'=>'view',)), TRUE); ?>">Project name</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li><a href="#">Home</a></li>
					<li><a href="#contact">Contact</a></li>
					<li class="active"><a href="<?php echo URL::Site(Route::get('default')->uri(array('controller'=>'gallery', 'action'=>'browse',)), TRUE); ?>">Gallery</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</div>