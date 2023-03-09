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
        <h3 class="text-dark text-uppercase font-weight-bold "><?php echo "Dr. ".$active_firstname." ".$active_lastname ?></h3>
      </div>

               
          <div class="panel panel-default">
            <div class="panel-heading text-center font-weight-bold"><h3><?php echo $active_specialization ?></h3></div>
            
          </div>

        
          
          
          <ul class="list-group">
            <li class="list-group-item text-muted"><h5>Account Settings</i></h5></li>
            <li class="list-group-item"><a class="link" style="cursor: pointer;" data-toggle="modal" data-target="#changeAvatarModal">Change Avatar</a></li>
            <li class="list-group-item"><a class="link" id="edit_details" style="cursor: pointer;">Edit Account Details</a></li>
            <!-- <li class="list-group-item"><a class="link" style="cursor: pointer;">Change Avatar</a></li> -->
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
                    
                    <label>Specialization</label>
                    <select id="specialization" name="specialization" class="form-control" disabled required>
                        <option <?php echo ($active_specialization == "Nurse") ? 'selected' : '';  ?> value="Nurse">Nurse</option>
                        <option <?php echo ($active_specialization == "Doctor") ? 'selected' : '';  ?> value="Doctor">Doctor</option>
                        <option <?php echo ($active_specialization == "Dentist") ? 'selected' : '';  ?> value="Dentist">Dentist</option>
                    </select>
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
                    <label>Address</label>
                    <input id="address" type="text" name="address" class="form-control" value="<?php echo $active_address ?>" readonly required>
                </div>
            </div>
            <div class="row d-flex justify-content-end align-items-center mt-4 pr-3">
                
                <a  class="btn btn-primary" id="cancel_update" hidden>Cancel</a>
                <button type="submit"  class="btn btn-primary ml-2" name="update_profile" id="update_profile" hidden>Save Changes</button>
                
            </div>
        </div><!--/col-9-->
        </form>
    </div><!--/row-->
    </div>
    <script src="../js/admin_enable_disbaled_inputs.js"></script>
    <script src="../js/password-show-hide.js"></script>

    
<?php include_once("layouts/footer.php") ?>