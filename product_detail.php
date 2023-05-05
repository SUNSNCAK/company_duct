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
  <script>
    $(function () {
      $('#add-cart').click(function () {
        var product_id = $(this).attr('data-product_id');
        var product_qty = document.getElementById("quantity").value;
        var product_length = document.getElementById("length").value;
        var product_width = document.getElementById("width").value;
        var product_height = document.getElementById("height").value;
        var product_other = document.getElementById("other").value;
        $.ajax({
          url: 'ajax-add-cart.php',
          data: { 'pro_id': product_id, 'pro_qty': product_qty, 'pro_length': product_length, 'pro_width': product_width, 'pro_height': product_height , 'pro_other': product_other},
          type: 'post',
          dataType: 'html',

          error: (xhr, textStatus) => alert(textStatus),
          success: (result) => {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'เพิ่มสินค้าเรียบร้อยแล้ว',
              showConfirmButton: false,
              timer: 1500
            })
            updateCart();
          }
        });
      });
      $('#add-cart1').click(function () {
        var product_id = $(this).attr('data-product_id');
        var product_qty = document.getElementById("quantity").value;
        var product_length = document.getElementById("length").value;
        var product_width = document.getElementById("width").value;
        var product_height = document.getElementById("height").value;
        var product_other = document.getElementById("other").value;
        $.ajax({
          url: 'ajax-add-cart.php',
          data: { 'pro_id': product_id, 'pro_qty': product_qty, 'pro_length': product_length, 'pro_width': product_width, 'pro_height': product_height , 'pro_other': product_other},
          type: 'post',
          dataType: 'html',

          error: (xhr, textStatus) => alert(textStatus),
          success: (result) => {
            updateCart();
            window.location.href = 'cart.php';
          }
        });
      });
    });
  </script>
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
  <div style="height:120px;"></div>
  <div class="container p-4 mb-5 rounded-4" style="background-color:#eef3f8;">
    <?php
    $product_id = $_GET['product_id'];

    $mysqli = new mysqli('localhost', 'root', '', 'company_duct');
    $sql = "SELECT * FROM product WHERE product_id = $product_id";
    $result = $mysqli->query($sql);

    $p = $result->fetch_object();
    ?>
    <div class="row">
      <div class="col-md-6">
        <img class="rounded-3 img-fluid" width="600" height="500"
          src="admin/assets/img/products/<?php echo $p->product_img ?>" alt="product">
      </div>
      <div class="col-md-6">
        <h2>
          <?php echo $p->product_name ?>
        </h2>
        <p>
          <?php echo $p->product_desc ?>
        </p>
        <p>รหัสสินค้า :
          <?php echo $p->product_code ?>
        </p>
        <div class="d-flex gap-2">
          <div class="number-input">
            <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
              class="bi bi-dash-lg"></button>
            <input class="quantity" id="quantity" data-product_qty="<?php echo $p->product_qty ?>" min="1"
              max="<?php echo $p->product_qty ?>" name="quantity" value="1" type="number" readonly>
            <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()"
              class="bi bi-plus-lg"></button>
          </div>
          <p class="d-flex align-items-center mb-0 text-muted">มีสินค้าทั้งหมด
            <?php echo $p->product_qty ?> ชิ้น
          </p>
        </div>
        <?php
          if (isset($_SESSION['user_login'])) { ?>
        <div class="col-md-8 mt-3 p-4 bg-light rounded-4 whlbg">
          <div class="input-group my-2">
            <input type="number" class="form-control" placeholder="ความกว้าง" name="" id="length" disabled>
            <span class="input-group-text">นิ้ว</span>
            <div class="ms-2">
              <input type="checkbox" id="todisable1" name="todisable">
            </div>
          </div>
          <div class="input-group my-2">
            <input type="number" class="form-control" placeholder="ความยาว" name="" id="width" disabled>
            <span class="input-group-text">นิ้ว</span>
            <div class="ms-2">
              <input type="checkbox" id="todisable2" name="todisable">
            </div>
          </div>
          <div class="input-group my-2">
            <input type="number" class="form-control" placeholder="ความสูง" name="" id="height" disabled>
            <span class="input-group-text">นิ้ว</span>
            <div class="ms-2">
              <input type="checkbox" id="todisable3" name="todisable">
            </div>
          </div>
          <div class="input-group my-2">
            <input type="text" class="form-control" placeholder="อื่นๆ โปรดระบุ" name="" id="other" disabled>
            <div class="ms-2">
              <input type="checkbox" id="todisable4" name="todisable">
            </div>
          </div>
          <span class="text-secondary text-opacity-75" style="font-size: 14px;">กรณีที่ไม่กำหนดขนาดสินค้าจะได้ขนาดตามรายละเอียดของสินค้า</span>
        </div>
        <?php } ?>
        <div class="col-md-8 text-center mt-3">
          <?php
          if (!isset($_SESSION['user_login'])) { ?>
            <p class="float-start text-danger">กรุณาลงชื่อเข้าใช้!</p>
          <?php } else { ?>
            <a id="add-cart" name="add-cart" data-product_id="<?php echo $p->product_id ?>"
              class="btnn bg-transparent border border-dark text-muted"><i class="bi bi-cart-plus"></i>เพิ่มสินค้า</a>
            <a id="add-cart1" name="add-cart1" data-product_id="<?php echo $p->product_id ?>" class="btnn"
              style="color:white;">ขอใบเสนอราคา</a>
          <?php }
          ?>
        </div>
      </div>
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
  <script>
    var checkbox1 = document.getElementById("todisable1");
    var checkbox2 = document.getElementById("todisable2");
    var checkbox3 = document.getElementById("todisable3");
    var checkbox4 = document.getElementById("todisable4");
    var input1 = document.getElementById("length");
    var input2 = document.getElementById("width");
    var input3 = document.getElementById("height");
    var input4 = document.getElementById("other");

    checkbox1.onclick = function () {
      if (checkbox1.checked) {
        input1.disabled = false;
      } else {
        input1.disabled = true;
      }
    };
    checkbox2.onclick = function () {
      if (checkbox2.checked) {
        input2.disabled = false;
      } else {
        input2.disabled = true;
      }
    };
    checkbox3.onclick = function () {
      if (checkbox3.checked) {
        input3.disabled = false;
      } else {
        input3.disabled = true;
      }
    };
    checkbox4.onclick = function () {
      if (checkbox4.checked) {
        input4.disabled = false;
      } else {
        input4.disabled = true;
      }
    };
  </script>
  <script src="dropdown.js"></script>
  <script src="chat.js"></script>
  <script src="script.js"></script>
</body>

</html>