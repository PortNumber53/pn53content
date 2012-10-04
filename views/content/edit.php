<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: mauricio
 * Date: 9/15/12 5:22 PM
 * Package: Package_Name
 * Description: something meaningful about the file
 */

?>
<div class="container">
    <div class="row">
        <div class="span12">

            <form class="form-horizontal" id="form_content" method="post" action="<?php echo Url::site( Route::get('content-stuff')->uri(array('action'=>'edit', 'request'=>'/new_content',)), TRUE); ?>">
                <fieldset>
                    <legend><?php echo __("Edit Content"); ?></legend>

                    <div class="control-group">
                        <label class="control-label" for="_id"><?php echo __("Url"); ?></label>
                        <div class="controls">
                            <input type="text" class="input-block-level" name="_id" id="_id" placeholder="<?php echo __("a valid URL"); ?>" value="<?php echo empty($content_data['_id']) ? '' : $content_data['_id']; ?>" />
                            <span class="help-inline">Please correct the error</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="title"><?php echo __("Title"); ?></label>
                        <div class="controls">
                            <input type="text" class="input-block-level" name="title" id="title" placeholder="<?php echo __("A good title"); ?>" value="<?php echo empty($content_data['title']) ? '' : $content_data['title']; ?>" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="description"><?php echo __("Description"); ?></label>
                        <div class="controls">
                            <textarea rows="3" name="description" id="description" class="input-block-level" placeholder="<?php echo __("Describe to people what this is about..."); ?>"><?php echo empty($content_data['description']) ? '' : $content_data['description']; ?></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="keywords"><?php echo __("Keywords"); ?></label>
                        <div class="controls">
                            <input type="text" class="input-block-level" name="keywords" id="keywords" placeholder="<?php echo __("Keywords"); ?>" value="<?php echo empty($content_data['keywords']) ? '' : $content_data['keywords']; ?>" />
                        </div>
                    </div>

                    <div class="control-group" id="sections">
                    </div>

                    <div class="form-actions" style="position: fixed; bottom: 0px">
                        <button class="btn" type="submit" id="btn_add_new_section">Add new section</button>
                        <button class="btn btn-primary" type="submit">Save changes</button>
                        <button class="btn">Cancel</button>
                    </div>

                </fieldset>
            </form>

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div id="dropbox">
            <div class="span12">
                <span class="message">Drop images here to upload. <br /></span>
            </div>
        </div>
    </div>
</div>

<script>


function build_template(id, section_title, section_content, section_image) {

    return '<div class="row">'+
            '<div class="span9">'+
            '<div class="control-group">'+
            '<label class="control-label" for="section_title_'+id+'"><?php echo __("Section Title"); ?></label>'+
            '<div class="controls">'+
            '<input type="text" class="input-block-level" name="section_title[]" id="section_title_'+id+'" placeholder="<?php echo __("A good title"); ?>" value="'+section_title+'" />'+
            '</div>'+
            '</div>'+

            '<div class="control-group">'+
            '<label class="control-label" for="section_content_'+id+'"><?php echo __("Content"); ?></label>'+
            '<div class="controls">'+
            '<textarea cols="60" rows="14" name="section_content[]" id="section_content_'+id+'" class="input-block-level jquery_ckeditor" placeholder="<?php echo __("Good content goes here"); ?>">'+section_content+'</textarea>'+
            '</div>'+
            '</div>'+

            '</div>'+

            '<div class="span3">'+
            '<a class="thumbnail" href="#" id="section_image">'+
            '<img alt="" src="http://placehold.it/360x268" id="thumbnail_'+id+'" style="max-height: 385px" class="dropbox" data-id="0">'+
            '</a>'+
            '<br />'+
            '<input type="text" class="input-block-level" name="image_path[]" id="image_path_'+id+'" placeholder="<?php echo __("Image path"); ?>" value="'+section_image+'" />'+
            '<br />'+
            '<br />'+
            '<button name="upload_'+id+'" id="upload_'+id+'" class="btn btn-success"><i class="icon-white icon-upload"></i> Drop Image Here</button>'+
            '<br />'+
            '<br />'+
            '<button name="remove_setion_'+id+'" id="remove_section_'+id+'" class="btn btn-danger remove-action"><i class="icon-white icon-remove"></i> Remove Section</button>'+
            '</div>'+
            '</div>';
}







