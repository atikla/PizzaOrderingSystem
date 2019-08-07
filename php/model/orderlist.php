<?php

class orderlist extends dao {

  private $orderlist;


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

  public function showorders(){

    $sql  ='SELECT OrderID FROM fullorder ORDER BY OrderID DESC';
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
      $orderlistarrayofobject = [];
      $orderlistarrayofarray  = [];
      //$data Dizinde Her Index Bir Nesne Olarak yaratik ve sound bu nesneler bir dizi koyduk
      while($iteration < $sizeofarray ){
        $neworder = new order();
        $neworder->__set('OrderID', $data[$iteration]['OrderID']);
        
        $orderlistarrayofarray  [$iteration] = $neworder->get();
        $orderlistarrayofobject [$iteration] = $neworder;
        $iteration++;
      } 
      $con = null;
      $this->__set('orderlist' , $orderlistarrayofobject);
      return $orderlistarrayofarray;
    } else {
      return false;
    }

  }

  // show order derails orderlist=>[Pizzalist=>pizzain[] 
  // nonpizzalist=>nonpizza], 
  public function showorder($id){

    $order = new order();
    $order->__set('OrderID', $id);
    $data  = $order->getdetails();
    if(!empty($data)){

      return $data;

    } else {
      return false;
    }
  }


  
  public function showpreorder($id){

    $order = new order();
    $order->__set('CustomerID', $id);
    
    $data  = $order->preorders();
    if(!empty($data)){

      $iteration              = 0;
      $sizeofarray            = sizeof($data);
      $orderlistarrayofobject = [];
      $orderlistarrayofarray  = [];
      //$data Dizinde Her Index Bir Nesne Olarak yaratik ve sound bu nesneler bir dizi koyduk
      while($iteration < $sizeofarray ){
        $neworder = new order();
        $neworder->__set('OrderID', $data[$iteration]);
        
        $orderlistarrayofarray  [$iteration] = $neworder->get();
        $orderlistarrayofobject [$iteration] = $neworder;
        $iteration++;
      } 
      $con = null;
      $this->__set('orderlist' , $orderlistarrayofobject);
      return $orderlistarrayofarray;

    } else {
      return false;
    }
  }
}