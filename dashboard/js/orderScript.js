
jQuery.ajaxSetup({async: false});
//Angular functions goes here..
var app = angular.module("myApp", []);
app.controller("myCtrl", function ($scope) {
	//define pizzaOrder array
	$scope.Orders = [];
	//get session and store it into pizzaOrder array
	if (getAllOrders() != "") {
		$scope.Orders = getAllOrders();
	}
	
	$scope.deleteOrder = function (x) {
		var OrderID = $scope.Orders[x].OrderID;
		jQuery.post("../php/admin/mservices.php", {method: "deleteOrder", id: OrderID}, function (data) {});
		$scope.Orders.splice(x, 1);
	}

	

	$scope.showCustomer = function (x) {
		getCustomerByID(x);
	}

	$scope.editStatus = function (x, currentStatus) {
		console.log(currentStatus);
		latestOrderID = x;
		latestStatus = currentStatus;
		jQuery("#statusBtns button").removeClass("btn-primary");
		jQuery("#statusBtns button").addClass("btn-secondary");
		jQuery("#status" + currentStatus).addClass("btn-primary");

		if (currentStatus == "Received") {
			$scope.Received = false;
			$scope.Approved = false;
			$scope.Prepared = false;
			$scope.Delivered = false;
			$scope.Rejected = false;
		} else if (currentStatus == "Approved") {
			$scope.Received = true;
			$scope.Approved = false;
			$scope.Prepared = false;
			$scope.Delivered = false;
			$scope.Rejected = true;
		} else if (currentStatus == "Prepared") {
			$scope.Received = true;
			$scope.Approved = true;
			$scope.Prepared = false;
			$scope.Delivered = false;
			$scope.Rejected = true;
		} else if (currentStatus == "Delivered") {
			$scope.Received = true;
			$scope.Approved = true;
			$scope.Prepared = true;
			$scope.Delivered = true;
			$scope.Rejected = true;
			jQuery("#statusBtns button").removeClass("btn-primary");
			jQuery("#statusBtns button").addClass("btn-secondary");
		} else if (currentStatus == "Rejected") {
			$scope.Received = true;
			$scope.Approved = true;
			$scope.Prepared = true;
			$scope.Delivered = true;
			$scope.Rejected = true;
			jQuery("#statusBtns button").removeClass("btn-primary");
			jQuery("#statusBtns button").addClass("btn-secondary");
		}
	}

	$scope.getOrderDetails = function(x) {
		jQuery.post("../php/admin/mservices.php", {method: "getOrderDetails", id: x}, function (data) {
			$scope.ordarDetails = data;
		});
		$scope.pizzaOrder = $scope.ordarDetails.pizza;
		$scope.nonPizzaOrder = $scope.ordarDetails.nonpizza;
	}

	$scope.deletePizza = function (x, id) {
		jQuery.post("../php/admin/mservices.php", {method: "deletePizza", id: id}, function (data) {});
		$scope.pizzaOrder.splice(x, 1);
	}

	$scope.deleteNonPizza = function (x, id) {
		jQuery.post("../php/admin/mservices.php", {method: "deleteOrderNonPizza", id: id}, function (data) {});
		$scope.nonPizzaOrder.splice(x, 1);
	}
});


//get all Order and return data
function getAllOrders() {
	ajaxData = '';
	jQuery.post("../php/admin/mservices.php", {method: "getAllOrders"}, function (data) {
		ajaxData = data;
	});
	return ajaxData;
}

//insert new admin data
function getOrderByID(ID) {
	ajaxData = '';
	jQuery.post("../php/admin/mservices.php", {method: "getOrder", id: ID}, function (data) {
		ajaxData = data;
	});
	if (ajaxData != "empty" || ajaxData != "") {
		try {
			jQuery('#OrderID').val(ajaxData.OrderID);
			jQuery('#OrderEmail').val(ajaxData.OrderEmail);
			jQuery('#OrderFname').val(ajaxData.OrderFname);
			jQuery('#OrderLname').val(ajaxData.OrderLname);
			jQuery('#OrderPhone').val(ajaxData.OrderPhone);
		} catch (error) {}
	}
}

function getCustomerByID(ID) {
	ajaxData = '';
	jQuery.post("../php/admin/mservices.php", {method: "getCustomer", id: ID}, function (data) {
		ajaxData = data;
	});
	if (ajaxData != "empty" || ajaxData != "") {
		try {
			jQuery('#CustomerID').val(ajaxData.CustomerID);
			jQuery('#CustomerEmail').val(ajaxData.CustomerEmail);
			jQuery('#CustomerFname').val(ajaxData.CustomerFname);
			jQuery('#CustomerLname').val(ajaxData.CustomerLname);
			jQuery('#CustomerPhone').val(ajaxData.CustomerPhone);
		} catch (error) {}
	}
}

function sendStatusData() {
	jQuery.post("../php/admin/mservices.php", {method: "updateOrderStatus", id: latestOrderID, status: latestStatus}, function (data) {});
	location.reload();
}

function logout() {
	jQuery.post("../php/sessions.php", {type: "setSession", loginInfo: "", orderType: "moChglak"}, function (data) {});
	window.location.replace("../index.html");
}

jQuery("#statusBtns button").on('click', function() {
	jQuery("#statusBtns button").removeClass("btn-primary");
	jQuery("#statusBtns button").addClass("btn-secondary");
	jQuery(this).addClass("btn-primary");
	latestStatus = jQuery("#statusBtns .btn-primary").text();
 });

