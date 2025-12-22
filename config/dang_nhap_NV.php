<?php
require '../config/config.php';
session_start();

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['id']);
    $password = $_POST['password'];

    $sql = "SELECT ID, `password`, `name`, sex, `role`
            FROM user 
            WHERE ID = '$username' 
            LIMIT 1";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $hashedPassword = $row['password'];
        $isValidPassword = false;

        if (password_verify($password, $hashedPassword)) {
            $isValidPassword = true;
        } elseif ($password === $hashedPassword) {
        
            $isValidPassword = true;
        }

        if ($isValidPassword) {
            if ($row['role'] == 0) {
                $_SESSION['id']=$row['ID'];
                $_SESSION['name']=$row['name'];
                header("Location: ../page_staff_manager/page_staff.php");
                exit(); 
            } else {
                echo '<script>
                    alert("Đăng Nhập Thất Bại!!! Sai Vai Trò!!!");
                    window.location.href = "../login_staff_manager/login_staff.php";
                </script>';
            }
        } else {
            echo '<script>
                alert("Đăng nhập thất bại! Sai mật khẩu");
                window.location.href = "../login_staff_manager/login_staff.php";
            </script>';
        }
    } else {
        echo '<script>
            alert("Đăng nhập thất bại! Sai tên đăng nhập");
            window.location.href = "../login_staff_manager/login_staff.php";
        </script>';
    }
}
?>
