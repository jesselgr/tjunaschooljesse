{literal}
<style>
		#ac_debug_panel{
			position: fixed; 
			height: 100%; width: 20%;
			z-index: 1000;
			right: 0; top: 0; 
/*			background-color: rgba(255,255,255,0.4); */
/*			border: 1px solid #aaa; */
			opacity: 0.2;
			overflow: hidden;
			font-size:11px;
			
			cursor: pointer;

		}
		#ac_debug_panel:hover{
			opacity: 0.8;
		}
		
		#ac_debug_panel.open{
			opacity:1;
			box-shadow: -2px 2px 5px rgba(0,0,0, 0.4);
			overflow: scroll; 

		}

		
		#ac_debug_title{
			position: fixed;
			margin: 0;
			text-align: center;
			background: url("{/literal}{base_url()}{literal}/assets/img/ac/debug.png");
			display: block;
			color: #fff;
			right: 0;
			height: 50px; width:90px;
			line-height: 10px;
			font-family: arial;
			text-align: center;
			border: 1px solid #333;
			box-shadow: 0px 0px 5px rgba(0,0,0,0.4);
		}
		
	
		
		#ac_debug_assigned_vars h3{
			padding: 0;
			margin: 0;
			font-family: arial;
			color: #24A0B1	;
			font-weight: normal;
			
			padding-bottom: 2px;
			margin-bottom: 5px;
			border-bottom: dotted 2px #ccc;
		}
		#ac_debug_assigned_vars pre{
		 	margin: 0;
		}
		
		#ac_debug_assigned_vars div{
			background: rgba(245,245,250,0.9);
		}
		#ac_debug_assigned_vars div.odd{
			background: rgba(250,250,255,0.9);
		}
		
		#ac_debug_assigned_vars div{
			overflow: hidden;
			padding: 15px;
			border-bottom: 1px solid #ddd;
			-webkit-transition: .2s ease-in-out 0s;
			
		}
		#ac_debug_assigned_vars div:hover{
			padding-left:  25px;
			-webkit-transition: .2s ease-in-out 0s;
			
		}
			#ac_debug_assigned_vars div:hover h3{
				-webkit-transition: .2s ease-in-out 0s;
			}
		#ac_debug_panel.open #ac_debug_assigned_vars div{
			overflow: auto !important;
		}
		#ac_debug_assigned_vars  .ac_deb_array h3{
		 	cursor: pointer;
		 	color: #5ae;
		 	font-style:italic;
			text-decoration: underline;
		}
	</style>
	{/literal}
	
<div id="ac_debug_panel">
	
	<div id="ac_debug_title">
		<h2>DEBUG</h2>
		<small>(click me)</small>
	</div>
	<div>
		{debug}
	</div>
</div>
<script src="{base_url()}/assets/js/ac/mousetrap.min.js" type="text/javascript"></script></script>
<script>
{literal}
$(function()
{
	$('#ac_debug_assigned_vars').hide();
	
	Mousetrap.bind(['command+f','ctrl+f'], function() {
	
		$('.ac_deb_array pre').show();
	});
	Mousetrap.bind(['command+b','ctrl+b'], function() {
		$('.ac_deb_array pre').hide();
	});
	
	console.log('test');
	$('#ac_debug_title').click(function(){ 
		$('#ac_debug_assigned_vars').fadeToggle(300); 
		$('#ac_debug_panel').toggleClass('open');
	});
//	$('#ac_debug_assigned_vars div pre').hide().click(this.toggle);
	$('.ac_deb_array pre').hide().parent().click(function(){$(this).find('pre').toggle();});
});
</script>
{/literal}
