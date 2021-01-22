<?php
require_once('connection.php');
class Artist extends Database{
    function get($id){
        $query = "SELECT * FROM artist WHERE ArtistId = ? ;"; 
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetch();
        $this->closeConnection();   
        return $results;         
    } 
    function create($name){
        $query = 'INSERT INTO artist (Name) VALUES (?);';  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$name]);
        if(!$stmt) {
            return false;
        }
        $id = $this->pdo->lastInsertId() ;
        $this->closeConnection();   
        $created_album = array('id' => $id, 'name' => $name );
        return $created_album ;    
    } 
    function read($offset){
        if($offset > 0){
            $offset = $offset * 30 + 1;
          } else {
            $offset = 1;
          }
        $query = "SELECT * FROM artist LIMIT 30 OFFSET :offset;"; 
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':offset', (int) $offset -1, PDO::PARAM_INT);
        $stmt->execute();
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();  
        $this->closeConnection();   
        return $results;   
    }  
    function readAll(){
      
        $query = "SELECT * FROM artist;"; 
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();  
        $this->closeConnection();   
        return $results;   
    }  

    function update($id, $name ){
        //check if theres an track connected
        //check if theres any invoice
        $query = 'UPDATE artist SET Name = ? WHERE ArtistId = ?';  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$name, $id]);
        if(!$stmt) {
            return false;
        }
        $this->closeConnection();
        return true; 

    }
    function delete($id){
        //check if theres an track connected
        //check if theres any invoice
        $query = "DELETE FROM artist WHERE ArtistId = ?;";  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);            
        if(!$stmt) {
            return false;
        }
        $this->closeConnection();
        return true; 
    } 
    function search($name){
        $query = "SELECT * FROM artist WHERE Name LIKE ?;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['%'.$name.'%']);        
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();  
        $this->closeConnection();   
        return $results;   
    }
}

?>