<?php

class order extends dao{

  
  private $OrderID;
  private $CustomerID;
  private $TotalPrice;
  private $Status;
  private $OrderAddress;
  private $OrderTime;
  private $OrderDeliverTime;
  private $pizzalist;
  private $nonpizzalist;
  private $payment;
  private $Customer;


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

  //Get Order details By ID
  public function getdetails(){
    $data = $this->get();
    if(!empty($data)){
      $pizzalist  = new pizzalist();
      $nonpizza   = new ordernonpizzalist();
      $payment    = new payment();
      $customer   = new customer();

      $customer->__set('CustomerID',   $this->__get('CustomerID'));
      $payment->__set( 'CustomerID',   $this->__get('CustomerID'));
      $payment->__set(    'OrderID',      $this->__get('OrderID'));
  

      $data['pizza']    = $pizzalist->getorderspizza($this->__get('OrderID'));
      $data['nonpizza'] = $nonpizza->getordernonpizza($this->__get('OrderID'));
      $data['payment']  = $payment->getbyorderid();
      $data['Customer'] = $customer->get();   

      // $this->__set('Customer', $data[0]['CustomerID']);
      // $this->__set('TotalPrice', $data[0]['TotalPrice']);
      // $this->__set( 'Status', $data[0]['Status']);
      // $this->__set( 'OrderAddress', $data[0]['OrderAddress']);
      // $this->__set( 'OrderTime', $data[0]['OrderTime']);
      // $this->__set( 'OrderDeliverTime', $data[0]['OrderDeliverTime']);
      $this->__set(    'pizzalist', $data['pizza']);
      $this->__set( 'nonpizzalist', $data['nonpizza']);
      $this->__set(      'payment', $data['payment']);
      $this->__set(     'Customer', $data['Customer']);
    
      return $data;
    } else {

      return false;

    }
  }


