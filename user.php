<?php 
session_start();


if (!isset($_SESSION['ACCESS'])) {  
    header('Location: index.php');
}

?>
<?php require_once('fragments/header.php') ?>
    <title>Mockify | User</title>
    <script src="./js/user.js"></script>
    <script src="./js/script.js"></script>
</head>
<body>
    <header>
        <?php require_once('fragments/navigation.php') ?>
    </header>

    <main>
        <div class="tabs">
            <button class="active"  id="read-tab"onclick="openTab('read-user')">User Information</button>
            <button   id="edit-tab" onclick="openTab('edit-user')">Edit User</button>
        </div>

        <div id="read-user" class="type">

            <h1>User information</h1>
            <p>Name: <span id="read-user-name"></span></p>
            <p>Company: <span id="read-user-company"></span></p>
            <p>Email: <span id="read-user-email"></span></p>
        </div>

        <div id="edit-user" class="type" style="display:none">
            <h1>Edit User</h1>
            <button id="delete-user-btn">Delete User</button>
            <form method="POST" id="update-user-form" class='form'>
                <div class="update-form-container">
                    <input type="hidden" id='update-id'>
                    <div class="update-form-side">
                        <label for="update-firstname">Firstname</label>
                        <input type="text" name="update-firstname" id="update-firstname">
                        <label for="update-lastname">Lastname</label>
                        <input type="text" name="update-lastname" id="update-lastname">
                        <label for="update-company">Company</label>
                        <input type="text" name="update-company" id="update-company">
                        <label for="update-address">Address</label>
                        <input type="text" name="update-address" id="update-address">
                        <label for="update-city">City</label>
                        <input type="text" name="update-city" id="update-city">
                        <label for="update-state">State</label>
                        <input type="text" name="update-state" id="update-state">
                    </div>
                    <div class="update-form-side">
                        <label for="update-country">country</label>
                        <input type="text" name="update-country" id="update-country">
                        <label for="update-postalcode">Postal Code</label>
                        <input type="text" name="update-postalcode" id="update-postalcode">
                        <label for="update-phone">Phone</label>
                        <input type="text" name="update-phone" id="update-phone">
                        <label for="update-fax">Fax</label>
                        <input type="text" name="update-fax" id="update-fax">
                        <label for="update-email">Email</label>
                        <input type="text" name="update-email" id="update-email">
                        <label for="update-oldpwd">Old Password</label>
                        <input type="text" name="update-oldpwd" id="update-oldpwd">
                        <label for="update-newpwd">New Password</label>
                        <input type="text" name="update-newpwd" id="update-newpwd">
                    </div>
                    </div>
                    <br>
                    <input type="submit" value="Update user">
            </form>

        </div>

                

    </main>
 
    
</body>
</html>