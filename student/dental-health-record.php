<?php 
$page_title = "RECORDS";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid mx-2">

   

    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
            <h3 class="font-weight-bold text-dark">My Dental Health Record</h3>
            <table id="medical_health_record" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Medical Professional</th>
                        <th>Date Recorded</th>
                        <th>Expiry Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $selectDentalHealthRecords = mysqli_query($conn,"SELECT *, dentalhealthrecord.id AS den_record_id, stud.student_id_number AS stud_id_number, u2.firstName AS stud_first_name, u2.lastName AS stud_last_name, u2.middleName as stud_middle_name, stud.birthdate AS stud_dob, stud.age as stud_age,stud.sex AS stud_sex,stud.nationality AS stud_nationality,stud.religion AS stud_religion, stud.contact_number AS stud_contact_number, u2.email_address AS stud_email_address, stud.courseID AS stud_course, stud.year as stud_year, stud.section as stud_sec ,stud.province AS stud_province,stud.city_municipality as stud_city_municipality, stud.barangay as stud_barangay, u2.profile_img AS stud_avatar, u1.firstName AS med_first_name, u1.lastName AS med_last_name, u1.middleName as med_middle_name   FROM dentalhealthrecord INNER JOIN students AS stud ON dentalhealthrecord.student_id = stud.id INNER JOIN users AS u2 ON u2.id = stud.userID INNER JOIN dentalexam ON dentalexam.dhrIDnum = dentalhealthrecord.id INNER JOIN dentaltreatmentrecord ON dentaltreatmentrecord.dhrIDnum = dentalhealthrecord.id INNER JOIN medicalprofessional AS med_prof ON med_prof.id = dentalhealthrecord.medprofID INNER JOIN users AS u1 ON u1.id = med_prof.userID WHERE dentalhealthrecord.student_id = '$active_student_id' ORDER BY dentalhealthrecord.id DESC");
                    while($row = $selectDentalHealthRecords->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $row['med_first_name']." ".$row['med_last_name']; ?></td>
                            <td><?php echo date("M-d-Y",strtotime($row['date_created'])); ?></td>
                            <td><?php echo date("M-d-Y",strtotime($row['expiry_date']));?></td>
                            <td class="d-flex justify-content-around align-items-center">
                                <div data-toggle="tooltip" data-placement="bottom" title="View">
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewDenRecordModal<?php echo $row['den_record_id'];?>"><i class="fas fa-eye"></i></button>
                                </div>
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
                                                        <input  type="text" name="address" class="form-control" value="<?php echo $row['stud_province']." ".$row['stud_city_municipality'].", ".$row['barangay'] ?>" readonly required>
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
                                                <label>Caries Indicated for Extraction</label>
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