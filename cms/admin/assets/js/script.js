
var currentMenu = null

//General functions

$('select').select2();
  /*
	  * Sidebar menus
	  * Slidetoggle for menu list
	  *
 */  


ACSideNav = {
	element : $('#sidebar'),
	current : null,
	init  	: function()
	{
		ACSideNav.set();
		ACSideNav.bindClick();
	},
	set 	: function()
	{
		ACSideNav.element.find('ul>li.submenu>a').each(function()
		{
				
			if(!$(this).parent().hasClass('current'))
			{
				$(this).next().hide();
			}else{
				ACSideNav.current = $(this); 
			}
		   
		});
	},
	bindClick : function()
	{
		var currentMenu = ACSideNav.current;
		ACSideNav.element.find('ul>li.submenu>a').click(function()
		{
			$('#sidebar>ul>li.current').removeClass('current'); 
			if(currentMenu != null && currentMenu.text() != $(this).text()){
				currentMenu.parent().find('ul:first').slideUp(); 
				
			}
			if(currentMenu != null && currentMenu.text() == $(this).text()){
				currentMenu.parent().find('ul:first').slideUp(); 
				currentMenu = null;
			}else{
				currentMenu = $(this);
				
				currentMenu.parent().addClass('current');
				currentMenu.parent().find('ul:first').slideDown(); 
			}
			return false;
		}); 
	}
}		
   


var dialogForm = {
	element : false,
	create 	: function ($link)
	{
		var url 		= 	$link.attr('href');

		if($('.dialogForm').length > 0)
		{
			var $dialog = dialogForm.element;
			$dialog
				.startLoadingAnim(true)
				.load(url, function()
				{
					$dialog.stopLoadingAnim(true);
					assign_selects($dialog);
				})
				.dialog({'title' : $link.attr('title')});
		}else{
			var $dialog 	=  new ACDialog(url).create({
				modal		: 	false,
				autoOpen	: 	true,
				title		: 	$link.attr('title'),
				position	: 	{ my: "right top", at: "right top", of: 'body', collission: 'fit' },
				draggable	: 	false,
				resizable	: 	false,
				dialogClass	: 	'dialogBox dialogForm',
				height		:	$(window).height()-10,
				width		:	750,
				buttons		:	[ 
					{ 
						text	: langLabels.save, 
						click	: function(){$( this ).find('form').submit();},  
						class 	: "buttonContent "  
					},{ 
						text	: langLabels.cancel, 
						click	: function() { $( this ).dialog( "close" ); }, 
						class 	: "buttonContent grey "  
					} 
				],
				beforeClose	: 	function()
				{
					return confirm(langLabels.cancelConfirm);
				}
			});

			$dialog
			.parent().css({position:"fixed",'top':0});
			dialogForm.element = $dialog;
			dialogForm.addSubmitListener();
		}
	},
	addSubmitListener : function ()
	{
		dialogForm.element.on('submit','form',function(e)
		{
			e.preventDefault(); // prevent event
			var formDataString = $(this).serialize();
		
			for ( var instanceName in CKEDITOR.instances )
			{
				var textData = CKEDITOR.instances[instanceName].getData();
				formDataString+='&'+encodeURIComponent(instanceName)+'='+encodeURIComponent(textData);
			}
			
			$.ajax({
				url		:	$(this).attr('action'),
				data	:	formDataString,
				type 	:	"POST",
				statusCode	: {
					404 : function(result) {
					  alert("page not found");
					},
					400	: function(result){
						show_ui_error(result.responseText);
						console.log(result);
					},
					201 : function(result){
						show_ui_message(result, function(){
							location.reload(true);
						});
						 dialogForm.element.dialog({beforeClose:null});
						 dialogForm.element.dialog( "close" );
						 
						
					},
					200 : function(result){
						dialogForm.element.html(result);
					},
					500 : function(result){
						show_ui_error('an error occured!');
						alert(result);

					}
				}
			});
			return false;
		});
	},
	removeSubmitListener : function()
	{
		$('body').off('submit','.ui-dialog form');
	}
}

/** AC file manager **/
/* file ref object */
var file_ref = {
	bind_file_buttons : function()
	{
		$('.ac').on('click', '.buttonFile',function(e)
		{
			e.preventDefault();
			var filePicker = new file_ref.ACFBpicker($(this)).open();
		});
	},
	ACFBpicker : function($button)
	{
			var url 		= 	site_url+'filebrowser?standalone=1',
			$dialog		= 	null,
			button 		= 	button,
			type;

			if(type = $button.data('type'))
				url+='&type='+type;
			if($('#'+$button.data('target')).val())
				url+='&file_id='+ $('#'+$button.data('target')).val();		

		this.open 		=	function()
		{


			//create dialog
			$dialog 	=  	new ACDialog(url).create({
				'title' 	: 	'Files', 
				'modal'		: 	true,
				width		:	800,
				close 		: 	this.close,
				beforeClose	: 	function(){},
				open		:	function(){
					$(this).startLoadingAnim();

					$(this).load(url, function()
					{
						ACFB.select.bind(function(file_id)
						{
							
							file_ref.update_file_ref($button, file_id)
							$dialog.dialog('close');
						});
					});
				}
			});
		};

		this.close 		= 	function()
		{
			ACFB.destruct();
			$dialog.dialog( "destroy" ).remove();
		};
	},
	update_file_ref : function($button, file_id){
		var $input 		= 	$('#' + $button.attr('data-target')),
			$preview 	= 	$('#' + $button.attr('data-preview'));


		var suffix		=	'';
		if($button.attr('data-natural')) 	suffix +='/1';
		if($button.attr('data-preset'))		suffix += '?preset='+$button.attr('data-preset');


		
		$input.attr('value',file_id);
		$preview.attr('src', cdi_url + 'graphic/getImage/'+file_id+'/'+suffix);
			
	}
}

