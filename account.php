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
      require_once('navbar.php');
    ?>
    <div style="height:250px;"></div>
    <div class="container d-flex">
      <div class="menuinfo">
        <h2 class="bi bi-person">บัญชีของฉัน</h2>
        <div style="margin-top:20px;"> <a href="account.php">แก้ไขบัญชี</a></div>
        <div style="margin-top:20px;"><a href="address.php">ที่อยู่</a></div>
        <div style="margin-top:20px;"><a href="password.php">เปลี่ยนรหัสผ่าน</a></div>
      </div>
      <div class="info">
            <?php
                if(isset($_POST['update'])){
                $username=$_POST['name'];
                $email=$_POST['email'];
                $number=$_POST['number'];
                $stmt = $conn->query("UPDATE users SET number='$number'
                WHERE user_id = $iduser");
                echo "<script>";
                echo "Swal.fire({
                  icon: 'success',
                  title: 'สำเร็จ',
                  text: 'บันทึกข้อมูลเรียบร้อยแล้ว!',
                })";
                echo "</script>";
                $stmt = $conn->query("SELECT * FROM users WHERE user_id = $iduser");
                $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            ?>
                  <div>
                      <form action="" method="post">
                          <div class="editcenter">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>ชื่อ :&nbsp;</a>
                              <input id="name" name="name" type="text" class="box" value="<?php echo $username?>" readonly>
                          </div>
                          <div class="editcenter">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>อีเมล :&nbsp;</a>
                              <input name="email" type="email" class="box" value="<?php echo $email?>" readonly>
                          </div>
                          <div class="editcenter">
                              <a>เบอร์โทรศัพท์ :&nbsp;</a>
                              <input name="number" id="phone" type="tel" class="box" value="<?php echo $number?>" pattern="[0-9]{10}" required>
                          </div>
                          <div class="editcenter">
                              <button type="submit" name="update" class="btnn"><i class="bi bi-pencil-square"></i>บันทึกข้อมูล</button>
                          </div>
                      </form>
                  </div>
        </div>
    </div>
    <div style="height:250px;"></div>
    <?php
      require_once('footer.php');
    ?>
    <?php
    if (isset($_SESSION['user_login'])) {
      require_once('chat-box.php');
    }
    ?>
    <script src="dropdown.js"></script>
    <script src="chat.js"></script>
</body>
</html>