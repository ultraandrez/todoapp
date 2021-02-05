<?php
  session_start();
  date_default_timezone_set('Asia/Yekaterinburg');

  if(!isset($_SESSION['loggedIN']) || $_SESSION['login_type'] != 1){
    header('Location: login.php');
    exit();
  }
 ?>

<!DOCTYPE html>
<html>
  <head>

      <meta charset="utf-8">
      <title>Users</title>

      <link rel="stylesheet" href="/css/table.css">
      <link rel="stylesheet" href="/css/style.css">
      <link rel="stylesheet" href="/css/sidebar.css">


      <meta name="viewport" content="width = device-width, initial-scale=1">

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

      <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <script src="https://kit.fontawesome.com/a076d05399.js"></script>

      <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" />

  </head>

  <body>
  <?php include 'sidebar.php' ?>
      <div class="col-lg-12">
          <div class="card card-outline card-success">
              <div class="main-div">
                  <div class="center-div">
                      <h1>Пользователи</h1>

                          <div class="text-right margin-rightside ">
                            <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_user_Modal"
                               class="btn btn btn-success form-check-inline" href="#"><i class="fa fa-plus"></i> Добавить пользователя
                            </button>
                          </div>


                      <div class="card-body">
                          <div class="table-responsive" id="users_table">
                            <table class="table-hover col-lg-12" id="users">
                              <colgroup>
                      					<col width="5%">
                      					<col width="45%">
                      					<col width="30%">
                      					<col width="20%">
                      				</colgroup>
                              <thead>
                                <tr>
                                  <th class="text-center">id</th>
                                  <th class="text-center">ФИО</th>
                                  <th class="text-center">Email</th>
                                  <th class="text-center no-sort">Действие</th>
                                </tr>
                              </thead>

                              <tbody>

                                <?php
                                  include 'db_connect.php';

                                  $selectquery = "SELECT * FROM user_list WHERE manager = " . $_SESSION['login_id'] . " ORDER BY lastname DESC";
                                  $query = $conn->query($selectquery);

                                  while($res = $query->fetch_assoc())
                                  {
                                  ?>
                                    <tr id="<?php echo $res["id"]; ?>">

                                      <td><?php echo $res['id']; ?></td>
                                      <td>
                                        <?php
                                            echo $res['lastname']. " " . $res['firstname'] . " " . $res['middlename'];
                                        ?>
                                      </td>

                                      <td><?php echo $res['email']; ?></td>

                                      <?php if($_SESSION['login_type'] == 1): ?>
                                        <td class="text-center">
                                          <input type="button" name="delete" value="Удалить" id="<?php echo $res["id"]; ?>" class="btn btn-danger delete_user" />
                                        </td>
                                      <?php endif; ?>
                                    </tr>
                                <?php
                                }
                                 ?>
                              </tbody>
                            </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </body>
</html>

<div id="add_user_Modal" class="modal fade">
     <div class="modal-dialog modal-lg">
          <div class="modal-content">
               <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle">Новая задача</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                 <form method="post" id="insert_user_form">
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="lastname">Фамилия</label>
                            <input type="text" class="form-control" name= "lastname" id="lastname">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="firstname">Имя</label>
                            <input type="text" class="form-control" name="firstname" id="firstname">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="middlename">Отчество</label>
                            <input type="text" class="form-control" name="middlename" id="middlename">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="confirmpassword">Подтвердите пароль</label>
                            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Password" onchange='check_pass();'>
                          </div>
                        </div>

                        <div class="form-row">
                          <label for="role">Роль</label>
                          <select name="role" id="role" class="form-control">
                            <option value="2" selected>Пользователь</option>
                            <option value="1">Руководитель</option>
                          </select>
                        </div>

                          <div class="modal-footer">
                               <input type="hidden" name="row_id" id="row_id" />
                               <button type="submit" name="insert" id="insert" value="Добавить" class="btn btn-success">Добавить</button>
                               <button type="button" class="btn btn-danger cancel-data" data-dismiss="modal">Назад</button>
                          </div>
                    </form>
               </div>
          </div>
     </div>
</div>

<script>
function check_pass() {
  if (document.getElementById('password').value ==
     document.getElementById('confirmpassword').value) {
     document.getElementById('insert').disabled = false;
  } else {
     document.getElementById('insert').disabled = true;
  }
}


 $(document).ready(function() {

  $('#users').dataTable( {
     "columnDefs":
     [ {
       "targets": 'no-sort',
       "orderable": false
     }]
 });

    $('#insert_user_form').on("submit", function(event) {
        event.preventDefault();

        $.ajax({
            url: "insertuser.php",
            method: "POST",
            data: $('#insert_user_form').serialize(),
            beforeSend: function() {
                $('#insert').val("Добавляю");
            },
            success: function(data) {
                $('#insert_user_form')[0].reset();
                $('#add_user_Modal').modal('hide');
                location.reload();
            }
        });
    });

    $(document).on('click', '.delete_user', function() {
        var row_id = $(this).attr("id");
        if (row_id != '') {
            $.ajax({
                url: "deleteuser.php",
                method: "POST",
                data: {
                    row_id: row_id
                },
                success: function(data) {
                    location.reload();
                }
            });
        }
    });

});
</script>
