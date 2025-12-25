<?php
    require '../config/config.php';
    session_start();
    
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Quản Lý</title>
    <link rel="stylesheet" href="../page_staff_manager/page_manager.css">
    <link rel="stylesheet" href="../page_staff_manager/them_nv.css">

</head>
<body>

<div class="admin-layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2 class="logo">QUẢN LÝ</h2>
        <p class="login-user">👋 Xin chào, <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'Chưa có thông tin'; ?></strong></p></p>
        <p class="login-user">ID: <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 'Chưa có thông tin'; ?></strong></p></p>
        <ul class="menu">
            <li class="active" onclick="showPage('schedule')">📅 Thêm lịch</li>
            <li onclick="showPage('schedule_Staff')">📅 Quản Lý Lịch Làm Việc</li>
            <li onclick="showPage('check_shchedule')">📅 Xác Nhận Ca</li>
            <li onclick="showPage('salary')">💰 Thanh toán lương</li>
            <li onclick="showPage('inventory')">📦 Kiểm kho</li>
            <li onclick="showPage('import')">📥 Thêm kho</li>
            <li onclick="showPage('StockReceipt')">🧾 Hóa đơn nhập kho</li>
            <li onclick="showPage('add_staff')">➕ Thêm Nhân Viên</li>
            <li onclick="showPage('employee')">👤 Tra cứu nhân viên</li>
            <li onclick="showPage('revenue')">💰 kiểm tra doanh thu</li> 
        </ul>
        <div class="sidebar-footer">
        <a href="../page_staff_manager/change_password_manager.php">
            <button class="change-password-btn">🔑 Đổi mật khẩu</button>
        </a>
        <a href="../config/logout.php">
            <button class="logout-btn">🚪 Đăng xuất</button>
        </a>
    </div>
    </aside>

    <!-- CONTENT -->
    <main class="content">

        <section id="schedule" class="page active">
            <h1>Thêm lịch làm việc</h1>
            <div class="box">
                <div class="container">
                    <h2>Thêm Lịch Cho Nhân Viên</h2>
                    <form action="../config/them_lich.php" method="POST">
                        <div class="form-group">
                        <select name="ID" id="ID_NV" required>
                            <option value="">Chọn ID Nhân Viên</option>
                            <?php
                            $sql= "SELECT ID FROM `user`";
                            $result = mysqli_query($conn,$sql);
                            while ($row = mysqli_fetch_assoc($result)){
                                echo '<option value="'.$row['ID'].'">'.$row['ID'].'</option>';
                            }
                            ?>
                        </select>
                        <div class="form-group">
                        <input type="text" id="name_NV" name="name_NV" readonly placeholder="Tên nhân viên">
                        </div>
                        <div class="form-group">
                        <label>Chọn Ngày Làm Việc</label>
                        <input type="date" name="date" placeholder="Nhập Ngày Làm Việc" required>
                        </div>
                        <div class="form-group">
                        <label>Chọn Ca Làm Việc</label>
                        <select name="shift" required>
                            <option value="">Chọn Ca Làm Việc</option>
                            <option value="Ca Sáng">Ca Sáng - 6h -> 10h</option>
                            <option value="Ca Trưa">Ca Trưa - 10h -> 14h</option>
                            <option value="Ca Chiều">ca chiều - 14h ->18h</option>
                            <option value="Ca Tối">Ca tối 18h ->22h</option>
                        </select>
                        </div>
                         <button type="submit">Xác Nhận</button>

                    </form>
                </div>

            </div>
        </section>
        <section id="schedule_Staff" class="page">
            <div class="box">
                <h1>Xem Lịch Nhân Viên</h1>
                <table border="1" width="100%" style="border-collapse: collapse; text-align: center;">
                    <tr style="background-color: #f2f2f2;">
                        <th>Mã Ca Làm</th>
                        <th>ID Nhân Viên</th> 
                        <th>Tên Nhân Viên</th>
                        <th>Ngày Làm Việc</th>
                        <th>Ca Làm Việc</th>
                        <th>Trạng Thái Ca Làm</th>
                    </tr>
                    <?php
                    
                    $sql = "SELECT * FROM SHIFT WHERE ID LIKE 'NV%'";

                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['ID_shift']}</td>
                                <td>{$row['ID']}</td>
                                <td>{$row['Name']}</td>
                                <td>{$row['Working_date']}</td>
                                <td>{$row['shift']}</td>
                                <td>{$row['Shift_status']}</td>
                            </tr>";
                    }
                    ?>
                </table>

            </div>
        </section>
        <section id="check_shchedule" class="page">
            <div class="box">
                <h1>Xác Nhận Ca</h1>
                <table border="1" width="100%" style="border-collapse: collapse; text-align: center;">
                    <tr style="background-color: #f2f2f2;">
                        <th>Mã Ca Làm</th>
                        <th>ID Nhân Viên</th> 
                        <th>Tên Nhân Viên</th>
                        <th>Ngày Làm</th>
                        <th>Ca Làm</th>
                        <th>Trạng Thái Ca</th>
                        <th>Xác Nhận Vào Ca</th>
                    </tr>
                    <?php
                    
                    $sql = "SELECT sr.ID_shift , s.ID, s.Name, s.Working_date, s.shift, s.Shift_status, sr.request_time
                    FROM SHIFT_REQUEST sr , SHIFT s
                    WHERE s.Shift_status!='Đã Vào Làm' AND s.ID = sr.ID AND sr.ID_shift = s.ID_shift AND s.ID LIKE 'NV%'" ;

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
                                    <form action='../config/xac_nhan_DD.php' method='POST'>
                                        <input type='hidden' name='ID_shift' value='{$row['ID_shift']}'>
                                        <input type='hidden' name='ID' value='{$row['ID']}'>
                                        <button type='submit'>Xác Nhận Đã Vào Làm</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                    ?>
                </table>

            </div>
        </section>
        <section id="add_staff" class="page">
            <div class="box">
                <div class="container">
                    <h2>Cấp Tài Khoản Nhân Viên</h2>
                    <form action="../config/them_nv.php" method="POST">
                        <div class="form-group">
                        <input type="text" name="name" placeholder="Nhập tên" required>
                        </div>
                        <div class="form-group">
                        <input type="email" name="email" placeholder="Nhập email" required>
                        </div>
                        <div class="form-group">
                        <input type="text" name="Phone_number" placeholder="Nhập số điện thoại" required>
                        </div>
                        <div class="form-group">
                        <select name="sex" required>
                            <option value="">Chọn giới tính</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                        <div class="form-group">
                        <input type="date" name="date" placeholder="Nhập ngày tháng năm sinh" required>
                        </div>
                        </div>
                        <div class="form-group">
                        <select name="position" required>
                            <option value="">Chọn loại nhân viên</option>
                            <option value="1">Nhân Viên Pha Chế</option>
                            <option value="2">Nhân Viên Thu Ngân</option>
                            <option value="3">Nhân Viên Bảo Vệ</option>
                            <option value="4">Nhân Viên Phục Vụ</option>

                        </select>
                        </div>
                        <div class="form-group">
                        <input type="text" name="address" placeholder="Nhập địa chỉ" required>
                        </div>
                        <div class="form-group">
                        <input type="text" name="password" placeholder="Nhập mật khẩu" required>
                        </div>

                        <div class="form-group">
                        <input type="password" class="password" id="password2" name="password2" placeholder="Nhập lại mật khẩu" required>
                        </div>
                        <button type="submit">Đăng ký</button>
                    </form>
                    </div>
                
        
            </div>
        </section>

        <section id="salary" class="page">
            <h1>Thanh toán lương</h1>
            <div class="box">
                <table border="1" width="100%" style="border-collapse: collapse; text-align: center;">
                <tr style="background-color: #f2f2f2;">
                    <th>ID Nhân Viên</th> 
                    <th>Tên Nhân Viên</th>
                    <th>Tổng Số Ca Làm</th>
                    <th>Lương/ca</th>
                    <th>Tổng Lương</th>
                    <th>Tháng</th>
                    <th>Năm</th>
                    <th>Trạng Thái Lương</th>
                    <th>Ngày Trả Lương</th>
                    <th>Xác Nhận Trả Lương</th>
                </tr>

                <?php
                $sql = "
                INSERT INTO salary (ID, Salary_month, `Year`, Salary, Total_shift, Total_salary)
                SELECT
                    ID,
                    MONTH(Working_date),
                    YEAR(Working_date),
                    100000,
                    COUNT(*),
                    COUNT(*) * 100000
                FROM shift
                WHERE Shift_status = 'Đã Vào Làm'
                GROUP BY ID, MONTH(Working_date), YEAR(Working_date)
                ON DUPLICATE KEY UPDATE
                    Total_shift = VALUES(Total_shift),
                    Total_salary = VALUES(Total_salary)
                ";
                $conn->query($sql);
                $sql2 = "
                SELECT
                    sa.ID,
                    MIN(s.Name) AS Name,
                    sa.Salary,
                    sa.Total_shift,
                    sa.Total_salary,
                    sa.Salary_month,
                    sa.Year,
                    sa.Salary_status,
                    sa.Payment_date
                FROM salary sa
                JOIN shift s ON sa.ID = s.ID
                GROUP BY
                    sa.ID,
                    sa.Salary_month,
                    sa.Year,
                    sa.Total_shift,
                    sa.Salary_status,
                    sa.Payment_date
                ";
                $result = $conn->query($sql2);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['ID']}</td>
                            <td>{$row['Name']}</td>
                            <td>{$row['Total_shift']}</td>
                            <td>{$row['Salary']}</td>
                            <td>{$row['Total_salary']}</td>
                            <td>{$row['Salary_month']}</td>
                            <td>{$row['Year']}</td>
                            <td>{$row['Salary_status']}</td>
                            <td>{$row['Payment_date']}</td>
                            <td>
                                <form action='../config/tra_luong.php' method='POST'>
                                    <input type='hidden' name='ID' value='{$row['ID']}'>
                                    <input type='hidden' name='month' value='{$row['Salary_month']}'>
                                    <input type='hidden' name='year' value='{$row['Year']}'>
                                    <button type='submit'>Xác Nhận Đã Trả Lương</button>
                                </form>
                            </td>
                        </tr>";
                }
                ?>
                </table>

            </div>
        </section>

        <section id="inventory" class="page">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1>📦 Quản lý kho nguyên liệu</h1>
        
                <div style="position: relative;">
                    <span style="position: absolute; left: 10px; top: 10px;">🔍</span>
                    <input type="text" id="inventorySearch" 
                        placeholder="Tìm tên nguyên liệu..." 
                        style="padding: 10px 10px 10px 35px; width: 300px; border-radius: 20px; border: 1px solid #ddd; outline: none; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                </div>
            </div>

            <div class="box">
                <table id="inventoryTable" border="1" style="width:100%; border-collapse: collapse; text-align: center;">
                    <thead>
                        <tr style="background: #333; color: white;">
                            <th style="padding: 12px;">Mã NL</th>
                            <th>Tên Nguyên Liệu</th>
                            <th>Số Lượng Tồn</th>
                            <th>Đơn Vị</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_inv = "SELECT * FROM warehouse";
                        $res_inv = mysqli_query($conn, $sql_inv);
                        while($row = mysqli_fetch_assoc($res_inv)) {
                            // Thêm một chút màu sắc cảnh báo nếu hết hàng
                            $status_text = ($row['Quantity'] <= 5) ? "<span style='color:red; font-weight:bold;'>Sắp hết!</span>" : "<span style='color:green;'>Ổn định</span>";
                    
                            echo "<tr>
                                    <td style='padding: 10px;'>{$row['ID_MT']}</td>
                                    <td style='font-weight: bold;'>{$row['Name_MT']}</td>
                                    <td>{$row['Quantity']}</td>
                                    <td>{$row['Unit']}</td>
                                    <td>$status_text</td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
        
                <p id="noResult" style="display: none; text-align: center; padding: 20px; color: #888;">
                    ❌ Không tìm thấy nguyên liệu nào khớp với từ khóa.
                </p>
            </div>
        </section>

        <section id="import" class="page">
            <h1>Nhập kho nguyên liệu</h1>
            <div class="box">
                <div class="container">
                    <form action="../config/them_kho.php" method="POST">
                        <div class="form-group">
                            <label>Chọn Nguyên Liệu (Mã - Tên)</label>
                            <select name="ID_MT" id="select_MT" onchange="updateNLDetails()" required>
                                <option value="">-- Chọn nguyên liệu hoặc thêm mới --</option>
                                <option value="NEW"> + Thêm nguyên liệu mới </option>
                                <?php
                                // Lấy dữ liệu từ bảng warehouse
                                $sql_list = "SELECT * FROM warehouse";
                                $res_list = mysqli_query($conn, $sql_list);
                                while($item = mysqli_fetch_assoc($res_list)) {
                                    // QUAN TRỌNG: Phải có data-name và data-unit
                                    echo "<option value='{$item['ID_MT']}' 
                                                data-name='{$item['Name_MT']}' 
                                                data-unit='{$item['Unit']}'>
                                            {$item['ID_MT']} - {$item['Name_MT']}
                                        </option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div id="new_id_group" class="form-group" style="display:none;">
                            <input type="text" name="new_ID_MT" id="new_ID_MT" placeholder="Nhập Mã NL mới (VD: NL05)">
                        </div>

                        <div class="form-group">
                            <input type="text" name="Name_MT" id="Name_MT" placeholder="Tên nguyên liệu" readonly required>
                        </div>
                
                        <div class="form-group">
                            <input type="text" name="Unit" id="Unit" placeholder="Đơn vị tính" readonly required>
                        </div>

                        <div class="form-group">
                            <input type="number" name="Quantity" placeholder="Số lượng nhập" required min="1">
                        </div>

                        <div class="form-group">
                            <input type="number" name="Price" placeholder="Giá nhập (VNĐ)" required min="0">
                        </div>

                        <div class="form-group">
                            <label>Ngày nhập</label>
                            <input type="date" name="Import_date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                
                        <button type="submit" name="btnNhapKho">Xác Nhận Nhập</button>
                    </form>
                </div>
            </div>
        </section>

        <section id="StockReceipt" class="page">
            <h1>Hóa đơn nhập kho</h1>
            <div class="box">
                <div style="margin-bottom: 20px;">
                    <label>Tên nguyên liệu: </label>
                    <input type="text" id="receiptSearchName" placeholder="Gõ tên để lọc nhanh..." 
                        style="padding: 5px; border-radius: 4px; border: 1px solid #ccc;">

                    <label style="margin-left: 10px;">Ngày nhập: </label>
                    <input type="date" id="receiptSearchDate"
                        style="padding: 5px; border-radius: 4px; border: 1px solid #ccc;">
            
                    <button type="button" onclick="resetReceiptFilter()" style="padding: 6px 15px; border-radius: 4px;">Làm mới</button>
                </div>

                <table id="stockReceiptTable" border="1" style="width:100%; border-collapse: collapse; text-align: center;">
                    <thead>
                        <tr style="background: #f4f4f4;">
                            <th>Mã NL</th>
                            <th>Tên Nguyên Liệu</th>
                            <th>Ngày Nhập</th>
                            <th>Số Lượng</th>
                            <th>Đơn Vị</th>
                            <th>Giá Nhập (VNĐ)</th>
                            <th>Tổng Tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Code PHP hiển thị dữ liệu giữ nguyên như cũ, 
                        // nhưng bỏ phần WHERE trong PHP đi để JS tự xử lý cho nhanh
                        $sql_receipt = "SELECT * FROM stock_receipt ORDER BY Import_date DESC";
                        $res_receipt = mysqli_query($conn, $sql_receipt);
                        while($row = mysqli_fetch_assoc($res_receipt)) {
                            $total = $row['Quantity'] * $row['Price'];
                            // Thêm class 'receipt-row' để JS dễ nhận diện
                            echo "<tr class='receipt-row'>
                                    <td>{$row['ID_MT']}</td>
                                    <td class='name-col'>{$row['Name_MT']}</td>
                                    <td class='date-col'>{$row['Import_date']}</td>
                                    <td>{$row['Quantity']}</td>
                                    <td>{$row['Unit']}</td>
                                    <td>" . number_format($row['Price'], 0, ',', '.') . "</td>
                                    <td>" . number_format($total, 0, ',', '.') . "</td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="employee" class="page">
            <h1>Tra cứu nhân viên</h1>
            <div class="box">Nội dung tra cứu nhân viên</div>
        </section>

        <section id="revenue" class="page">
            <h1>Báo Cáo & Kiểm Tra Doanh Thu</h1>
            <div class="box">
        
                <?php
                    $sql_wallet = "SELECT fund FROM wallet LIMIT 1";
                    $res_wallet = $conn->query($sql_wallet);
                    $current_fund = ($res_wallet->num_rows > 0) ? $res_wallet->fetch_assoc()['fund'] : 0;
                ?>
                <div class="wallet-card">
                    <div class="wallet-content">
                        <div>
                            <h3>💰 Số dư ví hiện tại</h3>
                            <h1><?php echo number_format($current_fund); ?> VNĐ</h1>
                        </div>
                        <form action="../config/xu_ly_vi.php" method="POST" class="wallet-form">
                        <input type="number" name="amount" placeholder="Số tiền..." required>
                        <button type="submit" name="action" value="add" class="btn btn-add">+ Nạp</button>
                        <button type="submit" name="action" value="sub" class="btn btn-sub">- Rút</button>
                        </form>
                    </div>
                </div>

                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

                <div class="report-box">
                    <h3>🚀 Chốt báo cáo tháng mới</h3>
                    <form action="../config/xu_ly_doanh_thu.php" method="POST" style="display: flex; gap: 15px; align-items: center;">
                        <div>
                            <label>Chọn tháng cần chốt:</label>
                            <input type="month" name="month_year" required>
                        </div>
                        <button type="submit" name="btnChot" class="calculate-button">
                            TÍNH TOÁN & CHỐT DOANH THU
                        </button>
                    </form>
                    <p class="note">* Hệ thống sẽ tự động tổng hợp: Bill, Lương, và Tiền nhập kho của tháng đã chọn.</p>
                </div>

                <div class="table-header">
            <h3>📊 Lịch sử báo cáo các tháng</h3>
    
            <div class="search-box">
                <label>🔍 Lọc nhanh:</label>
                <input type="text" id="revenueSearch" placeholder="Nhập tháng hoặc năm (VD: 12/2025)..." >
            </div>
        </div>

        <table id="revenueTable" border="1" style="width:100%; border-collapse: collapse; text-align: center; background: white;">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="padding: 12px;">Tháng</th>
                    <th>Doanh thu bán hàng (+)</th>
                    <th>Tiền lương (-)</th>
                    <th>Tiền nhập kho (-)</th>
                    <th>Lợi nhuận</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_history = "SELECT * FROM revenue ORDER BY Report_month DESC";
                $res_history = $conn->query($sql_history);
                while ($row = $res_history->fetch_assoc()) {
                    $m = date('m/Y', strtotime($row['Report_month']));
                    $profit = $row['Monthly_profit'];
                    $color = ($profit >= 0) ? "green" : "red";
                    echo "<tr>
                            <td style='padding: 12px; font-weight: bold;'>$m</td>
                            <td style='color: blue;'>" . number_format($row['Total_monthly_revenue']) . "đ</td>
                            <td style='color: #d9534f;'>" . number_format($row['Total_shift_cost']) . "đ</td>
                            <td style='color: #d9534f;'>" . number_format($row['Total_monthly_cost']) . "đ</td>
                            <td style='font-weight: bold; color: $color;'>" . number_format($profit) . "đ</td>
                            <td>
                                <form action='../config/xu_ly_doanh_thu.php' method='POST'>
                                    <input type='hidden' name='month_year' value='".date('Y-m', strtotime($row['Report_month']))."'>
                                    <button type='submit' style='background: none; border: 1px solid #007bff; color: #007bff; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 0.8em;'>Cập nhật lại</button>
                                </form>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
            </div>
        </section>

    </main>

</div>
<script src="../page_staff_manager/lay_ten_nv.js"></script>
<script src="../page_staff_manager/page_manager.js"></script>
<script src="../page_staff_manager/mau_nhap_kho.js"></script>
<script src="../page_staff_manager/tim_kiem_thang_nam.js"></script>
</body>
</html>