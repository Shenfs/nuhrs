<?php 
$page_title = "RECORDS";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2">
    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
            <h3 class="font-weight-bold text-dark">Dental Health Record</h3>
            <table id="dental_health_record" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Dental Health Record ID</th>
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
                    $selectDentalHealthRecords = mysqli_query($conn,"SELECT *, dentalhealthrecord.id AS den_record_id, stud.student_id_number AS stud_id_number, u2.firstName AS stud_first_name, u2.lastName AS stud_last_name, u2.middleName as stud_middle_name, stud.birthdate AS stud_dob, stud.age as stud_age,stud.sex AS stud_sex,stud.nationality AS stud_nationality,stud.religion AS stud_religion, stud.contact_number AS stud_contact_number, u2.email_address AS stud_email_address, stud.courseID AS stud_course, stud.year as stud_year, stud.section as stud_sec ,stud.province as stud_province,stud.city_municipality as stud_city_municipality, stud.barangay as stud_barangay, u2.profile_img AS stud_avatar   FROM dentalhealthrecord INNER JOIN students AS stud ON dentalhealthrecord.student_id = stud.id INNER JOIN users AS u2 ON u2.id = stud.userID INNER JOIN dentalexam ON dentalexam.dhrIDnum = dentalhealthrecord.id INNER JOIN dentaltreatmentrecord ON dentaltreatmentrecord.dhrIDnum = dentalhealthrecord.id ORDER BY dentalhealthrecord.id DESC");
                    while($row = $selectDentalHealthRecords->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $row['den_record_id']; ?></td>
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
                            <td><?php  echo $row['housenumber']." ".$row['streetname'].", ".$row['barangay']." ".$row['city_municipality'].", ".$row['province'] ?></td>
                            <td class="d-flex justify-content-around align-items-center">
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewDenRecordModal<?php echo $row['den_record_id'];?>"><i class="fas fa-eye"></i></button>
                                
                            </td>
                        </tr>
                        <!-- View Health Record Modal -->
                        <div class="modal fade" id="viewDenRecordModal<?php echo $row['den_record_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
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
                                                        <input  type="number" name="contact_number" class="form-control" value="<?php echo $row['stud_contact_number']; ?>" readonly required>
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
                                                        <label>Emergency Person Name</label>
                                                        <input type="text" name="emergency_person_name" class="form-control" value="<?php echo $row['emergency_person_name'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label >Relationship</label>
                                                        <input type="text" name="relationship" class="form-control" readonly value="<?php echo $row['emergency_relationship'] ?>" >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label >Emergency Address</label>
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

                                        <div class="row">
                                            <div class="col d-flex flex-column">
                                                <label>Tooth Description</label>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['toothdescription']); ?>" height="500" width="600">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center mt-2">
                                            <h3 class="text-center">Dental Examination</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label>Age of Last Birthday</label>
                                                <input type="number" name="agelastbirthday" class="form-control" value="<?php echo $row['agelastbirthday'] ?>" readonly>
                                            </div>
                                            <div class="col">
                                                <label>Presence of Calculus</label>
                                                <input type="text" name="calculuspresence" class="form-control" value="<?php echo $row['calculuspresence'] ?>" readonly>         
                                            </div>
                                            <div class="col">
                                                <label>Inflamation of Ginggiva</label>
                                                <input type="text" name="inflamedgingiva" class="form-control" value="<?php echo $row['inflamedgingiva'] ?>" readonly>          
                                            </div>
                                            <div class="col">
                                                <label>Presence of Periodontal Pocket</label>
                                                <input type="text" name="presenceofperiopockets" class="form-control" value="<?php echo $row['presenceofperiopockets'] ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label>Presence of Dento Facial Anomaly</label>
                                                <input type="text" name="presenceofanomalies" class="form-control" value="<?php echo $row['presenceofanomalies'] ?>" readonly>
                                            </div>
                                            <div class="col">
                                                <label>Number of Teeth Present</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_teethpresent" class="form-control" value="<?php echo $row['temporary_teethpresent'] ?>" readonly>      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_teethpresent" class="form-control" value="<?php echo $row['permanent_teethpresent'] ?>" readonly>      
                                                    </div>
                                                </div>  
                                            </div>
                                            <div class="col">
                                                <label>Caries of Teeth</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_cariesofteeth" class="form-control" value="<?php echo $row['temporary_cariesofteeth'] ?>" readonly>      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_cariesofteeth" class="form-control" value="<?php echo $row['permanent_cariesofteeth'] ?>" readonly>      
                                                    </div>
                                                </div>   
                                            </div>
                                            <div class="col">
                                                <label>Caries Indicated for Filling</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_cariesforfilling" class="form-control" value="<?php echo $row['temporary_cariesforfilling'] ?>" readonly>      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_cariesforfilling" class="form-control" value="<?php echo $row['permanent_cariesforfilling'] ?>" readonly>      
                                                    </div>
                                                </div>   
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label>Caries for Extraction</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_cariesforextraction" class="form-control" value="<?php echo $row['temporary_cariesforextraction'] ?>" readonly>      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_cariesforextraction" class="form-control" value="<?php echo $row['permanent_cariesforextraction'] ?>" readonly>      
                                                    </div>
                                                </div>  
                                            </div>
                                            <div class="col">
                                                <label>Root Fragment</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_rootfragments" class="form-control" value="<?php echo $row['temporary_rootfragments'] ?>" readonly>      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_rootfragments" class="form-control" value="<?php echo $row['permanent_rootfragments'] ?>" readonly>      
                                                    </div>
                                                </div>    
                                            </div>

                                            <div class="col">
                                                <label>Lost Due to Caries</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_lostduetocaries" class="form-control" value="<?php echo $row['temporary_lostduetocaries'] ?>" readonly>      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_lostduetocaries" class="form-control" value="<?php echo $row['permanent_lostduetocaries'] ?>" readonly>      
                                                    </div>
                                                </div>    
                                            </div>
                                            
                                            <div class="col">
                                                <label>Filled or Restored</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_restored" class="form-control" value="<?php echo $row['temporary_restored'] ?>" readonly>      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_restored" class="form-control" value="<?php echo $row['permanent_restored'] ?>" readonly>      
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="col">
                                            <label>Flouride Therapy</label>
                                            <input type="text" name="flouridetherapy" class="form-control mt-4" value="<?php echo $row['flouridetherapy'] ?>" readonly>    
                                        </div>
                                                            </div>
                                        <div class="row d-flex align-items-center justify-content-center mt-2">
                                            <h3 class="text-center">Dental Treatment</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label>Diagnosis</label>
                                                <textarea name="diagnosis" id="" cols="30" rows="10" cols="200" rows="5" class="form-control" style="resize: none;" required  readonly><?php echo
                                                 $row['diagnosis'] ?></textarea>
                                            </div>
                                            <div class="col">
                                                <label>Details of Service Rendered</label>
                                                <textarea name="detailsofservicesrendered" id="" cols="30" rows="10" cols="200" rows="5" class="form-control" style="resize: none;" required  readonly><?php echo $row['detailsofservicesrendered'] ?></textarea>
                                            </div>
                                            <div class="col">
                                                <label>Location of Teeth</label>
                                                <textarea name="locationofteeth" id="" cols="30" rows="10" cols="200" rows="5" class="form-control" style="resize: none;" required readonly><?php echo $row['locationofteeth'] ?></textarea>
                                            </div>
                                        </div>

                                        


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- View Health Record Modal -->

                        <!-- Edit Health Record Modal -->
                        <div class="modal fade" id="editDenRecordModal<?php echo $row['den_record_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-notes-medical mr-2"></i>Edit Dental Health Record</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                  
                                    <div class="modal-body">
                                    <form action="../Controller/DentalHealthRecordController.php" method="POST" enctype="multipart/form-data">
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
                                                        <input  type="number" name="contact_number" class="form-control" value="<?php echo $row['stud_contact_number']; ?>" readonly required>
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
                                                        <label>Emergency Person Name</label>
                                                        <input type="text" name="emergency_person_name" class="form-control" value="<?php echo $row['emergency_person_name'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label >Relationship</label>
                                                        <input type="text" name="relationship" class="form-control" readonly value="<?php echo $row['emergency_relationship'] ?>" >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label >Emergency Address</label>
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

                                        <div class="row">
                                            <input type="hidden" name="den_record_id" value="<?php echo $row['den_record_id'];?>">
                                            <div class="col d-flex flex-column">
                                                <label>Tooth Description</label>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['toothdescription']); ?>" height="500" width="600">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label>Tooth Description</label>
                                                <input type="file" name="image" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center mt-2">
                                            <h3 class="text-center">Dental Examination</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label>Age of Last Birthday</label>
                                                <input type="number" name="agelastbirthday" class="form-control" value="<?php echo $row['agelastbirthday'] ?>" >
                                            </div>
                                            <div class="col">
                                            <label>Presence of Calculus</label>
                                            <div class="d-flex align-items-center justify-content-around">
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="calculuspresence" value="Yes" required <?php echo ($row['calculuspresence'] == "Yes") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="">
                                                    Yes
                                                    </label>  
                                                </div>
                                                
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="calculuspresence" value="No" required <?php echo ($row['calculuspresence'] == "No") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="">
                                                    No
                                                    </label>  
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label>Inflamation of Ginggiva</label>
                                        
                                            <div class="d-flex align-items-center justify-content-around">
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="inflamedgingiva" value="Yes" required <?php echo ($row['inflamedgingiva'] == "Yes") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="">
                                                    Yes
                                                    </label>  
                                                </div>
                                                
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="inflamedgingiva" value="No" required <?php echo ($row['inflamedgingiva'] == "No") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="">
                                                    No
                                                    </label>  
                                                </div>  
                                            </div>       
                                        </div>
                                        <div class="col">
                                            <label>Presence of Periodontal Pocket</label>
                                        
                                            <div class="d-flex align-items-center justify-content-around">
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="presenceofperiopockets" value="Yes" required <?php echo ($row['presenceofperiopockets'] == "Yes") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="">
                                                    Yes
                                                    </label>  
                                                </div>
                                                
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="presenceofperiopockets" value="No" required <?php echo ($row['presenceofperiopockets'] == "No") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="">
                                                    No
                                                    </label>  
                                                </div>  
                                            </div> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label>Presence of Dento Facial Anomaly</label>
                                            

                                            <div class="d-flex align-items-center justify-content-around">
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="presenceofanomalies" value="Yes" required <?php echo ($row['presenceofanomalies'] == "Yes") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="">
                                                    Yes
                                                    </label>  
                                                </div>
                                                
                                                <div class="col">
                                                    <input class="form-check-input" type="radio" name="presenceofanomalies" value="No" required <?php echo ($row['presenceofanomalies'] == "No") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="">
                                                    No
                                                    </label>  
                                                </div>  
                                            </div> 
                                        </div>
                                        <div class="col">
                                                <label>Number of Teeth Present</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_teethpresent" class="form-control" value="<?php echo $row['temporary_teethpresent'] ?>" >      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_teethpresent" class="form-control" value="<?php echo $row['permanent_teethpresent'] ?>" >      
                                                    </div>
                                                </div>  
                                            </div>
                                            <div class="col">
                                                <label>Caries of Teeth</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_cariesofteeth" class="form-control" value="<?php echo $row['temporary_cariesofteeth'] ?>" >      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_cariesofteeth" class="form-control" value="<?php echo $row['permanent_cariesofteeth'] ?>" >      
                                                    </div>
                                                </div>   
                                            </div>
                                            <div class="col">
                                                <label>Caries Indicated for Filling</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_cariesforfilling" class="form-control" value="<?php echo $row['temporary_cariesforfilling'] ?>" >      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_cariesforfilling" class="form-control" value="<?php echo $row['permanent_cariesforfilling'] ?>" >      
                                                    </div>
                                                </div>   
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <label>Caries for Extraction</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_cariesforextraction" class="form-control" value="<?php echo $row['temporary_cariesforextraction'] ?>" >      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_cariesforextraction" class="form-control" value="<?php echo $row['permanent_cariesforextraction'] ?>" >      
                                                    </div>
                                                </div>  
                                            </div>
                                            <div class="col">
                                                <label>Root Fragment</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_rootfragments" class="form-control" value="<?php echo $row['temporary_rootfragments'] ?>" >      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_rootfragments" class="form-control" value="<?php echo $row['permanent_rootfragments'] ?>" >      
                                                    </div>
                                                </div>    
                                            </div>

                                            <div class="col">
                                                <label>Lost Due to Caries</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_lostduetocaries" class="form-control" value="<?php echo $row['temporary_lostduetocaries'] ?>" >      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_lostduetocaries" class="form-control" value="<?php echo $row['permanent_lostduetocaries'] ?>" >      
                                                    </div>
                                                </div>    
                                            </div>
                                            
                                            <div class="col">
                                                <label>Filled or Restored</label>
                                                <div class="row">
                                                    <div class="col">
                                                        Temporary
                                                    </div>
                                                    <div class="col">
                                                        Permanent
                                                    </div>
                                                </div>    
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="number" name="temporary_restored" class="form-control" value="<?php echo $row['temporary_restored'] ?>" >      
                                                    </div>
                                                    <div class="col">
                                                    <input type="number" name="permanent_restored" class="form-control" value="<?php echo $row['permanent_restored'] ?>" >      
                                                    </div>
                                                </div>    
                                            </div>

                                            <div class="col">
                                            <label>Flouride Therapy</label>
                                            <div class="d-flex align-items-center justify-content-around">
                                                <div class="col mt-4">
                                                    <input class="form-check-input" type="radio" name="flouridetherapy" value="Yes" required <?php echo ($row['flouridetherapy'] == "Yes") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="">
                                                    Yes
                                                    </label>  
                                                </div>
                                                
                                                <div class="col mt-4">
                                                    <input class="form-check-input" type="radio" name="flouridetherapy" value="No" required <?php echo ($row['flouridetherapy'] == "No") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="">
                                                    No
                                                    </label>  
                                                </div>  
                                            </div> 
                                        </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center mt-2">
                                            <h3 class="text-center">Dental Treatment</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label>Diagnosis</label>
                                                <textarea name="diagnosis" id="" cols="30" rows="10" cols="200" rows="5" class="form-control" style="resize: none;" required  ><?php echo
                                                 $row['diagnosis'] ?></textarea>
                                            </div>
                                            <div class="col">
                                                <label>Details of Service Rendered</label>
                                                <textarea name="detailsofservicesrendered" id="" cols="30" rows="10" cols="200" rows="5" class="form-control" style="resize: none;" required  ><?php echo $row['detailsofservicesrendered'] ?></textarea>
                                            </div>
                                            <div class="col">
                                                <label>Location of Teeth</label>
                                                <textarea name="locationofteeth" id="" cols="30" rows="10" cols="200" rows="5" class="form-control" style="resize: none;" required ><?php echo $row['locationofteeth'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="edit_record">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Health Record Modal -->
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
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-notes-medical mr-2"></i>Add Dental Health Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="../Controller/DentalHealthRecordController.php" method="POST" enctype="multipart/form-data">
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
                            <select class="form-control" aria-label="Default select example" id="student_ajax" name="student_id"  required >
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
                                        $('#student_ajax').append('<option disabled selected>Select Student</option>');
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

                        <script>
                        $("#student_ajax").change(function () {
                            var studentID = $(this).val();
                            if(studentID) {
                                console.log(studentID);

                                $.ajax({
                                    url: "getStudentAge.php",
                                    type: "POST",
                                    data:  "student_id=" + studentID ,
                                    success: function(data) {
                                        console.log(data);
                                        data = Number(data) - 1;
                                        $('#student_age').val(data);
                                    }
                                });


                            }else{
                                alert("failed");
                                console.log("Failed");
                                $('#student_age').empty();
                            }
                        });
                        </script>
                        
                        
                </div>
                <div class="row">
                    <div class="col">
                        <label>Tooth Description</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                </div>
                <div class="row d-flex align-items-center justify-content-center mt-2">
                    <h3 class="text-center">Dental Examination</h3>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Age of Last Birthday</label>
                        <input type="number" name="agelastbirthday" id="student_age" class="form-control" required>
                    </div>
                    <div class="col">
                        <label>Presence of Calculus</label>
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="col">
                                <input class="form-check-input" type="radio" name="calculuspresence" value="Yes" required>
                                <label class="form-check-label" for="">
                                Yes
                                </label>  
                            </div>
                            
                            <div class="col">
                                <input class="form-check-input" type="radio" name="calculuspresence" value="No" required>
                                <label class="form-check-label" for="">
                                No
                                </label>  
                            </div>  
                        </div>
                    </div>
                    <div class="col">
                        <label>Inflamation of Ginggiva</label>
                      
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="col">
                                <input class="form-check-input" type="radio" name="inflamedgingiva" value="Yes" required>
                                <label class="form-check-label" for="">
                                Yes
                                </label>  
                            </div>
                            
                            <div class="col">
                                <input class="form-check-input" type="radio" name="inflamedgingiva" value="No" required>
                                <label class="form-check-label" for="">
                                No
                                </label>  
                            </div>  
                        </div>       
                    </div>
                    <div class="col">
                        <label>Presence of Periodontal Pocket</label>
                       
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="col">
                                <input class="form-check-input" type="radio" name="presenceofperiopockets" value="Yes" required>
                                <label class="form-check-label" for="">
                                Yes
                                </label>  
                            </div>
                            
                            <div class="col">
                                <input class="form-check-input" type="radio" name="presenceofperiopockets" value="No" required>
                                <label class="form-check-label" for="">
                                No
                                </label>  
                            </div>  
                        </div> 
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Presence of Dento Facial Anomaly</label>
                        

                        <div class="d-flex align-items-center justify-content-around">
                            <div class="col">
                                <input class="form-check-input" type="radio" name="presenceofanomalies" value="Yes" required>
                                <label class="form-check-label" for="">
                                Yes
                                </label>  
                            </div>
                            
                            <div class="col">
                                <input class="form-check-input" type="radio" name="presenceofanomalies" value="No" required>
                                <label class="form-check-label" for="">
                                No
                                </label>  
                            </div>  
                        </div> 
                    </div>
                    <div class="col">
                        <label>Number of Teeth Present</label>
                        <div class="row">
                            <div class="col">
                                Temporary
                            </div>
                            <div class="col">
                                Permanent
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col">
                            <input type="number" name="temporary_teethpresent" class="form-control" required value="0" min="0">      
                            </div>
                            <div class="col">
                            <input type="number" name="permanent_teethpresent" class="form-control" required value="0" min="0">      
                            </div>
                        </div>  
                    </div>
                    <div class="col">
                        <label>Caries of Teeth</label>
                        <div class="row">
                            <div class="col">
                                Temporary
                            </div>
                            <div class="col">
                                Permanent
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col">
                            <input type="number" name="temporary_cariesofteeth" class="form-control" required value="0" min="0">      
                            </div>
                            <div class="col">
                            <input type="number" name="permanent_cariesofteeth" class="form-control" required value="0" min="0">      
                            </div>
                        </div>   
                    </div>
                    <div class="col">
                        <label>Caries Indicated for Filling</label>
                        <div class="row">
                            <div class="col">
                                Temporary
                            </div>
                            <div class="col">
                                Permanent
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col">
                            <input type="number" name="temporary_cariesforfilling" class="form-control" required value="0" min="0">      
                            </div>
                            <div class="col">
                            <input type="number" name="permanent_cariesforfilling" class="form-control" required value="0" min="0">      
                            </div>
                        </div>   
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Caries for Extraction</label>
                        <div class="row">
                            <div class="col">
                                Temporary
                            </div>
                            <div class="col">
                                Permanent
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col ">
                            <input type="number" name="temporary_cariesforextraction" class="form-control" required value="0" min="0">      
                            </div>
                            <div class="col">
                            <input type="number" name="permanent_cariesforextraction" class="form-control" required value="0" min="0">      
                            </div>
                        </div>  
                    </div>
                    <div class="col">
                        <label>Root Fragment</label>
                        <div class="row">
                            <div class="col">
                                Temporary
                            </div>
                            <div class="col">
                                Permanent
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col">
                            <input type="number" name="temporary_rootfragments" class="form-control" required value="0" min="0">      
                            </div>
                            <div class="col">
                            <input type="number" name="permanent_rootfragments" class="form-control" required value="0" min="0">      
                            </div>
                        </div>    
                    </div>

                    <div class="col">
                        <label>Lost Due to Caries</label>
                        <div class="row">
                            <div class="col">
                                Temporary
                            </div>
                            <div class="col">
                                Permanent
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col">
                            <input type="number" name="temporary_lostduetocaries" class="form-control" required value="0" min="0">      
                            </div>
                            <div class="col">
                            <input type="number" name="permanent_lostduetocaries" class="form-control" required value="0" min="0">      
                            </div>
                        </div>    
                    </div>
                    
                    <div class="col">
                        <label>Filled or Restored</label>
                        <div class="row">
                            <div class="col">
                                Temporary
                            </div>
                            <div class="col">
                                Permanent
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col">
                            <input type="number" name="temporary_restored" class="form-control" required value="0" min="0">      
                            </div>
                            <div class="col">
                            <input type="number" name="permanent_restored" class="form-control" required value="0" min="0">      
                            </div>
                        </div>    
                    </div>
                    <div class="col">
                        <label>Flouride Therapy</label>
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="col mt-4">
                                <input class="form-check-input" type="radio" name="flouridetherapy" value="Yes" required>
                                <label class="form-check-label" for="">
                                Yes
                                </label>  
                            </div>
                            
                            <div class="col mt-4">
                                <input class="form-check-input" type="radio" name="flouridetherapy" value="No" required>
                                <label class="form-check-label" for="">
                                No
                                </label>  
                            </div>  
                        </div> 
                    </div>
                </div>
                <div class="row d-flex align-items-center justify-content-center mt-2">
                    <h3 class="text-center">Dental Treatment</h3>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Diagnosis</label>
                        <textarea name="diagnosis" id="" cols="30" rows="10" cols="200" rows="5" class="form-control" style="resize: none;" required></textarea>
                    </div>
                    <div class="col">
                        <label>Details of Service Rendered</label>
                        <textarea name="detailsofservicesrendered" id="" cols="30" rows="10" cols="200" rows="5" class="form-control" style="resize: none;" required></textarea>
                    </div>
                    <div class="col">
                        <label>Location of Teeth</label>
                        <textarea name="locationofteeth" id="" cols="30" rows="10" cols="200" rows="5" class="form-control" style="resize: none;" required></textarea>
                    </div>
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="add_dental_health_record">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Health Record Modal -->
<!-- Modal -->



<script>
    $(function() {
        $("#dental_health_record").dataTable();
    });
</script>
<script src="../js/admin_enable_disbaled_inputs.js"></script>

<script src="../js/year_course.js"></script>


<?php include_once("layouts/footer.php") ?>