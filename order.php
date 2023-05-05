<?php
  session_start();
  require_once 'config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    require_once('head.php');
  ?>
</head>
<body>
    <?php
      require_once('navbar.php');
    ?>
    <?php
    $iduser = $_SESSION['user_login'];
    $status = "ชำระเรียบร้อย";
    $status1 = "ยกเลิกคำสั่งซื้อ";
    $check_data = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id AND pay_status != 'ชำระเรียบร้อย' AND pay_status != 'ยกเลิกคำสั่งซื้อ'");
    $check_data->bindParam(":user_id", $iduser);
    $check_data->execute();
    $row = $check_data->fetch(PDO::FETCH_ASSOC);
    $result = $row['pay_status'];
    if ($result == 'อยู่ระหว่างการชำระ'){
      ?> <script>window.location="status1.php";</script> <?php
    } else if ($result == 'ยืนยันคำสั่งซื้อ') {
        ?> <script>window.location="status1.php";</script> <?php
    } else if ($result == 'รอตรวจสอบหลักฐานค่ามัดจำ') {
      ?> <script>window.location="status2.php";</script> <?php
    } else if ($result == 'ยืนยันมัดจำ') {
      ?> <script>window.location="status3.php";</script> <?php
    } else {
    ?>
    <div class="container">
      <div class="text-center">
        <div style="height:120px;"></div>
        <h3 class="text-danger">ยังไม่มีคำสั่งซื้อในขณะนี้</h3>
      </div>
    </div>
    <?php
    }
    ?>
    <?php
    if (isset($_SESSION['user_login'])) {
      require_once('chat-box.php');
    }
    ?>
    <script src="dropdown.js"></script>
    <script src="chat.js"></script>
</body>
</html>