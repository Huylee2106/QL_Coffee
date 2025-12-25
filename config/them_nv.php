<?php
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Nhận dữ liệu
    $username = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $phone    = $_POST['phone'] ?? '';
    $sex      = $_POST['sex'] ?? '';
    $date     = $_POST['date'] ?? '';
    $pos_raw  = $_POST['position'] ?? '';
    $address  = $_POST['address'] ?? '';
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';
    $roleNV   = 0;

   
    if ($password !== $password2) {
        echo '<script>alert("Mật khẩu nhập lại không khớp!"); window.history.back();</script>';
        exit();
    }

    
    $checkUser = "SELECT * FROM `user` WHERE email = '$email'";
    $result = mysqli_query($conn, $checkUser);
    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("Email này đã tồn tại trên hệ thống! Tạo nhân viên thất bại");window.location.href="../page_staff_manager/page_manager.php";</script>';
        exit();
    }

    // 4. Map chức vụ
    $position_ID = [
        "1" => "Pha Chế",
        "2" => "Thu Ngân",
        "3" => "Bảo Vệ",
        "4" => "Phục Vụ"
    ];
    $position_fn = $position_ID[$pos_raw] ?? null;

    if (!$position_fn) {
        echo '<script>alert("Chức vụ không hợp lệ!"); window.history.back();</script>';
        exit();
    }

    // 5. Sinh ID NV
    $queryMax = "SELECT MAX(CAST(SUBSTRING(ID, 3) AS UNSIGNED)) AS maxNum FROM `user` WHERE ID LIKE 'NV%'";
    $resMax = mysqli_query($conn, $queryMax);
    $rowMax = mysqli_fetch_assoc($resMax);
    $num = ($rowMax['maxNum'] != null) ? $rowMax['maxNum'] + 1 : 1;
    $newNVID = "NV" . str_pad($num, 3, "0", STR_PAD_LEFT);

    // 6. Mã hóa mật khẩu
    $passwordMHNV = password_hash($password, PASSWORD_DEFAULT);

   
    $sqlUserNV = "INSERT INTO `user` (ID, `password`, email, `name`, Sex, `Date_of_birth`, `Address`, `Position`, `Phone_number`, `Role`) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sqlUserNV);
    mysqli_stmt_bind_param($stmt, "sssssssssi", 
        $newNVID, $passwordMHNV, $email, $username, $sex, $date, $address, $position_fn, $phone, $roleNV
    );

    if (mysqli_stmt_execute($stmt)) {
        echo '<script>
            alert("Cấp Tài Khoản Thành Công\nID: '.$newNVID.'\nChức vụ: '.$position_fn.'");
            window.location.href="../page_staff_manager/page_manager.php";
        </script>';
    } else {
        echo '<script>alert("Cấp tài khoản thất bại: '.$conn->error.'"); window.history.back();</script>';
    }
    mysqli_stmt_close($stmt);
}
    header("Location: ../page_staff_manager/page_manager.php");
    exit;
?>