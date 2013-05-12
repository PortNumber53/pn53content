<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 5/12/13
 * Time: 4:43 AM
 *
 */
 
 ?>

<h1>Log in</h1>

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
			<button type="submit" class="btn">Sign in</button>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<label class="checkbox">
				<a href="<?php echo Route::get('user-actions')->uri(array('action' => 'reset_password',),TRUE); ?>">Forgot your password?</a>
			</label>
			<button type="submit" class="btn">Sign in</button>
		</div>
	</div>
</form>

