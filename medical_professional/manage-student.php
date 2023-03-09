<?php 
$page_title = "MANAGE STUDENTS";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">Add Student</button>
        </div>
    </div>
    <div class="row border border-rounded p-3 mt-3 shadow">
        <div class="col">
        <h3 class="font-weight-bold text-dark">Manage Student</h3>
            <table id="manage_students" class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-light">Student ID</th>
                        <th class="text-light">Name</th>
                        <th>Year</th>
                        <th>Program</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th class="text-light">Action</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Program</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $selectAllStudents = mysqli_query($conn,"SELECT *, students.id AS stud_id, users.id AS user_id FROM students INNER JOIN users ON students.userID = users.id");
                    while($row = $selectAllStudents->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $row['student_id_number'] ?></td>
                        <td><?php echo $row['firstName']." ".$row['lastName'] ?></td>
                        <td><?php echo $row['year']?></td>
                        <td>
                          <?php 
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
                      </td>
                      <td><?php echo $row['section'] ?></td>
                      <td>
                        <?php 
                        switch($row['status']){
                          case "Active": echo "<p class='border font-weight-bold rounded bg-success d-flex align-items-center justify-content-center text-light'>Active</p>"; break;
                          case "Inactive": echo "<p class='border font-weight-bold rounded bg-danger d-flex align-items-center justify-content-center text-light'>Inactive</p>"; break;
                        }
                        ?>
                      </td>
                      <td class="d-flex align-items-center justify-content-center gap-5">
                          <div data-toggle="tooltip" data-placement="bottom" title="View">
                            <button class="btn btn-sm btn-success mx-1" data-toggle="modal" data-target="#viewStudentModal<?php echo $row['stud_id']; ?>"><i class="fas fa-eye"></i></button>
                          </div>
                          <div data-toggle="tooltip" data-placement="bottom" title="Edit">
                            <button class="btn btn-sm btn-primary mx-1" data-toggle="modal" data-target="#editStudentModal<?php echo $row['stud_id']; ?>" ><i class="fas fa-edit"></i></button>
                          </div>
                      </td>
                      
                    </tr>
                    <!-- View Student Modal -->
                    <div class="modal fade" id="viewStudentModal<?php echo $row['stud_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">View Student</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <div class="col-sm-4"><!--left col-->
                                                

                                            <div class="text-center">
                                            <?php if (empty($row['profile_img'])) {?>
                                                <img class="avatar border rounded-circle img-thumbnail" height="200" width="200" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                            <?php } else {?>
                                                <img class="avatar border rounded-circle img-thumbnail" height="200" width="200" src="../Controller/user_avatars/<?php echo $row['profile_img'] ?>">
                                            <?php } ?>
                                                <h3 class="text-dark text-uppercase font-weight-bold "><?php echo $row['firstName']." ".$row['lastName']; ?></h3>
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
                                                        <input type="text"   name="first_name" class="form-control" value="<?php echo $row['firstName'] ?>" readonly  required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Middle Name</label>
                                                        <input type="text"   name="middle_name" class="form-control" value="<?php echo $row['middleName'] ?>" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>Last Name</label>
                                                        <input type="text"    name="last_name" class="form-control" value="<?php echo $row['lastName'] ?>" readonly required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Birthdate</label>
                                                        <input type="date"  name="birthdate" class="form-control" value="<?php echo $row['birthdate']; ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Age</label>
                                                        <input type="number"  name="age" class="form-control" value="<?php echo $row['age'] ?>" readonly required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Sex</label>
                                                        <select  name="sex" class="form-control" disabled required>
                                                            <option <?php echo ($row['sex'] == "Male") ? 'selected' : '' ?> value="Male">Male</option>
                                                            <option <?php echo ($row['sex'] == "Female") ? 'selected' : '' ?> value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Nationality</label>
                                                        <input type="text" value="<?php echo ucfirst($row['nationality']); ?>" class="form-control" readonly>
                                                    </div>
                                                    
                                                    <div class="col">
                                                        <label>Religion</label>
                                                        <input type="text" value="<?php echo $row['religion']; ?>" class="form-control" readonly>
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
                                                        <input  type="text" name="contact_number" class="form-control" value="<?php echo $row['contact_number']; ?>" readonly required>
                                                    </div>

                                                    <div class="col">
                                                        <label>Email Address</label>
                                                        <input  type="email" name="email_address" class="form-control" value="<?php echo $row['email_address'] ?>" disabled required> 
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
                                                    <div class="col">
                                                    <label>Status</label>
                                                    <input  type="text" name="status" class="form-control" value="<?php echo $row['status'] ?>" readonly required>
                                                    </div>
                                                </div>  
                                              </div><!--/col-9-->
                                            </form>
                                        </div><!--/row-->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- View Student Modal -->

                        <!-- Edit Student Modal -->
                        <div class="modal fade" id="editStudentModal<?php echo $row['stud_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="../Controller/ManageStudentController.php" method="POST">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <div class="col-sm-4"><!--left col-->
                                                

                                            <div class="text-center">
                                            <?php if (empty($row['profile_img'])) {?>
                                                <img class="avatar border rounded-circle img-thumbnail" height="200" width="200" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                            <?php } else {?>
                                                <img class="avatar border rounded-circle img-thumbnail" height="200" width="200" src="../Controller/user_avatars/<?php echo $row['profile_img'] ?>">
                                            <?php } ?>
                                                <h3 class="text-dark text-uppercase font-weight-bold "><?php echo $row['firstName']." ".$row['lastName']; ?></h3>
                                            </div>

                                                
                                            <div class="panel panel-default">
                                                <div class="panel-heading text-center font-weight-bold"><h3></i><?php echo $row['student_id_number'] ?></h3></div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row p-1">
                                            <div class="col border p-2">
                                                <input type="hidden" name="stud_id" value="<?php echo $row['stud_id'];?>">
                                                <input type="hidden" name="user_id" value="<?php echo $row['user_id'];?>">
                                                    
                                                <div class="row">
                                                    <div class="col">
                                                        <label>First Name</label>
                                                        <input type="text"   name="first_name" class="form-control names" value="<?php echo $row['firstName'] ?>"   required >
                                                    </div>
                                                    <div class="col">
                                                        <label>Middle Name</label>
                                                        <input type="text"   name="middle_name" class="form-control names" value="<?php echo $row['middleName'] ?>"  >
                                                    </div>
                                                    <div class="col">
                                                        <label>Last Name</label>
                                                        <input type="text"    name="last_name" class="form-control names" value="<?php echo $row['lastName'] ?>"  required >
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Birthdate</label>
                                                        <input type="date"  name="birthdate" class="form-control" value="<?php echo $row['birthdate']; ?>"  required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Age</label>
                                                        <input type="number"  name="age" class="form-control" value="<?php echo $row['age'] ?>"  required readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>Sex</label>
                                                        <select  name="sex" class="form-control" required>
                                                            <option <?php echo ($row['sex'] == "Male") ? 'selected' : '' ?> value="Male">Male</option>
                                                            <option <?php echo ($row['sex'] == "Female") ? 'selected' : '' ?> value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <label>Nationality</label>
                                                        <select name="nationality" required class="form-control">
                                                            <option value="afghan" <?php echo ($row['nationality'] == "afghan") ? 'selected' : ''  ?>>Afghan</option>
                                                            <option value="albanian" <?php echo ($row['nationality'] == "albanian") ? 'selected' : ''  ?>>Albanian</option>
                                                            <option value="algerian" <?php echo ($row['nationality'] == "algerian") ? 'selected' : ''  ?>>Algerian</option>
                                                            <option value="american" <?php echo ($row['nationality'] == "american") ? 'selected' : ''  ?>>American</option>
                                                            <option value="andorran" <?php echo ($row['nationality'] == "andorran") ? 'selected' : ''  ?>>Andorran</option>
                                                            <option value="angolan" <?php echo ($row['nationality'] == "angolan") ? 'selected' : ''  ?>>Angolan</option>
                                                            <option value="antiguans" <?php echo ($row['nationality'] == "antiguans") ? 'selected' : ''  ?>>Antiguans</option>
                                                            <option value="argentinean" <?php echo ($row['nationality'] == "argentinean") ? 'selected' : ''  ?>>Argentinean</option>
                                                            <option value="armenian" <?php echo ($row['nationality'] == "armenian") ? 'selected' : ''  ?>>Armenian</option>
                                                            <option value="australian" <?php echo ($row['nationality'] == "australian") ? 'selected' : ''  ?>>Australian</option>
                                                            <option value="austrian" <?php echo ($row['nationality'] == "austrian") ? 'selected' : ''  ?>>Austrian</option>
                                                            <option value="azerbaijani" <?php echo ($row['nationality'] == "azerbaijani") ? 'selected' : ''  ?>>Azerbaijani</option>
                                                            <option value="bahamian" <?php echo ($row['nationality'] == "bahamian") ? 'selected' : ''  ?>>Bahamian</option>
                                                            <option value="bahraini" <?php echo ($row['nationality'] == "bahraini") ? 'selected' : ''  ?>>Bahraini</option>
                                                            <option value="bangladeshi" <?php echo ($row['nationality'] == "bangladeshi") ? 'selected' : ''  ?>>Bangladeshi</option>
                                                            <option value="barbadian" <?php echo ($row['nationality'] == "barbadian") ? 'selected' : ''  ?>>Barbadian</option>
                                                            <option value="barbudans" <?php echo ($row['nationality'] == "barbudans") ? 'selected' : ''  ?>>Barbudans</option>
                                                            <option value="batswana" <?php echo ($row['nationality'] == "batswana") ? 'selected' : ''  ?>>Batswana</option>
                                                            <option value="belarusian" <?php echo ($row['nationality'] == "belarusian") ? 'selected' : ''  ?>>Belarusian</option>
                                                            <option value="belgian" <?php echo ($row['nationality'] == "belgian") ? 'selected' : ''  ?>>Belgian</option>
                                                            <option value="belizean" <?php echo ($row['nationality'] == "belizean") ? 'selected' : ''  ?>>Belizean</option>
                                                            <option value="beninese" <?php echo ($row['nationality'] == "beninese") ? 'selected' : ''  ?>>Beninese</option>
                                                            <option value="bhutanese" <?php echo ($row['nationality'] == "bhutanese") ? 'selected' : ''  ?>>Bhutanese</option>
                                                            <option value="bolivian" <?php echo ($row['nationality'] == "bolivian") ? 'selected' : ''  ?>>Bolivian</option>
                                                            <option value="bosnian" <?php echo ($row['nationality'] == "bosnian") ? 'selected' : ''  ?>>Bosnian</option>
                                                            <option value="brazilian" <?php echo ($row['nationality'] == "brazilian") ? 'selected' : ''  ?>>Brazilian</option>
                                                            <option value="british" <?php echo ($row['nationality'] == "british") ? 'selected' : ''  ?>>British</option>
                                                            <option value="bruneian" <?php echo ($row['nationality'] == "bruneian") ? 'selected' : ''  ?>>Bruneian</option>
                                                            <option value="bulgarian" <?php echo ($row['nationality'] == "bulgarian") ? 'selected' : ''  ?>>Bulgarian</option>
                                                            <option value="burkinabe" <?php echo ($row['nationality'] == "burkinabe") ? 'selected' : ''  ?>>Burkinabe</option>
                                                            <option value="burmese" <?php echo ($row['nationality'] == "burmese") ? 'selected' : ''  ?>>Burmese</option>
                                                            <option value="burundian" <?php echo ($row['nationality'] == "burundian") ? 'selected' : ''  ?>>Burundian</option>
                                                            <option value="cambodian" <?php echo ($row['nationality'] == "cambodian") ? 'selected' : ''  ?>>Cambodian</option>
                                                            <option value="cameroonian" <?php echo ($row['nationality'] == "cameroonian") ? 'selected' : ''  ?>>Cameroonian</option>
                                                            <option value="canadian" <?php echo ($row['nationality'] == "canadian") ? 'selected' : ''  ?>>Canadian</option>
                                                            <option value="cape verdean" <?php echo ($row['nationality'] == "cape verdean") ? 'selected' : ''  ?>>Cape Verdean</option>
                                                            <option value="central african" <?php echo ($row['nationality'] == "central african") ? 'selected' : ''  ?>>Central African</option>
                                                            <option value="chadian" <?php echo ($row['nationality'] == "chadian") ? 'selected' : ''  ?>>Chadian</option>
                                                            <option value="chilean" <?php echo ($row['nationality'] == "chilean") ? 'selected' : ''  ?>>Chilean</option>
                                                            <option value="chinese" <?php echo ($row['nationality'] == "chinese") ? 'selected' : ''  ?>>Chinese</option>
                                                            <option value="colombian" <?php echo ($row['nationality'] == "colombian") ? 'selected' : ''  ?>>Colombian</option>
                                                            <option value="comoran" <?php echo ($row['nationality'] == "comoran") ? 'selected' : ''  ?>>Comoran</option>
                                                            <option value="congolese" <?php echo ($row['nationality'] == "congolese") ? 'selected' : ''  ?>>Congolese</option>
                                                            <option value="costa rican" <?php echo ($row['nationality'] == "costa rican") ? 'selected' : ''  ?>>Costa Rican</option>
                                                            <option value="croatian" <?php echo ($row['nationality'] == "croatian") ? 'selected' : ''  ?>>Croatian</option>
                                                            <option value="cuban" <?php echo ($row['nationality'] == "cuban") ? 'selected' : ''  ?>>Cuban</option>
                                                            <option value="cypriot" <?php echo ($row['nationality'] == "cypriot") ? 'selected' : ''  ?>>Cypriot</option>
                                                            <option value="czech" <?php echo ($row['nationality'] == "czech") ? 'selected' : ''  ?>>Czech</option>
                                                            <option value="danish" <?php echo ($row['nationality'] == "danish") ? 'selected' : ''  ?>>Danish</option>
                                                            <option value="djibouti" <?php echo ($row['nationality'] == "djibouti") ? 'selected' : ''  ?>>Djibouti</option>
                                                            <option value="dominican" <?php echo ($row['nationality'] == "dominican") ? 'selected' : ''  ?>>Dominican</option>
                                                            <option value="dutch" <?php echo ($row['nationality'] == "dutch") ? 'selected' : ''  ?>>Dutch</option>
                                                            <option value="east timorese" <?php echo ($row['nationality'] == "east timorese") ? 'selected' : ''  ?>>East Timorese</option>
                                                            <option value="ecuadorean" <?php echo ($row['nationality'] == "ecuadorean") ? 'selected' : ''  ?>>Ecuadorean</option>
                                                            <option value="egyptian" <?php echo ($row['nationality'] == "egyptian") ? 'selected' : ''  ?>>Egyptian</option>
                                                            <option value="emirian" <?php echo ($row['nationality'] == "emirian") ? 'selected' : ''  ?>>Emirian</option>
                                                            <option value="equatorial guinean" <?php echo ($row['nationality'] == "equatorial guinean") ? 'selected' : ''  ?>>Equatorial Guinean</option>
                                                            <option value="eritrean" <?php echo ($row['nationality'] == "eritrean") ? 'selected' : ''  ?>>Eritrean</option>
                                                            <option value="estonian" <?php echo ($row['nationality'] == "estonian") ? 'selected' : ''  ?>>Estonian</option>
                                                            <option value="ethiopian" <?php echo ($row['nationality'] == "ethiopian") ? 'selected' : ''  ?>>Ethiopian</option>
                                                            <option value="fijian" <?php echo ($row['nationality'] == "fijian") ? 'selected' : ''  ?>>Fijian</option>
                                                            <option value="filipino" <?php echo ($row['nationality'] == "filipino") ? 'selected' : ''  ?>>Filipino</option>
                                                            <option value="finnish" <?php echo ($row['nationality'] == "finnish") ? 'selected' : ''  ?>>Finnish</option>
                                                            <option value="french" <?php echo ($row['nationality'] == "french") ? 'selected' : ''  ?>>French</option>
                                                            <option value="gabonese" <?php echo ($row['nationality'] == "gabonese") ? 'selected' : ''  ?>>Gabonese</option>
                                                            <option value="gambian" <?php echo ($row['nationality'] == "gambian") ? 'selected' : ''  ?>>Gambian</option>
                                                            <option value="georgian" <?php echo ($row['nationality'] == "georgian") ? 'selected' : ''  ?>>Georgian</option>
                                                            <option value="german" <?php echo ($row['nationality'] == "german") ? 'selected' : ''  ?>>German</option>
                                                            <option value="ghanaian" <?php echo ($row['nationality'] == "ghanaian") ? 'selected' : ''  ?>>Ghanaian</option>
                                                            <option value="greek" <?php echo ($row['nationality'] == "greek") ? 'selected' : ''  ?>>Greek</option>
                                                            <option value="grenadian" <?php echo ($row['nationality'] == "grenadian") ? 'selected' : ''  ?>>Grenadian</option>
                                                            <option value="guatemalan" <?php echo ($row['nationality'] == "guatemalan") ? 'selected' : ''  ?>>Guatemalan</option>
                                                            <option value="guinea-bissauan" <?php echo ($row['nationality'] == "guinea-bissauan") ? 'selected' : ''  ?>>Guinea-Bissauan</option>
                                                            <option value="guinean" <?php echo ($row['nationality'] == "guinean") ? 'selected' : ''  ?>>Guinean</option>
                                                            <option value="guyanese" <?php echo ($row['nationality'] == "guyanese") ? 'selected' : ''  ?>>Guyanese</option>
                                                            <option value="haitian" <?php echo ($row['nationality'] == "haitian") ? 'selected' : ''  ?>>Haitian</option>
                                                            <option value="herzegovinian" <?php echo ($row['nationality'] == "herzegovinian") ? 'selected' : ''  ?>>Herzegovinian</option>
                                                            <option value="honduran" <?php echo ($row['nationality'] == "honduran") ? 'selected' : ''  ?>>Honduran</option>
                                                            <option value="hungarian" <?php echo ($row['nationality'] == "hungarian") ? 'selected' : ''  ?>>Hungarian</option>
                                                            <option value="icelander" <?php echo ($row['nationality'] == "icelander") ? 'selected' : ''  ?>>Icelander</option>
                                                            <option value="indian" <?php echo ($row['nationality'] == "indian") ? 'selected' : ''  ?>>Indian</option>
                                                            <option value="indonesian" <?php echo ($row['nationality'] == "indonesian") ? 'selected' : ''  ?>>Indonesian</option>
                                                            <option value="iranian" <?php echo ($row['nationality'] == "iranian") ? 'selected' : ''  ?>>Iranian</option>
                                                            <option value="iraqi" <?php echo ($row['nationality'] == "iraqi") ? 'selected' : ''  ?>>Iraqi</option>
                                                            <option value="irish" <?php echo ($row['nationality'] == "irish") ? 'selected' : ''  ?>>Irish</option>
                                                            <option value="israeli" <?php echo ($row['nationality'] == "israeli") ? 'selected' : ''  ?>>Israeli</option>
                                                            <option value="italian" <?php echo ($row['nationality'] == "italian") ? 'selected' : ''  ?>>Italian</option>
                                                            <option value="ivorian" <?php echo ($row['nationality'] == "ivorian") ? 'selected' : ''  ?>>Ivorian</option>
                                                            <option value="jamaican" <?php echo ($row['nationality'] == "jamaican") ? 'selected' : ''  ?>>Jamaican</option>
                                                            <option value="japanese" <?php echo ($row['nationality'] == "japanese") ? 'selected' : ''  ?>>Japanese</option>
                                                            <option value="jordanian" <?php echo ($row['nationality'] == "jordanian") ? 'selected' : ''  ?>>Jordanian</option>
                                                            <option value="kazakhstani" <?php echo ($row['nationality'] == "kazakhstani") ? 'selected' : ''  ?>>Kazakhstani</option>
                                                            <option value="kenyan" <?php echo ($row['nationality'] == "kenyan") ? 'selected' : ''  ?>>Kenyan</option>
                                                            <option value="kittian and nevisian" <?php echo ($row['nationality'] == "kittian and nevisian") ? 'selected' : ''  ?>>Kittian and Nevisian</option>
                                                            <option value="kuwaiti" <?php echo ($row['nationality'] == "kuwaiti") ? 'selected' : ''  ?>>Kuwaiti</option>
                                                            <option value="kyrgyz" <?php echo ($row['nationality'] == "kyrgyz") ? 'selected' : ''  ?>>Kyrgyz</option>
                                                            <option value="laotian" <?php echo ($row['nationality'] == "laotian") ? 'selected' : ''  ?>>Laotian</option>
                                                            <option value="latvian" <?php echo ($row['nationality'] == "latvian") ? 'selected' : ''  ?>>Latvian</option>
                                                            <option value="lebanese" <?php echo ($row['nationality'] == "lebanese") ? 'selected' : ''  ?>>Lebanese</option>
                                                            <option value="liberian" <?php echo ($row['nationality'] == "liberian") ? 'selected' : ''  ?>>Liberian</option>
                                                            <option value="libyan" <?php echo ($row['nationality'] == "libyan") ? 'selected' : ''  ?>>Libyan</option>
                                                            <option value="liechtensteiner" <?php echo ($row['nationality'] == "liechtensteiner") ? 'selected' : ''  ?>>Liechtensteiner</option>
                                                            <option value="lithuanian" <?php echo ($row['nationality'] == "lithuanian") ? 'selected' : ''  ?>>Lithuanian</option>
                                                            <option value="luxembourger" <?php echo ($row['nationality'] == "luxembourger") ? 'selected' : ''  ?>>Luxembourger</option>
                                                            <option value="macedonian" <?php echo ($row['nationality'] == "macedonian") ? 'selected' : ''  ?>>Macedonian</option>
                                                            <option value="malagasy" <?php echo ($row['nationality'] == "malagasy") ? 'selected' : ''  ?>>Malagasy</option>
                                                            <option value="malawian" <?php echo ($row['nationality'] == "malawian") ? 'selected' : ''  ?>>Malawian</option>
                                                            <option value="malaysian" <?php echo ($row['nationality'] == "malaysian") ? 'selected' : ''  ?>>Malaysian</option>
                                                            <option value="maldivan" <?php echo ($row['nationality'] == "maldivan") ? 'selected' : ''  ?>>Maldivan</option>
                                                            <option value="malian" <?php echo ($row['nationality'] == "malian") ? 'selected' : ''  ?>>Malian</option>
                                                            <option value="maltese" <?php echo ($row['nationality'] == "maltese") ? 'selected' : ''  ?>>Maltese</option>
                                                            <option value="marshallese" <?php echo ($row['nationality'] == "marshallese") ? 'selected' : ''  ?>>Marshallese</option>
                                                            <option value="mauritanian" <?php echo ($row['nationality'] == "mauritanian") ? 'selected' : ''  ?>>Mauritanian</option>
                                                            <option value="mauritian" <?php echo ($row['nationality'] == "mauritian") ? 'selected' : ''  ?>>Mauritian</option>
                                                            <option value="mexican" <?php echo ($row['nationality'] == "mexican") ? 'selected' : ''  ?>>Mexican</option>
                                                            <option value="micronesian" <?php echo ($row['nationality'] == "micronesian") ? 'selected' : ''  ?>>Micronesian</option>
                                                            <option value="moldovan" <?php echo ($row['nationality'] == "moldovan") ? 'selected' : ''  ?>>Moldovan</option>
                                                            <option value="monacan" <?php echo ($row['nationality'] == "monacan") ? 'selected' : ''  ?>>Monacan</option>
                                                            <option value="mongolian" <?php echo ($row['nationality'] == "mongolian") ? 'selected' : ''  ?>>Mongolian</option>
                                                            <option value="moroccan" <?php echo ($row['nationality'] == "moroccan") ? 'selected' : ''  ?>>Moroccan</option>
                                                            <option value="mosotho" <?php echo ($row['nationality'] == "mosotho") ? 'selected' : ''  ?>>Mosotho</option>
                                                            <option value="motswana" <?php echo ($row['nationality'] == "motswana") ? 'selected' : ''  ?>>Motswana</option>
                                                            <option value="mozambican" <?php echo ($row['nationality'] == "mozambican") ? 'selected' : ''  ?>>Mozambican</option>
                                                            <option value="namibian" <?php echo ($row['nationality'] == "namibian") ? 'selected' : ''  ?>>Namibian</option>
                                                            <option value="nauruan" <?php echo ($row['nationality'] == "nauruan") ? 'selected' : ''  ?>>Nauruan</option>
                                                            <option value="nepalese" <?php echo ($row['nationality'] == "nepalese") ? 'selected' : ''  ?>>Nepalese</option>
                                                            <option value="new zealander" <?php echo ($row['nationality'] == "new zealander") ? 'selected' : ''  ?>>New Zealander</option>
                                                            <option value="ni-vanuatu" <?php echo ($row['nationality'] == "ni-vanuatu") ? 'selected' : ''  ?>>Ni-Vanuatu</option>
                                                            <option value="nicaraguan" <?php echo ($row['nationality'] == "nicaraguan") ? 'selected' : ''  ?>>Nicaraguan</option>
                                                            <option value="nigerien" <?php echo ($row['nationality'] == "nigerien") ? 'selected' : ''  ?>>Nigerien</option>
                                                            <option value="north korean" <?php echo ($row['nationality'] == "north korean") ? 'selected' : ''  ?>>North Korean</option>
                                                            <option value="northern irish" <?php echo ($row['nationality'] == "northern irish") ? 'selected' : ''  ?>>Northern Irish</option>
                                                            <option value="norwegian" <?php echo ($row['nationality'] == "norwegian") ? 'selected' : ''  ?>>Norwegian</option>
                                                            <option value="omani" <?php echo ($row['nationality'] == "omani") ? 'selected' : ''  ?>>Omani</option>
                                                            <option value="pakistani" <?php echo ($row['nationality'] == "pakistani") ? 'selected' : ''  ?>>Pakistani</option>
                                                            <option value="palauan" <?php echo ($row['nationality'] == "palauan") ? 'selected' : ''  ?>>Palauan</option>
                                                            <option value="panamanian" <?php echo ($row['nationality'] == "panamanian") ? 'selected' : ''  ?>>Panamanian</option>
                                                            <option value="papua new guinean" <?php echo ($row['nationality'] == "papua new guinean") ? 'selected' : ''  ?>>Papua New Guinean</option>
                                                            <option value="paraguayan" <?php echo ($row['nationality'] == "paraguayan") ? 'selected' : ''  ?>>Paraguayan</option>
                                                            <option value="peruvian" <?php echo ($row['nationality'] == "peruvian") ? 'selected' : ''  ?>>Peruvian</option>
                                                            <option value="polish" <?php echo ($row['nationality'] == "polish") ? 'selected' : ''  ?>>Polish</option>
                                                            <option value="portuguese" <?php echo ($row['nationality'] == "portuguese") ? 'selected' : ''  ?>>Portuguese</option>
                                                            <option value="qatari" <?php echo ($row['nationality'] == "qatari") ? 'selected' : ''  ?>>Qatari</option>
                                                            <option value="romanian" <?php echo ($row['nationality'] == "romanian") ? 'selected' : ''  ?>>Romanian</option>
                                                            <option value="russian" <?php echo ($row['nationality'] == "russian") ? 'selected' : ''  ?>>Russian</option>
                                                            <option value="rwandan" <?php echo ($row['nationality'] == "rwandan") ? 'selected' : ''  ?>>Rwandan</option>
                                                            <option value="saint lucian" <?php echo ($row['nationality'] == "saint lucian") ? 'selected' : ''  ?>>Saint Lucian</option>
                                                            <option value="salvadoran" <?php echo ($row['nationality'] == "salvadoran") ? 'selected' : ''  ?>>Salvadoran</option>
                                                            <option value="samoan" <?php echo ($row['nationality'] == "samoan") ? 'selected' : ''  ?>>Samoan</option>
                                                            <option value="san marinese" <?php echo ($row['nationality'] == "san marinese") ? 'selected' : ''  ?>>San Marinese</option>
                                                            <option value="sao tomean" <?php echo ($row['nationality'] == "sao tomean") ? 'selected' : ''  ?>>Sao Tomean</option>
                                                            <option value="saudi" <?php echo ($row['nationality'] == "saudi") ? 'selected' : ''  ?>>Saudi</option>
                                                            <option value="scottish" <?php echo ($row['nationality'] == "scottish") ? 'selected' : ''  ?>>Scottish</option>
                                                            <option value="senegalese" <?php echo ($row['nationality'] == "senegalese") ? 'selected' : ''  ?>>Senegalese</option>
                                                            <option value="serbian" <?php echo ($row['nationality'] == "serbian") ? 'selected' : ''  ?>>Serbian</option>
                                                            <option value="seychellois" <?php echo ($row['nationality'] == "seychellois") ? 'selected' : ''  ?>>Seychellois</option>
                                                            <option value="sierra leonean" <?php echo ($row['nationality'] == "sierra leonean") ? 'selected' : ''  ?>>Sierra Leonean</option>
                                                            <option value="singaporean" <?php echo ($row['nationality'] == "singaporean") ? 'selected' : ''  ?>>Singaporean</option>
                                                            <option value="slovakian" <?php echo ($row['nationality'] == "slovakian") ? 'selected' : ''  ?>>Slovakian</option>
                                                            <option value="slovenian" <?php echo ($row['nationality'] == "slovenian") ? 'selected' : ''  ?>>Slovenian</option>
                                                            <option value="solomon islander" <?php echo ($row['nationality'] == "solomon islander") ? 'selected' : ''  ?>>Solomon Islander</option>
                                                            <option value="somali" <?php echo ($row['nationality'] == "somali") ? 'selected' : ''  ?>>Somali</option>
                                                            <option value="south african" <?php echo ($row['nationality'] == "south african") ? 'selected' : ''  ?>>South African</option>
                                                            <option value="south korean" <?php echo ($row['nationality'] == "south korean") ? 'selected' : ''  ?>>South Korean</option>
                                                            <option value="spanish" <?php echo ($row['nationality'] == "spanish") ? 'selected' : ''  ?>>Spanish</option>
                                                            <option value="sri lankan" <?php echo ($row['nationality'] == "sri lankan") ? 'selected' : ''  ?>>Sri Lankan</option>
                                                            <option value="sudanese" <?php echo ($row['nationality'] == "sudanese") ? 'selected' : ''  ?>>Sudanese</option>
                                                            <option value="surinamer" <?php echo ($row['nationality'] == "surinamer") ? 'selected' : ''  ?>>Surinamer</option>
                                                            <option value="swazi" <?php echo ($row['nationality'] == "swazi") ? 'selected' : ''  ?>>Swazi</option>
                                                            <option value="swedish" <?php echo ($row['nationality'] == "swedish") ? 'selected' : ''  ?>>Swedish</option>
                                                            <option value="swiss" <?php echo ($row['nationality'] == "swiss") ? 'selected' : ''  ?>>Swiss</option>
                                                            <option value="syrian" <?php echo ($row['nationality'] == "syrian") ? 'selected' : ''  ?>>Syrian</option>
                                                            <option value="taiwanese" <?php echo ($row['nationality'] == "taiwanese") ? 'selected' : ''  ?>>Taiwanese</option>
                                                            <option value="tajik" <?php echo ($row['nationality'] == "tajik") ? 'selected' : ''  ?>>Tajik</option>
                                                            <option value="tanzanian" <?php echo ($row['nationality'] == "tanzanian") ? 'selected' : ''  ?>>Tanzanian</option>
                                                            <option value="thai" <?php echo ($row['nationality'] == "thai") ? 'selected' : ''  ?>>Thai</option>
                                                            <option value="togolese" <?php echo ($row['nationality'] == "togolese") ? 'selected' : ''  ?>>Togolese</option>
                                                            <option value="tongan" <?php echo ($row['nationality'] == "tongan") ? 'selected' : ''  ?>>Tongan</option>
                                                            <option value="trinidadian or tobagonian" <?php echo ($row['nationality'] == "trinidadian or tobagonian") ? 'selected' : ''  ?>>Trinidadian or Tobagonian</option>
                                                            <option value="tunisian" <?php echo ($row['nationality'] == "tunisian") ? 'selected' : ''  ?>>Tunisian</option>
                                                            <option value="turkish" <?php echo ($row['nationality'] == "turkish") ? 'selected' : ''  ?>>Turkish</option>
                                                            <option value="tuvaluan" <?php echo ($row['nationality'] == "tuvaluan") ? 'selected' : ''  ?>>Tuvaluan</option>
                                                            <option value="ugandan" <?php echo ($row['nationality'] == "ugandan") ? 'selected' : ''  ?>>Ugandan</option>
                                                            <option value="ukrainian" <?php echo ($row['nationality'] == "ukrainian") ? 'selected' : ''  ?>>Ukrainian</option>
                                                            <option value="uruguayan" <?php echo ($row['nationality'] == "uruguayan") ? 'selected' : ''  ?>>Uruguayan</option>
                                                            <option value="uzbekistani" <?php echo ($row['nationality'] == "uzbekistani") ? 'selected' : ''  ?>>Uzbekistani</option>
                                                            <option value="venezuelan" <?php echo ($row['nationality'] == "venezuelan") ? 'selected' : ''  ?>>Venezuelan</option>
                                                            <option value="vietnamese" <?php echo ($row['nationality'] == "vietnamese") ? 'selected' : ''  ?>>Vietnamese</option>
                                                            <option value="welsh" <?php echo ($row['nationality'] == "welsh") ? 'selected' : ''  ?>>Welsh</option>
                                                            <option value="yemenite" <?php echo ($row['nationality'] == "yemenite") ? 'selected' : ''  ?>>Yemenite</option>
                                                            <option value="zambian" <?php echo ($row['nationality'] == "zambian") ? 'selected' : ''  ?>>Zambian</option>
                                                            <option value="zimbabwean" <?php echo ($row['nationality'] == "zimbabwean") ? 'selected' : ''  ?>>Zimbabwean</option>
                                                        </select>
                                                        
                                                    </div>
                                                    
                                                    <div class="col">
                                                        <label>Religion</label>
                                                        <select name="religion" required class="form-control">
                                                          <option <?php echo ($row['religion'] == "African Traditional") ? 'selected' : '' ?> value="African Traditional &amp; Diasporic">African Traditional &amp; Diasporic</option>
                                                          <option <?php echo ($row['religion'] == "Agnostic") ? 'selected' : '' ?> value="Agnostic">Agnostic</option>
                                                          <option <?php echo ($row['religion'] == "Atheist") ? 'selected' : '' ?> value="Atheist">Atheist</option>
                                                          <option <?php echo ($row['religion'] == "Baha'i") ? 'selected' : '' ?> value="Baha'i">Baha'i</option>
                                                          <option <?php echo ($row['religion'] == "Buddhism") ? 'selected' : '' ?> value="Buddhism">Buddhism</option>
                                                          <option <?php echo ($row['religion'] == "Cao Dai") ? 'selected' : '' ?> value="Cao Dai">Cao Dai</option>
                                                          <option <?php echo ($row['religion'] == "Chinese traditional religion") ? 'selected' : '' ?> value="Chinese traditional religion">Chinese traditional religion</option>
                                                          <option <?php echo ($row['religion'] == "Christianity") ? 'selected' : '' ?> value="Christianity">Christianity</option>
                                                          <option <?php echo ($row['religion'] == "Hinduism") ? 'selected' : '' ?> value="Hinduism">Hinduism</option>
                                                          <option <?php echo ($row['religion'] == "Islam") ? 'selected' : '' ?> value="Islam">Islam</option>
                                                          <option <?php echo ($row['religion'] == "Jainism") ? 'selected' : '' ?> value="Jainism">Jainism</option>
                                                          <option <?php echo ($row['religion'] == "Juche") ? 'selected' : '' ?> value="Juche">Juche</option>
                                                          <option <?php echo ($row['religion'] == "Judaism") ? 'selected' : '' ?> value="Judaism">Judaism</option>
                                                          <option <?php echo ($row['religion'] == "Neo-Paganism") ? 'selected' : '' ?> value="Neo-Paganism">Neo-Paganism</option>
                                                          <option <?php echo ($row['religion'] == "Nonreligious") ? 'selected' : '' ?> value="Nonreligious">Nonreligious</option>
                                                          <option <?php echo ($row['religion'] == "Rastafarianism") ? 'selected' : '' ?> value="Rastafarianism">Rastafarianism</option>
                                                          <option <?php echo ($row['religion'] == "Secular") ? 'selected' : '' ?> value="Secular">Secular</option>
                                                          <option <?php echo ($row['religion'] == "Shinto") ? 'selected' : '' ?> value="Shinto">Shinto</option>
                                                          <option <?php echo ($row['religion'] == "Sikhism") ? 'selected' : '' ?> value="Sikhism">Sikhism</option>
                                                          <option <?php echo ($row['religion'] == "Spiritism") ? 'selected' : '' ?> value="Spiritism">Spiritism</option>
                                                          <option <?php echo ($row['religion'] == "Tenrikyo") ? 'selected' : '' ?> value="Tenrikyo">Tenrikyo</option>
                                                          <option <?php echo ($row['religion'] == "Unitarian-Universalism") ? 'selected' : '' ?> value="Unitarian-Universalism">Unitarian-Universalism</option>
                                                          <option <?php echo ($row['religion'] == "Zoroastrianism") ? 'selected' : '' ?> value="Zoroastrianism">Zoroastrianism</option>
                                                          <option <?php echo ($row['religion'] == "primal-indigenous") ? 'selected' : '' ?> value="primal-indigenous">primal-indigenous</option>
                                                          <option <?php echo ($row['religion'] == "Other") ? 'selected' : '' ?> value="Other">Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                    <label>Year</label>
                                                    <select class="form-control"  aria-label="Default select example" name="year" required>
                                                        
                                                        <option <?php echo ($row['year'] == "Grade 11") ? 'selected' : ''; ?> value="Grade 11">Grade 11</option>
                                                        <option <?php echo ($row['year'] == "Grade 12") ? 'selected' : ''; ?> value="Grade 12">Grade 12</option>
                                                        <option <?php echo ($row['year'] == "1st Year") ? 'selected' : ''; ?> value="1st Year">1st Year</option>
                                                        <option <?php echo ($row['year'] == "2nd Year") ? 'selected' : ''; ?> value="2nd Year">2nd Year</option>
                                                        <option <?php echo ($row['year'] == "3rd Year") ? 'selected' : ''; ?> value="3rd Year">3rd Year</option>
                                                        <option <?php echo ($row['year'] == "4th Year") ? 'selected' : ''; ?> value="4th Year">4th Year</option>
                                                    </select>
                                                    </div>
                                                    <div class="col">
                                                        <label>Section</label>
                                                        <select class="form-control" aria-label="Default select example" name="section" required >
                                                            <option <?php echo ($row['section'] == 'A') ? 'selected' : '' ?> value="A">A</option>
                                                            <option <?php echo ($row['section'] == 'B') ? 'selected' : '' ?> value="B">B</option>
                                                            <option <?php echo ($row['section'] == 'C') ? 'selected' : '' ?> value="C">C</option>
                                                            <option <?php echo ($row['section'] == 'D') ? 'selected' : '' ?> value="D">D</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                    <label>Contact Number</label>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <label class="mr-1 mt-2">+63</label>
                                                        <input type="text"  class="form-control" name="contact_number" required minlength="10" placeholder="" title="+63 format and must be 10 digits" pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?php 
                                                            $contact_number = substr($row['contact_number'],3);
                                                            echo $contact_number;
                                                        ?>">
                                                    </div>
                                                    </div>

                                                    <div class="col">
                                                        <label>Email Address</label>
                                                        <input  type="email" name="email_address" class="form-control" value="<?php echo $row['email_address'] ?>"  required> 
                                                    </div>
                                                </div>

                                                
                                                <div class="row">
                                                    <div class="col">
                                                        <label >Emergency Person Name</label>
                                                        <input type="text" name="emergency_person_name" class="form-control" value="<?php echo $row['emergency_person_name'] ?>" >
                                                    </div>
                                                    <div class="col">
                                                        <label >Relationship</label>
                                                        <?php 
                                                        $relationships = [
                                                            "Mother",
                                                            "Father",
                                                            "Son",
                                                            "Daughter-in-law",
                                                            "Sister",
                                                            "Brother",
                                                            "Aunt",
                                                            "Uncle",
                                                            "Niece",
                                                            "Nephew",
                                                            "Cousin",
                                                            "Grandmother",
                                                            "Grandfather",
                                                            "Granddaughter",
                                                            "Grandson",
                                                            "Stepsister",
                                                            "Stepbrother",
                                                            "Stepmother",
                                                            "Stepfather",
                                                            "Stepdaughter",
                                                            "Stepson",
                                                            "Sister-in-law",
                                                            "Brother-in-law",
                                                            "Mother-in-law",
                                                            "Father-in-law",
                                                            "Daughter-in-law",
                                                            "Son-in-law",
                                                        ];
                                                        
                                                        if(in_array($row['emergency_relationship'],$relationships)){ ?>
                                                            <select  class="form-control" name="emergency_relationship" required>
                                                            <?php 
                                                            
                                                            for($i = 0; $i < count($relationships); $i++){?>
                                                              <option <?php echo ($row['emergency_relationship'] == $relationships[$i]) ? 'selected' : '' ?> value="<?php echo $relationships[$i] ?>"><?php echo $relationships[$i] ?></option>
                                                            <?php } ?>
                                                            </select>
                                                        <?php }
                                                        else{ ?>
                                                            <input type="text" name="emergency_relationship" value="<?php echo $row['emergency_relationship'] ?>" class="form-control" required>
                                                        <?php }
                                                        ?>
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label >Emergency Person's Address</label>
                                                        <input type="text" name="emergency_address" class="form-control"  value="<?php echo $row['emergency_address'] ?>" >
                                                    </div>
                                                    <div class="col">
                                                        <label >Emergency Contact No.</label>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <label class="mr-1 mt-2">+63</label>
                                                            <input type="text"  class="form-control" name="emergency_contact_number" required minlength="10" placeholder="" title="+63 format and must be 10 digits" pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?php 
                                                            $contact_number = substr($row['emergency_contact_number'],3);
                                                            echo $contact_number;
                                                            ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <label>Student ID Number</label>
                                                        <input  type="text" name="student_id_number" class="form-control" value="<?php echo $row['student_id_number'] ?>"  required>
                                                    </div>
                                                    <div class="col">
                                                        <label>Course</label>
                                                        <select name="course" class="form-control">
                                                          <option <?php echo ($row['courseID'] == '1') ? 'selected' : '' ?> value="1">BS Accountacy</option>
                                                          <option <?php echo ($row['courseID'] == '2') ? 'selected' : '' ?> value="2">BS Architecture</option>
                                                          <option <?php echo ($row['courseID'] == '3') ? 'selected' : '' ?> value="3">BSBA Major in Financial Management</option>
                                                          <option <?php echo ($row['courseID'] == '4') ? 'selected' : '' ?> value="4">BSBA Major in Marketing Management</option>
                                                          <option <?php echo ($row['courseID'] == '5') ? 'selected' : '' ?> value="5">BS Civil Engineering</option>
                                                          <option <?php echo ($row['courseID'] == '6') ? 'selected' : '' ?> value="6">BS Computer Engineering</option>
                                                          <option <?php echo ($row['courseID'] == '7') ? 'selected' : '' ?> value="7">BS Hospitality Management</option>
                                                          <option <?php echo ($row['courseID'] == '8') ? 'selected' : '' ?> value="8">BS Psychology</option>
                                                          <option <?php echo ($row['courseID'] == '9') ? 'selected' : '' ?> value="9">BS Tourism Management</option>
                                                          <option <?php echo ($row['courseID'] == '10') ? 'selected' : '' ?> value="10">BS Information Technology</option>
                                                          <option <?php echo ($row['courseID'] == '11') ? 'selected' : '' ?> value="11">Master in Management with Specialization in Bussiness Analytics</option>
                                                          <option <?php echo ($row['courseID'] == '12') ? 'selected' : '' ?> value="12">ABM</option>
                                                          <option <?php echo ($row['courseID'] == '13') ? 'selected' : '' ?> value="13">HUMSS</option>
                                                          <option <?php echo ($row['courseID'] == '14') ? 'selected' : '' ?> value="14">STEM</option>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control">
                                                      <option <?php echo ($row['status'] == 'Active') ? 'selected' : '' ?> value="Active">Active</option>
                                                      <option <?php echo ($row['status'] == 'Inactive') ? 'selected' : '' ?> value="Inactive">Inactive</option>
                                                    </select>
                                                    </div>
                                                </div>  
                                              </div><!--/col-9-->
                                            
                                        </div><!--/row-->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="update_student" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Student Modal -->
                        
                    <?php endwhile; ?>
                </tbody>
                
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>
    $(document).ready(function () {
      $('#manage_students').DataTable({
        "ordering": false,
          initComplete: function () {
              this.api()
                  .columns([2,3,4,5])
                  .every(function () {
                      var column = this;
                      
                      var select = $('<select class=""><option value=""></option></select>')
                          .appendTo($(column.header()).empty())
                          .on('change', function () {
                              var val = $.fn.dataTable.util.escapeRegex($(this).val());
   
                              column.search(val ? '^' + val + '$' : '', true, false).draw();
                          });
   
                      column
                          .data()
                          .unique()
                          .sort()
                          .each(function (d, j) {
                            var val = $('<div/>').html(d).text();
                            select.append( '<option value="' + val + '">' + val + '</option>' )
                          });
                  });
          },
      });
  });
</script>


<!--Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
            <form action="../Controller/RegisterController.php" method="POST">
                <input type="hidden" value="<?php echo $active_id ?>" name="user_id">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control names" required >
            </div>
            <div class="col">
                <label>Middle Name</label>
                <input type="text" name="middlename" class="form-control names" >
            </div>
            <div class="col">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control names" required >
            </div>
        </div>


        <div class="row">
            <div class="col-md-3">
                <label>Birthdate</label>
                <input type="date" class="form-control" name="birthdate" required  max="<?php echo date("Y-m-d",strtotime("-13 years")); ?>">
            </div>
            <div class="col-md-3">
                <label>Province</label>
                <select  class="form-control" name="province" id="province" required></select>
                <input type="hidden" name="province_name" required>
            </div>
            <div class="col-md-3">
                <label>City/Municipality</label>
                <select  class="form-control" name="city_municipality" id="city" required></select>
                <input type="hidden" name="municipality_name" required>
            </div>
            <div class="col-md-3">
                <label>Barangay</label>
                <select  class="form-control" name="barangay" id="barangay" required></select>
                <input type="hidden" name="barangay_name" required>
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-5">
                <label>Street Name</label>
                <input type="text" class="form-control" required name="streetname">
            </div>
            <div class="col">
                <label>House Number</label>
                <input type="number" class="form-control" required name="housenumber">
            </div>
            <div class="col" class="col-md-5">
                <label>Contact Number</label>
                <div class="d-flex align-items-center justify-content-between">
                    <label class="mr-1 mt-2">+63</label>
                    <input type="text"  class="form-control" name="contact_number" required minlength="10" placeholder="" title="+63 format and must be 10 digits" pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                </div>  
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Sex</label>
                <select class="form-control" aria-label="Default select example" name="sex" required>
                    <option selected disabled>Select Sex</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="col">
                <label>Religion</label>
                <?php include_once("../Utilities/religion.php"); ?>
            </div>
            <div class="col">
                <label>Nationality</label>
                <?php include_once("../Utilities/nationality.php"); ?>
            </div>

        </div>

        <div class="row">
            <div class="col">
                <label>Student ID Number</label>
                <script src="../js/jquery-3.6.0.min.js"></script>
                <input type="text"  class="form-control" id="student_id_number" name="student_id_number" required minlength="10" title="Must be 10 digits" pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                
            </div>
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
                <label>Section</label>
                <select class="form-control" aria-label="Default select example" name="section" required >
                    <option selected disabled>Select Section</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>
            <div class="col">
                <label>Course</label>
                <select name="courseID" class="form-control" id="child_selection" >
                    <option selected disabled>Select Course</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Emergency Person Name</label>
                <input type="text"  class="form-control" name="emergency_person_name" required>
            </div>
            <div class="col">
                <label>Relationship</label>
                <select  class="form-control" name="relationship" required>
                    <option selected disabled>Select Relationship</option>
                    <?php include_once("../Utilities/relationship.php"); ?>
                </select>
            </div>
        </div>



        <div class="row">
            <div class="col-md-8">
                <label>Emergency Person's Address</label>
                <input type="text"  class="form-control" name="emergency_address" id="emergency_address" required>
            </div>
            <div class="col-md-4">
                <label>Emergency Contact Number</label>
                <div class="d-flex align-items-center justify-content-between">
                    <label class="mr-1 mt-2">+63</label>
                    <input type="text"  class="form-control" name="emergency_contact_number" required minlength="10" placeholder="" title="+63 format and must be 10 digits" pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Email Address</label>
                <input type="email"  class="form-control" name="email_address" required>
            </div>
            <div class="col-md-6">
                
                <label>Password</label>
                <div class="input-group-append">
                <input type="text" name="password" id="password" class="form-control mr-1"  required>
                    <span class="input-group-text" onclick="password_show_hide();">
                    <i class="fas fa-eye" id="show_eye"></i>
                    <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                    </span>
                    <script src="../js/password-generator.js"></script>
                <button type="button" class="btn bg-secondary text-light ml-1" onclick="generatePassword()"><i class="fas fa-random"></i></button>
                </div>
            </div>

            <script>
                var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                var passwordLength = 8;
                var password = "";
                for (var i = 0; i <= passwordLength; i++) {
                    var randomNumber = Math.floor(Math.random() * chars.length);
                    password += chars.substring(randomNumber, randomNumber +1);
                }
                document.getElementById("password").value = password;
            </script>
            
            <!-- <div class="col-md-3">
                <label>Confirm Password</label>
                <div class="input-group-append">
                <input type="password" name="confirm_password" id="confirm_password" class="form-control mr-1" required>
                    <span class="input-group-text" onclick="confirm_password_show_hide();">
                    <i class="fas fa-eye" id="confirm_show_eye"></i>
                    <i class="fas fa-eye-slash d-none" id="confirm_hide_eye"></i>
                    </span>
                </div>
            </div> -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="register">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--Add Student Modal -->



<script src="../js/year_course.js"></script>
<script src="../js/jquery-3.6.0.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/password-show-hide.js"></script>

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
      

    // the hidden field will contain the name of the region, not the code
      $('input[name=province_name]').val(selected_caption);

}).ph_locations('fetch_list');

});

