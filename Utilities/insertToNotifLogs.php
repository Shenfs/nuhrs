<?php 
function insertToNotifLogs($conn,$user_id,$channel,$status){
    date_default_timezone_set("Asia/Manila");
    $date_time = date('Y-m-d h:i:s');
    $insertToNotifLogsQuery = mysqli_query($conn,"INSERT INTO notification_logs(user_id, channel, date_time, status) VALUES ('$user_id','$channel','$date_time','$status')");

}
?>