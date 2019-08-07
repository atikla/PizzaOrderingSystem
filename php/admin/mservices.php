<?php 
header('Content-Type: application/json');
require 'dao.php';

if (isset($_POST['method'])){
	$method = $_POST['method'];

	switch ($method) {

		//-----------------------------
		//		Admin Section
		//-----------------------------

		//get all admins
		case 'getAllAdmins':
			$dao = new dao();
			$result = $dao->showalladmin();
			sendData($result);
		break;

		//get admin
		case 'getAdmin':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->getadmin($id);
			sendData($result);
		break;

		//Delete admin
		case 'deleteAdmin':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->deleteadmin($id);
			sendData($result);
		break;

		//insert admin
		case'insertAdmin':
			$AdminName = $_POST['AdminName'];
			$AdminUser = $_POST['AdminUser'];
			$AdminPass = $_POST['AdminPass'];
			$dao = new dao();
			$JSON = array(
				'AdminName' => $AdminName,
				'AdminUser' => $AdminUser,
				'AdminPass' => $AdminPass
			);
			$result = $dao->insertadmin($JSON);
			sendData($result);
		break;

		//update admin
		case'updateAdmin':
			$AdminID = $_POST['AdminID'];	
			$AdminName = $_POST['AdminName'];
			$AdminUser = $_POST['AdminUser'];
			$AdminPass = $_POST['AdminPass'];
			$dao = new dao();
			$JSON = array(
				'AdminID' => $AdminID,
				'AdminName' => $AdminName,
				'AdminUser' => $AdminUser,
				'AdminPass' => $AdminPass
			);
			$result = $dao->updateadmin($JSON);
			sendData($result);
		break;





		//-----------------------------
		//		Order Section
		//-----------------------------

		// get all orders
		case 'getAllOrders':
			$dao = new dao();
			$result = $dao->showallorder();
			sendData($result);
		break;

		//get Order
		case 'getOrder':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->getorder($id);
			sendData($result);
		break;

		//get Order details
		case 'getOrderDetails':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->showorderdetails($id);
			sendData($result);
		break;

		//Delete Order
		case 'deleteOrder':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->deleteorder($id);
			sendData($result);
		break;

		//Insert Order
		case 'insertOrder':
			$data = $_POST["data"];
			//echo $orderDetailsArray['pizzaOrder'][0]["pizzaIng"];
			$dao = new dao();
			$date = date('Y-m-d');

			$pizzaOrderArray = array();
			for ($i = 0; $i < sizeof($data['pizzaOrder']); $i++) {
				$pizzaOrderArray[$i] = array (
					'PizzaID' => '',
					'OrderID'=> '',
					'Price' => $data['pizzaOrder'][$i]['pizzaPrice'],
					'Amount' => $data['pizzaOrder'][$i]['pizzaAmount'],
					'PizzaSize'=> $data['pizzaOrder'][$i]['pizzaSize'],
					'PizzaDough' => $data['pizzaOrder'][$i]['pizzaDough'],
					'PizzaIngList' => $data['pizzaOrder'][$i]['pizzaIng']
				);
			}

			$nonPizzaOrderArray = array();
			for ($i = 0; $i < sizeof($data['nonPizzaOrder']); $i++) {
				$nonPizzaOrderArray[$i] = array (
					'nonName' => $data['nonPizzaOrder'][$i]['productName'],
					'amount' => $data['nonPizzaOrder'][$i]['productAmount']
				);
			}

			$JSON = array(
				'OrderID' => '',
				'CustomerID' => '',
				'TotalPrice' =>  $data['customerData']['TotalPrice'],
				'Status' => 'Received',
				'OrderAddress' => $data['customerData']['CustomerAddress'],
				'OrderTime' => $date . '' . time(),
				'OrderDeliverTime' => NULL,
				'Customer' => array (
					'CustomerID'    => '',
					'CustomerPhone' => $data['customerData']['CustomerPhone'],
					'CustomerEmail' => $data['customerData']['CustomerEmail'],
					'CustomerFname' => $data['customerData']['CustomerFname'],
					'CustomerLname' => $data['customerData']['CustomerLname'],
				),
				'pizza' => $pizzaOrderArray,
				'nonpizza' => $nonPizzaOrderArray,
				'payment' => array(
					'PaymentID'=>'',
					'OrderID' => '',
					'CustomerID' => '',
					'PaymentType' => $data['customerData']['PaymentType']
				),
			);
			$result = $dao->createorder($JSON);
			$_SESSION['orderID'] = json_encode($result);
			$_SESSION['allOrder'] = json_encode($result);
			sendData($result);
		break;

		//Delete nonPizzaOrder
		case 'deleteOrderNonPizza':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->deleteordernonpizza($id);
			sendData($result);
		break;

		//update status
		case'updateOrderStatus':
			$id = $_POST['id'];
			$status = $_POST['status'];
			$dao = new dao();
			$JSON = array(
				'OrderID' => $id,
				'Status' => $status
			);
			$result = $dao->updateorderstatus($JSON);
		break;



		//-----------------------------
		//		Customer Section
		//-----------------------------

		// show all customer
		case 'getAllCustomers':
			$dao = new dao();
			$result = $dao->showallcustomer();
			sendData($result);
		break;

		//get Customer
		case 'getCustomer':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->getcustomer($id);
			sendData($result);
		break;

		//Delete Customer
		case 'deleteCustomer':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->deletecustomer($id);
			sendData($result);
		break;

		//insert customer
		case'insertCustomer':
			$CustomerEmail = $_POST['CustomerEmail'];
			$CustomerFname = $_POST['CustomerFname'];
			$CustomerLname = $_POST['CustomerLname'];
			$CustomerPhone = $_POST['CustomerPhone'];
			$dao = new dao();
			$JSON = array(
				'CustomerEmail' => $CustomerEmail,
				'CustomerPhone' => $CustomerPhone,
				'CustomerFname' => $CustomerFname,
				'CustomerLname' => $CustomerLname
			);
			$result = $dao->insertcustomer($JSON);
			sendData($result);
		break;
		
		//update customer
		case'updateCustomer':
			$CustomerID = $_POST['CustomerID'];
			$CustomerEmail = $_POST['CustomerEmail'];
			$CustomerFname = $_POST['CustomerFname'];
			$CustomerLname = $_POST['CustomerLname'];
			$CustomerPhone = $_POST['CustomerPhone'];
			$dao = new dao();
			$JSON = array(
				'CustomerID' => $CustomerID,
				'CustomerEmail' => $CustomerEmail,
				'CustomerFname' => $CustomerFname,
				'CustomerLname' => $CustomerLname,
				'CustomerPhone' => $CustomerPhone
			);
			$result = $dao->updatecustomer($JSON);
			sendData($result);
		break;





		//-----------------------------
		//		Pizza Section
		//-----------------------------

		// show all pizza
		case 'getAllPizzas':
			$dao = new dao();
			$result = $dao->showallpizza();
			sendData($result);
		break;

		// show pizza details
		case 'getPizzaDetails':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->showpizzadetails($id);
			sendData($result);
		break;

		//Delete pizza
		case 'deletePizza':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->deletepizza($id);
			sendData($result);
		break;





		//-----------------------------
		//		Ingredients Section
		//-----------------------------

		//get ingredients data
		case 'getAllIngredients':
			$dao = new dao();
			$result = $dao->showallingredient();
			sendData($result);
		break;

		//get one of ingredients
		case 'getIngredient':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->getingredient($id);
			sendData($result);
		break;

		//Delete ingredient
		case 'deleteIngredient':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->deleteingredient($id);
			sendData($result);
		break;

		//Insert ingredient
		case'insertIngredient':
			$IngName = $_POST['IngName'];
			$IngPrice = $_POST['IngPrice'];
			$dao = new dao();
			$JSON = array(
				'IngName' => $IngName,
				'IngPrice' => $IngPrice
			);
			$result = $dao->insertingredient($JSON);
			sendData($result);
		break;

		//update ingredient
		case'updateIngredient':
			$IngID = $_POST['IngID'];
			$IngName = $_POST['IngName'];
			$IngPrice = $_POST['IngPrice'];
			$dao = new dao();
			$JSON = array(
				'IngID' => $IngID,
				'IngName' => $IngName,
				'IngPrice' => $IngPrice
			);
			$result = $dao->updateingredient($JSON);
			sendData($result);
		break;





		//-----------------------------
		//		NonPizza Section
		//-----------------------------

		// show all nonpizza
		case'getAllNonPizzas':
			$dao = new dao();
			$result = $dao->showallnonpizza();
			sendData($result);
		break;

		// Get nonpizza info
		case'getNonPizza':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->getnonpizza($id);
			sendData($result);
		break;

		// show all nonpizza
		case'getOrderNonPizza':
			$dao = new dao();
			$id = $_POST['id'];
			$result = $dao->showordernonpizza($id);
			sendData($result);
		break;

		//Delete nonpizza
		case'deleteNonPizza':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->deletenonpizza($id);
			sendData($result);
		break;

		//Insert NonPizza
		case 'insertNonPizza':
			$nonName = $_POST['nonName'];
			$nonPrice = $_POST['nonPrice'];
			$nonCategory = $_POST['nonCategory'];
			$dao = new dao();
			$JSON = array(
				'nonName' => $nonName,
				'nonPrice' => $nonPrice,
				'nonCategory' => $nonCategory
			);
			$result = $dao->insertnonpizza($JSON);
			sendData($result);
		break;

		//update NonPizza
		case 'updateNonPizza':
			$nonID = $_POST['nonID'];
			$nonName = $_POST['nonName'];
			$nonPrice = $_POST['nonPrice'];
			$nonCategory = $_POST['nonCategory'];
			$dao = new dao();
			$JSON = array(
				'nonID' => $nonID,
				'nonName' => $nonName,
				'nonPrice' => $nonPrice,
				'nonCategory' => $nonCategory
			);
			$result = $dao->updatenonpizza($JSON);
			sendData($result);
		break;

		//update NonPizza
		case 'getNonPizzaByCat':
			$nonCategory = $_POST['nonCategory'];
			$dao = new dao();
			$result = $dao->getnonpizzasbycat($nonCategory);
			sendData($result);
		break;





		//-----------------------------
		//		payment Section
		//-----------------------------

		// show all payment
		case'showAllPayment':
			$dao = new dao();
			$result = $dao->showallpayment();
			sendData($result);
		break;

		//get payment
		case'getPayment':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->getpayment($id);
			sendData($result);
		break;

		//Delete payment
		case'deletePayment':
			$id = $_POST['id'];
			$dao = new dao();
			$result = $dao->deletepayment($id);
			sendData($result);
		break;





		//-----------------------------
		//		other Section
		//-----------------------------

		//check login data
		case 'login':
			$username = $_POST['username'];
			$password = $_POST['password'];
			$dao = new dao();
			$result = $dao->loginadmin($username, $password);
			sendData($result);
		break;

		//get price for nonpizza and ingredients
		case 'getPrice':
			$dao = new dao();
			$result = $dao->getprice();
			sendData($result);
		break;

		case'showPreOrders':
			$oldEmail = $_POST['oldEmail'];
			$oldPhone = $_POST['oldPhone'];
			$dao = new dao();
			$JSON = array(
				'CustomerEmail' => $oldEmail,
				'CustomerPhone' => $oldPhone
			);
			$result = $dao->showpreorder($JSON);
			$_SESSION['preOrder'] = json_encode($result);
			sendData($result);
		break;

		default:
			echo '------';
		break;
	}
}

//send data as JSON data
function sendData($data) {
	if (!$data) {
		echo json_encode("empty");
	} else {
		echo json_encode($data);
	}
}
