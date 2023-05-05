<?php
    while($row = mysqli_fetch_assoc($query)){
        /*$sql1 = "SELECT * FROM users WHERE user_id = $admin";
        $res = mysqli_query($mysqli, $sql1);
        $row1 = mysqli_fetch_assoc($res);
        $uniqueid = $row1['unique_id'];*/

        $outgoing_id = "1458668101";
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($mysqli, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="ไม่มีข้อความ";
        (strlen($result) > 28) ? $msg =  mb_strcut($result, 0, 28) . '...' : $msg = $result;
        if(isset($row2['outgoing_msg_id'])){
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "คุณ: " : $you = "";
        }else{
            $you = "";
        }
        /*($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";*/
        ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";

        $output .= '<a href="chat.php?user_id='. $row['unique_id'] .'">
                    <div class="content">
                    <div class="details">
                        <span>'. $row['name'].'</span>
                        <p class="text-muted">'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div style="margin-right:20px;"><i class="fa fa-comments"></i></div>
                </a>';
    }
?>