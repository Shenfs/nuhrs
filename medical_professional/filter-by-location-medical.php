<?php 
include_once("../db-connection.php");

if(isset($_POST['province'])){
    $db = new DatabaseConnection();
    $conn = $db->conn;
    $province = $_POST['province'];

    $selectStudentByProvince = mysqli_query($conn,"SELECT *, medicalhealthrecord.id AS med_record_id, stud.student_id_number AS stud_id_number, u2.firstName AS stud_first_name, u2.lastName AS stud_last_name,u2.middleName AS stud_middle_name, stud.courseID AS stud_course, stud.year as stud_year, stud.section as stud_sec, stud.birthdate AS stud_dob, stud.age as stud_age, stud.sex as stud_sex, stud.nationality AS stud_nationality, stud.religion as stud_religion, stud.contact_number as stud_contact_number, u2.email_address as stud_email_address,stud.province as stud_province,stud.city_municipality as stud_city_municipality, stud.barangay as stud_barangay, medicaltreatmentrecord.date_time AS med_record_date_time, u1.firstName as med_first_name, u1.middleName as med_middle_name, u1.lastName as med_last_name, u2.profile_img as stud_avatar  FROM medicalhealthrecord INNER JOIN students AS stud ON medicalhealthrecord.student_id = stud.id INNER JOIN users AS u2 ON u2.id = stud.userID INNER JOIN physicalexam ON physicalexam.mhrIDnum =  medicalhealthrecord.id INNER JOIN physicalexamfindings ON physicalexam.id = physicalexamfindings.physicalExamId INNER JOIN medicaltreatmentrecord ON medicalhealthrecord.id = medicaltreatmentrecord.mhrIDnum INNER JOIN medicalprofessional ON medicaltreatmentrecord.mhrIDnum = medicalprofessional.id INNER JOIN users AS u1 ON medicalprofessional.userID = u1.id INNER JOIN medicalhistory ON  medicalhistory.mhrIDnum = medicalhealthrecord.id INNER JOIN medicalhistoryofdisease ON  medicalhistory.id = medicalhistoryofdisease.medhistoryID WHERE province='$province' ORDER BY medicalhealthrecord.id DESC");
    $data = array();
    while( $row = mysqli_fetch_assoc($selectStudentByProvince) ) {
		$data = $row;
	}
    echo json_encode($data);
}
?>