<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/19/12 12:28 AM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

?>


<div class="container-fluid">
	<div class="row-fluid">
		<div class="span9">

			<h1>Start Tagging</h1>

			<ul class="dashboard-image">
				<?php
				foreach ($image_list as $image_item)
				{
					//echo"pre>";print_r($image_item);echo"</pre>";
					?>
					<li data-original-name="<?php echo $image_item['original_name']; ?>" data-tags="<?php echo $image_item['tags']; ?>" data-stats="image-statsimage-stats">
						<?php echo $image_item['original_name']; ?><br />
						<div class="image">
							<img data-source="<?php echo Url::site(Route::get('dynimage')->uri(array('path'=>substr($image_item['_id'], 0, 66), 'format'=>$image_item['format'], )), TRUE); ?>" />
						</div>
					</li>
					<?php
				}
				?>
			</ul>

		</div>


		<div class="span3 bs-docs-sidebar">

			<div class="row">
				<div class="span12" id="control-panel">

					<ul class="nav nav-list bs-docs-sidenav affix">
						<li>
							<input type="button" name="btnaction" id="unselect-all" value="Unselect All" class="btn" />
						</li>
						<li><a href="#gridSystem"><i class="icon-chevron-right"></i> Tags</a>
							<div id="image-tags" />
						</li>
					</ul>

				</div>
				<div class="row">

				</div>

			</div>
		</div>




		<script>

			$(document).ready(function() {
				$("ul.dashboard-image").on("click", "li", function() {
					//$(this).parent().children().removeClass("active");
					$(this).addClass("active");

					var tags = '<p>These are the current tags:<br />'+$(this).data('tags') + '</p>';
					$("#image-tags").html(tags);

				})

				$("#control-panel").on("click", "#unselect-all", function() {
					$("ul.dashboard-image").children().removeClass("active");
				});
			})


		</script>