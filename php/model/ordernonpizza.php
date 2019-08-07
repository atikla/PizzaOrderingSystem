<?php

class ordernonpizza extends dao{

  
  private $OrderNonPizzaID;
  private $OrderID;
  private $nonID;
  private $amount;
  

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

    $sql    = 'INSERT INTO ordernonpizza (OrderID, nonID, amount)';
    $sql   .= 'VALUES ("'. $this->__get('OrderID') .'","';
    $sql   .= '' . $this->__get('nonID') .'", "'. $this->__get('amount') .'")';
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmt   = $stmt->execute();  
    $con    = null;
    if(!$stmt){

        return false;
        
    } else {

      return true;
      
    }
  }

  public function get(){
    $sql    = 'SELECT * FROM ordernonpizza WHERE OrderNonPizzaID = ' . $this->__get('OrderNonPizzaID');
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute(); 
    $data   = [];
    // while($row  = $stmt->fetch(PDO::FETCH_ASSOC)){

    //   $data[] = $row;
      
    // }
    
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $con   = null;
    if(!empty($data)){

      $this->__set(   'nonID', $data['nonID']);
      $this->__set(  'amount', $data['amount']);
      $this->__set( 'OrderID', $data['OrderID']);

      $nonPizza = new nonpizza();
      $nonPizza ->__set('nonID', $data['nonID']);
      $name = $nonPizza->getnamebyid();

      $newarray = array(
          'OrderNonID' => $data['OrderNonPizzaID'],
          'nonID' => $data['nonID'],
          'nonName' => $name,
          'amount'=> $data['amount'],
      );
      return $newarray; 
    } else {
      
      return false;
    }
  }

  public function delete(){
    $sql  = 'DELETE FROM ordernonpizza WHERE OrderNonPizzaID = ' . $this->__get('OrderNonPizzaID');
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



