<?php
  session_start();
  require_once 'config/connection.php';
  require_once 'config/connect_mysqli.php';
  if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: cart.php');
  }
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
  <div class="container text-center" style="padding-top:20%">
  <img src="img/icon/check.png" alt="check" style="height:64px; width:64px; margin-bottom:10px;">
  <h4 class="text-success">คำสั่งซื้อสำเร็จ!</h4>
  <p class="text-secondary">สามารถตรวจสอบสถานะการสั่งซื้อได้ที่<a href="order.php"> การสั่งซื้อ </a>มุมบนขวา</p>
  <a href="home.php" class="btnn text-light">กลับสู่หน้าแรก</a>
  </div>
  <?php
  $iduser = $_SESSION['user_login'];
  $sel = "SELECT * FROM orders WHERE user_id = $iduser AND pay_status != 'ชำระเรียบร้อย' AND pay_status != 'ยกเลิกคำสั่งซื้อ'";
  $result = $connect->query($sel);
  if ($result->num_rows > 0 ) {
    echo "<script>alert('มีคำสั่งซื้อที่ดำเนินการอยู่');</script>";
    ?> <script>window.location="order.php";</script> <?php
  } else {
  $iduser = $_SESSION['user_login'];
  $add_id = $_POST['address'];
  $sel_add = "SELECT * FROM address WHERE address_id = $add_id";
  $result = $connect->query($sel_add);
  $stmt = $result->fetch_object();
  $name = $stmt->name;
  $number = $stmt->number;
  $sub_district = $stmt->sub_district;
  $district = $stmt->district;
  $province = $stmt->province;
  $postcode = $stmt->postcode;
  $details = $stmt->details;
  $sql = 'INSERT INTO orders VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
  $stmt = $connect->stmt_init();
  $stmt->prepare($sql);
  $now = strtotime('now');
  $date = date('Y-m-d', $now);
  $pts = "อยู่ระหว่างการชำระ";
  $p = [0,$iduser,$name,$number,$sub_district,$district,$province,$postcode,$details,$_POST['date'],$_POST['contact'],$date,$pts,"","","",""];
  $stmt->bind_param('iisssssssssssssss', ...$p);
  $stmt->execute();
  //อ่านรหัสการสังซื้อ เพื่อนำไปเก็บลงในตาราง orders_item
  $order_id = $stmt->insert_id;
  $stmt->close();

  $payqty = $_POST['contact'];
  for ($i=1; $i<=$payqty; $i++) {
    $array[] = array('pay_qty' => $i);
  }
  $codes = $array;
  foreach ($codes as $code) {
  $sql1 = 'INSERT INTO installment VALUES (?, ?, ?, ?, ?)';
  $stmt1 = $connect->stmt_init();
  $stmt1->prepare($sql1);
  $pts1 = "ยังไม่ได้ชำระ";
  $ins = [0,$order_id,'',$code['pay_qty'],$pts1];
  $stmt1->bind_param('iisss', ...$ins);
  $stmt1->execute();
  $stmt1->close();
  }

  //อ่านข้อมูลจากตาราง cart ที่ลูกค้ารายนั้นหยิบใส่รถเข็น
  $sql = "SELECT * FROM cart WHERE user_id = $iduser";
  $result = $connect->query($sql);
  //เก็บข้อมูลสินค้าแต่ละรายการลงในตาราง orders_item
  while ($cart = $result->fetch_object()) {
    $pid = $cart->product_id;
    $qty = $cart->quantity;
    $width = $cart->width;
    $length = $cart->length;
    $height = $cart->height;
    $other_item = $cart->other_item;
    $sql = "INSERT INTO orders_item (`order_id`, `product_id`, `quantity`, `width`, `length`, `height`, `other`) VALUES 
                ($order_id, $pid, $qty, $width, $length, $height , '".$other_item."')";
    $connect->query($sql);
    $quantity="SELECT * FROM product where product_id=$pid";
      $result1 = $connect->query($quantity);
      while($cart2= $result1->fetch_object()) {
            $quantity1=$cart2->product_qty;
            $sql1 = "UPDATE product Set product_qty=$quantity1-$qty where product_id = $pid";
            $connect->query($sql1);
    }
  }


  //ลบรายการสินค้าที่ลูกค้ารายนั้นหยิบใส่รถเข็นออกจากตาราง cart
  $sql = "DELETE FROM cart WHERE user_id = $iduser";
  $connect->query($sql);
  $connect->close();
  }
  ?>
  <?php
    if (isset($_SESSION['user_login'])) {
      require_once('chat-box.php');
    } else {
      require_once('cart.php');
    }
  ?>
  <script src="dropdown.js"></script>
  <script src="chat.js"></script>
</body>
</html>