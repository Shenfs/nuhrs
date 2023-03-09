<?php
include('../db-connection.php');
$db = new DatabaseConnection();
$conn = $db->conn;
$med_id = $_POST['med_id'];
$selectMedProfSched = mysqli_query($conn,"SELECT * FROM schedule WHERE medprofID='$med_id' ");
if($selectMedProfSched->num_rows > 0){
    while($row = $selectMedProfSched->fetch_assoc()){
        $startDate = $row['fromSchedule'];
        $endDate = $row['toSchedule'];

       
    
        $sched[] = returnBetweenDates( $startDate, $endDate );
    }
    
    $sched = array_flatten($sched);

    $sched = array_unique($sched);
    
    $data = $sched;

    
}
else{
    $data = [];
}


echo json_encode($data);



function returnBetweenDates( $startDate, $endDate ){
    $startStamp = strtotime(  $startDate );
    $endStamp   = strtotime(  $endDate );

    if( $endStamp > $startStamp ){
        while( $endStamp >= $startStamp ){

            $dateArr[] = date( 'Y-m-d', $startStamp );

            $startStamp = strtotime( ' +1 day ', $startStamp );

        }
        return $dateArr;    
    }else{
        return $startDate;
    }

}

function array_flatten($array) { 
    if (!is_array($array)) { 
      return FALSE; 
    } 
    $result = array(); 
    foreach ($array as $key => $value) { 
      if (is_array($value)) { 
        $result = array_merge($result, array_flatten($value)); 
      } 
      else { 
        $result[$key] = $value; 
      } 
    } 
    return $result; 
} 


?>