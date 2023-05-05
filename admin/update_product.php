<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['UpdateProduct'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["product_code"]) || empty($_POST["product_name"]) || empty($_POST['product_desc']) || empty($_POST['product_qty'])) {
    $err = "กรอกข้อมูลไม่ครบถ้วน";
  } else {
    $update = $_GET['update'];
    $product_code  = $_POST['product_code'];
    $product_name = $_POST['product_name'];
    $product_img = $_POST['product_img'];
    $product_desc = $_POST['product_desc'];
    $product_qty = $_POST['product_qty'];

    //Insert Captured information to a database table
    $postQuery = "UPDATE product SET product_code =?, product_name =?, product_img =?, product_desc =?, product_qty =? WHERE product_id = ?";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ssssss', $product_code, $product_name, $product_img, $product_desc, $product_qty, $update);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "แก้ไขสินค้าเรียบร้อย" && header("refresh:1; url=products.php");
    } else {
      $err = "เกิดข้อผิดพลาด";
    }
  }
}
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
    $update = $_GET['update'];
    $ret = "SELECT * FROM  product WHERE product_id = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($prod = $res->fetch_object()) {
    ?>
      <!-- Header -->
      <div style="background-image: url(assets/img/theme/backgroundadmin.jpg); background-size: 50% 100%;" class="header  pb-8 pt-5 pt-md-8">
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
                <h3>กรุณากรอกข้อมูลให้ครบทุกช่อง</h3>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>ชื่อสินค้า</label>
                      <input type="text" value="<?php echo $prod->product_name; ?>" name="product_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>รหัสสินค้า</label>
                      <input type="text" name="product_code" value="<?php echo $prod->product_code; ?>" class="form-control" value="">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>ภาพสินค้า</label>
                      <input type="text" name="product_img" class="btn btn-outline-success form-control" value="<?php echo $prod->product_img; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>จำนวนสินค้า/ชิ้น</label>
                      <input type="number" min="1" name="product_qty" class="form-control" value="<?php echo $prod->product_qty; ?>">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-12">
                      <label>รายละเอียดสินค้า</label>
                      <textarea rows="5" name="product_desc" class="form-control" value=""><?php echo $prod->product_desc; ?></textarea>
                    </div>
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="UpdateProduct" value="อัพเดทสินค้า" class="btn btn-success">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php
    }
      ?>
      </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>