$(function(){

// whenever the city dropdown change, update the value of hidden field
$('#city').on('change', function(){

      // we are getting the text() here, not val()
      var selected_caption = $("#city option:selected").text();

    // the hidden field will contain the name of the region, not the code
      $('input[name=municipality_name]').val(selected_caption);

}).ph_locations('fetch_list');

});

$(function(){

// whenever the city dropdown change, update the value of hidden field
$('#barangay').on('change', function(){

      // we are getting the text() here, not val()
      var selected_caption = $("#barangay option:selected").text();

    // the hidden field will contain the name of the region, not the code
      $('input[name=barangay_name]').val(selected_caption);

}).ph_locations('fetch_list');

});
</script>

<script>

$(document).ready(function() {
    //create arrays to store option and values
    var firsttofourtyear = [
        {display: "BS Accountacy", value: "1" }, 
        {display: "BS Architecture", value: "2" }, 
        {display: "BSBA Major in Financial Management", value: "3" }, 
        {display: "BSBA Major in Marketing Management", value: "4" }, 
        {display: "BS Civil Engineering", value: "5" }, 
        {display: "BS Computer Engineering", value: "6" }, 
        {display: "BS Hospitality Management", value: "7" }, 
        {display: "BS Psychology", value: "8" }, 
        {display: "BS Tourism Management", value: "9" }, 
        {display: "BS Information Technology", value: "10" }, 
        {display: "Master in Management with Specialization in Bussiness Analytics", value: "11" }    
    ];
       
    var grade11and12 = [
        {display: "ABM", value: "12" },
        {display: "HUMSS", value: "13" },
        {display: "STEM", value: "14" },
    ];

    //If parent option is changed
    $("#parent_selection").change(function() {
        var parent = $(this).val(); //get option value from parent       
        switch(parent){ //using switch compare selected option and populate child
            case 'Grade 11':
                $('#child_selection').attr('disabled', false);
                list(grade11and12);
                break;
            case 'Grade 12':
                $('#child_selection').attr('disabled', false);
                list(grade11and12);
                break;
            case '1st Year':
                $('#child_selection').attr('disabled', false);
                list(firsttofourtyear);
                break;
            case '2nd Year':
                $('#child_selection').attr('disabled', false);
                list(firsttofourtyear);
                break;
            case '3rd Year':
                $('#child_selection').attr('disabled', false);
                list(firsttofourtyear);
                break;
            case '4th Year':
                $('#child_selection').attr('disabled', false);
                list(firsttofourtyear);
                break;
            default: //default child option is blank
                $("#child_selection").html('');
                $('#child_selection').attr("disabled", true);
                break;
        }
    });

    //function to populate child select box
    function list(array_list) {
        $("#child_selection").html(""); //reset child options
        $(array_list).each(function (i) { //populate child options
            $("#child_selection").append("<option value='" + array_list[i].value + "'>" + array_list[i].display + "</option>");
        });
    }
});
</script>

<script>
$(".names").keypress(function(event) {
    var character = String.fromCharCode(event.keyCode);
    return isValid(character);     
});

function isValid(str) {
    return !/[0-9~`!@#$%\^&*()+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
}
</script>

<?php include_once("layouts/footer.php") ?>