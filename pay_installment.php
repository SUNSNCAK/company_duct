<?php
  session_start();
  require_once 'config/connection.php';
  require_once 'config/connect_mysqli.php';

  if (isset($_POST['upload'])) {
    $order_id = $_GET['order_id'];
    $qty = $_GET['pay_qty'];
    $status = "อยู่ระหว่างการตรวจสอบ";
    $numrand = (mt_rand());
    $date = date("Ymd");
    $upload_ins = strrchr($_FILES['file_user']['name'],".");
    $newname = $date.$numrand.$upload_ins;
    move_uploaded_file($_FILES["file_user"]["tmp_name"], "admin/assets/img/installment/" . $newname);
    $sql = "UPDATE installment SET file_user = (?) , pay_status = (?) WHERE order_id = $order_id AND pay_qty = $qty";
    $stmt = $connect->prepare($sql);
    $rc = $stmt->bind_param('ss',$newname,$status);
    $stmt->execute();
    if ($stmt) { ?>
      <script>window.location="status3.php";</script> <?php
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    require_once('head.php');
  ?>
</head>
<?php
  $qty = $_GET['pay_qty'];
  $order_id = $_GET['order_id'];
  $ret = "SELECT * FROM  orders WHERE order_id = '$order_id'";
  $stmt = $connect->prepare($ret);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($order = $res->fetch_object()) {
    $vat = 7;
    $total = $order->paytotal * (100+$vat)/100; //ราคารวม vat ทั้งหมด
    $percent = 20;
    $percent1 = $percent/100 * $total; //ค่ามัดจำ
    $deposit = $total - $percent1;
    $installment = $deposit / $order->pay_qty; //ราคาต่องวด
?>
<body>
  <div class="container mt-5 text-center">
    <div class="card text-center" style="max-width:50%; min-width:290px;">
      <div class="card-header">
        ชำระงวดที่ <?php echo $qty; ?>
      </div>
      <div class="card-body">
        <h2 class="card-title"><?php echo number_format($installment,2); ?> บาท</h2>
        <div style="border-bottom:solid 1px lightgray; margin-bottom:20px;"></div>
        <p class="text-secondary">อัพโหลดหลักฐานการชำระค่างวด</p>
          <form method="POST" enctype="multipart/form-data">
            <input type="file" name="file_user" id="formFile" class="btnn form-control" style="margin:0px;" accept="image/*"  required>
          </div>
          <div>
            <div class="text-center mb-3">
              <input type="submit" class="btnn" value="ยืนยัน" name="upload" style="margin:0px; padding: 0.5rem 2.5rem;">
            </div>
          </form>
      </div>
      <div class="card-footer text-muted">
        V.K. AIR GROUP รหัสคำสั่งซื้อที่ <?php echo $order_id; ?>
      </div>
    </div>
  </div>
  <?php
    if (isset($_SESSION['user_login'])) {
      require_once('chat-box.php');
    }
  ?>
  <script src="chat.js"></script>
</body>
</html>
<?php } ?>