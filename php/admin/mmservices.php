<?php 
session_start();
header('Content-Type: application/json');
require 'dao.php';

if (isset($_GET['method'])){
	$method = $_GET['method'];

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
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->getadmin($id);
			sendData($result);
		break;

		//Delete admin
		case 'deleteAdmin':
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->deleteadmin($id);
			sendData($result);
		break;

		//insert admin
		case'insertAdmin':
			$AdminName = $_GET['AdminName'];
			$AdminUser = $_GET['AdminUser'];
			$AdminPass = $_GET['AdminPass'];
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
			$AdminID = $_GET['AdminID'];	
			$AdminName = $_GET['AdminName'];
			$AdminUser = $_GET['AdminUser'];
			$AdminPass = $_GET['AdminPass'];
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
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->getorder($id);
			sendData($result);
		break;

		//get Order details
		case 'getOrderDetails':
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->showorderdetails($id);
			sendData($result);
		break;

		//Delete Order
		case 'deleteOrder':
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->deleteorder($id);
			sendData($result);
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
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->getcustomer($id);
			sendData($result);
		break;

		//Delete Customer
		case 'deleteCustomer':
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->deletecustomer($id);
			sendData($result);
		break;

		//insert customer
		case'insertCustomer':
			$CustomerEmail = $_GET['CustomerEmail'];
			$CustomerFname = $_GET['CustomerFname'];
			$CustomerLname = $_GET['CustomerLname'];
			$CustomerPhone = $_GET['CustomerPhone'];
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
			$CustomerID = $_GET['CustomerID'];
			$CustomerEmail = $_GET['CustomerEmail'];
			$CustomerFname = $_GET['CustomerFname'];
			$CustomerLname = $_GET['CustomerLname'];
			$CustomerPhone = $_GET['CustomerPhone'];
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
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->showpizzadetails($id);
			sendData($result);
		break;

		//Delete pizza
		case 'deletePizza':
			$id = $_GET['id'];
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
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->getingredient($id);
			sendData($result);
		break;

		//Delete ingredient
		case 'deleteIngredient':
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->deleteingredient($id);
			sendData($result);
		break;

		//Insert ingredient
		case'insertIngredient':
			$IngName = $_GET['IngName'];
			$IngPrice = $_GET['IngPrice'];
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
			$IngID = $_GET['IngID'];
			$IngName = $_GET['IngName'];
			$IngPrice = $_GET['IngPrice'];
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
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->getnonpizza($id);
			sendData($result);
		break;

		// show all nonpizza
		case'getOrderNonPizza':
			$dao = new dao();
			$id = $_GET['id'];
			$result = $dao->showordernonpizza($id);
			sendData($result);
		break;

		//Delete nonpizza
		case'deleteNonPizza':
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->deletenonpizza($id);
			sendData($result);
		break;

		//Insert NonPizza
		case 'insertNonPizza':
			$nonName = $_GET['nonName'];
			$nonPrice = $_GET['nonPrice'];
			$Category = $_GET['Category'];
			$dao = new dao();
			$JSON = array(
				'nonName' => $nonName,
				'nonPrice' => $nonPrice,
				'Category' => $Category
			);
			$result = $dao->insertnonpizza($JSON);
			sendData($result);
		break;

		//update NonPizza
		case 'updateNonPizza':
			$nonID = $_GET['nonID'];
			$nonName = $_GET['nonName'];
			$nonPrice = $_GET['nonPrice'];
			$nonCategory = $_GET['nonCategory'];
			$dao = new dao();
			$JSON = array(
				'nonID' => $nonID,
				'nonName' => $nonName,
				'nonPrice' => $nonPrice,
				'nonCategory' => $nonCategory
			);
			$result = $dao->insertnonpizza($JSON);
			sendData($result);
		break;

		//update NonPizza
		case 'getBonPizzasByCat':
			$nonID = $_GET['nonID'];
			$nonName = $_GET['nonName'];
			$nonPrice = $_GET['nonPrice'];
			$nonCategory = $_GET['nonCategory'];
			$dao = new dao();
			$JSON = array(
				'nonID' => $nonID,
				'nonName' => $nonName,
				'nonPrice' => $nonPrice,
				'nonCategory' => $nonCategory
			);
			$result = $dao->insertnonpizza($JSON);
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
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->getpayment($id);
			sendData($result);
		break;

		//Delete payment
		case'deletePayment':
			$id = $_GET['id'];
			$dao = new dao();
			$result = $dao->deletepayment($id);
			sendData($result);
		break;

			//Insert Order
		case 'insertOrder':
		$data = $_GET["data"];
		$_SESSION['allOrder'] = $data;
	break;



		//-----------------------------
		//		other Section
		//-----------------------------

		//check login data
		case 'login':
			$username = $_GET['username'];
			$password = $_GET['password'];
			$dao = new dao();
			$result = $dao->loginadmin($username, $password);
			sendData($result);
		break;

		case'showPreOrders':
			$oldEmail = $_GET['oldEmail'];
			$oldPhone = $_GET['oldPhone'];
			$dao = new dao();
			$JSON = array(
				'CustomerEmail' => $oldEmail,
				'CustomerPhone' => $oldPhone
			);
			$result = $dao->showpreorder($JSON);
			sendData($result);
		break;

		//get price for nonpizza and ingredients
		case 'getPrice':
			$dao = new dao();
			$result = $dao->getprice();
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
