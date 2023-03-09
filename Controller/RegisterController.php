<?php 
include_once('../Utilities/calculate-age.php'); //include file
include_once('../db-connection.php'); //include file
include_once('../Utilities/alert.php'); //include file
include_once('../Utilities/insertToActivityLogs.php');
// require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once("../vendor/phpmailer/src/PHPMailer.php");
// require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';
require_once("../vendor/phpmailer/src/SMTP.php");
require_once("../vendor/phpmailer/src/Exception.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class RegisterController extends DatabaseConnection{

    public function __construct()
    {
        parent::__construct();
    }

    public static function addStudent($conn){
        if(isset($_POST['register'])){  
            $firstName = $_POST['firstname'];
            empty($_POST['middle_name']) ? $middleName = "" : $middleName = $_POST['middlename']; //setting optional middlename
            $lastName = $_POST['lastname'];
            $birthDate = $_POST['birthdate'];
            $province = $_POST['province_name'];
            $city_municipality = $_POST['municipality_name'];
            $barangay = $_POST['barangay_name'];
            $contact_number = "+63".$_POST['contact_number'];
            $sex = $_POST['sex'];
            $religion = $_POST['religion'];
            $nationality = $_POST['nationality'];
            $student_id_number = $_POST['student_id_number'];
            $year = $_POST['year'];                                                                 //]getting user input
            $section = $_POST['section'];
            $courseID = $_POST['courseID'];
            $emergnecy_person_name = $_POST['emergency_person_name'];

            $_POST['relationship'] == "Others" ? $relationship = $_POST['relationship_others'] : $relationship =  $_POST['relationship'];
            $emergency_address = $_POST['emergency_address'];
            $emergency_contact_number = "+63".$_POST['emergency_contact_number'];
            $email_address = $_POST['email_address'];
            $password = $_POST['password'];
            
            $age = calculateAge($birthDate);//calculate age based on birthdate
            $user_type_id = 2;
            $status = "Active";

            $streetname = $_POST['streetname'];
            $housenumber = $_POST['barangay'];

            $user_id = $_POST['user_id'];
        
            $check_duplicate = mysqli_query($conn,"SELECT * FROM nuhrs.students WHERE student_id_number='$student_id_number'");
            //check if user is existing
            if($check_duplicate->num_rows > 0){//if existing
                alert("error","Student ID Number Already Exist","","../medical_professional/manage-student.php");//error message
            }
            else{
                $insertToUsers = mysqli_query($conn,"INSERT INTO users(user_type_id, firstName, middleName, lastName, password, email_address) VALUES ('$user_type_id','$firstName','$middleName','$lastName','$password','$email_address')");//insert into user table
        
                $selectId = mysqli_query($conn,"SELECT id FROM users WHERE email_address='$email_address'");
                $row = $selectId->fetch_assoc();
                $userID = $row['id'];
        
                if($insertToUsers){
                    $insertToStudents = mysqli_query($conn,"INSERT INTO students(student_id_number, userID, birthdate, province,city_municipality,barangay,streetname,housenumber,courseID, nationality, year, section, sex, contact_number, religion, age, emergency_contact_number, emergency_address, emergency_relationship, emergency_person_name,status) VALUES ('$student_id_number','$userID','$birthDate','$province','$city_municipality','$barangay','$streetname','$housenumber','$courseID','$nationality','$year','$section','$sex','$contact_number','$religion','$age','$emergency_contact_number','$emergency_address','$relationship','$emergnecy_person_name','$status')"); //insert into students table
        
                    if($insertToStudents){//if query success 
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
                        $outlook_mail->FromName = 'NU Fairview Clinic';// frome name
                        $outlook_mail->AddAddress($email_address);  // Add a recipient  to name
                        // $outlook_mail->AddAddress('to-Outlook-address@Outlook.com');  // Name is optional
                        
                        $outlook_mail->IsHTML(true); // Set email format to HTML
                        $outlook_mail->Subject = 'NUHRS Account Credentials';
                        $message = "NU Clinic Health Record System Account Credentials<br> Email: ".$email_address." <br>Password: ".$password."<br><br>Go to this link to login your account: https://clinic.nuhrs.online/login.php<br><br><p style='color:red;'>Please do not share your account from others<p>";
                        $outlook_mail->Body  = $message;
                        // $outlook_mail->AltBody = 'This is the body in plain text for non-HTML mail clients at https://onlinecode.org/';
        
                        $outlook_mail->Send();

                        insertToActivityLogs($conn,$user_id,"Add Student","Add ".$firstName." ".$lastName."(".$student_id_number.")");
                        alert("success","Student Successfully Added","","../medical_professional/manage-student.php");//success message
                    }
                    else{
                        alert("error","Something went wrong","","../medical_professional/manage-student.php");//error message
                    }
                }
                else{
                    alert("error","Something went wrong","","../medical_professional/manage-student.php");//error message
                }
            }
        }
    }
}

$db = new DatabaseConnection();
RegisterController::addStudent($db->conn);


