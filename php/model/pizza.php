<?php

class pizza extends dao{

  
  private $PizzaID;
  private $OrderID;
  private $Price;
  private $Amount;
  Private $PizzaSize;
  private $PizzaDough;
  private $PizzaIngList;
  

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

  public function get(){

    $sql='SELECT * FROM pizza WHERE PizzaID = ' . $this->__get('PizzaID');
    //$sql='SELECT * FROM pizza';
    $con = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = array();
    $counter = 0;
    $data = $stmt->fetch(PDO::FETCH_ASSOC) ;
    if(!empty($data)){


      $newpizzaing = new pizzaingredientslist();
      $newinglist = $newpizzaing->getpizzaingredients($this->__get('PizzaID'));

      $this->__set(       'Price',  $data['Price']);
      $this->__set(      'Amount',  $data['Amount']);
      $this->__set(     'PizzaID',  $data['PizzaID']);
      $this->__set(     'OrderID',  $data['OrderID']);
      $this->__set(   'PizzaSize',  $data['PizzaSize']);
      $this->__set(  'PizzaDough',  $data['PizzaDough']);
      $this->__set('PizzaIngList',  $newinglist);
      $pizza = array(
          'PizzaID'       => $data['PizzaID'],
          'OrderID'       => $data['OrderID'],
          'Price'         => $data['Price'],
          'Amount'        => $data['Amount'],
          'PizzaSize'     => $data['PizzaSize'],
          'PizzaDough'    => $data['PizzaDough'],
          'PizzaIngList'  => $newinglist,
          ); 
      $con = null;
      return $pizza;
    } else {

      return false;

    }
  }

  public function insert(){

    $sql    = 'INSERT INTO pizza (OrderID, Price, Amount, PizzaSize, PizzaDough)';
    $sql   .= 'VALUES ("'. $this->__get('OrderID') . '","';
    $sql   .= '' . $this->__get('Price')     . '", "' . $this->__get('Amount')     . '","';
    $sql   .= '' . $this->__get('PizzaSize') . '", "' . $this->__get('PizzaDough') . '");';
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmtr  = $stmt->execute();
    $stmtid = $con->query("SELECT LAST_INSERT_ID()");
    $lastId = $stmtid->fetchColumn();
    $con    = null;

    //set Pizza Id After Insert
    $this->__set('PizzaID', $lastId);
    
    $iteration    = 0 ;
    $numberofing  = sizeof($this->__get('PizzaIngList'));
    while ($iteration < $numberofing) {

      //Get Ing Id For Insert pizzaingredients 
      $ing = new ingredients();
      $ing->__set('IngName', $this->__get('PizzaIngList')[$iteration]);
      $ing->getidbyname();

      //insert pizzaingredients
      //4.2 - insert pizzza ing with pizzaID 
      $pizzaing = new pizzaingredients();
      $pizzaing->__set('PizzaID', $this->__get('PizzaID'));
      $pizzaing->__set('IngID', $ing->__get('IngID'));
      $pizzaing->insert();



      //echo '<br>inserted ' . $this->__get('PizzaIngList')[$iteration] . ' that have ID ' . $ing->__get('IngID') . ' For PizzaID ' . $this->__get('PizzaID') . '<br>';
      $iteration++;
    }

    if(!$stmtr){

        return false;

    } else {
      
      return true;

    }
  }

  public function delete(){

    $sql    = 'DELETE FROM pizza WHERE PizzaID = ' . $this->__get('PizzaID');
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
