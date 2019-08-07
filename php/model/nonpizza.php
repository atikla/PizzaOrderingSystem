<?php

class nonpizza extends dao{

  
  private $nonID;
  private $nonPrice;
  private $nonName;
  private $nonCategory;
  

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

    $sql    = 'INSERT INTO nonpizza (nonPrice, nonName, nonCategory)';
    $sql   .= 'VALUES ("'. $this->__get('nonPrice') .'", "' . $this->__get('nonName') .'", "';
    $sql   .= '' . $this->__get('nonCategory') .'")';
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

  //update nonpizza
  public function update(){

    $sql    = 'UPDATE nonpizza SET nonID = "' . $this->__get('nonID') . '", ';
    $sql   .= 'nonPrice = "' . $this->__get('nonPrice') . '", ';
    $sql   .= 'nonName = "' . $this->__get('nonName') . '", ';
    $sql   .= 'nonCategory = "' . $this->__get('nonCategory') . '"';
    $sql   .= 'WHERE nonID =' . $this->__get('nonID');
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


  // Get nonpizza info by ID
  public function get(){

    $sql    = 'SELECT * FROM nonpizza WHERE nonID = ' . $this->__get('nonID');
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    $data   = array();
    $data   = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($data)){

      $this->__set('nonPrice',  $data['nonPrice']);
      $this->__set( 'nonName',  $data['nonName'] );
      $this->__set('nonCategory',  $data['nonCategory']);

      return $data;
      
    } else {

      return false;

    }
  }

  //Get Id By Name
  public function getidbyname(){

    $sql    = 'SELECT nonID FROM nonpizza WHERE nonName = "' . $this->__get('nonName') . '"';
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    $data   = array();
    //echo 'FROM DELETE FUNCTION ' . $stmtr . '<br>';

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!empty($data)){

      $this->__set(  'nonID',  $data['nonID'] );

      return true;

    } else {

      return false;

    }
  }

  //Get Id By Name
  public function getnamebyid(){

    $sql    = 'SELECT nonName FROM nonpizza WHERE nonID = "' . $this->__get('nonID') . '"';
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    $data   = array();
    //echo 'FROM DELETE FUNCTION ' . $stmtr . '<br>';

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!empty($data)){

      $this->__set(  'nonName',  $data['nonName'] );

      return $data['nonName'];

    } else {

      return false;

    }
  }



  public function delete(){

    $sql  = 'DELETE FROM nonpizza WHERE nonID = ' . $this->__get('nonID');
    $con  = $this->openconnection();
    $stmt  = $con->prepare($sql);
    $stmtr = $stmt->execute();
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
