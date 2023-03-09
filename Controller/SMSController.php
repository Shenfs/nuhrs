<?php 
include_once('../db-connection.php'); //include database connection
include_once('../Utilities/alert.php'); //alert utility function para mag bigay ng success of error message
include_once('../Utilities/insertToNotifLogs.php');
include_once('../Utilities/insertToActivityLogs.php');
date_default_timezone_set("Asia/Manila"); //setting timezone to manila
class SMSController extends DatabaseConnection{

    public function __construct()
    {
        parent::__construct();
    }

    public static function SendSMS($conn){
        if(isset($_POST['send_sms'])){
            $receiver = $_POST['receiver'];
            $user_id = $_POST['user_id'];
            $message = $_POST['message'];
            $receiver = substr($receiver,3);
            $receiver = "0".$receiver;
        
            $ch = curl_init();
            $parameters = array(
                'apikey' => 'b62ebf6819b126c0781a17aab4d5b3cf', //Your API KEY
                'number' => $receiver,
                'message' => $message,
                'sendername' => 'SEMAPHORE'
            );
            curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
            curl_setopt( $ch, CURLOPT_POST, 1 );
            
            //Send the parameters set above with the request
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
            
            // Receive response from server
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            $output = curl_exec( $ch );
            $result = json_decode($output);
        
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
                insertToNotifLogs($conn,$user_id,"SMS (".$receiver.")","Not Sent");
                
                alert("error","Emails not sent",$error_msg,"../medical_professional/manage_notification.php");
                curl_close ($ch);
                exit;
            }
            else{
                insertToNotifLogs($conn,$user_id,"SMS (".$_POST['receiver'].")","Sent");
                insertToActivityLogs($conn,$user_id,"Send SMS","SMS Sent to ".$receiver);
                alert("success","SMS Sent to",$receiver,"../medical_professional/manage_notification.php");
                curl_close ($ch);
                exit;
            }
            curl_close ($ch);
            exit;
            
        }
    }

    public static function MultipleSendSMS($conn){
        if(isset($_POST['send_all_sms'])){
            $user_id = $_POST['user_id'];
            $selectApproachedAppointment = mysqli_query($conn,"SELECT *, appointment.id AS appointment_id, ut2.firstName AS stud_first_name, ut2.lastName AS stud_last_name, ut1.firstName AS med_first_name, ut1.lastName AS med_last_name,  students.contact_number AS stud_contact_number, ut2.email_address AS stud_email, ut2.id AS ut2_id FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON students.id = appointment.student_id INNER JOIN users AS ut1 ON ut1.id = medicalprofessional.userID INNER JOIN users AS ut2 ON ut2.id = students.userID WHERE YEAR(from_date) = YEAR(NOW()) AND MONTH(from_date) = MONTH(NOW()) AND DAY(from_date) >= DAY(NOW()) AND appointment.status IN ('Approved','Rescheduled')  ORDER BY from_date ASC");
        
            while($row = $selectApproachedAppointment->fetch_assoc()){
                $message = "Hi ".$row['stud_first_name']." ".$row['stud_last_name'].", your schedule of appointment is on ".date("M-d-Y",strtotime($row['from_date']))." ".date("h:i",strtotime($row['from_time']))."-".date("h:i A",strtotime($row['to_time']))." at the NU Fairview Clinic, Thankyou";
                $receiver = substr($row['stud_contact_number'],3);
                $receiver = "0".$receiver;
                $ch = curl_init();
                $parameters = array(
                    'apikey' => 'b62ebf6819b126c0781a17aab4d5b3cf', //Your API KEY
                    'number' => $receiver,
                    'message' =>  $message,
                    'sendername' => 'SEMAPHORE'
                );
                curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
                curl_setopt( $ch, CURLOPT_POST, 1 );
                
                //Send the parameters set above with the request
                curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
                
                // Receive response from server
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                $output = curl_exec( $ch );  
                insertToNotifLogs($conn,$row['ut2_id'],"SMS (".$row['stud_contact_number'].")","Sent");
            }
        
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
        
                alert("error","SMS not sent",$error_msg,"../medical_professional/manage_notification.php");
                curl_close ($ch);
                exit;
            }
            else{
                insertToActivityLogs($conn,$user_id,"Send SMS","SMS Sent to ".$selectApproachedAppointment->num_rows." students");
                alert("success","SMS Sent to","Students","../medical_professional/manage_notification.php");
                curl_close ($ch);
                exit;
            }
            curl_close ($ch);
            exit;
        }
    }
}

$db = new DatabaseConnection();
SMSController::SendSMS($db->conn);
SMSController::MultipleSendSMS($db->conn);

?>