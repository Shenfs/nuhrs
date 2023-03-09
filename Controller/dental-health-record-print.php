<?php 
require('../vendor/fpdf/fpdf.php');
require_once("../db-connection.php");
$db = new DatabaseConnection();
$conn = $db->conn;
$id = $_POST['den_record_id'];
$selectDentalHealthRecord = mysqli_query($conn,"SELECT *, dentalhealthrecord.id AS den_record_id, stud.student_id_number AS stud_id_number, u2.firstName AS stud_first_name, u2.lastName AS stud_last_name, u2.middleName as stud_middle_name, stud.birthdate AS stud_dob, stud.age as stud_age,stud.sex AS stud_sex,stud.nationality AS stud_nationality,stud.religion AS stud_religion, stud.contact_number AS stud_contact_number, u2.email_address AS stud_email_address, stud.courseID AS stud_course, stud.year as stud_year, stud.section as stud_sec ,stud.province as stud_province,stud.city_municipality as stud_city_municipality, stud.barangay as stud_barangay, u2.profile_img AS stud_avatar, u1.firstName as med_first_name, u1.middleName as med_middle_name, u1.lastName as med_last_name   FROM dentalhealthrecord INNER JOIN students AS stud ON dentalhealthrecord.student_id = stud.id INNER JOIN users AS u2 ON u2.id = stud.userID INNER JOIN dentalexam ON dentalexam.dhrIDnum = dentalhealthrecord.id INNER JOIN dentaltreatmentrecord ON dentaltreatmentrecord.dhrIDnum = dentalhealthrecord.id INNER JOIN medicalprofessional ON dentaltreatmentrecord.medprofIDnum = medicalprofessional.id INNER JOIN users AS u1 ON medicalprofessional.userID = u1.id WHERE dentalhealthrecord.id = '$id' ORDER BY dentalhealthrecord.id DESC");



$row = $selectDentalHealthRecord->fetch_assoc();

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
const toothdescription = 'tootdescription.png';

$dataURI    = "data:image/png;base64,".base64_encode($row['toothdescription']);
$dataPieces = explode(',',$dataURI);
$encodedImg = $dataPieces[1];
$decodedImg = base64_decode($encodedImg);

//  Check if image was properly decoded

$pdf = new FPDF(); 
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);



$pdf->Image('DENTAL_HEALTH_RECORD_STUDENTS01282022-converted_page-0001.jpg',10,10,189);
$pdf->Cell(180,22,"",0,1);
$pdf->Cell(180,22,"",0,1);
$pdf->Cell(22,5,"",0,0);
$pdf->Cell(49,5,$row['stud_first_name']." ".$row['stud_last_name'],0,0);
$pdf->Cell(15,5,"",0,0);
$pdf->Cell(33,5,$row['stud_religion'],0,0);
$pdf->Cell(21,5,"",0,0);
$pdf->Cell(40,5,ucfirst($row['stud_nationality']),0,1);
$pdf->Cell(41,5,"",0,0);
$pdf->Cell(30,5,$row['stud_year']."/".$stud_course,0,0);
$pdf->Cell(25,5,"",0,0);
$pdf->Cell(84,5,$row['housenumber']." ".$row['streetname'].", ".$row['stud_barangay']." ".$row['stud_city_municipality'].", ".$row['stud_province'],0,1);

$pdf->Cell(41,6,"",0,0);
$pdf->Cell(30,6,$row['stud_contact_number'],0,0);
$pdf->Cell(25,6,"",0,0);
$pdf->Cell(84,6,date("m-d-Y", strtotime($row['stud_dob'])),0,1);


$pdf->Cell(180,110,"",0,1);
if( $decodedImg!==false )
{
    //  Save image to a temporary location
    if( file_put_contents(toothdescription,$decodedImg)!==false )
    {
        //  Open new PDF document and print image
       
       
        $pdf->Image(toothdescription,x:15,y:70,w:179,h:108);
       

        //  Delete image from server
        unlink(toothdescription);
    }
}
$pdf->Cell(51,4,"",0,0);
$pdf->Cell(18,4,date('m/d/y', strtotime($row['date_created'])),0,1);
$pdf->Cell(51,4,"",0,0);
$pdf->Cell(18,4,$row['stud_age'],0,1,"C");

