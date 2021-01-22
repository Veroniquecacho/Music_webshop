<?php 
require_once('src/function.php');
$url = strtok($_SERVER['REQUEST_URI'], '?');
$url = explode('/', urldecode($url));
header("Access-Control-Allow-Origin: *");


// Slices the array path.
$url = array_slice($url, 3);
debug($url);

$path_size = count($url);
if($url[0] == 'v1' && $path_size == 1){
    echo description();
   
}elseif(count($url) > 4){
    error_response();
}else{

    $path = $url[1];
    if(isset($url[2])){$second_path = $url[2];}
    //default response
    $response['code'] = 400;
    $response['data'] = NULL;

    // The request method
    $method = $_SERVER["REQUEST_METHOD"];

    switch($path){
        case 'user':
        require_once('src/user.php');
        $user = new User();
        switch($method){
            case 'GET':
                if (isset($second_path)){
                    $response['code'] = (200);
                    $response['data'] = $user->get($second_path);
                } else if(isset($_GET['username'], $_GET['password'])){
                    $response['code'] = (200);
                    $response['data'] = $user->validate($_GET['username'], $_GET['password']);
                } else if(isset($_GET['password'])){
                    $response['code'] = (200);
                    $response['data'] = $user->validateAdmin($_GET['password']);
                }else{
                    $response['code'] = (400);
                    $response['data'] = 'User id or usernameand and password are not set';
                } 
                break;
            case 'POST':
                if(isset($_REQUEST['password'], $_REQUEST['firstname'], $_REQUEST['lastname'], $_REQUEST['company'], $_REQUEST['address'], $_REQUEST['city'], $_REQUEST['state'], $_REQUEST['country'], $_REQUEST['postalCode'], $_REQUEST['phone'], $_REQUEST['fax'], $_REQUEST['email'])){
                    $response['code'] = (200);
                    $response['data'] = $user->create($_REQUEST['firstname'], $_REQUEST['lastname'], $_REQUEST['company'], $_REQUEST['address'], $_REQUEST['city'], $_REQUEST['state'], $_REQUEST['country'], $_REQUEST['postalCode'], $_REQUEST['phone'], $_REQUEST['fax'], $_REQUEST['email'],  $_REQUEST['password']);
                }
                break;
            case 'PUT':
                if ($second_path){
                    $response['code'] = (200);
                    $response['data'] = $user->update($second_path, $_GET['oldPassword'],$_GET['newPassword'], $_GET['firstname'],$_GET['lastname'], $_GET['company'], $_GET['address'], $_GET['city'], $_GET['state'], $_GET['country'], $_GET['postalCode'], $_GET['phone'], $_GET['fax'], $_GET['email']);
                }else{
                    $response['code'] = (400);
                    $response['data'] ='User id not set';
                }
                break;
            case 'DELETE':
                if ($second_path ){
                    $response['code'] = (204);
                    $response['data'] = $user->delete($second_path);
                } else{
                    $response['code'] = (400);
                    $response['data'] ='User id and/or password not set';
                }   
                break;
            }break;
        case 'track':
            require_once('src/track.php');
            $track = new Track();
            switch($method){
                case 'GET':
                    if (isset($second_path) && !isset($_GET['name'])){
                        if($second_path == 'genre'){
                            $response['code'] = (200);
                            $response['data'] = $track->readGenre();
                        }elseif($second_path == 'mediatype'){
                            $response['code'] = (200);
                            $response['data'] = $track->readMedia();
                        }else{
                            $response['code'] = (200);
                            $response['data'] = $track->get($second_path);
                        }
                    }else if(isset($_GET['offset'])){
                        $response['code'] = (200);
                        $response['data'] = $track->read($_GET['offset']);
                    }else if(isset($_GET['name'])){
                        $response['code'] = (200);
                        $response['data'] = $track->search($_GET['name']);
                    }else{
                        $response['code'] = (200);
                        $response['data'] = $track->readAll();
                    }
                    break;
                case 'POST':
                    if (isset($_GET['name'], $_GET['albumId'], $_GET['mediaType'], $_GET['genreId'], $_GET['composer'] , $_GET['time'] , $_GET['bytes'] , $_GET['price'])){
                        if(!empty($_GET['name']) && !empty($_GET['albumId'])&& !empty($_GET['mediaType'])&& !empty($_GET['genreId'])&& !empty($_GET['composer'])&& !empty($_GET['time'])&& !empty($_GET['bytes'])&& !empty($_GET['price'])){
                            $response['code'] = (201);
                            $response['data'] = $track->create($_GET['name'], $_GET['albumId'], $_GET['mediaType'], $_GET['genreId'], $_GET['composer'] , $_GET['time'] , $_GET['bytes'] , $_GET['price']);
                        } else{
                            $response['code'] = (400);
                            $response['data'] ='Empty fields. Please fill all the fields';
                        }break;
                    }else{
                        $response['code'] = (400);
                    }break;
                case 'PUT':
                    if ($second_path){
                        $response['code'] = (200);
                        $response['data'] = $track->update( $second_path, $_GET['name'], $_GET['albumId'], $_GET['mediaType'], $_GET['genreId'], $_GET['composer'] , $_GET['time'] , $_GET['bytes'] , $_GET['price']);
                    } else{
                        $response['code'] = (400);
                        $response['data'] = 'Track second_path or data not set!';
                    }break;
                case 'DELETE':
                    if ($second_path){
                        $response['code'] = (204);
                        $response['data'] = $track->delete($second_path);
                        }else{
                        $response['code'] = (400);
                        $response['data'] ='Track second_path not set';
                    }break;
                }break;
        case 'album':
            require_once('src/album.php');
            $album = new Album();
            switch($method){
                case 'GET':
                    if(isset($second_path)){
                        if(isset($url[3]) && $url[3] == 'tracks'){
                             $response['code'] = (200);
                             $response['data'] = $album->getTracks($second_path);
                        }else{
                            $response['code'] = (200);
                            $response['data'] = $album->get($second_path);
                        }
                    }elseif(isset($_GET['title'])){
                        $response['code'] = (200);
                        $response['data'] = $album->search($_GET['title']);
                    }elseif(isset($_GET['offset'])){
                        $response['code'] = (200);
                        $response['data'] = $album->read($_GET['offset']);
                    }else{
                        $response['code'] = (200);
                        $response['data'] = $album->readAll();
                    }
                    break;
                case 'POST':
                    if (isset($_GET['title'], $_GET['artistId'])){
                        if(!empty($_GET['title']) && !empty($_GET['artistId'])){
                           
                            $response['code'] = (201);
                            $response['data'] = $album->create($_GET['title'], $_GET['artistId']);
                          
                        } else{
                            $response['code'] = (400);
                            $response['data'] ='Empty fields. Please fill all the fields';
                        }break;
                    }else{
                        $response['code'] = (400);
                        $response['data'] ='Title and/or artist second_path not set';
                    }
                    break;
                case 'PUT':
                    if ($second_path && isset($_GET['title'], $_GET['artistId'])){
                        if(!empty($_GET['title']) && !empty($_GET['artistId'])){
                            $response['code'] = (200);
                            $response['data'] = $album->update( $second_path,$_GET['title'], $_GET['artistId']);
                          } else{
                            $response['code'] = (400);
                            $response['data'] ='Empty fields. Please fill all the fields';
                          }break;
                    } else{
                        $response['code'] = (400);
                        $response['data'] ='Album second_path and/or title and artist second_path not set';
                    }
                    break;
                case 'DELETE':
                    if ($second_path){
                        $response['code'] = (204);
                        $response['data'] = $album->delete($second_path);
                        }else{
                        $response['code'] = (400);
                        $response['data'] ='Album second_path and/or title and artist second_path not set';
                    }
                    break;   
            }
            break;
        case 'artist':
            require_once('src/artist.php');
            $artist = new Artist();
            switch($method){
                case 'GET':
                    if (isset($second_path) && !isset($_GET['name'], $_GET['offset'])){
                        $response['code'] = (200);
                        $response['data'] = $artist->get($second_path);
                    }elseif(isset($_GET['offset'])){
                        $response['code'] = (200);
                        $response['data'] = $artist->read($_GET['offset']);
                    }elseif (isset($_GET['name'])){
                        $response['code'] = (200);
                        $response['data'] = $artist->search($_GET['name']);
                    }else{
                        $response['code'] = (200);
                        $response['data'] = $artist->readAll();
                    }break;
                case 'POST':
                    if (isset($_GET['name'])){
                        if(!empty($_GET['name'])){
                            $response['code'] = (201);
                            $response['data'] = $artist->create($_GET['name']);
                        } else{
                            $response['code'] = (400);
                            $response['data'] ='Empty fields. Please fill all the fields';
                        }break;
                    }else{
                        $response['code'] = (400);
                        $response['data'] ='artist and/or artist second_path not set';
                    }break;
                case 'PUT':
                    if ($second_path){
                        $response['code'] = (200);
                        $response['data'] = $artist->update($second_path, $_GET['name']);
                    } else{
                        $response['code'] = (400);
                        $response['data'] ='artist second_path and/or title and artist second_path not set';
                    }break;
                case 'DELETE':
                    if ($second_path){
                        $response['code'] = (204);
                        $response['data'] = $artist->delete($second_path);
                        }else{
                        $response['code'] = (400);
                        $response['data'] ='artist second_path and/or title and artist second_path not set';
                    }break;
                }
            break;
        case 'invoice':
            require_once('src/invoice.php');
            $invoice = new Invoice();
            switch($method){
                case 'GET':
                    if ($second_path){
                        if(isset($url[3]) && $url[3] == 'invoiceline'){
                            $response['code'] = (200);
                            $response['data'] = $invoice->getInvoicelines($second_path);
                        }else{
                            $response['code'] = (200);
                            $response['data'] = $invoice->getInvoice($second_path);
                        }
                    } else{
                        $response['code'] = (200);
                        $response['data'] ='Customer id not set to get invoice';
                    }break;
                case 'POST':
                    if (isset($second_path) && isset($url[3]) && $url[3] == 'invoiceline'){
                        if(isset($second_path, $_GET['trackId'], $_GET['unitPrice'], $_GET['quantity'])){
                            $response['code'] = (200);
                            $response['data'] = $invoice->createInvoiceLine($second_path, $_GET['trackId'], $_GET['unitPrice'], $_GET['quantity']);
                        }
                    }else{
                        if(isset($_GET['customerId'], $_GET['invoiceDate'], $_GET['billingAddress'], $_GET['billingCity'], $_GET['billingState'], $_GET['billingCountry'], $_GET['billingPostalCode'], $_GET['total'])){
                            $response['code'] = (200);
                            $response['data'] = $invoice->createInvoice($_GET['customerId'], $_GET['invoiceDate'], $_GET['billingAddress'], $_GET['billingCity'], $_GET['billingState'], $_GET['billingCountry'], $_GET['billingPostalCode'], $_GET['total']);
                        }
                    }
                    break;
                
                }
            break;
        // default:
        //     $response['code'] = 400;
        //     $response['data'] = 'Default message';
        //     break;
    }


    http_response($response);
}

   
?>