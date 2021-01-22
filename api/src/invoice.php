<?php

require_once('connection.php');
class Invoice extends Database{

    function getInvoice($id){
        $query = "SELECT * FROM invoice WHERE CustomerId = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();
        $this->closeConnection();   
        return $results;    

    }
    function getInvoicelines($id){
        $query = "SELECT * FROM invoiceline WHERE InvoiceId = (SELECT InvoiceId FROM invoice WHERE InvoiceId = ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        if(!$stmt) {
            return false;
        }
        $results = $stmt->fetchAll();
        $this->closeConnection();   
        return $results;    

    }

    function createInvoice($customerId, $invoiceDate, $billingAddress, $billingCity, $billingState, $billingCountry, $billingPostalCode, $total){
        $query = 'INSERT INTO invoice (CustomerId, InvoiceDate, BillingAddress, BillingCity, BillingState, BillingCountry, BillingPostalCode, Total) VALUES (?, ?, ?, ?, ?, ?, ?, ?);';  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$customerId, $invoiceDate, $billingAddress, $billingCity, $billingState, $billingCountry, $billingPostalCode, $total]);
        if(!$stmt) {
            return false;
        }
        $id = $this->pdo->lastInsertId() ;
        $this->closeConnection();   
        return $id;    
    } 
    function createInvoiceLine($invoiceId, $trackId, $unitPrice, $quantity){
        $query = 'INSERT INTO invoiceline (InvoiceId, TrackId, UnitPrice, Quantity) VALUES (?, ?, ?, ?);';  
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$invoiceId, $trackId, $unitPrice, $quantity]);
        if(!$stmt) {
            return false;
        }
        $id = $this->pdo->lastInsertId() ;
        $this->closeConnection();   
        return $id;    
    } 

}

?>