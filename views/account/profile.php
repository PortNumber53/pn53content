<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 5/12/13
 * Time: 4:54 AM
 *
 */
 
?>

<h1>Profile</h1>


<form class="form-horizontal">
	<div class="control-group">
		<label class="control-label" for="inputEmail">Email</label>
		<div class="controls">
			<input type="text" id="inputEmail" placeholder="Email">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputPassword">Password</label>
		<div class="controls">
			<input type="password" id="inputPassword" placeholder="Password">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<input type="checkbox"> Remember me
			</label>
			<button type="submit" class="btn">Update Profile</button>
		</div>
	</div>
</form>