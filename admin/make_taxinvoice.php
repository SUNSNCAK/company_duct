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
        <button onclick="location.href='taxinvoice.php'" class="btn btn-success">กลับหน้าคำสั่งซื้อ</button>
            <div class="row">
                <div id="Receipt" class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <h3 class="text-center">ใบกำกับภาษี</h3>
                    <div class="row">
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
                        <?php
                        $now = strtotime('now');
                        $date = date('Y-m-d', $now);
                        $mydate = date('Y-m-d' , strtotime($date));
                        $year = date('Y' , strtotime($date));
                        $yearbuddhist = $year + 543;
                        $inv = date("Ym");
                        $inv1 = date("Y");
                        $numrand = (mt_rand(0,99999));
                        $numrand1 = (mt_rand(0,9999));
                        ?>
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <p>เลขที่</p>
                            <p>วันที่</p>
                            <p>อ้างอิง</p>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <p>INV<?php echo $inv.$numrand; ?></p>
                            <p><?php echo date('d/m/', strtotime($mydate)).$yearbuddhist; ?></p>
                            <p>PO<?php echo $inv1.$numrand1; ?></p>
                        </div>
                    </div>
                    <hr class="my-1" style="border-top:1px solid #808080; margin-top:0px;">
                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-10">
                            <address>
                                <b>ชื่อผู้ซื้อ</b> บริษัท <?php echo $order->name; ?> (สำนักงานใหญ่)
                                <br>
                                <b>ที่อยู่</b> <?php echo $order->details." ".$order->sub_district." ".$order->district." ".$order->province." ".$order->postcode; ?>
                                <br>
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $sql1 = "SELECT * FROM product natural join orders_item where order_id = $orderid";
                        $stmt1 = $mysqli->prepare($sql1);
                        $stmt1->execute();
                        $res1 = $stmt1->get_result();
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>รหัสสินค้า</th>
                                    <th>รายการสินค้า</th>
                                    <th>จำนวน</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $count=0;
                            while ($order1 = $res1->fetch_object()) { ?>
                                <tr>
                                    <td class="col-md-2"><em> <?php echo $order1->product_code; ?> </em></h4>
                                    <td class="col-md-8"><em> <?php echo $order1->product_name; ?> </em></h4>
                                    </td>
                                    <td class="col-md-2" style="text-align: center"> <?php echo $order1->quantity; ?></td>
                                     <?php $count++; ?>
                                </tr>
                                
                                <?php
                                }
                                ?>
                                <tr>
                                    <td class="text-right" colspan="2">
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
                                    
                                    <td class="text-right" colspan="2">
                                        <h5><strong>รวมราคาทั้งสิ้น </strong></h5>
                                    </td>
                                    <td>
                                        <h5><strong><?php echo number_format($total); ?> บาท</strong></h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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