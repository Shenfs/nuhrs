<?php
namespace Controller;

use DatabaseConnection;

include_once('../db-connection.php'); //include file
include_once('../Utilities/alert.php'); //include file
include_once('../Utilities/insertToActivityLogs.php');

date_default_timezone_set("Asia/Manila"); //set timezone to manila
class MedicalHealthRecordController extends DatabaseConnection{

    public function __construct()
    {
        parent::__construct();
    }

    public static function addMedicalHealthRecord($conn){
        if(isset($_POST['add_medical_health_record'])){//check if add record button is clicked
            $student_id = $_POST['student_id'];
            $date_created = date("Y-m-d");
            $expiry_date =  date('Y-m-d', strtotime($date_created. ' + 5 years'));
            $med_prof_id = $_POST['med_prof_id'];
            $color_category = "";
            (!empty($_POST['history_of_previous_illness_or_surgery'])) ? $history_of_previous_illness_or_surgery =  $_POST['history_of_previous_illness_or_surgery'] : $history_of_previous_illness_or_surgery = '';// ] getting user input
            // $diseaseIDs = $_POST['diseaseIDs'];
            // $med_hisoty_descriptions= $_POST['med_hisoty_descriptions'];
            // $dates = $_POST['dates'];
        
            (!empty($_POST['allergy_date'])) ? $allergy_date = $_POST['allergy_date'] :$allergy_date = '';
            (!empty($_POST['allergy_description'])) ? $allergy_description = $_POST['allergy_description'] :$allergy_description = '';
        
            (!empty($_POST['diabetes_date'])) ? $diabetes_date = $_POST['diabetes_date'] :$diabetes_date = '';
            (!empty($_POST['diabetes_description'])) ? $diabetes_description = $_POST['diabetes_description'] :$diabetes_description = '';
        
            (!empty($_POST['kidney_date'])) ? $kidney_date = $_POST['kidney_date'] :$kidney_date = '';
            (!empty($_POST['kidney_description'])) ? $kidney_description = $_POST['kidney_description'] :$kidney_description = '';
        
            (!empty($_POST['smoker_date'])) ? $smoker_date = $_POST['smoker_date'] :$smoker_date = '';
            (!empty($_POST['smoker_description'])) ? $smoker_description = $_POST['smoker_description'] :$smoker_description = '';
        
            (!empty($_POST['asthma_date'])) ? $asthma_date = $_POST['asthma_date'] :$asthma_date = '';
            (!empty($_POST['asthma_description'])) ? $asthma_description = $_POST['asthma_description'] :$asthma_description = '';
        
            (!empty($_POST['heart_date'])) ? $heart_date = $_POST['heart_date'] :$heart_date = '';
            (!empty($_POST['heart_description'])) ? $heart_description = $_POST['heart_description'] :$heart_description = '';
        
            (!empty($_POST['gynecological_date'])) ? $gynecological_date = $_POST['gynecological_date'] :$gynecological_date = '';
            (!empty($_POST['gynecological_description'])) ? $gynecological_description = $_POST['gynecological_description'] :$gynecological_description = '';
        
            (!empty($_POST['alcoholic_date'])) ? $alcoholic_date = $_POST['alcoholic_date'] :$alcoholic_date = '';
            (!empty($_POST['alcoholic_description'])) ? $alcoholic_description = $_POST['alcoholic_description'] :$alcoholic_description = '';
        
            (!empty($_POST['tb_date'])) ? $tb_date = $_POST['tb_date'] :$tb_date = '';
            (!empty($_POST['tb_description'])) ? $tb_description = $_POST['tb_description'] :$tb_description = '';
        
            (!empty($_POST['hpn_date'])) ? $hpn_date = $_POST['hpn_date'] :$hpn_date = '';
            (!empty($_POST['hpn_description'])) ? $hpn_description = $_POST['hpn_description'] :$hpn_description = '';
        
        
        
            $systolic = $_POST['systolic'];
            $diastolic = $_POST['diastolic'];
            $pr = $_POST['pr'];
            $height = $_POST['height'];
            $weight = $_POST['weight'];
            // $body_parts = $_POST['body_parts'];
            // $physical_exam_descriptions = $_POST['phil_exam_descriptions'];
            (!empty($_POST['skin'])) ? $skin = $_POST['skin'] :$skin = '';
            (!empty($_POST['eyes'])) ? $eyes = $_POST['eyes'] :$eyes = '';
            (!empty($_POST['OD'])) ? $OD = $_POST['OD'] :$OD = '';
            (!empty($_POST['OS'])) ? $OS = $_POST['OS'] :$OS = '';
            (!empty($_POST['ears'])) ? $ears = $_POST['ears'] :$ears = '';
            (!empty($_POST['AD'])) ? $AD = $_POST['AD'] :$AD = '';
            (!empty($_POST['AS_findings'])) ? $AS = $_POST['AS_findings'] :$AS = '';
            (!empty($_POST['nose'])) ? $nose = $_POST['nose'] :$nose = '';
            (!empty($_POST['throat'])) ? $throat = $_POST['throat'] :$throat = '';
            (!empty($_POST['neck'])) ? $neck = $_POST['neck'] :$neck = '';
            (!empty($_POST['thorax'])) ? $thorax = $_POST['thorax'] :$thorax = '';
            (!empty($_POST['heart_findings'])) ? $heart_findings = $_POST['heart_findings'] :$heart_findings = '';
            (!empty($_POST['lungs'])) ? $lungs = $_POST['lungs'] :$lungs = '';
            (!empty($_POST['abdomen'])) ? $abdomen = $_POST['abdomen'] :$abdomen = '';
            (!empty($_POST['extremeties'])) ? $extremeties = $_POST['extremeties'] :$extremeties = '';
            (!empty($_POST['deformities'])) ? $deformities = $_POST['deformities'] : $deformities = '';
            (!empty($_POST['complaints'])) ? $complaints = $_POST['complaints'] : $complaints ='';
            (!empty($_POST['diagnosis'])) ? $diagnosis = $_POST['diagnosis'] : $diagnosis ='';
            (!empty($_POST['treatment'])) ? $treatment = $_POST['treatment'] : $treatment ='';
            isset($_POST['laboratory']) ? $laboratory = $_POST['laboratory'] : $laboratory = "no";
            isset($_POST['vaccine_record']) ? $vaccine_record = $_POST['vaccine_record'] : $vaccine_record = "no";
            $date_time = date("Y-m-d h:i:s");
        
            $insertIntoMedRecord = mysqli_query($conn,"INSERT INTO medicalhealthrecord(student_id, med_prof_id, color_category, date_created, expiry_date) VALUES ('$student_id','$med_prof_id','$color_category','$date_created','$expiry_date')"); //query to insert into med record
        
            if($insertIntoMedRecord){//if query is successful
                $selectMedRecordId = mysqli_query($conn,"SELECT id FROM medicalhealthrecord WHERE student_id='$student_id' AND date_created='$date_created' AND med_prof_id='$med_prof_id' ORDER BY id DESC LIMIT 1");
                $selectMedRecordId = $selectMedRecordId->fetch_assoc();
                $medRecordId = $selectMedRecordId['id'];
        
                $insertIntoMedHistory = mysqli_query($conn,"INSERT INTO medicalhistory(mhrIDnum, history_of_previous_illness_or_surgery) VALUES ('$medRecordId','$history_of_previous_illness_or_surgery')");//insert into med history table
        
                $selectMedHistoryId = mysqli_query($conn,"SELECT id FROM medicalhistory WHERE mhrIDnum='$medRecordId'  ORDER BY id DESC LIMIT 1");
                $selectMedHistoryId = $selectMedHistoryId->fetch_assoc();
                $medHistoryId = $selectMedHistoryId['id'];
                
                if($insertIntoMedHistory){
                    
                        $insertMedHistoryOfDisease = mysqli_query($conn,"INSERT INTO medicalhistoryofdisease( medhistoryID, allergy_date, allergy_description, diabetes_date, diabetes_description, kidney_date, kidney_description, smoker_date, smoker_description, asthma_date, asthma_description, heart_date, heart_description, gynecological_date, gynecological_description, alcoholic_date, alcoholic_description, tb_date, tb_description, hpn_date, hpn_description) VALUES ('$medHistoryId','$allergy_date','$allergy_description','$diabetes_date','$diabetes_description','$kidney_date','$kidney_description','$smoker_date','$smoker_description','$asthma_date','$asthma_description','$heart_date','$heart_description','$gynecological_date','$gynecological_description','$alcoholic_date','$alcoholic_description','$tb_date','$tb_description','$hpn_date','$hpn_description')");
        
                    if($insertMedHistoryOfDisease){
                        $insertIntoPhysicalExam = mysqli_query($conn,"INSERT INTO physicalexam(mhrIDnum, date_created, diastolic,systolic, pulse_rate, height, weight) VALUES ('$medRecordId','$date_created','$diastolic','$systolic','$pr','$height','$weight')");//insert into physical exam table
        
                        if($insertIntoPhysicalExam){
                            $selectPhilExamID = mysqli_query($conn,"SELECT id FROM physicalexam WHERE mhrIDnum='$medRecordId'  ORDER BY id DESC LIMIT 1");
                            $selectPhilExamID = $selectPhilExamID->fetch_assoc();
                            $philExamID = $selectPhilExamID['id'];
        
                            
                                $insertIntoPhilExamFindings = mysqli_query($conn,"INSERT INTO physicalexamfindings( physicalExamID, skin, eyes, OD, OS, ears, AD, AS_findings, nose, throat, neck, thorax, heart, lungs, abdomen, extremeties, deformities, findings_date) VALUES ('$philExamID','$skin','$eyes','$OD','$OS','$ears','$AD','$AS','$nose','$throat','$neck','$thorax','$heart_findings','$lungs','$abdomen','$extremeties','$deformities',' $date_time')");//insert into physical exam findings table
                            
        
                            if($insertIntoPhilExamFindings){
                                $insertToMedicalTreateMentRecord = mysqli_query($conn,"INSERT INTO medicaltreatmentrecord( date_time, complaints, diagnosis, treatment, mhrIDnum) VALUES ('$date_created','$complaints','$diagnosis','$treatment','$medRecordId')"); //insert into medical treatment table
        
                                if($insertToMedicalTreateMentRecord){
                                    if($laboratory == "yes"){
                                        mysqli_query($conn,"INSERT INTO laboratoryresult(mhrIDnum,status) VALUES ('$medRecordId','Not Set')");
                                    }
                                    if($vaccine_record == "yes"){
                                        mysqli_query($conn,"INSERT INTO vaccinationrecord(mhrIDnum, date_created, status) VALUES ('$medRecordId','$date_created','Not Set')");
                                    }
                                    $selectInvlovedUser = mysqli_query($conn,"SELECT *, users.id AS user_id FROM medicalprofessional INNER JOIN users ON medicalprofessional.userID = users.id WHERE medicalprofessional.id = '$med_prof_id'");
                                    $row = $selectInvlovedUser->fetch_assoc();
                                    $selectInvlovedUser2 = mysqli_query($conn,"SELECT * FROM students INNER JOIN users ON students.userID = users.id WHERE students.id = '$student_id'");
                                    $row2 = $selectInvlovedUser2->fetch_assoc();
                                    insertToActivityLogs($conn,$row['user_id'],"Add Medical Health Record","Add ".$row2['firstName']." ".$row2['lastName']);
                                    alert("success","Record Successfuly Added","","../medical_professional/medical-health-record.php");//success message
                                }
                                else{
                                    alert("error","There was an error","","../medical_professional/medical-health-record.php");//error message
                                }   
                            }
                            else{
                                alert("error","There was an error","","../medical_professional/medical-health-record.php");//error message
                            }
                            
                        }else{
                            alert("error","There was an error","","../medical_professional/medical-health-record.php");//error message
                        }
                    }
                    else{
                        alert("error","There was an error","","../medical_professional/medical-health-record.php");//error message
                    }
        
                }
                else{
                    alert("error","There was an error","","../medical_professional/medical-health-record.php");//error message
                }
            }
            else{
                alert("error","There was an error","","../medical_professional/medical-health-record.php");//error message
            }
        }
        
    }

