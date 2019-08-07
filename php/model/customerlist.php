<?php
class customerlist extends dao {

  private $customerlist;


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

  public function showcustomers(){

    $sql='SELECT CustomerID FROM customer';
    $con = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = array();
    while($row  = $stmt->fetch(PDO::FETCH_ASSOC)){

      $data[] = $row;

    }
    if(!empty($data)){

      $iteration                  = 0;
      $sizeofarray                = sizeof($data);
      $customerlistarrayofobject  = [];
      $customerlistarrayofarray   = [];
      while($iteration < $sizeofarray ){
        $newcustomer = new customer();
        $newcustomer->__set('CustomerID', $data[$iteration]['CustomerID']);
        
        $customerlistarrayofarray  [$iteration] = $newcustomer->get(); 
        $customerlistarrayofobject [$iteration] = $newcustomer;
        
        $iteration++;
      }
      $con = null;
      $this->__set('customerlist' , $customerlistarrayofobject);
      return $customerlistarrayofarray;
    } else {
      return false;
    }
  }
}