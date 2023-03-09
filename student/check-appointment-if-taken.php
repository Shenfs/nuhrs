<?php 
include_once("../db-connection.php");
$db = new DatabaseConnection();
$conn = $db->conn;
$date = $_POST['date'];
$appointment_type = $_POST['appointment_type'];



if($appointment_type == "Medical"){
    $time = array("08:00:00","08:30:00","09:00:00","09:30:00","10:00:00","10:30:00","11:00:00","11:30:00","13:00:00","13:30:00","14:00:00","14:30:00","15:00:00","15:30:00","16:00:00","16:30:00");


    for($i=0; $i < count($time); $i++){
        $checkIfTaken = mysqli_query($conn,"SELECT * FROM appointment WHERE from_date='$date' AND from_time='$time[$i]' AND status IN ('Approved','Rescheduled') AND appointment_type='Medical'");

        if($checkIfTaken->num_rows > 0){
            unset($time[$i]);
            $time = array_values($time);
        }
        
    }
    $json = [];

    for($i=0; $i < count($time); $i++){
        
        $json[$time[$i]] = date('h:i A',strtotime($time[$i]))." - ".date('h:i A', strtotime($time[$i]. ' +30 minutes'));
    }


    echo json_encode($json);
}
else{
    $time = array("08:00:00","08:30:00","09:00:00","09:30:00","10:00:00","10:30:00","11:00:00","11:30:00","13:00:00","13:30:00","14:00:00","14:30:00","15:00:00","15:30:00","16:00:00","16:30:00");


    for($i=0; $i < count($time); $i++){
        $checkIfTaken = mysqli_query($conn,"SELECT * FROM appointment WHERE from_date='$date' AND from_time='$time[$i]' AND status IN ('Approved','Rescheduled') AND appointment_type='Dental'");

        if($checkIfTaken->num_rows > 0){
            unset($time[$i]);
            $time = array_values($time);
        }
        
    }
    $json = [];

    for($i=0; $i < count($time); $i++){
        
        $json[$time[$i]] = date('h:i A',strtotime($time[$i]))." - ".date('h:i A', strtotime($time[$i]. ' +30 minutes'));
    }


    echo json_encode($json);
}


?>