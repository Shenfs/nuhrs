<?php
include('db-connection.php');
$db = new DatabaseConnection();
$conn = $db->conn;

$selectMedProfSched = mysqli_query($conn,"SELECT fromSchedule, toSchedule FROM schedule WHERE medprofID='1'");
$data = array();
$betweenDates = array();
while($row = $selectMedProfSched->fetch_assoc()){
    $startDate = date('Y-m-d',strtotime($row['fromSchedule']));
    $endDate = date('Y-m-d',strtotime($row['toSchedule']));

    

}
$betweenDates = returnBetweenDates( $startDate, $endDate );

for($i= 0; $i < count($betweenDates); $i++){
   $data[$i] = $betweenDates[$i];
}

echo json_encode($data);



function returnBetweenDates( $startDate, $endDate ){
    $startStamp = strtotime(  $startDate );
    $endStamp   = strtotime(  $endDate );

    if( $endStamp > $startStamp ){
        while( $endStamp >= $startStamp ){

            $dateArr[] = date( 'm-d-Y', $startStamp );

            $startStamp = strtotime( ' +1 day ', $startStamp );

        }
        return $dateArr;    
    }else{
        return $startDate;
    }

}


?>