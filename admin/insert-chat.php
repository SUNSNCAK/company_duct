<?php 
    session_start();
    if(isset($_SESSION['admin_login'])){
        include_once "config/config.php";
        $outgoing_id = "1458668101";
        $incoming_id = mysqli_real_escape_string($mysqli, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($mysqli, $_POST['message']);
        if(!empty($message)){
            $sql = mysqli_query($mysqli, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
        }
    }else{
        header("location: message.php");
    }


    
?>