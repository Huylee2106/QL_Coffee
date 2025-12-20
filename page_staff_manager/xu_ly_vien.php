<?php
require '../config/config.php';
$action = $_GET['action'];
$id = $_GET['id'];

if ($action == 'confirm') {
    // Chuyển đơn sang trạng thái đã thanh toán -> Sẽ hiện bên pha chế
    $conn->query("UPDATE bill SET bill_status = 1 WHERE ID_bill = '$id'");
} 

if ($action == 'done') {
    // Chuyển món sang trạng thái đã pha xong -> Sẽ ẩn khỏi danh sách pha chế
    $conn->query("UPDATE details_order SET item_status = 1 WHERE ID_bill = '$id'");
}

if ($action == 'release_table') {
    $id_tb = $_GET['id_tb'] ?? '';
    if ($id_tb != '') {
        // Cập nhật trạng thái bàn về 'Trống'
        $sql = "UPDATE tables SET Status = 'Trống' WHERE ID_TB = '$id_tb'";
        $conn->query($sql);
    }
}

header("Location: page_staff.php"); // Quay lại trang nhân viên
?>