
jQuery.ajaxSetup({async: false});
//Angular functions goes here..
var app = angular.module("myApp", []);
app.controller("myCtrl", function ($scope) {
	//define pizzaOrder array
	$scope.ingredients = [];
	//get session and store it into pizzaOrder array
	if (getAllIngredients() != "") {
		$scope.ingredients = getAllIngredients();
	}
	
	$scope.deleteIngredient = function (x) {
		var IngID = $scope.ingredients[x].IngID;
		jQuery.post("../php/admin/mservices.php", {method: "deleteIngredient", id: IngID}, function (data) {});
		$scope.ingredients.splice(x, 1);
	}

	$scope.editIngredient = function (x) {
		if (x != -1) {
			$scope.modalTitle = "Edit Ingredient";
			var IngID = $scope.ingredients[x].IngID;
			getIngredientByID(IngID);
		} else {
			$scope.modalTitle = "New Ingredient";
			jQuery('#IngID').val('');
			jQuery('#IngName').val('');
			jQuery('#IngPrice').val('');
		}
	}
});


//get all Ingredient and return data
function getAllIngredients() {
	ajaxData = '';
	jQuery.post("../php/admin/mservices.php", {method: "getAllIngredients"}, function (data) {
		ajaxData = data;
	});
	return ajaxData;
}

//insert new Ingredient data
function sendIngredientData() {
	var IngID = jQuery('#IngID').val();
	var IngName = jQuery('#IngName').val();
	var IngPrice = jQuery('#IngPrice').val();
	if (IngID != "") {
		jQuery.post("../php/admin/mservices.php", {
			method: "updateIngredient",
			IngID: IngID, 
			IngName: IngName, 
			IngPrice: IngPrice}, 
		function (data) {});
		location.reload();
	} else {
		jQuery.post("../php/admin/mservices.php", {
			method: "insertIngredient", 
			IngName: IngName, 
			IngPrice: IngPrice}, 
		function (data) {});
		location.reload();
	}
}

//get an Ingredient by id
function getIngredientByID(ID) {
	ajaxData = '';
	jQuery.post("../php/admin/mservices.php", {method: "getIngredient", id: ID}, function (data) {
		ajaxData = data;
	});
	if (ajaxData != "empty" || ajaxData != "") {
		try {
			jQuery('#IngID').val(ajaxData.IngID);
			jQuery('#IngName').val(ajaxData.IngName);
			jQuery('#IngPrice').val(ajaxData.IngPrice);
		} catch (error) {}
	}
}

function logout() {
	jQuery.post("../php/sessions.php", {type: "setSession", loginInfo: "", orderType: "moChglak"}, function (data) {});
	window.location.replace("../index.html");
}