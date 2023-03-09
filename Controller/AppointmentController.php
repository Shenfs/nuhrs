<?php 

namespace Controller;

use DatabaseConnection;

include_once('../db-connection.php'); //include database connection
include_once('../Utilities/alert.php'); //alert utility function para mag bigay ng success of error message
include_once("../Utilities/insertToActivityLogs.php");
date_default_timezone_set("Asia/Manila"); //setting timezone to manila



class AppointmentController extends DatabaseConnection{

    
    public function __construct()
    {
       parent::__construct();
        
    }

    
    //Student Side
    public static function setAppointment($conn){
        if(isset($_POST['set_appointment'])){ //checking if set appointment button is click
            date_default_timezone_set("Asia/Manila");
            $from_date = $_POST['from_date'];                               //
            $from_time = $_POST['from_time'];                               //
            $to_date = $_POST['from_date'];                                 //
            $to_time = date('H:i:s', strtotime($from_time. ' +30 minutes'));//   -getting inputs from field
            $med_prof_id = $_POST['med_prof_id'];                           //
            $student_id = $_POST['student_id'];                             //
            $datecreated = date('Y-m-d h:i:s');                             //
            $status = 'Pending';
            $createdby = $_POST['createdby'];
            $appointment_type = $_POST['appointment_type'];
            $student_id = $_POST['student_id'];
            
        
        
            if($appointment_type == "Dental"){// checking if apointment type is dental 
        
                $selectDuplicateAppointment = mysqli_query($conn,"SELECT * FROM appointment WHERE status IN ('Approved', 'Rescheduled') AND from_date='$from_date' AND  from_time='$from_time' AND appointment_type='$appointment_type'"); //db query to check if there is duplicate dental appointment
        
                if($selectDuplicateAppointment->num_rows > 0){//checking numbers of duplicate appointment if greaterthan 1 maglalabas ng error na appointment date is taken na
                    alert("warning","Appointment Date is Taken","","../student/dental-appointment.php");//lalabas tong error na to if taken na
                }
                else{//kapag walang duplicate mag eexecure yung code below
                    $insertAppointment = mysqli_query($conn,"INSERT INTO appointment(from_date, from_time, to_date, to_time, medprofID, student_id, datecreated, status, createdby,appointment_type) VALUES ('$from_date','$from_time','$to_date','$to_time','$med_prof_id','$student_id','$datecreated','$status','$createdby','$appointment_type')"); //db query to insert appointment
        
                    if($insertAppointment){ //checking if query is successful
                        insertToActivityLogs($conn,$student_id,"Set Dental Appointment","Status : Pending");
                        alert("success","Appointment Successfully Set","Please wait for updates","../student/dental-appointment.php");// if successful lalabas tong success message na to
                    }
                    else{// if hindi successful lalabas tong error message na to
                        alert("error","There was an error","","../student/dental-appointment.php");
                    }
                }
                
            }else{//if apointment type is medical mag eexecute yung code below
                $selectDuplicateAppointment = mysqli_query($conn,"SELECT * FROM appointment WHERE status IN ('Approved', 'Rescheduled') AND from_date='$from_date' AND  from_time='$from_time' AND appointment_type='$appointment_type'"); //db query to check if there is duplicate medical appointment 
        
                
        
                if($selectDuplicateAppointment->num_rows > 0){//checking numbers of duplicate appointment if greaterthan 1 maglalabas ng error na appointment date is taken na
                    alert("warning","Appointment Date is Taken","","../student/medical-appointment.php");//lalabas tong error na to if taken na
                }
                else{//kapag walang duplicate mag eexecure yung code below
                    $insertAppointment = mysqli_query($conn,"INSERT INTO appointment(from_date, from_time, to_date, to_time, medprofID, student_id, datecreated, status, createdby,appointment_type) VALUES ('$from_date','$from_time','$to_date','$to_time','$med_prof_id','$student_id','$datecreated','$status','$createdby','$appointment_type')");//db query to insert appointment
        
                    if($insertAppointment){//checking if query is successful
                        insertToActivityLogs($conn,$student_id,"Set Medical Appointment","Status : Pending");
                        alert("success","Appointment Successfully Set","Please wait for updates","../student/medical-appointment.php");// if successful lalabas tong success message na to
                    }
                    else{// if hindi successful lalabas tong error message na to
                        alert("error","There was an error","","../student/medical-appointment.php");
                    }
                }
            }
            
        }
    }

