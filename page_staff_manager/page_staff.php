<?php
    session_start();
    require '../config/config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhân viên</title>
    <link rel="stylesheet" href="../page_staff_manager/page_staff.css">
</head>
<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
    <h2 class="logo">NHÂN VIÊN</h2>
    <p class="login-user">👋 Xin chào, <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Chưa có thông tin'; ?></strong></p></p>
    <p class="login-user">ID: <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 'Chưa có thông tin'; ?></strong></p></p>
    <ul class="menu">
        <li class="active" onclick="showPage('view-schedule', this)">📅 Xem lịch</li>
        <li onclick="showPage('confirm-payment', this)">✅ Xác nhận thanh toán</li>
        <li onclick="showPage('view-orders', this)">☕ Yêu cầu pha chế</li>
        <li onclick="showPage('view-inventory', this)">📦 Xem kho</li>
        <li onclick="showPage('view-dish', this)">➕ Thêm món</li>
        <li onclick="showPage('view-recipe', this)">➕ Thêm công thức</li>
        <li onclick="showPage('manage-tables', this)">🪑 Quản lý bàn</li>
    </ul>

    <!-- FOOTER -->
    <div class="sidebar-footer">
        <a href="../page_staff_manager/change_password.php">
            <button class="change-password-btn">🔑 Đổi mật khẩu</button>
        </a>

        <a href="../config/logout.php">
            <button class="logout-btn">🚪 Đăng xuất</button>
        </a>
    </div>
