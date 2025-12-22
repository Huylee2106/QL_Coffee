<?php
require 'config.php';

if (isset($_POST['btnNhapKho'])) {
    // Làm sạch dữ liệu đầu vào
    $id_selection = mysqli_real_escape_string($conn, $_POST['ID_MT']);
    $name = mysqli_real_escape_string($conn, $_POST['Name_MT']);
    $unit = mysqli_real_escape_string($conn, $_POST['Unit']);
    $qty = (int)$_POST['Quantity'];
    $price = (float)$_POST['Price'];
    $date = $_POST['Import_date'];

    // Xác định ID thực sự
    if ($id_selection === "NEW") {
        $final_id = mysqli_real_escape_string($conn, $_POST['new_ID_MT']);
        
        // Kiểm tra xem ID mới này đã tồn tại trong kho chưa (tránh trùng lặp)
        $check_duplicate = mysqli_query($conn, "SELECT ID_MT FROM warehouse WHERE ID_MT = '$final_id'");
        if (mysqli_num_rows($check_duplicate) > 0) {
            echo "<script>alert('Lỗi: Mã nguyên liệu này đã tồn tại!'); window.history.back();</script>";
            exit();
        }
    } else {
        $final_id = $id_selection;
    }

    // Kiểm tra dữ liệu rỗng
    if (empty($final_id) || empty($name)) {
        echo "<script>alert('Lỗi: Vui lòng nhập đầy đủ thông tin!'); window.history.back();</script>";
        exit();
    }

    // 1. Thêm vào lịch sử nhập kho (stock_receipt)
    $sql_receipt = "INSERT INTO stock_receipt (ID_MT, Name_MT, Import_date, Price, Quantity, Unit) 
                    VALUES ('$final_id', '$name', '$date', '$price', '$qty', '$unit')";
    
    if (mysqli_query($conn, $sql_receipt)) {
        
        // 2. Cập nhật hoặc Thêm mới vào kho (warehouse)
        $check_warehouse = mysqli_query($conn, "SELECT ID_MT FROM warehouse WHERE ID_MT = '$final_id'");

        if (mysqli_num_rows($check_warehouse) > 0) {
            // Nếu đã có -> Cộng dồn số lượng
            $sql_stock = "UPDATE warehouse SET Quantity = Quantity + $qty WHERE ID_MT = '$final_id'";
        } else {
            // Nếu là nguyên liệu mới hoàn toàn -> Thêm mới dòng dữ liệu
            $sql_stock = "INSERT INTO warehouse (ID_MT, Name_MT, Quantity, Unit) 
                          VALUES ('$final_id', '$name', '$qty', '$unit')";
        }
        
        if (mysqli_query($conn, $sql_stock)) {
            echo "<script>alert('Nhập kho thành công!'); window.location.href='../page_staff_manager/page_manager.php';</script>";
        } else {
            echo "Lỗi cập nhật kho: " . mysqli_error($conn);
        }
    } else {
        echo "Lỗi lưu lịch sử: " . mysqli_error($conn);
    }
}
?>