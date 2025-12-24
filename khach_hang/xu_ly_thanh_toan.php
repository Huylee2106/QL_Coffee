<?php
// 1. KẾT NỐI DATABASE
$conn = new mysqli("localhost", "root", "", "ql_caffe");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// 2. LẤY DỮ LIỆU TỪ FORM
$ten_kh      = $_POST['ten'] ?? 'Khách vãng lai';
$sdt         = $_POST['sdt'] ?? '';
$tong_tien   = (float)($_POST['tong_tien'] ?? 0);
$json_cart   = $_POST['json_cart'] ?? '[]';
$cart        = json_decode($json_cart, true);

// Tạo mã ID
$id_bill = "B" . date("His"); 
$id_tb   = $_POST['id_tb'] ?? 'Mang đi';
$id_nv   = "NV001"; // ID nhân viên mặc định

// 3. LƯU VÀO BẢNG BILL
$sql_bill = "INSERT INTO bill (ID_bill, Day, Total, ID_TB, ID, bill_status) VALUES (?, NOW(), ?, ?, ?, 0)";
$stmt_bill = $conn->prepare($sql_bill);
if ($stmt_bill) {
    $stmt_bill->bind_param("sdss", $id_bill, $tong_tien, $id_tb, $id_nv);
    $stmt_bill->execute();
}

// 4. LƯU CHI TIẾT VÀO BẢNG DETAILS_ORDER
if (!empty($cart)) {
    $sql_detail = "INSERT INTO details_order (food_name, id_food, qty, price, ID_bill, name_KH, phonenumber, ID_TB, item_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt_detail = $conn->prepare($sql_detail);
    
    foreach ($cart as $item) {
        $stmt_detail->bind_param("ssisssss", 
            $item['ten'], 
            $item['id'], 
            $item['quantity'], 
            $item['gia'], 
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

// // Chỉ cập nhật trạng thái bàn nếu thực sự là ngồi tại bàn (không phải Mang đi)
// if ($id_tb != 'Mang đi') {
//     $conn->query("UPDATE tables SET Status = 'Có khách' WHERE ID_TB = '$id_tb'");
// }

$conn->close(); //
?>