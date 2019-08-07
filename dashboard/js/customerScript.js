
jQuery.ajaxSetup({async: false});
//Angular functions goes here..
var app = angular.module("myApp", []);
app.controller("myCtrl", function ($scope) {
	//define pizzaOrder array
	$scope.customers = [];
	//get session and store it into pizzaOrder array
	if (getAllCustomers() != "") {
		$scope.customers = getAllCustomers();
	}
	
	$scope.deleteCustomer = function (x) {
		var CustomerID = $scope.customers[x].CustomerID;
		jQuery.post("../php/admin/mservices.php", {method: "deleteCustomer", id: CustomerID}, function (data) {});
		$scope.customers.splice(x, 1);
	}

	$scope.editCustomer = function (x) {
		if (x != -1) {
			$scope.modalTitle = "Edit Customer";
			var CustomerID = $scope.customers[x].CustomerID;
			getCustomerByID(CustomerID);
		} else {
			$scope.modalTitle = "New Customer";
			jQuery('#CustomerID').val('');
			jQuery('#CustomerEmail').val('');
			jQuery('#CustomerFname').val('');
			jQuery('#CustomerLname').val('');
			jQuery('#CustomerPhone').val('');
		}
	}
});


//get all Customer and return data
function getAllCustomers() {
	ajaxData = '';
	jQuery.post("../php/admin/mservices.php", {method: "getAllCustomers"}, function (data) {
		ajaxData = data;
	});
	return ajaxData;
}

//get an Customer by id
function sendCustomerData() {
	var CustomerID = jQuery('#CustomerID').val();
	var CustomerEmail = jQuery('#CustomerEmail').val();
	var CustomerFname = jQuery('#CustomerFname').val();
	var CustomerLname = jQuery('#CustomerLname').val();
	var CustomerPhone = jQuery('#CustomerPhone').val();
	if (CustomerID != "") {
		jQuery.post("../php/admin/mservices.php", {
			method: "updateCustomer", 
			CustomerID: CustomerID, 
			CustomerEmail: CustomerEmail, 
			CustomerFname: CustomerFname, 
			CustomerLname: CustomerLname, 
			CustomerPhone: CustomerPhone}, 
		function (data) {});
		location.reload();
	} else {
		jQuery.post("../php/admin/mservices.php", {
			method: "insertCustomer", 
			CustomerEmail: CustomerEmail, 
			CustomerFname: CustomerFname, 
			CustomerLname: CustomerLname, 
			CustomerPhone: CustomerPhone}, 
		function (data) {});
		location.reload();
	}
}

//insert new admin data
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

function logout() {
	jQuery.post("../php/sessions.php", {type: "setSession", loginInfo: "", orderType: "moChglak"}, function (data) {});
	window.location.replace("../index.html");
}
