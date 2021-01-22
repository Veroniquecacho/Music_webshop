'use strict';

$(document).ready(function(){
    $('#signup-form').on('submit', function(){
        create_user($('#signup-firstname').val(),$('#signup-lastname').val(),$('#signup-email').val(),$('#signup-pwd').val(),$('#signup-company').val(),$('#signup-address').val(),$('#signup-city').val(),$('#signup-state').val(),$('#signup-country').val(),$('#signup-postalcode').val(), $('#signup-phone').val(), $('#signup-fax').val());
    })

    $('#login-username')
});
function create_user(firstname, lastname, email, password, company, address, city, state, country, postalCode, phone, fax){
    $.ajax({
        url: `./api/v1/user?firstname=${firstname}&lastname=${lastname}&email=${email}&password=${password}&company=${company}&address=${address}&city=${city}&state=${state}&country=${country}&postalCode=${postalCode}&phone=${phone}&fax=${fax}`,
        type: 'POST',
        success: function(data){
            if(data){
                alert('User has been created, Login to use');
                location.href = 'index.php';
            }
        }
    });
}


