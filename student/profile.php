<?php 
$page_title = "PROFILE";
include_once("layouts/header-sidebar.php") ?>

<div class="container-fluid bootstrap snippet shadow" >
    <div class="row border" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('../images/nu-background.jpg'); background-position: center; background-repeat: no-repeat; background-size: cover;">
  		
    	<div class="col-sm-2"><img  class="img-circle img-responsive" src="../images/nulogo.png" width="100" height="100"></div>
        <div class="row d-flex justify-content-start align-items-center ">
        <h1 class="text-light font-weight-bold">NATIONAL UNIVERSITY FAIRVIEW</h1>
        </div>
    </div>
    <div class="row  mt-3 pb-3">
  		<div class="col-sm-4"><!--left col-->
              

      <div class="text-center">
        <?php if (empty($active_avatar)) {?>
            <img class="avatar border rounded-circle img-thumbnail" height="200" width="200" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png">
        <?php } else {?>
            <img class="avatar border rounded-circle img-thumbnail" height="200" width="200" src="../Controller/user_avatars/<?php echo $active_avatar ?>">
        <?php } ?>
        <h3 class="text-dark text-uppercase font-weight-bold"><?php echo $active_firstname." ".$active_lastname ?></h3>
      </div>

               
          <div class="panel panel-default">
            <div class="panel-heading text-center font-weight-bold"><h3></i><?php echo $active_student_id_number ?></h3></div>
            
          </div>

        
          
          
          <ul class="list-group">
            <li class="list-group-item text-muted"><h5>Account Settings</i></h5></li>
            <!-- <li class="list-group-item"><a class="link" id="edit_details" style="cursor: pointer;">Edit Account Details</a></li> -->
            <!-- <li class="list-group-item"><a class="link" style="cursor: pointer;">Change Avatar</a></li> -->
            <li class="list-group-item"><a class="link" style="cursor: pointer;" data-toggle="modal" data-target="#changeAvatarModal">Change Avatar</a></li>
            <li class="list-group-item"><a class="link" style="cursor: pointer;" data-toggle="modal" data-target="#changePasswordModal">Change Password</a></li>
            
          </ul> 
               
          
          
        </div><!--/col-3-->
    	<div class="col-sm-8 border p-2">
            <form action="../Controller/ProfileController.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $active_id; ?>">
                <input type="hidden" name="user_type_id" value="<?php echo $active_user_type_id; ?>">
            <div class="row">
                <div class="col">
                    <label>First Name</label>
                    <input type="text" id="first_name"  name="first_name" class="form-control" value="<?php echo $active_firstname ?>" readonly  required>
                </div>
                <div class="col">
                    <label>Middle Name</label>
                    <input type="text" id="middle_name"  name="middle_name" class="form-control" value="<?php echo $active_middlename ?>" readonly>
                </div>
                <div class="col">
                    <label>Last Name</label>
                    <input type="text" id="last_name"   name="last_name" class="form-control" value="<?php echo $active_lastname ?>" readonly required>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label>Birthdate</label>
                    <input type="date" id="birthdate" name="birthdate" class="form-control" value="<?php echo $active_birthdate ?>" readonly required>
                </div>
                <div class="col">
                    <label>Age</label>
                    <input type="number" id="age" name="age" class="form-control" value="<?php echo $active_age ?>" readonly required>
                </div>
                <div class="col">
                    <label>Sex</label>
                    <select id="sex" name="sex" class="form-control" disabled required>
                        <option <?php echo ($active_sex == "Male") ? 'selected' : '' ?> value="Male">Male</option>
                        <option <?php echo ($active_sex == "Female") ? 'selected' : '' ?> value="Female">Female</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label>Nationality</label>
                    <select id="nationality" name="nationality" class="form-control" disabled required>
                        <?php include_once("../Utilities/nationality-profile.php"); ?>
                    </select>
                </div>
                
                <div class="col">
                    <label>Religion</label>
                    <select id="religion" name="religion" class="form-control" disabled required>
                        <?php include_once("../Utilities/religion-profile.php"); ?>
                    </select>
                </div>
                <div class="col">
                    <label>Year</label>
                    <input id="year" type="text" name="year" class="form-control" value="<?php echo $active_year ?>" readonly required>
                </div>
                <div class="col">
                    <label>Section</label>
                    <input id="section" type="text" name="section" class="form-control" value="<?php echo $active_section ?>" readonly required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Contact Number</label>
                    <div class="d-flex align-items-center justify-content-between">
                        <label class="mr-1 mt-2">+63</label>
                        <input id="contact_number" type="number" name="contact_number" class="form-control" value="<?php $active_contact_number = substr($active_contact_number,3); echo $active_contact_number; ?>" readonly required minlength="10" placeholder="" title="+63 format and must be 10 digits" pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>
                </div>

                <div class="col">
                    <label>Email Address</label>
                    <input id="email_address" type="email" name="email_address" class="form-control" value="<?php echo $active_email_address ?>" disabled required> 
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label>Province</label>
                    <input id="address" type="text" name="address" class="form-control" value="<?php echo $active_province ?>" readonly required>
                </div>
                <div class="col">
                    <label>Municipality/City</label>
                    <input id="address" type="text" name="address" class="form-control" value="<?php echo $active_city_municipality ?>" readonly required>
                </div>
                <div class="col">
                    <label>Barangay</label>
                    <input id="address" type="text" name="address" class="form-control" value="<?php echo $active_barangay ?>" readonly required>
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
                    <label>Emergency Contact Number</label>
                    <div class="d-flex align-items-center justify-content-between">
                        <label class="mr-1 mt-2">+63</label>
                        <input id="contact_number" type="number" name="contact_number" class="form-control" value="<?php $active_emergency_contact_number = substr($active_emergency_contact_number,3); echo $active_contact_number; ?>" readonly required minlength="10" placeholder="" title="+63 format and must be 10 digits" pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Student ID Number</label>
                    <input id="active_student_id_number" type="text" name="active_student_id_number" class="form-control" value="<?php echo $active_student_id_number ?>" readonly required>
                </div>
                <div class="col">
                    <label>Course</label>
                    <input id="active_student_id_number" type="text" name="active_student_id_number" class="form-control"  readonly required value="<?php 
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

    
    <script src="../js/admin_enable_disbaled_inputs.js"></script>
    <script src="../js/password-show-hide.js"></script>

    
<?php include_once("layouts/footer.php") ?>