    public static function updateMedicalHealthRecord($conn){
        if(isset($_POST['update_medical_health_record'])){
            $med_record_id = $_POST['med_record_id'];
            $history_of_previous_illness_or_surgery = $_POST['history_of_previous_illness_or_surgery']; // ] getting user input
        
            (!empty($_POST['allergy_date'])) ? $allergy_date = $_POST['allergy_date'] :$allergy_date = '';
            (!empty($_POST['allergy_description'])) ? $allergy_description = $_POST['allergy_description'] :$allergy_description = '';
        
            (!empty($_POST['diabetes_date'])) ? $diabetes_date = $_POST['diabetes_date'] :$diabetes_date = '';
            (!empty($_POST['diabetes_description'])) ? $diabetes_description = $_POST['diabetes_description'] :$diabetes_description = '';
        
            (!empty($_POST['kidney_date'])) ? $kidney_date = $_POST['kidney_date'] :$kidney_date = '';
            (!empty($_POST['kidney_description'])) ? $kidney_description = $_POST['kidney_description'] :$kidney_description = '';
        
            (!empty($_POST['smoker_date'])) ? $smoker_date = $_POST['smoker_date'] :$smoker_date = '';
            (!empty($_POST['smoker_description'])) ? $smoker_description = $_POST['smoker_description'] :$smoker_description = '';
        
            (!empty($_POST['asthma_date'])) ? $asthma_date = $_POST['asthma_date'] :$asthma_date = '';
            (!empty($_POST['asthma_description'])) ? $asthma_description = $_POST['asthma_description'] :$asthma_description = '';
        
            (!empty($_POST['heart_date'])) ? $heart_date = $_POST['heart_date'] :$heart_date = '';
            (!empty($_POST['heart_description'])) ? $heart_description = $_POST['heart_description'] :$heart_description = '';
        
            (!empty($_POST['gynecological_date'])) ? $gynecological_date = $_POST['gynecological_date'] :$gynecological_date = '';
            (!empty($_POST['gynecological_description'])) ? $gynecological_description = $_POST['gynecological_description'] :$gynecological_description = '';
        
            (!empty($_POST['alcoholic_date'])) ? $alcoholic_date = $_POST['alcoholic_date'] :$alcoholic_date = '';
            (!empty($_POST['alcoholic_description'])) ? $alcoholic_description = $_POST['alcoholic_description'] :$alcoholic_description = '';
        
            (!empty($_POST['tb_date'])) ? $tb_date = $_POST['tb_date'] :$tb_date = '';
            (!empty($_POST['tb_description'])) ? $tb_description = $_POST['tb_description'] :$tb_description = '';
        
            (!empty($_POST['hpn_date'])) ? $hpn_date = $_POST['hpn_date'] :$hpn_date = '';
            (!empty($_POST['hpn_description'])) ? $hpn_description = $_POST['hpn_description'] :$hpn_description = '';
        
        
        
            $systolic = $_POST['systolic'];
            $diastolic = $_POST['diastolic'];
            $pr = $_POST['pr'];
            $height = $_POST['height'];
            $weight = $_POST['weight'];
            (!empty($_POST['skin'])) ? $skin = $_POST['skin'] :$skin = '';
            (!empty($_POST['eyes'])) ? $eyes = $_POST['eyes'] :$eyes = '';
            (!empty($_POST['OD'])) ? $OD = $_POST['OD'] :$OD = '';
            (!empty($_POST['OS'])) ? $OS = $_POST['OS'] :$OS = '';
            (!empty($_POST['ears'])) ? $ears = $_POST['ears'] :$ears = '';
            (!empty($_POST['AD'])) ? $AD = $_POST['AD'] :$AD = '';
            (!empty($_POST['AS_findings'])) ? $AS = $_POST['AS_findings'] :$AS = '';
            (!empty($_POST['nose'])) ? $nose = $_POST['nose'] :$nose = '';
            (!empty($_POST['throat'])) ? $throat = $_POST['throat'] :$throat = '';
            (!empty($_POST['neck'])) ? $neck = $_POST['neck'] :$neck = '';
            (!empty($_POST['thorax'])) ? $thorax = $_POST['thorax'] :$thorax = '';
            (!empty($_POST['heart_findings'])) ? $heart_findings = $_POST['heart_findings'] :$heart_findings = '';
            (!empty($_POST['lungs'])) ? $lungs = $_POST['lungs'] :$lungs = '';
            (!empty($_POST['abdomen'])) ? $abdomen = $_POST['abdomen'] :$abdomen = '';
            (!empty($_POST['extremeties'])) ? $extremeties = $_POST['extremeties'] :$extremeties = '';
            (!empty($_POST['deformities'])) ? $deformities = $_POST['deformities'] : $deformities = '';
            $complaints = $_POST['complaints'];
            $diagnosis = $_POST['diagnosis'];
            $treatment = $_POST['treatment'];
        
            $updateMedicalHistory = mysqli_query($conn,"UPDATE medicalhistory SET history_of_previous_illness_or_surgery='$history_of_previous_illness_or_surgery' WHERE mhrIDnum='$med_record_id'");
        
            if($updateMedicalHistory){
                $selectMedHistoryId = mysqli_query($conn,"SELECT id FROM medicalhistory WHERE mhrIDnum='$med_record_id'  ORDER BY id DESC LIMIT 1");
                $selectMedHistoryId = $selectMedHistoryId->fetch_assoc();
                $medHistoryId = $selectMedHistoryId['id'];
        
        
                $updateMedicalHistoryOfDisease = mysqli_query($conn,"UPDATE medicalhistoryofdisease SET allergy_date='$allergy_date',allergy_description='$allergy_description',diabetes_date='$diabetes_date',diabetes_description='$diabetes_description',kidney_date='$kidney_date',kidney_description='$kidney_description',smoker_date='$smoker_date',smoker_description='$smoker_description',asthma_date='$asthma_date',asthma_description='$asthma_description',heart_date='$heart_date',heart_description='$heart_description',gynecological_date='$gynecological_date',gynecological_description='$gynecological_description',alcoholic_date='$alcoholic_date',alcoholic_description='$alcoholic_description',tb_date='$tb_date',tb_description='$tb_description',hpn_date='$hpn_date',hpn_description='$hpn_description' WHERE medhistoryID='$medHistoryId'");
        
                if($updateMedicalHistoryOfDisease){
                    $updatePhysicalExam = mysqli_query($conn,"UPDATE physicalexam SET systolic='$systolic',diastolic='$diastolic',pulse_rate='$pr',height='$height',weight='$weight' WHERE mhrIDnum='$med_record_id'");
        
                    if($updatePhysicalExam){
                        $selectPhilExamID = mysqli_query($conn,"SELECT id FROM physicalexam WHERE mhrIDnum='$med_record_id'  ORDER BY id DESC LIMIT 1");
                        $selectPhilExamID = $selectPhilExamID->fetch_assoc();
                        $philExamID = $selectPhilExamID['id'];
        
                        $updatePhysicalExamFindings = mysqli_query($conn,"UPDATE physicalexamfindings SET skin='$skin',eyes='$eyes',OD='$OD',OS='$OS',ears='$ears',AD='$AD',AS_findings='$AS',nose='$nose',throat='$throat',neck='$neck',thorax='$thorax',heart='$heart_findings',lungs='$lungs',abdomen='$abdomen',extremeties='$extremeties',deformities='$deformities' WHERE physicalExamID='$philExamID'");
        
                        if($updatePhysicalExamFindings){
                            $updateMedicalTreatement = mysqli_query($conn,"UPDATE medicaltreatmentrecord SET complaints='$complaints',diagnosis='$diagnosis',treatment='$treatment'  WHERE mhrIDnum='$med_record_id'");
        
                            if($updateMedicalTreatement){

                                $selectInvolvedUser = mysqli_query($conn,"SELECT *, u1.id AS u1_id, u2.firstName as stud_first_name, u2.lastName as stud_last_name FROM medicalhealthrecord INNER JOIN medicalprofessional ON medicalprofessional.id = medicalhealthrecord.med_prof_id INNER JOIN students ON students.id = medicalhealthrecord.student_id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN users AS u2 ON u2.id = students.userID WHERE medicalhealthrecord.id='$med_record_id'");
                                $row = $selectInvolvedUser->fetch_assoc();
                                insertToActivityLogs($conn,$row['u1_id'],"Update Medical Health Record","Update ".$row['stud_first_name']." ".$row['stud_last_name']);
                                alert("success","Record Updated Successfully","","../medical_professional/medical-health-record.php");//error message
                            }
                            else{
                                alert("error","There was an error","","../medical_professional/medical-health-record.php");//error message
                            }
                        }
                        else{
                            alert("error","There was an error","","../medical_professional/medical-health-record.php");//error message
                        }
                    }
                    else{
                        alert("error","There was an error","","../medical_professional/medical-health-record.php");//error message
                    }
                }
                else{
                    alert("error","There was an error","","../medical_professional/medical-health-record.php");//error message
                }
            }
            else{
                alert("error","There was an error","","../medical_professional/medical-health-record.php");//error message
            }
        }
    }

