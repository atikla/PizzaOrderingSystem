<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION["orderID"])) {
    // Here, you can also perform some database query operations with above values.
    $orderID = $_SESSION['orderID'];
    echo json_encode($orderID);
    //echo var_dump( json_decode(stripslashes($orderDetailsArray)));
}

?>