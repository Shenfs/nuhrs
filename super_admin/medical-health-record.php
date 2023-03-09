<?php 
$page_title = "RECORDS";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2">


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

