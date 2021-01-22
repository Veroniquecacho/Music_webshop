<?php
require_once('connection.php');
class Track extends Database{
    function get($id){
        $query = <<<'SQL'
             SELECT track.TrackId, track.Name AS Track, album.Title AS Album, track.AlbumId, artist.Name AS Artist, artist.ArtistId, genre.Name AS Genre, track.GenreId, mediatype.Name AS Mediatype, track.MediaTypeId,
            track.Composer, track.Milliseconds, track.UnitPrice, track.Bytes
            FROM track 
            INNER JOIN album ON album.AlbumId = track.AlbumId
            INNER JOIN genre ON genre.GenreId = track.GenreId
            INNER JOIN mediatype ON mediatype.MediaTypeId = track.MediaTypeId
            INNER JOIN artist ON artist.ArtistId = album.ArtistId
            WHERE TrackId = ?;
        SQL; 
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetch();
        $this->closeConnection();   
        return $results;         
    } 
 
    function create($name, $albumId, $mediaType, $genreId, $composer , $time , $bytes , $price){
        $query = 'INSERT INTO track (Name, AlbumId, MediaTypeId, GenreId, Composer, Milliseconds, Bytes, UnitPrice) VALUES (?, ?, ?, ?, ?, ?, ?, ?);';  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$name, $albumId, $mediaType, $genreId, $composer , $time , $bytes , $price]);
        if(!$stmt) {
            return false;
        }
        $id = $this->pdo->lastInsertId() ;
        $this->closeConnection();   
        return $id;    
    } 
    function read($offset){

        if($offset > 0){
            $offset = $offset * 30 + 1;
          } else {
            $offset = 1;
          }
        $query = <<<'SQL'
            SELECT track.TrackId, track.Name AS Track, album.Title AS Album, track.AlbumId, artist.Name AS Artist, genre.Name AS Genre, track.GenreId, mediatype.Name AS Mediatype, track.MediaTypeId,
            track.Composer, track.Milliseconds, track.UnitPrice
            FROM track 
            INNER JOIN album ON album.AlbumId = track.AlbumId
            INNER JOIN genre ON genre.GenreId = track.GenreId
            INNER JOIN mediatype ON mediatype.MediaTypeId = track.MediaTypeId
            INNER JOIN artist ON artist.ArtistId = album.ArtistId
            LIMIT 30 OFFSET :offset;
         SQL;  
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

        $query = <<<'SQL'
            SELECT track.TrackId, track.Name AS Track, album.Title AS Album, track.AlbumId, artist.Name AS Artist, genre.Name AS Genre, track.GenreId, mediatype.Name AS Mediatype, track.MediaTypeId,
            track.Composer, track.Milliseconds, track.UnitPrice
            FROM track 
            INNER JOIN album ON album.AlbumId = track.AlbumId
            INNER JOIN genre ON genre.GenreId = track.GenreId
            INNER JOIN mediatype ON mediatype.MediaTypeId = track.MediaTypeId
            INNER JOIN artist ON artist.ArtistId = album.ArtistId;
         SQL;  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();  
        $this->closeConnection();   
        return $results;   
    } 

    function readLimit($start, $per_page){
        $query = <<<'SQL'
            SELECT * FROM track
            LIMIT 25 OFFSET 25
         SQL;  
        $stmt = $this->pdo->prepare($query);
        // $stmt->bindValue(':limit', (int) $start, PDO::PARAM_INT);
        // $stmt->bindValue(':offset', (int) $per_page, PDO::PARAM_INT);
        $stmt->execute();
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();  
        $this->closeConnection();   
        return $results;   
    }  
    function update($id, $name, $albumId, $mediaType, $genreId, $composer , $time , $bytes , $price){
        //check if theres an track connected
        //check if theres any invoice
        $query = 'UPDATE track SET Name = ?, AlbumId = ?, MediaTypeId = ?, GenreId = ?, Composer = ?, Milliseconds = ?, Bytes = ?, UnitPrice = ? WHERE TrackId = ?';  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$name, $albumId, $mediaType, $genreId, $composer , $time , $bytes , $price, $id]);
        if(!$stmt) {
            return false;
        }
        $this->closeConnection();
        return true; 

    }
    function delete($id){
        //check if theres an track connected
        //check if theres any invoice
        $query = "DELETE FROM track WHERE TrackId LIKE ?;";  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);            
        if(!$stmt) {
            return false;
        }
        $this->closeConnection();
        return true; 
    } 
    function search($name){
        $query = <<<'SQL'
        SELECT track.TrackId, track.Name AS Track, album.Title AS Album,  artist.Name AS Artist, genre.Name AS Genre, track.GenreId, mediatype.Name AS Mediatype, track.MediaTypeId,
        track.Composer, track.Milliseconds, track.UnitPrice, track.AlbumId
        FROM track 
        INNER JOIN album ON album.AlbumId = track.AlbumId
        INNER JOIN genre ON genre.GenreId = track.GenreId
        INNER JOIN mediatype ON mediatype.MediaTypeId = track.MediaTypeId
        INNER JOIN artist ON artist.ArtistId = album.ArtistId
        WHERE track.Name LIKE ?;
        SQL; 
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['%'.$name.'%']);        
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();  
        $this->closeConnection();   
        return $results;   
        
    }

    function readGenre(){
        $query = "SELECT * FROM genre;";
           
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();  
        $this->closeConnection();   
        return $results;   
    }  

    function readMedia(){
        $query = "SELECT * FROM mediatype;";
           
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();  
        $this->closeConnection();   
        return $results;   
    }  
  

}

?>