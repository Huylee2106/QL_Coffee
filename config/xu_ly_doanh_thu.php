<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['month_year'])) {
    $month_year = $_POST['month_year']; // Định dạng: YYYY-MM
    $year = date('Y', strtotime($month_year));
    $month = date('m', strtotime($month_year));
    
    // Đưa về định dạng Y-m-01 để làm khóa chính đồng nhất
    $report_date = $year . "-" . $month . "-01";

    // 1. Tính Tổng Doanh Thu (từ bill đã thanh toán bill_status = 1)
    $q_rev = $conn->query("SELECT SUM(Total) as total FROM bill WHERE bill_status = 1 AND MONTH(Day) = $month AND YEAR(Day) = $year");
    $total_rev = $q_rev->fetch_assoc()['total'] ?? 0;

    // 2. Tính Tổng Lương (từ salary tháng đó)
    $q_sal = $conn->query("SELECT SUM(Total_salary) as total FROM salary WHERE Salary_month = $month AND Year = $year");
    $total_sal = $q_sal->fetch_assoc()['total'] ?? 0;

    // 3. Tính Tổng Tiền Nhập Kho (từ stock_receipt tháng đó)
    $q_stock = $conn->query("SELECT SUM(Price * Quantity) as total FROM stock_receipt WHERE MONTH(Import_date) = $month AND YEAR(Import_date) = $year");
    $total_stock = $q_stock->fetch_assoc()['total'] ?? 0;

    // 4. Tính Lợi Nhuận
    $new_profit = $total_rev - $total_sal - $total_stock;

    // 5. Xử lý ví (Wallet): Hoàn tác tiền của bản ghi cũ nếu đã tồn tại
    $q_check = $conn->query("SELECT Monthly_profit FROM revenue WHERE Report_month = '$report_date'");
    if ($q_check && $q_check->num_rows > 0) {
        $old_data = $q_check->fetch_assoc();
        $old_profit = $old_data['Monthly_profit'];
        
        // Trừ lợi nhuận cũ ra khỏi ví trước khi nạp cái mới vào
        $conn->query("UPDATE wallet SET fund = fund - $old_profit");
    }

    // 6. Cập nhật bảng Revenue (Dùng REPLACE để ghi đè dòng cũ nếu trùng tháng)
    $sql_update = "REPLACE INTO revenue (Report_month, Total_monthly_revenue, Total_shift_cost, Total_monthly_cost, Monthly_profit) 
                   VALUES ('$report_date', $total_rev, $total_sal, $total_stock, $new_profit)";
    
    if ($conn->query($sql_update)) {
        // 7. Cập nhật ví chủ với lợi nhuận mới nhất
        $conn->query("UPDATE wallet SET fund = fund + $new_profit");
        
        echo "<script>alert('Đã chốt/cập nhật doanh thu tháng $month/$year thành công!'); window.location.href='../page_staff_manager/page_manager.php';</script>";
    } else {
        echo "Lỗi SQL: " . $conn->error;
    }
}
?>