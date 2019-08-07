<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION["preOrder"])) {
    // Here, you can also perform some database query operations with above values.
    $preOrder = $_SESSION['preOrder'];
    echo json_encode($preOrder);
    //echo var_dump( json_decode(stripslashes($orderDetailsArray)));
}

?>