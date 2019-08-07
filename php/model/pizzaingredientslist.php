<?php 

class pizzaingredientslist extends dao {

  private $Pizzainglist;

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

  public function getpizzaingredients($id){

    $sql    = 'SELECT PizzaIngredientID FROM pizzaingredients WHERE PizzaID = ' . $id;
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute(); 
    $data   = [];
    while($row  = $stmt->fetchcolumn(0)){

      $pizzaing = new pizzaingredients();
      $pizzaing->__set('PizzaIngredientID', $row);
      $data[] = $pizzaing->get();
      
    }
    $con   = null;
    if(!empty($data)){

      return $data;        
    } else {
      
      return false;
    }
  }
}