</aside>

    <!-- CONTENT -->
    <main class="content">

        <!-- XEM LỊCH -->
        <section id="view-schedule" class="page active">
            <h1>Xem lịch làm việc</h1>
            <div class="box">
                <table border="1" width="100%" style="border-collapse: collapse; text-align: center;">
                    <tr style="background-color: #f2f2f2;">
                        <th>Mã Ca Làm</th>
                        <th>ID Nhân Viên</th> 
                        <th>Tên Nhân Viên</th>
                        <th>Ngày Làm Việc</th>
                        <th>Ca Làm Việc</th>
                        <th>Trạng Thái</th>
                        <th>Điểm Danh</th>
                    </tr>
                    <?php
                    $ID_NV = $_SESSION['id'];
                    $sql = "SELECT * FROM SHIFT WHERE ID ='$ID_NV'";

                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['ID_shift']}</td>
                                <td>{$row['ID']}</td>
                                <td>{$row['Name']}</td>
                                <td>{$row['Working_date']}</td>
                                <td>{$row['shift']}</td>
                                <td>{$row['Shift_status']}</td>
                                <td>
                                    <form action='../config/gui_diemdanh.php' method='POST'>
                                        <input type='hidden' name='ID_shift' value='{$row['ID_shift']}'>
                                        <button type='submit'>Vào ca</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                    ?>
                </table>

            </div>
        </section>

        <section id="confirm-payment" class="page">
            <h1>Xác nhận thanh toán</h1>
            <table border="1" width="100%">
                <tr>
                    <th>Mã Đơn</th>
                    <th>Tổng tiền</th>
                    <th>Tiếp nhận yêu cầu</th>
                    <th>Hủy yêu cầu</th>
                </tr>
                <?php
                $sql_confirm = "SELECT * FROM bill WHERE bill_status = 0";
                $res_confirm = $conn->query($sql_confirm);
                while($row = $res_confirm->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['ID_bill']}</td>
                            <td>".number_format($row['Total'])." VNĐ</td>
                            <td><a href='xu_ly_vien.php?action=confirm&id={$row['ID_bill']}'>Xác nhận đã thu tiền</a></td>
                            <td><a href='xu_ly_vien.php?action=delete&id={$row['ID_bill']}'>Từ chối</a></td>
                        </tr>";
                }
                ?>
            </table>
        </section>

        <!-- YÊU CẦU PHA CHẾ -->
        <section id="view-orders" class="page">
            <h1>Yêu cầu pha chế</h1>
            <div class="box">
                <table border="1" width="100%" style="border-collapse: collapse; text-align: center;">
                    <tr style="background-color: #f2f2f2;">
                        <th>Mã Đơn</th>
                        <th>Vị trí</th> <th>Tên Khách</th> <th>Số điện thoại</th>
                        <th>Danh sách món</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php
                    // Cập nhật SQL để lấy thêm ID_TB (Vị trí bàn)
                    $sql = "SELECT b.ID_bill, b.ID_TB, d.name_KH,d.phonenumber, 
                                GROUP_CONCAT(CONCAT(d.food_name, ' (', d.qty, ')') SEPARATOR '<br>') as list_mon 
                            FROM bill b
                            JOIN details_order d ON b.ID_bill = d.ID_bill
                            WHERE b.bill_status = 1 AND d.item_status = 0
                            GROUP BY b.ID_bill 
                            ORDER BY b.Day ASC";

                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                        $vi_tri = ($row['ID_TB'] == 'Mang đi') ? "<span style='color:red;'>Mang đi</span>" : "Bàn " . $row['ID_TB'];
                        echo "<tr>
                                <td>{$row['ID_bill']}</td>
                                <td><strong>$vi_tri</strong></td>
                                <td>{$row['name_KH']}</td>
                                <td>{$row['phonenumber']}</td>
                                <td style='text-align: left; padding: 10px;'>{$row['list_mon']}</td>
                                <td><a href='xu_ly_vien.php?action=done&id={$row['ID_bill']}'>Hoàn thành</a></td>
                            </tr>";
                    }
                    ?>
                </table>
            </div>
        </section>

        <!-- XEM KHO -->
        <section id="view-inventory" class="page">
            <h1>Xem kho</h1>
            <div class="box">
                <table border="1" style="width:100%; border-collapse: collapse; text-align: center;">
                    <thead>
                        <tr style="background: #070101ff;">
                            <th>Mã NL</th>
                            <th>Tên Nguyên Liệu</th>
                            <th>Số Lượng Tồn</th>
                            <th>Đơn Vị</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_inv = "SELECT * FROM warehouse";
                        $res_inv = mysqli_query($conn, $sql_inv);
                        while($row = mysqli_fetch_assoc($res_inv)) {
                            echo "<tr>
                                    <td>{$row['ID_MT']}</td>
                                    <td>{$row['Name_MT']}</td>
                                    <td>{$row['Quantity']}</td>
                                    <td>{$row['Unit']}</td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- THÊM MÓN -->
        <section id="view-dish" class="page">
            <h1>Thêm món</h1>
            <div class="box">
                <h3>Thêm món mới</h3>
                    <form action="../config/them_mon.php" method="POST" enctype="multipart/form-data" class="add-food-form">
                        <div class="input-group">
                            <label>Mã món:</label>
                            <input type="text" name="id_food" required placeholder="Ví dụ: CF01">
                        </div>
                        
                        <div class="input-group">
                            <label>Tên món:</label>
                            <input type="text" name="food_name" required placeholder="Ví dụ: Cafe Muối">
                        </div>

                        <div class="input-group">
                            <label>Giá bán:</label>
                            <input type="number" step="0.01" name="price" required placeholder="Ví dụ: 25000">
                        </div>

                        <div class="input-group">
                            <label>Loại (Type):</label>
                            <select name="type">
                                <option value="Coffee">Coffee</option>
                                <option value="Trà">Trà</option>
                                <option value="Trà sữa">Trà sữa</option>
                                <option value="Nước ngọt">Nước ngọt</option>
                                <option value="Sinh tố">Sinh tố</option>
                                <option value="Nước ép">Nước ép</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label>Hình ảnh:</label>
                            <input type="file" name="image" accept="image/*" required>
                        </div>

                        <button type="submit" name="btn_save" class="btn-add">Lưu món</button>
                    </form>


                    <style>
                        .add-food-form { display: grid; gap: 15px; max-width: 500px; margin: auto; }
                        .input-group { display: flex; flex-direction: column; text-align: left; }
                        .input-group label { font-weight: bold; margin-bottom: 5px; color: #555; }
                        .input-group input, .input-group select { 
                            padding: 10px; border: 1px solid #ccc; border-radius: 8px; font-size: 14px;
                        }
                        .btn-add { 
                            background: #2d5a27; color: white; border: none; padding: 12px; 
                            border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 16px;
                        }
                        .btn-add:hover { background: #1e3f1a; }
                    </style>
                    
            </div>
        </section>

        <!-- THÊM CÔNG THỨC -->
        <section id="view-recipe" class="page">
            <h1>Thêm món</h1>
            <div class="box">Thêm công thức cho món</div>
            
        </section>
        
        <section id="manage-tables" class="page">
        <h1>Quản lý trạng thái bàn (Dọn dẹp)</h1>
            <div class="box">
                <table border="1" width="100%" style="border-collapse: collapse; text-align: center;">
                    <tr style="background-color: #f2f2f2;">
                        <th>Số Bàn</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php
                    // Lấy danh sách bàn đang có khách (trừ bàn ảo 'Mang đi')
                    $sql_tables = "SELECT * FROM tables WHERE Status = 'Có khách' AND ID_TB != 'Mang đi'";
                    $res_tables = $conn->query($sql_tables);
            
                    if ($res_tables->num_rows > 0) {
                        while($table = $res_tables->fetch_assoc()) {
                            echo "<tr>
                                    <td><strong>{$table['ID_TB']}</strong></td>
                                    <td><span style='color: orange;'>Chờ dọn dẹp</span></td>
                                    <td>
                                        <a href='xu_ly_vien.php?action=release_table&id_tb={$table['ID_TB']}' 
                                        style='background: #007bff; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px;'>
                                        Xác nhận bàn trống
                                        </a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Tất cả các bàn đều sạch sẽ/đang trống.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </section>

    </main>

</div>

<script src="../page_staff_manager/page_staff.js"></script>
</body>
</html>