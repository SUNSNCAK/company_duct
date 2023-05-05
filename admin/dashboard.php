<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
require_once('partials/_analytics.php');
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
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">ลูกค้า</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $customers; ?></span>
                    </div><!-- For more projects: Visit codeastro.com  -->
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<!-- For more projects: Visit codeastro.com  -->
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">สินค้า</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $products; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                        <i class="fas fa-shopping-bag"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">คำสั่งซื้อ</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $orders; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-file-alt"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">ราคาสินค้าทุกคำสั่งซื้อ</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $sales; ?> ฿</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                        <i class="fas fa-wallet"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row mt-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">คำสั่งซื้อทั้งหมด</h3>
                </div>
                <div class="col text-right">
                  <a href="orders.php" class="btn btn-sm btn-primary">ดูทั้งหมด</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-success" scope="col"><b>รหัสคำสั่งซื้อ</b></th>
                    <th scope="col"><b>บริษัท</b></th>
                    <th class="text-success" scope="col"><b>ชำระ/งวด</b></th>
                    <th scope="col"><b>ราคาสินค้า</b></th>
                    <th class="text-success" scope="col"><b>สถานะ</b></th>
                    <th scope="col"><b>วันที่</b></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM  orders ORDER BY order_date DESC LIMIT 7 ";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($order = $res->fetch_object()) {
                    $mydate = date('Y-m-d' , strtotime($order->order_date));
                    $year = date('Y' , strtotime($order->order_date));
                    $yearbuddhist = $year + 543;

                  ?>
                    <tr>
                      <th class="text-success" scope="row"><?php echo $order->order_id; ?></th>
                      <td><?php echo $order->name; ?></td>
                      <td class="text-success"><?php echo $order->pay_qty; ?></td>
                      <td><?php echo $order->paytotal; ?></td>
                      <td>
                        <?php if($order->pay_status == 'ชำระเรียบร้อย') { ?>
                          <span class="badge badge-pill badge-success"><?php echo $order->pay_status; ?></span>
                        <?php } else if($order->pay_status == 'ยกเลิกคำสั่งซื้อ') { ?>
                          <span class="badge badge-pill badge-danger"><?php echo $order->pay_status; ?></span>
                        <?php } else { ?>
                          <span class="badge badge-pill badge-info"><?php echo $order->pay_status; ?></span>
                        <?php } ?>
                      </td>
                      <td><?php echo date('d/m/', strtotime($mydate)).$yearbuddhist; ?></td>
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