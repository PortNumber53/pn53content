<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 9/15/12 2:29 PM
 * Package: PN53Content sample frontend template
 */

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php echo I18n::$lang; ?>" xml:lang="<?php echo I18n::$lang; ?>"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="<?php echo I18n::$lang; ?>" xml:lang="<?php echo I18n::$lang; ?>"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="<?php echo I18n::$lang; ?>" xml:lang="<?php echo I18n::$lang; ?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo I18n::$lang; ?>" xml:lang="<?php echo I18n::$lang; ?>"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo empty($page_title) ? '' : "$page_title - "; ?><?php echo $site_settings['site_name']; ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL; ?>

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->


	<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL; ?>
	<?php
	foreach ($meta as $key=>$value)
	{
		?>
		<meta property="<?php echo $key; ?>" content="<?php echo $value; ?>" />
	<?php
	}

	foreach (View::$_global_data['og:tags'] as $tag=>$value)
	{
		?>
		<meta property="<?php echo $tag; ?>" content="<?php echo $value; ?>" />
	<?php
	}
	?>


</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<?php echo View::factory('modules/header')->render(); ?>



<!-- Add your site or application content here -->
<?php echo View::factory($main)->render(); ?>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>




<?php echo View::factory('modules/analytics/google')->render(); ?>
</body>
</html></html>