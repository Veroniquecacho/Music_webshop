<div id="head-page">
    <h1>Mockify</h1>
    <p>Music webshop</p>
</div>

<nav id="navigation">
    <ul>

        <li><a href="./track">Tracks</a></li>
        <li><a href="./album">Albums</a></li>
        <li><a href="./artist">Artist</a></li>
        <?php if($_SESSION['ACCESS'] !== 'admin'){ ?>
                <li><a href="./user" id="user-btn">User</a></li>
                <!-- <li><a href="#" id="edit-user-btn">Edit User</a></li> -->
                <li><a href="./cart" id="cart-btn">Cart</a></li>
        <?php } ?>
        <li><a href="fragments/logout">Log out</a></li>
    </ul>
</nav>
<input type="hidden" name="hidden-id" id="hidden-access-id" value="<?= $_SESSION['ACCESS'] ?>">
<?php
require_once('fragments/shopping_cart.php');
    // if($_SESSION['ACCESS'] !== 'admin'){
    //     // require_once('fragments/user-modal.php');
    // }else{
    //     require_once('fragments/admin_modal.php');
    // }
    ?>