<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once("vendor/phpmailer/src/PHPMailer.php");
// require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';
require_once("vendor/phpmailer/src/SMTP.php");
require_once("vendor/phpmailer/src/Exception.php");
date_default_timezone_set('Asia/Manila');
require_once("db-connection.php");
include_once('Utilities/insertToNotifLogs.php');
$db = new DatabaseConnection();
$conn = $db->conn;
$datenow = date('Y-m-d');
$dateTomorrow = date('Y-m-d',strtotime($datenow . ' +1 day'));
$selectAppoitnentTomorow = mysqli_query($conn,"SELECT *, appointment.id AS appointment_id, ut2.firstName AS stud_first_name, ut2.lastName AS stud_last_name, ut1.firstName AS med_first_name, ut1.lastName AS med_last_name, ut2.email_address AS stud_email, ut2.id AS ut2_id,  students.contact_number AS stud_contact_number FROM appointment INNER JOIN medicalprofessional ON appointment.medprofID = medicalprofessional.id INNER JOIN students ON students.id = appointment.student_id INNER JOIN users AS ut1 ON ut1.id = medicalprofessional.userID INNER JOIN users AS ut2 ON ut2.id = students.userID WHERE from_date='$dateTomorrow' AND appointment.status IN ('Approved','Rescheduled')  ORDER BY from_date ASC");
if($selectAppoitnentTomorow->num_rows > 0){
    while($row = $selectAppoitnentTomorow->fetch_assoc()){
        $receiver = $row['stud_email'];
        $EmailMessage = "Hi ".$row['stud_first_name']." ".$row['stud_last_name'].", your schedule of appointment is on ".date("M-d-Y",strtotime($row['from_date']))." ".date("h:i",strtotime($row['from_time']))."-".date("h:i A",strtotime($row['to_time']))." at the NU Fairview Clinic, Thankyou";
    
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
        $outlook_mail->Body    = $EmailMessage;
        // $outlook_mail->AltBody = 'This is the body in plain text for non-HTML mail clients at https://onlinecode.org/';
    
        $outlook_mail->Send();
    
        insertToNotifLogs($conn,$row['ut2_id'],"Email (".$receiver.")","Sent");
    
        $SMSmessage = "Hi ".$row['stud_first_name']." ".$row['stud_last_name'].", your schedule of appointment is on ".date("M-d-Y",strtotime($row['from_date']))." ".date("h:i",strtotime($row['from_time']))."-".date("h:i A",strtotime($row['to_time']))." at the NU Fairview Clinic, Thankyou";
            $receiver = substr($row['stud_contact_number'],3);
            $receiver = "0".$receiver;
            $ch = curl_init();
            $parameters = array(
                'apikey' => 'b62ebf6819b126c0781a17aab4d5b3cf', //Your API KEY
                'number' => $receiver,
                'message' =>  $SMSmessage,
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
}
else{
    exit;
}


?>