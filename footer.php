    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <h2>ห้างหุ้นส่วนจำกัด วี.เค.แอร์ กรุ๊ป 2012</h2>
            <p class="text-justify">บริการ ติดตั้ง วางระบบและออกแบบ ระบบปรับอากาศ</p>
            <p class="text-justify">2/9 หมู่ที่ 6 ตำบลหน้าไม้ อำเภอลาดหลุมแก้ว จ.ปทุมธานี 12140</p>
          </div>

          <div class="col-xs-6 col-md-3">
            <h2>เมนูผู้ใช้งาน</h2>
            <?php if (isset($_SESSION['user_login'])) { ?>
            <ul class="footer-links">
              <li><a href="account.php">บัญชี</a></li>
              <li><a href="address.php">ที่อยู่</a></li>
              <li><a href="order.php">คำสั่งซื้อ</a></li>
            </ul>
            <?php } else { ?>
            <ul class="footer-links">
              <li><a>บัญชี</a></li>
              <li><a>ที่อยู่</a></li>
              <li><a>คำสั่งซื้อ</a></li>
            </ul>
            <?php } ?>
          </div>

          <div class="col-xs-6 col-md-3">
            <h2>ช่องทางการติดต่อ</h2>
            <ul class="footer-links">
              <li><a href="tel:028012185">เบอร์โทรศัพท์</a></li>
              <li><a href="https://line.me/th/">Line</a></li>
              <li><a href="https://www.facebook.com/mambangkaee?mibextid=ZbWKwL">Facebook</a></li>
            </ul>
          </div>
        </div>
        <hr>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-6 col-xs-12">
            <p class="copyright-text">Copyright V.K. AIR GROUP 2012 LIMITED PARTNERSHIP © 2022. All rights reserved.</p>
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12">
            <ul class="social-icons">
              <li><a class="facebook" href="https://www.facebook.com/mambangkaee?mibextid=ZbWKwL"><i class="bi bi-facebook"></i></a></li>
              <li><a class="line" href="https://line.me/th/"><i class="bi bi-line"></i></a></li> 
            </ul>
          </div>
        </div>
      </div>
    </footer>