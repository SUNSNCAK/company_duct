<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config/connect_mysqli.php";
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($connect, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($connect, $_POST['message']);
        if(!empty($message)){
            $sql = mysqli_query($connect, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
        }
    }
?>