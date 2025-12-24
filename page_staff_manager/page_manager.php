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
            <div class="box">Nội dung thanh toán lương</div>
        </section>

        <section id="inventory" class="page">
            <h1>Kiểm kho</h1>
            <div class="box">
                <table border="1" style="width:100%; border-collapse: collapse; text-align: center;">
                    <thead>
                        <tr style="background: #f4f4f4;">
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
                    <form method="GET" action="">
                        <input type="hidden" name="page" value="StockReceipt"> 
        
                        <label>Tên nguyên liệu: </label>
                        <input type="text" name="search_name" placeholder="Nhập tên cần tìm..." 
                            value="<?php echo isset($_GET['search_name']) ? htmlspecialchars($_GET['search_name']) : ''; ?>" 
                            style="padding: 5px; border-radius: 4px; border: 1px solid #ccc;">

                        <label style="margin-left: 10px;">Ngày nhập: </label>
                        <input type="date" name="filter_date" 
                            value="<?php echo isset($_GET['filter_date']) ? $_GET['filter_date'] : ''; ?>"
                            style="padding: 5px; border-radius: 4px; border: 1px solid #ccc;">

                        <button type="submit" style="padding: 6px 15px; cursor: pointer; background: #28a745; color: white; border: none; border-radius: 4px;">Tìm kiếm</button>
                        <a href="page_manager.php"><button type="button" style="padding: 6px 15px; border-radius: 4px;">Làm mới</button></a>
                    </form>
                </div>

                <table border="1" style="width:100%; border-collapse: collapse; text-align: center;">
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
                        // Khởi tạo mảng điều kiện
                        $where_clauses = [];

                        // Kiểm tra tìm kiếm theo tên
                        if (isset($_GET['search_name']) && !empty($_GET['search_name'])) {
                            $s_name = mysqli_real_escape_string($conn, $_GET['search_name']);
                            $where_clauses[] = "Name_MT LIKE '%$s_name%'";
                        }

                        // Kiểm tra lọc theo ngày
                        if (isset($_GET['filter_date']) && !empty($_GET['filter_date'])) {
                            $f_date = mysqli_real_escape_string($conn, $_GET['filter_date']);
                            $where_clauses[] = "Import_date = '$f_date'";
                        }

                        // Xây dựng câu SQL
                        $sql_receipt = "SELECT * FROM stock_receipt";
                        if (count($where_clauses) > 0) {
                            $sql_receipt .= " WHERE " . implode(" AND ", $where_clauses);
                        }
                        $sql_receipt .= " ORDER BY Import_date DESC";

                        $res_receipt = mysqli_query($conn, $sql_receipt);

                        if (mysqli_num_rows($res_receipt) > 0) {
                            while($row = mysqli_fetch_assoc($res_receipt)) {
                                $total = $row['Quantity'] * $row['Price'];
                                echo "<tr>
                                        <td>{$row['ID_MT']}</td>
                                        <td>{$row['Name_MT']}</td>
                                        <td>" . date('d/m/Y', strtotime($row['Import_date'])) . "</td>
                                        <td>{$row['Quantity']}</td>
                                        <td>{$row['Unit']}</td>
                                        <td>" . number_format($row['Price'], 0, ',', '.') . "</td>
                                        <td>" . number_format($total, 0, ',', '.') . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' style='padding: 20px;'>Không tìm thấy hóa đơn nào phù hợp với yêu cầu tìm kiếm.</td></tr>";
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

    </main>

</div>
<script src="../page_staff_manager/lay_ten_nv.js"></script>
<script src="../page_staff_manager/page_manager.js"></script>
<script src="../page_staff_manager/mau_nhap_kho.js"></script>
</body>
</html>
