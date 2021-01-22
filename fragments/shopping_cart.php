<?php

if(isset($_POST["add-cart-item"])){
    if(isset($_COOKIE['shopping-cart'])){
        $cart_data = json_decode($_COOKIE['shopping-cart'], true);
    }else{
        $cart_data = array();
    }
    $cart_id_list = array_column($cart_data, 'item-id');
    if(in_array($_POST['hidden-id'], $cart_id_list)){
        foreach($cart_data  as $key => $track){
           if($cart_data[$key]['item-id'] == $_POST['hidden-id']){
             $cart_data[$key]['item-quantity'] = $cart_data[$key]['item-quantity'] + $_POST['quantity'];
           }
        }
    }else{
        $item_data = array(
            'item-id'   => $_POST["hidden-id"],
            'item-name'   => $_POST["hidden-name"],
            'item-price'  => $_POST["hidden-price"],
            'item-quantity'  => $_POST["quantity"]
           );
        $cart_data[] = $item_data;
    }
    $item = json_encode($cart_data);
    
    setcookie('shopping-cart', $item, time() + (86400 * 30));

    header('location:'. dirname($_SERVER['PHP_SELF']).'?success=1');
}
if(isset($_GET['action'])){
    $action = $_GET['action'];
    if($action == 'delete'){
        $cart_data = json_decode($_COOKIE['shopping-cart'], true);
        foreach($cart_data  as $key => $track){
            if($cart_data[$key]['item-id'] == $_GET['id']){
                unset($cart_data[$key]);
                $item = json_encode($cart_data);
                setcookie('shopping-cart', $item, time() + (86400 * 30));
                header('location: cart.php?remove=1');
            
             
            }
         }
    }if($action == 'delete_cart'){
        setcookie("shopping-cart", "", time() - 3600);
        header("location:cart.php?clearall=1");
    }
}  
  
  ?>