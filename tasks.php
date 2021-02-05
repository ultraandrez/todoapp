<?php
  session_start();
  date_default_timezone_set('Asia/Yekaterinburg');

  if(!isset($_SESSION['loggedIN'])){
    header('Location: login.php');
    exit();
  }
 ?>

<!DOCTYPE html>
<html>
  <head>

      <meta charset="utf-8">
      <title>Tasks</title>

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
      <div class="col-lg-12">
          <div class="card card-outline card-success">
              <div class="main-div">
                  <div class="center-div">
                      <h1>Список задач</h1>
                      <?php if($_SESSION['login_type'] == 1): ?>

                          <div class="text-right margin-rightside ">

                            <div class="text-right margin-rightside">
                               <?php
                                   $selected = "";
                                   if(!isset($_SESSION['admin_sort_type'])){
                                     $selected = "Сортировать по дате обновления";
                                   } else{
                                     $selected = $_SESSION['admin_sort_type'];
                                   }

                                   $options = array('Сортировать по дате обновления', 'Сортировать по подчиненным');
                                   echo "<select class='btn btn-success' id='chooseSortOption'>";
                                   foreach($options as $option){
                                       if($selected == $option) {
                                           echo "<option selected='selected' value='$option'>$option</option>";
                                       }
                                       else {
                                           echo "<option value='$option'>$option</option>";
                                       }
                                   }
                                   echo "</select>";
                               ?>
                           </div>

                            <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal"
                               class="btn btn btn-success form-check-inline" href="#"><i class="fa fa-plus"></i> Добавить задачу
                            </button>
                          </div>

                      <?php else: ?>
                        <div class="text-right margin-rightside">
                           <?php
                               $selected = "";
                               if(!isset($_SESSION['sort_type'])){
                                 $selected = "Все задачи";
                               } else{
                                 $selected = $_SESSION['sort_type'];
                               }

                               $options = array('Все задачи', 'На сегодня', 'На неделю', 'На будущее');
                               echo "<select class='btn btn-success' id='chooseSortOption'>";
                               foreach($options as $option){
                                   if($selected == $option) {
                                       echo "<option selected='selected' value='$option'>$option</option>";
                                   }
                                   else {
                                       echo "<option value='$option'>$option</option>";
                                   }
                               }
                               echo "</select>";
                           ?>
                       </div>

                        <!--<div class="text-right margin-rightside">
                          <select name="category" id="category" class="btn btn-sm btn-success">
                             <option value="">Все задачи</option>;
                             <option value="">На сегодня</option>;
                             <option value="">На неделю</option>;
                             <option value="">На будущее</option>;
                          </select>
                        </div> -->
                      <?php endif; ?>

                      <div class="card-body">
                          <div class="table-responsive" id="tasks_table">
                            <table class="table-hover col-lg-12" id="tasks">
                              <colgroup>
                      					<col width="5%">
                      					<col width="20%">
                      					<col width="15%">
                      					<col width="15%">
                      					<col width="20%">
                      					<col width="10%">
                                <col width="15%">
                      				</colgroup>
                              <thead>
                                <tr>
                                  <th class="text-center no-sort">id</th>
                                  <th class="text-center no-sort">Заголовок</th>
                                  <th class="text-center no-sort">Приоритет</th>
                                  <th class="text-center no-sort">Дата окончания</th>
                                  <th class="text-center<?php if($_SESSION['login_type'] != 1){ ?> no-sort <?php } ?> ">Ответственный</th>
                                  <th class="text-center no-sort">Статус</th>
                                  <?php if($_SESSION['login_type'] == 1): ?>
                                    <th class="text-center no-sort">Действие</th>
                                  <?php endif; ?>
                                </tr>
                              </thead>

                              <tbody>

                                <?php
                                  include 'db_connect.php';
                                  $selectquery = "";
                                  if($_SESSION['login_type'] == 1){
                                    if(!isset($_SESSION['admin_sort_type']) || $_SESSION['admin_sort_type'] == "Сортировать по дате обновления"){
                                      $selectquery = "SELECT * FROM todo_list WHERE manager = " . $_SESSION['login_id'] . " ORDER BY update_date DESC";
                                    } else if($_SESSION['admin_sort_type'] == "Сортировать по подчиненным"){
                                      $selectquery = "SELECT * FROM todo_list WHERE manager = " . $_SESSION['login_id'] . " ORDER BY performer ASC";
                                    }
                                  }
                                  else{
                                    $selectquery = "";
                                    if(!isset($_SESSION['sort_type']) || $_SESSION['sort_type'] == "Все задачи"){
                                      $selectquery = "SELECT * FROM todo_list WHERE performer = " . $_SESSION['login_id'] . " ORDER BY update_date DESC";
                                    } else if($_SESSION['sort_type'] == "На сегодня"){
                                      $selectquery = "SELECT * FROM todo_list WHERE performer = " . $_SESSION['login_id'] . "  AND end_date between DATE_FORMAT(CONCAT(CURDATE(), ' 00:00:00'), '%Y/%m/%d %H:%i:%s') and DATE_FORMAT(CONCAT(CURDATE(), ' 23:59:59'), '%Y/%m/%d %H:%i:%s') ORDER BY update_date DESC";
                                    }else if($_SESSION['sort_type'] == "На неделю"){
                                      $selectquery = "SELECT * FROM todo_list WHERE performer = " . $_SESSION['login_id'] . " AND end_date between now() and date_add(now(), INTERVAL 1 WEEK) ORDER BY update_date DESC";
                                    }else if($_SESSION['sort_type'] == "На будущее"){
                                      $selectquery = "SELECT * FROM todo_list WHERE performer = " . $_SESSION['login_id'] . " AND end_date between now() and date_add(now(), INTERVAL 1 MONTH) ORDER BY update_date DESC";
                                    }
                                  }

                                  $query = $conn->query($selectquery);

                                  while($res = $query->fetch_assoc()){
                                  ?>
                                    <tr id="<?php echo $res["id"]; ?>">
                                      <td><?php echo $res['id'] ?></td>
                                      <td>
                                        <?php
                                          if(strtotime($res['end_date']) < strtotime(date('Y-m-d H:i:s', time())) & $res['status'] != 3)
                                            echo "<span class='badge badge-danger'>{$res['title']}</span>";
                                          elseif($res['status'] == 3)
                                            echo "<span class='badge badge-success'>{$res['title']}</span>";
                                          else
                                            echo "<span class='badge badge-dunger'>{$res['title']}</span>";
                                        ?>
                                      </td>

                                      <td>
                                        <?php
                                        //echo $res['priority']
                                        if($res['priority'] == 1){
                                          echo "<span class='badge badge-danger'>Высокий</span>";
                                        }elseif($res['priority'] == 2){
                                          echo "<span class='badge badge-primary'>Средний</span>";
                                        }elseif($res['priority'] == 3){
                                          echo "<span class='badge badge-active'>Низкий</span>";
                                        }
                                        ?>
                                      </td>

                                      <td><?php echo date("d-m-Y H.i", strtotime($res['end_date'])); ?></td>

                                      <td>
                                        <?php
                                        $performerId = $res['performer'];
                                      	$performer = $conn->query("SELECT concat(firstname,' ',lastname) as name FROM user_list where id = '$performerId'");
                                        $user = $performer -> fetch_assoc();
                                        echo $user['name'];
                                      	?>
                                      </td>

                                      <td>
                                        <?php
                                        if($res['status'] == 1){
                                          echo "<span class='badge badge-primary'>К выполнению</span>";
                                        }elseif($res['status'] == 2){
                                          echo "<span class='badge badge-warning'>Выполняется</span>";
                                        }elseif($res['status'] == 3){
                                          echo "<span class='badge badge-success'>Выполнена</span>";
                                        }
                                        elseif($res['status'] == 4){
                                          echo "<span class='badge badge-dunger'>Отменена</span>";
                                        }
                                        ?>
                                      </td>

                                      <!--<td><i class="fa fa-edit" aria-hidden="true"></i></td> -->
                                      <!--<td><i class="fa fa-trash" aria-hidden="true"></i></td> -->
                                      <?php if($_SESSION['login_type'] == 1): ?>
                                        <td class="text-center"><input type="button" name="delete" value="Удалить" id="<?php echo $res["id"]; ?>" class="btn btn-danger delete_data" /></td>
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

<div id="add_data_Modal" class="modal fade">
     <div class="modal-dialog modal-lg">
          <div class="modal-content">
               <div class="modal-header">
                    <h4 class="modal-title" value="modaltitle" name="modaltitle" id="modaltitle">Задача</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                    <form method="post" id="insert_form">

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="" class="control-label">Заголовок</label>
                                <input type="text" class="form-control form-control-sm" name="title" id="title" <?php if($_SESSION['login_type'] != 1){ ?>disabled<?php } ?> required>
                              </div>
                            </div>


                              <div class="col-md-6">
                                <div class="form-group">
                                <label for="">Ответственный</label>
                                <select <?php if($_SESSION['login_type'] != 1){ ?>disabled<?php } ?> class="form-control form-control-sm select2" name="performer" id="performer" required>
                                  <option value=""></option>
                                  <?php
                                  $userid = $_SESSION['login_id'];
                                  $managers = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM user_list where type = 2 and manager = '$userid' order by concat(firstname,' ',lastname) asc ");
                                  while($row= $managers->fetch_assoc()):
                                  ?>
                                  <option value="<?php echo $row['id'] ?>"><?php echo ucwords($row['name']) ?></option>
                                  <?php endwhile; ?>
                                </select>
                              </div>
                            </div>

                          </div>


                          <div class="row">
                            <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="" class="control-label">Дата начала</label>
                                    <input type="datetime-local" class="form-control form-control-sm" autocomplete="off" name="start_date" id="start_date" <?php if($_SESSION['login_type'] != 1){ ?>disabled<?php } ?> required>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="" class="control-label">Заканчивается</label>
                                    <input type="datetime-local" class="form-control form-control-sm" autocomplete="off" name="end_date" id="end_date" <?php if($_SESSION['login_type'] != 1){ ?>disabled<?php } ?> required>
                                  </div>
                                </div>
                          </div>

                              <div class="row">
                                 <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="" class="control-label">Приоритет</label>
                                    <select name="priority" name="priority" id="priority" class="custom-select custom-select-sm" <?php if($_SESSION['login_type'] != 1){ ?>disabled<?php } ?> required>
                                      <option value="1">Высокий</option>
                                      <option value="2">Средний</option>
                                      <option value="3">Низкий</option>
                                    </select>
                                  </div>
                                </div>

                                   <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="" class="control-label">Статус</label>
                                      <select name="status" name="status" id="status" class="custom-select custom-select-sm" required>
                                        <option value="1">К выполнению</option>
                                        <option value="2">Выполняется</option>
                                        <option value="3">Выполнена</option>
                                        <option value="4">Отменена</option>
                                      </select>
                                    </div>
                                  </div>
                              </div>

                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="" class="control-label">Описание</label>
                                <textarea name="description" id="description" cols="30" rows="10" class="summernote form-control" <?php if($_SESSION['login_type'] != 1){ ?>disabled<?php } ?> required></textarea>
                              </div>
                            </div>
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

 $(document).ready(function() {

  $('#tasks').dataTable( {
     "columnDefs":
     [ {
       "targets": 'no-sort',
       "orderable": false
     }],
     "ordering":false
 });


  $('#chooseSortOption').on('change', function() {
    var select = document.getElementById('chooseSortOption');
    var index = select.selectedIndex;
    var given_text = select.options[index].value;
         if ($("#product_id").val() != "") {
             $.ajax({
                 url: "setsorttype.php",
                 method: "POST",
                 data: {
                     given_text: given_text
                 },
                 success: function (response){
                     location.reload();
                 }
             });

         }
     });

    $('#add').click(function() {
      var addTask = "yes";
      $.ajax({
          url: "selectTypeOfAction.php",
          method: "POST",
          data: {
              addTask: addTask
          },
          success: function(data) {
            $('#insert').val("Insert");
            $('#insert_form')[0].reset();
          }
      });
    });

    $('table tr').click( function () {
      var row_id = $(this).attr("id");
      $.ajax({
          url: "fetch.php",
          method: "POST",
          data: {
              row_id: row_id
          },
          dataType: "json",
          success: function(data) {
              $('#title').val(data.title);
              $('#description').val(data.description);
              $('#start_date').val(data.start_date);
              $('#end_date').val(data.end_date);
              $('#performer').val(data.performer);
              $('#priority').val(data.priority);
              $('#status').val(data.status);
              $('#row_id').val(data.id);
              $('#insert').val("Обновить");
              $('#modaltitle').val('Добавить изменения');
              $('#add_data_Modal').modal('show');
          }
      });
  });

    $('#insert_form').on("submit", function(event) {
        event.preventDefault();
        $.ajax({
            url: "insert.php",
            method: "POST",
            data: $('#insert_form').serialize(),
            beforeSend: function() {
                $('#insert').val("Добавляю");
            },
            success: function(data) {
                $('#insert_form')[0].reset();
                $('#add_data_Modal').modal('hide');
                location.reload();
            }
        });
    });

    $(document).on('click', '.delete_data', function() {
        var row_id = $(this).attr("id");
        if (row_id != '') {
            $.ajax({
                url: "delete.php",
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
