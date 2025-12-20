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
        <ul class="menu">
            <li class="active" onclick="showPage('view-schedule', this)">
                📅 Xem lịch
            </li>
            <li onclick="showPage('confirm-payment', this)">
                => Xác nhận thanh toán
            </li>
            <li onclick="showPage('view-orders', this)">
                ☕ Yêu cầu pha chế
            </li>
            <li onclick="showPage('view-inventory', this)">
                📦 Xem kho
            </li>
            <li onclick="showPage('view-dish', this)">
                ➕ Thêm món
            </li>
            <li onclick="showPage('view-recipe', this)">
                ➕ Thêm công thức
            </li>
            <li onclick="showPage('manage-tables', this)">
                🪑 Quản lý bàn
            </li>
            <li onclick="showPage('view-recipe', this)">
                <a href="../config/logout.php"><button class="logout-btn">Đăng xuất</button></a>
            </li>
            <li>
                <a href="../page_staff_manager/change_password.php">
                <button class="logout-btn" style="background: #ff00aeff; margin-top: 10px;">Đổi mật khẩu</button>
            </a>
</li>
        </ul>
    </aside>

    <!-- CONTENT -->
    <main class="content">

        <!-- XEM LỊCH -->
        <section id="view-schedule" class="page active">
            <h1>Xem lịch làm việc</h1>
            <div class="box">Nội dung lịch làm việc</div>
        </section>

        <section id="confirm-payment" class="page">
            <h1>Xác nhận thanh toán</h1>
            <table border="1" width="100%">
                <tr>
                    <th>Mã Đơn</th>
                    <th>Tổng tiền</th>
                    <th>Hành động</th>
                </tr>
                <?php
                $sql_confirm = "SELECT * FROM bill WHERE bill_status = 0";
                $res_confirm = $conn->query($sql_confirm);
                while($row = $res_confirm->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['ID_bill']}</td>
                            <td>".number_format($row['Total'])." VNĐ</td>
                            <td><a href='xu_ly_vien.php?action=confirm&id={$row['ID_bill']}'>Xác nhận đã thu tiền</a></td>
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
                    $sql = "SELECT b.ID_bill, b.ID_TB, d.name_KH,d.phone_number, 
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
                                <td>{$row['phone_number']}</td>
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
            <div class="box">Tình trạng kho</div>
        </section>

        <!-- THÊM MÓN -->
        <section id="view-dish" class="page">
            <h1>Thêm món</h1>
            <div class="box">Thêm món mới</div>
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
