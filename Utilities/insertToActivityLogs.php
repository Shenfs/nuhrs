<?php 
function insertToActivityLogs($conn,$user_id,$activity,$description){
    date_default_timezone_set("Asia/Manila");
    $date_time = date('Y-m-d h:i A');
    $insertToActivityLogs = mysqli_query($conn,"INSERT INTO user_activity_logs(user_id, activity, description, date_created) VALUES ('$user_id','$activity','$description','$date_time')");
}
?>