<?php 
if(session_id() == '') {
  session_start();
}
unset($_SESSION['admin']);
header('location: login.php');