<?php
  session_start();
  include 'db_connect.php';
  date_default_timezone_set('Asia/Yekaterinburg');
  if(!empty($_POST))
  {
       $message = '';
       $title = mysqli_real_escape_string($conn, $_POST["title"]);
       $performer = mysqli_real_escape_string($conn, $_POST["performer"]);
       $start_date = $_POST["start_date"];
       $end_date = $_POST["end_date"];
       $priority = mysqli_real_escape_string($conn, $_POST["priority"]);
       $status = mysqli_real_escape_string($conn, $_POST["status"]);
       $description = mysqli_real_escape_string($conn, $_POST["description"]);
       $updated = date('Y-m-d H:i:s', time());


       if($_POST["row_id"] != '' & $_SESSION['add_task'] != "yes")
       {
         $query = "";
         if($_SESSION['login_type'] == 1){
            $query = "
            UPDATE todo_list
            SET title='$title',
            description='$description',
            start_date='$start_date',
            end_date = '$end_date',
            update_date = '$updated',
            performer = '$performer',
            priority = '$priority',
            status = '$status'
            WHERE id='".$_POST["row_id"]."'";
          }
          else{
            $query = "
            UPDATE todo_list
            SET status = '$status',
            update_date = '$updated'
            WHERE id='".$_POST["row_id"]."'";
          }
            $message = 'Data Updated';
       }
       else
       {
            $message = 'Data Inserted';
            $manager = $_SESSION['login_id'];

            $query = "
              INSERT INTO todo_list(id, title, description, start_date, end_date, update_date, performer, manager, priority, status)
              VALUES (NULL, '$title', '$description', '$start_date', '$end_date', '$updated', '$performer', '$manager', '$priority', '$status')
            ";
       }
       mysqli_query($conn, $query);
  }
?>