    public static function uploadLabResult($conn){
        if(isset($_POST['upload_lab_result'])){
            $med_record_id = $_POST['med_record_id'];
            $date_of_lab_testing = $_POST['date_of_lab_testing'];
            $diagnosis = $_POST['diagnosis'];
            $findingsdescription = $_POST['findingsdescription'];
        
            $fileName = basename($_FILES["image"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                 
         
            $allowTypes = array('png','jpg','jpeg'); 
            $datenow = date('Y-m-d');
        
        
            if(in_array(strtolower($fileType), $allowTypes)){ 
                $image = $_FILES['image']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
        
                $updateLabResult = mysqli_query($conn,"UPDATE laboratoryresult SET uploadfile='$imgContent',findingsdescription='$findingsdescription',diagnosis='$diagnosis',date_of_lab_testing='$date_of_lab_testing',date_created='$datenow',status='Pending' WHERE id='$med_record_id'");
        
                if($updateLabResult){
                    alert("success","Lab Result Successfully Uploaded","Please wait for the approval of lab result","../student/medical-health-record.php");
                }
                else{
                    alert("error","There was an error","","../student/medical-health-record.php");
                }
            }
            else{
                alert("error","Incorrect Image Format","Sorry, only  PNG, JPG or JPEG files are allowed to upload.","../student/medical-health-record.php");
            }
        
        
        }
    }

    public static function uploadRejectedLabResult($conn){
        if(isset($_POST['upload_rejected_lab_result'])){
            $med_record_id = $_POST['med_record_id'];
            $date_of_lab_testing = $_POST['date_of_lab_testing'];
            $diagnosis = $_POST['diagnosis'];
            $findingsdescription = $_POST['findingsdescription'];
        
            $fileName = basename($_FILES["image"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                 
         
            $allowTypes = array('png','jpg','jpeg'); 
            $datenow = date('Y-m-d');
        
        
            if(in_array(strtolower($fileType), $allowTypes)){ 
                $image = $_FILES['image']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
        
                $updateLabResult = mysqli_query($conn,"UPDATE laboratoryresult SET uploadfile='$imgContent',findingsdescription='$findingsdescription',diagnosis='$diagnosis',date_of_lab_testing='$date_of_lab_testing',date_created='$datenow',status='Pending' WHERE id='$med_record_id'");
        
                if($updateLabResult){
                    alert("success","Lab Result Successfully Uploaded","Please wait for the approval of lab result","../student/medical-health-record.php");
                }
                else{
                    alert("error","There was an error","","../student/medical-health-record.php");
                }
            }
            else{
                alert("error","Incorrect Image Format","Sorry, only  PNG, JPG or JPEG files are allowed to upload.","../student/medical-health-record.php");
            }
        
        
        }

    }
    public static function uploadVaccRecord($conn){
        if(isset($_POST['upload_vacc_record'])){
            $vacc_id = $_POST['vacc_id'];
            $disease = $_POST['disease'];
            $description = $_POST['description'];
            $first_dose = $_POST['first_dose'];
            $second_dose = $_POST['second_dose'];
            $booster = $_POST['booster'];

            $fileName = basename($_FILES["image"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                    
            
            $allowTypes = array('png','jpg','jpeg'); 
            $datenow = date('Y-m-d');
        
        
            if(in_array(strtolower($fileType), $allowTypes)){ 
                $image = $_FILES['image']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
        
                $updateVaccineRecord = mysqli_query($conn,"UPDATE vaccinationrecord SET disease='$disease',description='$description',firstdose='$first_dose',seconddose='$second_dose',boosterdate='$booster',uploadFile='$imgContent',status='Pending' WHERE id='$vacc_id'");
        
                if($updateVaccineRecord){
                    alert("success","Vaccine Record Successfully Uploaded","Please wait for the approval of lab result","../student/medical-health-record.php");
                }
                else{
                    alert("error","There was an error","","../student/medical-health-record.php");
                }
            }
            else{
                alert("error","Incorrect Image Format","Sorry, only  PNG, JPG or JPEG files are allowed to upload.","../student/medical-health-record.php");
            }
        }
        
    }

    public static function uploadRejectedVaccRecord($conn){
        if(isset($_POST['upload_rejected_vacc_record'])){
            $vacc_id = $_POST['vacc_id'];
            $disease = $_POST['disease'];
            $description = $_POST['description'];
            $first_dose = $_POST['first_dose'];
            $second_dose = $_POST['second_dose'];
            $booster = $_POST['booster'];

            $fileName = basename($_FILES["image"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                    
            
            $allowTypes = array('png','jpg','jpeg'); 
            $datenow = date('Y-m-d');
        
        
            if(in_array(strtolower($fileType), $allowTypes)){ 
                $image = $_FILES['image']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
        
                $updateVaccineRecord = mysqli_query($conn,"UPDATE vaccinationrecord SET disease='$disease',description='$description',firstdose='$first_dose',seconddose='$second_dose',boosterdate='$booster',uploadFile='$imgContent',status='Pending' WHERE id='$vacc_id'");
        
                if($updateVaccineRecord){
                    alert("success","Vaccine Record Successfully Uploaded","Please wait for the approval of lab result","../student/medical-health-record.php");
                }
                else{
                    alert("error","There was an error","","../student/medical-health-record.php");
                }
            }
            else{
                alert("error","Incorrect Image Format","Sorry, only  PNG, JPG or JPEG files are allowed to upload.","../student/medical-health-record.php");
            }
        }
        
    }
}
$db = new DatabaseConnection();
MedicalHealthRecordController::addMedicalHealthRecord($db->conn);
MedicalHealthRecordController::updateMedicalHealthRecord($db->conn);
MedicalHealthRecordController::uploadLabResult($db->conn);
MedicalHealthRecordController::uploadRejectedLabResult($db->conn);
MedicalHealthRecordController::uploadVaccRecord($db->conn);
MedicalHealthRecordController::uploadRejectedVaccRecord($db->conn);




?>