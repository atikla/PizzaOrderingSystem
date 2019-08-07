<?php

class payment extends dao{

  
  private $PaymentID;
  private $OrderID; 
  private $CustomerID;
  private $PaymentType;
  

  //get property
  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }

  //set property
  public function __set($property, $value) {
    if (property_exists($this, $property)) {
      $this->$property = $value;
    }

    return $this;
  }


  public function insert(){
    if(!($this->getbyorderid() === false)){

      return 'You can not make another Payment to this Order';

    }else {
    
      $sql    = 'INSERT INTO payment (OrderID, CustomerID, PaymentType)';
      $sql   .= 'VALUES ("'. $this->__get('OrderID') .'","';
      $sql   .= '' . $this->__get('CustomerID') .'", "'. $this->__get('PaymentType') .'")';
      $con    = $this->openconnection();
      $stmt   = $con->prepare($sql);
      $stmt   = $stmt->execute();
      $stmtid = $con->query("SELECT LAST_INSERT_ID()");
      $lastId = $stmtid->fetchColumn();   
      $con    = null;
      if(!$stmt){
        // echo "FROM MODEL <br>";
          return false;
      } else {
        // echo "FROM MODELllll true<br>" . $lastId;
        return true; 
      }
    }
  }

  public function get(){

    $sql    = 'SELECT * FROM payment WHERE PaymentID = ' . $this->__get('PaymentID');
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    $data   = array();
    //echo 'FROM DELETE FUNCTION ' . $stmtr . '<br>';
    while($row  = $stmt->fetch(PDO::FETCH_ASSOC)){

      $data[] = $row;
      

    }
    if(!empty($data) && sizeof($data) == 1){
      $this->__set(     'OrderID', $data[0]['OrderID']);
      $this->__set(  'CustomerID', $data[0]['CustomerID']);
      $this->__set( 'PaymentType', $data[0]['PaymentType']);
      

      return $data;
      
    } else {

      return false;

    }
  }

  public function getbyorderid(){

    $sql    = 'SELECT * FROM payment WHERE OrderID = ' . $this->__get('OrderID');
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    $data   = array();
    $data   = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($data)){
      $this->__set(   'PaymentID', $data['PaymentID']);
      $this->__set(  'CustomerID', $data['CustomerID']);
      $this->__set( 'PaymentType', $data['PaymentType']);

      return $data;
      
    } else {

      return false;

    }
  }


  public function delete(){

    $sql    = 'DELETE FROM payment WHERE PaymentID = ' . $this->__get('PaymentID');
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    //echo 'FROM DELETE FUNCTION ' . $stmtr . '<br>';
    $con    = null;
    if(!$stmtr){
      //echo "FROM MODEL <br>";
      return false;
    } else {
      return true;
      //echo "FROM MODEL<br>";
    }
  }
}
