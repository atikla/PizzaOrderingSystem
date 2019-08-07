<?php
class nonpizzalist extends dao {

  private $nonpizzalist;
  
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
  //Show all 
  public function shownonpizzas(){

    $sql='SELECT nonID FROM nonpizza';
    $con = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = array();
    $counter = 0;
    // gonderilen Sotguden gelen Butun Satirlar bir diziye koydum ve her index butun nonpizzain biligleri icerir
    while($row  = $stmt->fetch(PDO::FETCH_ASSOC)){

      $data[] = $row;
      

    }
    if(!empty($data)){

      $counter1 = 0;
      $sizeofarray =sizeof($data);
      $i = 0;
      $nonpizzalistarrayofobject = [];
      $nonpizzalistarrayofarray = [];
      //$data Dizinde Her Index Bir Nesne Olarak yaratik ve sound bu nesneler bir dizi koyduk
      while($i < $sizeofarray ){
        $newnonpizza = new nonpizza();
        $newnonpizza->__set('nonID', $data[$i]['nonID']);
        
        $nonpizzalistarrayofarray  [$i] = $newnonpizza->get();
        $nonpizzalistarrayofobject [$i] = $newnonpizza;
        $i++;
      }
      $con = null;
      $this->__set('nonpizzalist' , $nonpizzalistarrayofobject);
      return $nonpizzalistarrayofarray;
    }else{
      return false;

    }
  }

  public function shownonpizzasbucat($Category){

    $sql='SELECT nonID FROM nonpizza WHERE nonCategory = "' . $Category . '";';
    $con = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = array();
    $counter = 0;
    // gonderilen Sotguden gelen Butun Satirlar bir diziye koydum ve her index butun nonpizzain biligleri icerir
    while($row  = $stmt->fetch(PDO::FETCH_ASSOC)){

      $data[] = $row;
      

    }
    if(!empty($data)){

      $counter1 = 0;
      $sizeofarray =sizeof($data);
      $i = 0;
      $nonpizzalistarrayofobject = [];
      $nonpizzalistarrayofarray = [];
      //$data Dizinde Her Index Bir Nesne Olarak yaratik ve sound bu nesneler bir dizi koyduk
      while($i < $sizeofarray ){
        $newnonpizza = new nonpizza();
        $newnonpizza->__set('nonID', $data[$i]['nonID'] );
        
        $nonpizzalistarrayofarray  [$i] = $newnonpizza->get();
        $nonpizzalistarrayofobject [$i] = $newnonpizza;
        $i++;
      }
      $con = null;
      $this->__set('nonpizzalist', $nonpizzalistarrayofobject );
      return $nonpizzalistarrayofarray;
    }else{
      return false;

    }
  }

  public function getprice(){

    $sql='SELECT nonID FROM nonpizza';
    $con = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = array();
    $object = array();

    // gonderilen Sotguden gelen Butun Satirlar bir diziye koydum ve her index butun ingredientsin biligleri icerir
    while($row  = $stmt->fetchcolumn(0)){

      $newingredients = new ingredients();
      $newingredients->__set( 'IngID'     , $row);
      $data[] = $newingredients->get();
      $object[] = $newingredients;
      
    }
    if(!empty($data)){
      
      $this->__set('ingredientslist' , $object);
      return $data;
    }else{
      return false;

    }
  }
}