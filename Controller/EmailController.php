<?php 
include_once('../Utilities/alert.php'); //include file
include_once('../Utilities/insertToNotifLogs.php');
include_once('../Utilities/insertToActivityLogs.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once("../vendor/phpmailer/src/PHPMailer.php");
// require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';
require_once("../vendor/phpmailer/src/SMTP.php");
require_once("../vendor/phpmailer/src/Exception.php");

include_once("../db-connection.php");

class EmailController extends DatabaseConnection{

    public function __construct()
    {
        parent::__construct();
    }

    public static function sendEmail($conn){
        if(isset($_POST['send_email'])){
            $user_id = $_POST['user_id'];
            $receiver = $_POST['receiver'];
            $message = $_POST['message'];
        
            $outlook_mail = new PHPMailer;
         
            $outlook_mail->IsSMTP();
            // Send email using Outlook SMTP server
            $outlook_mail->Host = 'smtp-mail.outlook.com';
            // port for Send email
            $outlook_mail->Port = 587;
            $outlook_mail->SMTPSecure = 'tls';
            $outlook_mail->SMTPDebug = 0;
            $outlook_mail->SMTPAuth = true;
            $outlook_mail->Username = 'nahialet@student.apc.edu.ph'; //sender email
            $outlook_mail->Password = 'Nahialet230051'; //sender password
            
            $outlook_mail->From = 'nahialet@student.apc.edu.ph'; //sender email
            $outlook_mail->FromName = 'NUHRS';// frome name
            $outlook_mail->AddAddress($receiver);  // Add a recipient  to name
            // $outlook_mail->AddAddress('to-Outlook-address@Outlook.com');  // Name is optional
            
            $outlook_mail->IsHTML(true); // Set email format to HTML
            
            $outlook_mail->Subject = 'NUHRS Clinic';
            $outlook_mail->Body    = $message;
            // $outlook_mail->AltBody = 'This is the body in plain text for non-HTML mail clients at https://onlinecode.org/';
            
            if(!$outlook_mail->Send()) {
                insertToNotifLogs($conn,$user_id,"Email (".$receiver.")","Not Sent");
                alert("error","Email not Sent",$outlook_mail->ErrorInfo,"../medical_professional/manage_notification.php");
                exit;
            }
            else
            {
                insertToNotifLogs($conn,$user_id,"Email (".$receiver.")","Sent");
                insertToActivityLogs($conn,$user_id,"Sent Email","Sent Email to".$receiver);
                alert("success","Email Sent","to $receiver","../medical_professional/manage_notification.php");
            }
        }
    }

    public static function multipleSendEmail($conn){
        if(isset($_POST['send_all_notif'])){
    
            $selectApproachedAppointment = mysqli_query($conn,"SELECT *, appointment.id AS appointment_id, ut2.firstName AS stud_first_name, ut2.lastName AS stud_last_name, ut1.firstName AS med_first_name, ut1.lastName AS med_last_name, ut2.email_address AS stud_email, ut2.id AS ut2_id FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON students.id = appointment.student_id INNER JOIN users AS ut1 ON ut1.id = medicalprofessional.userID INNER JOIN users AS ut2 ON ut2.id = students.userID WHERE YEAR(from_date) = YEAR(NOW()) AND MONTH(from_date) = MONTH(NOW()) AND DAY(from_date) >= DAY(NOW()) AND appointment.status IN ('Approved','Rescheduled')  ORDER BY from_date ASC");
        
        
            while($row = $selectApproachedAppointment->fetch_assoc()){
                
        
                $receiver = $row['stud_email'];
                $message = "Hi ".$row['stud_first_name']." ".$row['stud_last_name'].", your schedule of appointment is on ".date("M-d-Y",strtotime($row['from_date']))." ".date("h:i",strtotime($row['from_time']))."-".date("h:i A",strtotime($row['to_time']))." at the NU Fairview Clinic, Thankyou";
        
                $outlook_mail = new PHPMailer;
         
                $outlook_mail->IsSMTP();
                // Send email using Outlook SMTP server
                $outlook_mail->Host = 'smtp-mail.outlook.com';
                // port for Send email
                $outlook_mail->Port = 587;
                $outlook_mail->SMTPSecure = 'tls';
                $outlook_mail->SMTPDebug = 0;
                $outlook_mail->SMTPAuth = true;
                $outlook_mail->Username = 'nahialet@student.apc.edu.ph'; //sender email
                $outlook_mail->Password = 'Nahialet230051'; //sender password
                
                $outlook_mail->From = 'nahialet@student.apc.edu.ph'; //sender email
                $outlook_mail->FromName = 'NUHRS';// frome name
                $outlook_mail->AddAddress($receiver);  // Add a recipient  to name
                // $outlook_mail->AddAddress('to-Outlook-address@Outlook.com');  // Name is optional
                
                $outlook_mail->IsHTML(true); // Set email format to HTML
                
                $outlook_mail->Subject = 'NUHRS Clinic';
                $outlook_mail->Body    = $message;
                // $outlook_mail->AltBody = 'This is the body in plain text for non-HTML mail clients at https://onlinecode.org/';
        
                $outlook_mail->Send();
        
                insertToNotifLogs($conn,$row['ut2_id'],"Email (".$receiver.")","Sent");
               
                
            }
        
            if(!$outlook_mail->Send()) {
                
                alert("error","Emails not sent",$outlook_mail->ErrorInfo,"../medical_professional/manage_notification.php");
                exit;
            }
            else
            {
                insertToActivityLogs($conn,$row['ut2_id'],"Sent Email","Sent Email to ".$selectApproachedAppointment->num_rows." students");
                alert("success","Emails Sent","","../medical_professional/manage_notification.php");
            }
        }
    }
}

$db = new DatabaseConnection();
EmailController::sendEmail($db->conn);
EmailController::multipleSendEmail($db->conn);




?>