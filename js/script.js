jQuery.ajaxSetup({async: false});
toCalc = "";
order = "";
getPrices();
pizzaOrder = [];
nonPizzaOrder = [];
//get session and return data
function getOrderSession(orderType) {
	ajaxData = '';
	jQuery.post("php/sessions.php", {type: "getSession", orderType: orderType}, function (data) {
		ajaxData = JSON.parse(data);
	});
	return ajaxData;
}

//Send last state of Order Array to be saved as a session
function saveOrderSession(data, orderType) {
	jQuery.post("php/sessions.php", {type: "setSession", data: data, orderType: orderType}, function (data) {});
}

//Send last state of Order Array to be saved as a session
function destroyAllOrderSession() {
	jQuery.post("php/sessions.php", {destroy: "true"}, function (data) {});
}

//Angular functions goes here..
var app = angular.module("myApp", []);
app.controller("myCtrl", function ($scope) {
	
	//define pizzaOrder array
	$scope.pizzaOrder = [];
	$scope.nonPizzaOrder = [];
	//get session and store it into pizzaOrder array
	if (getOrderSession("pizzaOrder") != "") {
		pizzaOrder = getOrderSession("pizzaOrder");
		$scope.pizzaOrder = pizzaOrder;
	}

	if (getOrderSession("nonPizzaOrder") != "") {
		nonPizzaOrder = getOrderSession("nonPizzaOrder");
		$scope.nonPizzaOrder = nonPizzaOrder;
	}
	//update the number of the items in the cart
	cartItems();

	//remove item from pizzaOrder array the recalculate item number
	$scope.removeItem = function (x, order) {
		if (order == "pizzaOrder") {
			$scope.pizzaOrder.splice(x, 1);
			pizzaOrder = $scope.pizzaOrder;
			if (pizzaOrder.length == 0) {
				saveOrderSession("", "pizzaOrder");
			} else {
				saveOrderSession(pizzaOrder, "pizzaOrder");
			}
		} else if (order == "nonPizzaOrder") {
			$scope.nonPizzaOrder.splice(x, 1);
			nonPizzaOrder = $scope.nonPizzaOrder;
			if (pizzaOrder.length == 0) {
				saveOrderSession("", "nonPizzaOrder");
			} else {
				saveOrderSession(nonPizzaOrder, "nonPizzaOrder");
			}
		}
		cartItems();
		claculateCartPrices();
	}

	$scope.customizePizza = function (title, type) {
		//calcualte pizza model
		toCalc = "pizza";
		order = "pizza";
		//empty modal first
		emptyModal();
		//show add button
		$scope.tracking = false;
		//set the title of the modal which was sent by the ng-click function as a parameter
		$scope.modalTitle = title;
		buildPizzaModal();
		checkIngredients();
	}

	
	$scope.addOrder = function () {
		if (order == "pizza") {
			var arrayToPush = getPizzaDetails();
			arrayToPush.pizzaName = $scope.modalTitle;
			var length = $scope.pizzaOrder.length;
			var id;
			if (length == 0) {
				id = 0;
			} else {
				id = Number($scope.pizzaOrder[length - 1].pizzaId) + 1;
			}
			arrayToPush.pizzaId = id;
			$scope.pizzaOrder.push(arrayToPush);
			pizzaOrder = $scope.pizzaOrder;
			cartItems();
			console.log(pizzaOrder);
			saveOrderSession(pizzaOrder, "pizzaOrder");
		} else if (order == "nonPizza") {
			var oldArray = [];
			if (nonPizzaOrder.length > 0) {
				for (i = 0; i < nonPizzaOrder.length; i++) {
					oldArray.push(nonPizzaOrder[i].productName);
				}
			}
			getNonPizzaDetails(type, oldArray);
			console.log(nonPizzaOrder);
			cartItems();
			saveOrderSession(nonPizzaOrder, "nonPizzaOrder");
		}
	}

	$scope.track = function () {
		//empty modal first
		emptyModal();
		//set the title of the modal
		$scope.modalTitle = 'Track Order';
		//hide add button
		$scope.tracking = true;
		trackOrder();
	}

	$scope.extras = function (category) {
		toCalc = "nonPizza";
		order = "nonPizza";
		type = category;
		//empty modal first
		emptyModal();
		//set the title of the modal
		$scope.modalTitle = 'Extras';
		//hide add button
		$scope.tracking = false;
		buildNonPizzaModal(category);
	}

	//cartItems function
	function cartItems() {
		var cartItems = pizzaOrder.length + nonPizzaOrder.length;
		jQuery("#cartItemNumber").text(cartItems);
		$scope.cartIsEmpty = false;
		if (cartItems == 0) {
			jQuery("#cartItemNumber").text("");;
			$scope.cartIsEmpty = true;
		}
	}

	$scope.preOrders = function () {
		var oldEmail = jQuery("#oldEmail").val();
		var oldPhone = jQuery("#oldPhone").val();
		jQuery.post("php/admin/mservices.php", {method: "showPreOrders", oldEmail: oldEmail, oldPhone: oldPhone}, function (data) {
			$scope.oldOrderData = data;
		});
	
		$scope.oldOrders = [];
		for (i = 0; i < $scope.oldOrderData.length; i++) {
			jQuery.post("php/admin/mservices.php", {method: "getOrderDetails", id: $scope.oldOrderData[i].OrderID}, function (data) {
				$scope.oldOrders.push(data);
			});
		}
		
		$scope.oldPizzaOrder = $scope.oldOrders[0].pizza;
		$scope.oldNonPizzaOrder = $scope.oldOrders[0].nonpizza;
	}

	$scope.oldOrderDetails = function (x) {
		$scope.oldPizzaOrder = $scope.oldOrders[x].pizza;
		//$scope.oldNonPizzaOrder = $scope.oldOrders[x].nonpizza;
	}

	$scope.reOrder = function (x) {
		$scope.oldPizzaOrder = $scope.oldOrders[x].pizza;
		$scope.oldNonPizzaOrder = $scope.oldOrders[x].nonpizza;
		console.log($scope.oldPizzaOrder);
		for (i = 0; i < $scope.oldPizzaOrder.length; i++) {
			var ingStringList = []; 
			for (j = 0; j < $scope.oldPizzaOrder[i].PizzaIngList.length; j++) {
				ingStringList.push($scope.oldPizzaOrder[i].PizzaIngList[j]);
			}
			ingStringList = ingStringList.toString();
			var id;
			var length = $scope.pizzaOrder.length;
			if (length == 0) {
				id = 0;
			} else {
				id = Number($scope.pizzaOrder[length - 1].pizzaId) + 1;
			}
			var pizzaToPush = {
				pizzaAmount: $scope.oldPizzaOrder[i].Amount,
				pizzaDough: $scope.oldPizzaOrder[i].PizzaDough,
				pizzaId: id,
				pizzaIng: ingStringList,
				pizzaName: "OldPizza",
				pizzaPrice: $scope.oldPizzaOrder[i].Price,
				pizzaSize: $scope.oldPizzaOrder[i].PizzaSize,
			}
			$scope.pizzaOrder.push(pizzaToPush);
			pizzaOrder = $scope.pizzaOrder;
			cartItems();
			saveOrderSession(pizzaOrder, "pizzaOrder");
		}
		//console.log($scope.oldNonPizzaOrder);
	}
	
});
//End Of Angular



