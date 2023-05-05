<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_POST['add_filetax'])) {
    $order_id = $_GET['order_id'];
    $numrand = (mt_rand());
    $date = date("Ymd");
    $paytotal = strrchr($_FILES['tax_invoice']['name'],".");
    $newname = $date.$numrand.$paytotal;
    move_uploaded_file($_FILES["tax_invoice"]["tmp_name"], "assets/fileorder/" . $newname);
    $sql = "UPDATE orders SET tax_invoice = (?) WHERE order_id = $order_id";
    $stmt = $mysqli->prepare($sql);
    $rc = $stmt->bind_param('s',$newname);
    $stmt->execute();
    if ($stmt) { ?>
        <script>window.location="taxinvoice.php";</script> <?php
    } else { ?>
        <script>window.location="import_tax.php";</script> <?php
    }
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
              <h3>แนบใบกำกับภาษี</h3>
            </div>
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="file" name="tax_invoice" class="form-control form-control-lg" required>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="add_filetax" value="ส่งใบกำกับภาษี" class="btn btn-success">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>