<?php
include 'dao.php';
if(session_id() == '') {
  session_start();
}

?>

<a href="./signout.php">Press TO sign out</a>
<hr>

<h1> createorder <a href="./services.php?method=createorder">createorder</a></h1>

<h3> Admin Section </h3>

<br>

<h5>Show Section</h5>

<br>

<a href="./services.php?method=showalladmin">show all admin</a> done 

<br>

<a href="./services.php?method=showallorder"> show all order</a> done

<br>

<a href="./services.php?method=showallcustomer">show all customer</a> done

<br>

<a href="./services.php?method=showallpizza">show all pizza</a> done 

<br>

<a href="./services.php?method=showallingredient">show all ingredient</a> done 

<br>

<a href="./services.php?method=showallnonpizza">show all non pizza</a> done

<br>

<a href='./services.php?method=getnonpizzasbycat&category=ColaDrinks'>show all Nonpizza By Category ='ColaDrinks, Jucies, FriesSos' </a> <b>Yeni</b> Done

<br>

<a href="./services.php?method=showallpayment">show all payment</a> done 

<br>

<a href="./services.php?method=showpizzadetails&id=3">show pizza details id = pizza ID</a>

<br>

<a href="./services.php?method=showordernonpizza&id=2">show ordernonpizza details id = order ID  </a>


<br>

<a href="./services.php?method=showorderdetails&id=2">show  order details</a> Done

<br>

<h1><a href="./services.php?method=showpreorder">show  Pre details</a> Done</h1>

<br>

<hr>

<h5>Delete Section</h5>

<a href='./services.php?method=deleteadmin&id=3'>Delete admin</a> Done

<br>

<a href='./services.php?method=deleteorder&id=111'>Delete Order</a> Done

<br>

<a href='./services.php?method=deletecustomer&id=111'>Delete Customer</a> Done

<br>

<a href='./services.php?method=deletepizza&id=2'>Delete pizza</a> Done

<br>

<a href='./services.php?method=deleteingredient&id=1'>Delete ingredient</a> Done

<br> 

<a href='./services.php?method=deletenonpizza&id=1'>Delete nonpizza</a> Done

<br>

<a href='./services.php?method=deletepayment&id=6'>Delete payment</a> Done

<br>

<h5>get info with $id Section</h5>

<a href='./services.php?method=getadmin&id=1'>Get admin By ID </a> Done

<br>

<a href='./services.php?method=getorder&id=1'>Get Order By ID </a> Done For Tracking System

<br>

<a href='./services.php?method=getcustomer&id=45'>Get Customer By ID</a> Done

<br>

<a href='./services.php?method=getingredient&id=2'>Get ingredient By ID</a> Done

<br> 

<a href='./services.php?method=getnonpizza&id=3'>Get nonpizza By ID</a> Done

<br>

<a href='./services.php?method=getpayment&id=3'>Get payment id = Payment ID</a> Done

<br>

<h5> get prodcut price </h5>

<a href='./services.php?method=getprice'>Get Price for ing and nonpizza as a array </a> Done

<br>

<h3> insert Section</h3>

<a href='./services.php?method=insertadmin'>insert admin</a> Done

<br>

<a href='./services.php?method=insertcustomer'>insert customer</a> Done

<br>

<a href='./services.php?method=insertingredient'>insert ingredient</a> Done

<br>

<a href='./services.php?method=insertnonpizza'>insert nonpizza</a> Done

<br>

<h3>update Section</h3>

<a href='./services.php?method=updateadmin'>update admin</a> Done

<br>

<a href='./services.php?method=updatecustomer'>update Customer</a> Done

<br>

<a href='./services.php?method=updateingredient'>update ingredient</a> Done

<br>

<a href='./services.php?method=updatenonpizza'>update nonpizza</a> Done

<br>

<a href='./services.php?method=updateorderstatus'>update orderstatus</a> Done

<br>




<?php 

echo gmdate('Y-m-d h:i:s', time());
?>

<!-- <h1> PIZZA DETALIES AND ING AFTER THAR YOU WILL CONTINEU ORDER DETAL Fjngvfbvfrb fuckoffff</h1> -->

<!-- SELECT pizza.PizzaID, ingredients.IngName, ingredients.IngPrice, pizza.Amount, pizza.OrderID FROM pizzaingredients, pizza, ingredients, fullorder WHERE pizza.PizzaID = pizzaingredients.PizzaID AND pizzaingredients.IngID = ingredients.IngID and pizza.OrderID = fullorder.OrderID -->