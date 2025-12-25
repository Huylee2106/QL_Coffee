<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_food = mysqli_real_escape_string($conn, $_POST['ID_food']);
    $ids_mt  = $_POST['ID_MT'];
    $qtys    = $_POST['quantity'];
    $units   = $_POST['unit'];

    for ($i = 0; $i < count($ids_mt); $i++) {

        $id_mt = mysqli_real_escape_string($conn, $ids_mt[$i]);
        $qty   = mysqli_real_escape_string($conn, $qtys[$i]);
        $unit  = mysqli_real_escape_string($conn, $units[$i]);

        // lấy tên nguyên liệu
        $res = mysqli_query($conn, "SELECT Name_MT FROM warehouse WHERE ID_MT='$id_mt'");
        if (mysqli_num_rows($res) == 0) continue;

        $name_mt = mysqli_fetch_assoc($res)['Name_MT'];

        // insert
        mysqli_query($conn, "
            INSERT INTO recipe (ID_MT, id_food, Name_MT, Quantity_MT, Unit)
            VALUES ('$id_mt', '$id_food', '$name_mt', '$qty', '$unit')
        ");
    }

    echo "<script>
            alert('✅ Lưu công thức thành công');
            window.history.back();
          </script>";
}
?>