//get prices
function getPrices() {
	//global arrays to calculate price
	ingNames = [];
	ingPrices = [];
	nonNames = [];
	nonPrices = [];
	sizeNames = ["small", "medium", "large"];
	sizePrices = [4, 8, 10];

	ajaxData = '';
	jQuery.post("php/admin/mservices.php", {method: "getPrice"}, function (data) {
		ajaxData = data;
	});
	
	//split ingredient names and prices
	for (i = 0; i < ajaxData.IngPrice.length; i++) {
		ingNames[i] = ajaxData.IngPrice[i].IngName;
		ingPrices[i] = ajaxData.IngPrice[i].IngPrice;
	}

	//split nonPizza names and prices
	for (i = 0; i < ajaxData.nonpizzaprice.length; i++) {
		nonNames[i] = ajaxData.nonpizzaprice[i].nonName;
		nonPrices[i] = ajaxData.nonpizzaprice[i].nonPrice;
	}
}

//Make modal ready as a pizza order window
function buildPizzaModal() {
	//get the HTML of #pizzaStack html block
	//then paste it in the content of the modal
	var pizzaStack = jQuery('#pizzaStack').html();
	jQuery('#modalPizza').html(pizzaStack);

	//get the HTML of #pizzaBasics html block
	//then paste it in the body of the modal
	var pizzaBasics = jQuery('#pizzaBasics').html();
	jQuery('#modalBody').html(pizzaBasics);

	//Get all the ingredients from the database and create a checkbox for each one
	
	jQuery.ajaxSetup({async: false});
	jQuery.post("php/admin/mservices.php", {method: "getAllIngredients"}, function (data) {
		for (var i = 0; i < data.length; i++) {
			createCheckBoxes(i + 1, data[i].IngName);
		}
	});
	jQuery.ajaxSetup({async: true});

	//Create checkBoxes automatically from the database
	function createCheckBoxes(x, data) {
		var original = document.getElementById('rootCheckBox');
		var clone = original.cloneNode(true, true);
		clone.id = 'customCheckClone-' + x;
		//document.getElementById("modalBody").appendChild(clone);
		jQuery('#modalBody').append(clone);
		jQuery("#customCheckClone-" + x + " input").attr('id', 'ingredientCheckbox-' + x);
		jQuery("#customCheckClone-" + x + " input").attr('value', data);
		jQuery("#customCheckClone-" + x + " label").attr('for', 'ingredientCheckbox-' + x);
		jQuery("#customCheckClone-" + x + " label").text(data);
	}

	//get the HTML of #amountSection html block
	//then paste it in the body of the modal
	var amountSection = jQuery('#amountSection').html();
	jQuery('#modalBody').append(amountSection);

	calculatePizzaPrice();
}

