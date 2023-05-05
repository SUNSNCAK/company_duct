<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_POST['add_status'])) {
    $id = $_GET['id'];
    $status = "ชำระเรียบร้อย";
    $sql = "UPDATE installment SET pay_status = (?) WHERE id = $id";
    $stmt = $mysqli->prepare($sql);
    $rc = $stmt->bind_param('s',$status);
    $stmt->execute();
    if ($stmt) { ?>
        <script>window.location="installment.php";</script> <?php
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
<body class="mt-3">
    <div class="container">
        <button onclick="location.href='installment.php'" class="btn btn-danger">กลับหน้าผ่อนชำระ</button>
        <?php
        $id = $_GET['id'];
        $ret = "SELECT * FROM installment WHERE id = $id";
        $stmt1 = $mysqli->prepare($ret);
        $stmt1->execute();
        $res = $stmt1->get_result();
        while ($order = $res->fetch_object()) {
        ?>
        <div class="d-flex justify-content-center">
            <div>
                <img src="assets/img/installment/<?php echo $order->file_user; ?>"alt="slip">
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-md-offset-3 my-4">
                <form method="post">
                <button name="add_status" class="btn btn-success btn-lg text-center btn-block">
                    ยืนยัน <span class="fa fa-check-circle"></span>
                </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php } ?>