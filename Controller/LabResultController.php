<?php 
include_once('../db-connection.php'); //include file
include_once('../Utilities/alert.php'); //include file
date_default_timezone_set("Asia/Manila");
class LabResultController extends DatabaseConnection{

    public function __construct()
    {
        parent::__construct();
    }

    public static function approvedLabResult($conn){

        if(isset($_POST['approved_lab_result'])){
            $date_approved = date('Y-m-d');
            $lab_record_id = $_POST['lab_record_id'];
            $updateLabRecord = mysqli_query($conn,"UPDATE laboratoryresult SET date_approved='$date_approved',status='Approved' WHERE id='$lab_record_id'");

            if($updateLabRecord){
                alert("success","Lab Result Successfuly Approved","","../medical_professional/lab-result.php");//success message
            }
            else{
                alert("error","There was an error","","../medical_professional/lab-result.php");//error message
            }
        }
        
    }   

    public static function rejectLabResult($conn){
        if(isset($_POST['reject_lab_result'])){
           
            $lab_record_id = $_POST['lab_record_id'];
            $updateLabRecord = mysqli_query($conn,"UPDATE laboratoryresult SET status='Rejected' WHERE id='$lab_record_id'");

            if($updateLabRecord){
                alert("success","Lab Result Successfuly Rejected","","../medical_professional/lab-result.php");//success message
            }
            else{
                alert("error","There was an error","","../medical_professional/lab-result.php");//error message
            }
        }
    }
}
$db = new DatabaseConnection();
LabResultController::approvedLabResult($db->conn);
LabResultController::rejectLabResult($db->conn);