function calculatePizzaPrice() {
	var sum = 0;
	sum += sizePrices[sizeNames.indexOf(jQuery('input:radio[name="pizzaSize"]:checked').val())];
	jQuery('input[id*="ingredientCheckbox-"]:checked').each(function () {
		sum += ingPrices[ingNames.indexOf(jQuery(this).val())];
	});
	sum *= jQuery("#amountNumber").val();
	jQuery("#totalPrice").text(sum);
}

function getPizzaDetails() {
	var pizzaDetailsArray = {
		pizzaId: "",
		pizzaName: "",
		pizzaDough: "",
		pizzaSize: "",
		pizzaAmount: "",
		pizzaPrice: "",
		pizzaIng: ""
	};

	var ingArray = [];
	pizzaDetailsArray.pizzaDough = jQuery('input:radio[name="pizzaDough"]:checked').val();
	pizzaDetailsArray.pizzaSize = jQuery('input:radio[name="pizzaSize"]:checked').val();
	pizzaDetailsArray.pizzaAmount = jQuery("#amountNumber").val();
	pizzaDetailsArray.pizzaPrice = jQuery("#totalPrice").text();
	jQuery('input[id*="ingredientCheckbox-"]:checked').each(function () {
		ingArray.push(jQuery(this).val());
	});
	pizzaDetailsArray.pizzaIng = ingArray.toString();
	console.log(pizzaDetailsArray);
	return pizzaDetailsArray;
}

