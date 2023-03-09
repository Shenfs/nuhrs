<?php
include_once('../db-connection.php'); //include file
include_once('../Utilities/alert.php'); //include file
include_once('../Utilities/insertToActivityLogs.php');
date_default_timezone_set("Asia/Manila");
class DentalHealthRecord extends DatabaseConnection{

    public function __construct()
    {
        parent::__construct();
    }

    public static function addDentalHealthRecord($conn){
        //add dental record function
        if(isset($_POST['add_dental_health_record'])){
            $student_id = $_POST['student_id'];
            $med_prof_id = $_POST['med_prof_id'];
            $date_created = date("Y-m-d");
            $expiry_date =  date('Y-m-d', strtotime($date_created. ' + 5 years'));
            
            $agelastbirthday = $_POST['agelastbirthday'];
            $calculuspresence = $_POST['calculuspresence'];                                 // ] geeting user input
            $inflamedgingiva = $_POST['inflamedgingiva'];
            $presenceofperiopockets = $_POST['presenceofperiopockets'];
            $presenceofanomalies = $_POST['presenceofanomalies'];

            $temporary_teethpresent = $_POST['temporary_teethpresent'];
            $temporary_cariesofteeth = $_POST['temporary_cariesofteeth'];
            $temporary_cariesforfilling = $_POST['temporary_cariesforfilling'];
            $temporary_cariesforextraction = $_POST['temporary_cariesforextraction'];
            $temporary_rootfragments = $_POST['temporary_rootfragments'];
            $temporary_lostduetocaries = $_POST['temporary_lostduetocaries'];
            $temporary_restored = $_POST['temporary_restored'];

            $permanent_teethpresent = $_POST['permanent_teethpresent'];
            $permanent_cariesofteeth = $_POST['permanent_cariesofteeth'];
            $permanent_cariesforfilling = $_POST['permanent_cariesforfilling'];
            $permanent_cariesforextraction = $_POST['permanent_cariesforextraction'];
            $permanent_rootfragments = $_POST['permanent_rootfragments'];
            $permanent_lostduetocaries = $_POST['permanent_lostduetocaries'];
            $permanent_restored = $_POST['permanent_restored'];

            $flouridetherapy = $_POST['flouridetherapy'];


            $diagnosis = $_POST['diagnosis'];
            $detailsofservicesrendered = $_POST['detailsofservicesrendered'];
            $locationofteeth = $_POST['locationofteeth'];
            

            $fileName = basename($_FILES["image"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                
        
            $allowTypes = array('png'); 


            if(in_array(strtolower($fileType), $allowTypes)){ 
                $image = $_FILES['image']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 

                $insertIntoDentalHealthRecord = mysqli_query($conn,"INSERT INTO dentalhealthrecord(student_id, medprofID, date_created, expiry_date, toothdescription) VALUES ('$student_id','$med_prof_id','$date_created','$expiry_date','$imgContent')"); //insert into dental health record table

                if($insertIntoDentalHealthRecord){ 
                    $selectDentalHealthRecordID = mysqli_query($conn,"SELECT id from dentalhealthrecord WHERE student_id='$student_id' AND medprofID='$med_prof_id' AND date_created='$date_created' ORDER BY id DESC LIMIT 1");
                    $selectDentalHealthRecordID = $selectDentalHealthRecordID->fetch_assoc();
                    $dentalHealthRecordID = $selectDentalHealthRecordID['id'];

                    $insertIntoDentalExam = mysqli_query($conn,"INSERT INTO dentalexam(date, agelastbirthday, calculuspresence, inflamedgingiva, presenceofperiopockets, presenceofanomalies, permanent_teethpresent, permanent_cariesofteeth, permanent_cariesforfilling, permanent_cariesforextraction, permanent_rootfragments, permanent_lostduetocaries, permanent_restored, temporary_teethpresent, temporary_cariesofteeth, temporary_cariesforfilling, temporary_cariesforextraction, temporary_rootfragments, temporary_lostduetocaries, temporary_restored, flouridetherapy,dhrIDnum, medprofIDnum) VALUES ('$date_created','$agelastbirthday','$calculuspresence','$inflamedgingiva','$presenceofperiopockets','$presenceofanomalies','$permanent_teethpresent','$permanent_cariesofteeth','$permanent_cariesforfilling','$permanent_cariesforextraction','$permanent_rootfragments','$permanent_lostduetocaries','$permanent_restored','$temporary_teethpresent','$temporary_cariesofteeth','$temporary_cariesforfilling','$temporary_cariesforextraction','$temporary_rootfragments','$temporary_lostduetocaries','$temporary_restored','$flouridetherapy','$dentalHealthRecordID','$med_prof_id')"); //insert into dental exam record table

                    if($insertIntoDentalExam){
                        $insertIntoDentalTreatmentRecord = mysqli_query($conn,"INSERT INTO dentaltreatmentrecord(date, diagnosis, detailsofservicesrendered, locationofteeth, medprofIDnum, dhrIDnum) VALUES ('$date_created','$diagnosis','$detailsofservicesrendered','$locationofteeth','$med_prof_id',' $dentalHealthRecordID')"); //insert into dental treatment table

                        if($insertIntoDentalTreatmentRecord){
                            $inserIntoDentalHistory = mysqli_query($conn,"INSERT INTO dentalhistory(dhrIDnum, toothdescriptionhistory) VALUES ('$dentalHealthRecordID','$imgContent')");


                            if($inserIntoDentalHistory){

                                $selectInvlovedUser = mysqli_query($conn,"SELECT *, users.id AS user_id FROM medicalprofessional INNER JOIN users ON medicalprofessional.userID = users.id WHERE medicalprofessional.id = '$med_prof_id'");
                                $row = $selectInvlovedUser->fetch_assoc();
                                $selectInvlovedUser2 = mysqli_query($conn,"SELECT * FROM students INNER JOIN users ON students.userID = users.id WHERE students.id = '$student_id'");
                                $row2 = $selectInvlovedUser2->fetch_assoc();
                                insertToActivityLogs($conn,$row['user_id'],"Add Dental Health Record","Add ".$row2['firstName']." ".$row2['lastName']);

                                alert("success","Record Added Successfully","","../medical_professional/dental-health-record.php");//error message
                            }else{
                                alert("error","There was an error","","../medical_professional/dental-health-record.php");//error message
                            }
                        }
                        else{
                            alert("error","There was an error","","../medical_professional/dental-health-record.php");//error message
                        }
                    }
                    else{
                        alert("error","There was an error","","../medical_professional/dental-health-record.php");//error message
                    }
                }
                else{
                    alert("error","There was an error","","../medical_professional/dental-health-record.php");//error message
                }
            }else{
                alert("error","Incorrect Image Format","Sorry, only  PNG files are allowed to upload.","../medical_professional/dental-health-record.php");
            }

            
        }
    }

    public static function updateDentalRecord($conn){
        if(isset($_POST['edit_record'])){
            $den_record_id = $_POST['den_record_id'];
            $agelastbirthday = $_POST['agelastbirthday'];
            $calculuspresence = $_POST['calculuspresence'];                                 // ] geeting user input
            $inflamedgingiva = $_POST['inflamedgingiva'];
            $presenceofperiopockets = $_POST['presenceofperiopockets'];
            $presenceofanomalies = $_POST['presenceofanomalies'];
        
            $temporary_teethpresent = $_POST['temporary_teethpresent'];
            $temporary_cariesofteeth = $_POST['temporary_cariesofteeth'];
            $temporary_cariesforfilling = $_POST['temporary_cariesforfilling'];
            $temporary_cariesforextraction = $_POST['temporary_cariesforextraction'];
            $temporary_rootfragments = $_POST['temporary_rootfragments'];
            $temporary_lostduetocaries = $_POST['temporary_lostduetocaries'];
            $temporary_restored = $_POST['temporary_restored'];
        
            $permanent_teethpresent = $_POST['permanent_teethpresent'];
            $permanent_cariesofteeth = $_POST['permanent_cariesofteeth'];
            $permanent_cariesforfilling = $_POST['permanent_cariesforfilling'];
            $permanent_cariesforextraction = $_POST['permanent_cariesforextraction'];
            $permanent_rootfragments = $_POST['permanent_rootfragments'];
            $permanent_lostduetocaries = $_POST['permanent_lostduetocaries'];
            $permanent_restored = $_POST['permanent_restored'];
        
            $flouridetherapy = $_POST['flouridetherapy'];
        
            $diagnosis = $_POST['diagnosis'];
            $detailsofservicesrendered = $_POST['detailsofservicesrendered'];
            $locationofteeth = $_POST['locationofteeth'];
            
        
            $fileName = basename($_FILES["image"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                 
         
            $allowTypes = array('png'); 
        
        
            if(in_array(strtolower($fileType), $allowTypes)){ 
                $image = $_FILES['image']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
        
                $editDentalHealthRecord = mysqli_query($conn,"UPDATE dentalhealthrecord SET toothdescription='$imgContent' WHERE id='$den_record_id'");
        
                if($editDentalHealthRecord){
                    $editDentalExam = mysqli_query($conn,"UPDATE dentalexam SET agelastbirthday='$agelastbirthday',calculuspresence='$calculuspresence',inflamedgingiva='$inflamedgingiva',presenceofperiopockets='$presenceofperiopockets',presenceofanomalies='$presenceofanomalies',temporary_teethpresent='$temporary_teethpresent',temporary_cariesofteeth='$temporary_cariesofteeth',temporary_cariesforfilling='$temporary_cariesforfilling',temporary_cariesforextraction='$temporary_cariesforextraction',temporary_rootfragments='$temporary_rootfragments',temporary_lostduetocaries='$temporary_lostduetocaries',temporary_restored='$temporary_restored', permanent_teethpresent='$permanent_teethpresent',permanent_cariesofteeth='$permanent_cariesofteeth',permanent_cariesforfilling='$permanent_cariesforfilling',permanent_cariesforextraction='$permanent_cariesforextraction',permanent_rootfragments='$permanent_rootfragments',permanent_lostduetocaries='$permanent_lostduetocaries',permanent_restored='$permanent_restored', flouridetherapy='$flouridetherapy'  WHERE dhrIDnum='$den_record_id'");
        
                    if($editDentalExam){
                        $editDentalTreatment = mysqli_query($conn,"UPDATE dentaltreatmentrecord SET diagnosis='$diagnosis',detailsofservicesrendered='$detailsofservicesrendered',locationofteeth='$locationofteeth' WHERE dhrIDnum='$den_record_id'");
        
                        if($editDentalTreatment){
                            $editDenHistory = mysqli_query($conn,"UPDATE dentalhistory SET toothdescriptionhistory='$imgContent' WHERE dhrIDnum='$den_record_id'");
        
                            if($editDenHistory){
                                $selectInvolvedUser = mysqli_query($conn,"SELECT *, u1.id AS u1_id, u2.firstName as stud_first_name, u2.lastName as stud_last_name FROM dentalhealthrecord INNER JOIN medicalprofessional ON medicalprofessional.id = dentalhealthrecord.medprofID INNER JOIN students ON students.id = dentalhealthrecord.student_id INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN users AS u2 ON u2.id = students.userID WHERE dentalhealthrecord.id='$den_record_id'");
                                $row = $selectInvolvedUser->fetch_assoc();
                                insertToActivityLogs($conn,$row['u1_id'],"Update Dental Health Record","Update ".$row['stud_first_name']." ".$row['stud_last_name']);
                                alert("success","Record Successfully Updated","","../medical_professional/dental-health-record.php");//error message
                            }else{
                                alert("error","There was an error","","../medical_professional/dental-health-record.php");//error message
                            }
                        }else{
                            alert("error","There was an error","","../medical_professional/dental-health-record.php");//error message
                        }
                    }else{
                        alert("error","There was an error","","../medical_professional/dental-health-record.php");//error message
                    }
                }else{
                    alert("error","There was an error","","../medical_professional/dental-health-record.php");//error message
                }
            }else{
                alert("error","There was an error","","../medical_professional/dental-health-record.php");
            }
        
            
        }
    }
}

$db = new DatabaseConnection();
DentalHealthRecord::addDentalHealthRecord($db->conn);
DentalHealthRecord::updateDentalRecord($db->conn);


?>