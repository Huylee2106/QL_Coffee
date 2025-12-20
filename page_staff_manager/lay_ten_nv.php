<?php

include "../config/config.php"; 

if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $sql = "SELECT `Name` FROM `user` WHERE ID = '$id'"; 
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo $row['Name'];
    } else {
        echo "Không tìm thấy";
    }
}
?>