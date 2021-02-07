<?php
$conn = new mysqli('localhost','mysql','mysql','todo_db')or die("Could not connect to mysql".mysqli_error($con));
$charset = "utf8";
mysqli_set_charset($conn, $charset);
?>