  public function get(){

    $sql  = 'SELECT * FROM fullorder WHERE OrderID = ' . $this->__get('OrderID');
    $con  = $this->openconnection();
    $stmt  = $con->prepare($sql);
    $stmtr = $stmt->execute();
    $data = array();
    $data  = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($data)){
      
      $this->__set(           'Status', $data['Status']);
      $this->__set(        'OrderTime', $data['OrderTime']);
      $this->__set(       'TotalPrice', $data['TotalPrice']);
      $this->__set(       'CustomerID', $data['CustomerID']);
      $this->__set(     'OrderAddress', $data['OrderAddress']);
      $this->__set( 'OrderDeliverTime', $data['OrderDeliverTime']);

      return $data;
    } else {
      return false;
    }
  }

  public function preorders(){

    $sql  = 'SELECT OrderID FROM fullorder WHERE CustomerID = ' . $this->__get('CustomerID');
    $con  = $this->openconnection();
    $stmt  = $con->prepare($sql);
    $stmtr = $stmt->execute();
    $data = array();
    $data  = array();
    while($row  = $stmt->fetchColumn()){

      $data[] = $row;
      
    }
    return $data;
  }

  //Get Order details By ID
  public function create($JSON){

    // Steps 
    // 0 - set Order Attr
    // 1 - validate Customer (1,0)(getID, insert)
    // 2 - insert Order with CustomerID
    // 3 - get Order ID By query("SELECT LAST_INSERT_ID()");
    // 4 - insert Pizza with oreder ID 
    //  4.1 - get pizza ID By query("SELECT LAST_INSERT_ID()");
    //  4.2 - insert pizzza ing with pizzaID 
    // 5 - insert ordernonpizza with oredr ID
    // 6 - insert Payment For this Order with CostomerID and OrderID 
    // 7 - return Order Object With all info (pizza[ing], nonpizza[], payment[], Customer[], Order)
    
    // 0 - Set Order Attr 

    $this->__set('TotalPrice', $JSON['TotalPrice']);
    $this->__set( 'OrderAddress', $JSON['OrderAddress']);

    // 1 - Valvalidate 

    $customer = new customer();
    $customer->__set('CustomerPhone', $JSON['Customer']['CustomerPhone']);
    $customer->__set('CustomerEmail', $JSON['Customer']['CustomerEmail']);
    $customer->__set('CustomerFname', $JSON['Customer']['CustomerFname']);
    $customer->__set('CustomerLname', $JSON['Customer']['CustomerLname']);
    $customer->validate();

    $validate = $customer->validate();
    if (!$validate){
      $customer->insert();
    }

    //2 - insert Order with CustomerID
    // 3 - get Order ID By query("SELECT LAST_INSERT_ID()");
    $this->__set('CustomerID', $customer->__get('CustomerID'));
    $this->__set('CustomerID', $customer->__get('CustomerID'));
    $this->insert();
    
    //For Insert Pizza
    $numberofpizza = sizeof($JSON['pizza']);
    $iteration = 0 ;
    while ($iteration < $numberofpizza) {

    // 4 - insert Pizza with oreder ID
    //  4.1 - get pizza ID By query("SELECT LAST_INSERT_ID()");
      $pizza = new pizza();
      
      $pizza->__set(     'OrderID', $this->__get('OrderID'));
      $pizza->__set(       'Price', $JSON['pizza'][$iteration]['Price']);
      $pizza->__set(      'Amount', $JSON['pizza'][$iteration]['Amount']);
      $pizza->__set(   'PizzaSize', $JSON['pizza'][$iteration]['PizzaSize']);
      $pizza->__set(  'PizzaDough', $JSON['pizza'][$iteration]['PizzaDough']);
      $pizza->__set('PizzaIngList', explode(",", $JSON['pizza'][$iteration]['PizzaIngList']));
      
      $pizza->insert();
      $iteration++;

    }


    //ForInsert Nonpizza if order has

    $numberofnonpizza = sizeof($JSON['nonpizza']);
    $iteration = 0 ;

    if ($numberofnonpizza != 0){


      while ($iteration < $numberofnonpizza) {
  
        // 5 - insert ordernonpizza with oredr ID
        $nonpizza = new nonpizza();
  
        $nonpizza->__set('nonName', $JSON['nonpizza'][$iteration]['nonName']);
        $nonpizza->getidbyname();
  
        $ordernonpizza = new ordernonpizza();
        $ordernonpizza->__set('OrderID', $this->__get('OrderID'));
        $ordernonpizza->__set('nonID', $nonpizza->__get('nonID'));
        $ordernonpizza->__set('amount', $JSON['nonpizza'][$iteration]['amount']);
        $ordernonpizza->insert();
        $iteration++;
      }
    }


    // 6 - insert Payment
    $payment = new payment();

    $payment->__set(    'OrderID', $this->__get('OrderID'));
    $payment->__set( 'CustomerID', $this->__get('CustomerID'));
    $payment->__set('PaymentType', $JSON['payment']['PaymentType']);
    $payment->insert();




    // echo '<br><pre>';
    // echo var_dump($this);
    // echo '</pre><br>';
    
    //$result = $this->getdetails();
    $result = $this->__get('OrderID');
    return $result;

  }

  public function insert(){

    $sql    = 'INSERT INTO fullorder (CustomerID, TotalPrice, OrderAddress)';
    $sql   .= 'VALUES ("'. $this->__get('CustomerID') .'","';
    $sql   .= '' . $this->__get('TotalPrice') .'", "'. $this->__get('OrderAddress') . '");';
    try {
      $con  = $this->openconnection();
      $stmt  = $con->prepare($sql);
      $stmtr = $stmt->execute();
      $stmtid = $con->query("SELECT LAST_INSERT_ID()");
      $lastId = $stmtid->fetchColumn();
      $con   = null;
      if(!$stmtr){
  
          return false;
  
      } else {
        $this->__set('OrderID', $lastId);
        return true;
  
      }
    } catch (Exception $th) {
      echo $th;
    }
  }
  //update orderstatusecho gmdate('Y-m-d h:i:s', time());
  public function update(){

    $sql    = 'UPDATE fullorder SET ';
    $sql   .= 'Status = "' . $this->__get('Status') . '"';
    if ($this->__get('Status') == 'Delivered') {
      $date = date('Y-m-d');
      $time = $date . '' . time();
      $sql   .= ', OrderDeliverTime = NOW() ';
    }
    $sql   .= 'WHERE OrderID =' . $this->__get('OrderID');
    $con    = $this->openconnection();
    $stmt   = $con->prepare($sql);
    $stmt   = $stmt->execute(); 
    $con   = null;
    if(!$stmt){
      //echo "FROM MODEL <br>";
        return false;
    } else {
      //echo "FROM MODELllll true<br>" . $lastId;
      return true;
      
    }
  }
  //Delete Order
  public function delete(){

    $sql  = 'DELETE FROM fullorder WHERE OrderID = ' . $this->__get('OrderID');
    $con  = $this->openconnection();
    $stmt  = $con->prepare($sql);
    $stmtr = $stmt->execute();
    $con   = null;
    if(!$stmtr){

        return false;

    } else {

      return true;

    }
  }

}
