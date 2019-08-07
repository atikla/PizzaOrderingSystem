<?php

class pizzaingredients extends dao{

  
  private $PizzaIngredientID;
  private $PizzaID;
  private $IngID;
  

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

    $sql    = 'INSERT INTO pizzaingredients (PizzaID, IngID)';
    $sql   .= 'VALUES ("'. $this->__get('PizzaID') .'","';
    $sql   .= '' . $this->__get('IngID') .'")';
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


    $sql    = 'SELECT * FROM pizzaingredients WHERE PizzaIngredientID = ' . $this->__get('PizzaIngredientID');
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
      
      $this->__set('IngID', $data['IngID']);
      $this->__set('PizzaID', $data['PizzaID']);
      $this->__set('PizzaIngredientID', $data['PizzaIngredientID']);
      
      $Ing = new ingredients();
      $Ing -> __set('IngID', $data['IngID']);
      $name = $Ing -> getnamebyid();
      return $name;
        
    } else {
      return false;
    }
  }

}
