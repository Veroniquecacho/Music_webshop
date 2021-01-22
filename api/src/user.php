<?php 
    require_once ('connection.php');

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
            $this->password = $user['Password'];
            $this->firstname = $user['FirstName'];
            $this->lastname = $user['LastName'];
            $this->email = $user['Email'];
            $this->address = $user['Address'];
            $this->city = $user['City'];
            $this->country = $user['Country'];
            $this->state = $user['State'];
            $this->postalCode = $user['PostalCode'];
            $this->phone = $user['Phone'];
            $this->fax = $user['Fax'];
            if(password_verify($password, $user['Password'])){
                return $user['CustomerId'];
            } else{
                return false;
            }
            
             
        }
        function update($id, $oldPassword, $newPassword, $fistname, $lastname, $company, $address, $city, $state, $country, $postalCode, $phone, $fax, $email){
            $query = <<<SQL
                UPDATE customer SET FirstName = ?, LastName = ?, Company = ?, Address = ?, City = ?, State = ?, Country = ?, PostalCode = ?, Phone = ?, Fax = ?, Email = ?
            SQL; 
            $changePassword = $newPassword !== '';
            if($changePassword){
                if($this->validate($email, $oldPassword)){
                    $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $query .= ', Password = ?';
                   
                }else {return false;}
                
            }
            $query .= ' WHERE CustomerId = ?;';
            $stmt = $this->pdo->prepare($query);
            
            if($changePassword){
                $stmt->execute([$fistname, $lastname, $company, $address, $city, $state, $country, $postalCode, $phone, $fax, $email, $newPassword, $id]);
            } else {
                $stmt->execute([$fistname, $lastname, $company, $address, $city, $state, $country, $postalCode, $phone, $fax, $email, $id]);
            }
            $this->closeConnection();

            
            return true;

        }
        function deletePass($id, $password){
            $order = 'SELECT COUNT(*) AS total FROM invoice WHERE CustomerId = ?;';
            $stmt = $this->pdo->prepare($order);
            $stmt->execute([$id]);
            if($stmt->fetch()['total'] > 0){
                return false;
            }
            $get = 'SELECT Password FROM customer WHERE CustomerId = ?;';
            $stmtGet = $this->pdo->prepare($get);
            $stmtGet->execute([$id]);
            $user = $stmtGet->fetch();
            // could get email insted og id so i could use $this->validate()
            if(password_verify($password, $user['Password'])){
                $query = 'DELETE FROM customer WHERE CustomerId = ?;';
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$id]);
                $this->closeConnection();
                return true;
            }
        

        }
        function delete($id){
            $query = 'DELETE FROM customer WHERE CustomerId = ?;';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            $this->closeConnection();
          
            return $stmt;   
        }
        function create($firstname, $lastname, $company, $address, $city, $state, $country, $postalCode, $phone, $fax, $email, $password){
            $get = "SELECT COUNT(*) AS total FROM customer WHERE Email = ?;";
            
            $stmt = $this->pdo->prepare($get);
            $stmt->execute([$email]);
            
            if ($stmt->fetch()['total'] > 0){

                return false;
            }else{
                
                $insert = "INSERT INTO customer (FirstName, LastName, Company, Address, City, State, Country, PostalCode, Phone, Fax, Email, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                
                $password = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $this->pdo->prepare($insert);
                $stmt->execute([$firstname, $lastname, $company, $address, $city, $state, $country, $postalCode, $phone, $fax, $email, $password]);
                
                $this->closeConnection();

                return true;
            }
          

        }
        function get($id){
            $query = <<<SQL
            SELECT FirstName, LastName, Company, Address, City, State, Country, PostalCode, Phone, Fax, Email FROM customer WHERE CustomerId = ?;
            SQL;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            if($stmt->rowCount() === 0){
                return false;
            }
            $results = $stmt->fetchAll();   
            $this->closeConnection();

            return $results;   
        }
        function getByEmail($email){
            $query = <<<SQL
            SELECT * FROM customer WHERE Email = ?;
            SQL;
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$email]);
            if($stmt->rowCount() === 0){
                return false;
            }
            $results = $stmt->fetchAll();   
            $this->closeConnection();

            return $results;   
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