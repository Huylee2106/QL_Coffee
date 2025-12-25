<?php
include "../config/config.php"; 

if (isset($_POST['ID_food'])) {
    $id = mysqli_real_escape_string($conn, $_POST['ID_food']);
    $sql = "SELECT food_name FROM menu WHERE id_food = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo $row['food_name'];
    } else {
        echo "Không tìm thấy";
    }
}
?>