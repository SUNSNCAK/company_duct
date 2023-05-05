<!-- register system -->
<?php
    require_once('config/connection.php');
    if (isset($_POST['register'])) {
      $ran_id = rand(time(), 100000000);
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $repass = $_POST['re-password'];
      $number = $_POST['number'];
      $urole = 'user';

      if (empty($name)) {
        echo "<script>";
        echo "Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'กรุณากรอกชื่อของคุณ',
        showConfirmButton: false,
        timer: 1500
        })";
        echo "</script>";
        header("Refresh:2; url=home.php");
      } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>";
        echo "Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'รูปแบบอีเมลไม่ถูกต้อง',
        showConfirmButton: false,
        timer: 1500
        })";
        echo "</script>";
        header("Refresh:2; url=home.php");
      } else if (empty($password)) {
        echo "<script>";
        echo "Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'กรุณากรอกรหัสผ่าน',
        showConfirmButton: false,
        timer: 1500
        })";
        echo "</script>";
        header("Refresh:2; url=home.php");
      } else if ($repass != $password) {
        echo "<script>";
        echo "Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'ยืนยันรหัสผ่านไม่เหมือนรหัสผ่าน',
        showConfirmButton: false,
        timer: 1500
        })";
        echo "</script>";
        header("Refresh:2; url=home.php");
      } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
        echo "<script>";
        echo "Swal.fire({
        position: 'center',
        icon: 'warning',
        title: 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร',
        showConfirmButton: false,
        timer: 1500
        })";
        echo "</script>";
        header("Refresh:2; url=home.php");
      } else if (empty($number)) {
        echo "<script>";
        echo "Swal.fire({
        position: 'center',
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
        position: 'center',
        icon: 'warning',
        title: 'ความยาวของเบอร์ต้องอยู่ระหว่าง 4 ถึง 15 ตัวอักษร',
        showConfirmButton: false,
        timer: 1500
        })";
        echo "</script>";
        header("Refresh:2; url=home.php");
      } else {
        try{
              $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
              $check_email->bindParam(":email", $email);
              $check_email->execute();
              $row = $check_email->fetch(PDO::FETCH_ASSOC);

              if ($row['email'] == $email) {
                echo "<script>";
                echo "Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'มีอีเมลนี้อยู่ในระบบแล้ว',
                showConfirmButton: false,
                timer: 1500
                })";
                echo "</script>";
                header("Refresh:2; url=home.php");
              } else if (!isset($_SESSION['error'])) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users(unique_id,name, email, password, number, urole) 
                VALUES (:unique_id,:name,:email,:password,:number,:urole)");
                $stmt->bindParam(':unique_id', $ran_id, PDO::PARAM_STR);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
                $stmt->bindParam(':number', $number, PDO::PARAM_STR);
                $stmt->bindParam(':urole', $urole, PDO::PARAM_STR);
                $result = $stmt->execute();
                echo "<script>";
                echo "Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'สมัครสมาชิกเรียบร้อยแล้ว!',
                showConfirmButton: false,
                timer: 1500
                })";
                echo "</script>";
                header("Refresh:2; url=home.php");
              }else {
                echo "<script>";
                echo "Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'มีบางอย่างผิดพลาด',
                showConfirmButton: false,
                timer: 1500
                })";
                echo "</script>";
                header("Refresh:2; url=home.php");
              }
        } catch (PDOException $e) {
          echo $e->getMessage();
        }
      }
    }
    ?>

    <!-- Login System -->
    <?php 

      require_once 'config/connection.php';

    if (isset($_POST['signin'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email)) {
            echo "<script>";
            echo "Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'กรุณากรอกอีเมล',
            showConfirmButton: false,
            timer: 1500
            })";
            echo "</script>";
            header("Refresh:2; url=home.php");
        } else if (empty($password)) {
            echo "<script>";
            echo "Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'กรุณากรอกรหัสผ่าน',
            showConfirmButton: false,
            timer: 1500
            })";
            echo "</script>";
            header("Refresh:2; url=home.php");
        } else {
            try{
                $check_data = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $check_data->bindParam(":email", $email);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                if ($check_data->rowCount() > 0) {

                    if ($email == $row['email']) {
                        if (password_verify($password, $row['password'])) {
                            if ($row['urole'] == 'admin') {
                                $_SESSION['admin_login'] = $row['user_id'];
                                header("location: admin/dashboard.php");
                            } else {
                                $_SESSION['user_login'] = $row['user_id'];
                                $_SESSION['unique_id'] = $row['unique_id'];
                                echo "<script>";
                                echo "Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'เข้าสู่ระบบสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                                })";
                                echo "</script>";
                                header("Refresh:2; url=home.php");
                            }
                        } else {
                            echo "<script>";
                            echo "Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'รหัสผ่านผิด',
                            showConfirmButton: false,
                            timer: 1500
                            })";
                            echo "</script>";
                            header("Refresh:2; url=home.php");
                        }
                    } else {
                        echo "<script>";
                        echo "Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'อีเมลผิด',
                        showConfirmButton: false,
                        timer: 1500
                        })";
                        echo "</script>";
                        header("Refresh:2; url=home.php");
                    }
                } else {
                    echo "<script>";
                    echo "Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'ไม่มีข้อมูลในระบบ',
                    showConfirmButton: false,
                    timer: 1500
                    })";
                    echo "</script>";
                    header("Refresh:2; url=home.php");
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>