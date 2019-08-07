<?php 
require 'dao.php';
if (isset($_GET['method'])){

  $method = $_GET['method'];
  switch($method){

    
    // get price for nonpizza and ing 
    case'getprice':
      $dao = new dao();
      $result = $dao->getprice();
      if($result === false){
        echo 'empty';
      } else {

        // echo '<pre>';
        // echo var_dump($result);
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result;

      }
    break;

  /* -------------------------------------------
   * -------------------------------------------
   * -----------------admin------------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
    // Login For admin
    case'loginadmin':
      // for ajax header('Content-Type: application/json');
      // get varibel From URL
      $user = $_GET['user'];
      $pass = $_GET['pass'];
      $dao = new dao();
      $result = $dao->loginadmin( $user, $pass );
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else{
        // echo '<pre>';
        // echo var_dump($result);
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result;
      }
    break;

    //Show all admin 
    case'showalladmin':
      $dao = new dao();
      $result = $dao->showalladmin();
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        // echo '<pre>';
        // echo var_dump($result);
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result . ' <br>---------<br> ';
      }
    break;

    //insert admin
    case'insertadmin':
      $dao = new dao();
      $date = date('Y-m-d');
      $JSON = array(
       
        'AdminName' => 'NEWADMIN' . $date . '' . time(),
        'AdminUser' => 'NEWADMIN' . $date . '' . time(),
        'AdminPass' => 'NEWADMIN' . $date . '' . time(),
      );
      $result = $dao->insertadmin($JSON);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {

        echo var_dump($result) . '<br>';
      }
    break;

    //get admin
    case'getadmin':
      $id = $_GET['id'];
      $dao = new dao();
      $result = $dao->getadmin($id);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        // echo '<pre>';
        // echo var_dump($result);//Object
        // echo '</pre> <br>------------<br>';
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result . ' <br>---------<br> ';
      }
    break;


   //update admin
   case'updateadmin':
   $dao = new dao();
   $date = date('Y-m-d');
   $JSON = array(

     'AdminID' => 6,
     'AdminName' => 'NewNEWNew',
     'AdminUser' => 'NewNEWNew',
     'AdminPass' => 'NewNEWNew',
   );
   $result = $dao->updateadmin($JSON);
   //var_dump($result);
   if($result === false){
     echo 'empty';
   }else {

     echo var_dump($result) . '<br>';
   }
 break;
    //Delete admin
    case'deleteadmin':
      $id = $_GET['id'];
      $dao = new dao();
      $result = $dao->deleteadmin($id);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        echo '<pre>';
        echo var_dump($result);//True
        echo '</pre> <br>------------<br>';
      }
    break;      
  /* -------------------------------------------
   * -------------------------------------------
   * -----------------Order---------------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
    // show all order
    case 'showallorder':
      // for ajax header('Content-Type: application/json');
      $dao = new dao();
      $result = $dao->showallorder();
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        // echo '<pre>';
        // echo var_dump($result);
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result;
      }
    break;

    case'createorder':
      $dao = new dao();
      $date = date('Y-m-d');
      $JSON = array(
        'OrderID' => '',
        'CustomerID'=> '',
        'TotalPrice' => '11' ,
        'Status' => 'new',
        'OrderAddress' => 'NEWADDRESS',
        'OrderTime' => '',
        'OrderDeliverTime' => NULL,
        'Customer' => array(
          'CustomerID'    => '',
          'CustomerPhone' => 'safwwad',
          'CustomerEmail' => '14ssees5',
          'CustomerFname' => 'ass',
          'CustomerLname' => '3ads',
        ),
        'pizza' => array(
          '0' => array(
            'PizzaID' => '',
            'OrderID'=> '',
              'Price' => '15',
              'Amount' => '3',
              'PizzaSize'=> 'small',
              'PizzaDough' => 'thiny',
              'PizzaIngList' => 'Tomato,Pepper,BlackOlive,GreenOlive,Shrimp',
          ),
          '1' => array(
            'PizzaID' => '',
            'OrderID'=> '',
              'Price' => '15',
              'Amount' => '3',
              'PizzaSize'=> 'small',
              'PizzaDough' => 'thiny',
            'PizzaIngList' => 'Tomato,Pepper,GreenOlive',
        ),

        ),
        'nonpizza' => array (
          '0' => array(
            'nonName' => 'Jucies',
            'amount' => '1',
          ),
          '1' => array(
            'nonName' => 'coco',
            'amount' => '2',
          ),
          '2' => array(
            'nonName' => 'Ranch',
            'amount' => '3',
          ),
        ),
        'payment'=> array(
            'PaymentID'=>'',
            'OrderID' => '',
            'CustomerID' => '',
            'PaymentType' => 'Kredi kart',
        ),


      );

      $result = $dao->createorder($JSON);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        // echo '<pre>';
        // echo var_dump($result);//Object
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result;
      }
    break;

    case'updateorderstatus':
    $dao = new dao();
    $JSON = array(
 
      'OrderID' => 158,
      'Status' => 'delivered',
      'OrderAddress' => 'ohohoh',
      //if Status == delivered then OrderDeliverTime wil be updated automatic to real time
    );
    $result = $dao->updateorderstatus($JSON);
    //var_dump($result);
    if($result === false){
      echo 'empty';
    }else {
 
      echo var_dump($result) . '<br>';
    }
    break;
    //get Order
    case'getorder':
      $id = $_GET['id'];
      $dao = new dao();
      $result = $dao->getorder($id);
      var_dump($result);
      $result =0;
      if($result === false){
        echo 'empty';
      }else {
        // echo '<pre>';
        // echo var_dump($result);//Object
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result . ' <br>---------<br> ';
      }
    break;

    case'showpreorder':
      $JSON = array(
        'CustomerEmail' => '14ssees5',
        'CustomerPhone' => 'safwwad',
        'CustomerFname' => 'ass',
        'CustomerLname' => '3ads',


      );
      $dao = new dao();
      $result = $dao->showpreorder($JSON);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        // echo '<pre>';
        // echo var_dump($result);//Object
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result . ' <br>---------<br> ';
      }
    break;
    //get Order
    case'showorderdetails':
      $id = $_GET['id'];
      $dao = new dao();
      $result = $dao->showorderdetails($id);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        // echo '<pre>';
        // echo var_dump($result);//Object
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result . ' <br>---------<br> ';
      }
    break;

    //Delete Order
    case'deleteorder':
      $id = $_GET['id'];
      $dao = new dao();
      $result = $dao->deleteorder($id);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        echo '<pre>';
        echo var_dump($result);//True
        echo '</pre> <br>------------<br>';
      }
    break;

  /* -------------------------------------------
   * -------------------------------------------
   * -----------------customer------------------
   * -------------------------------------------
   * ------------------------------------------- 
   */ 
      // show all customer
      case'showallcustomer':
        // for ajax header('Content-Type: application/json');
      $dao = new dao();
      $result = $dao->showallcustomer();
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else{
        // echo '<pre> <br>------------<br>';
        // echo var_dump($result);
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result . ' <br>---------<br> ';
      }
      break;

    //insert admin
    case'insertcustomer':
      $dao = new dao();
      $date = date('Y-m-d');
      $JSON = array(
       
        'CustomerEmail' => 'NEWCuer@pizza.com',
        'CustomerPhone' => 'NEWCustadsomer' . $date . '' . time(),
        'CustomerFname' => 'NEWCustomer' . $date . '' . time(),
        'CustomerLname' => 'NEWCustomer' . $date . '' . time(),
      );
      $result = $dao->insertcustomer($JSON);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        echo var_dump($result);
      }
    break;

    case'updatecustomer':
    $dao = new dao();
    $date = date('Y-m-d');
    $JSON = array(
 
      'CustomerID' => 122,
      'CustomerPhone' => 'NewNEWNew',
      'CustomerEmail' => 'NewNEWNew',
      'CustomerFname' => 'NewNEWNew',
      'CustomerLname' => 'NewNEWNew',
    );
    $result = $dao->updatecustomer($JSON);
    //var_dump($result);
    if($result === false){
      echo 'empty';
    }else {
 
      echo var_dump($result) . '<br>';
    }
  break;
    //get Customer
    case'getcustomer':
      $id = $_GET['id'];
      $dao = new dao();
      $result = $dao->getcustomer($id);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        // echo '<pre>';
        // echo var_dump($result);//Object
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result . ' <br>---------<br> ';
      }
    break;

    //Delete Customer
    case'deletecustomer':
      $id = $_GET['id'];
      $dao = new dao();
      $result = $dao->deletecustomer($id);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        echo '<pre>';
        echo var_dump($result);//True
        echo '</pre> <br>------------<br>';
      }
    break;
  /* -------------------------------------------
   * -------------------------------------------
   * -----------------Pizza------------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
    // show all pizza
    case'showallpizza':
    // for ajax header('Content-Type: application/json');
      $dao = new dao();
      $result = $dao->showallpizza();
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else{
        // echo '<pre>';
        // echo var_dump($result);
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result;
      }
    break;

    case'showpizzadetails':
    // for ajax header('Content-Type: application/json');
      $dao = new dao();
      $id = $_GET['id'];
      $result = $dao->showpizzadetails($id);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else{
        // echo '<pre>';
        // echo var_dump($result);
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result;
      }
    break;
    //Delete pizza
    case'deletepizza':
      $id = $_GET['id'];
      $dao = new dao();
      $result = $dao->deletepizza($id);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        echo '<pre>';
        echo var_dump($result);//True
        echo '</pre> <br>------------<br>';
      }
    break;

  /* -------------------------------------------
   * -------------------------------------------
   * -----------------ingredients---------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
  // show all ingredients
  case'showallingredient':
    // for ajax header('Content-Type: application/json');
    $dao = new dao();
    $id = NULL;
    $result = $dao->showallingredient($id);
    //var_dump($result);
    if($result === false){
      echo 'empty';
    }else{
      // echo '<pre>';
      // echo var_dump($result);
      // echo '</pre> <br>------------<br>';
      $result = json_encode($result);
      echo $result;
    }
    break;

    case'insertingredient':
      $dao = new dao();
      $date = date('Y-m-d');
      $JSON = array(
       
        'IngName' => 'NEWIng' . $date . '' . time(),
        'IngPrice' => '10' . $date . '' . time(),
      );
      $result = $dao->insertingredient($JSON);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        echo var_dump($result);
      }
    break;

    case'updateingredient':
    $dao = new dao();
    $JSON = array(
 
      'IngID' => 20,
      'IngName' => 'IngName',
      'IngPrice' => 'IngPrice',
    );
    $result = $dao->updateingredient($JSON);
    //var_dump($result);
    if($result === false){
      echo 'empty';
    }else {
 
      echo var_dump($result) . '<br>';
    }
  break;

    case'getingredient':
      $id = $_GET['id'];
      $dao = new dao();
      $result = $dao->getingredient($id);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        // echo '<pre>';
        // echo var_dump($result);//Object
        // echo '</pre> <br>------------<br>';
        $result = json_encode($result);
        echo $result . ' <br>---------<br> ';
      }
    break;
    //Delete ingredient
    case'deleteingredient':
      $id = $_GET['id'];
      $dao = new dao();
      $result = $dao->deleteingredient($id);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        echo '<pre>';
        echo var_dump($result);//True
        echo '</pre> <br>------------<br>';
      }
    break;

  /* -------------------------------------------
   * -------------------------------------------
   * -----------------NonPizza------------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
      // show all nonpizza
      case'showallnonpizza':
        // for ajax header('Content-Type: application/json');
        $dao = new dao();
        $result = $dao->showallnonpizza();
        //var_dump($result);
        if($result === false){
          echo 'empty';
        }else{
          // echo '<pre>';
          // echo var_dump($result);
          // echo '</pre> <br>------------<br>';
          $result = json_encode($result);
          echo $result;
        }
      break;
      case'insertnonpizza':
      $dao = new dao();
      $date = date('Y-m-d');
      $JSON = array(
       
        'nonName' => 'nonName' . $date . '' . time(),
        'nonPrice' => '10' . $date . '' . time(),
        'Category' => 'ColaDrinks',
      );
      $result = $dao->insertnonpizza($JSON);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        echo var_dump($result);
      }
    break;
    
    //update
    case'updatenonpizza':
    $dao = new dao();
    $JSON = array(
 
      'nonID' => 9,
      'nonPrice' => 'nonPrice',
      'nonName' => 'nonName',
      'Category' => 'Jucies'
    );
    $result = $dao->updatenonpizza($JSON);
    //var_dump($result);
    if($result === false){
      echo 'empty';
    }else {
 
      echo var_dump($result) . '<br>';
    }
  break;
      // Get nonpizza info
      case'getnonpizza':
        $id = $_GET['id'];
        $dao = new dao();
        $result = $dao->getnonpizza($id);
        //var_dump($result);
        if($result === false){
          echo 'empty';
        }else {
          // echo '<pre>';
          // echo var_dump($result);//Object
          // echo '</pre> <br>------------<br>';
          $result = json_encode($result);
          echo $result . ' <br>---------<br> ';
        }
      break;

      // Get nonpizza info
      case'getnonpizzasbycat':
        $category = $_GET['category'];
        $dao = new dao();
        $result = $dao->getnonpizzasbycat($category);
        //var_dump($result);
        if($result === false){
          echo 'empty';
        }else {
          // echo '<pre>';
          // echo var_dump($result);//Object
          // echo '</pre> <br>------------<br>';
          $result = json_encode($result);
          echo $result . ' <br>---------<br> ';
        }
      break;
      // show all nonpizza
      case'showordernonpizza':
        // for ajax header('Content-Type: application/json');
        $dao = new dao();
        $id = $_GET['id'];
        $result = $dao->showordernonpizza($id);
        //var_dump($result);
        if($result === false){
          echo 'empty';
        }else{
          // echo '<pre>';
          // echo var_dump($result);//Object
          // echo '</pre> <br>------------<br>';
          $result = json_encode($result);
          echo $result;
        }
      break;
    //Delete nonpizza
    case'deletenonpizza':
      $id = $_GET['id'];
      $dao = new dao();
      $result = $dao->deletenonpizza($id);
      //var_dump($result);
      if($result === false){
        echo 'empty';
      }else {
        echo '<pre>';
        echo var_dump($result);//True
        echo '</pre> <br>------------<br>';
      }
    break;

  /* -------------------------------------------
   * -------------------------------------------
   * -----------------payment-------------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
  // show all payment
  case'showallpayment':
    // for ajax header('Content-Type: application/json');
    $dao = new dao();
    $result = $dao->showallpayment();
    //var_dump($result);
    if($result === false){
      echo 'empty';
    }else{
      // echo '<pre>';
      // echo var_dump($result);
      // echo '</pre> <br>------------<br>';
      $result = json_encode($result);
      echo $result;
    }
    break;

    case'getpayment':
    $id = $_GET['id'];
    $dao = new dao();
    $result = $dao->getpayment($id);
    //var_dump($result);
    if($result === false){
      echo 'empty';
    }else {
      // echo '<pre>';
      // echo var_dump($result);//Object
      // echo '</pre> <br>------------<br>';
      $result = json_encode($result);
      echo $result . ' <br>---------<br> ';
    }
  break;
  //Delete nonpizza
  case'deletepayment':
    $id = $_GET['id'];
    $dao = new dao();
    $result = $dao->deletepayment($id);
    //var_dump($result);
    if($result === false){
      echo 'empty';
    } else {
    echo '<pre>';
    echo var_dump($result);//True
    echo '</pre> <br>------------<br>';
    }
  break;

  default:
    echo 'From Servies';   
  }

}
      
