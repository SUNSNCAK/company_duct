<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config/connect_mysqli.php";
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($connect, $_POST['incoming_id']);
        $output = "";
        $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        $query = mysqli_query($connect, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $output .= '<div class="cm-msg-text outgoing chat-msg text-break">
                                    <div>'. $row['msg'] .'</div>
                                </div>';
                }else{
                    $output .= '<div class="cm-msg-text incoming chat-msg text-break">
                                    <div>'. $row['msg'] .'</div>
                                </div>';
                }
            }
        }else{
            $output .= '<div class="text-center">ไม่มีข้อความ เมื่อคุณส่งข้อความ จะปรากฏที่นี่</div>';
        }
        echo $output;
    }

?>