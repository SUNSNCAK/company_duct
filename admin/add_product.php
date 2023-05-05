<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['addProduct'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["product_code"]) || empty($_POST["product_name"]) || empty($_POST['product_desc']) || empty($_POST['product_qty'])) {
    $err = "กรอกข้อมูลไม่ครบถ้วน";
  } else {
    $product_code  = $_POST['product_code'];
    $product_name = $_POST['product_name'];
    $product_img = $_FILES['product_img']['name'];
    move_uploaded_file($_FILES["product_img"]["tmp_name"], "assets/img/products/" . $_FILES["product_img"]["name"]);
    $product_desc = $_POST['product_desc'];
    $product_qty = $_POST['product_qty'];
    //Insert Captured information to a database table
    $postQuery = "INSERT INTO product (product_code, product_name, product_img, product_desc, product_qty ) VALUES(?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('sssss', $product_code, $product_name, $product_img, $product_desc, $product_qty);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "เพิ่มสินค้าเรียบร้อย" && header("refresh:1; url=add_product.php");
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
                    <input type="text" name="product_name" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>รหัสสินค้า</label>
                    <input type="text" name="product_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>ภาพสินค้า</label>
                    <input type="file" name="product_img" class="btn btn-outline-success form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>จำนวนสินค้า/ชิ้น</label>
                    <input type="number" min="1" name="product_qty" class="form-control" value="">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-12">
                    <label>รายละเอียดสินค้า</label>
                    <textarea rows="5" name="product_desc" class="form-control" value=""></textarea>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="addProduct" value="เพิ่มสินค้า" class="btn btn-success" value="">
                  </div>
                </div>
              </form>
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