<?php 
$page_title = "RECORDS";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2">

    <div class="row">
        <div class="col">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addHealthRecordModal">Add Record</button>
        </div>
    </div>

    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
            <div class="d-flex align-items-center justify-content-between">
                <h3 class="font-weight-bold text-dark" style="width: 90%;">Medical Health Record</h3>
                
            </div>
            <table id="medical_health_record" class="table table-bordered" style="width: 100%;" >
                <thead>
                    <tr>
                        <th>Medical Health Record ID</th>
                        <th>Student ID No.</th>
                        <th>Student Name</th>
                        <th>Program</th>
                        <th>Year and Section</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $selectMedicalHealthRecords = mysqli_query($conn,"SELECT *, medicalhealthrecord.id AS med_record_id, stud.student_id_number AS stud_id_number, u2.firstName AS stud_first_name, u2.lastName AS stud_last_name,u2.middleName AS stud_middle_name, stud.courseID AS stud_course, stud.year as stud_year, stud.section as stud_sec, stud.birthdate AS stud_dob, stud.age as stud_age, stud.sex as stud_sex, stud.nationality AS stud_nationality, stud.religion as stud_religion, stud.contact_number as stud_contact_number, u2.email_address as stud_email_address,stud.province as stud_province,stud.city_municipality as stud_city_municipality, stud.barangay as stud_barangay, medicaltreatmentrecord.date_time AS med_record_date_time, u1.firstName as med_first_name, u1.middleName as med_middle_name, u1.lastName as med_last_name, u2.profile_img as stud_avatar  FROM medicalhealthrecord INNER JOIN students AS stud ON medicalhealthrecord.student_id = stud.id INNER JOIN medicalprofessional ON medicalprofessional.id = medicalhealthrecord.med_prof_id INNER JOIN medicaltreatmentrecord ON medicaltreatmentrecord.mhrIDnum = medicalhealthrecord.id INNER JOIN medicalhistory ON medicalhistory.mhrIDnum = medicalhealthrecord.id INNER JOIN medicalhistoryofdisease ON medicalhistoryofdisease.medhistoryID = medicalhistory.id INNER JOIN physicalexam ON medicalhealthrecord.id = physicalexam.mhrIDnum INNER JOIN physicalexamfindings ON physicalexamfindings.physicalExamID = physicalexam.id INNER JOIN users AS u1 ON medicalprofessional.userID = u1.id INNER JOIN users AS u2 ON stud.userID = u2.id ORDER BY medicalhealthrecord.id DESC");
                    while($row = $selectMedicalHealthRecords->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $row['med_record_id']; ?></td>
                            <td><?php echo $row['stud_id_number']; ?></td>
                            <td><?php echo $row['stud_first_name']." ". $row['stud_last_name'];?></td>
                            <td>
                                <?php 
                                switch($row['stud_course']){
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
                            </td>
                            
                            <td><?php echo $row['stud_year']."-".$row['stud_sec'] ?></td>
                            <td><?php echo $row['housenumber']." ".$row['streetname'].", ".$row['barangay']." ".$row['city_municipality'].", ".$row['province'] ?></td>
                            <td class="d-flex justify-content-around align-items-center">
                                <div data-toggle="tooltip"  data-placement="bottom" title="View">
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewHealthRecordModal<?php echo $row['med_record_id'];?>"><i class="fas fa-eye"></i></button>
                                </div>
                                <div data-toggle="tooltip"  data-placement="bottom" title="Edit">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editHealthRecordModal<?php echo $row['med_record_id'];?>"><i class="fas fa-edit"></i></button>
                                </div>
                                <div data-toggle="tooltip"  data-placement="bottom" title="Print">
                                    <form action="../Controller/medical-health-record-print.php" method="POST">
                                        <input type="hidden" name="medical_health_record_id" value="<?php echo $row['med_record_id'];?>">
                                        <button type="submit" nmae="print" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></button>
                                    </form>
                                </div>
                                
                               
                                
                            </td>
                        </tr>



                        <!-- Edit Health Record Modal -->
                        <div class="modal fade" id="editHealthRecordModal<?php echo $row['med_record_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-notes-medical mr-2"></i>Edit Medical Health Record</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="../Controller/MedicalHealthRecordController.php" method="post">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <div class="col-sm-4"><!--left col-->
                                                

                                            <div class="text-center">
                                            <?php if (empty($row['stud_avatar'])) {?>
                                                <img class="avatar border rounded-circle img-thumbnail" height="200" width="200" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                            <?php } else {?>
                                                <img class="avatar border rounded-circle img-thumbnail" height="200" width="200" src="../Controller/user_avatars/<?php echo $row['stud_avatar'] ?>">
                                            <?php } ?>
                                                <h3 class="text-dark text-uppercase font-weight-bold "><?php echo $row['stud_first_name']." ".$row['stud_last_name']; ?></h3>
                                            </div>
                                                

                                                
                                            <div class="panel panel-default">
                                                <div class="panel-heading text-center font-weight-bold"><h3></i><?php echo $row['student_id_number'] ?></h3></div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row p-1">
                                            <div class="col border p-2">
                                                <div class="row">
                                                    <div class="col">
                                                        <label>First Name</label>
                                                        <input type="text"   name="first_name" class="form-control" value="<?php echo $row['stud_first_name'] ?>" readonly  required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Middle Name</label>
                                                        <input type="text"   name="middle_name" class="form-control" value="<?php echo $row['stud_middle_name'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>Last Name</label>
                                                        <input type="text"    name="last_name" class="form-control" value="<?php echo $row['stud_last_name'] ?>" readonly required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Birthdate</label>
                                                        <input type="date"  name="birthdate" class="form-control" value="<?php echo $row['stud_dob']; ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Age</label>
                                                        <input type="number"  name="age" class="form-control" value="<?php echo $row['stud_age'] ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Sex</label>
                                                        <select  name="sex" class="form-control" disabled required>
                                                            <option <?php echo ($row['stud_sex'] == "Male") ? 'selected' : '' ?> value="Male">Male</option>
                                                            <option <?php echo ($row['stud_sex'] == "Female") ? 'selected' : '' ?> value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Nationality</label>
                                                        <input type="text" value="<?php echo ucfirst($row['stud_nationality']); ?>" class="form-control" readonly>
                                                    </div>
                                                    
                                                    <div class="col">
                                                        <label>Religion</label>
                                                        <input type="text" value="<?php echo $row['stud_religion']; ?>" class="form-control" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>Year</label>
                                                        <input  type="text" name="year" class="form-control" value="<?php echo $row['year'] ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Section</label>
                                                        <input  type="text" name="section" class="form-control" value="<?php echo $row['section'] ?>" readonly required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Contact Number</label>
                                                        <input  type="text" name="contact_number" class="form-control" value="<?php echo $row['stud_contact_number']; ?>" readonly required>
                                                    </div>

                                                    <div class="col">
                                                        <label>Email Address</label>
                                                        <input  type="email" name="email_address" class="form-control" value="<?php echo $row['stud_email_address'] ?>" disabled required> 
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Address</label>
                                                        <input  type="text" name="address" class="form-control" value="<?php echo $row['housenumber']." ".$row['streetname'].", ".$row['barangay']." ".$row['city_municipality'].", ".$row['province'] ?>" readonly required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label >Emergency Person Name</label>
                                                        <input type="text" name="emergency_person_name" class="form-control" value="<?php echo $row['emergency_person_name'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label >Relationship</label>
                                                        <input type="text" name="relationship" class="form-control" readonly value="<?php echo $row['emergency_relationship'] ?>" >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label >Emergency Person's Address</label>
                                                        <input type="text" name="emergency_address" class="form-control" readonly value="<?php echo $row['emergency_address'] ?>" >
                                                    </div>
                                                    <div class="col">
                                                        <label >Emergency Contact No.</label>
                                                        <input type="text" name="relationship" class="form-control" readonly value="<?php echo $row['emergency_contact_number'] ?>" >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Student ID Number</label>
                                                        <input  type="text" name="active_student_id_number" class="form-control" value="<?php echo $row['student_id_number'] ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Course</label>
                                                        <input  type="text" name="active_student_id_number" class="form-control"  readonly required value="<?php 
                                                        switch($row['courseID']){
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
                                            
                                        </div><!--/row-->

                                        <div class="row d-flex align-items-center justify-content-center mt-2">
                                            <h3 class="text-center">Medical History</h3>
                                            <input type="hidden" name="med_record_id" value="<?php echo $row['med_record_id'] ?>">
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label>History of previous illness or surgery</label>
                                                <textarea name="history_of_previous_illness_or_surgery" id="" cols="200" rows="5" class="form-control" style="resize: none;" required ><?php echo $row['history_of_previous_illness_or_surgery'] ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col">
                                                <div class="form-check">
                                                    
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Allergy </label> <br> 
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="allergy_date" value="<?php echo $row['allergy_date'] ?>"  >
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="allergy_description"   value="<?php echo $row['allergy_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                               
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Diabetes Mellitus </label> 
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="diabetes_date"   value="<?php echo $row['diabetes_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="diabetes_description"   value="<?php echo $row['diabetes_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                
                                                    <label class="form-check-label" for="flexCheckDefault" >
                                                        Kidney Disease </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="kidney_date"  value="<?php echo $row['kidney_date'] ?>"> 
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="kidney_description"   value="<?php echo $row['kidney_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                               
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Smoker </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="smoker_date"   value="<?php echo $row['smoker_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="smoker_description"   value="<?php echo $row['smoker_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                    
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Asthma </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="asthma_date"   value="<?php echo $row['asthma_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="asthma_description"   value="<?php echo $row['asthma_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                            <div class="form-check">
                                                    
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Heart Ailment </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="heart_date"   value="<?php echo $row['heart_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="heart_description"  value="<?php echo $row['heart_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                            <div class="form-check">
                                                   
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Gynecological/Obstetrical </label>
                                            </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="gynecological_date"   value="<?php echo $row['gynecological_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="gynecological_description"   value="<?php echo $row['gynecological_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                   
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Alcoholic Drinker </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="alcoholic_date"   value="<?php echo $row['alcoholic_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="alcoholic_description"   value="<?php echo $row['alcoholic_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                    
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        TB </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="tb_date"   value="<?php echo $row['tb_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="tb_description"   value="<?php echo $row['tb_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                   
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        HPN </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="hpn_date"   value="<?php echo $row['hpn_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                
                                                <input type="text" class="form-control" name="hpn_description" value="<?php echo $row['hpn_description'] ?>"  >
                                            </div>
                                            
                                        </div>

                                        <div class="row d-flex align-items-center justify-content-center mt-2">
                                            <h3 class="text-center">Physical Exam</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label>Systolic</label>
                                                <input type="text" name="systolic" class="form-control"  value="<?php echo $row['systolic'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Diastolic</label>
                                                <input type="text" name="diastolic" class="form-control"  value="<?php echo $row['diastolic'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Pulse Rate</label>
                                                <input type="text" name="pr" class="form-control"  value="<?php echo $row['pulse_rate'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Height</label>
                                                <input type="text" name="height" class="form-control"  value="<?php echo $row['height'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Weight</label>
                                                <input type="text" name="weight" class="form-control"  value="<?php echo $row['weight'] ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label>OD</label>
                                                <input type="text" name="OD" class="form-control"  value="<?php echo $row['OD'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>OS</label>
                                                <input type="text" name="OS" class="form-control"  value="<?php echo $row['OS'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>AD</label>
                                                <input type="text" name="AD" class="form-control"  value="<?php echo $row['AD'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>AS</label>
                                                <input type="text" name="AS_findings" class="form-control"  value="<?php echo $row['AS_findings'] ?>">
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col">
                                                <label>Skin</label>
                                                <input type="text" name="skin" class="form-control"  value="<?php echo $row['skin'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Eyes</label>
                                                <input type="text" name="eyes" class="form-control"  value="<?php echo $row['eyes'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Ears</label>
                                                <input type="text" name="ears" class="form-control"  value="<?php echo $row['ears'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Nose</label>
                                                <input type="text" name="nose" class="form-control"  value="<?php echo $row['nose'] ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label>Throat</label>
                                                <input type="text" class="form-control"  value="<?php echo $row['throat'] ?>" name="throat">
                                            </div>
                                            <div class="col">
                                                <label>Neck</label>
                                                <input type="text" class="form-control"  value="<?php echo $row['neck'] ?>" name="neck">
                                            </div>
                                            <div class="col">
                                                <label>Thorax</label>
                                                <input type="text" class="form-control"  value="<?php echo $row['thorax'] ?>" name="thorax">
                                            </div>
                                            <div class="col">
                                                <label>Heart</label>
                                                <input type="text" class="form-control"  value="<?php echo $row['heart'] ?>" name="heart_findings">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label>Lungs</label>
                                                <input type="text" class="form-control"  value="<?php echo $row['lungs'] ?>" name="lungs">
                                            </div>
                                            <div class="col">
                                                <label>Abdomen</label>
                                                <input type="text" class="form-control"  value="<?php echo $row['abdomen'] ?>" name="abdomen">
                                            </div>
                                            <div class="col">
                                                <label>Extermeties</label>
                                                <input type="text" class="form-control"  value="<?php echo $row['extremeties'] ?>" name="extremeties">
                                            </div>
                                            <div class="col">
                                                <label>Deformities</label>
                                                <input type="text" class="form-control"  value="<?php echo $row['deformities'] ?>" name="deformities">
                                            </div>
                                        </div>


                                        <div class="row d-flex align-items-center justify-content-center mt-2">
                                            <h3 class="text-center">Medical Treatment</h3>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col">
                                                <label>Complaints</label>
                                                <input type="text" name="complaints" value="<?php echo $row['complaints'] ?>" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label>Diagnosis</label>
                                                <textarea name="diagnosis" cols="200" rows="5" class="form-control" style="resize: none;" required><?php echo $row['diagnosis'] ?></textarea>
                                            </div>
                                            <div class="col">
                                                <label>Treatment</label>
                                                <textarea name="treatment" cols="200" rows="5" class="form-control" style="resize: none;" required><?php echo $row['treatment'] ?></textarea>
                                            </div>
                                        </div>
                                    

                                        


                                    </div>
                                    <div class="modal-footer">
                                        
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="update_medical_health_record" class="btn btn-primary" >Update</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Edit Health Record Modal -->

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
                                                <?php if (empty($row['stud_avatar'])) {?>
                                                    <img class="avatar border rounded-circle img-thumbnail" height="200" width="200" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                                <?php } else {?>
                                                    <img class="avatar border rounded-circle img-thumbnail" height="200" width="200" src="../Controller/user_avatars/<?php echo $row['stud_avatar'] ?>">
                                                <?php } ?>
                                                    <h3 class="text-dark text-uppercase font-weight-bold "><?php echo $row['stud_first_name']." ".$row['stud_last_name']; ?></h3>
                                                </div>

                                                    
                                                <div class="panel panel-default">
                                                    <div class="panel-heading text-center font-weight-bold"><h3></i><?php echo $row['student_id_number'] ?></h3></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-1">
                                            <div class="col border p-2">
                                                
                                                    <input type="hidden" name="id" value="">
                                                    <input type="hidden" name="user_type_id" value="">
                                                <div class="row">
                                                    <div class="col">
                                                        <label>First Name</label>
                                                        <input type="text"   name="first_name" class="form-control" value="<?php echo $row['stud_first_name'] ?>" readonly  required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Middle Name</label>
                                                        <input type="text"   name="middle_name" class="form-control" value="<?php echo $row['stud_middle_name'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>Last Name</label>
                                                        <input type="text"    name="last_name" class="form-control" value="<?php echo $row['stud_last_name'] ?>" readonly required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Birthdate</label>
                                                        <input type="date"  name="birthdate" class="form-control" value="<?php echo $row['stud_dob']; ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Age</label>
                                                        <input type="number"  name="age" class="form-control" value="<?php echo $row['stud_age'] ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Sex</label>
                                                        <select  name="sex" class="form-control" disabled required>
                                                            <option <?php echo ($row['stud_sex'] == "Male") ? 'selected' : '' ?> value="Male">Male</option>
                                                            <option <?php echo ($row['stud_sex'] == "Female") ? 'selected' : '' ?> value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Nationality</label>
                                                        <input type="text" value="<?php echo ucfirst($row['stud_nationality']); ?>" class="form-control" readonly>
                                                    </div>
                                                    
                                                    <div class="col">
                                                        <label>Religion</label>
                                                        <input type="text" value="<?php echo $row['stud_religion']; ?>" class="form-control" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>Year</label>
                                                        <input  type="text" name="year" class="form-control" value="<?php echo $row['year'] ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Section</label>
                                                        <input  type="text" name="section" class="form-control" value="<?php echo $row['section'] ?>" readonly required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Contact Number</label>
                                                        <input  type="text" name="contact_number" class="form-control" value="<?php echo $row['stud_contact_number']; ?>" readonly required>
                                                    </div>

                                                    <div class="col">
                                                        <label>Email Address</label>
                                                        <input  type="email" name="email_address" class="form-control" value="<?php echo $row['stud_email_address'] ?>" disabled required> 
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Address</label>
                                                        <input  type="text" name="address" class="form-control" value="<?php echo $row['housenumber']." ".$row['streetname'].", ".$row['barangay']." ".$row['city_municipality'].", ".$row['province'] ?>" readonly required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label >Emergency Person Name</label>
                                                        <input type="text" name="emergency_person_name" class="form-control" value="<?php echo $row['emergency_person_name'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label >Relationship</label>
                                                        <input type="text" name="relationship" class="form-control" readonly value="<?php echo $row['emergency_relationship'] ?>" >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label >Emergency Person's Address</label>
                                                        <input type="text" name="emergency_address" class="form-control" readonly value="<?php echo $row['emergency_address'] ?>" >
                                                    </div>
                                                    <div class="col">
                                                        <label >Emergency Contact No.</label>
                                                        <input type="text" name="relationship" class="form-control" readonly value="<?php echo $row['emergency_contact_number'] ?>" >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Student ID Number</label>
                                                        <input  type="text" name="active_student_id_number" class="form-control" value="<?php echo $row['student_id_number'] ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Course</label>
                                                        <input  type="text" name="active_student_id_number" class="form-control"  readonly required value="<?php 
                                                        switch($row['courseID']){
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
                                            <h3 class="text-center">Medical History</h3>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col">
                                                <label>History of previous illness or surgery</label>
                                                <textarea name="history_of_previous_illness_or_surgery" id="" cols="200" rows="5" class="form-control" style="resize: none;" required readonly><?php echo $row['history_of_previous_illness_or_surgery'] ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col">
                                                <div class="form-check">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Allergy </label> <br> 
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="dates[]" value="<?php echo $row['allergy_date'] ?>"  disabled>
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="med_hisoty_descriptions[]"  disabled value="<?php echo $row['allergy_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                               
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Diabetes Mellitus </label> 
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="dates[]"  disabled value="<?php echo $row['diabetes_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="med_hisoty_descriptions[]"  disabled value="<?php echo $row['diabetes_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                
                                                    <label class="form-check-label" for="flexCheckDefault" >
                                                        Kidney Disease </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="dates[]" disabled value="<?php echo $row['kidney_date'] ?>"> 
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="med_hisoty_descriptions[]"  disabled value="<?php echo $row['kidney_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                               
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Smoker </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="med_hisoty_descriptions[]"  disabled value="<?php echo $row['smoker_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="med_hisoty_descriptions[]"  disabled value="<?php echo $row['smoker_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                    
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Asthma </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="dates[]"  disabled value="<?php echo $row['asthma_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="med_hisoty_descriptions[]"  disabled value="<?php echo $row['asthma_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                            <div class="form-check">
                                                    
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Heart Ailment </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="dates[]"  disabled value="<?php echo $row['heart_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="med_hisoty_descriptions[]" disabled value="<?php echo $row['heart_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                            <div class="form-check">
                                                   
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Gynecological/Obstetrical </label>
                                            </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="dates[]"  disabled value="<?php echo $row['gynecological_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="med_hisoty_descriptions[]"  disabled value="<?php echo $row['gynecological_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                   
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Alcoholic Drinker </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="dates[]"  disabled value="<?php echo $row['alcoholic_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="med_hisoty_descriptions[]"  disabled value="<?php echo $row['alcoholic_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                    
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        TB </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="dates[]"  disabled value="<?php echo $row['tb_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                <!-- lalagyan ng date at description -->
                                                <input type="text" class="form-control" name="med_hisoty_descriptions[]"  disabled value="<?php echo $row['tb_description'] ?>">
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-check">
                                                   
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        HPN </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Date</label>
                                                <input type="date" class="form-control" name="dates[]"  disabled value="<?php echo $row['hpn_date'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Description</label>
                                                
                                                <input type="text" class="form-control" name="med_hisoty_descriptions[]" value="<?php echo $row['hpn_description'] ?>" disabled >
                                            </div>
                                            
                                        </div>

                                        <div class="row d-flex align-items-center justify-content-center mt-2">
                                            <h3 class="text-center">Physical Exam</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label>Blood Pressure</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['systolic']."/".$row['diastolic'] ?>">
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


                                        <div class="row">
                                            <div class="col">
                                                <label>Skin</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['skin'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Eyes</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['eyes'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Ears</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['ears'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Nose</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['nose'] ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label>Throat</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['throat'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Neck</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['neck'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Thorax</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['thorax'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Heart</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['heart'] ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label>Lungs</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['lungs'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Abdomen</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['abdomen'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Extermeties</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['extremeties'] ?>">
                                            </div>
                                            <div class="col">
                                                <label>Deformities</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $row['deformities'] ?>">
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
                                        <!-- -->
                                        <?php 
                                        $med_record_id = $row['med_record_id'];
                                        $checkifHaveLabResult = mysqli_query($conn,"SELECT uploadfile,status, laboratoryresult.status AS lab_status  FROM laboratoryresult WHERE mhrIDnum ='$med_record_id'");
                                        $row = $checkifHaveLabResult->fetch_assoc();

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
                                                        if(!in_array($row['lab_status'],['Rejected','Pending','Not Set'])) { ?>
                                                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['uploadfile']); ?>" height="500" width="600">
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
                                            echo "
                                            <div class='row mt-2'>
                                                <div class='col'>
                                                    <h3 class='text-center'>Vaccination Record is Not Required</h3>
                                                </div>
                                            </div>";
                                        }

                                        ?>
                                            <!-- -->
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
<!-- Add Health Record Modal -->
<div class="modal fade" id="addHealthRecordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-notes-medical mr-2"></i>Add Medical Health Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="../Controller/MedicalHealthRecordController.php" method="POST">
                <input type="hidden" name="med_prof_id" value="<?php echo $active_med_prof_id; ?>">
                <div class="row">
                    <div class="col">
                        <label>Year</label>
                            <select class="form-control" id="parent_selection" aria-label="Default select example" name="year" required>
                                <option selected disabled>Select Year</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Course</label>
                            <select name="courseID"  class="form-control" id="child_selection" >
                                <option selected disabled>Select Course</option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Section</label>
                            <select class="form-control" aria-label="Default select example" name="section" id="section_ajax" required >
                                <option selected disabled>Select Section</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>

                        <div class="col">
                            <label>Student</label>
                            <select class="form-control" aria-label="Default select example" id="student_ajax" name="student_id" required >
                                <option selected disabled>Select Student</option>
                                
                            </select>
                        </div>
                        
                        <script>
                        $("#section_ajax").change(function () {
                            var sectionID = $(this).val();
                            var courseID = $("select[name='courseID']").val();
                            var yearID = $("select[name='year']").val();


                            if(sectionID) {
                                console.log(sectionID);

                                $.ajax({
                                    url: "filter-students-by-section.php",
                                    type: "POST",
                                    data: { section: sectionID, course: courseID, year: yearID },
                                    success: function(data) {
                                        console.log(data);
                                        $('#student_ajax').empty();
                                        $.each(JSON.parse(data), function(key, value) {
                                            $('#student_ajax').append('<option value="'+ key +'">'+ value +'</option>');
                                        });
                                    }
                                });


                            }else{
                                console.log("Failed");
                                $('#student_ajax').empty();
                            }
                        });
                        </script>

                        <script>
                        $("#parent_selection").change(function () {
                            
                            var yearID = $(this).val();
                           


                            if(yearID) {
                                console.log(yearID);

                                $.ajax({
                                    url: "filter-students-by-year.php",
                                    type: "POST",
                                    data: { year: yearID },
                                    success: function(data) {
                                        console.log(data);
                                        $('#student_ajax').empty();
                                        $.each(JSON.parse(data), function(key, value) {
                                            $('#student_ajax').append('<option value="'+ key +'">'+ value +'</option>');
                                        });
                                    }
                                });


                            }else{
                                console.log("Failed");
                                $('#student_ajax').empty();
                            }
                        });
                        </script>

                        <script>
                        $("#child_selection").change(function () {
                            
                            var courseID = $(this).val();
                            var yearID = $("#parent_selection").val();
                           


                            if(courseID) {
                                console.log(courseID);

                                $.ajax({
                                    url: "filter-students-by-course.php",
                                    type: "POST",
                                    data: { course: courseID, year: yearID },
                                    success: function(data) {
                                        console.log(data);
                                        $('#student_ajax').empty();
                                        $.each(JSON.parse(data), function(key, value) {
                                            $('#student_ajax').append('<option value="'+ key +'">'+ value +'</option>');
                                        });
                                    }
                                });


                            }else{
                                console.log("Failed");
                                $('#student_ajax').empty();
                            }
                        });
                        </script>

                        <script>
                        $("#section_ajax").change(function () {
                            var sectionID = $(this).val();
                            var courseID = $("select[name='courseID']").val();
                            var yearID = $("select[name='year']").val();


                            if(sectionID) {
                                console.log(sectionID);

                                $.ajax({
                                    url: "filter-students.php",
                                    type: "POST",
                                    data: { section: sectionID, course: courseID, year: yearID },
                                    success: function(data) {
                                        console.log(data);
                                        $('#student_ajax').empty();
                                        $.each(JSON.parse(data), function(key, value) {
                                            $('#student_ajax').append('<option value="'+ key +'">'+ value +'</option>');
                                        });
                                    }
                                });


                            }else{
                                console.log("Failed");
                                $('#student_ajax').empty();
                            }
                        });
                        </script>





                        
                        
                </div>
                <div class="row d-flex align-items-center justify-content-center mt-2">
                    <h3 class="text-center">Medical History</h3>
                </div>
                
                
                <div class="row">
                    <div class="col">
                        <label>History of previous illness or surgery</label>
                        <textarea name="history_of_previous_illness_or_surgery" id="" cols="200" rows="5" class="form-control" style="resize: none;" required></textarea>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allergy_diseaseID" value="1" id="allergy" >
                            <label class="form-check-label" for="flexCheckDefault">
                                Allergy </label> <br> 
                        </div>
                    </div>
                    <div class="col">
                        <label>Date</label>
                        <input type="date" class="form-control" name="allergy_date" id="allergy_date" disabled required>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <!-- lalagyan ng date at description -->
                        <input type="text" class="form-control" name="allergy_description" id="allergy_description" disabled required>
                    </div>
                    <script>
                        let allergy = document.getElementById('allergy');
                        let allergy_date = document.getElementById('allergy_date');
                        let allergy_description = document.getElementById('allergy_description');
                        allergy.onchange = function() {
                            allergy_date.disabled = !this.checked;
                            allergy_date.value = "";
                            allergy_description.disabled = !this.checked;
                            allergy_description.value = "";
                        
                    };
                    </script>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="diabetes_diseaseID" value="2" id="diabetes">
                            <label class="form-check-label" for="flexCheckDefault">
                                Diabetes Mellitus </label> 
                        </div>
                    </div>
                    <div class="col">
                        <label>Date</label>
                        <input type="date" class="form-control" name="diabetes_date" id="diabetes_date" disabled required>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <!-- lalagyan ng date at description -->
                        <input type="text" class="form-control" name="diabetes_description" id="diabetes_description" disabled required>
                    </div>
                    <script>
                        let diabetes = document.getElementById('diabetes');
                        let diabetes_date = document.getElementById('diabetes_date');
                        let diabetes_description = document.getElementById('diabetes_description');
                        diabetes.onchange = function() {
                            diabetes_date.disabled = !this.checked;
                            diabetes_date.value = "";
                            diabetes_description.disabled = !this.checked;
                            diabetes_description.value = "";
                        
                    };
                    </script>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="kidney_diseaseID" value="3" id="kidney">
                            <label class="form-check-label" for="flexCheckDefault" >
                                Kidney Disease </label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Date</label>
                        <input type="date" class="form-control" name="kidney_date" id="kidney_date" disabled required> 
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <!-- lalagyan ng date at description -->
                        <input type="text" class="form-control" name="kidney_description" id="kidney_description"  disabled required>
                    </div>
                    <script>
                        let kidney = document.getElementById('kidney');
                        let kidney_date = document.getElementById('kidney_date');
                        let kidney_description = document.getElementById('kidney_description');
                        kidney.onchange = function() {
                            kidney_date.disabled = !this.checked;
                            kidney_date.value = "";
                            kidney_description.disabled = !this.checked;
                            kidney_description.value = "";
                        };
                    </script>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="smoker_diseaseID" value="4" id="smoker">
                            <label class="form-check-label" for="flexCheckDefault">
                                Smoker </label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Date</label>
                        <input type="date" class="form-control" name="smoker_date" id="smoker_date" disabled required>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <!-- lalagyan ng date at description -->
                        <input type="text" class="form-control" name="smoker_description" id="smoker_description" disabled required>
                    </div>
                    <script>
                        let smoker = document.getElementById('smoker');
                        let smoker_date = document.getElementById('smoker_date');
                        let smoker_description = document.getElementById('smoker_description');
                        smoker.onchange = function() {
                            smoker_date.disabled = !this.checked;
                            smoker_date.value = "";
                            smoker_description.disabled = !this.checked;
                            smoker_description.value = "";
                        };
                    </script>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="asthma_diseaseID" value="5" id="asthma">
                            <label class="form-check-label" for="flexCheckDefault">
                                Asthma </label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Date</label>
                        <input type="date" class="form-control" name="asthma_date" id="asthma_date" disabled required required required required required>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <!-- lalagyan ng date at description -->
                        <input type="text" class="form-control" name="asthma_description" id="asthma_description" disabled required required required required required>
                    </div>
                    <script>
                        let asthma = document.getElementById('asthma');
                        let asthma_date = document.getElementById('asthma_date');
                        let asthma_description = document.getElementById('asthma_description');
                        asthma.onchange = function() {
                            asthma_date.disabled = !this.checked;
                            asthma_date.value = "";
                            asthma_description.disabled = !this.checked;
                            asthma_description.value = "";
                        };
                    </script>
                </div>

                <div class="row">
                    <div class="col">
                    <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="heart_diseaseID" value="6" id="heart">
                            <label class="form-check-label" for="flexCheckDefault">
                                Heart Ailment </label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Date</label>
                        <input type="date" class="form-control" name="heart_date" id="heart_date" disabled required required required required>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <!-- lalagyan ng date at description -->
                        <input type="text" class="form-control" name="heart_description" id="heart_description" disabled required required required required>
                    </div>
                    <script>
                        let heart = document.getElementById('heart');
                        let heart_date = document.getElementById('heart_date');
                        let heart_description = document.getElementById('heart_description');
                        heart.onchange = function() {
                            heart_date.disabled = !this.checked;
                            heart_date.value = "";
                            heart_description.disabled = !this.checked;
                            heart_description.value = "";
                        };
                    </script>
                </div>

                <div class="row">
                    <div class="col">
                    <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="gynecological_diseaseID" value="7" id="gynecological">
                            <label class="form-check-label" for="flexCheckDefault">
                                Gynecological/Obstetrical </label>
                    </div>
                    </div>
                    <div class="col">
                        <label>Date</label>
                        <input type="date" class="form-control" name="gynecological_date" id="gynecological_date" disabled required required required>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <!-- lalagyan ng date at description -->
                        <input type="text" class="form-control" name="gynecological_description" id="gynecological_description" disabled required required required>
                    </div>
                    <script>
                        let gynecological = document.getElementById('gynecological');
                        let gynecological_date = document.getElementById('gynecological_date');
                        let gynecological_description = document.getElementById('gynecological_description');
                        gynecological.onchange = function() {
                            gynecological_date.disabled = !this.checked;
                            gynecological_date.value = "";
                            gynecological_description.disabled = !this.checked;
                            gynecological_description.value = "";
                        };
                    </script>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="alcoholic_diseaseID" value="8" id="alcoholic">
                            <label class="form-check-label" for="flexCheckDefault">
                                Alcoholic Drinker </label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Date</label>
                        <input type="date" class="form-control" name="alcoholic_date" id="alcoholic_date" disabled required required>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <!-- lalagyan ng date at description -->
                        <input type="text" class="form-control" name="alcoholic_description" id="alcoholic_description" disabled required required>
                    </div>
                    <script>
                        let alcoholic = document.getElementById('alcoholic');
                        let alcoholic_date = document.getElementById('alcoholic_date');
                        let alcoholic_description = document.getElementById('alcoholic_description');
                        alcoholic.onchange = function() {
                            alcoholic_date.disabled = !this.checked;
                            alcoholic_date.value = "";
                            alcoholic_description.disabled = !this.checked;
                            alcoholic_description.value = "";
                        };
                    </script>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tb_diseaseID" value="9" id="tb">
                            <label class="form-check-label" for="flexCheckDefault">
                                TB </label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Date</label>
                        <input type="date" class="form-control" name="tb_date" id="tb_date" disabled required>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <!-- lalagyan ng date at description -->
                        <input type="text" class="form-control" name="tb_description" id="tb_description" disabled required>
                    </div>
                    <script>
                        let tb = document.getElementById('tb');
                        let tb_date = document.getElementById('tb_date');
                        let tb_description = document.getElementById('tb_description');
                        tb.onchange = function() {
                            tb_date.disabled = !this.checked;
                            tb_date.value = "";
                            tb_description.disabled = !this.checked;
                            tb_description.value = "";
                        };
                    </script>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hpn_diseaseID" value="10" id="hpn">
                            <label class="form-check-label" for="flexCheckDefault">
                                HPN </label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Date</label>
                        <input type="date" class="form-control" name="hpn_date" id="hpn_date" disabled required>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        
                        <input type="text" class="form-control" name="hpn_description" id="hpn_description" disabled required>
                    </div>
                    <script>
                        let hpn = document.getElementById('hpn');
                        let hpn_date = document.getElementById('hpn_date');
                        let hpn_description = document.getElementById('hpn_description');
                        hpn.onchange = function() {
                            hpn_date.disabled = !this.checked;
                            hpn_date.value = "";
                            hpn_description.disabled = !this.checked;
                            hpn_description.value = "";
                        };
                    </script>
                </div>

                
                <div class="row d-flex align-items-center justify-content-center mt-2">
                    <h3 class="text-center">Physical Examination</h3>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Systolic</label>
                        <input type="number" class="form-control" name="systolic" required>
                    </div>
                    <div class="col">
                        <label>Diastolic</label>
                        <input type="number" class="form-control" name="diastolic" required>
                    </div>
                    
                    <div class="col">
                        <label>Pulse Rate</label>
                        <input type="number" class="form-control" name="pr" required>           
                    </div>
                    <div class="col">
                        <label>Height</label>
                        <input type="number" class="form-control" name="height" required> 
                    </div>
                    <div class="col">
                        <label>Weight</label>
                        <input type="number" class="form-control" name="weight" required> 
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Skin" id="skin">
                            <label class="form-check-label" for="flexCheckDefault">
                               Skin</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="skin" id="skin_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                            let skin = document.getElementById('skin');
                            let skin_description = document.getElementById('skin_description');
                            skin.onchange = function() {
                                skin_description.disabled = !this.checked;
                                skin_description.value = "";
                            };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Eyes" id="eyes">
                            <label class="form-check-label" for="flexCheckDefault">
                            Eyes</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="eyes" id="eyes_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                            let eyes = document.getElementById('eyes');
                            let eyes_description = document.getElementById('eyes_description');
                            eyes.onchange = function() {
                                eyes_description.disabled = !this.checked;
                                eyes_description.value = "";
                            };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="OD" id="od">
                            <label class="form-check-label" for="flexCheckDefault">
                            OD</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="OD" id="od_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let od = document.getElementById('od');
                                let od_description = document.getElementById('od_description');
                                od.onchange = function() {
                                    od_description.disabled = !this.checked;
                                    od_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="OS" id="os">
                            <label class="form-check-label" for="flexCheckDefault">
                            OS</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="OS" id="os_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let os = document.getElementById('os');
                                let os_description = document.getElementById('os_description');
                                os.onchange = function() {
                                    os_description.disabled = !this.checked;
                                    os_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Ears" id="ears">
                            <label class="form-check-label" for="flexCheckDefault">
                            Ears</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="ears" id="ears_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let ears = document.getElementById('ears');
                                let ears_description = document.getElementById('ears_description');
                                ears.onchange = function() {
                                    ears_description.disabled = !this.checked;
                                    ears_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="AD" id="ad">
                            <label class="form-check-label" for="flexCheckDefault">
                            AD</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="AD" id="ad_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let ad = document.getElementById('ad');
                                let ad_description = document.getElementById('ad_description');
                                ad.onchange = function() {
                                    ad_description.disabled = !this.checked;
                                    ad_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="AS" id="as">
                            <label class="form-check-label" for="flexCheckDefault">
                            AS</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="AS" id="as_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let as = document.getElementById('as');
                                let as_description = document.getElementById('as_description');
                                as.onchange = function() {
                                    as_description.disabled = !this.checked;
                                    as_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Nose" id="nose">
                            <label class="form-check-label" for="flexCheckDefault">
                            Nose</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="nose" id="nose_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let nose = document.getElementById('nose');
                                let nose_description = document.getElementById('nose_description');
                                nose.onchange = function() {
                                    nose_description.disabled = !this.checked;
                                    nose_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Throat" id="throat">
                            <label class="form-check-label" for="flexCheckDefault">
                            Throat</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="throat" id="throat_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let throat = document.getElementById('throat');
                                let throat_description = document.getElementById('throat_description');
                                throat.onchange = function() {
                                    throat_description.disabled = !this.checked;
                                    throat_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Neck" id="neck" >
                            <label class="form-check-label" for="flexCheckDefault">
                            Neck</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="neck" id="neck_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let neck = document.getElementById('neck');
                                let neck_description = document.getElementById('neck_description');
                                neck.onchange = function() {
                                    neck_description.disabled = !this.checked;
                                    neck_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Thorax" id="thorax">
                            <label class="form-check-label" for="flexCheckDefault">
                            Thorax</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="thorax" id="thorax_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let thorax = document.getElementById('thorax');
                                let thorax_description = document.getElementById('thorax_description');
                                thorax.onchange = function() {
                                    thorax_description.disabled = !this.checked;
                                    thorax_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Heart" id="heart2">
                            <label class="form-check-label" for="flexCheckDefault">
                            Heart</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="heart_findings" id="heart2_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let heart2 = document.getElementById('heart2');
                                let heart2_description = document.getElementById('heart2_description');
                                heart2.onchange = function() {
                                    heart2_description.disabled = !this.checked;
                                    heart2_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Lungs" id="lungs">
                            <label class="form-check-label" for="flexCheckDefault">
                            Lungs</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="lungs" id="lungs_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let lungs = document.getElementById('lungs');
                                let lungs_description = document.getElementById('lungs_description');
                                lungs.onchange = function() {
                                    lungs_description.disabled = !this.checked;
                                    lungs_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Abdomen" id="abdomen">
                            <label class="form-check-label" for="flexCheckDefault">
                            Abdomen</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="abdomen" id="abdomen_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let abdomen = document.getElementById('abdomen');
                                let abdomen_description = document.getElementById('abdomen_description');
                                abdomen.onchange = function() {
                                    abdomen_description.disabled = !this.checked;
                                    abdomen_description.value = "";
                                };
                        </script>   
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Extremeties" id="extremeties">
                            <label class="form-check-label" for="flexCheckDefault">
                            Extremeties</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="extremeties" id="extremeties_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let extremeties = document.getElementById('extremeties');
                                let extremeties_description = document.getElementById('extremeties_description');
                                extremeties.onchange = function() {
                                    extremeties_description.disabled = !this.checked;
                                    extremeties_description.value = "";
                                };
                        </script>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  value="Deformities" id="deformities">
                            <label class="form-check-label" for="flexCheckDefault">
                            Deformities</label>
                        </div>
                    </div>
                    <div class="col">
                        <label>Description</label>
                        <input type="text" class="form-control" name="deformities" id="deformities_description" disabled required>
                    </div>
                    <div class="col">
                        <script>
                                let deformities = document.getElementById('deformities');
                                let deformities_description = document.getElementById('deformities_description');
                                deformities.onchange = function() {
                                    deformities_description.disabled = !this.checked;
                                    deformities_description.value = "";
                                };
                        </script>
                    </div>
                </div>


                
                        

                <div class="row d-flex align-items-center justify-content-center mt-2">
                    <h3 class="text-center">Medical Treatment</h3>
                </div>

                <div class="row mt-1">
                    <div class="col">
                        <label>Complaints</label>
                        <input type="text" name="complaints" required class="form-control" >
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Diagnosis</label>
                        <textarea name="diagnosis" cols="200" rows="5" class="form-control" style="resize: none;" required></textarea>
                    </div>
                    <div class="col">
                        <label>Treatment</label>
                        <textarea name="treatment" cols="200" rows="5" class="form-control" style="resize: none;" required></textarea>
                    </div>
                </div>

               <div class="row mt-2 px-2">
               <div class="form-check mr-2">
                    <input class="form-check-input" type="checkbox" value="yes" id="flexCheckDefault" name="laboratory">
                    <label class="form-check-label" for="flexCheckDefault">
                        Is Laboratory Required?
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="yes" id="flexCheckDefault" name="vaccine_record">
                    <label class="form-check-label" for="flexCheckDefault">
                        Is Vaccine Record required?
                    </label>
                </div>
                
               </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="add_medical_health_record">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Health Record Modal -->
<!-- Modal -->



<script>
    $(function() {
        $("#medical_health_record").dataTable();
    });
</script>
<script src="../js/year_course.js"></script>



<?php include_once("layouts/footer.php") ?>

<script>
  /*
*  jquery-ph-locations - v1.0.1
*  jQuery Plugin for displaying dropdown list of Philippines' Region, Province, City and Barangay in your webpage.
*  https://github.com/buonzz/jquery-ph-locations
*
*  Made by Buonzz Systems
*  Under MIT License
*/
;( function( $, window, document, undefined ) {
  var filterfieldname = "";
  
  "use strict";

      // defaults
      var pluginName = "ph_locations",
          defaults = {
              location_type : "provinces", // what data this control supposed to display? regions, provinces, cities or barangays?,
              api_base_url: 'https://ph-locations-api.buonzz.com/',
              order: "name asc",
              filter: {}
          };

      // plugin constructor
      function Plugin ( element, options ) {
          this.element = element;
          this.settings = $.extend( {}, defaults, options );
          this._defaults = defaults;
          this._name = pluginName;
          this.init();
      }

      // Avoid Plugin.prototype conflicts
      $.extend( Plugin.prototype, {
          init: function() {
              return this
          },
          
          fetch_list: function (filter) {
              
              this.settings.filter = filter;
                  
              $.ajax({
                  type: "GET",
                  url: this.settings.api_base_url + 'v1/' +  this.settings.location_type,
                  success: this.onDataArrived.bind(this),
                  data: $.param(this.map_parameters())
              });
              

              
              
              

          }, // fetch list
          onDataArrived(data){
              var shtml = "";
              $(this.element).html(this.build_options(data));
          },

          map_parameters(){

              var mapped_parameter = {"filter": {
                  "where": {},
                  "order" : this.settings.order
                  }
              };

                for(var property in this.settings.filter)
                  mapped_parameter.filter.where[property] = this.settings.filter[property];

                return mapped_parameter;
          },

          build_options(params){
              var shtml = "";
              shtml += '<option disabled selected>-SELECT-</option>';
              for(var i=0; i<params.data.length;i++){
                  shtml += '<option value="' + params.data[i].id + '">';
                  shtml +=  params.data[i].name ;
                  shtml += '</option>';
              }

              return shtml
          }
          
      } );


      $.fn[ pluginName ] = function( options, args ) {
          return this.each( function() {
              var $plugin = $.data( this, "plugin_" + pluginName );
              if (!$plugin) {
                  var pluginOptions = (typeof options === 'object') ? options : {};
                  $plugin = $.data( this, "plugin_" + pluginName, new Plugin( this, pluginOptions ) );
              }
              
              if (typeof options === 'string') {
                  if (typeof $plugin[options] === 'function') {
                      if (typeof args !== 'object') args = [args];
                      $plugin[options].apply($plugin, args);
                  }
              }
          } );
      };

} )( jQuery, window, document );
</script>
<script type="text/javascript">
          
  var my_handlers = {

      // fill_provinces:  function(){

      //     var region_code = $(this).val();
      //     $('#province').ph_locations('fetch_list', [{"region_code": region_code}]);
          
      // },

      fill_cities: function(){

          var province_code = $(this).val();
          $('#city').ph_locations( 'fetch_list', [{"province_code": province_code}]);
      },


      fill_barangays: function(){

          var city_code = $(this).val();
          $('#barangay').ph_locations('fetch_list', [{"city_code": city_code}]);
      }
  };

  $(function(){
      // $('#region').on('change', my_handlers.fill_provinces);
      $('#province').on('change', my_handlers.fill_cities);
      $('#city').on('change', my_handlers.fill_barangays);

      // $('#region').ph_locations({'location_type': 'regions'});
      $('#province').ph_locations({'location_type': 'provinces'});
      $('#city').ph_locations({'location_type': 'cities'});
      $('#barangay').ph_locations({'location_type': 'barangays'});

      $('#province').ph_locations('fetch_list');
  });
</script>

<script>
  $(function(){

// whenever the province dropdown change, update the value of hidden field
$('#province').on('change', function(){

      // we are getting the text() here, not val()
      var selected_caption = $("#province option:selected").text();
      

    // // the hidden field will contain the name of the region, not the code
    //   $('input[name=province_name]').val(selected_caption);

}).ph_locations('fetch_list');

});

$(function(){

// whenever the city dropdown change, update the value of hidden field
$('#city').on('change', function(){

      // we are getting the text() here, not val()
      var selected_caption = $("#city option:selected").text();

    // // the hidden field will contain the name of the region, not the code
    //   $('input[name=municipality_name]').val(selected_caption);

}).ph_locations('fetch_list');

});

$(function(){

// whenever the city dropdown change, update the value of hidden field
$('#barangay').on('change', function(){

      // we are getting the text() here, not val()
      var selected_caption = $("#barangay option:selected").text();

    // // the hidden field will contain the name of the region, not the code
    //   $('input[name=barangay_name]').val(selected_caption);

}).ph_locations('fetch_list');

});
</script>

