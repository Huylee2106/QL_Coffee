<?php
$cartJson = $_POST['cart'] ?? '[]';
$cart = json_decode($cartJson, true); // chuyển từ JSON string sang array

$total = $_POST['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thanh toán</title>
  <link rel="stylesheet" href="ThanhToan.css" />
</head>
<body>
  <div class="container">
    <h2>Thanh Toán</h2>

    <form method="POST" action="xu_ly_thanh_toan.php">
      <h3>Thông tin khách hàng</h3>
      <label>Họ và tên</label>
      <input name="ten" type="text" required />

      <label>Số điện thoại</label>
      <input name="sdt" type="text" required />

      <h3>Vị trí ngồi</h3>
      <label for="id_tb">Chọn bàn hoặc Mang đi:</label>
      <select name="id_tb" id="id_tb" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
        <option value="Mang đi">Mang đi (Take away)</option>
        <?php
        require '../config/config.php';
        // Lấy danh sách các bàn đang trống
        $sql_tables = "SELECT ID_TB FROM tables WHERE Status = 'Trống'";
        $res_tables = $conn->query($sql_tables);
        if ($res_tables->num_rows > 0) {
            while($table = $res_tables->fetch_assoc()) {
                echo "<option value='{$table['ID_TB']}'>Bàn {$table['ID_TB']}</option>";
            }
        }
        ?>
      </select>

      <h3>Đơn hàng của bạn</h3>
      <div class="summary-box">
        <?php if(!empty($cart)){ foreach($cart as $item){ ?>
          <p><?php echo $item['ten']; ?> x <?php echo $item['quantity']; ?> — <strong><?php echo number_format($item['gia'] * $item['quantity']); ?>đ</strong></p>
        <?php }} ?>
        <hr>
        <p>Tổng cộng: <strong><?php echo number_format($total); ?>đ</strong></p>
      </div>

      <input type="hidden" name="json_cart" value='<?php echo json_encode($cart); ?>'>
      <input type="hidden" name="tong_tien" value='<?php echo $total; ?>'>

      <button class="btn">Gửi yêu cầu thanh toán</button>
    </form>
  </div>
</body>
</html>
