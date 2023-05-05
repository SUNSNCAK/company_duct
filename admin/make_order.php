<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="MartDevelopers Inc">
    <title>V.K. AIR GROUP </title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icons/apple-touch-icon.jpg">
    <link rel="icon" type="image/jpg" sizes="32x32" href="assets/img/icons/favicon-32x32.jpg">
    <link rel="icon" type="image/jpg" sizes="16x16" href="assets/img/icons/favicon-16x16.jpg">
    <link rel="manifest" href="assets/img/icons/site.webmanifest">
    <link rel="mask-icon" href="assets/img/icons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="assets/css/bootstrap.css" rel="stylesheet" id="bootstrap-css">
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/jquery.js"></script>
    <style>
        body {
            margin-top: 20px;
        }
    </style>
    <?php
    $orderid = $_GET['order_id'];
    $ret = "SELECT * FROM  orders WHERE order_id = '$orderid'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($order = $res->fetch_object()) {
        $mydate = date('Y-m-d' , strtotime($order->order_date));
        $year = date('Y' , strtotime($order->order_date));
        $yearbuddhist = $year + 543;
        $vat = 7;
        $totalvat = $vat/100 * $order->paytotal;
        $total = $order->paytotal * (100+$vat)/100;
    ?>
</head>
<body>
        <div class="container">
        <button onclick="location.href='orders.php'" class="btn btn-success">กลับหน้าคำสั่งซื้อ</button>
            <div class="row">
                <div id="Receipt" class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                    <div class="row d-flex">
                        <div class="col-xs-2 col-sm-2 col-md-2 align-items-center">
                            <img src="assets/img/icons/logoduct.jpg" alt="">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <address>
                                ห้างหุ้นส่วนจำกัด วี.เค.แอร์ กรุ๊ป 2012 (สำนักงานใหญ่)
                                <br>
                                2/9 หมู่ที่6 ตำบลหน้าไม้
                                <br>
                                อำเภอลาดหลุมแก้ว จังหวัดปทุมธานี 12140
                                <br>
                                โทร.081-420-2935 02-8012185 e-mail ttc_toey@hotmail.com
                                <br>
                                เลขประจำตัวผู้เสียภาษี 0103556003715
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            <h4>ใบเสนอราคา</h4>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            เรียนถึง บริษัท <?php echo $order->name; ?>
                            <br>
                        </div>
                        <div class="md-6 text-right">
                        <p>
                            <?php echo date('d/m/', strtotime($mydate)).$yearbuddhist; ?>
                        </p>
                        </div>
                        <?php
                        $sql1 = "SELECT * FROM product natural join orders_item where order_id = $orderid";
                        $stmt1 = $mysqli->prepare($sql1);
                        $stmt1->execute();
                        $res1 = $stmt1->get_result();
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>รายการสินค้า</th>
                                    <th>จำนวน</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $count=0;
                            while ($order1 = $res1->fetch_object()) { ?>
                                <tr>
                                    <td class="col-md-10"><em> <?php echo $order1->product_name; ?> </em></h4>
                                    </td>
                                    <td class="col-md-2" style="text-align: center"> <?php echo $order1->quantity; ?></td>
                                    <?php $count++; ?>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    
                                    <td class="text-right">
                                        <p>
                                            <strong>รวมราคา <?php echo $count; ?> รายการ</strong>
                                        </p>
                                        <p>
                                            <strong>VAT 7 % </strong>
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            <strong><?php echo number_format($order->paytotal); ?> บาท</strong>
                                        </p>
                                        <p>
                                            <strong><?php echo number_format($totalvat); ?> บาท</strong>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    
                                    <td class="text-right">
                                        <h5><strong>รวมราคาทั้งสิ้น </strong></h5>
                                    </td>
                                    <td>
                                        <h5><strong><?php echo number_format($total); ?> บาท</strong></h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                        $percent = 20;
                        $percent1 = $percent/100 * $total;
                        $deposit = $total - $percent1;
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ค่ามัดจำ 20 %</th>
                                    <th><?php echo number_format($percent1); ?> บาท</th>
                                </tr>
                            </thead>
                            
                        </table>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <h4>ตารางการผ่อนชำระ</h4>
                        </div>
                        <?php
                        $payqty = $order->pay_qty;
                        for ($i=1; $i<=$payqty; $i++) {
                            $array[] = array('pay_qty' => $i);
                        }
                        $codes = $array;
                        $installment = $deposit / $order->pay_qty;
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">จำนวนงวดชำระ</th>
                                <th scope="col">ราคาต่องวด</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($codes as $code) { ?>
                                <tr>
                                <td>งวดที่ <?php echo implode("",$code); ?></td>
                                <td><?php echo number_format($installment,2); ?> บาท</td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <p>ชำระเงินผ่านพร้อมเพย์ qrcode</p>
                            <img src="assets/img/qrcode.jpg" style="width:150px; height:150px; filter: grayscale(100%);">
                            <p style="margin-top:10px;">รหัสอ้างอิง: 004999082492009</p>
                        </div>
                        <div class="md-6 text-right">
                        <h4>จึงเรียนมาเพื่อให้ทราบ</h4>
                        <h4>วรากร เสงี่ยมศักดิ์</h4>
                        <h4>ผู้เสนอราคา</h4>
                        </div>
                    </div>
                </div>
                <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                    <button id="print" onclick="printContent('Receipt');" class="btn btn-success btn-lg text-justify btn-block">
                        Print <span class="fas fa-print"></span>
                    </button>
                </div>
            </div>
        </div>
</body>
</html>
<script>
    function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }
</script>
<?php } ?>