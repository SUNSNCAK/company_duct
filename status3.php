<?php
  session_start();
  require_once 'config/connection.php';
  require_once 'config/connect_mysqli.php';

  $iduser = $_SESSION['user_login'];
  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = $iduser AND pay_status = 'ยืนยันมัดจำ'");
  $stmt->execute();
  $rows = $stmt->fetch(PDO::FETCH_ASSOC);
  $orderid = $rows['order_id'];
  $qty = $rows['pay_qty'];
  $success = "ชำระเรียบร้อย";

  $sql2 = "SELECT * FROM installment WHERE pay_status= 'ชำระเรียบร้อย' and  order_id  =".$orderid;
  $stmt2 = $connect->prepare($sql2);
  $stmt2->execute();
  $res2 = $stmt2->get_result();
  $count=0;
  foreach($res2 as $a){
    $count++;
  }
  if ($count == $qty) { 
    $sql = "UPDATE orders SET pay_status = (?) WHERE order_id = $orderid";
    $stmt = $connect->prepare($sql);
    $rc = $stmt->bind_param('s',$success);
    $stmt->execute();
  ?>
    <script>window.location="order.php";</script> <?php
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
    <div style="height:120px;"></div>
    <div class="container">
      <div class="position-relative m-4">
        <div class="progress" style="height: 2px;">
          <div class="progress-bar bg-dark" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <button type="button" onclick="location.href='status1.php'" class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-dark rounded-pill" style="width: 2.5rem; height:2.5rem;"><i class="bi bi-list-check"></i></button>
        <button type="button" onclick="location.href='status2.php'" class="position-absolute top-0 start-50 translate-middle btn btn-sm btn-dark rounded-pill" style="width: 2.5rem; height:2.5rem;"><i class="bi bi-printer"></i></button>
        <button type="button" onclick="location.href='status3.php'" class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-dark rounded-pill" style="width: 2.5rem; height:2.5rem;"><i class="bi bi-pen"></i></button>
      </div>
      <div class="position-relative m-4">
        <div class="text-dark text-center mt-4 position-absolute top-0 start-0 translate-middle">รายละเอียด<br>คำสั่งซื้อ</div>
        <div class="text-dark text-center mt-4 position-absolute top-0 start-50 translate-middle">พิมพ์เอกสาร<br>ชำระเงิน</div>
        <div class="text-dark text-center mt-4 position-absolute top-0 start-100 translate-middle">สถานะดำเนิน</div>
      </div>
      <?php
        $iduser = $_SESSION['user_login'];
        $status = "ชำระเรียบร้อย";
        $status1 = "ยกเลิกคำสั่งซื้อ";
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id AND pay_status != 'ชำระเรียบร้อย' AND pay_status != 'ยกเลิกคำสั่งซื้อ'");
        $stmt->bindParam(":user_id", $iduser);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderid = $rows['order_id'];
        $qty = $rows['pay_qty'];
        $fileadmin = $rows['file_admin'];
      ?>
      <div style="height:60px;"></div>
      <div class="p-4 rounded-3 shadow p-3 mb-5 bg-body-tertiary rounded" style="background-color:#eef3f8;">
        <h3 class="mb-3 text-center">งวดชำระ</h3>
          <div class="container">
          <h6>รหัสคำสั่งซื้อที่ : <?php echo $orderid; ?></h6>
          <div class="table-responsive">
          <table class="table">
            <thead style="background-color:#222831; color:white;">
              <tr>
                <th scope="col">ลำดับ</th>
                <th scope="col">งวดที่</th>
                <th scope="col">สถานะ</th>
                <th scope="col">ใบเสนอราคา</th>
                <th scope="col">action</th>
              </tr>
            </thead>
            <tbody>
            <?php
            foreach ($conn->query("SELECT * FROM installment WHERE order_id = $orderid") as $rows1) {
              $payqty = $rows1['pay_qty'];
              $status = $rows1['pay_status'];
              $order_id = $rows1['order_id'];
            ?>
              <tr>
                <th scope="row"><?php echo $payqty; ?></th>
                <td><?php echo $payqty; ?>/<?php echo $qty; ?></td>
                <?php
                  if ($rows1['pay_status'] == 'อยู่ระหว่างการตรวจสอบ') { ?>
                  <td><p class="text-secondary fw-bold"><?php echo $status; ?></p></td>
                  <td><a href="download.php?path=<?php echo $fileadmin; ?>"><?php echo $fileadmin; ?></a></td>
                  <td>
                  <button type="button" class="btn btn-sm btn-secondary" disabled><i class="bi bi-receipt"></i>ตรวจสอบ</button>
                </td>
                <?php
                } else if ($rows1['pay_status'] == 'ชำระเรียบร้อย'){ ?>
                  <td><p class="text-success fw-bold"><?php echo $status; ?></p></td>
                  <td><a href="download.php?path=<?php echo $fileadmin; ?>"><?php echo $fileadmin; ?></a></td>
                  <td>
                  <button type="button" class="btn btn-sm btn-success" disabled><i class="bi bi-check-circle"></i>ชำระแล้ว</button>
                <?php
                } else {
                ?>
                <td><p class="text-danger fw-bold"><?php echo $status; ?></p></td>
                <td><a href="download.php?path=<?php echo $fileadmin; ?>"><?php echo $fileadmin; ?></a></td>
                <td>
                  <button type="submit" class="btn btn-sm btn-danger" onclick = "location.href='pay_installment.php?order_id=<?php echo $order_id; ?>&&pay_qty=<?php echo $payqty; ?>'"><i class="bi bi-receipt"></i>ชำระ</button>
                </td>
                <?php
                }
                ?>
              </tr>
            <?php }
            ?>
            </tbody>
          </table>
          </div>
          </div>
        </div>
      </div>  
    </div>
    <?php
    if (isset($_SESSION['user_login'])) {
      require_once('chat-box.php');
    }
    ?>
    <script src="dropdown.js"></script>
    <script src="chat.js"></script>
</body>
</html>