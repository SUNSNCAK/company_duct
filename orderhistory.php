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
  <div style="height:200px;"></div>
  <div class="container">
    <?php
    $iduser = $_SESSION['user_login'];
    $sql = "SELECT * FROM orders WHERE user_id = $iduser";
    $result = $connect->query($sql);
    if ($connect->error || $result->num_rows == 0) {
      echo '<h4 class="text-center text-danger">ยังไม่มีการสั่งซื้อ</h4>';
      $connect->close();
    } else {
    foreach ($conn->query("SELECT * FROM orders WHERE user_id = $iduser ORDER BY order_id DESC") as $rows1)
      {
        $orderid = $rows1['order_id'];
        $mydate = date('Y-m-d' , strtotime($rows1['order_date']));
        $year = date('Y' , strtotime($rows1['order_date']));
        $yearbuddhist = $year + 543;
        $paytotal = $rows1['paytotal'];
        $status = $rows1['pay_status'];
        $tax = $rows1['tax_invoice'];
        $address_name = $rows1['name'];
        $number = $rows1['number'];
        $sub_district = $rows1['sub_district'];
        $district = $rows1['district'];
        $province = $rows1['province'];
        $postcode = $rows1['postcode'];
    ?>
      <div class="card text-start mb-5" style="max-width:100%;">
      <?php if ($status == 'ชำระเรียบร้อย') { ?>
        <div class="card-header bg-success text-light bg-opacity-75">
      <?php } else if ($status == 'ยกเลิกคำสั่งซื้อ') { ?>
        <div class="card-header bg-danger text-light bg-opacity-75">
      <?php } else { ?>
        <div class="card-header">
      <?php } ?>
          <div class="d-flex">
            <a>หมายเลขคำสั่งซื้อที่ : <?php echo $orderid; ?></a>
            <div class="flex-fill"></div>
            <a><?php echo $status; ?></a>
          </div>
        </div>
        <div class="mt-2 mx-3 py-2 bg-secondary p-2 text-dark bg-opacity-25 rounded">
          <span class="m-2"><?php echo $address_name." | ".$number." ต. ".$sub_district." อ.".$district." จ.".$province." ".$postcode; ?></span>
        </div>
        <div class="card-body">
            <h6 class="card-title">วันที่ : <?php echo date('d/m/', strtotime($mydate)).$yearbuddhist; ?></h6>
          <?php
            $sql1 = "SELECT * FROM product natural join orders_item where order_id = $orderid";
            $stmt1 = $connect->prepare($sql1);
            $stmt1->execute();
            $res1 = $stmt1->get_result();
            ?>
          <div class="table-responsive">
            <table class="table">
              <tbody>
              <?php while ($order1 = $res1->fetch_object()) { ?>
                <tr>
                  <td><img src="admin/assets/img/products/<?php echo $order1->product_img; ?>" style="width: 64px; height: 64px; border-radius:5px;"></td>
                  <td><?php echo $order1->product_name; ?></td>
                  <td>x <?php echo $order1->quantity; ?></td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <p class="card-text text-end">ยอดคำสั่งซื้อทั้งหมด : <?php if ($paytotal == null || $paytotal == "") { ?>
           <span>-</span> <?php } else { echo number_format($paytotal,2); } ?> บาท</p>
          <?php
          if ($tax == '') { ?>

          <?php } else { ?>
          <a href="download.php?path=<?php echo $tax; ?>" title="Download File" target="_blank" class="btnn text-light"><i class="bi bi-file-earmark-arrow-down"></i> ดาวน์โหลดใบกำกับภาษี</a>
          <?php } ?>
        </div>
      </div>
      <?php
        }
      }
      ?>
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