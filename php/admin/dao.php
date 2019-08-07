<?php 
require '../model/customer.php';
require '../model/customerlist.php';
require '../model/admin.php';
require '../model/adminlist.php';
require '../model/ingredients.php';
require '../model/ingredientslist.php';
require '../model/nonpizza.php';
require '../model/nonpizzalist.php';
require '../model/order.php';
require '../model/orderlist.php';
require '../model/ordernonpizza.php';
require '../model/ordernonpizzalist.php';
require '../model/payment.php';
require '../model/paymentlist.php';
require '../model/pizza.php';
require '../model/pizzaingredients.php';
require '../model/pizzaingredientslist.php';
require '../model/pizzalist.php';
if(session_id() == '') {
  session_start();
}
//These Class To Access Eevery Model And Obtened Data
class dao {

  //get price For Frontend
  public function getprice(){
    $data = [];
    $ingprice = new ingredientslist();
    $data['IngPrice'] = $ingprice->showingredients();
    $nonpizzaprice = new nonpizzalist();
    $data['nonpizzaprice'] = $nonpizzaprice->shownonpizzas();
    $data['size'] = array(
        'small' => 10,
        'Medium' => 15,
        'larg'  => 20

    );
    if ($data['IngPrice'] === false && $data['nonpizzaprice'] === false){

      return false;

    }else {

      return $data;
    }

  }
  //For Connect DataBace
  public function openconnection(){
    $servername    = 'localhost';
    $username      = 'root';
    $password      = '';
    $databasename  = 'pizzaorderingsystem';
    try {  
      $DBH = new PDO("mysql:host=$servername;dbname=$databasename", $username,$password);    
      $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $DBH->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      return $DBH;
    } catch(PDOException $e) {echo 'ERROR: ' . $e->getMessage();}
  }


