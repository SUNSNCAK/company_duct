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
              ตรวจสอบคำสั่งซื้อ เพื่อทำใบเสนอราคา
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col"><b>รหัสคำสั่งซื้อ</b></th>
                    <th scope="col"><b>ที่อยู่คำสั่งซื้อ</b></th>
                    <th scope="col"><b>วันที่ติดตั้ง</b></th>
                    <th scope="col"><b>งวด</b></th>
                    <th scope="col"><b>สถานะ</b></th>
                    <th scope="col"><b>Action</b></th>
                  </tr>
                </thead><!-- For more projects: Visit codeastro.com  -->
                <tbody>
                  <?php
                  $ret = "SELECT * FROM  orders WHERE file_admin = '' and pay_status != 'ยกเลิกคำสั่งซื้อ' and pay_status != 'ชำระเรียบร้อย' order by setup_date";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) { 
                    $mydate = date('Y-m-d' , strtotime($prod->setup_date));
                    $year = date('Y' , strtotime($prod->setup_date));
                    $yearbuddhist = $year + 543;
                    $test = $prod->order_id;
                    $sql1 = "SELECT * FROM product natural join orders_item where order_id = $test";
                    $stmt2 = $mysqli->prepare($sql1);
                    $stmt2->execute();
                    $res2 = $stmt2->get_result();
                  ?>
                    <tr>
                      <td><?php echo $prod->order_id; ?></td>
                      <td><a style="cursor:pointer; color:royalblue;" data-toggle="modal" data-target=#myModal<?php echo $prod->order_id; ?>>ดูที่อยู่ที่ติดตั้ง</a>
                        <div class="modal fade" id=myModal<?php echo $prod->order_id; ?> role="dialog">
                          <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5>ที่อยู่คำสั่งซื้อ</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                <p>แขวง/ตำบล : <?php echo $prod->sub_district; ?> เขต/อำเภอ : <?php echo $prod->district; ?></p>
                                <p>จังหวัด : <?php echo $prod->province; ?></p>
                                <p>รหัสไปรษณีย์ : <?php echo $prod->postcode; ?></p>
                                <p>รายละเอียดที่อยู่ : <?php echo $prod->details; ?></p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">ปิด</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td><?php echo date('d/m/', strtotime($mydate)).$yearbuddhist; ?></td>
                      <td><?php echo $prod->pay_qty; ?></td>
                      <td>
                        <?php if($prod->pay_status == 'ชำระเรียบร้อย') { ?>
                          <span class="badge badge-pill badge-success"><?php echo $prod->pay_status; ?></span>
                        <?php } else if($prod->pay_status == 'ยกเลิกคำสั่งซื้อ') { ?>
                          <span class="badge badge-pill badge-danger"><?php echo $prod->pay_status; ?></span>
                        <?php } else { ?>
                          <span class="badge badge-pill badge-info"><?php echo $prod->pay_status; ?></span>
                        <?php } ?>
                      </td>
                      <td>
                        <button type="submit" class="btn btn-sm btn-warning" onclick = "location.href='checkproduct.php?order_id=<?php echo $prod->order_id; ?>'"><i class="fa fa-book"></i>ใบเสนอราคา</button>
                        <button type="submit" class="btn btn-sm btn-success" onclick = "location.href='import_orders.php?order_id=<?php echo $prod->order_id; ?>'"><i class="fa fa-check-circle"></i>แนบคำสั่งซื้อ</button>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card shadow mt-5">
            <div class="card-header border-0">
              ตรวจสอบค่ามัดจำ
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col"><b>รหัสคำสั่งซื้อ</b></th>
                    <th scope="col"><b>วันที่ติดตั้ง</b></th>
                    <th scope="col"><b>งวด</b></th>
                    <th scope="col"><b>สถานะ</b></th>
                    <th scope="col"><b>Action</b></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM  orders WHERE file_user != '' AND pay_status != 'ยืนยันมัดจำ' AND pay_status != 'ชำระเรียบร้อย' AND pay_status != 'ยกเลิกคำสั่งซื้อ' order by setup_date";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) { 
                    $mydate = date('Y-m-d' , strtotime($prod->setup_date));
                    $year = date('Y' , strtotime($prod->setup_date));
                    $yearbuddhist = $year + 543;
                    $test = $prod->order_id;
                    $sql1 = "SELECT * FROM product natural join orders_item where order_id = $test";
                    $stmt2 = $mysqli->prepare($sql1);
                    $stmt2->execute();
                    $res2 = $stmt2->get_result();
                  ?>
                    <tr>
                      <td><?php echo $prod->order_id; ?></td>
                      <td><?php echo date('d/m/', strtotime($mydate)).$yearbuddhist; ?></td>
                      <td><?php echo $prod->pay_qty; ?></td>
                      <td><?php echo $prod->pay_status; ?></td>
                      <td>
                        <button type="submit" class="btn btn-sm btn-warning" onclick = "location.href='checkinstallment.php?order_id=<?php echo $prod->order_id; ?>'"><i class="fa fa-book"></i>หลักฐานมัดจำ</button>
                      </td>
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
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>
</html>