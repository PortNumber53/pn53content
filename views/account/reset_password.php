<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 5/12/13
 * Time: 4:54 AM
 *
 */
 ?>

 <h1>Reset Password</h1>

<form class="form-horizontal">
	<div class="control-group">
		<label class="control-label" for="inputEmail">Email</label>
		<div class="controls">
			<input type="text" id="inputEmail" placeholder="Email">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputPassword">Captcha?</label>
		<div class="controls">
			<input type="password" id="inputPassword" placeholder="Password">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">reset password</button>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<a href="<?php echo Route::get('user-actions')->uri(array('action' => 'login',),TRUE); ?>">Oh wait! I remember my password now!</a>
		</div>
	</div></form>