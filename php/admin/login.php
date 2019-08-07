<?php 

if(session_id() == '') {
  session_start();
}
if (isset($_SESSION['admin'])){
  header('Location: ./index.php');
  die();
}
 ?>
      <h1>Welcome Admin</h1>
      <form action='./services.php' method='GET'>
        <label>username</label>
        <input hidden type ='text'name = 'method' value = 'loginadmin'>
        <input hidden type ='text' name = 'id'>
        <input type='text' name='user'>
        <br>
        <label>password</label>
        <input type='password' name=pass>
        <br>
        <input type='submit'>
      </form>
<?php
