<?php
// 1. KẾT NỐI DATABASE
$servername = "localhost";
$username   = "root";        // tài khoản MySQL
$password   = "";            // mật khẩu MySQL
$dbname     = "shop_db";     // TÊN DATABASE của bạn

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// 2. LẤY DỮ LIỆU TỪ FORM
$ten            = $_POST['ten']            ?? '';
$sdt            = $_POST['sdt']            ?? '';
$payment_method = $_POST['payment_method'] ?? '';
$json_cart      = $_POST['json_cart']      ?? '[]';
$tong_tien      = $_POST['tong_tien']      ?? 0;

// (tuỳ chọn) ép kiểu số cho tổng tiền
$tong_tien = (int)$tong_tien;

// 3. CHUẨN BỊ CÂU LỆNH INSERT
// Giả sử bảng trong DB tên là `don_hang` và có cột:
// Ten_khach_hang, sdt, Phuong_thuc_thanh_toan, Gio_hang, Tong_tien
$sql = "INSERT INTO don_hang (Ten_khach_hang, sdt, Phuong_thuc_thanh_toan, Gio_hang, Tong_tien)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $ten, $sdt, $payment_method, $json_cart, $tong_tien);

// 4. THỰC THI
if ($stmt->execute()) {
    // Lưu xong thì thông báo
    echo "<h2>Đặt hàng thành công!</h2>";
    echo "<p>Cảm ơn bạn, $ten</p>";
    echo "<a href='index.php'>Quay lại trang chủ</a>";
} else {
    echo "Lỗi khi lưu đơn hàng: " . $stmt->error;
}

// 5. ĐÓNG KẾT NỐI
$stmt->close();
$conn->close();
?>
