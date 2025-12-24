<?php
require 'config.php';

if (isset($_POST['btn_save'])) {
    $id_food = $_POST['id_food'];
    $food_name = $_POST['food_name'];
    $price = (float)$_POST['price'];
    $type = $_POST['type'];

    // Xử lý ảnh
    // ... phía trên giữ nguyên ...

// Xử lý ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file_name = $_FILES['image']['name'];
        $file_tmp  = $_FILES['image']['tmp_name'];

        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($file_tmp, $target_file)) {
            $sql = "INSERT INTO menu (id_food, food_name, price, image, type)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdss", $id_food, $food_name, $price, $file_name, $type);
            $stmt->execute();

            if ($stmt->execute()) {
                echo "<script>alert('Thêm món thành công!'); window.location.href='../page_staff_manager/page_staff.php';</script>";
            } else {
                echo "Lỗi SQL: " . $conn->error;
            }
        } else {
            echo "Lỗi: Không thể di chuyển file vào thư mục uploads. Hãy kiểm tra quyền ghi (Permission).";
        }
    }
    }
    $conn->close();
?>