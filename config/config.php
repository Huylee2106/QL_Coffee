<?php
    $servername ="localhost";
    $username ="root";
    $password ="";
    $db_name= "login_ck";
    $conn= new mysqli($servername, $username, $password , $db_name , 3306);

    if($conn->connect_error){
        die("Đăng Nhập Thất Bại".$conn->connection_error);
    }else{echo " "; }

    $conn->set_charset("utf8mb4");
    
?>