$(document).ready(function() {
    $('a.window').click(function() {
        $('body').append('<div id="mask"></div>');
        $('#mask').fadeIn(300);
        $("#login_form").show();
    });
        $('a.close').click(function() {
        $("#login_form").hide(600);
        $('#mask').hide();
 
    });
    // haal formulier op als javascript element
    
    var logform = $('#logform');
    var count = 0;


    $('#logform').on('submit', function(event){

        
        var logform = $(this);
        var action = logform.attr('action');
        var form_data = logform.serialize();
        
        event.preventDefault();

        $.ajax(
        {
            type    : 'post',
            url     : action,
            data    : form_data,
            dataType: 'json',
            success  : function(data)
            {
                var validator = data.success;
                if(validator)
                {
                    location.reload();
                }
                else {
                
                var error = $("<p id='error'>Fout bij inloggen, probeer opnieuw!</p>");
               
                 
                if (count === 0){
                    error.appendTo(logform);
                    count = 1;
                }

                }
            }
            
        }).fail(function() {
        alert('Fail!');
    });
        // doe ajax post call naar action attribuut van het formulier

    });
    // sla het action attribuut van het formulier op
    var comments = $('#comments');
    var formpie = $('#formpie');


    // van het submit evenement af van het formulier
    formpie.submit(function( event ) {
        
        var action = formpie.attr('action');
        var form_data = formpie.serialize();
      
        event.preventDefault();

        // doe ajax post call naar action attribuut van het formulier
        $.ajax(
        {
            type    : 'post',
            url     : action,
            data    : form_data,
            dataType: 'json',
            success  : function(data)
            {
            
                // html veranderen..
                var block = $("<div class='commentblock' id='"+data.id+"'></div>");
                var title = $("<h2>"+data.author+"</h2>");
                var body = $("<p>"+data.body+"</p>");
                var user = $("<p>"+'Geschreven door: '+data.user+"</p>");
                var button2 = $("<button class='edit' id='"+data.id+"'>Aanpassen</button>");
                var button = $("<button class='delete' id='"+data.id+"'>Verwijder</button><hr>");
                var end = $();
                // html element maken voor comment

                block.appendTo(comments);
                title.appendTo(block);
                body.appendTo(block);
                user.appendTo(block);
                button2.appendTo(block);
                button.appendTo(block);
                document.getElementById("formpie").reset();
                

            }
        }
        );
    });
    
    // delete comments
    $('#comments').on('click', ".delete", function(){
        var del_id = $(this).attr('id');
        
        $.ajax({
            
            type:'post',
            url: base_url + 'blog/comment_delete/',
            data:'delete_id='+del_id,
            dataType : 'json',
            
            success:function(data) {
                if(data) {
                    $('#'+del_id).hide('slow');
                }
                else { // DO SOMETHING 
                }
            }
        });
    });

    // edit comments
     $('#comments').on('click', ".edit", function(){
        var edit_id = $(this).attr('id');
        var text = $('#'+edit_id+' p').first().text();

        $('#'+edit_id+'.edit').hide();
        $('#'+edit_id+'.commentblock').append('<div id="textedit">\
            <h3>Pas hier uw reactie aan</h3>\
            <form id="editform" class="editform" action="'+base_url+'blog/comment_edit" method="post">\
            <p><textarea name="edit_body" rows ="10">'+text+'</textarea></p>\
            <p><input type="submit" value="Pas aan"/><p/>\
            <input type="hidden" name="id" value="'+edit_id+'">\
            </form>\
            <hr></div>');
    });

    

    // van het submit evenement af van het formulier
    $('#comments').on('submit', ".editform", function(event){
        

        var editform = $(this);
        var action = editform.attr('action');
        var form_data = editform.serialize();
        
        event.preventDefault();
        // doe ajax post call naar action attribuut van het formulier
        $.ajax(
            {
                type    : 'post',
                url     : action,
                data    : form_data,
                dataType: 'json',
                success  : function(data)
                    {
                    var id = data.id;
                    var body = data.message;
                    // html veranderen..
                    var comment = $('#'+id);
                    comment.find('p').first().html(body);

                // html element maken voor comment

            }
        }
        );

        $("#textedit").hide(600);
    });

    var postform = $('#postform');
    var post = $('#post');
    var postmessage = $('.postmessage');

    postform.submit(function( event ) {
        
        var action = postform.attr('action');
        var form_data = postform.serialize();
        
        event.preventDefault();
        
        $.ajax(
        {
            type    : 'post',
            url     : action,
            data    : form_data,
            dataType: 'json',
            success  : function(data)
            {
                // html veranderen..
                var block = $("<div class='postmessage' id='"+data.id+"'></div>");
                var title = $("<h2>"+data.title+"</h2>");
                var body = $("<p>"+data.body+"</p>");
                var user = $("<p>"+'Geschreven door: '+data.user+"</p>");
                var reactie = $("<a href="+base_url+"blog/comments/"+data.id+">Reacties</a><hr>");
                var end = $();
                // html element maken voor comment

                block.appendTo(post);
                title.appendTo(block);
                body.appendTo(block);
                user.appendTo(block);
                reactie.appendTo(block);
                document.getElementById("postform").reset();
                

            }
        }
        );
    });
    
  



});

