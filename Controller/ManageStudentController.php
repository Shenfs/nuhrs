<?php 
include_once('../db-connection.php'); //include file
include_once('../Utilities/alert.php'); //include file
include_once('../Utilities/insertToActivityLogs.php');

date_default_timezone_set("Asia/Manila"); //set timezone to manila
include_once('../Utilities/calculate-age.php');
class ManageUserController extends DatabaseConnection{

    public function __construct()
    {
        parent::__construct();
    }

    public static function updateStudent($conn){
        if(isset($_POST['update_student'])){
            $user_id = $_POST['user_id'];
            $student_id = $_POST['stud_id'];
            $first_name = $_POST['first_name'];
            empty($_POST['middle_name']) ? $middle_name = "" : $middle_name = $_POST['middle_name'];
            $last_name = $_POST['last_name'];
            $email_address = $_POST['email_address'];
            $student_id_number = $_POST['student_id_number'];
            $birthdate = $_POST['birthdate'];
            $age = calculateAge($birthdate);
            
            $courseID = $_POST['course'];
            $nationality = $_POST['nationality'];
            $year = $_POST['year'];
            $section = $_POST['section'];
            $sex = $_POST['sex'];
            $contact_number = "+63".$_POST['contact_number'];
            $religion = $_POST['religion'];
            $age = $_POST['age'];
            $emergency_contact_number = "+63".$_POST['emergency_contact_number'];
            $emergency_address = $_POST['emergency_address'];
            $emergy_relationship = $_POST['emergency_relationship'];
            $emergy_person_name = $_POST['emergency_person_name'];
            $status = $_POST['status'];
            $user_id = $_POST['user_id'];
        
        
            $check_duplicate = mysqli_query($conn,"SELECT * FROM nuhrs.students INNER JOIN users ON students.userID = users.id WHERE student_id_number='$student_id_number' AND users.id !='$user_id'");
            //check if user is existing
            if($check_duplicate->num_rows > 0){//if existing
                alert("error","Student ID Number already Exist","","../medical_professional/manage-student.php");//error message
            }
            else{
                $updateUser = mysqli_query($conn,"UPDATE users SET firstName='$first_name',middleName='$middle_name',lastName='$last_name',email_address='$email_address' WHERE id='$user_id'");
        
                if($updateUser){
                    insertToActivityLogs($conn,$user_id,"Update Student","Update ".$first_name." ".$last_name."(".$student_id_number.")");
                    $updateStudent = mysqli_query($conn,"UPDATE students SET student_id_number='$student_id_number',birthdate='$birthdate',courseID='$courseID',nationality='$nationality',year='$year',section='$section',sex='$sex',contact_number='$contact_number',religion='$religion',age='$age',emergency_contact_number='$emergency_contact_number',emergency_address='$email_address',emergency_relationship='$emergy_relationship',emergency_person_name='$emergy_person_name',status='$status' WHERE id='$student_id'");
            
                    if($updateStudent){
                        alert("success","Student Successfuly Updated","","../medical_professional/manage-student.php");//error message
                    }
                    else{
                        alert("error","There was an error","","../medical_professional/manage-student.php");//error message
                    }
                }
                else{
                    alert("error","There was an error","","../medical_professional/manage-student.php");//error message
                }
            }
        }
           
    }
    
}

$db = new DatabaseConnection();
ManageUserController::updateStudent($db->conn);

?>