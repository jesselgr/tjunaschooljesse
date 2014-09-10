<html>
	<head>
		<link rel="stylesheet" href="<?= base_url()?>ac/css/setup.css?v=2">
		<link rel="stylesheet" href="<?= base_url()?>ac/css/admin.css">
		<script src="<?=base_url()?>ac/js/libs/jquery-1.5.1.min.js"></script>
		<style>
		.item:hover{
			background: #ddd;
			position: relative;
		}
		
		</style>
	</head>
	<body>
	<script>
	
$(document).ready(function() {
  $('tr').bind('click', function(event) {
   var target 		= window.opener.document.getElementById('content'); 
   
   target.value		= $(this).find('.<?=$type?>').text(); 
   
   <?if(isset($extra)){?>
   var target_name 	= window.opener.document.getElementById('content_title'); 
   target_name.value= $(this).find('.<?=$extra?>').text();
   <?}?>
   window.close(); 

  });
});

</script>
<section class="contentMain">
<h3>Klik hieronder op een rij</h3>
</section>
<?$switch='odd';?>
<section class="contentSection">	
		<table class="contentMain">
		
		<? foreach($data as $row){
			echo' <tr class="'.$switch.'  item">';
			foreach($row as $key =>$value){
			$class= $key;
			
				echo'<td class="'.$class.'" title="'.$class.'">'; 
				echo $value.'</td>';
			}
			
			
			echo'</tr>';
		
		if($switch=='even'){$switch='odd';}else{$switch='even';}
		}?>
		</table>
				</section> 
	</body>
</html>