/** AC dialog **/
var ACDialogInstances = new Array();
var ACDialog = function(url)
{
	// create dialog html element / url variables
	var $dialog 	=  	$('<div class="ac_dialog"></div>'),
		dialog_url 	= 	url;
	var instance 	= 	this;
	this.element = $dialog;	
	// set default options
	this.options = {
		modal		: 	false,
		autoOpen	: 	true,
		draggable	: 	false,
		resizable	: 	false,
		show		: 	"fade",
		hide		: 	"fade",
		height		:	400,
		width		:	600,
		dialogClass	: 	'dialogBox',
		beforeClose	: 	function()
		{
			var shouldClose = confirm(langLabels.cancelConfirm)
			if(shouldClose)
			{
				for ( var instanceName in CKEDITOR.instances )
				{
					CKEDITOR.instances.instanceName.destroy();
				}
				return shouldClose;
			}
		},
		close		: 	function(){
				$( ".ui-tabs" ).tabs( "destroy" );
				$dialog.dialog( "destroy" ).remove();	

				
		},
		open		:	function(){
			$dialog.find("input, a, button").blur();
			instance.fillByLoad(dialog_url);
			
		}
	};

	this.fillByLoad = function(url)
	{
		this.element
			.startLoadingAnim()
			.load(url,function()
			{
				assign_selects($dialog);
			});
	}

	this.create = function (user_options)
	{
		var options = this.options;
		for (var attrname in user_options) 
		{ 
			options[attrname] = user_options[attrname]; 
		}
	
		$dialog.dialog(options);
		this.element = $dialog;			
		ACDialogInstances.push(this);

		return $dialog;
	};

	this.close = function()
	{
		this.element.dialog({beforeClose:null});
		this.element.dialog('close');
	};
}


function show_ui_message(message,callback)
{
	if(!callback) callback = null;
	$msgBox = $('.changeMessage');
	if(message) $msgBox.text(message);
	
	$msgBox.fadeIn().delay(1000).fadeOut('fast', callback);   
}
function show_ui_error(message)
{
	$msgBox = $('.errorMessage');
	if(message) $msgBox.text(message);
	
	$msgBox.fadeIn().delay(1000).fadeOut();   
}

/* global yes/no feedback function */
function confirmSubmit(message)
{
	return confirm(message);
}


function urlEncode(text)
{
	var removeChars = /[^\w\s]/ig,
			 spaceChars = /[\s]/ig;
	if(text) text = text.toLowerCase().replace(removeChars, '').replace(spaceChars, '-');
	return text;
}


file_ref.bind_file_buttons();
ACSideNav.init();
$.ajaxSetup({
  cache: false
});




// confirm submission
$('.confirmSubmit').click(function(e)
{
	if(!confirmSubmit($(this).attr('data-confirm')))
	{
		e.preventDefault();
	}
});


$('.hoverLight').hover(function()
{
	$(this).stop(true, true).switchClass('', 'highlight', 300);
},
function()
{
	$(this).stop(true, true).switchClass('highlight', '', 300);	
});	



if($('.dateTimePicker').length){
	$( ".dateTimePicker" ).datetimepicker(
	{
		dateFormat: 'yy-mm-dd',
		timeFormat: 'hh:mm:ss',
		regional : 'en'
	});
}
if($('.datepicker').length){
	$( ".datePicker" ).datepicker(
	{
		dateFormat: 'yy-mm-dd',
		timeFormat: 'hh:mm:ss',
		showButtonPanel: true,
		regional : 'en'
	});
};
if($('.yearPicker').length){
	$( ".yearPicker" ).datepicker(
	{
		dateFormat: 'yy-mm-dd',
		timeFormat: 'hh:mm:ss',
		changeYear: true,
		changeMonth: true,
		yearRange: "1500:+0",
		regional : 'en'
	});
}

if($('a[rel]').length){
	Shadowbox.init();
}
 
		

if($('.jsDialogLink').length > 0)
{
	$('.jsDialogLink').click(function(e)
	{
		e.preventDefault();
		dialogForm.create($(this));
		$("html, body").animate({ scrollTop: "0px" });
		return false;
	});
}
function getImgSize(imgSrc, callback) {
    var newImg = new Image();

    newImg.onload = callback(newImg);

    newImg.src = imgSrc; // this must be done AFTER setting onload
}

function assign_selects($parent)
{
	$('.datePicker').datepicker({dateFormat: 'yy-mm-dd'});
	$parent.find('select').not('.ui-toggle-switch').each(function(i,item)
	{
		console.log(i);
		var id = $(this).attr('id');
		if(!id) 
		{
			id = 'select_'+i;
			$(this).attr('id',id);
		}

		$('#'+id).select2({'width':200});
	});
}



//$('.sidebarContainer').height($('body').height() );
	