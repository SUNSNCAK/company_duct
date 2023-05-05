<?php
session_start();
require_once 'config/connection.php';
require_once 'config/connect_mysqli.php';
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
        <div class="progress-bar bg-dark" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0"
          aria-valuemax="100"></div>
      </div>
      <button type="button" onclick="location.href='status1.php'"
        class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-dark rounded-pill"
        style="width: 2.5rem; height:2.5rem;"><i class="bi bi-list-check"></i></button>
      <button type="button" onclick="location.href='status2.php'"
        class="position-absolute top-0 start-50 translate-middle btn btn-sm btn-dark rounded-pill"
        style="width: 2.5rem; height:2.5rem;"><i class="bi bi-printer"></i></button>
      <button type="button"
        class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-secondary rounded-pill"
        style="width: 2.5rem; height:2.5rem;"><i class="bi bi-pen"></i></button>
    </div>
    <div class="position-relative m-4">
      <div class="text-dark text-center mt-4 position-absolute top-0 start-0 translate-middle">
        รายละเอียด<br>คำสั่งซื้อ</div>
      <div class="text-dark text-center mt-4 position-absolute top-0 start-50 translate-middle">
        พิมพ์เอกสาร<br>ชำระเงิน</div>
      <div class="text-secondary text-center mt-4 position-absolute top-0 start-100 translate-middle">สถานะดำเนิน</div>
    </div>
    <?php
    $iduser = $_SESSION['user_login'];
    $status = "ชำระเรียบร้อย";
    $status1 = "ยกเลิกคำสั่งซื้อ";
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id AND pay_status != 'ชำระเรียบร้อย' AND pay_status != 'ยกเลิกคำสั่งซื้อ'");
    $stmt->bindParam(":user_id", $iduser);
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    $order_id = $rows['order_id'];
    $username = $rows['name'];
    $sub_district = $rows['sub_district'];
    $district = $rows['district'];
    $province = $rows['province'];
    $postcode = $rows['postcode'];
    $mydate = date('Y-m-d', strtotime($rows['setup_date']));
    $year = date('Y', strtotime($rows['setup_date']));
    $yearbuddhist = $year + 543;
    $chackstatus = $rows['pay_status'];
    $fileadmin = $rows['file_admin'];
    $paytotal = $rows['paytotal'];
    $vat = 7;
    $total = $paytotal * (100 + $vat) / 100; //ราคารวม vat ทั้งหมด
    $percent = 20;
    $percent1 = $percent / 100 * $total; //ค่ามัดจำ
    
    if (isset($_POST['upload'])) {
      $iduser = $_SESSION['user_login'];
      $numrand = (mt_rand());
      $date = date("Ymd");
      $addstatus = 'รอตรวจสอบหลักฐานค่ามัดจำ';
      $upload_ins = strrchr($_FILES['file_user']['name'], ".");
      $newname = $date . $numrand . $upload_ins;
      move_uploaded_file($_FILES["file_user"]["tmp_name"], "admin/assets/img/user_deposit/" . $newname);
      $sql = "UPDATE orders SET file_user = (?) , pay_status = (?) WHERE order_id = $order_id";
      $stmt = $connect->prepare($sql);
      $rc = $stmt->bind_param('ss', $newname, $addstatus);
      $stmt->execute();
      if ($stmt) { ?>
        <script>window.location = "status2.php";</script>
        <?php
      }
    }

    if (isset($_POST['cancel'])) {
      $sql = $conn->prepare("SELECT * FROM product natural join orders_item where order_id = $order_id");
      $sql->execute();
      $rows1 = $sql->fetch(PDO::FETCH_ASSOC);
      $p_id = $rows1['product_id'];
      $qty = $rows1['quantity'];
      $pqty = $rows1['product_qty'];

      //คืนจำนวนสินค้าคำสั่งซื้อ
      $sql1 = "UPDATE product SET product_qty = $pqty+$qty WHERE product_id = $p_id";
      $ins = $conn->prepare($sql1);
      $ins->execute();

      //ลบคำสั่งซื้อในตาราง order_item
      $sql2 = "DELETE FROM orders_item WHERE order_id = ?";
      $del = $conn->prepare($sql2);
      $del->execute([$order_id]);

      //ลบคำสั่งซื้อในตาราง installment
      $sql3 = "DELETE FROM installment WHERE order_id = ?";
      $del1 = $conn->prepare($sql3);
      $del1->execute([$order_id]);

      //เปลี่ยนสถานะเป็นยกเลิกคำสั่งซื้อ
      $status1 = "ยกเลิกคำสั่งซื้อ";
      $sql4 = "UPDATE orders SET pay_status = ? WHERE user_id = $iduser";
      $ins = $conn->prepare($sql4);
      $ins->execute([$status1]);
      ?>
      <script>window.location = "order.php";</script>
      <?php
    }
    ?>
    <div style="height:60px;"></div>
    <div class="p-4 rounded-3 shadow p-3 mb-5 bg-body-tertiary rounded" style="background-color:#eef3f8;">
      <h3 class="mb-3 text-center">รายละเอียดคำสั่งซื้อ</h3>
      <h5>สถานที่ติดตั้ง</h5>
      <div class="row">
        <p>
          <?php echo $username ?> แขวง/ตำบล
          <?php echo $sub_district ?> เขต/อำเภอ
          <?php echo $district ?> จังหวัด
          <?php echo $province ?>
          <?php echo $postcode ?>
        </p>
        <table class="table">
          <thead class="table-dark">
            <tr>
              <th scope="col">ภาพสินค้า</th>
              <th scope="col">ชื่อสินค้า</th>
              <th scope="col">รหัสสินค้า</th>
              <th scope="col">จำนวน</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($conn->query("SELECT * FROM product natural join orders_item WHERE order_id = $order_id") as $rows2) {
            $product_img = $rows2['product_img'];
            $product_name = $rows2['product_name'];
            $product_code = $rows2['product_code'];
            $product_qty = $rows2['quantity'];
            ?>
            <tr>
              <td><?php echo "<img src='admin/assets/img/products/$product_img' height='60' width='60' class='rounded-1'>"; ?></td>
              <td><?php echo $product_name; ?></td>
              <td><?php echo $product_code; ?></td>
              <td><?php echo $product_qty; ?> ชิ้น</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <div class="col-md-12">
          <p class="float-end mb-0">ราคารวม vat 7 %
            <?php echo number_format($total); ?> บาท
          </p><br>
          <h5 class="float-end text-danger mt-1">ค่ามัดจำ
            <?php echo number_format($percent1); ?> บาท
          </h5>
        </div>
        <div style="border-bottom:solid 1px lightgray;"></div>
      </div>
      <div class="row my-3">
        <div class="col-md-5 mt-2">
          <a href="download.php?path=<?php echo $fileadmin; ?>" title="Download File" target="_blank">
            <div class="card card-checkboxes card-hover-effect text-primary py-3">
              <h3 class="bi bi-printer"></h3>
              <p class="fw-bold">พิมพ์ใบเสนอราคา</p>
            </div>
          </a>
        </div>
        <div class="col-md-7 mt-2">
          <h4>ขั้นตอนการดำเนินการเมื่อพิมพ์ใบเสนอราคา</h4>
          <p class="text-secondary">1. ให้ลูกค้าพิมพ์ใบเสนอราคาและนำไปชำระเงินมัดจำ<br>2. อัปโหลดหลักฐานการชำระเงินมัดจำ
          </p>
        </div>
      </div>
      <div style="border-bottom:solid 1px lightgray;"></div>
      <?php
      if ($chackstatus == 'รอตรวจสอบหลักฐานค่ามัดจำ') { ?>
        <h4 class="mt-3 text-center text-success">อยู่ระหว่างการตรวจสอบหลักฐานค่ามัดจำ</h4>
      <?php } else { ?>
        <div class="row mt-3">
          <div class="col-md-6">
            <form method="POST" enctype="multipart/form-data">
              <input type="file" name="file_user" id="formFile" class="btnn form-control" style="margin:0px;"
                accept="image/*" required>
          </div>
          <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="text-center mx-2">
              <input type="submit" class="btnn" value="ยืนยัน" name="upload" style="margin:0px; padding: 0.5rem 2.5rem;">
            </div>
            </form>
            <div class="text-center mx-2">
              <a class="text-danger" href="" data-bs-toggle="modal" data-bs-target="#exampleModal">ยกเลิกคำสั่งซื้อ !</a>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">คำสั่งซื้อ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    ต้องการยกเลิกคำสั่งซื้อหรือไม่ ?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <form action="" method="post">
                      <input type="submit" class="btn btn-danger" value="ยืนยัน" name="cancel">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
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