<?php 
include_once('../db-connection.php'); //include file
include_once('../Utilities/alert.php'); //include file
date_default_timezone_set("Asia/Manila");
class VaccRecordController extends DatabaseConnection{

    public function __construct()
    {
        parent::__construct();
    }

    public static function approvedVaccRecord($conn){

        if(isset($_POST['approved_vacc_record'])){
            $date_approved = date('Y-m-d');
            $vaccination_record_id = $_POST['vaccination_record_id'];
            $updateLabRecord = mysqli_query($conn,"UPDATE vaccinationrecord SET date_approved='$date_approved',status='Approved' WHERE id='$vaccination_record_id'");

            if($updateLabRecord){
                alert("success","Vaccine Successfuly Approved","","../medical_professional/vaccine_record.php");//success message
            }
            else{
                alert("error","There was an error","","../medical_professional/vaccine_record.php");//error message
            }
        }
        
    }   

    public static function rejectVaccRecord($conn){
        if(isset($_POST['reject_vacc_record'])){
           
            $vaccination_record_id = $_POST['vaccination_record_id'];
            $updateLabRecord = mysqli_query($conn,"UPDATE vaccinationrecord SET status='Rejected' WHERE id='$vaccination_record_id'");

            if($updateLabRecord){
                alert("success","Vaccine Successfuly Rejected","","../medical_professional/vaccine_record.php");//success message
            }
            else{
                alert("error","There was an error","","../medical_professional/vaccine_record.php");//error message
            }
        }
    }
}
$db = new DatabaseConnection();
VaccRecordController::approvedVaccRecord($db->conn);
VaccRecordController::rejectVaccRecord($db->conn);