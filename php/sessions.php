<?php
session_start();
header('Content-Type: application/json');
require('db.php');

if (isset($_POST["destroy"]) && $_POST["destroy"] != "true") {
    unset($_SESSION["pizzaOrderSession"]);
    unset($_SESSION["nonPizzaOrderSession"]);
}

if (isset($_POST["type"]) && $_POST["type"] != "" && isset($_POST["orderType"])) {
    //get session if exist
    if ($_POST["type"] == "getSession") {
        if ($_POST["orderType"] == "pizzaOrder") {
            if (isset($_SESSION["pizzaOrderSession"])) {
                echo json_encode($_SESSION['pizzaOrderSession']);
            }
        } else if ($_POST["orderType"] == "nonPizzaOrder") {
            if (isset($_SESSION["nonPizzaOrderSession"])) {
                echo json_encode($_SESSION['nonPizzaOrderSession']);
            }
        }
    } else if ($_POST["type"] == "setSession") {
        if ($_POST["orderType"] == "pizzaOrder") {
            if (isset($_POST["data"]) && $_POST["data"] != "") {
                $data = $_POST["data"];
                $_SESSION['pizzaOrderSession'] = json_encode($data);
                if($_SESSION['pizzaOrderSession']) {
                    echo json_encode("Done");
                }
            } else {
                unset($_SESSION["pizzaOrderSession"]);
            }
        } else if ($_POST["orderType"] == "nonPizzaOrder") {
            if (isset($_POST["data"]) && $_POST["data"] != "") {
                $data = $_POST["data"];
                $_SESSION['nonPizzaOrderSession'] = json_encode($data);
                if($_SESSION['nonPizzaOrderSession']) {
                    echo json_encode("Done");
                }
            } else {
                unset($_SESSION["nonPizzaOrderSession"]);
            }
        }
        

        if (isset($_POST["loginInfo"]) && $_POST["loginInfo"] != "") {
            $info = $_POST["loginInfo"];
            $_SESSION['loginInfo'] = json_encode($info);
        } else {
            unset($_SESSION["loginInfo"]);
        }
    }

} else {
    die("Specify if you want to set session or to get it..");
}






$conn->close();
?>