function buildNonPizzaModal(data) {
	//get the HTML of #NonPizzaStart html block
	//then paste it in the body of the modal
	var NonPizzaStart = jQuery('#NonPizzaStart').html();
	jQuery('#modalBody').html(NonPizzaStart);
	jQuery.ajaxSetup({async: false});
	//Get all the NonPizzas from the database and create a row for each one
	jQuery.post("php/admin/mservices.php", {method: "getNonPizzaByCat", nonCategory: data}, function (data) {
		for (var i = 0; i < data.length; i++) {
			creatRows(i + 1, data[i].nonName, data[i].nonPrice);
		}
	});

	//Create checkBoxes automatically from the database
	function creatRows(x, Name, Price) {
		var original = document.getElementById('rootTableRow');
		var clone = original.cloneNode(true, true);
		clone.id = 'nonPizzaRow-' + x;
		//document.getElementById("modalBody").appendChild(clone);
		jQuery('#modalBody #nonPizzaTableBody').append(clone);
		jQuery("#nonPizzaRow-" + x + " #nonPizzaCheck-").attr('id', 'nonPizzaCheck-' + x);
		jQuery("#nonPizzaCheck-" + x).attr('value', Name);
		jQuery("#nonPizzaRow-" + x + " label").attr('for', 'nonPizzaCheck-' + x);
		jQuery("#nonPizzaRow-" + x + " #nonPizzaName-").attr('id', 'nonPizzaName-' + x);
		jQuery("#nonPizzaName-" + x).text(Name);
		jQuery("#nonPizzaRow-" + x + " #nonPizzaPrice-").attr('id', 'nonPizzaPrice-' + x);
		jQuery("#nonPizzaPrice-" + x).text(Price);
		jQuery("#nonPizzaRow-" + x + " #nonPizzaAmount-").attr('id', 'nonPizzaAmount-' + x);
	}
	
	calculateNonPizzaPrice();
}

function calculateNonPizzaPrice() {
	var sum = 0;
	for (i = 1; i <= nonNames.length; i++) {
		if (jQuery('#nonPizzaCheck-' + i).prop("checked")) {
			sum +=  jQuery('#nonPizzaPrice-' + i).text() * jQuery('#nonPizzaAmount-' + i).val();
		}
	}
	jQuery("#totalPrice").text(sum);
}

function getNonPizzaDetails(data, oldArray) {

	//[{productName:"ddd", Amount:23, price:22, totalPrice:amount*price}]
	jQuery.ajaxSetup({async: false});
	
	console.log(data);
	jQuery.post("php/admin/mservices.php", {method: "getNonPizzaByCat", nonCategory: data}, function (data) {
		list = data;
	});
	jQuery.ajaxSetup({async: true});
	for (i = 0; i < list.length; i++) {
		var product = {productID: "", productName: "", productPrice: "", productAmount: "", productTotalPrice: ""};
		x = i + 1;
		if (jQuery('#nonPizzaCheck-' + x).prop("checked")) {
			var productName = jQuery("#nonPizzaName-" + x).text();
			if (oldArray.indexOf(productName) != -1) {
				var oldIndex = oldArray.indexOf(productName);
				var oldPrice = nonPizzaOrder[oldIndex].productPrice;
				var oldAmount = nonPizzaOrder[oldIndex].productAmount;
				var newAmount = parseInt(oldAmount) + parseInt(jQuery("#nonPizzaAmount-" + x).val());
				nonPizzaOrder[oldIndex].productAmount = newAmount;
				nonPizzaOrder[oldIndex].productTotalPrice = oldPrice * newAmount;
			} else {
				console.log(nonPizzaOrder.length == 0);
				console.log(nonPizzaOrder.length);
				if (nonPizzaOrder.length == 0) {
					product.productID = 0;
				} else {
					product.productID = parseInt(nonPizzaOrder[nonPizzaOrder.length - 1 ].productID) + 1;
				}
				product.productName = jQuery("#nonPizzaName-" + x).text();
				product.productPrice = parseInt(jQuery("#nonPizzaPrice-" + x).text());
				product.productAmount = parseInt(jQuery("#nonPizzaAmount-" + x).val());
				product.productTotalPrice = product.productPrice * product.productAmount;
				nonPizzaOrder.push(product);
			}			
		}
	}
}

