<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER | NUHRS</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="images/favicon.ico">
    <!-- <link rel="stylesheet" href="style.css"> -->

</head>

<body>
<div class="container-fluid h-20 w-100 bg-dark py-1">
        <div class="row my-1">
            <div class="col ml-5 d-flex align-items-center">
                <img src="images/nulogo.png" alt="" height="50" width="50" class="border rounded-circle">
                <h4 class="ml-2 text-white">NUHRS</h4>
            </div>

            <!-- <div class="col d-flex align-items-center justify-content-end pr-5">
                <h4 class="text-white"></h4>
            </div> -->

        </div>
    </div>

    <div class="main-container">
        <div class="container w-80 h-90">
        <div class="card my-5">
            <div class="card-header">
                <div class="d-flex justify-content-between alight-items-center">
                <h3>Register</h3>
                <a class="text-muted text-decoration-underline text-center" href="login.php">Already have an account?</a>
                </div>
            </div>
            <div class="card-body">
                <form action="Controller/RegisterController.php" method="POST">
                <div class="row">
                    <div class="col">
                        <label>Firstname</label>
                        <input type="text" name="firstname" class="form-control" required>
                    </div>
                    <div class="col">
                        <label>Middlename</label>
                        <input type="text" name="middlename" class="form-control">
                    </div>
                    <div class="col">
                        <label>Lastname</label>
                        <input type="text" name="lastname" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Birthdate</label>
                        <input type="date" class="form-control" name="birthdate" required>
                    </div>
                    <div class="col">
                        <label>Province</label>
                        <select  class="form-control" name="province" id="province" required></select>
                        <input type="hidden" name="province_name" required>
                    </div>
                    <div class="col">
                        <label>City/Municipality</label>
                        <select  class="form-control" name="city_municipality" id="city" required></select>
                        <input type="hidden" name="municipality_name" required>
                    </div>
                    <div class="col">
                        <label>Barangay</label>
                        <select  class="form-control" name="barangay" id="barangay" required></select>
                        <input type="hidden" name="barangay_name" required>
                    </div>
                    <div class="col">
                        <label>Contact Number</label>
                        <input type="number"  class="form-control" name="contact_number" required>
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
                        <?php include_once("Utilities/religion.php"); ?>
                    </div>
                    <div class="col">
                        <label>Nationality</label>
                        <?php include_once("Utilities/nationality.php"); ?>
                    </div>

                </div>

                <div class="row">
                    <div class="col">
                        <label>Student ID Number</label>
                        <script src="js/jquery-3.6.0.min.js"></script>
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
                            <?php include_once("Utilities/relationship.php"); ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Emergency Address</label>
                        <input type="text"  class="form-control" name="emergency_address" required>
                    </div>
                    <div class="col">
                        <label>Emergency Contact Number</label>
                        <input type="number"  class="form-control" name="emergency_contact_number" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Email Address</label>
                        <input type="email"  class="form-control" name="email_address" required>
                    </div>
                    <div class="col-md-3">
                        <label>Password</label>
                        <div class="input-group-append">
                        <input type="password" name="password" id="password" class="form-control mr-1" required>
                            <span class="input-group-text" onclick="password_show_hide();">
                            <i class="fas fa-eye" id="show_eye"></i>
                            <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Confirm Password</label>
                        <div class="input-group-append">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control mr-1" required>
                            <span class="input-group-text" onclick="confirm_password_show_hide();">
                            <i class="fas fa-eye" id="confirm_show_eye"></i>
                            <i class="fas fa-eye-slash d-none" id="confirm_hide_eye"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-center my-3">
                <button class="btn btn-primary fa-lg my-3 py-3" name="register" type="submit" style="background-color:#1034a6;">Register</button>
                </div>
            </form>
            </div>
            </div>
        </div>
    </div>
     <!-- Footer -->
     <footer class="text-center text-lg-start text-muted bg-dark">
        <!-- Section: Social media -->
        <section class="d-flex justify-content-center justify-content-lg-between p-2 ">

            <!-- Right -->
        </section>

        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start mt-5 ">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i>NATIONAL UNIVERSITY FAIRVIEW
                        </h6>
                        <p>
                            HEALTH RECORD SYSTEM
                        </p>
                    </div>
                    <!-- Grid column -->

                    

                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Learn More
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">About</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Contact
                        </h6>
                        <p><i class="fas fa-home me-3"></i> </p>
                        <p>
                            <i class="fas fa-envelope me-3"></i>

                        </p>
                        <p><i class="fas fa-phone me-3"></i>Mobile: 00000000000</p>
                        <p><i class="fas fa-print me-3"></i>Land Line: 00000000</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        NATIONAL UNIVERSITY FAIRVIEW
            <!-- <a class="text-reset fw-bold" href="https://mdbootstrap.com/">MDBootstrap.com</a> -->
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
    </div>
    </nav>
    </div>

    <script src="js/year_course.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/password-show-hide.js"></script>
    
</body>

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



</html>