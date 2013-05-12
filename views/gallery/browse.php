<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 10/5/12 11:24 PM
 * Package: Package_Name
 */

?>

<div class="container-fluid">
	<div class="row-fluid">
		<h1>New Images</h1>
		<ul class="dashboard-image">
			<?php
			foreach ($image_list as $image_item)
			{
				$tags = implode(',', $image_item['tags']);
				?>
				<li data-id="<?php echo $image_item['_id']; ?>" data-original-name="<?php echo $image_item['original_name']; ?>" data-tags="<?php echo $tags; ?>" data-stats="image-statsimage-stats">
					<div class="image">
						<a href="" title="<?php echo $image_item['original_name']; ?>">
						<img src="<?php echo Url::site(Route::get('dynimage')->uri(array(
							'path'=>substr($image_item['_id'], 0, 66),
							'format'=>$image_item['format'],
							'width'=>Arr::path($site_settings, 'template.backend.gallery.thumbnail.width'),
							'height'=>Arr::path($site_settings, 'template.backend.gallery.thumbnail.height'),
						), TRUE)); ?>" />
						</a>
					</div>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
</div>