<?php
    if(session_id() == '') {
        session_start();
    }
    if (isset($_SESSION['loginInfo'])){
        header('Location: ./dashboard/dashboard.html');
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login | Dominant Pizza</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="css/fontawesome.min.css" rel="stylesheet" type="text/css">
    <!-- Plugin CSS -->
    <link href="css/magnific-popup.css" rel="stylesheet">
    <!-- Flags CSS -->
    <link href="css/flag-icon.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <script src="js/angular.min.js"></script>
</head>

<body id="page-top" ng-app="myApp" ng-controller="myCtrl">

    <section id="loginForm">
        <div class="container h-100">
            <div class="row justify-content-center align-self-center">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-primary card-title text-center">Login</h4>
                            <form>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control round" id="username" aria-describedby="emailHelp"
                                        placeholder="Username ..">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control round" id="password" placeholder="Password ..">
                                </div>
                                <button onClick="login()" class="btn btn-primary mt-3">Login</button>
                                <div id="loginError" class="form-group mt-4 mb-0 text-danger">
                                    <label>Entered Data is not correct!</label>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <a href="index.html" class="text-center pt-4 mt-4">Back To Homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <!-- Custom scripts for this template -->
    <script src="js/script.js"></script>
</body>

</html>
