<?php
    session_start();
    if(isset($_POST["given_text"]) & $_SESSION['login_type'] != 1)
    {
     $_SESSION['sort_type'] = $_POST["given_text"];
    }
    else if(isset($_POST["given_text"]) & $_SESSION['login_type'] == 1){
      $_SESSION['admin_sort_type'] = $_POST["given_text"];
    }
 ?>
