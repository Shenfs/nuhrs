<?php 
require('../vendor/fpdf/fpdf.php');
require_once("../db-connection.php");
$db = new DatabaseConnection();
$conn = $db->conn;
$med_record_id = $_POST['medical_health_record_id'];
$selectMedicalHealthRecords = mysqli_query($conn,"SELECT *, medicalhealthrecord.id AS med_record_id, stud.student_id_number AS stud_id_number, u2.firstName AS stud_first_name, u2.lastName AS stud_last_name,u2.middleName AS stud_middle_name, stud.courseID AS stud_course, stud.year as stud_year, stud.section as stud_sec, stud.birthdate AS stud_dob, stud.age as stud_age, stud.sex as stud_sex, stud.nationality AS stud_nationality, stud.religion as stud_religion, stud.contact_number as stud_contact_number, u2.email_address as stud_email_address,stud.province as stud_province,stud.city_municipality as stud_city_municipality, stud.barangay as stud_barangay, medicaltreatmentrecord.date_time AS med_record_date_time, u1.firstName as med_first_name, u1.middleName as med_middle_name, u1.lastName as med_last_name, u2.profile_img as stud_avatar  FROM medicalhealthrecord INNER JOIN students AS stud ON medicalhealthrecord.student_id = stud.id INNER JOIN medicalprofessional ON medicalprofessional.id = medicalhealthrecord.med_prof_id INNER JOIN medicaltreatmentrecord ON medicaltreatmentrecord.mhrIDnum = medicalhealthrecord.id INNER JOIN medicalhistory ON medicalhistory.mhrIDnum = medicalhealthrecord.id INNER JOIN medicalhistoryofdisease ON medicalhistoryofdisease.medhistoryID = medicalhistory.id INNER JOIN physicalexam ON medicalhealthrecord.id = physicalexam.mhrIDnum INNER JOIN physicalexamfindings ON physicalexamfindings.physicalExamID = physicalexam.id INNER JOIN users AS u1 ON medicalprofessional.userID = u1.id INNER JOIN users AS u2 ON stud.userID = u2.id WHERE medicalhealthrecord.id = '$med_record_id' ORDER BY medicalhealthrecord.id DESC");

$row = $selectMedicalHealthRecords->fetch_assoc();

switch($row['courseID']){
    case "1" : $stud_course = "BSA"; break; 
    case "2" : $stud_course = "BSArch"; break; 
    case "3" : $stud_course = "BSBA-FM"; break; 
    case "4" : $stud_course = "BSBA-MktgMgt"; break; 
    case "5" : $stud_course = "BSCE"; break; 
    case "6" : $stud_course = "BSCPE"; break; 
    case "7" : $stud_course = "BSHM"; break; 
    case "8" : $stud_course = "BSPSY"; break; 
    case "9" : $stud_course = "BSTM"; break; 
    case "10" : $stud_course = "BSIT"; break; 
    case "11" : $stud_course = "MM-BA"; break; 
    case "12" : $stud_course = "ABM"; break; 
    case "13" : $stud_course = "HUMSS"; break; 
    case "14" : $stud_course = "STEM"; break; 
    default : $stud_course = "Something went wrong";
}


$pdf = new FPDF(); 
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

