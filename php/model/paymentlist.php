<?php
class paymentlist extends dao {

  private $paymentlist;


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

  public function showpayments(){

    $sql  ='SELECT PaymentID FROM payment';
    $con  = $this->openconnection();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $data = array();
    
    while($row  = $stmt->fetch(PDO::FETCH_ASSOC)){

      $data[]= $row;
    }

    if(!empty($data)){

      $iteration                = 0;
      $sizeofarray              = sizeof($data);
      $paymentlistarrayofobject = [];
      $paymentlistarrayofarray  = [];
      //$data Dizinde Her Index Bir Nesne Olarak yaratik ve sound bu nesneler bir dizi koyduk
      while($iteration < $sizeofarray ){
        $newpayment = new payment();
        $newpayment->__set('PaymentID', $data[$iteration]['PaymentID']);

        $paymentlistarrayofarray  [$iteration] = $newpayment->get();
        $paymentlistarrayofobject [$iteration] = $newpayment;
        $iteration++;
      } 
      $con = null;
      $this->__set('paymentlist' , $paymentlistarrayofobject);

      return $paymentlistarrayofarray;
    } else {
      return false;

    }
  }
}