<?php 
include_once('../db-connection.php'); //include database connection
include_once('../Utilities/alert.php'); //alert utility function para mag bigay ng success of error message
include_once('../Utilities/insertToActivityLogs.php');
date_default_timezone_set("Asia/Manila"); //setting timezone to manila
$user_id = $_POST['user_id'];
class ReportController extends DatabaseConnection{

    public function __construct(){
        parent::__construct();
    }

    public static function editAppointmentStatus($conn){
        if(isset($_POST['edit_status'])){
            $appointment_id = $_POST['appointment_id'];
            $status = $_POST['status'];
        
            if($status == "Successful"){
                $datenow = date("Y-m-d H:i:s");
               
                $updateStatus = mysqli_query($conn,"UPDATE appointment SET timefinished='$datenow',status='$status' WHERE appointment.id='$appointment_id'");
        
                if($updateStatus){
                    $selectInvlovedUsers = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_first_name, u1.lastName AS  med_prof_last_name, u2.firstName AS stud_first_name, u2.lastName as stud_last_name, u1.id AS med_prof_user_id FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON appointment.student_id = students.id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.id='$appointment_id'");
                    $row = $selectInvlovedUsers->fetch_assoc();
                    insertToActivityLogs($conn,$row['med_prof_user_id'],"Edit Appointment Status","Set Successful Appointment Status of ".$row['stud_first_name']." ".$row['stud_last_name']);

                    alert("success","Appointment Status Updated Successfuly","","../medical_professional/reports.php");
                }
                else{
                    
                    alert("error","There was an error","","../medical_professional/reports.php");
                }
               
            }
            else{
                $updateStatus = mysqli_query($conn,"UPDATE appointment SET status='Unsuccessful' WHERE appointment.id='$appointment_id'");
        
                if($updateStatus){
                    $selectInvlovedUsers = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_first_name, u1.lastName AS  med_prof_last_name, u2.firstName AS stud_first_name, u2.lastName as stud_last_name, u1.id AS med_prof_user_id FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON appointment.student_id = students.id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.id='$appointment_id'");
                    $row = $selectInvlovedUsers->fetch_assoc();
                    insertToActivityLogs($conn,$row['med_prof_user_id'],"Edit Appointment Status","Set Unsuccessful Appointment Status of ".$row['stud_first_name']." ".$row['stud_last_name']);

                    alert("success","Appointment Status Updated Successfuly","","../medical_professional/reports.php");
                }
                else{
                    alert("error","There was an error","","../medical_professional/reports.php");
                }
        
                
            }
        }
    }
    public static function exportDatabase($conn,$inputted_password,$correct_password,$tables = false,$user_id,$user_type_id){
        if($correct_password == $inputted_password){
            //ENTER THE RELEVANT INFO BELOW
            $mysqli = new mysqli('localhost','root','','nuhrs');
            $mysqli->select_db('nuhrs');
            $mysqli->query("SET NAMES 'utf8'");

            $queryTables    = $mysqli->query('SHOW TABLES');
            while($row = $queryTables->fetch_row())
            {
                $target_tables[] = $row[0];
            }
            if($tables !== false)
            {
                $target_tables = array_intersect( $target_tables, $tables);
            }
            foreach($target_tables as $table)
            {
                $result         =   $mysqli->query('SELECT * FROM '.$table);
                $fields_amount  =   $result->field_count;
                $rows_num=$mysqli->affected_rows;
                $res            =   $mysqli->query('SHOW CREATE TABLE '.$table);
                $TableMLine     =   $res->fetch_row();
                $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

                for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0)
                {
                    while($row = $result->fetch_row())
                    { //when started (and every after 100 command cycle):
                        if ($st_counter%100 == 0 || $st_counter == 0 )
                        {
                                $content .= "\nINSERT INTO ".$table." VALUES";
                        }
                        $content .= "\n(";
                        for($j=0; $j<$fields_amount; $j++)
                        {
                            $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) );
                            if (isset($row[$j]))
                            {
                                $content .= '"'.$row[$j].'"' ;
                            }
                            else
                            {
                                $content .= '""';
                            }
                            if ($j<($fields_amount-1))
                            {
                                    $content.= ',';
                            }
                        }
                        $content .=")";
                        //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                        if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num)
                        {
                            $content .= ";";
                        }
                        else
                        {
                            $content .= ",";
                        }
                        $st_counter=$st_counter+1;
                    }
                } $content .="\n\n\n";
            }
            //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
            $datetimenow = date('Y-M-d H:i A');
            insertToActivityLogs($conn,$user_id,"Export Database","Filename: nuhrs_".$datetimenow.".sql");
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary");
          
            header("Content-disposition: attachment; filename=\"nuhrs_".$datetimenow.".sql\"");
            
            echo $content; exit;
            
        }
        else{
            if($user_type_id == 1){
                alert("error","Unauthorized","Incorrect Password","../medical_professional/reports.php");
            }
            else{
                alert("error","Unauthorized","Incorrect Password","../super_admin/reports.php");
            }
           
        }
            
    }

}
$db = new DatabaseConnection();
ReportController::editAppointmentStatus($db->conn);

if(isset($_POST['export_database'])){
    ReportController::exportDatabase($db->conn,$_POST['inputted_password'],$_POST['correct_password'],false,$user_id,$_POST['user_type_id']);
}

?>