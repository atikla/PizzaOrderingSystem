<?php

class customer extends dao{

  
  private $CustomerID;
  private $CustomerPhone;
  private $CustomerEmail;
  private $CustomerFname;
  private $CustomerLname;

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

  //Get Customer By ID
  public function get(){

    $sql   = 'SELECT * FROM customer WHERE CustomerID = ' . $this->__get('CustomerID');
    $con   = $this->openconnection();
    $stmt  = $con->prepare($sql);
    $stmtr = $stmt->execute();
    $data  = $stmt->fetch(PDO::FETCH_ASSOC);
    //echo var_dump($data);
    
    if(!empty($data)){
      
      $this->__set( 'CustomerPhone',  $data['CustomerPhone'] );
      $this->__set( 'CustomerEmail',  $data['CustomerEmail'] );
      $this->__set( 'CustomerFname',  $data['CustomerFname'] );
      $this->__set( 'CustomerLname',  $data['CustomerLname'] );
     
      return $data;
    } else {
      return false;
      

    }
  }

  public function validate(){

    $sql    = 'SELECT * FROM customer WHERE CustomerEmail = "' . $this->__get('CustomerEmail');
    $sql   .= '" AND CustomerPhone = "' . $this->__get('CustomerPhone') . '"';
    //$sql   .= '" AND CustomerFname = "' . $this->__get('CustomerFname') . '" AND CustomerLname = "' . $this->__get('CustomerLname') . '"';
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    $data   = $stmt->fetch(PDO::FETCH_ASSOC);
    $con    = null;

    if(!empty($data)){
      
      $this->__set('CustomerID', $data['CustomerID']);
      return true;
     
    } else {
      return false;
      

    }
  }

  public function customerorders(){


    $validate = $this->validate();
    if (!$validate){

      echo 'empty';
      
    }else{

      $orderlist = new orderlist();
      $preorder  = $orderlist->showpreorder($this->__get('CustomerID'));
      return $preorder;

    }

    // $sql   = 'SELECT * FROM customer WHERE CustomerID = ' . $this->__get('CustomerID');
    // $con   = $this->openconnection();
    // $stmt  = $con->prepare($sql);
    // $stmtr = $stmt->execute();
    // $data  = $stmt->fetch(PDO::FETCH_ASSOC);
    // //echo var_dump($data);
    
    // if(!empty($data)){
      
    //   $this->__set( 'CustomerPhone',  $data['CustomerPhone'] );
    //   $this->__set( 'CustomerEmail',  $data['CustomerEmail'] );
    //   $this->__set( 'CustomerFname',  $data['CustomerFname'] );
    //   $this->__set( 'CustomerLname',  $data['CustomerLname'] );
     
    //   return $data;
    // } else {
    //   return false;
      

    // }
  }

  public function insert(){

    $sql    = 'INSERT INTO customer (CustomerEmail, CustomerPhone, CustomerFname, CustomerLname)';
    $sql   .= 'VALUES ("'. $this->__get('CustomerEmail') .'","';
    $sql   .= '' . $this->__get('CustomerPhone') .'", "'. $this->__get('CustomerFname') . '", "';
    $sql   .= '' .  $this->__get('CustomerLname') . '")';
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    try{
      $stmt   = $stmt->execute();
      $stmtid = $con->query("SELECT LAST_INSERT_ID()");
      $lastId = $stmtid->fetchColumn();
      $con    = null;
      if(!$stmt){

      return false;

      } else {

        $this->__set('CustomerID', $lastId);
        return true;

      }
    }catch(Exception $e) {
      $Error = 'Bir hata Olustu lutfen tekra deniniz';
      return $Error;
    }
    
  }
  

  //update Admin
  public function update(){

    $sql    = 'UPDATE customer SET CustomerPhone = "' . $this->__get('CustomerPhone') . '", ';
    $sql   .= 'CustomerEmail = "' . $this->__get('CustomerEmail') . '", ';
    $sql   .= 'CustomerFname = "' . $this->__get('CustomerFname') . '", ';
    $sql   .= 'CustomerLname = "' . $this->__get('CustomerLname') . '" ';
    $sql   .= 'WHERE CustomerID =' . $this->__get('CustomerID');
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmt   = $stmt->execute();
    $con   = null;
    if(!$stmt){
      //echo "FROM MODEL <br>";
        return false;
    } else {
      //echo "FROM MODELllll true<br>" . $lastId;
      return true;
      
    }
  }  
  public function delete(){

    $sql    = 'DELETE FROM customer WHERE CustomerID = ' . $this->__get('CustomerID');
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    //echo 'FROM DELETE FUNCTION ' . $stmtr . '<br>';
    $con   = null;
    if(!$stmtr){
      //echo "FROM MODEL <br>";
        return false;
    } else {
      return true;
      //echo "FROM MODEL<br>";
    }
  }
}
