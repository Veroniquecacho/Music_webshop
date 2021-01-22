<?php
require_once('connection.php');
class Album extends Database{
    function get($id){
        $query = <<<'SQL'
                SELECT AlbumId, album.Title AS Album, artist.Name AS Artist, album.ArtistId
                FROM album 
                INNER JOIN artist ON artist.ArtistId = album.ArtistId
                WHERE AlbumId LIKE ?;
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
    function create($title, $artistId){
        $query = 'INSERT INTO album (Title, ArtistId) VALUES (?, ?);';  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$title, $artistId]);
        if(!$stmt) {
            return false;
        }
        $id = $this->pdo->lastInsertId();
        $created_album = array('id' => $id, 'title' => $title, 'artistId' => $artistId, );
        $this->closeConnection();   
        return $created_album;    
    } 
    function read($offset){

        if($offset > 0){
            $offset = $offset * 30 + 1;
          } else {
            $offset = 1;
          }
        $query = <<<'SQL'
                SELECT AlbumId, album.Title AS Album, artist.Name AS Artist
                FROM album 
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
                SELECT AlbumId, album.Title AS Album, artist.Name AS Artist
                FROM album 
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
    function update($id, $title, $artistId){

        $query = 'UPDATE album SET Title = ?, ArtistId = ? WHERE AlbumId = ?';  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$title, $artistId, $id]);
        if(!$stmt) {
            return false;
        }
        $this->closeConnection();
        return true; 

    }
    function delete($id){
        $query = "DELETE FROM album WHERE AlbumId LIKE ?;";  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);            
        if(!$stmt) {
            return false;
        }
        $this->closeConnection();
        return true; 
    } 
    function search($title){
        $query = <<<'SQL'
        SELECT AlbumId, album.Title AS Album, artist.Name AS Artist
        FROM album 
        INNER JOIN artist ON artist.ArtistId = album.ArtistId
        WHERE Title LIKE ?;
    SQL; 
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['%'.$title.'%']);        
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();  
        $this->closeConnection();   
        return $results;   
        
    }

    function getTracks($id){
        $query = <<<'SQL'
             SELECT track.TrackId, track.Name AS Track, album.Title AS Album, track.AlbumId, artist.Name AS Artist, artist.ArtistId, genre.Name AS Genre, track.GenreId, mediatype.Name AS Mediatype, track.MediaTypeId,
            track.Composer, track.Milliseconds, track.UnitPrice, track.Bytes
            FROM track 
            INNER JOIN album ON album.AlbumId = track.AlbumId
            INNER JOIN genre ON genre.GenreId = track.GenreId
            INNER JOIN mediatype ON mediatype.MediaTypeId = track.MediaTypeId
            INNER JOIN artist ON artist.ArtistId = album.ArtistId
            WHERE track.AlbumId = ?;
        SQL; 
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();
        $this->closeConnection();   
        return $results;         
    } 
  
  

}

?>