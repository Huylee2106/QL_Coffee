<?php
    require '../config/config.php';

    $ID    = $_POST['ID'];
    $month = $_POST['month'];
    $year  = $_POST['year'];

    $sql = "
    UPDATE salary
    SET Salary_status = 'Đã Thanh Toán',
        Payment_date = NOW()
    WHERE ID = ?
    AND Salary_month = ?
    AND Year = ?
    AND Salary_status <> 'Đã Trả'
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $ID, $month, $year);
    $stmt->execute();

    header("Location: ../page_staff_manager/page_manager.php");
?>