    public static function approveAppointment($conn){
        //Admin Side
        if(isset($_POST['approve_appointment'])){//checking if approve appointment button is click
            $appointment_id = $_POST['appointment_id']; // getting user input
            $appointment_type = $_POST['appointment_type']; //getting user input

            if($appointment_type == "Medical"){//if apointment type is medical mag eexecute yung code below
                $update_appointment_status = mysqli_query($conn,"UPDATE appointment SET status='Approved' WHERE id='$appointment_id'"); //db query to approved appointment 
               
                if($update_appointment_status){//if query ay successful mag eexecute yung code velow
                    $selectInvlovedUsers = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_first_name, u1.lastName AS  med_prof_last_name, u2.firstName AS stud_first_name, u2.lastName as stud_last_name, u1.id AS med_prof_user_id FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON appointment.student_id = students.id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.id='$appointment_id'");
                    $row = $selectInvlovedUsers->fetch_assoc();
                    insertToActivityLogs($conn,$row['med_prof_user_id'],"Approve Appointment","Approved Appointment of ".$row['stud_first_name']." ".$row['stud_last_name']);
                    alert("success","Appointment Successfuly Approved","","../medical_professional/medical-appointment.php");//success message
                }
                else{//if query ay hindi successful mag eexecute yung code below
                    alert("error","There was an error","","../medical_professional/medical-appointment.php"); //error message
                }
            }
            else{//if apointment type is dental mag eexecute yung code below
                $update_appointment_status = mysqli_query($conn,"UPDATE appointment SET status='Approved' WHERE id='$appointment_id'");//db query to approved appointment 
                if($update_appointment_status){///if query ay successful mag eexecute yung code velow
                    $selectInvlovedUsers = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_first_name, u1.lastName AS  med_prof_last_name, u2.firstName AS stud_first_name, u2.lastName as stud_last_name, u1.id AS med_prof_user_id FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON appointment.student_id = students.id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.id='$appointment_id'");
                    $row = $selectInvlovedUsers->fetch_assoc();
                    insertToActivityLogs($conn,$row['med_prof_user_id'],"Approve Appointment","Approved Appointment of ".$row['stud_first_name']." ".$row['stud_last_name']);
                    alert("success","Appointment Successfuly Approved","","../medical_professional/dental-appointment.php");//success message
                }
                else{//if query ay hindi successful mag eexecute yung code below
                    alert("error","There was an error","","../medical_professional/dental-appointment.php");//error message
                }
            }
        }
    }

    public static function cancelAppointment($conn){
        if(isset($_POST['cancel_appointment'])){//checking if approve appointment button is click
            $appointment_id = $_POST['appointment_id'];// getting user input
            $appointment_type = $_POST['appointment_type'];// getting user input
            $reason = $_POST['reason'];
        
            if($appointment_type == "Medical"){//if apointment type is medical mag eexecute yung code below
                $update_appointment_status = mysqli_query($conn,"UPDATE appointment SET status='Cancelled', reason_for_cancellation='$reason' WHERE id='$appointment_id'");//db query to cancel appointment
        
                if($update_appointment_status){//check if query ay successful
                    $selectInvlovedUsers = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_first_name, u1.lastName AS  med_prof_last_name, u2.firstName AS stud_first_name, u2.lastName as stud_last_name, u1.id AS med_prof_user_id FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON appointment.student_id = students.id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.id='$appointment_id'");
                    $row = $selectInvlovedUsers->fetch_assoc();
                    insertToActivityLogs($conn,$row['med_prof_user_id'],"Cancelled Appointment","Cancelled Appointment of ".$row['stud_first_name']." ".$row['stud_last_name']);
                    alert("success","Appointment Cancelled Successfuly","","../medical_professional/medical-appointment.php"); //success message
                }
                else{//if hind successful
                    alert("error","There was an error","","../medical_professional/medical-appointment.php");//error message
                }
            }
            else{//if apointment type is dental mag eexecute yung code below
                $update_appointment_status = mysqli_query($conn,"UPDATE appointment SET status='Cancelled', reason_for_cancellation='$reason' WHERE id='$appointment_id'");//db query to cancel appointment
        
        
                if($update_appointment_status){//check if query ay successful
                    $selectInvlovedUsers = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_first_name, u1.lastName AS  med_prof_last_name, u2.firstName AS stud_first_name, u2.lastName as stud_last_name, u1.id AS med_prof_user_id FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON appointment.student_id = students.id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.id='$appointment_id'");
                    $row = $selectInvlovedUsers->fetch_assoc();
                    insertToActivityLogs($conn,$row['med_prof_user_id'],"Cancelled Appointment","Cancelled Appointment of ".$row['stud_first_name']." ".$row['stud_last_name']);
                    alert("success","Appointment Cancelled Successfuly","","../medical_professional/dental-appointment.php");//success message
                }
                else{
                    alert("error","There was an error","","../medical_professional/dental-appointment.php");//error message
                }
            }
        }        
    }

