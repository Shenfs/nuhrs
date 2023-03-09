<?php 
$page_title = "RECORDS";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2">

   

    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
            <h3 class="font-weight-bold text-dark">My Medical Health Record</h3>
            <table id="medical_health_record" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Medical Professional</th>
                        <th>Date Recorded</th>
                        <th>Expiry Date</th>
                        <th>Lab Result</th>
                        <th>Vaccine Record</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $selectMedicalHealthRecords = mysqli_query($conn,"SELECT *, medicalhealthrecord.id AS med_record_id, stud.student_id_number AS stud_id_number,medicalhealthrecord.date_created as date_created, medicalhealthrecord.expiry_date as expiry_date,u2.firstName AS stud_first_name, u2.lastName AS stud_last_name, stud.courseID AS stud_course, stud.year AS stud_year, stud.section as stud_sec,  u1.firstName AS med_first_name, u1.lastName AS med_last_name,  physicalexam.pulse_rate AS pulse_rate, physicalexam.height AS height,  physicalexam.weight AS weight, medicaltreatmentrecord.date_time AS med_record_date_time FROM medicalhealthrecord INNER JOIN students AS stud ON medicalhealthrecord.student_id = stud.id INNER JOIN medicalprofessional ON medicalprofessional.id = medicalhealthrecord.med_prof_id INNER JOIN users AS u2 ON u2.id = stud.userID INNER JOIN users AS u1 ON u1.id = medicalprofessional.userID INNER JOIN physicalexam ON physicalexam.mhrIDnum = medicalhealthrecord.id INNER JOIN medicaltreatmentrecord ON medicaltreatmentrecord.mhrIDnum = medicalhealthrecord.id INNER JOIN physicalexamfindings ON  physicalexam.id = physicalexamfindings.physicalExamID WHERE stud.id = '$active_student_id'  ORDER BY medicalhealthrecord.id DESC");
                    while($row = $selectMedicalHealthRecords->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $row['med_first_name']." ".$row['med_last_name']; ?></td>
                            <td><?php echo date("M-d-Y",strtotime($row['date_created'])); ?></td>
                            <td><?php echo date("M-d-Y",strtotime($row['expiry_date']));?></td>
                            <td>
                                
                                <?php
                                $med_record_id = $row['med_record_id'];
                                $selectIFLabisRequired = mysqli_query($conn,"SELECT * FROM laboratoryresult WHERE mhrIDnum='$med_record_id'");
                                while($row2 = $selectIFLabisRequired->fetch_assoc()){
                                    $lab_id = $row2['id'];
                                    $lab_status = $row2['status'];
                                }
                                if($selectIFLabisRequired->num_rows > 0){ ?>
                                    <?php 
                                    if($lab_status == "Not Set"){ ?>
                                        <a class='text-underline text-center' data-toggle="modal" data-target="#uploadLabResult<?php echo $med_record_id ?>" style='cursor:pointer;'>Lab Result is Required (Upload Now)<a>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="uploadLabResult<?php echo $med_record_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Laboratory Result</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../Controller/MedicalHealthRecordController.php" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                <input type="hidden" name="med_record_id" value="<?php echo $lab_id ?>">
                                                <div class="col">
                                                    <label for="">Lab Result Image</label>
                                                    <input type="file" name="image" class="form-control" required>
                                                </div>
                                                <div class="col">
                                                    <label for="">Date of Laboratory Test</label>
                                                    <input type="date" name="date_of_lab_testing" class="form-control" required>
                                                </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Diagnosis</label>
                                                        <textarea name="diagnosis" class="form-control" id="" cols="3" rows="5" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Findings</label>
                                                        <textarea name="findingsdescription" class="form-control" id="" cols="3" rows="5" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name="upload_lab_result" class="btn btn-primary">Upload</button>
                                                </form>
                                            </div>
                                            </div>
                                            </div>
                                        </div>
                                    <?php } 
                                    elseif($lab_status == "Pending"){
                                        echo "Uploaded File is Pending";
                                    }
                                    elseif($lab_status == "Approved"){
                                        echo "Required and Approved";
                                    }
                                    elseif($lab_status == "Rejected"){
                                        echo"<a class='text-underline text-center' data-toggle='modal' data-target='#uploadRejectedLabResult" .$med_record_id."'style='cursor:pointer;'>Lab Result is Rejected (Upload Now)<a>"; ?>

                                        <!-- Modal -->
                                        <div class="modal fade" id="uploadRejectedLabResult<?php echo $med_record_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Laboratory Result</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../Controller/MedicalHealthRecordController.php" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                <input type="hidden" name="med_record_id" value="<?php echo $lab_id ?>">
                                                <div class="col">
                                                    <label for="">Lab Result Image</label>
                                                    <input type="file" name="image" class="form-control" required>
                                                </div>
                                                <div class="col">
                                                    <label for="">Date of Laboratory Test</label>
                                                    <input type="date" name="date_of_lab_testing" class="form-control" required>
                                                </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Diagnosis</label>
                                                        <textarea name="diagnosis" class="form-control" id="" cols="3" rows="5" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Findings</label>
                                                        <textarea name="findingsdescription" class="form-control" id="" cols="3" rows="5" required></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name="upload_rejected_lab_result" class="btn btn-primary">Upload</button>
                                                </form>
                                            </div>
                                            </div>
                                            </div>
                                        </div>
                                   <?php }
                                    ?>

                                <?php } else {
                                   echo "Lab Result is not Required";
                                }
                                ?>
                            </td>
                            <td>
                                <!-- Vaccine Records -->
                                <?php
                                $med_record_id = $row['med_record_id'];
                                $selectIFVaccisRequired = mysqli_query($conn,"SELECT * FROM vaccinationrecord WHERE mhrIDnum='$med_record_id'");
                                while($row3 = $selectIFVaccisRequired->fetch_assoc()){
                                    $vacc_id = $row3['id'];
                                    $vacc_status = $row3['status'];
                                }
                                if($selectIFVaccisRequired->num_rows > 0){ ?>
                                    <?php 
                                    if($vacc_status == "Not Set"){ ?>
                                        <a class='text-underline text-center' data-toggle="modal" data-target="#uploadVaccRecord<?php echo $med_record_id ?>" style='cursor:pointer;'>Vaccine Record is Required (Upload Now)<a>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="uploadVaccRecord<?php echo $med_record_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Upload Vaccine Record</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../Controller/MedicalHealthRecordController.php" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <input type="hidden" name="vacc_id" value="<?php echo $vacc_id ?>">
                                                    <div class="col">
                                                        <label for="">Disease</label>
                                                        <input type="text" name="disease" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="">Description</label>
                                                       <textarea name="description"  cols="5" rows="5" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>First Dose</label>
                                                        <input type="date" name="first_dose" required class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label>Second Dose</label>
                                                        <input type="date" name="second_dose" required class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label>Booster</label>
                                                        <input type="date" name="booster" required class="form-control" required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Vaccine Record Image</label>
                                                        <input type="file" name="image" class="form-control" required>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name="upload_vacc_record" class="btn btn-primary">Upload</button>
                                                </form>
                                            </div>
                                            </div>
                                            </div>
                                        </div>
                                    <?php } 
                                    elseif($vacc_status == "Pending"){
                                        echo "Uploaded File is Pending";
                                    }
                                    elseif($vacc_status == "Approved"){
                                        echo "Required and Approved";
                                    }
                                    elseif($vacc_status == "Rejected"){
                                        echo"<a class='text-underline text-center' data-toggle='modal' data-target='#uploadRejectedVaccRecord" .$med_record_id."'style='cursor:pointer;'>Lab Result is Rejected (Upload Now)<a>"; ?>

                                        <!-- Modal -->
                                        <div class="modal fade" id="uploadRejectedVaccRecord<?php echo $med_record_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Upload Vaccine Record</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../Controller/MedicalHealthRecordController.php" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <input type="hidden" name="vacc_id" value="<?php echo $vacc_id ?>">
                                                    <div class="col">
                                                        <label for="">Disease</label>
                                                        <input type="text" name="disease" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="">Description</label>
                                                       <textarea name="description"  cols="5" rows="5" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>First Dose</label>
                                                        <input type="date" name="first_dose" required class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label>Second Dose</label>
                                                        <input type="date" name="second_dose" required class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label>Booster</label>
                                                        <input type="date" name="booster" required class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label>Vaccine Record Image</label>
                                                        <input type="file" name="image" class="form-control" required>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" name="upload_rejected_vacc_record" class="btn btn-primary">Upload</button>
                                                </form>
                                            </div>
                                            </div>
                                            </div>
                                        </div>
                                   <?php }
                                    ?>

                                <?php } else {
                                   echo "Vaccine is not Required";
                                }
                                ?>
                                <!-- -->
                            </td>
                            <td class="d-flex justify-content-around align-items-center">
                                <div data-toggle="tooltip" data-placement="bottom" title="View">
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewHealthRecordModal<?php echo $row['med_record_id'];?>"><i class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>

                        <!-- View Health Record Modal -->
                        <div class="modal fade" id="viewHealthRecordModal<?php echo $row['med_record_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-notes-medical mr-2"></i>View Medical Health Record</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <div class="col-sm-4"><!--left col-->
                                                

                                            <div class="text-center">
                                                <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar border rounded-circle img-thumbnail" alt="avatar">
                                                <h3 class="text-dark text-uppercase font-weight-bold "><?php echo $active_firstname." ".$active_lastname ?></h3>
                                            </div>

                                                
                                            <div class="panel panel-default">
                                                <div class="panel-heading text-center font-weight-bold"><h3></i><?php echo $active_student_id_number ?></h3></div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row p-1">

                                        
                                                
                                            
                                            
                                            
                                            <div class="col border p-2">
                                                <form action="../Controller/ProfileController.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $active_id; ?>">
                                                    <input type="hidden" name="user_type_id" value="<?php echo $active_user_type_id; ?>">
                                                <div class="row">
                                                    <div class="col">
                                                        <label>First Name</label>
                                                        <input type="text"   name="first_name" class="form-control" value="<?php echo $active_firstname ?>" readonly  required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Middle Name</label>
                                                        <input type="text"   name="middle_name" class="form-control" value="<?php echo $active_middlename ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>Last Name</label>
                                                        <input type="text"    name="last_name" class="form-control" value="<?php echo $active_lastname ?>" readonly required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Birthdate</label>
                                                        <input type="date"  name="birthdate" class="form-control" value="<?php echo $active_birthdate ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Age</label>
                                                        <input type="number"  name="age" class="form-control" value="<?php echo $active_age ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Sex</label>
                                                        <select  name="sex" class="form-control" disabled required>
                                                            <option <?php echo ($active_sex == "Male") ? 'selected' : '' ?> value="Male">Male</option>
                                                            <option <?php echo ($active_sex == "Female") ? 'selected' : '' ?> value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Nationality</label>
                                                        <select  name="nationality" class="form-control" disabled required>
                                                            <?php include_once("../Utilities/nationality-profile.php"); ?>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col">
                                                        <label>Religion</label>
                                                        <select  name="religion" class="form-control" disabled required>
                                                            <?php include_once("../Utilities/religion-profile.php"); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label>Year</label>
                                                        <input  type="text" name="year" class="form-control" value="<?php echo $active_year ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Section</label>
                                                        <input  type="text" name="section" class="form-control" value="<?php echo $active_section ?>" readonly required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Contact Number</label>
                                                        <input  type="text" name="contact_number" class="form-control" value="<?php echo $active_contact_number ?>" readonly required>
                                                    </div>

                                                    <div class="col">
                                                        <label>Email Address</label>
                                                        <input  type="email" name="email_address" class="form-control" value="<?php echo $active_email_address ?>" disabled required> 
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Address</label>
                                                        <input  type="text" name="address" class="form-control" value="<?php echo $active_province." ".$active_city_municipality.", ".$active_barangay ?>" readonly required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label >Emergency Person Name</label>
                                                        <input type="text" name="emergency_person_name" class="form-control" value="<?php echo $active_emergency_person_name ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label >Relationship</label>
                                                        <input type="text" name="relationship" class="form-control" readonly value="<?php echo $active_emergency_relationship ?>" >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label >Emergency Address</label>
                                                        <input type="text" name="emergency_address" class="form-control" readonly value="<?php echo $active_emergency_address ?>" >
                                                    </div>
                                                    <div class="col">
                                                        <label >Emergency Contact No.</label>
                                                        <input type="text" name="relationship" class="form-control" readonly value="<?php echo $active_emergency_contact_number ?>" >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Student ID Number</label>
                                                        <input  type="text" name="active_student_id_number" class="form-control" value="<?php echo $active_student_id_number ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Course</label>
                                                        <input  type="text" name="active_student_id_number" class="form-control"  readonly required value="<?php 
                                                        switch($active_course_id){
                                                            case "1" : echo "BS Accountacy"; break; 
                                                            case "2" : echo "BS Architecture"; break; 
                                                            case "3" : echo "BSBA Major in Financial Management"; break; 
                                                            case "4" : echo "BSBA Major in Marketing Management"; break; 
                                                            case "5" : echo "BS Civil Engineering"; break; 
                                                            case "6" : echo "BS Computer Engineering"; break; 
                                                            case "7" : echo "BS Hospitality Management"; break; 
                                                            case "8" : echo "BS Psychology"; break; 
                                                            case "9" : echo "BS Tourism Management"; break; 
                                                            case "10" : echo "BS Information Technology"; break; 
                                                            case "11" : echo "Master in Management with Specialization in Bussiness Analytics"; break; 
                                                            case "12" : echo "ABM"; break; 
                                                            case "13" : echo "HUMSS"; break; 
                                                            case "14" : echo "STEM"; break; 
                                                            default : echo "Something went wrong";
                                                        }
                                                        ?>
                                                        ">
                                                    </div>
                                                </div>
                                                <!-- <div class="row d-flex justify-content-end align-items-center mt-4 pr-3">
                                                    
                                                    <a  class="btn btn-primary" id="cancel_update" hidden>Cancel</a>
                                                    <button type="submit"  class="btn btn-primary ml-2" name="update_profile" id="update_profile" hidden>Save Changes</button>
                                                    
                                                </div> -->
                                            </div><!--/col-9-->
                                            </form>
                                        </div><!--/row-->

                                        <div class="row d-flex align-items-center justify-content-center mt-2">
                                            <h3 class="text-center">Physical Exam</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label>Blood Pressure</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['systolic']."/".$row['diastolic']; ?>">
                                            </div>
                                            <div class="col">
                                                <label>Pulse Rate</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['pulse_rate'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Height</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['height'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Weight</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['weight'] ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label>OD</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['OD'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>OS</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['OS'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>AD</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['AD'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>AS</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['AS_findings'] ?>">
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center mt-2">
                                            <h3 class="text-center">Medical Treatment</h3>
                                        </div>
                                        <div class="row px-2 mt-2">
                                            <div class="col border border-dark">
                                                <h6 class="text-center">Date</h6>
                                                
                                            </div>
                                            <div class="col border border-dark">
                                                <h6 class="text-center">Doctor/Nurse</h6>
                                            </div>
                                            <div class="col border border-dark">
                                                <h6 class="text-center">Complaint</h6>
                                            </div>
                                            <div class="col border border-dark">
                                                <h6 class="text-center">Diagnosis</h6>
                                            </div>
                                            <div class="col border border-dark">
                                                <h6 class="text-center">Treatment</h6>
                                            </div>
                                        </div>
                                        <div class="row px-2">
                                            <div class="col border border-dark">
                                                <p><?php echo date('M-d-Y h:i A', strtotime($row['med_record_date_time'])) ?></p>
                                                
                                            </div>
                                            <div class="col border border-dark">
                                                <p><?php echo $row['med_first_name']." ".$row['med_last_name']; ?></p>
                                            </div>
                                            <div class="col border border-dark">
                                                <p><?php echo $row['complaints'] ?></p>
                                            </div>
                                            <div class="col border border-dark">
                                            <p><?php echo $row['diagnosis'] ?></p>
                                            </div>
                                            <div class="col border border-dark">
                                            <p><?php echo $row['treatment'] ?></p>
                                            </div>
                                        </div>

                                        
                                                <?php 
                                                $med_record_id = $row['med_record_id'];
                                                $checkifHaveLabResult = mysqli_query($conn,"SELECT uploadfile,status, laboratoryresult.status AS lab_status  FROM laboratoryresult WHERE mhrIDnum ='$med_record_id'");
                                                $row2 = $checkifHaveLabResult->fetch_assoc();

                                                if($checkifHaveLabResult->num_rows == 1){?>
                                                        <div class="row mt-2">
                                                        <div class="col">
                                                            <h3 class="text-center">Lab Result</h3>
                                                        </div>
                                                        </div>
                                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                                        <div class="row">
                                                            <div class="col">
                                                                <?php 
                                                                if(!in_array($row2['lab_status'],['Rejected','Pending','Not Set'])) { ?>
                                                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row2['uploadfile']); ?>" height="500" width="600">
                                                                <?php }
                                                                 else {
                                                                    echo "Lab Result is Rejected Penidng or Not Set";
                                                                } ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }
                                                else{
                                                    echo "<div class='row mt-2'>
                                                    <div class='col'>
                                                    <h3 class='text-center'>Lab Result is Not Required</h3>
                                                    </div>
                                                    </div>";
                                                }
                                                ?>

                                                <?php 

                                                $checkifHaveVaccRecord = mysqli_query($conn,"SELECT uploadFile,status, vaccinationrecord.status AS vacc_status  FROM vaccinationrecord WHERE mhrIDnum ='$med_record_id'");
                                                $row3 = $checkifHaveVaccRecord->fetch_assoc();

                                                if($checkifHaveVaccRecord->num_rows == 1){?>
                                                        <div class="row mt-3">
                                                        <div class="col">
                                                            <h3 class="text-center">Vaccination Record</h3>
                                                        </div>
                                                        </div>
                                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                                        <div class="row">
                                                            <div class="col">
                                                                <?php 
                                                                if(!in_array($row3['vacc_status'],['Rejected','Pending','Not Set'])) { ?>
                                                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row3['uploadFile']); ?>" height="500" width="600">
                                                                <?php }
                                                                 else {
                                                                    echo "Vaccination Record is Rejected Penidng or Not Set";
                                                                } ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }
                                                else{
                                                    echo "<div class='row mt-2'>
                                                    <div class='col'>
                                                    <h3 class='text-center'>Vaccination Record is Not Required</h3>
                                                    </div>
                                                    </div>";
                                                }
                                                ?>


                                               
                                        


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- View Health Record Modal -->

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal -->

<!-- Modal -->



<script>
    $(function() {
        $("#medical_health_record").dataTable();
    });
</script>
<script src="../js/admin_enable_disbaled_inputs.js"></script>


<?php include_once("layouts/footer.php") ?>