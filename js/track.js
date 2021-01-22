'use strict';

$(document).ready(function(){

    const user_id = $('#hidden-access-id').val();

   
    list_tracks(0)

    $('#track-prev-btn').on('click', function(){
        var offset = $(this).attr('page-id')
        list_tracks(offset)
        offset = -- offset
        $(this).attr('page-id', offset)
        offset = ++ offset
        offset = ++ offset
        $('#track-next-btn').attr('page-id', offset)
        if($(this).attr('page-id') == -1){
          $(this).attr('disabled', true)
        }
    })
    $('#track-next-btn').on('click', function(){
        var offset = $(this).attr('page-id')
        list_tracks(offset)
        offset = ++ offset
        $(this).attr('page-id', offset)
        $('#track-prev-btn').attr('page-id', offset -2)
        $('#track-prev-btn').attr('disabled', false)
        

    })

    $('#search-track-form').on('submit', function(e){
        e.preventDefault()
        const searched = $('#search-input-track').val();
       
        list_searched_tracks(searched);
    });

    $(document).on("click", ".trigger-btn",function(e){
        const track_id = $(this).attr("data-id");
        const type = $(this).attr("class").slice(12);
        if(type == 'add-track'){
            $('#add-track-modal').show();
            get_genre(0);
            get_media(0)
        }else if(type == 'read-track'){
            $('#read-track-modal').show();
            get_track(track_id, 'read')
        }else if (type == 'edit-track'){
            $('#update-track-modal').show();
            get_track(track_id, 'update')
        }else if (type == 'delete-track'){
            if(confirm('Are you sure that you want to delete this track?')){
                $(this).parent().parent().remove();
                delete_track(track_id);
            }
        }
    })

    $('.close-read-track-modal').click(function(){
        $('#read-track-modal').hide();
   });
    $('.close-add-track-modal').click(function(){
        $('#add-track-modal').hide();
   });

    $('.close-update-track-modal').click(function(){
        $('#update-track-modal').hide();
   });

   $('#update-track-form').on('submit', function(){
       update_track($('#update-track-id').val(), $('#update-track-name').val(),$('#update-track-album-id').val(),$('#update-media-id option:selected').val(),$('#update-genre-id option:selected').val(),$('#update-composer').val(),$('#update-time').val(),$('#update-bytes').val(),$('#update-price').val());
   })

    $('#add-track-form').on('submit', function(){
        create_track($('#add-track-name').val(),$('#add-track-album-id').val(), $('#add-track-media-id option:selected').val() ,$('#add-track-genre-id option:selected').val(),$('#add-track-composer').val(),$('#add-track-time').val(),$('#add-track-bytes').val(),$('#add-track-price').val());
    })

});



function list_tracks(offset){
    $.ajax({
        // url: `./api/v1/track?offset=${offset}`,
        // url: `../api/index.php/v1/track?offset=${offset}`,
        url: `./api/v1/track?offset=${offset}`,
        type: 'GET',
        success: function(tracks){
            if(tracks.length < 30){
                $('#track-next-btn').attr('disabled', true)
            }else{
                $('#track-next-btn').attr('disabled', false)
            }
            if(tracks){
                display_tracks(tracks, 'searched-tracks')
            }
        }
    });
}
function list_searched_tracks(searched){
    $.ajax({
        url: `./api/v1/track?name=${searched}`,
        type: 'GET',
        success: function(tracks){
            if(tracks){
                display_tracks(tracks, 'searched-tracks')
            }
        }
    });
}

