<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['reset_otp'])) {
    header("Location: forgot_pass.php");
    exit();
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = $_POST['otp'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($user_otp != $_SESSION['reset_otp']) {
        $message = "<p style='color:red;'>Mã OTP không chính xác!</p>";
    } elseif ($new_pass != $confirm_pass) {
        $message = "<p style='color:red;'>Mật khẩu xác nhận không khớp!</p>";
    } else {
        // Nếu mọi thứ OK, cập nhật mật khẩu vào CSDL
        $email = $_SESSION['reset_email'];
        // Nếu web có mã hóa thì dùng: $hashed_pass = md5($new_pass);
        $update = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
        $update->bind_param("ss", $new_pass, $email);
        
        if ($update->execute()) {
            // Xóa session sau khi đổi xong để bảo mật
            session_destroy();
            echo "<script>alert('Đổi mật khẩu thành công!'); window.location.href='login_staff.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận OTP</title>
    <link rel="stylesheet" href="../login_staff_manager/forgot_pass.css">
</head>
<body>
    <div class="wrapper">
        <form method="POST">
            <h1>Xác nhận OTP</h1>
            <?php echo $message; ?>
            <p>Mã đã được gửi đến: <?php echo $_SESSION['reset_email']; ?></p>
            <div class="input-box">
                <input type="text" name="otp" placeholder="Nhập mã 6 số" required>
            </div>
            <div class="input-box">
                <input type="password" name="new_password" placeholder="Mật khẩu mới" required>
            </div>
            <div class="input-box">
                <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu mới" required>
            </div>
            <button type="submit" class="btn">Đổi mật khẩu</button>
        </form>
    </div>
</body>
</html>