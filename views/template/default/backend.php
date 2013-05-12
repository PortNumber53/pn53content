<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="canonical" href="<?php echo empty($canonical_url) ? URL::site('/', TRUE) : str_replace('/.html', '/', $canonical_url); ?>" />
	<title><?php echo empty($page_title)? '' : "$page_title - "; ?><?php echo $site_settings['site_name']; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="<?php echo Url::site('/library/bootstrap/css/bootstrap.css', TRUE); ?>" rel="stylesheet">
	<?php foreach ($styles as $file => $type) echo HTML::style($file, array('media' => $type)), PHP_EOL; ?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->


	<?php foreach ($scripts as $file) echo HTML::script($file), PHP_EOL; ?>
</head>
<body id="backend">
<?php echo View::factory('modules/backend/header')->render(); ?>



<section>
	<?php
	echo empty($main) ? '{no $main content}' : $main;
	?>
</section>


<?php
echo View::factory('modules/debug')->render();
?>

</body>
</html>