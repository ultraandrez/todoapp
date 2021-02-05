<?php
  session_start();
  //если залогинен
  if(isset($_SESSION['loggedIN'])){
    header('Location: index.php');
  }

  include('./db_connect.php');

  if(isset($_POST['login'])){
      $email = $conn->real_escape_string($_POST['emailPHP']);
      $userExist = $conn->query("SELECT id FROM user_list WHERE email='$email'");
      if($userExist->num_rows == 0)
      {
        exit('<font color="red">Пользователя с таким логином не существует</font>');
      }

      $password = md5($conn->real_escape_string($_POST['passwordPHP'])); //условие: хэширование

      $data = $conn->query("SELECT id FROM user_list WHERE email='$email' AND password='$password'");
      if($data->num_rows > 0)
      {
        $_SESSION['loggedIN'] = '1';
        $_SESSION['email'] = $email;

        $qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM user_list where email = '".$email."' and password = '$password'  ");
        if($qry->num_rows > 0)
        {
          foreach ($qry->fetch_array() as $key => $value)
          {
            if($key != 'password' && !is_numeric($key))
              $_SESSION['login_'.$key] = $value;
          }
        }


      } else
      {
        exit('<font color="red">Пользователь ввел неверный пароль</font>');
      }
  }
?>

<html>
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="/css/style.css">
  </head>
  <body>

    <div class="form">
      <h1>Вход</h1>
      <div class="input-form">
        <input type="email" id="email" placeholder="Логин">
      </div>
      <div class="input-form">
        <input type="password" id="password" placeholder="Пароль">
      </div>
      <div class="input-form">
        <p id="response"></p>
      </div>
      <div class="input-form">
        <input type="submit" value="Войти" id="login">
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(document).ready(function () {
        $("#login").on('click', function () {
          var email = $("#email").val();
          var password = $("#password").val();

          if(email == "" || password == "")
            alert('Проверьте введенные данные!');
          else{
            $.ajax(
              {
                url: 'login.php',
                method: 'POST',
                data:{
                  login: 1,
                  emailPHP: email,
                  passwordPHP: password
                },
                success: function (response) {
                  $("#response").html(response);

                  if(response.indexOf('success') >= 0)
                    window.location = 'index.php';
                },
                dataType: 'text'
              }
            );
          }
        });
      });
    </script>
  </body>
</html>