function get_track(track_id, type){
    $.ajax({
        url: `./api/v1/track/${track_id}`,
        type: 'GET',
        success: function(data){
            if(data){
                if(type == 'read'){
                    $('#read-title').text(data.Track)
                    $('#read-artist').text(data.Artist)
                    $('#read-album').text(data.Album)
                    $('#read-composer').text(data.Composer)
                    $('#read-genre').text(data.Genre)
                }else if(type == 'update'){
                    $('#update-track-id').val(track_id);
                    $('#update-track-name').val(data.Track);
                    $('#update-composer').val(data.Composer);
                    $('#update-time').val(data.Milliseconds);
                    $('#update-price').val(data.UnitPrice);
                    $('#update-bytes').val(data.Bytes);
                    $('#update-track-album-id').val(data.AlbumId);
                    get_genre(data.GenreId)
                    get_media(data.MediaTypeId)
                }
             
            }
      
        }
    });
}
function create_track(name, album_id, media_type_id, genre_id, composer, time, bytes, price){
    $.ajax({
        url: `./api/v1/track?name=${name}&albumId=${album_id}&mediaType=${media_type_id}&genreId=${genre_id}&composer=${composer}&time=${time}&bytes=${bytes}&price=${price}`,
        type: 'POST',
        success: function(data){
            if(data){
                alert('Track with the id: '+data+' has been created!');
            }
        }
    });
}
function update_track(track_id, name, album_id, media_type_id, genre_id, composer, time, bytes, price){
    $.ajax({
        url: `./api/v1/track/${track_id}?name=${name}&albumId=${album_id}&mediaType=${media_type_id}&genreId=${genre_id}&composer=${composer}&time=${time}&bytes=${bytes}&price=${price}`,
        type: 'PUT',
        success: function(data){
            if(data){
                alert('Track with the id: '+track_id+' has been updated!');
            }
        }
    });
}
function delete_track(track_id){
    $.ajax({
        url: `./api/v1/track/${track_id}`,
        type: 'DELETE',
        success: function(data){
            if(data){
                alert('Track has been deleted!')
            }
      
        }
    });
}

function display_tracks(tracks, section_id){
    const user_id = $('#hidden-access-id').val();
    if(tracks.length === 0){
        $('section#'+section_id).html('No tracks was found!');
    }else{
        $('section#'+section_id).empty();

        const table = $("<table/>");
        const head = $("<thead/>");
        const head_row = $("<tr/>");

        if(user_id != 'admin'){
            head_row.
            append($("<th/>").text( "Track Name")).
            append($("<th/>").text( "Artist Name")).
            append($("<th/>").text( "Album Title")).
            append($("<th/>").text( "Price")).
            append($("<th/>").text( "Quantaty"))
            head.append(head_row);
            table.append(head);
        }else{
            head_row.
            append($("<th/>").text("Track ID")).
            append($("<th/>").text("Track Name")).
            append($("<th/>").text("Album Title")).
            append($("<th/>").text("Read")).
            append($("<th/>").text("Edit")).
            append($("<th/>").text("Delete"))
            head.append(head_row);
            table.append(head);

        }
        const body = $("<tbody />");
        for(const track of tracks){
    
            const body_row= $('<tr></tr>');
            const id = track['TrackId'];


            if(user_id != 'admin'){
                body_row.
                append($('<td></td>').text(track['Track']  )).
                append($('<td></td>').text(track['Artist'] )).
                append($('<td></td>').text(track['Album']) ).
                append($('<td></td>').text(track['UnitPrice'] )).
                append($('<td></td>').html(`<form method="POST" class="add-to-cart-form">
                <input type="text" class="quantity" name="quantity" value="1">
                <input type="hidden" name="hidden-name" value="`+escape_string(track['Track']) +`">
                <input type="hidden" name="hidden-price" value="`+escape_string(track['UnitPrice']) +`">
                <input type="hidden" name="hidden-id" value="`+escape_string(id) +`"> 
                <br><input type="submit" class="cart-add-btn" name="add-cart-item" value="Add to cart">
            </form>`).addClass('trigger'))
            }else{
                body_row.
                append($('<td></td>').text(id)).
                append($('<td></td>').text(track['Track'] )).
                append($('<td></td>').text(track['Album']) ).
                append($('<td></td>').html(`<svg width='30px' height='30px' class='trigger-btn read-track' data-id='${id}' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' color='#fff'><path fill='none' d='M0 0h24v24H0z'></path><path d='M13 7h9v2h-9zm0 8h9v2h-9zm3-4h6v2h-6zm-3 1L8 7v4H2v2h6v4z'></path></svg>`).addClass('trigger')).
                append($('<td></td>').html(`<svg width="24" height="24" class='trigger-btn edit-track' data-id='${id}' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" color="#fff"><path d="M0 0h24v24H0z" fill="none"></path><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 000-1.41l-2.34-2.34a.996.996 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>`).addClass('trigger')).
                append($('<td></td>').html(`<svg width="24" height="24"  class='trigger-btn delete-track' data-id='${id}' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" color="#fff"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>`).addClass('trigger'))
        
    
            }
           
            body.append(body_row);}
            table.append(body);
        table.appendTo($('section#'+section_id));
    }

}