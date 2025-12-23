<?php
    session_start();
    require '../config/config.php';

    $ID_SH=$_POST['ID_shift'];
    $ID=$_SESSION['id'];

    $sql= "INSERT INTO shift_request(ID_shift, ID, `status`) VALUES ('$ID_SH','$ID','Chờ Xác Nhận') ";
    $conn->query($sql);

    $conn->query("
    UPDATE shift 
    SET Shift_status = 'chờ xác nhận' 
    WHERE ID_shift = '$ID_SH'
");
    header("Location: ../page_staff_manager/page_staff.php");
    exit;
?>


