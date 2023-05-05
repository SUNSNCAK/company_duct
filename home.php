<?php
  session_start();
  require_once 'config/connection.php';
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
    require_once('user_db.php');
  ?>
  <?php
    require_once('navbar.php');
  ?>
  <?php
    require_once('user_form.php');
  ?>
    <div class="bgcontent">
      <div class="overlay">
        <div class="heading-text">
          <h1>V.K. AIR GROUP 2012 LIMITED PARTNERSHIP</h1>
          <h3>บริการ ติดตั้ง วางระบบและออกแบบ ระบบปรับอากาศ</h3>
          <div class="button-header">
            <button onclick="location.href='#section'" class="bi bi-chevron-double-down dropbtn" style="background-color:#393E46;"> เลือกสินค้า</button>
          </div>
        </div>
      </div>
    </div>
    <div class="py-4" style="background-color:#eef3f8;">
      <div class="container">
        <div class="row align-items-baseline">
          <div class="col-md-3 py-3 text-center rounded-4 menuhov">
            <img src="img/icon/product.png" alt="product">
            <div>เลือกสินค้าพร้อมติดตั้ง</div>
          </div>
          <div class="col-md-3 py-3 text-center rounded-4 menuhov">
            <img src="img/icon/customer.png" alt="customer">
            <div>รับทำและออกแบบตามความต้องการของลูกค้า</div>
          </div>
          <div class="col-md-3 py-3 text-center rounded-4 menuhov">
            <img src="img/icon/pipe.png" alt="pipe">
            <div>อะไหล่พร้อมไว้บริการ</div>
          </div>
          <div class="col-md-3 py-3 text-center rounded-4 menuhov">
            <img src="img/icon/cash.png" alt="cash" style="width:64px; height:64px;">
            <div>ผ่อนชำระได้หลายงวด</div>
          </div>
        </div>
      </div>
    </div>
    <div class="p-5 m-0 border-0 bd-example" id="section">
      <div class="row row-cols-1 row-cols-md-6 g-4">
          <?php
              foreach ($conn->query("SELECT * FROM product WHERE product_id AND product_qty > 0") as $rows1)
              {
            $product_id = $rows1['product_id'];
            $productname = $rows1['product_name'];
            $productimg = $rows1['product_img'];
            $productdesc = $rows1['product_desc'];
          ?>
        <div class="col product">
          <div class="card h-100">
            <img class="bd-placeholder-img card-img-top" width="100%" height="140"src="admin/assets/img/products/<?php echo $productimg?>" alt="pruduct">
            <div class="card-body">
              <h5 class="card-title text-truncate"><?php echo $productname?></h5>
              <p class="card-text text-start text-truncate" style="color:gray;"><?php echo $productdesc?></p>
              <button onclick="location.href='product_detail.php?product_id=<?php echo $product_id; ?>'" class="btnn">เพิ่มเติม</button>
            </div>
          </div>
        </div>
        <?php
          }
        ?>
      </div>
    </div>
    <?php
      require_once('footer.php');
    ?>
    <?php
    if (isset($_SESSION['user_login'])) {
      require_once('chat-box.php');
    }
    ?> 
  <script src="custom.js"></script>
  <script src="dropdown.js"></script>
  <script src="chat.js"></script>
  <script src="script.js"></script>

</body>
</html>