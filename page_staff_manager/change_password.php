<?php
session_start();
require '../config/config.php';

// Kiểm tra xem đã đăng nhập chưa
if (!isset($_SESSION['id'])) {
    header("Location: ../login_staff_manager/login_staff.php");
    exit();
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    $user_id = $_SESSION['id']; // Lấy ID từ session đã lưu lúc đăng nhập

    // 1. Lấy mật khẩu hiện tại trong CSDL để đối chiếu
    // Lưu ý: Cột trong DB là ID (viết hoa)
    $stmt = $conn->prepare("SELECT password FROM user WHERE ID = ?");
    $stmt->bind_param("s", $user_id); // Dùng "s" vì ID của bạn có thể là chuỗi
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // 2. Kiểm tra logic
    if ($old_pass !== $user['password']) {
        $message = "<p style='color:red;'>Mật khẩu cũ không chính xác!</p>";
    } elseif ($new_pass != $confirm_pass) {
        $message = "<p style='color:red;'>Mật khẩu mới không khớp!</p>";
    } elseif (strlen($new_pass) < 6) {
        $message = "<p style='color:red;'>Mật khẩu mới phải từ 6 ký tự trở lên!</p>";
    } else {
        // 3. Cập nhật mật khẩu mới (Cột ID viết hoa)
        $update = $conn->prepare("UPDATE user SET password = ? WHERE ID = ?");
        $update->bind_param("ss", $new_pass, $user_id);
        
        if ($update->execute()) {
            echo "<script>alert('Đổi mật khẩu thành công!'); window.location.href='page_staff.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đổi mật khẩu</title>
    <link rel="stylesheet" href="../login_staff_manager/forgot_pass.css">
</head>
<body>
    <div class="wrapper">
        <form method="POST">
            <h1>Đổi mật khẩu</h1>
            <?php echo $message; ?>
            <div class="input-box">
                <input type="password" name="old_password" placeholder="Mật khẩu cũ" required>
            </div>
            <div class="input-box">
                <input type="password" name="new_password" placeholder="Mật khẩu mới" required>
            </div>
            <div class="input-box">
                <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu mới" required>
            </div>
            <button type="submit" class="btn">Xác nhận đổi</button>
            <div class="register-link">
                <p><a href="page_staff.php">Quay lại</a></p> <p><a href="..\login_staff_manager\forgot_pass.php">Quên mật khẩu</a></p>
            </div>
        </form>
    </div>
</body>
</html>