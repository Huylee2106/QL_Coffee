<?php
// 1. KẾT NỐI DATABASE
$conn = new mysqli("localhost", "root", "", "ql_caffe"); //
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error); //
}

// 2. LẤY DỮ LIỆU TỪ FORM
$ten_kh      = $_POST['ten'] ?? ''; //
$sdt         = $_POST['sdt'] ?? ''; //
$tong_tien   = (float)($_POST['tong_tien'] ?? 0); //
$json_cart   = $_POST['json_cart'] ?? '[]'; //
$cart        = json_decode($json_cart, true); //

// Tạo các mã ID giả định (vì form hiện tại chưa có phần chọn bàn)
$id_bill = "B" . date("His"); // Mã hóa đơn dựa trên thời gian
$id_tb = $_POST['id_tb'] ?? 'Mang đi';// Lấy ID bàn từ form gửi lên
$id_nv   = "NV001";           // ID nhân viên mặc định

// 3. LƯU VÀO BẢNG BILL
// Có 5 cột cần truyền tham số: ID_bill, Total, ID_TB, ID, bill_status
$sql_bill = "INSERT INTO bill (ID_bill, Day, Total, ID_TB, ID, bill_status) VALUES (?, NOW(), ?, ?, ?, 0)";
$stmt_bill = $conn->prepare($sql_bill);

// "sdss" tương ứng với: 
// s (string - id_bill), d (double - tong_tien), s (string - id_tb), s (string - id_nv)
$stmt_bill->bind_param("sdss", $id_bill, $tong_tien, $id_tb, $id_nv);
$stmt_bill->execute();

// 4. LƯU CHI TIẾT VÀO BẢNG DETAILS_ORDER
$sql_detail = "INSERT INTO details_order (food_name, id_food, qty, price, ID_bill, name_KH, phonenumber, ID_TB) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_detail = $conn->prepare($sql_detail);

if (!empty($cart)) {
    foreach ($cart as $item) {
        // Map dữ liệu từ JSON giỏ hàng vào câu lệnh SQL
        $stmt_detail->bind_param("ssisssss", 
            $item['ten'],      //
            $item['id'],       // Lấy từ data-id ở menu
            $item['quantity'], //
            $item['gia'],      //
            $id_bill, 
            $ten_kh, 
            $sdt, 
            $id_tb
        );
        $stmt_detail->execute();
    }
}

// 5. THÔNG BÁO THÀNH CÔNG
echo "<h2>Đặt hàng thành công!</h2>";
echo "<p>Cảm ơn khách hàng: $ten_kh</p>";
echo "<a href='index.php'>Quay lại trang chủ</a>"; //

if ($id_tb != 'Mang đi') {
    $conn->query("UPDATE tables SET Status = 'Có khách' WHERE ID_TB = '$id_tb'");
}

// Chỉ cập nhật trạng thái bàn nếu thực sự là ngồi tại bàn (không phải Mang đi)
if ($id_tb != 'Mang đi') {
    $conn->query("UPDATE tables SET Status = 'Có khách' WHERE ID_TB = '$id_tb'");
}

$conn->close(); //
?>