<?php
require 'config.php';

if (isset($_POST['amount']) && isset($_POST['action'])) {
    $amount = (float)$_POST['amount'];
    $action = $_POST['action'];

    if ($amount <= 0) {
        echo "<script>alert('Số tiền phải lớn hơn 0'); window.history.back();</script>";
        exit();
    }

    if ($action == 'add') {
        // Nạp tiền
        $sql = "UPDATE wallet SET fund = fund + $amount";
        $msg = "Đã nạp thành công " . number_format($amount) . "đ vào ví!";
    } else if ($action == 'sub') {
        // Kiểm tra xem ví có đủ tiền để rút không
        $res = $conn->query("SELECT fund FROM wallet LIMIT 1");
        $row = $res->fetch_assoc();
        if ($row['fund'] < $amount) {
            echo "<script>alert('Số dư ví không đủ để rút!'); window.history.back();</script>";
            exit();
        }
        // Rút tiền
        $sql = "UPDATE wallet SET fund = fund - $amount";
        $msg = "Đã rút thành công " . number_format($amount) . "đ khỏi ví!";
    }

    if ($conn->query($sql)) {
        echo "<script>alert('$msg'); window.location.href='../page_staff_manager/page_manager.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
$conn->close();
?>