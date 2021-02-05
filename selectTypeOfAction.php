<?php
  session_start();
  if (isset($_POST["addTask"])) {
    $_SESSION['add_task'] = $_POST["addTask"];
  }
 ?>
