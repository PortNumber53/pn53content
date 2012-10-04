<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/22/12 12:52 AM
 * Package: Package_Name
 * Description: something meaningful about the file
 */
?>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="span9">
			<h1>New Images</h1>
			<ul class="dashboard-image">
				<?php
				foreach ($image_list as $image_item)
				{
					$tags = implode(',', $image_item['tags']);
					?>
					<li data-id="<?php echo $image_item['_id']; ?>" data-original-name="<?php echo $image_item['original_name']; ?>" data-tags="<?php echo $tags; ?>" data-stats="image-statsimage-stats">
						<?php echo $image_item['original_name']; ?><br />
						<div class="image">
							<img src="<?php echo Url::site(Route::get('dynimage')->uri(array('path'=>substr($image_item['_id'], 0, 66), 'format'=>$image_item['format'], 'width'=>420, 'height'=>315)), TRUE); ?>" />
						</div>
					</li>
					<?php
				}
				?>
			</ul>
		</div>

		<div class="span3 bs-docs-sidebar">
			<div class="row">
				<div class="span12">
					<ul class="nav nav-list bs-docs-sidenav affix" id="control-panel">
						<li class="active"><a href="#global"><i class="icon-chevron-right"></i> Image Info</a>
							<div id="image-info" />
						</li>
						<li><a href="#gridSystem"><i class="icon-chevron-right"></i> Tags</a>
							<div id="image-tags" />
						</li>
						<li><a href="#fluidGridSystem"><i class="icon-chevron-right"></i> Stats</a>
							<div id="image-stats" />
						</li>
					</ul>

				</div>
			<div class="row">
		</div>

	</div>
</div>

<script>
var _id = '';
var ItemList = undefined;

$(document).ready(function() {
	$("ul.dashboard-image").on("click", "li", function() {
		$(this).parent().children().removeClass("active");
		$(this).addClass("active");

		ItemList = $(this);
		_id = $(this).data("id");

		var html = '<p>Information about the picture:<br />'+$(this).data('original-name') + '</p>';
		$("#image-info").html(html);

		var html = '';
		var tmp_tags = $(this).data('tags').split(',');
		for (i=0; i<tmp_tags.length; i++ ) {
			html = html + '<input type="button" value="'+tmp_tags[i]+'" class="btn btn-info edit-tag" /> ';
		}

		var tags = '<p>These are the current tags:<br />'+html+'</p>';
		tags = tags + '<input type="text" id="new-tag" placeholder="+ New Tag" class="input-large" />';
		$("#image-tags").html(tags);
		var stats = '<ul><li>visits:</li><li>likes:</li></ul>';
		$("#image-stats").html(stats);
	})

	$("#control-panel").on("keypress", "#new-tag", function(event) {

		if ( event.which == 13 ) {
			event.preventDefault();

			var This = this;
			var new_tag = $(this).val()+"";
			var old_tag = $(this).data('old-tag');
			$(This).val('');

			if (new_tag != "") {
				$.post('<?php echo Url::base(); ?>service/tag/add',
						{
							_id: _id,
							new_tag: new_tag,
							old_tag: old_tag
						},
						function(response) {
							if (response.error == 0) {
								//alert($("ul.dashboard-image > li[data-id='"+_id+"']").html());
								//alert($("ul.dashboard-image > li[data-id='"+_id+"']").data('tags'));
								$("ul.dashboard-image > li[data-id='"+_id+"']").data('tags', response.return_tags).click();
								//$(ItemList).data('tags', response.return_tags);
								//alert($("ul.dashboard-image > li[data-id='"+_id+"']").data('tags'));
								$(This).val('').click().focus();
							} else {
								alert(response.message);
								$(This).val(new_tag);
							}
						},
						'json'
				);
			}
		}
	}).on("click", ".edit-tag", function (event) {
		var This = this;
		var current_tag = $(this).val()+"";

		if (event.ctrlKey) {
			console.log('Control key pressed, delete TAG!');
			$.post('<?php echo Url::base(); ?>service/tag/remove',
					{
						_id: _id,
						delete_tag: current_tag
					},
					function(response) {
						if (response.error == 0) {
							$("ul.dashboard-image > li[data-id='"+_id+"']").data('tags', response.return_tags).click();
						}
					},
					'json'
			);
		} else {
			console.log( $(this).val());
			$("#new-tag").data('old-tag', $(this).val()).val($(this).val());
		}
	});
})

</script>