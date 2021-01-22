'use strict';

function escape_string(string) {
    return string
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/\//g, "&#x2F;")
    .replace(/=/g, "&#x3D;");
    }

function get_genre(genre_id){
    $.ajax({
        url: './api/v1/track/genre',
        type: 'GET',
        success: function(data){
            $.each(data, function(i, value){

                if(genre_id == 0){
                    $('#add-track-genre-id').append($('<option>').text(value.Name).attr('value', value.GenreId));
                }else{
                    if(value.GenreId === genre_id ){
                        $('#update-genre-id').append($('<option>').text(value.Name).attr('value', value.GenreId).attr("selected","selected"));  
                    }else{
                        $('#update-genre-id').append($('<option>').text(value.Name).attr('value', value.GenreId));
                    }
                }
            })
        }
    });
}
function get_media(media_id){
    $.ajax({
        url: './api/v1/track/mediatype',
        type: 'GET',
        success: function(data){
            $.each(data, function(i, value){
                if(media_id == 0){
                    $('#add-track-media-id').append($('<option>').text(value.Name).attr('value', value.MediaTypeId));
                }else{
                    if(value.GenreId == media_id ){
                        $('#update-media-id').append($('<option>').text(value.Name).attr('value', value.MediaTypeId).attr("selected","selected"));  
                    }else{
                        $('#update-media-id').append($('<option>').text(value.Name).attr('value', value.MediaTypeId));
                    }
                }
            })
        }
    });
}
function openTab(type) {

    $('.type').hide();
    $('#'+type).show();

    if(type === 'login'){
        $('#signup-tab').removeClass( 'active' )
        $('#login-tab').attr( 'class' , 'active' )
    }else if(type === 'signup'){
        $('#login-tab').removeClass( 'active' )
        $('#signup-tab').attr( 'class' , 'active' )

    }else if(type == 'edit-user'){
        $('#read-tab').removeClass( 'active' )
        $('#edit-tab').attr( 'class' , 'active' )

    }else if(type == 'read-user'){
        $('#edit-tab').removeClass( 'active' )
        $('#read-tab').attr( 'class' , 'active' )

    }
  
}

