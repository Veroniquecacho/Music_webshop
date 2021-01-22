<?php

    session_start();

    $validate = true;
    if(isset($_SESSION['ACCESS'])){
        header('Location: ./track');
    }

    if(isset($_POST['login-username'],$_POST['login-password'])){
    
        
        require_once('src/user.php');
        $user = new User();

        $username = $_POST['login-username'];
        $password = $_POST['login-password'];
   
        if($username === 'admin'){
            $validUser = $user->validateAdmin($username, $password);
            if ($validUser) {
               
                $validate = true;
                $_SESSION['ACCESS'] = $username;
                
                header('Location: ./track');
            }else{
                $validate = false;
                }
            
        }else{
            $validUser = $user->validate($username, $password);
        
            if ($validUser) {
                $_SESSION['ACCESS'] = $user->id;
                $_SESSION['username'] = $username;
                $validate = true;  
                header('Location: ./track');
            }else{
                $validate = false;
                }
        }
       
    } 

  
?>


<?php require_once('fragments/header.php') ?>
    <title>Mockify</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/script.js"></script>
    <script src="./js/signup.js"></script>
</head>
<body>
    <header id="head-title"> 
        <h1>Mockify</h1>
        <p>Music webshop</p>
    </header>
    <main class="front-main">
     

        <div class="tabs">
            <button class="active" id="login-tab" onclick="openTab('login')">Login</button>
            <button  id="signup-tab" onclick="openTab('signup')">Signup</button>
        </div>

        <div id="login" class="type">
     
                <h1>Login</h1>
                <div id="validate-error">
                <?php if(!$validate){ ?>
                    <p>Wrong username or password!</p>
                    <?php } ?>
                </div>
                <form method="POST" id="login-form" class="form">
                    <input type="text" name="login-username" id="login-username"  placeholder="Username">
                    <input type="password" name="login-password" id="login-password" placeholder="Password">
                    <input type="submit" value="Login" id="login-btn">
                </form>
                
       
        </div>

        <div id="signup" class="type" style="display:none">
        <h1>Sign up</h1>
            <form method="POST" id="signup-form" class='form'>
                <input type="hidden" id='signup-id'>
                <input type="text" name="signup-firstname" id="signup-firstname" placeholder="Firstname">
                <input type="text" name="signup-lastname" id="signup-lastname" placeholder="Lastname">
                <input type="text" name="signup-address" id="signup-address" placeholder="Address">
                <input type="text" name="signup-company" id="signup-company" placeholder="Company">
                <input type="text" name="signup-city" id="signup-city" placeholder="City">
                <input type="text" name="signup-email" id="signup-email" placeholder="Email">
                <input type="text" name="signup-postalcode" id="signup-postalcode" placeholder="Postal Code">
                <input type="password" name="signup-pwd" id="signup-pwd" placeholder="Password">
                <input type="text" name="signup-state" id="signup-state" placeholder="State">
                <input type="text" name="signup-phone" id="signup-phone" placeholder="Phone">
                <input type="text" name="signup-country" id="signup-country" placeholder="Country">
                <input type="text" name="signup-fax" id="signup-fax" placeholder="Fax">


                <input type="submit" value="Sign up">
            </form>
        </div>

    </main>
    <footer>
    </footer>
</body>
</html>