$pdf->Image('MEDICAL_RECORD_FORM_students-converted_page-0001.jpg',10,10,189);
$pdf->Cell(180 ,8,'',0,1);
$pdf->Cell(180 ,8,'',0,1);
$pdf->Cell(180 ,8,'',0,1);
$pdf->Cell(180 ,8,'',0,1);
$pdf->Cell(180 ,8,'',0,1);
$pdf->Cell(180 ,8,'',0,1);
$pdf->Cell(90 ,8,'',0,0);
$pdf->Cell(75 ,8,$row['date_created'],0,1,"R");
$pdf->Cell(25 ,8,'',0,0);
$pdf->Cell(23 ,8,$row['stud_last_name'],0,0,"C");
$pdf->Cell(28 ,8,$row['stud_first_name'],0,0,"C");
$pdf->Cell(23 ,8,ucfirst(substr($row['stud_middle_name'], 0, 1)).".",0,0,"R");
$pdf->Cell(58 ,8,$row['stud_id_number'],0,1,"R");
$pdf->Cell(138 ,5,'',0,0);
$pdf->Cell(42 ,5,$stud_course."/".$row['year'],0,1,"L");
$pdf->Cell(25 ,5,'',0,0);
$pdf->Cell(155 ,5,$row['housenumber']." ".$row['streetname'].", ".$row['stud_barangay']." ".$row['stud_city_municipality'].", ".$row['stud_province'],0,1,"L");
$pdf->Cell(126 ,8,'',0,0);
$pdf->Cell(54 ,8,$row['stud_contact_number'],0,1,"C");
$pdf->Cell(20,7,"",0,0);
$pdf->Cell(40 ,7,date("m-d-Y", strtotime($row['stud_dob'])),0,0,"C");
$pdf->Cell(10 ,7,$row['stud_age'],0,0,"C");
$pdf->Cell(25 ,7,$row['stud_sex'],0,0,"C");
$pdf->Cell(13 ,7,'',0,0);
$pdf->Cell(25 ,7,ucfirst($row['stud_nationality']),0,0,"C");
$pdf->Cell(15 ,7,'',0,0);
$pdf->Cell(32 ,7,$row['stud_religion'],0,1,"C");
$pdf->Cell(180 ,3,'',0,1);
$pdf->Cell(56 ,8,'',0,0);
$pdf->Cell(80 ,8,$row['emergency_person_name'],0,0,"C");
$pdf->Cell(44 ,8,$row['emergency_relationship'],0,1,"C");
$pdf->Cell(25 ,5,'',0,0);
$pdf->Cell(110 ,5,$row['emergency_address'],0,0);
$pdf->Cell(45 ,5,$row['emergency_contact_number'],0,1,"C");
$pdf->Cell(180 ,15,'',0,1);
$pdf->Cell(80 ,6,'',0,0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100 ,7,$row['history_of_previous_illness_or_surgery'],0,1,"L");
$pdf->Cell(22 ,7,'',0,0);
$pdf->Cell(55 ,7,$row['allergy_description'],0,0,"L");
$pdf->Cell(14 ,7,'',0,0);
$pdf->Cell(42 ,7,$row['asthma_description'],0,0,"L");
$pdf->Cell(5 ,7,'',0,0);
$pdf->Cell(42 ,7,$row['tb_description'],0,1,"L");
$pdf->Cell(38 ,7,'',0,0);
$pdf->Cell(40 ,7,$row['diabetes_description'],0,0,"L");
$pdf->Cell(23 ,7,'',0,0);
$pdf->Cell(33 ,7,$row['heart_description'],0,0,"L");
$pdf->Cell(8 ,7,'',0,0);
$pdf->Cell(38 ,7,$row['hpn_description'],0,1,"L");
$pdf->Cell(34 ,7,'',0,0);
$pdf->Cell(44 ,7,$row['kidney_description'],0,0,"L");
$pdf->Cell(41 ,7,'',0,0);
$pdf->Cell(61 ,7,$row['gynecological_description'],0,1,"L");
$pdf->Cell(23 ,7,'',0,0,"L");
$pdf->Cell(55 ,7,$row['smoker_description'],0,0,"L");
$pdf->Cell(28 ,7,'',0,0);
$pdf->Cell(74 ,7,$row['alcoholic_description'],0,1,"L");
$pdf->Cell(180 ,16,'',0,1);
$pdf->Cell(15 ,5,'',0,0);
$pdf->Cell(30 ,5,$row['systolic']."/".$row['diastolic'],0,0,"C");
$pdf->Cell(5 ,5,'',0,0);
$pdf->Cell(30 ,5,$row['pulse_rate']." bpm",0,0,"C");
$pdf->Cell(11 ,5,'',0,0);
$pdf->Cell(38 ,5,$row['height']." cm",0,0,"C");
$pdf->Cell(13 ,5,'',0,0);
$pdf->Cell(38 ,5,$row['weight']." kg",0,1,"C");
$pdf->Cell(18 ,5,'',0,0);
$pdf->Cell(162 ,5,$row['skin'],0,1,"L");
$pdf->Cell(18 ,5,'',0,0);
$pdf->Cell(68 ,5,$row['eyes'],0,0,"L");
$pdf->Cell(7 ,5,'',0,0);
$pdf->Cell(38 ,5,$row['OD'],0,0,"L");
$pdf->Cell(6 ,5,'',0,0);
$pdf->Cell(43 ,5,$row['OS'],0,1,"L");

$pdf->Cell(18 ,5,'',0,0);
$pdf->Cell(68 ,5,$row['ears'],0,0,"L");
$pdf->Cell(7 ,5,'',0,0);
$pdf->Cell(38 ,5,$row['AD'],0,0,"L");
$pdf->Cell(6 ,5,'',0,0);
$pdf->Cell(43 ,5,$row['AS_findings'],0,1,"L");

$pdf->Cell(18 ,4,'',0,0);
$pdf->Cell(162 ,4,$row['nose'],0,1,"L");

$pdf->Cell(21 ,4,'',0,0);
$pdf->Cell(159 ,4,$row['throat'],0,1,"L");

$pdf->Cell(18 ,5,'',0,0);
$pdf->Cell(162 ,5,$row['neck'],0,1,"L");

$pdf->Cell(22 ,5,'',0,0);
$pdf->Cell(158 ,5,$row['thorax'],0,1,"L");

$pdf->Cell(20 ,5,'',0,0);
$pdf->Cell(160 ,5,$row['heart'],0,1,"L");

$pdf->Cell(20 ,4,'',0,0);
$pdf->Cell(160 ,4,$row['lungs'],0,1,"L");

$pdf->Cell(26 ,4,'',0,0);
$pdf->Cell(154 ,4,$row['abdomen'],0,1,"L");

$pdf->Cell(28 ,5,'',0,0);
$pdf->Cell(152 ,5,$row['extremeties'],0,1,"L");

$pdf->Cell(28 ,5,'',0,0);
$pdf->Cell(152 ,5,$row['deformities'],0,1,"L");

$pdf->Cell(50 ,5,'',0,0);
$pdf->Cell(130 ,5,'',0,1,"L");
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(180 ,8,'',0,1);
$pdf->Cell(122 ,5,'',0,0);
$pdf->Cell(58 ,5, $row['med_first_name']." ".$row['med_last_name']." / ".$row['date_created'],0,1,"C");





$pdf->AddPage();
$pdf->Image('MEDICAL_RECORD_FORM_students-converted_page-0002.jpg',10,10,189);
$pdf->Cell(180 ,36,'',0,1);
$pdf->Cell(10 ,100,'',0,0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(22 ,10,date('m/d/y', strtotime($row['date_time'])),0,0,"C");
$pdf->MultiAlignCell(58 ,10,$row['complaints']."/".$row['diagnosis'],0,0, "C",false);
$pdf->MultiAlignCell(55 ,10,$row['treatment'],0,0, "C",false);
$pdf->MultiAlignCell(34 ,10,$row['med_first_name']." ".$row['med_last_name'],0,0, "C",false);
$pdf->Cell(1 ,100,'',0,0);
$pdf->Output();
?>