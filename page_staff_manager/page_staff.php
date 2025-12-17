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
            <li onclick="showPage('view-orders', this)">
                ☕ Yêu cầu pha chế
            </li>
            <li onclick="showPage('view-inventory', this)">
                📦 Xem kho
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

        <!-- YÊU CẦU PHA CHẾ -->
        <section id="view-orders" class="page">
            <h1>Yêu cầu pha chế</h1>
            <div class="box">Danh sách đơn khách gọi</div>
        </section>

        <!-- XEM KHO -->
        <section id="view-inventory" class="page">
            <h1>Xem kho</h1>
            <div class="box">Tình trạng kho</div>
        </section>

    </main>

</div>

<script src="../page_staff_manager/page_staff.js"></script>
</body>
</html>
