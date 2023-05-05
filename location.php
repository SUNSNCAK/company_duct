<?php
  session_start();
  require_once 'config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    require_once('head.php');
  ?>
</head>
<body>
  <?php
    require_once('user_db.php');
  ?>
  <?php
    require_once('navbar.php');
  ?>
  <?php
    require_once('user_form.php');
  ?>
    <h4 style="padding-top:100px;" class="row justify-content-center">V.K. AIR GROUP 2012</h4>
    <iframe class="col-md-6 offset-md-3 container" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7740.921270824802!2d100.34313705418963!3d14.049954940589467!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e28bc520c923f7%3A0xd811e30e455d0a01!2z4Lir4LiI4LiBIOC4p-C4tS7guYDguIQg4LmB4Lit4Lij4LmMIOC4geC4o-C4uOC5iuC4miAyMDEy!5e0!3m2!1sth!2sth!4v1662898020286!5m2!1sth!2sth" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <?php
      require_once('footer.php');
    ?>
    <?php
    if (isset($_SESSION['user_login'])) {
      require_once('chat-box.php');
    }
    ?>
    <script src="dropdown.js"></script>
    <script src="chat.js"></script>
    <script src="script.js"></script>
</body>
</html>