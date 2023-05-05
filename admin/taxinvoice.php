<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');
?>

<body>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/backgroundadmin.jpg); background-size: 50% 100%;" class="header  pb-8 pt-5 pt-md-8">
    <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div><!-- For more projects: Visit codeastro.com  -->
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              ทำใบกำกับภาษี
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col"><b>รหัสคำสั่งซื้อ</b></th>
                    <th scope="col"><b>ชื่อบริษัท</b></th>
                    <th scope="col"><b>ชำระ/งวด</b></th>
                    <th scope="col"><b>สถานะ</b></th>
                    <th scope="col"><b>Action</b></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM  orders WHERE pay_status = 'ชำระเรียบร้อย' AND tax_invoice =''";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td><?php echo $prod->order_id; ?></td>
                      <td><?php echo $prod->name; ?></td>
                      <td><?php echo $prod->pay_qty; ?> งวด</td>
                      <td><?php echo $prod->pay_status; ?></td>
                      <td>
                        <button type="submit" class="btn btn-sm btn-warning" onclick = "location.href='make_taxinvoice.php?order_id=<?php echo $prod->order_id; ?>'"><i class="fa fa-book"></i>ใบกำกับภาษี</button>
                        <button type="submit" class="btn btn-sm btn-success" onclick = "location.href='import_tax.php?order_id=<?php echo $prod->order_id; ?>'"><i class="fa fa-check-circle"></i>แนบใบกำกับภาษี</button>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card shadow mt-5">
            <div class="card-header border-0">
              รายการใบกำกับภาษีที่สำเร็จ
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="example">
                <thead class="thead-light">
                  <tr>
                    <th scope="col"><b>รหัสคำสั่งซื้อ</b></th>
                    <th scope="col"><b>ชื่อบริษัท</b></th>
                    <th scope="col"><b>ชำระ/งวด</b></th>
                    <th scope="col"><b>สถานะ</b></th>
                    <th scope="col"><b>ใบกำกับภาษี</b></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM  orders WHERE pay_status = 'ชำระเรียบร้อย' AND tax_invoice !=''";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td><?php echo $prod->order_id; ?></td>
                      <td><?php echo $prod->name; ?></td>
                      <td><?php echo $prod->pay_qty; ?> งวด</td>
                      <td><?php echo $prod->pay_status; ?></td>
                      <td><span class="badge badge-success"><?php echo $prod->tax_invoice; ?></span></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
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