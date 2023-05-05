<?php
session_start();
require_once 'config/connection.php';
if (!isset($_SESSION['user_login'])) {
  header('location: home.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once('head.php');
  ?>
  <script>
    $(function () {
      $('a.delete').click(function () {
        if (confirm('ยืนยันการลบสินค้ารายการนี้ออกจากรถเข็น')) {
          var del_id = $(this).attr('data-id');
          $('#delete-id').val(del_id);
          $('#form-delete').submit();
        }
      });
    });
  </script>
</head>

<body>
  <?php
  require_once('navbar.php');
  ?>
  <div style="height:120px;"></div>
  <div class="container p-4 rounded-4">
    <?php
    $iduser = $_SESSION['user_login'];
    $mysqli = new mysqli('localhost', 'root', '', 'company_duct');
    if (isset($_POST['delete_id'])) {
      $pid = $_POST['delete_id'];
      $sql = "DELETE FROM cart WHERE user_id = $iduser AND product_id = $pid";
      $mysqli->query($sql);
    }
    if (isset($_POST['qty'])) {
      $count = count($_POST['qty']);
      for ($i = 0; $i < $count; $i++) {
        $qty = $_POST['qty'][$i];
        $pid = $_POST['pid'][$i];
        $sql = "UPDATE cart SET quantity = $qty
                          WHERE user_id = $iduser AND product_id = $pid";
        $mysqli->query($sql);
      }
    }

    $sql = <<<SQL
      SELECT p.*,  c.*
      FROM product p 
      LEFT JOIN  cart c
      ON p.product_id = c.product_id
      WHERE c.user_id = $iduser
      SQL;


    $result = $mysqli->query($sql);
    if ($mysqli->error || $result->num_rows == 0) {
      echo '<h4 class="text-center text-danger">ไม่มีสินค้า</h4>';
      $mysqli->close();

    } else {

      echo '<h4 class="text-center">รายการสินค้า</h4>';
      echo <<<HTML
        <div class="table-responsive">
        <table class="table text-center">
          <thead style="background-color:#222831; color:white;">
            <tr>
              <th scope="col">รูปสินค้า</th>
              <th scope="col">ชื่อสินค้า</th>
              <th scope="col">จำนวน</th>
              <th scope="col">ลบสินค้า</th>
            </tr>
          </thead>
        HTML;
      while ($p = $result->fetch_object()) {
        $src = "admin/assets/img/products/$p->product_img";
        echo <<<HTML
            <tbody style="background-color:#eef3f8;">
              <tr>
                <th scope="row" class="py-3"><img src="$src" style="width: 64px; height: 64px; border-radius:5px;"></th>
                <td class="py-3">
                  <h5><a href="product_detail.php?product_id=$p->product_id" target="_blank">$p->product_name</a></h5>
                  <p>$p->product_code</p>
                </td>
                <td class="py-3">
                  <form id="form-cart" method="post">
                    <div class="number-input"> 
                      <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="bi bi-dash-lg"></button>
                      <input type="number" name="qty[]" class="quantity" id="quantity" min="1" max="$p->product_qty" value="$p->quantity">
                      <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="bi bi-plus-lg"></button>
                      <input type="hidden" name="pid[]" value="$p->product_id">
                    </div>
                  </form>
                </td>
                <td class="py-3">
                  <a href=# class="delete" data-id="$p->product_id">
                    <h4 class="bi bi-trash3"></h4>
                  </a>
                </td>
              </tr>
          HTML;
      }
      echo <<<HTML
            </tbody>
          </table>
          </div>
          <form class="row g-3" method="post" id="form-checkin" action="place-order.php">
          <div style="border-bottom:solid 1px lightgray;"></div>
          <h5 class="my-3">วันที่ติดตั้งและการชำระเงิน</h5>
            <div class="col-md-6">
              <label for="name" class="form-label">วันที่ติดตั้ง</label>
              <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <script>
              var today = new Date().toISOString().split('T')[0];
              document.getElementsByName("date")[0].setAttribute('min', today);
            </script>
            <div class="col-md-6">
              <label for="name" class="form-label">ชำระ/งวด</label>
                <div>
                  <input type="radio" id="contactChoice1"
                  name="contact" value="1" checked>
                  <label class="me-3" for="contactChoice1">1 งวด</label>
                  <input type="radio" id="contactChoice2"
                  name="contact" value="2">
                  <label class="me-3" for="contactChoice2">2 งวด</label>
                  <input type="radio" id="contactChoice3"
                  name="contact" value="3">
                  <label class="me-3" for="contactChoice3">3 งวด</label>
                  <input type="radio" id="contactChoice4"
                  name="contact" value="4">
                  <label class="me-3" for="contactChoice4">4 งวด</label>
                  <input type="radio" id="contactChoice5"
                  name="contact" value="5">
                  <label class="me-3" for="contactChoice5">5 งวด</label>
                  <input type="radio" id="contactChoice6"
                  name="contact" value="6">
                  <label class="me-3" for="contactChoice6">6 งวด</label>
                </div>
            </div>
          <div style="border-bottom:solid 1px lightgray;"></div>
          <h5 class="mt-3">ที่อยู่ในการติดตั้ง</h5>
          HTML;
      $iduser = $_SESSION['user_login'];
      $stmt4 = $conn->query("SELECT * FROM address WHERE user_id = $iduser");
      $stmt4->execute();
      $rows2 = $stmt4->fetch(PDO::FETCH_ASSOC);
      if ($rows2 == 0) {
        echo <<<HTML
            </form>
            <div class="text-center">
              <button onclick="location.href='address.php'" class="showbtn"><i class="bi bi-plus-lg"></i> เพิ่มที่อยู่</button>
            </div>
          HTML;
      } else {
        $iduser = $_SESSION['user_login'];
        foreach ($conn->query("SELECT * FROM address WHERE user_id = $iduser") as $rows1) {
          $address_id = $rows1['address_id'];
          $addressname = $rows1['name'];
          $addressnumber = $rows1['number'];
          $addresssub = $rows1['sub_district'];
          $addressdetails = $rows1['details'];
          $addressdistrict = $rows1['district'];
          $addressprovince = $rows1['province'];
          $addresspostcode = $rows1['postcode'];
          echo <<<HTML
            <div class="cartaddress">
              <div class = "selectradio">
                <div class="cartaddress1">
                  <div>$addressname</div>
                  <div style="border-left: 0.5px solid rgba(0,0,0,.50); margin:0px 8px"></div>
                  <div style="flex: 1 1 0%;"> $addressnumber</div>
                  <div style="display:flex;" class="input-container">
                      <input type="radio" id="address"
                      name="address" value="$address_id" class="radio-address" required>
                  </div>
                </div>
                <div>
                <span> $addressdetails</span>
                <span>ตำบล $addresssub</span>
                </div>
                <div>
                <span>อำเภอ $addressdistrict</span>
                <span> , จังหวัด $addressprovince</span>
                <span> , $addresspostcode</span>
                </div>
              </div>
            </div>
            HTML;
        }
        echo <<<HTML
            <div class="text-center my-4">
            <a href="home.php" class="btnn px-md-5 link-light">&laquo; เลือกสินค้าเพิ่มเติม</a>
            <button type="submit" class="checkout btnn px-md-5 link-light">ขอใบเสนอราคา &raquo;</button>
            </form>
            </div>
            HTML;
      }
    }
    ?>
  </div>
  <form id="form-delete" method="post">
    <input type="hidden" name="delete_id" id="delete-id" value="">
  </form>
  <?php
  if (isset($_SESSION['user_login'])) {
    require_once('chat-box.php');
  }
  ?>
  <script src="dropdown.js"></script>
  <script src="chat.js"></script>
</body>

</html>