<?php
// ================================
// 1. KẾT NỐI DATABASE
// ================================
$conn = new mysqli("localhost", "root", "", "ql_caffe");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// ================================
// 2. LẤY DỮ LIỆU TỪ FORM
// ================================
$ten_kh    = $_POST['ten'] ?? 'Khách vãng lai';
$sdt       = $_POST['sdt'] ?? '';
$tong_tien = (float)($_POST['tong_tien'] ?? 0);
$json_cart = $_POST['json_cart'] ?? '[]';
$cart      = json_decode($json_cart, true);

$id_tb = $_POST['id_tb'] ?? 'Mang đi';
$id_nv = "NV001";

// tạo mã bill
$id_bill = "B" . date("YmdHis");

// ================================
// 3. BẮT ĐẦU TRANSACTION
// ================================
$conn->begin_transaction();

try {

    // ================================
    // 4. INSERT BILL
    // ================================
    $sql_bill = "
        INSERT INTO bill (ID_bill, Day, Total, ID_TB, ID, bill_status)
        VALUES (?, NOW(), ?, ?, ?, 0)
    ";
    $stmt_bill = $conn->prepare($sql_bill);
    $stmt_bill->bind_param("sdss", $id_bill, $tong_tien, $id_tb, $id_nv);
    $stmt_bill->execute();

    // ================================
    // 5. INSERT DETAILS_ORDER
    // ================================
    $sql_detail = "
        INSERT INTO details_order
        (food_name, id_food, qty, price, ID_bill, name_KH, phonenumber, ID_TB, item_status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)
    ";
    $stmt_detail = $conn->prepare($sql_detail);

    foreach ($cart as $item) {
        $stmt_detail->bind_param(
            "ssisssss",
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


    // 6. TRỪ KHO (THEO UNIT)
    
    foreach ($cart as $item) {

        $id_food    = $item['id'];
        $soLuongMon = (int)$item['quantity'];

        $sqlCT = "
            SELECT 
                ct.ID_MT,
                ct.Quantity_MT,
                ct.Unit,
                nl.quantity AS tonKho,
                nl.Name_MT
            FROM recipe ct
            JOIN warehouse nl ON ct.ID_MT = nl.ID_MT
            WHERE ct.id_food = ?
        ";
        $stmtCT = $conn->prepare($sqlCT);
        $stmtCT->bind_param("s", $id_food);
        $stmtCT->execute();
        $dsCT = $stmtCT->get_result();

        while ($r = $dsCT->fetch_assoc()) {

            $unit = strtolower(trim($r['Unit']));
            $truKho = 0;

            switch ($unit) {

                // ---- CÂN / ĐO ----
                case 'gram':
                    $truKho = ($r['Quantity_MT'] * $soLuongMon) / 1000;
                    break;

                case 'ml':
                    $truKho = ($r['Quantity_MT'] * $soLuongMon) / 1000;
                    break;

                // ---- ĐẾM SỐ ----
                case 'lon':
                case 'ion':   // fix lỗi gõ
                case 'cai':
                case 'trai':
                    $truKho = $r['Quantity_MT'] * $soLuongMon;
                    break;

                default:
                    throw new Exception("Đơn vị không hỗ trợ: " . $unit);
            }

            // kiểm tra tồn kho
            if ($r['tonKho'] < $truKho) {
                throw new Exception("Không đủ nguyên liệu: " . $r['Name_MT']);
            }

            // trừ kho
            $sqlUpdate = "
                UPDATE warehouse
                SET Quantity = Quantity - ?
                WHERE ID_MT = ?
            ";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("ds", $truKho, $r['ID_MT']);
            $stmtUpdate->execute();
        }
    }

    // ================================
    // 7. CẬP NHẬT TRẠNG THÁI BÀN
    // ================================
    if ($id_tb !== 'Mang đi') {
        $sqlTable = "UPDATE tables SET Status = 'Có khách' WHERE ID_TB = ?";
        $stmtTable = $conn->prepare($sqlTable);
        $stmtTable->bind_param("s", $id_tb);
        $stmtTable->execute();
    }

    // ================================
    // 8. COMMIT
    // ================================
    $conn->commit();

} catch (Exception $e) {

    // rollback nếu có lỗi
    $conn->rollback();
    die("❌ Thanh toán thất bại: " . $e->getMessage());
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng - Coffee Shop</title>
    <style>
        :root {
            --primary-color: #2d5a27;
            --bg-color: #f4f7f6;
            --text-main: #333;
            --text-sub: #777;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #fff;
            max-width: 450px;
            width: 90%;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 40px;
            margin: 0 auto 20px;
            box-shadow: 0 8px 20px rgba(45, 90, 39, 0.2);
        }

        h2 { color: var(--text-main); margin-bottom: 5px; }
        p.subtitle { color: var(--text-sub); margin-bottom: 25px; font-size: 15px; }

        .receipt {
            background: #f9f9f9;
            border: 1px dashed #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
            color: var(--text-main);
        }

        .receipt-row.total {
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: 15px;
            font-weight: bold;
            font-size: 18px;
            color: var(--primary-color);
        }

        .label { color: var(--text-sub); }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn {
            padding: 14px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: #1e3f1a;
            transform: translateY(-2px);
        }

        .btn-outline {
            color: var(--text-sub);
            font-size: 14px;
        }

        .btn-outline:hover { color: var(--text-main); }
    </style>
</head>
<body>

<div class="container">
    <div class="success-icon">✓</div>
    <h2>Đặt hàng thành công!</h2>
    <p class="subtitle">Đơn hàng của bạn đã được gửi đến quầy pha chế.</p>

    <div class="receipt">
        <div class="receipt-row">
            <span class="label">Khách hàng:</span>
            <span><?php echo htmlspecialchars($ten_kh); ?></span>
        </div>
        <div class="receipt-row">
            <span class="label">Mã hóa đơn:</span>
            <span>#<?php echo $id_bill; ?></span>
        </div>
        <div class="receipt-row">
            <span class="label">Vị trí:</span>
            <span><?php echo $id_tb; ?></span>
        </div>
        <div class="receipt-row">
            <span class="label">Thời gian:</span>
            <span><?php echo date("H:i - d/m/Y"); ?></span>
        </div>
        <div class="receipt-row total">
            <span>TỔNG TIỀN</span>
            <span><?php echo number_format($tong_tien, 0, ',', '.'); ?>đ</span>
        </div>
    </div>

    <div class="btn-group">
        <a href="index.php" class="btn btn-primary">Tiếp tục mua hàng</a>
        <a href="javascript:window.print()" class="btn btn-outline">In hóa đơn</a>
    </div>
</div>

</body>
</html>