'use strict';

$(document).ready(function(){
    list_artists(0)
    $('#prev-btn').on('click', function(){
        var offset = $(this).attr('page-id')
        list_artists(offset)
        offset = -- offset
        $(this).attr('page-id', offset)
        offset = ++ offset
        offset = ++ offset
        $('#next-btn').attr('page-id', offset)
        if($(this).attr('page-id') == -1){
          $(this).attr('disabled', true)
        }



    })
    $('#next-btn').on('click', function(){
        var offset = $(this).attr('page-id')
        list_artists(offset)
        offset = ++ offset
        $(this).attr('page-id', offset)
        $('#prev-btn').attr('page-id', offset -2)
        $('#prev-btn').attr('disabled', false)
       

    })

    $('#search-artist-form').on('submit', function(e){
        e.preventDefault()
        const searched = $('#search-input-artist').val();

        list_searched_artists(searched);
    });

    $(document).on("click", "svg.trigger-btn",function(e){
        const artist_id = $(this).attr("data-id");
        const type = $(this).attr("class").slice(12);
     
        if(type == 'add-artist'){
            $('#add-artist-modal').show();
        }else if(type == 'read-artist'){
            $('#read-artist-modal').show();
            get_artist(artist_id, 'read')
        }else if (type == 'edit-artist'){
            $('#update-artist-modal').show();
            get_artist(artist_id, 'update')
        }else if (type == 'delete-artist'){
            if(confirm('Are you sure that you want to delete this artist?')){
                $(this).parent().parent().remove();
                delete_artist(artist_id);
            }
        }
    })

    $('.close-read-artist-modal').click(function(){
        $('#read-artist-modal').hide();
   });
    $('.close-add-artist-modal').click(function(){
        $('#add-artist-modal').hide();
   });

    $('.close-update-artist-modal').click(function(){
        $('#update-artist-modal').hide();
   });
   $('#update-artist-form').on('submit', function(){
        update_artist($('#update-artist-id').val(), $('#update-artist-name').val());
    })
   $('#add-artist-form').on('submit', function(){
        create_artist($('#add-artist-name').val());
    })

   

});

function list_artists(offset){
    $.ajax({
        // url: `./api/v1/artist?offset=${offset}`,
        url: `./api/v1/artist?offset=${offset}`,
        type: 'GET',
        success: function(artists){
            if(artists.length < 30){
                $('#next-btn').attr('disabled', true)
            }else{
                $('#next-btn').attr('disabled', false)
            }
            if(artists){
                display_artists(artists, 'searched-artist')
            }
        }
    });
}
function list_searched_artists(searched){
    $.ajax({
        url: `./api/v1/artist?name=${searched}`,
        type: 'GET',
        success: function(artists){

            console.log(artists)
            if(artists){
                display_artists(artists, 'searched-artist')
            }
        }
    });
}
function get_artist(artist_id, type){
    $.ajax({
        url: `./api/v1/artist/${artist_id}`,
        type: 'GET',
        success: function(artists){
            if(artists){
                if(type == 'read'){
                    $('#read-artist-name').text(artists.Name)
                }else if(type == 'update'){
                    $('#update-artist-id').val(artist_id);
                    $('#update-artist-name').val(artists.Name); 
                } 
            }
        }
    });
}

function create_artist(name){
    $.ajax({
        url: `./api/v1/artist?name=${name}`,
        type: 'POST',
        success: function(data){
            if(data){
                alert('Artis with the id: '+data+' has been created!')
            }
        }
    });
}
function update_artist(artist_id, name){
    $.ajax({
        url: `./api/v1/artist/${artist_id}?name=${name}`,
        type: 'PUT',
        success: function(data){
            if(data){
                alert('Artist with the id: '+artist_id+' has been updated!')
            }
        }
    });
}
function delete_artist(artist_id){
    $.ajax({
        url: `./api/v1/artist/${artist_id}`,
        type: 'DELETE',
        success: function(data){
            if(data){
                alert('Track has been deleted!')
            }
      
        }
    });
}
function display_artists(artists, section_id){
    const user_id = $('#hidden-access-id').val();
    
    if(artists.length === 0){
        $('section#'+section_id).html('No Artist was found!');
    }else{
        $('section#'+section_id).empty();

        const table = $("<table/>");
        const head = $("<thead/>");
        const head_row = $("<tr/>");

        if(user_id != 'admin'){
       
            head_row.
            append($("<th/>").text( "Artist Name"))
            head.append(head_row);
            table.append(head);
        }else{
        
            head_row.
            append($("<th/>").text("Artist ID")).
            append($("<th/>").text("Artist Name")).
            append($("<th/>").text("Read")).
            append($("<th/>").text("Edit")).
            append($("<th/>").text("Delete"))
            head.append(head_row);
            table.append(head);

        }
        const body = $("<tbody />");
        for(const artist of artists){
    
            const body_row= $('<tr></tr>');
            const id = artist['ArtistId'];


            if(user_id != 'admin'){
               
                body_row.
                append($('<td></td>').text( artist['Name'] ))
            }else {
                
                body_row.
                append($('<td></td>').text(id)).
                append($('<td></td>').text( artist['Name'] )).
                append($('<td></td>').html(`<svg width='30px' height='30px' class='trigger-btn read-artist' data-id='${id}' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' color='#fff'><path fill='none' d='M0 0h24v24H0z'></path><path d='M13 7h9v2h-9zm0 8h9v2h-9zm3-4h6v2h-6zm-3 1L8 7v4H2v2h6v4z'></path></svg>`).addClass('trigger')).
                append($('<td></td>').html(`<svg width="24" height="24" class='trigger-btn edit-artist' data-id='${id}' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" color="#fff"><path d="M0 0h24v24H0z" fill="none"></path><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 000-1.41l-2.34-2.34a.996.996 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>`).addClass('trigger')).
                append($('<td></td>').html(`<svg width="24" height="24"  class='trigger-btn delete-artist' data-id='${id}' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" color="#fff"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>`).addClass('trigger'))
        
    
            }
           
            body.append(body_row);}
            table.append(body);
        table.appendTo($('section#'+section_id));
    }

}