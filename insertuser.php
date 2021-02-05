<?php
  session_start();
  include 'db_connect.php';
  date_default_timezone_set('Asia/Yekaterinburg');
  if(!empty($_POST))
  {
       $firstname = $_POST["firstname"];
       $middlename = $_POST["middlename"];
       $lastname = $_POST["lastname"];
       $email = $_POST["email"];
       $password = md5($_POST["password"]);
       $type = $_POST["role"];
       $manager = $_SESSION['login_id'];

       $query = "
          INSERT INTO user_list(id, firstname, lastname, middlename, email, password, type, manager)
          VALUES (NULL, '$firstname', '$lastname', '$middlename', '$email', '$password', '$type', '$manager')";

  }
  mysqli_query($conn, $query);
?>
