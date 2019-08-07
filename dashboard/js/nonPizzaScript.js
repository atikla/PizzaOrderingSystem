
jQuery.ajaxSetup({async: false});
//Angular functions goes here..
var app = angular.module("myApp", []);
app.controller("myCtrl", function ($scope) {
	//define pizzaOrder array
	$scope.NonPizzas = [];
	//get session and store it into pizzaOrder array
	if (getAllNonPizzas() != "") {
		$scope.NonPizzas = getAllNonPizzas();
	}
	
	$scope.deleteNonPizza = function (x) {
		var nonID = $scope.NonPizzas[x].nonID;
		jQuery.post("../php/admin/mservices.php", {method: "deleteNonPizza", id: nonID}, function (data) {});
		$scope.NonPizzas.splice(x, 1);
	}

	$scope.editNonPizza = function (x) {
		if (x != -1) {
			$scope.modalTitle = "Edit NonPizza";
			var nonID = $scope.NonPizzas[x].nonID;
			getNonPizzaByID(nonID);
		} else {
			$scope.modalTitle = "New NonPizza";
			jQuery('#nonID').val('');
			jQuery('#nonPrice').val('');
			jQuery('#nonName').val('');
			jQuery('#nonCategory').val('');
		}
	}
});


//get all NonPizza and return data
function getAllNonPizzas() {
	ajaxData = '';
	jQuery.post("../php/admin/mservices.php", {method: "getAllNonPizzas"}, function (data) {
		ajaxData = data;
	});
	return ajaxData;
}

//insert new NonPizza data
function sendNonPizzaData() {
	var nonID = jQuery('#nonID').val();
	var nonName = jQuery('#nonName').val();
	var nonPrice = jQuery('#nonPrice').val();
	var nonCategory = jQuery('#nonCategory').val();
	if (nonID != "") {
		jQuery.post("../php/admin/mservices.php", {
			method: "updateNonPizza", 
			nonID: nonID,
			nonName: nonName,
			nonPrice: nonPrice,
			nonCategory: nonCategory}, 
		function (data) {});
		location.reload();
	} else {
		jQuery.post("../php/admin/mservices.php", {
			method: "insertNonPizza", 
			nonName: nonName,
			nonPrice: nonPrice,
			nonCategory: nonCategory}, 
		function (data) {});
		location.reload();
	}
}

//get an NonPizza by id
function getNonPizzaByID(ID) {
	ajaxData = '';
	jQuery.post("../php/admin/mservices.php", {method: "getNonPizza", id: ID}, function (data) {
		ajaxData = data;
	});
	if (ajaxData != "empty" || ajaxData != "") {
		try {
			jQuery('#nonID').val(ajaxData.nonID);
			jQuery('#nonName').val(ajaxData.nonName);
			jQuery('#nonPrice').val(ajaxData.nonPrice);
			jQuery('#nonCategory').val(ajaxData.nonCategory);
		} catch (error) {}
	}
}

function logout() {
	jQuery.post("../php/sessions.php", {type: "setSession", loginInfo: "", orderType: "moChglak"}, function (data) {});
	window.location.replace("../index.html");
}
