<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 9/19/12 12:18 AM
 * Package: Package_Name
 */

?><!DOCTYPE html>
	<meta charset="UTF-8">
	<title>[default]<?php echo $site_settings['site_name']; ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
	body {
		padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
	}
</style>
<link href="<?php echo URL::site('/media/library/bootstrap/css/bootstrap.css', TRUE); ?>" rel="stylesheet">
<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL; ?>
<link href="<?php echo URL::site('/media/library/bootstrap/css/bootstrap-responsive.css', TRUE); ?>" rel="stylesheet">

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

<script src="<?php echo URL::site('/media/library/js/jquery.js', TRUE); ?>"></script>
<script src="<?php echo URL::site('/media/library/js/jquery.form.js', TRUE); ?>"></script>
<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL; ?>
<script src="<?php echo URL::site('/media/library/bootstrap/js/bootstrap.js', TRUE); ?>"></script>

<?php
foreach ($meta as $key=>$value)
{
?>
<meta property="<?php echo $key; ?>" content="<?php echo $value; ?>" />
<?php
}
?>
</head>


<body>

<?php echo View::factory($main)->render(); ?>

<?php echo View::factory('modules/backend/footer')->render(); ?>

<?php
echo View::factory('modules/debug')->render();
?>
</body>
</html>