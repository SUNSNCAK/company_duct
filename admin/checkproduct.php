<?php
session_start();
include('config/config.php');
include('config/pdoconfig.php');
include('config/checklogin.php');
check_login();

if (isset($_POST['add_paytotal'])) {
  $paytotal = $_POST['paytotal'];
  $order_id = $_GET['order_id'];
  $sql = "UPDATE orders SET paytotal = (?) WHERE order_id = $order_id";
  $stmt = $mysqli->prepare($sql);
  $rc = $stmt->bind_param('s', $paytotal);
  $stmt->execute();
  if ($stmt) { ?>
    <script>window.location = "make_order.php?order_id=<?php echo $order_id; ?>";</script> <?php
  } else { ?>
    <script>window.location = "checkproduct.php";</script> <?php
  }
}

if (isset($_POST['cancel'])) {
  $order_id = $_GET['order_id'];
  $sql = $DB_con->prepare("SELECT * FROM product natural join orders_item where order_id = $order_id");
  $sql->execute();
  $rows1 = $sql->fetch(PDO::FETCH_ASSOC);
  $p_id = $rows1['product_id'];
  $qty = $rows1['quantity'];
  $pqty = $rows1['product_qty'];

  //คืนจำนวนสินค้าคำสั่งซื้อ
  $sql1 = "UPDATE product SET product_qty = $pqty+$qty WHERE product_id = $p_id";
  $ins = $DB_con->prepare($sql1);
  $ins->execute();

  //ลบคำสั่งซื้อในตาราง order_item
  $sql2 = "DELETE FROM orders_item WHERE order_id = ?";
  $del = $DB_con->prepare($sql2);
  $del->execute([$order_id]);

  //ลบคำสั่งซื้อในตาราง installment
  $sql3 = "DELETE FROM installment WHERE order_id = ?";
  $del1 = $DB_con->prepare($sql3);
  $del1->execute([$order_id]);

  //เปลี่ยนสถานะเป็นยกเลิกคำสั่งซื้อ
  $status1 = "ยกเลิกคำสั่งซื้อ";
  $sql4 = "UPDATE orders SET pay_status = ? WHERE order_id = $order_id";
  $ins = $DB_con->prepare($sql4);
  $ins->execute([$status1]);
  ?>
  <script>window.location = "orders.php";</script> <?php
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once('partials/_head.php');
  ?>
</head>

<body>
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/backgroundadmin.jpg); background-size: 50% 100%;"
      class="header  pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3>รายการสินค้า</h3>
              <?php
              $orderid = $_GET['order_id'];
              $sql1 = "SELECT * FROM product natural join orders_item where order_id = $orderid";
              $stmt1 = $mysqli->prepare($sql1);
              $stmt1->execute();
              $res1 = $stmt1->get_result();
              ?>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="bg-dark text-white">
                    <tr>
                      <th scope="col">รหัสสินค้า</th>
                      <th scope="col">รูปสินค้า</th>
                      <th scope="col">ชื่อสินค้า</th>
                      <th scope="col">ขนาด</th>
                      <th scope="col">จำนวน</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($order = $res1->fetch_object()) { ?>
                      <tr>
                        <th scope="row">
                          <?php echo $order->product_code; ?>
                        </th>
                        <td>
                          <?php
                          if ($order->product_img) {
                            echo "<img src='assets/img/products/$order->product_img' height='60' width='60 class='img-thumbnail'>";
                          } else {
                            echo "<img src='assets/img/products/default.jpg' height='60' width='60 class='img-thumbnail'>";
                          }

                          ?>
                        </td>
                        <td>
                          <?php echo $order->product_name; ?>
                        </td>
                        <td>
                          <p>
                            <a class="mx-5 text-center d-flex justify-content-center" data-toggle="collapse"
                              href="#collapseExample<?php echo $order->product_id ?>" role="button" aria-expanded="false"
                              aria-controls="collapseExample">
                              ดูขนาดสินค้า
                            </a>
                          </p>
                          <div class="collapse" id="collapseExample<?php echo $order->product_id ?>">
                            <div class="d-flex justify-content-center">
                              <div class="text-right ps-4 rounded-left" style="background-color:#222831; color:white;">
                                <p class="me-2">กว้าง : </p>
                                <p class="me-2">ยาว : </p>
                                <p class="me-2">สูง : </p>
                                <p class="me-2 mb-0">เพิ่มเติม : </p>
                              </div>
                              <div class="text-right pe-4 rounded-right" style="background-color:#222831; color:white;">
                                <p>
                                  <?php echo $order->length ?> นิ้ว
                                </p>
                                <p>
                                  <?php echo $order->width ?> นิ้ว
                                </p>
                                <p>
                                  <?php echo $order->height ?> นิ้ว
                                </p>
                                <p class="mb-0">
                                  <?php echo $order->other ?>
                                </p>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td>
                          <?php echo $order->quantity; ?>
                        </td>
                      </tr>
                      <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-body">
              <form method="POST">
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="text" name="paytotal" class="form-control" placeholder="ราคาสินค้าทั้งหมด" required>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="add_paytotal" value="ทำใบเสนอราคา" class="btn btn-success">
                    <input type="button" data-toggle="modal" data-target="#exampleModal" value="ยกเลิกคำสั่งซื้อนี้"
                      class="btn btn-danger">
                  </div>
                </div>
              </form>
              <form method="post">
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ยกเลิกคำสั่งซื้อ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        ต้องการยกเลิกคำสั่งซื้อนี้หรือไม่?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" name="cancel">ยืนยัน</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>