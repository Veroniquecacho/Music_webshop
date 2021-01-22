<?php 
require_once ('db_connection.php');
    
class User extends Database{
    public int $id;
    public string $fistname;
    public string $lastname;
    public string $password;
    public string $company;
    public string $address;
    public string $city;
    public string $state;
    public string $country;
    public string $postalCode;
    public string $phone;
    public string $fax;
    public string $email;

    function validate($email, $password){
        $query = <<<SQL
            SELECT * FROM customer WHERE Email = ?;
        SQL;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email]);
 
        if($stmt->rowCount() === 0){
            return false;
        }
        $user = $stmt->fetch();
        $this->id = $user['CustomerId'];
       
        // if(password_verify($password, $user['Password'])){
        //     return $user['CustomerId'];
        // } else{
        //     return false;
        // }
        return (password_verify($password, $user['Password']));
         
    }
    

    function validateAdmin($password){

        $query = "SELECT * FROM admin;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $admin = $stmt->fetch();
        
        if(!(password_verify($password, $admin['Password']))){
            return false;
        } else{
            return true;
        }
         
    }
   
}    
    
    
?>