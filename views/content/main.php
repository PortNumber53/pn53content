<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 9/15/12 5:10 PM
 * Package: Package_Name
 */

//View::add_global('og:tags', 'og:type', $content_data['type']);
View::add_global('og:tags', 'og:url', Url::site($content_data['url'], TRUE));
//View::add_global('og:tags', 'og:type', $content_data['type']);

if (!empty($content_data['sections'][0]['image']))
{
	View::add_global('og:tags', 'og:image', Url::site($content_data['sections'][0]['image']));
}
else
{
	View::add_global('og:tags', 'og:image', Url::site('/no_image.jpg', TRUE));
}

if (!empty($content_data['open_graph']) && is_array($content_data['open_graph']))
{
	foreach ($content_data['open_graph'] as $og_item)
	{
		list($tag, $value) = explode("=", $og_item);
		View::set_global('og:'.$tag, $value);
	}
}

?>
<h1><?php echo $content_data['title']; ?></h1>

<?php
if ( ! empty($content_data['description']))
{
?>
	<div class="main-content"><?php echo $content_data['description']; ?></div>
<?php
}
?>

<?php
if ( ! empty($content_data['sections']))
{
	foreach ($content_data['sections'] as $section)
	{
		?><h2><?php echo $section['title']; ?></h2>
	<div><?php echo $section['content']; ?></div>
	<?php
	}
}
else
{
	if (is_string($content_data['content']))
	{
		echo $content_data['content'];
	}
}




echo "<pre>";var_dump($content_data);echo"</pre>";