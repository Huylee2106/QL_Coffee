<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../config/config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT name FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 1. Tạo OTP 6 số ngẫu nhiên
        $otp = rand(100000, 999999);
        
        // 2. Lưu OTP và Email vào Session để đối chiếu ở trang sau
        $_SESSION['reset_otp'] = $otp;
        $_SESSION['reset_email'] = $email;
        $_SESSION['otp_time'] = time(); // Lưu thời điểm tạo để làm hết hạn (tùy chọn)

        // 3. Gửi Mail mã OTP
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hoangphu24122005@gmail.com'; 
            $mail->Password = 'iynl ikbi nvkf yaib'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('hoangphu24122005@gmail.com', 'Caffee Support');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Ma xac nhan doi mat khau';
            $mail->Body    = "Mã xác nhận (OTP) của bạn là: <h2 style='color:blue;'>$otp</h2> Mã có hiệu lực trong 5 phút.";

            $mail->send();
            
            // Chuyển hướng sang trang nhập OTP
            header("Location: verify_otp.php");
            exit();
        } catch (Exception $e) {
            $message = "Lỗi gửi mail: {$mail->ErrorInfo}";
        }
    } else {
        $message = "Email không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../login_staff_manager/forgot_pass.css">
    <title>Forgot Password</title>
</head>
<body>
    <div class="wrapper">
        <form action="../login_staff_manager/forgot_pass.php" method="POST">
            <h1>Quên mật khẩu</h1>
            <?php echo $message; ?>
            <div class="login">
                <div class="input-box">
                    <input type="email" name="email" placeholder="Nhập email" required>
                </div>
                <button type="submit" class="btn">Tiếp tục</button>
                <div class="register-link"><p><a href="./login_staff.php">Trang chủ</a></p></div>
            </div>
        </form>
    </div>
</body>
</html>