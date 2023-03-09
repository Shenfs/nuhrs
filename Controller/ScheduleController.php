<?php 
include_once('../db-connection.php'); //include file
include_once("../Utilities/alert.php"); //include file
include_once("../Utilities/insertToActivityLogs.php");

class ScheduleController extends DatabaseConnection{

    public function __construct()
    {
        parent::__construct();
    }

    public static function addSchedule($conn){
        if(isset($_POST['add_schedule'])){
            $fromSchedule = $_POST['fromSchedule'];
            $toSchedule = $_POST['toSchedule'];
            $med_prof_id = $_POST['med_prof_id'];

            $user_id = $_POST['user_id'];
        
            $insertSched = mysqli_query($conn,"INSERT INTO schedule(fromSchedule,toSchedule,medprofID) VALUES('$fromSchedule','$toSchedule','$med_prof_id')");
        
            if($insertSched){
                insertToActivityLogs($conn,$user_id,"Add Off Duty Schedule",$fromSchedule."-".$toSchedule);
                alert("success","Schedule Added Successfully","","../medical_professional/schedule.php");
            }
            else{
                alert("error","There was an error","","../medical_professional/schedule.php");//error message
            }
        
        
        }
    }

    public static function editSchedule($conn){
        
        if(isset($_POST['edit_schedule'])){
            $fromSchedule = date('Y-m-d', strtotime($_POST['fromSchedule']));
            $toSchedule = date('Y-m-d', strtotime($_POST['toSchedule']));
            $sched_id = $_POST['sched_id'];
            $user_id = $_POST['user_id'];

            $editSched = mysqli_query($conn,"UPDATE schedule SET fromSchedule='$fromSchedule',toSchedule='$toSchedule' WHERE id='$sched_id'");

            if($editSched){
                insertToActivityLogs($conn,$user_id,"Edit Off Duty Schedule",$fromSchedule."-".$toSchedule);
                alert("success","Schedule Updated Successfully","","../medical_professional/schedule.php");
            }
            else{
                alert("error","There was an error","","../medical_professional/schedule.php");//error message
            }
        }
    }
}
$db = new DatabaseConnection();
ScheduleController::addSchedule($db->conn);
ScheduleController::editSchedule($db->conn);



?>