    public static function reschedAppointment($conn){
        if(isset($_POST['resched_appointment'])){
            date_default_timezone_set("Asia/Manila");
            $appointment_id = $_POST['appointment_id'];
            $from_date = $_POST['from_date'];                               
            $from_time = $_POST['from_time'];
            $to_date = $_POST['from_date'];                                 
            $to_time = date('H:i:s', strtotime($from_time. ' +30 minutes'));
            $appointment_type = $_POST['appointment_type'];
        
            if($appointment_type == "Medical"){
        
                $selectDuplicateAppointment = mysqli_query($conn,"SELECT * FROM appointment WHERE status IN ('Approved', 'Rescheduled') AND from_date='$from_date' AND  from_time='$from_time' AND appointment_type='$appointment_type' AND id!='$appointment_id'");
        
                if($selectDuplicateAppointment->num_rows > 0){
                    alert("warning","Appointment Date is Taken","","../medical_professional/medical-appointment.php");
                }
                else{
                    $resched_appointment = mysqli_query($conn,"UPDATE appointment SET from_date='$from_date', from_time='$from_time', to_date='$to_date', to_time='$to_time',status='Rescheduled' WHERE id='$appointment_id'");
        
                    if($resched_appointment){
                        $selectInvlovedUsers = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_first_name, u1.lastName AS  med_prof_last_name, u2.firstName AS stud_first_name, u2.lastName as stud_last_name, u1.id AS med_prof_user_id FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON appointment.student_id = students.id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.id='$appointment_id'");
                        $row = $selectInvlovedUsers->fetch_assoc();
                        insertToActivityLogs($conn,$row['med_prof_user_id'],"Rescheduled Appointment","Rescheduled Appointment of ".$row['stud_first_name']." ".$row['stud_last_name']);
                        alert("success","Appointment Successfuly Reschedule","","../medical_professional/medical-appointment.php");
                    }
                    else{
                        alert("error","There was an error","","../medical_professional/medical-appointment.php");
                    }
                }
                
            }
            else{
                $selectDuplicateAppointment = mysqli_query($conn,"SELECT * FROM appointment WHERE status IN ('Approved', 'Rescheduled') AND from_date='$from_date' AND  from_time='$from_time' AND appointment_type='$appointment_type' AND id!='$appointment_id'");
        
                if($selectDuplicateAppointment->num_rows > 0){
                    alert("warning","Appointment Date is Taken","","../medical_professional/dental-appointment.php");
                }
                else{
                    $resched_appointment = mysqli_query($conn,"UPDATE appointment SET from_date='$from_date', from_time='$from_time', to_date='$to_date', to_time='$to_time',status='Rescheduled' WHERE id='$appointment_id'");
        
                    if($resched_appointment){
                        $selectInvlovedUsers = mysqli_query($conn,"SELECT *, u1.firstName AS med_prof_first_name, u1.lastName AS  med_prof_last_name, u2.firstName AS stud_first_name, u2.lastName as stud_last_name, u1.id AS med_prof_user_id FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON appointment.student_id = students.id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN users AS u2 ON u2.id = students.userID WHERE appointment.id='$appointment_id'");
                        $row = $selectInvlovedUsers->fetch_assoc();
                        insertToActivityLogs($conn,$row['med_prof_user_id'],"Rescheduled Appointment","Rescheduled Appointment of ".$row['stud_first_name']." ".$row['stud_last_name']);
                        alert("success","Appointment Successfuly Reschedule","","../medical_professional/dental-appointment.php");
                    }
                    else{
                        alert("error","There was an error","","../medical_professional/dental-appointment.php");
                    }
                }
        
                
            }
        
        }
    }
}
$db = new DatabaseConnection();
AppointmentController::setAppointment($db->conn);
AppointmentController::approveAppointment($db->conn);
AppointmentController::cancelAppointment($db->conn);
AppointmentController::reschedAppointment($db->conn);









?>