<?php
session_start();
include 'db_connect.php';
if (isset($_POST["row_id"])) {
    $_SESSION['add_task'] = "";
    $query  = "SELECT * FROM todo_list WHERE id = '" . $_POST["row_id"] . "'";
    $result = mysqli_query($conn, $query);
    $row    = mysqli_fetch_array($result);

    $row['start_date'] = date('Y-m-d\TH:i:s', strtotime($row['start_date']));
    $row['end_date'] = date('Y-m-d\TH:i:s', strtotime($row['end_date']));
    echo json_encode($row);
}
?>
