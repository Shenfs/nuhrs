<?php
include_once("db-connection.php");
$db = new DatabaseConnection();
	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=student_list.xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");
 
	
 
	$output = "";
 
	$output .="
		<table>
			<thead>
				<tr>
                <th align = 'center'>Date</th>
                <th align = 'center'>Name</th>
                <th align = 'center'>Course</th>
                <th align = 'center'>Online/Onsite</th>
                <th align = 'center'>Diagnosis</th>
                <th align = 'center'>Management</th>
				</tr>
			<tbody>
	";
 
	$query = $db->conn->query("SELECT *, medicalhealthrecord.id AS med_record_id, stud.student_id_number AS stud_id_number,medicalhealthrecord.date_created as date_created, medicalhealthrecord.expiry_date as expiry_date,u2.firstName AS stud_first_name, u2.lastName AS stud_last_name, stud.courseID AS stud_course, stud.year AS stud_year, stud.section AS stud_sec,  u1.firstName AS med_first_name, u1.lastName AS med_last_name,  physicalexam.pulse_rate AS pulse_rate, physicalexam.height AS height,  physicalexam.weight AS weight, medicaltreatmentrecord.date_time AS med_record_date_time FROM medicalhealthrecord INNER JOIN students AS stud ON medicalhealthrecord.student_id = stud.id INNER JOIN medicalprofessional ON medicalprofessional.id = medicalhealthrecord.med_prof_id INNER JOIN users AS u2 ON u2.id = stud.userID INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN physicalexam ON physicalexam.mhrIDnum = medicalhealthrecord.id INNER JOIN medicaltreatmentrecord ON medicaltreatmentrecord.mhrIDnum = medicalhealthrecord.id INNER JOIN physicalexamfindings ON  physicalexam.id = physicalexamfindings.physicalExamID WHERE stud.courseID IN ('1','2','3','4','5','6','7','8','9','10','11') AND medicalhealthrecord.date_created ORDER BY medicalhealthrecord.id DESC");
    while($row = $query->fetch_assoc()){
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
 
	echo $output;
 
 
?>