var lineup;
$(function() {
$( ".order_reset" ).hide();
    lineup =sortabe_to_array();
    
    	//activate sortable on draglist
        $(".dragList").nestedSortable({
         
            forcePlaceholderSize: true,
            items: 'li',
            autoscroll: 'true',
            placeholder: 'placeholder',
            tolerance: 'pointer',
            disableNesting: 'no-nest',
            hoverclass: 'droppable',
            toleranceElement: '> div',
             helperclass: 'helper',
             delay: 100
          });
    
      
    $( ".order_reset" ).click(function(event, ui){
    	if(confirmSubmit('reset?')){
			$(".dragList").sortable( "cancel" );
			update_list();
			show_ui_message('Volgorde teruggezet');
    	 }
    	 
    	 $( ".order_reset" ).fadeOut(300);
    });
    
        
    // as soon as a page is dragged, initiate a function
   	  var list = $(".dragList").serialize();
    $( ".dragList" ).disableSelection();
  
    
    
    
    
    $( ".dragList" ).bind( "sortstop", function(event, ui){
           update_list();
           $( ".order_reset" ).fadeIn(300);
    }); 
 });
 
 
 
function update_list(){
   counter = 1;
   // call sortable_to_array to convert the html elements to php vars
    pages = sortabe_to_array();
    
    // assign new positions
    items = reorder(pages, lineup);
    
    // save new pos values to the html elements
    set_html(items);
	 
     $.post(page_sort_url, {items: items}, function(data) {


        $(".dragList").children().each(function(){
            $(this).attr('data-sort-order', counter);
            counter++;
        });
       
     });
     show_ui_message('Volgorde opgeslagen');


}


 //convert the list to a workable array
function sortabe_to_array(){
    var listArray = new Array();
    
    array = set_children(".dragList",listArray);
    return array;
}

// recursive function to fill array with .dragList ' li ' elements  //
function set_children(parent, listArray){

    $(parent).children().each(function(){
        
        // declaration //
        var data_item;
        var parentPage;
        var $child = $(this);
        
        
        // determine parent //
        parentPage = (parent=='.dragList')? $(".dragList").attr("id") : $(this).parent().parent().attr('id');
        
        
        // add to arrays //
        data_item = {
            page_id         : $child.attr('id'),
            nav_prio        : $child.attr('data-sort-order'),
            parent_page_id  : parentPage
        };
        listArray.push(data_item);
        
        // recurse //
        // !!bug here: finds all children list items, should only find first. Non-fatal //
        if($child.find('li'))
        {
            listArray= set_children($child.find('ol'), listArray); // damn kids..
        }
    });
    return listArray;
}

// reorder pages  //
function reorder(items, olditems){
    
    for(i=0;  i<items.length; i++){
        items[i].nav_prio = i+1;
    }
    
    return items;
    
}

function set_html(items){
  for(i=0;  i<items.length; i++){
 	
 	$('.dragList').find('#'+items[i][0]).attr('data-sort-order',items[i][1]);
 	
  }
}