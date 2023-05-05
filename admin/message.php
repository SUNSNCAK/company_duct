<?php
session_start();
include('config/config.php');
include('config/pdoconfig.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
?>
<body>
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <div class="main-content">
    <?php
    require_once('partials/_topnav.php');
    ?>
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/backgroundadmin.jpg); background-size: 50% 100%;" class="header  pb-8 pt-5 pt-md-8">
    <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="wrapper">
            <section class="users p-3">
              <div class="content">
                <?php
                  $admin = $_SESSION['admin_login'];
                  $stmt = $DB_con->query("SELECT * FROM users WHERE user_id = $admin");
                  $stmt->execute();
                  $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                  $unique_id = $rows['unique_id'];
                  $sql = mysqli_query($mysqli, "SELECT * FROM users WHERE unique_id = $unique_id");
                  if(mysqli_num_rows($sql) > 0){
                    $row = mysqli_fetch_assoc($sql);
                  }
                ?>
              </div>
              <div class="search">
                <span class="text">ค้นหาชื่อผู้ใช้</span>
                <input type="text" placeholder="ใส่ชื่อเพื่อค้นหา...">
                <button><i class="fas fa-search"></i></button>
              </div>
              <div class="users-list">
                <?php require_once('search.php'); ?>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/users.js"></script>
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>
</html>