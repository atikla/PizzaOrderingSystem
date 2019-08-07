<?php

class ordernonpizzalist extends dao {

private $ordernonpizzalist;

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


public function getordernonpizza($id){

  $sql    = 'SELECT OrderNonPizzaID FROM ordernonpizza WHERE OrderID = ' . $id;
  $con    = $this->openconnection();
  $stmt   = $con->prepare($sql);
  $stmtr  = $stmt->execute(); 
  $data   = [];
  while($row  = $stmt->fetchcolumn(0)){

    $ordernonpizza = new ordernonpizza();
    $ordernonpizza->__set('OrderNonPizzaID', $row);
    $data[] = $ordernonpizza->get();
    
  }
  $con  = null;
  if(!empty($data)){

    return $data;
      
  } else {
    
    return false;
  }
}

}