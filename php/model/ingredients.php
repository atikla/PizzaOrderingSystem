<?php

class ingredients extends dao{

  
  private $IngID;
  private $IngName;
  private $IngPrice;
  

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

    $sql    = 'INSERT INTO ingredients (IngName, IngPrice)';
    $sql   .= 'VALUES ("'. $this->__get('IngName') .'","';
    $sql   .= '' . $this->__get('IngPrice') .'")';
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmt   = $stmt->execute();
    $stmtid = $con->query("SELECT LAST_INSERT_ID()");
    $lastId = $stmtid->fetchColumn();   
    $con    = null;
    if(!$stmt){
      //echo "FROM MODEL <br>";
        return false;
    } else {
      
      //echo "FROM MODELllll true<br>" . $lastId;
      return true;

    }
  }

  //update Ing
  public function update(){

    $sql    = 'UPDATE ingredients SET IngName = "' . $this->__get('IngName') . '", ';
    $sql   .= 'IngPrice = "' . $this->__get('IngPrice') . '" ';
    $sql   .= 'WHERE IngID =' . $this->__get('IngID');
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

  public function get(){

    $sql    = 'SELECT * FROM ingredients WHERE IngID = ' . $this->__get('IngID');
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    $data   = array();
    //echo 'FROM DELETE FUNCTION ' . $stmtr . '<br>';

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!empty($data)){

      $this->__set(  'IngName',  $data['IngName'] );
      $this->__set( 'IngPrice',  $data['IngPrice'] );

      $newarray = array (

        'IngID'     => $data['IngID'],
        'IngName'   => $data['IngName'],
        'IngPrice'  => $data['IngPrice'],

      );
      
      return $newarray;

    } else {

      return false;

    }
  }

  public function getidbyname(){

    $sql    = 'SELECT IngID FROM ingredients WHERE IngName = "' . $this->__get('IngName') . '"';
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    $data   = array();
    //echo 'FROM DELETE FUNCTION ' . $stmtr . '<br>';

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!empty($data)){

      $this->__set(  'IngID',  $data['IngID'] );

      return true;

    } else {

      return false;

    }
  }

  public function getnamebyid(){

    $sql    = 'SELECT IngName FROM ingredients WHERE IngID = "' . $this->__get('IngID') . '"';
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    $data   = array();
    //echo 'FROM DELETE FUNCTION ' . $stmtr . '<br>';

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!empty($data)){

      $this->__set(  'IngName',  $data['IngName'] );

      return $data['IngName'];

    } else {

      return false;

    }
  }

  public function delete(){

    $sql    = 'DELETE FROM ingredients WHERE IngID = ' . $this->__get('IngID');
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
