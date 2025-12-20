<?php
session_start();        // Bắt đầu session
session_unset();        // Xóa tất cả biến session
session_destroy();      // Hủy session
header("Location: ../login_staff_manager/login_staff.php"); // Chuyển về trang đăng nhập
exit();
?>