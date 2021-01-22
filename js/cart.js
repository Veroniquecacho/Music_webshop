'use strict';

$(document).ready(function(){


    const user_id = $('#hidden-access-id').val();
    billing_data(user_id);



    $('#buy-tracks-form').on('submit', function(){
       

        var invoice_date = new Date().toJSON().slice(0,19).replace(/T/g,' ');
        const billing_address = $('#billing-address').val();
        const billing_city = $('#billing-city').val();
        const billing_state = $('#billing-state').val();
        const billing_country = $('#billing-country').val();
        const billing_postalcode = $('#billing-postalcode').val();
        const total = $('#cart-total').find('td:eq(3)').text();
     
        create_invoice(invoice_date, billing_address, billing_city, billing_state, billing_country, billing_postalcode, total, user_id); 

          
    
    })


});

function create_invoice(invoice_date, billing_address, billing_city, billing_state, billing_country, billing_postalcode, total, user_id){
    $.ajax({
        url: `./api/v1/invoice?customerId=${user_id}&invoiceDate=${invoice_date}&billingAddress=${billing_address}&billingCity=${billing_city}&billingState=${billing_state}&billingCountry=${billing_country}&billingPostalCode=${billing_postalcode}&total=${total}`,
        type: 'POST',
        success: function(invoice_id){
            if(invoice_id){
                alert('Invoice has been created')
                const items = $('.cart-items');
          
                for(var i = 0; i < items.length; i++){
                const track_id = $(items[i]).find('#cart-hidden-id').val()
                const quantity = $(items[i]).find('td:eq(1)').text();
                const price = $(items[i]).find('td:eq(2)').text();
           
                create_invoiceline(invoice_id, $(items[i]).find('#cart-hidden-id').val(), $(items[i]).find('td:eq(2)').text(), $(items[i]).find('td:eq(1)').text());
            }
            }
        }
    });
}

function create_invoiceline(invoice_id, track_id, price, quantity){
    location.href = 'cart.php?action=delete_cart'
    $.ajax({
        url: `./api/v1/invoice/${invoice_id}/invoiceline?trackId=${track_id}&unitPrice=${price}&quantity=${quantity}`,
        type: 'POST',
        success: function(data){
            if(data){
                //location.href = 'cart.php?action=delete_cart';
            }
        }
    });
}

function billing_data(user_id){
    $.ajax({
        url: `./api/v1/user/${user_id}`,
        type: 'GET',
        success: function(data){
            if(data){
                console.log(data)
                for(const user of data){
                    $('#billing-address').val(user.Address);
                    $('#billing-city').val(user.City);
                    $('#billing-state').val(user.State)
                    $('#billing-country').val(user.Country)
                    $('#billing-postalcode').val(user.PostalCode)
                }
            }
        }
    });
    
}

