<?php 
$page_title = "MANAGE STUDENTS";
include_once("layouts/header-sidebar.php") ?>
<!-- Begin Page Content -->
<div class="container-fluid">

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