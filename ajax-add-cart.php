<?php
@session_start();
$msg = '';

if (!isset($_SESSION['user_login'])) {
      $msg = 'กรุณาเข้าสู่ระบบ!';
}

if (isset($_POST['pro_id'])) {        
      $iduser = $_SESSION['user_login'];
      $pid = $_POST['pro_id'];
      $pqty = $_POST['pro_qty'];
      $plength = $_POST['pro_length'];
      $pwidth = $_POST['pro_width'];
      $pheight = $_POST['pro_height'];
      $pother = $_POST['pro_other'];

      $mysqli = new mysqli('localhost', 'root', '', 'company_duct');
      $sql = 'REPLACE INTO cart VALUES (?, ?, ?, ?, ?, ?, ?)';
      $stmt = $mysqli->stmt_init();
      $stmt->prepare($sql);
      $stmt->bind_param('iiiddds', ...[$iduser, $pid, $pqty, $plength, $pwidth, $pheight, $pother]);
      $stmt->execute();
      $aff_row = $stmt->affected_rows;
      if ($stmt->error || $aff_row == 0) {
            $msg = 'เกิดข้อผิดพลาดในการหยิบสินค้าใส่รถเข็น';
      } else {
            $msg = 'หยิบสินค้าใส่รถเข็นเรียบร้อยแล้ว';
      }           
}



end:
echo <<<HTML
<div class="alert alert-danger mb-4" role="alert">
      $msg
</div>             
HTML;
?>