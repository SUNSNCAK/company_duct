<?php 
  session_start();
  include_once "config/config.php";
?>
<?php require_once('partials/_head.php'); ?>
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
            <section class="chat-area">
              <header>
                <?php 
                  $user_id = mysqli_real_escape_string($mysqli, $_GET['user_id']);
                  $sql = mysqli_query($mysqli, "SELECT * FROM users WHERE unique_id = {$user_id}");
                  if(mysqli_num_rows($sql) > 0){
                    $row = mysqli_fetch_assoc($sql);
                  }else{
                    header("location: message.php");
                  }
                ?>
                <a href="message.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <div class="details ml-3">
                  <h2 style="margin-top:9px;"><?php echo $row['name']?></h2>
                </div>
              </header>
              <div class="chat-box">

              </div>
              <form action="#" class="typing-area">
                <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="พิมพ์ข้อความที่นี่..." autocomplete="off">
                <button><i class="fab fa-telegram-plane"></i></button>
              </form>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/chat.js"></script>
  <?php
  require_once('partials/_scripts.php');
  ?>

</body>
</html>
