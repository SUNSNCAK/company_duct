<?php
    if(!isset($_SESSION))
    {
    session_start();
    }
    include_once "config/config.php";

    $admin = $_SESSION['admin_login'];
    isset($_POST['searchTerm']) ? $searchTerm = $_POST['searchTerm'] : $searchTerm = '';

    $sql = "SELECT * FROM users WHERE NOT user_id = $admin AND (name LIKE '%{$searchTerm}%') AND urole != 'admin'";
    $output = "";
    $query = mysqli_query($mysqli, $sql);

    if(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }else{
        $output .= 'ไม่พบชื่อผู้ใช้ที่เกี่ยวข้องกับคำค้นหาของคุณ';
    }
    echo $output;
?>