($row['calculuspresence'] == "No") ? $pdf->Image("circle.png",x:63,y:188,h:3,w:5) : $pdf->Image("circle.png",x:72,y:188,h:3,w:5);
($row['inflamedgingiva'] == "No") ? $pdf->Image("circle.png",x:63,y:192,h:3,w:5) : $pdf->Image("circle.png",x:72,y:192,h:3,w:5);
($row['presenceofperiopockets'] == "No") ? $pdf->Image("circle.png",x:63,y:197,h:3,w:5) : $pdf->Image("circle.png",x:72,y:197,h:3,w:5);
($row['presenceofanomalies'] == "No") ? $pdf->Image("circle.png",x:63,y:205,h:3,w:5) : $pdf->Image("circle.png",x:72,y:205,h:3,w:5);

$pdf->Cell(180,27,"",0,1);

$pdf->Cell(51,4,"",0,0);
$pdf->Cell(9,4,$row['temporary_teethpresent'],0,0,"C");
$pdf->Cell(9,4,$row['permanent_teethpresent'],0,1,"C");

$pdf->Cell(51,4,"",0,0);
$pdf->Cell(9,4,$row['temporary_cariesofteeth'],0,0,"C");
$pdf->Cell(9,4,$row['permanent_cariesofteeth'],0,1,"C");

$pdf->Cell(51,7,"",0,0);
$pdf->Cell(9,7,$row['temporary_cariesforfilling'],0,0,"C");
$pdf->Cell(9,7,$row['permanent_cariesforfilling'],0,1,"C");

$pdf->Cell(51,8,"",0,0);
$pdf->Cell(9,8,$row['temporary_cariesforextraction'],0,0,"C");
$pdf->Cell(9,8,$row['permanent_cariesforextraction'],0,1,"C");


$pdf->Cell(51,4,"",0,0);
$pdf->Cell(9,4,$row['temporary_rootfragments'],0,0,"C");
$pdf->Cell(9,4,$row['permanent_rootfragments'],0,1,"C");


$pdf->Cell(51,4,"",0,0);
$pdf->Cell(9,4,$row['temporary_lostduetocaries'],0,0,"C");
$pdf->Cell(9,4,$row['permanent_lostduetocaries'],0,1,"C");


$pdf->Cell(51,4,"",0,0);
$pdf->Cell(9,4,$row['temporary_restored'],0,0,"C");
$pdf->Cell(9,4,$row['permanent_restored'],0,1,"C");

$temporary_total = (int)$row['temporary_teethpresent'] + (int)$row['temporary_cariesofteeth'] + (int)$row['temporary_cariesforfilling'] + (int)$row['temporary_cariesforextraction'] + (int)$row['temporary_rootfragments'] + (int)$row['temporary_lostduetocaries'] + (int)$row['temporary_restored'];
$permanent_total = (int)$row['permanent_teethpresent'] + (int)$row['permanent_cariesofteeth'] + (int)$row['permanent_cariesforfilling'] + (int)$row['permanent_cariesforextraction'] + (int)$row['permanent_rootfragments'] + (int)$row['permanent_lostduetocaries'] + (int)$row['permanent_restored'];


$pdf->Cell(51,4,"",0,0);
$pdf->Cell(9,4,$temporary_total,0,0,"C");
$pdf->Cell(9,4,$permanent_total,0,1,"C");

$pdf->Cell(51,4,"",0,0);
$pdf->Cell(18,4,$row['flouridetherapy'],0,1,"C");

$pdf->Cell(51,4,"",0,0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18,4,$row['med_first_name']." ".$row['med_last_name'],0,1,"C");


$pdf->AddPage();
$pdf->Image('DENTAL_HEALTH_RECORD_STUDENTS01282022-converted_page-0002.jpg',10,10,189);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(182,50,"",0,1);
$pdf->Cell(11,22,"",0,0,"C");
$pdf->Cell(21,22,date('m/d/y', strtotime($row['date_created'])),0,0,"C");
$pdf->Cell(36,22,$row['diagnosis'],0,0,"C");
$pdf->Cell(49,22,$row['detailsofservicesrendered'],0,0,"C");
$pdf->Cell(39,22,$row['locationofteeth'],0,0,"C");
$pdf->Cell(26,22,$row['med_first_name']." ".$row['med_last_name'],0,1,"C");




$pdf->Output();


?>