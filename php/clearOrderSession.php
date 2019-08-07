<?php
session_start();
unset($_SESSION['pizzaOrderSession']);
unset($_SESSION['nonPizzaOrderSession']);
echo "done";
?>