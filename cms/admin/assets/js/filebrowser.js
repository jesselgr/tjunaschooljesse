

var $filebrower = $('#filebrowser');
var ACFB = {
	construct : function()
	{
		$('#uploadForm').hide();
		$filebrower.on('click','.file .jsDeleteFile', ACFB.delete_file);
		$filebrower.on('click','.file .jsRenameFile', ACFB.rename_file.begin);
		$('.toggleUploadForm').click(function(e)
		{
			e.preventDefault();
			if(ACFB.form.is_open)
			{
				$('#uploadForm').stop().slideUp('fast');
				ACFB.form.close();
			}else{
				$('#uploadForm').stop().slideDown('fast');
				ACFB.form.open();
			}
		});

		$( "#category-form" ).dialog({
		autoOpen	: false,
		height		: 300,
		width		: 350,
		modal		: true,
		buttons: [
		{
			text 	: "add category",
			class 	: "buttonContent",
			click 	: function() {
			var data = {
				'title'					:	$('#category_name').val(),
				'parent_file_category_id'	:	$('#parent_category_id').val()
			};
			$.post('filebrowser/insert_category', data, function(){
				
				// var $newLi = $('<li')
				// $('#nav-cat-'+parent_category_id).append($newLi);
				$( "#category-form" ).dialog( "close" );
				location.reload();
			});
			}
		}],
		Cancel: function() {
				$( this ).dialog( "close" );
		}
		
		});
	 
		$( ".createCategory" ).click(function() {
			$( "#category-form" ).dialog( "open" );
		});
	},
	destruct : function()
	{
		$('.toggleUploadForm').unbind('click');
		if(ACFB.select.is_bound) ACFB.select.unbind();
		if(ACFB.form.is_open) ACFB.form.close();
	},
	select : {
		is_bound	:	false,
		bind		:	function(callback)
		{
			$filebrower.find(".file" ).click(function(e)
			{
				e.preventDefault();
				callback($(this).data('id'), $(this).data('filename'));
			});
			ACFB.select.is_bound = true;
		},
		unbind		: function()
		{
			$filebrower.find(".file").unbind('click');
			ACFB.select.is_bound = false;
		}
	},
	rename_file : {

		begin : function(e)
		{
			var $label	= $(e.target);
			var $file	= $label.parent();

			var text 	= $label.text();
			var $input 	= $('<input value="'+text+'"/>');
			
			$label.replaceWith($input);

			$input.focus();

			$input.blur(ACFB.rename_file.end);

		},
		end : function(e)
		{
			var $input	= $(this),
				$labelTemplate = $('<span class="jsRenameFile fileLabel"></span>');
			var value	= $input.val()
				$label  = $labelTemplate,
				$file 	= $input.parent();

			$label.text(value);
			$input.off('blur');
			$input.replaceWith($label);

			var file_id = $file.attr('data-id');

			$.post(cdi_url+'file/update/'+file_id, {title : value}, function(){
				$label.animate({'border': 'solid 1px green'}, 1000,function(){});
			});
		}
	},
	delete_file : function(e)
	{
		e.preventDefault();
		$file = $(this).parent();
		var file_id = $file.attr('data-id');

		if(confirm('delete this file?'))
		{
			$.ajax({
				datatype: 'json',
				url		: cdi_url+'file/delete/'+file_id,
				success : function(url, data, success)
				{
					$file.fadeOut();
				}
			});

			
		}
	},
	form	:	{
		is_open : false,
		open	: function()
		{
			ACFB.form.is_open	= true;
			var formData 		= {},
			$latestAdded 		= null;
			$("#addFile").uploadify({
				'buttonText'	: '+ Upload',
				'fileSizeLimit' : upload_max,
				'buttonClass'	: 'buttonContent small',

				'uploadLimit' 	: 0,
				'auto'     		: true,
				'width'    		: 70,
				'button_height'	: 50,
				'button_width'	: 120,
				'queueSizeLimit': 20,
				'swf'           : site_url + 'assets/js/libs/uploadify/uploadify.swf',
				'uploader'      : cdi_url + 'file/upload', 
				'onUploadStart' : function(file) 
				{
					var object = ACFB.form.set_uploadify_form_vars();
					
					var $fileLi = $('<li class="file"><span class="jsRenameFile fileLabel">'+file.name+'</span></li>');
					var $target_category_list = $('#files_'+object.file_category_id).find('ul');

					$fileLi.startLoadingAnim();
					$fileLi.appendTo($target_category_list);

					ACFB.$last_added_file = $fileLi;
				},
				'onUploadSuccess' : function(file,data, response) 
				{
					var data 		= 	$.parseJSON(data);
					var $img 		= 	$('<img src="'+cdi_url + 'graphic/getImage/' + data.file_id+'"/>');
						$delButton 	= 	$('<a href="#" class="file_delete jsDeleteFile">&#10006;</a>');
					
					var $latestAdded = ACFB.$last_added_file;
			
					$latestAdded.append($img);
					$latestAdded
						.append($delButton)
						.attr('data-id',data.file_id)
						.attr('id', 'file_' + data.file_id)
						.stopLoadingAnim(); 
				},
				'onUploadError' : function(file, errorCode, errorMsg, errorString) 
				{
					alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
				}
			});
		},
		set_uploadify_form_vars : function()
		{
			var object = {};
			$('#uploadForm').find(':input').each(function(i, item){
				object[$(item).attr('name')] = $(item).val();
			}) ; 
			$("#addFile").uploadify("settings", 'formData', object );
			return object;
		},
		close : function()
		{
			$("#addFile").uploadify('destroy');
			ACFB.form.is_open = false;
		}

	},
	$last_added_file  : null,
}

// $( "#filebrowser" ).startLoadingAnim();
$(function() {
	var $nav = $('.cat_nav ul');
	$nav.menu({
		'select' : function( event, ui ) {	
			$('.filesList').fadeOut(100).promise().done(function(){
				$(ui.item.find('a').attr('href')).fadeIn(200);

			});
			
		}
	});
	
	// $('.filesList').hide();
});

ACFB.construct();

if(ckeditor.enabled)
{
	ACFB.select.bind(function(file_id, filename)
	{
		switch(ckeditor.type)
		{
			case 'image':
				var file_url = cdi_url + 'graphic/getImage/' + file_id;		
				break;
			default:
				var file_url = cdi_url + '/files/' + filename;		
			break;
		}
		 
		 window.opener.CKEDITOR.tools.callFunction( ckeditor.functionNr, file_url );
		 window.close();
	});
}