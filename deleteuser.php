<?php
include 'db_connect.php';
if (isset($_POST["row_id"])) {
    $query  = "DELETE FROM user_list WHERE id = '" . $_POST["row_id"] . "'";
    $result = mysqli_query($conn, $query);
}
?>
