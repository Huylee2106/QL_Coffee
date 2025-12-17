<?php
require '../config/config.php';
session_start();

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['id']);
    $password = $_POST['password'];

    $sql = "SELECT u.ID, u.user_name, u.password, u.role,
                   h.ID_HS, h.ID_Lop
            FROM user u
            JOIN hocsinh h ON u.ID = h.ID_HS
            WHERE u.email = '$username' or u.user_name ='$username'
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
            if ($row['role'] == 1) {
                // Lưu session
                $_SESSION['user_id']    = $row['ID'];        
                $_SESSION['user_name']  = $row['user_name']; 
                $_SESSION['id_hs']      = $row['ID_HS'];     
                $_SESSION['id_lop']     = $row['ID_Lop'];  
                $id_hs = $row['ID'];
                $sql_count = "SELECT COUNT(*) AS total_exercises 
                  FROM results 
                  WHERE ID = '$id_hs'";
                $result_count = mysqli_query($conn, $sql_count);
                $row_count = mysqli_fetch_assoc($result_count);
                $_SESSION['sl_bt'] = $row_count['total_exercises'];

                header("Location: ../Giao%20Diện%20WEB/login_student.php");
                exit(); 
            } else {
                echo '<script>
                    alert("Đăng Nhập Thất Bại!!! Sai Vai Trò!!!");
                    window.location.href = "../Giao%20Diện%20WEB/login.php";
                </script>';
            }
        } else {
            echo '<script>
                alert("Đăng nhập thất bại! Sai mật khẩu");
                window.location.href = "../Giao%20Diện%20WEB/login.php";
            </script>';
        }
    } else {
        echo '<script>
            alert("Đăng nhập thất bại! Sai tên đăng nhập");
            window.location.href = "../Giao%20Diện%20WEB/login.php";
        </script>';
    }
}
?>
