<?php
session_start();
require_once 'config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="duct.css">
  <link rel="icon" type="image/jpg" href="admin/assets/img/icons/favicon-32x32.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript"
    src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
  <script type="text/javascript"
    src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
  <link rel="stylesheet"
    href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
  <script type="text/javascript"
    src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
    crossorigin="anonymous"></script>
  <title>Address</title>
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100;300;400;500;600&display=swap');

    body {
      font-family: 'Noto Sans Thai', sans-serif;
    }

    .btn {
      border: none;
      color: #EEEEEE;
    }

    a {
      text-decoration: none;
    }
  </style>
  <script>
    $(function () {
      $('button.delete').click(function () {
        if (confirm('ยืนยันการลบที่อยู่')) {
          var del_id = $(this).attr('data-id');
          $('#delete-id').val(del_id);
          $('#form-delete').submit();
        }
      });
    });
  </script>
</head>

<body>
  <?php
  require_once('navbar.php');
  ?>
  <?php
  require_once('config/connection.php');
  if (isset($_POST['add'])) {
    $iduser = $_SESSION['user_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE user_id = $iduser");
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = $_POST['name'];
    $number = $_POST['number'];
    $sub_district = $_POST['sub_district'];
    $district = $_POST['district'];
    $province = $_POST['province'];
    $postcode = $_POST['postcode'];
    $details = $_POST['details'];
    $iduser = $rows['user_id'];
    if (empty($name)) {
      echo "<script>";
      echo "Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: 'กรุณากรอกชื่อที่อยู่',
          showConfirmButton: false,
          timer: 1500
          })";
      echo "</script>";
      header("Refresh:2; url=address.php");
    } else if (empty($number)) {
      echo "<script>";
      echo "Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: 'กรุณากรอกเบอร์โทรศัพท์',
          showConfirmButton: false,
          timer: 1500
          })";
      echo "</script>";
      header("Refresh:2; url=home.php");
    } else if (strlen($_POST['number']) > 15 || strlen($_POST['number']) < 4) {
      echo "<script>";
      echo "Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: 'ความยาวของเบอร์ต้องอยู่ระหว่าง 4 ถึง 15 ตัวอักษร',
          showConfirmButton: false,
          timer: 1500
          })";
      echo "</script>";
      header("Refresh:2; url=address.php");
    } else if (empty($sub_district)) {
      echo "<script>";
      echo "Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: 'กรุณากรอกที่อยู่ตำบล',
          showConfirmButton: false,
          timer: 1500
          })";
      echo "</script>";
      header("Refresh:2; url=address.php");
    } else if (empty($district)) {
      echo "<script>";
      echo "Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: 'กรุณากรอกที่อยู่อำเภอ',
          showConfirmButton: false,
          timer: 1500
          })";
      echo "</script>";
      header("Refresh:2; url=address.php");
    } else if (empty($province)) {
      echo "<script>";
      echo "Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: 'กรุณากรอกที่อยู่จังหวัด',
          showConfirmButton: false,
          timer: 1500
          })";
      echo "</script>";
      header("Refresh:2; url=address.php");
    } else if (empty($postcode)) {
      echo "<script>";
      echo "Swal.fire({
          position: 'top-end',
          icon: 'warning',
          title: 'กรุณากรอกรหัสไปรษณีย์',
          showConfirmButton: false,
          timer: 1500
          })";
      echo "</script>";
      header("Refresh:2; url=address.php");
    } else {
      try {
        $stmt = $conn->prepare("INSERT INTO address(address_id,name, number, sub_district, district, province, postcode, details,user_id) 
                  VALUES (null,:name,:number,:sub_district,:district,:province,:postcode,:details,:user_id)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':number', $number, PDO::PARAM_STR);
        $stmt->bindParam(':sub_district', $sub_district, PDO::PARAM_STR);
        $stmt->bindParam(':district', $district, PDO::PARAM_STR);
        $stmt->bindParam(':province', $province, PDO::PARAM_STR);
        $stmt->bindParam(':postcode', $postcode, PDO::PARAM_STR);
        $stmt->bindParam(':details', $details, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $iduser, PDO::PARAM_STR);
        $result = $stmt->execute();
        echo "<script>";
        echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'เพิ่มข้อมูลที่อยู่เรียบร้อย!',
                  showConfirmButton: false,
                  timer: 1500
                  })";
        echo "</script>";
      } catch (PDOException $e) {
        echo $e->getMessage();
      }
    }
  }
  if (isset($_POST['editaddress'])) {
    $iduser = $_SESSION['user_login'];
    $stmt = $conn->query("SELECT * FROM `company_duct`.`address` WHERE `user_id` = $iduser");
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $_POST['name'];
    $number = $_POST['number'];
    $sub_district = $_POST['sub_district'];
    $district = $_POST['district'];
    $province = $_POST['province'];
    $postcode = $_POST['postcode'];
    $details = $_POST['details'];
    $iduser = $rows['user_id'];
    $address_id = $rows['address_id'];
    $stmt1 = $conn->query("UPDATE address SET name='$name', number='$number', sub_district='$sub_district', district='$district', province='$province', postcode='$postcode', details='$details', user_id='$iduser'
                WHERE address_id = $address_id");
    echo "<script>";
    echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'บันทึกข้อมูลเรียบร้อยแล้ว!',
                  timer: 1500
                })";
    echo "</script>";
  }
  if (isset($_POST['delete_id'])) {
    $iduser = $_SESSION['user_login'];
    $aid = $_POST['delete_id'];
    $sql = "DELETE FROM address WHERE user_id = $iduser AND address_id = $aid";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$aid]);
  }
  ?>
  <div class="address-form-container">
    <form action="address.php" method="post" class="address-form">
      <h3>ที่อยู่ใหม่</h3>
      <div style="display:flex; gap:1em;">
        <input type="text" id="name" name="name" placeholder="ชื่อบริษัท" class="box">
        <input type="tel" id="phone" name="number" placeholder="โทรศัพท์" class="box" pattern="[0-9]{10}" required>
      </div>
      <input type="text" id="sub_district" name="sub_district" class="box" placeholder="แขวง/ตำบล">
      <input type="text" id="district" name="district" class="box" placeholder="เขต/อำเภอ">
      <input type="text" id="province" name="province" class="box" placeholder="จังหวัด">
      <input type="text" id="postcode" name="postcode" class="box" placeholder="รหัสไปรษณีย์">
      <input type="text" style="padding-top:1rem; padding-left:1.2rem; padding-right:1.2rem; padding-bottom:3rem;"
        id="details" name="details" class="box" placeholder="รายละเอียดที่อยู่">
      <div style="display:flex; gap:1em; float:right;">
        <input type="button" value="ยกเลิก" id="close-address-form" class="btnn">
        <input type="submit" value="ยืนยัน" name="add" class="btnn">
      </div>
    </form>
  </div>
  <script>
    $.Thailand({
      $district: $("#sub_district"), // input ของตำบล
      $amphoe: $("#district"), // input ของอำเภอ
      $province: $("#province"), // input ของจังหวัด
      $zipcode: $("#postcode") // input ของรหัสไปรษณีย์
    });
  </script>
  <div style="height:250px;"></div>
  <div class="container d-flex" style="min-width:350px">
    <div class="menuinfo">
      <h2 class="bi bi-person">บัญชีของฉัน</h2>
      <div style="margin-top:20px;"> <a href="account.php">แก้ไขบัญชี</a></div>
      <div style="margin-top:20px;"><a href="address.php">ที่อยู่</a></div>
      <div style="margin-top:20px;"><a href="password.php">เปลี่ยนรหัสผ่าน</a></div>
    </div>
    <div class="info">
      <div class="contentheader">
        <div style="font-size: 1.2rem; flex: 1 1 0%;">ที่อยู่การติดตั้ง</div>
        <button class="showbtn" id="toaddress"><i class="bi bi-plus-lg"></i> เพิ่มที่อยู่</button>
      </div>
      <div style="font-size: 1.2rem;">ที่อยู่</div>
      <?php
      $iduser = $_SESSION['user_login'];
      foreach ($conn->query("SELECT * FROM address WHERE user_id = $iduser") as $rows1) {
        $addressname = $rows1['name'];
        $addressnumber = $rows1['number'];
        $addresssub = $rows1['sub_district'];
        $addressdistrict = $rows1['district'];
        $addressprovince = $rows1['province'];
        $addresspostcode = $rows1['postcode'];
        $addressdetails = $rows1['details'];
        $address_id = $rows1['address_id'];
        ?>
        <div class="infoaddress">
          <div>
            <div class="infoaddress1">
              <div>
                <?php echo $addressname ?>
              </div>
              <div style="border-left: 0.5px solid rgba(0,0,0,.50); margin:0px 8px"></div>
              <div style="flex: 1 1 0%;">
                <?php echo $addressnumber ?>
              </div>
              <div style="display:flex;">
                <button class="infoedit" data-bs-toggle="modal" data-bs-target=#Modal<?php echo $address_id ?>
                  data-bs-whatever=<?php echo $address_id ?>>แก้ไข</button>
                <button class="infoedit delete" data-id=<?php echo $address_id ?>>ลบ</button>
              </div>
            </div>
            <div>
              <span>
                <?php echo $addressdetails ?>
              </span>
              <span>ตำบล
                <?php echo $addresssub ?>
              </span>
            </div>
            <div>
              <span>อำเภอ
                <?php echo $addressdistrict ?>
              </span>
              <span> , จังหวัด
                <?php echo $addressprovince ?>
              </span>
              <span> ,
                <?php echo $addresspostcode ?>
              </span>
            </div>
          </div>
        </div>
        <div class="modal fade" id=Modal<?php echo $address_id ?> tabindex="-1" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไขที่อยู่</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="address.php" method="post" class="edit-form">
                  <div class="row">
                    <div class="col">
                      <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อบริษัท"
                        value="<?php echo $addressname ?>">
                    </div>
                    <div class="col">
                      <input type="tel" id="phone" name="number" value="<?php echo $addressnumber ?>"
                        placeholder="โทรศัพท์" class="form-control" pattern="[0-9]{10}" required>
                    </div>
                  </div>
                  <input type="text" id="sub_district" name="sub_district" class="form-control mt-3"
                    value="<?php echo $addresssub ?>" placeholder="แขวง/ตำบล">
                  <input type="text" id="district" name="district" class="form-control mt-3"
                    value="<?php echo $addressdistrict ?>" placeholder="เขต/อำเภอ">
                  <input type="text" id="province" name="province" class="form-control mt-3"
                    value="<?php echo $addressprovince ?>" placeholder="จังหวัด">
                  <input type="text" id="postcode" name="postcode" class="form-control mt-3"
                    value="<?php echo $addresspostcode ?>" placeholder="รหัสไปรษณีย์">
                  <input type="text"
                    style="padding-top:1rem; padding-left:1.2rem; padding-right:1.2rem; padding-bottom:3rem;" id="details"
                    name="details" class="form-control my-3" value="<?php echo $addressdetails ?>"
                    placeholder="รายละเอียดที่อยู่">
                  <div class="modal-footer">
                    <input type="button" value="ยกเลิก" class="btnn" data-bs-dismiss="modal">
                    <input type="submit" value="ยืนยัน" name="editaddress" class="btnn">
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
  <div style="height:250px;"></div>
  <form id="form-delete" method="post">
    <input type="hidden" name="delete_id" id="delete-id" value="">
  </form>
  <?php
  require_once('footer.php');
  ?>
  <?php
  if (isset($_SESSION['user_login'])) {
    require_once('chat-box.php');
  }
  ?>
  <script>
    document.querySelector('#toaddress').onclick = () => {
      document.querySelector('.address-form-container').classList.toggle('active');
    }
    document.querySelector('#close-address-form').onclick = () => {
      document.querySelector('.address-form-container').classList.remove('active');
    }
    document.querySelector('#toedit').onclick = () => {
      document.querySelector('.edit-form-container').classList.toggle('active');
    }
    document.querySelector('#close-edit-form').onclick = () => {
      document.querySelector('.edit-form-container').classList.remove('active');
    }
  </script>
  <script src="dropdown.js"></script>
  <script src="chat.js"></script>
</body>

</html>