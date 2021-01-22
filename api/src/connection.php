<?php 
    class Database {
        public $pdo;
       
        public function __construct(){
            
            require('db_data.php');

            $dsn = 'mysql:host='.$server.';dbname='.$dbname.';charset=utf8';
        
            $options = [
                PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC
            ];

            try{
                $this->pdo = @new PDO($dsn, $user, $pwd, $options);
           
            }catch (PDOException $e) {
               die('Connection unsuccessful: ' . $e->getMessage());
                exit();
            }
        }

        public function closeConnection(){
            $this->pdo = null; 
        }

    }

?>