  /* -------------------------------------------
   * -------------------------------------------
   * -----------------ADMIN---------------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
  // DAO login Admin
  public function loginadmin ($AdminUser, $AdminPass){

    //Make an object instance from admin
    $adminobject = new admin();
    $adminobject->__set('AdminUser', $AdminUser);
    $adminobject->__set('AdminPass', $AdminPass);
    if ($adminobject->login( $adminobject->__get('AdminUser'), $adminobject->__get('AdminPass') )){
      //echo 'hoooooooooba';
      //if admin info currect
      //convert an object to  accs array for ajax;
      $admininfoarray = array(
        'AdminID'   => $adminobject->__get('AdminID'),
        'AdminName' => $adminobject->__get('AdminName'),
        'AdminUser' =>$adminobject->__get('AdminUser'),
      );
      return $admininfoarray;
    } else {
      //echo 'Hata';
      return false;
    }
  }

  //Show all admin 
  public function showalladmin(){

    //Make an object instance from admin List model
    $adminlist = new adminlist();
    $result    = $adminlist->showadmins();
    if(!$result){

      //echo 'hata';
      return false;
    
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }
  //get  admin By Id
  public function getadmin($id){

    //Make an object instance from admin
    $admin = new admin();
    $admin->__set('AdminID', $id);
    $result = $admin->get();
    if(!$result){
      //echo 'hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }
  //Delete admin
  public function deleteadmin($id) {

    //Make an object instance from admin
    $admin = new admin();
    $admin->__set('AdminID', $id);
    if($admin->delete()){
      //echo 'Hooooooooooba';
      return true;
    } else { 
      //echo 'hata';
      return false;
    }
  }

  //insert admin
  public function insertadmin($JSON){
     
    //Make an object instance from admin
    $admin = new admin();
    $admin->__set('AdminName', $JSON['AdminName']);
    $admin->__set('AdminUser', $JSON['AdminUser']);
    $admin->__set('AdminPass', $JSON['AdminPass']);
    $result = $admin->insert();

    if($result === false){
      //echo 'Hata';
      return false;
    }else{ 
      //echo 'Hooooooooooba';
      return true;
    }
  }
    //update admin
  public function updateadmin($JSON){
     
    //Make an object instance from admin
    $admin = new admin();
    $admin->__set('AdminID', $JSON['AdminID']);
    $admin->__set('AdminName', $JSON['AdminName']);
    $admin->__set('AdminUser', $JSON['AdminUser']);
    $admin->__set('AdminPass', $JSON['AdminPass']);
    $result = $admin->update();

    if($result === false){
      //echo 'Hata';
      return false;
    }else{ 
      //echo 'Hooooooooooba';
      return true;
    }
  }
   

  /* -------------------------------------------
   * -------------------------------------------
   * ------------------ORDER--------------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
  
  //Show all order
  public function showallorder(){

    //Make an object instance from order list
    $orderlistobject = new orderlist();
    $result = $orderlistobject->showorders();
    if($result === false){
      //echo 'Hata';
      return false;
    }else{ 
      //echo 'Hooooooooooba';
      return $result;
    }
   }

  //get  Order By ID
  public function getorder($id){

    //Make an object instance from order
    $order = new order();
    $order->__set('OrderID', $id);
    $result = $order->get();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }
  //Create Oredr From Customer
  public function createorder($JSON){

    //Make an object instance from order
    $order = new order();
    $result = $order->create($JSON);
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }
  //update
  public function updateorderstatus($JSON){
     
    //Make an object instance from ingredients
    $order = new order();
    $order->__set('OrderID', $JSON['OrderID']);
    $order->__set('Status', $JSON['Status']);
    $order->__set('OrderAddress', $JSON['OrderAddress']);
    $result = $order->update();

    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

  // Show Order details
  public function showorderdetails($id){

    //Make an object instance from order
    $order = new order();
    $order->__set('OrderID', $id);
    $result = $order->getdetails();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }


  //Delete Order
  public function deleteorder($id) {
    $order = new order();
    $order->__set('OrderID', $id);
    $result = $order->delete();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

   //Delete Pizza
   public function deleteordernonpizza($id) {
    
    //Make an object instance from ordernonpizza
    $ordernonpizza = new ordernonpizza();
    $ordernonpizza->__set('OrderNonPizzaID', $id);
    $result = $ordernonpizza->delete();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }
  /* -------------------------------------------
   * -------------------------------------------
   * -----------------Customer------------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
  //Show all Customer
  public function showallcustomer(){

    //Make an object instance from Customer List
    $customerlistobject = new customerlist();
    $result = $customerlistobject->showcustomers();
    if($result === false){
      //echo 'hata';
      return false;
    } else { 
      //echo 'Hobaaaaaaaaaaaa!';
      return $result;
    }
  }

  //get  Order By ID
  public function getcustomer($id){

    //Make an object instance from Customer
    $customer = new customer();
    $customer->__set('CustomerID', $id);
    $result = $customer->get();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

  public function showpreorder($JSON){

    //Make an object instance from order list
    $customer = new customer();
    $customer->__set('CustomerEmail', $JSON['CustomerEmail']);
    $customer->__set('CustomerPhone', $JSON['CustomerPhone']);
    //$customer->__set('CustomerFname', $JSON['CustomerFname']);
    //$customer->__set('CustomerLname', $JSON['CustomerLname']);
    $result = $customer->customerorders();
    if($result === false){
      //echo 'Hata';
      return false;
    }else{ 
      //echo 'Hooooooooooba';
      return $result;
    }
   }
  //Insert Customer
  public function insertcustomer($JSON){
     
    //Make an object instance from Customer
    $customer = new customer();
    $customer->__set('CustomerEmail', $JSON['CustomerEmail']);
    $customer->__set('CustomerPhone', $JSON['CustomerPhone']);
    $customer->__set('CustomerFname', $JSON['CustomerFname']);
    $customer->__set('CustomerLname', $JSON['CustomerLname']);
    $result = $customer->insert();

    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

    //update Customer
    public function updatecustomer($JSON){
     
      //Make an object instance from admin
      $customer = new customer();
      $customer->__set('CustomerID', $JSON['CustomerID']);
      $customer->__set('CustomerPhone', $JSON['CustomerPhone']);
      $customer->__set('CustomerEmail', $JSON['CustomerEmail']);
      $customer->__set('CustomerFname', $JSON['CustomerFname']);
      $customer->__set('CustomerLname', $JSON['CustomerLname']);
      $result = $customer->update();
  
      if($result === false){
        //echo 'Hata';
        return false;
      }else{ 
        //echo 'Hooooooooooba';
        return true;
      }
    }

  //Delete Customer
  public function deletecustomer($id) {

    //Make an object instance from Customer
    $customer = new customer();
    $customer->__set('CustomerID', $id);
    $result = $customer->delete();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

  /* -------------------------------------------
   * -------------------------------------------
   * --------------------Pizza------------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
  // Show All Pizza
  public function showallpizza(){

    //Make an object instance from pizza list
    $pizzalistobject = new pizzalist();
    $result = $pizzalistobject->showpizzas();
    if($result === false){
      return false;
    } else { 
      return $result;
    }
  }

  // Show  Pizzadetails
  public function showpizzadetails($id){

    //Make an object instance from pizza
    $pizza = new pizza();
    $pizza->__set('PizzaID', $id);
    $result = $pizza->get();
    if($result === false){
      return false;
    } else { 
      return $result;
    }
  }

  //Delete Pizza
  public function deletepizza($id) {
    
    //Make an object instance from pizza
    $pizza = new pizza();
    $pizza->__set('PizzaID', $id);
    $result = $pizza->delete();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

  /* -------------------------------------------
   * -------------------------------------------
   * -----------------ingredients---------------
   * -------------------------------------------
   * ------------------------------------------- 
   */

   //Show  all ingredients
  public function showallingredient(){

    //Make an object instance from ingredients List
    $ingredientslistobject = new ingredientslist();
    $id = null;
    $result = $ingredientslistobject->showingredients();
    if($result === false){
      return false;
    } else { 
      return $result;
    }
  }

