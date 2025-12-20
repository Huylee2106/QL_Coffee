<?php
    require '../config/config.php';
    
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
        <ul class="menu">
            <li class="active" onclick="showPage('schedule')">📅 Thêm lịch</li>
            <li onclick="showPage('salary')">💰 Thanh toán lương</li>
            <li onclick="showPage('inventory')">📦 Kiểm kho</li>
            <li onclick="showPage('add_staff')">➕ Thêm Nhân Viên</li>
            <li onclick="showPage('employee')">👤 Tra cứu nhân viên</li>
            <li> <a href="../config/logout.php"><button class="logout-btn">Đăng xuất</button></a></li>
        </ul>
    </aside>

    <!-- CONTENT -->
    <main class="content">

        <section id="schedule" class="page active">
            <h1>Thêm lịch làm việc</h1>
            <div class="box">
                <div class="container">
                    <h2>Thêm Lịch CHo Nhân Viên</h2>
                    <form action="../config/them_nv.php" method="POST">
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
                        <label>Chọn Ngày Làm Việc</label>
                        <select name="shift" required>
                            <option value="">Chọn Ca Làm Việc</option>
                            <option value="Ca Sáng">Ca Sáng - 6h -> 10h</option>
                            <option value="Ca Trưa">Ca Trưa - 10h -> 14h</option>
                            <option value="Ca Chiều">ca chiều - 14h ->18h</option>
                            <option value="Ca Tối">Ca tối 18h ->22h</option>
                        </select>
                        </div>


                    </form>
                    </div>

            </div>
        </section>
        <section id="add_staff" class="page">
            <h1>thêm nhân viên</h1>
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
            <div class="box">Nội dung kiểm kho</div>
        </section>

        <section id="employee" class="page">
            <h1>Tra cứu nhân viên</h1>
            <div class="box">Nội dung tra cứu nhân viên</div>
        </section>

    </main>

</div>
<script src="../page_staff_manager/lay_ten_nv.js"></script>

<script src="../page_staff_manager/page_manager.js"></script>
</body>
</html>