// track order function
function trackOrder() {
	//get the HTML of #trackMessage html block
	//then paste it in the body of the modal
	var trackMessage = jQuery('#trackMessage').html();
	jQuery('#modalBody').html(trackMessage);

	var trackReferance = jQuery("#trackNumber").val();
	//get data
	ajaxData = '';
	jQuery.ajaxSetup({async: false});
	jQuery.post("php/admin/mservices.php", {method: "getOrder", id: trackReferance}, function (data) {
		ajaxData = data;
	});
	jQuery.ajaxSetup({async: true});
	if (ajaxData != "empty") {
		try {
			jQuery('#modalBody p').text("Your Orders is " + ajaxData.Status);
		} catch (error) {}
	} else {
		jQuery('#modalBody p').text("Entered Referance is Wrong");
	}
}

//login admin in login.php
function login() {
	//get username and password from inputs
	var user = jQuery("#username").val();
	var pass = jQuery("#password").val();
	//check if there is any record in the database
	jQuery.post("php/admin/mservices.php", {method: "login", username: user, password: pass}, function (data) {
		if (data != "empty") {
			//make a session with data
			jQuery.post("php/sessions.php", {type: "setSession", loginInfo: data, orderType: "moChglak"}, function (data) {});
			window.location.replace("dashboard/dashboard.html");
		} else {
			//show error massege
			jQuery("#loginError").show();
		}
	});
}

function claculateCartPrices() {
	if (window.location.pathname == "/pizza/cart.html") {
		var pizzaOrderSum = 0;
		var nonPizzaOrderSum = 0;
		AllOrderTotalPrice = 0;
		if (pizzaOrder.length > 0) {
			for (i = 0; i < pizzaOrder.length; i++) {
				pizzaOrderSum += parseInt(pizzaOrder[i].pizzaPrice);
			}
		}
		
		if (nonPizzaOrder.length > 0) {
			for (i = 0; i < nonPizzaOrder.length; i++) {
				nonPizzaOrderSum += parseInt(nonPizzaOrder[i].productTotalPrice);
			}
		}
		
		AllOrderTotalPrice = pizzaOrderSum + nonPizzaOrderSum;
		jQuery("#pizzaOrderTotalPrice").text(pizzaOrderSum);
		jQuery("#nonPizzaOrderTotalPrice").text(nonPizzaOrderSum);
	}
}

function getlatestOrderID() {
	jQuery.ajaxSetup({async: false});
	jQuery.post("php/orderID.php", function (data) {
		ajaxData = JSON.parse(data);
	});
	return ajaxData;
}

function getPreOrders() {
	jQuery.ajaxSetup({async: false});
	jQuery.post("php/orderID.php", function (data) {
		ajaxData = JSON.parse(data);
	});
	return ajaxData;
}

function sendOrder() {
	var customerData = {
		CustomerFname: jQuery("#CustomerFname").val(),
		CustomerLname: jQuery("#CustomerLname").val(),
		CustomerEmail: jQuery("#CustomerEmail").val(),
		CustomerPhone: jQuery("#CustomerPhone").val(),
		CustomerAddress: jQuery("#CustomerAddress").val(),
		TotalPrice: AllOrderTotalPrice,
		PaymentType: jQuery("#payment").val()
	}
	
	var AllOrder = {customerData: customerData, pizzaOrder: pizzaOrder, nonPizzaOrder: nonPizzaOrder};
	console.log(AllOrder);
	jQuery.post("php/admin/mservices.php", {method: "insertOrder", data: AllOrder}, function (data) {});

	var ReferanceCode = getlatestOrderID();
	jQuery("#referanceCode").text(ReferanceCode);

	saveOrderSession("", "pizzaOrder");
	saveOrderSession("", "nonPizzaOrder");
}


