<?php
session_start();
// header('Content-Type: application/json');
// require('db.php');

/*
if (isset($_SESSION["pizzaOrderSession"])) {
    // Here, you can also perform some database query operations with above values.
    $orderDetailsArray = $_SESSION['pizzaOrderSession'];
    echo json_encode(stripslashes($orderDetailsArray));
    //echo var_dump( json_decode(stripslashes($orderDetailsArray)));
}
echo "----------------------------------------------------------------------------------";
if (isset($_SESSION["nonPizzaOrderSession"])) {
    // Here, you can also perform some database query operations with above values.
    $orderDetailsArray = $_SESSION['nonPizzaOrderSession'];
    echo json_encode(stripslashes($orderDetailsArray));
    //echo var_dump( json_decode(stripslashes($orderDetailsArray)));
}*/

if (isset($_SESSION["allOrder"])) {
    // Here, you can also perform some database query operations with above values.
    $orderDetailsArray = $_SESSION['allOrder'];
    echo json_encode($orderDetailsArray);
    //echo var_dump( json_decode(stripslashes($orderDetailsArray)));
}
/*
$myArray = array();
for ($i = 0; $i < sizeof($orderDetailsArray['pizzaOrder']); $i++) {
    $myArray[$i] = array (
        'PizzaID' => '',
        'OrderID'=> '',
        'Price' => $orderDetailsArray['pizzaOrder'][$i]['pizzaPrice'],
        'Amount' => $orderDetailsArray['pizzaOrder'][$i]['pizzaAmount'],
        'PizzaSize'=> $orderDetailsArray['pizzaOrder'][$i]['pizzaSize'],
        'PizzaDough' => $orderDetailsArray['pizzaOrder'][$i]['pizzaDough'],
        'PizzaIngList' => $orderDetailsArray['pizzaOrder'][$i]['pizzaIng']
    );
}
*/


// $conn->close();
?>