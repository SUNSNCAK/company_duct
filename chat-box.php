<?php
  include_once "config/connect_mysqli.php";
?>
<div id="body"> 
  
<div id="chat-circle" class="btn btn-raised">
        <div id="chat-overlay"></div>
		    <h4 class="bi bi-chat-dots-fill"></h4>
	</div>
  
  <div class="chat-box">
  <?php 
    $user_id = "1458668101";
    $sql = mysqli_query($connect, "SELECT * FROM users WHERE unique_id = {$user_id}");
    if(mysqli_num_rows($sql) > 0){
      $row = mysqli_fetch_assoc($sql);
    }
  ?>
    <div class="chat-box-header">
        <h5 class="d-inline float-start ms-3 my-0">LIVE CHAT</h5>
        <span class="d-inline chat-box-toggle float-end"><i class="bi bi-x-lg"></i></span>
    </div>
    <div class="chat-box-body">
      <div class="chat-box-overlay">   
      </div>
      <div class="chat-logs">
       
      </div><!--chat-log -->
    </div>
    <div class="chat-input">      
      <form class="typing-area" autocomplete="off">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" id="chat-input" placeholder="Send a message..."/>
      <button class="chat-submit" id="chat-submit"><h4 class="bi bi-send"></h4></button>
      </form>      
    </div>
  </div>
</div>