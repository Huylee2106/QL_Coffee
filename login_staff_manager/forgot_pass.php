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