  //Insert
  public function insertingredient($JSON){
     
    //Make an object instance from ingredients
    $ingredients = new ingredients();
    $ingredients->__set('IngName', $JSON['IngName']);
    $ingredients->__set('IngPrice', $JSON['IngPrice']);
    $result = $ingredients->insert();

    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

  //update
  public function updateingredient($JSON){
     
    //Make an object instance from ingredients
    $ingredients = new ingredients();
    $ingredients->__set('IngID', $JSON['IngID']);
    $ingredients->__set('IngName', $JSON['IngName']);
    $ingredients->__set('IngPrice', $JSON['IngPrice']);
    $result = $ingredients->update();

    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

  //get ingredient by ID
  public function getingredient($id){

    //Make an object instance from ingredients
    $ingredients = new ingredients();
    $ingredients->__set('IngID', $id);
    $result = $ingredients->get();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

  //delete ingredient
  public function deleteingredient($id) {

    //Make an object instance from ingredients
    $ingredients = new ingredients();
    $ingredients->__set('IngID', $id);
    $result = $ingredients->delete();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

  /* -------------------------------------------
   * -------------------------------------------
   * -----------------nonpizza------------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
  public function showallnonpizza(){

    //Make an object instance from nonpizza lsit
    $nonpizzalistobject = new nonpizzalist();
    $result = $nonpizzalistobject->shownonpizzas();
    if($result === false){
      return false;
    } else { 
      return $result;
    }
  }

  public function insertnonpizza($JSON){
     
    //Make an object instance from nonPizza
    $nonpizza = new nonpizza();
    $nonpizza->__set('nonName', $JSON['nonName']);
    $nonpizza->__set('nonPrice', $JSON['nonPrice']);
    $nonpizza->__set('nonCategory', $JSON['nonCategory']);
    $result = $nonpizza->insert();

    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hobaaaaaa!';
      return $result;
    }
  }

  //update
  public function updatenonpizza($JSON){
     
    //Make an object instance from ingredients
    $nonpizza = new nonpizza();
    $nonpizza->__set('nonID', $JSON['nonID']);
    $nonpizza->__set('nonPrice', $JSON['nonPrice']);
    $nonpizza->__set('nonName', $JSON['nonName']);
    $nonpizza->__set('nonCategory', $JSON['nonCategory']);
    $result = $nonpizza->update();

    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

  //get nonpizza by ID
  public function getnonpizza($id){

    //Make an object instance from nonpizza
    $nonpizza = new nonpizza();
    $nonpizza->__set('nonID', $id);
    $result = $nonpizza->get();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

  //get nonpizza by nonCategory
  public function getnonpizzasbycat($noncategory){

    //Make an object instance from nonpizzaList
    $nonpizzalistobject = new nonpizzalist();
    $result = $nonpizzalistobject->shownonpizzasbucat($noncategory);
    if($result === false){
      return false;
    } else { 
      return $result;
    }
  }

  public function showordernonpizza($id){

    //Make an object instance from ordernonpizza List
    $ordernonpizzalist = new ordernonpizzalist();
    $result = $ordernonpizzalist->getordernonpizza($id);
    if($result === false){
      return false;
    } else { 
      return $result;
    }
  }
  //delete nonpizza
  public function deletenonpizza($id) {

    //Make an object instance from nonpizza
    $nonpizza = new nonpizza();
    $nonpizza->__set('nonID', $id);
    $result = $nonpizza->delete();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }

  /* -------------------------------------------
   * -------------------------------------------
   * --------------------payment----------------
   * -------------------------------------------
   * ------------------------------------------- 
   */
  public function showallpayment(){

    //Make an object instance from Payment
    $paymentlistobject = new paymentlist();
    $result = $paymentlistobject->showpayments();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      return $result;
    }
  }


  public function insertpayment(){


    //Preper Json to Insert
    $JSON = array(
       
      'OrderID'     => '6',
      'CustomerID'  => '46',
      'PaymentType' => 'Kredi cart',
    );
    //Make an object instance from payment
    $payment = new payment();
    $payment->__set('OrderID', $JSON['OrderID']);
    $payment->__set('CustomerID', $JSON['CustomerID']);
    $payment->__set('PaymentType', $JSON['PaymentType']);
    $result = $payment->insert();

    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hobaaaaaaaaaaa!';
      return true;
    }
  }
  //get payment by  Order ID
  public function getpayment($id){

    //Make an object instance from Payment
    $payment = new payment();
    $payment->__set('PaymentID', $id);
    $result = $payment->get();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }
  //Delete payment
  public function deletepayment($id) {
    $payment = new payment();
    $payment->__set('PaymentID', $id);
    $result = $payment->delete();
    if($result === false){
      //echo 'Hata';
      return false;
    } else { 
      //echo 'Hooooooooooba';
      return $result;
    }
  }
  
}
