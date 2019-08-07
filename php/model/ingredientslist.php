<?php
class ingredientslist extends dao {

  private $ingredientslist;


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

  public function showingredients(){

    $sql  ='SELECT IngID FROM ingredients';
    $con  = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $con    = null;
    $data   = array();
    $object = array();

    // gonderilen Sotguden gelen Butun Satirlar bir diziye koydum ve her index butun ingredientsin biligleri icerir
    while($row  = $stmt->fetchcolumn(0)){

      $newingredients = new ingredients();
      $newingredients->__set( 'IngID'     , $row);
      $data[]   = $newingredients->get();
      $object[] = $newingredients;
      
    }
    if(!empty($data)){
      
      $this->__set('ingredientslist' , $object);
      return $data;
    } else {
      return false;

    }

  }

  public function getpizzaingredients($id){

    $sql  = 'SELECT IngID FROM pizzaingredients WHERE  PizzaID = ' . $id;
    $con  = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = array();
    // gonderilen Sotguden gelen Butun Satirlar bir diziye koydum ve her index butun ingredientsin biligleri icerir
    // while($row  = $stmt->fetch(PDO::FETCH_COLUMN, 0)){

    //   $data[$counter] = $row;
    //   $counter++;

    // }
    $data = $stmt->fetch(PDO::FETCH_ASSOC) ;
    if(!empty($data)){
      $con = null;
      $this->__set('ingredientslist' , $data);
      return $data;
    } else {
      return false;
    }
  }    

  public function get(){

    $sql  = 'SELECT IngID FROM ingredients';
    $con  = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = array();
    // gonderilen Sotguden gelen Butun Satirlar bir diziye koydum ve her index butun ingredientsin biligleri icerir
    while($row  = $stmt->fetch(PDO::FETCH_ASSOC)){

      $data[] = $row;

    }
    if(!empty($data)){

      $iteration                    = 0;
      $sizeofarray                  = sizeof($data);
      $ingredientslistarrayofobject = [];
      $ingredientslistarrayofarray  = [];
      //$data Dizinde Her Index Bir Nesne Olarak yaratik ve sound bu nesneler bir dizi koyduk
      while($iteration < $sizeofarray ){
        $newingredients = new ingredients();
        $newingredients->__set( 'IngID', $data[$iteration]['IngID'] );

        $ingredientslistarrayofarray  [$iteration] = $newingredients->get(); 
        $ingredientslistarrayofobject [$iteration] = $newingredients;
        $iteration++;
      } 
      $con = null;
      $this->__set( 'ingredientslist', $ingredientslistarrayofobject );
      return $ingredientslistarrayofarray;
    } else {
      return false;

    }

  }
} 