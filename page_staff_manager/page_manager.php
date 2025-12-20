<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Quản Lý</title>
    <link rel="stylesheet" href="../page_staff_manager/page_manager.css">
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
            <li onclick="showPage('employee')">👤 Tra cứu nhân viên</li>
            <li> <a href="../config/logout.php"><button class="logout-btn">Đăng xuất</button></a></li>
        </ul>
    </aside>

    <!-- CONTENT -->
    <main class="content">

        <section id="schedule" class="page active">
            <h1>Thêm lịch làm việc</h1>
            <div class="box">Nội dung thêm lịch</div>
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

<script src="../page_staff_manager/page_manager.js"></script>
</body>
</html>