function form_validate() {
    var data = $('#form_content').serializeObject();
    console.log('validating: '+data._id);
    var url = "<?php echo Url::site( Route::get('content-stuff')->uri(array('request'=>$param['request'],'action'=>'save',)), TRUE); ?>";
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: submit_ok,
        dataType: "json"
    });
    return false;
}

function submit_ok(data)
{
    alert(data.message);
}





function bind_filedrop(Element) {
    $("#"+Element).filedrop({
        // The name of the $_FILES entry:
        paramname:'image',

        maxfiles: 1,
        maxfilesize: 2,
        url: '<?php echo Url::site( Route::get('image-handler')->uri(array('action'=>'upload')),TRUE); ?>',

        uploadFinished:function(i,file,dropbox){
            $.data(file).addClass('done');
            // response is the JSON object that post_file.php returns
        },

        error: function(err, file) {
            switch(err) {
                case 'BrowserNotSupported':
                    showMessage('Your browser does not support HTML5 file uploads!');
                    break;
                case 'TooManyFiles':
                    alert('Too many files! Please select 5 at most! (configurable)');
                    break;
                case 'FileTooLarge':
                    alert(file.name+' is too large! Please upload files up to 2mb (configurable).');
                    break;
                default:
                    break;
            }
        },

        // Called before each upload is started
        beforeEach: function(file){
            if(!file.type.match(/^image\//)){
                alert('Only images are allowed!');

                // Returning false will cause the
                // file to be rejected
                return false;
            }
        },

        uploadStarted:function(i, file, len){
            createImage(file);
        },

        progressUpdated: function(i, file, progress) {

            $.data(file).find('.progress').width(progress);
        }

    });
};

$(document).ready(function() {


    <!------------------ -->
<?php
$max = count($content_data['sections']);
for ($counter = 0; $counter < $max; $counter++)
{
	$section = $content_data['sections'][$counter];
	?>
    $("#sections").append( build_template(<?php echo $counter; ?>, '<?php echo $section['title']; ?>', '<?php echo str_replace("\r", '', str_replace("\n", '', $section['content'])); ?>', '<?php echo $section['image']; ?>') );
    bind_filedrop("thumbnail_<?php echo $counter; ?>");
	<?php
}
echo "number_of_sections = $counter;\n";

?>



    //var dropbox = $('.dropbox');
    ////message = $('.message', dropbox);
    //;

    $("#form_content").submit(function()
    {
        return form_validate();
    });


    var config = {
        skin:'v2',
        toolbar:
                [
                    ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
                    ['UIColor']
                ],
        height: 400
    };

    $('.jquery_ckeditor').ckeditor(config);


    $(".content_type").change(function () {
        var selected = $(this).val();

        if (selected == 'image') {

        }
    });


    $("#_id").blur(function() {

    });

    $("#btn_add_new_section").live('click', function() {
        number_of_sections++;
        $("#sections").append( build_template(number_of_sections, '', '', '') );
        $('#section_content_' + number_of_sections + '').ckeditor(config);

        return false;
    });

    $('.remove-action').live('click', function() {
        var section_row = $(this).parent().parent();
        $(section_row).remove();
    });



    var template = '<div class="preview">'+
            '<span class="imageHolder">'+
            '<img />'+
            '<span class="uploaded"></span>'+
            '</span>'+
            '<div class="progressHolder">'+
            '<div class="progress"></div>'+
            '</div>'+
            '</div>';


    function createImage(file){

        var preview = $(template),
                image = $('img', preview);

        var reader = new FileReader();

        image.width = 100;
        image.height = 100;

        reader.onload = function(e){

            // e.target.result holds the DataURL which
            // can be used as a source of the image:
            image.attr('src',e.target.result);
            //var id=$(e).data("id");
            $("#thumbnail_0").attr("src", e.target.result);
        };

        // Reading the file as a DataURL. When finished,
        // this will trigger the onload function above:
        reader.readAsDataURL(file);

        message.hide();
        //preview.appendTo(dropbox);

        // Associating a preview container
        // with the file, using jQuery's $.data():

        $.data(file,preview);
    }

    function showMessage(msg){
        message.html(msg);
    }






})
</script>



<?php
echo "Content Data<pre>";var_dump($content_data);echo"</pre>";
