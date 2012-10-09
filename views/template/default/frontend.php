<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/15/12 2:29 PM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

?><!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--><html class="no-js" lang="<?php echo I18n::$lang; ?>" xml:lang="<?php echo I18n::$lang; ?>">
<head>
	<meta charset="UTF-8">
	<title>[default]<?php echo $site_settings['site_name']; ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	    body {
	        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
	    }
	</style>
	<link href="<?php echo Url::site('/media/library/bootstrap/css/bootstrap.css', TRUE); ?>" rel="stylesheet">
	<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL; ?>
	<link href="<?php echo Url::site('/media/library/bootstrap/css/bootstrap-responsive.css', TRUE); ?>" rel="stylesheet">

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="../assets/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">

	<script src="<?php echo Url::site('/media/library/js/jquery.js', TRUE); ?>"></script>
	<script src="<?php echo Url::site('/media/library/js/jquery.form.js', TRUE); ?>"></script>
	<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL; ?>
	<script src="<?php echo Url::site('/media/library/bootstrap/js/bootstrap.js', TRUE); ?>"></script>

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
	<?php echo View::factory('modules/analytics/google')->render(); ?>
</head>

<body>
<?php echo View::factory('modules/header')->render(); ?>

<div class="container">

    <section>
		<?php echo View::factory('modules/breadcrumb')->render(); ?>
    </section>

    <section>
		<?php
		echo View::factory($main)->render();
		?>
    </section>

</div> <!-- /container -->

<hr />

<?php echo View::factory('modules/footer')->render(); ?>

<?php
echo View::factory('modules/debug')->render();
?>

</body>

</html>