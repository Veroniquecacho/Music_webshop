<?php 
session_start();


if (!isset($_SESSION['ACCESS'])) {  
    header('Location: index.php');
}

?>


<?php require_once('fragments/header.php') ?>
<script src="./js/cart.js"></script>
    <title>Mockify | Cart</title>
</head>
<body>
    <header>
        <?php require_once('fragments/navigation.php') ?>
    </header>


    <main>

    <div id="cart" >
        
                <h2>Shopping Cart</h2>
                <table>
                   <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                   </thead> 
                   <tbody>
                    <?php
                        
                        if(isset($_COOKIE['shopping-cart']) && count(json_decode($_COOKIE['shopping-cart'], true)) != 0){
                            $cart_data = json_decode($_COOKIE['shopping-cart'], true);
                            $total = 0;
                            foreach($cart_data  as $key => $track){  ?>
                                <tr class="cart-items">
                                    <td><?php echo $track['item-name']?></td>
                                    <td><?php echo $track['item-quantity'] ?></td>
                                    <td><?php echo $track['item-price'] ?></td>
                                    <td>$ <?php echo number_format($track['item-quantity'] * $track['item-price'], 2) ?></td>
                                    <td><a href="cart.php?action=delete&id=<?= $track['item-id'];?>">Remove</a></td>
                                    <input type="hidden" id="cart-hidden-id" value=<?php echo $track['item-id']?>>
                                </tr>
                    <?php   
                                $total = $total + ($track['item-quantity'] * $track['item-price']);
                            }
                    ?>      
                                <tr id="cart-total">
                                    <td>Total</td>
                                    <td></td>
                                    <td>$</td>
                                    <td><?php echo number_format($total, 2)?></td>
                                </tr>   
                                </tbody>
            
                     
                    <?php  
                         }else{
                            echo '<tr><td id="cart_status">You have no items in the cart!</td></tr>';
                        }
                    ?>
                   </table>
                   <div class="cart-btn" <?php if (!isset($_COOKIE['shopping-cart']) || count(json_decode($_COOKIE['shopping-cart'])) === 0){ echo 'style="display:none;"'; } ?>>
                   <h3>Billing Information</h3>
                    <form method='POST' id='buy-tracks-form'>
                        <label for="billing-address">Address</label>
                        <input type="text" name="billing-address" id="billing-address">
                        <label for="billing-city">City</label>
                        <input type="text" name="billing-city" id="billing-city">
                        <label for="billing-state">State</label>
                        <input type="text" name="billing-state" id="billing-state">
                        <label for="billing-country">Country</label>
                        <input type="text" name="billing-country" id="billing-country">
                        <label for="billing-postalcode">Postal Cpde</label>
                        <input type="text" name="billing-postalcode" id="billing-postalcode">
                        <input type="submit" value="Buy" id='buy-btn'>
                    </form>
                    </div> 
                 
         
    </div>
    </main>
 
    
</body>
</html>