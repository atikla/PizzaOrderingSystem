
jQuery.ajaxSetup({async: false});
//Angular functions goes here..
var app = angular.module("myApp", []);
app.controller("myCtrl", function ($scope) {
	//define pizzaOrder array
	$scope.admins = [];
	//get session and store it into pizzaOrder array
	if (getAllAdmins() != "") {
		$scope.admins = getAllAdmins();
	}
	
	$scope.deleteAdmin = function (x) {
		var AdminID = $scope.admins[x].AdminID;
		jQuery.post("../php/admin/mservices.php", {method: "deleteAdmin", id: AdminID}, function (data) {});
		$scope.admins.splice(x, 1);
	}

	$scope.editAdmin = function (x) {
		if (x != -1) {
			$scope.modalTitle = "Edit Admin";
			var AdminID = $scope.admins[x].AdminID;
			getAdminByID(AdminID);
		} else {
			$scope.modalTitle = "New Admin";
			jQuery('#AdminID').val('');
			jQuery('#AdminName').val('');
			jQuery('#AdminUser').val('');
			jQuery('#AdminPass').val('');
		}
	}
});




//get all Admins and return data
function getAllAdmins() {
	ajaxData = '';
	jQuery.post("../php/admin/mservices.php", {method: "getAllAdmins"}, function (data) {
		ajaxData = data;
	});
	return ajaxData;
}

//get an Admin by id
function sendAdminData() {
	
	var AdminID = jQuery('#AdminID').val();
	var AdminName = jQuery('#AdminName').val();
	var AdminUser = jQuery('#AdminUser').val();
	var AdminPass = jQuery('#AdminPass').val();
	if (AdminID != "") {
		jQuery.post("../php/admin/mservices.php", {
			method: "updateAdmin", 
			AdminID: AdminID, 
			AdminName: AdminName, 
			AdminUser: AdminUser, 
			AdminPass: AdminPass}, 
		function (data) {});
		location.reload();
	} else {
		jQuery.post("../php/admin/mservices.php", {
			method: "insertAdmin", 
			AdminName: AdminName, 
			AdminUser: AdminUser, 
			AdminPass: AdminPass}, 
		function (data) {});
		location.reload();
	}
}

//insert new admin data
function getAdminByID(ID) {
	ajaxData = '';
	jQuery.post("../php/admin/mservices.php", {method: "getAdmin", id: ID}, function (data) {
		ajaxData = data;
	});
	if (ajaxData != "empty" || ajaxData != "") {
		try {
			jQuery('#AdminID').val(ajaxData.AdminID);
			jQuery('#AdminName').val(ajaxData.AdminName);
			jQuery('#AdminUser').val(ajaxData.AdminUser);
			jQuery('#AdminPass').val(ajaxData.AdminPass);
		} catch (error) {}
	}
}

function logout() {
	jQuery.post("../php/sessions.php", {type: "setSession", loginInfo: "", orderType: "moChglak"}, function (data) {});
	window.location.replace("../index.html");
}

