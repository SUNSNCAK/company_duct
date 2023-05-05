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
    <div class="container d-flex" style="min-width:400px">
      <div class="menuinfo">
        <h2 class="bi bi-person">บัญชีของฉัน</h2>
        <div style="margin-top:20px;"> <a href="account.php">แก้ไขบัญชี</a></div>
        <div style="margin-top:20px;"><a href="address.php">ที่อยู่</a></div>
        <div style="margin-top:20px;"><a href="password.php">เปลี่ยนรหัสผ่าน</a></div>
      </div>
      <div class="info">
            <?php
                if (isset($_POST['enter'])) {
                    $oldpassword = $_POST['oldpassword'];
                    $newpassword = $_POST['newpassword'];
                    $Confirmnewpassword = $_POST['Confirmnewpassword'];

                    if (empty($oldpassword)) {
                        echo "<script>";
                        echo "Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'กรุณากรอกรหัสผ่านเดิม',
                        showConfirmButton: false,
                        timer: 1500
                        })";
                        echo "</script>";
                        echo "<script>setTimeout(() => { window.location='password.php'; }, 1500);</script>";
                    } else if (empty($newpassword)) {
                        echo "<script>";
                        echo "Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'กรุณากรอกรหัสผ่านใหม่',
                        showConfirmButton: false,
                        timer: 1500
                        })";
                        echo "</script>";
                        echo "<script>setTimeout(() => { window.location='password.php'; }, 1500);</script>";
                    } else if (empty($Confirmnewpassword)) {
                        echo "<script>";
                        echo "Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'กรุณายืนยันรหัสผ่าน',
                        showConfirmButton: false,
                        timer: 1500
                        })";
                        echo "</script>";
                        echo "<script>setTimeout(() => { window.location='password.php'; }, 1500);</script>";
                    } else {
                        try{
                            $iduser = $_SESSION['user_login'];
                            $check_password = $conn->prepare("SELECT password FROM users WHERE user_id = $iduser");
                            $check_password->execute();
                            $row = $check_password->fetch(PDO::FETCH_ASSOC);

                            if (password_verify($oldpassword, $row['password'])) {
                                if ($newpassword == $Confirmnewpassword) {
                                    $passwordHash = password_hash($newpassword, PASSWORD_DEFAULT);
                                    $stmt = $conn->prepare("UPDATE users SET password='$passwordHash'
                                    WHERE user_id = $iduser");
                                    $stmt->bindParam(":password", $passwordHash);
                                    $stmt->execute();
                                    echo "<script>";
                                    echo "Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
                                    showConfirmButton: false,
                                    timer: 1500
                                    })";
                                    echo "</script>";
                                    echo "<script>setTimeout(() => { window.location='password.php'; }, 1500);</script>";
                                } else {
                                    echo "<script>";
                                    echo "Swal.fire({
                                    position: 'top-end',
                                    icon: 'warning',
                                    title: 'รหัสผ่านไม่ตรงกัน',
                                    showConfirmButton: false,
                                    timer: 1500
                                    })";
                                    echo "</script>";
                                    echo "<script>setTimeout(() => { window.location='password.php'; }, 1500);</script>";
                                }
                            } else {
                                echo "<script>";
                                echo "Swal.fire({
                                position: 'top-end',
                                icon: 'warning',
                                title: 'รหัสผ่านปัจจุบันไม่ถูกต้อง',
                                showConfirmButton: false,
                                timer: 1500
                                })";
                                echo "</script>";
                                echo "<script>setTimeout(() => { window.location='password.php'; }, 1500);</script>";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    }
                }
            ?>
                  <div>
                      <form action="" method="post">
                          <div class="editcenter">
                          <a>รหัสผ่านปัจจุบัน :&nbsp;</a>
                              <input name="oldpassword" type="password" class="box"></input>
                          </div>
                          <div class="editcenter">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a>รหัสผ่านใหม่ :&nbsp;</a>
                              <input name="newpassword" type="password" class="box"></input>
                          </div>
                          <div class="editcenter">
                                &nbsp;<a>ยืนยันรหัสผ่าน :&nbsp;</a>
                              <input name="Confirmnewpassword" type="password" class="box"></input>
                          </div>
                          <div class="editcenter">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="enter" class="btnn"><i class="bi bi-pencil-square"></i>ยืนยัน</button>
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