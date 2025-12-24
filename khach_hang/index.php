<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tong_tien'])) {
    // 👉 Xử lý lưu đơn hàng, database ở đây nếu có

    // Gán thông báo thành công
    $_SESSION['success'] = "Đã gửi yêu cầu thành công! Cảm ơn bạn đã đặt hàng ❤️";

    // Chuyển hướng tránh submit lại form
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Caffe Đắng</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
  <link rel="icon" href="../khach_hang/images/icon_web.webp" type="image/x-icon" />
  
</head>
<body>
  <div class="topbar">
    <h1>Caffe Đắng</h1>
    <div class="search-box">
      <input type="text" id="search-input" placeholder="Tìm kiếm món...">
      <i class="fa fa-search"></i>
    </div>
  </div>
    
  <div class="typewater">
    <button class="active" data-filter="Tất cả">Tất cả</button>
    <button data-filter="Coffee">Coffee</button>
    <button data-filter="Sinh tố">Sinh tố</button>
    <button data-filter="Trà">Trà</button>
    <button data-filter="Trà sữa">Trà sữa</button>
    <button data-filter="Nước ép">Nước ép</button>
    <button data-filter="Nước ngọt">Nước ngọt</button>
    <button data-filter="Khác">Khác</button> </div>
    
  <div class="main-content">

    <div class="water">
      <?php
        $conn = new mysqli("localhost", "root", "", "ql_caffe");
        if ($conn->connect_error) {
          die("Kết nối thất bại: " . $conn->connect_error);
        }

        $sql = "SELECT id_food, image, food_name, price, `type` FROM menu";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<div class='item' data-loai='" . $row['type'] . "'>";
            echo "<img src='images/" . $row['image'] . "' alt='" . $row['food_name'] . "'>";
            echo "<h3>" . $row['food_name'] . "</h3>";
            echo "<p id='gia'>Giá: " . number_format($row['price']) . " VND</p>";
            
            // *** THAY ĐỔI 2: Thêm class và data attributes cho nút
            echo "<button class='add-to-cart' 
                      data-id='" . $row['id_food'] . "' 
                      data-ten='" . htmlspecialchars($row['food_name'], ENT_QUOTES) . "' 
                      data-gia='" . $row['price'] . "' 
                      data-img='images/" . $row['image'] . "'>+</button>";
                      
            echo "</div>";
          }
        } else {
          echo "Không có sản phẩm.";
        }

        $conn->close();
      ?>
    </div>

    <div class="cart-container">
      <h2>Giỏ hàng</h2>
      <div id="cart-items">
        <p class="empty-cart">Giỏ hàng của bạn đang trống.</p>
      </div>
      <div class="cart-total">
        <strong>Tổng cộng:</strong>
        <span id="cart-total-price">0 VND</span>
      </div>

      <form id="checkout-form" method="POST" action="ThanhToan.php">
        <input type="hidden" name="cart" id="cart-input">
        <input type="hidden" name="total" id="total-input">
      </form>

      <button class="buy-btn" id="checkout-btn">Thanh toán</button>
    </div>

  </div> <div class="info">
    <div class="footer-container">
      <div class="footer-column">
        <h3>Caffe Đắng</h3>
        <p>Thưởng thức trọn vẹn vị đắng của cuộc sống, một cách ngọt ngào.</p>
      </div>

      <div class="footer-column">
        <h3>Hệ thống cửa hàng</h3>
        <p>Cơ sở 1: 50 Tân Lộc, Phường 4, Huyện Bình Chánh</p>
        <p>Cơ sở 2: 23 Trần Hưng Đạo, Quận 5, TP Hồ Chí Minh</p>
      </div>

      <div class="footer-column">
        <h3>Liên hệ</h3>
        <p>Hotline: 0902320962</p>
        <p>Email: lienhe@caffedang.vn</p>
      </div>
    </div>
  </div>

  <script src="GioHang_And_LocNuoc.js"></script>

    
</body>
<?php
if (isset($_SESSION['success'])) {
    echo "<script>alert('{$_SESSION['success']}');</script>";
    unset($_SESSION['success']); // Xóa sau khi hiện
}
?>

</html>