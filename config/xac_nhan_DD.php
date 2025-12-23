<?php
    session_start();
    require '../config/config.php';
    $ID_SH=$_POST['ID_shift'];
    $ID=$_POST['ID'];



    $conn->query("
    UPDATE shift_request
    SET status = 'Đã Xác Nhận' 
    WHERE ID_shift = '$ID_SH'");

    $conn->query("
    UPDATE shift 
    SET Shift_status = 'Đã Vào Làm' 
    WHERE ID_shift = '$ID_SH'
");
    header("Location: ../page_staff_manager/page_manager.php");
    exit;

?>