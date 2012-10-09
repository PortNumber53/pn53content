<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 10/8/12 12:05 AM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.sitemaps.org/schemas/sitemap-image/1.1"
        xmlns:video="http://www.sitemaps.org/schemas/sitemap-video/1.1">
	<url>
		<loc>http://truvis.co/privacy-policy.html</loc>
	</url>
	<?php
	foreach ($url_array as $url)
	{
		?>
		<url>
			<loc><?php echo Url::site($url, true); ?></loc>
		</url>
	<?php
	}
	?>
</urlset>