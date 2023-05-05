    <nav class="navbar navbar-expand-sm navcolor position-fixed py-0 shadow-lg p-3 mb-5 bg-body-tertiary">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <!-- NAVIGATION MENU -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!-- NAVIGATION MENUS -->
            <li class="nav-item"><a class="bi bi-house-fill dropbtn" href="home.php"> หน้าแรก</a></li>
            <li class="nav-item"><a class="bi bi-geo-alt-fill dropbtn" href="location.php"> สถานที่บริษัท</a></li>
        </ul>
                      <?php

                          if (isset($_SESSION['user_login'])) {
                            $iduser = $_SESSION['user_login'];
                            $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = $iduser");
                            $stmt->execute();
                            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                            $username = $rows['name'];
                            $email = $rows['email'];
                            $number = $rows['number'];
                      ?> 
                          <a class="position-relative mx-2" href="cart.php"><h2 style="color:white; margin-right:10px;" class="bi bi-handbag d-inline-flex"></h2><span class="position-absolute top-50 start-50 badge rounded-pill bg-danger" style="z-index:1;"></span></a>
                          <div class="d-flex">
                            <div class="dropdown">
                            <button onclick="usedropdown()" class="dropbtn bi bi-caret-down-fill"> <?php echo $username?></button>
                            <div id="myDropdown" class="dropdown-content">
                              <a class="text-light bi bi-person-circle" href="account.php"> บัญชีของฉัน</a>
                              <a class="text-light bi bi-bag-check-fill" href="order.php"> การสั่งซื้อ</a>
                              <a class="text-light bi bi-file-earmark-medical-fill" href="orderhistory.php"> ประวัติการสั่งซื้อ</a>
                              <hr class="my-1" style="border-top:1px solid #808080; margin-top:0px;">
                              <a class="bi bi-box-arrow-right text-danger" href="logout.php"> ออกจากระบบ</a>
                            </div>   
                          </div>
                          <script>
                            function updateCart() {
                                $.ajax({
                                      url: 'ajax-update-cart.php', 
                                      success: (result) => {  
                                              if (result == 0) {
                                                    result = '';
                                              }               
                                              $('span.badge').text(result);
                                      }                 
                                  });
                            }
                            $(function() {
                                updateCart();
                            });
                          </script>                       
                      <?php  } else {
                          $username = 'ลงชื่อเข้าใช้'; ?>
                          <div class="d-flex">
                            <div class="dropdown"id="login-btn">
                              <button class="bi bi-person-circle dropbtn"> <?php echo $username?></button>
                            </div>
                          </div>
                      <?php  }
                      ?>
        </div>
      </div>
    </nav>