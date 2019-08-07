<?php

class admin extends dao{

  private $AdminID;
  private $AdminName;
  private $AdminUser;
  private $AdminPass;

  // function __construct(){

  // }
  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }

  public function __set($property, $value) {
    if (property_exists($this, $property)) {
      $this->$property = $value;
    }

    return $this;
  }

  public function login($AdminUser, $AdminPass){

    $sql = 'SELECT * FROM admin WHERE AdminUser = :AdminUser AND AdminPass = :AdminPass';
    // open Connection With database
    $con = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute(array(
        ':AdminUser' => $AdminUser,
        ':AdminPass' => $AdminPass,
      ));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($data) && sizeof($data) == 4){
      
      $this->__set( 'AdminName',   $data['AdminName'] );
      $this->__set(   'AdminID',   $data['AdminID'] );
      //close Connection With database
      $con = null;
      return true;
    }else{

      //close Connection With database
      $con = null;
      return false;
    }
  }
  //insert Admin
  public function insert(){

    $sql    = 'INSERT INTO admin (AdminName, AdminUser, AdminPass)';
    $sql   .= 'VALUES ("'. $this->__get('AdminName') .'","';
    $sql   .= '' . $this->__get('AdminUser') .'", "'. $this->__get('AdminPass') .'")';
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmt   = $stmt->execute();
    $stmtid = $con->query("SELECT LAST_INSERT_ID()");
    $lastId = $stmtid->fetchColumn();   
    $con   = null;
    if(!$stmt){
      //echo "FROM MODEL <br>";
        return false;
    } else {
      //echo "FROM MODELllll true<br>" . $lastId;
      return true;
      
    }
  }
  //update Admin
  public function update(){

    $sql    = 'UPDATE admin SET AdminName = "' . $this->__get('AdminName') . '", ';
    $sql   .= 'AdminUser = "' . $this->__get('AdminUser') . '", ';
    $sql   .= 'AdminPass = "' . $this->__get('AdminPass') . '" ';
    $sql   .= 'WHERE AdminID =' . $this->__get('AdminID');
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

  // Get admin By ID
  public function get(){

    $sql    = 'SELECT * FROM admin WHERE AdminID = ' . $this->__get('AdminID');
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    $data   = array();

    //echo 'FROM DELETE FUNCTION ' . $stmtr . '<br>';
    // while($row  = $stmt->fetch(PDO::FETCH_ASSOC)){

    //   $data[$counter] = $row;
    //   $counter++;

    // }
    $data = $stmt->fetch(PDO::FETCH_ASSOC) ;

    if(!empty($data)){
      $this->__set( 'AdminName',  $data['AdminName'] );
      $this->__set( 'AdminUser',  $data['AdminUser'] );
      $this->__set( 'AdminPass',  $data['AdminPass'] );
      return $data;

    } else {

      return false;

    }
  }
  public function delete(){

    $sql  = 'DELETE FROM admin WHERE AdminID = ' . $this->__get('AdminID');
    $con  = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt = $stmt->execute();
    //echo 'FROM DELETE FUNCTION ' . $stmtr . '<br>';
    $con   = null;
    if(!$stmt){
      //echo "FROM MODEL <br>";
      return false;
    } else {
      return true;
      //echo "FROM MODEL<br>";
    }
  }
}