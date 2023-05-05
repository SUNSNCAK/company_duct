<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if (isset($_POST['add_status'])) {
    $order_id = $_GET['order_id'];
    $status = "ยืนยันมัดจำ";
    $sql = "UPDATE orders SET pay_status = (?) WHERE order_id = $order_id";
    $stmt = $mysqli->prepare($sql);
    $rc = $stmt->bind_param('s',$status);
    $stmt->execute();
    if ($stmt) { ?>
        <script>window.location="orders.php";</script> <?php
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
        <button onclick="location.href='orders.php'" class="btn btn-danger">กลับหน้าคำสั่งซื้อ</button>
        <?php
        $order_id = $_GET['order_id'];
        $ret = "SELECT * FROM orders WHERE order_id = $order_id";
        $stmt1 = $mysqli->prepare($ret);
        $stmt1->execute();
        $res = $stmt1->get_result();
        while ($order = $res->fetch_object()) {
        ?>
        <div class="d-flex justify-content-center">
            <div>
                <img src="assets/img/user_deposit/<?php echo $order->file_user; ?>"alt="slip">
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