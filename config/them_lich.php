<?php
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
  
    $id =$_POST['ID'];
    $name =$_POST['name_NV'];
    $date =$_POST['date'];
    $shift =$_POST['shift'];


    $queryMax = "SELECT MAX(CAST(SUBSTRING(ID_shift, 3) AS UNSIGNED)) AS maxNum FROM `shift` WHERE ID_shift LIKE 'SH%'";
    $resMax = mysqli_query($conn, $queryMax);
    $rowMax = mysqli_fetch_assoc($resMax);
    $num = ($rowMax['maxNum'] != null) ? $rowMax['maxNum'] + 1 : 1;
    $newIDSHIFT = "SH" . str_pad($num, 3, "0", STR_PAD_LEFT);


   
    $sqlLich = "INSERT INTO `shift` (ID_shift, `ID`, `Name`, Working_date, `shift`) 
                  VALUES (?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sqlLich);
    mysqli_stmt_bind_param($stmt, "sssss", 
        $newIDSHIFT, $id, $name, $date, $shift
    );

    if (mysqli_stmt_execute($stmt)) {
        echo '<script>
            alert("Đã thêm lịch thành công cho nhân viên\nID: '.$id.'\nChức vụ: '.$shift.'\n ngày làm '.$date.'");
            window.location.href="../page_staff_manager/page_manager.php";
        </script>';
    } else {
        echo '<script>alert("thêm lịch thất bại: '.$conn->error.'"); window.history.back();</script>';
    }
    mysqli_stmt_close($stmt);
}
    header("Location: ../page_staff_manager/page_staff.php");
    exit;
?>