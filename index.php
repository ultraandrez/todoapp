<?php
  session_start();
  date_default_timezone_set('Asia/Yekaterinburg');
  include('./db_connect.php');
  if(!isset($_SESSION['loggedIN'])){
    header('Location: login.php');
    exit();
  }
  else {
    $qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM user_list where email = '".$email."' and password = '".md5($password)."'  ");
    if($qry->num_rows > 0)
    {
      foreach ($qry->fetch_array() as $key => $value)
      {
        if($key != 'password' && !is_numeric($key))
          $_SESSION['login_'.$key] = $value;
      }
    }
  }
 ?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <title>Home</title>
      <meta name="viewport" content="width = device-width, initial-scale=1">
      <link rel="stylesheet" href="/css/sidebar.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </head>

  <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
    <?php include 'topbar.php' ?>
    <?php include 'sidebar.php' ?>

       <div class="content-wrapper">
          <section class="content">
            <div class="container-fluide">
             <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'tasks';
                if(!file_exists($page.".php")){
                    include '404.html';
                }else{
                include $page.'.php';
                }
              ?>
            </div>
          </section>

      </div>
    </div>
  </body>
</html>