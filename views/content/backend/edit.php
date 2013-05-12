<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User: mauricio
 * Date: 9/15/12 5:22 PM
 * Package: Package_Name
 */

?>
<form class="form-horizontal" method="post" action="">
	<ul class="nav nav-tabs">
		<li><a href="#tab-general" data-toggle="tab">General</a></li>
		<li><a href="#tab-seo" data-toggle="tab">SEO</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab-general">

			<div class="control-group">
				<label class="control-label" for="inputTitle">Title</label>
				<div class="controls">
					<input type="text" id="inputTitle" placeholder="Title" class="input-xxlarge" data-bind="value: title"><br />
					<span class="text-info" data-bind="text: seo_url" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputUrl">URL</label>
				<div class="controls">
					<div class="input-prepend input-append">
						<span class="add-on">/</span>
						<input type="text" id="inputUrl" placeholder="URL" class="input-xxlarge" data-bind="value: url">
						<button class="btn" type="button">Go!</button>
					</div>
					<label class="checkbox">
						<input type="checkbox" id="manualURL" data-bind="checked: manual_url">
						Set URL manually (do not include a starting slash)
					</label>
				</div>

			</div>


			<div class="control-group">
				<label class="control-label" for="inputContent">Content</label>
				<div class="controls">
					<textarea id="inputContent" placeholder="Content goes here..." class="input-xxlarge" data-bind="ckeditor: content"></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputTag" class="input-xxlarge">Tags</label>
				<div class="controls">
					<input type="text" id="inputTag" placeholder="tags" data-bind="value: tag">
				</div>
			</div>
		</div><!-- #tab-general -->
		<div class="tab-pane" id="tab-seo">...</div><!-- #tab-seo -->
	</div>

	<button type="submit" id="btn_save" class="btn" data-bind='click: save, enable: title.length !="title"'>Save</button>
</form>



<script>

	//This is the viewmodel
	function AppViewModel() {
		self = this;

		self.content_id = ko.observable(<?php echo empty($content_data['content_id']) ? 0 : $content_data['content_id']; ?>);
		self.title = ko.observable('<?php echo empty($content_data['title']) ? '' : $content_data['title']; ?>');
		self.url = ko.observable('<?php echo empty($content_data['url']) ? '' : $content_data['url']; ?>');
		self.content = ko.observable('<?php echo empty($content_data['content']) ? '' : str_replace("\n", "", $content_data['content']); ?>');
		self.tag = ko.observable('<?php echo empty($content_data['tag']) ? '' : $content_data['tag']; ?>');
		self.manual_url = ko.observable('<?php echo empty($content_data['manual_url']) ? false : $content_data['manual_url']; ?>');

		self.seo_url = ko.computed(function() {
			if (self.manual_url()) {
				return '/' + self.url();
			} else {
				return '/'+self.content_id() + "-" + self.url();
			}
		}, this);


		self.load = function(data) {
			var self = this;
			self.content_id(data.content_id);
			self.title(data.title);
			self.url(data.url);
			self.content(data.content);
			self.tag(data.tag);
		};

		self.save = function() {
			//self.lastSavedJson(JSON.stringify(ko.toJS(self), null, 2));
			//console.log(ko.toJSON(self));
			$.ajax({
				type: "POST",
				url: "/service/content/save",
				data: {
					json: ko.toJSON(self)
				},
				success: function(result) {
					if (result.data) {
						self.load(result.data);
					}
					if (result.content_id) { self.content_id = result.content_id; }
					if (result.title) { self.title(result.title); }
					if (result.url) { self.url = result.url; }
					if (result.content) { self.content = result.content; }
					if (result.tag) { self.tag = result.tag; }
					console.log(result);
				},
				dataType: "json"
			});
		};

		//self.lastSavedJson = ko.observable("");
	}

	// Activates knockout.js
	ko.bindingHandlers.ckeditor = {
		init: function (element, valueAccessor, allBindingsAccessor, context) {
			var options = allBindingsAccessor().ckeditorOptions || {};
			var modelValue = valueAccessor();
			var value = ko.utils.unwrapObservable(valueAccessor());

			$(element).html(value);
			//$(element).ckeditor();
			CKEDITOR.replace( element );

			//var editor = $(element).ckeditorGet();
			//CKEDITOR.instances.element.getData()
			//CKEDITOR.instances.editor1.on("blur", function (e) {
			//	alert($(this).getData());
			//});

			//handle edits made in the editor

			CKEDITOR.instances.inputContent.on('blur', function (e) {
				var self = this;
				//console.log('quase');
				//console.log(CKEDITOR.instances.inputContent2.getData());
				if (ko.isWriteableObservable(self)) {
					self(CKEDITOR.instances.inputContent.getData());
				}
			}, modelValue, element);
		},
		//update the control when the view model changes
		update: function(element, valueAccessor) {
			var value = ko.utils.unwrapObservable(valueAccessor());
			CKEDITOR.instances.inputContent.setData( value );
		}

	};


	ko.applyBindings(new AppViewModel());



	$(document).ready(function() {
		var config = {
			skin:'v2',
			toolbar:
				[
					['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
					['UIColor']
				],
			height: 400
		};

		//$('.jquery_ckeditor').ckeditor(config);

	});
</script>
