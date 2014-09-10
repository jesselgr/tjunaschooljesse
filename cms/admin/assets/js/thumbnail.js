/* set thumb path */
destination_path 	= '/assets/uploads/files/resized/';
/* image file name */
no_select_text 		= 	"Je moet eerst een selectie maken voordat je kan opslaan";

x1 = 5;
y1 = 5;

$(function(){
	
	// zodra afbeelding crop is gekozen met deze functie: submit thumb
	/*
	*     submit thumb cropper
	*/
	$("#thumb_submit").click(function(e) {
		e.preventDefault();
		
		if( x2=="" || y2==""){  
	          alert(no_select_text);  
	    }else{  
	          submit_thumb(); 
	    } 
		
	});
});

/* initialize image cropper on lightbox */
function initialize_cropper(element, settings){
	str = element.content;
	host = document.location.hostname;
	url = str.replace("http://"+host+"/","");
	id  = element.link.id;
	
	var image 	= $('#sb-player');
	
	if(url.charAt(0) == "/") url = url.substr(1);
	$('#image').val(url);
	file 	= url.substr(url.lastIndexOf('/')+1);
	n 		= file.lastIndexOf(".");
	ext 	= file.substr(n +1);
	name 	= url;
	file_name = file.substr(0, n);
	trueWidth = image.naturalWidth();
	trueHeight = image.naturalHeight();
	resizeWidth = settings.resizeWidth;
	resizeHeight = settings.resizeHeight;

	$('img#sb-player').imgAreaSelect({
	    handles: true,
	    persistent :true,
	    zIndex: 9999,
	    resizable : true,
		minWidth: settings.minWidth,
		minHeight: settings.minHeight,
		imageWidth: trueWidth,
		imageHeight: trueHeight,
		resize: false,
	    aspectRatio: settings.aspectRatio,
	    fadeSpeed : 200,
	    x1: 5, y1: 5, x2: settings.minWidth, y2: settings.minHeight,
	    parent: '#sb-container',
	    onSelectChange: function (img, selection) {
			if(isNaN(selection.width)){ 
				alert('Note: the image is too small to edit.');
			}else{
				$('#save_crop').show(); 
			};
	    },
		onSelectEnd: function (img, selection) {
	        x1 = selection.x1;
	        y1 = selection.y1;
	        x2 = selection.x2;
	        y2 = selection.y2;      
	    },
//    onSelectChange: update_preview  
	});
}

/* lightbox: submit thumb coordinates */

function submit_thumb(){
	data = new Object();
	data.x1 	= x1;
	data.y1 	= y1;
	data.x2 	= x2;
	data.y2 	= y2;
	data.file 	= file_name;
	data.path 	= name.replace(file,'');
	data.destination_path = destination_path;
	data.ext  	= ext;
	data.resizeWidth = resizeWidth;
	data.resizeHeight = resizeHeight;
	$.ajax({
	  type: 'POST',
	  url: site_url + 'thumbnail/create_by_post/',
	  data: data,
	  success: function(data){
	  	if(data == 'success');
	  		update_thumb_image(data);
		 }
	});
}


/* add image to the form */
function update_thumb_image(data){
	inputId = id.replace("preview-", "");
	Shadowbox.close();
	
	Shadowbox.clearCache();
	Shadowbox.setup('a[rel]');
	
	var n 	= data.lastIndexOf(".");
	var file_name = data.substr(0, n);
	data = file_name + '.jpg';
	
	$('#image-'+id).attr('src', data);
	$('#image-'+id).parent().attr('href', data);
	$('#'+inputId).val(data);
	
	closeImgAreaSelect(inputId);
}

// update preview window, used by imgareaselect in lightbox 
//function update_preview(img, selection) {
//
//	img_width  = img.width;
//	img_height = img.height;
//	
//    var scaleX = 100 / (selection.width || 1);
//    var scaleY = 100 / (selection.height || 1);
//
//    $('#preview').css({
//        width: Math.round(scaleX * img_width) + 'px',
//        height: Math.round(scaleY * img_height) + 'px',
//        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
//        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
//    });
//}