<?php
class pizzalist extends dao {

  private $pizzalist;


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

  public function showpizzas(){

    $sql  ='SELECT PizzaID FROM pizza';
    $con  = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = array();
    while($row  = $stmt->fetch(PDO::FETCH_ASSOC)){

      $data[] = $row;

    }
    if(!empty($data)){

      $iteration              = 0;
      $sizeofarray            = sizeof($data);
      $pizzalistarrayofobject = [];
      $pizzalistarrayofarray  = [];
      //$data Dizinde Her Index Bir Nesne Olarak yaratik ve sound bu nesneler bir dizi koyduk
      while($iteration < $sizeofarray ){
        $newpizza = new pizza();
        $newpizza->__set('PizzaID', $data[$iteration]['PizzaID']);
        

        $pizzalistarrayofarray  [$iteration] = $newpizza->get();
        $pizzalistarrayofobject [$iteration] = $newpizza;
        $iteration++;
      } 
      $con = null;
      $this->__set('pizzalist' , $pizzalistarrayofobject);
      return $pizzalistarrayofarray;
    }else{
      return false;

    }
  }

  public function getorderspizza ($id){

    $sql  = 'SELECT PizzaID FROM pizza WHERE OrderID = ' . $id;
    $con  = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = [];
    while($row  = $stmt->fetch(PDO::FETCH_ASSOC)){

      $data[] = $row;
      
    }
    if(!empty($data)){
      $sizeofarray =sizeof($data);

      $iteration              = 0;
      $sizeofarray            = sizeof($data);
      $pizzalistarrayofobject = [];
      $pizzalistarrayofarray  = [];
      //$data Dizinde Her Index Bir Nesne Olarak yaratik ve sound bu nesneler bir dizi koyduk
      while($iteration < $sizeofarray ){
        $newpizza = new pizza();
        $newpizza->__set('PizzaID', $data[$iteration]['PizzaID']) ;
        $pizzalistarrayofarray  [$iteration] = $newpizza->get();
        $pizzalistarrayofobject [$iteration] = $newpizza;
        $iteration++;
      } 
      $con = null;
      $this->__set('pizzalist' , $pizzalistarrayofobject);
      return $pizzalistarrayofarray;
    }else{

      return false;

    }
  }
}