'use strict';

$(document).ready(function(){

    list_albums(0);

    $('#album-prev-btn').on('click', function(){
        var offset = $(this).attr('page-id')
        list_albums(offset)
        offset = -- offset
        $(this).attr('page-id', offset)
        offset = ++ offset
        offset = ++ offset
        $('#album-next-btn').attr('page-id', offset)
        if($(this).attr('page-id') == -1){
          $(this).attr('disabled', true)
        }



    })
    $('#album-next-btn').on('click', function(){
        var offset = $(this).attr('page-id')
        list_albums(offset)
        offset = ++ offset
        $(this).attr('page-id', offset)
        $('#album-prev-btn').attr('page-id', offset -2)
        $('#album-prev-btn').attr('disabled', false)
        

    })

    $('.close-read-album').click(function(){
        $('#read-album').hide();
    });

    $('#search-album-form').on('submit', function(e){
        e.preventDefault()
        const searched = $('#search-input-album').val();

        list_searched_albums(searched);
    });

    $(document).on("click", ".trigger-btn",function(e){
        const user_id = $('#hidden-access-id').val();
        const album_id = $(this).attr("data-id");
        const type = $(this).attr("class").slice(12);

     
        if(type == 'add-album'){
            $('#add-album-modal').show()
            
        }else if(type == 'read-album'){
            if(user_id != 'admin'){
                $('#read-album').show()
                get_album_tracks(album_id)
            }else{
                $('#read-album-modal').show()
                get_album(album_id, 'read')
            }
        }else if (type == 'edit-album'){
            $('#update-album-modal').show();
            get_album(album_id, 'update')
     
        }else if (type == 'delete-album'){
            if(confirm('Are you sure that you want to delete this Album?')){
                $(this).parent().parent().remove();
                delete_album(album_id);
            }
        }
    })


    $('.close-read-album-modal').click(function(){
        $('#read-album').hide();
   });
    $('.close-album-modal').click(function(){
        $('#read-album-modal').hide();
   });
    $('.close-add-album-modal').click(function(){
        $('#add-album-modal').hide();
   });

    $('.close-update-album-modal').click(function(){
        $('#update-album-modal').hide();
   });

   $('#update-album-form').on('submit', function(){
        update_album($('#update-album-id').val(), $('#update-album-title').val(), $('#update-album-artist-id').val());
    })
   $('#add-album-form').on('submit', function(){
        create_album( $('#add-album-title').val(), $('#add-album-artist-id').val());
    })
});

function list_albums(offset){
    $.ajax({
        // url: `./api/v1/album?offset=${offset}`,
        url: `./api/v1/album?offset=${offset}`,
        type: 'GET',
        success: function(albums){
            if(albums.length < 30){
                $('#album-next-btn').attr('disabled', true)
            }else{
                $('#album-next-btn').attr('disabled', false)
            }
            if(albums){
                display_albums(albums, 'searched-album')
            }
        }
    });
}
function list_searched_albums(searched){
    $.ajax({
        url: `./api/v1/album?title=${searched}`,
        type: 'GET',
        success: function(albums){

            console.log(albums)
            if(albums){
                display_albums(albums, 'searched-album')
            }
        }
    });
}

function get_album(album_id, type){
    $.ajax({
        url: `./api/v1/album/${album_id}`,
        type: 'GET',
        success: function(album){
            if(album){
                if(type == 'read'){
                    $('#read-album-title').text(album.Album)
                    $('#read-album-artist').text(album.Artist)
                
                    console.log(album.Artist)
                }else if(type == 'update'){
                    $('#update-album-id').val(album_id);
                    $('#update-album-title').val(album.Album);
                    $('#update-album-artist-id').val(album.ArtistId);
                   
                } 
            }
        }
    });
}
function get_album_tracks(album_id){
    $.ajax({
        url: `./api/v1/album/${album_id}/tracks`,
        type: 'GET',
        success: function(tracks){
            console.log(tracks)
            if(tracks){
        
                display_tracks(tracks, 'album-tracks')

            }
        }
    });
}

function create_album(name, artist_id,){
    $.ajax({
        url: `./api/v1/album?title=${name}&artistId=${artist_id}`,
        type: 'POST',
        success: function(data){
            if(data){
                alert('Album with the id: '+data.id+' has been created!')
            }
        }
    });
}
function update_album(album_id, name, artist_id,){
    $.ajax({
        url: `./api/v1/album/${album_id}?title=${name}&artistId=${artist_id}`,
        type: 'PUT',
        success: function(data){
            if(data){
                alert('Album with the id: '+album_id+' has been updated!')
            }
        }
    });
}
function delete_album(album_id){
    $.ajax({
        url: `./api/v1/album/${album_id}`,
        type: 'DELETE',
        success: function(data){
            if(data){
                alert('Track has been deleted!')
            }
      
        }
    });
}
function display_albums(albums, section_id){
    const user_id = $('#hidden-access-id').val();
    
    if(albums.length === 0){
        $('section#'+section_id).html('No Album was found!');
    }else{
        $('section#'+section_id).empty();

        const table = $("<table/>");
        const head = $("<thead/>");
        const head_row = $("<tr/>");

        if(user_id != 'admin'){
       
            head_row.
            append($("<th/>").text( "Album Title")).
            append($("<th/>").text( "Artist Name")).
            append($("<th/>").text( "Read"))
            head.append(head_row);
            table.append(head);
        }else{
        
            head_row.
            append($("<th/>").text("Album ID")).
            append($("<th/>").text("Album Title")).
            append($("<th/>").text("Artist Name")).
            append($("<th/>").text("Read")).
            append($("<th/>").text("Edit")).
            append($("<th/>").text("Delete"))
            head.append(head_row);
            table.append(head);

        }
        const body = $("<tbody />");
        for(const album of albums){
    
            const body_row= $('<tr></tr>');
            const id = album['AlbumId'];


            if(user_id != 'admin'){
               
                body_row.
                append($('<td></td>').text(album['Album'] )).
                append($('<td></td>').text( album['Artist'] )).
                append($('<td></td>').html("<svg width='30px' height='30px' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' color='#ffffff' data-id='"+id+"' class='trigger-btn read-album'><path fill='none' d='M0 0h24v24H0z'></path><path d='M13 7h9v2h-9zm0 8h9v2h-9zm3-4h6v2h-6zm-3 1L8 7v4H2v2h6v4z'></path></svg>").addClass('trigger'))
            }else {
                
                body_row.
                append($('<td></td>').text(id)).
                append($('<td></td>').text(album['Album'] )).
                append($('<td></td>').text( album['Artist'] )).
                append($('<td></td>').html(`<svg width='30px' height='30px' class='trigger-btn read-album' data-id='${id}' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' color='#fff'><path fill='none' d='M0 0h24v24H0z'></path><path d='M13 7h9v2h-9zm0 8h9v2h-9zm3-4h6v2h-6zm-3 1L8 7v4H2v2h6v4z'></path></svg>`).addClass('trigger')).
                append($('<td></td>').html(`<svg width="24" height="24" class='trigger-btn edit-album' data-id='${id}' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" color="#fff"><path d="M0 0h24v24H0z" fill="none"></path><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 000-1.41l-2.34-2.34a.996.996 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>`).addClass('trigger')).
                append($('<td></td>').html(`<svg width="24" height="24"  class='trigger-btn delete-album' data-id='${id}' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" color="#fff"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4z"></path></svg>`).addClass('trigger'))
        
    
            }
           
            body.append(body_row);}
            table.append(body);
        table.appendTo($('section#'+section_id));
    }

}

