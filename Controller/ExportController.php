<?php 
include_once("../db-connection.php");
include_once("../Utilities/alert.php");
include_once('../Utilities/insertToActivityLogs.php');
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$record_type = $_POST['record_type'];
$year_type = $_POST['year_type'];
$user_id = $_POST['user_id'];


class ExportController extends DatabaseConnection{
    public function __construct()
    {
        parent::__construct();
    }

    public static function exportRecords($connection_string,$record_type,$year_type,$start_date,$end_date,$user_id){
        if($year_type == "College"){
            if($record_type == "Medical"){
                $file_name_start_date = date('M-d-Y',strtotime($start_date));
                $file_name_end_date = date('M-d-Y',strtotime($end_date));
                $filename = "MHR-".$file_name_start_date."_to_".$file_name_end_date.".xls";
                $selectMedicalHealthRecords = mysqli_query($connection_string,"SELECT *, medicalhealthrecord.id AS med_record_id, stud.student_id_number AS stud_id_number,medicalhealthrecord.date_created as date_created, medicalhealthrecord.expiry_date as expiry_date,u2.firstName AS stud_first_name, u2.lastName AS stud_last_name, stud.courseID AS stud_course, stud.year AS stud_year, stud.section as stud_sec,  u1.firstName AS med_first_name, u1.lastName AS med_last_name,  physicalexam.pulse_rate AS pulse_rate, physicalexam.height AS height,  physicalexam.weight AS weight, medicaltreatmentrecord.date_time AS med_record_date_time FROM medicalhealthrecord INNER JOIN students AS stud ON medicalhealthrecord.student_id = stud.id INNER JOIN medicalprofessional ON medicalprofessional.id = medicalhealthrecord.med_prof_id INNER JOIN users AS u2 ON u2.id = stud.userID INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN physicalexam ON physicalexam.mhrIDnum = medicalhealthrecord.id INNER JOIN medicaltreatmentrecord ON medicaltreatmentrecord.mhrIDnum = medicalhealthrecord.id INNER JOIN physicalexamfindings ON  physicalexam.id = physicalexamfindings.physicalExamID WHERE stud.courseID IN ('1','2','3','4','5','6','7','8','9','10','11') AND medicalhealthrecord.date_created BETWEEN '$start_date' AND '$end_date' ORDER BY medicalhealthrecord.id DESC");
                $output ='<table>
                <tr>
                <th align = "center">Date</th>
                <th align = "center">Name</th>
                <th align = "center">Course</th>
                <th align = "center">Online/Onsite</th>
                <th align = "center">Diagnosis</th>
                <th align = "center">Management</th>
                </tr>';
                while($row = $selectMedicalHealthRecords->fetch_assoc()){
                    switch($row['stud_course']){
                        case "1" : $course = "BS Accountacy"; break; 
                        case "2" : $course = "BS Architecture"; break; 
                        case "3" : $course = "BSBA Major in Financial Management"; break; 
                        case "4" : $course = "BSBA Major in Marketing Management"; break; 
                        case "5" : $course = "BS Civil Engineering"; break; 
                        case "6" : $course = "BS Computer Engineering"; break; 
                        case "7" : $course = "BS Hospitality Management"; break; 
                        case "8" : $course = "BS Psychology"; break; 
                        case "9" : $course = "BS Tourism Management"; break; 
                        case "10" : $course = "BS Information Technology"; break; 
                        case "11" : $course = "Master in Management with Specialization in Bussiness Analytics"; break; 
                        case "12" : $course = "ABM"; break; 
                        case "13" : $course = "HUMSS"; break; 
                        case "14" : $course = "STEM"; break; 
                        default : $course = "Something went wrong";
                    }
                    $output.='<tr>
                    <th align = "center">'.$row['date_created'].'</th>
                    <th align = "center">'.$row['stud_first_name'].' '. $row['stud_last_name'].'</th>
                    <th align = "center">'.$course.'</th>
                    <th align = "center">Onsite</th>
                    <th align = "center">'.$row['diagnosis'].'</th>
                    <th align = "center">'.$row['treatment'].'</th>
                    </tr>';
                } 
                $output.='</table>';
                header('Content-Type:application/xls');
                header('Content-Disposition:attachment;filename='.$filename);
                insertToActivityLogs($connection_string,$user_id,"Export Reports","Export Medical Reports ".$start_date." - ".$end_date." (".$year_type." Level)");
                echo $output;
            }
            else{  
                $file_name_start_date = date('M-d-Y',strtotime($start_date));
                $file_name_end_date = date('M-d-Y',strtotime($end_date));
                $filename = "DHR-".$file_name_start_date."_to_".$file_name_end_date.".xls";
                $selectDentalHealthRecords = mysqli_query($connection_string,"SELECT *, dentalhealthrecord.id AS den_record_id, stud.student_id_number AS stud_id_number, u2.firstName AS stud_first_name, u2.lastName AS stud_last_name, u2.middleName as stud_middle_name, stud.birthdate AS stud_dob, stud.age as stud_age,stud.sex AS stud_sex,stud.nationality AS stud_nationality,stud.religion AS stud_religion, stud.contact_number AS stud_contact_number, u2.email_address AS stud_email_address, stud.courseID AS stud_course, stud.year as stud_year, stud.section as stud_sec ,stud.province as stud_province,stud.city_municipality as stud_city_municipality, stud.barangay as stud_barangay, u2.profile_img AS stud_avatar   FROM dentalhealthrecord INNER JOIN students AS stud ON dentalhealthrecord.student_id = stud.id INNER JOIN users AS u2 ON u2.id = stud.userID INNER JOIN dentalexam ON dentalexam.dhrIDnum = dentalhealthrecord.id INNER JOIN dentaltreatmentrecord ON dentaltreatmentrecord.dhrIDnum = dentalhealthrecord.id WHERE stud.courseID IN ('1','2','3','4','5','6','7','8','9','10','11') AND dentalhealthrecord.date_created BETWEEN '$start_date' AND '$end_date' ORDER BY dentalhealthrecord.id DESC");
                $output ='<table>
                <tr>
                <th align = "center">Date</th>
                <th align = "center">Name</th>
                <th align = "center">Course</th>
                <th align = "center">Online/Onsite</th>
                <th align = "center">Diagnosis</th>
                <th align = "center">Management</th>
                </tr>';
                while($row = $selectDentalHealthRecords->fetch_assoc()){
                    switch($row['stud_course']){
                        case "1" : $course = "BS Accountacy"; break; 
                        case "2" : $course = "BS Architecture"; break; 
                        case "3" : $course = "BSBA Major in Financial Management"; break; 
                        case "4" : $course = "BSBA Major in Marketing Management"; break; 
                        case "5" : $course = "BS Civil Engineering"; break; 
                        case "6" : $course = "BS Computer Engineering"; break; 
                        case "7" : $course = "BS Hospitality Management"; break; 
                        case "8" : $course = "BS Psychology"; break; 
                        case "9" : $course = "BS Tourism Management"; break; 
                        case "10" : $course = "BS Information Technology"; break; 
                        case "11" : $course = "Master in Management with Specialization in Bussiness Analytics"; break; 
                        case "12" : $course = "ABM"; break; 
                        case "13" : $course = "HUMSS"; break; 
                        case "14" : $course = "STEM"; break; 
                        default : $course = "Something went wrong";
                    }
                    $output.='<tr>
                    <th align = "center">'.$row['date_created'].'</th>
                    <th align = "center">'.$row['stud_first_name'].' '. $row['stud_last_name'].'</th>
                    <th align = "center">'.$course.'</th>
                    <th align = "center">Onsite</th>
                    <th align = "center">'.$row['diagnosis'].'</th>
                    <th align = "center">'.$row['detailsofservicesrendered'].'</th>
                    </tr>';
                } 
                $output.='</table>';
                header('Content-Type:application/xls');
                header('Content-Disposition:attachment;filename='.$filename);
                insertToActivityLogs($connection_string,$user_id,"Export Reports","Export Dental Reports ".$start_date." - ".$end_date." (".$year_type." Level)");
                echo $output;
                
            }
        }
        else{
            if($record_type == "Medical"){
                $file_name_start_date = date('M-d-Y',strtotime($start_date));
                $file_name_end_date = date('M-d-Y',strtotime($end_date));
                $filename = "MHR-".$file_name_start_date."_to_".$file_name_end_date.".xls";
                $selectMedicalHealthRecords = mysqli_query($connection_string,"SELECT *, medicalhealthrecord.id AS med_record_id, stud.student_id_number AS stud_id_number, u2.firstName AS stud_first_name, u2.lastName AS stud_last_name,u2.middleName AS stud_middle_name, stud.courseID AS stud_course, stud.year as stud_year, stud.section as stud_sec, stud.birthdate AS stud_dob, stud.age as stud_age, stud.sex as stud_sex, stud.nationality AS stud_nationality, stud.religion as stud_religion, stud.contact_number as stud_contact_number, u2.email_address as stud_email_address,stud.province as stud_province,stud.city_municipality as stud_city_municipality, stud.barangay as stud_barangay, medicaltreatmentrecord.date_time AS med_record_date_time, u1.firstName as med_first_name, u1.middleName as med_middle_name, u1.lastName as med_last_name, u2.profile_img as stud_avatar  FROM medicalhealthrecord INNER JOIN students AS stud ON medicalhealthrecord.student_id = stud.id INNER JOIN users AS u2 ON u2.id = stud.userID INNER JOIN physicalexam ON physicalexam.mhrIDnum =  medicalhealthrecord.id INNER JOIN physicalexamfindings ON physicalexam.id = physicalexamfindings.physicalExamId INNER JOIN medicaltreatmentrecord ON medicalhealthrecord.id = medicaltreatmentrecord.mhrIDnum INNER JOIN medicalprofessional ON medicaltreatmentrecord.mhrIDnum = medicalprofessional.id INNER JOIN users AS u1 ON medicalprofessional.userID = u1.id INNER JOIN medicalhistory ON  medicalhistory.mhrIDnum = medicalhealthrecord.id INNER JOIN medicalhistoryofdisease ON  medicalhistory.id = medicalhistoryofdisease.medhistoryID WHERE stud.courseID IN ('12','13','14') AND medicalhealthrecord.date_created BETWEEN '$start_date' AND '$end_date' ORDER BY medicalhealthrecord.id DESC");
                $output ='<table>
                <tr>
                <th align = "center">Date</th>
                <th align = "center">Name</th>
                <th align = "center">Course</th>
                <th align = "center">Online/Onsite</th>
                <th align = "center">Diagnosis</th>
                <th align = "center">Management</th>
                </tr>';
                while($row = $selectMedicalHealthRecords->fetch_assoc()){
                    switch($row['stud_course']){
                        case "1" : $course = "BS Accountacy"; break; 
                        case "2" : $course = "BS Architecture"; break; 
                        case "3" : $course = "BSBA Major in Financial Management"; break; 
                        case "4" : $course = "BSBA Major in Marketing Management"; break; 
                        case "5" : $course = "BS Civil Engineering"; break; 
                        case "6" : $course = "BS Computer Engineering"; break; 
                        case "7" : $course = "BS Hospitality Management"; break; 
                        case "8" : $course = "BS Psychology"; break; 
                        case "9" : $course = "BS Tourism Management"; break; 
                        case "10" : $course = "BS Information Technology"; break; 
                        case "11" : $course = "Master in Management with Specialization in Bussiness Analytics"; break; 
                        case "12" : $course = "ABM"; break; 
                        case "13" : $course = "HUMSS"; break; 
                        case "14" : $course = "STEM"; break; 
                        default : $course = "Something went wrong";
                    }
                    $output.='<tr>
                    <th align = "center">'.$row['date_created'].'</th>
                    <th align = "center">'.$row['stud_first_name'].' '. $row['stud_last_name'].'</th>
                    <th align = "center">'.$course.'</th>
                    <th align = "center">Onsite</th>
                    <th align = "center">'.$row['diagnosis'].'</th>
                    <th align = "center">'.$row['treatment'].'</th>
                    </tr>';
                } 
                $output.='</table>';
                header('Content-Type:application/xls');
                header('Content-Disposition:attachment;filename='.$filename);
                insertToActivityLogs($connection_string,$user_id,"Export Reports","Export Medical Reports ".$start_date." - ".$end_date." (".$year_type." Level)");
                echo $output;
            }
            else{  
                $file_name_start_date = date('M-d-Y',strtotime($start_date));
                $file_name_end_date = date('M-d-Y',strtotime($end_date));
                $filename = "DHR-".$file_name_start_date."_to_".$file_name_end_date.".xls";
                $selectDentalHealthRecords = mysqli_query($connection_string,"SELECT *, dentalhealthrecord.id AS den_record_id, stud.student_id_number AS stud_id_number, u2.firstName AS stud_first_name, u2.lastName AS stud_last_name, u2.middleName as stud_middle_name, stud.birthdate AS stud_dob, stud.age as stud_age,stud.sex AS stud_sex,stud.nationality AS stud_nationality,stud.religion AS stud_religion, stud.contact_number AS stud_contact_number, u2.email_address AS stud_email_address, stud.courseID AS stud_course, stud.year as stud_year, stud.section as stud_sec ,stud.province as stud_province,stud.city_municipality as stud_city_municipality, stud.barangay as stud_barangay, u2.profile_img AS stud_avatar   FROM dentalhealthrecord INNER JOIN students AS stud ON dentalhealthrecord.student_id = stud.id INNER JOIN users AS u2 ON u2.id = stud.userID INNER JOIN dentalexam ON dentalexam.dhrIDnum = dentalhealthrecord.id INNER JOIN dentaltreatmentrecord ON dentaltreatmentrecord.dhrIDnum = dentalhealthrecord.id WHERE stud.courseID IN ('12','13','14') AND dentalhealthrecord.date_created BETWEEN '$start_date' AND '$end_date' ORDER BY dentalhealthrecord.id DESC");
                $output ='<table>
                <tr>
                <th align = "center">Date</th>
                <th align = "center">Name</th>
                <th align = "center">Course</th>
                <th align = "center">Online/Onsite</th>
                <th align = "center">Diagnosis</th>
                <th align = "center">Management</th>
                </tr>';
                while($row = $selectDentalHealthRecords->fetch_assoc()){
                    switch($row['stud_course']){
                        case "1" : $course = "BS Accountacy"; break; 
                        case "2" : $course = "BS Architecture"; break; 
                        case "3" : $course = "BSBA Major in Financial Management"; break; 
                        case "4" : $course = "BSBA Major in Marketing Management"; break; 
                        case "5" : $course = "BS Civil Engineering"; break; 
                        case "6" : $course = "BS Computer Engineering"; break; 
                        case "7" : $course = "BS Hospitality Management"; break; 
                        case "8" : $course = "BS Psychology"; break; 
                        case "9" : $course = "BS Tourism Management"; break; 
                        case "10" : $course = "BS Information Technology"; break; 
                        case "11" : $course = "Master in Management with Specialization in Bussiness Analytics"; break; 
                        case "12" : $course = "ABM"; break; 
                        case "13" : $course = "HUMSS"; break; 
                        case "14" : $course = "STEM"; break; 
                        default : $course = "Something went wrong";
                    }
                    $output.='<tr>
                    <th align = "center">'.$row['date_created'].'</th>
                    <th align = "center">'.$row['stud_first_name'].' '. $row['stud_last_name'].'</th>
                    <th align = "center">'.$course.'</th>
                    <th align = "center">Onsite</th>
                    <th align = "center">'.$row['diagnosis'].'</th>
                    <th align = "center">'.$row['detailsofservicesrendered'].'</th>
                    </tr>';
                } 
                $output.='</table>';
                header('Content-Type:application/xls');
                header('Content-Disposition:attachment;filename='.$filename);
                insertToActivityLogs($connection_string,$user_id,"Export Reports","Export Dental Reports ".$start_date." - ".$end_date." (".$year_type." Level)");
                echo $output;
                
            }
        }
    
        
    }
}
$db = new DatabaseConnection();


ExportController::exportRecords($db->conn,$record_type,$year_type,$start_date,$end_date,$user_id);





?>