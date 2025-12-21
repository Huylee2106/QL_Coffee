<?php
require '../config/config.php';
$action = $_GET['action'];
$id = $_GET['id'];

if ($action == 'confirm') {
    // 1. Cập nhật hóa đơn sang trạng thái đã thanh toán (bill_status = 1)
    $conn->query("UPDATE bill SET bill_status = 1 WHERE ID_bill = '$id'");

    // 2. Lấy ID_TB (Mã bàn) từ hóa đơn này để cập nhật trạng thái bàn
    $result = $conn->query("SELECT ID_TB FROM bill WHERE ID_bill = '$id'");
    if ($row = $result->fetch_assoc()) {
        $id_tb = $row['ID_TB'];
        
        // 3. Nếu không phải là "Mang đi", thì mới đổi trạng thái bàn thành "Có khách"
        if ($id_tb != 'Mang đi') {
            $conn->query("UPDATE tables SET Status = 'Có khách' WHERE ID_TB = '$id_tb'");
        }
    }
}

if ($action == 'delete') {
    // Chuyển đơn sang trạng thái từ chối đơn
    $conn->query("UPDATE bill SET bill_status = 2 WHERE ID_bill = '$id'");
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