'use strict';

$(document).ready(function(){
    const user_id = $('#hidden-access-id').val();

    get_user(user_id, read_data);
    get_user(user_id, edit_data);


       
    $('#delete-user-btn').click(function (){
        if (confirm('Are you sure that you want to delete this account?')){
            delete_user(user_id);
            location.href = './fragments/logout.php';
            alert('Your account has now been deleted!');
        }
    });
    $('#update-user-form').on('submit', function(){
        const firstname = $('#update-firstname').val().trim()
        const lastname = $('#update-lastname').val().trim()
        const company = $('#update-company').val().trim()
        const address = $('#update-address').val().trim()
        const city = $('#update-city').val().trim()
        const state = $('#update-state').val().trim()
        const country = $('#update-country').val().trim()
        const postalCode = $('#update-postalcode').val().trim()
        const phone = $('#update-phone').val().trim()
        const fax = $('#update-fax').val().trim()
        const email = $('#update-email').val().trim()
        const oldPassword = $('#update-oldpwd').val().trim()
        const newPassword = $('#update-newpwd').val().trim()
        update_user(user_id, firstname, lastname, company, address, city, state, country, postalCode, phone, fax, email, oldPassword, newPassword);
    
    })


});

function get_user(id, handel_data){
    $.ajax({
        url: `./api/v1/user/${id}`,
        type: 'GET',
        success: function(data){
            if(data){
                handel_data(data);
            }
        }
    });
}
function update_user(id, firstname, lastname, company, address, city, state, country, postalCode, phone, fax, email, oldPassword, newPassword){
 
    $.ajax({
        url: `./api/v1/user/${id}?firstname=${firstname}&lastname=${lastname}&email=${email}&oldPassword=${oldPassword}&newPassword=${newPassword}&company=${company}&address=${address}&city=${city}&state=${state}&country=${country}&postalCode=${postalCode}&phone=${phone}&fax=${fax}`,
        type: 'PUT',
        success: function(data){
            alert('User has been updated');
        }
    });
}
function delete_user(id){
    $.ajax({
        url: `./api/v1/user/${id}`,
        type: 'DELETE',
        success: function(data){
       
        }
    });
}

function read_data(data){
    for(const user of data){
        $('#read-user-name').text(user.FirstName + ' ' + user.LastName);
        $('#read-user-company').text(user.Company);
        $('#read-user-email').text(user.Email);
    }
}
function edit_data(data){
    for(const user of data){
        $('#delete-user-btn').attr('user-id', user.CustomerId)
        $('#update-id').val(user.CustomerId);
        $('#update-firstname').val(user.FirstName );
        $('#update-lastname').val(user.LastName );
        $('#update-company').val(user.Company );
        $('#update-address').val(user.Address );
        $('#update-city').val(user.City );
        $('#update-state').val(user.State );
        $('#update-country').val(user.Country );
        $('#update-postalcode').val(user.PostalCode );
        $('#update-phone').val(user.Phone );
        $('#update-fax').val(user.Fax );
        $('#update-email').val(user.Email );
    }
}
