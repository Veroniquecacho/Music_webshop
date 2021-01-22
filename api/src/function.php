<?php

  // Response header and code function
  function http_response($response){
    $status_code = array(
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        400 => 'Bad Request',
        401 => 'Unauthorised',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        409 => 'Conflict'
    );
    // The HTTP Response
    header('HTTP/1.1 '. $response['code'].' '.$status_code[ $response['code'] ]);
    // The Response Content Type
    header('Content-Type: application/json; charset=utf-8');
    // The data formatted to JSON response
    $data = json_encode($response['data']);
    echo $data;

    exit;
    } 
    
    function error_response(){
        $response['code'] = 400;
        $response['data'] = 'Incorrect format';
        http_response($response);
    }
    function default_response(){
        $response['code'] = 400;
        $response['data'] = NULL;
        
    }

    function description(){
     
        $base_url = '{host}/api/v1';
        $track = '/track';
        $album = '/album';
        $artist = '/artist';
        $user = '/user';
        $invoice = '/invoice';
        $invoiceline = '/invoiceline';


        $api_description['description'] = array('method' => 'GET', 'url' => $base_url);

        $api_description['track'] = [
            ['information' => 'get all tracks', 'method' => 'GET', 'url' => $base_url . $track],
            ['information' => 'get all tracks with offset', 'method' => 'GET', 'url' => $base_url . $track . '?offset={offset}'],
            ['information' => 'search for tracks by track name', 'method' => 'GET', 'url' => $base_url . $track . '?name={track_name}'],
            ['information' => 'get one track', 'method' => 'GET', 'url' => $base_url . $track . '/{track_id}'],
            ['information' => 'create new track', 'method' => 'POST', 'url' => $base_url . $track . '?name={name}&albumId={album_id}&mediaType={media_type_id}&genreId={genre_id}&composer={composer}time={time}&bytes={bytes}&price={price}'],
            ['information' => 'update track by the id', 'method' => 'PUT', 'url' => $base_url . $track . '/{track_id}?name={name}&albumId={album_id}&mediaType={media_type_id}&genreId={genre_id}&composer={composer}time={time}&bytes={bytes}&price={price}'],
            ['information' => 'delete track by the id', 'method' => 'DELETE', 'url' => $base_url . $track . '/{track_id}'],
        ];
        $api_description['album'] = [
            ['information' => 'get all albums', 'method' => 'GET', 'url' => $base_url . $album],
            ['information' => 'get all albums with offset', 'method' => 'GET', 'url' => $base_url . $album . '?offset={offset}'],
            ['information' => 'search for albums by album title', 'method' => 'GET', 'url' => $base_url . $album. '?title={album_title}'],
            ['information' => 'get one album', 'method' => 'GET', 'url' => $base_url . $album . '/{album_id}'],
            ['information' => 'get one albums tracks', 'method' => 'GET', 'url' => $base_url . $album . '/{album_id}/tracks'],
            ['information' => 'create new album', 'method' => 'POST', 'url' => $base_url . $album . '?title={album_title}&artistId={artist_id}'],
            ['information' => 'update album by the id', 'method' => 'PUT', 'url' => $base_url . $album . '/{album_id}?title={album_title}&artistId={artist_id}'],
            ['information' => 'delete album by the id', 'method' => 'DELETE', 'url' => $base_url . $album . '/{album_id}'],
        ];
        $api_description['artist'] = [
            ['information' => 'get all artists', 'method' => 'GET', 'url' => $base_url . $artist],
            ['information' => 'get all artists with offset', 'method' => 'GET', 'url' => $base_url . $artist . '?offset={offset}'],
            ['information' => 'search for artists by artist name', 'method' => 'GET', 'url' => $base_url . $artist . '?name={artist_name}'],
            ['information' => 'get one artist', 'method' => 'GET', 'url' => $base_url . $artist . '/{artist_id}'],
            ['information' => 'create new artist', 'method' => 'POST', 'url' => $base_url . $artist . '?name={artist_name}'],
            ['information' => 'update artist by the id', 'method' => 'PUT', 'url' => $base_url . $artist . '/{artist_id}?name={artist_name}'],
            ['information' => 'delete artist by the id', 'method' => 'DELETE', 'url' => $base_url . $artist . '/{artist_id}'],
        ];
        $api_description['user'] = [
            ['information' => 'get one user', 'method' => 'GET', 'url' => $base_url . $user . '/{user_id}'],
            ['information' => 'create new user', 'method' => 'POST', 'url' => $base_url . $user . '?firstname={firstname}&lastname={lastname}&email={email}&password={password}&company={company}&address={address}&city={city}&state={state}&country={country}&postalCode={postal_code}&phone={phone}&fax={fax}'],
            ['information' => 'update user by the id', 'method' => 'PUT', 'url' => $base_url . $user . '/{user_id}?firstname={firstname}&lastname={lastname}&email={email}&oldPassword={old_password}&newPassword={new_password}&company={company}&address={address}&city={city}&state={state}&country={country}&postalCode={postal_code}&phone={phone}&fax={fax}'],
            ['information' => 'delete user by the id', 'method' => 'DELETE', 'url' => $base_url . $user . '/{user_id}'],
        ];
        $api_description['invoice'] = [
            ['information' => 'get invoices for customer by costomer id', 'method' => 'GET', 'url' => $base_url . $invoice . '/{customer_id}'],
            ['information' => 'create new invoice with customer id', 'method' => 'POST', 'url' => $base_url . $invoice . '?{customer_id}&invoiceDate={invoice_date}&billingAddress={billing_address}&billingCity={billing_city}&billingState={billing_state}&billingCountry={billing_country}&billingPostalCode={billing_postalcode}&total={total}'],
          
        ];
        $api_description['invoiceline'] = [
            ['information' => 'get invoiceline  by invoice id', 'method' => 'GET', 'url' => $base_url . $invoice . '/{invoice_id}'. $invoiceline],
            ['information' => 'create new invoice with customer id', 'method' => 'POST', 'url' => $base_url . $invoice . '/{invoice_id}'. $invoiceline . '?trackId={track_id}&unitPrice={price}&quantity={quantity}'],
          
        ];

        return json_encode($api_description);
    }

    function debug($info){
        if (gettype($info) === 'array') {
            print_r($info, true);
        } else {
            echo $info;
        }
        
    }

?>